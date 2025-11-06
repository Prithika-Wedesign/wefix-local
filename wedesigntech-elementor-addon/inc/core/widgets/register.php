<?php

if (! class_exists ( 'WeDesignTechElementorWidget' )) {

	class WeDesignTechElementorWidget {

		private static $_instance = null;

		public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		function __construct() {

			add_action( 'elementor/element/common/_section_style/after_section_end', array( $this, 'after_section_end' ), 10, 2 );
			add_action( 'elementor/frontend/before_enqueue_scripts',  array( $this, 'enqueue_scripts' ) );

		}

		public function after_section_end( $elementor_object, $args ) {

			$elementor_object->start_controls_section(
				'wdt_section_options',
				array(
					'label' => esc_html__( 'WeDesignTech Options', 'wdt-elementor-addon' )
				)
			);

			// Animation Effects

				$elementor_object->add_control(
					'wdt_animation_effects_heading',
					array(
						'label' => esc_html__( 'Animation Effects', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before'
					)
				);

				$elementor_object->add_control(
					'wdt_animation_effect',
					array(
						'label'   => esc_html__( 'Effects', 'wdt-elementor-addon' ),
						'type'    => Elementor\Controls_Manager::SELECT,
						'default' => 'none',
						'options' => array(
							'none'          => esc_html__( 'None', 'wdt-elementor-addon' ),
							'mouse-move'    => esc_html__( 'Mouse Move', 'wdt-elementor-addon' ),
							'scroll'        => esc_html__( 'Scroll', 'wdt-elementor-addon' ),
							'auto-movement' => esc_html__( 'Auto Movement', 'wdt-elementor-addon' )
						),
						'frontend_available' => true
					)
				);

			// Mouse Move - Effect

				$elementor_object->add_responsive_control(
					'wdt_mme_speed',
					array(
						'label' => esc_html__( 'Speed', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => array ( 'ms' ),
						'default' => array (
							'unit' => 'ms',
							'size' => 0.1,
						),
						'range' => array (
							'ms' => array (
								'min' => 0.1,
								'max' => 1,
								'step' => 0.1
							)
						),
						'frontend_available' => true,
						'condition' => array(
							'wdt_animation_effect' => 'mouse-move',
						)
					)
				);

				$elementor_object->add_responsive_control(
					'wdt_mme_depth',
					array(
						'label' => esc_html__( 'Depth', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => array ( 'dpt' ),
						'default' => array (
							'unit' => 'dpt',
							'size' => 1,
						),
						'range' => array (
							'dpt' => array (
								'min' => 0,
								'max' => 5,
								'step' => 0.1
							)
						),
						'frontend_available' => true,
						'condition' => array(
							'wdt_animation_effect' => 'mouse-move',
						)
					)
				);

				$elementor_object->add_control(
					'wdt_mme_move_along',
					array(
						'label'   => esc_html__( 'Movement', 'wdt-elementor-addon' ),
						'type'    => Elementor\Controls_Manager::SELECT,
						'default' => 'both',
						'options' => array(
							'x-axis' => esc_html__( 'X Axis', 'wdt-elementor-addon' ),
							'y-axis' => esc_html__( 'Y Axis', 'wdt-elementor-addon' ),
							'both'   => esc_html__( 'Both', 'wdt-elementor-addon' )
						),
						'frontend_available' => true,
						'condition' => array(
							'wdt_animation_effect' => 'mouse-move',
						)
					)
				);

				$elementor_object->add_control(
					'wdt_mme_invert_movement',
					array(
						'label'        => esc_html__( 'Invert Movement', 'wdt-elementor-addon' ),
						'type'         => \Elementor\Controls_Manager::SWITCHER,
						'default'      => '',
						'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
						'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
						'return_value' => 'true',
						'frontend_available' => true,
						'condition' => array(
							'wdt_animation_effect' => 'mouse-move',
						)
					)
				);

			// Scroll - Effect

				$elementor_object->add_control(
					'wdt_sle_parallax_x_direction',
					array(
						'label'        => esc_html__( 'Horizontal Direction', 'wdt-elementor-addon' ),
						'type'         => \Elementor\Controls_Manager::SWITCHER,
						'default'      => '',
						'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
						'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
						'return_value' => 'true',
						'frontend_available' => true,
						'condition' => array(
							'wdt_animation_effect' => 'scroll'
						)
					)
				);

				$elementor_object->add_responsive_control(
					'wdt_sle_parallax_x_depth',
					array(
						'label' => esc_html__( 'Horizontal Depth', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => array ( 'dpt' ),
						'default' => array (
							'unit' => 'dpt',
							'size' => 50,
						),
						'range' => array (
							'dpt' => array (
								'min' => 0,
								'max' => 250,
								'step' => 1
							)
						),
						'frontend_available' => true,
						'condition' => array(
							'wdt_animation_effect' => 'scroll',
							'wdt_sle_parallax_x_direction' => 'true'
						)
					)
				);

				$elementor_object->add_control(
					'wdt_sle_parallax_y_direction',
					array(
						'label'        => esc_html__( 'Vertical Direction', 'wdt-elementor-addon' ),
						'type'         => \Elementor\Controls_Manager::SWITCHER,
						'default'      => '',
						'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
						'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
						'return_value' => 'true',
						'frontend_available' => true,
						'condition' => array(
							'wdt_animation_effect' => 'scroll'
						)
					)
				);

				$elementor_object->add_responsive_control(
					'wdt_sle_parallax_y_depth',
					array(
						'label' => esc_html__( 'Vertical Depth', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => array ( 'dpt' ),
						'default' => array (
							'unit' => 'dpt',
							'size' => 50,
						),
						'range' => array (
							'dpt' => array (
								'min' => 0,
								'max' => 250,
								'step' => 1
							)
						),
						'frontend_available' => true,
						'condition' => array(
							'wdt_animation_effect' => 'scroll',
							'wdt_sle_parallax_y_direction' => 'true'
						)
					)
				);

				$elementor_object->add_control(
					'wdt_sle_rotate_x',
					array(
						'label'        => esc_html__( 'Rotate X', 'wdt-elementor-addon' ),
						'type'         => \Elementor\Controls_Manager::SWITCHER,
						'default'      => '',
						'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
						'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
						'return_value' => 'true',
						'frontend_available' => true,
						'condition' => array(
							'wdt_animation_effect' => 'scroll'
						)
					)
				);

				$elementor_object->add_responsive_control(
					'wdt_sle_rotate_x_angle',
					array(
						'label' => esc_html__( 'Rotate X Angle', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => array ( 'deg' ),
						'default' => array (
							'unit' => 'deg',
							'size' => 45,
						),
						'range' => array (
							'deg' => array (
								'min' => 0,
								'max' => 360,
								'step' => 1
							)
						),
						'frontend_available' => true,
						'condition' => array(
							'wdt_animation_effect' => 'scroll',
							'wdt_sle_rotate_x' => 'true'
						)
					)
				);

				$elementor_object->add_control(
					'wdt_sle_rotate_y',
					array(
						'label'        => esc_html__( 'Rotate Y', 'wdt-elementor-addon' ),
						'type'         => \Elementor\Controls_Manager::SWITCHER,
						'default'      => '',
						'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
						'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
						'return_value' => 'true',
						'frontend_available' => true,
						'condition' => array(
							'wdt_animation_effect' => 'scroll'
						)
					)
				);

				$elementor_object->add_responsive_control(
					'wdt_sle_rotate_y_angle',
					array(
						'label' => esc_html__( 'Rotate Y Angle', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => array ( 'deg' ),
						'default' => array (
							'unit' => 'deg',
							'size' => 45,
						),
						'range' => array (
							'deg' => array (
								'min' => 0,
								'max' => 360,
								'step' => 1
							)
						),
						'frontend_available' => true,
						'condition' => array(
							'wdt_animation_effect' => 'scroll',
							'wdt_sle_rotate_y' => 'true'
						)
					)
				);

				$elementor_object->add_control(
					'wdt_sle_rotate_z',
					array(
						'label'        => esc_html__( 'Rotate Z', 'wdt-elementor-addon' ),
						'type'         => \Elementor\Controls_Manager::SWITCHER,
						'default'      => '',
						'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
						'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
						'return_value' => 'true',
						'frontend_available' => true,
						'condition' => array(
							'wdt_animation_effect' => 'scroll'
						)
					)
				);

				$elementor_object->add_responsive_control(
					'wdt_sle_rotate_z_angle',
					array(
						'label' => esc_html__( 'Rotate Z Angle', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => array ( 'deg' ),
						'default' => array (
							'unit' => 'deg',
							'size' => 45,
						),
						'range' => array (
							'deg' => array (
								'min' => 0,
								'max' => 360,
								'step' => 1
							)
						),
						'frontend_available' => true,
						'condition' => array(
							'wdt_animation_effect' => 'scroll',
							'wdt_sle_rotate_z' => 'true'
						)
					)
				);

				$elementor_object->add_control(
					'wdt_sle_scale',
					array(
						'label'        => esc_html__( 'Scale', 'wdt-elementor-addon' ),
						'type'         => \Elementor\Controls_Manager::SWITCHER,
						'default'      => '',
						'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
						'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
						'return_value' => 'true',
						'frontend_available' => true,
						'condition' => array(
							'wdt_animation_effect' => 'scroll'
						)
					)
				);

				$elementor_object->add_responsive_control(
					'wdt_sle_scale_value',
					array(
						'label' => esc_html__( 'Scale Value', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => array ( 'value' ),
						'default' => array (
							'unit' => 'value',
							'size' => 1,
						),
						'range' => array (
							'value' => array (
								'min' => 0.5,
								'max' => 1.5,
								'step' => 0.1
							)
						),
						'frontend_available' => true,
						'condition' => array(
							'wdt_animation_effect' => 'scroll',
							'wdt_sle_scale' => 'true'
						)
					)
				);

				$elementor_object->add_control(
					'wdt_sle_blur',
					array(
						'label'        => esc_html__( 'Blur', 'wdt-elementor-addon' ),
						'type'         => \Elementor\Controls_Manager::SWITCHER,
						'default'      => '',
						'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
						'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
						'return_value' => 'true',
						'frontend_available' => true,
						'condition' => array(
							'wdt_animation_effect' => 'scroll'
						)
					)
				);

				$elementor_object->add_responsive_control(
					'wdt_sle_blur_value',
					array(
						'label' => esc_html__( 'Blur Value', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => array ( 'value' ),
						'default' => array (
							'unit' => 'value',
							'size' => 0,
						),
						'range' => array (
							'value' => array (
								'min' => 0,
								'max' => 2,
								'step' => 0.1
							)
						),
						'frontend_available' => true,
						'condition' => array(
							'wdt_animation_effect' => 'scroll',
							'wdt_sle_blur' => 'true'
						)
					)
				);

				$elementor_object->add_control(
					'wdt_sle_opacity',
					array(
						'label'        => esc_html__( 'Opacity', 'wdt-elementor-addon' ),
						'type'         => \Elementor\Controls_Manager::SWITCHER,
						'default'      => '',
						'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
						'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
						'return_value' => 'true',
						'frontend_available' => true,
						'condition' => array(
							'wdt_animation_effect' => 'scroll'
						)
					)
				);

				$elementor_object->add_responsive_control(
					'wdt_sle_opacity_value',
					array(
						'label' => esc_html__( 'Opacity Value', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => array ( 'value' ),
						'default' => array (
							'unit' => 'value',
							'size' => 1,
						),
						'range' => array (
							'value' => array (
								'min' => 0.1,
								'max' => 1,
								'step' => 0.1
							)
						),
						'frontend_available' => true,
						'condition' => array(
							'wdt_animation_effect' => 'scroll',
							'wdt_sle_opacity' => 'true'
						)
					)
				);

			// Auto Movement - Effect

				$elementor_object->add_control(
					'wdt_ame_duration',
					array(
						'label' => esc_html__( 'Duration', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => array ( 'dpt' ),
						'default' => array (
							'unit' => 'dpt',
							'size' => 5,
						),
						'range' => array (
							'dpt' => array (
								'min' => 1,
								'max' => 10,
								'step' => 0.5
							)
						),
						'frontend_available' => true,
						'condition' => array(
							'wdt_animation_effect' => 'auto-movement'
						)
					)
				);

				$elementor_object->add_control(
					'wdt_ame_iteration',
					array(
						'label'   => esc_html__( 'Iteration', 'wdt-elementor-addon' ),
						'type'    => Elementor\Controls_Manager::SELECT,
						'default' => 'infinity',
						'options' => array(
							'infinity' => esc_html__( 'Infinity', 'wdt-elementor-addon' ),
							'once' => esc_html__( 'Only Once', 'wdt-elementor-addon' )
						),
						'frontend_available' => true,
						'condition' => array(
							'wdt_animation_effect' => 'auto-movement'
						)
					)
				);

				$repeater = new \Elementor\Repeater();

				$repeater->add_control(
					'wdt_x_direction',
					array(
						'label'        => esc_html__( 'Horizontal Direction', 'wdt-elementor-addon' ),
						'type'         => \Elementor\Controls_Manager::SWITCHER,
						'default'      => '',
						'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
						'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
						'return_value' => 'true',
						'frontend_available' => true
					)
				);

				$repeater->add_responsive_control(
					'wdt_x_depth',
					array(
						'label' => esc_html__( 'Horizontal Depth', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => array ( 'dpt' ),
						'default' => array (
							'unit' => 'dpt',
							'size' => 0,
						),
						'range' => array (
							'dpt' => array (
								'min' => 0,
								'max' => 500,
								'step' => 1
							)
						),
						'frontend_available' => true,
						'condition' => array(
							'wdt_x_direction' => 'true'
						)
					)
				);

				$repeater->add_control(
					'wdt_y_direction',
					array(
						'label'        => esc_html__( 'Vertical Direction', 'wdt-elementor-addon' ),
						'type'         => \Elementor\Controls_Manager::SWITCHER,
						'default'      => '',
						'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
						'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
						'return_value' => 'true',
						'frontend_available' => true
					)
				);

				$repeater->add_responsive_control(
					'wdt_y_depth',
					array(
						'label' => esc_html__( 'Vertical Depth', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => array ( 'dpt' ),
						'default' => array (
							'unit' => 'dpt',
							'size' => 0,
						),
						'range' => array (
							'dpt' => array (
								'min' => 0,
								'max' => 500,
								'step' => 1
							)
						),
						'frontend_available' => true,
						'condition' => array(
							'wdt_y_direction' => 'true'
						)
					)
				);

				$repeater->add_control(
					'wdt_rotate',
					array(
						'label'        => esc_html__( 'Rotate', 'wdt-elementor-addon' ),
						'type'         => \Elementor\Controls_Manager::SWITCHER,
						'default'      => '',
						'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
						'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
						'return_value' => 'true',
						'frontend_available' => true
					)
				);

				$repeater->add_responsive_control(
					'wdt_rotate_angle',
					array(
						'label' => esc_html__( 'Rotate Angle', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => array ( 'deg' ),
						'default' => array (
							'unit' => 'deg',
							'size' => 0,
						),
						'range' => array (
							'deg' => array (
								'min' => 0,
								'max' => 360,
								'step' => 1
							)
						),
						'frontend_available' => true,
						'condition' => array(
							'wdt_rotate' => 'true'
						)
					)
				);

				$repeater->add_control(
					'wdt_scale',
					array(
						'label'        => esc_html__( 'Scale', 'wdt-elementor-addon' ),
						'type'         => \Elementor\Controls_Manager::SWITCHER,
						'default'      => '',
						'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
						'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
						'return_value' => 'true',
						'frontend_available' => true
					)
				);

				$repeater->add_responsive_control(
					'wdt_scale_value',
					array(
						'label' => esc_html__( 'Scale Value', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => array ( 'value' ),
						'default' => array (
							'unit' => 'value',
							'size' => 1,
						),
						'range' => array (
							'value' => array (
								'min' => 0.5,
								'max' => 1.5,
								'step' => 0.1
							)
						),
						'frontend_available' => true,
						'condition' => array(
							'wdt_scale' => 'true'
						)
					)
				);

				$repeater->add_control(
					'wdt_blur',
					array(
						'label'        => esc_html__( 'Blur', 'wdt-elementor-addon' ),
						'type'         => \Elementor\Controls_Manager::SWITCHER,
						'default'      => '',
						'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
						'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
						'return_value' => 'true',
						'frontend_available' => true
					)
				);

				$repeater->add_responsive_control(
					'wdt_blur_value',
					array(
						'label' => esc_html__( 'Blur Value', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => array ( 'value' ),
						'default' => array (
							'unit' => 'value',
							'size' => 0,
						),
						'range' => array (
							'value' => array (
								'min' => 0,
								'max' => 2,
								'step' => 0.1
							)
						),
						'frontend_available' => true,
						'condition' => array(
							'wdt_blur' => 'true'
						)
					)
				);

				$repeater->add_control(
					'wdt_opacity',
					array(
						'label'        => esc_html__( 'Opacity', 'wdt-elementor-addon' ),
						'type'         => \Elementor\Controls_Manager::SWITCHER,
						'default'      => '',
						'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
						'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
						'return_value' => 'true',
						'frontend_available' => true
					)
				);

				$repeater->add_responsive_control(
					'wdt_opacity_value',
					array(
						'label' => esc_html__( 'Opacity Value', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => array ( 'value' ),
						'default' => array (
							'unit' => 'value',
							'size' => 1,
						),
						'range' => array (
							'value' => array (
								'min' => 0,
								'max' => 1,
								'step' => 0.1
							)
						),
						'frontend_available' => true,
						'condition' => array(
							'wdt_opacity' => 'true'
						)
					)
				);

				$elementor_object->add_control(
					'wdt_ame_custom_directions',
					array(
						'label'              => esc_html__( 'Custom Directions', 'wdt-elementor-addon' ),
						'type'               => \Elementor\Controls_Manager::REPEATER,
						'fields'             => $repeater->get_controls(),
						'frontend_available' => true,
						'prevent_empty'      => false,
						'condition' => array(
							'wdt_animation_effect' => 'auto-movement',
						)
					)
				);

				$elementor_object->add_control(
					'wdt_dark_mode',
					array(	
						'label'        => esc_html__( 'Enable Dark Background', 'wdt-elementor-addon' ),
						'type'         => \Elementor\Controls_Manager::SWITCHER,
						'default'      => '',
						'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
						'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
						'description' => esc_html__( 'If you like to enable dark mode for this item, choose "Yes".', 'wdt-elementor-addon' ),
						'frontend_available' => true,
						'return_value' => 'true'
					)
				);

			// InView Status

				$elementor_object->add_control(
					'wdt_item_inview_heading',
					array(
						'label' => esc_html__( 'InView', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before'
					)
				);

				$elementor_object->add_control(
					'wdt_enable_inview_status',
					array(
						'label'        => esc_html__( 'Enable InView Status', 'wdt-elementor-addon' ),
						'type'         => \Elementor\Controls_Manager::SWITCHER,
						'default'      => '',
						'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
						'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
						'description' => esc_html__( 'If you like to find if the item is in view port, for any custom animation or custom effects you want to add, choose "Yes".', 'wdt-elementor-addon' ),
						'frontend_available' => true,
						'return_value' => 'true'
					)
				);

				$elementor_object->add_control(
					'wdt_enable_inview_loop',
					array(
						'label'        => esc_html__( 'Enable InView Loop', 'wdt-elementor-addon' ),
						'type'         => \Elementor\Controls_Manager::SWITCHER,
						'default'      => '',
						'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
						'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
						'description' => esc_html__( 'Inview class will be added on every time item comes to view port.', 'wdt-elementor-addon' ),
						'frontend_available' => true,
						'return_value' => 'true'
					)
				);

			$elementor_object->end_controls_section();

		}

		public function enqueue_scripts() {
			wp_enqueue_script( 'wdt-parallax-scroll' );
			wp_enqueue_script( 'wdt-parallax' );
			wp_enqueue_script( 'wdt-elementor-widgets', WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'inc/core/widgets/assets/js/script.js', array ('jquery', 'elementor-frontend'), WEDESIGNTECH_ELEMENTOR_ADDON_VERSION, true );

		}

	}

}


if( !function_exists('wedesigntech_elementor_widget') ) {
	function wedesigntech_elementor_widget() {
		return WeDesignTechElementorWidget::instance();
	}
}

wedesigntech_elementor_widget();
?>