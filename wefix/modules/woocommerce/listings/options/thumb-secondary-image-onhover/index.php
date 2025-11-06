<?php
/**
 * Listing Options - Image Effect
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Woo_Listing_Option_Thumb_Secondary_Image_on_Hover' ) ) {

    class WeFix_Woo_Listing_Option_Thumb_Secondary_Image_on_Hover extends WeFix_Woo_Listing_Option_Core {

        private static $_instance = null;

        public $option_slug;

        public $option_name;

        public $option_desc;

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

            $this->option_slug          = 'product-thumb-secondary-image-onhover';
            $this->option_name          = esc_html__('Show Secondary Image On Hover', 'wefix');
            $this->option_desc          = esc_html__('YES! to show secondary image on product hover. First image in the gallery will be used as secondary image.', 'wefix');
            $this->option_type          = array ( 'html', 'key-css' );
            $this->option_default_value = '';
            $this->option_value_prefix  = 'product-';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {
            add_filter( 'wefix_woo_custom_product_template_thumb_options', array( $this, 'woo_custom_product_template_thumb_options'), 5, 1 );
        }

        /**
         * Custom Product Templates - Options
         */
        function woo_custom_product_template_thumb_options( $template_options ) {

            array_push( $template_options, $this->setting_args() );

            return $template_options;
        }

        /**
         * Settings Group
         */
        function setting_group() {
            return 'thumb';
        }

        /**
         * Setting Args
         */
        function setting_args() {
            $settings            =  array ();
            $settings['id']      =  $this->option_slug;
            $settings['type']    =  'switcher';
            $settings['title']   =  $this->option_name;
            $settings['desc']    =  $this->option_desc;
            $settings['default'] =  $this->option_default_value;

            return $settings;
        }
    }

}

if( !function_exists('wefix_woo_listing_option_thumb_secondary_image_onhover') ) {
	function wefix_woo_listing_option_thumb_secondary_image_onhover() {
		return WeFix_Woo_Listing_Option_Thumb_Secondary_Image_on_Hover::instance();
	}
}

wefix_woo_listing_option_thumb_secondary_image_onhover();