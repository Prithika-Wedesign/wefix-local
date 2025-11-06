<?php

/**
 * WooCommerce - Cart Notification Core Class
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Shop_Others_Cart_Notification' ) ) {

    class WeFix_Shop_Others_Cart_Notification {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            // Load Modules
                $this->load_modules();


            // CSS
                add_filter( 'wefix_after_woo_css', array( $this, 'woo_css'), 10 );

            // JS
                add_filter( 'wefix_after_woo_js', array( $this, 'woo_js'), 10 );

        }


        /*
        Module Paths
        */

            function module_dir_path() {

                if( wefix_is_file_in_theme( __FILE__ ) ) {
                    return WEFIX_MODULE_DIR . '/woocommerce/others/cart-notification/';
                } else {
                    return trailingslashit( plugin_dir_path( __FILE__ ) );
                }

            }

            function module_dir_url() {

                if( wefix_is_file_in_theme( __FILE__ ) ) {
                    return WEFIX_MODULE_URI . '/woocommerce/others/cart-notification/';
                } else {
                    return trailingslashit( plugin_dir_url( __FILE__ ) );
                }

            }

        /**
         * Load Modules
         */
            function load_modules() {

                if( function_exists( 'wefix_pro' ) ) {

                    // Customizer
                        include_once $this->module_dir_path(). 'customizer/index.php';

                    // Elementor
                        include_once $this->module_dir_path(). 'elementor/index.php';

                    // Includes
                        include_once $this->module_dir_path(). 'includes/index.php';

                }

            }

        /*
        CSS
        */
       
       

        function woo_css() {

             

                $css_file_path = $this->module_dir_path() . 'assets/css/style.css';

                $css = '';
                if( file_exists ( $css_file_path ) ) {

                    $css .=  file_get_contents( $css_file_path );

                }
                

                if( !empty($css) ) { 
                        file_put_contents($css_file_path, $css);

                         wp_register_style(
                    'wefix-woo-cart-notification',
                    $this->module_dir_url() . 'assets/css/style.css',
                    array(),
                    WEFIX_PRO_VERSION,
                    'all'
                );

                wp_enqueue_style('wefix-woo-cart-notification');
 
                }
 
                return $css;

            }

 

 

            
        /*
        JS
        */
            function woo_js() {

                wp_enqueue_script('jquery-nicescroll', $this->module_dir_url() . 'assets/js/jquery.nicescroll.js', array('jquery'), false, true);

                wp_register_script( 'wefix-woo-cart-notification', '', array ('jquery'), false, true );
                wp_enqueue_script( 'wefix-woo-cart-notification' );

                $js_file_path = $this->module_dir_path() . 'assets/js/scripts.js';

                $js = '';
                if( file_exists ( $js_file_path ) ) {

                    $js .= file_get_contents( $js_file_path );

                }

                if( !empty($js) ) {
                    wp_add_inline_script( 'wefix-woo-cart-notification', $js );
                }

                return $js;

            }

            

    }

}

if( !function_exists('wefix_shop_others_cart_notification') ) {
	function wefix_shop_others_cart_notification() {
        $reflection = new ReflectionClass('WeFix_Shop_Others_Cart_Notification');
        return $reflection->newInstanceWithoutConstructor();
	}
}

WeFix_Shop_Others_Cart_Notification::instance();