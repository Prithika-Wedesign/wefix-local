<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixPlusSiteCustomLoader' ) ) {
    class WeFixPlusSiteCustomLoader {

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

            if( $site_loader == 'custom-loader' ) {

                add_filter( 'body_class', array( $this, 'apply_custom_class' ), 10, 1 );
                add_action( 'wefix_after_main_css', array( $this, 'enqueue_assets' ) );
                add_action( 'wefix_after_enqueue_js', array( $this, 'enqueue_js' ) );

                /**
                 * filter: wefix_primary_color_style - to use primary color
                 * filter: wefix_secondary_color_style - to use secondary color
                 * filter: wefix_tertiary_color_style - to use tertiary color
                 */
                add_filter( 'wefix_primary_color_style', array( $this, 'primary_color_css' ) );
                add_filter( 'wefix_tertiary_color_style', array( $this, 'tertiary_color_style' ) );
            }

        }

        function apply_custom_class( $classes ) {
           array_push($classes, 'wdt-circle-loader');
            return $classes;
        }

        function add_option( $options ) {
            $options['custom-loader'] = esc_html__('Custom Loader', 'wefix-plus');
            return $options;
        }

        function enqueue_assets() {
            $loader = wefix_customizer_settings('site_loader');
            $loader_site = wefix_customizer_settings('show_site_loader');
            if( isset($loader_site) && $loader_site && $loader == 'custom-loader' ) {
                wp_enqueue_style( 'site-loader', WEFIX_PLUS_DIR_URL . 'modules/site-loader/layouts/custom-loader/assets/css/custom-loader.css', false, WEFIX_PLUS_VERSION, 'all' );
            }
        }

        function enqueue_js() {
            $loader = wefix_customizer_settings('site_loader');
            $loader_site = wefix_customizer_settings('show_site_loader');
            if( isset($loader_site) && $loader_site && $loader == 'custom-loader' ) {
                wp_enqueue_script( 'site-transition', WEFIX_PLUS_DIR_URL . 'modules/site-loader/layouts/custom-loader/assets/js/custom-loader.js', array('jquery'), WEFIX_PLUS_VERSION, true );
            }
        }

        function primary_color_css( $style ) {
            $style .= ".custom_loader { background-color:var( --wdtBodyBGColor );}";
            return $style;
        }

        function tertiary_color_style( $style ) {
            $style .= ".custom_loader:before { background-color:var( --wdtTertiaryColor );}";
            return $style;
        }
    }
}

WeFixPlusSiteCustomLoader::instance();