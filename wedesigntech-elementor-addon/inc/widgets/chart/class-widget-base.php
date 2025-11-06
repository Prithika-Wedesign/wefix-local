<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Chart {

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
		return 'wdt-chart';
	}

	public function title() {
		return esc_html__( 'Donut & Pie Chart', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'wdt-widget-icon';
	}

	public function init_styles() {
		return array (
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/chart/assets/css/style.css'
		);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array (
			'jquery-chart' => WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'inc/widgets/chart/assets/js/chart.min.js',
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/chart/assets/js/script.js'
		);
	}

	public function create_elementor_controls($elementor_object) {

		// Chart Section

		$elementor_object->start_controls_section(
			'wdt_section_content',
			array (
				'label' => esc_html__( 'Data', 'wdt-elementor-addon' ),
			)
		);

			$elementor_object->add_control(
				'chart_type',
				array (
					'label' => esc_html__( 'Chart Type', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => array (
						'doughnut' => esc_html__( 'Doughnut', 'wdt-elementor-addon' ),
						'pie' => esc_html__( 'Pie', 'wdt-elementor-addon' )
					),
					'default' => 'doughnut'
				)
			);

			$repeater = new \Elementor\Repeater();

			$repeater->add_control(
				'label',
				array (
					'label' => esc_html__( 'Label', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Label', 'wdt-elementor-addon' )
				)
			);

			$repeater->add_control(
				'value',
				 array(
					'label'   => esc_html__( 'Value', 'wdt-elementor-addon' ),
					'type'    => \Elementor\Controls_Manager::NUMBER,
					'default' => 20,
				)
			);

			$repeater->add_control(
				'background_color',
				 array(
					'label'   => esc_html__( 'Background Color', 'wdt-elementor-addon' ),
					'type'    => \Elementor\Controls_Manager::COLOR,
					'default' => wedesigntech_elementor_global_colors( 'system_colors', 0 )
				)
			);

			$repeater->add_control(
				'background_hover_color',
				 array(
					'label'   => esc_html__( 'Background Hover Color', 'wdt-elementor-addon' ),
					'type'    => \Elementor\Controls_Manager::COLOR,
					'default' => wedesigntech_elementor_global_colors( 'system_colors', 1 )
				)
			);

			$repeater->add_control(
				'border_color',
				 array(
					'label'   => esc_html__( 'Border Color', 'wdt-elementor-addon' ),
					'type'    => \Elementor\Controls_Manager::COLOR,
					'default' => wedesigntech_elementor_global_colors( 'system_colors', 2 )
				)
			);

			$repeater->add_control(
				'border_hover_color',
				 array(
					'label'   => esc_html__( 'Border Hover Color', 'wdt-elementor-addon' ),
					'type'    => \Elementor\Controls_Manager::COLOR,
					'default' => wedesigntech_elementor_global_colors( 'system_colors', 3 )
				)
			);

			$elementor_object->add_control( 'chart_data', array(
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'label'       => esc_html__('Chart Data', 'wdt-elementor-addon'),
				'fields'      => $repeater->get_controls(),
				'default' => array (
					array (
						'label' => esc_html__( 'Label A', 'plugin-name' ),
						'value' => 10,
						'background_color' => wedesigntech_elementor_global_colors( 'system_colors', 0 ),
						'background_hover_color' => wedesigntech_elementor_global_colors( 'system_colors', 1 ),
						'border_color' => wedesigntech_elementor_global_colors( 'system_colors', 2 ),
						'border_hover_color' => wedesigntech_elementor_global_colors( 'system_colors', 3 )
					),
					array (
						'label' => esc_html__( 'Label B', 'plugin-name' ),
						'value' => 20,
						'background_color' => wedesigntech_elementor_global_colors( 'system_colors', 2 ),
						'background_hover_color' => wedesigntech_elementor_global_colors( 'system_colors', 3 ),
						'border_color' => wedesigntech_elementor_global_colors( 'system_colors', 0 ),
						'border_hover_color' => wedesigntech_elementor_global_colors( 'system_colors', 1 )
					),
				),
				'title_field' => '{{{label}}}'
			) );

		$elementor_object->end_controls_section();


		$elementor_object->start_controls_section(
			'wdt_section_settings',
			array (
				'label' => esc_html__( 'Settings', 'wdt-elementor-addon' ),
			)
		);

			// Legend

			$elementor_object->add_control(
				'chart_legend_heading',
				array(
					'label'              => esc_html__( 'Legend', 'wdt-elementor-addon' ),
					'type'               => \Elementor\Controls_Manager::HEADING
				)
			);

			$elementor_object->add_control(
				'chart_legend_show',
				array(
					'label'              => esc_html__( 'Show Legend', 'wdt-elementor-addon' ),
					'type'               => \Elementor\Controls_Manager::SWITCHER,
					'frontend_available' => true,
					'default'            => 'true',
					'return_value'       => 'true'
				)
			);

			$elementor_object->add_control(
				'chart_legend_position',
				array(
					'label'   => esc_html__( 'Position', 'wdt-elementor-addon' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => 'top',
					'options' => array(
						'top'    => esc_html__( 'Top', 'wdt-elementor-addon' ),
						'left'   => esc_html__( 'Left', 'wdt-elementor-addon' ),
						'bottom' => esc_html__( 'Bottom', 'wdt-elementor-addon' ),
						'right'  => esc_html__( 'Right', 'wdt-elementor-addon' ),
					),
				)
			);

			$elementor_object->add_control(
				'chart_legend_alignment',
				array(
					'label'   => esc_html__( 'Alignment', 'wdt-elementor-addon' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => '',
					'options' => array(
						''       => esc_html__( 'Default', 'wdt-elementor-addon' ),
						'start'  => esc_html__( 'Start', 'wdt-elementor-addon' ),
						'center' => esc_html__( 'Center', 'wdt-elementor-addon' ),
						'end'    => esc_html__( 'End', 'wdt-elementor-addon' ),
					),
				)
			);

			$elementor_object->add_control(
				'chart_legend_reverse',
				array(
					'label'              => esc_html__( 'Reverse Legend', 'wdt-elementor-addon' ),
					'type'               => \Elementor\Controls_Manager::SWITCHER,
					'frontend_available' => true,
					'default'            => '',
					'return_value'       => 'true'
				)
			);

			// Tooltip

			$elementor_object->add_control(
				'chart_tooltip_heading',
				array(
					'label'     => esc_html__( 'Tooltip', 'wdt-elementor-addon' ),
					'type'      => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before'
				)
			);

			$elementor_object->add_control(
				'chart_tooltip_enable',
				array(
					'label'              => esc_html__( 'Enable Tooltip', 'wdt-elementor-addon' ),
					'type'               => \Elementor\Controls_Manager::SWITCHER,
					'frontend_available' => true,
					'default'            => 'true',
					'return_value'       => 'true'
				)
			);


			// Animation

			$elementor_object->add_control(
				'chart_animation_heading',
				array(
					'label'     => esc_html__( 'Animation', 'wdt-elementor-addon' ),
					'type'      => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before'
				)
			);

			$elementor_object->add_control(
				'chart_animation_enable',
				array(
					'label'              => esc_html__( 'Enable Animation', 'wdt-elementor-addon' ),
					'type'               => \Elementor\Controls_Manager::SWITCHER,
					'frontend_available' => true,
					'default'            => 'true',
					'return_value'       => 'true'
				)
			);

			$animation_easing = array(
				'linear',
				'easeInQuad',
				'easeOutQuad',
				'easeInOutQuad',
				'easeInCubic',
				'easeOutCubic',
				'easeInOutCubic',
				'easeInQuart',
				'easeOutQuart',
				'easeInOutQuart',
				'easeInQuint',
				'easeOutQuint',
				'easeInOutQuint',
				'easeInSine',
				'easeOutSine',
				'easeInOutSine',
				'easeInExpo',
				'easeOutExpo',
				'easeInOutExpo',
				'easeInCirc',
				'easeOutCirc',
				'easeInOutCirc',
				'easeInElastic',
				'easeOutElastic',
				'easeInOutElastic',
				'easeInBack',
				'easeOutBack',
				'easeInOutBack',
				'easeInBounce',
				'easeOutBounce',
				'easeInOutBounce',
			);

			$elementor_object->add_control(
				'chart_animation_easing',
				array(
					'label'   => esc_html__( 'Easing', 'wdt-elementor-addon' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => 'easeOutQuart',
					'options' => array_combine( $animation_easing, $animation_easing )
				)
			);

			$elementor_object->add_control(
				'chart_animation_duration',
				array(
					'label'       => esc_html__( 'Duration', 'wdt-elementor-addon' ),
					'type'        => \Elementor\Controls_Manager::SLIDER,
					'size_units'  => array( 'ms' ),
					'range' => array(
						'ms' => array(
							'min' => 100,
							'max' => 3000,
						),
					),
					'default' => array(
						'size' => 1000,
						'unit' => 'ms'
					),
				)
			);

			$elementor_object->add_control(
				'chart_animation_scale',
				array(
					'label'              => esc_html__( 'Animation Scale', 'wdt-elementor-addon' ),
					'type'               => \Elementor\Controls_Manager::SWITCHER,
					'frontend_available' => true,
					'default'            => 'true',
					'return_value'       => 'true'
				)
			);

		$elementor_object->end_controls_section();


		// Chart Style
			$this->cc_style->get_style_controls($elementor_object, array (
				'slug' => 'chart',
				'title' => esc_html__( 'Chart', 'wdt-elementor-addon' ),
				'styles' => array (
					'alignment' => array (
						'field_type' => 'alignment',
                        'control_type' => 'responsive',
						'selector' => array (
							'{{WRAPPER}} .wdt-chart-container' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
						),
						'condition' => array ()
					),
					'width' => array (
						'field_type' => 'width',
						'default' => array (
							'size' => 100,
							'unit' => '%'
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
							)
						),
						'selector' => array (
							'{{WRAPPER}} .wdt-chart-container .wdt-chart-container-inner' => 'width: {{SIZE}}{{UNIT}};',
						),
						'condition' => array ()
					),
					'slider' => array (
						'field_type' => 'slider',
						'unique_key' => 'cutout_percentage',
						'label' => esc_html__( 'Cutout Percentage', 'wdt-elementor-addon' ),
						'default' => array (
							'size' => 50,
							'unit' => '%'
						),
						'size_units' => array ( '%' ),
						'range' => array (
							'%' => array (
								'min' => 0,
								'max' => 100,
							)
						),
						'condition' => array (
							'chart_type' => 'doughnut'
						)
					),
					'number_border_width' => array (
						'field_type' => 'number',
						'unique_key' => 'border_width',
						'label' => esc_html__( 'Border Width', 'elementor' ),
						'min' => 1,
						'max' => 100,
						'default' => 2,
						'condition' => array ()
					),
					'number_border_hover_width' => array (
						'field_type' => 'number',
						'unique_key' => 'border_hover_width',
						'label' => esc_html__( 'Border Hover Width', 'elementor' ),
						'min' => 1,
						'max' => 100,
						'default' => 4,
						'condition' => array ()
					)
				)
			));

		// Legend Style
			$this->cc_style->get_style_controls($elementor_object, array (
				'slug' => 'legend',
				'title' => esc_html__( 'Legend', 'wdt-elementor-addon' ),
				'styles' => array (
					'width' => array (
						'field_type' => 'width',
						'default' => array (
							'size' => 40,
							'unit' => '%'
						),
						'size_units' => array ( '%' ),
						'range' => array (
							'%' => array (
								'min' => 1,
								'max' => 100,
							)
						),
						'condition' => array ()
					),
					'height' => array (
						'field_type' => 'height',
						'default' => array (
							'size' => 14,
							'unit' => '%'
						),
						'size_units' => array ( '%' ),
						'range' => array (
							'%' => array (
								'min' => 1,
								'max' => 100,
							)
						),
						'condition' => array ()
					),
					'margin' => array (
						'field_type' => 'slider',
						'unique_key' => 'margin',
						'label' => esc_html__( 'Margin', 'wdt-elementor-addon' ),
						'default' => array (
							'size' => 10,
							'unit' => '%'
						),
						'size_units' => array ( '%' ),
						'range' => array (
							'%' => array (
								'min' => 1,
								'max' => 100,
							)
						),
						'condition' => array ()
					),
					'font' => array (
						'field_type' => 'font',
						'condition' => array ()
					),
					'font_size' => array (
						'field_type' => 'font_size',
						'default' => array (
							'size' => 14,
							'unit' => 'px'
						),
						'condition' => array ()
					),
					'color' => array (
						'field_type' => 'color',
						'condition' => array ()
					),
					'select' => array (
						'field_type' => 'select',
						'unique_key' => 'font_weight',
						'label' => esc_html__( 'Font Weight', 'wdt-elementor-addon' ),
						'options' =>  array (
							100 => esc_html__( 'Thin (100)', 'wdt-elementor-addon' ),
							200 => esc_html__( 'Extra Light (200)', 'wdt-elementor-addon' ),
							300 => esc_html__( 'Light (300)', 'wdt-elementor-addon' ),
							400 => esc_html__( 'Normal (400)', 'wdt-elementor-addon' ),
							500 => esc_html__( 'Medium (500)', 'wdt-elementor-addon' ),
							600 => esc_html__( 'Semi Bold (600)', 'wdt-elementor-addon' ),
							700 => esc_html__( 'Bold (700)', 'wdt-elementor-addon' ),
							800 => esc_html__( 'Extra Bold (800)', 'wdt-elementor-addon' ),
							900 => esc_html__( 'Black (900)', 'wdt-elementor-addon' )
						),
						'condition' => array ()
					),
				)
			));

		// Tooltip Style
			$this->cc_style->get_style_controls($elementor_object, array (
				'slug' => 'tooltip',
				'title' => esc_html__( 'Tooltip', 'wdt-elementor-addon' ),
				'styles' => array (
					'color_background' => array (
						'field_type' => 'color',
						'unique_key' => 'background',
						'label' => esc_html__( 'Background Color', 'wdt-elementor-addon' ),
						'condition' => array ()
					),
					'padding' => array (
						'field_type' => 'slider',
						'unique_key' => 'padding',
						'label' => esc_html__( 'Padding', 'wdt-elementor-addon' ),
						'default' => array (
							'size' => 6,
							'unit' => '%'
						),
						'size_units' => array ( '%' ),
						'range' => array (
							'%' => array (
								'min' => 1,
								'max' => 100,
							)
						),
						'condition' => array ()
					),
					'padding_inner' => array (
						'field_type' => 'slider',
						'unique_key' => 'inner_padding',
						'label' => esc_html__( 'Space btw Text & Color Box', 'wdt-elementor-addon' ),
						'default' => array (
							'size' => 1,
							'unit' => '%'
						),
						'size_units' => array ( '%' ),
						'range' => array (
							'%' => array (
								'min' => 1,
								'max' => 100,
							)
						),
						'condition' => array ()
					),
					'font' => array (
						'field_type' => 'font',
						'condition' => array ()
					),
					'font_size' => array (
						'field_type' => 'font_size',
						'default' => array (
							'size' => 14,
							'unit' => 'px'
						),
						'condition' => array ()
					),
					'color' => array (
						'field_type' => 'color',
						'label' => esc_html__( 'Font Color', 'wdt-elementor-addon' ),
						'condition' => array ()
					),
					'select_font_weight' => array (
						'field_type' => 'select',
						'unique_key' => 'font_weight',
						'label' => esc_html__( 'Font Weight', 'wdt-elementor-addon' ),
						'options' =>  array (
							100 => esc_html__( 'Thin (100)', 'wdt-elementor-addon' ),
							200 => esc_html__( 'Extra Light (200)', 'wdt-elementor-addon' ),
							300 => esc_html__( 'Light (300)', 'wdt-elementor-addon' ),
							400 => esc_html__( 'Normal (400)', 'wdt-elementor-addon' ),
							500 => esc_html__( 'Medium (500)', 'wdt-elementor-addon' ),
							600 => esc_html__( 'Semi Bold (600)', 'wdt-elementor-addon' ),
							700 => esc_html__( 'Bold (700)', 'wdt-elementor-addon' ),
							800 => esc_html__( 'Extra Bold (800)', 'wdt-elementor-addon' ),
							900 => esc_html__( 'Black (900)', 'wdt-elementor-addon' )
						),
						'condition' => array ()
					),
					'select_font_style' => array (
						'field_type' => 'select',
						'unique_key' => 'font_style',
						'label' => esc_html__( 'Font Style', 'wdt-elementor-addon' ),
						'options' =>  array (
							''        => esc_html__( 'Default', 'wdt-elementor-addon' ),
							'normal'  => esc_html__( 'Normal', 'wdt-elementor-addon' ),
							'italic'  => esc_html__( 'Italic', 'wdt-elementor-addon' ),
							'oblique' => esc_html__( 'Oblique', 'wdt-elementor-addon' ),
						),
						'condition' => array ()
					),
				)
			));


	}

	public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}

		$chart_settings = array();

		$chart_labels = $chart_values = $chart_bg_colors = $chart_bg_hover_colors = $chart_br_colors = $chart_br_hover_colors = array();
		if(is_array($settings['chart_data']) && !empty($settings['chart_data'])) {
			foreach($settings['chart_data'] as $chart_data) {
				array_push($chart_labels, $chart_data['label']);
				array_push($chart_values, $chart_data['value']);
				array_push($chart_bg_colors, $chart_data['background_color']);
				array_push($chart_bg_hover_colors, $chart_data['background_hover_color']);
				array_push($chart_br_colors, $chart_data['border_color']);
				array_push($chart_br_hover_colors, $chart_data['border_hover_color']);
			}
		}


		// Chart
		$chart_settings['chartType'] = $settings['chart_type'];
		$chart_settings['chartData'] = array (
			'labels' => $chart_labels,
			'datasets' => array (
				array (
					'data' => $chart_values,
					'backgroundColor' => $chart_bg_colors,
					'hoverBackgroundColor' => $chart_bg_hover_colors,
					'borderColor' => $chart_br_colors,
					'hoverBorderColor' => $chart_br_hover_colors,
					'borderWidth' => $settings['chart_border_width'],
					'hoverBorderWidth' => $settings['chart_border_hover_width']
				)
			)
		);

		// Legends
		$chart_settings['chartLegend'] = array (
			'display' => filter_var($settings['chart_legend_show'], FILTER_VALIDATE_BOOLEAN),
			'position' => isset($settings['chart_legend_position']) ? $settings['chart_legend_position'] : 'top',
			'align' => isset($settings['chart_legend_alignment']) ? $settings['chart_legend_alignment'] : '',
			'reverse'  => filter_var($settings['chart_legend_reverse'], FILTER_VALIDATE_BOOLEAN),
			'labels' => array (
				'boxWidth' => (isset($settings['legend_width']['size']) && !empty($settings['legend_width']['size'])) ? $settings['legend_width']['size'] : 40,
				'boxHeight' => (isset($settings['legend_height']['size']) && !empty($settings['legend_height']['size'])) ? $settings['legend_height']['size'] : 14,
				'padding' => (isset($settings['legend_margin']['size']) && !empty($settings['legend_margin']['size'])) ? $settings['legend_margin']['size'] : 10,
				'color' => (isset($settings['legend_color']) && !empty($settings['legend_color'])) ? $settings['legend_color'] : '',
				'font' => array (
					'family' => (isset($settings['legend_font']) && !empty($settings['legend_font'])) ? $settings['legend_font'] : '',
					'size' => (isset($settings['legend_font_size']['size']) && !empty($settings['legend_font_size']['size'])) ? $settings['legend_font_size']['size'] : 14,
					'weight' => (isset($settings['legend_font_weight']) && !empty($settings['legend_font_weight'])) ? $settings['legend_font_weight'] : '',
				)
			)
		);

		// Tooltip
		$chart_settings['chartTooltip'] = array (
			'enabled' => filter_var($settings['chart_tooltip_enable'], FILTER_VALIDATE_BOOLEAN),
			'backgroundColor' => (isset($settings['tooltip_background_color']) && !empty($settings['tooltip_background_color'])) ? $settings['tooltip_background_color'] : 'rgba(0, 0, 0, 0.8)',
			'bodyColor' => (isset($settings['tooltip_color']) && !empty($settings['tooltip_color'])) ? $settings['tooltip_color'] : '',
			'padding' => (isset($settings['tooltip_padding']['size']) && !empty($settings['tooltip_padding']['size'])) ? $settings['tooltip_padding']['size'] : 6,
			'boxPadding' => (isset($settings['tooltip_inner_padding']['size']) && !empty($settings['tooltip_inner_padding']['size'])) ? $settings['tooltip_inner_padding']['size'] : 1,
			'bodyFont' => array (
				'family' => (isset($settings['tooltip_font']) && !empty($settings['tooltip_font'])) ? $settings['tooltip_font'] : '',
				'size' => (isset($settings['tooltip_font_size']['size']) && !empty($settings['tooltip_font_size']['size'])) ? $settings['tooltip_font_size']['size'] : 14,
				'weight' => (isset($settings['tooltip_font_weight']) && !empty($settings['tooltip_font_weight'])) ? $settings['tooltip_font_weight'] : '',
				'style' => (isset($settings['tooltip_font_style']) && !empty($settings['tooltip_font_style'])) ? $settings['tooltip_font_style'] : '',
			)
		);

		// Animation
		$chart_animation_enable = filter_var($settings['chart_animation_enable'], FILTER_VALIDATE_BOOLEAN);
		if($chart_animation_enable) {
			$chart_settings['chartAnimation'] = array (
				'duration' => isset($settings['chart_animation_duration']['size']) ? $settings['chart_animation_duration']['size'] : 1000,
				'easing' => isset($settings['chart_animation_easing']) ? $settings['chart_animation_easing'] : 'easeInQuad',
				'animateScale'  => filter_var($settings['chart_animation_scale'], FILTER_VALIDATE_BOOLEAN)
			);
		} else{
			$chart_settings['chartAnimation'] = false;
		}

		$chart_settings['chartCutoutPercentage'] = isset($settings['chart_cutout_percentage']['size']) ? $settings['chart_cutout_percentage']['size'].'%' : 0;
		$chart_settings['moduleId'] = 'wdt-chart-canvas-'.$widget_object->get_id();

        // Resposnive Settings

            $responsive_datas = array ();
            $active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();
            $breakpoint_keys = array_keys($active_breakpoints);

            foreach($breakpoint_keys as $breakpoint) {

                // Legend Width
                    $legend_width_str = 'legend_width_'.$breakpoint;
                    $responsive_datas['legend_width'][$breakpoint] = (isset($settings[$legend_width_str]['size']) && !empty($settings[$legend_width_str]['size'])) ? $settings[$legend_width_str]['size'] : $settings['legend_width']['size'];

                // Legend Height
                    $legend_height_str = 'legend_height_'.$breakpoint;
                    $responsive_datas['legend_height'][$breakpoint] = (isset($settings[$legend_height_str]['size']) && !empty($settings[$legend_height_str]['size'])) ? $settings[$legend_height_str]['size'] : $settings['legend_height']['size'];

                // Legend Margin
                    $legend_margin_str = 'legend_margin_'.$breakpoint;
                    $responsive_datas['legend_margin'][$breakpoint] = (isset($settings[$legend_margin_str]['size']) && !empty($settings[$legend_margin_str]['size'])) ? $settings[$legend_margin_str]['size'] : $settings['legend_margin']['size'];

                // Legend Font Size
                    $legend_font_size_str = 'legend_font_size_'.$breakpoint;
                    $responsive_datas['legend_font_size'][$breakpoint] = (isset($settings[$legend_font_size_str]['size']) && !empty($settings[$legend_font_size_str]['size'])) ? $settings[$legend_font_size_str]['size'] : $settings['legend_font_size']['size'];


                // Tooltip Padding
                    $tooltip_padding_str = 'tooltip_padding_'.$breakpoint;
                    $responsive_datas['tooltip_padding'][$breakpoint] = (isset($settings[$tooltip_padding_str]['size']) && !empty($settings[$tooltip_padding_str]['size'])) ? $settings[$tooltip_padding_str]['size'] : $settings['tooltip_padding']['size'];

                // Tooltip Box Padding
                    $tooltip_inner_padding_str = 'tooltip_inner_padding_'.$breakpoint;
                    $responsive_datas['tooltip_box_padding'][$breakpoint] = (isset($settings[$tooltip_inner_padding_str]['size']) && !empty($settings[$tooltip_inner_padding_str]['size'])) ? $settings[$tooltip_inner_padding_str]['size'] : $settings['tooltip_inner_padding']['size'];

                // Tooltip Font Size
                    $tooltip_font_size_str = 'tooltip_font_size_'.$breakpoint;
                    $responsive_datas['tooltip_font_size'][$breakpoint] = (isset($settings[$tooltip_font_size_str]['size']) && !empty($settings[$tooltip_font_size_str]['size'])) ? $settings[$tooltip_font_size_str]['size'] : $settings['tooltip_font_size']['size'];

            }

            // For Desktop
                // Legends
                    $responsive_datas['legend_width']['desktop'] = $settings['legend_width']['size'];
                    $responsive_datas['legend_height']['desktop'] = $settings['legend_height']['size'];
                    $responsive_datas['legend_margin']['desktop'] = $settings['legend_margin']['size'];
                    $responsive_datas['legend_font_size']['desktop'] = $settings['legend_font_size']['size'];

                // Tooltips
                    $responsive_datas['tooltip_padding']['desktop'] = $settings['tooltip_padding']['size'];
                    $responsive_datas['tooltip_box_padding']['desktop'] = $settings['tooltip_inner_padding']['size'];
                    $responsive_datas['tooltip_font_size']['desktop'] = $settings['tooltip_font_size']['size'];

            $chart_settings['responsiveData'] = $responsive_datas;

		$chart_settings_attr = wp_json_encode($chart_settings);

        $output = '';

        if((isset($settings['legend_font']) && !empty($settings['legend_font']))) {
            $output .= '<link href="https://fonts.googleapis.com/css?family='.esc_attr($settings['legend_font']).'" rel="stylesheet"> ';
        }
        if((isset($settings['tooltip_font']) && !empty($settings['tooltip_font']))) {
            $output .= '<link href="https://fonts.googleapis.com/css?family='.esc_attr($settings['tooltip_font']).'" rel="stylesheet"> ';
        }

		$output .= '<div class="wdt-chart-container" data-chart-settings="'.esc_js($chart_settings_attr).'">
                        <div class="wdt-chart-container-inner">
                            <canvas class="wdt-chart-canvas '.esc_attr($chart_settings['moduleId']).'"></canvas>
                        </div>
                    </div>';

		return $output;

	}

}

if( !function_exists( 'wedesigntech_widget_base_chart' ) ) {
    function wedesigntech_widget_base_chart() {
        return WeDesignTech_Widget_Base_Chart::instance();
    }
}