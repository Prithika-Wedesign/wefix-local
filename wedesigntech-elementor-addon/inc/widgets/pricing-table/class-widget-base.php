<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Pricing_Table {

	private static $_instance = null;

	private $cc_content_position;
	private $cc_style;
	private $cc_repeater_contents;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	function __construct() {

		// Group 1 content positions
			$group1_content_position_elements = array(
				'media'    => esc_html__( 'Media', 'wdt-elementor-addon'),
				'header'   => esc_html__( 'Header', 'wdt-elementor-addon'),
				'pricing'  => esc_html__( 'Pricing', 'wdt-elementor-addon'),
				'features' => esc_html__( 'Features', 'wdt-elementor-addon'),
				'footer'   => esc_html__( 'Footer', 'wdt-elementor-addon')
			);
			$group1_content_positions = wedesigntech_elementor_format_repeater_values($group1_content_position_elements);

		// Group 1 - Element Group content positions
			$group1_element_group_content_position_elements = array();
			$group1_element_group_content_positions = array();


		// Group 2 content positions
			$group2_content_position_elements = array();
			$group2_content_positions = array();

		// Group 2 - Element Group content positions
			$group2_element_group_content_position_elements = array();
			$group2_element_group_content_positions = array();


		// Content position elements
			$content_position_elements = array_merge($group1_content_position_elements, $group1_element_group_content_position_elements, $group2_content_position_elements, $group2_element_group_content_position_elements);

		// Module Details
			$module_details = array(
				'content_positions' => array ( 'group1' ),
				'group1_title'      => esc_html__( 'Elements', 'wdt-elementor-addon'),
				'group2_title'      => '',
				'group_cp_label'    => '',
				'group_eg_cp_label' => '',
				'jsSlug'            => 'wdtRepeaterPricingTableContent',
				'title'             => esc_html__( 'Pricing Table Items', 'wdt-elementor-addon' ),
				'description'       => ''
			);

		// Initialize depandant class
			$this->cc_repeater_contents = new WeDesignTech_Common_Controls_Repeater_Contents(array (), array (), array (), array ());
			$this->cc_content_position = new WeDesignTech_Common_Controls_Content_Position($content_position_elements, $group1_content_positions, $group1_element_group_content_positions, $group2_content_positions, $group2_element_group_content_positions, $module_details);
			$this->cc_style = new WeDesignTech_Common_Controls_Style();

		// Actions & Filters
			add_filter( 'wdt_elementor_localize_settings', array( $this, 'wdt_register_elementor_localize_settings' )  );

	}

	public function name() {
		return 'wdt-pricing-table';
	}

	public function title() {
		return esc_html__( 'Pricing Table', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'wdt-widget-icon';
	}

	public function init_styles() {
		return array (
				$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/pricing-table/assets/css/style.css'
			);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array ();
	}

	public function wdt_register_elementor_localize_settings($settings) {
		$settings['wdtPricingTableItems'] = array(
			'title'       => esc_html__( 'Title', 'wdt-elementor-addon'),
			'subtitle'    => esc_html__( 'Sub Title', 'wdt-elementor-addon'),
			'button'      => esc_html__( 'Button', 'wdt-elementor-addon'),
			'description' => esc_html__( 'Description', 'wdt-elementor-addon')
		);
		return $settings;
	}

	public function create_elementor_controls($elementor_object) {

		// Media

			$elementor_object->start_controls_section( 'wdt_section_media', array(
				'label' => esc_html__( 'Media', 'wdt-elementor-addon'),
				'condition' => array (
					'template!' => array ('list', 'classic', 'default'),
				),
			) );

				$elementor_object->add_control(
					'media_element',
					array (
						'label' => esc_html__( 'Media Element', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::CHOOSE,
						'label_block' => false,
						'options' => array (
							'none' => array (
								'title' => esc_html__( 'None', 'wdt-elementor-addon' ),
								'icon' => 'fas fa-ban'
							),
							'image' => array (
								'title' => esc_html__( 'Image', 'wdt-elementor-addon' ),
								'icon' => 'far fa-image'
							),
							'icon' => array (
								'title' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
								'icon' => 'fas fa-star'
							),
						),
						'default' => 'icon',
					)
				);

				$elementor_object->add_control(
					'media_image',
					array (
						'label' => esc_html__( 'Choose Image', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::MEDIA,
						'default' => array (
							'url' => \Elementor\Utils::get_placeholder_image_src(),
						),
						'condition' => array (
							'media_element' => 'image',
						),
					)
				);

				$elementor_object->add_control(
					'media_icon',
					array (
						'label' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::ICONS,
						'default' => array( 'value' => 'fas fa-star', 'library' => 'fa-solid' ),
						'condition' => array (
							'media_element' => 'icon',
						),
					)
				);

			$elementor_object->end_controls_section();

		// Header

			$elementor_object->start_controls_section( 'wdt_section_header', array(
				'label' => esc_html__( 'Header', 'wdt-elementor-addon'),
			) );

				$elementor_object->add_control( 'title', array(
					'label'       => esc_html__( 'Title', 'wdt-elementor-addon' ),
					'type'        => \Elementor\Controls_Manager::TEXT,
					'label_block' => true,
					'placeholder' => esc_html__( 'Your title goes here', 'wdt-elementor-addon' ),
					'default'     => esc_html__( 'Architecto beatae', 'wdt-elementor-addon' )
				) );

				$elementor_object->add_control( 'sub_title', array(
					'label'       => esc_html__( 'Sub Title', 'wdt-elementor-addon' ),
					'type'        => \Elementor\Controls_Manager::TEXT,
					'label_block' => true,
					'placeholder' => esc_html__( 'Your sub title goes here', 'wdt-elementor-addon' ),
					'default'     => ''
				) );

				// Postions
				$header_positions = new \Elementor\Repeater();
				$header_positions->add_control( 'element_value', array(
					'type'    => \Elementor\Controls_Manager::SELECT,
					'label'   => esc_html__('Element', 'wdt-elementor-addon'),
					'default' => 'title',
					'options' => array(
						'title' => esc_html__( 'Title', 'wdt-elementor-addon'),
						'subtitle' => esc_html__( 'Sub Title', 'wdt-elementor-addon')
					)
				) );
				$elementor_object->add_control( 'header_positions', array(
					'type'          => \Elementor\Controls_Manager::REPEATER,
					'label'         => esc_html__('Positions', 'wdt-elementor-addon'),
					'fields'        => $header_positions->get_controls(),
					'default'       =>  array(
						array(
							'element_value' => 'title'
						),
						array(
							'element_value' => 'subtitle'
						)
					),
					'prevent_empty' => true,
					'title_field'   => '{{ wdtGetPricingTableItems( obj ) }}'
				) );

			$elementor_object->end_controls_section();

		// Pricing

			$elementor_object->start_controls_section( 'wdt_section_pricing', array(
				'label' => esc_html__( 'Pricing', 'wdt-elementor-addon'),
			) );

				$elementor_object->add_control(
					'currency_symbol',
					array(
						'label' => esc_html__( 'Currency Symbol', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => array(
							'' => esc_html__( 'None', 'wdt-elementor-addon' ),
							'dollar' => '&#36; ' . _x( 'Dollar', 'Currency', 'wdt-elementor-addon' ),
							'euro' => '&#128; ' . _x( 'Euro', 'Currency', 'wdt-elementor-addon' ),
							'baht' => '&#3647; ' . _x( 'Baht', 'Currency', 'wdt-elementor-addon' ),
							'franc' => '&#8355; ' . _x( 'Franc', 'Currency', 'wdt-elementor-addon' ),
							'guilder' => '&fnof; ' . _x( 'Guilder', 'Currency', 'wdt-elementor-addon' ),
							'krona' => 'kr ' . _x( 'Krona', 'Currency', 'wdt-elementor-addon' ),
							'lira' => '&#8356; ' . _x( 'Lira', 'Currency', 'wdt-elementor-addon' ),
							'peseta' => '&#8359 ' . _x( 'Peseta', 'Currency', 'wdt-elementor-addon' ),
							'peso' => '&#8369; ' . _x( 'Peso', 'Currency', 'wdt-elementor-addon' ),
							'pound' => '&#163; ' . _x( 'Pound Sterling', 'Currency', 'wdt-elementor-addon' ),
							'real' => 'R$ ' . _x( 'Real', 'Currency', 'wdt-elementor-addon' ),
							'ruble' => '&#8381; ' . _x( 'Ruble', 'Currency', 'wdt-elementor-addon' ),
							'rupee' => '&#8360; ' . _x( 'Rupee', 'Currency', 'wdt-elementor-addon' ),
							'indian_rupee' => '&#8377; ' . _x( 'Rupee (Indian)', 'Currency', 'wdt-elementor-addon' ),
							'shekel' => '&#8362; ' . _x( 'Shekel', 'Currency', 'wdt-elementor-addon' ),
							'yen' => '&#165; ' . _x( 'Yen/Yuan', 'Currency', 'wdt-elementor-addon' ),
							'won' => '&#8361; ' . _x( 'Won', 'Currency', 'wdt-elementor-addon' ),
							'custom' => esc_html__( 'Custom', 'wdt-elementor-addon' ),
						),
						'default' => 'dollar',
					)
				);

				$elementor_object->add_control(
					'custom_symbol',
					array(
						'type'    => \Elementor\Controls_Manager::TEXT,
						'label'   => esc_html__('Custom Symbol', 'wdt-elementor-addon'),
						'default' => '',
						'condition' => array(
							'currency_symbol' => 'custom',
						)
					)
				);

				$elementor_object->add_control(
					'price',
					array(
						'label'   => esc_html__( 'Price', 'wdt-elementor-addon' ),
						'type'    => \Elementor\Controls_Manager::NUMBER,
						'min'     => 0,
						'default' => 39.99
					)
				);

				$elementor_object->add_control(
					'period',
					array(
						'type'    => \Elementor\Controls_Manager::TEXT,
						'label'   => esc_html__('Period', 'wdt-elementor-addon'),
						'default' => '/mo'
					)
				);

				$elementor_object->add_control(
					'currency_format',
					array(
						'label' => esc_html__( 'Currency Format', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => array(
							'' => '1,234.56 (Default)',
							',' => '1.234,56',
						),
						'default' => ''
					)
				);

				$elementor_object->add_control( 'show_original_price', array(
					'label' => esc_html__( 'Show Original Price', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'default' => '',
					'frontend_available' => true
				) );

				$elementor_object->add_control(
					'original_price',
					array(
						'label'   => esc_html__( 'Original Price', 'wdt-elementor-addon' ),
						'type'    => \Elementor\Controls_Manager::NUMBER,
						'min' => 0,
						'default' => 59,
						'condition' => array ( 'show_original_price' => 'yes' )
					)
				);

			$elementor_object->end_controls_section();


		// Features

			$elementor_object->start_controls_section( 'wdt_section_features', array(
				'label' => esc_html__( 'Features', 'wdt-elementor-addon'),
			) );

				$elementor_object->add_control(
					'feature_title',
					array(
						'type'    => \Elementor\Controls_Manager::TEXT,
						'label'   => esc_html__('Feature Title', 'wdt-elementor-addon'),
						'default' => 'Feature Title'
					)
				);

				$repeater = new \Elementor\Repeater();

				$repeater->add_control(
					'text',
					array(
						'type'    => \Elementor\Controls_Manager::TEXT,
						'label'   => esc_html__('Text', 'wdt-elementor-addon'),
						'default' => ''
					)
				);

				$repeater->add_control( 'included', array(
					'label' => esc_html__( 'Included', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'default' => 'yes',
					'frontend_available' => true
				) );

				$repeater->add_control(
					'media_icon',
					array (
						'label' => esc_html__( 'Included / Excluded Icon', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::ICONS,
						'default' => array( 'value' => 'fas fa-check', 'library' => 'fa-solid' )
					)
				);

				$elementor_object->add_control( 'features_content', array(
					'type'        => \Elementor\Controls_Manager::REPEATER,
					'label'       => esc_html__('Feature Items', 'wdt-elementor-addon'),
					'description' => esc_html__('Feature Items', 'wdt-elementor-addon' ),
					'fields'      => $repeater->get_controls(),
					'default' => array (
						array (
							'text'     => esc_html__('Sed ut perspiciatis', 'wdt-elementor-addon' ),
							'included' => 'yes',
							'media_icon' => array( 'value' => 'fas fa-check', 'library' => 'fa-solid' )
						),
						array (
							'text'     => esc_html__('Unde omnis iste', 'wdt-elementor-addon' ),
							'included' => 'yes',
							'media_icon' => array( 'value' => 'fas fa-check', 'library' => 'fa-solid' )
						),
						array (
							'text'     => esc_html__('Natus error sit', 'wdt-elementor-addon' ),
							'included' => 'yes',
							'media_icon' => array( 'value' => 'fas fa-check', 'library' => 'fa-solid' )
						),
						array (
							'text'     => esc_html__('Eaque ipsa quae ab', 'wdt-elementor-addon' ),
							'included' => 'yes',
							'media_icon' => array( 'value' => 'fas fa-check', 'library' => 'fa-solid' )
						),
						array (
							'text'     => esc_html__('Illo inventore veritatis', 'wdt-elementor-addon' ),
							'included' => 'no',
							'media_icon' => array( 'value' => 'fas fa-times', 'library' => 'fa-solid' )
						)
					),
					'title_field' => '{{{text}}}'
				) );

			$elementor_object->end_controls_section();

		// Footer

			$elementor_object->start_controls_section( 'wdt_section_footer', array(
				'label' => esc_html__( 'Footer', 'wdt-elementor-addon'),
			) );

				$elementor_object->add_control( 'footer_button_text', array(
					'label'     => esc_html__( 'Button Text', 'wdt-elementor-addon' ),
					'type'      => \Elementor\Controls_Manager::TEXT,
					'label_block' => true,
					'default'   => esc_html__( 'Buy Now', 'wdt-elementor-addon' )
				) );

				$elementor_object->add_control( 'footer_link', array(
					'label'       => esc_html__( 'Link', 'wdt-elementor-addon' ),
					'type'        => \Elementor\Controls_Manager::URL,
					'label_block' => true,
					'default' => array (
						'url' => '#',
					),
					'placeholder' => esc_html__( 'https://your-link.com', 'wdt-elementor-addon' )
				) );

				$elementor_object->add_control(
					'footer_description',
					array (
						'label' => esc_html__( 'Description', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::TEXTAREA,
						'default' => '',
						'placeholder' => esc_html__( 'Enter your description', 'wdt-elementor-addon' ),
						'separator' => 'none',
						'rows' => 10
					)
				);

				// Postions
				$footer_positions = new \Elementor\Repeater();
				$footer_positions->add_control( 'element_value', array(
					'type'    => \Elementor\Controls_Manager::SELECT,
					'label'   => esc_html__('Element', 'wdt-elementor-addon'),
					'default' => 'button',
					'options' => array(
						'button' => esc_html__( 'Button', 'wdt-elementor-addon'),
						'description' => esc_html__( 'Description', 'wdt-elementor-addon')
					)
				) );
				$elementor_object->add_control( 'footer_positions', array(
					'type'          => \Elementor\Controls_Manager::REPEATER,
					'label'         => esc_html__('Positions', 'wdt-elementor-addon'),
					'fields'        => $footer_positions->get_controls(),
					'default'       =>  array(
						array(
							'element_value' => 'button'
						),
						array(
							'element_value' => 'description'
						)
					),
					'prevent_empty' => true,
					'title_field'   => '{{ wdtGetPricingTableItems( obj ) }}'
				) );

			$elementor_object->end_controls_section();

		// Badge

			$elementor_object->start_controls_section( 'wdt_section_badge', array(
				'label' => esc_html__( 'Badge', 'wdt-elementor-addon'),
			) );

				$elementor_object->add_control( 'show_badge', array(
					'label' => esc_html__( 'Show Badge', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'default' => 'no',
					'return_value' => 'yes',
					'frontend_available' => true
				) );

				$elementor_object->add_control( 'badge_type', array(
					'label'   => esc_html__( 'Badge Type', 'wdt-elementor-addon' ),
					'type'    => \Elementor\Controls_Manager::SELECT2,
					'default' => 'type1',
					'options' => array(
						'type1'  => esc_html__( 'Type 1', 'wdt-elementor-addon' ),
						'type2'  => esc_html__( 'Type 2', 'wdt-elementor-addon' ),
						'type3'  => esc_html__( 'Type 3', 'wdt-elementor-addon' ),
						'type4'  => esc_html__( 'Type 4', 'wdt-elementor-addon' )
					),
					'condition' => array ( 'show_badge' => 'yes' )
				) );

				$elementor_object->add_control( 'badge_position', array(
					'label'   => esc_html__( 'Badge Position', 'wdt-elementor-addon' ),
					'type'    => \Elementor\Controls_Manager::SELECT2,
					'default' => 'left',
					'options' => array(
						'left'  => esc_html__( 'Left', 'wdt-elementor-addon' ),
						'right'  => esc_html__( 'Right', 'wdt-elementor-addon' )
					),
					'condition' => array (
						'show_badge' => 'yes'
					)
				) );

				$elementor_object->add_control( 'badge_text', array(
					'label'     => esc_html__( 'Badge Text', 'wdt-elementor-addon' ),
					'type'      => \Elementor\Controls_Manager::TEXT,
					'default'   => esc_html__( 'New', 'wdt-elementor-addon' ),
					'condition' => array ( 'show_badge' => 'yes' )
				) );

			$elementor_object->end_controls_section();

		// Settings

			$elementor_object->start_controls_section( 'wdt_section_settings', array(
				'label' => esc_html__( 'Settings', 'wdt-elementor-addon'),
			) );

				$elementor_object->add_control( 'template', array(
					'label'   => esc_html__( 'Template', 'wdt-elementor-addon' ),
					'type'    => \Elementor\Controls_Manager::SELECT2,
					'default' => 'default',
					'options' => array(
						'default'  => esc_html__( 'Default', 'wdt-elementor-addon' ),
						'classic'  => esc_html__( 'Classic', 'wdt-elementor-addon' ),
						'list'  => esc_html__( 'List', 'wdt-elementor-addon' ),
						'custom-template' => esc_html__( 'Custom Template', 'wdt-elementor-addon' )
					)
				) );

			$elementor_object->end_controls_section();

		// Content Positions

			$this->cc_content_position->get_controls($elementor_object, array ( 'template' => 'custom-template' ));

		// Styles

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
								'{{WRAPPER}} .wdt-pricing-table-holder' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
							),
							'condition' => array ()
						),
						'margin' => array (
							'field_type' => 'margin',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'padding' => array (
							'field_type' => 'padding',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
												'{{WRAPPER}} .wdt-pricing-table-holder' => 'color: {{VALUE}};'
											),
											'condition' => array ()
										),
										'background' => array (
											'field_type' => 'background',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder',
											'condition' => array ()
										),
										'border' => array (
											'field_type' => 'border',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder',
											'condition' => array ()
										),
										'border_radius' => array (
											'field_type' => 'border_radius',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
											),
											'condition' => array ()
										),
										'box_shadow' => array (
											'field_type' => 'box_shadow',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder',
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
												'{{WRAPPER}} .wdt-pricing-table-holder:hover' => 'color: {{VALUE}};'
											),
											'condition' => array ()
										),
										'background' => array (
											'field_type' => 'background',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder:hover',
											'condition' => array ()
										),
										'border' => array (
											'field_type' => 'border',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder:hover',
											'condition' => array ()
										),
										'border_radius' => array (
											'field_type' => 'border_radius',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
											),
											'condition' => array ()
										),
										'box_shadow' => array (
											'field_type' => 'box_shadow',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder:hover',
											'condition' => array ()
										)
									)
								)
							)
						)
					)
				));

			// Media
				$this->cc_style->get_style_controls($elementor_object, array (
					'slug' => 'media',
					'title' => esc_html__( 'Media', 'wdt-elementor-addon' ),
					'condition' => array (
						'template!' => array ('list', 'classic', 'default'),
					),
					'styles' => array (
						'alignment' => array (
							'field_type' => 'alignment',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-media' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
							),
							'condition' => array ()
						),
						'margin' => array (
							'field_type' => 'margin',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-media' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'padding' => array (
							'field_type' => 'padding',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-media' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-media',
											'condition' => array ()
										),
										'border' => array (
											'field_type' => 'border',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-media',
											'condition' => array ()
										),
										'border_radius' => array (
											'field_type' => 'border_radius',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
											),
											'condition' => array ()
										),
										'box_shadow' => array (
											'field_type' => 'box_shadow',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-media',
											'condition' => array ()
										)
									)
								),
								'hover' => array (
									'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
									'styles' => array (
										'background' => array (
											'field_type' => 'background',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder:hover  .wdt-pricing-table-media',
											'condition' => array ()
										),
										'border' => array (
											'field_type' => 'border',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder:hover  .wdt-pricing-table-media',
											'condition' => array ()
										),
										'border_radius' => array (
											'field_type' => 'border_radius',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder:hover  .wdt-pricing-table-media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
											),
											'condition' => array ()
										),
										'box_shadow' => array (
											'field_type' => 'box_shadow',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder:hover  .wdt-pricing-table-media',
											'condition' => array ()
										)
									)
								)
							)
						),

						'heading_image' => array (
							'field_type' => 'heading',
							'unique_key' => 'image',
							'title' => esc_html__( 'Image', 'wdt-elementor-addon' ),
							'condition' => array (
								'media_element' => 'image',
							),
							'separator'=> 'before'
						),
						'width_image' => array (
							'field_type' => 'width',
							'unique_key' => 'image',
							'default' => array (
								'unit' => 'px'
							),
							'size_units' => array ( 'px' ),
							'range' => array (
								'px' => array (
									'min' => 1,
									'max' => 500,
								)
							),
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-media .wdt-content-image span' => 'width: {{SIZE}}{{UNIT}};'
							),
							'condition' => array (
								'media_element' => 'image',
							),
						),
						'height_image' => array (
							'field_type' => 'height',
							'unique_key' => 'image',
							'default' => array (
								'unit' => 'px'
							),
							'size_units' => array ( 'px' ),
							'range' => array (
								'px' => array (
									'min' => 1,
									'max' => 500,
								)
							),
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-media .wdt-content-image span' => 'height: {{SIZE}}{{UNIT}};',
							),
							'condition' => array (
								'media_element' => 'image',
							),
						),
						'tabs_image' => array (
							'field_type' => 'tabs',
							'unique_key' => 'image',
							'tab_items' => array (
								'normal' => array (
									'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
									'condition' => array (
										'media_element' => 'image',
									),
									'styles' => array (
										'color' => array (
											'field_type' => 'color',
											'label' => esc_html__( 'Overlay Color', 'wdt-elementor-addon' ),
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-media .wdt-content-image span:before' => 'background-color: {{VALUE}};'
											),
											'condition' => array (
												'media_element' => 'image',
											),
										),
										'border' => array (
											'field_type' => 'border',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-media .wdt-content-image span',
											'condition' => array (
												'media_element' => 'image',
											),
										),
										'border_radius' => array (
											'field_type' => 'border_radius',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-media .wdt-content-image span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
											),
											'condition' => array (
												'media_element' => 'image',
											),
										),
										'box_shadow' => array (
											'field_type' => 'box_shadow',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-media .wdt-content-image span',
											'condition' => array (
												'media_element' => 'image',
											),
										)
									)
								),
								'hover' => array (
									'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
									'condition' => array (
										'media_element' => 'image',
									),
									'styles' => array (
										'color' => array (
											'field_type' => 'color',
											'label' => esc_html__( 'Overlay Color', 'wdt-elementor-addon' ),
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-media .wdt-content-image span:before' => 'background-color: {{VALUE}};'
											),
											'condition' => array (
												'media_element' => 'image',
											),
										),
										'border' => array (
											'field_type' => 'border',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-media .wdt-content-image span',
											'condition' => array (
												'media_element' => 'image',
											),
										),
										'border_radius' => array (
											'field_type' => 'border_radius',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-media .wdt-content-image span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
											),
											'condition' => array (
												'media_element' => 'image',
											),
										),
										'box_shadow' => array (
											'field_type' => 'box_shadow',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-media .wdt-content-image span',
											'condition' => array (
												'media_element' => 'image',
											),
										)
									)
								)
							)
						),

						'heading_icon' => array (
							'field_type' => 'heading',
							'unique_key' => 'icon',
							'title' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
							'condition' => array (
								'media_element' => 'icon',
							)
						),
						'font_size_icon' => array (
							'field_type' => 'font_size',
							'unique_key' => 'icon',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-media .wdt-content-icon-wrapper .wdt-content-icon span' => 'font-size: {{SIZE}}{{UNIT}};'
							),
							'condition' => array (
								'media_element' => 'icon',
							),
						),
						'width_icon' => array (
							'field_type' => 'width',
							'unique_key' => 'icon',
							'default' => array (
								'unit' => 'px'
							),
							'size_units' => array ( 'px' ),
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-media .wdt-content-icon-wrapper .wdt-content-icon span' => 'width: {{SIZE}}{{UNIT}};'
							),
							'condition' => array (
								'media_element' => 'icon',
							),
						),
						'height_icon' => array (
							'field_type' => 'height',
							'unique_key' => 'icon',
							'default' => array (
								'unit' => 'px'
							),
							'size_units' => array ( 'px' ),
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-media .wdt-content-icon-wrapper .wdt-content-icon span' => 'height: {{SIZE}}{{UNIT}};'
							),
							'condition' => array (
								'media_element' => 'icon',
							),
						),
						'tabs_icon' => array (
							'field_type' => 'tabs',
							'unique_key' => 'icon',
							'tab_items' => array (
								'normal' => array (
									'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
									'condition' => array (
										'media_element' => 'icon',
									),
									'styles' => array (
										'color' => array (
											'field_type' => 'color',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-media .wdt-content-icon-wrapper .wdt-content-icon span' => 'color: {{VALUE}};'
											),
											'condition' => array (
												'media_element' => 'icon',
											),
										),
										'background' => array (
											'field_type' => 'background',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-media .wdt-content-icon-wrapper .wdt-content-icon span:before',
											'condition' => array (
												'media_element' => 'icon',
											),
										),
										'border' => array (
											'field_type' => 'border',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-media .wdt-content-icon-wrapper .wdt-content-icon span:before',
											'condition' => array (
												'media_element' => 'icon',
											),
										),
										'border_radius' => array (
											'field_type' => 'border_radius',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-media .wdt-content-icon-wrapper .wdt-content-icon span:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
											),
											'condition' => array (
												'media_element' => 'icon',
											),
										),
										'box_shadow' => array (
											'field_type' => 'box_shadow',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-media .wdt-content-icon-wrapper .wdt-content-icon span:before',
											'condition' => array (
												'media_element' => 'icon',
											),
										)
									)
								),
								'hover' => array (
									'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
									'condition' => array (
										'media_element' => 'icon',
									),
									'styles' => array (
										'color' => array (
											'field_type' => 'color',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-media .wdt-content-icon-wrapper .wdt-content-icon span' => 'color: {{VALUE}};'
											),
											'condition' => array (
												'media_element' => 'icon',
											),
										),
										'background' => array (
											'field_type' => 'background',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-media .wdt-content-icon-wrapper .wdt-content-icon span:before',
											'condition' => array (
												'media_element' => 'icon',
											),
										),
										'border' => array (
											'field_type' => 'border',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-media .wdt-content-icon-wrapper .wdt-content-icon span:before',
											'condition' => array (
												'media_element' => 'icon',
											),
										),
										'border_radius' => array (
											'field_type' => 'border_radius',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-media .wdt-content-icon-wrapper .wdt-content-icon span:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
											),
											'condition' => array (
												'media_element' => 'icon',
											),
										),
										'box_shadow' => array (
											'field_type' => 'box_shadow',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-media .wdt-content-icon-wrapper .wdt-content-icon span',
											'condition' => array (
												'media_element' => 'icon',
											),
										)
									)
								)
							)
						),



					)
				));

			// Header
				$this->cc_style->get_style_controls($elementor_object, array (
					'slug' => 'header',
					'title' => esc_html__( 'Header', 'wdt-elementor-addon' ),
					'styles' => array (
						'alignment' => array (
							'field_type' => 'alignment',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-header' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
							),
							'condition' => array ()
						),
						'margin' => array (
							'field_type' => 'margin',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'padding' => array (
							'field_type' => 'padding',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-header',
											'condition' => array ()
										),
										'border' => array (
											'field_type' => 'border',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-header',
											'condition' => array ()
										),
										'border_radius' => array (
											'field_type' => 'border_radius',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
											),
											'condition' => array ()
										)
									)
								),
								'hover' => array (
									'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
									'styles' => array (
										'background' => array (
											'field_type' => 'background',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-header',
											'condition' => array ()
										),
										'border' => array (
											'field_type' => 'border',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-header',
											'condition' => array ()
										),
										'border_radius' => array (
											'field_type' => 'border_radius',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
											),
											'condition' => array ()
										)
									)
								)
							)
						),
						'heading_title' => array (
							'field_type' => 'heading',
							'unique_key' => 'title',
							'title' => esc_html__( 'Title', 'wdt-elementor-addon' ),
							'condition' => array (),
							'separator' => 'before'
						),
						'typography_title' => array (
							'field_type' => 'typography',
							'unique_key' => 'title',
							'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-header .wdt-content-title h5',
							'condition' => array ()
						),
						'margin_title' => array (
							'field_type' => 'margin',
							'unique_key' => 'title',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-header .wdt-content-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'tabs_title' => array (
							'field_type' => 'tabs',
							'unique_key' => 'title',
							'tab_items' => array (
								'normal' => array (
									'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
									'styles' => array (
										'color' => array (
											'field_type' => 'color',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-header .wdt-content-title h5, {{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-header .wdt-content-title h5 > a' => 'color: {{VALUE}};'
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
												'{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-header .wdt-content-title h5, {{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-header .wdt-content-title h5 > a' => 'color: {{VALUE}};'
											),
											'condition' => array ()
										),
									)
								)
							)
						),
						'heading_subtitle' => array (
							'field_type' => 'heading',
							'unique_key' => 'subtitle',
							'title' => esc_html__( 'Sub Title', 'wdt-elementor-addon' ),
							'condition' => array (),
							'separator' => 'before'
						),
						'typography_subtitle' => array (
							'field_type' => 'typography',
							'unique_key' => 'subtitle',
							'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-header .wdt-content-subtitle',
							'condition' => array ()
						),
						'margin_subtitle' => array (
							'field_type' => 'margin',
							'unique_key' => 'subtitle',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-header .wdt-content-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'tabs_subtitle' => array (
							'field_type' => 'tabs',
							'unique_key' => 'subtitle',
							'tab_items' => array (
								'normal' => array (
									'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
									'styles' => array (
										'color' => array (
											'field_type' => 'color',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-header .wdt-content-subtitle' => 'color: {{VALUE}};'
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
												'{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-header .wdt-content-subtitle' => 'color: {{VALUE}};'
											),
											'condition' => array ()
										),
									)
								)
							)
						)
					)
				));

			// Pricing
				$this->cc_style->get_style_controls($elementor_object, array (
					'slug' => 'pricing',
					'title' => esc_html__( 'Pricing', 'wdt-elementor-addon' ),
					'styles' => array (
						'alignment' => array (
							'field_type' => 'alignment',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-pricing' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
							),
							'condition' => array (
								'template!' => 'list',
							),
						),
						'margin' => array (
							'field_type' => 'margin',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-pricing' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array (
								'template!' => 'list',
							),
						),
						'padding' => array (
							'field_type' => 'padding',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-pricing' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array (
								'template!' => 'list',
							),
						),
						'tabs' => array (
							'field_type' => 'tabs',
							'condition' => array (
								'template!' => 'list',
							),
							'tab_items' => array (
								'normal' => array (
									'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
									'styles' => array (
										'color' => array (
											'field_type' => 'color',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-pricing' => 'color: {{VALUE}};'
											),
											'condition' => array ()
										),
										'background' => array (
											'field_type' => 'background',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-pricing',
											'condition' => array ()
										),
										'border' => array (
											'field_type' => 'border',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-pricing',
											'condition' => array ()
										),
										'border_radius' => array (
											'field_type' => 'border_radius',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-pricing' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
											),
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
												'{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-pricing' => 'color: {{VALUE}};'
											),
											'condition' => array ()
										),
										'background' => array (
											'field_type' => 'background',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-pricing',
											'condition' => array ()
										),
										'border' => array (
											'field_type' => 'border',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-pricing',
											'condition' => array ()
										),
										'border_radius' => array (
											'field_type' => 'border_radius',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-pricing' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
											),
											'condition' => array ()
										)
									)
								)
							)
						),

						'heading_price' => array (
							'field_type' => 'heading',
							'unique_key' => 'price',
							'title' => esc_html__( 'Price', 'wdt-elementor-addon' ),
							'condition' => array (),
							'separator' => 'before'
						),
						'typography_price' => array (
							'field_type' => 'typography',
							'unique_key' => 'price',
							'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-pricing .wdt-pricing-table-pricing-sale .wdt-pricing-table-pricing-prefix, {{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-pricing .wdt-pricing-table-pricing-sale .wdt-pricing-table-pricing-sale-price, {{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-pricing .wdt-pricing-table-pricing-sale .wdt-pricing-table-pricing-sale-fraction, {{WRAPPER}} .wdt-pricing-table-holder.wdt-template-list .wdt-pricing-table-pricing-inner .wdt-pricing-table-pricing-sale .wdt-pricing-table-pricing-prefix, {{WRAPPER}} .wdt-pricing-table-holder.wdt-template-list .wdt-pricing-table-pricing-inner .wdt-pricing-table-pricing-sale .wdt-pricing-table-pricing-sale-price, {{WRAPPER}} .wdt-pricing-table-holder.wdt-template-list .wdt-pricing-table-pricing-inner .wdt-pricing-table-pricing-sale .wdt-pricing-table-pricing-sale-fraction',
							'condition' => array ()
						),

						'heading_currency_symbol' => array (
							'field_type' => 'heading',
							'unique_key' => 'currency_symbol',
							'title' => esc_html__( 'Currency Symbol', 'wdt-elementor-addon' ),
							'condition' => array (),
							'separator' => 'before'
						),
						'font_size_currency_symbol' => array (
							'field_type' => 'font_size',
							'unique_key' => 'currency_symbol',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-pricing .wdt-pricing-table-pricing-sale .wdt-pricing-table-pricing-prefix, {{WRAPPER}} .wdt-pricing-table-holder.wdt-template-list .wdt-pricing-table-pricing-inner .wdt-pricing-table-pricing-sale .wdt-pricing-table-pricing-prefix' => 'font-size: {{SIZE}}{{UNIT}};'
							),
							'condition' => array ()
						),
						'vertical_align_currency_symbol' => array (
							'field_type' => 'vertical_align',
							'unique_key' => 'currency_symbol',
							'label' => esc_html__( 'Vertical Position', 'wdt-elementor-addon' ),
							'options' => array (
								'top' => array (
									'title' => esc_html__( 'Top', 'wdt-elementor-addon' ),
									'icon' => 'eicon-v-align-top',
								),
								'middle' => array (
									'title' => esc_html__( 'Middle', 'wdt-elementor-addon' ),
									'icon' => 'eicon-v-align-middle',
								),
								'baseline' => array (
									'title' => esc_html__( 'Bottom', 'wdt-elementor-addon' ),
									'icon' => 'eicon-v-align-bottom',
								)
							),
							'default' => 'middle',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-pricing .wdt-pricing-table-pricing-sale .wdt-pricing-table-pricing-prefix, {{WRAPPER}} .wdt-pricing-table-holder.wdt-template-list .wdt-pricing-table-pricing-inner .wdt-pricing-table-pricing-sale .wdt-pricing-table-pricing-prefix' => 'vertical-align: {{VALUE}};'
							),
							'condition' => array ()
						),
						'horizontal_align_currency_symbol' => array (
							'field_type' => 'horizontal_align',
							'unique_key' => 'currency_symbol',
							'label' => esc_html__( 'Horizontal Position', 'wdt-elementor-addon' ),
							'condition' => array ()
						),

						'heading_fraction' => array (
							'field_type' => 'heading',
							'unique_key' => 'fraction',
							'title' => esc_html__( 'Fraction', 'wdt-elementor-addon' ),
							'condition' => array (),
							'separator' => 'before'
						),
						'font_size_fraction' => array (
							'field_type' => 'font_size',
							'unique_key' => 'fraction',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-pricing .wdt-pricing-table-pricing-sale .wdt-pricing-table-pricing-sale-fraction, {{WRAPPER}} .wdt-pricing-table-holder.wdt-template-list .wdt-pricing-table-pricing-inner .wdt-pricing-table-pricing-sale .wdt-pricing-table-pricing-sale-fraction' => 'font-size: {{SIZE}}{{UNIT}};'
							),
							'condition' => array ()
						),
						'vertical_align_fraction' => array (
							'field_type' => 'vertical_align',
							'unique_key' => 'fraction',
							'label' => esc_html__( 'Vertical Position', 'wdt-elementor-addon' ),
							'options' => array (
								'top' => array (
									'title' => esc_html__( 'Top', 'wdt-elementor-addon' ),
									'icon' => 'eicon-v-align-top',
								),
								'middle' => array (
									'title' => esc_html__( 'Middle', 'wdt-elementor-addon' ),
									'icon' => 'eicon-v-align-middle',
								),
								'baseline' => array (
									'title' => esc_html__( 'Bottom', 'wdt-elementor-addon' ),
									'icon' => 'eicon-v-align-bottom',
								)
							),
							'default' => 'middle',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-pricing .wdt-pricing-table-pricing-sale .wdt-pricing-table-pricing-sale-fraction, {{WRAPPER}} .wdt-pricing-table-holder.wdt-template-list .wdt-pricing-table-pricing-inner .wdt-pricing-table-pricing-sale .wdt-pricing-table-pricing-sale-fraction' => 'vertical-align: {{VALUE}};'
							),
							'condition' => array ()
						),

						'heading_period' => array (
							'field_type' => 'heading',
							'unique_key' => 'period',
							'title' => esc_html__( 'Period', 'wdt-elementor-addon' ),
							'condition' => array (),
							'separator' => 'before'
						),
						'typography_period' => array (
							'field_type' => 'typography',
							'unique_key' => 'period',
							'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-pricing .wdt-pricing-table-pricing-sale .wdt-pricing-table-pricing-suffix, {{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-pricing .wdt-pricing-table-pricing-suffix, {{WRAPPER}} .wdt-pricing-table-holder.wdt-template-list .wdt-pricing-table-pricing-inner .wdt-pricing-table-pricing-sale .wdt-pricing-table-pricing-suffix, {{WRAPPER}} .wdt-pricing-table-holder.wdt-template-list .wdt-pricing-table-pricing-inner .wdt-pricing-table-pricing-suffix',
							'condition' => array ()
						),
						'tabs_period' => array (
							'field_type' => 'tabs',
							'unique_key' => 'period',
							'tab_items' => array (
								'normal' => array (
									'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
									'styles' => array (
										'color' => array (
											'field_type' => 'color',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-pricing .wdt-pricing-table-pricing-sale .wdt-pricing-table-pricing-suffix, {{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-pricing .wdt-pricing-table-pricing-suffix, {{WRAPPER}} .wdt-pricing-table-holder.wdt-template-list .wdt-pricing-table-pricing-inner .wdt-pricing-table-pricing-sale .wdt-pricing-table-pricing-suffix, {{WRAPPER}} .wdt-pricing-table-holder.wdt-template-list .wdt-pricing-table-pricing-inner .wdt-pricing-table-pricing-suffix' => 'color: {{VALUE}};'
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
												'{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-pricing .wdt-pricing-table-pricing-sale .wdt-pricing-table-pricing-suffix, {{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-pricing .wdt-pricing-table-pricing-suffix, {{WRAPPER}} .wdt-pricing-table-holder:hover.wdt-template-list .wdt-pricing-table-pricing-inner .wdt-pricing-table-pricing-sale .wdt-pricing-table-pricing-suffix, {{WRAPPER}} .wdt-pricing-table-holder:hover.wdt-template-list .wdt-pricing-table-pricing-inner .wdt-pricing-table-pricing-suffix' => 'color: {{VALUE}};'
											),
											'condition' => array ()
										),
									)
								)
							)
						),
						'select_period' => array (
							'field_type' => 'select',
							'unique_key' => 'period_position',
							'label' => esc_html__( 'Position', 'wdt-elementor-addon' ),
							'default' => 'beside',
							'options' => array(
								'below'  => esc_html__( 'Below', 'wdt-elementor-addon' ),
								'beside' => esc_html__( 'Beside', 'wdt-elementor-addon' )
							),
							'condition' => array (),
						),

						'heading_original_price' => array (
							'field_type' => 'heading',
							'unique_key' => 'original_price',
							'title' => esc_html__( 'Original Price', 'wdt-elementor-addon' ),
							'condition' => array (),
							'separator' => 'before'
						),
						'typography_original_price' => array (
							'field_type' => 'typography',
							'unique_key' => 'original_price',
							'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-pricing .wdt-pricing-table-pricing-original, {{WRAPPER}} .wdt-pricing-table-holder.wdt-template-list .wdt-pricing-table-pricing-inner .wdt-pricing-table-pricing-original',
							'condition' => array ()
						),
						'tabs_original_price' => array (
							'field_type' => 'tabs',
							'unique_key' => 'original_price',
							'tab_items' => array (
								'normal' => array (
									'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
									'styles' => array (
										'color' => array (
											'field_type' => 'color',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-pricing .wdt-pricing-table-pricing-original, {{WRAPPER}} .wdt-pricing-table-holder.wdt-template-list .wdt-pricing-table-pricing-inner .wdt-pricing-table-pricing-original' => 'color: {{VALUE}};'
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
												'{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-pricing .wdt-pricing-table-pricing-original, {{WRAPPER}} .wdt-pricing-table-holder:hover.wdt-template-list .wdt-pricing-table-pricing-inner .wdt-pricing-table-pricing-original' => 'color: {{VALUE}};'
											),
											'condition' => array ()
										),
									)
								)
							)
						),
						'vertical_align_original_price' => array (
							'field_type' => 'vertical_align',
							'unique_key' => 'original_price',
							'label' => esc_html__( 'Vertical Position', 'wdt-elementor-addon' ),
							'options' => array (
								'top' => array (
									'title' => esc_html__( 'Top', 'wdt-elementor-addon' ),
									'icon' => 'eicon-v-align-top',
								),
								'middle' => array (
									'title' => esc_html__( 'Middle', 'wdt-elementor-addon' ),
									'icon' => 'eicon-v-align-middle',
								),
								'baseline' => array (
									'title' => esc_html__( 'Bottom', 'wdt-elementor-addon' ),
									'icon' => 'eicon-v-align-bottom',
								)
							),
							'default' => 'middle',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-pricing .wdt-pricing-table-pricing-original, {{WRAPPER}} .wdt-pricing-table-holder.wdt-template-list .wdt-pricing-table-pricing-inner .wdt-pricing-table-pricing-original' => 'vertical-align: {{VALUE}};'
							),
							'condition' => array ()
						),


					)
				));

			// Features
				$this->cc_style->get_style_controls($elementor_object, array (
					'slug' => 'features',
					'title' => esc_html__( 'Features', 'wdt-elementor-addon' ),
					'styles' => array (
						'typography' => array (
							'field_type' => 'typography',
							'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-features',
							'condition' => array ()
						),
						'alignment' => array (
							'field_type' => 'alignment',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-features .wdt-pricing-table-features-list li' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
							),
							'condition' => array ()
						),
						'margin' => array (
							'field_type' => 'margin',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-features' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'padding' => array (
							'field_type' => 'padding',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-features' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'tabs' => array (
							'field_type' => 'tabs',
							'tab_items' => array (
								'normal' => array (
									'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
									'styles' => array (
										'include_text_color' => array (
											'field_type' => 'color',
											'unique_key' => 'include_text',
											'label' => esc_html__( 'Included Text Color', 'wdt-elementor-addon' ),
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-features .wdt-pricing-table-feature-included .wdt-pricing-table-features-list-text' => 'color: {{VALUE}};'
											),
											'condition' => array ()
										),
										'include_icon_color' => array (
											'field_type' => 'color',
											'unique_key' => 'include_icon',
											'label' => esc_html__( 'Included Icon Color', 'wdt-elementor-addon' ),
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-features .wdt-pricing-table-feature-included .wdt-pricing-table-features-list-icon .wdt-content-icon span' => 'color: {{VALUE}};'
											),
											'condition' => array ()
										),
										'exclude_text_color' => array (
											'field_type' => 'color',
											'unique_key' => 'exclude_text',
											'label' => esc_html__( 'Excluded Text Color', 'wdt-elementor-addon' ),
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-features .wdt-pricing-table-feature-excluded .wdt-pricing-table-features-list-text' => 'color: {{VALUE}};'
											),
											'condition' => array ()
										),
										'exclude_icon_color' => array (
											'field_type' => 'color',
											'unique_key' => 'exclude_icon',
											'label' => esc_html__( 'Excluded Icon Color', 'wdt-elementor-addon' ),
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-features .wdt-pricing-table-feature-excluded .wdt-pricing-table-features-list-icon .wdt-content-icon span' => 'color: {{VALUE}};'
											),
											'condition' => array ()
										),
										'background' => array (
											'field_type' => 'background',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-features',
											'condition' => array ()
										),
										'border' => array (
											'field_type' => 'border',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-features',
											'condition' => array ()
										),
										'border_radius' => array (
											'field_type' => 'border_radius',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-features' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
											),
											'condition' => array ()
										)
									)
								),
								'hover' => array (
									'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
									'styles' => array (
										'include_text_color' => array (
											'field_type' => 'color',
											'unique_key' => 'include_text',
											'label' => esc_html__( 'Included Text Color', 'wdt-elementor-addon' ),
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-features .wdt-pricing-table-feature-included .wdt-pricing-table-features-list-text' => 'color: {{VALUE}};'
											),
											'condition' => array ()
										),
										'include_icon_color' => array (
											'field_type' => 'color',
											'unique_key' => 'include_icon',
											'label' => esc_html__( 'Included Icon Color', 'wdt-elementor-addon' ),
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-features .wdt-pricing-table-feature-included .wdt-pricing-table-features-list-icon .wdt-content-icon span' => 'color: {{VALUE}};'
											),
											'condition' => array ()
										),
										'exclude_text_color' => array (
											'field_type' => 'color',
											'unique_key' => 'exclude_text',
											'label' => esc_html__( 'Excluded Text Color', 'wdt-elementor-addon' ),
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-features .wdt-pricing-table-feature-excluded .wdt-pricing-table-features-list-text' => 'color: {{VALUE}};'
											),
											'condition' => array ()
										),
										'exclude_icon_color' => array (
											'field_type' => 'color',
											'unique_key' => 'exclude_icon',
											'label' => esc_html__( 'Excluded Icon Color', 'wdt-elementor-addon' ),
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-features .wdt-pricing-table-feature-excluded .wdt-pricing-table-features-list-icon .wdt-content-icon span' => 'color: {{VALUE}};'
											),
											'condition' => array ()
										),
										'color' => array (
											'field_type' => 'color',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-features' => 'color: {{VALUE}};'
											),
											'condition' => array ()
										),
										'background' => array (
											'field_type' => 'background',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-features',
											'condition' => array ()
										),
										'border' => array (
											'field_type' => 'border',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-features',
											'condition' => array ()
										),
										'border_radius' => array (
											'field_type' => 'border_radius',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-features' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
											),
											'condition' => array ()
										)
									)
								)
							)
						),

						'heading' => array (
							'field_type' => 'heading',
							'unique_key' => 'divider',
							'title' => esc_html__( 'Divider', 'wdt-elementor-addon' ),
							'condition' => array (
								'template!' => 'list',
							),
							'separator' => 'before'
						),
						'switcher' => array (
							'field_type' => 'switcher',
							'unique_key' => 'show_divider',
							'condition' => array (
								'template!' => 'list',
							),
						),
						'select' => array (
							'field_type' => 'select',
							'unique_key' => 'divider_style',
							'label' => esc_html__( 'Style', 'wdt-elementor-addon' ),
							'default' => 'solid',
							'options' => array(
								'solid'  => esc_html__( 'Solid', 'wdt-elementor-addon' ),
								'double' => esc_html__( 'Double', 'wdt-elementor-addon' ),
								'dotted' => esc_html__( 'Dotted', 'wdt-elementor-addon' ),
								'dashed' => esc_html__( 'Dashed', 'wdt-elementor-addon' ),
							),
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-features .wdt-pricing-table-features-list li:after' => 'border-top-style: {{VALUE}};'
							),
							'condition' => array (
								'template!' => 'list',
								'features_show_divider' => 'yes'
							),
						),
						'color' => array (
							'field_type' => 'color',
							'unique_key' => 'divider_color',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-features .wdt-pricing-table-features-list li:after' => 'border-top-color: {{VALUE}};'
							),
							'condition' => array (
								'template!' => 'list',
								'features_show_divider' => 'yes'
							),
						),
						'weight' => array (
							'field_type' => 'weight',
							'default' => array (
								'size' => 1,
								'unit' => 'px'
							),
							'size_units' => array ( 'px' ),
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-features .wdt-pricing-table-features-list li:after' => 'border-top-width: {{SIZE}}{{UNIT}};'
							),
							'condition' => array (
								'template!' => 'list',
								'features_show_divider' => 'yes'
							),
						),
						'width' => array (
							'field_type' => 'width',
							'default' => array (
								'size' => 100,
								'unit' => '%'
							),
							'size_units' => array ( '%' ),
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-features .wdt-pricing-table-features-list li:after' => 'width: {{SIZE}}{{UNIT}};'
							),
							'condition' => array (
								'template!' => 'list',
								'features_show_divider' => 'yes'
							),
						),
						'gap' => array (
							'field_type' => 'gap',
							'default' => array (
								'size' => 15,
								'unit' => 'px'
							),
							'size_units' => array ( 'px' ),
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder div[class*="-table-features"] .wdt-pricing-table-features-list li:not(:last-child):after' => 'margin-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};'
							),
							'condition' => array (
								'template!' => 'list',
								'features_show_divider' => 'yes'
							),
						)

					)
				));

			// Footer
				$this->cc_style->get_style_controls($elementor_object, array (
					'slug' => 'footer',
					'title' => esc_html__( 'Footer', 'wdt-elementor-addon' ),
					'styles' => array (
						'alignment' => array (
							'field_type' => 'alignment',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-footer' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
							),
							'condition' => array ()
						),
						'margin' => array (
							'field_type' => 'margin',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-footer' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'padding' => array (
							'field_type' => 'padding',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
												'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-footer' => 'color: {{VALUE}};'
											),
											'condition' => array ()
										),
										'background' => array (
											'field_type' => 'background',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-footer',
											'condition' => array ()
										),
										'border' => array (
											'field_type' => 'border',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-footer',
											'condition' => array ()
										),
										'border_radius' => array (
											'field_type' => 'border_radius',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-footer' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
											),
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
												'{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-footer' => 'color: {{VALUE}};'
											),
											'condition' => array ()
										),
										'background' => array (
											'field_type' => 'background',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-footer',
											'condition' => array ()
										),
										'border' => array (
											'field_type' => 'border',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-footer',
											'condition' => array ()
										),
										'border_radius' => array (
											'field_type' => 'border_radius',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-footer' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
											),
											'condition' => array ()
										)
									)
								)
							)
						),

						'heading_description' => array (
							'field_type' => 'heading',
							'unique_key' => 'description',
							'title' => esc_html__( 'Description', 'wdt-elementor-addon' ),
							'condition' => array (),
							'separator' => 'before'
						),
						'typography_description' => array (
							'field_type' => 'typography',
							'unique_key' => 'description',
							'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-footer .wdt-pricing-table-footer-description',
							'condition' => array ()
						),
						'margin_description' => array (
							'field_type' => 'margin',
							'unique_key' => 'description',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-footer .wdt-pricing-table-footer-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'tabs_description' => array (
							'field_type' => 'tabs',
							'unique_key' => 'description',
							'tab_items' => array (
								'normal' => array (
									'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
									'styles' => array (
										'color' => array (
											'field_type' => 'color',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-footer .wdt-pricing-table-footer-description' => 'color: {{VALUE}};'
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
												'{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-footer .wdt-pricing-table-footer-description' => 'color: {{VALUE}};'
											),
											'condition' => array ()
										),
									)
								)
							)
						),

						'heading_button' => array (
							'field_type' => 'heading',
							'unique_key' => 'button',
							'title' => esc_html__( 'Button', 'wdt-elementor-addon' ),
							'condition' => array (),
							'separator' => 'before'
						),
						'switcher_button' => array (
							'field_type' => 'switcher',
							'unique_key' => 'enable_fullwidth_button',
							'return_value' => 'yes',
							'default' => 'yes',
							'label' => esc_html__( 'Enable Fullwidth', 'wdt-elementor-addon' ),
							'condition' => array ()
						),
						'typography_button' => array (
							'field_type' => 'typography',
							'unique_key' => 'button',
							'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-footer .wdt-content-button > a',
							'condition' => array ()
						),
						'alignment_button' => array (
							'field_type' => 'alignment',
							'unique_key' => 'button',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-footer .wdt-content-button > a' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
							),
							'condition' => array ()
						),
						'margin_button' => array (
							'field_type' => 'margin',
							'unique_key' => 'button',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-footer .wdt-content-button > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'padding_button' => array (
							'field_type' => 'padding',
							'unique_key' => 'button',
							'selector' => array (
								'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-footer .wdt-content-button > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'tabs_button' => array (
							'field_type' => 'tabs',
							'unique_key' => 'button',
							'tab_items' => array (
								'normal' => array (
									'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
									'styles' => array (
										'color' => array (
											'field_type' => 'color',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-footer .wdt-content-button > a' => 'color: {{VALUE}};'
											),
											'condition' => array ()
										),
										'background' => array (
											'field_type' => 'background',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-footer .wdt-content-button > a',
											'condition' => array ()
										),
										'border' => array (
											'field_type' => 'border',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-footer .wdt-content-button > a',
											'condition' => array ()
										),
										'border_radius' => array (
											'field_type' => 'border_radius',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-footer .wdt-content-button > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
											),
											'condition' => array ()
										),
										'box_shadow' => array (
											'field_type' => 'box_shadow',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder .wdt-pricing-table-footer .wdt-content-button > a',
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
												'{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-footer .wdt-content-button > a' => 'color: {{VALUE}};'
											),
											'condition' => array ()
										),
										'background' => array (
											'field_type' => 'background',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-footer .wdt-content-button > a',
											'condition' => array ()
										),
										'border' => array (
											'field_type' => 'border',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-footer .wdt-content-button > a',
											'condition' => array ()
										),
										'border_radius' => array (
											'field_type' => 'border_radius',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-footer .wdt-content-button > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
											),
											'condition' => array ()
										),
										'box_shadow' => array (
											'field_type' => 'box_shadow',
											'selector' => '{{WRAPPER}} .wdt-pricing-table-holder:hover .wdt-pricing-table-footer .wdt-content-button > a',
											'condition' => array ()
										)
									)
								)
							)
						)

					)
				));

			// Badge
				$this->cc_style->get_style_controls($elementor_object, array (
					'slug' => 'badge',
					'title' => esc_html__( 'Badge', 'wdt-elementor-addon' ),
					'styles' => array (
						'tabs' => array (
							'field_type' => 'tabs',
							'tab_items' => array (
								'normal' => array (
									'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
									'styles' => array (
										'color' => array (
											'field_type' => 'color',
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder div[class*="-table-badge"]:not(.type4), {{WRAPPER}} .wdt-pricing-table-holder div[class*="-table-badge"].type4 .wdt-pricing-table-badge-inner' => 'color: {{VALUE}};'
											),
											'condition' => array ()
										),
										'color_background' => array (
											'field_type' => 'color',
											'unique_key' => 'background',
											'label' => esc_html__( 'Background Color', 'wdt-elementor-addon' ),
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder div[class*="-table-badge"]:not(.type4), {{WRAPPER}} .wdt-pricing-table-holder div[class*="-table-badge"].type4 .wdt-pricing-table-badge-inner' => 'background-color: {{VALUE}};',
												'{{WRAPPER}}  .wdt-pricing-table-holder div[class*="-table-badge"].type2:after' => 'border-bottom-color: {{VALUE}};'
											),
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
												'{{WRAPPER}} .wdt-pricing-table-holder:hover div[class*="-table-badge"]:not(.type4), {{WRAPPER}} .wdt-pricing-table-holder:hover div[class*="-table-badge"].type4 .wdt-pricing-table-badge-inner' => 'color: {{VALUE}};'
											),
											'condition' => array ()
										),
										'color_background' => array (
											'field_type' => 'color',
											'unique_key' => 'background',
											'label' => esc_html__( 'Background Color', 'wdt-elementor-addon' ),
											'selector' => array (
												'{{WRAPPER}} .wdt-pricing-table-holder:hover div[class*="-table-badge"]:not(.type4), {{WRAPPER}} .wdt-pricing-table-holder:hover div[class*="-table-badge"].type4 .wdt-pricing-table-badge-inner' => 'background-color: {{VALUE}};',
												'{{WRAPPER}} .wdt-pricing-table-holder:hover div[class*="-table-badge"].type2:after' => 'border-bottom-color: {{VALUE}};'
											),
											'condition' => array ()
										)
									)
								)
							)
						)
					)
				));


	}

	public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}

		$output = '';

		$classes = array ();
		array_push($classes, 'wdt-template-'.$settings['template']);

		$module_id = $widget_object->get_id();

		$link_start = $link_end = '';
		if( !empty( $settings['footer_link']['url'] ) ){
			$target = ( $settings['footer_link']['is_external'] == 'on' ) ? ' target="_blank" ' : '';
			$nofollow = ( $settings['footer_link']['nofollow'] == 'on' ) ? 'rel="nofollow" ' : '';
			$link_start = '<a href="'.esc_url( $settings['footer_link']['url'] ).'"'. $target . $nofollow.'>';
			$link_end = '</a>';
		}

		$output .= '<div class="wdt-pricing-table-holder '.esc_attr(implode(' ', $classes)).'" id="wdt-pricing-table-'.esc_attr($module_id).'">';

			if($settings['template'] == 'default') {

				// Badge
				$output .= $this->render_badge_html($settings);

				// Header
				$output .= $this->render_header_html($settings, $link_start, $link_end);

				// Pricing
				$output .= $this->render_pricing_html($settings);

				// Features
				$output .= $this->render_features_html($settings, $widget_object);

				// Footer
				$output .= $this->render_footer_html($settings, $link_start, $link_end);

			} else if($settings['template'] == 'classic') {

				// Badge
				$output .= $this->render_badge_html($settings);

				// Header
				$output .= $this->render_header_html($settings, $link_start, $link_end);

				// Pricing
				$output .= $this->render_pricing_html($settings);

				// Features
				$output .= $this->render_features_html($settings, $widget_object);

				// Footer
				$output .= $this->render_footer_html($settings, $link_start, $link_end);

			} else if($settings['template'] == 'list') {

				$output .= '<div class="wdt-pricing-table-header">';

					// Badge
						$output .= $this->render_badge_html($settings);

					// Title & Sub title
						$header_content_positions = $this->cc_repeater_contents->content_position_items($settings['header_positions']);

						if(is_array($header_content_positions) && !empty($header_content_positions)) {
							foreach($header_content_positions as $content_position) {
								if($content_position == 'title') {
									$output .= $this->cc_repeater_contents->render_title($settings['title'], $link_start, $link_end);
								} else if($content_position == 'subtitle') {
									$output .= $this->cc_repeater_contents->render_sub_title($settings['sub_title']);
								}
							}
						}

					// Pricing
						$output .= '<div class="wdt-pricing-table-pricing-inner">';
							$output .= $this->render_pricing_inner_html($settings);
						$output .= '</div>';

				$output .= '</div>';

				// Features
				$output .= $this->render_features_html($settings, $widget_object);

				// Footer
				$output .= $this->render_footer_html($settings, $link_start, $link_end);

			} else if($settings['template'] == 'custom-template') {

				$content_positions = $this->cc_repeater_contents->content_position_items($settings['group1_content_positions']);

				if(is_array($content_positions) && !empty($content_positions)) {

					$output .= $this->render_badge_html($settings);
					foreach($content_positions as $content_position) {
						if($content_position == 'media') {
							$output .= $this->render_media_html($module_id, $widget_object, $settings, $link_start, $link_end);
						} else if($content_position == 'header') {
							$output .= $this->render_header_html($settings, $link_start, $link_end);
						} else if($content_position == 'pricing') {
							$output .= $this->render_pricing_html($settings);
						} else if($content_position == 'features') {
							$output .= $this->render_features_html($settings, $widget_object);
						} else if($content_position == 'footer') {
							$output .= $this->render_footer_html($settings, $link_start, $link_end);
						}
					}

				}

			}

		$output .= '</div>';

		return $output;

	}

	public function render_badge_html($settings) {

		$output = '';

		if($settings['show_badge'] == 'yes') {
			$output .= '<div class="wdt-pricing-table-badge '.esc_attr($settings['badge_type']).'  '.esc_attr($settings['badge_position']).'">';
				$output .= ($settings['badge_type'] == 'type4') ? '<span class="wdt-pricing-table-badge-inner">' : '';
					$output .= $settings['badge_text'];
				$output .= ($settings['badge_type'] == 'type4') ? '</span>' : '';
			$output .= '</div>';
		}

		return $output;

	}

	public function render_image($item, $link_start, $link_end) {
		$output = '';
		if ( ! empty( $item['media_image']['url'] ) ) :
			$output .= '<div class="wdt-content-image">';
				$output .=  ($link_start != '') ? $link_start : '';
					$output .=   '<span style="background-image:url('.esc_url($item['media_image']['url']).')">';
					$output .=  '</span>';
				$output .=  ($link_end != '') ? $link_end : '';
			$output .= '</div>';
		endif;
		return $output;
	}

	public function render_media_html($module_id, $widget_object, $settings, $link_start, $link_end) {

		$output = '';

		$output .= '<div class="wdt-pricing-table-media">';
			$output .= $this->render_image($settings, $link_start, $link_end);
			$output .= $this->cc_repeater_contents->render_icon($module_id, $settings, $widget_object);
		$output .= '</div>';

		return $output;

	}

	public function render_header_html($settings, $link_start, $link_end) {

		$output = '';

		$header_content_positions = $this->cc_repeater_contents->content_position_items($settings['header_positions']);

		if(is_array($header_content_positions) && !empty($header_content_positions)) {
			$output .= '<div class="wdt-pricing-table-header">';
			foreach($header_content_positions as $content_position) {
				if($content_position == 'title') {
					$output .= $this->cc_repeater_contents->render_title($settings['title'], $link_start, $link_end);
				} else if($content_position == 'subtitle') {
					$output .= $this->cc_repeater_contents->render_sub_title($settings['sub_title']);
				}
			}
			$output .= '</div>';
		}

		return $output;

	}

	private function get_currency_symbol( $symbol_name ) {
		$symbols = [
			'dollar' => '&#36;',
			'euro' => '&#128;',
			'franc' => '&#8355;',
			'pound' => '&#163;',
			'ruble' => '&#8381;',
			'shekel' => '&#8362;',
			'baht' => '&#3647;',
			'yen' => '&#165;',
			'won' => '&#8361;',
			'guilder' => '&fnof;',
			'peso' => '&#8369;',
			'peseta' => '&#8359',
			'lira' => '&#8356;',
			'rupee' => '&#8360;',
			'indian_rupee' => '&#8377;',
			'real' => 'R$',
			'krona' => 'kr',
		];

		return isset( $symbols[ $symbol_name ] ) ? $symbols[ $symbol_name ] : '';
	}

	public function render_pricing_html($settings) {

		$output = '';

		$output .= '<div class="wdt-pricing-table-pricing">';
			$output .= $this->render_pricing_inner_html($settings);
		$output .= '</div>';

		return $output;

	}

	public function render_pricing_inner_html($settings) {

		$output = '';

		$currency_format = empty($settings['currency_format']) ? '.' : $settings['currency_format'];
		$price = explode($currency_format, $settings['price']);
		$intprice = $price[0];
		$fraction = '';
		if ( 2 === count($price)) {
			$fraction = $price[1];
		}

		$settings['prefix'] = ($settings['currency_symbol'] == 'custom') ? $settings['custom_symbol'] : $settings['currency_symbol'];
		$settings['prefix'] = $this->get_currency_symbol($settings['prefix']);
		$settings['suffix'] = $settings['period'];

		if($settings['show_original_price'] == 'yes') {
			$output .= '<div class="wdt-pricing-table-pricing-original">';
				if($settings['pricing_currency_symbol_horizontal_align'] == 'left' && !empty($settings['prefix'])) {
					$output .= '<span class="wdt-pricing-table-pricing-prefix">'.$settings['prefix'].'</span>';
				}
				$output.= '<span class="wdt-pricing-table-pricing-original-price">'.$settings['original_price'].'</span>';
				if($settings['pricing_currency_symbol_horizontal_align'] == 'right' && !empty($settings['prefix'])) {
					$output .= '<span class="wdt-pricing-table-pricing-prefix">'.$settings['prefix'].'</span>';
				}
			$output .= '</div>';
		}

		$output .= '<div class="wdt-pricing-table-pricing-sale">';
			if($settings['pricing_currency_symbol_horizontal_align'] == 'left' && !empty($settings['prefix'])) {
				$output .= '<span class="wdt-pricing-table-pricing-prefix">'.$settings['prefix'].'</span>';
			}
			if(!empty($intprice) && $intprice >= 0) {
				$output.= '<span class="wdt-pricing-table-pricing-sale-price">'.$intprice.'</span>';
			}
			if(!empty($fraction)) {
				$output.= '<span class="wdt-pricing-table-pricing-sale-fraction">'.$fraction.'</span>';
			}
			if($settings['pricing_currency_symbol_horizontal_align'] == 'right' && !empty($settings['prefix'])) {
				$output .= '<span class="wdt-pricing-table-pricing-prefix">'.$settings['prefix'].'</span>';
			}
			if($settings['pricing_period_position'] == 'beside' && !empty($settings['suffix'])) {
				$output .= '<span class="wdt-pricing-table-pricing-suffix '.esc_attr($settings['pricing_period_position']).'">'.$settings['suffix'].'</span>';
			}
		$output .= '</div>';
		if($settings['pricing_period_position'] == 'below' && !empty($settings['suffix'])) {
			$output .= '<span class="wdt-pricing-table-pricing-suffix '.esc_attr($settings['pricing_period_position']).'">'.$settings['suffix'].'</span>';
		}

		return $output;

	}

	public function render_features_html($settings, $widget_object) {

		$output = '';

		if(is_array($settings['features_content']) && !empty($settings['features_content'])) {
			$output .= '<div class="wdt-pricing-table-features">';
				$output .= '<span>'.esc_html($settings['feature_title']).'</span>';
				$output .= '<ul class="wdt-pricing-table-features-list">';
					foreach($settings['features_content'] as $key => $feature_content) {
						$included_class = 'wdt-pricing-table-feature-excluded';
						if($feature_content['included'] == 'yes') {
							$included_class = 'wdt-pricing-table-feature-included';
						}
						$output .= '<li class="elementor-repeater-item-'.esc_attr($feature_content['_id']).' '.esc_attr($included_class).'">';
							$output .= '<div class="wdt-pricing-table-features-list-inner">';
								if (!empty($feature_content['media_icon']['value'])) {
									$output .= '<span class="wdt-pricing-table-features-list-icon">';
										$output .= $this->cc_repeater_contents->render_icon($key, $feature_content, $widget_object);
									$output .= '</span>';
								}
								$output .= '<span class="wdt-pricing-table-features-list-text">'.esc_html($feature_content['text']).'</span>';
							$output .= '</div>';
						$output .= '</li>';
					}
				$output .= '</ul>';
			$output .= '</div>';
		}

		return $output;

	}

	public function render_footer_html($settings, $link_start, $link_end) {

		$output = '';

		$footer_content_positions = $this->cc_repeater_contents->content_position_items($settings['footer_positions']);

		if(is_array($footer_content_positions) && !empty($footer_content_positions)) {
			$output .= '<div class="wdt-pricing-table-footer">';
				foreach($footer_content_positions as $content_position) {
					if($content_position == 'button') {
						if( !empty($settings['footer_button_text']) && !empty($link_start) ) {
							$fullwidth_class = '';
							if($settings['footer_enable_fullwidth_button'] == 'yes') {
								$fullwidth_class = 'fullwidth';
							}
							$output .= '<div class="wdt-content-button '.esc_attr($fullwidth_class).'">';
								$output .= $link_start;
								$output .= '<span>' .esc_html( $settings['footer_button_text'] ). '</span>';
								if( !empty($settings['footer_button_text'])){
									$output .= '<i></i>';
								}
								$output .= $link_end;
							$output .= '</div>';
						}
					} else if($content_position == 'description' && isset($settings['footer_description']) && !empty($settings['footer_description'])) {
						$output .= '<div class="wdt-pricing-table-footer-description">';
							$output .= $settings['footer_description'];
						$output .= '</div>';
					}
				}
			$output .= '</div>';
		}

		return $output;

	}

}

if( !function_exists( 'wedesigntech_widget_base_pricing_table' ) ) {
    function wedesigntech_widget_base_pricing_table() {
        return WeDesignTech_Widget_Base_Pricing_Table::instance();
    }
}