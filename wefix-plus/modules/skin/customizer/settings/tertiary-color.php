<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixPlusSkinTertiaryColor' ) ) {
    class WeFixPlusSkinTertiaryColor {
        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'wefix_plus_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 15);

            add_filter( 'wefix_tertiary_color_css_var', array( $this, 'tertiary_color_var' ) );
            add_filter( 'wefix_tertiary_rgb_color_css_var', array( $this, 'tertiary_rgb_color_var' ) );
            add_filter( 'wefix_add_inline_style', array( $this, 'base_style' ) );
        }

        function default( $option ) {
            $theme_defaults = function_exists('wefix_theme_defaults') ? wefix_theme_defaults() : array ();
            $option['tertiary_color'] = $theme_defaults['tertiary_color'];
            return $option;
        }

        function register( $wp_customize ) {

                /**
                 * Option : Tertiary Color
                 */
                $wp_customize->add_setting(
                    WEFIX_CUSTOMISER_VAL . '[tertiary_color]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WeFix_Customize_Control_Color(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[tertiary_color]', array(
                            'section' => 'site-skin-main-section',
                            'label'   => esc_html__( 'Tertiary Color', 'wefix-plus' ),
                        )
                    )
                );

        }

        function tertiary_color_var( $var ) {
            $tertiary_color = wefix_customizer_settings( 'tertiary_color' );
            if( !empty( $tertiary_color ) ) {
                $var = '--wdtTertiaryColor:'.esc_attr($tertiary_color).';';
            }

            return $var;
        }

        function tertiary_rgb_color_var( $var ) {
            $tertiary_color = wefix_customizer_settings( 'tertiary_color' );
            if( !empty( $tertiary_color ) ) {
                $var = '--wdtTertiaryColorRgb:'.wefix_hex2rgba($tertiary_color, false).';';
            }

            return $var;
        }

        function base_style( $style ) {
            $style = apply_filters( 'wefix_tertiary_color_style', $style );

            return $style;
        }
    }
}

WeFixPlusSkinTertiaryColor::instance();