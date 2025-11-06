<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixPlusSitePopup' ) ) {
    class WeFixPlusSitePopup {

        private static $_instance = null;

        private $show_site_popup = false;
        private $site_popup = '';
        private $site_popup_conditions = '';
        private $site_popup_specific_pages = [];
        private $site_popup_exclude_specific_pages = [];

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->show_site_popup                   = wefix_customizer_settings( 'show_site_popup' );
            $this->site_popup                        = wefix_customizer_settings( 'site_popup' );
            $this->site_popup_conditions             = wefix_customizer_settings( 'site_popup_conditions' ); 
            $this->site_popup_specific_pages         = wefix_customizer_settings( 'site_popup_specific_pages' ); 
            $this->site_popup_exclude_specific_pages = wefix_customizer_settings( 'site_popup_exclude_specific_pages' ); 
            $this->load_loader_layouts();
            $this->load_modules();
            $this->frontend();
        }

        function load_loader_layouts() {
            foreach( glob( WEFIX_PLUS_DIR_PATH. 'modules/site-popup/layouts/*/index.php'  ) as $module ) {
                include_once $module;
            }
        }

        function load_modules() {
            include_once WEFIX_PLUS_DIR_PATH.'modules/site-popup/customizer/index.php';
        }

        function frontend() {
            if( $this->show_site_popup ) {
                add_action( 'wefix_after_main_css', array( $this, 'enqueue_assets' ) );
                add_action( 'wp_footer', array( $this, 'load_template' ) );
            }
        }

        function enqueue_assets() {
            if($this->show_site_popup) {    
            wp_enqueue_style( 'site-popup-css', WEFIX_PLUS_DIR_URL . 'modules/site-popup/assets/css/site-popup.css', false, WEFIX_PLUS_VERSION, 'all' );
            wp_enqueue_style( 'site-popup-jquery.magnific-popup-css', WEFIX_PLUS_DIR_URL . 'modules/site-popup/assets/css/jquery.magnific-popup.css', false, WEFIX_PLUS_VERSION, 'all' );
            
            wp_enqueue_script( 'site-popup-js', WEFIX_PLUS_DIR_URL . 'modules/site-popup/assets/js/site-popup.js', array('jquery'), WEFIX_PLUS_VERSION, true );
            wp_enqueue_script( 'site-popup-jquery-cookie', WEFIX_PLUS_DIR_URL . 'modules/site-popup/assets/js/jquery.cookie.min.js', array('jquery'), WEFIX_PLUS_VERSION, true );
            wp_enqueue_script( 'site-popup-jquery-magnific', WEFIX_PLUS_DIR_URL . 'modules/site-popup/assets/js/jquery.magnific-popup.min.js', array('jquery'), WEFIX_PLUS_VERSION, true );
            }
        }

        function load_template() {

            if ( ! $this->show_site_popup ) {
                return;
            }

            if ( empty( $this->site_popup ) || ! get_post( $this->site_popup ) ) {
                return;
            }

            $popup_conditions = wefix_customizer_settings( 'site_popup_conditions' );
            $specific_pages   = (array) wefix_customizer_settings( 'site_popup_specific_pages' );
            $exclude_pages    = (array) wefix_customizer_settings( 'site_popup_exclude_specific_pages' );

            $current_id = get_the_ID();

            if ( $popup_conditions === 'specific_pages' && ! in_array( $current_id, $specific_pages ) ) {
                return;
            }

            if ( $popup_conditions === 'all_pages' && in_array( $current_id, $exclude_pages ) ) {
                return;
            }

            $template_file = WEFIX_PLUS_DIR_PATH . 'modules/site-popup/layouts/template.php';
            if ( ! file_exists( $template_file ) ) {
                return;
            }

            $args = [
                'module_id'         => '1234',
                'module_ref_id'     => 'wdt-popup-box-main-wrapper',
                'popup_class'       => 'wdt-popup-box-holder',
                'trigger_type'      => 'on-load',
                'on_load_delay'     => ['unit' => 'ms', 'size' => 300],
                'on_load_after'     => ['unit' => 'day', 'size' => 1],
                'show_close_Button' => true,
                'esc_to_exit'       => true,
                'click_to_exit'     => true,
                'mfp_src'           => '#wdt-popup-box-wrapper',
                'mfp_type'          => 'inline',
            ];

            $template_id = $this->site_popup;

            include $template_file;
        }

    }
}

WeFixPlusSitePopup::instance();