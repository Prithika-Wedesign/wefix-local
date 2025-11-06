<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixPlusSiteToTop' ) ) {
    class WeFixPlusSiteToTop {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_modules();
            $this->frontend();
        }

        function load_modules() {
            include_once WEFIX_PLUS_DIR_PATH.'modules/site-to-top/customizer/index.php';
        }

        function frontend() {
            $show = wefix_customizer_settings('show_site_to_top');
            if( $show ) {
                add_filter( 'body_class', array( $this, 'add_body_classes' ) );
                add_action( 'wefix_after_main_css', array( $this, 'enqueue_assets' ) );
                add_action( 'wp_footer', array( $this, 'load_template' ), 999 );
            }
        }

        function add_body_classes( $classes ) {
            $classes[] = 'has-go-to-top';
            return $classes;
        }

        function enqueue_assets() {
            wp_enqueue_style( 'site-to-top', WEFIX_PLUS_DIR_URL . 'modules/site-to-top/assets/css/totop.css', false, WEFIX_PLUS_VERSION, 'all' );
            wp_enqueue_script( 'go-to-top', WEFIX_PLUS_DIR_URL . 'modules/site-to-top/assets/js/go-to-top.js', array('jquery'), WEFIX_PLUS_VERSION, true );
        }

        function load_template() {
            $args = array(
                'icon' => '<i class="wdticon-angle-up"></i>'
            );

            echo wefix_get_template_part( 'site-to-top/layouts/', 'template', '', $args );
        }
    }
}

WeFixPlusSiteToTop::instance();