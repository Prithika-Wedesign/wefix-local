<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Advanced_Heading {

	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	function __construct() { }

	public function name() {
		return 'wdt-advanced-heading';
	}

	public function title() {
		return esc_html__( 'Advanced Heading', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'wdt-widget-icon';
	}

	public function init_styles() {
		return [
			$this->name() => WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'inc/widgets/advanced-heading/assets/css/style.css'
		];
	}

	public function init_inline_styles() {
		return [];
	}

	public function init_scripts() {
		return [
			$this->name() => WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'inc/widgets/advanced-heading/assets/js/script.js'
		];
	}

	public function wdt_register_elementor_localize_settings($settings) {
		$settings['wdtHeaderItems'] = [
			'title' => esc_html__( 'Title', 'wdt-elementor-addon'),
		];
		return $settings;
	}

	public function create_elementor_controls($elementor_object) {
		$elementor_object->start_controls_section( 'wdt_section_item', [
			'label' => esc_html__( 'Item', 'wdt-elementor-addon'),
		]);

		$elementor_object->add_control( 'heading_template', [
			'label'   => esc_html__( 'Template Type', 'wdt-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'default',
			'options' => [
				'default'      => esc_html__( 'Default', 'wdt-elementor-addon' ),
			],
			'separator' => 'after',
		]);

		$elementor_object->add_control( 'sub_title', [
			'label' => esc_html__( 'Sub Title', 'elementor' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'placeholder' => esc_html__( 'Your sub title goes here', 'wdt-elementor-addon' ),
			'default' => esc_html__( 'Sub Heading', 'wdt-elementor-addon' ),
		]);

		$elementor_object->add_control( 'title', [
			'label'       => esc_html__( 'Title', 'wdt-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'placeholder' => esc_html__( 'Your title goes here', 'wdt-elementor-addon' ),
			'default'     => esc_html__( 'Heading', 'wdt-elementor-addon' )
		]);

		$elementor_object->add_control( 'content', [
			'label' => esc_html__( 'Content', 'elementor' ),
			'type' => \Elementor\Controls_Manager::TEXTAREA,
			'default' => esc_html__( 'Few lines to well describe your content supporting headline.', 'wdt-elementor-addon' ),
			'condition' => [
				'heading_template!' => ['title_btn', 'title_only']
			]
		]);

		$elementor_object->add_control( 'heading_tag', [
			'label'   => esc_html__( 'Title Tag', 'wdt-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'h2',
			'options' => [
				'div'  => esc_html__( 'Div', 'wdt-elementor-addon' ),
				'h1'   => esc_html__( 'H1', 'wdt-elementor-addon' ),
				'h2'   => esc_html__( 'H2', 'wdt-elementor-addon' ),
				'h3'   => esc_html__( 'H3', 'wdt-elementor-addon' ),
				'h4'   => esc_html__( 'H4', 'wdt-elementor-addon' ),
				'h5'   => esc_html__( 'H5', 'wdt-elementor-addon' ),
				'h6'   => esc_html__( 'H6', 'wdt-elementor-addon' ),
				'span' => esc_html__( 'Span', 'wdt-elementor-addon' ),
				'p'    => esc_html__( 'P', 'wdt-elementor-addon' )
			]
		]);

		$elementor_object->add_control( 'heading_animation', [
			'label'   => esc_html__( 'Motion Effect', 'wdt-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'default',
			'options' => [
				'default'        => esc_html__( 'Default', 'wdt-elementor-addon' ),
				'skew' => esc_html__( 'Skew Fade', 'wdt-elementor-addon' ),
				'charsplit'  => esc_html__( 'Letter Animation', 'wdt-elementor-addon' )
			],
			'separator' => 'before',
		]);

		$elementor_object->add_control( 'text_align', [
			'label' => esc_html__( 'Text Alignment', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::CHOOSE,
			'options' => [
				'left' => [
					'title' => esc_html__( 'Left', 'wdt-elementor-addon' ),
					'icon' => 'eicon-text-align-left',
				],
				'center' => [
					'title' => esc_html__( 'Center', 'wdt-elementor-addon' ),
					'icon' => 'eicon-text-align-center',
				],
				'right' => [
					'title' => esc_html__( 'Right', 'wdt-elementor-addon' ),
					'icon' => 'eicon-text-align-right',
				],
			],
			'default' => 'center',
			'toggle' => true,
			'selectors' => [
				'{{WRAPPER}} .wdt-creative-heading-holder' => 'text-align: {{VALUE}};',
			],

		]);

		$elementor_object->end_controls_section();

	}

	public function render_html($widget_object, $settings) {
		if ($widget_object->widget_type != 'elementor') {
			return;
		}

		$settings['module_id'] = $widget_object->get_id();
		$output = '<div class="wdt-creative-heading-holder template-'. esc_attr($settings['heading_template']) .' animat-'. esc_attr($settings['heading_animation']) .'" data-id="'. esc_attr($settings['module_id']) .'">';

			if ($settings['heading_template'] === 'default') {
				$output = $this->render_sub_title($settings, $output);
				$output = $this->render_title($settings, $output);
				$output = $this->render_content($settings, $output);
			}

		$output .= '</div>';

		return $output;
	}

	// Title
	public function render_title($settings, $output) {
		if (!empty($settings['title'])) {
			$output .= '<'. esc_attr($settings['heading_tag']) .' class="wdt-heading-title-wrapper">'. wp_kses_post($settings['title']) .'</'. esc_attr($settings['heading_tag']) .'>';
		}
		return $output;
	}

	// Sub Title
	public function render_sub_title($settings, $output) {
		if (!empty($settings['sub_title'])) {
			$output .= '<div class="wdt-heading-sub_title">'. wp_kses_post($settings['sub_title']) .'</div>';
		}
		return $output;
	}

	// Description
	public function render_content($settings, $output) {
		if (!empty($settings['content'])) {
			$output .= '<div class="wdt-heading-content-wrapper">';
				$output .= '<p class="wdt-heading-content">'. esc_html($settings['content']) .'</p>';
			$output .= '</div>';
		}
		return $output;
	}

}

if ( ! function_exists( 'wedesigntech_widget_base_advanced_heading' ) ) {
	function wedesigntech_widget_base_advanced_heading() {
		return WeDesignTech_Widget_Base_Advanced_Heading::instance();
	}
}
