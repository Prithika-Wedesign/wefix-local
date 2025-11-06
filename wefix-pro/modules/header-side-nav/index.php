<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixHeaderProSideNav' ) ) {
    class WeFixHeaderProSideNav {

        private static $_instance = null;
        private $global_layout    = '';
        private $global_sidebar   = '';

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_module();
            $this->frontend();
        }

        function load_module() {
            include_once WEFIX_PRO_DIR_PATH.'modules/side-nav/metabox/index.php';
            include_once WEFIX_PRO_DIR_PATH.'modules/side-nav/elementor/index.php';
            add_filter( 'theme_page_templates', array( $this, 'add_sidenav_template' ) );
        }

        function add_sidenav_template( $templates ) {
            $templates = array_merge( $templates, array( 'tpl-header-side-nav.php' => esc_html__('Header Side Navigation', 'wefix-pro' ) ) );
            return $templates;
        }

        function frontend() {
            add_action( 'wefix_after_main_css', array( $this, 'enqueue_assets' ) );
        }

        function enqueue_assets() {
            $page_template = $this->get_page_template();
            if( $page_template == 'tpl-header-side-nav.php' ) {
                wp_enqueue_style( 'headersidenav', WEFIX_PRO_DIR_URL . 'modules/header-side-nav/assets/css/header-side-nav.css', false, WEFIX_PRO_VERSION, 'all' );
                wp_enqueue_script( 'theia-sticky-sidebar', WEFIX_PRO_DIR_URL . 'assets/js/theia-sticky-sidebar.min.js', array('jquery'), WEFIX_PRO_VERSION, true );
            }
        }
        function get_page_template() {
            if( is_singular('page') ) {
                return get_post_meta( get_the_ID(), '_wp_page_template', true );
            }
        }
    }
}

WeFixHeaderProSideNav::instance();