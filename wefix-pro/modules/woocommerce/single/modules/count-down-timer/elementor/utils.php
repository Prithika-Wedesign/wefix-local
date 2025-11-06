<?php

/*
* Update Summary - Options Filter
*/

if( ! function_exists( 'wefix_shop_woo_single_summary_options_cwefix_render' ) ) {
	function wefix_shop_woo_single_summary_options_cwefix_render( $options ) {

		$options['countdown'] = esc_html__('Summary Count Down', 'wefix-pro');
		return $options;

	}
	add_filter( 'wefix_shop_woo_single_summary_options', 'wefix_shop_woo_single_summary_options_cwefix_render', 10, 1 );

}

/*
* Update Summary - Styles Filter
*/

if( ! function_exists( 'wefix_shop_woo_single_summary_styles_cwefix_render' ) ) {
	function wefix_shop_woo_single_summary_styles_cwefix_render( $styles ) {

		array_push( $styles, 'wdt-shop-coundown-timer' );
		return $styles;

	}
	add_filter( 'wefix_shop_woo_single_summary_styles', 'wefix_shop_woo_single_summary_styles_cwefix_render', 10, 1 );

}

/*
* Update Summary - Scripts Filter
*/

if( ! function_exists( 'wefix_shop_woo_single_summary_scripts_cwefix_render' ) ) {
	function wefix_shop_woo_single_summary_scripts_cwefix_render( $scripts ) {

		array_push( $scripts, 'jquery-downcount' );
		array_push( $scripts, 'wdt-shop-coundown-timer' );
		return $scripts;

	}
	add_filter( 'wefix_shop_woo_single_summary_scripts', 'wefix_shop_woo_single_summary_scripts_cwefix_render', 10, 1 );

}