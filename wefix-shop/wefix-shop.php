<?php
/**
 * Plugin Name:	WeFix Shop
 * Description: Adds shop features for WeFix Theme shop test.
 * Version: 1.0.0
 * Author: the WeDesignTech team
 * Author URI: https://wedesignthemes.com/
 * Text Domain: wefix-shop
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * The main class that initiates and runs the plugin.
 */
final class WeFix_Shop {

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

	/**
	 * Constructor
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'wefix_shop_i18n' ) );
		add_filter( 'wefix_required_plugins_list', array( $this, 'upadate_required_plugins_list' ) );
		add_action( 'plugins_loaded', array( $this, 'wefix_shop_plugins_loaded' ) );


		add_filter('woocommerce_product_data_tabs', array( $this, 'custom_ad_tab' ) );
		add_action('woocommerce_product_data_panels', array( $this, 'custom_ad_tab_content' ) ); 
		add_action('woocommerce_admin_process_product_object', array( $this, 'save_custom_ad_tab_fields' ) ); 
		add_action( 'woocommerce_before_single_product', array( $this, 'load_my_plugin_template' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_action('init', array( $this, 'handle_feedback_form_submission' ) );
		add_action('init', array( $this, 'register_feedback_post_type' ) );
		add_action('add_meta_boxes', array( $this, 'add_feedback_meta_box' ) );

		add_action('wp_ajax_notify_me', array( $this, 'handle_notify_me' ) );
		add_action('wp_ajax_nopriv_notify_me', array( $this, 'handle_notify_me' ) ); 
		add_action('woocommerce_product_set_stock_status', array( $this, 'notify_variation_when_instock' ), 10, 3);
		add_action('admin_menu', array( $this, 'notify_me_admin_menu') );
		add_action('wp_ajax_check_variation_stock', array( $this, 'check_variation_stock') ); 
		add_action('wp_ajax_nopriv_check_variation_stock', array( $this, 'check_variation_stock') );

		add_action('wp_ajax_notify_me_variation', array( $this, 'handle_notify_me_variation') );
		add_action('wp_ajax_nopriv_notify_me_variation', array( $this, 'handle_notify_me_variation') );

	}

	/* notify me */
		public function check_variation_stock() {
			$variation_id = intval($_POST['variation_id']);

			if (!$variation_id) {
				wp_send_json_error(['message' => 'Invalid variation ID']);
			}

			$variation = wc_get_product($variation_id);

			if (!$variation) {
				wp_send_json_error(['message' => 'Variation not found']);
			}

			$in_stock = $variation->is_in_stock();

			wp_send_json_success([
				'in_stock' => $in_stock
			]);
		}

		public function handle_notify_me_variation() {
			$email = sanitize_email($_POST['email']);
			$variation_id = intval($_POST['variation_id']);

			if (!is_email($email)) {
				echo 'Invalid Email';
				wp_die();
			}

			$existing = get_post_meta($variation_id, '_notify_emails', true);
			$emails = is_array($existing) ? $existing : [];

			if (!in_array($email, $emails)) {
				$emails[] = $email;
				update_post_meta($variation_id, '_notify_emails', $emails);
				echo 'You will be notified when this variant is back in stock.';
			} else {
				echo 'You are already subscribed for this variant.';
			}

			wp_die();
		}

		public function notify_me_admin_menu() {
			add_menu_page(
				'Notify Me Subscribers',
				'Notify Me',
				'manage_options',
				'notify-me-subscribers',
				array($this, 'notify_me_admin_page'), // Correct callback
				'dashicons-email',
				26
			);
		}

		public function notify_me_admin_page() {
			?>
			<div class="wrap">
				<h1>Notify Me Subscribers</h1>

				<?php
				$args = array(
					'post_type'      => 'product',
					'posts_per_page' => -1,
					'post_status'    => 'publish',
				);

				$products = get_posts($args);

				echo '<table class="wp-list-table widefat fixed striped">';
				echo '<thead><tr>
						<th>Product ID</th>
						<th>Product Name</th>
						<th>Emails Subscribed</th>
					</tr></thead><tbody>';

				foreach ($products as $product) {
				$product_obj = wc_get_product($product->ID);
				$emails = get_post_meta($product->ID, '_notify_emails', true);

	
				if (!empty($emails) && is_array($emails)) {
					echo '<tr>';
					echo '<td>' . esc_html($product->ID) . '</td>';
					echo '<td><a href="' . esc_url(get_edit_post_link($product->ID)) . '">' . esc_html($product->post_title) . '</a></td>';
					echo '<td>' . implode('<br>', array_map('esc_html', $emails)) . '</td>';
					echo '</tr>';
				}

			
				if ($product_obj && $product_obj->is_type('variable')) {
					$variations = $product_obj->get_children(); 

					foreach ($variations as $variation_id) {
						$variation = wc_get_product($variation_id);
						$variation_emails = get_post_meta($variation_id, '_notify_emails', true);

						$parent_id = wp_get_post_parent_id($variation_id);
						$parent_url = get_permalink($parent_id);

						if (!empty($variation_emails) && is_array($variation_emails)) {
							$variation_name = $variation->get_formatted_name();

							echo '<tr>';
							echo '<td>' . esc_html($variation_id) . '</td>';
							echo '<td><a href="' .  esc_url($parent_url)  . '">' . wp_kses_post($variation_name) . '</a></td>'; 
							echo '<td>' . implode('<br>', array_map('esc_html', $variation_emails)) . '</td>';
							echo '</tr>';
						}
					}
				}
			}

				echo '</tbody></table>';
				?>
			</div>
			<?php
		}

