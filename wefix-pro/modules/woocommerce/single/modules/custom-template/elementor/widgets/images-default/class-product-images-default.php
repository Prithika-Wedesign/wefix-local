<?php

namespace WeFixElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class WeFix_Shop_Widget_Product_Images_Default extends Widget_Base {

	public function get_categories() {
		return [ 'wdt-shop-widgets' ];
	}

	public function get_name() {
		return 'wdt-shop-product-images-default';
	}

	public function get_title() {
		return esc_html__( 'Product Single - Images Default', 'wefix-pro' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'product_images_default_section', array(
			'label' => esc_html__( 'General', 'wefix-pro' ),
		) );

			$this->add_control( 'product_id', array(
				'label'       => esc_html__( 'Product Id', 'wefix-pro' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__('Provide product id for which you have to display woocommerce default product images gallery. No need to provide ID if it is used in Product single page.', 'wefix-pro'),
			) );

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings();

		$output = '';

		if(is_singular('product') && (!isset($settings['product_id']) || $settings['product_id'] == '')) {

			ob_start();
			do_action( 'woocommerce_before_single_product_summary' );
			$woocommerce_before_single_product_summary = ob_get_clean();

			$output .= $woocommerce_before_single_product_summary;

		}

		echo $output;

	}

}