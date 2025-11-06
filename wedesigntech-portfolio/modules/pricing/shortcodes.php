<?php

// Single Page - Price
if(!function_exists('wdt_sp_price')) {
	function wdt_sp_price( $attrs, $content = null ) {

		$attrs = shortcode_atts ( array (
			'listing_id' => '',
			'type'       => 'type1',
			'class'      => '',
		), $attrs, 'wdt_sp_price' );

		$output = '';

		if($attrs['listing_id'] == '' && is_singular('wdt_listings')) {
			global $post;
			$attrs['listing_id'] = $post->ID;
		}

		if($attrs['listing_id'] != '') {

			$wdt_before_price_label = get_post_meta($attrs['listing_id'], 'wdt_before_price_label', true);
			$wdt_after_price_label  = get_post_meta($attrs['listing_id'], 'wdt_after_price_label', true);
			$price_label             = wdt_generate_price_html($attrs['listing_id']);

			if((isset($price_label['regular_price']) && !empty($price_label['regular_price'])) || (isset($price_label['sale_price']) && !empty($price_label['sale_price']))) {

				if($attrs['type'] == 'listing') {
					$attrs['type'] = '';
				}

				$output .= '<div class="wdt-listings-price-container '.esc_attr( $attrs['type'] ).' '.esc_attr( $attrs['class'] ).'">';

					$output .= '<div class="wdt-listings-price-label-holder">';
						if($wdt_before_price_label != '') {
							$output .= '<span class="wdt-price-before-label">'.esc_html( $wdt_before_price_label ).'</span>';
						}
						$output .= '<div class="wdt-listings-price-item">';
							$output .= $price_label['regular_price'];
							$output .= $price_label['sale_price'];
						$output .= '</div>';
						if($wdt_after_price_label != '') {
							$output .= '<span class="wdt-price-after-label">'.esc_html( $wdt_after_price_label ).'</span>';
						}
					$output .= '</div>';

				$output .= '</div>';

			}

		} else {

			$listing_singular_label = apply_filters( 'listing_label', 'singular' );

			$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!','wdt-portfolio'), strtolower($listing_singular_label) );

		}

		return $output;

	}
	add_shortcode ( 'wdt_sp_price', 'wdt_sp_price' );
}

// Single Page - Add to Cart
if(!function_exists('wdt_sp_add_to_cart')) {
	function wdt_sp_add_to_cart( $attrs, $content = null ) {

		$attrs = shortcode_atts ( array (
			'listing_id' => '',
			'class'      => '',
		), $attrs, 'wdt_sp_add_to_cart' );

		$output = '';

		if($attrs['listing_id'] == '' && is_singular('wdt_listings')) {
			global $post;
			$attrs['listing_id'] = $post->ID;
		}

		if($attrs['listing_id'] != '') {

			if ( class_exists( 'WooCommerce' ) ) {

				$wdt_before_price_label = get_post_meta($attrs['listing_id'], 'wdt_before_price_label', true);
				$wdt_after_price_label = get_post_meta($attrs['listing_id'], 'wdt_after_price_label', true);

				$price_label = wdt_generate_price_html($attrs['listing_id']);

				if((isset($price_label['regular_price']) && !empty($price_label['regular_price'])) || (isset($price_label['sale_price']) && !empty($price_label['sale_price']))) {

					$current_user = wp_get_current_user();
					$user_id = $current_user->ID;

					$purchased_listings = get_user_meta($user_id, 'purchased_listings', true);
					$purchased_listings = (is_array($purchased_listings) && !empty($purchased_listings)) ? $purchased_listings : array();

					$output .= '<div class="wdt-listings-addtocart-container '.esc_attr( $attrs['class'] ).'">';

						$product = wdt_get_product_object($attrs['listing_id']);

						if(array_key_exists($attrs['listing_id'], $purchased_listings)) {

							$output .= '<span class="wdt-purchased">
											'.esc_html__('Purchased','wdt-portfolio').
										'</span>';

						} else if(wdt_check_item_is_in_cart($attrs['listing_id'])) {

							$output .= '<div class="wdt-proceed-button">';
								$output .= '<a href="'.esc_url( wc_get_cart_url() ).'" target="_self" class="custom-button-style wdt-cart-link"><span class="fa fa-cart-plus"></span>'.esc_html__('View Cart','wdt-portfolio').'</a>';
							$output .= '</div>';

						} else {

							$output .= '<div class="wdt-proceed-button">';
								$output .= '<a href="'. apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) ) .'" rel="nofollow" data-product_id="'.esc_attr($product->get_id()).'" class="custom-button-style add_to_cart_button ajax_add_to_cart product_type_'.esc_attr($product->get_type()).'"><span class="fa fa-shopping-cart"></span>'.esc_html__('Add to Cart','wdt-portfolio').'</a>';
							$output .= '</div>';

						}

					$output .= '</div>';

				}

			} else {
				$output .= esc_html__('Please make sure "WooCommerce" plugin is installed and activated!','wdt-portfolio');
			}

		} else {

			$listing_singular_label = apply_filters( 'listing_label', 'singular' );

			$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!','wdt-portfolio'), strtolower($listing_singular_label) );

		}

		return $output;

	}
	add_shortcode ( 'wdt_sp_add_to_cart', 'wdt_sp_add_to_cart' );
}

