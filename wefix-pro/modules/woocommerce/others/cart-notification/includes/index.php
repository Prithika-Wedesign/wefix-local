<?php

if( ! function_exists( 'wefix_shop_woo_cart_fragments' ) ) {

	function wefix_shop_woo_cart_fragments( $fragments  ) {

        $settings = wefix_woo_others()->woo_default_settings();
        extract($settings);


		$cart_action = false;
		if ( function_exists('get_site_transient') ) {
			$cart_action = get_site_transient( 'cart_action' );
		}
		if ( $cart_action ) {
			$addtocart_custom_action = $cart_action;
		}

		if($addtocart_custom_action == 'sidebar_widget') {

			// Total items in cart
			ob_start();
			echo count(WC()->cart->get_cart());
			$count = ob_get_clean();

			// Get mini cart
			ob_start();
			woocommerce_mini_cart();
			$mini_cart = ob_get_clean();


			$fragments ['.wdt-shop-cart-widget-header'] = '<div class="wdt-shop-cart-widget-header">
																<h3>'.esc_html__( 'Shopping cart', 'wefix-pro' ).'
																	<span>'.esc_html($count).'</span>
																	<a href="#" class="wdt-shop-cart-widget-close-button">'.esc_html__( 'Close', 'wefix-pro' ).'</a>
																</h3>
															</div>';
			$fragments ['.wdt-shop-cart-widget-content'] = '<div class="wdt-shop-cart-widget-content">'.wefix_html_output($mini_cart).'</div>';


		}


		if($addtocart_custom_action == 'notification_widget') {

			global $woocommerce;

			$items = $woocommerce->cart->get_cart();

			$ids = array();
			foreach($items as $item => $values) {
		        $_product = $values['data']->post;
		        $ids[] = $_product->ID;
			}

			if( is_array($ids) && !empty($ids) ) {

				$last_product_id = end($ids);

				$product = wc_get_product( $last_product_id );

				$fragments ['.wdt-shop-cart-widget-header'] = '<div class="wdt-shop-cart-widget-header">
																	<a href="#" class="wdt-shop-cart-widget-close-button">'.esc_html__( 'Close', 'wefix-pro' ).'</a>
																</div>';
				$fragments ['.wdt-shop-cart-widget-content'] = '<div class="wdt-shop-cart-widget-content">
																	<div class="wdt-shop-cart-widget-content-thumb">
																		<a class="image" href="'.esc_url($product->get_permalink()).'" title="'.esc_attr($product->get_name()).'">'.wefix_html_output($product->get_image()).'</a>
																	</div>
																	<div class="wdt-shop-cart-widget-content-info">
																		'.sprintf( esc_html__( 'Product %1$s has been added to cart sucessfully.', 'wefix-pro' ), '<a class="image" href="'.esc_url($product->get_permalink()).'" title="'.esc_attr($product->get_name()).'">'.wefix_html_output($product->get_name()).'</a>').'
																	</div>
																</div>';

			}

		}


		// Shortcode

		// Total items in cart
		$count_html = '';
		$count = count(WC()->cart->get_cart());
		if($count > 0) {
			$count_html = $count;
		}

		// Total items in cart
		$subtotal = WC()->cart->get_cart_subtotal();

		// Get mini cart
		ob_start();
		woocommerce_mini_cart();
		$mini_cart = ob_get_clean();


		$fragments ['.wdt-shop-menu-cart-number'] = '<span class="wdt-shop-menu-cart-number">'.wefix_html_output($count_html).'</span>';
		$fragments ['.wdt-shop-menu-cart-subtotal'] = '<span class="wdt-shop-menu-cart-subtotal">'.wefix_html_output($subtotal).'</span>';
		$fragments ['.wdt-shop-menu-cart-totals'] = '<span class="wdt-shop-menu-cart-totals">'.wefix_html_output($subtotal).'</span>';
		$fragments ['.wdt-shop-menu-cart-content'] = '<div class="wdt-shop-menu-cart-content">'.wefix_html_output($mini_cart).'</div>';



		return $fragments;

	}

	add_filter('woocommerce_add_to_cart_fragments', 'wefix_shop_woo_cart_fragments');

}


if ( ! function_exists( 'wefix_shop_woo_sidebar_widget' ) ) {

	function wefix_shop_woo_sidebar_widget() {

        $settings = wefix_woo_others()->woo_default_settings();
        extract($settings);


		$notification_class = '';
		if($addtocart_custom_action == 'notification_widget') {

			$notification_class = 'cart-notification-widget';

		} else if($addtocart_custom_action == 'sidebar_widget') {

			$notification_class = 'activate-sidebar-widget';

		} else {

			if ( $cart_action = get_site_transient( 'cart_action' ) ) {

				if($cart_action == 'sidebar_widget') {
					$notification_class = 'activate-sidebar-widget';
				}

			}

		}

		if($notification_class != '') {

			echo '<div class="wdt-shop-cart-widget '.esc_attr($notification_class).'">';
				echo '<div class="wdt-shop-cart-widget-inner">';
					echo '<div class="wdt-shop-cart-widget-header">';
						echo '<h3>'.esc_html__( 'Your Shopping cart', 'wefix-pro' ).'<span></span></h3>';
						echo '<a href="#" class="wdt-shop-cart-widget-close-button">'.esc_html__( 'Close', 'wefix-pro' ).'</a>';
					echo '</div>';
					echo '<div class="wdt-shop-cart-widget-content-wrapper">';
						echo '<div class="wdt-shop-cart-widget-content"></div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
			echo '<div class="wdt-shop-cart-widget-overlay"></div>';

		}

	}

	add_action( 'wp_footer', 'wefix_shop_woo_sidebar_widget', 10 );

}