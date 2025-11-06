<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Flex_Banner {

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
		return 'wdt-flex-banner';
	}

	public function title() {
		return esc_html__( 'Flex Banner', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'wdt-widget-icon';
	}

    public function init_styles() {
		return array (
				$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/flex-banner/assets/css/style.css'
			);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array (
			$this->name() => WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/flex-banner/assets/js/script.js'
		);
	}

    public function create_elementor_controls($elementor_object) {

        $elementor_object->start_controls_section( 'wdt_section_features', array(
        'label' => esc_html__( 'Content', 'wdt-elementor-addon'),
        ) );

            $repeater = new \Elementor\Repeater();

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
                    'default' => 'Sample Sub Title'
                )
            );

            $repeater->add_control(
                'list_content',
                array(
                    'type' => \Elementor\Controls_Manager::WYSIWYG,
                    'label' => esc_html__( 'Description', 'wdt-elementor-addon' ),
                    'default' => 'Sample Description'
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
                    'default' => array( 'value' => 'fas fa-check', 'library' => 'fa-solid' )
                )
            );

            $repeater->add_control(
                'button',
                array(
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'label' => esc_html__( 'Button text', 'wdt-elementor-addon' ),
                    'default' => 'Click Here'
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
    
            $elementor_object->add_control( 'animation_slider', array(
                'label'        => esc_html__( 'Show slider on hover', 'wdt-elementor-addon' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'No',
            ) );

            $elementor_object->add_responsive_control(
                'flex-height',
                array(
                    'label' => esc_html__( 'Banner Height', 'wdt-elementor-addon' ),
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
                        'size' => 600,
                    ),
                    'selectors' => array(
                        '{{WRAPPER}} .wdt-flex-banner-option' => 'height: {{SIZE}}{{UNIT}};',
                    ),
                )
            );
    
        $elementor_object->end_controls_section();

    }

    public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}

		$output = '';
        $animation_settings = array (
            'option' => $settings['animation_slider'],
        );

        $output .= ' <div class="wdt-flex-banner-options" id="wdt-animation-'.esc_attr($widget_object->get_id()).'" data-settings="'.esc_js(wp_json_encode($animation_settings)).'"  >';
   
            foreach ( $settings['features_content'] as $index => $item ) :
                    $img_output = '';
                    $class = ($index == 0) ? 'active' : '';
                    $img_output .= esc_url( $item['image']['url'] );
                    $output .= '  <div class="wdt-flex-banner-option ' . $class .'" style="background-image:url(' . $img_output . ');">';
                            $output .= ' <div class="wdt-flex-banner-label">';
                                $output .= '  <div class="wdt-flex-banner-info">';
                                    if(!empty($item['list_icon']['value'])) {
                                        $output .= ' <div class="wdt-flex-banner-icon">';
                                            ob_start();
                                            \Elementor\Icons_Manager::render_icon( $item['list_icon'], [ 'aria-hidden' => 'true' ] );
                                            $contents = ob_get_contents();
                                            ob_end_clean();
                                            $output .= $contents;
                                        $output .= ' </div>';
                                    }
                                    if(isset($item['list_sub_title']) && !empty($item['list_sub_title'])) {
                                    $output .= '<div class="wdt-flex-banner-sub-title">' . $item['list_sub_title'] . '</div>';
                                    }

                                    if(isset($item['list_title']) && !empty($item['list_title'])) {
                                        $output .= '<div class="wdt-flex-banner-title">' . $item['list_title'] . '</div>';
                                    }

                                    if(isset($item['list_content']) && !empty($item['list_content'])) {
                                    $output .= '<div class="wdt-flex-banner-content">' . $item['list_content'] . '</div>';
                                    }
            
                                    $link_start = $link_end = '';
                                    if( !empty( $item['button_link']['url'] ) && $item['button'] !== '' ){
                                        $target = ( $item['button_link']['is_external'] == 'on' ) ? ' target="_blank" ' : '';
                                        $nofollow = ( $item['button_link']['nofollow'] == 'on' ) ? 'rel="nofollow" ' : '';
                                        $link_start = '<a href="'.esc_url( $item['button_link']['url'] ).'"'. $target . $nofollow.'>';
                                        $link_end = '</a>';
                                        $output .= '<div class="wdt-flex-banner-button">' . $link_start . $item['button'] . $link_end . '</div>' ;
                                    }
                                $output .= '   </div>';

                            if(isset($item['list_title']) && !empty($item['list_title'])) {
                                $output .= '<div class="wdt-flex-banner-title">' . $item['list_title'] . '</div>';
                            }
                        $output .= '  </div>';
                    $output .= '  </div>';
            endforeach;

        $output .= '</div>';

        return $output;

	}

}

if( !function_exists( 'wedesigntech_widget_base_flex_banner' ) ) {
    function wedesigntech_widget_base_flex_banner() {
        return WeDesignTech_Widget_Base_Flex_Banner::instance();
    }
}