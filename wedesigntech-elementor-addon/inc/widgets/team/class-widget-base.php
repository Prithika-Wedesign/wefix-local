<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Team {

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
				'image'        => esc_html__( 'Image', 'wdt-elementor-addon'),
				'title'        => esc_html__( 'Name', 'wdt-elementor-addon'),
				'sub_title'    => esc_html__( 'Role', 'wdt-elementor-addon'),
				'description'  => esc_html__( 'Description', 'wdt-elementor-addon'),
				'social_icons' => esc_html__( 'Social Icons', 'wdt-elementor-addon')
			);

		// Group 1 content positions
			$group1_content_position_elements = array(
				'image'           => esc_html__( 'Image', 'wdt-elementor-addon'),
				'title'           => esc_html__( 'Name', 'wdt-elementor-addon'),
				'sub_title'       => esc_html__( 'Role', 'wdt-elementor-addon')
			);
			$group1_content_positions = wedesigntech_elementor_format_repeater_values($group1_content_position_elements);

		// Group 2 content positions
			$group2_content_position_elements = array(
				'description' => esc_html__( 'Description', 'wdt-elementor-addon'),
				'social_icons' => esc_html__( 'Social Icons', 'wdt-elementor-addon'),
				'button'          => esc_html__( 'Button', 'wdt-elementor-addon')
			);
			$group2_content_positions = wedesigntech_elementor_format_repeater_values($group2_content_position_elements);

		// Content position elements
			$other_content_position_elements = array(
				'title_sub_title' => esc_html__( 'Name and Role', 'wdt-elementor-addon')
			);
			$content_position_elements = array_merge($other_content_position_elements, $group1_content_position_elements, $group2_content_position_elements);

		// Module defaults
            $option_defaults = array(
                array(
                    'item_type' => 'default',
                    'media_image' => array (
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ),
                    'media_image_size' => 'thumbnail',
                    'item_title' => esc_html__( 'Ut accumsan mass', 'wdt-elementor-addon' ),
                    'item_sub_title' => esc_html__( 'Accumsan mass', 'wdt-elementor-addon' ),
                    'item_description' => esc_html__( 'Donec sit amet turpis tincidunt eros, nam porttitor massa leo porta maecenas reque.', 'wdt-elementor-addon' ),
                    'facebook_link' => array (
                        'url' => '#'
                    ),
                    'twitter_link' => array (
                        'url' => '#'
                    ),
                    'youtube_link' => array (
                        'url' => '#'
                    ),
                    'linkedin_link' => array (
                        'url' => '#'
                    )
                ),
                array(
                    'item_type' => 'default',
                    'media_image' => array (
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ),
                    'media_image_size' => 'thumbnail',
                    'item_title' => esc_html__( 'Pellentesque ornare', 'wdt-elementor-addon' ),
                    'item_sub_title' => esc_html__( 'Tesque ornare', 'wdt-elementor-addon' ),
                    'item_description' => esc_html__( 'Donec sit amet turpis tincidunt eros, nam porttitor massa leo porta maecenas reque.', 'wdt-elementor-addon' ),
                    'facebook_link' => array (
                        'url' => '#'
                    ),
                    'twitter_link' => array (
                        'url' => '#'
                    ),
                    'youtube_link' => array (
                        'url' => '#'
                    ),
                    'linkedin_link' => array (
                        'url' => '#'
                    )
                    ),
                array(
                    'item_type' => 'default',
                    'media_image' => array (
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ),
                    'media_image_size' => 'thumbnail',
                    'item_title' => esc_html__( 'Pellentesque ornare', 'wdt-elementor-addon' ),
                    'item_sub_title' => esc_html__( 'Tesque ornare', 'wdt-elementor-addon' ),
                    'item_description' => esc_html__( 'Donec sit amet turpis tincidunt eros, nam porttitor massa leo porta maecenas reque.', 'wdt-elementor-addon' ),
                    'facebook_link' => array (
                        'url' => '#'
                    ),
                    'twitter_link' => array (
                        'url' => '#'
                    ),
                    'youtube_link' => array (
                        'url' => '#'
                    ),
                    'linkedin_link' => array (
                        'url' => '#'
                    )
                )
            );

		// Module Details
			$module_details = array(
				'content_positions'    => array ( 'group1', 'group1_element_group', 'group2', 'group2_element_group', 'title_subtitle_position'),
				'group1_title'         => esc_html__( 'Image Group', 'wdt-elementor-addon'),
				'group2_title'         => esc_html__( 'Content Group', 'wdt-elementor-addon'),
				'group_cp_label'       => esc_html__( 'Content Positions', 'wdt-elementor-addon'),
				'group_eg_cp_label'    => esc_html__( 'Element Group - Content Positions', 'wdt-elementor-addon'),
				'jsSlug'               => 'wdtRepeaterTeamContent',
				'title'                => esc_html__( 'Team Items', 'wdt-elementor-addon' ),
				'description'          => ''
			);

		// Initialize depandant class
			$this->cc_repeater_contents = new WeDesignTech_Common_Controls_Repeater_Contents($options_group, $options, $option_defaults, $module_details);
			$this->cc_layout = new WeDesignTech_Common_Controls_Layout('both');
			$this->cc_style = new WeDesignTech_Common_Controls_Style();

	}

	public function name() {
		return 'wdt-team';
	}

	public function title() {
		return esc_html__( 'Team', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'wdt-widget-icon';
	}

	public function init_styles() {
		return array_merge(
			$this->cc_layout->init_styles(),
			$this->cc_repeater_contents->init_styles(),
			array (
				$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/team/assets/css/style.css'
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
				$this->name() => WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/team/assets/js/script.js'
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

			$elementor_object->add_control( 'item_clickable', array(
				'label'   => esc_html__( 'Item Clickable', 'wdt-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__( 'Yes', 'wdt-elementor-addon' ),
				'label_off' => esc_html__( 'No', 'wdt-elementor-addon' ),
				'description' => esc_html__( 'Enable this option to make the item clickable.', 'wdt-elementor-addon' ),
				'condition' => array (
					'template' => 'default'
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

		// Name
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'name',
			'title' => esc_html__( 'Name', 'wdt-elementor-addon' ),
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
				'color' => array (
					'field_type' => 'color',
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item .wdt-content-title h5' => 'color: {{VALUE}};'
					),
					'condition' => array ()
				),
			)
		));

		// Role
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'role',
			'title' => esc_html__( 'Role', 'wdt-elementor-addon' ),
			'styles' => array (
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-subtitle',
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-content-item .wdt-content-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'color' => array (
					'field_type' => 'color',
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item .wdt-content-subtitle' => 'color: {{VALUE}};'
					),
					'condition' => array ()
				),
			)
		));

		// Image
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'image',
			'title' => esc_html__( 'Image', 'wdt-elementor-addon' ),
			'styles' => array (
				'alignment' => array (
					'field_type' => 'alignment',
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item .wdt-content-image-wrapper, 
						{{WRAPPER}} .wdt-content-item .wdt-content-image-wrapper .wdt-content-image' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
					),
					'condition' => array ()
				),
				'width' => array (
					'field_type' => 'width',
					'selector' => array (
                        '{{WRAPPER}} .wdt-content-item-holder .wdt-content-item .wdt-content-image-wrapper .wdt-content-image > span, 
						 {{WRAPPER}} .wdt-content-item-holder .wdt-content-item .wdt-content-image-wrapper .wdt-content-image > a' => 'width: {{SIZE}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'height' => array (
					'field_type' => 'height',
					'selector' => array (
                        '{{WRAPPER}} .wdt-content-item-holder .wdt-content-item .wdt-content-image-wrapper .wdt-content-image > span, 
						 {{WRAPPER}} .wdt-content-item-holder .wdt-content-item .wdt-content-image-wrapper .wdt-content-image > a' => 'height: {{SIZE}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-content-item .wdt-content-image-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item-holder .wdt-content-item .wdt-content-image-wrapper .wdt-content-image > span, 
						 {{WRAPPER}} .wdt-content-item-holder .wdt-content-item .wdt-content-image-wrapper .wdt-content-image > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'border' => array (
					'field_type' => 'border',
					'selector' => '{{WRAPPER}} .wdt-content-item-holder .wdt-content-item .wdt-content-image-wrapper .wdt-content-image > span, 
								   {{WRAPPER}} .wdt-content-item-holder .wdt-content-item .wdt-content-image-wrapper .wdt-content-image > a',
					'condition' => array ()
				),
				'border_radius' => array (
					'field_type' => 'border_radius',
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item-holder .wdt-content-item .wdt-content-image-wrapper .wdt-content-image > span, 
						 {{WRAPPER}} .wdt-content-item-holder .wdt-content-item .wdt-content-image-wrapper .wdt-content-image > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'box_shadow' => array (
					'field_type' => 'box_shadow',
					'selector' => '{{WRAPPER}} .wdt-content-item-holder .wdt-content-item .wdt-content-image-wrapper .wdt-content-image > span, 
								   {{WRAPPER}} .wdt-content-item-holder .wdt-content-item .wdt-content-image-wrapper .wdt-content-image > a',
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

		// Social Icons
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'socialicons',
			'title' => esc_html__( 'Social Icons', 'wdt-elementor-addon' ),
			'styles' => array (
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-content-item .wdt-social-icons-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
										'{{WRAPPER}} .wdt-content-item .wdt-social-icons-list li a' => 'color: {{VALUE}};'
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
										'{{WRAPPER}} .wdt-content-item:hover .wdt-social-icons-list li:hover a, 
										 {{WRAPPER}} .wdt-content-item:hover .wdt-social-icons-list li a:hover' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
							)
						)
					)
				)
			)
		));

		// Arrow
		$this->cc_layout->get_carousel_style_controls($elementor_object, array ('layout' => 'carousel'));

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
			$settings['module_class'] = 'team';
			if( !empty($settings['item_clickable']) && $settings['item_clickable'] == 'yes' ) {
				array_push($classes, 'wdt-item-clickable');
			}
			$settings['classes'] = $classes;
			$this->cc_layout->set_settings($settings);
			$settings['module_layout_class'] = $this->cc_layout->get_item_class();

			$output .= $this->cc_layout->get_wrapper_start();
				if($settings['template'] == 'default') {

					$group1_content_position_elements = array(
						'image' => esc_html__( 'Image', 'wdt-elementor-addon'),
					);
					$group2_content_position_elements = array(
						'title_sub_title' => esc_html__( 'Name and Role', 'wdt-elementor-addon'),
						'social_icons'    => esc_html__( 'Social Icons', 'wdt-elementor-addon')
					);

					$settings['group1_content_positions'] = wedesigntech_elementor_format_repeater_values($group1_content_position_elements);
					$settings['group2_content_positions'] = wedesigntech_elementor_format_repeater_values($group2_content_position_elements);
					if(!isset($settings['title_subtitle_position'])) {
						$settings['title_subtitle_position'] = 'below';
					}

					$output .= $this->cc_repeater_contents->render_html($widget_object, $settings);

				} else if($settings['template'] == 'standard') {

					$group1_content_position_elements = array(
						'image' => esc_html__( 'Image', 'wdt-elementor-addon'),
						'title' 		  => esc_html__( 'Name', 'wdt-elementor-addon'),
						'sub_title' 	  => esc_html__( 'Role', 'wdt-elementor-addon')
					);
					$group2_content_position_elements = array(
						'description'     => esc_html__( 'Description', 'wdt-elementor-addon'),
						'social_icons'    => esc_html__( 'Social Icons', 'wdt-elementor-addon')
					);

					$settings['group1_content_positions'] = wedesigntech_elementor_format_repeater_values($group1_content_position_elements);
					$settings['group2_content_positions'] = wedesigntech_elementor_format_repeater_values($group2_content_position_elements);

					$output .= $this->cc_repeater_contents->render_html($widget_object, $settings);

				}
				$output .= $this->cc_layout->get_column_edit_mode_css();
			$output .= $this->cc_layout->get_wrapper_end();

		else:
			$output .= '<div class="wdt-team-container no-records">';
				$output .= esc_html__('No records found!', 'wdt-elementor-addon');
			$output .= '</div>';
		endif;

		return $output;

	}

}

if( !function_exists( 'wedesigntech_widget_base_team' ) ) {
    function wedesigntech_widget_base_team() {
        return WeDesignTech_Widget_Base_Team::instance();
    }
}