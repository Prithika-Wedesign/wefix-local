<?php

/**
 * Listing Options - Overlay Effect
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Woo_Listing_Option_Overlay_Effect' ) ) {

    class WeFix_Woo_Listing_Option_Overlay_Effect extends WeFix_Woo_Listing_Option_Core {

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

            $this->option_slug          = 'product-overlay-effect';
            $this->option_name          = esc_html__('Overlay Effect', 'wefix');
            $this->option_type          = array ( 'class', 'value-css' );
            $this->option_default_value = '';
            $this->option_value_prefix  = 'product-overlay-';

            $this->render_backend();

        }

        /*
        Backend Render
        */

            function render_backend() {

                /* Custom Product Templates - Options */
                    add_filter( 'wefix_woo_custom_product_template_hover_options', array( $this, 'woo_custom_product_template_hover_options'), 20, 1 );

            }

        /*
        Custom Product Templates - Options
        */
            function woo_custom_product_template_hover_options( $template_options ) {

                array_push( $template_options, $this->setting_args() );

                return $template_options;

            }

        /*
        Setting Group
        */
            function setting_group() {

                return 'hover';

            }

        /*
        Setting Arguments
        */
            function setting_args() {

                $settings                                 =  array ();

                $settings['id']                           =  $this->option_slug;
                $settings['type']                         =  'select';
                $settings['title']                        =  $this->option_name;
                $settings['options']                      =  array (
                    ''                                    => esc_html__('None', 'wefix'),
                    'product-overlay-fixed'               => esc_html__('Fixed', 'wefix'),
                    'product-overlay-toptobottom'         => esc_html__('Top to Bottom', 'wefix'),
                    'product-overlay-bottomtotop'         => esc_html__('Bottom to Top', 'wefix'),
                    'product-overlay-righttoleft'         => esc_html__('Right to Left', 'wefix'),
                    'product-overlay-lefttoright'         => esc_html__('Left to Right', 'wefix'),
                    'product-overlay-middle'              => esc_html__('Middle', 'wefix'),
                    'product-overlay-middleradial'        => esc_html__('Middle Radial', 'wefix'),
                    'product-overlay-gradienttoptobottom' => esc_html__('Gradient - Top to Bottom', 'wefix'),
                    'product-overlay-gradientbottomtotop' => esc_html__('Gradient - Bottom to Top', 'wefix'),
                    'product-overlay-gradientrighttoleft' => esc_html__('Gradient - Right to Left', 'wefix'),
                    'product-overlay-gradientlefttoright' => esc_html__('Gradient - Left to Right', 'wefix'),
                    'product-overlay-gradientradial'      => esc_html__('Gradient - Radial', 'wefix'),
                    'product-overlay-flash'               => esc_html__('Flash', 'wefix'),
                    'product-overlay-scale'               => esc_html__('Scale', 'wefix'),
                    'product-overlay-horizontalelastic'   => esc_html__('Horizontal - Elastic', 'wefix'),
                    'product-overlay-verticalelastic'     => esc_html__('Vertical - Elastic', 'wefix')
                );
                $settings['default']                      =  $this->option_default_value;

                return $settings;

            }

    }

}

if( !function_exists('wefix_woo_listing_option_overlay_effect') ) {
	function wefix_woo_listing_option_overlay_effect() {
		return WeFix_Woo_Listing_Option_Overlay_Effect::instance();
	}
}

wefix_woo_listing_option_overlay_effect();