		public function notify_variation_when_instock($product_id, $stock_status, $product) {
			if ($product->is_type('variation') && $stock_status === 'instock') {
				$emails = get_post_meta($product_id, '_notify_emails', true);

				if (!empty($emails) && is_array($emails)) {
					foreach ($emails as $email) {
						wp_mail(
							$email,
							'Product Variant Back In Stock!',
							'The variant "' . get_the_title($product_id) . '" is now back in stock. Check it here: ' . get_permalink(wp_get_post_parent_id($product_id))
						);
					}

					// Clear the emails after notification
					delete_post_meta($product_id, '_notify_emails');
				}
			}
		}

		public function handle_notify_me() {
			$email = sanitize_email($_POST['email']);
			$product_id = intval($_POST['product_id']);

			if (!is_email($email)) {
				echo 'Invalid Email';
				wp_die();
			}

			$existing = get_post_meta($product_id, '_notify_emails', true);
			$emails = is_array($existing) ? $existing : [];

			if (!in_array($email, $emails)) {
				$emails[] = $email;
				update_post_meta($product_id, '_notify_emails', $emails);
				echo 'You will be notified when this product is back in stock.';
			} else {
				echo 'You are already subscribed for this product.';
			}

			wp_die();
		}

	/* notify me */
	
		public function load_my_plugin_template() {
		
		
				wc_get_template(
					'offer-popup.php',
					array(),
					'',
					WEFIX_SHOP_PATH . 'templates/global/'
				);

		}

		public function custom_ad_tab($tabs) {
			$tabs['ad_settings'] = array(
				'label'    => __('Ad Settings', 'woocommerce'),
				'target'   => 'ad_settings_product_data',
				'class'    => array('show_if_simple', 'show_if_variable', 'show_if_grouped', 'show_if_external'),
				'priority' => 90,
			);
			return $tabs;
		}
	 
 	//Ad media in product page
		public function custom_ad_tab_content() {
			?>
			<div id="ad_settings_product_data" class="panel woocommerce_options_panel">
				<div class="options_group">
					<?php
					woocommerce_wp_text_input(array(
						'id'          => '_ad_media_url',
						'label'       => __('Ad Image/Video URL', 'woocommerce'),
						'placeholder' => 'https://wefix.com/ad.mp4 or ad.jpg',
						'desc_tip'    => true,
						'description' => __('URL of the ad media to show on product page.', 'woocommerce')
					));
					?>
				</div>
			</div>
			<?php
		}		

		public function save_custom_ad_tab_fields($product) {
			if (isset($_POST['_ad_media_url'])) {
				$product->update_meta_data('_ad_media_url', sanitize_text_field($_POST['_ad_media_url']));
			}
		}

	/**
		 * Add Common css & javascript
	*/

		function enqueue_assets() { 
				wp_enqueue_style( 'wefix-shop-core', WEFIX_SHOP_URL . 'assets/css/shop_base.css', array(), WEFIX_SHOP_VERSION, 'all'); 
				wp_enqueue_style( 'variation-swatches-css', get_theme_file_uri('/modules/woocommerce/assets/css/variation-swatches.css'),  array(),  WEFIX_THEME_VERSION, 'all');  
				wp_enqueue_script( 'wdt-elementor-addon-core', WEFIX_SHOP_URL . 'assets/js/shop.js', array ('jquery'), WEFIX_SHOP_VERSION, true );
				do_action( 'wefix_pro_after_asset_enqueue' );
		}

