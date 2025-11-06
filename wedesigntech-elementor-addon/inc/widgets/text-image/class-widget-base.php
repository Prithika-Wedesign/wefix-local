<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Text_With_Image {

    private static $_instance = null;

	private $cc_style;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	function __construct() {
	}

    public function name() {
		return 'wdt-text-image';
	}

    public function title() {
		return esc_html__( 'Text with Image', 'wdt-elementor-addon' );
	}

    public function icon() {
		return 'wdt-widget-icon';
	}

    public function init_styles() {
		return array (
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/text-image/assets/css/style.css'
		);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array ();
	}

    public function create_elementor_controls($elementor_object) {

        $elementor_object->start_controls_section( 'wdt_section_features', array(
            'label' => esc_html__( 'Content', 'wdt-elementor-addon'),
		));
			$repeater = new \Elementor\Repeater();
			$repeater->add_control( 
				'content_type', 
				array(
				'type'    => \Elementor\Controls_Manager::SELECT2,
				'label'   => esc_html__( 'Content Type', 'wdt-elementor-addon' ),
				'default' => 'default',
				'options' => array(
					'default'  => esc_html__( 'Text', 'wdt-elementor-addon' ),
					'image' => esc_html__( 'Image', 'wdt-elementor-addon' ),
					'icon' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
				)
			));

			$repeater->add_control(
				'content_template', 
				array(
				'label'     => esc_html__( 'Image ', 'wdt-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'condition' => array (
					'content_type' => 'image'
				),
				'default' => array(
								'url' => \Elementor\Utils::get_placeholder_image_src(),
							),
			));

			$repeater->add_responsive_control( 'image_width', array(
				'label' => esc_html__( 'Width', 'wdt-elementor-addon' ),
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
					'size' => 50,
				),
				'selectors' => array(
						'{{WRAPPER}} {{CURRENT_ITEM}} img' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition' => array (
					'content_type' => 'image'
				),
			) );

			$repeater->add_responsive_control( 'image_height', array(
				'label' => esc_html__( 'Height', 'wdt-elementor-addon' ),
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
					'size' => 50,
				),
				'selectors' => array(
						'{{WRAPPER}} {{CURRENT_ITEM}} img' => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition' => array (
					'content_type' => 'image'
				),
			) );

			$repeater->add_responsive_control( 'image_radius', array(
				'label' => esc_html__( 'Radius', 'wdt-elementor-addon' ),
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
					'size' => 50,
				),
				'selectors' => array(
						'{{WRAPPER}} {{CURRENT_ITEM}} img' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
				'condition' => array (
					'content_type' => 'image'
				),
			) );

			$repeater->add_control( 'list_title', array(
				'type'    => \Elementor\Controls_Manager::TEXT,
				'label' => esc_html__( 'Title', 'wdt-elementor-addon' ),
				'default' => 'Sample Title',
				'condition' => array (
					'content_type' => 'default'
				),
			) );

			$repeater->add_control( 'list_color', array(
				'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition' => array (
					'content_type' => 'default'
				),
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}'
				),
			) );

			$repeater->add_control( 'text_format', array(
				'type'           => \Elementor\Controls_Manager::SELECT,
				'label'          => esc_html__( 'Style', 'wdt-elementor-addon' ),
				'default'        => 'underline',
				'options'        => array(
					'default' => esc_html__( 'Default', 'wdt-elementor-addon' ),
					'underline' => esc_html__( 'Underline', 'wdt-elementor-addon' ),
					'line-through' => esc_html__( 'Line Through', 'wdt-elementor-addon' ),
					'overline' => esc_html__( 'Overline', 'wdt-elementor-addon' )
				),
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'text-decoration: {{VALUE}};',
				),
				'condition' => array (
					'content_type' => 'default'
				),
			) );

			$repeater->add_responsive_control( 'text_size', array(
				'label' => esc_html__( 'Size', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array('px', '%', 'em', 'rem', 'custom'),
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default' => array(
					'unit' => 'px',
					'size' => 32,
				),
				'selectors' => array(
						'{{WRAPPER}} {{CURRENT_ITEM}}' => 'font-size: {{SIZE}}{{UNIT}};',
				),
				'condition' => array (
					'content_type' => 'default'
				),
			) );

			$repeater->add_control( 'icon', array(
				'type'    => \Elementor\Controls_Manager::ICONS,
				'label' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
				'default' => array(
					'value' => 'far fa-paper-plane',
					'library' => 'fa-solid',
				),
				'condition' => array (
					'content_type' => 'icon'
				),
			) );

			$repeater->add_responsive_control( 'icon_size', array(
				'label' => esc_html__( 'Size', 'wdt-elementor-addon' ),
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
					'size' => 25,
				),
				'selectors' => array(
						'{{WRAPPER}} {{CURRENT_ITEM}}.wdt-opt-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				),
				'condition' => array (
					'content_type' => 'icon'
				),
			) );

			$repeater->add_responsive_control( 'icon_width', array(
				'label' => esc_html__( 'Width', 'wdt-elementor-addon' ),
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
					'size' => 50,
				),
				'selectors' => array(
						'{{WRAPPER}} {{CURRENT_ITEM}}.wdt-opt-icon' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition' => array (
					'content_type' => 'icon'
				),
			) );

			$repeater->add_responsive_control( 'icon_height', array(
				'label' => esc_html__( 'Height', 'wdt-elementor-addon' ),
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
					'size' => 50,
				),
				'selectors' => array(
						'{{WRAPPER}} {{CURRENT_ITEM}}.wdt-opt-icon' => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition' => array (
					'content_type' => 'icon'
				),
			) );

			$repeater->add_control( 'icon_color', array(
				'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition' => array (
					'content_type' => 'icon'
				),
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}.wdt-opt-icon' => 'color: {{VALUE}}'
				),
			) );

			$repeater->add_control( 'icon_background', array(
				'label' => esc_html__( 'Background', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition' => array (
					'content_type' => 'icon'
				),
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}.wdt-opt-icon' => 'background-color: {{VALUE}}'
				),
			) );

			$repeater->add_responsive_control( 'icon_radius', array(
				'label' => esc_html__( 'Radius', 'wdt-elementor-addon' ),
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
					'size' => 50,
				),
				'selectors' => array(
						'{{WRAPPER}} {{CURRENT_ITEM}}.wdt-opt-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
				'condition' => array (
					'content_type' => 'icon'
				),
			) );

			$elementor_object->add_control( 'features_content', array(
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'label'       => esc_html__('Content Items', 'wdt-elementor-addon'),
				'description' => esc_html__('Content Items', 'wdt-elementor-addon' ),
				'fields'      => $repeater->get_controls(),
				'default' => array (
					array (
						'list_title'     => esc_html__('Sed ut perspiciatis', 'wdt-elementor-addon' ),
					),
					array (
						'list_title'     => esc_html__('Lorem ipsum dolor', 'wdt-elementor-addon' ),
					),
				),
				'title_field' => '{{{list_title}}}'
			) );

            $elementor_object->end_controls_section();

			$elementor_object->start_controls_section( 'wdt_item_style_section', array (
				'label' => esc_html__( 'Item', 'wdt-elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			) );
	
			$elementor_object->add_control( 'text_align', array(
				'label' => esc_html__( 'Alignment', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => array(
					'left' => array(
						'title' => esc_html__( 'Left', 'wdt-elementor-addon' ),
						'icon' => 'eicon-text-align-left',
					),
	
					'center' => array(
						'title' => esc_html__( 'Center', 'wdt-elementor-addon' ),
						'icon' => 'eicon-text-align-center',
					),
											
					'right' => array(
						'title' => esc_html__( 'Right', 'wdt-elementor-addon' ),
						'icon' => 'eicon-text-align-right',
					),
						
				),
				'default' => 'center',
				'toggle' => true,
				'selectors' => array(
					'{{WRAPPER}} .wdt-elementor-repeater-container-wrapper' => 'text-align: {{VALUE}};',
				),
			) );
	
			$elementor_object->add_responsive_control( 'item_margin', array (
				'label' => esc_html__( 'Margin', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array ( 'px', 'em', '%' ),
				'selectors' => array (
					'{{WRAPPER}} .wdt-elementor-repeater-container-wrapper > div' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			) );	
	
			$elementor_object->end_controls_section();

			//Title

			$elementor_object->start_controls_section( 'wdt_title_style_section', array (
				'label' => esc_html__( 'Title', 'wdt-elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			) );
	
			$elementor_object->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				array(
					'name' => 'title_typography',
					'selector' => '{{WRAPPER}} .wdt-text-tile',
				)
			);
	
			$elementor_object->add_responsive_control( 'item_title_margin', array (
				'label' => esc_html__( 'Margin', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array ( 'px', 'em', '%' ),
				'selectors' => array (
					'{{WRAPPER}} .wdt-text-tile' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			) );

			$elementor_object->add_control( 'title_color', array(
				'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wdt-text-tile' => 'color: {{VALUE}}',
				),
			) );
			
			$elementor_object->end_controls_section();


		}

    public function render_html($widget_object, $settings){

        if($widget_object->widget_type != 'elementor') {
			return;
		}
		$output  = '';
		if ( $settings['features_content'] ) 
		{
			$output.= '<div class="wdt-elementor-repeater-container">';
				$output.= '<div class="wdt-elementor-repeater-container-wrapper">';
					foreach (  $settings['features_content'] as $item ) {

						if($item['content_type']=="image")
							$output.= '<div class="wdt-opt-image elementor-repeater-item-'.esc_attr( $item['_id'] ).'"><img src='.esc_url( $item['content_template']['url'] ).' alt="image-'.esc_attr( $item['_id'] ).'" title="image-'.esc_attr( $item['_id'] ).'"></div>';
						else if($item['content_type']=="default")
							$output.= '<div class="wdt-text-tile elementor-repeater-item-'.esc_attr( $item['_id'] ).'">' . $item['list_title'] . '</div>';
						else {
							$output.='<div class="wdt-opt-icon elementor-repeater-item-'.esc_attr( $item['_id'] ).'">';
								ob_start();
								\Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] );
								$output .= ob_get_clean();
							$output.='</div>';
						}

					}
				$output .= '</div>';
			$output.= '</div>';
			return $output;
		}
    }

}

if( !function_exists( 'wedesigntech_widget_base_text_with_image' ) ) {
    function wedesigntech_widget_base_text_with_image() {
        return WeDesignTech_Widget_Base_Text_With_Image::instance();
    }
}
