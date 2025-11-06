<?php

/*
Product Thumb - Content Action
*/

function wefix_shop_woo_loop_product_thumb_content_setup($product_thumb_contents) {

	if(!empty($product_thumb_contents)) {

		$i = 0;
		foreach($product_thumb_contents as $product_thumb_content) {

			add_action('wefix_woo_loop_product_thumb_content', 'wefix_shop_woo_loop_product_content_'.$product_thumb_content, $i, 1);

			$i++;

		}

	}

}


/*
Product Content - Content Action
*/

function wefix_shop_woo_loop_product_content_content_setup($product_content_contents) {

	if(!empty($product_content_contents)) {

		$i = 0;
		foreach($product_content_contents as $product_content_content) {

			add_action('wefix_woo_loop_product_content_content', 'wefix_shop_woo_loop_product_content_'.$product_content_content, $i, 1);

			$i++;

		}

	}

}


/*
Content Actions
*/

// Content Actions - Title

if( ! function_exists( 'wefix_shop_woo_loop_product_content_title' ) ) {

	function wefix_shop_woo_loop_product_content_title() {

		global $product;
		echo '<div class="product-title"><h5><a href="'.esc_url($product->get_permalink()).'">'.wefix_html_output($product->get_name()).'</a></h5></div>';

	}

}

// Content Actions - Excerpt

if( ! function_exists( 'wefix_shop_woo_loop_product_content_excerpt' ) ) {

	function wefix_shop_woo_loop_product_content_excerpt() {

		global $product;
		if($product->get_short_description() != '') {
			echo '<div class="product-short-description">'.wefix_html_output($product->get_short_description()).'</div>';
		}

	}

}

// Content Actions - Rating

if( ! function_exists( 'wefix_shop_woo_loop_product_content_rating' ) ) {

	function wefix_shop_woo_loop_product_content_rating() {

        global $product;

        $product_empty_rating = wc_get_loop_prop( 'product-empty-rating' );

		if(wc_get_rating_html( $product->get_average_rating() ) != '') {
			echo '<div class="product-rating-wrapper">'.wc_get_rating_html( $product->get_average_rating() ).'</div>';
		} else if($product_empty_rating) {
            $rating = 0;
            $label = sprintf( esc_html__( 'Rated %s out of 5', 'wefix' ), $rating );
            echo '<div class="product-rating-wrapper">';
                echo '<div class="star-rating" role="img" aria-label="' . esc_attr( $label ) . '">' . wc_get_star_rating_html( $rating, 0 ) . '</div>';
            echo '</div>';
        }

	}

}

// Content Actions - Category

if( ! function_exists( 'wefix_shop_woo_loop_product_content_category' ) ) {

	function wefix_shop_woo_loop_product_content_category() {

		global $product;
		echo '<div class="product-category-wrapper">'.wc_get_product_category_list( $product->get_id(), ', ' ).'</div>';

	}

}

// Content Actions - Price

if( ! function_exists( 'wefix_shop_woo_loop_product_content_price' ) ) {

	function wefix_shop_woo_loop_product_content_price() {

		global $product;

		ob_start();
		woocommerce_template_loop_price();
		$price = ob_get_clean();

		if(trim($price) != '') {
			echo '<div class="product-price">'.trim($price).'</div>';
		}

	}

}

// Content Actions - Button Element

