<?php

/**
 * WooCommerce - Size Guide - Include Class
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Shop_Others_Size_Guide_Include' ) ) {

    class WeFix_Shop_Others_Size_Guide_Include {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

			// On Init
				add_action( 'init', array( $this, 'on_init' ), 10 );

			// Regsiter Fields
				add_filter( 'cs_taxonomy_options', array( $this, 'register_fields' ) );

			// Ajax Call
				add_action( 'wp_ajax_wefix_shop_size_guide_popup', array( $this, 'wefix_shop_size_guide_popup' ) );
				add_action( 'wp_ajax_nopriv_wefix_shop_size_guide_popup', array( $this, 'wefix_shop_size_guide_popup' ) );

		}


        /**
         * On Init
         */
			function on_init() {

				// Register Taxonomy

					register_taxonomy(
						'size_guide',
						array ( 'product' ),
						array (
							'hierarchical'       => false,
							'show_ui'            => true,
							'query_var'          => false,
							'rewrite'            => false,
							'public'             => false,
							'capabilities'      => array( 'edit_theme_options' ),
							'label'              => esc_html__( 'Size Guide', 'wefix-pro' ),
							'labels'             => array (
								'name'              => esc_html__( 'Size Guides', 'wefix-pro' ),
								'singular_name'     => esc_html__( 'Size Guide', 'wefix-pro' ),
								'menu_name'         => _x( 'Size Guides', 'Admin menu name', 'wefix-pro' ),
								'search_items'      => esc_html__( 'Search Size Guides', 'wefix-pro' ),
								'all_items'         => esc_html__( 'All Size Guides', 'wefix-pro' ),
								'parent_item'       => esc_html__( 'Parent Size Guide', 'wefix-pro' ),
								'parent_item_colon' => esc_html__( 'Parent Size Guide: ', 'wefix-pro' ),
								'edit_item'         => esc_html__( 'Edit Size Guide', 'wefix-pro' ),
								'update_item'       => esc_html__( 'Update Size Guide', 'wefix-pro' ),
								'add_new_item'      => esc_html__( 'Add new Size Guide', 'wefix-pro' ),
								'new_item_name'     => esc_html__( 'New Size Guide name', 'wefix-pro' ),
								'not_found'         => esc_html__( 'No Size Guides found', 'wefix-pro' ),
							)
						)
					);

				// WooCommerce Default Page - Size Guide Button

					$settings = wefix_woo_single_core()->woo_default_settings();
					extract($settings);

					if($product_enable_size_guide) {
						add_action( 'woocommerce_single_product_summary', array( $this, 'wefix_shop_woo_loop_product_button_elements_sizeguide' ), 35 );
					}

				// WooCommerce Custom Template Page - Size Guide Button

					add_action( 'wefix_woo_loop_product_button_elements_sizeguide', array( $this, 'wefix_shop_woo_loop_product_button_elements_sizeguide' ) );

			}

		/**
         * Regsiter Fields
         */
			function register_fields( $options ) {
				$options[] = array(
					'id'       => 'size_guide_options',
					'taxonomy' => 'size_guide',
					'fields'   => array(
						array(
							'id'      => 'type',
							'type'    => 'image',
							'title'   => esc_html__('Image', 'wefix-pro')
						),

					)
				);

				return $options;
			}

		/**
         * Size Guide Frontend
         */
			function wefix_shop_woo_loop_product_button_elements_sizeguide() {


				global $product;
				$product_id = $product->get_id();

				$terms = wp_get_post_terms($product_id, 'size_guide');
				if( is_array($terms) && !empty($terms) ) {

					echo '<div class="wcsg_btn_wrapper wc_btn_inline" data-tooltip="'.esc_attr__('Size Guide', 'wefix-pro' ).'"><a href="#" class="button wdt-wcsg-button" data-product_id="'.esc_attr($product_id).'" data-sizeguide-nonce="'.wp_create_nonce('sizeguide_nonce').'">'.esc_html__('Size Guide', 'wefix-pro' ).'</a></div>';

				}

			}

			function wefix_shop_size_guide_popup() {

				$sizeguide_nonce = $_POST['sizeguide_nonce'];
				if(isset($sizeguide_nonce) && wp_verify_nonce($sizeguide_nonce, 'sizeguide_nonce')) {

					$product_id = (isset($_REQUEST['product_id']) && $_REQUEST['product_id'] != '') ? $_REQUEST['product_id'] : -1;

					if($product_id > -1) {

						$terms = wp_get_post_terms($product_id, 'size_guide');
						if( is_array($terms) && !empty($terms) ) {

							echo '<div class="wdt-size-guide-popup-holder">';

								echo '<div class="wdt-size-guide-popup-container swiper wdt-products-size-guide">';
									echo '<div class="wdt-size-guide-popup-content swiper-wrapper">';

									foreach( $terms as $term ) {

										$size_guide_options = get_term_meta( $term->term_id, 'size_guide_options', true );
										$image_id = $size_guide_options['type'];

										$image_attributes = wp_get_attachment_image_src( $image_id, 'full' );

										echo '<div class="wdt-size-guide-popup-item swiper-slide">';
											echo '<div class="wdt-size-guide-popup-content-title">'.esc_html($term->name).'</div>';
											echo '<div class="wdt-size-guide-popup-content-details"><img src="'.esc_url($image_attributes[0]).'" width="'.esc_attr($image_attributes[1]).'" height="'.esc_attr($image_attributes[2]).'" alt="'.esc_attr($term->name).'" title="'.esc_attr($term->name).'"/></div>';
										echo '</div>';

									}

									echo '</div>';

									echo '<div class="wdt-products-pagination-holder">';
										echo '<div class="wdt-products-bullet-pagination"></div>';
									echo '</div>';

								echo '</div>';

								echo '<div class="wdt-size-guide-popup-close">'.esc_html__('Close','wefix-pro').'</div>';
							echo '</div>';
						}

					}

				}

				wp_die();

			}

    }

}

if( !function_exists('wefix_shop_others_size_guide_include') ) {
	function wefix_shop_others_size_guide_include() {
        $reflection = new ReflectionClass('WeFix_Shop_Others_Size_Guide_Include');
        return $reflection->newInstanceWithoutConstructor();
	}
}

WeFix_Shop_Others_Size_Guide_Include::instance();