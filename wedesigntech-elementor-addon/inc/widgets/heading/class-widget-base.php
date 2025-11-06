<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Heading {

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

		// Initialize depandant class
			$this->cc_repeater_contents = new WeDesignTech_Common_Controls_Repeater_Contents(array (), array (), array (), array ());
			$this->cc_style = new WeDesignTech_Common_Controls_Style();

		// Actions & Filters
			add_filter( 'wdt_elementor_localize_settings', array( $this, 'wdt_register_elementor_localize_settings' )  );

	}

	public function name() {
		return 'wdt-heading';
	}

	public function title() {
		return esc_html__( 'Heading', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'wdt-widget-icon';
	}

	public function init_styles() {
		return array (
				$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/heading/assets/css/style.css'
			);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array ();
	}

	public function wdt_register_elementor_localize_settings($settings) {
		$settings['wdtHeaderItems'] = array(
			'title' => esc_html__( 'Title', 'wdt-elementor-addon'),
			'subtitle' => esc_html__( 'Sub Title', 'wdt-elementor-addon'),
            'background_text' => esc_html__( 'Background Text', 'wdt-elementor-addon'),
			'content' => esc_html__( 'Content', 'wdt-elementor-addon')
		);
		return $settings;
	}


	public function create_elementor_controls($elementor_object) {

		// Header

			$elementor_object->start_controls_section( 'wdt_section_header', array(
				'label' => esc_html__( 'Header', 'wdt-elementor-addon'),
			));

				// Title

					$elementor_object->add_control(
						'title_heading',
						array (
							'label' => esc_html__( 'Title', 'elementor' ),
							'type' => \Elementor\Controls_Manager::HEADING
						)
					);

					$elementor_object->add_control( 'title_tag', array(
						'label'   => esc_html__( 'Title Tag', 'wdt-elementor-addon' ),
						'type'    => \Elementor\Controls_Manager::SELECT,
						'default' => 'h2',
						'options' => array(
							'div'  => esc_html__( 'Div', 'wdt-elementor-addon' ),
							'h1'   => esc_html__( 'H1', 'wdt-elementor-addon' ),
							'h2'   => esc_html__( 'H2', 'wdt-elementor-addon' ),
							'h3'   => esc_html__( 'H3', 'wdt-elementor-addon' ),
							'h4'   => esc_html__( 'H4', 'wdt-elementor-addon' ),
							'h5'   => esc_html__( 'H5', 'wdt-elementor-addon' ),
							'h6'   => esc_html__( 'H6', 'wdt-elementor-addon' ),
							'span' => esc_html__( 'Span', 'wdt-elementor-addon' ),
							'p'    => esc_html__( 'P', 'wdt-elementor-addon' )
						)
					));

					$elementor_object->add_control( 'title', array(
						'label'       => esc_html__( 'Title', 'wdt-elementor-addon' ),
						'type'        => \Elementor\Controls_Manager::TEXT,
						'label_block' => true,
						'placeholder' => esc_html__( 'Your title goes here', 'wdt-elementor-addon' ),
						'default'     => esc_html__( 'Heading', 'wdt-elementor-addon' )
					));


				// Sub Title

					$elementor_object->add_control(
						'subtitle_heading',
						array (
							'label' => esc_html__( 'Sub Title', 'elementor' ),
							'type' => \Elementor\Controls_Manager::HEADING,
							'separator' => 'before'
						)
					);

					$elementor_object->add_control(
						'subtitle',
						array (
							'label' => esc_html__( 'Sub Title', 'elementor' ),
							'type' => \Elementor\Controls_Manager::TEXT,
							'label_block' => true,
							'placeholder' => esc_html__( 'Your sub title goes here', 'wdt-elementor-addon' ),
							'default' => esc_html__( 'Sub Heading', 'wdt-elementor-addon' )
						)
					);


				// Content

					$elementor_object->add_control(
						'content_heading',
						array (
							'label' => esc_html__( 'Content', 'elementor' ),
							'type' => \Elementor\Controls_Manager::HEADING,
							'separator' => 'before'
						)
					);

					$elementor_object->add_control(
						'content',
						array (
							'label' => esc_html__( 'Content', 'elementor' ),
							'type' => \Elementor\Controls_Manager::TEXTAREA,
							'default' => esc_html__( 'Few lines to well describe your content supporting headline.', 'wdt-elementor-addon' )
						)
					);

				// Background Text

                    $elementor_object->add_control(
                        'background_text_heading',
                        array (
                            'label' => esc_html__( 'Background Text', 'elementor' ),
                            'type' => \Elementor\Controls_Manager::HEADING,
                            'separator' => 'before'
                        )
                    );

                    $elementor_object->add_control(
                        'background_text',
                        array (
                            'label' => esc_html__( 'Background Text', 'elementor' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'label_block' => true,
                            'placeholder' => esc_html__( 'Your background text goes here', 'wdt-elementor-addon' ),
                            'default' => ''
                        )
                    );

			$elementor_object->end_controls_section();

		// Highlight Elements

			$elementor_object->start_controls_section( 'wdt_section_highlight_elements', array(
				'label' => esc_html__( 'Highlight Elements', 'wdt-elementor-addon'),
			));

				$elementor_object->add_control( 'colored_elements', array(
					'label'       => esc_html__( 'Colored Elements', 'wdt-elementor-addon' ),
					'type'        => \Elementor\Controls_Manager::TEXT,
					'label_block' => true,
					'placeholder' => '1,2',
					'description'     => esc_html__( 'Enter comma separated positions of the Title, for colored elements.', 'wdt-elementor-addon' )
				));

			$elementor_object->end_controls_section();

		// Content Positions

			$elementor_object->start_controls_section( 'wdt_section_content_positions', array(
				'label' => esc_html__( 'Content Positions', 'wdt-elementor-addon'),
			));

				$header_positions = new \Elementor\Repeater();
				$header_positions->add_control( 'element_value', array(
					'type'    => \Elementor\Controls_Manager::SELECT,
					'label'   => esc_html__('Element', 'wdt-elementor-addon'),
					'default' => 'title',
					'options' => array(
						'title'           => esc_html__( 'Title', 'wdt-elementor-addon'),
						'subtitle'        => esc_html__( 'Sub Text', 'wdt-elementor-addon'),
						'background_text' => esc_html__( 'Background Text', 'wdt-elementor-addon'),
						'content'         => esc_html__( 'Content', 'wdt-elementor-addon')
					)
				) );
				$elementor_object->add_control( 'header_positions', array(
					'type'          => \Elementor\Controls_Manager::REPEATER,
					'label'         => esc_html__('Positions', 'wdt-elementor-addon'),
					'fields'        => $header_positions->get_controls(),
					'default'       =>  array(
						array(
							'element_value' => 'subtitle'
						),
						array(
							'element_value' => 'title'
						),
						array(
							'element_value' => 'content'
						),
						array(
							'element_value' => 'background_text'
						)
					),
					'prevent_empty' => true,
					'title_field'   => '{{ wdtGetHeaderItems( obj ) }}'
				) );

			$elementor_object->end_controls_section();


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
								'{{WRAPPER}} .wdt-heading-holder, 
								 {{WRAPPER}} .wdt-heading-holder > .wdt-heading-title-wrapper .wdt-heading-title, 
								 {{WRAPPER}} .wdt-heading-holder > .wdt-heading-subtitle-wrapper .wdt-heading-subtitle' => 'text-align: {{VALUE}}; justify-content: {{VALUE}};'
							),
							'condition' => array ()
						),
						'margin' => array (
							'field_type' => 'margin',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'padding' => array (
							'field_type' => 'padding',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						)
					)
				));

			// Title
				$this->cc_style->get_style_controls($elementor_object, array (
					'slug' => 'title',
					'title' => esc_html__( 'Title', 'wdt-elementor-addon' ),
					'styles' => array (
						'margin' => array (
							'field_type' => 'margin',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper.wdt-heading-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'padding' => array (
							'field_type' => 'padding',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper.wdt-heading-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'typography' => array (
							'field_type' => 'typography',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper.wdt-heading-title',
							'condition' => array ()
						),
						'color' => array (
							'field_type' => 'color',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper.wdt-heading-title' => 'color: {{VALUE}};'
							),
							'condition' => array ()
						),
						'gradient_color' => array (
							'field_type' => 'gradient_color',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper.wdt-heading-title',
							'separator' => 'after',
							'condition' => array ()
						),
						'text_shadow' => array (
							'field_type' => 'text_shadow',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper.wdt-heading-title',
							'condition' => array ()
						)
					)
				));

			// Sub Title
				$this->cc_style->get_style_controls($elementor_object, array (
					'slug' => 'subtitle',
					'title' => esc_html__( 'Sub Title', 'wdt-elementor-addon' ),
					'styles' => array (
						'margin' => array (
							'field_type' => 'margin',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-subtitle-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'typography' => array (
							'field_type' => 'typography',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-subtitle-wrapper',
							'condition' => array ()
						),
						'color' => array (
							'field_type' => 'color',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-subtitle-wrapper' => 'color: {{VALUE}};'
							),
							'condition' => array ()
						)
					)
				));

			// Background Text
                $this->cc_style->get_style_controls($elementor_object, array (
                    'slug' => 'background_text',
                    'title' => esc_html__( 'Background Text', 'wdt-elementor-addon' ),
                    'styles' => array (
                        'typography' => array (
                            'field_type' => 'typography',
                            'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-background-text-wrapper',
                            'condition' => array ()
                        ),
                        'color' => array (
                            'field_type' => 'color',
                            'selector' => array (
                                '{{WRAPPER}} .wdt-heading-holder .wdt-heading-background-text-wrapper' => 'color: {{VALUE}};'
                            ),
                            'condition' => array ()
                        )
                    )
                ));

			// Content
				$this->cc_style->get_style_controls($elementor_object, array (
					'slug' => 'content',
					'title' => esc_html__( 'Content', 'wdt-elementor-addon' ),
					'styles' => array (
						'margin' => array (
							'field_type' => 'margin',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-content-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'padding' => array (
							'field_type' => 'padding',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'typography' => array (
							'field_type' => 'typography',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-content-wrapper',
							'condition' => array ()
						),
						'color' => array (
							'field_type' => 'color',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-content-wrapper' => 'color: {{VALUE}};'
							),
							'condition' => array ()
						)
					)
				));

			

			// Highlight Elements
				$this->cc_style->get_style_controls($elementor_object, array (
					'slug' => 'highlight_elements',
					'title' => esc_html__( 'Highlight Elements', 'wdt-elementor-addon' ),
					'condition' => array (
						'colored_elements!' => ''
					),
					'styles' => array (
						'color' => array (
							'field_type' => 'color',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-title .wdt-heading-colored-elements' => 'color: {{VALUE}};'
							)
						),
						'gradient_color' => array (
							'field_type' => 'gradient_color',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-title .wdt-heading-colored-elements',
							'separator' => 'after',
							'condition' => array ()
						),
					)
				));

		do_action('wdt_heading_pro_controls', $elementor_object);


	}

	public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}

		$output = '';

		$classes = array ();
		$module_id = $widget_object->get_id();

		$content_positions = $this->cc_repeater_contents->content_position_items($settings['header_positions']);
		if(is_array($content_positions) && !empty($content_positions)) {

			$output .= '<div class="wdt-heading-holder '.esc_attr(implode(' ', $classes)).'" id="wdt-heading-'.esc_attr($module_id).'">';

			foreach($content_positions as $content_position) {
				 if($content_position == 'title') {
					$output .= $this->render_title_html($settings);
				}else if($content_position == 'subtitle') {
					$output .= $this->render_subtitle_html($settings, $widget_object);
				} else if($content_position == 'background_text') {
					$output .= $this->render_background_text_html($settings, $widget_object);
				} else if($content_position == 'content') {
					$output .= $this->render_content_html($settings);
				}
			}

			$output .= '</div>';

		}

		return $output;

	}

	public function render_title_html($settings) {

		$output = '';

		if(isset($settings['title']) && !empty($settings['title'])) {
			$output .= '<'.esc_attr($settings['title_tag']).' class="wdt-heading-title-wrapper wdt-heading-title">';
				$output .= $this->render_title_splitup_html($settings['title'], $settings['colored_elements']);
			$output .= '</'.esc_attr($settings['title_tag']).'>';
		}

		return $output;

	}

	public function render_title_splitup_html($title, $colored_elements) {

		$splitted_titles = explode(' ', $title);
		$colored_elements_splitted = explode(',', trim($colored_elements));

		$text = '';
		foreach($splitted_titles as $key => $splitted_title) {
			$updated_key = $key + 1;
			if(in_array($updated_key, $colored_elements_splitted)) {
				$text .= '<span class="wdt-heading-colored-elements">'.$splitted_title.'</span>';
			} else {
				$text .= $splitted_title.' ';
			}
		}

		return trim($text);

	}

	public function render_subtitle_html($settings) {

		$output = '';

		if(isset($settings['subtitle']) && !empty($settings['subtitle'])) {
			$output .= '<div class="wdt-heading-subtitle-wrapper wdt-heading-subtitle">';
				$output .= $settings['subtitle'];
			$output .= '</div>';
		}

		return $output;

	}

	public function render_background_text_html($settings) {

		$output = '';

		if(isset($settings['background_text']) && !empty($settings['background_text'])) {
			$output .= '<div class="wdt-heading-background-text-wrapper">';
				$output .= $settings['background_text'];
			$output .= '</div>';
		}

		return $output;

	}

	public function render_content_html($settings) {

		$output = '';

		if(isset($settings['content']) && !empty($settings['content'])) {
			$output .= '<div class="wdt-heading-content-wrapper">';
				$output .= $settings['content'];
			$output .= '</div>';
		}

		return $output;

	}

}

if( !function_exists( 'wedesigntech_widget_base_heading' ) ) {
    function wedesigntech_widget_base_heading() {
		/* if(class_exists('WeDesignTechElementorProAddon') && class_exists('WeDesignTech_Pro_Widget_Base_Heading')) {
        	return WeDesignTech_Pro_Widget_Base_Heading::instance();
		} else { */
			return WeDesignTech_Widget_Base_Heading::instance();
		//}
    }
}