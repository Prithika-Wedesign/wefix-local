<?php

class WeDesignTech_Common_Controls_Rating {

    function __construct() {
    }

    public function init_styles() {
		return array ();
	}

	public function init_scripts() {
		return array ();
	}

	public function get_controls($elementor_object, $condition) {

		$elementor_object->add_control( 'rating', array(
			'label'          => esc_html__( 'Rating', 'wdt-elementor-addon' ),
			'type'           => \Elementor\Controls_Manager::SELECT,
			'default'        => '',
			'options'        => array(
				'' => esc_html__( 'None', 'wdt-elementor-addon' ),
				1 => esc_html__( '1', 'wdt-elementor-addon' ),
				2 => esc_html__( '2', 'wdt-elementor-addon' ),
				3 => esc_html__( '3', 'wdt-elementor-addon' ),
				4 => esc_html__( '4', 'wdt-elementor-addon' ),
				5 => esc_html__( '5', 'wdt-elementor-addon' )
			),
			'condition' => $condition
		) );

	}

    public function render_html($rating) {

		$output = '';

		if (isset($rating) && !empty($rating)) {
			$max_rating = 5;
			$output .= '<div class="wdt-rating-container">';
				$output .= '<div class="wdt-rating" data-rating="' . esc_attr($rating) . '">';
					$output .= '<span class="wdt-rating-count">' . esc_html($rating) . '/' . $max_rating . '</span>';
					$output .= '<span class="wdticon-stars"></span>';
				$output .= '</div>';
			$output .= '</div>';
		}

		return $output;

    }

}