<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Hotspot {

	private static $_instance = null;

	private $cc_repeater_contents;
	private $cc_style;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	function __construct() {

		$options_group = array ();
		$options = array ();
		$option_defaults = array ();
		$module_details = array ();

		// Initialize depandant class
			$this->cc_repeater_contents = new WeDesignTech_Common_Controls_Repeater_Contents($options_group, $options, $option_defaults, $module_details);
			$this->cc_style = new WeDesignTech_Common_Controls_Style();

	}

	public function name() {
		return 'wdt-hotspot';
	}

	public function title() {
		return esc_html__( 'Hotspot', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'wdt-widget-icon';
	}

	public function init_styles() {
		return array (
				$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/hotspot/assets/css/style.css'
			);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array (
			'jquery-popper' => WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'inc/widgets/hotspot/assets/js/popper.min.js',
			'jquery-tippy-bundle' => WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'inc/widgets/hotspot/assets/js/tippy-bundle.min.js',
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/hotspot/assets/js/script.js'
		);
	}

	public function create_elementor_controls($elementor_object) {

		$elementor_object->start_controls_section( 'wdt_section_image', array(
			'label' => esc_html__( 'Image', 'wdt-elementor-addon'),
		) );

			$elementor_object->add_control(
				'media_image',
				array (
					'label' => esc_html__( 'Choose Image', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => array (
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					)
				)
			);

			$elementor_object->add_group_control(
				\Elementor\Group_Control_Image_Size::get_type(),
				array (
					'name' => 'media_image',
					'default' => 'large',
					'separator' => 'none'
				)
			);

			$elementor_object->add_control(
                'media_image_align',
                array (
                    'label' => esc_html__( 'Alignment', 'wdt-elementor-addon' ),
                    'type' =>\Elementor\Controls_Manager::CHOOSE,
                    'options' => array (
                        'left' => array (
                            'title' => esc_html__( 'Left', 'wdt-elementor-addon' ),
                            'icon' => 'eicon-text-align-left',
                        ),
                        'center' => array (
                            'title' => esc_html__( 'Center', 'elementor' ),
                            'icon' => 'eicon-text-align-center',
                        ),
                        'right' => array (
                            'title' => esc_html__( 'Right', 'elementor' ),
                            'icon' => 'eicon-text-align-right',
                        )
                    ),
                    'selectors' => array (
						'{{WRAPPER}}' => 'text-align: {{VALUE}};',
                    ),
                )
            );

		$elementor_object->end_controls_section();


		$elementor_object->start_controls_section( 'wdt_section_hotspots', array(
			'label' => esc_html__( 'Hotspots', 'wdt-elementor-addon'),
		) );

			$elementor_object->add_control(
				'hotspot_type',
				array (
					'label' => esc_html__( 'Hotspot Type', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => array (
						'default'  => esc_html__( 'Default', 'wdt-elementor-addon' ),
						'number'   => esc_html__( 'Number', 'wdt-elementor-addon' ),
						'alphabet' => esc_html__( 'Alphabet', 'wdt-elementor-addon' ),
						'icon'     => esc_html__( 'Icon', 'wdt-elementor-addon' )
					),
					'default' => 'default'
				)
			);

			$elementor_object->add_control(
				'hotspot_animation',
				array (
					'label' => esc_html__( 'Animation', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => array (
						'' => esc_html__( 'None', 'wdt-elementor-addon' ),
						'wdt-hotspot-soft-beat' => esc_html__( 'Soft Beat', 'wdt-elementor-addon' ),
						'wdt-hotspot-expand' => esc_html__( 'Expand', 'wdt-elementor-addon' ),
						'wdt-hotspot-overlay' => esc_html__( 'Overlay', 'wdt-elementor-addon' ),
						'wdt-hotspot-ripple' => esc_html__( 'Ripple', 'wdt-elementor-addon' )
					),
					'default' => '',
					'separator' => 'after'
				)
			);

			$repeater = new \Elementor\Repeater();

			$repeater->start_controls_tabs( 'hotspot_items' );

				$repeater->start_controls_tab(
					'hotspot_item_content',
					array (
						'label' => esc_html__( 'Content', 'wdt-elementor-addon' ),
					)
				);

					$repeater->add_control( 
						'content_type', 
						array(
						'type'    => \Elementor\Controls_Manager::SELECT2,
						'label'   => esc_html__( 'Content Type', 'wdt-elementor-addon' ),
						'default' => 'default',
						'options' => array(
							'default'  => esc_html__( 'Default', 'wdt-elementor-addon' ),
							'template' => esc_html__( 'Template', 'wdt-elementor-addon' ),
						)
					));

					$repeater->add_control(
						'content_template', 
						array(
						'label'     => esc_html__( 'Select Template', 'wdt-elementor-addon' ),
						'type'      => \Elementor\Controls_Manager::SELECT,
						'options'   => $elementor_object->get_elementor_page_list(),
						'condition' => array (
							'content_type' => 'template'
						)
					));

					$repeater->add_control( 'show_label', array(
						'label' => esc_html__( 'Show Label', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'default' => 'yes',
						'frontend_available' => true,
						'condition' => array (
							'content_type' => 'default'
						)
					) );

					$repeater->add_control( 'label', array(
						'label'       => esc_html__( 'Label', 'wdt-elementor-addon' ),
						'type'        => \Elementor\Controls_Manager::TEXT,
						'label_block' => true,
						'default' => '',
						'condition' => array ( 'show_label' => 'yes', 'content_type' => 'default' )
					) );

					$repeater->add_control( 'link', array(
						'label'       => esc_html__( 'Link', 'wdt-elementor-addon' ),
						'type'        => \Elementor\Controls_Manager::URL,
						'label_block' => true,
						'placeholder' => esc_html__( 'https://your-link.com', 'wdt-elementor-addon' ),
						'condition' => array (
							'content_type' => 'default'
						)
					) );

					$repeater->add_control( 'show_tooltip_content', array(
						'label' => esc_html__( 'Show Tooltip Content', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'default' => 'yes',
						'frontend_available' => true,
						'condition' => array (
							'content_type' => 'default'
						)
					) );

					$repeater->add_control( 'tooltip_label', array(
						'label'       => esc_html__( 'Tooltip Label', 'wdt-elementor-addon' ),
						'type'        => \Elementor\Controls_Manager::TEXT,
						'label_block' => true,
						'default' => '',
						'condition' => array ( 'show_tooltip_content' => 'yes', 'content_type' => 'default' )
					) );

					$repeater->add_control( 'tooltip_content', array(
						'label'       => esc_html__( 'Tooltip Content', 'wdt-elementor-addon' ),
						'type'        => \Elementor\Controls_Manager::TEXTAREA,
						'label_block' => true,
						'default' => '',
						'dynamic' => array (
							'active' => true,
						),
						'condition' => array ( 'show_tooltip_content' => 'yes', 'content_type' => 'default' )
					) );

					$repeater->add_control( 'tooltip_image', array(
						'label'       => esc_html__( 'Tooltip Image', 'wdt-elementor-addon' ),
						'type'        => \Elementor\Controls_Manager::MEDIA,
						'default' => array (
							'url' => '',
						),
						'condition' => array ( 'show_tooltip_content' => 'yes', 'content_type' => 'default' )
					) );

					$repeater->add_control(
						'media_icon',
						array (
							'label' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
							'type' => \Elementor\Controls_Manager::ICONS,
							'label_block' => false,
							'skin' => 'inline',
							'condition' => array (
								'content_type' => 'default'
							)
						)
					);

					$repeater->add_control(
						'media_icon_description',
						array(
							'type' => \Elementor\Controls_Manager::RAW_HTML,
							'raw'  => esc_html__( 'Icon option will be used only when "Hotspot Type" is "Icon".', 'wdt-elementor-addon' ),
							'content_classes' => 'elementor-descriptor',
							'condition' => array (
								'content_type' => 'default'
							)
						)
					);

				$repeater->end_controls_tab();

				$repeater->start_controls_tab(
					'hotspot_item_position',
					array (
						'label' => esc_html__( 'Position', 'wdt-elementor-addon' ),
					)
				);

					$repeater->add_responsive_control(
						'horizontal_position',
						array (
							'label' => esc_html__( 'Horizontal Position', 'wdt-elementor-addon' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => array ( '%' ),
							'default' => array (
								'unit' => '%',
								'size' => '50',
							),
							'selectors' => array (
								'{{WRAPPER}} {{CURRENT_ITEM}}' => 'left: {{SIZE}}{{UNIT}}; right: auto;'
							),
						)
					);

					$repeater->add_responsive_control(
						'vertical_position',
						array (
							'label' => esc_html__( 'Vertical Position', 'wdt-elementor-addon' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => array ( '%' ),
							'default' => array (
								'unit' => '%',
								'size' => '50',
							),
							'selectors' => array (
								'{{WRAPPER}} {{CURRENT_ITEM}}' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;'
							),
						)
					);

					$repeater->add_control(
						'tooltip_position_heading',
						array (
							'label' => esc_html__( 'Tooltip', 'wdt-elementor-addon' ),
							'type' => \Elementor\Controls_Manager::HEADING,
							'separator' => 'before',
						)
					);

					$repeater->add_control( 'custom_tooltip_properties', array(
						'label' => esc_html__( 'Custom Tooltip Properties', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'default' => 'yes',
						'frontend_available' => true
					) );

					$repeater->add_responsive_control(
						'custom_tooltip_position',
						array(
							'label'   => esc_html__( 'Position', 'wdt-elementor-addon' ),
							'type'    => \Elementor\Controls_Manager::SELECT,
							'default' => 'global',
							'options' => array(
								'global'       => esc_html__( 'Global', 'wdt-elementor-addon' ),
								'top-start'    => esc_html__( 'Top Start', 'wdt-elementor-addon' ),
								'top'          => esc_html__( 'Top', 'wdt-elementor-addon' ),
								'top-end'      => esc_html__( 'Top End', 'wdt-elementor-addon' ),
								'right-start'  => esc_html__( 'Right Start', 'wdt-elementor-addon' ),
								'right'        => esc_html__( 'Right', 'wdt-elementor-addon' ),
								'right-end'    => esc_html__( 'Right End', 'wdt-elementor-addon' ),
								'bottom-start' => esc_html__( 'Bottom Start', 'wdt-elementor-addon' ),
								'bottom'       => esc_html__( 'Bottom', 'wdt-elementor-addon' ),
								'bottom-end'   => esc_html__( 'Bottom End', 'wdt-elementor-addon' ),
								'left-start'   => esc_html__( 'Left Start', 'wdt-elementor-addon' ),
								'left'         => esc_html__( 'Left', 'wdt-elementor-addon' ),
								'left-end'     => esc_html__( 'Left End', 'wdt-elementor-addon' ),
							),
							'condition' => array (
								'custom_tooltip_properties' => 'yes',
							)
						)
					);

				$repeater->end_controls_tab();

			$repeater->end_controls_tabs();

			$elementor_object->add_control( 'hotspots', array(
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'label'       => esc_html__( 'Hotspots', 'wdt-elementor-addon' ),
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{label}}}',
				'default' => array(
					array(
						'show_tooltip_content' => 'yes',
						'tooltip_content' =>  esc_html__( 'Ut accumsan mass', 'wdt-elementor-addon' ),
						'horizontal_position' => array (
							'unit' => '%',
							'size' => '50',
						),
						'vertical_position' => array (
							'unit' => '%',
							'size' => '50',
						)
					),
					array(
						'show_tooltip_content' => 'yes',
						'tooltip_content' =>  esc_html__( 'Pellentesque ornare', 'wdt-elementor-addon' ),
						'horizontal_position' => array (
							'unit' => '%',
							'size' => '40',
						),
						'vertical_position' => array (
							'unit' => '%',
							'size' => '40',
						)
					)
				),
			) );

		$elementor_object->end_controls_section();


		$elementor_object->start_controls_section( 'wdt_section_tooltip', array(
			'label' => esc_html__( 'Tooltip', 'wdt-elementor-addon'),
		) );

			$elementor_object->add_control(
				'tooltip_position',
				array(
					'label'   => esc_html__( 'Position', 'wdt-elementor-addon' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => 'top',
					'options' => array(
						'top-start'    => esc_html__( 'Top Start', 'wdt-elementor-addon' ),
						'top'          => esc_html__( 'Top', 'wdt-elementor-addon' ),
						'top-end'      => esc_html__( 'Top End', 'wdt-elementor-addon' ),
						'right-start'  => esc_html__( 'Right Start', 'wdt-elementor-addon' ),
						'right'        => esc_html__( 'Right', 'wdt-elementor-addon' ),
						'right-end'    => esc_html__( 'Right End', 'wdt-elementor-addon' ),
						'bottom-start' => esc_html__( 'Bottom Start', 'wdt-elementor-addon' ),
						'bottom'       => esc_html__( 'Bottom', 'wdt-elementor-addon' ),
						'bottom-end'   => esc_html__( 'Bottom End', 'wdt-elementor-addon' ),
						'left-start'   => esc_html__( 'Left Start', 'wdt-elementor-addon' ),
						'left'         => esc_html__( 'Left', 'wdt-elementor-addon' ),
						'left-end'     => esc_html__( 'Left End', 'wdt-elementor-addon' ),
					),
				)
			);

			$elementor_object->add_control( 'tooltip_show_arrow', array(
				'label' => esc_html__( 'Show Arrow', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
				'default' => 'yes',
				'frontend_available' => true
			) );

			$elementor_object->add_responsive_control(
				'tooltip_trigger',
				array (
					'label' => esc_html__( 'Trigger', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => array (
						'manual' => esc_html__( 'Manual', 'wdt-elementor-addon' ),
						'mouseenter' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
						'click' => esc_html__( 'Click', 'wdt-elementor-addon' ),
					),
					'default' => 'click',
					'frontend_available' => true,
				)
			);

			$elementor_object->add_control(
				'tooltip_trigger_manual_description',
				array(
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw'  => esc_html__( 'Always shows tooltip.', 'wdt-elementor-addon' ),
					'content_classes' => 'elementor-descriptor',
					'condition' => array(
						'tooltip_trigger' => 'manual',
					),
				)
			);

			$elementor_object->add_control(
				'tooltip_animation',
				array (
					'label' => esc_html__( 'Animation', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => array (
						'fade'         => esc_html__( 'Fade', 'wdt-elementor-addon' ),
						'shift-away'   => esc_html__( 'Shift-Away', 'wdt-elementor-addon' ),
						'shift-toward' => esc_html__( 'Shift-Toward', 'wdt-elementor-addon' ),
						'scale'        => esc_html__( 'Scale', 'wdt-elementor-addon' ),
						'perspective'  => esc_html__( 'Perspective', 'wdt-elementor-addon' )
					),
					'default' => 'fade',
					'separator' => 'before',
					'condition' => array(
						'tooltip_trigger!' => 'manual',
					),
				)
			);

			$elementor_object->add_control(
				'tooltip_delay',
				array(
					'label'      => esc_html__( 'Animation Delay', 'wdt-elementor-addon' ),
					'type'       => \Elementor\Controls_Manager::SLIDER,
					'size_units' => array(
						'ms',
					),
					'range'      => array(
						'ms' => array(
							'min'  => 0,
							'max'  => 1000,
							'step' => 100,
						),
					),
					'default' => array(
						'size' => 0,
						'unit' => 'ms',
					),
					'condition' => array(
						'tooltip_trigger!' => 'manual',
					),
				)
			);

		$elementor_object->end_controls_section();


		// Hotspot Icon
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'hotspot_icon',
			'title' => esc_html__( 'Hotspot Icon', 'wdt-elementor-addon' ),
			'styles' => array (
				'font_size' => array (
					'field_type' => 'font_size',
					'selector' => array (
						'{{WRAPPER}} .wdt-hotspot-item-trigger .wdt-hotspot-item-default, 
						 {{WRAPPER}} .wdt-hotspot-item-trigger .wdt-hotspot-item-number, 
						 {{WRAPPER}} .wdt-hotspot-item-trigger .wdt-hotspot-item-alphabet, 
						 {{WRAPPER}} .wdt-hotspot-item-trigger .wdt-hotspot-item-icon .wdt-content-icon-wrapper .wdt-content-icon span' => 'font-size: {{SIZE}}{{UNIT}};'
					),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-hotspot-item-trigger .wdt-hotspot-item-default, 
						 {{WRAPPER}} .wdt-hotspot-item-trigger .wdt-hotspot-item-number, 
						 {{WRAPPER}} .wdt-hotspot-item-trigger .wdt-hotspot-item-alphabet, 
						 {{WRAPPER}} .wdt-hotspot-item-trigger .wdt-hotspot-item-icon .wdt-content-icon-wrapper:not(.wdt-content-icon-style-default) .wdt-content-icon span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
										'{{WRAPPER}} .wdt-hotspot-item-trigger .wdt-hotspot-item-default, 
										 {{WRAPPER}} .wdt-hotspot-item-trigger .wdt-hotspot-item-number, 
										 {{WRAPPER}} .wdt-hotspot-item-trigger .wdt-hotspot-item-alphabet, 
										 {{WRAPPER}} .wdt-hotspot-item-trigger .wdt-hotspot-item-icon .wdt-content-icon-wrapper .wdt-content-icon span' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'color_label' => array (
									'field_type' => 'color',
									'unique_key' => 'label',
									'label' => esc_html__( 'Label Color', 'wdt-elementor-addon' ),
									'selector' => array (
										'{{WRAPPER}} .wdt-hotspot-item-trigger .wdt-hotspot-item-label' => 'color: {{VALUE}};'
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
										'{{WRAPPER}} .wdt-hotspot-item-trigger:hover .wdt-hotspot-item-default, 
										 {{WRAPPER}} .wdt-hotspot-item-trigger:hover .wdt-hotspot-item-number, 
										 {{WRAPPER}} .wdt-hotspot-item-trigger:hover .wdt-hotspot-item-alphabet, 
										 {{WRAPPER}} .wdt-hotspot-item-trigger:hover .wdt-hotspot-item-icon .wdt-content-icon-wrapper .wdt-content-icon span' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'color_label_hover' => array (
									'field_type' => 'color',
									'unique_key' => 'label_hover',
									'label' => esc_html__( 'Label Hover Color', 'wdt-elementor-addon' ),
									'selector' => array (
										'{{WRAPPER}} .wdt-hotspot-item-trigger:hover .wdt-hotspot-item-label' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
							)
						)
					)
				)
			)
		));


		// Hotspot Element
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'hotspot_element',
			'title' => esc_html__( 'Hotspot Element', 'wdt-elementor-addon' ),
			'styles' => array (
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-hotspot-item-trigger' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
									'selector' => '{{WRAPPER}} .wdt-hotspot-item-trigger',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-hotspot-item-trigger',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-hotspot-item-trigger' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-hotspot-item-trigger',
									'condition' => array ()
								)
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-hotspot-item-trigger:hover',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-hotspot-item-trigger:hover',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-hotspot-item-trigger:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-hotspot-item-trigger:hover',
									'condition' => array ()
								)
							)
						)
					)
				)
			)
		));

		// Tooltip
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'tooltip',
			'title' => esc_html__( 'Tooltip', 'wdt-elementor-addon' ),
			'styles' => array (
				'typography_tooltip_label' => array (
					'field_type' => 'typography',
					'unique_key' => 'tooltip_label',
					'label' => esc_html__( 'Label Typography', 'wdt-elementor-addon' ),
					'selector' => '{{WRAPPER}} .tippy-box .tippy-content h5',
					'condition' => array ()
				),
				'typography_tooltip_content' => array (
					'field_type' => 'typography',
					'unique_key' => 'tooltip_content',
					'label' => esc_html__( 'Content Typography', 'wdt-elementor-addon' ),
					'selector' => '{{WRAPPER}} .tippy-box .tippy-content p',
					'condition' => array ()
				),
				'alignment' => array (
					'field_type' => 'alignment',
					'selector' => array (
						'{{WRAPPER}} .tippy-box .tippy-content' => 'text-align: {{VALUE}}; justify-content: {{VALUE}};'
					),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .tippy-box .tippy-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'color_label' => array (
					'field_type' => 'color',
					'unique_key' => 'label',
					'label' => esc_html__( 'Label Color', 'wdt-elementor-addon' ),
					'selector' => array (
						'{{WRAPPER}} .tippy-box .tippy-content h5' => 'color: {{VALUE}};'
					),
					'condition' => array ()
				),
				'color_content' => array (
					'field_type' => 'color',
					'unique_key' => 'content',
					'label' => esc_html__( 'Content Color', 'wdt-elementor-addon' ),
					'selector' => array (
						'{{WRAPPER}} .tippy-box .tippy-content p' => 'color: {{VALUE}};'
					),
					'condition' => array ()
				),
				'background' => array (
					'field_type' => 'background',
					'selector' => '{{WRAPPER}} .tippy-box .tippy-content',
					'condition' => array ()
				),
				'border' => array (
					'field_type' => 'border',
					'selector' => '{{WRAPPER}} .tippy-box .tippy-content',
					'condition' => array ()
				),
				'border_radius' => array (
					'field_type' => 'border_radius',
					'selector' => array (
						'{{WRAPPER}} .tippy-box .tippy-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'box_shadow' => array (
					'field_type' => 'box_shadow',
					'selector' => '{{WRAPPER}} .tippy-box .tippy-content',
					'condition' => array ()
				),
				'color_arrow' => array (
					'field_type' => 'color',
					'unique_key' => 'arrow',
					'label' => esc_html__( 'Arrow Color', 'wdt-elementor-addon' ),
					'selector' => array (
						'{{WRAPPER}} .tippy-arrow' => 'color: {{VALUE}};'
					),
					'separator' => 'before',
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

		$media_image_setting = array ();
		$media_image_setting['image'] = $settings['media_image'];
		$media_image_setting['image_size'] = $settings['media_image_size'];
		$media_image_setting['image_custom_dimension'] = isset($settings['media_image_custom_dimension']) ? $settings['media_image_custom_dimension'] : array ();

        // Resposnive Settings

            $responsive_datas = array ();
            $active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();
            $breakpoint_keys = array_keys($active_breakpoints);

            foreach($breakpoint_keys as $breakpoint) {

                $tooltip_trigger_str = 'tooltip_trigger_'.$breakpoint;
                $responsive_datas['tooltip_trigger'][$breakpoint] = (isset($settings[$tooltip_trigger_str]) && !empty($settings[$tooltip_trigger_str])) ? $settings[$tooltip_trigger_str] : $settings['tooltip_trigger'];

            }

            $responsive_datas['tooltip_trigger']['desktop'] = $settings['tooltip_trigger'];


		$json_settings = wp_json_encode(array (
			'tooltipPlacement' => $settings['tooltip_position'],
			'tooltipTrigger'   => $settings['tooltip_trigger'],
			'tooltipAnimation' => $settings['tooltip_animation'],
			'tooltipDelay'     => $settings['tooltip_delay'],
			'tooltipArrow'     => filter_var( $settings['tooltip_show_arrow'], FILTER_VALIDATE_BOOLEAN ),
            'tooltipResponsive' => $responsive_datas
		));


		$output .= '<div class="wdt-hotspot-holder" data-settings="'.esc_js($json_settings).'">';
			$output .= \Elementor\Group_Control_Image_Size::get_attachment_image_html( $media_image_setting );
			if( is_array($settings['hotspots']) && !empty($settings['hotspots']) ) {
				$output .= '<div class="wdt-hotspot-items-holder">';
					foreach ( $settings['hotspots'] as $key => $hotspot ) {

						// Item attributes

						$is_hotspot_link = ! empty( $hotspot['link']['url'] );
						$hotspot_element_tag = $is_hotspot_link ? 'a' : 'div';

						$tooltip_content = $hostspot_image = '';
						
						if( $hotspot['content_type'] == 'template' ) {
							$frontend = Elementor\Frontend::instance();
                            $tooltip_content .= $frontend->get_builder_content( $hotspot['content_template'], true );
						} else {
							
							if($hotspot['show_tooltip_content'] && $hotspot['tooltip_content']) {
	
								if(isset($hotspot['tooltip_image']['url']) && !empty($hotspot['tooltip_image']['url'])) {
									$media_image_setting = array ();
									$media_image_setting['image'] = $hotspot['tooltip_image'];
									$media_image_setting['image_size'] = 'thumbnail';
									$hostspot_image .= '<span class="wdt-hotspot-image">';
										$hostspot_image .= $this->render_tooltip_image($hotspot, '', '');
									$hostspot_image .= '</span>';
								}
	
								if( !empty($hotspot['tooltip_content']) && !empty($hotspot['tooltip_label']) ) {
									$tooltip_content .= '<div class="wdt-hotspot-content">';
								}
								if(!empty($hotspot['tooltip_label'])) {
									$tooltip_content .= '<h5>'.$hotspot['tooltip_label'].'</h5>';
								}
								$tooltip_content .= '<p>'.$hotspot['tooltip_content'].'</p>';
	
								if( !empty($hotspot['tooltip_content']) && !empty($hotspot['tooltip_label']) ) {
									$tooltip_content .= '</div>';
								}
							}
						}

						$hotspot_repeater_setting_key = 'wdt-hotspot-repeater-item-'.$key;
						$widget_object->add_render_attribute(
							$hotspot_repeater_setting_key, array (
								'class' => array (
									'wdt-hotspot-repeater-item',
									'elementor-repeater-item-' . $hotspot['_id'],
									$is_hotspot_link ? 'wdt-hotspot-link' : ''
								),
								'data-tooltip-position' => $hotspot['custom_tooltip_position'] ? $hotspot['custom_tooltip_position'] : 'global',
								'data-tooltip-content' => $tooltip_content,
								'data-tooltip-image' => $hostspot_image
							)
						);
						if ( $is_hotspot_link ) {
							$widget_object->add_link_attributes( $hotspot_repeater_setting_key, $hotspot['link'] );
						}

						//Item trigger attributes

						$hotspot_repeater_trigger_setting_key = 'wdt-hotspot-repeater-trigger-item-'.$key;
						$widget_object->add_render_attribute(
							$hotspot_repeater_trigger_setting_key, array (
								'class' => array (
									'wdt-hotspot-item-trigger',
									$settings['hotspot_animation'],
								),
							)
						);


						$output .= '<'.esc_attr($hotspot_element_tag).' '.$widget_object->get_render_attribute_string( $hotspot_repeater_setting_key ).'>';
							$output .= '<div '.$widget_object->get_render_attribute_string( $hotspot_repeater_trigger_setting_key ).'>';

								if($settings['hotspot_type'] == 'icon') {
									if($hotspot['media_icon']['value']) {
										$icon_item = array ();
										$icon_item['media_icon'] = $hotspot['media_icon'];
										$icon_item['media_icon_style'] = '';
										$icon_item['media_icon_shape'] = '';
										$output .= '<div class="wdt-hotspot-item-icon">';
											$output .= $this->cc_repeater_contents->render_icon($key, $icon_item, $widget_object);
										$output .= '</div>';
									} else {
										$output .= '<div class="wdt-hotspot-item-default">';
											$output .= '<i class="wdticon-plus"></i>';
										$output .= '</div>';
									}
								} elseif($settings['hotspot_type'] == 'alphabet') {
									$alphabets = range('A', 'Z');
									$output .= '<div class="wdt-hotspot-item-alphabet">';
										$output .= $alphabets[$key];
									$output .= '</div>';
								} else if($settings['hotspot_type'] == 'number') {
									$output .= '<div class="wdt-hotspot-item-number">';
										$output .= $key+1;
									$output .= '</div>';
								} else {
									$output .= '<div class="wdt-hotspot-item-default">';
										$output .= '<i class="wdticon-plus"></i>';
									$output .= '</div>';
								}

								if($hotspot['show_label'] && !empty($hotspot['label'])) {
									$output .= '<div class="wdt-hotspot-item-label">'.esc_html($hotspot['label']).'</div>';
								}
							$output .= '</div>';
							/* if($hotspot['show_tooltip_content']) {
								$output .= '<div class="wdt-hotspot-item-tooltip">'.esc_html($hotspot['tooltip_content']).'</div>';
							} */
						$output .= '</'.esc_attr($hotspot_element_tag).'>';

					}
				$output .= '</div>';
			}
		$output .= '</div>';

		return $output;

	}

	public function render_tooltip_image($item, $link_start, $link_end) {
		$output = '';
		if ( ! empty( $item['tooltip_image']['url'] ) ) :
			$class = '';
			$output .= '<div class="wdt-content-image-wrapper '.esc_attr($class).'">';
				$output .= '<div class="wdt-content-image">';

					$media_image_setting = array ();
					$media_image_setting['image'] = $item['tooltip_image'];
					$media_image_setting['image_size'] = 'thumbnail';
					$media_image_setting['image_custom_dimension'] = isset($item['tooltip_image_custom_dimension']) ? $item['media_image_custom_dimension'] : array ();

					$output .=  ($link_start != '') ? $link_start : '<span>';
						$output .= \Elementor\Group_Control_Image_Size::get_attachment_image_html( $media_image_setting );
					$output .=  ($link_end != '') ? $link_end : '</span>';

				$output .= '</div>';
			$output .= '</div>';

		endif;
		return $output;
	}

}

if( !function_exists( 'wedesigntech_widget_base_hotspot' ) ) {
    function wedesigntech_widget_base_hotspot() {
        return WeDesignTech_Widget_Base_Hotspot::instance();
    }
}