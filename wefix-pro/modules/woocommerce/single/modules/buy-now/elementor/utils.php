<?php

/*
* Update Summary - Options Filter
*/

if( ! function_exists( 'wefix_shop_woo_single_summary_options_bn_render' ) ) {
	function wefix_shop_woo_single_summary_options_bn_render( $options ) {

		$options['buy_now'] = esc_html__('Summary Buy Now', 'wefix-pro');
		return $options;

	}
	add_filter( 'wefix_shop_woo_single_summary_options', 'wefix_shop_woo_single_summary_options_bn_render', 10, 1 );

}

/*
* Update Summary - Styles Filter
*/

if( ! function_exists( 'wefix_shop_woo_single_summary_styles_bn_render' ) ) {
	function wefix_shop_woo_single_summary_styles_bn_render( $styles ) {

		array_push( $styles, 'wdt-shop-buy-now' );
		return $styles;

	}
	add_filter( 'wefix_shop_woo_single_summary_styles', 'wefix_shop_woo_single_summary_styles_bn_render', 10, 1 );

}

/*
* Update Summary - Scripts Filter
*/

if( ! function_exists( 'wefix_shop_woo_single_summary_scripts_bn_render' ) ) {
	function wefix_shop_woo_single_summary_scripts_bn_render( $scripts ) {

		array_push( $scripts, 'wdt-shop-buy-now' );
		return $scripts;

	}
	add_filter( 'wefix_shop_woo_single_summary_scripts', 'wefix_shop_woo_single_summary_scripts_bn_render', 10, 1 );

}