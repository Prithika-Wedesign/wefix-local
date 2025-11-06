<?php

/*
* Update Summary Options Filter
*/

if( ! function_exists( 'wefix_shop_woo_single_summary_options_ssf_render' ) ) {
	function wefix_shop_woo_single_summary_options_ssf_render( $options ) {

		$options['share_follow'] = esc_html__('Summary Share / Follow', 'wefix-pro');
		return $options;

	}
	add_filter( 'wefix_shop_woo_single_summary_options', 'wefix_shop_woo_single_summary_options_ssf_render', 10, 1 );

}


/*
* Update Summary - Styles Filter
*/

if( ! function_exists( 'wefix_shop_woo_single_summary_styles_ssf_render' ) ) {
	function wefix_shop_woo_single_summary_styles_ssf_render( $styles ) {

		array_push( $styles, 'wdt-shop-social-share-and-follow' );
		return $styles;

	}
	add_filter( 'wefix_shop_woo_single_summary_styles', 'wefix_shop_woo_single_summary_styles_ssf_render', 10, 1 );

}
