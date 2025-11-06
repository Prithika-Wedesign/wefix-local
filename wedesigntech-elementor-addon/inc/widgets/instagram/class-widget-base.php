<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Instagram {

	private static $_instance = null;

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
			$this->cc_layout = new WeDesignTech_Common_Controls_Layout('both');
			$this->cc_style = new WeDesignTech_Common_Controls_Style();

	}

	public function name() {
		return 'wdt-instagram';
	}

	public function title() {
		return esc_html__( 'Instagram', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'wdt-widget-icon';
	}

	public function init_styles() {
		return array_merge(
			$this->cc_layout->init_styles(),
			array (
				$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/instagram/assets/css/style.css'
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
			array ()
		);
	}

	public function create_elementor_controls($elementor_object) {

		$elementor_object->start_controls_section( 'wdt_section_settings', array(
			'label' => esc_html__( 'Instagram Settings', 'wdt-elementor-addon'),
		) );

			$elementor_object->add_control(
				'settings_description',
				array(
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw'  => esc_html__( 'Choose "Configure Settings" if you like to provide instagram application settings individually, else  elementor global settings will be used if set.', 'wdt-elementor-addon' ),
					'content_classes' => 'elementor-descriptor'
				)
			);

			$elementor_object->add_control( 'configure_settings', array(
				'label' => esc_html__( 'Configure Settings', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return' => 'yes',
				'default' => 'no',
				'frontend_available' => true
			) );

			$elementor_object->add_control( 'app_id', array(
				'label'       => esc_html__( 'App ID', 'wdt-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your App Id', 'wdt-elementor-addon' ),
				'condition' => array (
					'configure_settings' => 'yes'
				)
			) );

			$elementor_object->add_control( 'app_secret', array(
				'label'       => esc_html__( 'App Secret', 'wdt-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your App Secret', 'wdt-elementor-addon' ),
				'condition' => array (
					'configure_settings' => 'yes'
				)
			) );

			$elementor_object->add_control( 'access_token', array(
				'label'       => esc_html__( 'Access Token', 'wdt-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your App Token', 'wdt-elementor-addon' ),
				'condition' => array (
					'configure_settings' => 'yes'
				)
			) );


			$elementor_object->add_control( 'limit', array(
				'label'   => esc_html__('Limit', 'wdt-elementor-addon'),
				'type'    => \Elementor\Controls_Manager::SLIDER,
				'range'   => array(
					'px' => array( 'min' => 1, 'max' => 10, 'step' => 1 )
				),
				'separator' => 'before',
				'default' => array(
					'size' => 12
				)
        	) );

			$elementor_object->add_control( 'show_link', array(
				'label' => esc_html__( 'Show Link', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return' => 'yes',
				'default' => '',
				'frontend_available' => true
			) );

		$elementor_object->end_controls_section();

		$this->cc_layout->get_controls($elementor_object);

		// General
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'general',
			'title' => esc_html__( 'General', 'wdt-elementor-addon' ),
			'styles' => array (
				'tabs_image' => array (
					'field_type' => 'tabs',
					'unique_key' => 'image',
					'tab_items' => array (
						'normal' => array (
							'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
							'styles' => array (
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-instagram-item:before',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-instagram-item, {{WRAPPER}} .wdt-instagram-item .wdt-instagram-media, {{WRAPPER}} .wdt-instagram-item .wdt-instagram-media img, {{WRAPPER}} .wdt-instagram-item:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-instagram-item .wdt-instagram-media img',
									'condition' => array ()
								)
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'label' => esc_html__( 'Overlay Color', 'wdt-elementor-addon' ),
									'selector' => array (
										'{{WRAPPER}} .wdt-instagram-item:hover .wdt-instagram-media-overlay' => 'background-color: {{VALUE}};'
									),
									'condition' => array (),
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-instagram-item:hover:after',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-instagram-item:hover, {{WRAPPER}} .wdt-instagram-item:hover .wdt-instagram-media, {{WRAPPER}} .wdt-instagram-item:hover .wdt-instagram-media img, {{WRAPPER}} .wdt-instagram-item:hover:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-instagram-item:hover .wdt-instagram-media',
									'condition' => array ()
								),
								'heading_icon' => array (
									'field_type' => 'heading',
									'unique_key' => 'icon',
									'title' => esc_html__( 'Icon Part', 'wdt-elementor-addon' ),
									'separator' => 'before',
									'condition' => array ()
								),
								'select_effects' => array (
									'field_type' => 'select',
									'unique_key' => 'effects',
									'label' => esc_html__( 'Effects', 'wdt-elementor-addon' ),
									'default' => '',
									'options' =>  array (
										'' => esc_html__( 'None', 'wdt-elementor-addon' ),
										'black-white' => esc_html__( 'Black & White', 'wdt-elementor-addon' ),
										'scale-in' => esc_html__( 'Scale-in', 'wdt-elementor-addon' ),
										'scale-out-rotate' => esc_html__( 'Scale-out Rotate', 'wdt-elementor-addon' )
									),
									'condition' => array ()
								),
								'select_icon_style' => array (
									'field_type' => 'select',
									'unique_key' => 'icon_style',
									'label' => esc_html__( 'Icon Style', 'wdt-elementor-addon' ),
									'default' => '',
									'options' =>  array (
										'' => esc_html__( 'None', 'wdt-elementor-addon' ),
										'plus' => esc_html__( 'Plus', 'wdt-elementor-addon' ),
										'instagram' => esc_html__( 'Instagram', 'wdt-elementor-addon' )
									),
									'condition' => array ()
								),
								'color_icon' => array (
									'field_type' => 'color',
									'unique_key' => 'icon',
									'label' => esc_html__( 'Icon Color', 'wdt-elementor-addon' ),
									'selector' => array (
										'{{WRAPPER}} .wdt-instagram-item .wdt-instagram-media-icon i, {{WRAPPER}} .wdt-instagram-item:hover .wdt-instagram-media-icon i' => 'color: {{VALUE}};'
									),
									'condition' => array (),
								),
								'font_size' => array (
									'field_type' => 'font_size',
									'unique_key' => 'icon',
									'default' => array (
										'size' => 24,
										'unit' => 'px'
									),
									'selector' => array (
										'{{WRAPPER}} .wdt-instagram-item .wdt-instagram-media-icon' => 'font-size: {{SIZE}}{{UNIT}};'
									),
									'condition' => array ()
								),
							)
						)
					)
				)
			)
		));

	}

	public function get_instagram_data( $instagram_app_token ) {

		$data = '';
		$url  = 'https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&&access_token='. $instagram_app_token;

		$response = wp_remote_get( $url, array(
			'timeout'    => 100,
			'user-agent' => $_SERVER['HTTP_USER_AGENT'],
        ) );

        if( !is_wp_error( $response ) ) {
        	$status  = wp_remote_retrieve_response_code( $response );
        	if( $status === 200 ) {
        		$body                = json_decode( wp_remote_retrieve_body( $response ) );
        		$instagram_app_token = $body->access_token;
        		$url                 = 'https://graph.instagram.com/me?fields=id&access_token='. $instagram_app_token;

        		$response = wp_remote_get( $url, array(
        			'timeout'    => 100,
        			'user-agent' => $_SERVER['HTTP_USER_AGENT'],
				) );

				if( !is_wp_error( $response ) ) {
					$status = wp_remote_retrieve_response_code( $response );
					if( $status === 200 ) {
						$body                 = json_decode( wp_remote_retrieve_body( $response ) );
						$instagram_account_id = $body->id;

						$url      = 'https://graph.instagram.com/'.$instagram_account_id.'/media?fields=id,media_type,media_url,username,timestamp&access_token='.$instagram_app_token.'&limit=100';
						$response = wp_remote_get( $url, array(
							'timeout'    => 100,
							'user-agent' => $_SERVER['HTTP_USER_AGENT'],
						) );

						$status  = wp_remote_retrieve_response_code( $response );
						if( $status === 200 ) {
							$data = json_decode( wp_remote_retrieve_body( $response ) );
							return $data->data;
						}
					}
				}
        	}
        }

    	return $data;

    }

	public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}

		$output = '';

		$classes = array ();

		$app_id     = get_option( 'elementor_wdt_instagram_app_id' );
		$app_secret = get_option( 'elementor_wdt_instagram_app_secret' );
		$app_token  = get_option( 'elementor_wdt_instagram_app_access_token' );

		if($settings['configure_settings'] == 'yes') {
			$app_id     = $settings['app_id'];
			$app_secret = $settings['app_secret'];
			$app_token  = $settings['access_token'];
		}

		if(!empty($app_token)) {

			if(isset($settings['general_image_hover_effects']) && $settings['general_image_hover_effects'] != '') {
				array_push($classes, 'wdt-effects-'.$settings['general_image_hover_effects']);
			}

			$settings['module_id'] = $widget_object->get_id();
			$settings['module_class'] = 'instagram';
			$settings['classes'] = $classes;
			$this->cc_layout->set_settings($settings);
			$module_layout_class = $this->cc_layout->get_item_class();

			$output .= $this->cc_layout->get_wrapper_start();

				$data  = $this->get_instagram_data( $app_token );
				$count = $settings['limit']['size'];
				$limit = 1;
				if(is_array($data) && !empty($data)) {
					foreach( $data as $item ) {

						$output.= '<div class="'.esc_attr($module_layout_class).'">';
							$output .= '<div class="wdt-instagram-item">';
								$output .= '<div class="wdt-instagram-media">';
									if($settings['show_link'] == 'yes') {
										$output .= '<a href="'.esc_url('instagram.com/'.$item->username).'">';
									}
										if($item->media_type == 'IMAGE') {
											$output .= '<img src="'.esc_url( $item->media_url ).'" alt="'.esc_attr__('Image By ','wdt-elementor-addon'). $item->username.'" title="'.esc_attr__('Image By ','wdt-elementor-addon'). $item->username.'"/>';
										} else if($item->media_type == 'VIDEO') {
											$output .= '<video src="'.esc_url( $item->media_url ).'" alt="'.esc_attr__('Video By ','wdt-elementor-addon').$item->username.'" title="'.esc_attr__('Video By ','wdt-elementor-addon').$item->username.'"></>';
										}

										$output .= '<div class="wdt-instagram-media-overlay"></div>';
										if(isset($settings['general_image_hover_icon_style']) && $settings['general_image_hover_icon_style'] != '') {
											$output .= '<div class="wdt-instagram-media-icon">';
												if($settings['general_image_hover_icon_style'] == 'instagram') {
													$output .= '<i class="fab fa-instagram"></i>';
												} else if($settings['general_image_hover_icon_style'] == 'plus') {
													$output .= '<i class="plus"></i>';
												}
											$output .= '</div>';
										}
									if($settings['show_link'] == 'yes') {
										$output .= '</a>';
									}
								$output .= '</div>';
							$output .= '</div>';
						$output .= '</div>';

						if( $limit == $count ) {
							break;
						}

						$limit++;

					}
				}

				$output .= $this->cc_layout->get_column_edit_mode_css();
			$output .= $this->cc_layout->get_wrapper_end();

		} else {
			$output .= '<p>'.esc_html__('Please provide "Instagram App" settings to proceed.','wdt-elementor-addon').'</p>';
		}

		return $output;

	}

}

if( !function_exists( 'wedesigntech_widget_base_instagram' ) ) {
    function wedesigntech_widget_base_instagram() {
        return WeDesignTech_Widget_Base_Instagram::instance();
    }
}