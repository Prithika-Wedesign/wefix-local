<?php

/**
 * WooCommerce - Others - Quantity Plus Minus - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Shop_Customizer_Others_Quantity_Plus_Minus' ) ) {

    class WeFix_Shop_Customizer_Others_Quantity_Plus_Minus {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'wefix_woo_others_settings', array( $this, 'others_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 15);

        }

        function others_settings( $settings ) {

            $enable_quantity_plusminus             = wefix_customizer_settings('wdt-woo-others-enable-quantity-plusminus' );
            $settings['enable_quantity_plusminus'] = $enable_quantity_plusminus;
            $enable_quantity_modern             = wefix_customizer_settings('wdt-woo-others-enable-quantity-modern' );
            $settings['enable_quantity_modern'] = $enable_quantity_modern;

            return $settings;

        }

        function register( $wp_customize ) {

            /**
             * Option : Enable Quantity Plus Minus
             */

               $wp_customize->add_setting(
                    WEFIX_CUSTOMISER_VAL . '[wdt-woo-others-enable-quantity-modern]', array(
                        'type' => 'option',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    )
                );
                   $wp_customize->add_control(
                    new WeFix_Customize_Control_Switch(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[wdt-woo-others-enable-quantity-modern]', array(
                            'type'    => 'wdt-switch',
                            'label'   => esc_html__( 'Enable Quantity Modern', 'wefix'),
                            'section' => 'woocommerce-others-section',
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'wefix' ),
                                'off' => esc_attr__( 'No', 'wefix' )
                            )
                        )
                    )
                );


                $wp_customize->add_setting(
                    WEFIX_CUSTOMISER_VAL . '[wdt-woo-others-enable-quantity-plusminus]', array(
                        'type' => 'option',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    )
                );
                

                $wp_customize->add_control(
                    new WeFix_Customize_Control_Switch(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[wdt-woo-others-enable-quantity-plusminus]', array(
                            'type'    => 'wdt-switch',
                            'label'   => esc_html__( 'Enable Quantity Plus Minus', 'wefix'),
                            'section' => 'woocommerce-others-section',
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'wefix' ),
                                'off' => esc_attr__( 'No', 'wefix' )
                            )
                        )
                    )
                );

        }

    }

}


if( !function_exists('wefix_shop_customizer_others_quantity_plus_minus') ) {
	function wefix_shop_customizer_others_quantity_plus_minus() {
		return WeFix_Shop_Customizer_Others_Quantity_Plus_Minus::instance();
	}
}

wefix_shop_customizer_others_quantity_plus_minus();