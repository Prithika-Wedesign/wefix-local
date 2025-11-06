<?php

/**
 * Listings - Category
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Pro_Listing_Category' ) ) {

    class WeFix_Pro_Listing_Category {

        private static $_instance = null;

        private $settings;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            /* Load Modules */
                $this->load_modules();

            /* Loop Shop Per Page */
                add_filter( 'loop_shop_per_page', array ( $this, 'woo_loop_shop_per_page' ) );

        }

        /*
        Load Modules
        */
            function load_modules() {

                /* Customizer */
                    include_once WEFIX_PRO_DIR_PATH.'modules/woocommerce/category/customizer/index.php';

            }

        /*
        Loop Shop Per Page
        */
            function woo_loop_shop_per_page( $count ) {

                if( is_product_category() ) {
                    $count = wefix_customizer_settings('wdt-woo-category-page-product-per-page' );
                }

                return $count;

            }

    }

}


if( !function_exists('wefix_listing_category') ) {
	function wefix_listing_category() {
		return WeFix_Pro_Listing_Category::instance();
	}
}

wefix_listing_category();