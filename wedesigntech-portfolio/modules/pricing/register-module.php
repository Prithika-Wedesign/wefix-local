<?php

if (!class_exists ( 'WDTPortfolioRegisterPricingModule' )) {

	class WDTPortfolioRegisterPricingModule extends WDTPortfolioAddon {

		private $module_name;
		private $module_url;

		/**
		 * Instance variable
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

		function __construct() {

			$this->wdt_define_constants( 'WDT_PRICING_PLUGIN_PATH', WDT_PLUGIN_PATH . 'modules/pricing/' );
			$this->wdt_define_constants( 'WDT_PRICING_PLUGIN_URL', WDT_PLUGIN_URL . 'modules/pricing/' );

			add_filter ( 'wdt_woo_purchase_cpt', array ( $this, 'wdt_woo_purchase_cpt_update' ), 10, 1 );

			add_filter ( 'wdt_metabox_tabs', array ( $this, 'wdt_metabox_tabs_tab' ) );
			add_filter ( 'wdt_settings', array ( $this, 'wdt_add_settings' ) );

			add_action ( 'wp_enqueue_scripts', array ( $this, 'wdt_enqueue_scripts' ), 20 );

			add_action ( 'wdt_addorupdate_listing_module', array ( $this, 'wdt_addorupdate_listing_pricing_module' ), 10, 2 );

			require_once WDT_PRICING_PLUGIN_PATH . 'shortcodes.php';
			require_once WDT_PRICING_PLUGIN_PATH . 'utils.php';
			require_once WDT_PRICING_PLUGIN_PATH . 'utils-woocommerce.php';

		}

		function wdt_woo_purchase_cpt_update($cpt) {

			array_push($cpt, 'wdt_listings');

			return $cpt;

		}

		function wdt_metabox_tabs_tab($tabs) {

			$tabs['price'] = array (
				'label' => esc_html__('Price','wdt-portfolio'),
				'icon' => 'far fa-money-bill-alt',
				'path' => WDT_PRICING_PLUGIN_PATH . 'metabox-tab-price.php'
			);

			return $tabs;

		}

		function wdt_add_settings($tabs) {

			$tabs['price'] = array (
				'label' => esc_html__('Price','wdt-portfolio'),
				'path'  => WDT_PRICING_PLUGIN_PATH . 'settings.php'
			);

			return $tabs;

		}

		function wdt_enqueue_scripts() {

			$this->wdt_register_dependent_files();
			$this->wdt_enqueue_registered_files();

		}

		function wdt_register_dependent_files() {

			// CSS
			wp_register_style ( 'wdt-pricing-frontend', WDT_PRICING_PLUGIN_URL . 'assets/pricing-frontend.css');
			wp_register_style ( 'wdt-pricing-search', WDT_PRICING_PLUGIN_URL . 'assets/pricing-search.css' );

			// JS
			wp_register_script ( 'wdt-pricing-search', WDT_PRICING_PLUGIN_URL . 'assets/search.js', false, true );

		}

		function wdt_enqueue_registered_files() {

			wp_enqueue_style ( 'wdt-pricing-frontend' );
			wp_enqueue_style ( 'wdt-pricing-search' );

			wp_enqueue_script ( 'jquery-ui-slider' );
			wp_enqueue_script ( 'wdt-pricing-search' );
		}

		function wdt_addorupdate_listing_pricing_module($data, $listing_id) {

			extract($data);

			update_post_meta($listing_id, 'wdt_currency_symbol', $wdt_currency_symbol);
			update_post_meta($listing_id, 'wdt_currency_symbol_position', $wdt_currency_symbol_position);
			update_post_meta($listing_id, '_regular_price', $_regular_price);
			update_post_meta($listing_id, '_sale_price', $_sale_price);
			update_post_meta($listing_id, 'wdt_before_price_label', $wdt_before_price_label);
			update_post_meta($listing_id, 'wdt_after_price_label', $wdt_after_price_label);
		}

	}

}

if( !function_exists('wdtPricingModule') ) {
	function wdtPricingModule() {
		return WDTPortfolioRegisterPricingModule::instance();
	}
}

wdtPricingModule();
?>