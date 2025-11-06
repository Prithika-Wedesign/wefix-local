<?php
class WeDesignTech_Common_Controls_Layout {

	private $layout_type;
	private $cc_style;
	private $cc_class;
	private $cc_id;
	private $cc_name;
	
	private $settings = array ();

    function __construct($layout_type) {
		$this->layout_type = $layout_type;
		// Initialize depandant class
			$this->cc_style = new WeDesignTech_Common_Controls_Style();
    }

	public function init_styles() {

		$layout_styles = array ();
		if(\Elementor\Plugin::$instance->preview->is_preview_mode() || (array_key_exists('layout', $this->settings) && $this->settings['layout'] == 'column')) {
			$layout_styles['wdt-column'] =  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/common-controls/layout/assets/css/column.css';
		}

		if(\Elementor\Plugin::$instance->preview->is_preview_mode() || (array_key_exists('layout', $this->settings) && $this->settings['layout'] == 'carousel')) {
			$layout_styles['jquery-swiper'] = WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/common-controls/layout/assets/css/swiper.min.css';
			$layout_styles['wdt-carousel'] =  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/common-controls/layout/assets/css/carousel.css';
		}

		return $layout_styles;
	}

	public function init_scripts() {
		$layout_scripts = array ();
		if(\Elementor\Plugin::$instance->preview->is_preview_mode() || (array_key_exists('layout', $this->settings) && $this->settings['layout'] == 'column')) {
			$layout_scripts['wdt-column'] =  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/common-controls/layout/assets/js/column.js';
		}

		if(\Elementor\Plugin::$instance->preview->is_preview_mode() || (array_key_exists('layout', $this->settings) && $this->settings['layout'] == 'carousel')) {
			$layout_scripts['jquery-swiper'] = WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/common-controls/layout/assets/js/swiper.min.js';
			$layout_scripts['wdt-carousel'] =  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/common-controls/layout/assets/js/carousel.js';
		}

		return $layout_scripts;
	}

	public function set_settings($settings) {
		$this->settings = $settings;
		if($this->layout_type == 'carousel') {
			$this->settings['layout'] = 'carousel';
		} else if($this->layout_type == 'column') {
			$this->settings['layout'] = 'column';
		}
	}

