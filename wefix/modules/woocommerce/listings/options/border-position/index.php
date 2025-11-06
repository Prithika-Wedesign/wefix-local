<?php
/**
 * Listing Options - Image Effect
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Woo_Listing_Option_Border_Position' ) ) {

    class WeFix_Woo_Listing_Option_Border_Position extends WeFix_Woo_Listing_Option_Core {

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

            $this->option_slug          = 'product-border-position';
            $this->option_name          = esc_html__('Border Position', 'wefix');
            $this->option_type          = array ( 'class', 'value-css' );
            $this->option_default_value = 'product-border-position-default';
            $this->option_value_prefix  = 'product-border-position-';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {
            add_filter( 'wefix_woo_custom_product_template_common_options', array( $this, 'woo_custom_product_template_common_options'), 45, 1 );
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
            $settings['type']    =  'select';
            $settings['title']   =  $this->option_name;
            $settings['options'] =  array (
                'product-border-position-default'      => esc_html__('Default', 'wefix'),
                'product-border-position-left'         => esc_html__('Left', 'wefix'),
                'product-border-position-right'        => esc_html__('Right', 'wefix'),
                'product-border-position-top'          => esc_html__('Top', 'wefix'),
                'product-border-position-bottom'       => esc_html__('Bottom', 'wefix'),
                'product-border-position-top-left'     => esc_html__('Top Left', 'wefix'),
                'product-border-position-top-right'    => esc_html__('Top Right', 'wefix'),
                'product-border-position-bottom-left'  => esc_html__('Bottom Left', 'wefix'),
                'product-border-position-bottom-right' => esc_html__('Bottom Right', 'wefix')
            );
            $settings['default'] =  $this->option_default_value;

            return $settings;
        }
    }

}

if( !function_exists('wefix_woo_listing_option_border_position') ) {
	function wefix_woo_listing_option_border_position() {
		return WeFix_Woo_Listing_Option_Border_Position::instance();
	}
}

wefix_woo_listing_option_border_position();