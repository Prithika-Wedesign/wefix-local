<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once WEDESIGNTECH_ELEMENTOR_ADDON_DIR_PATH . 'inc/widgets/mailchimp/subscription.php';

class WeDesignTech_Widget_Base_Mailchimp {

	private static $_instance = null;

	private $cc_repeater_contents;
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

	}

	public function name() {
		return 'wdt-mailchimp';
	}

	public function title() {
		return esc_html__( 'Mailchimp', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'wdt-widget-icon';
	}

	public function init_styles() {
		return array (
				$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/mailchimp/assets/css/style.css'
			);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array (
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'inc/widgets/mailchimp/assets/js/script.js'
		);
	}

	public function list_ids() {

		$lists = array();

		$apiKey = get_option('elementor_wdt_mailchimp_api_key');

		if (!empty($apiKey)) {

			$dataCenter = substr($apiKey, strpos($apiKey, '-') + 1);
			$url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/';
			$args = array(
				'headers' => array(
					'Authorization' => 'apikey ' . $apiKey,
				),
			);

			$response = wp_remote_get(esc_url($url), $args);
			if (is_wp_error($response)) {
				// Handle error if any
				return $lists;
			}
			
			$results = json_decode(wp_remote_retrieve_body($response));
			if (isset($results->lists)) {
				foreach ($results->lists as $list) {
					$lists[$list->id] = $list->name;
				}
			}

		}

		return $lists;
	}

	public function create_elementor_controls($elementor_object) {

		$elementor_object->start_controls_section( 'wdt_section_settings', array(
			'label' => esc_html__( 'Settings', 'wdt-elementor-addon'),
		) );

			$elementor_object->add_control( 'list_id', array(
				'label'     => esc_html__('List ID', 'wdt-elementor-addon'),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => '',
				'options'   => $this->list_ids()
			) );

			$elementor_object->add_control( 'template', array(
				'label'   => esc_html__( 'Template', 'wdt-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT2,
				'default' => 'type2',
				'options' => array(
					'type1'  => esc_html__( 'Type 1', 'wdt-elementor-addon' ),
					'type2'  => esc_html__( 'Type 2', 'wdt-elementor-addon' )
				)
			) );

			$elementor_object->add_control( 'terms_condition', array(
				'label'     => esc_html__('Enable terms and condition', 'wdt-elementor-addon'),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'default'   => 'no',
				'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
				'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
				'return_value' => 'yes',
				'condition' => array ()
			) );

			$elementor_object->add_control( 'terms_text', array(
				'label'       => esc_html__( 'Terms and Conditions Text', 'wdt-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'label_block' => true,
				'default'     => esc_html__( 'I agree in receiving email\'s from WPFW.', 'wdt-elementor-addon' ),
				'condition'   => array(
					'terms_condition' => 'yes'
				)
			) );

		$elementor_object->end_controls_section();

		$elementor_object->start_controls_section( 'wdt_section_form', array(
			'label' => esc_html__( 'Form', 'wdt-elementor-addon'),
		) );

			$elementor_object->add_control( 'show_name_field', array(
				'label'        => esc_html__( 'Show Name Field', 'wdt-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
				'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
				'return_value' => 'yes',
				'condition' => array (
					'template!' => array ('type2')
				)
			) );

			$elementor_object->add_control( 'name_label', array(
				'label'       =>  esc_html__( 'Name Label', 'wdt-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Name', 'wdt-elementor-addon' ),
				'default'     => esc_html__( 'Name', 'wdt-elementor-addon' ),
				'condition' => array (
					'template!' => array ('type2'),
					'show_name_field' => 'yes'
				)
			) );

			$elementor_object->add_control( 'email_label', array(
				'label'       =>  esc_html__( 'Email Label', 'wdt-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Email', 'wdt-elementor-addon' ),
				'default'     => esc_html__( 'Email', 'wdt-elementor-addon' )
			) );

			$elementor_object->add_control( 'button_type', array(
				'label'   => esc_html__( 'Button Type', 'wdt-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT2,
				'default' => 'text',
				'options' => array(
					'text'  => esc_html__( 'Text', 'wdt-elementor-addon' ),
					'icon'  => esc_html__( 'Icon', 'wdt-elementor-addon' ),
					'text_n_icon'  => esc_html__( 'Text & Icon', 'wdt-elementor-addon' )
				)
			) );

			$elementor_object->add_control( 'button_label', array(
				'label'       =>  esc_html__( 'Button Label', 'wdt-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Submit', 'wdt-elementor-addon' ),
				'default'     => esc_html__( 'Submit', 'wdt-elementor-addon' ),
				'condition' => array (
					'button_type' => array ('text', 'text_n_icon')
				)
			) );

			$elementor_object->add_control(
				'button_icon',
				array (
					'label' => esc_html__( 'Button Icon', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'label_block' => false,
					'skin' => 'inline',
					'default' => array( 'value' => 'far fa-paper-plane', 'library' => 'fa-regular', ),
					'condition' => array (
						'button_type' => array ('icon', 'text_n_icon')
					)
				)
			);

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
							'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-subscribe-form' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
						),
						'condition' => array ()
					),
					'margin' => array (
						'field_type' => 'margin',
						'selector' => array (
							'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-subscribe-form' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
						'condition' => array ()
					),
					'padding' => array (
						'field_type' => 'padding',
						'selector' => array (
							'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-subscribe-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
											'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-subscribe-form' => 'color: {{VALUE}};'
										),
										'condition' => array ()
									),
									'background' => array (
										'field_type' => 'background',
										'selector' => '{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-subscribe-form',
										'condition' => array ()
									),
									'border' => array (
										'field_type' => 'border',
										'selector' => '{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-subscribe-form',
										'condition' => array ()
									),
									'border_radius' => array (
										'field_type' => 'border_radius',
										'selector' => array (
											'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-subscribe-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
										),
										'condition' => array ()
									),
									'box_shadow' => array (
										'field_type' => 'box_shadow',
										'selector' => '{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-subscribe-form',
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
											'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-subscribe-form:hover' => 'color: {{VALUE}};'
										),
										'condition' => array ()
									),
									'background' => array (
										'field_type' => 'background',
										'selector' => '{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-subscribe-form:hover',
										'condition' => array ()
									),
									'border' => array (
										'field_type' => 'border',
										'selector' => '{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-subscribe-form:hover',
										'condition' => array ()
									),
									'border_radius' => array (
										'field_type' => 'border_radius',
										'selector' => array (
											'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-subscribe-form:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
										),
										'condition' => array ()
									),
									'box_shadow' => array (
										'field_type' => 'box_shadow',
										'selector' => '{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-subscribe-form:hover',
										'condition' => array ()
									)
								)
							)
						)
					)
				)
			));

			// Form
			$this->cc_style->get_style_controls($elementor_object, array (
				'slug' => 'form',
				'title' => esc_html__( 'Form', 'wdt-elementor-addon' ),
				'styles' => array (
					'heading_input' => array (
						'field_type' => 'heading',
						'unique_key' => 'input',
						'title' => esc_html__( 'Input', 'wdt-elementor-addon' ),
						'condition' => array (),
						'separator' => 'before'
					),
					'alignment_input' => array (
						'field_type' => 'alignment',
						'unique_key' => 'input',
						'selector' => array (
							'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper input, 
							 {{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper input::placeholder,
							 {{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper input::-webkit-placeholder' => 'text-align: {{VALUE}}; justify-content: {{VALUE}};'
						),
						'condition' => array ()
					),
					'margin_input' => array (
						'field_type' => 'margin',
						'unique_key' => 'input',
						'selector' => array (
							'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
						'condition' => array ()
					),
					'padding_input' => array (
						'field_type' => 'padding',
						'unique_key' => 'input',
						'selector' => array (
							'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
						'condition' => array ()
					),
                    'typography_input' => array (
                        'field_type' => 'typography',
                        'unique_key' => 'input',
                        'selector' => '{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper input',
                        'condition' => array ()
                    ),
					'tabs_input' => array (
						'field_type' => 'tabs',
						'unique_key' => 'input',
						'tab_items' => array (
							'normal' => array (
								'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
								'styles' => array (
									'color_text' => array (
										'field_type' => 'color',
										'unique_key' => 'text',
										'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
										'selector' => array (
											'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper input, {{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper input::placeholder' => 'color: {{VALUE}};'
										),
										'condition' => array ()
									),
									'color_background' => array (
										'field_type' => 'color',
										'unique_key' => 'background',
										'label' => esc_html__( 'Background Color', 'wdt-elementor-addon' ),
										'selector' => array (
											'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper input' => 'background-color: {{VALUE}};'
										),
										'condition' => array ()
									),
									'border' => array (
										'field_type' => 'border',
										'selector' => '{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper input',
										'condition' => array ()
									),
									'border_radius' => array (
										'field_type' => 'border_radius',
										'selector' => array (
											'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
										),
										'condition' => array ()
									),
									'box_shadow' => array (
										'field_type' => 'box_shadow',
										'selector' => '{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper input',
										'condition' => array ()
									)
								)
							),
							'hover' => array (
								'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
								'styles' => array (
									'color_text' => array (
										'field_type' => 'color',
										'unique_key' => 'text',
										'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
										'selector' => array (
											'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper input:hover, {{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper input:focus, {{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper input:focus::placeholder' => 'color: {{VALUE}};'
										),
										'condition' => array ()
									),
									'color_background' => array (
										'field_type' => 'color',
										'unique_key' => 'background',
										'label' => esc_html__( 'Background Color', 'wdt-elementor-addon' ),
										'selector' => array (
											'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper input:hover, {{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper input:focus' => 'background-color: {{VALUE}};'
										),
										'condition' => array ()
									),
									'border' => array (
										'field_type' => 'border',
										'selector' => '{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper input:hover, {{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper input:focus',
										'condition' => array ()
									),
									'border_radius' => array (
										'field_type' => 'border_radius',
										'selector' => array (
											'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper input:hover, {{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper input:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
										),
										'condition' => array ()
									),
									'box_shadow' => array (
										'field_type' => 'box_shadow',
										'selector' => '{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper input:hover, {{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper input:focus',
										'condition' => array ()
									)
								)
							)
						)
					),

					'heading_button' => array (
						'field_type' => 'heading',
						'unique_key' => 'button',
						'title' => esc_html__( 'Button', 'wdt-elementor-addon' ),
						'condition' => array (),
						'separator' => 'before'
					),
					'margin_button' => array (
						'field_type' => 'margin',
						'unique_key' => 'button',
						'selector' => array (
							'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper .wdt-mailchimp-subscription-button-holder button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
						'condition' => array ()
					),
					'padding_button' => array (
						'field_type' => 'padding',
						'unique_key' => 'button',
						'selector' => array (
							'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper .wdt-mailchimp-subscription-button-holder button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
						'condition' => array ()
					),
                    'typography_button' => array (
                        'field_type' => 'typography',
                        'unique_key' => 'button',
                        'selector' => '{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper .wdt-mailchimp-subscription-button-holder button',
                        'condition' => array ()
                    ),
					'tabs_button' => array (
						'field_type' => 'tabs',
						'unique_key' => 'button',
						'tab_items' => array (
							'normal' => array (
								'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
								'styles' => array (
									'color_text' => array (
										'field_type' => 'color',
										'unique_key' => 'text',
										'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
										'selector' => array (
											'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper .wdt-mailchimp-subscription-button-holder button' => 'color: {{VALUE}};'
										),
										'condition' => array ()
									),
									'color_background' => array (
										'field_type' => 'color',
										'unique_key' => 'background',
										'label' => esc_html__( 'Background Color', 'wdt-elementor-addon' ),
										'selector' => array (
											'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper .wdt-mailchimp-subscription-button-holder button' => 'background-color: {{VALUE}};'
										),
										'condition' => array ()
									),
									'border' => array (
										'field_type' => 'border',
										'selector' => '{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper .wdt-mailchimp-subscription-button-holder button',
										'condition' => array ()
									),
									'border_radius' => array (
										'field_type' => 'border_radius',
										'selector' => array (
											'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper .wdt-mailchimp-subscription-button-holder button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
										),
										'condition' => array ()
									),
									'box_shadow' => array (
										'field_type' => 'box_shadow',
										'selector' => '{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper .wdt-mailchimp-subscription-button-holder button',
										'condition' => array ()
									)
								)
							),
							'hover' => array (
								'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
								'styles' => array (
									'color_text' => array (
										'field_type' => 'color',
										'unique_key' => 'text',
										'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
										'selector' => array (
											'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper .wdt-mailchimp-subscription-button-holder button:hover' => 'color: {{VALUE}};'
										),
										'condition' => array ()
									),
									'color_background' => array (
										'field_type' => 'color',
										'unique_key' => 'background',
										'label' => esc_html__( 'Background Color', 'wdt-elementor-addon' ),
										'selector' => array (
											'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper .wdt-mailchimp-subscription-button-holder button:hover' => 'background-color: {{VALUE}};'
										),
										'condition' => array ()
									),
									'border' => array (
										'field_type' => 'border',
										'selector' => '{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper .wdt-mailchimp-subscription-button-holder button:hover',
										'condition' => array ()
									),
									'border_radius' => array (
										'field_type' => 'border_radius',
										'selector' => array (
											'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper .wdt-mailchimp-subscription-button-holder button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
										),
										'condition' => array ()
									),
									'box_shadow' => array (
										'field_type' => 'box_shadow',
										'selector' => '{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper .wdt-mailchimp-subscription-button-holder button:hover',
										'condition' => array ()
									)
								)
							)
						)
					),

					'heading_message' => array (
						'field_type' => 'heading',
						'unique_key' => 'message',
						'title' => esc_html__( 'Message', 'wdt-elementor-addon' ),
						'condition' => array (),
						'separator' => 'before'
					),
					'margin_message' => array (
						'field_type' => 'margin',
						'unique_key' => 'message',
						'selector' => array (
							'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper .wdt-mailchimp-subscription-msg-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
						'condition' => array ()
					),
					'padding_message' => array (
						'field_type' => 'padding',
						'unique_key' => 'message',
						'selector' => array (
							'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper .wdt-mailchimp-subscription-msg-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
						'condition' => array ()
					),
                    'typography_message' => array (
                        'field_type' => 'typography',
                        'unique_key' => 'message',
                        'selector' => '{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper .wdt-mailchimp-subscription-msg-inner',
                        'condition' => array ()
                    ),
					'border_message' => array (
						'field_type' => 'border',
						'unique_key' => 'message',
						'selector' => '{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper .wdt-mailchimp-subscription-msg-inner',
						'condition' => array ()
					),
					'border_radius_message' => array (
						'field_type' => 'border_radius',
						'unique_key' => 'message',
						'selector' => array (
							'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper .wdt-mailchimp-subscription-msg-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
						'condition' => array ()
					),
					'box_shadow_message' => array (
						'field_type' => 'box_shadow',
						'unique_key' => 'message',
						'selector' => '{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper .wdt-mailchimp-subscription-msg-inner',
						'condition' => array ()
					),
					'tabs_message' => array (
						'field_type' => 'tabs',
						'unique_key' => 'message',
						'tab_items' => array (
							'success' => array (
								'title' => esc_html__( 'Success', 'wdt-elementor-addon' ),
								'styles' => array (
									'color_text' => array (
										'field_type' => 'color',
										'unique_key' => 'text',
										'selector' => array (
											'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper .wdt-mailchimp-subscription-msg-inner.success' => 'color: {{VALUE}};'
										),
										'condition' => array ()
									),
									'color_background' => array (
										'field_type' => 'color',
										'unique_key' => 'background',
										'label' => esc_html__( 'Background Color', 'wdt-elementor-addon' ),
										'selector' => array (
											'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper .wdt-mailchimp-subscription-msg-inner.success' => 'background-color: {{VALUE}};'
										),
										'condition' => array ()
									),
								)
							),
							'error' => array (
								'title' => esc_html__( 'Error', 'wdt-elementor-addon' ),
								'styles' => array (
									'color_text' => array (
										'field_type' => 'color',
										'unique_key' => 'text',
										'selector' => array (
											'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper .wdt-mailchimp-subscription-msg-inner.error' => 'color: {{VALUE}};'
										),
										'condition' => array ()
									),
									'color_background' => array (
										'field_type' => 'color',
										'unique_key' => 'background',
										'label' => esc_html__( 'Background Color', 'wdt-elementor-addon' ),
										'selector' => array (
											'{{WRAPPER}} .wdt-mailchimp-holder .wdt-mailchimp-wrapper .wdt-mailchimp-subscription-msg-inner.error' => 'background-color: {{VALUE}};'
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

	public function render_form_html($settings) {

		$api_key = get_option( 'elementor_wdt_mailchimp_api_key' );

		$button_class = '';
		if($settings['button_type'] == 'text') {
			$button_class = 'with-btn-text';
		} else if($settings['button_type'] == 'icon') {
			$button_class = 'with-btn-icon';
		} else if($settings['button_type'] == 'text_n_icon') {
			$button_class = 'with-btn-icon-and-text';
		}

		$output = '';
		$output .= '<form class="wdt-mailchimp-subscribe-form '.esc_attr($button_class).'" name="mailchimpSubscribeForm" action="#" method="post">';
			
			if ($settings['template'] == 'type2') {
				$output .= '<div class="wdt-mailchimp-form-holder">';
			}
				if($settings['show_name_field'] == 'yes') {
					$output .= '<input type="text" name="wdt_mc_fname" placeholder="'.esc_attr($settings['name_label']).'">';
				}
				$output .= '<input type="email" name="wdt_mc_emailid" required="required" placeholder="'.esc_attr($settings['email_label']).'" value="">';

				$output .= '<input type="hidden" name="wdt_mc_apikey" value="'.esc_attr($api_key).'" />';
				$output .= '<input type="hidden" name="wdt_mc_listid" value="'.esc_attr($settings['list_id']).'" />';

				if(($settings['terms_condition'] == 'yes') && ($settings['template'] == 'type1')) {
					$output .= '<div class="wdt-terms-and-condition-holder">';
						$output .= '<input type="checkbox" class="wdt-terms-and-conditions" required="required"><span class="wdt-terms-condition-lbl">' . esc_html($settings['terms_text']) . '</span>';
					$output .= '</div>';
				}

				$output .= '<div class="wdt-mailchimp-subscription-button-holder">';

					$output .= '<button type="submit" name="wdt_mc_submit">';

						if($settings['button_type'] == 'text' || $settings['button_type'] == 'text_n_icon') {
							$output .= '<span>'.esc_html($settings['button_label']).'</span>';
						}

						if($settings['button_type'] == 'icon' || $settings['button_type'] == 'text_n_icon') {
							if(!empty($settings['button_icon']['value'])) {
								ob_start();
								\Elementor\Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] );
								$output .= ob_get_clean();
							}
						}

					$output .= '</button>';

				$output .= '</div>';

			if ($settings['template'] == 'type2') {
				$output .= '</div>';
			} 
			$output .= '</form>';
			
			if(($settings['terms_condition'] == 'yes') && ($settings['template'] == 'type2')) {
				$output .= '<div class="wdt-terms-and-condition-holder">';
					$output .= '<input type="checkbox" class="wdt-terms-and-conditions" required="required"><span class="wdt-terms-condition-lbl">' . esc_html($settings['terms_text']) . '</span>';
				$output .= '</div>';
			}

		
		$output .= '<div class="wdt-mailchimp-subscription-msg"></div>';

		return $output;
	}

	public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}

		extract($settings);

		$output = '';

		$module_id = $widget_object->get_id();

		$output .= '<div class="wdt-mailchimp-holder '.esc_attr('wdt-template-'.$template).'" id="wdt-mailchimp-'.esc_attr( $module_id ).'">';
			$output .= '<div class="wdt-mailchimp-wrapper">';
				$output .= $this->render_form_html($settings);
			$output .= '</div>';
		$output .= '</div>';

		return $output;

	}

}

if( !function_exists( 'wedesigntech_widget_base_mailchimp' ) ) {
    function wedesigntech_widget_base_mailchimp() {
        return WeDesignTech_Widget_Base_Mailchimp::instance();
    }
}