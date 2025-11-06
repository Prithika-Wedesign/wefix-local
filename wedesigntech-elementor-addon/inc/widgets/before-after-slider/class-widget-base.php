<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Before_After_Slider {

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
		return 'wdt-before-after-slider';
	}

    public function title() {
		return esc_html__( 'Before After Slider', 'wdt-elementor-addon' );
	}

    public function icon() {
		return 'wdt-widget-icon';
	}

    public function init_styles() {
		return array (
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/before-after-slider/assets/css/style.css'
		);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array (
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/before-after-slider/assets/js/script.js'
		);
	}

    public function create_elementor_controls($elementor_object) {

		$elementor_object->start_controls_section( 'wdt_section_content', array(
			'label' => esc_html__( 'Content', 'wdt-elementor-addon'),
		));
        $elementor_object->add_control('first-image',array(
            'label' => esc_html__( 'Choose First Image', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => array(
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                )         
        ) );

        $elementor_object->add_control('second-image',array(
            'label' => esc_html__( 'Choose Second Image', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => array(
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                )         
        ) );

        
        $elementor_object->add_responsive_control(
            'height',
            array (
                'label' => esc_html__( 'Height', 'wdt-elementor-addon' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => array (
                    'px' => array (
                        'min' => 1,
                        'max' => 1000,
                    ),
                    'vh' => array (
                        'min' => 1,
                        'max' => 100,
                    ),
                ),
                'size_units' => array ( 'px', 'vh', '%' ),
                'selectors' => array (
                    '{{WRAPPER}} .wdt-before-after-slider-container' => 'height: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $elementor_object->end_controls_section();
    }

    public function render_html($widget_object, $settings){

        if($widget_object->widget_type != 'elementor') {
			return;
		}

        $output = '';
            $output .=  ' <div class="wdt-before-after-slider-container"> ';
                $output .=  ' <div class="wdt-img wdt-background-img"> '; 
                if($settings['first-image']['url'] != '') {
                    $alt_text = !empty($settings['first-image']['alt']) ? esc_attr($settings['first-image']['alt']) : esc_attr__('First Image', 'wdt-elementor-addon');
                    $output .=  ' <img src="'. esc_url( $settings['first-image']['url'] ) . '" alt="' . $alt_text . '" title="First Image">';
                    $output .= '<span class="wdt-before-after-slider-span-after">'.esc_html__('Before', 'wdt-elementor-addon').'</span>';
                }
                $output .=  ' </div>';
                
                $output .=  ' <div class="wdt-img wdt-foreground-img" style="clip-path: inset(0 0 0 50%);">';
                if($settings['second-image']['url'] != '') {
                    $alt_text = !empty($settings['second-image']['alt']) ? esc_attr($settings['second-image']['alt']) : esc_attr__('Second Image', 'wdt-elementor-addon');
                    $output .=  ' <img src="'. esc_url( $settings['second-image']['url'] ) . '" alt="' . $alt_text . '" title="Second Image">';
                    $output .= '<span class="wdt-before-after-slider-span-before">'.esc_html__('After', 'wdt-elementor-addon').'</span>';
                }
                $output .=  ' </div>';

                $output .= '<input type="range" min="0" max="100" value="50" class="wdt-before-after-sliders" name="wdt_before_after_slider" id="wdt_before_after_slider_'.esc_attr($widget_object->get_id()).'" aria-label="'.esc_attr__('Slider control', 'wdt-elementor-addon').'">';

                $output .=  ' <div class="wdt-slider-button">';
                $output .= '<span>'.esc_html__('Drag', 'wdt-elementor-addon').'</span>';
                $output .=  ' </div>';
            $output .=  ' </div>';

        return $output;

    }

}

if( !function_exists( 'wedesigntech_widget_base_before_after_slider' ) ) {
    function wedesigntech_widget_base_before_after_slider() {
        return WeDesignTech_Widget_Base_Before_After_Slider::instance();
    }
}
