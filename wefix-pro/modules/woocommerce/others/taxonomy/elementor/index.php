<?php

/**
 * WooCommerce - Elementor Taxonomy Widgets Core Class
 */

namespace WeFixElementor\widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeFix_Shop_Elementor_Taxonomy_Widgets {

	/**
	 * A Reference to an instance of this class
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Constructor
	 */
	function __construct() {

		add_action( 'wefix_shop_register_widgets', array( $this, 'wefix_shop_register_widgets' ), 10, 1 );

		add_action( 'wefix_shop_register_widget_styles', array( $this, 'wefix_shop_register_widget_styles' ), 10, 1 );
		add_action( 'wefix_shop_register_widget_scripts', array( $this, 'wefix_shop_register_widget_scripts' ), 10, 1 );

		add_action( 'wefix_shop_preview_styles', array( $this, 'wefix_shop_preview_styles') );

	}

	/**
	 * Register widgets
	 */
	function wefix_shop_register_widgets( $widgets_manager ) {

		require wefix_shop_others_taxonomy()->module_dir_path() . 'elementor/widgets/product-cat/class-product-cat.php';
		$widgets_manager->register( new WeFix_Shop_Widget_Product_Cat() );

		require wefix_shop_others_taxonomy()->module_dir_path() . 'elementor/widgets/product-cat-single/class-product-cat-single.php';
		$widgets_manager->register( new WeFix_Shop_Widget_Product_Cat_Single() );

	}

	/**
	 * Register widgets styles
	 */
	function wefix_shop_register_widget_styles( $suffix ) {

		# Product Cat
			wp_register_style( 'wdt-shop-product-cat',
				wefix_shop_others_taxonomy()->module_dir_url() . 'assets/css/style'.$suffix.'.css',
				array()
			);
			wp_register_style( 'wdt-shop-product-cat-css-swiper',
				WEFIX_PRO_DIR_URL . 'modules/woocommerce/listings/elementor/widgets/products/assets/css/swiper.min.css',
				array()
			);

		# Product Cat Single
			wp_register_style( 'wdt-shop-product-cat-single',
				wefix_shop_others_taxonomy()->module_dir_url() . 'assets/css/style'.$suffix.'.css',
				array()
			);

	}

	/**
	 * Register widgets scripts
	 */
	function wefix_shop_register_widget_scripts( $suffix ) {

		# Product Cat
			wp_register_script( 'wdt-shop-product-cat-js',
				wefix_shop_others_taxonomy()->module_dir_url() . 'assets/js/carousel.js',
				array()
			);
			# Product Cat
			
			wp_register_script( 'wdt-shop-product-cat-js-swiper',
				WEFIX_PRO_DIR_URL . 'modules/woocommerce/listings/elementor/widgets/products/assets/js/swiper.min.js',
				array( 'jquery' ),
				false,
				true
			);
			
	}

	/**
	 * Editor Preview Style
	 */
	function wefix_shop_preview_styles() {

		# Product Cat
			wp_enqueue_style( 'wdt-shop-product-cat' );
			wp_enqueue_style( 'wdt-shop-product-cat-css-swiper' );

		# Product Cat Single
			wp_enqueue_style( 'wdt-shop-product-cat-single' );
			# Product Cat Single
			wp_enqueue_script( 'wdt-shop-product-cat-js' );
			wp_enqueue_script( 'wdt-shop-product-cat-js-swiper' );

	}

}

WeFix_Shop_Elementor_Taxonomy_Widgets::instance();