<?php

/**
 * content-product.php hooks
 *
 * woocommerce_before_shop_loop_item_title
 */


/** Hook: woocommerce_before_shop_loop_item_title. **/

remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

if (! function_exists('wefix_shop_woo_loop_product_thumbnail')) {

	function wefix_shop_woo_loop_product_thumbnail()
	{

		global $product;

		$product_id = $product->get_id();

		// Loop defined variables

		$show_secondary_image_on_hover = wc_get_loop_prop('product-thumb-secondary-image-onhover');
		$show_secondary_image_on_hover = (isset($show_secondary_image_on_hover) && !empty($show_secondary_image_on_hover)) ? true : false;


		$product_thumb_content = wc_get_loop_prop('product-thumb-content');
		$product_thumb_content = (isset($product_thumb_content['enabled']) && !empty($product_thumb_content['enabled'])) ? array_keys($product_thumb_content['enabled']) : false;

		$product_overlay_bgcolor = wc_get_loop_prop('product-overlay-bgcolor');
		$product_overlay_bgcolor = (isset($product_overlay_bgcolor) && !empty($product_overlay_bgcolor)) ? 'style="background-color:' . esc_attr($product_overlay_bgcolor) . ';"' : '';

		$product_hover_style = wc_get_loop_prop('product-hover-style');

		$product_thumb_content_overlay_bgcolor = '';
		if ($product_hover_style == 'product-hover-egrpovrcnt') {
			$product_thumb_content_overlay_bgcolor = $product_overlay_bgcolor;
		}

		$product_show_labels = wc_get_loop_prop('product-show-label');
		$product_show_labels = (isset($product_show_labels) && $product_show_labels == 'true') ? true : false;

		$product_show_offer_percentage = wc_get_loop_prop('product-show-offer-percentage');
		$product_show_offer_percentage = (isset($product_show_offer_percentage) && $product_show_offer_percentage == 'thumb') ? true : false;

		echo '<div class="product-thumb">';

		// Featrued Item
		if ($product_show_labels) {

			if ($product->is_featured()) {
				echo '<div class="featured-tag">
							<div>
								<i class="wdticon-thumb-tack"></i>
								<span>' . esc_html__('Featured', 'wefix') . '</span>
							</div>
						</div>';
			}
		}

		if (function_exists('wefix_customizer_settings')) {
			$page_enablelistingswiper =  wefix_customizer_settings('wdt-woo-shop-page-enable-listingswiper');
			$page_listingswiperscrollbar =  wefix_customizer_settings('wdt-woo-shop-page-enable-listingswiperscrollbar');
		}

		if (isset($page_enablelistingswiper)  && !empty($page_enablelistingswiper) && ($page_enablelistingswiper == 1)) {
			echo '<div class="image">';

			if ($product_show_labels) {
				echo '<div class="product-labels">';
				if ($product->is_on_sale() && $product->is_in_stock()) echo '<span class="onsale"><span>' . esc_html__('Sale', 'wefix') . '</span></span>';
				elseif (!$product->is_in_stock()) echo '<span class="out-of-stock"><span>' . esc_html__('Sold Out', 'wefix') . '</span></span>';
				$settings = get_post_meta($product_id, '_custom_settings', true);

				if (isset($settings['product-new-label']) && $settings['product-new-label'] == 'true') {
					$productnew_text = $settings['product-new-label-text'];
					echo '<span class="new"><span>' . esc_html($productnew_text) . '</span></span>';
				}
				echo '</div>';
			}

			if ($product_show_offer_percentage) echo wefix_shop_woo_loop_product_offer_percentage($product);

			do_action('wefix_woo_before_product_thumb_image', $product_id);

			$thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'woocommerce_thumbnail', false)[0] ?? wc_placeholder_img_src('woocommerce_thumbnail');
			echo '<div class="swiper primary-image-wrapper wdt-product-image-gallery" data-carouselslidesperview="1"><div class="swiper-wrapper" id="swiper-wrapper-' . get_the_ID() . '">';

			echo '<div class="swiper-slide one"><div class="primary-image"><a class="swiper_image" href="' . esc_url($product->get_permalink()) . '" title="' . esc_attr($product->get_name()) . '"><img src="' . esc_url($thumbnail_url) . '" alt="' . esc_attr__('Shop Primary Image', 'wefix') . '" /></div></a></div>';

			foreach ($product->get_gallery_image_ids() as $img_id) {
				$img_src = wp_get_attachment_image_src($img_id, 'woocommerce_thumbnail', false)[0] ?? '';

				if ($img_src) echo '<div class="swiper-slide"><a class="swiper_image" href="' . esc_url($product->get_permalink()) . '" title="' . esc_attr($product->get_name()) . '"><div class="primary-image"><img src="' . esc_url($img_src) . '" alt="' . esc_attr__('Gallery Image', 'wefix') . '" /></div></a></div>';
			}

			echo '</div><div class="wdt_swiper_pagination"><div class="wdt-product-arrow-prev"><i class="wdticon-angle-double-left"></i></div><div class="wdt-product-arrow-next"><i class="wdticon-angle-double-right"></i></div></div>';
			if (isset($page_listingswiperscrollbar)  && !empty($page_listingswiperscrollbar) && ($page_listingswiperscrollbar == 1)) {
				echo '<div class="swiper-scrollbar"></div>';
			}
			if ($product_hover_style !== 'product-hover-egrpovrcnt') echo '<div class="product-thumb-overlay" ' . wefix_html_output($product_overlay_bgcolor) . '></div>';
			echo '</div></div>';
		} else {
			echo '<a class="image" href="' . esc_url($product->get_permalink()) . '" title="' . esc_attr($product->get_name()) . '">';

			if ($product_hover_style !== 'product-hover-egrpovrcnt') echo '<div class="product-thumb-overlay" ' . wefix_html_output($product_overlay_bgcolor) . '></div>';

			if ($product_show_labels) {
				echo '<div class="product-labels">';
				if ($product->is_on_sale() && $product->is_in_stock()) echo '<span class="onsale"><span>' . esc_html__('Sale', 'wefix') . '</span></span>';
				elseif (!$product->is_in_stock()) echo '<span class="out-of-stock"><span>' . esc_html__('Sold Out', 'wefix') . '</span></span>';

				$settings = get_post_meta($product_id, '_custom_settings', true);

				if (isset($settings['product-new-label']) && $settings['product-new-label'] == 'true') {
					$productnew_text = $settings['product-new-label-text'];
					echo '<span class="new"><span>' . esc_html($productnew_text) . '</span></span>';
				}
				echo '</div>';
			}
			if ($product_show_offer_percentage) echo wefix_shop_woo_loop_product_offer_percentage($product);

			do_action('wefix_woo_before_product_thumb_image', $product_id);

			$primary_image_src = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'woocommerce_thumbnail', false)[0] ?? wc_placeholder_img_src('woocommerce_thumbnail');
			$secondary_image_src = $show_secondary_image_on_hover ? (wp_get_attachment_image_src($product->get_gallery_image_ids()[0] ?? '', 'woocommerce_thumbnail', false)[0] ?? '') : '';
			echo '<div class="primary-image"><img src="' . esc_url($primary_image_src) . '" alt="' . esc_attr__('Shop Primary Image', 'wefix') . '" /></div>';
			if ($secondary_image_src) echo '<div class="secondary-image"><img src="' . esc_url($secondary_image_src) . '" alt="' . esc_attr__('Shop Secondary Image', 'wefix') . '" /></div>';
			echo '</a>';
		}
		// Content

		if ($product_thumb_content) {

			wefix_shop_woo_loop_product_thumb_content_setup($product_thumb_content);

			echo '<div class="product-thumb-content" ' . wefix_html_output($product_thumb_content_overlay_bgcolor) . '>';
			do_action('wefix_woo_loop_product_thumb_content', 'thumb');
			remove_all_actions('wefix_woo_loop_product_thumb_content');
			echo '</div>';
		}

		echo "</div>";
	}

	add_action('woocommerce_before_shop_loop_item_title', 'wefix_shop_woo_loop_product_thumbnail', 10);
}