<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixProSideNav' ) ) {
    class WeFixProSideNav {

        private static $_instance = null;
        private $global_layout    = '';
        private $global_sidebar   = '';

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_module();
            $this->frontend();
        }

        function load_module() {
            include_once WEFIX_PRO_DIR_PATH.'modules/side-nav/metabox/index.php';
            include_once WEFIX_PRO_DIR_PATH.'modules/side-nav/elementor/index.php';
            add_filter( 'theme_page_templates', array( $this, 'add_sidenav_template' ) );
        }

        function add_sidenav_template( $templates ) {
            $templates = array_merge( $templates, array( 'tpl-side-nav.php' => esc_html__('Side Navigation', 'wefix-pro' ) ) );
            return $templates;
        }

        function frontend() {
            add_action( 'wefix_after_main_css', array( $this, 'enqueue_assets' ) );
            add_action( 'wefix_before_single_page_content_wrap', array( $this, 'before_content_wrap' ) );
            add_action( 'wefix_after_single_page_content_wrap', array( $this, 'after_content_wrap' ), 9999999 );
        }

        function enqueue_assets() {
            $page_template = $this->get_page_template();
            if( $page_template == 'tpl-side-nav.php' ) {
                wp_enqueue_style( 'sidenav', WEFIX_PRO_DIR_URL . 'modules/side-nav/assets/css/sidenav.css', false, WEFIX_PRO_VERSION, 'all' );
                wp_enqueue_script( 'theia-sticky-sidebar', WEFIX_PRO_DIR_URL . 'assets/js/theia-sticky-sidebar.min.js', array('jquery'), WEFIX_PRO_VERSION, true );
                wp_enqueue_script( 'sidenav-sticky', WEFIX_PRO_DIR_URL . 'modules/side-nav/assets/js/side-nav.js', array('theia-sticky-sidebar'), WEFIX_PRO_VERSION, true );
            }
        }

        function before_content_wrap() {
            $page_template = $this->get_page_template();
            if( $page_template == 'tpl-side-nav.php' ) {
                $id       = get_the_ID();
                $settings = get_post_meta( $id, '_wefix_sidenav_settings', true );
                $settings = is_array( $settings ) ? array_filter( $settings ) : array();

                $side_nav_class = ( isset( $settings['align'] ) && !empty( $settings['align'] ) ) ? 'rightSidebar' : 'leftSidebar';

                $show_content = isset( $settings['show_content'] ) ? $settings['show_content'] : '';
                $content_id = isset( $settings['content'] ) ? $settings['content'] : '';

                $classes = '';
                if( isset( $settings['style'] ) ) {
                    $classes .= ' '.$settings['style'];
                }

                if( isset( $settings['align'] ) ) {
                    $classes .= " sidenav-alignright";
                }

                if( isset( $settings['sticky'] ) ) {
                    $classes .= " sidenav-sticky ";
                    $classes .= $side_nav_class;
                }

                echo '<div class="side-navigation-container '.esc_attr($settings['style']).'">';
                    echo wefix_get_template_part( 'side-nav', 'template/tpl-side-nav', '', array( 'id' => $id, 'show_content' => $show_content, 'content_id' => $content_id, 'classes' => $classes ) );
                    echo '<div class="side-navigation-content">';
            }
        }
        function after_content_wrap() {
            $page_template = $this->get_page_template();
            if( $page_template == 'tpl-side-nav.php' ) {
                    echo "</div>";
                echo "</div>";

                $id       = get_the_ID();
                $settings = get_post_meta( $id, '_wefix_sidenav_settings', true );
                $settings = is_array( $settings ) ? array_filter( $settings ) : array();

                $show_bottom_content = isset( $settings['show_bottom_content'] ) ? $settings['show_bottom_content'] : '';
                $bottom_content_id = isset( $settings['bottom_content'] ) ? $settings['bottom_content'] : '';

                if( !empty( $show_bottom_content ) && !empty( $bottom_content_id ) ){
                    if( class_exists( '\Elementor\Plugin' ) ) {
                        $elementor_instance = Elementor\Plugin::instance();

                        if( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
                            $css_file = new \Elementor\Core\Files\CSS\Post( $bottom_content_id );
                            $css_file->enqueue();
                        }

                        if( !empty( $elementor_instance ) ) {
                            echo wefix_html_output($elementor_instance->frontend->get_builder_content_for_display( $bottom_content_id ));
                        }

                    } else {
                        $content = get_the_content( '', false, $bottom_content_id );
                        echo do_shortcode( $content );
                    }
                }
            }
        }

        function get_page_template() {
            if( is_singular('page') ) {
                return get_post_meta( get_the_ID(), '_wp_page_template', true );
            }
        }
    }
}

WeFixProSideNav::instance();