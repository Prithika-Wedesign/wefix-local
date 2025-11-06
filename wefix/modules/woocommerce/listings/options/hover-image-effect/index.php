<?php
/**
 * Listing Options - Image Effect
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Woo_Listing_Option_Hover_Image_Effect' ) ) {

    class WeFix_Woo_Listing_Option_Hover_Image_Effect extends WeFix_Woo_Listing_Option_Core {

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

            $this->option_slug          = 'product-hover-image-effect';
            $this->option_name          = esc_html__('Image Effect', 'wefix');
            $this->option_type          = array ( 'class', 'value-css' );
            $this->option_default_value = '';
            $this->option_value_prefix  = 'product-hover-image-';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {
            add_filter( 'wefix_woo_custom_product_template_hover_options', array( $this, 'woo_custom_product_template_hover_options'), 10, 1 );
        }

        /**
         * Custom Product Templates - Options
         */
        function woo_custom_product_template_hover_options( $template_options ) {

            array_push( $template_options, $this->setting_args() );

            return $template_options;
        }

        /**
         * Settings Group
         */
        function setting_group() {
            return 'hover';
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
                ''                                => esc_html__('None', 'wefix'),
                'product-hover-image-blur'        => esc_html__('Blur', 'wefix'),
                'product-hover-image-blackwhite'  => esc_html__('Black & White', 'wefix'),
                'product-hover-image-fadeinleft'  => esc_html__('Fade In Left', 'wefix'),
                'product-hover-image-fadeinright' => esc_html__('Fade In Right', 'wefix'),
                'product-hover-image-rotate'      => esc_html__('Rotate', 'wefix'),
                'product-hover-image-rotatealt'   => esc_html__('Rotate - Alt', 'wefix'),
                'product-hover-image-scalein'     => esc_html__('Scale In', 'wefix'),
                'product-hover-image-scaleout'    => esc_html__('Scale Out', 'wefix'),
                'product-hover-image-floatout'    => esc_html__('Float Up', 'wefix')

            );
            $settings['default'] =  $this->option_default_value;

            return $settings;
        }
    }

}

if( !function_exists('wefix_woo_listing_option_hover_image_effect') ) {
	function wefix_woo_listing_option_hover_image_effect() {
		return WeFix_Woo_Listing_Option_Hover_Image_Effect::instance();
	}
}

wefix_woo_listing_option_hover_image_effect();