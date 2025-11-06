<?php

/**
 * Listings - Category
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Shop_Listing_Category' ) ) {

    class WeFix_Shop_Listing_Category {

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
                    include_once WEFIX_SHOP_PATH . 'modules/category/customizer/index.php';

            }

    }

}


if( !function_exists('wefix_shop_listing_category') ) {
	function wefix_shop_listing_category() {
		return WeFix_Shop_Listing_Category::instance();
	}
}

wefix_shop_listing_category();