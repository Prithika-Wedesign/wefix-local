<?php
/**
 * Listing Options - Image Effect
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Woo_Listing_Option_Content_Button_Element_Style' ) ) {

    class WeFix_Woo_Listing_Option_Content_Button_Element_Style extends WeFix_Woo_Listing_Option_Core {

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

            $this->option_slug          = 'product-content-buttonelement-style';
            $this->option_name          = esc_html__('Button Element - Style', 'wefix');
            $this->option_default_value = 'product-content-buttonelement-style-simple';
            $this->option_type          = array ( 'class', 'value-css' );
            $this->option_value_prefix  = 'product-content-buttonelement-style-';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {
            add_filter( 'wefix_woo_custom_product_template_content_options', array( $this, 'woo_custom_product_template_content_options'), 40, 1 );
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
                'product-content-buttonelement-style-simple'                      => esc_html__('Simple', 'wefix'),
                'product-content-buttonelement-style-bgfill-square'               => esc_html__('Background Fill Square', 'wefix'),
                'product-content-buttonelement-style-bgfill-rounded-square'       => esc_html__('Background Fill Rounded Square', 'wefix'),
                'product-content-buttonelement-style-bgfill-rounded'              => esc_html__('Background Fill Rounded', 'wefix'),
                'product-content-buttonelement-style-brdrfill-square'             => esc_html__('Border Fill Square', 'wefix'),
                'product-content-buttonelement-style-brdrfill-rounded-square'     => esc_html__('Border Fill Rounded Square', 'wefix'),
                'product-content-buttonelement-style-brdrfill-rounded'            => esc_html__('Border Fill Rounded', 'wefix'),
                'product-content-buttonelement-style-skinbgfill-square'           => esc_html__('Skin Background Fill Square', 'wefix'),
                'product-content-buttonelement-style-skinbgfill-rounded-square'   => esc_html__('Skin Background Fill Rounded Square', 'wefix'),
                'product-content-buttonelement-style-skinbgfill-rounded'          => esc_html__('Skin Background Fill Rounded', 'wefix'),
                'product-content-buttonelement-style-skinbrdrfill-square'         => esc_html__('Skin Border Fill Square', 'wefix'),
                'product-content-buttonelement-style-skinbrdrfill-rounded-square' => esc_html__('Skin Border Fill Rounded Square', 'wefix'),
                'product-content-buttonelement-style-skinbrdrfill-rounded'        => esc_html__('Skin Border Fill Rounded', 'wefix')
            );
            $settings['default']    =  $this->option_default_value;

            return $settings;
        }
    }

}

if( !function_exists('wefix_woo_listing_option_content_buttonelement_style') ) {
	function wefix_woo_listing_option_content_buttonelement_style() {
		return WeFix_Woo_Listing_Option_Content_Button_Element_Style::instance();
	}
}

wefix_woo_listing_option_content_buttonelement_style();