<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixPlusBreadcrumbRight' ) ) {
    class WeFixPlusBreadcrumbRight {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'wefix_plus_breadcrumb_layouts', array( $this, 'add_option' ) );
        }

        function add_option( $options ) {
            $options['breadcrumb-right'] = esc_html__('Breadcrumb Right', 'wefix-plus');
            return $options;
        }
    }
}

WeFixPlusBreadcrumbRight::instance();