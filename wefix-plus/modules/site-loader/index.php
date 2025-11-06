<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixPlusSiteLoader' ) ) {
    class WeFixPlusSiteLoader {

        private static $_instance = null;

        private $show_site_loader = false;
        private $site_loader = '';

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->show_site_loader = wefix_customizer_settings( 'show_site_loader' );
            $this->site_loader = wefix_customizer_settings( 'site_loader' );
            $this->load_loader_layouts();
            $this->load_modules();
            $this->frontend();
        }

        function load_loader_layouts() {
            foreach( glob( WEFIX_PLUS_DIR_PATH. 'modules/site-loader/layouts/*/index.php'  ) as $module ) {
                include_once $module;
            }
        }

        function load_modules() {
            include_once WEFIX_PLUS_DIR_PATH.'modules/site-loader/customizer/index.php';
        }

        function frontend() {
            if( $this->show_site_loader ) {
                add_action( 'wefix_after_main_css', array( $this, 'enqueue_assets' ) );
                add_action( 'wefix_hook_top', array( $this, 'load_template' ) );
            }
        }

        function enqueue_assets() {
            if($this->show_site_loader) {
                if(in_array($this->site_loader, array ('loader-1', 'custom-loader'))) {
                    wp_enqueue_script( 'site-loader', WEFIX_PLUS_DIR_URL . 'modules/site-loader/assets/js/site-loader.js', array('jquery'), WEFIX_PLUS_VERSION, true );
                }
            }
        }

        function load_template() {
            if($this->show_site_loader) {
                if(in_array($this->site_loader, array ('loader-1', 'custom-loader'))) {
                    echo wefix_get_template_part( 'site-loader/layouts/'.esc_attr($this->site_loader), '/template', '', array() );
                }
            }
        }

    }
}

WeFixPlusSiteLoader::instance();
