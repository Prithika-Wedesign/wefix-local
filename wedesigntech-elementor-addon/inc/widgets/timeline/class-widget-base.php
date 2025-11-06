<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Timeline {

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
	}

	public function name() {
		return 'wdt-timeline';
	}

	public function title() {
		return esc_html__( 'Timeline', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'wdt-widget-icon';
	}

	public function init_styles() {
		return array (
			'jquery-swiper' =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/common-controls/layout/assets/css/swiper.min.css',
            $this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/timeline/assets/css/style.css',	
		);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array (
			'jquery-swiper' =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/common-controls/layout/assets/js/swiper.min.js',
			$this->name() => WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/timeline/assets/js/script.js',
		);
	}

	public function create_elementor_controls($elementor_object) {

        $elementor_object->start_controls_section( 'wdt_section_features', array(
        	'label' => esc_html__( 'Content', 'wdt-elementor-addon'),
        ));

		$elementor_object->add_control( 'template', array(
			'label'   => esc_html__( 'Template', 'wdt-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::SELECT2,
			'default' => 'default',
			'options' => array(
				'default'  => esc_html__( 'Default', 'wdt-elementor-addon' ),
				'timeline-list' => esc_html__( 'Timeline', 'wdt-elementor-addon' )
			)
		));

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'list_icon', array (
			'type'      => \Elementor\Controls_Manager::ICONS,
			'label'     => esc_html__( 'Icon', 'wdt-elementor-addon' ),
			'default'   => array( 'value' => 'fas fa-check', 'library' => 'fa-solid' ),
			'condition' => array(
				'template' => 'timeline-list',
			)
		));
		
		$repeater->add_control( 'image', array (
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'label'   => esc_html__( 'Image', 'wdt-elementor-addon' ),
			'default' => array(
				'url' => \Elementor\Utils::get_placeholder_image_src(),
			),
			'condition' => array()
		));

		$repeater->add_control( 'list_title', array (
			'type'      => \Elementor\Controls_Manager::TEXT,
			'label'     => esc_html__( 'Title', 'wdt-elementor-addon' ),
			'default'   => 'Sample Title',
			'condition' => array()
		));

		$repeater->add_control( 'list_timeline_title', array (
			'type'    => \Elementor\Controls_Manager::TEXT,
			'label'   => esc_html__( 'Timeline List', 'wdt-elementor-addon' ),
			'default' => 'Sample Title',
			'condition' => array(
				'template' => 'timeline-list',
			)
		));

		$repeater->add_control( 'list_content', array (
			'type'      => \Elementor\Controls_Manager::WYSIWYG,
			'label'     => esc_html__( 'Description', 'wdt-elementor-addon' ),
			'default'   => 'Sample Description',
			'condition' => array()
		));

		$repeater->add_control( 'button', array (
			'type'     	=> \Elementor\Controls_Manager::TEXT,
			'label'     => esc_html__( 'Button text', 'wdt-elementor-addon' ),
			'default'   => 'Click Here',
			'condition' => array()
		));

		$repeater->add_control( 'button_link', array(
			'label' => esc_html__( 'Link', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::URL,
			'placeholder' => esc_html__( 'https://your-link.com', 'wdt-elementor-addon' ),
			'options' => array( 'url', 'is_external', 'nofollow' ),
			'default' => array(
				'url' => '#',
				'is_external' => false,
				'nofollow' => false,
			),
			'label_block' => true,
			'condition' => array()
		));

		$elementor_object->add_control( 'features_content', array(
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'label'       => esc_html__('Banner Items', 'wdt-elementor-addon'),
			'description' => esc_html__('Banner Items', 'wdt-elementor-addon' ),
			'fields'      => $repeater->get_controls(),
			'default' => array (
				array (
					'list_title'     => esc_html__('Sed ut perspiciatis', 'wdt-elementor-addon' ),
					'list_subtitle'     => esc_html__('Sed Sub title', 'wdt-elementor-addon' ),
					'list_timeline_title'     => esc_html__('2023', 'wdt-elementor-addon' ),
					'list_content'     => esc_html__('when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin.', 'wdt-elementor-addon' ),
					'list_icon' => array( 'value' => 'fas fa-check', 'library' => 'fa-solid' ),
					'button' => esc_html__('Click Here', 'wdt-elementor-addon' ),
					'button_link' => array( 'value' => '#' )
				),
				array (
					'list_title'     => esc_html__('Lorem ipsum dolor', 'wdt-elementor-addon' ),
					'list_subtitle'     => esc_html__('Lorem Sub title', 'wdt-elementor-addon' ),
					'list_timeline_title'     => esc_html__('2024', 'wdt-elementor-addon' ),
					'list_content'     => esc_html__('He lay on his armour-like back, and if he lifted his head a little he could see his brown belly', 'wdt-elementor-addon' ),
					'list_icon' => array( 'value' => 'fas fa-check', 'library' => 'fa-solid' ),
					'button' => esc_html__('Click Here', 'wdt-elementor-addon' ),
					'button_link' => array( 'value' => '#' )
				)        
			),
			'title_field' => '{{{list_title}}}'
		));

	$elementor_object->end_controls_section();


	$elementor_object->start_controls_section( 'wdt_item_style_section', array (
			'label' => esc_html__( 'Item', 'wdt-elementor-addon' ),
			'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		));

		$elementor_object->add_control( 'text_align', array(
			'label' => esc_html__( 'Alignment', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::CHOOSE,
			'options' => array(
				'left' => array(
					'title' => esc_html__( 'Left', 'wdt-elementor-addon' ),
					'icon' => 'eicon-text-align-left',
				),

				'center' => array(
					'title' => esc_html__( 'Center', 'wdt-elementor-addon' ),
					'icon' => 'eicon-text-align-center',
				),
										
				'right' => array(
					'title' => esc_html__( 'Right', 'wdt-elementor-addon' ),
					'icon' => 'eicon-text-align-right',
				),
					
			),
			'default' => 'left',
			'toggle' => true,
			'selectors' => array(
				'{{WRAPPER}} .wdt-timeline-content-group, {{WRAPPER}} .wdt-timeline-icon-wrapper, {{WRAPPER}} .timeline-title-item, 
				 {{WRAPPER}} .wdt-timeline-content-group .wdt-timeline-content, {{WRAPPER}} .wdt-timeline-image' => 'text-align: {{VALUE}};',
				'{{WRAPPER}} .wdt-timeline-image, {{WRAPPER}} .wdt-timeline-icon-wrapper' => 'justify-content: {{VALUE}};',
			),
		));

		$elementor_object->add_responsive_control( 'item_margin', array (
			'label' => esc_html__( 'Margin', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array ( 'px', 'em', '%' ),
			'selectors' => array (
				'{{WRAPPER}} .timeline-content-item > .wdt-timeline-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		));

		$elementor_object->add_responsive_control( 'item_padding', array (
			'label' => esc_html__( 'Padding', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array ( 'px', 'em', '%' ),
			'selectors' => array (
				'{{WRAPPER}} .timeline-content-item > .wdt-timeline-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		));	

		$elementor_object->start_controls_tabs(
			'style_tabs'
		);

		$elementor_object->start_controls_tab( 'style_normal_tab', array(
			'label' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
		));

		$elementor_object->add_control( 'text_color', array(
			'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .wdt-timeline-container, {{WRAPPER}} .wdt-timeline-container h4, 
				 {{WRAPPER}} .wdt-timeline-container a, {{WRAPPER}} .wdt-timeline-container h6' => 'color: {{VALUE}}',
			),
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
			'name' => 'background',
			'types' =>  array('classic', 'gradient', 'video' ),
			'selector' => '{{WRAPPER}} .timeline-content-item .wdt-timeline-container',
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
			'name' => 'border',
			'selector' => '{{WRAPPER}} .timeline-content-item .wdt-timeline-container',
		));

		$elementor_object->add_responsive_control( 'item-border-radius', array (
			'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array ( 'px', 'em', '%' ),
			'selectors' => array (
				'{{WRAPPER}} .timeline-content-item .wdt-timeline-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
			'name' => 'item-box_shadow',
			'selector' => '{{WRAPPER}} .timeline-content-item .wdt-timeline-container',
		));

		$elementor_object->end_controls_tab();

		$elementor_object->start_controls_tab( 'style_hover_tab', array(
			'label' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
		));

		$elementor_object->add_control( 'text_color_hover', array(
			'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .wdt-timeline-container:hover, {{WRAPPER}} .wdt-timeline-container:hover h4, 
				 {{WRAPPER}} .wdt-timeline-container:hover a, {{WRAPPER}} .wdt-timeline-container:hover h6' => 'color: {{VALUE}}',
			),
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
			'name' => 'background_hover',
			'types' =>  array('classic', 'gradient', 'video' ),
			'selector' => '{{WRAPPER}} .wdt-timeline-info:hover',
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
			'name' => 'border_hover',
			'selector' => '{{WRAPPER}} .wdt-timeline-container:hover',
		));

		$elementor_object->add_responsive_control( 'item-border-radius_hover', array (
			'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array ( 'px', 'em', '%' ),
			'selectors' => array (
				'{{WRAPPER}} .wdt-timeline-container:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
			'name' => 'item-box_shadow_hover',
			'selector' => '{{WRAPPER}} .wdt-timeline-container:hover',
		));

		$elementor_object->end_controls_tab();

		$elementor_object->end_controls_tabs();

		$elementor_object->end_controls_section();

		//Title

		$elementor_object->start_controls_section( 'wdt_title_style_section', array (
			'label' => esc_html__( 'Title', 'wdt-elementor-addon' ),
			'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		));

		$elementor_object->add_control( 'content_text_align', array(
			'label' => esc_html__( 'Alignment', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::CHOOSE,
			'options' => array(
				'left' => array(
					'title' => esc_html__( 'Left', 'wdt-elementor-addon' ),
					'icon' => 'eicon-text-align-left',
				),

				'center' => array(
					'title' => esc_html__( 'Center', 'wdt-elementor-addon' ),
					'icon' => 'eicon-text-align-center',
				),
										
				'right' => array(
					'title' => esc_html__( 'Right', 'wdt-elementor-addon' ),
					'icon' => 'eicon-text-align-right',
				),
					
		),
			'default' => '',
			'toggle' => true,
			'selectors' => array(
				'{{WRAPPER}} .wdt-timeline-title' => 'text-align: {{VALUE}};',
			),
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
			'name' => 'title_typography',
			'selector' => '{{WRAPPER}} .wdt-timeline-title h5',
		));

		$elementor_object->add_responsive_control( 'item_title_margin', array (
			'label' => esc_html__( 'Margin', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array ( 'px', 'em', '%' ),
			'selectors' => array (
				'{{WRAPPER}} .wdt-timeline-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		));

		
		$elementor_object->start_controls_tabs(
			'title_style_tabs'
		);

		$elementor_object->start_controls_tab( 'title_normal_tab', array(
			'label' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
		));

		$elementor_object->add_control( 'title_color', array(
			'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .wdt-timeline-container h5' => 'color: {{VALUE}}',
			),
		));

		$elementor_object->end_controls_tab();

		$elementor_object->start_controls_tab( 'title_hover_tab', array(
			'label' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
		));

		$elementor_object->add_control( 'title_hover_color', array(
			'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .wdt-timeline-container:hover h5' => 'color: {{VALUE}}',
			),
		));

		$elementor_object->end_controls_tab();

		$elementor_object->end_controls_tabs();

		$elementor_object->end_controls_section();

		// List title

		$elementor_object->start_controls_section( 'wdt_list_title_style_section', array (
			'label' => esc_html__( 'List Title', 'wdt-elementor-addon' ),
			'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
			'name' => 'list_title_typography',
			'selector' => '{{WRAPPER}} .wdt-timeline-main-title',
		));

		$elementor_object->add_responsive_control( 'item_list_title_margin', array (
			'label' => esc_html__( 'Margin', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array ( 'px', 'em', '%' ),
			'selectors' => array (
				'{{WRAPPER}} .wdt-timeline-main-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		));
		
		$elementor_object->start_controls_tabs(
			'list_title_style_tabs'
		);

		$elementor_object->start_controls_tab( 'list_title_normal_tab', array(
			'label' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
		));

		$elementor_object->add_control( 'list_title_color', array (
			'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .wdt-timeline-main-title' => 'color: {{VALUE}}',
			),
		));

		$elementor_object->end_controls_tab();

		$elementor_object->start_controls_tab( 'list_title_hover_tab', array (
			'label' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
		));

		$elementor_object->add_control( 'list_title_hover_color', array (
			'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .wdt-timeline-main-title:hover' => 'color: {{VALUE}}',
			),
		));

		$elementor_object->end_controls_tab();

		$elementor_object->end_controls_tabs();

		$elementor_object->end_controls_section();


		//content 

		$elementor_object->start_controls_section( 'wdt_content_style_section', array (
			'label' => esc_html__( 'Description', 'wdt-elementor-addon' ),
			'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
			'name' => 'content_typography',
			'selector' => '{{WRAPPER}} .wdt-timeline-content',
		));

		$elementor_object->add_responsive_control( 'item_content_margin', array (
			'label' => esc_html__( 'Margin', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array ( 'px', 'em', '%' ),
			'selectors' => array (
				'{{WRAPPER}} .wdt-timeline-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		));

		$elementor_object->add_responsive_control( 'item_content_padding', array (
			'label' => esc_html__( 'Padding', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array ( 'px', 'em', '%' ),
			'selectors' => array (
				'{{WRAPPER}} .wdt-timeline-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		));	
		
		$elementor_object->start_controls_tabs(
			'content_style_tabs'
		);

		$elementor_object->start_controls_tab( 'content_normal_tab', array (
			'label' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
		));

		$elementor_object->add_control( 'content_color', array (
			'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .wdt-timeline-content' => 'color: {{VALUE}}',
			),
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
			'name' => 'content_background',
			'types' =>  array('classic', 'gradient', 'video' ),
			'selector' => '{{WRAPPER}} .wdt-timeline-content',
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
			'name' => 'content_border',
			'selector' => '{{WRAPPER}} .wdt-timeline-content',
		));

		$elementor_object->add_responsive_control( 'item-content_border-radius', array (
			'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array ( 'px', 'em', '%' ),
			'selectors' => array (
				'{{WRAPPER}} .wdt-timeline-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
			'name' => 'item-content_box_shadow',
			'selector' => '{{WRAPPER}} .wdt-timeline-content',
		));

		$elementor_object->end_controls_tab();

		$elementor_object->start_controls_tab( 'content_hover_tab', array(
			'label' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
		));

		$elementor_object->add_control( 'content_hover_color', array(
			'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .wdt-timeline-content:hover' => 'color: {{VALUE}}',
			),
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
			'name' => 'content_hover_background',
			'types' =>  array('classic', 'gradient', 'video' ),
			'selector' => '{{WRAPPER}} .wdt-timeline-content:hover',
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
			'name' => 'content_hover_border',
			'selector' => '{{WRAPPER}} .wdt-timeline-content:hover',
		));

		$elementor_object->add_responsive_control( 'item-content-hover-border-radius', array (
			'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array ( 'px', 'em', '%' ),
			'selectors' => array (
				'{{WRAPPER}} .wdt-timeline-content:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
			'name' => 'item-content_hover_box_shadow',
			'selector' => '{{WRAPPER}} .wdt-timeline-content:hover',
		));

		$elementor_object->end_controls_tab();

		$elementor_object->end_controls_tabs();

		$elementor_object->end_controls_section();


		//icon

		$elementor_object->start_controls_section( 'wdt_icon_style_section', array (
			'label' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
			'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		));

		$elementor_object->add_responsive_control( 'icon-font-size', array (
			'label' => esc_html__( 'Icon Size', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'size_units' => array('px', '%', 'em', 'rem', 'custom'),
			'range' => array(
				'px' => array(
					'min' => 0,
					'max' => 1000,
					'step' => 5,
				),
				'%' => array(
					'min' => 0,
					'max' => 100,
				),
			),
			'selectors' => array(
				'{{WRAPPER}} .wdt-timeline-icon' => 'font-size: {{SIZE}}{{UNIT}};',
			),
		));

		$elementor_object->add_responsive_control( 'icon-width', array (
			'label' => esc_html__( 'Icon Width', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'size_units' => array('px', '%', 'em', 'rem', 'custom'),
			'range' => array(
				'px' => array(
					'min' => 0,
					'max' => 1000,
					'step' => 5,
				),
				'%' => array(
					'min' => 0,
					'max' => 100,
				),
			),
			'selectors' => array(
				'{{WRAPPER}} .wdt-timeline-icon' => 'width: {{SIZE}}{{UNIT}};',
			),
		));

		
		$elementor_object->add_responsive_control( 'icon-height', array (
			'label' => esc_html__( 'Icon Height', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'size_units' => array('px', '%', 'em', 'rem', 'custom'),
			'range' => array(
				'px' => array(
					'min' => 0,
					'max' => 1000,
					'step' => 5,
				),
				'%' => array(
					'min' => 0,
					'max' => 100,
				),
			),
			'default' => array(
				'unit' => 'px',
				'size' => 50,
			),
			'selectors' => array(
				'{{WRAPPER}} .wdt-timeline-icon' => 'height: {{SIZE}}{{UNIT}};',
			),
		));

		$elementor_object->add_responsive_control( 'item_icon_margin', array (
			'label' => esc_html__( 'Margin', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array ( 'px', 'em', '%' ),
			'selectors' => array (
				'{{WRAPPER}} .wdt-timeline-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		));

		$elementor_object->add_responsive_control( 'item_icon_padding', array (
			'label' => esc_html__( 'Padding', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array ( 'px', 'em', '%' ),
			'selectors' => array (
				'{{WRAPPER}} .wdt-timeline-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		));	

		$elementor_object->start_controls_tabs(
			'icons_style_tabs'
		);

		$elementor_object->start_controls_tab( 'icon_style_normal_tab', array(
			'label' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
		));

		$elementor_object->add_control( 'icon_color', array (
			'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .wdt-timeline-icon' => 'color: {{VALUE}}',
			),
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Background::get_type(), array (
			'name' => 'icon_normal_background',
			'types' =>  array('classic', 'gradient', 'video' ),
			'selector' => '{{WRAPPER}} .wdt-timeline-icon',
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Border::get_type(), array (
			'name' => 'icon_normal_border',
			'selector' => '{{WRAPPER}} .wdt-timeline-icon',
		));

		$elementor_object->add_responsive_control( 'item-icon-border-radius', array (
			'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array ( 'px', 'em', '%' ),
			'selectors' => array (
				'{{WRAPPER}} .wdt-timeline-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array (
			'name' => 'item-icon_normal_box_shadow',
			'selector' => '{{WRAPPER}} .wdt-timeline-icon',
		));

		$elementor_object->end_controls_tab();

		$elementor_object->start_controls_tab( 'icon_style_hover_tab', array (
			'label' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
		));

		$elementor_object->add_control( 'icon_hover_color', array (
			'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .wdt-timeline-icon:hover i' => 'color: {{VALUE}}',
			),
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Background::get_type(), array (
			'name' => 'icon_hover_background',
			'types' =>  array('classic', 'gradient', 'video' ),
			'selector' => '{{WRAPPER}} .wdt-timeline-icon:hover',
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Border::get_type(), array (
			'name' => 'icon_hover_border',
			'selector' => '{{WRAPPER}} .wdt-timeline-icon:hover',
		));

		$elementor_object->add_responsive_control( 'item-icon-hover-border-radius', array (
			'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array ( 'px', 'em', '%' ),
			'selectors' => array (
				'{{WRAPPER}} .wdt-timeline-icon:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array (
			'name' => 'item-icon_hover_box_shadow',
			'selector' => '{{WRAPPER}} .wdt-timeline-icon:hover',
		));

		$elementor_object->end_controls_tab();

		$elementor_object->end_controls_tabs();
		
		$elementor_object->end_controls_section();

		//Button

		$elementor_object->start_controls_section( 'wdt_button_style_section', array (
			'label' => esc_html__( 'Button', 'wdt-elementor-addon' ),
			'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Typography::get_type(), array (
			'name' => 'button_typography',
			'selector' => '{{WRAPPER}} .wdt-timeline-button-text span',
		));

		$elementor_object->add_control( 'button_text_align', array (
			'label' => esc_html__( 'Alignment', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::CHOOSE,
			'options' => array(
				'left' => array(
					'title' => esc_html__( 'Left', 'wdt-elementor-addon' ),
					'icon' => 'eicon-text-align-left',
				),

				'center' => array(
					'title' => esc_html__( 'Center', 'wdt-elementor-addon' ),
					'icon' => 'eicon-text-align-center',
				),
										
				'right' => array(
					'title' => esc_html__( 'Right', 'wdt-elementor-addon' ),
					'icon' => 'eicon-text-align-right',
				),
					
			),
			'default' => '',
			'toggle' => true,
			'selectors' => array(
				'{{WRAPPER}} .wdt-timeline-button' => 'text-align: {{VALUE}};',
			),
		));

		$elementor_object->add_responsive_control( 'button_margin', array (
			'label' => esc_html__( 'Margin', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array ( 'px', 'em', '%' ),
			'selectors' => array (
				'{{WRAPPER}} .wdt-timeline-button a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		));

		$elementor_object->add_responsive_control( 'button_padding', array (
			'label' => esc_html__( 'Padding', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array ( 'px', 'em', '%' ),
			'selectors' => array (
				'{{WRAPPER}} .wdt-timeline-button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		));	

		$elementor_object->start_controls_tabs(
			'button_style_tabs'
		);

		$elementor_object->start_controls_tab( 'button_style_normal_tab', array(
			'label' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
		));

		$elementor_object->add_control( 'button_color', array(
			'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .wdt-timeline-button a' => 'color: {{VALUE}}',
			),
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
				'name' => 'button_normal_background',
				'types' =>  array('classic', 'gradient', 'video' ),
				'selector' => '{{WRAPPER}} .wdt-timeline-button a',
			));

		$elementor_object->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
			'name' => 'button_normal_border',
			'selector' => '{{WRAPPER}} .wdt-timeline-button a',
		));

		$elementor_object->add_responsive_control( 'item-button-border-radius', array (
			'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array ( 'px', 'em', '%' ),
			'selectors' => array (
				'{{WRAPPER}} .wdt-timeline-button a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
			'name' => 'item_button_normal_box_shadow',
			'selector' => '{{WRAPPER}} .wdt-timeline-button a',
		));

		$elementor_object->end_controls_tab();

		$elementor_object->start_controls_tab( 'button_style_hover_tab', array(
			'label' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
		));

		$elementor_object->add_control( 'button_hover_color', array(
			'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .wdt-timeline-button a:hover' => 'color: {{VALUE}}',
			),
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
			'name' => 'button_hover_background',
			'types' =>  array('classic', 'gradient', 'video' ),
			'selector' => '{{WRAPPER}} .wdt-timeline-button a:hover',
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
			'name' => 'button_hover_border',
			'selector' => '{{WRAPPER}} .wdt-timeline-button a:hover',
		));

		$elementor_object->add_responsive_control( 'item-button-hover-border-radius', array (
			'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array ( 'px', 'em', '%' ),
			'selectors' => array (
				'{{WRAPPER}} .wdt-timeline-button a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		));

		$elementor_object->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
			'name' => 'item_button_hover_box_shadow',
			'selector' => '{{WRAPPER}} .wdt-timeline-button a:hover',
		));

		$elementor_object->end_controls_tab();

		$elementor_object->end_controls_tabs();

		$elementor_object->end_controls_section();


    }

	public function get_timeline_attributes($settings) {

		extract($settings);


	}

	public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}

		$output  = '';
		$settings['module_id'] = $widget_object->get_id();
		$settings['module_class'] = 'wdt-timeline__';
	
		$settings_attr = $this->get_timeline_attributes($settings);
		if($settings['template'] == 'timeline-list') {
			$output .= '<div class="wdt-timeline-holder">';
				$output .= '<div id="'.esc_attr($settings['module_class']).($settings['module_id']).'" class="wdt-temp-'.$settings['template'].' wdt-timeline-wrapper" data-id="'.($settings['module_id']).'">';

					$output .= '<div class="wdt-timeline-content-items">';
						foreach ( $settings['features_content'] as $index => $item ) :
							$output .= '<div class="timeline-content-item">';
							
								if(!empty($item['list_icon']['value'])) {
									$output .= '  <div class="wdt-timeline-icon-wrapper">';
										$output .= '  <div class="wdt-timeline-icon">';
											$output .= ($item['list_icon']['library'] === 'svg') ? '' : '';
													ob_start();
													\Elementor\Icons_Manager::render_icon( $item['list_icon'], [ 'aria-hidden' => 'true' ] );
													$contents = ob_get_contents();
													ob_end_clean();
													$output .= $contents;
											$output .= ($item['list_icon']['library'] === 'svg') ? '' : '';
										$output .= '</div>';
									$output .= '</div>';
								}
							
								$output .= '<div class="wdt-timeline__line"></div>';
								
								$output .='<div class="wdt-timeline-container">';

									if(isset($item['image']['url']) && !empty($item['image']['url'])) {
										$output .= '<div class="wdt-timeline-image">';
											$alt_text = 'Timeline Image ' . ($index + 1);
											$output .= '<img src="' . esc_url( $item['image']['url'] ) . '" alt="' . esc_attr($alt_text) . '">';
										$output .= '</div>';
									}

									$output .= '  <div class="wdt-timeline-content-group">';

										if(isset($item['list_timeline_title']) && !empty($item['list_timeline_title'])) {
											$output .= '<span class="wdt-timeline-main-title">' . $item['list_timeline_title'] . '</span>';
										}
										if(isset($item['list_title']) && !empty($item['list_title'])) {
											$output .= '<div class="wdt-timeline-title"><h5>' . $item['list_title'] . '</h5></div>';
										}
										if(isset($item['list_content']) && !empty($item['list_content'])) {
											$output .= '<div class="wdt-timeline-content">' . $item['list_content'] . '</div>';
										}

										$link_start = $link_end = '';
										if( !empty( $item['button_link']['url'] ) && $item['button'] !== '' ){
											$target = ( $item['button_link']['is_external'] == 'on' ) ? ' target="_blank" ' : '';
											$nofollow = ( $item['button_link']['nofollow'] == 'on' ) ? 'rel="nofollow" ' : '';
											$link_start = '<a class="wdt-button" href="'.esc_url( $item['button_link']['url'] ).'"'. $target . $nofollow.'>';
											$link_end = '</a>';
											$output .= '<div class="wdt-timeline-button">' . $link_start . '<div class="wdt-timeline-button-text">' . $item['button'] . '</div>' . $link_end . '</div>' ;
										}
										
									$output .= '   </div>';

								$output .= '   </div>';
								
							$output .= '</div>';
						endforeach;
					$output .= '</div>';

				$output .= '</div>';
			$output .= '</div>';
		} else {
		
			$output .= '<div class="wdt-timeline-holder">';
				$output .= '<div id="'.esc_attr($settings['module_class']).($settings['module_id']).'" class="swiper wdt-temp-'.$settings['template'].' wdt-timeline-wrapper swiper-'.($settings['module_id']).'" data-id="'.($settings['module_id']).'">';
					$output .= '<div class="wdt-timeline-content-items swiper-wrapper">';
						foreach ( $settings['features_content'] as $index => $item ) :
							$output .= '<div class="timeline-content-item swiper-slide">';
								$output .='<div class="wdt-timeline-container">';
									
									$output .= '  <div class="wdt-timeline-media-group">';
										if(isset($item['image']['url']) && !empty($item['image']['url'])) {
											$output .= '<div class="wdt-timeline-image">';
												$alt_text = 'Timeline Image ' . ($index + 1);
												$output .= '<img src="' . esc_url( $item['image']['url'] ) . '" alt="' . esc_attr($alt_text) . '">';
											$output .= '</div>';										
										}
									$output .= '</div>';
									$output .= '  <div class="wdt-timeline-content-group">';
										$output .= '<div class="wdt-timeline-info">';
											if(isset($item['list_title']) && !empty($item['list_title'])) {
												$output .= '<div class="wdt-timeline-title"><h5>' . $item['list_title'] . '</h5></div>';
											}
											if(isset($item['list_content']) && !empty($item['list_content'])) {
												$output .= '<div class="wdt-timeline-content">' . $item['list_content'] . '</div>';
											}
										$output .= '</div>';
									$output .= '</div>';
								
								$output .= '</div>';
								$output .= '<div class="wdt-timeline-line"></div>';
							$output .= '</div>';
						endforeach;
					$output .= '</div>';

					// Pagination and Navigation
					$output .= '<div class="wdt-timeline-pagination">';
						$output .= '<div class="swiper-button-next-'.$settings['module_id'].'"><i class="wdticon-angle-right"></i></div>';
						$output .= '<div class="swiper-button-prev-'.$settings['module_id'].'"><i class="wdticon-angle-left"></i></div>';
					$output .= '</div>';
					
				$output .= '</div>';
			$output .= '</div>';

		}		
        return $output;

	}

}

if( !function_exists( 'wedesigntech_widget_base_timeline' ) ) {
    function wedesigntech_widget_base_timeline() {
        return WeDesignTech_Widget_Base_Timeline::instance();
    }
}