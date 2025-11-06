<?php

/**
 * Customizer - Product Single Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Pro_Customizer_Single' ) ) {

    class WeFix_Pro_Customizer_Single {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'wefix_shop_pro_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 15);

        }

        function default( $option ) {

            $settings = wefix_woo_single_core()->woo_default_settings();
            extract($settings);

            $option['wdt-single-product-default-template']           = $product_default_template;
            $option['wdt-single-product-sale-countdown-timer']       = $product_sale_countdown_timer;
            $option['wdt-single-product-enable-size-guide']          = $product_enable_size_guide;
            $option['wdt-single-product-disable-breadcrumb']         = $product_disable_breadcrumb;
            $option['wdt-single-product-addtocart-sticky']           = $product_addtocart_sticky;
            $option['wdt-single-product-show-360-viewer']            = $product_show_360_viewer;
            $option['wdt-single-product-enable-ajax-addtocart']      = $product_enable_ajax_addtocart;

            $option['wdt-single-product-upsell-display']             = $product_upsell_display;
            $option['wdt-single-product-upsell-title']               = $product_upsell_title;
            $option['wdt-single-product-upsell-column']              = $product_upsell_column;
            $option['wdt-single-product-upsell-limit']               = $product_upsell_limit;
            if( $product_upsell_style_template == 'predefined' ) {
                $option['wdt-single-product-upsell-style-template']  = 'predefined-template-'.$product_upsell_style_custom_template;
            } else {
                $option['wdt-single-product-upsell-style-template']  = $product_upsell_style_custom_template;
            }

            $option['wdt-single-product-related-display']            = $product_related_display;
            $option['wdt-single-product-related-title']              = $product_related_title;
            $option['wdt-single-product-related-column']             = $product_related_column;
            $option['wdt-single-product-related-limit']              = $product_related_limit;
            if( $product_related_style_template == 'predefined' ) {
                $option['wdt-single-product-related-style-template'] = 'predefined-template-'.$product_related_style_custom_template;
            } else {
                $option['wdt-single-product-related-style-template'] = $product_related_style_custom_template;
            }

            $option['wdt-single-product-show-sharer-facebook']       = $product_show_sharer_facebook;
            $option['wdt-single-product-show-sharer-delicious']      = $product_show_sharer_delicious;
            $option['wdt-single-product-show-sharer-digg']           = $product_show_sharer_digg;
            $option['wdt-single-product-show-sharer-stumbleupon']    = $product_show_sharer_stumbleupon;
            $option['wdt-single-product-show-sharer-twitter']        = $product_show_sharer_twitter;
            $option['wdt-single-product-show-sharer-googleplus']     = $product_show_sharer_googleplus;
            $option['wdt-single-product-show-sharer-linkedin']       = $product_show_sharer_linkedin;
            $option['wdt-single-product-show-sharer-pinterest']      = $product_show_sharer_pinterest;

            return $option;

        }

        function register( $wp_customize ) {

            $wp_customize->add_panel(
                new WeFix_Customize_Panel(
                    $wp_customize,
                    'woocommerce-single-page-section',
                    array(
                        'title'    => esc_html__('Product Single Page', 'wefix-pro'),
                        'panel'    => 'woocommerce-main-section',
                        'priority' => 40
                    )
                )
            );

                $wp_customize->add_section(
                    new WeFix_Customize_Section(
                        $wp_customize,
                        'woocommerce-single-page-default-section',
                        array(
                            'title'    => esc_html__('Default Settings', 'wefix-pro'),
                            'panel'    => 'woocommerce-single-page-section',
                            'priority' => 10,
                        )
                    )
                );

                $wp_customize->add_section(
                    new WeFix_Customize_Section(
                        $wp_customize,
                        'woocommerce-single-page-upsell-section',
                        array(
                            'title'    => esc_html__('Upsell Settings', 'wefix-pro'),
                            'panel'    => 'woocommerce-single-page-section',
                            'priority' => 20,
                        )
                    )
                );

                $wp_customize->add_section(
                    new WeFix_Customize_Section(
                        $wp_customize,
                        'woocommerce-single-page-related-section',
                        array(
                            'title'    => esc_html__('Related Settings', 'wefix-pro'),
                            'panel'    => 'woocommerce-single-page-section',
                            'priority' => 30,
                        )
                    )
                );

                $wp_customize->add_section(
                    new WeFix_Customize_Section(
                        $wp_customize,
                        'woocommerce-single-page-sociable-share-section',
                        array(
                            'title'    => esc_html__('Sociable Share Settings', 'wefix-pro'),
                            'panel'    => 'woocommerce-single-page-section',
                            'priority' => 40,
                        )
                    )
                );

                $wp_customize->add_section(
                    new WeFix_Customize_Section(
                        $wp_customize,
                        'woocommerce-single-page-sociable-follow-section',
                        array(
                            'title'    => esc_html__('Sociable Follow Settings', 'wefix-pro'),
                            'panel'    => 'woocommerce-single-page-section',
                            'priority' => 50,
                        )
                    )
                );

        }

    }

}


if( !function_exists('wefix_customizer_single') ) {
	function wefix_customizer_single() {
		return WeFix_Pro_Customizer_Single::instance();
	}
}

wefix_customizer_single();