<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Advanced_Toggle {

    private static $_instance = null;

	private $cc_style;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	function __construct() {

		// Initialize depandant class
			$this->cc_style = new WeDesignTech_Common_Controls_Style();

	}

    public function name() {
		return 'wdt-advanced-toggle';
	}

    public function title() {
		return esc_html__( 'Advanced Toggle', 'wdt-elementor-addon' );
	}

    public function icon() {
		return 'wdt-widget-icon';
	}

    public function init_styles() {
		return array (
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/advanced-toggle/assets/css/style.css'
		);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array (
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/advanced-toggle/assets/js/script.js'
		);
	}

    public function create_elementor_controls($elementor_object) {

		$elementor_object->start_controls_section( 'wdt_section_content', array(
			'label' => esc_html__( 'Content', 'wdt-elementor-addon'),
		));
        $elementor_object->add_control('left_side_title',array(
            'label' => esc_html__( 'Left Side Title', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => esc_html__( 'Left Title 1', 'wdt-elementor-addon' ),
			'placeholder' => esc_html__( 'Enter Your Left Side Title Here', 'wdt-elementor-addon' ),
			'condition' => array()
		) );

		$elementor_object->add_control('right_side_title',array(
            'label' => esc_html__( 'Right Side Title', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => esc_html__( 'Right Title 1', 'wdt-elementor-addon' ),
			'placeholder' => esc_html__( 'Enter Your Right Side Title Here', 'wdt-elementor-addon' ),
			'condition' => array()
		) );

        $elementor_object->add_control( 'left_side_template', array(
			'label'   => esc_html__( 'Select Left Side Template', 'wdt-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::SELECT2,
			'default' => '',
			'options'   => $elementor_object->get_elementor_page_list(),
			'condition' => array()
		));

		$elementor_object->add_control( 'right_side_template', array(
			'label'   => esc_html__( 'Select Right Side Template', 'wdt-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::SELECT2,
			'default' => '',
			'options'   => $elementor_object->get_elementor_page_list(),
			'condition' => array()
		));

        $elementor_object->end_controls_section();

		// Switcher Content Section
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'switcher_content_section',
			'title' => esc_html__( 'Switcher Content Style', 'wdt-elementor-addon' ),
			'styles' => array (
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-advanced-toggle-container .wdt-advanced-toggle-switcher-container .wdt-advanced-toggle-title',
					'condition' => array ()
				),
				'alignment' => array (
					'field_type' => 'alignment',
                    'control_type' => 'responsive',
                    'default' => 'center',
					'selector' => array (
						'{{WRAPPER}} .wdt-advanced-toggle-container .wdt-advanced-toggle-switcher-container' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
					),
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-advanced-toggle-container .wdt-advanced-toggle-switcher-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-advanced-toggle-container .wdt-advanced-toggle-switcher-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'color' => array (
					'field_type' => 'color',
					'selector' => array (
						'{{WRAPPER}} .wdt-advanced-toggle-container .wdt-advanced-toggle-switcher-container .wdt-advanced-toggle-title' => 'color: {{VALUE}};'
					),
					'condition' => array ()
				),
				'background' => array (
					'field_type' => 'background',
					'selector' => '{{WRAPPER}} .wdt-advanced-toggle-container .wdt-advanced-toggle-switcher-container',
					'condition' => array ()
				),
				'border' => array (
					'field_type' => 'border',
					'selector' => '{{WRAPPER}} .wdt-advanced-toggle-container .wdt-advanced-toggle-switcher-container',
					'condition' => array ()
				),
				'border_radius' => array (
					'field_type' => 'border_radius',
					'selector' => array (
						'{{WRAPPER}} .wdt-advanced-toggle-container .wdt-advanced-toggle-switcher-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'box_shadow' => array (
					'field_type' => 'box_shadow',
					'selector' => '{{WRAPPER}} .wdt-advanced-toggle-container .wdt-advanced-toggle-switcher-container',
					'condition' => array ()
				)
			)
		));

		// Switcher Section
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'switcher_section',
			'title' => esc_html__( 'Switcher Style', 'wdt-elementor-addon' ),
			'styles' => array (
				'color' => array (
					'field_type' => 'color',
					'selector' => array (
						'{{WRAPPER}} .wdt-advanced-toggle-container .wdt-advanced-toggle-switcher-container input.wdt-advanced-checkbox-toggle:after' => 'color: {{VALUE}};'
					),
					'condition' => array ()
				),
				'background' => array (
					'field_type' => 'background',
					'selector' => '{{WRAPPER}} .wdt-advanced-toggle-container .wdt-advanced-toggle-switcher-container input.wdt-advanced-checkbox-toggle',
					'condition' => array ()
				),
				'border' => array (
					'field_type' => 'border',
					'selector' => '{{WRAPPER}} .wdt-advanced-toggle-container .wdt-advanced-toggle-switcher-container input.wdt-advanced-checkbox-toggle',
					'condition' => array ()
				),
				'border_radius' => array (
					'field_type' => 'border_radius',
					'selector' => array (
						'{{WRAPPER}} .wdt-advanced-toggle-container .wdt-advanced-toggle-switcher-container input.wdt-advanced-checkbox-toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .wdt-advanced-toggle-container .wdt-advanced-toggle-switcher-container input.wdt-advanced-checkbox-toggle:after' => 'border-radius: calc({{TOP}}{{UNIT}} - 5px) calc({{RIGHT}}{{UNIT}} - 5px) calc({{BOTTOM}}{{UNIT}} - 5px) calc({{LEFT}}{{UNIT}} - 5px);',
					),
					'condition' => array ()
				),
				'box_shadow' => array (
					'field_type' => 'box_shadow',
					'selector' => '{{WRAPPER}} .wdt-advanced-toggle-container .wdt-advanced-toggle-switcher-container input.wdt-advanced-checkbox-toggle',
					'condition' => array ()
				)
			)
		));
    }

    public function render_html($widget_object, $settings){

        if($widget_object->widget_type != 'elementor') {
			return;
		}

        $output = '';
		$output .= '<div class="wdt-advanced-toggle-container">';
			$output .= '<div class="wdt-advanced-toggle-switcher-container">';

				$output .= '<div class="wdt-advanced-toggle-left-section-title">';
				if( isset($settings['left_side_title']) && !empty($settings['left_side_title'])) {
					$output .= '<div class="wdt-advanced-toggle-title">';
						$output .= $settings['left_side_title'];
					$output .= '</div>';
				}
				$output .= '</div>';
				
				$output .= '<input type="checkbox" class="wdt-advanced-checkbox-toggle" value="1">';

				$output .= '<div class="wdt-advanced-toggle-right-section-title">';
				if( isset($settings['right_side_title']) && !empty($settings['right_side_title'])) {
					$output .= '<div class="wdt-advanced-toggle-title">';
						$output .= $settings['right_side_title'];
					$output .= '</div>';
				}
				$output .= '</div>';
			$output .= '</div>';

			$output .= '<div class="wdt-advanced-toggle-section">';

				$output .= '<div class="wdt-advanced-toggle-left-section">';
					if( isset($settings['left_side_template']) && !empty($settings['left_side_template']) ) {
						$frontend = Elementor\Frontend::instance();
						$output .= $frontend->get_builder_content( $settings['left_side_template'], true );
					}
				$output .= '</div>';

				$output .= '<div class="wdt-advanced-toggle-right-section">';
					if( isset($settings['right_side_template']) && !empty($settings['right_side_template']) ) {
						$frontend = Elementor\Frontend::instance();
						$output .= $frontend->get_builder_content( $settings['right_side_template'], true );
					}
				$output .= '</div>';

			$output .= '</div>';

		$output .= ' </div>';

        return $output;

    }

}

if( !function_exists( 'wedesigntech_widget_base_advanced_toggle' ) ) {
    function wedesigntech_widget_base_advanced_toggle() {
        return WeDesignTech_Widget_Base_Advanced_Toggle::instance();
    }
}