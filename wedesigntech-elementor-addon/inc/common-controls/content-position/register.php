<?php

class WeDesignTech_Common_Controls_Content_Position {

	private $content_position_elements = array ();
	private $group1_content_positions = array ();
	private $group1_element_group_content_positions = array ();
	private $group2_content_positions = array ();
	private $group2_element_group_content_positions = array ();
	private $module_details = array ();

    function __construct($content_position_elements, $group1_content_positions, $group1_element_group_content_positions, $group2_content_positions, $group2_element_group_content_positions, $module_details) {

		$this->content_position_elements = $content_position_elements;
        $this->group1_content_positions = $group1_content_positions;
        $this->group1_element_group_content_positions = $group1_element_group_content_positions;
        $this->group2_content_positions = $group2_content_positions;
        $this->group2_element_group_content_positions = $group2_element_group_content_positions;
        $this->module_details = $module_details;

        add_filter( 'wdt_elementor_localize_settings', array( $this, 'wdt_register_elementor_localize_settings' )  );

    }

    public function init_styles() {
		return array ();
	}

	public function init_scripts() {
		return array ();
	}

	public function wdt_register_elementor_localize_settings($settings) {
		$settings[$this->module_details['jsSlug']] = $this->content_position_elements;
		return $settings;
	}

	public function get_controls($elementor_object, $condition = array ()) {

		$elementor_object->start_controls_section( 'wdt_section_content_position', array(
			'label' => esc_html__( 'Content Position', 'wdt-elementor-addon'),
			'description' => esc_html__( 'Content Position', 'wdt-elementor-addon'),
			'condition' => $condition
		) );


			if(in_array('group1', $this->module_details['content_positions'])) {

				// Group 1

					$elementor_object->add_control(
						'group1_heading',
						array (
							'label' => $this->module_details['group1_title'],
							'type' => \Elementor\Controls_Manager::HEADING,
						)
					);

					$group1_content_positions_filtered = $this->content_position_elements;
					unset($group1_content_positions_filtered['description']);

				// Content Postions
					$repeater_group1_content_positions = new \Elementor\Repeater();
					$repeater_group1_content_positions->add_control( 'element_value', array(
						'type'    => \Elementor\Controls_Manager::SELECT,
						'label'   => esc_html__('Element', 'wdt-elementor-addon'),
						'default' => 'title',
						'options' => $group1_content_positions_filtered,
					) );
					$repeater_group1_content_positions->add_control( 'module', array(
						'type'    => \Elementor\Controls_Manager::HIDDEN,
						'label'   => esc_html__('Module', 'wdt-elementor-addon'),
						'default' => $this->module_details['jsSlug']
					) );
					$elementor_object->add_control( 'group1_content_positions', array(
						'type'        => \Elementor\Controls_Manager::REPEATER,
						'label'       => $this->module_details['group_cp_label'],
						'description' => $this->module_details['group_cp_label'],
						'fields'      => $repeater_group1_content_positions->get_controls(),
						'default' => $this->group1_content_positions,
						'prevent_empty' => false,
						'title_field' => '{{ wdtGetRepeaterContentTitle( obj ) }}'
					) );

			}

			if(in_array('group1_element_group', $this->module_details['content_positions'])) {

				// Content Element Group Postions
					$repeater_group1_element_group_content_positions = new \Elementor\Repeater();
					$repeater_group1_element_group_content_positions->add_control( 'element_value', array(
						'type'    => \Elementor\Controls_Manager::SELECT,
						'label'   => esc_html__('Element', 'wdt-elementor-addon'),
						'default' => 'title',
						'options' => $group1_content_positions_filtered,
					) );
					$repeater_group1_element_group_content_positions->add_control( 'module', array(
						'type'    => \Elementor\Controls_Manager::HIDDEN,
						'label'   => esc_html__('Module', 'wdt-elementor-addon'),
						'default' => $this->module_details['jsSlug']
					) );
					$elementor_object->add_control( 'group1_element_group_content_positions', array(
						'type'        => \Elementor\Controls_Manager::REPEATER,
						'label'       => $this->module_details['group_eg_cp_label'],
						'description' => $this->module_details['group_eg_cp_label'],
						'fields'      => $repeater_group1_element_group_content_positions->get_controls(),
						'default' => $this->group1_element_group_content_positions,
						'separator'   => 'before',
						'prevent_empty' => false,
						'title_field' => '{{ wdtGetRepeaterContentTitle( obj ) }}'
					) );

			}

			if(in_array('group2', $this->module_details['content_positions'])) {

				// Group 2

					$elementor_object->add_control(
						'group2_heading',
						array (
							'label' => $this->module_details['group2_title'],
							'type' => \Elementor\Controls_Manager::HEADING,
							'separator' => 'before'
						)
					);

					$group2_content_positions_filtered = $this->content_position_elements;
					unset($group2_content_positions_filtered['image']);

				// Content Postions
					$repeater_group2_content_positions = new \Elementor\Repeater();
					$repeater_group2_content_positions->add_control( 'element_value', array(
						'type'    => \Elementor\Controls_Manager::SELECT,
						'label'   => esc_html__('Element', 'wdt-elementor-addon'),
						'default' => 'title',
						'options' => $group2_content_positions_filtered,
					) );
					$repeater_group2_content_positions->add_control( 'module', array(
						'type'    => \Elementor\Controls_Manager::HIDDEN,
						'label'   => esc_html__('Module', 'wdt-elementor-addon'),
						'default' => $this->module_details['jsSlug']
					) );
					$elementor_object->add_control( 'group2_content_positions', array(
						'type'        => \Elementor\Controls_Manager::REPEATER,
						'label'       => $this->module_details['group_cp_label'],
						'description' => $this->module_details['group_cp_label'],
						'fields'      => $repeater_group2_content_positions->get_controls(),
						'default' => $this->group2_content_positions,
						'prevent_empty' => false,
						'title_field' => '{{ wdtGetRepeaterContentTitle( obj ) }}'
					) );

			}

			if(in_array('group2_element_group', $this->module_details['content_positions'])) {

				// Content Element Group Postions
					$repeater_group2_element_group_content_positions = new \Elementor\Repeater();
					$repeater_group2_element_group_content_positions->add_control( 'element_value', array(
						'type'    => \Elementor\Controls_Manager::SELECT,
						'label'   => esc_html__('Element', 'wdt-elementor-addon'),
						'default' => 'title',
						'options' => $group2_content_positions_filtered,
					) );
					$repeater_group2_element_group_content_positions->add_control( 'module', array(
						'type'    => \Elementor\Controls_Manager::HIDDEN,
						'label'   => esc_html__('Module', 'wdt-elementor-addon'),
						'default' => $this->module_details['jsSlug']
					) );
					$elementor_object->add_control( 'group2_element_group_content_positions', array(
						'type'        => \Elementor\Controls_Manager::REPEATER,
						'label'       => $this->module_details['group_eg_cp_label'],
						'description' => $this->module_details['group_eg_cp_label'],
						'fields'      => $repeater_group2_element_group_content_positions->get_controls(),
						'default'     => $this->group2_element_group_content_positions,
						'separator'   => 'before',
						'prevent_empty' => false,
						'title_field' => '{{ wdtGetRepeaterContentTitle( obj ) }}'
					) );

			}

			if(in_array('title_subtitle_position', $this->module_details['content_positions'])) {
				$elementor_object->add_control( 'title_subtitle_position', array(
					'label'       => esc_html__( 'Title & Sub Title Positions', 'wdt-elementor-addon' ),
					'type'        => \Elementor\Controls_Manager::SELECT,
					'label_block' => true,
					'separator' => 'before',
					'default' => 'below',
					'options' => array(
						'below'  => esc_html__( 'Below', 'wdt-elementor-addon' ),
						'beside' => esc_html__( 'Beside', 'wdt-elementor-addon' )
					),
				) );
			}

		$elementor_object->end_controls_section();

	}

}