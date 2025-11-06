<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Interactive_Showcase {

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
			$options_group = array( 'default', 'template' );
			$options['default'] = array(
				'icon'           => esc_html__( 'Icon', 'wdt-elementor-addon'),
				'title'          => esc_html__( 'Title', 'wdt-elementor-addon'),
				'description'    => esc_html__( 'Description', 'wdt-elementor-addon'),
				'image'          => esc_html__( 'Image', 'wdt-elementor-addon'),
				'link'           => esc_html__( 'Link', 'wdt-elementor-addon'),
				'button'         => esc_html__( 'Button', 'wdt-elementor-addon')
			);
			$options['template'] = array(
				'icon'           => esc_html__( 'Icon', 'wdt-elementor-addon'),
				'title'          => esc_html__( 'Title', 'wdt-elementor-addon'),
				'description'    => esc_html__( 'Description', 'wdt-elementor-addon'),
				'link'           => esc_html__( 'Link', 'wdt-elementor-addon'),
				'button'         => esc_html__( 'Button', 'wdt-elementor-addon')
			);

		// Group 1 content positions
			$group1_content_position_elements = array(
				'image'           => esc_html__( 'Image', 'wdt-elementor-addon'),
				'icon'            => esc_html__( 'Icon', 'wdt-elementor-addon'),
				'elements_group'  => esc_html__( 'Elements Group', 'wdt-elementor-addon')
			);
			$group1_content_positions = wedesigntech_elementor_format_repeater_values($group1_content_position_elements);

		// Group 1 - Element Group content positions
			$group1_element_group_content_position_elements = array(
				'title'           => esc_html__( 'Title', 'wdt-elementor-addon'),
				'description'     => esc_html__( 'Description', 'wdt-elementor-addon'),
				'link'            => esc_html__( 'Link', 'wdt-elementor-addon'),
				'button'          => esc_html__( 'Button', 'wdt-elementor-addon')
			);
			$group1_element_group_content_positions = wedesigntech_elementor_format_repeater_values($group1_element_group_content_position_elements);

		// Group 2 content positions
			$group2_content_position_elements = array();
			$group2_content_positions = wedesigntech_elementor_format_repeater_values($group2_content_position_elements);

		// Group 2 - Element Group content positions
			$group2_element_group_content_position_elements = array();
			$group2_element_group_content_positions = wedesigntech_elementor_format_repeater_values($group2_element_group_content_position_elements);

		// Content position elements
			$content_position_elements = array_merge($group1_content_position_elements, $group1_element_group_content_position_elements, $group2_content_position_elements, $group2_element_group_content_position_elements);

		// Module defaults
			$option_defaults = array(
				array(
					'item_type' => 'default',
					'media_image' => array (
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
					'media_image_size' => 'full',
					'media_icon' => array (
						'value' => 'fas fa-star',
						'library' => 'fa-solid'
					),
					'media_icon_style' => 'default',
					'media_icon_shape' => 'circle',
					'item_title' => esc_html__( 'Ut accumsan mass', 'wdt-elementor-addon' ),
					'item_description' => esc_html__( 'Donec sed lectus mi. Vestibulum et augue ultricies, tempus augue non, consectetur est. In arcu justo, pulvinar sit amet turpis id, tincidunt fermentum eros.', 'wdt-elementor-addon' ),
					'item_link'    => array (
						'url' => '#',
						'is_external' => true,
						'nofollow' => true,
						'custom_attributes' => ''
					),
					'item_button_text' => esc_html__( 'Click Here', 'wdt-elementor-addon' )
				),
				array(
					'item_type' => 'default',
					'media_image' => array (
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
					'media_image_size' => 'full',
					'media_icon' => array (
						'value' => 'fas fa-star',
						'library' => 'fa-solid'
					),
					'media_icon_style' => 'default',
					'media_icon_shape' => 'circle',
					'item_title' => esc_html__( 'Pellentesque ornare', 'wdt-elementor-addon' ),
					'item_sub_title' => esc_html__( 'Tesque ornare', 'wdt-elementor-addon' ),
					'item_description' => esc_html__( 'Vestibulum et augue ultricies, tempus augue non, consectetur est. In arcu justo, pulvinar sit amet turpis id, tincidunt fermentum eros.', 'wdt-elementor-addon' ),
					'item_link'    => array (
						'url' => '#',
						'is_external' => true,
						'nofollow' => true,
						'custom_attributes' => ''
					),
					'item_button_text' => esc_html__( 'Click Here', 'wdt-elementor-addon' )
				)
			);

		// Module Details
			$module_details = array (
				'content_positions' => array ( 'group1', 'group1_element_group', 'group2', 'group2_element_group'),
				'group1_title'    => esc_html__( 'Image Group', 'wdt-elementor-addon'),
				'group2_title'    => esc_html__( 'Content Group', 'wdt-elementor-addon'),
				'group_cp_label'    => esc_html__( 'Content Positions', 'wdt-elementor-addon'),
				'group_eg_cp_label' => esc_html__( 'Element Group - Content Positions', 'wdt-elementor-addon'),
				'jsSlug'          => 'wdtRepeaterInteractiveShowcaseContent',
				'title'           => esc_html__( 'Items', 'wdt-elementor-addon' ),
				'description'     => ''
			);

		// Initialize depandant class
			$this->cc_repeater_contents = new WeDesignTech_Common_Controls_Repeater_Contents($options_group, $options, $option_defaults, $module_details);
			$this->cc_content_position = new WeDesignTech_Common_Controls_Content_Position($content_position_elements, $group1_content_positions, $group1_element_group_content_positions, $group2_content_positions, $group2_element_group_content_positions, $module_details);
			$this->cc_layout = new WeDesignTech_Common_Controls_Layout('both');
			$this->cc_style = new WeDesignTech_Common_Controls_Style();

	}

	public function name() {
		return 'wdt-interactive-showcase';
	}

	public function title() {
		return esc_html__( 'Interactive Showcase', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'wdt-widget-icon';
	}

	public function init_styles() {
		return array_merge(
			$this->cc_repeater_contents->init_styles(),
			array (
				$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/interactive-showcase/assets/css/style.css'
			)
		);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array (
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/interactive-showcase/assets/js/script.js'
		);
	}

	public function create_elementor_controls($elementor_object) {

		$this->cc_repeater_contents->get_controls($elementor_object);

		$elementor_object->start_controls_section( 'wdt_section_settings', array(
			'label' => esc_html__( 'Settings', 'wdt-elementor-addon'),
		) );

			$elementor_object->add_control(
				'icon_show',
				array(
					'label'              => esc_html__( 'Show Icon', 'wdt-elementor-addon' ),
					'type'               => \Elementor\Controls_Manager::SWITCHER,
					'frontend_available' => true,
					'default'            => 'true',
					'return_value'       => 'true',
					'condition' => array ()
				)
			);

			$elementor_object->add_control(
				'hover_and_click',
				array(
					'label'              => esc_html__( 'Show Content on Click', 'wdt-elementor-addon' ),
					'type'               => \Elementor\Controls_Manager::SWITCHER,
					'frontend_available' => true,
					'default'            => 'false',
					'return_value'       => 'true',
					'condition' => array ()
				)
			);

			$elementor_object->add_control(
				'title_prefix',
				array (
					'label' 			 => esc_html__( 'Title Prefix', 'wdt-elementor-addon' ),
					'type' 				 => \Elementor\Controls_Manager::SELECT,
					'options' 			 => array (
						''  			 => esc_html__( 'None', 'wdt-elementor-addon' ),
						'number'   		 => esc_html__( 'Number', 'wdt-elementor-addon' ),
						'alphabet' 		 => esc_html__( 'Alphabet', 'wdt-elementor-addon' ),
					),
					'default' 			 => ''
				)
			);

		$elementor_object->end_controls_section();


	// Item Content
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'tab_item_content',
			'title' => esc_html__( 'Item Content', 'wdt-elementor-addon' ),
			'styles' => array (
				'alignment' => array (
					'field_type' => 'alignment',
					'selector' => array (
						'{{WRAPPER}} .wdt-showcase-container .wdt-showcase-list' => 'text-align: {{VALUE}}; justify-content: {{VALUE}};'
					),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-showcase-container .wdt-showcase-list-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'background' => array (
					'field_type' => 'background',
					'selector' => '{{WRAPPER}} .wdt-showcase-container .wdt-showcase-list-wrapper',
					'color_selector' => array (
						'{{WRAPPER}} .wdt-showcase-container .wdt-showcase-list-wrapper, 
						 {{WRAPPER}} .wdt-showcase-container .wdt-showcase-list-wrapper:before' => 'background-color: {{VALUE}};'
					),
					'condition' => array ()
				),
				'border' => array (
					'field_type' => 'border',
					'selector' => '{{WRAPPER}} .wdt-showcase-container .wdt-showcase-list-wrapper, 
					 			   {{WRAPPER}} .wdt-showcase-container .wdt-showcase-list-wrapper:before',
					'condition' => array ()
				),
				'border_radius' => array (
					'field_type' => 'border_radius',
					'selector' => array (
						'{{WRAPPER}} .wdt-showcase-container .wdt-showcase-list-wrapper, 
						 {{WRAPPER}} .wdt-showcase-container .wdt-showcase-list-wrapper:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				)
			)
		));

	// Tab Content
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'tab_content',
			'title' => esc_html__( 'Tab Content', 'wdt-elementor-addon' ),
			'styles' => array (
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-showcase-container .wdt-showcase-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'background' => array (
					'field_type' => 'background',
					'selector' => '{{WRAPPER}} .wdt-showcase-container .wdt-showcase-content-wrapper',
					'condition' => array ()
				),
				'border' => array (
					'field_type' => 'border',
					'selector' => '{{WRAPPER}} .wdt-showcase-container .wdt-showcase-content-wrapper',
					'condition' => array ()
				),
				'border_radius' => array (
					'field_type' => 'border_radius',
					'selector' => array (
						'{{WRAPPER}} .wdt-showcase-container .wdt-showcase-content-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'box_shadow' => array (
					'field_type' => 'box_shadow',
					'selector' => '{{WRAPPER}} .wdt-showcase-container .wdt-showcase-content-wrapper',
					'condition' => array ()
				)
			)
		));

	// Title Group 
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'title_group',
			'title' => esc_html__( 'Title Group', 'wdt-elementor-addon' ),
			'styles' => array (
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-showcase-title-group .wdt-content-title, 
								   {{WRAPPER}} .wdt-showcase-title-group .wdt-showcase-title-prefix',
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-showcase-title-group .wdt-content-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'color' => array (
					'field_type' => 'color',
					'selector' => array (
						'{{WRAPPER}} .wdt-showcase-title-group .wdt-content-title, 
						 {{WRAPPER}} .wdt-showcase-title-group .wdt-showcase-title-prefix' => 'color: {{VALUE}};'
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
					'selector' => '{{WRAPPER}} .wdt-showcase-container .wdt-content-description',
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-showcase-container .wdt-content-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-showcase-container .wdt-content-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'color' => array (
					'field_type' => 'color',
					'selector' => array (
						'{{WRAPPER}} .wdt-showcase-container .wdt-content-description' => 'color: {{VALUE}};'
					),
					'condition' => array ()
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
					'selector' => '{{WRAPPER}} .wdt-showcase-container .wdt-showcase-button > a',
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-showcase-container .wdt-showcase-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-showcase-container .wdt-showcase-button > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
										'{{WRAPPER}} .wdt-showcase-container .wdt-showcase-button > a' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-showcase-container .wdt-showcase-button > a',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-showcase-container .wdt-showcase-button > a',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-showcase-container .wdt-showcase-button > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-showcase-container .wdt-showcase-button > a',
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
										'{{WRAPPER}} .wdt-showcase-container .wdt-showcase-button > a:focus, 
										 {{WRAPPER}} .wdt-showcase-container .wdt-showcase-button > a:hover' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-showcase-container .wdt-showcase-button > a:focus, 
									 			   {{WRAPPER}} .wdt-showcase-container .wdt-showcase-button > a:hover',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-showcase-container .wdt-showcase-button > a:focus, 
									               {{WRAPPER}} .wdt-showcase-container .wdt-showcase-button > a:hover',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-showcase-container .wdt-showcase-button > a:focus, 
										 {{WRAPPER}} .wdt-showcase-container .wdt-showcase-button > a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-showcase-container .wdt-showcase-button > a:focus, 
									 			   {{WRAPPER}} .wdt-showcase-container .wdt-showcase-button > a:hover',
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

		if( count( $settings['item_contents'] ) > 0 ):

			$settings['module_id'] = $widget_object->get_id();
			$settings['module_class'] = 'interactive-showcase';

			$output .= '<div class="wdt-showcase-container" data-click="'. esc_js($settings['hover_and_click']) .'">';

				// Showcase List
				$output .= '<div class="wdt-showcase-list-wrapper">';

					$output .= '<ul class="wdt-showcase-list">';
						foreach( $settings['item_contents'] as $key => $item ) {
							$output .= '<li id="wdt-showcase-'.esc_attr($key).'">';
								$output .= '<div class="wdt-showcase-element">';

								if( $item['item_type'] == 'template' ) {

									$output .= '<div class="wdt-showcase-content-group">';

										if($settings['icon_show'] == 'true') {
											$output .= $this->cc_repeater_contents->render_template_icon($key, $item, $widget_object);
										}									
										
										// Title group
										$output .= '<div class="wdt-showcase-title-group">';

											if($settings['title_prefix'] == 'alphabet') {
												$alphabets = range('A', 'Z');
												$output .= '<div class="wdt-showcase-title-prefix alphabet">';
													$output .= $alphabets[$key];
												$output .= '</div>';
											} else if($settings['title_prefix'] == 'number') {
												$output .= '<div class="wdt-showcase-title-prefix number">';
													$output .= '0'.($key+1);
												$output .= '</div>';
											}
											
											if( !empty($item['item_title']) ) {
												$output .= '<h4 class="wdt-content-title">'.esc_html($item['item_title']).'</h4>';
											}

										$output .= '</div>';

										if( !empty($item['item_description_template']) ) {
											$output .= '<div class="wdt-content-description">'.esc_html($item['item_description_template']).'</div>';
										}
										
										if ( isset($item['item_link_template']['url']) && !empty($item['item_link_template']['url']) && !empty($item['item_button_text_template']) ) {
											$output .= '<div class="wdt-showcase-button">';
												$target = ( $item['item_link_template']['is_external'] == 'on' ) ? ' target="_blank" ' : '';
												$nofollow = ( $item['item_link_template']['nofollow'] == 'on' ) ? 'rel="nofollow" ' : '';
												$output .= '<a class="wdt-button" href="'.esc_url( $item['item_link_template']['url'] ).'"'. $target . $nofollow.'>'. esc_html__($item['item_button_text_template']) .'</a>';
											$output .= '</div>';
										}

									$output .= '</div>';

								} else {
									
									$output .= '<div class="wdt-showcase-content-group">';

										if($settings['icon_show'] == 'true') {
											$output .= $this->render_icon($item['media_icon']);
										}

										// Title group
										$output .= '<div class="wdt-showcase-title-group">';

											if($settings['title_prefix'] == 'alphabet') {
												$alphabets = range('A', 'Z');
												$output .= '<div class="wdt-showcase-title-prefix alphabet">';
													$output .= $alphabets[$key];
												$output .= '</div>';
											} else if($settings['title_prefix'] == 'number') {
												$output .= '<div class="wdt-showcase-title-prefix number">';
													$output .= '0'.($key+1);
												$output .= '</div>';
											}	

											if( !empty($item['item_title']) ) {
												$output .= '<h4 class="wdt-content-title">'.esc_html($item['item_title']).'</h4>';
											}

										$output .= '</div>';
										
										if( !empty($item['item_description']) ) {
											$output .= '<div class="wdt-content-description">'.esc_html($item['item_description']).'</div>';
										}

										if ( !empty($item['item_button_text']) && isset($item['item_link']['url']) && !empty($item['item_link']['url']) ) {
											$output .= '<div class="wdt-showcase-button">';
												$target = ( $item['item_link']['is_external'] == 'on' ) ? ' target="_blank" ' : '';
												$nofollow = ( $item['item_link']['nofollow'] == 'on' ) ? 'rel="nofollow" ' : '';
												$output .= '<a class="wdt-button" href="'.esc_url( $item['item_link']['url'] ).'"'. $target . $nofollow.'>'. esc_html__($item['item_button_text']) .'</a>';
											$output .= '</div>';
										}

									$output .= '</div>';

								}
							$output .= '</div></li>';
						}
					$output .= '</ul>';
				$output .= '</div>';

				// Showcase Content
				$output .= '<div class="wdt-showcase-content-wrapper">';

					foreach( $settings['item_contents'] as $key => $item ) {
						$output .= '<div id="wdt-showcase-'.esc_attr($key).'">';

						if( $item['item_type'] == 'template' ) {

							$frontend = Elementor\Frontend::instance();
							$output .= $frontend->get_builder_content( $item['item_template'], true );

						} else {

								if ( !empty($item['media_image']['url']) ) {
									$output .= $this->cc_repeater_contents->render_image($item, '', '');
								} else {
									$output .= '<div class="wdt-content-image-wrapper empty">' . esc_html__('No Image', 'wdt-elementor-addon') . '</div>';
								}

						}

						$output .= '</div>';
					}

				$output .= '</div>';

			$output .= '</div>';

		else:
			$output .= '<div class="wdt-showcase-container no-records">';
				$output .= esc_html__('No records found!', 'wdt-elementor-addon');
			$output .= '</div>';
		endif;

		return $output;

	}

	public function render_icon($icon) {
		$output = '';
			if(!empty($icon['value'])):
				$output .= '<div class="wdt-content-icon"><span>';
					ob_start();
					\Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );
					$output .= ob_get_clean();
				$output .= '</span></div>';
			endif;
		return $output;
	}

	public function render_image($item, $link_start, $link_end) {
		$output = '';
		if ( ! empty( $item['media_image_template']['url'] ) ) :
			$class = '';
			$output .= '<div class="wdt-content-image-wrapper '.esc_attr($class).'">';
				$output .= '<div class="wdt-content-image">';

					$media_image_setting = array ();
					$media_image_setting['image'] = $item['media_image_template'];
					$media_image_setting['image_size'] = 'full';
					$media_image_setting['image_custom_dimension'] = isset($item['media_image_template_custom_dimension']) ? $item['media_image_custom_dimension'] : array ();

					$output .=  ($link_start != '') ? $link_start : '<span>';
						$output .= \Elementor\Group_Control_Image_Size::get_attachment_image_html( $media_image_setting );
					$output .=  ($link_end != '') ? $link_end : '</span>';

				$output .= '</div>';
			$output .= '</div>';

		endif;
		return $output;
	}

}

if( !function_exists( 'wedesigntech_widget_base_interactive_showcase' ) ) {
    function wedesigntech_widget_base_interactive_showcase() {
        return WeDesignTech_Widget_Base_Interactive_Showcase::instance();
    }
}