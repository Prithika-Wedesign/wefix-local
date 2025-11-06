<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Shop_Metabox_Suggested_Products' ) ) {
    class WeFix_Shop_Metabox_Suggested_Products {

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

			if(isset($enable_suggested_products) && !empty($enable_suggested_products)) {

				$options[] = array(
					'id'        => '_suggested_products_type',
					'title'     => esc_html__('Suggested Product','wefix-pro'),
					'post_type' => 'product',
					'context'   => 'side',
					'priority'  => 'low',
					'sections'  => array(
								array(
								'name'   => 'suggested_products_type_section',
								'fields' =>  array(
												array(
													'id'         => 'suggested-products-location',
													'type'       => 'text',
													'title'      => esc_html__('Suggested Location ', 'wefix-pro'),
													'desc'       => esc_html__('Enter the location', 'wefix-pro')
												),
												array(
													'id'         => 'suggested-products-time',
													'type'       => 'text',
													'title'      => esc_html__('Suggested Time ', 'wefix-pro'),
													'desc'       => esc_html__('Enter the time in minutes', 'wefix-pro')
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

WeFix_Shop_Metabox_Suggested_Products::instance();