// Search - Price
if(!function_exists('wdt_sf_price_range_field')) {
	function wdt_sf_price_range_field( $attrs, $content = null ) {

		$attrs = shortcode_atts ( array (
			'min_price' => 1,
			'max_price' => 100,
			'ajax_load' => '',
			'class'     => '',
		), $attrs, 'wdt_sf_price_range_field' );

		$output = '';
		$output .= '<div class="wdt-sf-fields-holder wdt-sf-pricerange-field-holder '.esc_attr( $attrs['class'] ).'">';

			$additional_class = '';
			if($attrs['ajax_load'] == 'true') {
				$additional_class = 'wdt-with-ajax-load';
			}

			$currency_symbol = wdt_option('price','currency-symbol');
			$currency_symbol_position = wdt_option('price','currency-symbol-position');

			$wdt_sf_pricerange_start = $attrs['min_price'];
			if(isset($_REQUEST['wdt_sf_pricerange_start']) && $_REQUEST['wdt_sf_pricerange_start'] != '') {
				$wdt_sf_pricerange_start = wdt_sanitize_fields($_REQUEST['wdt_sf_pricerange_start']);
			}

			$wdt_sf_pricerange_end = $attrs['max_price'];
			if(isset($_REQUEST['wdt_sf_pricerange_end']) && $_REQUEST['wdt_sf_pricerange_end'] != '') {
				$wdt_sf_pricerange_end = wdt_sanitize_fields($_REQUEST['wdt_sf_pricerange_end']);
			}

			if($currency_symbol_position == 'left') {

				$wdt_sf_pricerange_start_value = $currency_symbol.$wdt_sf_pricerange_start;
				$wdt_sf_pricerange_end_value = $currency_symbol.$wdt_sf_pricerange_end;

				$wdt_sf_min_price = $currency_symbol.$attrs['min_price'];
				$wdt_sf_max_price = $currency_symbol.$attrs['max_price'];

			} else if($currency_symbol_position == 'right') {

				$wdt_sf_pricerange_start_value = $wdt_sf_pricerange_start.$currency_symbol;
				$wdt_sf_pricerange_end_value = $wdt_sf_pricerange_end.$currency_symbol;

				$wdt_sf_min_price = $attrs['min_price'].$currency_symbol;
				$wdt_sf_max_price = $attrs['max_price'].$currency_symbol;

			} else if($currency_symbol_position == 'left_space') {

				$wdt_sf_pricerange_start_value = $currency_symbol.' '.$wdt_sf_pricerange_start;
				$wdt_sf_pricerange_end_value = $currency_symbol.' '.$wdt_sf_pricerange_end;

				$wdt_sf_min_price = $currency_symbol.' '.$attrs['min_price'];
				$wdt_sf_max_price = $currency_symbol.' '.$attrs['max_price'];

			} else if($currency_symbol_position == 'right_space') {

				$wdt_sf_pricerange_start_value = $wdt_sf_pricerange_start.' '.$currency_symbol;
				$wdt_sf_pricerange_end_value = $wdt_sf_pricerange_end.' '.$currency_symbol;

				$wdt_sf_min_price = $attrs['min_price'].' '.$currency_symbol;
				$wdt_sf_max_price = $attrs['max_price'].' '.$currency_symbol;

			}

			$output .= '<div class="wdt-sf-pricerange-slider '.esc_attr($additional_class).'" data-min="'.esc_attr($attrs['min_price']).'" data-max="'.esc_attr($attrs['max_price']).'" data-updated-min="'.esc_attr($wdt_sf_pricerange_start).'" data-updated-max="'.esc_attr($wdt_sf_pricerange_end).'" data-currencysymbol="'.esc_attr($currency_symbol).'" data-currencysymbolposition="'.esc_attr($currency_symbol_position).'">';
				$output .= '<div class="wdt-sf-pricerange-slider-start-handle">'.$wdt_sf_pricerange_start_value.'</div>';
				$output .= '<div class="wdt-sf-pricerange-slider-end-handle">'.$wdt_sf_pricerange_end_value.'</div>';
				$output .= '<div class="wdt-sf-pricerange-slider-ranges">';
					$output .= '<div class="wdt-sf-pricerange-slider-range-min-holder">';
						$output .= '<label>'.esc_html__('Min','wdt-portfolio').'</label>';
						$output .= '<div class="wdt-sf-pricerange-slider-range-min">'.$wdt_sf_min_price.'</div>';
					$output .= '</div>';
					$output .= '<div class="wdt-sf-pricerange-slider-range-max-holder">';
						$output .= '<label>'.esc_html__('Max','wdt-portfolio').'</label>';
						$output .= '<div class="wdt-sf-pricerange-slider-range-max">'.$wdt_sf_max_price.'</div>';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';

			$output .= '<input name="wdt_sf_pricerange_start" class="wdt-sf-field wdt-sf-pricerange-start" type="hidden" value="'.esc_attr($wdt_sf_pricerange_start).'" />';
			$output .= '<input name="wdt_sf_pricerange_end" class="wdt-sf-field wdt-sf-pricerange-end" type="hidden" value="'.esc_attr($wdt_sf_pricerange_end).'" />';

		$output .= '</div>';

		return $output;

	}
	add_shortcode ( 'wdt_sf_price_range_field', 'wdt_sf_price_range_field' );
}

// Modifying Listing Query Arguments - For Search Price
if(!function_exists('wdt_modify_listings_args_from_pricing_module')) {
	function wdt_modify_listings_args_from_pricing_module($args, $custom_options) {

		$pricerange_start = $custom_options['pricerange_start'];
		$pricerange_end   = $custom_options['pricerange_end'];

		if($pricerange_start != '' && $pricerange_end != '') {
			$args['meta_query'][] = array (
				'key'     => '_sale_price',
				'value'   => array( $pricerange_start, $pricerange_end ),
				'type'    => 'numeric',
				'compare' => 'BETWEEN',
			);
		}

		return $args;
	}
	add_filter( 'wdt_modify_listings_args_from_modules', 'wdt_modify_listings_args_from_pricing_module', 10, 2 );
}?>