<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixProPost' ) ) {
    class WeFixProPost {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_post_layouts();
            $this->load_modules();
            $this->frontend();
        }

        function load_post_layouts() {
            foreach( glob( WEFIX_PRO_DIR_PATH. 'modules/post/templates/*/index.php'  ) as $module ) {
                include_once $module;
            }
        }

        function load_modules() {
            include_once WEFIX_PRO_DIR_PATH.'modules/post/customizer/index.php';
            include_once WEFIX_PRO_DIR_PATH.'modules/post/metabox/index.php';
            include_once WEFIX_PRO_DIR_PATH.'modules/post/elementor/index.php';
        }

        function frontend() {
            add_action( 'wefix_after_main_css', array( $this, 'enqueue_css_assets' ), 20 );

            add_filter( 'wefix_single_post_params', array( $this, 'register_single_post_params' ) );
            add_filter( 'wefix_single_post_style', array( $this, 'load_post_style'), 10, 2 );
            add_filter( 'wefix_single_post_image', array( $this, 'load_post_image' ), 10, 3 );

            add_action( 'wefix_before_enqueue_js', array( $this, 'enqueue_js_assets' ) );

            add_action( 'wp_ajax_single_post_process_like', array( $this, 'single_post_process_like' ) );
            add_action( 'wp_ajax_nopriv_single_post_process_like', array( $this, 'single_post_process_like' ) );

            $enable = wefix_customizer_settings( 'enable_related_article' );
            if( !empty( $enable )  ) {
                add_action( 'wefix_after_single_post_content_wrap', array( $this, 'single_post_related_article' ) );
            }
        }

        function enqueue_css_assets() {
            if( is_singular('post') ) {
                wp_enqueue_style( 'wefix-pro-post', WEFIX_PRO_DIR_URL . 'modules/post/assets/css/post.css', false, WEFIX_PRO_VERSION, 'all');
                wp_enqueue_style( 'wefix-pro-post-navigation', WEFIX_PRO_DIR_URL . 'modules/post/assets/css/post-navigation.css', false, WEFIX_PRO_VERSION, 'all');

                $post_style = wefix_get_single_post_style( get_the_ID() );
                wp_enqueue_style( 'wdt-blog-post-'.$post_style, WEFIX_PRO_DIR_URL . 'modules/post/templates/'.$post_style.'/assets/css/post-'.$post_style.'.css', false, WEFIX_PRO_VERSION, 'all');
            }
        }

        function register_single_post_params() {

            $params = array(
                'enable_title'           => wefix_customizer_settings( 'enable_title' ),
                'enable_image_lightbox'  => wefix_customizer_settings( 'enable_image_lightbox' ),
                'enable_disqus_comments' => wefix_customizer_settings( 'enable_disqus_comments' ),
                'enable_related_article' => wefix_customizer_settings( 'enable_related_article' ),
                'post_disqus_shortname'  => wefix_customizer_settings( 'post_disqus_shortname' ),
                'post_dynamic_elements'  => wefix_customizer_settings( 'post_dynamic_elements' ),
                'rposts_title'           => wefix_customizer_settings( 'rposts_title' ),
                'rposts_column'          => wefix_customizer_settings( 'rposts_column' ),
                'rposts_count'           => wefix_customizer_settings( 'rposts_count' ),
                'rposts_excerpt'         => wefix_customizer_settings( 'rposts_excerpt' ),
                'rposts_excerpt_length'  => wefix_customizer_settings( 'rposts_excerpt_length' ),
                'rposts_carousel'        => wefix_customizer_settings( 'rposts_carousel' ),
                'rposts_carousel_nav'    => wefix_customizer_settings( 'rposts_carousel_nav' ),
                'post_commentlist_style' => wefix_customizer_settings( 'post_commentlist_style' ),
                'select_post_navigation' => wefix_customizer_settings( 'select_post_navigation' )
            );

            return $params;
        }

        function load_post_style( $post_style, $post_id ) {
            $post_meta = get_post_meta( $post_id, '_wefix_post_settings', TRUE );
            $post_meta = is_array( $post_meta ) ? $post_meta  : array();

            $post_style = !empty( $post_meta['single_post_style'] ) ? $post_meta['single_post_style'] : $post_style;

            return $post_style;
        }

        function load_post_image( $image, $post_id, $post_meta ) {
            if( array_key_exists( 'single_post_style', $post_meta ) && $post_meta['single_post_style'] == 'split' ) :
                $entry_bg = '';
                $url = get_the_post_thumbnail_url( $post_id, 'full' );
                $entry_bg = "style=background-image:url(".$url.")";

                return '<div class="split-full-img" '.esc_attr($entry_bg).'></div>';
            else:
                return $image;
            endif;
        }

        function enqueue_js_assets() {
            if( is_singular('post') ) {
                wp_enqueue_script( 'jquery-caroufredsel', WEFIX_PRO_DIR_URL . 'modules/post/assets/js/jquery.caroufredsel.js', array(), WEFIX_PRO_VERSION, true );
                wp_enqueue_script( 'jquery-waypoints', WEFIX_PRO_DIR_URL . 'modules/post/assets/js/jquery.waypoints.min.js', array(), WEFIX_PRO_VERSION, true );
                wp_enqueue_script( 'post-likes', WEFIX_PRO_DIR_URL . 'modules/post/assets/js/post-likes.js', array(), WEFIX_PRO_VERSION, true );
                wp_localize_script('post-likes', 'wefix_urls', array(
                    'ajaxurl' => esc_url( admin_url('admin-ajax.php') ),
                    'wpnonce' => wp_create_nonce('rating-nonce')
                ));
            }
        }

        function single_post_process_like() {

            $out = '';
            $postid = $_REQUEST['post_id'];
            $nonce = $_REQUEST['nonce'];
            $action = $_REQUEST['doaction'];
            $arr_pids = array();

            if ( wp_verify_nonce( $nonce, 'rating-nonce' ) && $postid > 0 ) {

                $post_meta = get_post_meta ( $postid, '_wefix_post_settings', TRUE );
                $post_meta = is_array ( $post_meta ) ? $post_meta : array ();

                $var_count = ($action == 'like') ? 'like_count' : 'unlike_count';

                if( isset( $_COOKIE['arr_pids'] ) ) {

                    // article voted already...
                    if( in_array( $postid, explode(',', $_COOKIE['arr_pids']) ) ) {
                        $out = esc_html__('Already', 'wefix-pro');
                    } else {
                        // article first vote...
                        $v = array_key_exists($var_count, $post_meta) ?  $post_meta[$var_count] : 0;
                        $v = $v + 1;
                        $post_meta[$var_count] = $v;
                        update_post_meta( $postid, '_wefix_post_settings', $post_meta );

                        $out = $v;

                        $arr_pids = explode(',', $_COOKIE['arr_pids']);
                        array_push( $arr_pids, $postid);
                        setcookie( "arr_pids", implode(',', $arr_pids ), time()+1314000, "/" );
                    }
                } else {
                    // site first vote...
                    $v = array_key_exists($var_count, $post_meta) ?  $post_meta[$var_count] : 0;
                    $v = $v + 1;
                    $post_meta[$var_count] = $v;
                    update_post_meta( $postid, '_wefix_post_settings', $post_meta );

                    $out = $v;

                    array_push( $arr_pids, $postid);
                    setcookie( "arr_pids", implode(',', $arr_pids ), time()+1314000, "/" );
                }
            } else {
                $out = esc_html__('Security check', 'wefix-pro');
            }

            echo wefix_html_output($out);

            wp_die();
        }

        function single_post_related_article( $post_id ) {
            echo wefix_get_template_part( 'post', 'templates/post-extra/related_article', '', array( 'post_ID' => $post_id ) );
        }
    }
}

WeFixProPost::instance();