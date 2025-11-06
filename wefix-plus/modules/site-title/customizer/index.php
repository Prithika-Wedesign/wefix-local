<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixPlusCustomizerSiteTitle' ) ) {
    class WeFixPlusCustomizerSiteTitle {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15 );
        }

        function register( $wp_customize ) {

            $wp_customize->add_section(
                new WeFix_Customize_Section(
                    $wp_customize,
                    'site-title-section',
                    array(
                        'title'    => esc_html__('Site Title', 'wefix-plus'),
                        'panel'    => 'site-identity-main-panel',
                        'priority' => 10,
                    )
                )
            );

            $wp_customize->remove_control('display_header_text');
            $wp_customize->get_control('blogname')->section  = 'site-title-section';
            $wp_customize->get_control('blogname')->priority = 5;

            if ( ! defined( 'WEFIX_PRO_VERSION' ) ) {
                $wp_customize->add_control(
                    new WeFix_Customize_Control_Separator(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[wefix-plus-site-title-separator]',
                        array(
                            'type'        => 'wdt-separator',
                            'section'     => 'site-title-section',
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

WeFixPlusCustomizerSiteTitle::instance();