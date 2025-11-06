<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Popup_Box {

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
		return 'wdt-popup-box';
	}

	public function title() {
		return esc_html__( 'Popup Box', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'wdt-widget-icon';
	}

	public function init_styles() {
		return array (
			'jquery.magnific-popup' =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/popup-box/assets/css/jquery.magnific-popup.css',
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/popup-box/assets/css/style.css'
		);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array (
			'jquery.cookie' =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/popup-box/assets/js/jquery.cookie.min.js',
			'jquery.magnific-popup' =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/popup-box/assets/js/jquery.magnific-popup.min.js',
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/popup-box/assets/js/script.js'
		);
	}

	public function create_elementor_controls($elementor_object) {

		$elementor_object->start_controls_section( 'wdt_section_content', array(
			'label' => esc_html__( 'Content', 'wdt-elementor-addon'),
		));

			$elementor_object->add_control( 'content_type', array(
				'label'   => esc_html__( 'Content Type', 'wdt-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT2,
				'default' => 'content',
				'options' => array(
					'content'  => esc_html__( 'Content', 'wdt-elementor-addon' ),
					'image'  => esc_html__( 'Image', 'wdt-elementor-addon' ),
					'link'  => esc_html__( 'Link (Video|Map|Page)', 'wdt-elementor-addon' ),
					'template' => esc_html__( 'Template', 'wdt-elementor-addon' ),
				)
			));

			$elementor_object->add_control( 'content_description', array(
				'label'       => esc_html__( 'Your Content', 'wdt-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::WYSIWYG,
				'label_block' => true,
				'placeholder' => esc_html__( 'Your description goes here', 'wdt-elementor-addon' ),
				'default'     => 'Sed ut perspiciatis unde omnis iste natus error sit, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae.',
				'condition'   => array (
					'content_type' => 'content'
				)
			));

			$elementor_object->add_control( 'content_image', array(
				'label'       => esc_html__( 'Image', 'wdt-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'label_block' => true,
				'default' => array (
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
				'condition'   => array (
					'content_type' => 'image'
				)
			));

			$elementor_object->add_control( 'content_link', array(
				'label'       => esc_html__( 'URL', 'wdt-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'label_block' => true,
				'default' => array (
					'url' => 'https://www.youtube.com/watch?v=C_S2EFSju3s',
				),
				'show_external'     => false,
				'condition'   => array (
					'content_type' => 'link'
				)
			));

			$elementor_object->add_control('content_template', array(
				'label'     => esc_html__( 'Select Template', 'wdt-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => $elementor_object->get_elementor_page_list(),
				'condition' => array (
					'content_type' => 'template'
				)
			));

			$elementor_object->add_control( 'animation_type', array(
				'label'   => esc_html__( 'Animation', 'wdt-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'wdt-fade-zoom',
				'options' => array(
					'wdt-fade-zoom'  => esc_html__( 'FadeIn', 'wdt-elementor-addon' ),
					'wdt-fade-slide' => esc_html__( 'FadeIn Transform', 'wdt-elementor-addon' ),
					'wdt-right-side-slide' => esc_html__( 'Slide RTL', 'wdt-elementor-addon' ),
					'wdt-left-side-slide' => esc_html__( 'Slide LTR', 'wdt-elementor-addon' ),
					'wdt-right-side-slide-full' => esc_html__( 'Full Slide RTL', 'wdt-elementor-addon' ),
					'wdt-left-side-slide-full' => esc_html__( 'Full Slide LTR', 'wdt-elementor-addon' ),
				)
			));

		$elementor_object->end_controls_section();


		$elementor_object->start_controls_section( 'wdt_section_settings', array(
			'label' => esc_html__( 'Settings', 'wdt-elementor-addon'),
		));

			$elementor_object->add_control( 'trigger_type', array(
				'label'   => esc_html__( 'Trigger Type', 'wdt-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT2,
				'default' => 'on-click',
				'options' => array(
					'off' => esc_html( 'Disable', 'wdt-elementor-addon' ),
					'on-click'  => esc_html__( 'On Click', 'wdt-elementor-addon' ),
					'on-load' => esc_html__( 'On Load', 'wdt-elementor-addon' ),
					'external-class' => esc_html__( 'External Class', 'wdt-elementor-addon' ),
					'external-id' => esc_html__( 'External ID', 'wdt-elementor-addon' ),
				)
			));

			$elementor_object->add_control( 'on_click_heading', array(
				'label'   => esc_html__( 'On Click - Settings', 'wdt-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'trigger_type' => 'on-click'
				)
			));

			$elementor_object->add_control( 'on_click_element', array(
				'label'   => esc_html__( 'On Click - Element Type', 'wdt-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT2,
				'default' => 'label-n-icon',
				'options' => array(
					'image'  => esc_html__( 'Image', 'wdt-elementor-addon' ),
					'label' => esc_html__( 'Label', 'wdt-elementor-addon' ),
					'icon'  => esc_html__( 'Icon', 'wdt-elementor-addon' ),
					'label-n-icon' => esc_html__( 'Label + Icon', 'wdt-elementor-addon' ),
					'image-n-icon' => esc_html__( 'Image + Icon', 'wdt-elementor-addon' )
					
				),
				'condition' => array(
					'trigger_type' => 'on-click'
				)
			));

			$elementor_object->add_control( 'on_click_element_image', array(
				'label'       => esc_html__( 'Image', 'wdt-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'label_block' => true,
				'default' => array (
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
				'condition' => array(
					'trigger_type' => 'on-click',
					'on_click_element' => array ('image', 'image-n-icon'),
				)
			));

			$elementor_object->add_control( 'on_click_element_label', array(
				'label'       => esc_html__( 'Label', 'wdt-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Accumsan mass', 'wdt-elementor-addon' ),
				'placeholder' => esc_html__( 'Your label goes here', 'wdt-elementor-addon' ),
				'condition' => array(
					'trigger_type' => 'on-click',
					'on_click_element' => array ('label', 'label-n-icon'),
				)
			));

			$elementor_object->add_control( 'on_click_element_icon', array (
				'label' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => array( 'value' => 'fas fa-star', 'library' => 'fa-solid' ),
				'label_block' => true,
				'condition' => array(
					'trigger_type' => 'on-click',
					'on_click_element' => array ('icon', 'label-n-icon', 'image-n-icon'),
				)
			));

			$elementor_object->add_control( 'on_load_heading', array(
				'label'   => esc_html__( 'On Load - Settings', 'wdt-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'trigger_type' => 'on-load',
				)
			));

			$elementor_object->add_control( 'on_load_delay', array(
				'label'   => esc_html__( 'On Load Delay', 'wdt-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array(
					'ms',
				),
				'range'      => array(
					'ms' => array(
						'min'  => 0,
						'max'  => 2000,
						'step' => 100,
					),
				),
				'default' => array(
					'size' => 200,
					'unit' => 'ms',
				),
				'condition' => array(
					'trigger_type' => 'on-load',
				)
			));

			$elementor_object->add_control( 'on_load_after', array(
				'label'   => esc_html__( 'On Load After', 'wdt-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array(
					'days',
				),
				'range' => array(
					'days' => array(
						'min'  => 1,
						'max'  => 10,
						'step' => 1,
					),
				),
				'default' => array(
					'size' => 1,
					'unit' => 'days',
				),
				'condition' => array(
					'trigger_type' => 'on-load',
				)
			));

			$elementor_object->add_control( 'external_class_heading', array(
				'label'   => esc_html__( 'External Class - Settings', 'wdt-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'trigger_type' => 'external-class'
				)
			));

			$elementor_object->add_control( 'external_class', array(
				'label'       => esc_html__( 'External Class', 'wdt-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => '.external-class',
				'description' => esc_html__('Provide external class here, with dot symbol (.)', 'wdt-elementor-addon'),
				'condition' => array(
					'trigger_type' => 'external-class'
				)
			));

			$elementor_object->add_control( 'external_id_heading', array(
				'label'   => esc_html__( 'External Class - Settings', 'wdt-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'trigger_type' => 'external-id'
				)
			));

			$elementor_object->add_control( 'external_id', array(
				'label'       => esc_html__( 'External ID', 'wdt-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => '#external-id',
				'description' => esc_html__('Provide external id here, with hash symbol (#)', 'wdt-elementor-addon'),
				'condition' => array(
					'trigger_type' => 'external-id'
				)
			));

			$elementor_object->add_control( 'exit_settings_heading', array(
				'label'   => esc_html__( 'Exit - Settings', 'wdt-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before'
			));

			$elementor_object->add_control( 'show_close_Button', array(
				'label'              => esc_html__( 'Show Close Button', 'wdt-elementor-addon' ),
				'type'               => \Elementor\Controls_Manager::SWITCHER,
				'description'        => esc_html__('If you like to show close button in popup.', 'wdt-elementor-addon'),
				'frontend_available' => true,
				'default'            => 'true',
				'return_value'       => 'true'
			));

			$elementor_object->add_control( 'esc_to_exit', array(
				'label'              => esc_html__( 'Esc to Exit', 'wdt-elementor-addon' ),
				'type'               => \Elementor\Controls_Manager::SWITCHER,
				'description'        => esc_html__('Allow escape button to close popup.', 'wdt-elementor-addon'),
				'frontend_available' => true,
				'default'            => 'true',
				'return_value'       => 'true'
			));

			$elementor_object->add_control( 'click_to_exit', array(
				'label'              => esc_html__( 'Click to Exit', 'wdt-elementor-addon' ),
				'type'               => \Elementor\Controls_Manager::SWITCHER,
				'description'        => esc_html__('Click on overlay to close popup.', 'wdt-elementor-addon'),
				'frontend_available' => true,
				'default'            => 'true',
				'return_value'       => 'true'
			));

			$elementor_object->add_control( 'popup_none', array(
				'label'       => esc_html__( 'Popup None', 'wdt-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::HIDDEN,
				'default'     => '',
				'condition'   => array(
					'trigger_type' => 'off'
				)
			));

		$elementor_object->end_controls_section();

		// Trigger Element
			$this->cc_style->get_style_controls($elementor_object, array (
				'slug' => 'trigger_element',
				'title' => esc_html__( 'Trigger Element', 'wdt-elementor-addon' ),
				'condition' => array(
					'trigger_type' => 'on-click',
					'on_click_element' => array ( 'label', 'label-n-icon', 'image', 'image-n-icon' )
				),
				'styles' => array (
					'alignment' => array (
						'field_type' => 'alignment',
						'selector' => array (
							'{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
						),
						'condition' => array ()
					),
					'typography' => array (
						'field_type' => 'typography',
						'selector' => '{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element',
						'condition' => array ()
					),
					'margin' => array (
						'field_type' => 'margin',
						'selector' => array (
							'{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
						'condition' => array ()
					),
					'padding' => array (
						'field_type' => 'padding',
						'selector' => array (
							'{{WRAPPER}} .wdt-popup-box-trigger-holder:not([class*="wdt-click-element-label"]) .wdt-popup-box-trigger-element, {{WRAPPER}} .wdt-popup-box-trigger-holder[class*="wdt-click-element-label"] .wdt-popup-box-trigger-element .wdt-popup-box-trigger-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
											'{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element' => 'color: {{VALUE}};'
										),
										'condition' => array ()
									),
									'background' => array (
										'field_type' => 'background',
										'selector' => '{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element',
										'color_selector' =>  array (
											'{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element' => 'background-color: {{VALUE}};'
										),
										'condition' => array ()
									),
									'border' => array (
										'field_type' => 'border',
										'selector' => '{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element',
										'color_selector' => array (
											'{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element' => 'border-color: {{VALUE}};'
										),
										'condition' => array ()
									),
									'border_radius' => array (
										'field_type' => 'border_radius',
										'selector' => array (
											'{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
										),
										'condition' => array ()
									),
									'box_shadow' => array (
										'field_type' => 'box_shadow',
										'selector' => '{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element',
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
											'{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element:focus, {{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element:hover' => 'color: {{VALUE}};'
										),
										'condition' => array ()
									),
									'background' => array (
										'field_type' => 'background',
										'selector' => '{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element:focus, {{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element:hover',
										'color_selector' => array(
											'{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element:focus, {{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element:hover' => 'background-color: {{VALUE}};'
										),
										'condition' => array ()
									),
									'border' => array (
										'field_type' => 'border',
										'selector' => '{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element:focus, {{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element:hover',
										'color_selector' => array (
											'{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element:focus, {{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element:hover' => 'border-color: {{VALUE}};'
										),
										'condition' => array ()
									),
									'border_radius' => array (
										'field_type' => 'border_radius',
										'selector' => array (
											'{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element:focus, {{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
										),
										'condition' => array ()
									),
									'box_shadow' => array (
										'field_type' => 'box_shadow',
										'selector' => '{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element:focus, {{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element:hover',
										'condition' => array ()
									)
								)
							)
						)
					)
				)
			));

		// Trigger Element - Icon
			$this->cc_style->get_style_controls($elementor_object, array (
				'slug' => 'trigger_element_icon',
				'title' => esc_html__( 'Trigger Element - Icon', 'wdt-elementor-addon' ),
				'condition' => array(
					'trigger_type' => 'on-click',
					'on_click_element' => array ( 'icon', 'label-n-icon', 'image-n-icon' )
				),
				'styles' => array (
                    'alignment' => array (
						'field_type' => 'alignment',
						'selector' => array (
							'{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element .wdt-popup-box-trigger-icon' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
						),
						'condition' => array (
                            'on_click_element' => array ( 'icon', 'image-n-icon' ),
                            'on_click_element!' => array ( 'label-n-icon' )
                        )
					),
					'margin' => array (
						'field_type' => 'margin',
						'selector' => array (
							'{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element .wdt-popup-box-trigger-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
						'condition' => array ()
					),
					'padding' => array (
						'field_type' => 'padding',
						'selector' => array (
							'{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element .wdt-popup-box-trigger-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
						'condition' => array ()
					),
					'font_size' => array (
						'field_type' => 'font_size',
						'selector' => array (
							'{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element .wdt-popup-box-trigger-icon' => 'font-size: {{SIZE}}{{UNIT}};'
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
							'{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element .wdt-popup-box-trigger-icon' => 'width: {{SIZE}}{{UNIT}};'
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
							'{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element .wdt-popup-box-trigger-icon' => 'height: {{SIZE}}{{UNIT}};'
						)
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
											'{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element .wdt-popup-box-trigger-icon' => 'color: {{VALUE}};'
										),
										'condition' => array ()
									),
									'background' => array (
										'field_type' => 'background',
										'selector' => '{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element .wdt-popup-box-trigger-icon',
										'condition' => array ()
									),
									'border' => array (
										'field_type' => 'border',
										'selector' => '{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element .wdt-popup-box-trigger-icon',
										'condition' => array ()
									),
									'border_radius' => array (
										'field_type' => 'border_radius',
										'selector' => array (
											'{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element .wdt-popup-box-trigger-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
										),
										'condition' => array ()
									),
									'box_shadow' => array (
										'field_type' => 'box_shadow',
										'selector' => '{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element .wdt-popup-box-trigger-icon',
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
											'{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element:focus .wdt-popup-box-trigger-icon, {{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element:hover .wdt-popup-box-trigger-icon' => 'color: {{VALUE}};'
										),
										'condition' => array ()
									),
									'background' => array (
										'field_type' => 'background',
										'selector' => '{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element:focus .wdt-popup-box-trigger-icon, {{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element:hover .wdt-popup-box-trigger-icon',
										'condition' => array ()
									),
									'border' => array (
										'field_type' => 'border',
										'selector' => '{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element:focus .wdt-popup-box-trigger-icon, {{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element:hover .wdt-popup-box-trigger-icon',
										'condition' => array ()
									),
									'border_radius' => array (
										'field_type' => 'border_radius',
										'selector' => array (
											'{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element:focus .wdt-popup-box-trigger-icon, {{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element:hover .wdt-popup-box-trigger-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
										),
										'condition' => array ()
									),
									'box_shadow' => array (
										'field_type' => 'box_shadow',
										'selector' => '{{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element:focus .wdt-popup-box-trigger-icon, {{WRAPPER}} .wdt-popup-box-trigger-holder .wdt-popup-box-trigger-element:hover .wdt-popup-box-trigger-icon',
										'condition' => array ()
									)
								)
							)
						)
					)
				)
			));

		// Popup Box
			$this->cc_style->get_style_controls($elementor_object, array (
				'slug' => 'popup_box',
				'title' => esc_html__( 'Popup Box', 'wdt-elementor-addon' ),
				'condition' => array(
					'content_type' => array ( 'content', 'template' )
				),
				'styles' => array (
					'alignment' => array (
						'field_type' => 'alignment',
						'selector' => array (
							'.wdt-popup-box-window-{{ID}} .wdt-popup-box-content-holder.wdt-content-type-content, .wdt-popup-box-window-{{ID}}.wdt-popup-box-window.mfp-wrap .mfp-container.mfp-inline-holder .mfp-content .wdt-popup-box-content-holder.wdt-content-type-content' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
						),
						'condition' => array ()
					),
					'typography' => array (
						'field_type' => 'typography',
						'selector' => '.wdt-popup-box-window-{{ID}} .wdt-popup-box-content-holder.wdt-content-type-content, .wdt-popup-box-window-{{ID}}.wdt-popup-box-window.mfp-wrap .mfp-container.mfp-inline-holder .mfp-content .wdt-popup-box-content-holder.wdt-content-type-content',
						'condition' => array ()
					),
					'margin' => array (
						'field_type' => 'margin',
						'selector' => array (
							'.wdt-popup-box-window-{{ID}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
						'condition' => array ()
					),
					'padding' => array (
						'field_type' => 'padding',
						'selector' => array (
							'.wdt-popup-box-window-{{ID}} .wdt-popup-box-content-holder, .wdt-popup-box-window-{{ID}}.wdt-popup-box-window.mfp-wrap .mfp-container.mfp-inline-holder .mfp-content .wdt-popup-box-content-holder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
								'min' => 200,
								'max' => 1920,
							)
						),
						'selector' => array (
							'.wdt-popup-box-window-{{ID}} .wdt-popup-box-content-holder, .wdt-popup-box-window-{{ID}}.wdt-popup-box-window.mfp-wrap .mfp-container.mfp-inline-holder .mfp-content .wdt-popup-box-content-holder' => 'width: {{SIZE}}{{UNIT}};'
						),
						'condition' => array ()
					),
					'color' => array (
						'field_type' => 'color',
						'selector' => array (
							'.wdt-popup-box-window-{{ID}} .wdt-popup-box-content-holder.wdt-content-type-content, .wdt-popup-box-window-{{ID}}.wdt-popup-box-window.mfp-wrap .mfp-container.mfp-inline-holder .mfp-content .wdt-popup-box-content-holder.wdt-content-type-content' => 'color: {{VALUE}};'
						),
						'condition' => array ()
					),
					'background' => array (
						'field_type' => 'background',
						'selector' => '.wdt-popup-box-content-holder-{{ID}}',
						'color_selector' => array(
							'.wdt-popup-box-window-{{ID}} .wdt-popup-box-content-holder, .wdt-popup-box-window-{{ID}}.wdt-popup-box-window.mfp-wrap .mfp-container.mfp-inline-holder .mfp-content .wdt-popup-box-content-holder' => 'background-color: {{VALUE}};'
						),
						'condition' => array ()
					),
					'border' => array (
						'field_type' => 'border',
						'selector' => '.wdt-popup-box-content-holder-{{ID}}',
						'color_selector' => array (
							'.wdt-popup-box-window-{{ID}} .wdt-popup-box-content-holder, .wdt-popup-box-window-{{ID}}.wdt-popup-box-window.mfp-wrap .mfp-container.mfp-inline-holder .mfp-content .wdt-popup-box-content-holder' => 'border-color: {{VALUE}};'
						),
						'condition' => array ()
					),
					'border_radius' => array (
						'field_type' => 'border_radius',
						'selector' => array (
							'.wdt-popup-box-window-{{ID}} .wdt-popup-box-content-holder, .wdt-popup-box-window-{{ID}}.wdt-popup-box-window.mfp-wrap .mfp-container.mfp-inline-holder .mfp-content .wdt-popup-box-content-holder' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
						'condition' => array ()
					),
					'box_shadow' => array (
						'field_type' => 'box_shadow',
						'selector' => '.wdt-popup-box-window-{{ID}} .wdt-popup-box-content-holder, .wdt-popup-box-window-{{ID}}.wdt-popup-box-window.mfp-wrap .mfp-container.mfp-inline-holder .mfp-content .wdt-popup-box-content-holder',
						'condition' => array ()
					)
				)
			));

	}

	public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}

		$output = '';

		$module_id = $widget_object->get_id();
		
		// echo"<pre> -- Settings"; print_r($settings);

		$classes = array ();
		if(isset($settings['on_click_element']) && !empty($settings['on_click_element'])) {
			array_push($classes, 'wdt-click-element-'.$settings['on_click_element']);
		}

		$content_classes = array('wdt-popup-box-content-holder', 'wdt-popup-box-content-holder-' . esc_attr($module_id), 'wdt-content-type-' . esc_attr($settings['content_type']));
		if (isset($settings['trigger_type'])) {
			if ($settings['trigger_type'] === 'off') {
				$classes[] = 'wdt-popup-disable';
				$content_classes[] = 'wdt-popup-disable';
			} else {
				$classes[] = 'wdt-click-element-' . $settings['trigger_type'];
			}
		}

		$pb_settings = array (
			'module_id'         => $module_id,
			'module_ref_id'     => 'wdt-popup-box-'.$module_id,
			'popup_class'       => 'wdt-popup-box-window wdt-popup-box-window-'.esc_attr($module_id).' '.esc_attr($settings['animation_type']),
			'trigger_type'      => $settings['trigger_type'],
			'on_load_delay'     => $settings['on_load_delay'],
			'on_load_after'     => $settings['on_load_after'],
			'external_class'    => $settings['external_class'],
			'external_id'       => $settings['external_id'],
			'show_close_Button' => isset($settings['show_close_Button']) ? filter_var($settings['show_close_Button'], FILTER_VALIDATE_BOOLEAN) : false,
			'esc_to_exit'       => isset($settings['esc_to_exit']) ? filter_var($settings['esc_to_exit'], FILTER_VALIDATE_BOOLEAN) : false,
			'click_to_exit'     => isset($settings['click_to_exit']) ? filter_var($settings['click_to_exit'], FILTER_VALIDATE_BOOLEAN) : false,
		);

		if ('content' === $settings['content_type'] || 'template' === $settings['content_type']) {
			$pb_settings['mfp_src'] = '#wdt-popup-box-content-holder-'.esc_attr($module_id);
			$pb_settings['mfp_type'] = 'inline';
		}

		if ('image' === $settings['content_type']) {
			$pb_settings['mfp_src'] = esc_url($settings['content_image']['url']);
			$pb_settings['mfp_type'] = 'image';
		}

		if ('link' === $settings['content_type']) {
			$pb_settings['mfp_src'] =  esc_url($settings['content_link']['url']);
			$pb_settings['mfp_type'] = 'iframe';
		}

		$pb_settings_json = wp_json_encode($pb_settings);

		$output .= '<div class="wdt-popup-box-trigger-holder '.esc_attr(implode(' ', $classes)).' '.esc_attr($settings['animation_type']).' " id="wdt-popup-box-trigger-'.esc_attr($module_id).'" data-settings="'.esc_js($pb_settings_json).'">';
			if(isset($settings['on_click_element_image']['url']) || isset($settings['on_click_element_label']) || isset($settings['on_click_element_icon']['value'])) {
				$output .= '<div class="wdt-popup-box-trigger-element">';
					if(isset($settings['on_click_element_label'])) {
						$output .= '<span class="wdt-popup-box-trigger-item wdt-popup-box-trigger-label">'.$settings['on_click_element_label'].'</span>';
					}
					if(isset($settings['on_click_element_image']['url'])) {
						$output .= '<img alt="'.esc_attr( get_bloginfo( 'name' ) ).'" src="'.esc_url($settings['on_click_element_image']['url']).'" class="wdt-popup-box-trigger-item wdt-popup-box-trigger-image">';
					}
					if(isset($settings['on_click_element_icon']['value'])) {
						$output .= '<span class="wdt-popup-box-trigger-item wdt-popup-box-trigger-icon">'.$this->render_icon($settings['on_click_element_icon']).'</span>';
					}
				$output .= '</div>';
			}
		$output .= '</div>';
		if ($settings['content_type'] == 'content' || $settings['content_type'] == 'template') {
			$output .= '<div id="wdt-popup-box-content-holder-'.esc_attr($module_id).'" class="'.esc_attr(implode(' ', $content_classes)).' mfp-hide">';
				$output .= '<div class="wdt-popup-box-content-inner">';
				if ($settings['content_type'] == 'content') {
					$output .= $settings['content_description'];
				} else if ($settings['content_type'] == 'template') {
					$frontend = Elementor\Frontend::instance();
					$output .= $frontend->get_builder_content($settings['content_template'], true);
				}
				$output .= '</div>';
			$output .= '</div>';
		}
		return $output;

	}

	public function render_icon($icon) {
		$output = '';
		if(!empty($icon['value'])):

			$output .= ($icon['library'] === 'svg') ? '<i>' : '';
				ob_start();
				\Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );
				$output .= ob_get_clean();
			$output .= ($icon['library'] === 'svg') ? '</i>' : '';

		endif;
		return $output;
	}

}

if( !function_exists( 'wedesigntech_widget_base_popup_box' ) ) {
    function wedesigntech_widget_base_popup_box() {
        return WeDesignTech_Widget_Base_Popup_Box::instance();
    }
}