<?php

/**
 * WooCommerce - Single Core Class
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Shop_Single' ) ) {

    class WeFix_Shop_Single {

        private static $_instance = null;

        private $settings;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            // Load WooCommerce Comments Template
                add_filter( 'comments_template',  array( $this, 'wefix_shop_comments_template' ), 20, 1 );

            // Load Modules
                $this->load_modules();

        }

        /**
         * Override WooCommerce comments template file
         */
            function wefix_shop_comments_template( $template ) {

                if ( get_post_type() !== 'product' ) {
                    return $template;
                }

                $plugin_path  = WEFIX_SHOP_PATH . 'templates/';

                if ( file_exists( $plugin_path . 'single-product-reviews.php' ) ) {
                    return $plugin_path . 'single-product-reviews.php';
                }

                return $template;

            }

        /*
        Load Modules
        */

            function load_modules() {

                // Customizer Widgets
                    include_once WEFIX_SHOP_PATH . 'modules/single/customizer/index.php';

                // Metabox Widgets
                    include_once WEFIX_SHOP_PATH . 'modules/single/metabox/index.php';

            }

    }

}

if( !function_exists('wefix_shop_single') ) {
	function wefix_shop_single() {
		return WeFix_Shop_Single::instance();
	}
}

wefix_shop_single();