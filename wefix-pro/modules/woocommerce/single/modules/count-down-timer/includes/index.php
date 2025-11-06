<?php

/*
 * Product Countdown Timer
 */

if ( ! function_exists( 'wefix_shop_products_sale_countdown_timer' ) ) {

	function wefix_shop_products_sale_countdown_timer() {

		if(is_product()) {

			$product_template = wefix_shop_woo_product_single_template_option();

			if( $product_template == 'woo-default' ) {

				$settings = wefix_woo_single_core()->woo_default_settings();
				extract($settings);

				if(!$product_sale_countdown_timer) {
					return;
				}

			}

		}

		$output = '';

		global $product;
        $sale_date_end = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
		$sale_date_start = get_post_meta( $product->get_id(), '_sale_price_dates_from', true );

		if ( $product->get_type() == 'variable' && $variations = $product->get_available_variations() ) {
			$sale_date_end = get_post_meta( $variations[0]['variation_id'], '_sale_price_dates_to', true );
			$sale_date_start = get_post_meta( $variations[0]['variation_id'], '_sale_price_dates_from', true );
		}

		$curent_date = strtotime( date( 'Y-m-d H:i:s' ) );

		if ( $sale_date_end < $curent_date || $curent_date < $sale_date_start ) {
			return;
		}

		$gmt_offset = get_option('gmt_offset');

		echo '<div class="wdt-product-sale-countdown-holder">';
			echo '<div class="wdt-shop-downcount" data-date="'.esc_attr( date( 'm/d/Y H:i:s', $sale_date_end ) ).'" data-offset="'.esc_attr($gmt_offset).'">';
				echo '<div class="wdt-counter-wrapper">';
					echo '<div class="counter-icon-wrapper">';
						echo '<div class="wdt-counter-number days">00</div>';
					echo '</div>';
					echo '<h3 class="title">'.esc_html__('Day(s)', 'wefix-pro').'</h3>';
				echo '</div>';
				echo '<div class="wdt-counter-wrapper">';
					echo '<div class="counter-icon-wrapper">';
						echo '<div class="wdt-counter-number hours">00</div>';
					echo '</div>';
					echo '<h3 class="title">'.esc_html__('Hr(s)', 'wefix-pro').'</h3>';
				echo '</div>';
				echo '<div class="wdt-counter-wrapper">';
					echo '<div class="counter-icon-wrapper">';
						echo '<div class="wdt-counter-number minutes">00</div>';
					echo '</div>';
					echo '<h3 class="title">'.esc_html__('Min(s)', 'wefix-pro').'</h3>';
				echo '</div>';
				echo '<div class="wdt-counter-wrapper last">';
					echo '<div class="counter-icon-wrapper">';
						echo '<div class="wdt-counter-number seconds">00</div>';
					echo '</div>';
					echo '<h3 class="title">'.esc_html__('Sec(s)', 'wefix-pro').'</h3>';
				echo '</div>';
			echo '</div>';
		echo '</div>';

	}

	add_action( 'woocommerce_single_product_summary', 'wefix_shop_products_sale_countdown_timer', 15 );

}