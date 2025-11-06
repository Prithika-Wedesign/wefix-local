<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixPlusCustomizerSidebar' ) ) {
    class WeFixPlusCustomizerSidebar {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            add_action( 'customize_register', array( $this, 'register' ), 15);
            $this->load_modules();
        }

        function register( $wp_customize ) {

            /**
             * Main Panel
             */
            $wp_customize->add_panel(
                new WeFix_Customize_Panel(
                    $wp_customize,
                    'site-widget-main-panel',
                    array(
                        'title'    => esc_html__('Site Sidebar', 'wefix-plus'),
                        'priority' => wefix_customizer_panel_priority( 'sidebar' )
                    )
                )
            );

                /**
                 * Settings Panel
                 */
                $wp_customize->add_panel(
                    new WeFix_Customize_Panel(
                        $wp_customize,
                        'site-widget-settings-panel',
                        array(
                            'title'    => esc_html__('Settings', 'wefix-plus'),
                            'panel'    => 'site-widget-main-panel',
                            'priority' => 10
                        )
                    )
                );

                /**
                 * Widget Area Panel
                 */
                $wp_customize->add_panel(
                    new WeFix_Customize_Panel(
                        $wp_customize,
                        'widgets',
                        array(
                            'title'       => esc_html__('Widget Areas', 'wefix-plus'),
                            'panel'       => 'site-widget-main-panel',
                            'description' => esc_html__( 'Widgets are independent sections of content that can be placed into widgetized areas provided by your theme (commonly lled sidebars).', 'wefix-plus' ),
                            'priority'    => 15,
                        )
                    )
                );

        }

        function load_modules() {
            foreach( glob( WEFIX_PLUS_DIR_PATH. 'modules/sidebar/customizer/settings/*.php'  ) as $module ) {
                include_once $module;
            }
        }

    }
}

WeFixPlusCustomizerSidebar::instance();