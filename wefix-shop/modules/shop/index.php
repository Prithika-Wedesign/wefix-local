<?php

/**
 * Listings - Shop
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Shop_Listing_Shop' ) ) {

    class WeFix_Shop_Listing_Shop {

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

        }

        /*
        Load Modules
        */
            function load_modules() {

                /* Customizer */
                    include_once WEFIX_SHOP_PATH . 'modules/shop/customizer/index.php';

            }

    }

}


if( !function_exists('wefix_shop_listing_shop') ) {
	function wefix_shop_listing_shop() {
		return WeFix_Shop_Listing_Shop::instance();
	}
}

wefix_shop_listing_shop();