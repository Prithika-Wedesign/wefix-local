<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Shop_Metabox_Single_Custom_Product_Type' ) ) {
    class WeFix_Shop_Metabox_Single_Custom_Product_Type {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
			add_filter( 'cs_metabox_options', array( $this, 'product_options' ) );
        }

        function product_options( $options ) {

			$settings = wefix_woo_others()->woo_default_settings();
			extract($settings);

			$custom_product_types = explode(',', $custom_product_types);

			if(is_array($custom_product_types) && !empty($custom_product_types)) {

				$options[] = array(
					'id'        => '_custom_product_type',
					'title'     => esc_html__('Custom Product Type','wefix-pro'),
					'post_type' => 'product',
					'context'   => 'side',
					'priority'  => 'low',
					'sections'  => array(
								array(
								'name'   => 'custom_product_type_section',
								'fields' =>  array(

													array(
													'id'         => 'custom-product-type',
													'type'       => 'radio',
													'title'      => esc_html__('Choose Product Type', 'wefix-pro'),
													'options'    => $custom_product_types
												)

											)
								)
								)
				);

			}

			return $options;

		}

    }
}

WeFix_Shop_Metabox_Single_Custom_Product_Type::instance();