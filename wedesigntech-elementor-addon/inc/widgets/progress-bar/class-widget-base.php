<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Progress_Bar {

	private static $_instance = null;

	private $cc_style;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	function __construct() {
		$this->cc_style = new WeDesignTech_Common_Controls_Style();
	}

	public function name() {
		return 'wdt-progress-bar';
	}

	public function title() {
		return esc_html__( 'Progress Bar', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'wdt-widget-icon';
	}

	public function init_styles() {
		return array (
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/progress-bar/assets/css/style.css'
		);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array (
			'jquery-progress-bar' => WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'inc/widgets/progress-bar/assets/js/progressbar.min.js',
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/progress-bar/assets/js/script.js'
		);
	}

	public function create_elementor_controls($elementor_object) {

		$elementor_object->start_controls_section(
			'wdt_section_content',
			array (
				'label' => esc_html__( 'Data', 'wdt-elementor-addon' ),
			)
		);

			$elementor_object->add_control(
				'type',
				array (
					'label' => esc_html__( 'Type', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => array (
						'horizontal' => esc_html__( 'Horizontal', 'wdt-elementor-addon' ),
						'circle' => esc_html__( 'Circle', 'wdt-elementor-addon' ),
						'semi-circle' => esc_html__( 'Semi Circle', 'wdt-elementor-addon' )
					),
					'default' => 'horizontal'
				)
			);

			$elementor_object->add_control(
				'percentage',
				 array(
					'label'   => esc_html__( 'Percentage', 'wdt-elementor-addon' ),
					'type'    => \Elementor\Controls_Manager::NUMBER,
					'min' => 1,
					'max' => 100,
					'default' => 80
				)
			);

			$elementor_object->add_control(
				'content_type',
				array (
					'label' => esc_html__( 'Content Type', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => array (
						'default' => esc_html__( 'Default', 'wdt-elementor-addon' ),
						'floating' => esc_html__( 'Floating', 'wdt-elementor-addon' ),
						'fixed' => esc_html__( 'Fixed', 'wdt-elementor-addon' ),
						'fixed-along' => esc_html__( 'Fixed Along', 'wdt-elementor-addon' ),
					),
					'default' => 'default',
					'condition' => array(
						'type' => 'horizontal'
					),
				)
			);

			$elementor_object->add_control(
				'title',
				array(
					'label'       => esc_html__( 'Title', 'wdt-elementor-addon' ),
					'type'        => \Elementor\Controls_Manager::TEXT,
					'default'     => esc_html__( 'Example Title', 'wdt-elementor-addon' ),
					'placeholder' => esc_html__( 'Example Title', 'wdt-elementor-addon' ),
					'condition' => array(
						'type' => 'horizontal'
					),
				)
			);

		$elementor_object->end_controls_section();

		$elementor_object->start_controls_section( 'wdt_style_section_bar', array(
        	'label'      => esc_html__( 'Bar', 'wdt-elementor-addon' ),
			'tab'        => \Elementor\Controls_Manager::TAB_STYLE
		) );

			$elementor_object->add_responsive_control(
				'bar_width',
				array (
					'label' => esc_html__( 'Width', 'elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'default' => array (
						'size' => 100,
						'unit' => '%',
					),
					'size_units' => array ( '%', 'px', 'vw' ),
					'range' => array (
						'%' => array (
							'min' => 1,
							'max' => 100,
						),
						'px' => array (
							'min' => 1,
							'max' => 1000,
						),
						'vw' => array (
							'min' => 1,
							'max' => 100,
						),
					),
					'selectors' => array (
						'{{WRAPPER}} .wdt-progressbar-container.wdt-progressbar-circle .wdt-progressbar, {{WRAPPER}} .wdt-progressbar-container.wdt-progressbar-semi-circle .wdt-progressbar' => 'width: {{SIZE}}{{UNIT}};',
					),
                    'condition' => array (
						'type!' => 'horizontal'
					)
				)
			);

			$elementor_object->add_control(
				'bar_active_thickness',
				array (
					'label' => esc_html__( 'Active Thickeness', 'elementor' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 0.1,
					'max' => 100,
					'step' => 0.1,
					'default' => 2
				)
			);

			$elementor_object->add_control(
				'bar_inactive_thickness',
				array (
					'label' => esc_html__( 'Inactive Thickeness', 'elementor' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 0.1,
					'max' => 100,
					'step' => 0.1,
					'default' => 2
				)
			);

			$elementor_object->add_control(
				'bar_active_color',
				array (
					'label' => esc_html__( 'Active Color', 'elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => wedesigntech_elementor_global_colors( 'system_colors', 0 ),
					'global' => array (
						'active' => false,
					)
				)
			);

			$elementor_object->add_control(
				'bar_inactive_color',
				array (
					'label' => esc_html__( 'Inactive Color', 'elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => wedesigntech_elementor_global_colors( 'system_colors', 2 ),
					'global' => array (
						'active' => false,
					)
				)
			);

			$elementor_object->add_control(
				'circle_fill_color',
				array (
					'label' => esc_html__( 'Fill Color', 'elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#FFFFFF',
					'selectors' => array (
						'{{WRAPPER}} .wdt-progressbar-circle .wdt-progressbar svg path:first-child, {{WRAPPER}} .wdt-progressbar-semi-circle .wdt-progressbar svg path:first-child' => 'fill: {{VALUE}}; fill-opacity: 1;',
					),
					'condition' => array(
						'type' => array ('circle', 'semi-circle')
					)
				)
			);

			$elementor_object->add_control(
				'enable_gradient',
				array(
					'label'              => esc_html__( 'Enable Gradient', 'wdt-elementor-addon' ),
					'type'               => \Elementor\Controls_Manager::SWITCHER,
					'frontend_available' => true,
					'default'            => '',
					'return_value'       => 'true'
				)
			);

			$elementor_object->add_control(
				'gradient_color',
				array (
					'label' => esc_html__( 'Gradient Color', 'elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'global' => array (
						'active' => true,
					),
					'default' => wedesigntech_elementor_global_colors( 'system_colors', 3 ),
					'condition' => array(
						'enable_gradient' => 'true'
					)
				)
			);

			$elementor_object->add_control(
				'background_active_heading',
				array (
					'label' => esc_html__( 'Background', 'elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before'
				)
			);

			$elementor_object->add_control(
				'background_color',
				array (
					'label' => esc_html__( 'Background Color', 'elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' =>  array (
						'{{WRAPPER}} .wdt-progressbar' => 'background-color: {{VALUE}};'
					)
				)
			);

			$elementor_object->add_control(
				'background_inactive_heading',
				array (
					'label' => esc_html__( 'Inactive Background', 'elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before'
				)
			);

			$elementor_object->add_control(
				'inactive_background',
				array(
					'label' => esc_html__('Inactive Background', 'wdt-elementor-addon'),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'selectors' => array (
						'{{WRAPPER}} .wdt-progressbar-container svg' => 'background-image: url("{{URL}}"); background-position:center; background-size:cover;',
					)
				)
			);

			$elementor_object->add_control(
				'border_heading',
				array (
					'label' => esc_html__( 'Border', 'elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before'
				)
			);

			$elementor_object->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				array (
					'name' => 'border',
					'label' => esc_html__('Border', 'wdt-elementor-addon'),
					'selector' => '{{WRAPPER}} .wdt-progressbar',
				)
			);

			$elementor_object->add_responsive_control(
               'border_radius',
                array (
                    'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => array ( 'px', 'em', '%' ),
                    'selectors' => array (
						'{{WRAPPER}} .wdt-progressbar, {{WRAPPER}} .wdt-progressbar svg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
                )
            );

			$elementor_object->add_responsive_control(
				'padding',
				array (
                    'label' => esc_html__( 'Padding', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => array ( 'px', 'em', '%', 'rem' ),
                    'selectors' =>  array (
						'{{WRAPPER}} .wdt-progressbar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$elementor_object->end_controls_section();


		$elementor_object->start_controls_section( 'wdt_style_section_data', array(
        	'label'      => esc_html__( 'Data', 'wdt-elementor-addon' ),
			'tab'        => \Elementor\Controls_Manager::TAB_STYLE
		) );

			$elementor_object->add_control(
				'title_color',
				array (
					'label' => esc_html__( 'Title Color', 'elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => array (
						'{{WRAPPER}} .wdt-progressbar-horizontal .wdt-progressbar-title' => 'color: {{VALUE}};'
					),
					'condition' => array(
						'type' => 'horizontal'
					)
				)
			);

			$elementor_object->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				array (
					'name' => 'title',
					'label' => esc_html__('Title Typography', 'wdt-elementor-addon'),
					'selector' => '{{WRAPPER}} .wdt-progressbar-horizontal .wdt-progressbar-title',
					'separator' => 'after',
					'condition' => array(
						'type' => 'horizontal'
					)
				)
			);

			$elementor_object->add_control(
				'percentage_color',
				array (
					'label' => esc_html__( 'Percentage Color', 'elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => array (
						'{{WRAPPER}} .wdt-progressbar-horizontal .wdt-progressbar-value, {{WRAPPER}} .wdt-progressbar-circle .wdt-progressbar-value' => 'color: {{VALUE}};'
					)
				)
			);

			$elementor_object->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				array (
					'name' => 'percentage',
					'label' => esc_html__('Percentage Typography', 'wdt-elementor-addon'),
					'selector' =>'{{WRAPPER}} .wdt-progressbar-horizontal .wdt-progressbar-value, {{WRAPPER}} .wdt-progressbar-circle .wdt-progressbar-value, {{WRAPPER}} .wdt-progressbar-semi-circle .wdt-progressbar-value'
				)
			);

			$elementor_object->add_control(
				'percentage_symbol_position',
				array (
					'label' => esc_html__( 'Percentage Symbol Position', 'elementor' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => array (
						'flex-start' => array (
							'title' => esc_html__( 'Start', 'wdt-elementor-addon' ),
							'icon' => 'eicon-v-align-top',
						),
						'center' => array (
							'title' => esc_html__( 'Center', 'wdt-elementor-addon' ),
							'icon' => 'eicon-v-align-middle',
						),
						'flex-end' => array (
							'title' => esc_html__( 'End', 'wdt-elementor-addon' ),
							'icon' => 'eicon-v-align-bottom',
						)
					),
					'default' => 'center',
					'selectors' => array (
						'{{WRAPPER}} .wdt-progressbar-container .wdt-progressbar-value .wdt-progressbar-percentage' => 'align-self: {{VALUE}};'
					),
					'condition' => array(
						'type' => array ('horizontal')
					)
				)
			);

			$elementor_object->add_responsive_control(
                'percentage_symbol_font_size',
                array (
                    'label' => esc_html__( 'Percentage Symbol Font Size', 'wdt-elementor-addon' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'default' => array (
						'size' => 14,
						'unit' => 'px'
					),
                    'size_units' => array(
                        'px'
                    ),
                    'responsive' => true,
                    'range' => array (
                        'px' => array (
                            'min' => 12,
                            'max' => 60
                        ),
                    ),
					'selectors' => array (
                        '{{WRAPPER}} .wdt-progressbar-container .wdt-progressbar-value .wdt-progressbar-percentage' => 'font-size: {{SIZE}}{{UNIT}};'
                    ),
					'condition' => array(
						'type' => array ('horizontal')
					)
                )
            );

		$elementor_object->end_controls_section();

	}

	public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}

		extract($settings);

		$output = '';

		$module_id = $widget_object->get_id();

		$bar_settings = array();
		$bar_settings['module_id'] = $module_id;
		$bar_settings['module_pb_id'] = '#wdt-progressbar-'.$module_id;
		$bar_settings['type'] = $type;
		$bar_settings['content_type'] = $content_type;
		$bar_settings['percentage'] = $percentage;
		$bar_settings['bar_active_thickness'] = $bar_active_thickness;
		$bar_settings['bar_inactive_thickness'] = $bar_inactive_thickness;
		$bar_settings['bar_active_color'] = !empty($bar_active_color) ? $bar_active_color : '';
		$bar_settings['bar_inactive_color'] = !empty($bar_inactive_color) ? $bar_inactive_color : '';
		$bar_settings['enable_gradient'] = (isset($enable_gradient) && $enable_gradient == 'true') ? true : false;
		$bar_settings['gradient_color'] = !empty($gradient_color) ? $gradient_color : '';
		$bar_settings['percentage_color'] = !empty($percentage_color) ? $percentage_color : '';

		$bar_settings_attr = wp_json_encode($bar_settings);

		$classes = array ();
		if(isset($type) && $type != '') {
			array_push($classes, 'wdt-progressbar-'.$type);
		}
		if(isset($content_type) && $content_type != '') {
			array_push($classes, 'wdt-progressbar-content-'.esc_attr($content_type));
		}

		$output .= '<div class="wdt-progressbar-container '.esc_attr(implode(' ', $classes)).'" id="wdt-progressbar-'.esc_attr($module_id).'" data-bar-settings="'.esc_js($bar_settings_attr).'">';
			if($type == 'horizontal') {
				$output .= '<div class="wdt-progressbar-content">';
					$output .= '<div class="wdt-progressbar-title">'.esc_html($title).'</div>';
					$output .= '<div class="wdt-progressbar-value"></div>';
				$output .= '</div>';
			}
			$output .= '<div class="wdt-progressbar"></div>';
		$output .= '</div>';

		return $output;

	}

}

if( !function_exists( 'wedesigntech_widget_base_progress_bar' ) ) {
    function wedesigntech_widget_base_progress_bar() {
        return WeDesignTech_Widget_Base_Progress_Bar::instance();
    }
}