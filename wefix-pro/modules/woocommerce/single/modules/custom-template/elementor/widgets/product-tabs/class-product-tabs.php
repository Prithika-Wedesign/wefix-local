<?php
namespace WeFixElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class WeFix_Shop_Widget_Product_Tabs extends Widget_Base {

	public function get_categories() {
		return [ 'wdt-shop-widgets' ];
	}

	public function get_name() {
		return 'wdt-shop-product-single-tabs';
	}

	public function get_title() {
		return esc_html__( 'Product Single - Tabs', 'wefix-pro' );
	}

	public function get_style_depends() {
		return array( 'wdt-shop-product-single-tabs' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'product_tabs_section', array(
			'label' => esc_html__( 'General', 'wefix-pro' ),
		) );

			$this->add_control( 'product_id', array(
				'label'       => esc_html__( 'Product Id', 'wefix-pro' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__('Provide product id for which you have to display product summary items. No need to provide ID if it is used in Product single page.', 'wefix-pro'),
			) );

			$this->add_control( 'hide_title', array(
				'label'        => esc_html__( 'Hide Title', 'wefix-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'yes', 'wefix-pro' ),
				'label_off'    => esc_html__( 'no', 'wefix-pro' ),
				'default'      => '',
				'return_value' => 'true',
				'description'  => esc_html__( 'If you wish to hide title you can do it here', 'wefix-pro' ),
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

			$hide_title_class = '';
			if($settings['hide_title'] == 'true') {
				$hide_title_class = 'wdt-product-hide-tab-title';
			}

			$output .= '<div class="wdt-product-tabs-wrapper '.$settings['class'].' '.$hide_title_class.'">';

				add_filter( 'woocommerce_product_tabs', 'woocommerce_default_product_tabs' );
				add_filter( 'woocommerce_product_tabs', 'woocommerce_sort_product_tabs', 99 );

				ob_start();
				woocommerce_output_product_data_tabs();
				$output .= ob_get_clean();

			$output .= '</div>';

		} else {

			$output .= esc_html__('Please provide product id to display corresponding data!', 'wefix-pro');

		}

		echo $output;

	}

}