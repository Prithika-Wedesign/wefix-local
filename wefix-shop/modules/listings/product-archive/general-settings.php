<?php

/**
 * Listing Framework Archive Settings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Woo_Listing_Fw_Archive_General_Settings' ) ) {

    class WeFix_Woo_Listing_Fw_Archive_General_Settings {

        private static $_instance = null;

        private $shop_custom_options = array ();

        function __construct($shop_custom_options) {

            $this->shop_custom_options = $shop_custom_options;

            /* Update Archive Default Options */
                add_filter( 'wefix_woo_shop_page_default_settings', array( $this, 'shop_page_default_settings' ), 20, 1 );

            /* Post per page update */
                add_filter( 'loop_shop_per_page', array ( $this, 'woo_loop_shop_per_page' ), 10 );

            /* Breadcrumb disable */
                add_action( 'wefix_hook_content_before', array( $this, 'woo_handle_product_breadcrumb' ), 10);

        }

        /*
        Update Archive Options
        */
            function shop_page_default_settings( $settings ) {

                $settings['product_style_template'] = 'custom';
                $settings['product_style_custom_template'] = $this->shop_custom_options['product-template'];
                $settings['product_per_page'] = $this->shop_custom_options['product-per-page'];
                $settings['product_layout'] = $this->shop_custom_options['product-layout'];
                $settings['show_sorter_on_header'] = isset($this->shop_custom_options['show-sorter-on-header']) ? true : false;
                $settings['sorter_header_elements'] = array_keys($this->shop_custom_options['sorter-header-elements']['enabled']);
                $settings['show_sorter_on_footer'] = isset($this->shop_custom_options['show-sorter-on-footer']) ? true : false;
                $settings['sorter_footer_elements'] = array_keys($this->shop_custom_options['sorter-footer-elements']['enabled']);

                $this->product_per_page = $this->shop_custom_options['product-per-page'];

                return $settings;

            }

        /*
        Loop Shop Per Page
        */
            function woo_loop_shop_per_page( $count ) {

                if( $this->shop_custom_options['product-per-page'] ) {
                    $count = $this->shop_custom_options['product-per-page'];
                }

                return $count;

            }

        /*
        Breadcrumb disable
        */
            function woo_handle_product_breadcrumb() {

                if(is_shop() && isset($this->shop_custom_options['disable-breadcrumb']) && $this->shop_custom_options['disable-breadcrumb']) {
                    remove_action('wefix_breadcrumb', 'wefix_breadcrumb_template');
                }

            }


    }

}