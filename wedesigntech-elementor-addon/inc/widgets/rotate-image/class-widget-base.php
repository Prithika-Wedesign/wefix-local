<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Rotate_Image {

	private static $_instance = null;

	private $cc_style;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	function __construct() {
		$this->cc_style = new WeDesignTech_Common_Controls_Style();
	}

	public function name() {
		return 'wdt-rotate-image';
	}

	public function title() {
		return esc_html__( 'Rotate Image', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'wdt-widget-icon';
	}

	public function init_styles() {
		return array (
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/rotate-image/assets/css/style.css'
		);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array (
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/rotate-image/assets/js/script.js'
		);
	}

	public function create_elementor_controls($elementor_object) {

		$elementor_object->start_controls_section(
			'wdt_section_content',
			array (
				'label' => esc_html__( 'Data', 'wdt-elementor-addon' ),
			)
		);

		$elementor_object->add_control(
			'rotate_image',
			array (
				'label' => esc_html__( 'Choose Image', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => array (
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
				'condition' => array (),
			)
		);

		$elementor_object->add_control(
			'rotate_second_image',
			array (
				'label' => esc_html__( 'Choose Another Image', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => array (
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
				'condition' => array (),
			)
		);

		$elementor_object->end_controls_section();

		$elementor_object->start_controls_section(
			'wdt_setting_content',
			array (
				'label' => esc_html__( 'Settings', 'wdt-elementor-addon' ),
			)
		);

		$elementor_object->add_control( 'rotation_side', array (
			'label' => esc_html__( 'Rotate', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::SELECT,
			'default' => 'anti-clock',
			'options' => array(
				'anti-clock'  => esc_html__( 'Anti-Clock Wise', 'wdt-elementor-addon' ),
				'clock'   	  => esc_html__( 'Clock Wise', 'wdt-elementor-addon' )
			)
		) );

		$elementor_object->add_responsive_control( 'image_width', array(
			'label' => esc_html__( 'Image Width', 'wdt-elementor-addon' ),
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
				'size' => 250,
			),
			'selectors' => array(
					'{{WRAPPER}} img' => 'max-width: {{SIZE}}{{UNIT}};',
			)
		) );

		$elementor_object->end_controls_section();

	}

	public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}

		$output = '';

		$animation_settings = array (
			'rotation_side' => $settings['rotation_side']
		);

		$output .= '<div class="wdt-rotate-image-container" data-settings="'.esc_js(wp_json_encode($animation_settings)).'">';
			$output .= '<div class="wdt-rotate-image">';
			if( (isset($settings['rotate_image']['url']) && !empty($settings['rotate_image']['url'])) ) {
				$image_setting = array ();
				$image_setting['image'] = $settings['rotate_image'];
				$image_setting['image_custom_dimension'] = isset($settings['rotate_image_custom_dimension']) ? $settings['rotate_image_custom_dimension'] : array ();
				$output .= \Elementor\Group_Control_Image_Size::get_attachment_image_html( $image_setting );
			}
			$output .= '</div>';

			$output .= '<div class="wdt-rotate-second-image">';
			if( (isset($settings['rotate_second_image']['url']) && !empty($settings['rotate_second_image']['url'])) ) {
				$image_setting = array ();
				$image_setting['image'] = $settings['rotate_second_image'];
				$image_setting['image_custom_dimension'] = isset($settings['rotate_second_image_custom_dimension']) ? $settings['rotate_second_image_custom_dimension'] : array ();
				$output .= \Elementor\Group_Control_Image_Size::get_attachment_image_html( $image_setting );
				
			}
			$output .= '</div>';

		$output .= '</div>';

		return $output;

	}

}

if( !function_exists( 'wedesigntech_widget_base_rotate_image' ) ) {
    function wedesigntech_widget_base_rotate_image() {
        return WeDesignTech_Widget_Base_Rotate_Image::instance();
    }
}