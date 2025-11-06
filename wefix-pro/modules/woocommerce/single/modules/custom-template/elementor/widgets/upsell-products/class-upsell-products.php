<?php
namespace WeFixElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class WeFix_Shop_Widget_Upsell_Products extends Widget_Base {

	public function get_categories() {
		return [ 'wdt-shop-widgets' ];
	}

	public function get_name() {
		return 'wdt-shop-upsell-products';
	}

	public function get_title() {
		return esc_html__( 'Product Single - Upsell Products', 'wefix-pro' );
	}

	public function get_style_depends() {
		return array( 'wdt-shop-product-single-upsell-products' );
	}

	public function product_style_templates() {

		$shop_product_templates['admin'] = esc_html__('Admin Option', 'wefix-pro');
		$shop_product_templates = array_merge ( $shop_product_templates, wefix_woo_listing_customizer_settings()->product_templates_list() );

		return $shop_product_templates;

	}

	protected function register_controls() {
		$this->start_controls_section( 'upsell_products_section', array(
			'label' => esc_html__( 'General', 'wefix-pro' ),
		) );

			$this->add_control( 'product_id', array(
				'label'       => esc_html__( 'Product Id', 'wefix-pro' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__('Provide product id for which you have to display product summary items. No need to provide ID if it is used in Product single page.', 'wefix-pro'),
			) );

			$this->add_control( 'columns', array(
				'label'       => esc_html__( 'Columns', 'wefix-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose column that you like to display upsell products.', 'wefix-pro' ),
				'options'     => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4 ),
				'default'     => 4,
	        ) );

			$this->add_control( 'limit', array(
				'label'       => esc_html__( 'Limit', 'wefix-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose number of products that you like to display.', 'wefix-pro' ),
				'options'     => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10 ),
				'default'     => 4,
	        ) );

			$this->add_control( 'product_style_template', array(
				'label'       => esc_html__( 'Product Style Template', 'wefix-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose number of products that you like to display.', 'wefix-pro' ),
				'options'     => $this->product_style_templates(),
				'default'     => 'admin',
	        ) );

			$this->add_control( 'hide_title', array(
				'label'        => esc_html__( 'Hide Title', 'wefix-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish to hide title you can do it here', 'wefix-pro'),
				'label_on'     => esc_html__( 'yes', 'wefix-pro' ),
				'label_off'    => esc_html__( 'no', 'wefix-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control(
				'class',
				array (
					'label' => esc_html__( 'Class', 'wefix-pro' ),
					'type'  => Controls_Manager::TEXT
				)
			);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings();

		$output = '';

		if($settings['product_id'] == '' && is_singular('product')) {
			global $post;
			$settings['product_id'] = $post->ID;
		}

		if($settings['product_id'] != '') {

			$output .= '<div class="wdt-product-upsell-products '.$settings['class'].'">';

				if($settings['product_style_template'] == 'admin') {
					$product_style_template = wefix_customizer_settings( 'wdt-single-product-upsell-style-template' );
				} else {
					$product_style_template = $settings['product_style_template'];
				}

                $settings['product_upsell_style_template']        = 'custom';
                $settings['product_upsell_style_custom_template'] = $product_style_template;


				wefix_shop_single_module_upsell_related()->woo_load_listing( $settings['product_upsell_style_template'], $settings['product_upsell_style_custom_template'] );

				wc_set_loop_prop('product_upsell_hide_title', $settings['hide_title']);
				wc_set_loop_prop('columns', $settings['columns']);

				woocommerce_upsell_display( $limit = $settings['limit'], $columns = $settings['columns'], $orderby = 'rand', $order = 'desc' );

				wefix_shop_product_style_reset_loop_prop(); /* Reset Product Style Loop Prop */

			$output .= '</div>';

		} else {

			$output .= esc_html__('Please provide product id to display corresponding data!', 'wefix-pro');

		}

		echo $output;

	}

}