<?php

/**
 * Listing Options - Product Thumb Content
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Woo_Listing_Option_Thumb_Element_Group' ) ) {

    class WeFix_Woo_Listing_Option_Thumb_Element_Group extends WeFix_Woo_Listing_Option_Core {

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

            $this->option_slug          = 'product-thumb-element-group';
            $this->option_name          = esc_html__('Element Group Content', 'wefix');
            $this->option_type          = array ( 'html', 'value-css' );
            $this->option_default_value = '';
            $this->option_value_prefix  = '';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {

            /* Custom Product Templates - Options */
            add_filter( 'wefix_woo_custom_product_template_thumb_options', array( $this, 'woo_custom_product_template_thumb_options'), 55, 1 );
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
         * Setting Arguments
         */
        function setting_args() {

            $settings            =  array ();
            $settings['id']      =  $this->option_slug;
            $settings['type']    =  'sorter';
            $settings['title']   =  $this->option_name;
            $settings['default'] =  array (
                'enabled' => array(
                    'title' => esc_html__('Title', 'wefix'),
                    'price' => esc_html__('Price', 'wefix'),
                ),
                'disabled'         => array(
                    'cart'           => esc_html__('Cart', 'wefix'),
                    'wishlist'       => esc_html__('Wishlist', 'wefix'),
                    'compare'        => esc_html__('Compare', 'wefix'),
                    'quickview'      => esc_html__('Quick View', 'wefix'),
                    'category'       => esc_html__('Category', 'wefix'),
                    'button_element' => esc_html__('Button Element', 'wefix'),
                    'icons_group'    => esc_html__('Icons Group', 'wefix'),
                    'excerpt'        => esc_html__('Excerpt', 'wefix'),
                    'rating'         => esc_html__('Rating', 'wefix'),
                    'separator'      => esc_html__('Separator', 'wefix'),
                    'swatches'       => esc_html__('Swatches', 'wefix')
                ),
            );
            $settings['enabled_title']  =  esc_html__('Active Elements', 'wefix');
            $settings['disabled_title'] =  esc_html__('Deatcive Elements', 'wefix');

            return $settings;
        }
    }

}

if( !function_exists('wefix_woo_listing_option_thumb_element_group') ) {
	function wefix_woo_listing_option_thumb_element_group() {
		return WeFix_Woo_Listing_Option_Thumb_Element_Group::instance();
	}
}

wefix_woo_listing_option_thumb_element_group();