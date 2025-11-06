<?php

if (! class_exists ( 'WeDesignTechElementorRegister' )) {

	class WeDesignTechElementorRegister {

		private static $_instance = null;

		public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		function __construct() {

			require_once WEDESIGNTECH_ELEMENTOR_ADDON_DIR_PATH . 'inc/helper.php';
			require_once WEDESIGNTECH_ELEMENTOR_ADDON_DIR_PATH . 'inc/core/columns/register.php';
			require_once WEDESIGNTECH_ELEMENTOR_ADDON_DIR_PATH . 'inc/core/widgets/register.php';
			require_once WEDESIGNTECH_ELEMENTOR_ADDON_DIR_PATH . 'inc/settings.php';

			add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'register_elementor_editor_scripts' ) );
			add_filter( 'elementor/editor/localize_settings', array( $this, 'register_localize_settings' )  );
			add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ) );
			add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ), 10 );
			add_action( 'init', array( $this, 'register_shortcodes' ), 0 );
			add_action( 'elementor/frontend/after_enqueue_scripts',  array( $this, 'enqueue_scripts' ), 10 );

		}

		public function register_elementor_editor_scripts(){
			wp_enqueue_script( 'wdt-elementor-editor', WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'assets/js/elementor-editor.js', array ('jquery'), WEDESIGNTECH_ELEMENTOR_ADDON_VERSION, true );
		}

		public function register_localize_settings ($settings) {
			$settings = apply_filters( 'wdt_elementor_localize_settings', $settings );
			return $settings;
		}

		public function register_category( $elements_manager ) {

			$elements_manager->add_category(
				'wdt-widgets',
                array (
					'title' => WEDESIGNTECH_ELEMENTOR_ADDON_NAME,
					'icon'  => 'font'
				)
			);

		}

		public function register_widgets( $widgets_manager ) {

			require_once WEDESIGNTECH_ELEMENTOR_ADDON_DIR_PATH . 'inc/register-widget-base.php';

			foreach( glob( WEDESIGNTECH_ELEMENTOR_ADDON_DIR_PATH. 'inc/widgets/*/class-widget-elementor.php'  ) as $elementor_item ) {
				include_once $elementor_item;
			}

		}

		public function register_shortcodes() {

			foreach( glob( WEDESIGNTECH_ELEMENTOR_ADDON_DIR_PATH. 'inc/common-controls/*/register.php'  ) as $base_item ) {
				include_once $base_item;
			}

			foreach( glob( WEDESIGNTECH_ELEMENTOR_ADDON_DIR_PATH. 'inc/widgets/*/class-widget-base.php'  ) as $base_item ) {
				include_once $base_item;
			}

			do_action('wedesigntech_elementor_register_shortcodes');

		}

		public function enqueue_scripts() {

            wp_dequeue_style( 'e-animations' );
			wp_enqueue_style( 'wdt-e-animations', WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'assets/css/animations.min.css', false, WEDESIGNTECH_ELEMENTOR_ADDON_VERSION, 'all');

		}

	}

}


if( !function_exists('wedesigntech_elementor_register') ) {
	function wedesigntech_elementor_register() {
		return WeDesignTechElementorRegister::instance();
	}
}

wedesigntech_elementor_register();
?>