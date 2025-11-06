<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixPlusBreadcrumb' ) ) {
    class WeFixPlusBreadcrumb {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_breadcrumb_layouts();
            $this->load_modules();
            $this->load_frontend();
        }

        function load_breadcrumb_layouts() {
            foreach( glob( WEFIX_PLUS_DIR_PATH. 'modules/breadcrumb/layouts/*/index.php'  ) as $module ) {
                include_once $module;
            }
            foreach( glob( WEFIX_PLUS_DIR_PATH. 'modules/breadcrumb/templates/*/index.php'  ) as $module ) {
                include_once $module;
            }
        }

        function load_modules() {
            include_once WEFIX_PLUS_DIR_PATH.'modules/breadcrumb/customizer/index.php';
        }

        function load_frontend() {
            include_once WEFIX_PLUS_DIR_PATH.'modules/breadcrumb/templates/index.php';
        }
    }
}

WeFixPlusBreadcrumb::instance();