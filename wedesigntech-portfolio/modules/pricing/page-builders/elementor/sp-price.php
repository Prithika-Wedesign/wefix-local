<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class WDTPortfolioSpPrice extends Widget_Base {

	public function get_categories() {
		return [ 'wdt-singlepage-widgets' ];
	}

	public function get_name() {
		return 'wdt-widget-sp-price';
	}

	public function get_title() {
		return esc_html__( 'Price','wdt-portfolio');
	}

	public function get_style_depends() {
		return array ( 'wdt-pricing-frontend' );
	}

	public function get_script_depends() {
		return array ();
	}

	protected function register_controls() {

		$listing_singular_label = apply_filters( 'listing_label', 'singular' );

		$this->start_controls_section( 'price_default_section', array(
			'label' => esc_html__( 'General','wdt-portfolio'),
		) );

			$this->add_control( 'listing_id', array(
				'label'       => sprintf( esc_html__('%1$s Id','wdt-portfolio'), $listing_singular_label ),
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Provide %1$s id to display your item. No need to provide ID if it is used in %1$s single page.','wdt-portfolio'), strtolower($listing_singular_label) ),
				'default'     => ''
			) );

			$this->add_control( 'type', array(
				'label'   => esc_html__( 'Type','wdt-portfolio'),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'type1' => esc_html__('Type 1','wdt-portfolio'),
					'type2' => esc_html__('Type 2','wdt-portfolio'),
					'type3' => esc_html__('Type 3','wdt-portfolio')
				),
				'description' => esc_html__( 'Choose any of the available type.','wdt-portfolio'),
				'default'     => 'type1',
			) );

			$this->add_control( 'class', array(
				'label'       => esc_html__( 'Class','wdt-portfolio'),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can add additional class name here.','wdt-portfolio'),
				'default'     => ''
			) );

		$this->end_controls_section();
	}

	protected function render() {

		$settings   = $this->get_settings();
		$attributes = wdtportfolio_elementor_instance()->wdt_parse_shortcode_attrs( $settings );
		$output     = do_shortcode('[wdt_sp_price '.$attributes.' /]');

		echo $output;

	}

}