if( ! function_exists( 'wefix_shop_woo_loop_product_content_button_element' ) ) {

	function wefix_shop_woo_loop_product_content_button_element($location) {

		if($location == 'thumb') {

			$product_buttonelement_button = wc_get_loop_prop( 'product-thumb-buttonelement-button' );
			$product_buttonelement_button = (isset($product_buttonelement_button) && !empty($product_buttonelement_button)) ? $product_buttonelement_button : false;

			$product_buttonelement_secondary_button = wc_get_loop_prop( 'product-thumb-buttonelement-secondary-button' );
			$product_buttonelement_secondary_button = (isset($product_buttonelement_secondary_button) && !empty($product_buttonelement_secondary_button)) ? $product_buttonelement_secondary_button : false;

		} else if($location == 'content') {

			$product_buttonelement_button = wc_get_loop_prop( 'product-content-buttonelement-button' );
			$product_buttonelement_button = (isset($product_buttonelement_button) && !empty($product_buttonelement_button)) ? $product_buttonelement_button : false;

			$product_buttonelement_secondary_button = wc_get_loop_prop( 'product-content-buttonelement-secondary-button' );
			$product_buttonelement_secondary_button = (isset($product_buttonelement_secondary_button) && !empty($product_buttonelement_secondary_button)) ? $product_buttonelement_secondary_button : false;

		}

		if($product_buttonelement_button) {

			if($product_buttonelement_button == 'cart-with-quantity') {
				global $product;
				if ( $product && $product->is_type( 'simple' ) ) {
					do_action( 'wefix_woo_loop_product_button_elements_cart_with_quantity' );
				} else {
					echo '<div class="product-buttons-wrapper product-button">';
						echo '<div class="wc_inline_buttons">';
							do_action( 'wefix_woo_loop_product_button_elements_cart' );
						echo '</div>';
					echo '</div>';
				}
			} else {
				echo '<div class="product-buttons-wrapper product-button">';
					echo '<div class="wc_inline_buttons">';

						if($product_buttonelement_button == 'cart') {
							do_action( 'wefix_woo_loop_product_button_elements_cart' );
						} else if($product_buttonelement_button == 'wishlist') {
							do_action( 'wefix_woo_loop_product_button_elements_wishlist' );
						} else if($product_buttonelement_button == 'compare') {
							do_action( 'wefix_woo_loop_product_button_elements_compare' );
						} else if($product_buttonelement_button == 'quickview') {
							do_action( 'wefix_woo_loop_product_button_elements_quickview' );
						}

						if($product_buttonelement_secondary_button == 'cart') {
							do_action( 'wefix_woo_loop_product_button_elements_cart' );
						} else if($product_buttonelement_secondary_button == 'wishlist') {
							do_action( 'wefix_woo_loop_product_button_elements_wishlist' );
						} else if($product_buttonelement_secondary_button == 'compare') {
							do_action( 'wefix_woo_loop_product_button_elements_compare' );
						} else if($product_buttonelement_secondary_button == 'quickview') {
							do_action( 'wefix_woo_loop_product_button_elements_quickview' );
						}

					echo '</div>';
				echo '</div>';
			}

		}

	}

}

// Content Actions - Countdown Timer

if( ! function_exists( 'wefix_shop_woo_loop_product_content_countdown' ) ) {

	function wefix_shop_woo_loop_product_content_countdown() {

		ob_start();
		wefix_shop_products_sale_countdown_timer();
		$woocommerce_template_countdown = ob_get_clean();
		$countdown = $woocommerce_template_countdown;

		if($countdown != '') {
            if( function_exists('wefix_shop_single_module_count_down_timer') ) {
                wp_enqueue_style( 'wdt-shop-coundown-timer',
                    wefix_shop_single_module_count_down_timer()->module_dir_url() . 'assets/css/style.css',
                    array()
                );
                wp_enqueue_script( 'jquery-downcount',
                    wefix_shop_single_module_count_down_timer()->module_dir_url() . 'assets/js/jquery.downcount.js',
                    array( 'jquery' ),
                    false,
                    true
                );
                wp_enqueue_script( 'wdt-shop-coundown-timer',
                    wefix_shop_single_module_count_down_timer()->module_dir_url() . 'assets/js/scripts.js',
                    array( 'jquery' ),
                    false,
                    true
                );
                wp_localize_script('wdt-shop-coundown-timer', 'wdtShopObjects', array (
                    'enable_countdown_scripts' => true
                ));
                echo '<div class="product-countdown-wrapper">'.wefix_html_output($countdown).'</div>';
            }
		}

	}

}