		function handle_feedback_form_submission() {
				if (isset($_POST['submit_feedback']) && isset($_POST['feedback_nonce']) && wp_verify_nonce($_POST['feedback_nonce'], 'save_feedback_form')) {
					
					$feedback_data = [
						'selected_option' => sanitize_text_field($_POST['feedback_option'] ?? ''),
					];

					// Loop through dynamic answers
					foreach ($_POST as $key => $value) {
						if (strpos($key, 'answer_') === 0) {
							$feedback_data[$key] = is_array($value) ? array_map('sanitize_text_field', $value) : sanitize_text_field($value);
						}
					}

					// Save as custom post type or custom table
					$post_id = wp_insert_post([
						'post_type' => 'user_feedback',
						'post_title' => 'Feedback - ' . current_time('mysql'),
						'post_status' => 'publish',
					]);

					if ($post_id && !is_wp_error($post_id)) {
						foreach ($feedback_data as $key => $val) {
							update_post_meta($post_id, $key, $val);
						}
					}
				}
		}

		public function register_feedback_post_type() {
				register_post_type('user_feedback', [
				'labels' => [
					'name' => 'User Feedback',
					'singular_name' => 'Feedback',
					'all_items' => 'All Feedback',
					'edit_item' => 'View Feedback',
				],
				'public' => false,
				'show_ui' => true,
				'show_in_menu' => true,
				'supports' => ['title'],
				'menu_icon' => 'dashicons-feedback', 
				'capability_type' => 'post',
				'capabilities' => [
					'create_posts' => 'do_not_allow',
				],
				'map_meta_cap' => true,
			]);
		} 

		public function add_feedback_meta_box() {
			add_meta_box(
			'feedback_data',
			'Feedback Details',
			array($this, 'render_feedback_meta_box'),  
			'user_feedback',
			'normal',
			'default'
			);
		}

		function render_feedback_meta_box($post) {
			wp_nonce_field('save_feedback_meta_box', 'feedback_meta_box_nonce');
			$meta = get_post_meta($post->ID);
			echo '<table class="form-table">';
			foreach ($meta as $key => $val) {
				if (strpos($key, '_') === 0) continue;
				$value = maybe_unserialize($val[0]);
				echo '<tr>';
				echo '<th><label for="' . esc_attr($key) . '">' . esc_html($key) . '</label></th>';
				echo '<td>'. esc_attr($value) . '</td>';
				echo '</tr>';
			}
			echo '</table>';
		}
		

