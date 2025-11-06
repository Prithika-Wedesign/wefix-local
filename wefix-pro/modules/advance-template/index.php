<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixProAdvanceTemplate' ) ) {
    class WeFixProAdvanceTemplate {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_widgets();
            add_action( 'wefix_after_main_css', array( $this, 'enqueue_css_assets' ), 20 );
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_js_assets' ) );
        }

        function load_widgets() {
            add_action( 'widgets_init', array( $this, 'register_widgets_init' ) );
        }

        function register_widgets_init() {
            include_once WEFIX_PRO_DIR_PATH.'modules/advance-template/widget/widget-advance-template.php';
            register_widget('WeFix_Widget_Advance_Template');
        }
        function enqueue_css_assets() {
        }

        function enqueue_js_assets() {  
        }

    }
}

WeFixProAdvanceTemplate::instance();