// Content Actions - Swatches
if( ! function_exists( 'wefix_shop_woo_loop_product_content_swatches' ) ) {

	function wefix_shop_woo_loop_product_content_swatches() {
 

		wp_enqueue_style( 'variation-swatches-css', get_theme_file_uri('/modules/woocommerce/assets/css/variation-swatches.css'), false, WEFIX_THEME_VERSION, 'all');  
		wp_enqueue_script('variation-swatches-js', get_theme_file_uri('/assets/js/variation-swatches.js'), array('jquery'), false, true); 
 
		wp_localize_script('variation-swatches-js', 'ajax_object', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'wpnonce' => wp_create_nonce('wefix_ajax_settings_nonce')
		)); 
 

		global $product;

		$product_id = get_the_ID();


		if ($product->is_type('variable') && class_exists ( 'WeFixPlus' ) && class_exists ( 'WeFixPro' )) { 
			$attributes = $product->get_variation_attributes();
			$available_variations = $product->get_available_variations();
			
			echo '<div class="attribute-swatchesselectbox" data-product-id="'.$product_id.'">';
				echo '<label for="all-attributes">' . __('Choose a Variant', 'wefix') . '</label>';
				echo '<select class="all-attributes-'.$product_id.'" name="all_attributes" >';
					$default_price = $product->get_price();
					$default_regular_price = $product->get_regular_price();
					$symbol = html_entity_decode(get_woocommerce_currency_symbol());

					$formatted_default = number_format((float)$default_price, 2, '.', '');
					$formatted_default_regular = number_format((float)$default_regular_price, 2, '.', '');

					if ($default_price == $default_regular_price || empty($default_regular_price)) {
						$default_dis_price = $symbol . $formatted_default;
					} else {
						$default_dis_price = $symbol . $formatted_default . ' - ' . $symbol . $formatted_default_regular;
					} 
					echo '<option value="" data-price="' . esc_attr($default_dis_price) . '">' . __('Choose an option', 'wefix') . '</option>';
					$options_combined = []; 
					$available_variations = $product->get_available_variations();

					foreach ($available_variations as $variation) {
						$formatted_attributes = [];

						foreach ($variation['attributes'] as $key => $value) {
							$formatted_attributes[] = ucfirst($value);
						}

						$option_label = implode(', ', $formatted_attributes);
						$variation_id = $variation['variation_id']; 

						
						$variation_obj = new WC_Product_Variation($variation_id);
					
						$display_price = $variation_obj->get_price();
						$display_regular_price = $variation_obj->get_regular_price();
					
						$symbol = html_entity_decode(get_woocommerce_currency_symbol());

						$formatted_regular = number_format((float)$display_regular_price, 2, '.', '');
						$formatted_price = number_format((float)$display_price, 2, '.', '');

						if ($display_price == $display_regular_price || empty($display_regular_price)) {
							$dis_price = $symbol . $formatted_price;
						} else {
							$dis_price = $symbol . $formatted_price . ' - ' . $symbol . $formatted_regular;
						}

						$variation_image_id = $variation_obj->get_image_id();  
						$data_img = wp_get_attachment_url( $variation_image_id );  


						if (!in_array($option_label, $options_combined)) {
							$options_combined[] = $option_label;
							echo '<option data-price="' . esc_attr($dis_price) . '" data-variantimage = "'.$data_img.'" value="' . esc_attr($variation_id) . '">' .esc_html($option_label). '</option>';
						}
					}
				echo '</select>';
			echo '</div>'; 

			echo '<div class="variation-swatches">';  

				foreach ($attributes as $attribute_name => $options) {
					echo '<div class="attribute-swatches attribute-swatches-'.$product_id.'">';
				
						foreach ($options as $option) {
							$variation_found = false;
							foreach ($available_variations as $variation) { 
								$variation_id = $variation['variation_id']; 
								if (isset($variation['attributes']['attribute_' . $attribute_name]) && 
									$variation['attributes']['attribute_' . $attribute_name] === $option) {
									$variation_found = true;
									break;  
								}
							}
				
							if ($variation_found) {
								
								$term = get_term_by('slug', sanitize_title($option), $attribute_name);
								$term_id = ($term) ? $term->term_id : ''; 
								$custom_color = $term_id ? get_term_meta($term_id, 'custom_fieldvariant_color', true) : '';
								$custom_image_id = $term_id ? get_term_meta($term_id, 'custom_field_image', true) : '';
								$material_image = $custom_image_id ? wp_get_attachment_url($custom_image_id) : ''; 
								$variation_obj = new WC_Product_Variation($variation_id);
								$attachment_id = $variation_obj->get_image_id();

								if (empty($attachment_id)) {
									$attachment_id = get_post_thumbnail_id($variation_id) ?: get_post_thumbnail_id($product_id);
								} 
								if (!empty($custom_color)) {
									echo '<div class="swatch swatch-'.$product_id.' swatch-color" data-attribute-id="' . esc_attr($variation_id) . '" data-product="'.esc_attr($product_id).'" data-attribute-name="' . esc_attr($attribute_name) . '" data-attribute-value="' . esc_attr($option) . '">
											<div style="background:' . esc_attr($custom_color) . '"></div>
										</div>';
								} elseif (!empty($material_image)) {
									echo '<div class="swatch swatch-'.$product_id.' swatch-material" data-attribute-id="' . esc_attr($variation_id) . '" data-product="'.esc_attr($product_id).'" data-attribute-name="' . esc_attr($attribute_name) . '" data-attribute-value="' . esc_attr($option) . '">
											<div style="background-image:url(' . esc_url($material_image) . ')"></div>
										</div>';
								} else {
									echo '<div class="swatch swatch-button swatch-'.$product_id.'" data-attribute-id="' . esc_attr($variation_id) . '" data-product="'.esc_attr($product_id).'" data-attribute-name="' . esc_attr($attribute_name) . '" data-attribute-value="' . esc_attr($option) . '">';
									echo esc_html($option);
									echo '</div>';
								}
								
							}
						}
				
					echo '</div>';
				}
			
			echo '</div>';  
		}

	}
}

