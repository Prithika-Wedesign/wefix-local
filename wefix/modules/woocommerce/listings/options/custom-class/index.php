<?php
/**
 * Listing Options - Image Effect
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Woo_Listing_Option_Custom_Class' ) ) {

    class WeFix_Woo_Listing_Option_Custom_Class extends WeFix_Woo_Listing_Option_Core {

        private static $_instance = null;

        public $option_slug;

        public $option_name;

        public $option_type;

        public $option_default_value;

        public $option_value_prefix;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            $this->option_slug          = 'product-custom-class';
            $this->option_name          = esc_html__('Custom Class', 'wefix');
            $this->option_type          = array ( 'class', 'key-css' );
            $this->option_default_value = '';
            $this->option_value_prefix  = 'product-';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {
            add_filter( 'wefix_woo_custom_product_template_common_options', array( $this, 'woo_custom_product_template_common_options'), 65, 1 );
        }

        /**
         * Custom Product Templates - Options
         */
        function woo_custom_product_template_common_options( $template_options ) {

            array_push( $template_options, $this->setting_args() );

            return $template_options;
        }

        /**
         * Settings Group
         */
        function setting_group() {
            return 'common';
        }

        /**
         * Setting Args
         */
        function setting_args() {
            $settings            =  array ();
            $settings['id']      =  $this->option_slug;
            $settings['type']    =  'text';
            $settings['title']   =  $this->option_name;
            $settings['default'] =  $this->option_default_value;

            return $settings;
        }
    }

}

if( !function_exists('wefix_woo_listing_option_custom_class') ) {
	function wefix_woo_listing_option_custom_class() {
		return WeFix_Woo_Listing_Option_Custom_Class::instance();
	}
}

wefix_woo_listing_option_custom_class();