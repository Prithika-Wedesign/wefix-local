<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Animation {

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
		return 'wdt-animation';
	}

	public function title() {
		return esc_html__( 'Animation', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'wdt-widget-icon';
	}

	public function init_styles() {
		return array (
				$this->name() => WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/animation/assets/css/style.css'
			);
	}

	public function init_inline_styles() {
		return array ();
	}

    public function init_scripts() {
		return array (
			$this->name() => WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/animation/assets/js/script.js'
		);
	}

	public function create_elementor_controls($elementor_object) {

		$elementor_object->start_controls_section( 'wdt_section_content', array(
			'label' => esc_html__( 'Content', 'wdt-elementor-addon'),
		) );

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'content_type', array(
			'label'   => esc_html__( 'Content Type', 'wdt-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'image',
			'options' => array(
				'image' => esc_html__( 'Image', 'wdt-elementor-addon' ),
				'text' => esc_html__( 'Text', 'wdt-elementor-addon' ),
				'icon' => esc_html__( 'Icon', 'wdt-elementor-addon' )
			)
		) );

		$repeater->add_control( 'image', array (
			'label' => esc_html__( 'Image', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::MEDIA,
			'default' => array (
				'url' => \Elementor\Utils::get_placeholder_image_src(),
			),
			'condition'   => array (
				'content_type' =>'image'
			)
		) );

		$repeater->add_control( 'icon', array (
			'label' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::ICONS,
			'default' => array(
				'value' => 'far fa-paper-plane',
				'library' => 'fa-solid',
			),
			'condition'   => array (
				'content_type' =>'icon'
			)
		) );

		$repeater->add_control( 'text', array(
			'label'       => esc_html__( 'Text', 'wdt-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'placeholder' => esc_html__( 'Title goes here', 'wdt-elementor-addon' ),
			'condition'   => array (
				'content_type' =>'text'
			)
		) );

		$repeater->add_control( 'link',array(
			'label'       => esc_html__( 'Link', 'wdt-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => esc_html__( 'https://your-link.com', 'wdt-elementor-addon' ),
			'default'     => array( 'url' => '#' ),
			'condition'   => array (
				'content_type' =>'text'
			)
		) );

		$elementor_object->add_control( 'contents', array(
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'label'       => esc_html__('Contents', 'wdt-elementor-addon'),
			'description' => esc_html__('Contents', 'wdt-elementor-addon' ),
			'fields'      => $repeater->get_controls(),
			'default' => array (
				array (
					'content_type' => 'text',
					'text' => 'Ut accumsan mass'
				),
				array (
					'content_type' => 'text',
					'text' => 'Pellentesque ornare'
				),
				array (
					'content_type' => 'text',
					'text' => 'Progressively plagiarize'
				)
			)
		) );

		$elementor_object->end_controls_section();

		$elementor_object->start_controls_section( 'wdt_section_settings', array(
			'label' => esc_html__( 'Settings', 'wdt-elementor-addon'),
		) );

		$elementor_object->add_control( 'wdt_mqa_direction', array(
			'label'   => esc_html__( 'Direction', 'wdt-elementor-addon' ),
			'type'    => Elementor\Controls_Manager::SELECT,
			'default' => 'left-to-right',
			'options' => array(
				'left-to-right' => esc_html__( 'Left to Right', 'wdt-elementor-addon' ),
				'right-to-left' => esc_html__( 'Right to Left', 'wdt-elementor-addon' )
			),
			'frontend_available' => true
		) );

		$elementor_object->end_controls_section();

		// items

		$elementor_object->start_controls_section( 'wdt_item_style_section', array (
			'label' => esc_html__( 'Item', 'wdt-elementor-addon' ),
			'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		) );
		
		$elementor_object->add_responsive_control( 'item_margin', array (
			'label' => esc_html__( 'Margin', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array ( 'px', 'em', '%' ),
			'selectors' => array (
				'{{WRAPPER}} .wdt-animation-wrapper .wdt-animation-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		) );

		$elementor_object->add_responsive_control( 'item_padding', array (
			'label' => esc_html__( 'Padding', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array ( 'px', 'em', '%' ),
			'selectors' => array (
				'{{WRAPPER}} .wdt-animation-wrapper .wdt-animation-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		) );

		$elementor_object->add_control( 'item_speed', array(
			'label' => esc_html__( 'Speed', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'size_units' => array ( 'dpt' ),
			'default' => array (
				'unit' => 'dpt',
				'size' => 20,
			),
			'range' => array (
				'dpt' => array (
					'min' => 0.5,
					'max' => 40,
					'step' => 0.5
				)
			),
			'selectors' => array (
				'{{WRAPPER}} .wdt-animation-wrapper div[class*="-marqee"].left-to-right, 
				 {{WRAPPER}} .wdt-animation-wrapper div[class*="-marqee"].left-to-right ~ div.wdt-animation-cloned-marqee,
				 {{WRAPPER}} .wdt-animation-wrapper div[class*="-marqee"].right-to-left, 
				 {{WRAPPER}} .wdt-animation-wrapper div[class*="-marqee"].right-to-left ~ div.wdt-animation-cloned-marqee' => 'animation-duration: {{SIZE}}s;',
			),
		) );

		$elementor_object->end_controls_section();

		// Icon
		
        $elementor_object->start_controls_section( 'wdt_icon_style_section', array (
			'label' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
			'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		) );

		$elementor_object->add_responsive_control( 'icon-font-size', array(
			'label' => esc_html__( 'Icon Size', 'wdt-elementor-addon' ),
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
			'selectors' => array(
				'{{WRAPPER}} .icon-item' => 'font-size: {{SIZE}}{{UNIT}};',
			),
		) );

		$elementor_object->add_responsive_control( 'item_icon_margin', array (
			'label' => esc_html__( 'Margin', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array ( 'px', 'em', '%' ),
			'selectors' => array (
				'{{WRAPPER}} .icon-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		) );

		$elementor_object->add_responsive_control( 'item_icon_padding', array (
			'label' => esc_html__( 'Padding', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array ( 'px', 'em', '%' ),
			'selectors' => array (
				'{{WRAPPER}} .icon-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		) );	

		$elementor_object->add_control( 'icon_color', array(
			'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .icon-item' => 'color: {{VALUE}}',
			),
		) );

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name' => 'icon_normal_background',
				'types' =>  array('classic', 'gradient', 'video' ),
				'selector' => '{{WRAPPER}} .icon-item',
			)
		);

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name' => 'icon_normal_border',
				'selector' => '{{WRAPPER}} .icon-item',
			)	
		);

		$elementor_object->add_responsive_control( 'item-icon-border-radius', array (
			'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array ( 'px', 'em', '%' ),
			'selectors' => array (
				'{{WRAPPER}} .icon-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		) );

		$elementor_object->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'item-icon_normal_box_shadow',
				'selector' => '{{WRAPPER}} .icon-item',
			)	
		);

		$elementor_object->end_controls_tabs();
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
                'selector' => '{{WRAPPER}} .text-item',
		) );

        $elementor_object->add_responsive_control( 'item_title_margin', array (
			'label' => esc_html__( 'Margin', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array ( 'px', 'em', '%' ),
			'selectors' => array (
				'{{WRAPPER}} .text-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		) );

        
        $elementor_object->start_controls_tabs( 'title_style_tabs' );

        $elementor_object->start_controls_tab( 'title_normal_tab', array(
			'label' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
		) );

        $elementor_object->add_control( 'title_color', array(
			'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .text-item, {{WRAPPER}} .text-item a' => 'color: {{VALUE}}',
			),
		) );

        $elementor_object->end_controls_tab();

        $elementor_object->start_controls_tab( 'title_hover_tab', array(
			'label' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
		) );

        $elementor_object->add_control( 'title_hover_color', array(
			'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .text-item a:hover' => 'color: {{VALUE}}',
			), 
		) );

        $elementor_object->end_controls_tab();
        $elementor_object->end_controls_tabs();
        $elementor_object->end_controls_section();

        //  Image

        $elementor_object->start_controls_section( 'wdt_image_style_section', array (
			'label' => esc_html__( 'Image', 'wdt-elementor-addon' ),
			'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		) );

		$elementor_object->add_responsive_control(
			'wdt_image_width_section',
			array(
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
					'{{WRAPPER}} .image-item img' => 'width: {{SIZE}}{{UNIT}};',
			),
		) );

		$elementor_object->add_responsive_control(
			'wdt_image_height_section',
			array(
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
					'{{WRAPPER}} .image-item img' => 'height: {{SIZE}}{{UNIT}};',
			),
		) );

		$elementor_object->add_responsive_control( 'item-image-border-radius', array (
			'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array ( 'px', 'em', '%' ),
			'selectors' => array (
				'{{WRAPPER}} .image-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		) );
            
        $elementor_object->end_controls_section();
	}

	public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}

		$output = '';

		if( count( $settings['contents'] ) > 0 ):

			$classes = array ();

            $animation_settings = array (
                'direction' => $settings['wdt_mqa_direction']
            );

			$output .= '<div class="wdt-animation-holder '.esc_attr(implode(' ', $classes)).'" id="wdt-animation-'.esc_attr($widget_object->get_id()).'" data-settings="'.esc_js(wp_json_encode($animation_settings)).'">';
                $output .= '<div class="wdt-animation-wrapper">';

					$output .= '<div class="wdt-animation-main-marqee '.esc_attr($settings['wdt_mqa_direction']).'">';
						foreach( $settings['contents'] as $key => $item ) {
							if( $item['content_type'] == 'image' ) {
								if(isset($item['image']['url']) && !empty($item['image']['url'])) {
									$output .= '<div class="wdt-animation-item image-item">';

										$image_setting = array ();
										$image_setting['image'] = $item['image'];
										$image_setting['image_size'] = 'full';
										$image_setting['image_custom_dimension'] = isset($item['image_custom_dimension']) ? $item['image_custom_dimension'] : array ();
	
										$output .= \Elementor\Group_Control_Image_Size::get_attachment_image_html( $image_setting );

									$output .= '</div>';
								}
							} 
							else if( $item['content_type'] == 'text' ) {
								if( !empty( $item['link']['url'] ) && $item['text'] != '' ){
									$target = ( $item['link']['is_external'] == 'on' ) ? ' target="_blank" ' : '';
									$nofollow = ( $item['link']['nofollow'] == 'on' ) ? 'rel="nofollow" ' : '';
									$output .= '<div class="wdt-animation-item text-item">';
										$output .= '<a href="'.esc_url( $item['link']['url'] ).'"'. $target . $nofollow.'>';
											$output .= $item['text'];
										$output .= '</a>';
									$output .= '</div>';
								} elseif($item['text'] != '') {
									$output .= '<div class="wdt-animation-item text-item">';
										$output .= $item['text'];
									$output .= '</div>';
								}
							}
							else
							{
								$output .= '<div class="wdt-animation-item icon-item">';
									ob_start();
									\Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] );
									$output .= ob_get_clean();
								$output.='</div>';
							}
						}
					$output .= '</div>';

					$output .= '<div class="wdt-animation-cloned-marqee">';
						foreach( $settings['contents'] as $key => $item ) {
							if( $item['content_type'] == 'image' ) {
								if(isset($item['image']['url']) && !empty($item['image']['url'])) {
									$output .= '<div class="wdt-animation-item image-item">';

										$image_setting = array ();
										$image_setting['image'] = $item['image'];
										$image_setting['image_size'] = 'full';
										$image_setting['image_custom_dimension'] = isset($item['image_custom_dimension']) ? $item['image_custom_dimension'] : array ();
	
										$output .= \Elementor\Group_Control_Image_Size::get_attachment_image_html( $image_setting );

									$output .= '</div>';
								}
							} 
							else if( $item['content_type'] == 'text' ) {
								if( !empty( $item['link']['url'] ) && $item['text'] != '' ){
									$target = ( $item['link']['is_external'] == 'on' ) ? ' target="_blank" ' : '';
									$nofollow = ( $item['link']['nofollow'] == 'on' ) ? 'rel="nofollow" ' : '';
									$output .= '<div class="wdt-animation-item text-item">';
										$output .= '<a href="'.esc_url( $item['link']['url'] ).'"'. $target . $nofollow.'>';
											$output .= $item['text'];
										$output .= '</a>';
									$output .= '</div>';
								} elseif($item['text'] != '') {
									$output .= '<div class="wdt-animation-item text-item">';	
										$output .= $item['text'];
									$output .= '</div>';
								}
							}
							else
							{
								$output .= '<div class="wdt-animation-item icon-item">';
									ob_start();
									\Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] );
									$output .= ob_get_clean();
								$output.='</div>';
							}
						}
					$output .= '</div>';

                $output .= '</div>';
			$output .= '</div>';

		else:
			$output .= '<div class="wdt-animation-container no-records">';
				$output .= esc_html__('No records found!', 'wdt-elementor-addon');
			$output .= '</div>';
		endif;

		return $output;

	}

}

if( !function_exists( 'wedesigntech_widget_base_animation' ) ) {
    function wedesigntech_widget_base_animation() {
        return WeDesignTech_Widget_Base_Animation::instance();
    }
}