// Content Actions - Icons Group

if( ! function_exists( 'wefix_shop_woo_loop_product_content_icons_group' ) ) {

	function wefix_shop_woo_loop_product_content_icons_group($location) {

		if($location == 'thumb') {

			$product_iconsgroup_icons = wc_get_loop_prop( 'product-thumb-iconsgroup-icons' );
			$product_iconsgroup_icons = (isset($product_iconsgroup_icons) && !empty($product_iconsgroup_icons)) ? $product_iconsgroup_icons : false;

		} else if($location == 'content') {

			$product_iconsgroup_icons = wc_get_loop_prop( 'product-content-iconsgroup-icons' );
			$product_iconsgroup_icons = (isset($product_iconsgroup_icons) && !empty($product_iconsgroup_icons)) ? $product_iconsgroup_icons : false;

		}

		if($product_iconsgroup_icons) {

			echo '<div class="product-buttons-wrapper product-icons">';
				echo '<div class="wc_inline_buttons">';

					if(in_array('cart', $product_iconsgroup_icons)) {
						do_action( 'wefix_woo_loop_product_button_elements_cart' );
					}
					if(in_array('wishlist', $product_iconsgroup_icons)) {
						do_action( 'wefix_woo_loop_product_button_elements_wishlist' );
					}
					if(in_array('compare', $product_iconsgroup_icons)) {
						do_action( 'wefix_woo_loop_product_button_elements_compare' );
					}
					if(in_array('quickview', $product_iconsgroup_icons)) {
						do_action( 'wefix_woo_loop_product_button_elements_quickview' );
					}

				echo '</div>';
			echo '</div>';

		}

	}

}

// Content Actions - Separator

if( ! function_exists( 'wefix_shop_woo_loop_product_content_separator' ) ) {

	function wefix_shop_woo_loop_product_content_separator() {

		echo '<div class="product-separator"></div>';

	}

}

// Content Actions - Element Group

