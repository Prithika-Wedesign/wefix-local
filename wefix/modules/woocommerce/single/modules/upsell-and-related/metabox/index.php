<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Shop_Metabox_Single_Upsell_Related' ) ) {
    class WeFix_Shop_Metabox_Single_Upsell_Related {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

			add_filter( 'wefix_shop_product_custom_settings', array( $this, 'wefix_shop_product_custom_settings' ), 10 );

		}

        function wefix_shop_product_custom_settings( $options ) {

			$ct_dependency      = array ();
			$upsell_dependency  = array ( 'show-upsell', '==', 'true');
			$related_dependency = array ( 'show-related', '==', 'true');
			if( function_exists('wefix_shop_single_module_custom_template') ) {
				$ct_dependency['dependency'] 	= array ( 'product-template', '!=', 'custom-template');
				$upsell_dependency 				= array ( 'product-template|show-upsell', '!=|==', 'custom-template|true');
				$related_dependency 			= array ( 'product-template|show-related', '!=|==', 'custom-template|true');
			}

			$product_options = array (

				array_merge (
					array(
						'id'         => 'show-upsell',
						'type'       => 'select',
						'title'      => esc_html__('Show Upsell Products', 'wefix'),
						'class'      => 'chosen',
						'default'    => 'admin-option',
						'attributes' => array( 'data-depend-id' => 'show-upsell' ),
						'options'    => array(
							'admin-option' => esc_html__( 'Admin Option', 'wefix' ),
							'true'         => esc_html__( 'Show', 'wefix'),
							null           => esc_html__( 'Hide', 'wefix'),
						)
					),
					$ct_dependency
				),

				array(
					'id'         => 'upsell-column',
					'type'       => 'select',
					'title'      => esc_html__('Choose Upsell Column', 'wefix'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'wefix' ),
						1              => esc_html__( 'One Column', 'wefix' ),
						2              => esc_html__( 'Two Columns', 'wefix' ),
						3              => esc_html__( 'Three Columns', 'wefix' ),
						4              => esc_html__( 'Four Columns', 'wefix' ),
					),
					'dependency' => $upsell_dependency
				),

				array(
					'id'         => 'upsell-limit',
					'type'       => 'select',
					'title'      => esc_html__('Choose Upsell Limit', 'wefix'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'wefix' ),
						1              => esc_html__( 'One', 'wefix' ),
						2              => esc_html__( 'Two', 'wefix' ),
						3              => esc_html__( 'Three', 'wefix' ),
						4              => esc_html__( 'Four', 'wefix' ),
						5              => esc_html__( 'Five', 'wefix' ),
						6              => esc_html__( 'Six', 'wefix' ),
						7              => esc_html__( 'Seven', 'wefix' ),
						8              => esc_html__( 'Eight', 'wefix' ),
						9              => esc_html__( 'Nine', 'wefix' ),
						10              => esc_html__( 'Ten', 'wefix' ),
					),
					'dependency' => $upsell_dependency
				),

				array_merge (
					array(
						'id'         => 'show-related',
						'type'       => 'select',
						'title'      => esc_html__('Show Related Products', 'wefix'),
						'class'      => 'chosen',
						'default'    => 'admin-option',
						'attributes' => array( 'data-depend-id' => 'show-related' ),
						'options'    => array(
							'admin-option' => esc_html__( 'Admin Option', 'wefix' ),
							'true'         => esc_html__( 'Show', 'wefix'),
							null           => esc_html__( 'Hide', 'wefix'),
						)
					),
					$ct_dependency
				),

				array(
					'id'         => 'related-column',
					'type'       => 'select',
					'title'      => esc_html__('Choose Related Column', 'wefix'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'wefix' ),
						2              => esc_html__( 'Two Columns', 'wefix' ),
						3              => esc_html__( 'Three Columns', 'wefix' ),
						4              => esc_html__( 'Four Columns', 'wefix' ),
					),
					'dependency' => $related_dependency
				),

				array(
					'id'         => 'related-limit',
					'type'       => 'select',
					'title'      => esc_html__('Choose Related Limit', 'wefix'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'wefix' ),
						1              => esc_html__( 'One', 'wefix' ),
						2              => esc_html__( 'Two', 'wefix' ),
						3              => esc_html__( 'Three', 'wefix' ),
						4              => esc_html__( 'Four', 'wefix' ),
						5              => esc_html__( 'Five', 'wefix' ),
						6              => esc_html__( 'Six', 'wefix' ),
						7              => esc_html__( 'Seven', 'wefix' ),
						8              => esc_html__( 'Eight', 'wefix' ),
						9              => esc_html__( 'Nine', 'wefix' ),
						10              => esc_html__( 'Ten', 'wefix' ),
					),
					'dependency' => $related_dependency
				)

			);

			$options = array_merge( $options, $product_options );

			return $options;

		}

    }
}

WeFix_Shop_Metabox_Single_Upsell_Related::instance();