	public function get_controls($elementor_object) {

		if($this->layout_type == 'both' || $this->layout_type == 'column') {
			$elementor_object->start_controls_section( 'wdt_section_layout', array(
				'label' => esc_html__( 'Layout', 'wdt-elementor-addon')
			) );
		}

			$column_condition = array();
			$carousel_condition = array();

			if($this->layout_type == 'both') {

				$column_condition = array( 'layout' => 'column' );
				$carousel_condition = array( 'layout' => 'carousel' );

				$elementor_object->add_control(
					'layout',
					array (
						'label' => esc_html__( 'Layout', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => array (
							'default' => esc_html__( 'Default', 'wdt-elementor-addon' ),
							'column' => esc_html__( 'Column', 'wdt-elementor-addon' ),
							'carousel' => esc_html__( 'Carousel', 'wdt-elementor-addon' )
						),
						'default' => 'column'
					)
				);

			}

				if($this->layout_type == 'both' || $this->layout_type == 'column') {
					$this->get_column_controls($elementor_object, $column_condition);
				}

		if($this->layout_type == 'both' || $this->layout_type == 'column') {
			$elementor_object->end_controls_section();
		}

		if($this->layout_type == 'both' || $this->layout_type == 'carousel') {
			$this->get_carousel_controls($elementor_object, $carousel_condition);
		}

	}

	public function get_column_controls($elementor_object, $column_condition) {

		$columns = range( 1, 6 );
		$columns = array_combine( $columns, $columns );

		$elementor_object->add_responsive_control( 'columns', array(
			'type' => \Elementor\Controls_Manager::SELECT,
			'label' => esc_html__( 'Columns', 'wdt-elementor-addon' ),
			'options' => $columns,
			'desktop_default'      => 2,
			'laptop_default'       => 2,
			'tablet_default'       => 2,
			'tablet_extra_default' => 2,
			'mobile_default'       => 1,
			'mobile_extra_default' => 1,
			'frontend_available'   => true,
			'condition'   		   => $column_condition
		) );

		$elementor_object->add_control(
			'column_gap',
			array(
				'label' => esc_html__( 'Columns Gap', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array(
					'default' => esc_html__( 'Default', 'wdt-elementor-addon' ),
					'no' => esc_html__( 'No Gap', 'wdt-elementor-addon' ),
					'narrow' => esc_html__( 'Narrow', 'wdt-elementor-addon' ),
					'extended' => esc_html__( 'Extended', 'wdt-elementor-addon' ),
					'wide' => esc_html__( 'Wide', 'wdt-elementor-addon' ),
					'wider' => esc_html__( 'Wider', 'wdt-elementor-addon' ),
					'custom' => esc_html__( 'Custom', 'wdt-elementor-addon' ),
				),
				'condition' => $column_condition
			)
		);

		$elementor_object->add_responsive_control(
			'column_gap_custom',
			array(
				'label' => esc_html__( 'Custom Columns Gap', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 500,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
					'vh' => array(
						'min' => 0,
						'max' => 100,
					),
					'vw' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'size_units' => array( 'px', '%', 'vh', 'vw' ),
				'selectors' => array(
                    '{{WRAPPER}} .wdt-column-gap-custom' => 'margin: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wdt-column-gap-custom .wdt-column' => 'padding: {{SIZE}}{{UNIT}};',
				),
				'condition' => array_merge (
					array(
					'column_gap' => 'custom',
					),
					$column_condition
				),
			)
		);

		$elementor_object->add_control(
			'wdt_snap_scroll',
			array(
				'label'        => esc_html__( 'Enable Snap Scroll', 'wdt-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
				'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
				'return_value' => 'yes',
				'condition'    => array( 'layout' => 'column' )
			)
		);

		if ( \Elementor\Plugin::$instance->breakpoints && method_exists( \Elementor\Plugin::$instance->breakpoints, 'get_active_breakpoints') ) {
			$active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();
			$breakpoints_list   = array();

			foreach ($active_breakpoints as $key => $value) {
				$breakpoints_list[$key] = $value->get_label();
			}

			$breakpoints_list['desktop'] = esc_html__( 'Desktop', 'wdt-elementor-addon' );
			$breakpoints_list            = array_reverse($breakpoints_list);
		} else {
			$breakpoints_list = array(
				'desktop' => esc_html__( 'Desktop', 'wdt-elementor-addon' ),
				'tablet'  => esc_html__( 'Tablet', 'wdt-elementor-addon' ),
				'mobile'  => esc_html__( 'Mobile', 'wdt-elementor-addon' )
			);
		}

		$elementor_object->add_control(
			'wdt_snap_scroll_on_devices',
			array(
				'label'       => esc_html__( 'Snap Scroll On Devices', 'wdt-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => 'true',
				'default'     => array(
					'tablet',
					'mobile',
				),
				'condition' => array( 'wdt_snap_scroll' => 'yes', 'layout' => 'column' ),
				'options' => $breakpoints_list,
			)
		);

	}

	public function get_carousel_controls($elementor_object, $condition) {

		$elementor_object->start_controls_section( 'wdt_section_carousel', array(
			'label' => esc_html__( 'Carousel Options', 'wdt-elementor-addon'),
			'condition' => $condition
		) );

			$elementor_object->add_control( 'direction', array(
				'label' => esc_html__( 'Direction', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => array(
					'horizontal' => esc_html__( 'Horizontal', 'wdt-elementor-addon' ),
					'vertical' => esc_html__( 'Vertical', 'wdt-elementor-addon' ),
				),
				'frontend_available' => true
			));

            $elementor_object->add_control( 'effect', array(
				'label' => esc_html__( 'Effect', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array(
					'default'   => esc_html__( 'Default', 'wdt-elementor-addon' ),
					'fade' 	    => esc_html__( 'Fade', 'wdt-elementor-addon' ),
					'cube' 	    => esc_html__( 'Cube', 'wdt-elementor-addon' ),
					'coverflow' => esc_html__( 'Coverflow', 'wdt-elementor-addon' ),
					'free_mode'	=> esc_html__( 'Free Mode', 'wdt-elementor-addon' )
				),
				'frontend_available' => true
			));

			$slides_per_view = range( 1, 8 );
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
				'frontend_available'   => true,
				'condition'   		   => array( 'direction' => 'horizontal' )
			) );

			$elementor_object->add_control( 'mouse_wheel_scroll', array(
				'label' => esc_html__( 'Mouse Wheel Scroll', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'false',
				'frontend_available' => true
			) );

			$elementor_object->add_control( 'pagination', array(
				'label' => esc_html__( 'Pagination', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'bullets',
				'options' => array(
					'' => esc_html__( 'None', 'wdt-elementor-addon' ),
					'bullets' => esc_html__( 'Dots', 'wdt-elementor-addon' ),
					'fraction' => esc_html__( 'Fraction', 'wdt-elementor-addon' ),
					'progressbar' => esc_html__( 'Progress', 'wdt-elementor-addon' ),
					'scrollbar' => esc_html__( 'Scrollbar', 'wdt-elementor-addon' ),
					'fraction_bullets' => esc_html__( 'Fraction & Dots', 'wdt-elementor-addon' ),
				),
				'frontend_available' => true
			));

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

			$elementor_object->add_control( 'speed', array(
				'label' => esc_html__( 'Transition Duration', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 300,
				'frontend_available' => true
			));

			$elementor_object->add_control( 'unequal_height_compatability', array(
				'label' => esc_html__( 'Unequal Height Compatability', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return' => 'yes',
				'default' => 'no',
				'condition' => array(
					'direction' => 'vertical'
				),
				'frontend_available' => true
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
                    'condition' => array( 'direction' => 'horizontal' )
                )
            );

			$elementor_object->add_control( 'autoplay', array(
				'label' => esc_html__( 'Autoplay', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'separator' => 'before',
				'frontend_available' => true
			));

			$elementor_object->add_control( 'autoplay_speed', array(
				'label' => esc_html__( 'Autoplay Speed', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 5000,
				'condition' => array(
					'autoplay' => 'yes'
				),
				'frontend_available' => true
			));

			$elementor_object->add_control( 'loop', array(
				'label' => esc_html__( 'Infinite Loop', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
				'frontend_available' => true,
			));
			$elementor_object->add_control( 'centered_slides', array(
				'label' => esc_html__( 'Centered Slides', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'no',
				'frontend_available' => true
			));

			$elementor_object->add_control( 'pause_on_interaction', array(
				'label' => esc_html__( 'Pause on Interaction', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => array(
					'autoplay' => 'yes'
				),
				'frontend_available' => true
			));
			$elementor_object->add_control( 'overflow_opacity', array(
				'label' => esc_html__( 'Overflow Opacity', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
				'frontend_available' => true
			) );

        $elementor_object->end_controls_section();

	}

	public function get_carousel_style_controls($elementor_object, $condition) {

		// Carousel Arrows
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'carousel_arrows',
			'title' => esc_html__( 'Carousel Arrows', 'wdt-elementor-addon' ),
			'styles' => array (
				'tabs_default' => array (
					'field_type' => 'tabs',
					'unique_key' => 'default',
					'tab_items' => array (
						'normal' => array (
							'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'label' => esc_html__( 'Font Color', 'wdt-elementor-addon' ),
									'selector' => array (
										'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-carousel-arrow-pagination > div' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'font_size' => array (
									'field_type' => 'font_size',
									'selector' => array (
										'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-carousel-arrow-pagination > div' => 'font-size: {{SIZE}}{{UNIT}};'
									),
									'condition' => array ()
								),
								'width' => array (
									'field_type' => 'width',
									'default' => array (
										'unit' => 'px'
									),
									'size_units' => array ( 'px' ),
									'selector' => array (
										'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-carousel-arrow-pagination > div' => 'width: {{SIZE}}{{UNIT}};'
									),
									'condition' => array ()
								),
								'height' => array (
									'field_type' => 'height',
									'default' => array (
										'unit' => 'px'
									),
									'size_units' => array ( 'px' ),
									'selector' => array (
										'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-carousel-arrow-pagination > div' => 'height: {{SIZE}}{{UNIT}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-carousel-arrow-pagination > div:before',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-carousel-arrow-pagination > div:before',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-carousel-arrow-pagination > div:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-carousel-arrow-pagination > div:before',
									'condition' => array ()
								)
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'label' => esc_html__( 'Font Color', 'wdt-elementor-addon' ),
									'selector' => array (
										'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-carousel-arrow-pagination > div:hover' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'font_size' => array (
									'field_type' => 'font_size',
									'selector' => array (
										'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-carousel-arrow-pagination > div:hover' => 'font-size: {{SIZE}}{{UNIT}};'
									),
									'condition' => array ()
								),
								'width' => array (
									'field_type' => 'width',
									'default' => array (
										'unit' => 'px'
									),
									'size_units' => array ( 'px' ),
									'selector' => array (
										'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-carousel-arrow-pagination > div:hover' => 'width: {{SIZE}}{{UNIT}};'
									),
									'condition' => array ()
								),
								'height' => array (
									'field_type' => 'height',
									'default' => array (
										'unit' => 'px'
									),
									'size_units' => array ( 'px' ),
									'selector' => array (
										'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-carousel-arrow-pagination > div:hover' => 'height: {{SIZE}}{{UNIT}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-carousel-arrow-pagination > div:hover:before',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-carousel-arrow-pagination > div:hover:before',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-carousel-arrow-pagination > div:hover:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-carousel-arrow-pagination > div:hover:before',
									'condition' => array ()
								)
							)
						)
					)
				),
				'heading_prev_arrow' => array (
					'field_type' => 'heading',
					'unique_key' => 'prev_arrow',
					'title' => esc_html__( 'Prev Arrow Position', 'wdt-elementor-addon' ),
					'separator' => 'before',
					'condition' => array ()
				),
				'prev_arrow_vertical_align' => array (
					'field_type' => 'vertical_align',
					'unique_key' => 'prev_arrow',
					'selector' => array (),
					'condition' => array ()
				),
				'indent_prev_arrow_vertical_top' => array (
					'field_type' => 'indent',
					'unique_key' => 'prev_arrow_vertical_top',
					'label' => esc_html__( 'Top Indent', 'wdt-elementor-addon' ),
					'selector' => array (
						'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-carousel-arrow-pagination .wdt-arrow-pagination-prev' => 'display: inline-flex; margin-top: -20px; position: absolute; top: {{SIZE}}{{UNIT}};'
					),
					'condition' => array (
						'carousel_arrows_prev_arrow_vertical_align' => 'flex-start'
					)
				),
				'indent_prev_arrow_vertical_bottom' => array (
					'field_type' => 'indent',
					'unique_key' => 'prev_arrow_vertical_bottom',
					'label' => esc_html__( 'Bottom Indent', 'wdt-elementor-addon' ),
					'selector' => array (
						'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-carousel-arrow-pagination .wdt-arrow-pagination-prev' => 'display: inline-flex; margin-top: 0; margin-bottom: -20px; position: absolute; bottom: {{SIZE}}{{UNIT}};'
					),
					'condition' => array (
						'carousel_arrows_prev_arrow_vertical_align' => 'flex-end'
					)
				),
				'prev_arrow_horizontal_align' => array (
					'field_type' => 'horizontal_align',
					'unique_key' => 'prev_arrow',
					'selector' => array (),
					'condition' => array ()
				),
				'indent_prev_arrow_horizontal_left' => array (
					'field_type' => 'indent',
					'unique_key' => 'prev_arrow_horizontal_left',
					'label' => esc_html__( 'Left Indent', 'wdt-elementor-addon' ),
					'selector' => array (
						'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-carousel-arrow-pagination .wdt-arrow-pagination-prev' => 'display: inline-flex; position: absolute; left: {{SIZE}}{{UNIT}};'
					),
					'condition' => array (
						'carousel_arrows_prev_arrow_horizontal_align' => 'left'
					)
				),
				'indent_prev_arrow_horizontal_right' => array (
					'field_type' => 'indent',
					'unique_key' => 'prev_arrow_horizontal_right',
					'label' => esc_html__( 'Right Indent', 'wdt-elementor-addon' ),
					'selector' => array (
						'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-carousel-arrow-pagination .wdt-arrow-pagination-prev' => 'display: inline-flex; position: absolute; right: {{SIZE}}{{UNIT}};'
					),
					'condition' => array (
						'carousel_arrows_prev_arrow_horizontal_align' => 'right'
					)
				),
				'heading_next_arrow' => array (
					'field_type' => 'heading',
					'unique_key' => 'next_arrow',
					'title' => esc_html__( 'Next Arrow Position', 'wdt-elementor-addon' ),
					'separator' => 'before',
					'condition' => array ()
				),
				'next_arrow_vertical_align' => array (
					'field_type' => 'vertical_align',
					'unique_key' => 'next_arrow',
					'selector' => array (),
					'condition' => array ()
				),
				'indent_next_arrow_vertical_top' => array (
					'field_type' => 'indent',
					'unique_key' => 'next_arrow_vertical_top',
					'label' => esc_html__( 'Top Indent', 'wdt-elementor-addon' ),
					'selector' => array (
						'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-carousel-arrow-pagination .wdt-arrow-pagination-next' => 'display: inline-flex; margin-top: -20px; position: absolute; top: {{SIZE}}{{UNIT}};'
					),
					'condition' => array (
						'carousel_arrows_next_arrow_vertical_align' => 'flex-start'
					)
				),
				'indent_next_arrow_vertical_bottom' => array (
					'field_type' => 'indent',
					'unique_key' => 'next_arrow_vertical_bottom',
					'label' => esc_html__( 'Bottom Indent', 'wdt-elementor-addon' ),
					'selector' => array (
						'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-carousel-arrow-pagination .wdt-arrow-pagination-next' => 'display: inline-flex; margin-top: 0; margin-bottom: -20px; position: absolute; bottom: {{SIZE}}{{UNIT}};'
					),
					'condition' => array (
						'carousel_arrows_next_arrow_vertical_align' => 'flex-end'
					)
				),
				'next_arrow_horizontal_align' => array (
					'field_type' => 'horizontal_align',
					'unique_key' => 'next_arrow',
					'selector' => array (),
					'condition' => array ()
				),
				'indent_next_arrow_horizontal_left' => array (
					'field_type' => 'indent',
					'unique_key' => 'next_arrow_horizontal_left',
					'label' => esc_html__( 'Left Indent', 'wdt-elementor-addon' ),
					'selector' => array (
						'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-carousel-arrow-pagination .wdt-arrow-pagination-next' => 'display: inline-flex; position: absolute; left: {{SIZE}}{{UNIT}};'
					),
					'condition' => array (
						'carousel_arrows_next_arrow_horizontal_align' => 'left'
					)
				),
				'indent_next_arrow_horizontal_right' => array (
					'field_type' => 'indent',
					'unique_key' => 'next_arrow_horizontal_right',
					'label' => esc_html__( 'Right Indent', 'wdt-elementor-addon' ),
					'selector' => array (
						'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-carousel-arrow-pagination .wdt-arrow-pagination-next' => 'display: inline-flex; position: absolute; right: {{SIZE}}{{UNIT}};'
					),
					'condition' => array (
						'carousel_arrows_next_arrow_horizontal_align' => 'right'
					)
				)
			)
		));

		// Carousel Dots
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'carousel_dots',
			'title' => esc_html__( 'Carousel Dots', 'wdt-elementor-addon' ),
			'styles' => array (
				'tabs_default' => array (
					'field_type' => 'tabs',
					'unique_key' => 'default',
					'tab_items' => array (
						'normal' => array (
							'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
							'styles' => array (
								'width' => array (
									'field_type' => 'width',
									'default' => array (
										'unit' => 'px'
									),
									'size_units' => array ( 'px' ),
									'selector' => array (
										'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-swiper-pagination.swiper-pagination-bullets .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};'
									),
									'condition' => array ()
								),
								'height' => array (
									'field_type' => 'height',
									'default' => array (
										'unit' => 'px'
									),
									'size_units' => array ( 'px' ),
									'selector' => array (
										'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-swiper-pagination.swiper-pagination-bullets .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-swiper-pagination.swiper-pagination-bullets .swiper-pagination-bullet:before',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-swiper-pagination.swiper-pagination-bullets .swiper-pagination-bullet:before',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-swiper-pagination.swiper-pagination-bullets .swiper-pagination-bullet:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-swiper-pagination.swiper-pagination-bullets .swiper-pagination-bullet:before',
									'condition' => array ()
								)
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'width' => array (
									'field_type' => 'width',
									'default' => array (
										'unit' => 'px'
									),
									'size_units' => array ( 'px' ),
									'selector' => array (
										'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-swiper-pagination.swiper-pagination-bullets .swiper-pagination-bullet:hover, {{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-swiper-pagination.swiper-pagination-bullets .swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};'
									),
									'condition' => array ()
								),
								'height' => array (
									'field_type' => 'height',
									'default' => array (
										'unit' => 'px'
									),
									'size_units' => array ( 'px' ),
									'selector' => array (
										'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-swiper-pagination.swiper-pagination-bullets .swiper-pagination-bullet:hover, {{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-swiper-pagination.swiper-pagination-bullets .swiper-pagination-bullet-active' => 'height: {{SIZE}}{{UNIT}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-swiper-pagination.swiper-pagination-bullets .swiper-pagination-bullet:hover:before, {{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-swiper-pagination.swiper-pagination-bullets .swiper-pagination-bullet-active:before',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-swiper-pagination.swiper-pagination-bullets .swiper-pagination-bullet:hover:before, {{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-swiper-pagination.swiper-pagination-bullets .swiper-pagination-bullet-active:before',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-swiper-pagination.swiper-pagination-bullets .swiper-pagination-bullet:hover:before, {{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-swiper-pagination.swiper-pagination-bullets .swiper-pagination-bullet-active:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-swiper-pagination.swiper-pagination-bullets .swiper-pagination-bullet:hover:before, {{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-swiper-pagination.swiper-pagination-bullets .swiper-pagination-bullet-active:before',
									'condition' => array ()
								)
							)
						)
					)
				),
				'alignment' => array (
					'field_type' => 'alignment',
					'selector' => array (
						'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
					),
					'separator' => 'before',
					'condition' => array ()
				),
				'gap' => array (
					'field_type' => 'gap',
					'default' => array (
						'unit' => 'px'
					),
					'size_units' => array ( 'px' ),
					'selector' => array (
						'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-swiper-pagination.swiper-pagination-bullets .swiper-pagination-bullet' => 'margin: 0 {{SIZE}}{{UNIT}};'
					),
					'separator' => 'before',
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
						'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-swiper-pagination.swiper-pagination-bullets' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				)
			)
		));

		// Carousel Pagination
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'carousel_pagination',
			'title' => esc_html__( 'Carousel Pagination', 'wdt-elementor-addon' ),
			'styles' => array (
				'color_background' => array (
					'field_type' => 'color',
					'unique_key' => 'background',
					'label' => esc_html__( 'Background Color', 'wdt-elementor-addon' ),
					'selector' => array (
						'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-swiper-pagination.swiper-pagination-fraction, {{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .swiper-pagination-progressbar, {{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-swiper-scrollbar' => 'background-color: {{VALUE}};'
					),
					'condition' => array ()
				),
				'color_text' => array (
					'field_type' => 'color',
					'unique_key' => 'text',
					'label' => esc_html__( 'Text / Active Color', 'wdt-elementor-addon' ),
					'selector' => array (
						'{{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-swiper-pagination.swiper-pagination-fraction, {{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .swiper-pagination-progressbar .swiper-pagination-progressbar-fill, {{WRAPPER}} .wdt-carousel-holder .wdt-carousel-pagination-wrapper .wdt-swiper-scrollbar .swiper-scrollbar-drag' => 'color: {{VALUE}};'
					),
					'condition' => array ()
				),
			)
		));

	}

	public function get_wrapper_start() {

		extract($this->settings);

		$wrapper_start = '';

		$classes_str = '';
		if(isset($classes)) {
			$classes_str = implode(' ', $classes);
		}

		$custom_attributes_str = '';
        if(isset($this->settings['custom_attributes']) && !empty($this->settings['custom_attributes'])) {
            $custom_attributes_str = wp_json_encode($this->settings['custom_attributes']);
        }

		if($layout == 'carousel') {

			$settings_attr = $this->get_carousel_attributes();

			$wrapper_start .= '<div class="wdt-'.esc_attr($module_class).'-holder wdt-content-item-holder wdt-carousel-holder '.esc_attr($classes_str).'" id="wdt-'.esc_attr($module_class).'-'.esc_attr($module_id).'" data-id="'.esc_attr($module_id).'" data-settings="'.esc_js($custom_attributes_str).'">';
				$wrapper_start .= '<div class="wdt-'.esc_attr($module_class).'-container swiper" data-settings="'.esc_js($settings_attr).'" id="wdt-'.esc_attr($module_class).'-swiper-'.esc_attr($module_id).'">';
					$wrapper_start .= '<div class="wdt-'.esc_attr($module_class).'-wrapper swiper-wrapper">';

		} else if($layout == 'column') {

			$wdt_snap_scroll = $json_column_settings = '';
			if( $this->settings['wdt_snap_scroll'] ) {
				$wdt_snap_scroll = 'wdt-snap-scroll-enabled';

				$json_column_settings = wp_json_encode(array (
					'columnDevices'    => $this->settings['wdt_snap_scroll_on_devices']
				));
			}

			$wrapper_start .= '<div class="wdt-'.esc_attr($module_class).'-holder wdt-content-item-holder wdt-column-holder '.esc_attr($classes_str).'" id="wdt-'.esc_attr($module_class).'-'.esc_attr($module_id).'" data-settings="'.esc_js($custom_attributes_str).'">';
				$wrapper_start .= '<div class="wdt-column-wrapper wdt-column-gap-'.esc_attr($column_gap).' '.$wdt_snap_scroll.'" data-column-settings="'.esc_js($json_column_settings).'" data-module-id="wdt-module-id-'.esc_attr($module_id).'" id="wdt-module-id-'.esc_attr($module_id).'">';

		} else {

			$wrapper_start .= '<div class="wdt-'.esc_attr($module_class).'-holder wdt-content-item-holder wdt-column-holder '.esc_attr($classes_str).'" id="wdt-'.esc_attr($module_class).'-'.esc_attr($module_id).'">';

		}

		return $wrapper_start;

	}

	public function get_wrapper_end() {

		extract($this->settings);

		$wrapper_end = '';

		if($layout == 'carousel') {

					$wrapper_end .= '</div>';
				$wrapper_end .= '</div>';
				$wrapper_end .= $this->get_carousel_pagination_html();
			$wrapper_end .= '</div>';

		} else if($layout == 'column') {
				$wrapper_end .= '</div>';
				if( $this->settings['wdt_snap_scroll'] ) {
					$wrapper_end .= '<div class="wdt-column-pagination wdt-snap-scroll-pagination">
						<button class="wdt-pagination-prev wdt-module-id-'.esc_attr($module_id).'">'.esc_html__('Previous', 'wdt-elementor-addon').'</button>
						<button class="wdt-pagination-next wdt-module-id-'.esc_attr($module_id).'">'.esc_html__('Next', 'wdt-elementor-addon').'</button>';
					$wrapper_end .= '</div>';
				}
			$wrapper_end .= '</div>';
		} else {
			$wrapper_end .= '</div>';
		}

		return $wrapper_end;

	}

	public function get_item_class() {

		extract($this->settings);

		$item_class = '';

		if($layout == 'column') {
			$item_class = 'wdt-column';
		} else if($layout == 'carousel') {
			$item_class = 'swiper-slide';
		}

		return $item_class;

	}

	public function get_column_css() {

		extract($this->settings);

		if (!isset($this->settings['layout']) || $this->settings['layout'] !== 'column') {
            return '';
        }
		
		$column_css = '';

		$responsive_breakpoints = array ();

		$active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();
		$breakpoint_keys = array_keys($active_breakpoints);
		$breakpoint_keys= array_reverse($breakpoint_keys);
		$mobile_breakpoint_value = $active_breakpoints['mobile']->get_value()+1;

		foreach($breakpoint_keys as $breakpoint) {
			if($breakpoint == 'widescreen') {
				$widescreen_breakpoint_value = $active_breakpoints['widescreen']->get_value();
			} else {
				$breakpoint_value = $active_breakpoints[$breakpoint]->get_value();
				$column_str = 'columns_'.$breakpoint;
				$responsive_breakpoints[$breakpoint_value] = $$column_str;
			}
		}


		//for desktop
		$column_css .= "\n".'@media only screen and (min-width: '.$mobile_breakpoint_value.'px) {'."\n";
			$column_css .= '#wdt-'.esc_attr($module_class).'-'.esc_attr($module_id).' .wdt-column-wrapper:not(.wdt-snap-scroll-enabled) .wdt-column {'."\n";
				if($columns == 6) {
					$column_css .= 'width: 16.66%;'."\n";
				} else if($columns == 5) {
					$column_css .= 'width: 20%;'."\n";
				} else if($columns == 4) {
					$column_css .= 'width: 25%;'."\n";
				} else if($columns == 3) {
					$column_css .= 'width: 33.33%;'."\n";
				} else if($columns == 2) {
					$column_css .= 'width: 50%;'."\n";
				} else if($columns == 1) {
					$column_css .= 'width: 100%;'."\n";
				}
			$column_css .= '}'."\n";
		$column_css .= '}'."\n";

		// Snap Scroll Responsive
		$column_css .= "\n".'@media only screen and (min-width: '.$mobile_breakpoint_value.'px) {'."\n";
			$column_css .= '#wdt-'.esc_attr($module_class).'-'.esc_attr($module_id).' .wdt-column-wrapper.wdt-snap-scroll-enabled .wdt-column {'."\n";
				if($columns == 6) {
					$column_css .= 'flex: 0 0 16.66%;'."\n";
				} else if($columns == 5) {
					$column_css .= 'flex: 0 0 20%;'."\n";
				} else if($columns == 4) {
					$column_css .= 'flex: 0 0 25%;'."\n";
				} else if($columns == 3) {
					$column_css .= 'flex: 0 0 33.33%;'."\n";
				} else if($columns == 2) {
					$column_css .= 'flex: 0 0 50%;'."\n";
				} else if($columns == 1) {
					$column_css .= 'flex: 0 0 100%;'."\n";
				}
			$column_css .= '}'."\n";
		$column_css .= '}'."\n";

		// for widescreen
		if(isset($columns_widescreen) && $columns_widescreen != '') {
            if(isset($widescreen_breakpoint_value)) {
                $column_css .= "\n".'@media only screen and (min-width: '.$widescreen_breakpoint_value.'px) {'."\n";
                    $column_css .= '#wdt-'.esc_attr($module_class).'-'.esc_attr($module_id).' .wdt-column-wrapper:not(.wdt-snap-scroll-enabled) .wdt-column {'."\n";
                        if($columns_widescreen == 6) {
                            $column_css .= 'width: 16.66%;'."\n";
                        } else if($columns_widescreen == 5) {
                            $column_css .= 'width: 20%;'."\n";
                        } else if($columns_widescreen == 4) {
                            $column_css .= 'width: 25%;'."\n";
                        } else if($columns_widescreen == 3) {
                            $column_css .= 'width: 33.33%;'."\n";
                        } else if($columns_widescreen == 2) {
                            $column_css .= 'width: 50%;'."\n";
                        } else if($columns_widescreen == 1) {
                            $column_css .= 'width: 100%;'."\n";
                        }
                    $column_css .= '}'."\n";
                $column_css .= '}'."\n";
            }
		}
		// Snap Scroll Responsive
		if(isset($columns_widescreen) && $columns_widescreen != '') {
            if(isset($widescreen_breakpoint_value)) {
                $column_css .= "\n".'@media only screen and (min-width: '.$widescreen_breakpoint_value.'px) {'."\n";
                    $column_css .= '#wdt-'.esc_attr($module_class).'-'.esc_attr($module_id).' .wdt-column-wrapper.wdt-snap-scroll-enabled .wdt-column {'."\n";
                        if($columns_widescreen == 6) {
                            $column_css .= 'flex: 0 0 16.66%;'."\n";
                        } else if($columns_widescreen == 5) {
                            $column_css .= 'flex: 0 0 20%;'."\n";
                        } else if($columns_widescreen == 4) {
                            $column_css .= 'flex: 0 0 25%;'."\n";
                        } else if($columns_widescreen == 3) {
                            $column_css .= 'flex: 0 0 33.33%;'."\n";
                        } else if($columns_widescreen == 2) {
                            $column_css .= 'flex: 0 0 50%;'."\n";
                        } else if($columns_widescreen == 1) {
                            $column_css .= 'flex: 0 0 100%;'."\n";
                        }
                    $column_css .= '}'."\n";
                $column_css .= '}'."\n";
            }
		}

		// for other responsive size
		if(is_array($responsive_breakpoints) && !empty($responsive_breakpoints)) {
			foreach($responsive_breakpoints as $key => $responsive_breakpoint) {
				$column_css .= "\n".'@media only screen and (max-width: '.$key.'px) {'."\n";
					$column_css .= '#wdt-'.esc_attr($module_class).'-'.esc_attr($module_id).' .wdt-column-wrapper:not(.wdt-snap-scroll-enabled) .wdt-column {'."\n";

						if($responsive_breakpoint == 6) {
							$column_css .= 'width: 16.66%;'."\n";
						} else if($responsive_breakpoint == 5) {
							$column_css .= 'width: 20%;'."\n";
						} else if($responsive_breakpoint == 4) {
							$column_css .= 'width: 25%;'."\n";
						} else if($responsive_breakpoint == 3) {
							$column_css .= 'width: 33.33%;'."\n";
						} else if($responsive_breakpoint == 2) {
							$column_css .= 'width: 50%;'."\n";
						} else {
							$column_css .= 'width: 100%;'."\n";
						}

					$column_css .= '}'."\n";
				$column_css .= '}'."\n";
			}
		}
		// Snap Scroll Responsive
		if(is_array($responsive_breakpoints) && !empty($responsive_breakpoints)) {
			foreach($responsive_breakpoints as $key => $responsive_breakpoint) {
				$column_css .= "\n".'@media only screen and (max-width: '.$key.'px) {'."\n";
					$column_css .= '#wdt-'.esc_attr($module_class).'-'.esc_attr($module_id).' .wdt-column-wrapper.wdt-snap-scroll-enabled .wdt-column {'."\n";

						if($responsive_breakpoint == 6) {
							$column_css .= 'flex: 0 0 16.66%;'."\n";
						} else if($responsive_breakpoint == 5) {
							$column_css .= 'flex: 0 0 20%;'."\n";
						} else if($responsive_breakpoint == 4) {
							$column_css .= 'flex: 0 0 25%;'."\n";
						} else if($responsive_breakpoint == 3) {
							$column_css .= 'flex: 0 0 33.33%;'."\n";
						} else if($responsive_breakpoint == 2) {
							$column_css .= 'flex: 0 0 50%;'."\n";
						} else {
							$column_css .= 'flex: 0 0 100%;'."\n";
						}

					$column_css .= '}'."\n";
				$column_css .= '}'."\n";
			}
		}

		return $column_css;

	}

	public function get_column_edit_mode_css() {
		if(\Elementor\Plugin::$instance->editor->is_edit_mode()) {
			return '<style type="text/css">'."\n".$this->get_column_css()."\n".'</style>';
		}
		return '';
	}

	public function get_carousel_attributes() {

		extract($this->settings);

		$slides_to_show_opts_vertical = 1;

		if($direction == 'vertical') {
			$slides_to_show = $slides_to_show_opts_vertical;
		} else {
			$slides_to_show = $slides_to_show_opts;
		}


		$carousel_settings = array (
			'direction' 				=> $direction,
            'effect' 				    => $effect,
			'slides_to_show' 			=> $slides_to_show,
			'arrows'					=> $arrows,
			'pagination'				=> $pagination,
			'mouse_wheel_scroll'        => $mouse_wheel_scroll,
			'speed'						=> $speed,
			'autoplay'   				=> $autoplay,
			'autoplay_speed'   			=> $autoplay_speed,
			'loop'						=> $loop,
			'centered_slides'			=> $centered_slides,
			'pause_on_interaction'		=> $pause_on_interaction,
			'overflow_opacity'			=> $overflow_opacity,
			'unequal_height_compatability' => $unequal_height_compatability,
			'gap' => isset($gap['size']) ? $gap['size'] : 20
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

			if($direction == 'vertical') {

				$breakpoint_toshow = 1;
				$breakpoint_toscroll = 1;

			} else {
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

				$breakpoint_gap_str = 'gap_'.$breakpoint;
				$breakpoint_gap = $$breakpoint_gap_str;
                $breakpoint_gap = ($breakpoint_gap['size'] != '') ? $breakpoint_gap['size'] : $gap['size'];

                $space_between_gaps[$breakpoint] = $breakpoint_gap;

			}

			array_push($swiper_breakpoints, array (
					'breakpoint' => $active_breakpoints[$breakpoint]->get_value() + 1
				)
			);
			array_push($swiper_breakpoints_slides, array (
					'toshow' => (int)$breakpoint_toshow,
				)
			);

		}

		array_push($swiper_breakpoints_slides, array (
				'toshow' => (int)$slides_to_show,
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

    public function get_carousel_pagination_html() {

		extract($this->settings);

        $output = '';

		$output .= '<div class="wdt-carousel-pagination-wrapper">';
			if ( isset( $pagination ) && $pagination == 'scrollbar' ) :
				$output .= '<div class="wdt-swiper-scrollbar wdt-swiper-scrollbar-'.esc_attr($this->settings['module_id']).'"></div>';
			elseif ( isset( $pagination) && $pagination == 'fraction_bullets'):
				$output .= '<div class="wdt-swiper-cointainer-block">';
					$output .= '<div class="wdt-swiper-pagination wdt-swiper-pagination-fraction-bullets-'.esc_attr($this->settings['module_id']).'"></div>';
				$output .= '</div>';
			elseif ( isset( $pagination ) && $pagination != 'scrollbar' ) :
				$output .= '<div class="wdt-swiper-pagination wdt-swiper-pagination-'.esc_attr($this->settings['module_id']).'"></div>';
			endif;
			if ( isset( $arrows ) && $arrows == 'yes' ) :
				$output .= '<div class="wdt-carousel-arrow-pagination">';
					if(!empty($arrows_prev_icon['value'])) {
						$output .= '<div class="wdt-arrow-pagination-prev wdt-arrow-pagination-prev-'.esc_attr($this->settings['module_id']).'">';
							$output .= ($arrows_prev_icon['library'] === 'svg') ? '<i>' : '';
								ob_start();
								\Elementor\Icons_Manager::render_icon( $arrows_prev_icon, [ 'aria-hidden' => 'true' ] );
								$output .= ob_get_clean();
							$output .= ($arrows_prev_icon['library'] === 'svg') ? '</i>' : '';
						$output .= '</div>';
					}
					if(!empty($arrows_next_icon['value'])) {
						$output .= '<div class="wdt-arrow-pagination-next wdt-arrow-pagination-next-'.esc_attr($this->settings['module_id']).'">';
							$output .= ($arrows_next_icon['library'] === 'svg') ? '<i>' : '';
								ob_start();
								\Elementor\Icons_Manager::render_icon( $arrows_next_icon, [ 'aria-hidden' => 'true' ] );
								$output .= ob_get_clean();
							$output .= ($arrows_next_icon['library'] === 'svg') ? '</i>' : '';
						$output .= '</div>';
					}
				$output .= '</div>';
			endif;
		$output .= '</div>';

        return $output;

    }

}