if( ! function_exists( 'wefix_shop_woo_loop_product_content_element_group' ) ) {

	function wefix_shop_woo_loop_product_content_element_group($location) {

		if($location == 'thumb') {

			$product_element_group = wc_get_loop_prop( 'product-thumb-element-group' );
			$product_element_group = (isset($product_element_group['enabled']) && !empty($product_element_group['enabled'])) ? array_keys($product_element_group['enabled']) : false;

		}
		if($location == 'content') {

			$product_element_group = wc_get_loop_prop( 'product-content-element-group' );
			$product_element_group = (isset($product_element_group['enabled']) && !empty($product_element_group['enabled'])) ? array_keys($product_element_group['enabled']) : false;

		}

		if($product_element_group) {

			echo '<div class="product-element-group-wrapper">';

				$title = '';
				if(in_array('title', $product_element_group)) {
					ob_start();
					wefix_shop_woo_loop_product_content_title();
					$title = ob_get_clean();
				}

				$price = '';
				if(in_array('price', $product_element_group)) {
					ob_start();
					wefix_shop_woo_loop_product_content_price();
					$price = ob_get_clean();
				}


				$category = '';
				if(in_array('category', $product_element_group)) {
					ob_start();
					wefix_shop_woo_loop_product_content_category();
					$category = ob_get_clean();
				}

				$button_element = '';
				if(in_array('button_element', $product_element_group)) {
					ob_start();
					wefix_shop_woo_loop_product_content_button_element($location);
					$button_element = ob_get_clean();
				}

				$icons_group = '';
				if(in_array('icons_group', $product_element_group)) {
					ob_start();
					wefix_shop_woo_loop_product_content_icons_group($location);
					$icons_group = ob_get_clean();
				}

				$excerpt = '';
				if(in_array('excerpt', $product_element_group)) {
					ob_start();
					wefix_shop_woo_loop_product_content_excerpt();
					$excerpt = ob_get_clean();
				}

				$rating = '';
				if(in_array('rating', $product_element_group)) {
					ob_start();
					wefix_shop_woo_loop_product_content_rating();
					$rating = ob_get_clean();
				}

				$separator = '';
				if(in_array('separator', $product_element_group)) {
					ob_start();
					wefix_shop_woo_loop_product_content_separator();
					$separator = ob_get_clean();
				}

				$swatches = '';
				if(in_array('swatches', $product_element_group)) {
					ob_start();
					wefix_shop_woo_loop_product_content_swatches();
					$swatches = ob_get_clean();
				}


				$cart = '';
				if(in_array('cart', $product_element_group)) {
					ob_start();
					do_action( 'wefix_woo_loop_product_button_elements_cart' );
					$cart = ob_get_clean();
				}

				$wishlist = '';
				if(in_array('wishlist', $product_element_group)) {
					ob_start();
					do_action( 'wefix_woo_loop_product_button_elements_wishlist' );
					$wishlist = ob_get_clean();
				}

				$compare = '';
				if(in_array('compare', $product_element_group)) {
					ob_start();
					do_action( 'wefix_woo_loop_product_button_elements_compare' );
					$compare = ob_get_clean();
				}

				$quickview = '';
				if(in_array('quickview', $product_element_group)) {
					ob_start();
					do_action( 'wefix_woo_loop_product_button_elements_quickview' );
					$quickview = ob_get_clean();
				}


				foreach ($product_element_group as $key => $value) {
					if($$value == '') {
						unset($product_element_group[$key]);
					}
				}

				$total_elements = count($product_element_group);

				if ($total_elements & 1) {
					$split_count = ($total_elements+1)/2;
				} else {
					$split_count = $total_elements/2;
				}

				echo '<div class="product-element-group-items">';

					$i = 1;
					foreach ($product_element_group as $key => $value) {
						echo wefix_html_output($$value);
						if($split_count == $i && $total_elements > 1) {
							echo '</div>';
							echo '<div class="product-element-group-items">';
						}
						$i++;
					}

				echo '</div>';


			echo '</div>';

		}

	}

}

// Remove YITH Quick View Button from adding dynamically

if( ! function_exists( 'wefix_shop_after_shop_loop_quick_view' ) ) {

	function wefix_shop_after_shop_loop_quick_view($location) {

		if( function_exists( 'YITH_WCQV_Frontend' ) && defined('YITH_WCQV_FREE_INIT') ) {
			remove_action( 'woocommerce_after_shop_loop_item', array( YITH_WCQV_Frontend(), 'yith_add_quick_view_button' ), 15 );
		}

	}

	add_action( 'template_redirect', 'wefix_shop_after_shop_loop_quick_view' );
	add_action( 'admin_init', 'wefix_shop_after_shop_loop_quick_view' );

}

// Content Actions - Label InStock

if( ! function_exists( 'wefix_shop_woo_loop_product_content_label_instock' ) ) {

	function wefix_shop_woo_loop_product_content_label_instock() {

        global $product;
        if($product->is_in_stock()) {
            echo '<div class="product-labels"><span class="instock"><span>'.esc_html__('In Stock', 'wefix').'</span></span></div>';
        }

	}

}

?>