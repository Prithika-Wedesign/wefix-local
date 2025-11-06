<?php

/**
 * Product single template option
 **/

if( ! function_exists( 'wefix_shop_woo_product_single_template_option' ) ) {

	function wefix_shop_woo_product_single_template_option() {

		if(is_singular('product')) {

			if( function_exists( 'wefix_shop_woo_product_single_custom_template_option' ) ) {
				return wefix_shop_woo_product_single_custom_template_option();
			} else {
				return 'woo-default';
			}

		}

		return false;

	}

}