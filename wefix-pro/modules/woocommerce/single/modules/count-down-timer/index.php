<?php

/**
 * WooCommerce - Single - Module - CountDown Timer
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Shop_Single_Module_Count_Down_Timer' ) ) {

    class WeFix_Shop_Single_Module_Count_Down_Timer {

        private static $_instance = null;

        private $product_sale_countdown_timer;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            // Load Modules
                $this->load_modules();

            // Enable Ajax Cart
                $settings = wefix_woo_single_core()->woo_default_settings();
                extract($settings);
                $this->product_sale_countdown_timer = $product_sale_countdown_timer;

            // Js Variables
                add_filter( 'wefix_woo_objects', array ( $this, 'woo_objects' ), 10, 1 );

            // Enqueue Count Down JS
                add_action( 'wefix_before_woo_js', array ( $this, 'before_woo_js' ), 10 );

            // CSS
                add_filter( 'wefix_woo_css', array( $this, 'woo_css'), 10, 1 );

            // JS
                add_filter( 'wefix_woo_js', array( $this, 'woo_js'), 10, 1 );

        }

        /*
        Module Paths
        */

            function module_dir_path() {

                if( wefix_is_file_in_theme( __FILE__ ) ) {
                    return WEFIX_MODULE_DIR . '/woocommerce/single/modules/count-down-timer/';
                } else {
                    return trailingslashit( plugin_dir_path( __FILE__ ) );
                }

            }

            function module_dir_url() {

                if( wefix_is_file_in_theme( __FILE__ ) ) {
                    return WEFIX_MODULE_URI . '/woocommerce/single/modules/count-down-timer/';
                } else {
                    return trailingslashit( plugin_dir_url( __FILE__ ) );
                }

            }


        /*
        Load Modules
        */

            function load_modules() {

                // If Theme-Plugin is activated

                    if( function_exists( 'wefix_pro' ) ) {

                        // Customizer
                            include_once $this->module_dir_path() . 'customizer/index.php';

                        // Elementor
                            include_once $this->module_dir_path() . 'elementor/index.php';

                    }

                // Includes
                    include_once $this->module_dir_path() . 'includes/index.php';

            }


        /*
        Js Variables
        */

            function woo_objects( $woo_objects ) {

                $product_template = wefix_shop_woo_product_single_template_option();

                $woo_objects['enable_countdown_scripts'] = esc_js(false);
                if( is_shop() || is_product_category() || is_product_tag() || ( $this->product_sale_countdown_timer && $product_template == 'woo-default' ) ) {
                    $woo_objects['enable_countdown_scripts'] = esc_js(true);
                }

                return $woo_objects;

            }


        /*
        Enqueue Count Down JS
        */
            function before_woo_js() {

                $product_template = wefix_shop_woo_product_single_template_option();

                if( is_shop() || is_product_category() || is_product_tag() || ( $this->product_sale_countdown_timer && $product_template == 'woo-default' ) ) {
                    wp_enqueue_script('jquery-downcount', $this->module_dir_url() . 'assets/js/jquery.downcount.js', array('jquery'), false, true);
                }

            }

        /*
        CSS
        */
            function woo_css( $css ) {

                $product_template = wefix_shop_woo_product_single_template_option();

                if( is_shop() || is_product_category() || is_product_tag() || ( $this->product_sale_countdown_timer && $product_template == 'woo-default' ) ) {

                    $css_file_path = $this->module_dir_path() . 'assets/css/style.css';

                    if( file_exists ( $css_file_path ) ) {

                        $css .= file_get_contents( $css_file_path );

                    }

                }

                return $css;

            }

        /*
        JS
        */
            function woo_js( $js ) {

                $product_template = wefix_shop_woo_product_single_template_option();

                if( is_shop() || is_product_category() || is_product_tag() || ( $this->product_sale_countdown_timer && $product_template == 'woo-default' ) ) {

                    $js_file_path = $this->module_dir_path() . 'assets/js/scripts.js';

                    if( file_exists ( $js_file_path ) ) {

                        $js .= file_get_contents( $js_file_path );

                    }

                }

                return $js;

            }

    }

}


if( !function_exists('wefix_shop_single_module_count_down_timer') ) {
	function wefix_shop_single_module_count_down_timer() {
        $reflection = new ReflectionClass('WeFix_Shop_Single_Module_Count_Down_Timer');
        return $reflection->newInstanceWithoutConstructor();
	}
}

if( class_exists( 'WeFix_Shop_Single_Module_Custom_template' ) ) {
    WeFix_Shop_Single_Module_Count_Down_Timer::instance();
}