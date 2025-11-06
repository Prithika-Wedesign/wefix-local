<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixPlusBreadcrumbAlignRight' ) ) {
    class WeFixPlusBreadcrumbAlignRight {

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
            $options['alignright'] = esc_html__('Align Right', 'wefix-plus');
            return $options;
        }
    }
}

WeFixPlusBreadcrumbAlignRight::instance();