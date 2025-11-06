<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixPlusCustomizerSiteBreadcrumb' ) ) {
    class WeFixPlusCustomizerSiteBreadcrumb {

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
             * Panel
             */
            $wp_customize->add_panel(
                new WeFix_Customize_Panel(
                    $wp_customize,
                    'site-breadcrumb-main-panel',
                    array(
                        'title'    => esc_html__('Site Breadcrumb', 'wefix-plus'),
                        'priority' => wefix_customizer_panel_priority( 'breadcrumb' )
                    )
                )
            );
        }

        function load_modules() {
            foreach( glob( WEFIX_PLUS_DIR_PATH. 'modules/breadcrumb/customizer/settings/*.php'  ) as $module ) {
                include_once $module;
            }
        }
    }
}

WeFixPlusCustomizerSiteBreadcrumb::instance();