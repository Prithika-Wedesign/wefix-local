<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixProSiteTitle' ) ) {
    class WeFixProSiteTitle {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_modules();
        }

        function load_modules() {
            include_once WEFIX_PRO_DIR_PATH.'modules/site-title/customizer/index.php';
        }
    }
}

WeFixProSiteTitle::instance();