	/**
	 * Load Textdomain
	 */
		public function wefix_shop_i18n() {

			load_plugin_textdomain( 'wefix-shop', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}

	/**
	 * Update required plugins list
	 */
		function upadate_required_plugins_list($plugins_list) {

            $required_plugins = array(
                array(
                    'name'				=> 'WooCommerce',
                    'slug'				=> 'woocommerce',
                    'required'			=> true,
                    'force_activation'	=> false,
                )
            );
            $new_plugins_list = array_merge($plugins_list, $required_plugins);

            return $new_plugins_list;

        }

	/**
	 * Initialize the plugin
	 */
		public function wefix_shop_plugins_loaded() {

			// Check for WooCommerce plugin
				if( !function_exists( 'is_woocommerce' ) ) {
					add_action( 'admin_notices', array( $this, 'wefix_shop_woo_plugin_req' ) );
					return;
				}

			// Check for WeFix Theme plugin
				if( !function_exists( 'wefix_pro' ) ) {
					add_action( 'admin_notices', array( $this, 'wefix_shop_dttheme_plugin_req' ) );
					return;
				}

			// Setup Constants (non-translatable ones)
			$this->wefix_shop_setup_non_translatable_constants();
			// Setup translatable constants later
			add_action('init', array($this, 'wefix_shop_setup_translatable_constants'), 11);

			// Load Modules & Helper
				$this->wefix_shop_load_modules();
                $this->load_helper();

				add_filter( 'woocommerce_single_product_image_thumbnail_html',  array( $this, 'custom_add_variant_id_to_thumbnail' ), 10, 2 );

			// Locate Module Files
				add_filter( 'wefix_woo_pro_locate_file',  array( $this, 'wefix_woo_pro_shop_locate_file' ), 10, 2 );

			// Load WooCommerce Template Files
				add_filter( 'woocommerce_locate_template',  array( $this, 'wefix_shop_woocommerce_locate_template' ), 30, 3 );

		}


	/**
	 * Admin notice
	 * Warning when the site doesn't have WooCommerce plugin.
	 */
		public function wefix_shop_woo_plugin_req() {

			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			$message = sprintf(
				/* translators: 1: Plugin name 2: Required plugin name */
				esc_html__( '"%1$s" requires "%2$s" plugin to be installed and activated.', 'wefix-shop' ),
				'<strong>' . esc_html__( 'WeFix Shop', 'wefix-shop' ) . '</strong>',
				'<strong>' . esc_html__( 'WooCommerce - excelling eCommerce', 'wefix-shop' ) . '</strong>'
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

	/**
	 * Admin notice
	 * Warning when the site doesn't have WeFix Theme plugin.
	 */
		public function wefix_shop_dttheme_plugin_req() {

			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			$message = sprintf(
				/* translators: 1: Plugin name 2: Required plugin name */
				esc_html__( '"%1$s" requires "%2$s" plugin to be installed and activated.', 'wefix-shop' ),
				'<strong>' . esc_html__( 'WeFix Shop', 'wefix-shop' ) . '</strong>',
				'<strong>' . esc_html__( 'WeFix Pro', 'wefix-shop' ) . '</strong>'
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

	/**
	 * Define constant if not already set.
	 */
		public function wefix_shop_define_constants( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

	/**
	 * Configure Non-Translatable Constants
	 */
	public function wefix_shop_setup_non_translatable_constants()
	{
		$this->wefix_shop_define_constants('WEFIX_SHOP_VERSION', '1.0');
		$this->wefix_shop_define_constants('WEFIX_SHOP_PATH', trailingslashit(plugin_dir_path(__FILE__)));
		$this->wefix_shop_define_constants('WEFIX_SHOP_URL', trailingslashit(plugin_dir_url(__FILE__)));

		$this->wefix_shop_define_constants('WEFIX_SHOP_MODULE_PATH', trailingslashit(plugin_dir_path(__FILE__) . 'modules'));
		$this->wefix_shop_define_constants('WEFIX_SHOP_MODULE_URL', trailingslashit(plugin_dir_url(__FILE__) . 'modules'));
	}

	/**
	 * Configure Translatable Constants
	 */
	public function wefix_shop_setup_translatable_constants()
	{
		$this->wefix_shop_define_constants('WEFIX_SHOP_NAME', esc_html__('WeFix Shop', 'wefix-shop'));
	}

	/**
	 * Load Modules
	 */
		public function wefix_shop_load_modules() {

			foreach( glob( WEFIX_SHOP_MODULE_PATH. '*/index.php' ) as $module ) {
				include_once $module;
			}

		}

	/**
	 * Locate Module Files
	 */
		public function wefix_woo_pro_shop_locate_file( $file_path, $module ) {

			$file_path = WEFIX_SHOP_PATH . 'modules/' . $module .'.php';

			$located_file_path = false;
			if ( $file_path && file_exists( $file_path ) ) {
				$located_file_path = $file_path;
			}

			return $located_file_path;

		}

	/**
	 * Override WooCommerce default template files
	 */
		public function wefix_shop_woocommerce_locate_template( $template, $template_name, $template_path ) {

			global $woocommerce;

			$_template = $template;

			if ( ! $template_path ) $template_path = $woocommerce->template_url;

			$plugin_path  = WEFIX_SHOP_PATH . 'templates/';

			// Look within passed path within the theme - this is priority
			$template = locate_template(
				array(
					$template_path . $template_name,
					$template_name
				)
			);

			// Modification: Get the template from this plugin, if it exists
			if ( ! $template && file_exists( $plugin_path . $template_name ) )
			$template = $plugin_path . $template_name;

			// Use default template
			if ( ! $template )
			$template = $_template;

			// Return what we found
			return $template;

		}

	/**
	 * Load helper
	 */
        function load_helper() {
            require_once WEFIX_SHOP_PATH . 'functions.php';
        }

		function custom_add_variant_id_to_thumbnail( $html, $attachment_id ) {
			global $product;

			if ( ! $product || ! is_a( $product, 'WC_Product' ) || ! $product->is_type( 'variable' ) ) {
				return $html;
			}

			$available_variations = $product->get_available_variations();

			foreach ( $available_variations as $variation ) {
				if ( isset( $variation['image_id'] ) && (int) $variation['image_id'] === (int) $attachment_id ) {
					$variant_id = $variation['variation_id'];
					$attach_id = $variation['image_id'];

					// Add data-variant_id attribute to the image tag
					$html = preg_replace(
						'/<img(.*?)\/?>/i',
						'<img$1 data-variant_id="' . esc_attr( $attach_id ) . '" />',
						$html
					);

					break;
				}
			}

			return $html;
		}


}

if( !function_exists('wefix_shop_instance') ) {
	function wefix_shop_instance() {
		return WeFix_Shop::instance();
	}
}

wefix_shop_instance();