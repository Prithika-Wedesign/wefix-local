<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Thumbs_Slider {

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
		return 'wdt-thumbs-slider';
	}

	public function title() {
		return esc_html__( 'Thumbs slider', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'wdt-widget-icon';
	}

	public function init_styles() {
		return array (
			'jquery-swiper' =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/common-controls/layout/assets/css/swiper.min.css',
            $this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/thumbs-slider/assets/css/style.css',	
		);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array (
			'jquery-swiper' =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/common-controls/layout/assets/js/swiper.min.js',
			$this->name() => WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/thumbs-slider/assets/js/script.js',
		);
	}

	public function create_elementor_controls($elementor_object) {

        $elementor_object->start_controls_section( 'wdt_section_features', array(
        'label' => esc_html__( 'Content', 'wdt-elementor-addon'),
        ) );

            $repeater = new \Elementor\Repeater();

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

            $repeater->add_control(
                'list_title',
                array(
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'label' => esc_html__( 'Title', 'wdt-elementor-addon' ),
                    'default' => 'Sample Title'
                )
            );

            $repeater->add_control(
                'list_sub_title',
                array(
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'label' => esc_html__( 'Sub Title', 'wdt-elementor-addon' ),
                    'default' => 'Sample Sub Title',
					'condition' => array (
						'content_type' => 'default'
					)
                )
            );

            $repeater->add_control(
                'list_content',
                array(
                    'type' => \Elementor\Controls_Manager::WYSIWYG,
                    'label' => esc_html__( 'Description', 'wdt-elementor-addon' ),
                    'default' => 'Sample Description',
					'condition' => array (
						'content_type' => 'default'
					)
                )
                
            );

            $repeater->add_control(
                'image',
                array(
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'label' => esc_html__( 'Image', 'wdt-elementor-addon' ),
                    'default' => array(
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ),
                )
            );

            $repeater->add_control(
                'list_icon',
                array(
                    'type' => \Elementor\Controls_Manager::ICONS,
                    'label' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
                    'default' => array( 'value' => 'fas fa-check', 'library' => 'fa-solid' ),
					'condition' => array (
						'content_type' => 'default'
					)
                )
            );

            $repeater->add_control(
                'button',
                array(
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'label' => esc_html__( 'Button text', 'wdt-elementor-addon' ),
                    'default' => 'Click Here',
					'condition' => array (
						'content_type' => 'default'
					)
                )
            );

            $repeater->add_control(
                'button_link', 
					array(
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
							'condition' => array (
								'content_type' => 'default'
							)
					)
            );

            $elementor_object->add_control( 'features_content', array(
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'label'       => esc_html__('Banner Items', 'wdt-elementor-addon'),
                'description' => esc_html__('Banner Items', 'wdt-elementor-addon' ),
                'fields'      => $repeater->get_controls(),
                'default' => array (
                    array (
                        'list_title'     => esc_html__('Sed ut perspiciatis', 'wdt-elementor-addon' ),
                        'list_sub_title'     => esc_html__('Unde omnis iste', 'wdt-elementor-addon' ),
                        'list_content'     => esc_html__('when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin.', 'wdt-elementor-addon' ),
                        'list_icon' => array( 'value' => 'fas fa-check', 'library' => 'fa-solid' ),
                        'button' => esc_html__('Click Here', 'wdt-elementor-addon' ),
                        'button_link' => array( 'value' => '#' )
                    ),
                    array (
                        'list_title'     => esc_html__('Lorem ipsum dolor', 'wdt-elementor-addon' ),
                        'list_sub_title'     => esc_html__('Nemo enim ipsam', 'wdt-elementor-addon' ),
                        'list_content'     => esc_html__('He lay on his armour-like back, and if he lifted his head a little he could see his brown belly', 'wdt-elementor-addon' ),
                        'list_icon' => array( 'value' => 'fas fa-check', 'library' => 'fa-solid' ),
                        'button' => esc_html__('Click Here', 'wdt-elementor-addon' ),
                        'button_link' => array( 'value' => '#' )
                    ),
                    array (
                        'list_title'     => esc_html__('Li Europan lingues', 'wdt-elementor-addon' ),
                        'list_sub_title'     => esc_html__('The European languages', 'wdt-elementor-addon' ),
                        'list_content'     => esc_html__('The bedding was hardly able to cover it and seemed ready to slide off any moment.', 'wdt-elementor-addon' ),
                        'list_icon' => array( 'value' => 'fas fa-check', 'library' => 'fa-solid' ),
                        'button' => esc_html__('Click Here', 'wdt-elementor-addon' ),
                        'button_link' => array( 'value' => '#' )
                    ),
                    array (
                        'list_title'     => esc_html__('Far far away', 'wdt-elementor-addon' ),
                        'list_sub_title'     => esc_html__('One morning, when', 'wdt-elementor-addon' ),
                        'list_content'     => esc_html__('His many legs, pitifully thin compared with the size of the rest of him, waved about helplessly as he looked.', 'wdt-elementor-addon' ),
                        'list_icon' => array( 'value' => 'fas fa-check', 'library' => 'fa-solid' ),
                        'button' => esc_html__('Click Here', 'wdt-elementor-addon' ),
                        'button_link' => array( 'value' => '#' )
                    ),
                    array (
                        'list_title'     => esc_html__('A wonderful serenity', 'wdt-elementor-addon' ),
                        'list_sub_title'     => esc_html__('The quick, brown', 'wdt-elementor-addon' ),
                        'list_content'     => esc_html__('Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.', 'wdt-elementor-addon' ),
                        'list_icon' => array( 'value' => 'fas fa-check', 'library' => 'fa-solid' ),
                        'button' => esc_html__('Click Here', 'wdt-elementor-addon' ),
                        'button_link' => array( 'value' => '#' )
                    )         
                ),
                'title_field' => '{{{list_title}}}'
            ) );

        $elementor_object->end_controls_section();

		$elementor_object->start_controls_section( 'wdt_section_settings', array(
			'label' => esc_html__( 'Settings', 'wdt-elementor-addon'),
			));

			$elementor_object->add_control( 'loop', array(
				'label' => esc_html__( 'Infinite Loop', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
				'frontend_available' => false
			));

			$elementor_object->add_control( 'freemode', array(
				'label' => esc_html__( 'Free Mode', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
				'frontend_available' => false
			));

			$elementor_object->add_responsive_control(
                'gap',
                array (
                    'label' => esc_html__( 'Gap', 'wdt-elementor-addon' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'default' => array (
                        'size' => 20,
                        'unit' => 'dpt',
                    ),
                    'size_units' => array( 'dpt' ),
                    'range' => array (
                        'dpt' => array(
                            'min' => 0,
                            'step' => 1,
                            'max' => 100
                        )
                    ),
                    'frontend_available' => true,
                )
            );

			$slides_per_view = range( 1, 5 );
			$slides_per_view = array_combine( $slides_per_view, $slides_per_view );

			$elementor_object->add_responsive_control( 'slides_to_show_opts', array(
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => esc_html__( 'Slides to Show', 'wdt-elementor-addon' ),
				'options' => $slides_per_view,
				'desktop_default'      => 4,
				'laptop_default'       => 4,
				'tablet_default'       => 2,
				'tablet_extra_default' => 2,
				'mobile_default'       => 1,
				'mobile_extra_default' => 1,
				'frontend_available'   => true
				
			) );

			$elementor_object->add_control( 'slides_to_scroll_opts', array(
				'label'              => esc_html__( 'Slides to Scroll', 'wdt-elementor-addon' ),
				'type'               => \Elementor\Controls_Manager::SELECT,
				'default'            => 'single',
				'frontend_available' => true,
				'options'            => array(
					'all'    => esc_html__( 'All visible', 'wdt-elementor-addon' ),
					'single' => esc_html__( 'One at a Time', 'wdt-elementor-addon' ),
				),
			) );

			$elementor_object->add_control( 'arrows', array(
				'label' => esc_html__( 'Arrows', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
				'frontend_available' => true
			) );

			$elementor_object->add_control(
				'arrows_prev_icon',
				array (
					'label' => esc_html__( 'Arrow Prev Icon', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'label_block' => false,
					'skin' => 'inline',
					'default' => array( 'value' => 'fas fa-arrow-left', 'library' => 'fa-solid', ),
					'condition' => array( 'arrows' => 'yes' )
				)
			);

			$elementor_object->add_control(
				'arrows_next_icon',
				array (
					'label' => esc_html__( 'Arrow Next Icon', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'label_block' => false,
					'skin' => 'inline',
					'default' => array( 'value' => 'fas fa-arrow-right', 'library' => 'fa-solid', ),
					'condition' => array( 'arrows' => 'yes' )
				)
			);

		$elementor_object->end_controls_section();

		$elementor_object->start_controls_section(
			'wdt_item_style_section',
			array (
				'label' => esc_html__( 'Item', 'wdt-elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$elementor_object->add_control(
			'text_align',
			array(
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
				'default' => 'center',
				'toggle' => true,
				'selectors' => array(
					'{{WRAPPER}} .wdt-thumb-slider-info, {{WRAPPER}} .wdt-thumb-slider-icon' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .wdt-thumb-slider-image, {{WRAPPER}} .wdt-thumb-slider-icon' => 'justify-content: {{VALUE}};',
					'{{WRAPPER}} .wdt-thumb-slider-info p' => 'text-align: {{VALUE}};',
				),
			)
				
		);

		$elementor_object->add_control(
			'vertical_align',
			array(
				'label' => esc_html__( 'Vertical Alignment', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => array(
					'flex-start' => array(
						'title' => esc_html__( 'Top', 'wdt-elementor-addon' ),
						'icon' => 'eicon-v-align-top',
					),
	
					'center' => array(
						'title' => esc_html__( 'Center', 'wdt-elementor-addon' ),
						'icon' => 'eicon-v-align-middle',
					),
											
					'flex-end' => array(
						'title' => esc_html__( 'Bottom', 'wdt-elementor-addon' ),
						'icon' => 'eicon-v-align-bottom',
					),
						
				),
				'default' => 'center',
				'toggle' => true,
				'selectors' => array(
					'{{WRAPPER}} .wdt-thumb-slider-info' => 'align-self: {{VALUE}};',
				),
			)
				
		);

		$elementor_object->add_control(
			'horizontal_align',
			array(
				'label' => esc_html__( 'Horizontal Alignment', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => array(
					'left' => array(
						'title' => esc_html__( 'Left', 'wdt-elementor-addon' ),
						'icon' => 'eicon-h-align-left',
					),
	
					'center' => array(
						'title' => esc_html__( 'Center', 'wdt-elementor-addon' ),
						'icon' => 'eicon-h-align-center',
					),
											
					'right' => array(
						'title' => esc_html__( 'Right', 'wdt-elementor-addon' ),
						'icon' => 'eicon-h-align-right',
					),
						
				),
				'default' => 'center',
				'toggle' => true,
				'selectors' => array(
					'{{WRAPPER}} .wdt-thumb-slider-info' => 'justify-self: {{VALUE}};',
				),
			)
				
		);

		$elementor_object->add_responsive_control(
			'item_margin',
			array (
				'label' => esc_html__( 'Margin', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array ( 'px', 'em', '%' ),
				'selectors' => array (
					'{{WRAPPER}} .wdt-thumb-slider-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$elementor_object->add_responsive_control(
			'item_padding',
			array (
				'label' => esc_html__( 'Padding', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array ( 'px', 'em', '%' ),
				'selectors' => array (
					'{{WRAPPER}} .wdt-thumb-slider-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);	

		$elementor_object->start_controls_tabs(
			'style_tabs'
		);

		$elementor_object->start_controls_tab(
			'style_normal_tab',
			array(
				'label' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
			)	
		);

		$elementor_object->add_control(
			'text_color',
			array(
				'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wdt-thumb-slider-container, {{WRAPPER}} .wdt-thumb-slider-container h4, {{WRAPPER}} .wdt-thumb-slider-container a, {{WRAPPER}} .wdt-thumb-slider-container h6' => 'color: {{VALUE}}',
				),
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name' => 'background',
				'types' =>  array('classic', 'gradient', 'video' ),
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-info',
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name' => 'border',
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-container',
			)
				
		);

		$elementor_object->add_responsive_control(
			'item-border-radius',
			array (
				'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array ( 'px', 'em', '%' ),
				'selectors' => array (
					'{{WRAPPER}} .wdt-thumb-slider-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'item-box_shadow',
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-container',
			)
				
		);

		$elementor_object->end_controls_tab();

		$elementor_object->start_controls_tab(
			'style_hover_tab',
			array(
				'label' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
			)	
		);

		$elementor_object->add_control(
			'text_color_hover',
			array(
				'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wdt-thumb-slider-container:hover, {{WRAPPER}} .wdt-thumb-slider-container:hover h4, {{WRAPPER}} .wdt-thumb-slider-container:hover a, {{WRAPPER}} .wdt-thumb-slider-container:hover h6' => 'color: {{VALUE}}',
				),
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name' => 'background_hover',
				'types' =>  array('classic', 'gradient', 'video' ),
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-info:hover',
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name' => 'border_hover',
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-container:hover',
			)
				
		);

		$elementor_object->add_responsive_control(
			'item-border-radius_hover',
			array (
				'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array ( 'px', 'em', '%' ),
				'selectors' => array (
					'{{WRAPPER}} .wdt-thumb-slider-container:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'item-box_shadow_hover',
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-container:hover',
			)	
		);

		$elementor_object->end_controls_tab();

		$elementor_object->end_controls_tabs();

		$elementor_object->end_controls_section();

		//Title

		$elementor_object->start_controls_section(
			'wdt_title_style_section',
			array (
				'label' => esc_html__( 'Title', 'wdt-elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-title h4',
			)
		);

		$elementor_object->add_responsive_control(
			'item_title_margin',
			array (
				'label' => esc_html__( 'Margin', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array ( 'px', 'em', '%' ),
				'selectors' => array (
					'{{WRAPPER}} .wdt-thumb-slider-title h4' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		
		$elementor_object->start_controls_tabs(
			'title_style_tabs'
		);

		$elementor_object->start_controls_tab(
			'title_normal_tab',
			array(
				'label' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
			)	
		);

		$elementor_object->add_control(
			'title_color',
			array(
				'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wdt-thumb-slider-container h4' => 'color: {{VALUE}}',
				),
			)
		);

		$elementor_object->end_controls_tab();

		$elementor_object->start_controls_tab(
			'title_hover_tab',
			array(
				'label' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
			)	
		);

		$elementor_object->add_control(
			'title_hover_color',
			array(
				'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wdt-thumb-slider-container:hover h4' => 'color: {{VALUE}}',
				),
			)
		);

		$elementor_object->end_controls_tab();

		$elementor_object->end_controls_tabs();

		$elementor_object->end_controls_section();

		//Subtitle

		$elementor_object->start_controls_section(
			'wdt_sub_title_style_section',
			array (
				'label' => esc_html__( 'Sub Title', 'wdt-elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name' => 'sub_title_typography',
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-sub-title h6',
			)
		);

		$elementor_object->add_responsive_control(
			'item_sub_title_margin',
			array (
				'label' => esc_html__( 'Margin', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array ( 'px', 'em', '%' ),
				'selectors' => array (
					'{{WRAPPER}} .wdt-thumb-slider-sub-title h6' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		
		$elementor_object->start_controls_tabs(
			'sub_title_style_tabs'
		);

		$elementor_object->start_controls_tab(
			'sub_title_normal_tab',
			array(
				'label' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
			)	
		);

		$elementor_object->add_control(
			'sub_title_color',
			array(
				'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wdt-thumb-slider-container h6' => 'color: {{VALUE}}',
				),
			)
		);

		$elementor_object->end_controls_tab();

		$elementor_object->start_controls_tab(
			'sub_title_hover_tab',
			array(
				'label' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
			)	
		);

		$elementor_object->add_control(
			'sub_title_hover_color',
			array(
				'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wdt-thumb-slider-container:hover h6' => 'color: {{VALUE}}',
				),
			)
		);
		$elementor_object->end_controls_tab();

		$elementor_object->end_controls_tabs();

		$elementor_object->end_controls_section();


		//content 

		$elementor_object->start_controls_section(
			'wdt_content_style_section',
			array (
				'label' => esc_html__( 'Description', 'wdt-elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-content',
			)	
		);

		$elementor_object->add_responsive_control(
			'item_content_margin',
			array (
				'label' => esc_html__( 'Margin', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array ( 'px', 'em', '%' ),
				'selectors' => array (
					'{{WRAPPER}} .wdt-thumb-slider-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$elementor_object->add_responsive_control(
			'item_content_padding',
			array (
				'label' => esc_html__( 'Padding', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array ( 'px', 'em', '%' ),
				'selectors' => array (
					'{{WRAPPER}} .wdt-thumb-slider-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);	
		
		$elementor_object->start_controls_tabs(
			'content_style_tabs'
		);

		$elementor_object->start_controls_tab(
			'content_normal_tab',
			array(
				'label' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
			)	
		);

		$elementor_object->add_control(
			'content_color',
			array(
				'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wdt-thumb-slider-content' => 'color: {{VALUE}}',
				),
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name' => 'content_background',
				'types' =>  array('classic', 'gradient', 'video' ),
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-content',
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name' => 'content_border',
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-content',
			)
				
		);

		$elementor_object->add_responsive_control(
			'item-content_border-radius',
			array (
				'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array ( 'px', 'em', '%' ),
				'selectors' => array (
					'{{WRAPPER}} .wdt-thumb-slider-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'item-content_box_shadow',
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-content',
			)
				
		);

		$elementor_object->end_controls_tab();

		$elementor_object->start_controls_tab(
			'content_hover_tab',
			array(
				'label' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
			)	
		);

		$elementor_object->add_control(
			'content_hover_color',
			array(
				'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wdt-thumb-slider-content:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name' => 'content_hover_background',
				'types' =>  array('classic', 'gradient', 'video' ),
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-content:hover',
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name' => 'content_hover_border',
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-content:hover',
			)
				
		);

		$elementor_object->add_responsive_control(
			'item-content-hover-border-radius',
			array (
				'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array ( 'px', 'em', '%' ),
				'selectors' => array (
					'{{WRAPPER}} .wdt-thumb-slider-content:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'item-content_hover_box_shadow',
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-content:hover',
			)
				
		);

		$elementor_object->end_controls_tab();

		$elementor_object->end_controls_tabs();

		$elementor_object->end_controls_section();


		//icon

		$elementor_object->start_controls_section(
			'wdt_icon_style_section',
			array (
				'label' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$elementor_object->add_responsive_control(
			'icon-font-size',
			array(
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
					'{{WRAPPER}} .wdt-thumb-slider-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$elementor_object->add_responsive_control(
			'icon-width',
			array(
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
					'{{WRAPPER}} .wdt-thumb-slider-icon' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		
		$elementor_object->add_responsive_control(
			'icon-height',
			array(
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
					'{{WRAPPER}} .wdt-thumb-slider-icon' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$elementor_object->add_responsive_control(
			'item_icon_margin',
			array (
				'label' => esc_html__( 'Margin', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array ( 'px', 'em', '%' ),
				'selectors' => array (
					'{{WRAPPER}} .wdt-thumb-slider-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$elementor_object->add_responsive_control(
			'item_icon_padding',
			array (
				'label' => esc_html__( 'Padding', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array ( 'px', 'em', '%' ),
				'selectors' => array (
					'{{WRAPPER}} .wdt-thumb-slider-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);	

		$elementor_object->start_controls_tabs(
			'icons_style_tabs'
		);

		$elementor_object->start_controls_tab(
			'icon_style_normal_tab',
			array(
				'label' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
			)
		);

		$elementor_object->add_control(
			'icon_color',
			array(
				'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wdt-thumb-slider-icon i' => 'color: {{VALUE}}',
				),
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name' => 'icon_normal_background',
				'types' =>  array('classic', 'gradient', 'video' ),
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-icon',
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name' => 'icon_normal_border',
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-icon',
			)	
		);

		$elementor_object->add_responsive_control(
			'item-icon-border-radius',
			array (
				'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array ( 'px', 'em', '%' ),
				'selectors' => array (
					'{{WRAPPER}} .wdt-thumb-slider-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'item-icon_normal_box_shadow',
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-icon',
			)	
		);

		$elementor_object->end_controls_tab();

		$elementor_object->start_controls_tab(
			'icon_style_hover_tab',
			array(
				'label' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
			)
		);

		$elementor_object->add_control(
			'icon_hover_color',
			array(
				'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wdt-thumb-slider-icon:hover i' => 'color: {{VALUE}}',
				),
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name' => 'icon_hover_background',
				'types' =>  array('classic', 'gradient', 'video' ),
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-icon:hover',
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name' => 'icon_hover_border',
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-icon:hover',
			)
				
		);

		$elementor_object->add_responsive_control(
			'item-icon-hover-border-radius',
			array (
				'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array ( 'px', 'em', '%' ),
				'selectors' => array (
					'{{WRAPPER}} .wdt-thumb-slider-icon:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'item-icon_hover_box_shadow',
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-icon:hover',
			)	
		);

		$elementor_object->end_controls_tab();


		$elementor_object->end_controls_tabs();
		

		$elementor_object->end_controls_section();

		//Button

		$elementor_object->start_controls_section(
			'wdt_button_style_section',
			array (
				'label' => esc_html__( 'Button', 'wdt-elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-button a',
			)			
		);

		$elementor_object->add_responsive_control(
			'button_margin',
			array (
				'label' => esc_html__( 'Margin', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array ( 'px', 'em', '%' ),
				'selectors' => array (
					'{{WRAPPER}} .wdt-thumb-slider-button a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$elementor_object->add_responsive_control(
			'button_padding',
			array (
				'label' => esc_html__( 'Padding', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array ( 'px', 'em', '%' ),
				'selectors' => array (
					'{{WRAPPER}} .wdt-thumb-slider-button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);	

		$elementor_object->start_controls_tabs(
			'button_style_tabs'
		);

		$elementor_object->start_controls_tab(
			'button_style_normal_tab',
			array(
				'label' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
			)
		);

		$elementor_object->add_control(
			'button_color',
			array(
				'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wdt-thumb-slider-button a' => 'color: {{VALUE}}',
				),
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name' => 'button_normal_background',
				'types' =>  array('classic', 'gradient', 'video' ),
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-button a',
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name' => 'button_normal_border',
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-button a',
			)
		);

		$elementor_object->add_responsive_control(
			'item-button-border-radius',
			array (
				'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array ( 'px', 'em', '%' ),
				'selectors' => array (
					'{{WRAPPER}} .wdt-thumb-slider-button a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'item_button_normal_box_shadow',
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-button a',
			)
				
		);

		$elementor_object->end_controls_tab();

		$elementor_object->start_controls_tab(
			'button_style_hover_tab',
			array(
				'label' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
			)
		);

		$elementor_object->add_control(
			'button_hover_color',
			array(
				'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wdt-thumb-slider-button a:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name' => 'button_hover_background',
				'types' =>  array('classic', 'gradient', 'video' ),
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-button a:hover',
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name' => 'button_hover_border',
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-button a:hover',
			)
		);

		$elementor_object->add_responsive_control(
			'item-button-hover-border-radius',
			array (
				'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array ( 'px', 'em', '%' ),
				'selectors' => array (
					'{{WRAPPER}} .wdt-thumb-slider-button a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'item_button_hover_box_shadow',
				'selector' => '{{WRAPPER}} .wdt-thumb-slider-button a:hover',
			)
				
		);

		$elementor_object->end_controls_tab();

		$elementor_object->end_controls_tabs();

		$elementor_object->end_controls_section();

		//Thumbnail style

		$elementor_object->start_controls_section(
			'wdt_thumb_style_section',
			array (
				'label' => esc_html__( 'Thumbnail', 'wdt-elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$elementor_object->add_responsive_control(
			'thumb_margin',
			array (
				'label' => esc_html__( 'Margin', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array ( 'px', 'em', '%' ),
				'selectors' => array (
					'{{WRAPPER}} .wdt-thumbnail-carousel' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$elementor_object->add_responsive_control(
			'thumb_padding',
			array (
				'label' => esc_html__( 'Padding', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array ( 'px', 'em', '%' ),
				'selectors' => array (
					'{{WRAPPER}} .wdt-thumbnail-carousel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);	

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name' => 'thumb_border',
				'selector' => '{{WRAPPER}} .wdt-thumbnail-carousel',
			)		
		);

		$elementor_object->add_responsive_control(
			'thumb-border-radius',
			array (
				'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array ( 'px', 'em', '%' ),
				'selectors' => array (
					'{{WRAPPER}} .wdt-thumbnail-carousel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'thumb_box_shadow',
				'selector' => '{{WRAPPER}} .wdt-thumbnail-carousel',
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'label' => esc_html__( 'Thumbnail Image Border', 'wdt-elementor-addon' ),
				'name' => 'thumb_image_border',
				'selector' => '{{WRAPPER}} .wdt-thumbnail-carousel img',
			)
		);

		$elementor_object->add_responsive_control(
			'thumb-image-border-radius',
			array (
				'label' => esc_html__( 'Thumbnail Image Radius', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array ( 'px', 'em', '%' ),
				'selectors' => array (
					'{{WRAPPER}} .wdt-thumbnail-carousel img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'label' => esc_html__( 'Thumbnail Image shadow', 'wdt-elementor-addon' ),
				'name' => 'thumb_image_box_shadow',
				'selector' => '{{WRAPPER}} .wdt-thumbnail-carousel img',
			)
		);

		$elementor_object->end_controls_section();

    }

	public function get_thumb_carousel_attributes($settings) {

		extract($settings);

		$slides_to_show = $slides_to_show_opts;
		if( $slides_to_scroll_opts == 'all' ) {
			$slides_to_scroll = $slides_to_show;
		} else {
			$slides_to_scroll = 1;
		}

		$carousel_settings = array (
			'slides_to_scroll'      	=> $slides_to_scroll,
			'slides_to_show' 			=> $slides_to_show,
			'loop'						=> $loop,
			'arrows'					=> $arrows,
			'freemode'					=> $freemode,
			'gap' 						=> isset($gap['size']) ? $gap['size'] : 20
		);

		$active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();
		$breakpoint_keys = array_keys($active_breakpoints);

		$space_between_gaps = array ( 'desktop' => isset($gap['size']) ? $gap['size'] : 20 );

		$swiper_breakpoints = array ();
		$swiper_breakpoints[] = array (
				'breakpoint' => 319
			);
		$swiper_breakpoints_slides = array ();

		foreach($breakpoint_keys as $breakpoint) {

				$breakpoint_show_str = 'slides_to_show_opts_'.$breakpoint;
				$breakpoint_toshow = $$breakpoint_show_str;
				if($breakpoint_toshow == '') {
					if($breakpoint == 'mobile') {
						$breakpoint_toshow = 1;
					} else if($breakpoint == 'mobile_extra') {
						$breakpoint_toshow = 1;
					} else if($breakpoint == 'tablet') {
						$breakpoint_toshow = 2;
					} else if($breakpoint == 'tablet_extra') {
						$breakpoint_toshow = 2;
					} else if($breakpoint == 'laptop') {
						$breakpoint_toshow = 4;
                    } else if($breakpoint == 'widescreen') {
						$breakpoint_toshow = 4;
					} else {
						$breakpoint_toshow = 4;
					}
				}
				if( $slides_to_scroll_opts == 'all' ) {
					$breakpoint_toscroll = $breakpoint_toshow;
				} else {
					$breakpoint_toscroll = 1;
				}


				$breakpoint_gap_str = 'gap_'.$breakpoint;
				$breakpoint_gap = $$breakpoint_gap_str;
                $breakpoint_gap = ($breakpoint_gap['size'] != '') ? $breakpoint_gap['size'] : $gap['size'];

                $space_between_gaps[$breakpoint] = $breakpoint_gap;


			array_push($swiper_breakpoints, array (
					'breakpoint' => $active_breakpoints[$breakpoint]->get_value() + 1
				)
			);
			array_push($swiper_breakpoints_slides, array (
					'toshow' => (int)$breakpoint_toshow,
					'toscroll' => (int)$breakpoint_toscroll
				)
			);

		}

		array_push($swiper_breakpoints_slides, array (
				'toshow' => (int)$slides_to_show,
				'toscroll' => (int)$slides_to_scroll
			)
		);

		$responsive_breakpoints = array ();
		if(is_array($swiper_breakpoints) && !empty($swiper_breakpoints)) {
			foreach($swiper_breakpoints as $key => $swiper_breakpoint) {
				$responsive_breakpoints[] = array_merge($swiper_breakpoint, $swiper_breakpoints_slides[$key]);
			}
		}

		$carousel_settings['responsive'] = $responsive_breakpoints;
		$carousel_settings['space_between_gaps'] = $space_between_gaps;
		return wp_json_encode($carousel_settings);

	}

	public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}

		$output  = '';
		$settings['module_id'] = $widget_object->get_id();
		$settings['module_class'] = 'carousel-slider-thumb-';
	
		$settings_attr = $this->get_thumb_carousel_attributes($settings);

		$output .= '<div class="wdt-thumb-carousel-holder" data-settings="'.esc_attr($settings_attr).'">';
			$output .= '<div class="swiper wdt-'.esc_attr($settings['module_class']).($settings['module_id']).'" data-id="'.($settings['module_id']).'" data-wrapper-class="wdt-'.esc_attr($settings['module_class']).($settings['module_id']).'">';

				$output .= '<div class="swiper-wrapper">';

					foreach ( $settings['features_content'] as $index => $item ) :
						$output .= '<div class="swiper-slide">';
						if( $item['content_type'] == 'template' ) {
							$frontend = Elementor\Frontend::instance();
							$output .= $frontend->get_builder_content( $item['content_template'], true );
						} else {
							$output .='<div class="wdt-thumb-slider-container" id="wdt-thumb-slider-index-'.esc_attr($index).'">';

								$output .= '<div class="wdt-thumb-slider-image">';
									$output .= '<img src="' . esc_url( $item['image']['url'] ) . '" alt="' . esc_attr($item['list_title']) . '" title="' . esc_attr($item['list_title']) . '">';
								$output .= '</div>';

								$output .= '  <div class="wdt-thumb-slider-info">';

									if(!empty($item['list_icon']['value'])) {
										$output .= '  <div class="wdt-thumb-slider-icon">';
											ob_start();
											\Elementor\Icons_Manager::render_icon( $item['list_icon'], [ 'aria-hidden' => 'true' ] );
											$contents = ob_get_contents();
											ob_end_clean();
											$output .= $contents;
										$output .= '</div>';
									}

									if(isset($item['list_sub_title']) && !empty($item['list_sub_title'])) {
										$output .= '<div class="wdt-thumb-slider-sub-title"><h6>' . $item['list_sub_title'] . '</h6></div>';
									}

									if(isset($item['list_title']) && !empty($item['list_title'])) {
									$output .= '<div class="wdt-thumb-slider-title"><h4>' . $item['list_title'] . '</h4></div>';
									}
							
									if(isset($item['list_content']) && !empty($item['list_content'])) {
										$output .= '<div class="wdt-thumb-slider-content">' . $item['list_content'] . '</div>';
									}
									

									$link_start = $link_end = '';
									if( !empty( $item['button_link']['url'] ) && $item['button'] !== '' ){
										$target = ( $item['button_link']['is_external'] == 'on' ) ? ' target="_blank" ' : '';
										$nofollow = ( $item['button_link']['nofollow'] == 'on' ) ? 'rel="nofollow" ' : '';
										$link_start = '<a href="'.esc_url( $item['button_link']['url'] ).'"'. $target . $nofollow.'>';
										$link_end = '</a>';
										$output .= '<div class="wdt-thumb-slider-button">' . $link_start . $item['button'] . $link_end . '</div>' ;
									}
									
								$output .= '   </div>';

							$output .= '   </div>';
						}
						$output .= '</div>';
					endforeach;
	
				$output .= '</div>';

				// $output .='<div class="wdt-thumb-pagination-group">';

					$output .= '<div class="swiper wdt-thumbnail-carousel wdt-thumbnail-carousel-'.($settings['module_id']).'" data-wrapper-thumb-class="wdt-thumbnail-carousel-'.($settings['module_id']).'">';
							
						$output .= '<div class="swiper-wrapper">';

							foreach ( $settings['features_content'] as $index => $item ) :
								$output .= '<div class="swiper-slide">';
									$output .= '<div class="wdt-thumb-slider-thumbnail">';
										$output .= '<img src="' . esc_url( $item['image']['url'] ) . '" alt="' . esc_attr( $item['list_title'] ) . '" title="' . esc_attr( $item['list_title'] ) . '">';
									$output .= '</div>';
								$output .= '</div>';
							endforeach;

						$output .= '</div>';

					$output .= '</div>';

					$output .= '<div class="wdt-thumbcarousel-pagination-wrapper">';
						if ( $settings['arrows'] == 'yes' ) :
							$output .= '<div class="wdt-thumbcarousel-arrow-pagination">';
								if(!empty( $settings['arrows_prev_icon']['value'])) {
									$output .= '<div class="wdt-arrow-thumb-pagination-prev wdt-arrow-thumb-pagination-prev-'.esc_attr($settings['module_id']).'">';
										$output .= ($settings['arrows_prev_icon']['library'] === 'svg') ? '<i>' : '';
											ob_start();
											\Elementor\Icons_Manager::render_icon( $settings['arrows_prev_icon'], [ 'aria-hidden' => 'true' ] );
											$output .= ob_get_clean();
										$output .= ($settings['arrows_prev_icon']['library'] === 'svg') ? '</i>' : '';
									$output .= '</div>';
								}
								if(!empty($settings['arrows_next_icon']['value'])) {
									$output .= '<div class="wdt-arrow-thumb-pagination-next wdt-arrow-thumb-pagination-next-'.esc_attr($settings['module_id']).'">';
										$output .= ($settings['arrows_next_icon']['library'] === 'svg') ? '<i>' : '';
											ob_start();
											\Elementor\Icons_Manager::render_icon( $settings['arrows_next_icon'], [ 'aria-hidden' => 'true' ] );
											$output .= ob_get_clean();
										$output .= ($settings['arrows_next_icon']['library'] === 'svg') ? '</i>' : '';
									$output .= '</div>';
								}
							$output .= '</div>';
						endif;
					$output .= '</div>';

				// $output .= '</div>';

			$output .= '</div>';
		$output .= '</div>';

        return $output;

	}

}

if( !function_exists( 'wedesigntech_widget_base_thumbs_slider' ) ) {
    function wedesigntech_widget_base_thumbs_slider() {
        return WeDesignTech_Widget_Base_Thumbs_Slider::instance();
    }
}