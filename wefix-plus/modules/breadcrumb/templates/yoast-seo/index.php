<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixPlusBCYoast' ) ) {
    class WeFixPlusBCYoast {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'plugins_loaded', array( $this, 'register_init' ) );
        }

        function register_init() {
            if ( function_exists('yoast_breadcrumb') ) {
                $this->load_backend();
            }
        }

        function load_backend() {
            add_filter( 'wefix_breadcrumb_source', array( $this, 'register_option' ) );
        }

        function register_option( $options ) {
            $options['yoast-seo'] = esc_html__('Yoast SEO','wefix-plus');
            return $options;
        }

        function register_template() {
            $bc_source = wefix_customizer_settings( 'breadcrumb_source' );
            if ($bc_source === 'yoast-seo'):
                    wefix_template_part( 'breadcrumb', 'templates/yoast-seo/title-content', '', $template_args );
            endif;
         }
    }
}

WeFixPlusBCYoast::instance();