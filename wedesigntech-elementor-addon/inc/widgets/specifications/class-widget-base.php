<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Specifications {

	private static $_instance = null;

	private $cc_layout;
	private $cc_style;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	function __construct() {

		// Initialize depandant class
		$this->cc_layout = new WeDesignTech_Common_Controls_Layout('both');
		$this->cc_style = new WeDesignTech_Common_Controls_Style();

	}

	public function name() {
		return 'wdt-specifications';
	}

	public function title() {
		return esc_html__( 'Specifications', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'wdt-widget-icon';
	}

	public function init_styles() {
		return array_merge(
			$this->cc_layout->init_styles(),
			array (
				$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/specifications/assets/css/style.css'
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
				$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/specifications/assets/js/script.js'
			)
		);
	}

	public function create_elementor_controls($elementor_object) {

		$elementor_object->start_controls_section( 'wdt_section_content', array(
			'label' => esc_html__( 'Content', 'wdt-elementor-addon'),
		) );

		$elementor_object->add_control( 'enable_spec_type',
			array(
				'label'   => esc_html__( 'Template', 'wdt-elementor-addon' ),
				'type'    => Elementor\Controls_Manager::SELECT,
				'default' => 'wdt_type_1',
				'options' => array(
					'wdt_type_1'   => esc_html__( 'Type-1', 'wdt-elementor-addon' ),
					'wdt_type_2'   => esc_html__( 'Type-2', 'wdt-elementor-addon' )
				)
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'enable_swap_media', array(
			'label' => esc_html__( 'Icon to Image', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'frontend_available' => true,
			'default'            => '',
			'return_value'       => 'true'
		) );

		$repeater->add_control( 'icon', array(
			'label' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::ICONS,
			'default' => array( 'value' => 'fas fa-star', 'library' => 'fa-solid', ),
			'condition' => array (
				'enable_swap_media!' => 'true',
			)
		) );

		$repeater->add_control( 'image', array (
			'label' => esc_html__( 'Image', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::MEDIA,
			'default' => array (
				'url' => \Elementor\Utils::get_placeholder_image_src(),
			),
			'condition' => array (
				'enable_swap_media' => 'true',
			)
		) );

		$repeater->add_control( 'title', array(
			'label'       => esc_html__( 'Title', 'wdt-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'placeholder' => esc_html__( 'Title goes here', 'wdt-elementor-addon' ),
			'condition'   => array ()
		) );

		$repeater->add_control( 'sub_title', array(
			'label'       => esc_html__( 'Sub Title', 'wdt-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'placeholder' => esc_html__( 'Sub title goes here', 'wdt-elementor-addon' ),
			'condition'   => array ()
		) );

		$repeater->add_control( 'description', array(
			'label'       => esc_html__( 'Description', 'wdt-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::WYSIWYG,
			'label_block' => true,
			'placeholder' => esc_html__( 'Item Description', 'wdt-elementor-addon' ),
			'default'     => esc_html__( 'Sed ut perspiciatis unde omnis iste natus error sit, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae.', 'wdt-elementor-addon' ),
			'condition'   => array()
		) );

		$repeater->add_control( 'button',array(
			'label'       => esc_html__( 'Button Text', 'wdt-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => esc_html__('Click Here!', 'wdt-elementor-addon'),
			'placeholder' => esc_html__('Click Here!', 'wdt-elementor-addon')
		) );
		$repeater->add_control( 'button_link',array(
			'label'       => esc_html__( 'Button Link', 'wdt-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => esc_html__( 'https://your-link.com', 'wdt-elementor-addon' ),
			'default'     => array( 'url' => '#' ),
			'separator' => 'after'
		) );

		$repeater->add_control( 'enable_spec_alignment',
			array(
				'label'   => esc_html__( 'Spec Alignment', 'wdt-elementor-addon' ),
				'type'    => Elementor\Controls_Manager::SELECT,
				'default' => 'item-block',
				'options' => array(
					'item-block'    => esc_html__( 'Item Block', 'wdt-elementor-addon' ),
					'item-inline'   => esc_html__( 'Item Inline', 'wdt-elementor-addon' )
				),
				'frontend_available' => true
			)
		);

		$repeater->add_control( 'enable_spec_one', array(
			'label' => esc_html__( 'Enable Spec One', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'frontend_available' => true,
			'default'            => '',
			'return_value'       => 'true'
		) );

		$repeater->add_control( 'specifications_1_item', array(
			'label'       => esc_html__( 'Specifications One', 'wdt-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'placeholder' => esc_html__( 'Specifications item 1 goes here', 'wdt-elementor-addon' ),
			'default'	  => esc_html__('Specifications Item One.', 'wdt-elementor-addon'),
			'condition'   => array ( 'enable_spec_one' => 'true' )
		) );

		$repeater->add_control( 'specifications_1_link',array(
			'label'       => esc_html__( 'Specifications One Link', 'wdt-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => esc_html__( 'https://your-link.com', 'wdt-elementor-addon' ),
			'default'     => array( 'url' => '#' ),
			'condition'   => array( 'enable_spec_one' => 'true' ),
			'separator'   => 'after'
		) );

		$repeater->add_control( 'enable_spec_two', array(
			'label' => esc_html__( 'Enable Spec Two', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'frontend_available' => true,
			'default'            => '',
			'return_value'       => 'true'
		) );

		$repeater->add_control( 'specifications_2_item', array(
			'label'       => esc_html__( 'Specifications Two', 'wdt-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'placeholder' => esc_html__( 'Specifications item 2 goes here', 'wdt-elementor-addon' ),
			'default'	  => esc_html__('Specifications Item Two.', 'wdt-elementor-addon'),
			'condition'   => array ( 'enable_spec_two' => 'true' )
		) );

		$repeater->add_control( 'specifications_2_link',array(
			'label'       => esc_html__( 'Specifications Two Link', 'wdt-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => esc_html__( 'https://your-link.com', 'wdt-elementor-addon' ),
			'default'     => array( 'url' => '#' ),
			'condition'   => array( 'enable_spec_two' => 'true' ),
			'separator'   => 'after'
		) );

		$repeater->add_control( 'enable_spec_three', array(
			'label' => esc_html__( 'Enable Spec Three', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'frontend_available' => true,
			'default'            => '',
			'return_value'       => 'true'
		) );

		$repeater->add_control( 'specifications_3_item', array(
			'label'       => esc_html__( 'Specifications Three', 'wdt-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'placeholder' => esc_html__( 'Specifications item 1 goes here', 'wdt-elementor-addon' ),
			'default'	  => esc_html__('Specifications Item Three.', 'wdt-elementor-addon'),
			'condition'   => array ( 'enable_spec_three' => 'true' )
		) );

		$repeater->add_control( 'specifications_3_link',array(
			'label'       => esc_html__( 'Specifications Three Link', 'wdt-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => esc_html__( 'https://your-link.com', 'wdt-elementor-addon' ),
			'default'     => array( 'url' => '#' ),
			'condition'   => array( 'enable_spec_three' => 'true' ),
			'separator'   => 'after'
		) );

		$repeater->add_control( 'enable_spec_four', array(
			'label' => esc_html__( 'Enable Spec Four', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'frontend_available' => true,
			'default'            => '',
			'return_value'       => 'true'
		) );

		$repeater->add_control( 'specifications_4_item', array(
			'label'       => esc_html__( 'Specifications Four', 'wdt-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'placeholder' => esc_html__( 'Specifications item 1 goes here', 'wdt-elementor-addon' ),
			'default'	  => esc_html__('Specifications Item Four.', 'wdt-elementor-addon'),
			'condition'   => array ( 'enable_spec_four' => 'true' )
		) );

		$repeater->add_control( 'specifications_4_link',array(
			'label'       => esc_html__( 'Specifications Four Link', 'wdt-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => esc_html__( 'https://your-link.com', 'wdt-elementor-addon' ),
			'default'     => array( 'url' => '#' ),
			'condition'   => array( 'enable_spec_four' => 'true' ),
			'separator'   => 'after'
		) );

		$elementor_object->add_control( 'contents', array(
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'label'       => esc_html__('Contents', 'wdt-elementor-addon'),
			'description' => esc_html__('Contents', 'wdt-elementor-addon' ),
			'fields'      => $repeater->get_controls(),
			'default' => array (
				array (
					'title' => 'Title 1',
					'sub_title' => 'Sub title 1',
					'icon'   => array( 'value' => 'fas fa-star', 'library' => 'fa-solid' ),
					'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
				),
				array (
					'title' => 'Title 2',
					'sub_title' => 'Sub title 2',
					'icon'   => array( 'value' => 'fas fa-star', 'library' => 'fa-solid' ),
					'description' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.'
				),
				array (
					'title' => 'Title 3',
					'sub_title' => 'Sub title 3',
					'icon'   => array( 'value' => 'fas fa-star', 'library' => 'fa-solid' ),
					'description' => 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.'
				)
			)
		) );

		$elementor_object->end_controls_section();

		$this->cc_layout->get_controls($elementor_object);

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
						'{{WRAPPER}} .wdt-specification-block' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
					),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-specification-block' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
										'{{WRAPPER}} .wdt-specification-block, {{WRAPPER}} .wdt-specification-block .wdt-content-title h5, {{WRAPPER}} .wdt-specification-block .wdt-content-title h5 > a, {{WRAPPER}} .wdt-specification-block .wdt-content-subtitle, {{WRAPPER}} .wdt-specification-block .wdt-social-icons-list li a, {{WRAPPER}} .wdt-specification-block .wdt-rating li span, {{WRAPPER}} .wdt-specification-block ul li, {{WRAPPER}} .wdt-specification-block span' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-specification-block, {{WRAPPER}} .wdt-specification-block > div.wdt-content-detail-group:after',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-specification-block > div.wdt-content-detail-group:after',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-specification-block' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-specification-block:hover > div.wdt-content-detail-group:after,
												   {{WRAPPER}} .wdt-active .wdt-specification-block > div.wdt-content-detail-group:after',
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
										'{{WRAPPER}} .wdt-specification-block:hover, {{WRAPPER}} .wdt-specification-block:hover .wdt-content-title h5, {{WRAPPER}} .wdt-specification-block:hover .wdt-content-title h5 > a, {{WRAPPER}} .wdt-specification-block:hover .wdt-content-subtitle, {{WRAPPER}} .wdt-specification-block:hover .wdt-social-icons-list li a, {{WRAPPER}} .wdt-specification-block:hover .wdt-rating li span, {{WRAPPER}} .wdt-specification-block:hover ul li, {{WRAPPER}} .wdt-specification-block:hover span' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-specification-block:hover',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-specification-block:hover',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-specification-block:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-specification-block:hover',
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
					'selector' => '{{WRAPPER}} .wdt-specification-block .wdt-content-title h4',
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-specification-block .wdt-content-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'color' => array (
					'field_type' => 'color',
					'selector' => array (
						'{{WRAPPER}} .wdt-specification-block .wdt-content-title, 
						 {{WRAPPER}} .wdt-specification-block .wdt-content-title h4' => 'color: {{VALUE}};'
					),
					'condition' => array ()
				)
			)
		));

		// Sub Title
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'subtitle',
			'title' => esc_html__( 'Sub Title', 'wdt-elementor-addon' ),
			'styles' => array (
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-specification-block .wdt-content-subtitle',
					'condition' => array ()
				),
				'color' => array (
					'field_type' => 'color',
					'selector' => array (
						'{{WRAPPER}} .wdt-specification-block .wdt-content-subtitle' => 'color: {{VALUE}};'
					),
					'condition' => array ()
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
					'selector' => '{{WRAPPER}} .wdt-specification-block .wdt-content-description',
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-specification-block .wdt-content-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-specification-block .wdt-content-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'color' => array (
					'field_type' => 'color',
					'selector' => array (
						'{{WRAPPER}} .wdt-specification-block .wdt-content-description' => 'color: {{VALUE}};'
					),
					'condition' => array ()
				)
			)
		));

		// Specifications Items
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'specifications_item',
			'title' => esc_html__( 'Specifications Item', 'wdt-elementor-addon' ),
			'styles' => array (
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-specification-block .wdt-content-spec-group .wdt-content-spec-items',
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-specification-block .wdt-content-spec-group .wdt-content-spec-items' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
										'{{WRAPPER}} .wdt-specification-block .wdt-content-spec-group .wdt-content-spec-items, 
										 {{WRAPPER}} .wdt-specification-block .wdt-content-spec-group .wdt-content-spec-items > a' => 'color: {{VALUE}};'
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
										 '{{WRAPPER}} .wdt-specification-block .wdt-content-spec-group .wdt-content-spec-items > a:hover' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
							)
						)
					)
				)
			)
		));

		// Button
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'button',
			'title' => esc_html__( 'Button', 'wdt-elementor-addon' ),
			'styles' => array (
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-specification-block .wdt-content-button > a',
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-specification-block .wdt-content-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-specification-block .wdt-content-button > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
										'{{WRAPPER}} .wdt-specification-block .wdt-content-button > a' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-specification-block .wdt-content-button > a',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-specification-block .wdt-content-button > a',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-specification-block .wdt-content-button > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-specification-block .wdt-content-button > a',
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
										'{{WRAPPER}} .wdt-specification-block .wdt-content-button > a:focus, 
										 {{WRAPPER}} .wdt-specification-block .wdt-content-button > a:hover' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-specification-block .wdt-content-button > a:focus, 
									 			   {{WRAPPER}} .wdt-specification-block .wdt-content-button > a:hover',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-specification-block .wdt-content-button > a:focus, 
									               {{WRAPPER}} .wdt-specification-block .wdt-content-button > a:hover',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-specification-block .wdt-content-button > a:focus, 
										 {{WRAPPER}} .wdt-specification-block .wdt-content-button > a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-specification-block .wdt-content-button > a:focus, 
									 			   {{WRAPPER}} .wdt-specification-block .wdt-content-button > a:hover',
									'condition' => array ()
								)
							)
						)
					)
				)
			)
		));

		// Carousel
        $this->cc_layout->get_carousel_style_controls($elementor_object, array ('layout' => 'carousel'));

	}

	public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}
		
		$output = '';
		$classes = array ();

        $settings['module_id'] = $widget_object->get_id();
        $settings['module_class'] = 'specifications';
        $settings['classes'] = $classes;
		$this->cc_layout->set_settings($settings);
        $module_layout_class_value = $this->cc_layout->get_item_class();
		$module_layout_class = !empty($module_layout_class_value) ? $module_layout_class_value : 'wdt-specification-wrapper';

		if( count( $settings['contents'] ) > 0 ):
			$output .= $this->cc_layout->get_wrapper_start();
			foreach( $settings['contents'] as $key => $item ) {

				$output .= '<div class="'.esc_attr($module_layout_class).'">';
					$output .= '<div class="wdt-content-item">';
						$output .= '<div class="wdt-specification-block '.esc_attr($settings['enable_spec_type']).'">';

							if( (isset($item['image']['url']) && !empty($item['image']['url'])) ) {
								$output .= '<div class="wdt-content-image-wrapper ">';
									$output .= '<div class="wdt-content-image">';
										$image_setting = array ();
										$image_setting['image'] = $item['image'];
										$image_setting['image_size'] = 'full';
										$image_setting['image_custom_dimension'] = isset($item['image_custom_dimension']) ? $item['image_custom_dimension'] : array ();
										$output .= '<a href="'.esc_url( $item['button_link']['url'] ).'" target="_blank" rel="nofollow">';
											$output .= \Elementor\Group_Control_Image_Size::get_attachment_image_html( $image_setting );
										$output .= '</a>';
									$output .= '</div>';
								$output .= '</div>';
							} elseif (isset($item['icon']['value']) && !empty($item['icon']['value'])) {
								$output .= '<div class="wdt-content-icon-wrapper">';
									$output .= '<div class="wdt-content-icon">';
											ob_start();
											\Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] );
											$output .= ob_get_clean();
									$output .= '</div>';
								$output .= '</div>';
							}

							$output .= '<div class="wdt-content-detail-group">';
								if( (isset($item['title']) && !empty($item['title'])) ):
									$output .= '<div class="wdt-content-title"><h4>';
										$output .= esc_html($item['title']);
									$output .= '</h4></div>';
								endif;
								if( (isset($item['sub_title']) && !empty($item['sub_title'])) ):
									$output .= '<div class="wdt-content-subtitle">'.esc_html($item['sub_title']).'</div>';
								endif;
								if( (isset($item['description']) && !empty($item['description'])) ):
									$output .= '<div class="wdt-content-description">'.$item['description'].'</div>';
								endif;

								if( !empty($item['specifications_1_item']) || !empty($item['specifications_2_item']) || !empty($item['specifications_3_item']) || !empty($item['specifications_4_item']) ) {
									$output .= '<div class="wdt-content-spec-group '.$item['enable_spec_alignment'].'">';
										if( isset($item['specifications_1_item']) && !empty($item['specifications_1_item']) ) {
											$output .= '<div class="wdt-content-spec-items">';
												if( isset($item['specifications_1_link']['url']) && !empty($item['specifications_1_link']['url']) ) {
													$output .= '<a href="'. esc_url($item['specifications_1_link']['url']) .'" target="_blank" rel="nofollow">'. esc_html($item['specifications_1_item']) .'</a>';
												} else {
													$output .= esc_html($item['specifications_1_item']);
												}
											$output .= '</div>';
										}
										if( isset($item['specifications_2_item']) && !empty($item['specifications_2_item']) ) {
											$output .= '<div class="wdt-content-spec-items">';
												if( isset($item['specifications_2_link']['url']) && !empty($item['specifications_2_link']['url']) ) {
													$output .= '<a href="'. esc_url($item['specifications_2_link']['url']) .'" target="_blank" rel="nofollow">'. esc_html($item['specifications_2_item']) .'</a>';
												} else {
													$output .= esc_html($item['specifications_2_item']);
												}
											$output .= '</div>';
										}
										if( isset($item['specifications_3_item']) && !empty($item['specifications_3_item']) ) {
											$output .= '<div class="wdt-content-spec-items">';
												if( isset($item['specifications_3_link']['url']) && !empty($item['specifications_3_link']['url']) ) {
													$output .= '<a href="'. esc_url($item['specifications_3_link']['url']) .'" target="_blank" rel="nofollow">'. esc_html($item['specifications_3_item']) .'</a>';
												} else {
													$output .= esc_html($item['specifications_3_item']);
												}
											$output .= '</div>';
										}
										if( isset($item['specifications_4_item']) && !empty($item['specifications_4_item']) ) {
											$output .= '<div class="wdt-content-spec-items">';
												if( isset($item['specifications_4_link']['url']) && !empty($item['specifications_4_link']['url']) ) {
													$output .= '<a href="'. esc_url($item['specifications_4_link']['url']) .'" target="_blank" rel="nofollow">'. esc_html($item['specifications_4_item']) .'</a>';
												} else {
													$output .= esc_html($item['specifications_4_item']);
												}
											$output .= '</div>';
										}
									$output .= '</div>';
								}
								
								if( !empty( $item['button_link']['url'] ) && !empty( $item['button'] ) ){
									$output .= '<div class="wdt-content-button wdt-button-clone">';
										$target = ( $item['button_link']['is_external'] == 'on' ) ? ' target="_blank" ' : '';
										$nofollow = ( $item['button_link']['nofollow'] == 'on' ) ? 'rel="nofollow" ' : '';
										$output .= '<a href="'.esc_url( $item['button_link']['url'] ).'"'. $target . $nofollow.'>'. esc_html( $item['button'] ) .'</a>';
									$output .= '</div>';		
								}

							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';

				$output .= '</div>';

			}

			$output .= $this->cc_layout->get_column_edit_mode_css();
            $output .= $this->cc_layout->get_wrapper_end();

		else:
			$output .= '<div class="wdt-specifications-container no-records">';
				$output .= esc_html__('No records found!', 'wdt-elementor-addon');
			$output .= '</div>';
		endif;

		return $output;

	}

}

if( !function_exists( 'wedesigntech_widget_base_specifications' ) ) {
    function wedesigntech_widget_base_specifications() {
        return WeDesignTech_Widget_Base_Specifications::instance();
    }
}