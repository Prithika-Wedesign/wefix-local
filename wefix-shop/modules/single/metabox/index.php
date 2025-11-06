<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Shop_Single_Metabox_Options' ) ) {
    class WeFix_Shop_Single_Metabox_Options {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'wefix_shop_product_custom_settings', array( $this, 'wefix_shop_product_custom_settings' ), 20 );
        }

        function wefix_shop_product_custom_settings( $options ) {

			$product_options = array(

				# Product New Label
					array(
						'id'         => 'product-new-label',
						'type'       => 'switcher',
						'title'      => esc_html__('Add "New" label', 'wefix-shop'),
					),
					array(
						'id'         => 'product-new-label-text',
						'type'       => 'text',
						'title'      => esc_html__('Change Label Text', 'wefix-shop'),
						'default'    => esc_html__('New', 'wefix-shop'),
						'dependency' => array('product-new-label', '==', 'true'),
					),

					 
			);

			$options = array_merge( $options, $product_options );

			return $options;

        }

    }
}

WeFix_Shop_Single_Metabox_Options::instance();