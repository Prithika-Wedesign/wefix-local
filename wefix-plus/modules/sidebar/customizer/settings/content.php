<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixPlusWidgetContentSettings' ) ) {
    class WeFixPlusWidgetContentSettings {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15);
        }

        function register( $wp_customize ){

            /**
             * Content Section
             */
            $wp_customize->add_section(
                new WeFix_Customize_Section(
                    $wp_customize,
                    'site-widgets-content-style-section',
                    array(
                        'title'    => esc_html__('Widget Content', 'wefix-plus'),
                        'panel'    => 'site-widget-settings-panel',
                        'priority' => 10,
                    )
                )
            );

            if ( ! defined( 'WEFIX_PRO_VERSION' ) ) {
                $wp_customize->add_control(
                    new WeFix_Customize_Control_Separator(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[wefix-plus-site-widgets-content-style-separator]',
                        array(
                            'type'        => 'wdt-separator',
                            'section'     => 'site-widgets-content-style-section',
                            'settings'    => array(),
                            'caption'     => WEFIX_PLUS_REQ_CAPTION,
                            'description' => WEFIX_PLUS_REQ_DESC,
                        )
                    )
                );
            }

        }

    }
}

WeFixPlusWidgetContentSettings::instance();