<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class WDTPortfolioSfPriceRange extends Widget_Base {

	public function get_categories() {
		return [ 'wdt-searchform-widgets' ];
	}

	public function get_name() {
		return 'wdt-widget-sf-pricerange';
	}

	public function get_title() {
        return esc_html__( 'Price Range','wdt-portfolio');
	}

	public function get_style_depends() {
		return array ( 'jquery-ui', 'wdt-pricing-search');
	}

	public function get_script_depends() {
		return array ( 'jquery-ui-slider', 'wdt-pricing-search');
	}

	protected function register_controls() {

		$this->start_controls_section( 'pricerange_default_section', array(
			'label' => esc_html__( 'General','wdt-portfolio'),
		) );

            $this->add_control( 'min_price', array(
				'label'       => esc_html__( 'Minimum Price','wdt-portfolio'),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Set minimum price range.','wdt-portfolio'),
				'default'     => 1
            ) );

            $this->add_control( 'max_price', array(
				'label'       => esc_html__( 'Maximum Price','wdt-portfolio'),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Set maximum price range.','wdt-portfolio'),
				'default'     => 100
			) );

			$this->add_control( 'ajax_load', array(
				'label'   => esc_html__( 'Ajax Load','wdt-portfolio'),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'false' => esc_html__('False','wdt-portfolio'),
					'true'  => esc_html__('True','wdt-portfolio'),
				),
				'description' => esc_html__('If you want to display the output in same page choose "True" here.','wdt-portfolio'),
				'default'     => 'false'
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
		$output     = do_shortcode('[wdt_sf_price_range_field '.$attributes.' /]');

		echo $output;

	}

}