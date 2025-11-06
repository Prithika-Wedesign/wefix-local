<?php

/**
 * WooCommerce - Size Guide Core Class
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Shop_Others_Size_Guide' ) ) {

    class WeFix_Shop_Others_Size_Guide {

        private static $_instance = null;

        private $product_enable_size_guide;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            // Load Modules
                $this->load_modules();

            // Enable Size Guide
                $settings = wefix_woo_single_core()->woo_default_settings();
                extract($settings);
                $this->product_enable_size_guide = $product_enable_size_guide;

            // Js Variables
                add_filter( 'wefix_woo_objects', array ( $this, 'woo_objects' ), 10, 1 );

            // Enqueue CSS
                add_action( 'wefix_before_woo_css', array ( $this, 'before_woo_css' ), 10 );

            // Enqueue JS
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
                    return WEFIX_MODULE_DIR . '/woocommerce/others/size-guide/';
                } else {
                    return trailingslashit( plugin_dir_path( __FILE__ ) );
                }

            }

            function module_dir_url() {

                if( wefix_is_file_in_theme( __FILE__ ) ) {
                    return WEFIX_MODULE_URI . '/woocommerce/others/size-guide/';
                } else {
                    return trailingslashit( plugin_dir_url( __FILE__ ) );
                }

            }

        /**
         * Load Modules
         */
            function load_modules() {

                // Includes
                    include_once $this->module_dir_path(). 'includes/index.php';

                if( function_exists( 'wefix_pro' ) ) {

                    // Customizer
                        include_once $this->module_dir_path(). 'customizer/index.php';

                    // Elementor
                        include_once $this->module_dir_path(). 'elementor/index.php';

                }

            }

        /*
        Js Variables
        */

            function woo_objects( $woo_objects ) {

                $product_template = wefix_shop_woo_product_single_template_option();

                $woo_objects['product_enable_size_guide'] = esc_js($this->product_enable_size_guide);
                $woo_objects['product_template']          = esc_js($product_template);

                return $woo_objects;

            }

        /*
        Enqueue CSS
        */
            function before_woo_css() {

                if($this->product_enable_size_guide) {

                    $product_template = wefix_shop_woo_product_single_template_option();

                    if($product_template == 'woo-default') {
                        wp_enqueue_style('swiper', $this->module_dir_url() . 'assets/js/swiper.min.css');
                    }

                }

            }

        /*
        Enqueue JS
        */
            function before_woo_js() {

                if($this->product_enable_size_guide) {

                    $product_template = wefix_shop_woo_product_single_template_option();

                    if($product_template == 'woo-default') {
                        wp_enqueue_script('size-jquery-swiper', $this->module_dir_url() . 'assets/js/swiper.min.js', array('jquery'), false, true);
                    }

                }

            }

        /*
        CSS
        */
            function woo_css( $css ) {

                if($this->product_enable_size_guide) {

                    $product_template = wefix_shop_woo_product_single_template_option();

                    if($product_template == 'woo-default') {

                        $css_file_path = $this->module_dir_path() . 'assets/css/style.css';

                        if( file_exists ( $css_file_path ) ) {

                            $css .=  file_get_contents( $css_file_path );

                        }

                    }

                }

                return $css;

            }

        /*
        JS
        */
            function woo_js( $js ) {

                if($this->product_enable_size_guide) {

                    $product_template = wefix_shop_woo_product_single_template_option();

                    if($product_template == 'woo-default') {

                        $js_file_path = $this->module_dir_path() . 'assets/js/scripts.js';

                        if( file_exists ( $js_file_path ) ) {

                            $js .= file_get_contents( $js_file_path );

                        }

                    }

                }

                return $js;

            }

    }

}

if( !function_exists('wefix_shop_others_size_guide') ) {
	function wefix_shop_others_size_guide() {
        $reflection = new ReflectionClass('WeFix_Shop_Others_Size_Guide');
        return $reflection->newInstanceWithoutConstructor();
	}
}

WeFix_Shop_Others_Size_Guide::instance();