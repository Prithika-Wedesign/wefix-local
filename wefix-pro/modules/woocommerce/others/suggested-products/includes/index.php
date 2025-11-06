<?php

/**
 * WooCommerce - Suggested Products Products - Include Class
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Shop_Others_Suggested_Products_Include' ) ) {

    class WeFix_Shop_Others_Suggested_Products_Include {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {
			add_action( 'wefix_hook_bottom', array( $this, 'wefix_shop_suggested_products_content' ) );
		}

		/**
         * Suggested Products Content
         */
			function wefix_shop_suggested_products_content() {

				$settings = wefix_woo_others()->woo_default_settings();
				
				extract($settings);

				if($enable_suggested_products) {

					$form_args = array(
						'post_type'      => 'product',
						'meta_key'       => '_suggested_products_type',

					);
					$form_query = new WP_Query( $form_args );
				
					if ( $form_query->have_posts() ) {
						echo '<ul class="suggested-product-list">';
							while ( $form_query->have_posts() ) {
								$form_query->the_post();
								$product_permalink = get_the_permalink();
								$product_id = get_the_ID();
								$product_title = get_the_title();
								$suggested = get_post_meta( $product_id, '_suggested_products_type', true );
								$suggested_products_location = $suggested['suggested-products-location'];
								$suggested_products_time     = $suggested['suggested-products-time'];
								
								echo '<li class="suggested-product-data">';
									echo '<div class="suggested-product-image">';
										$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ));
										echo '<a href="'.esc_url($product_permalink).'"><img src="'.esc_url($image[0]).'" alt="'.esc_html__('Suggest Product Thumbnail', 'wefix-pro').'" title="'.esc_html__('Suggest Product Thumbnail', 'wefix-pro').'"></a>';
									echo '</div>';

									echo '<div class="suggested-product-content">';
										echo '<span>'.esc_html__('Someone purchased a ', 'wefix-pro').'</span>';
										echo '<a href="'.esc_url($product_permalink).'">'. esc_html( $product_title ). '</a>';
										echo '<p class="suggested-product-time">'. esc_html( $suggested_products_time ). esc_html__(' Minutes ago from ', 'wefix-pro') .esc_html( $suggested_products_location ).'</p>';
									echo '</div>';

									echo '<a href="javascript:void(0)" onclick="event.preventDefault()" title="Close" class="wdt_close"><i class="fa fa-window-close" aria-hidden="true"></i></a>';
								echo '</li>';
								
							}
						echo '</ul>';
						wp_reset_postdata();
					}

				}


			}


    }

}

if( !function_exists('wefix_shop_others_suggested_products_include') ) {
	function wefix_shop_others_suggested_products_include() {
        $reflection = new ReflectionClass('WeFix_Shop_Others_Suggested_Products_Include');
        return $reflection->newInstanceWithoutConstructor();
	}
}

WeFix_Shop_Others_Suggested_Products_Include::instance();