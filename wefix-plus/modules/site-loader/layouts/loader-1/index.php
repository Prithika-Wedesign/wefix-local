<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixPlusSiteLoaderOne' ) ) {
    class WeFixPlusSiteLoaderOne {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'wefix_loader_layouts', array( $this, 'add_option' ) );

            $site_loader = wefix_customizer_settings( 'site_loader' );

            if( $site_loader == 'loader-1' ) {

                add_action( 'wefix_after_main_css', array( $this, 'enqueue_assets' ) );

                /**
                 * filter: wefix_primary_color_style - to use primary color
                 * filter: wefix_secondary_color_style - to use secondary color
                 * filter: wefix_tertiary_color_style - to use tertiary color
                 */
                add_filter( 'wefix_tertiary_color_style', array( $this, 'tertiary_color_style' ) );
            }
        }

        function add_option( $options ) {
            $options['loader-1'] = esc_html__('Loader 1', 'wefix-plus');
            return $options;
        }

        function enqueue_assets() {
            wp_enqueue_style( 'site-loader', WEFIX_PLUS_DIR_URL . 'modules/site-loader/layouts/loader-1/assets/css/loader-1.css', false, WEFIX_PLUS_VERSION, 'all' );
        }

        function tertiary_color_style( $style ) {
            $style .= ".loader1 { background-color:var( --wdtBodyBGColor );}";
            return $style;
        }
    }
}

WeFixPlusSiteLoaderOne::instance();