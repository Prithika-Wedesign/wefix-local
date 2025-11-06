<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Counter {

	private static $_instance = null;

	private $cc_repeater_contents;
	private $cc_content_position;
	private $cc_layout;
	private $cc_style;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	function __construct() {

		// Options
			$options_group = array( 'default' );
			$options['default'] = array(
				'icon'          => esc_html__( 'Icon', 'wdt-elementor-addon'),
				'title'         => esc_html__( 'Title', 'wdt-elementor-addon'),
				'sub_title'     => esc_html__( 'Sub Title', 'wdt-elementor-addon'),
				'description'   => esc_html__( 'Description', 'wdt-elementor-addon'),
				'custom'      => array (
					'title' => esc_html__( 'Pricing', 'wdt-elementor-addon'),
					'control_action' => 'wdt_widgets_custom_counter_control',
					'render_filter' => 'wdt_widgets_custom_counter_html_render',
				)
			);

		// Group 1 content positions
			$group1_content_position_elements = array(
				'icon'          => esc_html__( 'Icon', 'wdt-elementor-addon'),
				'title_sub_title' => esc_html__( 'Title and Sub Title', 'wdt-elementor-addon'),
				'custom'          => esc_html__( 'Counter', 'wdt-elementor-addon'),
				'title'           => esc_html__( 'Title', 'wdt-elementor-addon'),
				'sub_title'       => esc_html__( 'Sub Title', 'wdt-elementor-addon')
			);
			$group1_content_positions = wedesigntech_elementor_format_repeater_values($group1_content_position_elements);

		// Group 2 content positions
			$group2_content_position_elements = array(
				'title_sub_title' => esc_html__( 'Title and Sub Title', 'wdt-elementor-addon'),
				'description'     => esc_html__( 'Description', 'wdt-elementor-addon'),
				'elements_group'  => esc_html__( 'Elements Group', 'wdt-elementor-addon'),
				'custom'          => esc_html__( 'Counter', 'wdt-elementor-addon')
			);
			$group2_content_positions = wedesigntech_elementor_format_repeater_values($group2_content_position_elements);

		// Content position elements
			$content_position_elements = array_merge($group1_content_position_elements, $group2_content_position_elements);

		// Module defaults
			$option_defaults = array(
				array(
					'item_type' => 'default',
					'media_icon' => array (
						'value' => 'far fa-paper-plane',
						'library' => 'fa-regular'
					),
					'item_title' => esc_html__( 'Ut accumsan mass', 'wdt-elementor-addon' ),
					'item_sub_title' => esc_html__( 'Accumsan mass', 'wdt-elementor-addon' ),
					'item_description' => esc_html__( 'Donec sit amet turpis tincidunt eros, nam porttitor massa leo porta maecenas reque.', 'wdt-elementor-addon' )
				),
				array(
					'item_type' => 'default',
					'media_icon' => array (
						'value' => 'far fa-paper-plane',
						'library' => 'fa-regular'
					),
					'item_title' => esc_html__( 'Pellentesque ornare', 'wdt-elementor-addon' ),
					'item_sub_title' => esc_html__( 'Tesque ornare', 'wdt-elementor-addon' ),
					'item_description' => esc_html__( 'Donec sit amet turpis tincidunt eros, nam porttitor massa leo porta maecenas reque.', 'wdt-elementor-addon' )
				)
			);

		// Module Details
			$module_details = array(
				'content_positions'    => array ( 'group1', 'group1_element_group', 'group2', 'group2_element_group', 'title_subtitle_position'),
				'group1_title'         => esc_html__( 'Media Group', 'wdt-elementor-addon'),
				'group2_title'         => esc_html__( 'Content Group', 'wdt-elementor-addon'),
				'group_cp_label'       => esc_html__( 'Content Positions', 'wdt-elementor-addon'),
				'group_eg_cp_label'    => esc_html__( 'Element Group - Content Positions', 'wdt-elementor-addon'),
				'jsSlug'               => 'wdtRepeaterCounterContent',
				'title'                => esc_html__( 'Counter Items', 'wdt-elementor-addon' ),
				'icon_default_library' => array (
					'value'               => 'far fa-paper-plane',
					'library'             => 'fa-regular'
				),
				'description'          => ''
			);

		// Initialize depandant class
			$this->cc_repeater_contents = new WeDesignTech_Common_Controls_Repeater_Contents($options_group, $options, $option_defaults, $module_details);
			$this->cc_layout = new WeDesignTech_Common_Controls_Layout('both');
			$this->cc_style = new WeDesignTech_Common_Controls_Style();

		// Actions
			add_action('wdt_widgets_custom_counter_control', array ( $this, 'wdt_widgets_custom_counter_control_register' ), 10, 1);
			add_filter('wdt_widgets_custom_counter_html_render', array ( $this, 'wdt_widgets_custom_counter_html_render_register' ), 10, 7);


	}

	public function name() {
		return 'wdt-counter';
	}

	public function title() {
		return esc_html__( 'Counter', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'wdt-widget-icon';
	}

	public function init_styles() {
		return array_merge(
			$this->cc_layout->init_styles(),
			$this->cc_repeater_contents->init_styles(),
			array (
				$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/counter/assets/css/style.css'
			)
		);
	}

	public function init_inline_styles() {
		if(!\Elementor\Plugin::$instance->preview->is_preview_mode()) {
			return array (
				$this->name() => $this->cc_layout->get_column_css()
			);
		}
		return array ();
	}

	public function init_scripts() {
		return array_merge(
			$this->cc_layout->init_scripts(),
			array (
				'jquery-countTo' => WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'inc/widgets/counter/assets/js/jquery.countTo.js',
				$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'inc/widgets/counter/assets/js/script.js'
			)
		);
	}

	public function create_elementor_controls($elementor_object) {

		$this->cc_repeater_contents->get_controls($elementor_object);
		$this->cc_layout->get_controls($elementor_object);

		$elementor_object->start_controls_section( 'wdt_section_settings', array(
			'label' => esc_html__( 'Settings', 'wdt-elementor-addon'),
		));

			$elementor_object->add_control( 'template', array(
				'label'   => esc_html__( 'Template', 'wdt-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT2,
				'default' => 'default',
				'options' => array(
					'default'  => esc_html__( 'Default', 'wdt-elementor-addon' ),
					'standard' => esc_html__( 'Standard', 'wdt-elementor-addon' )
				)
			) );

		$elementor_object->end_controls_section();

		// Item
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'item',
			'title' => esc_html__( 'Item', 'wdt-elementor-addon' ),
			'styles' => array (
				'alignment' => array (
					'field_type' => 'alignment',
                    'control_type' => 'responsive',
                    'default' => 'center',
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item' => 'text-align: {{VALUE}}; justify-content: {{VALUE}};'
					),
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-content-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'tabs' => array (
					'field_type' => 'tabs',
					'tab_items' => array (
						'normal' => array (
							'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
							'styles' => array (
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-content-item',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-content-item',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-content-item',
									'condition' => array ()
								)
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover',
									'condition' => array ()
								)
							)
						)
					)
				)
			)
		));

		// Title
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'title',
			'title' => esc_html__( 'Title', 'wdt-elementor-addon' ),
			'styles' => array (
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-title h5',
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-content-item .wdt-content-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'tabs' => array (
					'field_type' => 'tabs',
					'tab_items' => array (
						'normal' => array (
							'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item .wdt-content-title h5, 
										 {{WRAPPER}} .wdt-content-item .wdt-content-title h5 > a' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item:hover .wdt-content-title h5, 
										 {{WRAPPER}} .wdt-content-item:hover .wdt-content-title h5 > a:hover' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
							)
						)
					)
				)
			)
		));

		// Sub Title
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'sub_title',
			'title' => esc_html__( 'Sub Title', 'wdt-elementor-addon' ),
			'styles' => array (
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-subtitle',
					'condition' => array ()
				),
				'color' => array (
					'field_type' => 'color',
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item .wdt-content-subtitle' => 'color: {{VALUE}};'
					),
					'condition' => array ()
				)
			)
		));

		// Icon
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'icon',
			'title' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
			'styles' => array (
				'font_size' => array (
					'field_type' => 'font_size',
					'selector' => array (
                        '{{WRAPPER}} .wdt-content-item .wdt-content-icon-wrapper .wdt-content-icon span' => 'font-size: {{SIZE}}{{UNIT}};'
                    ),
					'condition' => array ()
				),
				'width' => array (
					'field_type' => 'width',
					'default' => array (
						'unit' => 'px'
					),
					'size_units' => array ( 'px' ),
					'range' => array (
                        'px' => array (
                            'min' => 10,
                            'max' => 500,
                        )
                    ),
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item .wdt-content-icon-wrapper .wdt-content-icon span' => 'width: {{SIZE}}{{UNIT}};'
					)
				),
				'height' => array (
					'field_type' => 'height',
					'default' => array (
						'unit' => 'px'
					),
					'size_units' => array ( 'px' ),
					'range' => array (
                        'px' => array (
                            'min' => 10,
                            'max' => 500,
                        )
                    ),
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item .wdt-content-icon-wrapper .wdt-content-icon span' => 'height: {{SIZE}}{{UNIT}};'
					)
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-content-item .wdt-content-icon-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item .wdt-content-icon-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'tabs_default' => array (
					'field_type' => 'tabs',
					'unique_key' => 'default',
					'tab_items' => array (
						'normal' => array (
							'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item .wdt-content-icon-wrapper .wdt-content-icon span' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-icon-wrapper .wdt-content-icon span',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-icon-wrapper .wdt-content-icon span',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}}  .wdt-content-item .wdt-content-icon-wrapper .wdt-content-icon span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-icon-wrapper .wdt-content-icon span',
									'condition' => array ()
								)
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item:hover .wdt-content-icon-wrapper .wdt-content-icon span' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover .wdt-content-icon-wrapper .wdt-content-icon span',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover .wdt-content-icon-wrapper .wdt-content-icon span',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item:hover .wdt-content-icon-wrapper .wdt-content-icon span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover .wdt-content-icon-wrapper .wdt-content-icon span',
									'condition' => array ()
								)
							)
						)
					)
				)
			)
		));

		// Counter
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'counter',
			'title' => esc_html__( 'Counter', 'wdt-elementor-addon' ),
			'styles' => array (
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-counter-wrapper .wdt-content-counter',
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-content-item .wdt-content-counter-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item .wdt-content-counter-wrapper .wdt-content-counter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'tabs_default' => array (
					'field_type' => 'tabs',
					'unique_key' => 'default',
					'tab_items' => array (
						'normal' => array (
							'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item .wdt-content-counter-wrapper .wdt-content-counter' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-counter-wrapper .wdt-content-counter',
									'color_selector' => array (
                                        '{{WRAPPER}} .wdt-content-item .wdt-content-counter-wrapper .wdt-content-counter' => 'background-color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-counter-wrapper .wdt-content-counter',
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-counter-wrapper .wdt-content-counter',
									'condition' => array ()
								)
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item:hover .wdt-content-counter-wrapper .wdt-content-counter' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover .wdt-content-counter-wrapper .wdt-content-counter',
									'color_selector' => array (
										'{{WRAPPER}} .wdt-content-item:hover .wdt-content-counter-wrapper .wdt-content-counter' => 'background-color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover .wdt-content-counter-wrapper .wdt-content-counter',
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover .wdt-content-counter-wrapper .wdt-content-counter',
									'condition' => array ()
								)
							)
						)
					)
				)
			)
		));

		// Description
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'description',
			'title' => esc_html__( 'Description', 'wdt-elementor-addon' ),
			'styles' => array (
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-description',
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-content-item .wdt-content-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item .wdt-content-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'color' => array (
					'field_type' => 'color',
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item .wdt-content-description' => 'color: {{VALUE}};'
					),
					'condition' => array ()
				)
			)
		));

		// Arrow
		$this->cc_layout->get_carousel_style_controls($elementor_object, array ('layout' => 'carousel'));

	}

	public function wdt_widgets_custom_counter_control_register($elementor_object) {

		$elementor_object->add_control(
			'counter_heading',
			array (
				'label' => esc_html__( 'Numbers', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before'
			)
		);

		$elementor_object->add_control(
			'start_digit',
			 array(
				'label'   => esc_html__( 'Start Digit', 'wdt-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'default' => 0
			)
		);

		$elementor_object->add_control(
			'end_digit',
			 array(
				'label' => esc_html__( 'End Digit', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'default' => 100
			)
		);

		$elementor_object->add_control(
			'speed',
			 array(
				'label' => esc_html__( 'Speed', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'default' => 1000
			)
		);

		$elementor_object->add_control(
			'refresh_interval',
			 array(
				'label' => esc_html__( 'Refresh Interval', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'default' => 100,
				'description' => esc_html__('How often the element should be updated', 'wdt-elementor-addon')
			)
		);

		$elementor_object->add_control(
			'prefix',
			array(
				'type'      => \Elementor\Controls_Manager::TEXT,
				'label'     => esc_html__('Prefix', 'wdt-elementor-addon')
			)
		);

		$elementor_object->add_control(
			'suffix',
			array(
				'type'      => \Elementor\Controls_Manager::TEXT,
				'label'     => esc_html__('Suffix', 'wdt-elementor-addon')
			)
		);

	}

	public function wdt_widgets_custom_counter_html_render_register($output, $widget_object, $key, $item, $link_start, $link_end, $settings) {
		$output .= '<div class="wdt-content-counter-wrapper">';
			$output .= '<div class="wdt-content-counter">';
				if($item['prefix'] != '') {
					$output .= '<span class="wdt-content-counter-prefix">'.esc_attr($item['prefix']).'</span>';
				}
				$output .= '<span class="wdt-content-counter-number" data-from="'.esc_attr($item['start_digit']).'" data-to="'.esc_attr($item['end_digit']).'" data-speed="'.esc_attr($item['speed']).'" data-refresh-interval="'.esc_attr($item['refresh_interval']).'"></span>';
				if($item['suffix'] != '') {
					$output .= '<span class="wdt-content-counter-suffix">'.esc_attr($item['suffix']).'</span>';
				}
			$output .= '</div>';
		$output .= '</div>';
		return $output;
	}

	public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}

		$output = '';

		if( count( $settings['item_contents'] ) > 0 ):

			$classes = array ();
			array_push($classes, 'wdt-rc-template-'.$settings['template']);

			$settings['module_id'] = $widget_object->get_id();
			$settings['module_class'] = 'counter';
			$settings['classes'] = $classes;
			$this->cc_layout->set_settings($settings);
			$settings['module_layout_class'] = $this->cc_layout->get_item_class();

			$output .= $this->cc_layout->get_wrapper_start();
				if($settings['template'] == 'default') {

					$group1_content_position_elements = array(
						'icon'  => esc_html__( 'Icon', 'wdt-elementor-addon')
					);
					$group2_content_position_elements = array(
						'custom'          => esc_html__( 'Counter', 'wdt-elementor-addon'),
						'title' 		  => esc_html__( 'Title', 'wdt-elementor-addon'),
					);

					$settings['group1_content_positions'] = wedesigntech_elementor_format_repeater_values($group1_content_position_elements);
					$settings['group2_content_positions'] = wedesigntech_elementor_format_repeater_values($group2_content_position_elements);

					$output .= $this->cc_repeater_contents->render_html($widget_object, $settings);

				} else if($settings['template'] == 'standard') {

					$group1_content_position_elements = array(
						'icon'  		  => esc_html__( 'Icon', 'wdt-elementor-addon'),
					);
					$group2_content_position_elements = array(
						'custom'          => esc_html__( 'Counter', 'wdt-elementor-addon'),
						'sub_title' 	  => esc_html__( 'Sub Title', 'wdt-elementor-addon')
					);

					$settings['group1_content_positions'] = wedesigntech_elementor_format_repeater_values($group1_content_position_elements);
					$settings['group2_content_positions'] = wedesigntech_elementor_format_repeater_values($group2_content_position_elements);

					$output .= $this->cc_repeater_contents->render_html($widget_object, $settings);

				}
				$output .= $this->cc_layout->get_column_edit_mode_css();
			$output .= $this->cc_layout->get_wrapper_end();

		else:
			$output .= '<div class="wdt-counter-container no-records">';
				$output .= esc_html__('No records found!', 'wdt-elementor-addon');
			$output .= '</div>';
		endif;

		return $output;

	}

}

if( !function_exists( 'wedesigntech_widget_base_counter' ) ) {
    function wedesigntech_widget_base_counter() {
        return WeDesignTech_Widget_Base_Counter::instance();
    }
}