<?php
/**
 * Listing Options - Image Effect
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Woo_Listing_Option_Content_Icons_Group_Icons' ) ) {

    class WeFix_Woo_Listing_Option_Content_Icons_Group_Icons extends WeFix_Woo_Listing_Option_Core {

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

            $this->option_slug          = 'product-content-iconsgroup-icons';
            $this->option_name          = esc_html__('Icons Group - Icons', 'wefix');
            $this->option_type          = array ( 'html', 'value-css' );
            $this->option_default_value = '';
            $this->option_value_prefix  = '';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {
            add_filter( 'wefix_woo_custom_product_template_content_options', array( $this, 'woo_custom_product_template_content_options'), 20, 1 );
        }

        /**
         * Custom Product Templates - Options
         */
        function woo_custom_product_template_content_options( $template_options ) {

            array_push( $template_options, $this->setting_args() );

            return $template_options;
        }

        /**
         * Settings Group
         */
        function setting_group() {
            return 'content';
        }

        /**
         * Setting Args
         */
        function setting_args() {
            $settings            =  array ();
            $settings['id']      =  $this->option_slug;
            $settings['type']    =  'select';
            $settings['title']   =  $this->option_name;
            $settings['options'] =  array (
                'cart'      => esc_html__('Cart', 'wefix'),
                'wishlist'  => esc_html__('Wishlist', 'wefix'),
                'compare'   => esc_html__('Compare', 'wefix'),
                'quickview' => esc_html__('Quick View', 'wefix')
            );
            $settings['class']      = 'chosen';
            $settings['attributes'] = array( 'multiple' => 'multiple' );
            $settings['default']    =  $this->option_default_value;

            return $settings;
        }
    }

}

if( !function_exists('wefix_woo_listing_option_content_iconsgroup_icons') ) {
	function wefix_woo_listing_option_content_iconsgroup_icons() {
		return WeFix_Woo_Listing_Option_Content_Icons_Group_Icons::instance();
	}
}

wefix_woo_listing_option_content_iconsgroup_icons();