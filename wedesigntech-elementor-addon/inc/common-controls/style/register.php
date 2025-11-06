<?php

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class WeDesignTech_Common_Controls_Style {

    function __construct() {
    }

	public function get_global_settings( $type, $value ) {

		$kit = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend();
		$kit_settings = $kit->get_settings_for_display( $type );

		if($type == 'system_colors') {
			return $kit_settings[$value]['color'];
		}

	}

	public function map_global_settings( $type, $value ) {
		$schemes_to_globals_map = array (
			'color' => array (
				'0' => Global_Colors::COLOR_PRIMARY,
				'1' => Global_Colors::COLOR_SECONDARY,
				'2' => Global_Colors::COLOR_TEXT,
				'3' => Global_Colors::COLOR_ACCENT,
			),
			'typography' => array (
				'0' => Global_Typography::TYPOGRAPHY_PRIMARY,
				'1' => Global_Typography::TYPOGRAPHY_SECONDARY,
				'2' => Global_Typography::TYPOGRAPHY_TEXT,
				'3' => Global_Typography::TYPOGRAPHY_ACCENT,
			),
		);

		return $schemes_to_globals_map[ $type ][ $value ];
	}

    public function get_style_control_element($elementor_object, $field_type, $style, $unique_key) {

        if($field_type == 'typography') {
            $elementor_object->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                array (
                    'name' => $unique_key,
                    'label' => isset($style['label']) ? $style['label'] : esc_html__( 'Typography', 'wdt-elementor-addon' ),
                    'selector' => isset($style['selector']) ? $style['selector'] : '',
                    'condition' => isset($style['condition']) ? $style['condition'] : array (),
                    'separator' => isset($style['separator']) ? $style['separator'] : ''
                )
            );
        }

        if($field_type == 'margin') {
            $elementor_object->add_responsive_control(
                $unique_key.'_margin',
                array (
                    'label' => isset($style['label']) ? $style['label'] : esc_html__( 'Margin', 'wdt-elementor-addon' ),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => array ( 'px', 'em', '%', 'rem' ),
                    'selectors' => $style['selector'],
                    'condition' => isset($style['condition']) ? $style['condition'] : array (),
                    'separator' => isset($style['separator']) ? $style['separator'] : ''
                )
            );
        }

        if($field_type == 'padding') {
			$elementor_object->add_responsive_control(
				$unique_key.'_padding',
				array (
                    'label' => isset($style['label']) ? $style['label'] : esc_html__( 'Padding', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => array ( 'px', 'em', '%', 'rem' ),
                    'selectors' => isset($style['selector']) ? $style['selector'] : '',
                    'condition' => isset($style['condition']) ? $style['condition'] : array (),
                    'separator' => isset($style['separator']) ? $style['separator'] : ''
				)
			);
        }

        if($field_type == 'color') {
            $elementor_object->add_control(
                $unique_key.'_color',
                array (
                    'label' => isset($style['label']) ? $style['label'] : esc_html__( 'Color', 'wdt-elementor-addon' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => isset($style['selector']) ? $style['selector'] : '',
                    'condition' => isset($style['condition']) ? $style['condition'] : array (),
                    'separator' => isset($style['separator']) ? $style['separator'] : ''
                )
            );
        }

        if($field_type == 'gradient_color') {
            $elementor_object->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                array (
                    'name' => $unique_key.'_gradient_color',
                    'types' => array ( 'gradient' ),
                    'selector' => $style['selector'],
                    'fields_options' => array (
                        'background' => array (
                            'label' => esc_html__( 'Gradient Color', 'wdt-elementor-addon' ),
                            'frontend_available' => true
                        ),
                        'gradient_angle' => array (
                            'frontend_available' => true,
                            'selectors' => array (
                                $style['selector'] => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}});  -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;'
                            ),
                            'separator' => isset($style['separator']) ? $style['separator'] : '',
                            'condition' => array(
                                'background' => [ 'gradient' ],
                                'gradient_type' => [ 'linear', 'radial' ]
                            ),
                        )
                    ),
                    'condition' => isset($style['condition']) ? $style['condition'] : array (),
                    'separator' => isset($style['separator']) ? $style['separator'] : ''
                )
            );
        }

        if($field_type == 'background') {
            $elementor_object->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                array (
                    'name' => $unique_key.'_background',
                    'types' => array ( 'classic', 'gradient' ),
                    'selector' => $style['selector'],
                    'fields_options' => array (
                        'background' => array (
                            'frontend_available' => true
                        ),
                        'color' => array (
                            'label' => esc_html__( 'Background Color', 'wdt-elementor-addon' ),
                            'frontend_available' => true,
                            'selectors' => isset($style['color_selector']) ? $style['color_selector'] : array (
                                $style['selector'] => 'background-color: {{VALUE}};'
                            )
                        ),
                    ),
                    'condition' => isset($style['condition']) ? $style['condition'] : array (),
                    'separator' => isset($style['separator']) ? $style['separator'] : ''
                )
            );
        }

        if($field_type == 'border') {
            $elementor_object->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                array (
                    'name' => $unique_key.'_border',
                    'selector' => $style['selector'],
                    'fields_options' => array (
                        'width' => array (
                            'label' => esc_html__( 'Border Width', 'wdt-elementor-addon' ),
                        ),
                        'color' => array (
                            'label' => esc_html__( 'Border Color', 'wdt-elementor-addon' ),
                            'selectors' => isset($style['color_selector']) ? $style['color_selector'] : array (
                                $style['selector'] => 'border-color: {{VALUE}};'
                            )
                        ),
                    ),
                    'condition' => isset($style['condition']) ? $style['condition'] : array (),
                    'separator' => isset($style['separator']) ? $style['separator'] : ''
                )
            );
        }

        if($field_type == 'border_radius') {
            $elementor_object->add_responsive_control(
                $unique_key.'_border_radius',
                array (
                    'label' => isset($style['label']) ? $style['label'] : esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => array ( 'px', 'em', '%' ),
                    'selectors' => $style['selector'],
                    'condition' => isset($style['condition']) ? $style['condition'] : array (),
                    'separator' => isset($style['separator']) ? $style['separator'] : ''
                )
            );
        }

        if($field_type == 'box_shadow') {
            $elementor_object->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                array (
                    'name' => $unique_key.'_box_shadow',
                    'selector' => $style['selector'],
                    'condition' => isset($style['condition']) ? $style['condition'] : array (),
                    'separator' => isset($style['separator']) ? $style['separator'] : ''
                )
            );
        }

        if($field_type == 'text_shadow') {
            $elementor_object->add_group_control(
                \Elementor\Group_Control_Text_Shadow::get_type(),
                array (
                    'name' => $unique_key.'_text_shadow',
                    'selector' => $style['selector'],
                    'condition' => isset($style['condition']) ? $style['condition'] : array (),
                    'separator' => isset($style['separator']) ? $style['separator'] : ''
                )
            );
        }

        if($field_type == 'alignment') {
            $control = 'add_control';
            if(isset($style['control_type']) && $style['control_type'] === 'responsive') {
                $control = 'add_responsive_control';
            }
			$elementor_object->add_responsive_control(
				$unique_key.'_align',
				array (
                    'label' => isset($style['label']) ? $style['label'] : esc_html__( 'Alignment', 'wdt-elementor-addon' ),
					'type' =>\Elementor\Controls_Manager::CHOOSE,
					'options' => isset($style['options']) ? $style['options'] : array (
						'start' => array (
							'title' => esc_html__( 'Start', 'wdt-elementor-addon' ),
							'icon' => 'eicon-text-align-left',
						),
						'center' => array (
							'title' => esc_html__( 'Center', 'wdt-elementor-addon' ),
							'icon' => 'eicon-text-align-center',
						),
						'end' => array (
							'title' => esc_html__( 'End', 'wdt-elementor-addon' ),
							'icon' => 'eicon-text-align-right',
						)
					),
                   // 'frontend_available' => true,
					'selectors' => isset($style['selector']) ? $style['selector'] : array (),
                    'prefix_class' => isset($style['prefix_class']) ? $style['prefix_class'] : '',
                    'condition' => isset($style['condition']) ? $style['condition'] : array (),
					'default' => isset($style['default']) ? $style['default'] : '',
					'separator' => isset($style['separator']) ? $style['separator'] : ''
				)
			);
        }

        if($field_type == 'width') {
            $elementor_object->add_responsive_control(
                $unique_key.'_width',
                array (
                    'label' => isset($style['label']) ? $style['label'] : esc_html__( 'Width', 'wdt-elementor-addon' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'default' => isset($style['default']) ? $style['default'] : array (
                        'unit' => '%',
                    ),
                    'size_units' => isset($style['size_units']) ? $style['size_units'] : array ( '%', 'px' ),
                    'range' => isset($style['range']) ? $style['range'] :  array (
                        '%' => array (
                            'min' => 1,
                            'max' => 100,
                        ),
                        'px' => array (
                            'min' => 1,
                            'max' => 1000,
                        )
                    ),
                    'selectors' => isset($style['selector']) ? $style['selector'] : '',
                    'condition' => isset($style['condition']) ? $style['condition'] : array (),
					'separator' => isset($style['separator']) ? $style['separator'] : ''
                )
            );
        }

        if($field_type == 'height') {
            $elementor_object->add_responsive_control(
                $unique_key.'_height',
                array (
                    'label' => isset($style['label']) ? $style['label'] : esc_html__( 'Height', 'wdt-elementor-addon' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'default' => isset($style['default']) ? $style['default'] : array (
                        'unit' => '%',
                    ),
                    'size_units' => isset($style['size_units']) ? $style['size_units'] : array ( '%', 'px' ),
                    'range' => isset($style['range']) ? $style['range'] :  array (
                        '%' => array (
                            'min' => 1,
                            'max' => 100,
                        ),
                        'px' => array (
                            'min' => 1,
                            'max' => 500,
                        )
                    ),
                    'selectors' => isset($style['selector']) ? $style['selector'] : '',
                    'condition' => isset($style['condition']) ? $style['condition'] : array (),
					'separator' => isset($style['separator']) ? $style['separator'] : ''
                )
            );
        }

        if($field_type == 'font_size') {
            $elementor_object->add_responsive_control(
                $unique_key.'_font_size',
                array (
                    'label' => isset($style['label']) ? $style['label'] : esc_html__( 'Font Size', 'wdt-elementor-addon' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'default' => isset($style['default']) ? $style['default'] : array (),
                    'size_units' => array(
                        'px'
                    ),
                    'responsive' => true,
                    'range' => array (
                        'px' => array (
                            'min' => 16,
                            'max' => 160
                        ),
                    ),
                    'selectors' => isset($style['selector']) ? $style['selector'] : '',
                    'condition' => isset($style['condition']) ? $style['condition'] : array (),
					'separator' => isset($style['separator']) ? $style['separator'] : ''
                )
            );
        }

        if($field_type == 'ratio') {
            $elementor_object->add_responsive_control(
                $unique_key.'_ratio',
                array (
                    'label' => isset($style['label']) ? $style['label'] : esc_html__( 'Ratio', 'wdt-elementor-addon' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'default' => array (
                        'unit' => '%',
                    ),
                    'tablet_default' => array (
                        'unit' => '%',
                    ),
                    'mobile_default' => array (
                        'unit' => '%',
                    ),
                    'size_units' => array ( '%' ),
                    'range' => array (
                        '%' => array (
                            'min' => 0,
                            'max' => 200,
                        )
                    ),
                    'selectors' => $style['selector'],
                    'condition' => isset($style['condition']) ? $style['condition'] : array (),
                )
            );
        }

        if($field_type == 'vertical_align') {
			$elementor_object->add_control(
				$unique_key.'_vertical_align',
				array (
                    'label' => isset($style['label']) ? $style['label'] : esc_html__( 'Vertical Align', 'wdt-elementor-addon' ),
					'type' =>\Elementor\Controls_Manager::CHOOSE,
                    'options' => isset($style['options']) ? $style['options'] : array (
						'flex-start' => array (
							'title' => esc_html__( 'Top', 'wdt-elementor-addon' ),
							'icon' => 'eicon-v-align-top',
						),
						'flex-end' => array (
							'title' => esc_html__( 'Bottom', 'wdt-elementor-addon' ),
							'icon' => 'eicon-v-align-bottom',
						)
					),
                    'frontend_available' => true,
                    'default' => isset($style['default']) ? $style['default'] : 'flex-start',
					'selectors' => $style['selector'],
                    'condition' => isset($style['condition']) ? $style['condition'] : array (),
					'separator' => isset($style['separator']) ? $style['separator'] : ''
				)
			);
        }

        if($field_type == 'horizontal_align') {
			$elementor_object->add_control(
				$unique_key.'_horizontal_align',
				array (
                    'label' => isset($style['label']) ? $style['label'] : esc_html__( 'Horizontal Align', 'wdt-elementor-addon' ),
					'type' =>\Elementor\Controls_Manager::CHOOSE,
					'options' => array (
						'left' => array (
							'title' => esc_html__( 'Left', 'wdt-elementor-addon' ),
							'icon' => 'eicon-h-align-left',
						),
						'right' => array (
							'title' => esc_html__( 'Right', 'wdt-elementor-addon' ),
							'icon' => 'eicon-h-align-right',
						)
					),
                    'default' => 'left',
                    'selectors' => isset($style['selector']) ? $style['selector'] : array (),
                    'condition' => isset($style['condition']) ? $style['condition'] : array (),
					'separator' => isset($style['separator']) ? $style['separator'] : ''
				)
			);
        }

        if($field_type == 'indent') {
            $elementor_object->add_responsive_control(
                $unique_key.'_indent',
                array (
                    'label' => isset($style['label']) ? $style['label'] : esc_html__( 'Indent', 'wdt-elementor-addon' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'default' => array (
                        'unit' => '%',
                    ),
                    'tablet_default' => array (
                        'unit' => '%',
                    ),
                    'mobile_default' => array (
                        'unit' => '%',
                    ),
                    'size_units' => array( 'px', '%', 'em' ),
                    'range' => array (
                        'px' => array(
                            'min' => -400,
                            'max' => 400,
                        ),
                        '%' => array(
                            'min' => -100,
                            'max' => 100,
                        ),
                        'em' => array(
                            'min' => -50,
                            'max' => 50,
                        )
                    ),
                    'frontend_available' => true,
                    'selectors' => $style['selector'],
                    'condition' => isset($style['condition']) ? $style['condition'] : array (),
                )
            );
        }

        if($field_type == 'weight') {
            $elementor_object->add_responsive_control(
                $unique_key.'_weight',
                array (
                    'label' => isset($style['label']) ? $style['label'] : esc_html__( 'Weight', 'wdt-elementor-addon' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'default' => isset($style['default']) ? $style['default'] : array (
                        'unit' => '%',
                    ),
                    'size_units' => isset($style['size_units']) ? $style['size_units'] : array ( '%', 'px' ),
                    'range' => array (
                        '%' => array (
                            'min' => 1,
                            'max' => 100,
                        ),
                        'px' => array (
                            'min' => 1,
                            'max' => 10,
                        )
                    ),
                    'selectors' => $style['selector'],
                    'condition' => isset($style['condition']) ? $style['condition'] : array (),
					'separator' => isset($style['separator']) ? $style['separator'] : ''
                )
            );
        }

        if($field_type == 'gap') {
            $elementor_object->add_responsive_control(
                $unique_key.'_gap',
                array (
                    'label' => isset($style['label']) ? $style['label'] : esc_html__( 'Gap', 'wdt-elementor-addon' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'default' => isset($style['default']) ? $style['default'] : array (
                        'unit' => 'px',
                    ),
                    'size_units' => isset($style['size_units']) ? $style['size_units'] : array ( 'px' ),
                    'range' => array (
                        'px' => array (
                            'min' => 0,
                            'max' => 50,
                        )
                    ),
                    'selectors' => $style['selector'],
                    'condition' => isset($style['condition']) ? $style['condition'] : array (),
                )
            );
        }

        if($field_type == 'select') {
            $elementor_object->add_control(
                $unique_key,
                array(
                    'label' => isset($style['label']) ? $style['label'] : esc_html__( 'Select', 'wdt-elementor-addon' ),
                    'type'    => \Elementor\Controls_Manager::SELECT,
                    'default' => isset($style['default']) ? $style['default'] : '',
                    'options' =>  isset($style['options']) ? $style['options'] : array (),
                    'separator' => isset($style['separator']) ? $style['separator'] : '',
                    'selectors' => isset($style['selector']) ? $style['selector'] : '',
                    'condition' => isset($style['condition']) ? $style['condition'] : array (),
                )
            );
        }

        if($field_type == 'number') {
            $elementor_object->add_control(
                $unique_key,
                array(
                    'label' => isset($style['label']) ? $style['label'] : esc_html__( 'Number', 'wdt-elementor-addon' ),
                    'type'    => \Elementor\Controls_Manager::NUMBER,
                    'default' => isset($style['default']) ? $style['default'] : 1,
                    'min' =>  isset($style['min']) ? $style['min'] : 1,
                    'max' =>  isset($style['max']) ? $style['max'] : 100,
                    'selectors' => isset($style['selector']) ? $style['selector'] : '',
                    'separator' => isset($style['separator']) ? $style['separator'] : '',
                    'condition' => isset($style['condition']) ? $style['condition'] : array (),
                )
            );
        }

        if($field_type == 'switcher') {
            $elementor_object->add_control( $unique_key, array(
                'label' => isset($style['label']) ? $style['label'] : esc_html__( 'Switcher', 'wdt-elementor-addon' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => isset($style['default']) ? $style['default'] : 'yes',
                'frontend_available' => true,
                'return_value' => isset($style['return_value']) ? $style['return_value'] : 'yes',
                'separator' => isset($style['separator']) ? $style['separator'] : '',
                'condition' => isset($style['condition']) ? $style['condition'] : array (),
            ) );
        }

        if($field_type == 'slider') {
            $elementor_object->add_responsive_control(
                $unique_key,
                array (
                    'label' => isset($style['label']) ? $style['label'] : esc_html__( 'Slider', 'wdt-elementor-addon' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'default' => isset($style['default']) ? $style['default'] : array (
                        'unit' => '%',
                    ),
                    'size_units' => isset($style['size_units']) ? $style['size_units'] : array ( '%', 'px' ),
                    'range' => isset($style['range']) ? $style['range'] : array (
                        '%' => array (
                            'min' => 1,
                            'max' => 100,
                        ),
                        'px' => array (
                            'min' => 1,
                            'max' => 10,
                        )
                    ),
                    'selectors' => isset($style['selector']) ? $style['selector'] : '',
                    'condition' => isset($style['condition']) ? $style['condition'] : array (),
					'separator' => isset($style['separator']) ? $style['separator'] : ''
                )
            );
        }

        if($field_type == 'font') {
            $elementor_object->add_control(
                $unique_key.'_font',
                array (
                    'label' => isset($style['label']) ? $style['label'] : esc_html__( 'Font', 'wdt-elementor-addon' ),
                    'type' => \Elementor\Controls_Manager::FONT,
                    'condition' => isset($style['condition']) ? $style['condition'] : array (),
					'separator' => isset($style['separator']) ? $style['separator'] : ''
                )
            );
        }

        if($field_type == 'heading') {
            $elementor_object->add_control(
                $unique_key.'_heading',
                array (
                    'label' => $style['title'],
                    'type' => \Elementor\Controls_Manager::HEADING,
                    'separator' => isset($style['separator']) ? $style['separator'] : '',
                    'condition' => isset($style['condition']) ? $style['condition'] : array ()
                )
            );
        }

        // Image type - Specially for image group

        if($field_type == 'media_image_type') {
            $elementor_object->add_control( 'media_image_type', array(
                'label'   => esc_html__( 'Image Type', 'wdt-elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'default',
                'options' => $style['options'],
                'condition' => isset($style['condition']) ? $style['condition'] : array (),
                'separator' => isset($style['separator']) ? $style['separator'] : ''
            ) );
        }

        if($field_type == 'media_image_ratio') {
            $elementor_object->add_responsive_control(
                'media_image_ratio',
                array (
                    'label' => esc_html__( 'Image Ratio', 'elementor' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'default' => array (
                        'unit' => '%',
                    ),
                    'tablet_default' => array (
                        'unit' => '%',
                    ),
                    'mobile_default' => array (
                        'unit' => '%',
                    ),
                    'size_units' => array ( '%' ),
                    'range' => array (
                        '%' => array (
                            'min' => 0,
                            'max' => 100,
                        )
                    ),
                    'selectors' => $style['selector'],
                    'condition' => isset($style['condition']) ? $style['condition'] : array (),
                )
            );
        }

    }

    public function get_style_controls($elementor_object, $options) {

        $elementor_object->start_controls_section( 'wdt_style_section_'.$options['slug'], array(
        	'label'      => $options['title'],
			'tab'        => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => (isset($options['condition']) && !empty($options['condition'])) ? $options['condition'] : array (),
			'show_label' => false,
		) );

        if(is_array($options['styles']) && !empty($options['styles'])) {
            foreach($options['styles'] as $style) {

                $control_unique_key = isset($style['unique_key']) ? $options['slug'].'_'.$style['unique_key'] : $options['slug'];

                if($style['field_type'] === 'tabs') {

                    if(isset($style) && !empty($style)) {

                        $elementor_object->start_controls_tabs( 'tabs_'.$control_unique_key.'_style',
                            array (
                                'condition' => isset($style['condition']) ? $style['condition'] : array (),
                            )
                        );

                        foreach($style['tab_items'] as $tab_item_key => $tab_item) {

                            $elementor_object->start_controls_tab(
                                'tab_'.$control_unique_key.'_'.$tab_item_key,
                                array (
                                    'label' => $tab_item['title'],
                                    'condition' => isset($tab_item['condition']) ? $tab_item['condition'] : array (),
                                )
                            );

                                if(isset($tab_item['styles']) && !empty($tab_item['styles'])) {
                                    foreach($tab_item['styles'] as $tab_style) {

                                        $tab_control_unique_key = isset($tab_style['unique_key']) ? $control_unique_key.'_'.$tab_item_key.'_'.$tab_style['unique_key'] : $control_unique_key.'_'.$tab_item_key;

                                        $this->get_style_control_element($elementor_object, $tab_style['field_type'], $tab_style, $tab_control_unique_key);

                                    }
                                }

                            $elementor_object->end_controls_tab();

                        }

                        $elementor_object->end_controls_tabs();

                    }

                } else {
                    $this->get_style_control_element($elementor_object, $style['field_type'], $style, $control_unique_key);
                }

            }
        }

        $elementor_object->end_controls_section();

	}


    /* to delete */

	public function get_content_style_controls($elementor_object, $options) {}

    public function get_basic_style_controls($elementor_object, $options) {}

	public function get_image_style_controls($elementor_object, $options) {}

    public function get_icon_style_controls($elementor_object, $options) {}

}