<?php

/**
 * Plugin Name:	WeDesignTech Elementor Addon
 * Description: Adds additional modules for Elementor plugin.
 * Version: 1.0.0
 * Author: the WeDesignTech team
 * Author URI: https://wedesignthemes.com/
 * Text Domain: wdt-elementor-addon
 * Elementor tested up to: 3.32.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeDesignTechElementorAddon' ) ) {
    class WeDesignTechElementorAddon {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

			 /**
             * Before Init
             */
				$this->before_init();

                /**
                 * Load language text domian
                 */
                add_action('init', array($this, 'load_textdomain'));
                // Add this line to define translatable constants after init
                add_action('init', array($this, 'define_translatable_constants'), 11);


                $this->register_modules();
                $this->load_assets();


        }
		function before_init() {
            $this->define_non_translatable_constants();
			require_once WEDESIGNTECH_ELEMENTOR_ADDON_DIR_PATH . 'helpers/helper.php';
		}
        function define_non_translatable_constants()
        {
            define('WEDESIGNTECH_ELEMENTOR_ADDON_VERSION', '1.0.0');
            define('WEDESIGNTECH_ELEMENTOR_ADDON_ABS_PATH', dirname(__FILE__));
            define('WEDESIGNTECH_ELEMENTOR_ADDON_BASE_NAME', dirname(plugin_basename(__FILE__)));
            define('WEDESIGNTECH_ELEMENTOR_ADDON_DIR_PATH', trailingslashit(plugin_dir_path(__FILE__)));
            define('WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL', trailingslashit(plugin_dir_url(__FILE__)));
        }

        // Create this new method for translatable constants
        function define_translatable_constants()
        {
            define('WEDESIGNTECH_ELEMENTOR_ADDON_NAME', esc_html__('WeDesignTech Elementor Addon', 'wdt-elementor-addon'));
        }
        function load_textdomain() {
            load_plugin_textdomain( 'wdt-elementor-addon', false, WEDESIGNTECH_ELEMENTOR_ADDON_BASE_NAME . '/languages' );
        }

        function register_modules() {
            require_once WEDESIGNTECH_ELEMENTOR_ADDON_DIR_PATH . 'inc/register.php';
        }

        function load_assets() {
            add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'enqueue_ele_scripts' ), 10 ); // Elementor Assets file

            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 10 );
            add_action( 'wp_enqueue_scripts', array( $this, 'add_inline_styles' ), 10 );
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 10 );
        }

        function enqueue_styles() {

            wp_enqueue_style( 'wdt-elementor-addon-core', WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'assets/css/core.css', false, WEDESIGNTECH_ELEMENTOR_ADDON_VERSION, 'all');

            $css = $this->generate_core_css();
            if( !empty( $css ) ) {
                wp_add_inline_style( 'wdt-elementor-addon-core', ':root {'.$css.'}' );
            }

            // add css files from elementor widgets
            do_action('wedesigntech_elementor_enqueue_styles');

        }

        function generate_core_css() {

            $css = "\n";

            $css .=  '--wdt-elementor-color-primary: '.wedesigntech_elementor_global_colors( 'system_colors', 0 ).';'."\n";
            $css .=  '--wdt-elementor-color-primary-rgb: '.wedesigntech_hex2rgba(wedesigntech_elementor_global_colors( 'system_colors', 0 ), false).';'."\n";
            $css .=  '--wdt-elementor-color-secondary: '.wedesigntech_elementor_global_colors( 'system_colors', 1 ).';'."\n";
            $css .=  '--wdt-elementor-color-secondary-rgb: '.wedesigntech_hex2rgba(wedesigntech_elementor_global_colors( 'system_colors', 1 ), false).';'."\n";
            $css .=  '--wdt-elementor-color-text: '.wedesigntech_elementor_global_colors( 'system_colors', 2 ).';'."\n";
            $css .=  '--wdt-elementor-color-text-rgb: '.wedesigntech_hex2rgba(wedesigntech_elementor_global_colors( 'system_colors', 2 ), false).';'."\n";
            $css .=  '--wdt-elementor-color-accent: '.wedesigntech_elementor_global_colors( 'system_colors', 3 ).';'."\n";
            $css .=  '--wdt-elementor-color-accent-rgb: '.wedesigntech_hex2rgba(wedesigntech_elementor_global_colors( 'system_colors', 3 ), false).';'."\n";

            $css .=  '--wdt-elementor-color-custom-1: '.wedesigntech_elementor_global_colors( 'custom_colors', 0 ).';'."\n";
            $css .=  '--wdt-elementor-color-custom-1-rgb: '.wedesigntech_hex2rgba(wedesigntech_elementor_global_colors( 'custom_colors', 0 ), false).';'."\n";
            $css .=  '--wdt-elementor-color-custom-2: '.wedesigntech_elementor_global_colors( 'custom_colors', 1 ).';'."\n";
            $css .=  '--wdt-elementor-color-custom-2-rgb: '.wedesigntech_hex2rgba(wedesigntech_elementor_global_colors( 'custom_colors', 1 ), false).';'."\n";
            $css .=  '--wdt-elementor-color-custom-3: '.wedesigntech_elementor_global_colors( 'custom_colors', 2 ).';'."\n";
            $css .=  '--wdt-elementor-color-custom-3-rgb: '.wedesigntech_hex2rgba(wedesigntech_elementor_global_colors( 'custom_colors', 2 ), false).';'."\n";
            $css .=  '--wdt-elementor-color-custom-4: '.wedesigntech_elementor_global_colors( 'custom_colors', 3 ).';'."\n";
            $css .=  '--wdt-elementor-color-custom-4-rgb: '.wedesigntech_hex2rgba(wedesigntech_elementor_global_colors( 'custom_colors', 3 ), false).';'."\n";

            $css .=  '--wdt-elementor-typo-primary-font-family: '.wedesigntech_elementor_global_colors( 'system_typography', 0 )['typography_font_family'].';'."\n";
            $css .=  '--wdt-elementor-typo-primary-font-weight: '.wedesigntech_elementor_global_colors( 'system_typography', 0 )['typography_font_weight'].';'."\n";
            $css .=  '--wdt-elementor-typo-secondary-font-family: '.wedesigntech_elementor_global_colors( 'system_typography', 1 )['typography_font_family'].';'."\n";
            $css .=  '--wdt-elementor-typo-secondary-font-weight: '.wedesigntech_elementor_global_colors( 'system_typography', 1 )['typography_font_weight'].';'."\n";
            $css .=  '--wdt-elementor-typo-text-font-family: '.wedesigntech_elementor_global_colors( 'system_typography', 2 )['typography_font_family'].';'."\n";
            $css .=  '--wdt-elementor-typo-text-font-weight: '.wedesigntech_elementor_global_colors( 'system_typography', 2 )['typography_font_weight'].';'."\n";
            $css .=  '--wdt-elementor-typo-accent-font-family: '.wedesigntech_elementor_global_colors( 'system_typography', 3 )['typography_font_family'].';'."\n";
            $css .=  '--wdt-elementor-typo-accent-font-weight: '.wedesigntech_elementor_global_colors( 'system_typography', 3 )['typography_font_weight'].';'."\n";

            return $css;

        }

        function add_inline_styles() {

            wp_register_style( 'wdt-elementor-addon-inline', '', array (), WEDESIGNTECH_ELEMENTOR_ADDON_VERSION, 'all' );
            wp_enqueue_style( 'wdt-elementor-addon-inline' );

            $css = apply_filters( 'wedesigntech_elementor_addon_inline_style', '' );

            if( !empty( $css ) ) {
                wp_add_inline_style( 'wdt-elementor-addon-inline', $css );
            }

            // add inline css from elementor widgets
            do_action('wedesigntech_elementor_add_inline_styles');

        }

        function enqueue_ele_scripts() {
            wp_enqueue_style( 'ele-custom-css', WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'assets/css/wdt-ele.css', WEDESIGNTECH_ELEMENTOR_ADDON_VERSION, true );
        }

        function enqueue_scripts() {

            wp_register_script( 'wdt-parallax-scroll', WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'assets/js/parallax-scroll.min.js', array ('jquery'), WEDESIGNTECH_ELEMENTOR_ADDON_VERSION, true );
			wp_register_script( 'wdt-parallax', WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'assets/js/parallax.min.js', array ('jquery'), WEDESIGNTECH_ELEMENTOR_ADDON_VERSION, true );

            wp_enqueue_script( 'wdt-elementor-addon-core', WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'assets/js/core.js', array ('jquery'), WEDESIGNTECH_ELEMENTOR_ADDON_VERSION, true );

            $globals = apply_filters(
				'wedesigntech_elementor_addon_js_globals',
				array (
					'ajaxUrl' => admin_url('admin-ajax.php')
				)
			);

            wp_localize_script('wdt-elementor-addon-core', 'wdtElementorAddonGlobals', $globals );

            // add js files from elementor widgets
            do_action('wedesigntech_elementor_enqueue_scripts');

        }


    }
}

if( !function_exists( 'wedesigntech_elementor_addon' ) ) {
    function wedesigntech_elementor_addon() {
        return WeDesignTechElementorAddon::instance();
    }
}

if (  defined( 'ELEMENTOR_VERSION' ) ) {
    wedesigntech_elementor_addon();
} else {
    add_action( 'admin_init', 'wedesigntech_init' );
    function wedesigntech_init() {
        deactivate_plugins( plugin_basename( __FILE__ ) );
    }
}

register_activation_hook( __FILE__, 'wedesigntech_elementor_addon_activation_hook' );
function wedesigntech_elementor_addon_activation_hook() {

    if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
        deactivate_plugins( plugin_basename( __FILE__ ) );
        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'wdt-elementor-addon' ),
            '<strong>' . esc_html__( 'WeDesignTech Elementor Addon', 'wdt-elementor-addon' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor Plugin', 'wdt-elementor-addon' ) . '</strong>'
        );
        wp_die( sprintf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message ), 'Plugin dependency check', array( 'back_link' => true ) );
    } else {
        wedesigntech_elementor_addon();
    }

}