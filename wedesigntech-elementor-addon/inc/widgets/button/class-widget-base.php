<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Button {

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
		return 'wdt-button';
	}

	public function title() {
		return esc_html__( 'Button', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'wdt-widget-icon';
	}

	public function init_styles() {
		return array (
				$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/button/assets/css/style.css'
			);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array ();
	}

	public function create_elementor_controls($elementor_object) {

		$elementor_object->start_controls_section( 'wdt_section_content', array(
			'label' => esc_html__( 'Content', 'wdt-elementor-addon'),
		));

			$elementor_object->add_control( 'text', array(
				'label'       => esc_html__( 'Text', 'wdt-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Click Here', 'wdt-elementor-addon' ),
				'placeholder' => esc_html__( 'Your button title goes here', 'wdt-elementor-addon' ),
			) );

			$elementor_object->add_control( 'subtext', array(
				'label'       => esc_html__( 'Sub Text', 'wdt-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'See More Here', 'wdt-elementor-addon' ),
				'placeholder' => esc_html__( 'Your button sub title goes here', 'wdt-elementor-addon' ),
			) );

			$elementor_object->add_control('icon',array (
				'label' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => array(
					'value' => 'far fa-paper-plane',
					'library' => 'fa-regular'
				)
			) );

			$elementor_object->add_control( 'icon_position', array(
				'label'     => esc_html__( 'Icon Position', 'wdt-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'after',
				'options'   => array(
					'before'  => esc_html__( 'Before', 'wdt-elementor-addon' ),
					'after' => esc_html__( 'After', 'wdt-elementor-addon' ),
				),
				'condition' => array(
					'icon[value]!' => ''
				),
			) );

			$elementor_object->add_control( 'icon_spacing', array(
				'label'     => esc_html__( 'Icon Spacing', 'wdt-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array( 'px' => array( 'max' => 50, ), ),
				'selectors' => array(
					'{{WRAPPER}} .wdt-button-holder.wdt-button-icon-after .wdt-button-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wdt-button-holder.wdt-button-icon-before .wdt-button-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'icon[value]!' => ''
				),
			) );

			$elementor_object->add_control( 'link',array(
				'label'       => esc_html__( 'Link', 'wdt-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'wdt-elementor-addon' ),
				'default'     => array( 'url' => '#' ),
			) );

		$elementor_object->end_controls_section();

		$elementor_object->start_controls_section( 'wdt_section_settings', array(
			'label' => esc_html__( 'Settings', 'wdt-elementor-addon'),
		));

			$elementor_object->add_control( 'template', array(
				'label'   => esc_html__( 'Template', 'wdt-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT2,
				'default' => 'filled',
				'options' => array(
					'filled' => esc_html__( 'Filled', 'wdt-elementor-addon' ),
					'bordered' => esc_html__( 'Bordered', 'wdt-elementor-addon' ),
					'textual' => esc_html__( 'Textual', 'wdt-elementor-addon' )
				)
			) );

			$elementor_object->add_control( 'style', array(
				'label'          => esc_html__( 'Style', 'wdt-elementor-addon' ),
				'type'           => \Elementor\Controls_Manager::SELECT,
				'default'        => 'underline',
				'options'        => array(
					'default' => esc_html__( 'Default', 'wdt-elementor-addon' ),
					'underline' => esc_html__( 'Underline', 'wdt-elementor-addon' )
				)
			) );

			$elementor_object->add_control( 'size', array(
				'label'          => esc_html__( 'Size', 'wdt-elementor-addon' ),
				'type'           => \Elementor\Controls_Manager::SELECT,
				'default'        => 'sm',
				'options'        => array(
					'sm' => esc_html__( 'Small', 'wdt-elementor-addon' ),
					'nm' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
					'lg' => esc_html__( 'Large', 'wdt-elementor-addon' ),
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
							'{{WRAPPER}} .elementor-widget-container' => 'text-align: {{VALUE}}; justify-content: {{VALUE}};'
						),
						'condition' => array ()
					),
					'typography' => array (
						'field_type' => 'typography',
						'selector' => '{{WRAPPER}} .wdt-button-holder .wdt-button',
						'condition' => array ()
					),
					'margin' => array (
						'field_type' => 'margin',
						'selector' => array (
							'{{WRAPPER}} .wdt-button-holder .wdt-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
						'condition' => array ()
					),
					'padding' => array (
						'field_type' => 'padding',
						'selector' => array (
							'{{WRAPPER}} .wdt-button-holder .wdt-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
											'{{WRAPPER}} .wdt-button-holder .wdt-button' => 'color: {{VALUE}} !important;'
										),
										'condition' => array ()
									),
									'border' => array (
										'field_type' => 'border',
										'selector' => '{{WRAPPER}} .wdt-button-holder .wdt-button',
										'color_selector' => array (
											'{{WRAPPER}} .wdt-button-holder .wdt-button' => 'border-color: {{VALUE}};',
											'{{WRAPPER}} .wdt-button-holder.wdt-button-style-underline:before' => 'color: {{VALUE}};'
										),
										'condition' => array ()
									),
									'background' => array (
										'field_type' => 'background',
										'selector' => '{{WRAPPER}} .wdt-button-holder .wdt-button',
										'color_selector' => array (
											'{{WRAPPER}} .wdt-button-holder .wdt-button' => 'background-color: {{VALUE}};',
											'{{WRAPPER}} .wdt-button-holder.wdt-button-style-underline:before' => 'color: {{VALUE}};'
										),
										'condition' => array ()
									),
									'border_radius' => array (
										'field_type' => 'border_radius',
										'selector' => array (
											'{{WRAPPER}} .wdt-button-holder .wdt-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
										),
										'condition' => array ()
									),
									'box_shadow' => array (
										'field_type' => 'box_shadow',
										'selector' => '{{WRAPPER}} .wdt-button-holder .wdt-button',
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
											'{{WRAPPER}} .wdt-button-holder .wdt-button:focus, 
											 {{WRAPPER}} .wdt-button-holder .wdt-button:hover' => 'color: {{VALUE}} !important;'
										),
										'condition' => array ()
									),
									'border' => array (
										'field_type' => 'border',
										'selector' => '{{WRAPPER}} .wdt-button-holder .wdt-button:focus, 
													   {{WRAPPER}} .wdt-button-holder .wdt-button:hover',
										'color_selector' => array (
											'{{WRAPPER}} .wdt-button-holder .wdt-button:focus, 
											 {{WRAPPER}} .wdt-button-holder .wdt-button:hover' => 'border-color: {{VALUE}};',

											'{{WRAPPER}} .wdt-button-holder.wdt-button-style-underline:focus:before,
											 {{WRAPPER}} .wdt-button-holder.wdt-button-style-underline:hover:before' => 'color: {{VALUE}};',

										),
										'condition' => array ()
									),
									'background' => array (
										'field_type' => 'background',
										'selector' => '{{WRAPPER}} .wdt-button-holder .wdt-button:focus, 
													   {{WRAPPER}} .wdt-button-holder .wdt-button:hover, 
													   {{WRAPPER}} .wdt-button-holder.wdt-template-bordered .wdt-button:focus:before, 
													   {{WRAPPER}} .wdt-button-holder.wdt-template-bordered .wdt-button:hover:before',
										'color_selector' => array (
											'{{WRAPPER}} .wdt-button-holder .wdt-button:focus, 
											 {{WRAPPER}} .wdt-button-holder .wdt-button:hover,
											 {{WRAPPER}} .wdt-button-holder.wdt-template-bordered .wdt-button:focus:before,
											 {{WRAPPER}} .wdt-button-holder.wdt-template-bordered .wdt-button:hover:before' => 'background-color: {{VALUE}};',

											'{{WRAPPER}} .wdt-button-holder.wdt-button-style-underline:focus:before,
											 {{WRAPPER}} .wdt-button-holder.wdt-button-style-underline:hover:before' => 'color: {{VALUE}};'
										),
										'condition' => array ()
									),
									'border_radius' => array (
										'field_type' => 'border_radius',
										'selector' => array (
											'{{WRAPPER}} .wdt-button-holder .wdt-button:focus, 
											 {{WRAPPER}} .wdt-button-holder .wdt-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
										),
										'condition' => array ()
									),
									'box_shadow' => array (
										'field_type' => 'box_shadow',
										'selector' => '{{WRAPPER}} .wdt-button-holder .wdt-button:focus, 
										 			   {{WRAPPER}} .wdt-button-holder .wdt-button:hover',
										'condition' => array ()
									)
								)
							)
						)
					),
					'padding_label' => array (
						'field_type' => 'padding',
						'unique_key' => 'label',
						'separator' => 'before',
						'label' => esc_html__( 'Label Padding', 'wdt-elementor-addon' ),
						'selector' => array (
							'{{WRAPPER}} .wdt-button-holder .wdt-button .wdt-button-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
						'condition' => array ()
					)
				)
			));

		// Icon
			$this->cc_style->get_style_controls($elementor_object, array (
				'slug' => 'icon',
				'title' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
				'styles' => array (
					'margin' => array (
						'field_type' => 'margin',
						'selector' => array (
							'{{WRAPPER}} .wdt-button-holder .wdt-button .wdt-button-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
						'condition' => array ()
					),
					'padding' => array (
						'field_type' => 'padding',
						'selector' => array (
							'{{WRAPPER}} .wdt-button-holder .wdt-button .wdt-button-icon span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
											'{{WRAPPER}} .wdt-button-holder .wdt-button .wdt-button-icon span' => 'color: {{VALUE}};'
										),
										'condition' => array ()
									),
									'background' => array (
										'field_type' => 'background',
										'selector' => '{{WRAPPER}} .wdt-button-holder .wdt-button .wdt-button-icon span',
										'condition' => array ()
									),
									'border' => array (
										'field_type' => 'border',
										'selector' => '{{WRAPPER}} .wdt-button-holder .wdt-button .wdt-button-icon span',
										'condition' => array ()
									),
									'border_radius' => array (
										'field_type' => 'border_radius',
										'selector' => array (
											'{{WRAPPER}} .wdt-button-holder .wdt-button .wdt-button-icon span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
										),
										'condition' => array ()
									),
									'box_shadow' => array (
										'field_type' => 'box_shadow',
										'selector' => '{{WRAPPER}} .wdt-button-holder .wdt-button .wdt-button-icon span',
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
											'{{WRAPPER}} .wdt-button-holder .wdt-button:focus .wdt-button-icon span, 
											 {{WRAPPER}} .wdt-button-holder .wdt-button:hover .wdt-button-icon span' => 'color: {{VALUE}};'
										),
										'condition' => array ()
									),
									'background' => array (
										'field_type' => 'background',
										'selector' => '{{WRAPPER}} .wdt-button-holder .wdt-button:focus .wdt-button-icon span, 
										 			   {{WRAPPER}} .wdt-button-holder .wdt-button:hover .wdt-button-icon span',
										'condition' => array ()
									),
									'border' => array (
										'field_type' => 'border',
										'selector' => '{{WRAPPER}} .wdt-button-holder .wdt-button:focus .wdt-button-icon span, 
													   {{WRAPPER}} .wdt-button-holder .wdt-button:hover .wdt-button-icon span',
										'condition' => array ()
									),
									'border_radius' => array (
										'field_type' => 'border_radius',
										'selector' => array (
											'{{WRAPPER}} .wdt-button-holder .wdt-button:focus .wdt-button-icon span, 
											 {{WRAPPER}} .wdt-button-holder .wdt-button:hover .wdt-button-icon span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
										),
										'condition' => array ()
									),
									'box_shadow' => array (
										'field_type' => 'box_shadow',
										'selector' => '{{WRAPPER}} .wdt-button-holder .wdt-button:focus .wdt-button-icon span, 
													   {{WRAPPER}} .wdt-button-holder .wdt-button:hover .wdt-button-icon span',
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

		$button_class = $icon_class = '';

		if(!empty($settings['link']['url'])) {
			$widget_object->add_link_attributes( 'button', $settings['link'] );
			array_push($classes, 'wdt-button-link');
		}

		if(!empty($settings['style'])) {
			array_push($classes, 'wdt-button-style-' . esc_attr($settings['style']));
		}

		if(!empty($settings['size'])) {
			array_push($classes, 'wdt-button-size-' . esc_attr($settings['size']));
		}

		if ( ! empty($settings['icon']) ) {
			if ( $settings['icon_position'] == 'before' ) {
				array_push($classes, 'wdt-button-icon-before');
			} else {
				array_push($classes, 'wdt-button-icon-after');
			}
		}

		$module_id = $widget_object->get_id();

		$output .= '<div class="wdt-button-holder '.esc_attr(implode(' ', $classes)).'" id="wdt-button-'.esc_attr($module_id).'">';
			$output .= '<a class="wdt-button" '.$widget_object->get_render_attribute_string('button').'>';
				if($settings['icon_position'] == 'before'){
					$output .= '<span class="wdt-button-icon">'.$this->render_icon($settings['icon']).'</span>';
				}
				$output .= '<span class="wdt-button-text">'.esc_html($settings['text']);
					if($settings['subtext'] != '') {
						$output .= '<small class="wdt-button-subtext">'.esc_html($settings['subtext']).'</small>';
					}
				$output .= '</span>';
				if($settings['icon_position'] == 'after'){
					$output .= '<span class="wdt-button-icon">'.$this->render_icon($settings['icon']).'</span>';
				}
			$output .= '</a>';
		$output .= '</div>';

		return $output;

	}

	public function render_icon($icon) {
		$output = '';
			if(!empty($icon['value'])):

				$output .= '<span class="wdt-button-icon-inner">';
					ob_start();
					\Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );
					$output .= ob_get_clean();
				$output .= '</span>';

			endif;
		return $output;
	}

}

if( !function_exists( 'wedesigntech_widget_base_button' ) ) {
    function wedesigntech_widget_base_button() {
        return WeDesignTech_Widget_Base_Button::instance();
    }
}