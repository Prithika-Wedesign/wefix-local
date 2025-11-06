<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixPlusBCDefault' ) ) {
    class WeFixPlusBCDefault {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_backend();
        }

        function load_backend() {
            add_filter( 'wefix_breadcrumb_source', array( $this, 'register_option' ) );
        }

        function register_option( $options ) {
            $options['default'] = esc_html__('Default','wefix-plus');
            return $options;
        }
    }
}

WeFixPlusBCDefault::instance();