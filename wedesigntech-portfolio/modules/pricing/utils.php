<?php

// Price HTML Generator
if ( ! function_exists( 'wdt_generate_price_html' ) ) {
	function wdt_generate_price_html( $listing_id ) {

		$wdt_currency_symbol          = get_post_meta( $listing_id, 'wdt_currency_symbol', true );
		$wdt_currency_symbol_position = get_post_meta( $listing_id, 'wdt_currency_symbol_position', true );

		$currency_symbol          = wdt_option( 'price', 'currency-symbol' );
		$currency_symbol_position = wdt_option( 'price', 'currency-symbol-position' );

		if ( $wdt_currency_symbol == '' ) {
			$wdt_currency_symbol = $currency_symbol;
		}

		if ( $wdt_currency_symbol_position == '' ) {
			$wdt_currency_symbol_position = $currency_symbol_position;
		}

		$_regular_price = get_post_meta( $listing_id, '_regular_price', true );
		$_sale_price    = get_post_meta( $listing_id, '_sale_price', true );

		// Wrap currency symbol inside span (sanitize symbol text only)
		if ( $wdt_currency_symbol != '' ) {
			$wdt_currency_symbol = '<span class="wdt-price-currency-symbol">' . esc_html( $wdt_currency_symbol ) . '</span>';
		}

		$_regular_price_label = $_sale_price_label = '';

		// Right with space (e.g. 20 Rs)
		if ( $wdt_currency_symbol_position == 'right_space' ) {
			if ( $_regular_price != '' ) {
				$_regular_price_label = '<del><span class="wdt-price-amount">' . esc_html( $_regular_price ) . ' ' . $wdt_currency_symbol . '</span></del>';
			}
			if ( $_sale_price != '' ) {
				$_sale_price_label = '<ins><span class="wdt-price-amount">' . esc_html( $_sale_price ) . ' ' . $wdt_currency_symbol . '</span></ins>';
			}

		// Left with space (e.g. Rs 20)
		} elseif ( $wdt_currency_symbol_position == 'left_space' ) {
			if ( $_regular_price != '' ) {
				$_regular_price_label = '<del><span class="wdt-price-amount">' . $wdt_currency_symbol . ' ' . esc_html( $_regular_price ) . '</span></del>';
			}
			if ( $_sale_price != '' ) {
				$_sale_price_label = '<ins><span class="wdt-price-amount">' . $wdt_currency_symbol . ' ' . esc_html( $_sale_price ) . '</span></ins>';
			}

		// Right without space (e.g. 20Rs)
		} elseif ( $wdt_currency_symbol_position == 'right' ) {
			if ( $_regular_price != '' ) {
				$_regular_price_label = '<del><span class="wdt-price-amount">' . esc_html( $_regular_price ) . $wdt_currency_symbol . '</span></del>';
			}
			if ( $_sale_price != '' ) {
				$_sale_price_label = '<ins><span class="wdt-price-amount">' . esc_html( $_sale_price ) . $wdt_currency_symbol . '</span></ins>';
			}

		// Default: left without space (e.g. Rs20)
		} else {
			if ( $_regular_price != '' ) {
				$_regular_price_label = '<del><span class="wdt-price-amount">' . $wdt_currency_symbol . esc_html( $_regular_price ) . '</span></del>';
			}
			if ( $_sale_price != '' ) {
				$_sale_price_label = '<ins><span class="wdt-price-amount">' . $wdt_currency_symbol . esc_html( $_sale_price ) . '</span></ins>';
			}
		}

		$output = array(
			'regular_price' => $_regular_price_label,
			'sale_price'    => $_sale_price_label,
		);

		return $output;
	}
}

?>