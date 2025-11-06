<?php
/**
 * Plugin Name:	WeFix Plus
 * Description: Adds additional features for WeFix Theme.
 * Version: 1.0.0
 * Author: the WeDesignTech team
 * Author URI: https://wedesignthemes.com/
 * Text Domain: wefix-plus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixPlus' ) ) {
    class WeFixPlus {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            /**
             * Before Hook
             */
            do_action( 'wefix_plus_before_plugin_load' );

                add_action('init', array($this, 'i18n'));
                add_action('init', array($this, 'define_constants_with_translations'), 11);
                add_filter( 'wefix_required_plugins_list', array( $this, 'upadate_required_plugins_list' ) );
                $this->define_constants_without_translations();
                $this->load_helper();
                $this->load_elementor();
                $this->load_customizer();
                $this->load_modules();
                $this->load_post_types();
    			add_filter( 'body_class', array( $this, 'add_body_classes' ) );
                add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );


            /**
             * After Hook
             */
            do_action( 'wefix_plus_after_plugin_load' );
        }

        function upadate_required_plugins_list($plugins_list) {

            $required_plugins = array(
                array(
                    'name'				=> 'Elementor',
                    'slug'				=> 'elementor',
                    'required'			=> false,
                    'force_activation'	=> false,
                ),
                array(
                    'name'				=> 'Contact Form 7',
                    'slug'				=> 'contact-form-7',
                    'required'			=> false,
                    'force_activation'	=> false,
                )
            );
            $new_plugins_list = array_merge($plugins_list, $required_plugins);

            return $new_plugins_list;

        }

        function i18n() {
            load_plugin_textdomain( 'wefix-plus', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        }

        function define_constants_without_translations()
        {
            define('WEFIX_PLUS_VERSION', '1.0.0');
            define('WEFIX_PLUS_DIR_PATH', trailingslashit(plugin_dir_path(__FILE__)));
            define('WEFIX_PLUS_DIR_URL', trailingslashit(plugin_dir_url(__FILE__)));
            define('WEFIX_CUSTOMISER_VAL', 'wefix-customiser-option');
        }

        function define_constants_with_translations()
        {
            // Define constants that require translations here
            define('WEFIX_PLUS_REQ_CAPTION', esc_html__('Go Pro!', 'wefix-plus'));
            define('WEFIX_PLUS_REQ_DESC', '<p>' . esc_html__('Avtivate WeFix Pro plugin to avail additional features!', 'wefix-plus') . '</p>');
        }

        function load_helper() {
            require_once WEFIX_PLUS_DIR_PATH . 'functions.php';
        }

        function load_customizer() {
            require_once WEFIX_PLUS_DIR_PATH . 'customizer/customizer.php';
        }

        function load_elementor() {
            require_once WEFIX_PLUS_DIR_PATH . 'elementor/index.php';
        }

        function load_modules() {

            /**
             * Before Hook
             */
            do_action( 'wefix_plus_before_load_modules' );

                foreach( glob( WEFIX_PLUS_DIR_PATH. 'modules/*/index.php'  ) as $module ) {
                    include_once $module;
                }

            /**
             * After Hook
             */
            do_action( 'wefix_plus_after_load_modules' );
        }

        function load_post_types() {
            require_once WEFIX_PLUS_DIR_PATH . 'post-types/post-types.php';
        }

        function add_body_classes( $classes ) {
            $classes[] = 'wefix-plus-'.WEFIX_PLUS_VERSION;
            return $classes;
        }


        function enqueue_assets() {
            wp_enqueue_style( 'wefix-plus-common', WEFIX_PLUS_DIR_URL . 'assets/css/common.css', false, WEFIX_PLUS_VERSION, 'all');
        }

    }
}

if( !function_exists( 'wefix_plus' ) ) {
    function wefix_plus() {
        return WeFixPlus::instance();
    }
}

if (class_exists ( 'WeFixPlus' )) {
    wefix_plus();
}

register_activation_hook( __FILE__, 'wefix_plus_activation_hook' );
function wefix_plus_activation_hook() {
    $settings = get_option( WEFIX_CUSTOMISER_VAL );
    if(empty($settings)) {
        update_option( constant( 'WEFIX_CUSTOMISER_VAL' ), apply_filters( 'wefix_plus_customizer_default', array() ) );
    }
}