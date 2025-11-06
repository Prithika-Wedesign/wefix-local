<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixProCustomizerSiteTagline' ) ) {
    class WeFixProCustomizerSiteTagline {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15 );
            add_filter( 'wefix_google_fonts_list', array( $this, 'fonts_list' ) );
        }

        function register( $wp_customize ) {

            /**
             * Option :Site Tagline Typography
             */
                $wp_customize->add_setting(
                    WEFIX_CUSTOMISER_VAL . '[site_tagline_typo]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WeFix_Customize_Control_Typography(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[site_tagline_typo]', array(
                            'type'    => 'wdt-typography',
                            'section' => 'site-tagline-section',
                            'label'   => esc_html__( 'Typography', 'wefix-pro'),
                        )
                    )
                );
            
        }

        function fonts_list( $fonts ) {
            $settings = wefix_customizer_settings( 'site_tagline_typo' );
            return wefix_customizer_frontend_font( $settings, $fonts );
        }

    }
}

WeFixProCustomizerSiteTagline::instance();