<?php

class WeDesignTech_Common_Controls_Repeater_Contents {

	private $options_group;
    //private $options;
    private $options_default;
    private $options_template;
	//private $option_keys;
	private $option_default_keys;
	private $option_template_keys;
	private $option_default_condition = array ();
	private $option_template_condition = array ();
	private $option_media_image_condition = array ();
	private $option_media_icon_condition = array ();
	private $option_defaults = array ();
	private $module_details = array ();

	private $cc_rating;

    function __construct($options_group, $options, $option_defaults, $module_details) {

		$this->options_group = $options_group;
        //$this->options = $options;
        $this->options_default = (isset($options['default']) && !empty($options['default'])) ? $options['default'] : array ();
        $this->options_template = (isset($options['template']) && !empty($options['template'])) ? $options['template'] : array ();
        //$this->option_keys = array_keys($options);
		$this->option_default_keys = (isset($options['default']) && !empty($options['default'])) ? array_keys($options['default']) : array ();
        $this->option_template_keys = (isset($options['template']) && !empty($options['template'])) ? array_keys($options['template']) : array ();
        $this->option_defaults = $option_defaults;
        $this->module_details = $module_details;

		if(in_array('default', $this->options_group) && in_array('template', $this->options_group)) {
			$this->option_default_condition = array( 'item_type' => 'default' );
			$this->option_template_condition = array( 'item_type' => 'template' );
		}

		$this->cc_rating = new WeDesignTech_Common_Controls_Rating();

    }

	public function init_styles() {
		$layout_styles = array ();
		$layout_styles['wdt-repeater-content'] = WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/common-controls/repeater-contents/assets/css/style.css';
		return $layout_styles;
	}

	public function init_scripts() {
		return array ();
	}

	public function get_controls($elementor_object) {

		$elementor_object->start_controls_section( 'wdt_section_content', array(
            'label' => esc_html__( 'Content', 'wdt-elementor-addon'),
        ) );

			$repeater = new \Elementor\Repeater();
			if(in_array('default', $this->options_group) && in_array('template', $this->options_group)) {
				$repeater->add_control( 'item_type', array(
					'label'   => esc_html__( 'Content Type', 'wdt-elementor-addon' ),
					'type'    => \Elementor\Controls_Manager::SELECT2,
					'default' => 'default',
					'options' => array(
						'default'  => esc_html__( 'Default', 'wdt-elementor-addon' ),
						'template' => esc_html__( 'Template', 'wdt-elementor-addon' ),
					)
				) );
			} else if(in_array('default', $this->options_group)) {
				$repeater->add_control( 'item_type', array(
					'type'    => \Elementor\Controls_Manager::HIDDEN,
					'label'   => esc_html__('Content Type', 'wdt-elementor-addon'),
					'default' => 'default'
				) );
			} else if(in_array('template', $this->options_group)) {
				$repeater->add_control( 'item_type', array(
					'type'    => \Elementor\Controls_Manager::HIDDEN,
					'label'   => esc_html__('Content Type', 'wdt-elementor-addon'),
					'default' => 'template'
				) );
			}

            if((in_array('default', $this->options_group) && in_array('title', $this->option_default_keys)) || (in_array('template', $this->options_group) && in_array('title', $this->option_template_keys))) {

                $repeater->add_control( 'item_title', array(
                    'label'       => $this->options_default['title'],
                    'type'        => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'placeholder' => esc_html__( 'Item Title', 'wdt-elementor-addon' ),
                    'default'     => esc_html__( 'Item Title', 'wdt-elementor-addon' )
                ));

            }

			if(in_array('default', $this->options_group)) {
				if(in_array('image_or_icon', $this->option_default_keys)) {
					$repeater->add_control(
						'media_type',
						array (
							'label' => esc_html__( 'Graphic Element', 'wdt-elementor-addon' ),
							'type' => \Elementor\Controls_Manager::CHOOSE,
							'label_block' => false,
							'options' => array (
								'none' => array (
									'title' => esc_html__( 'None', 'wdt-elementor-addon' ),
									'icon' => 'fas fa-ban',
								),
								'image' => array (
									'title' => esc_html__( 'Image', 'wdt-elementor-addon' ),
									'icon' => 'far fa-image',
								),
								'icon' => array (
									'title' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
									'icon' => 'fas fa-star',
								),
							),
							'default' => 'icon',
							'condition' => $this->option_default_condition
						)
					);
					$this->option_media_image_condition = array( 'media_type' => 'image' );
					$this->option_media_icon_condition = array( 'media_type' => 'icon' );
				}
				if(in_array('image', $this->option_default_keys)) {
					$repeater->add_control(
						'media_image',
						array (
							'label' => esc_html__( 'Choose Image', 'wdt-elementor-addon' ),
							'type' => \Elementor\Controls_Manager::MEDIA,
							'default' => array (
								'url' => \Elementor\Utils::get_placeholder_image_src(),
							),
							'condition' => array_merge(
								$this->option_default_condition,
								$this->option_media_image_condition
							),
						)
					);
				}
				if(in_array('icon', $this->option_default_keys)) {
					$repeater->add_control(
						'media_icon',
						array (
							'label' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
							'type' => \Elementor\Controls_Manager::ICONS,
							'default' => (isset($this->module_details['icon_default_library']) && !empty($this->module_details['icon_default_library'])) ? $this->module_details['icon_default_library'] : array( 'value' => 'fas fa-star', 'library' => 'fa-solid' ),
							'condition' => array_merge(
								$this->option_default_condition,
								$this->option_media_icon_condition
							),
						)
					);
				}
				if(in_array('additional_title', $this->option_default_keys)) {
					$repeater->add_control( 'item_additional_title', array(
						'label'       => $this->options_default['additional_title'],
						'type'        => \Elementor\Controls_Manager::TEXT,
						'label_block' => true,
						'placeholder' => esc_html__( 'Item Additional Title', 'wdt-elementor-addon' ),
						'default'     => esc_html__( 'Item Additional Title', 'wdt-elementor-addon' ),
						'condition'   => $this->option_default_condition
					) );
				}
				if(in_array('sub_title', $this->option_default_keys)) {
					$repeater->add_control( 'item_sub_title', array(
						'label'       => $this->options_default['sub_title'],
						'type'        => \Elementor\Controls_Manager::TEXT,
						'label_block' => true,
						'placeholder' => esc_html__( 'Item Sub Title', 'wdt-elementor-addon' ),
						'default'     => esc_html__( 'Item Sub Title', 'wdt-elementor-addon' ),
						'condition'   => $this->option_default_condition
					) );
				}
				if(in_array('description', $this->option_default_keys)) {
					$repeater->add_control( 'item_description', array(
						'label'       => $this->options_default['description'],
						'type'        => \Elementor\Controls_Manager::TEXTAREA,
						'label_block' => true,
						'placeholder' => esc_html__( 'Item Description', 'wdt-elementor-addon' ),
						'default'     => esc_html__( 'Sed ut perspiciatis unde omnis iste natus error sit, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae.', 'wdt-elementor-addon' ),
						'condition'   => $this->option_default_condition
					) );
				}
				if(in_array('link', $this->option_default_keys)) {
					$repeater->add_control( 'item_link', array(
						'label'       => esc_html__( 'Link', 'wdt-elementor-addon' ),
						'type'        => \Elementor\Controls_Manager::URL,
						'label_block' => true,
						'placeholder' => esc_html__( 'https://your-link.com', 'wdt-elementor-addon' ),
						'condition'   => $this->option_default_condition
					) );
				}
				if(in_array('button', $this->option_default_keys)) {
					$repeater->add_control( 'item_button_text', array(
						'label'     => esc_html__( 'Button Text', 'wdt-elementor-addon' ),
						'type'      => \Elementor\Controls_Manager::TEXT,
						'default'   => '',
						'condition' => $this->option_default_condition
					) );
				}
				if(in_array('rating', $this->option_default_keys)) {
					$this->cc_rating->get_controls($repeater, $this->option_default_condition);
				}
				if(in_array('social_icons', $this->option_default_keys)) {
					$repeater->add_control( 'facebook_link', array(
						'label'       => esc_html__( 'Facebook Link', 'wdt-elementor-addon' ),
						'type'        => \Elementor\Controls_Manager::URL,
						'label_block' => true,
						'placeholder' => esc_html__( '#', 'wdt-elementor-addon' ),
						'condition'   => $this->option_default_condition
					) );
					$repeater->add_control( 'twitter_link', array(
						'label'       => esc_html__( 'Twitter Link', 'wdt-elementor-addon' ),
						'type'        => \Elementor\Controls_Manager::URL,
						'label_block' => true,
						'placeholder' => esc_html__( '#', 'wdt-elementor-addon' ),
						'condition'   => $this->option_default_condition
					) );
					$repeater->add_control( 'youtube_link', array(
						'label'       => esc_html__( 'YouTube Link', 'wdt-elementor-addon' ),
						'type'        => \Elementor\Controls_Manager::URL,
						'label_block' => true,
						'placeholder' => esc_html__( '#', 'wdt-elementor-addon' ),
						'condition'   => $this->option_default_condition
					) );
					$repeater->add_control( 'linkedin_link', array(
						'label'       => esc_html__( 'LinkedIn Link', 'wdt-elementor-addon' ),
						'type'        => \Elementor\Controls_Manager::URL,
						'label_block' => true,
						'placeholder' => esc_html__( '#', 'wdt-elementor-addon' ),
						'condition'   => $this->option_default_condition
					) );
				}
				if(in_array('custom', $this->option_default_keys)) {
					do_action($this->options_default['custom']['control_action'], $repeater);
				}
			}

			if(in_array('template', $this->options_group)) {
				if(in_array('icon', $this->option_template_keys)) {
					$repeater->add_control(
						'media_icon_template',
						array (
							'label' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
							'type' => \Elementor\Controls_Manager::ICONS,
							'default' => (isset($this->module_details['icon_default_library']) && !empty($this->module_details['icon_default_library'])) ? $this->module_details['icon_default_library'] : array( 'value' => 'fas fa-star', 'library' => 'fa-solid' ),
							'condition' => $this->option_template_condition
						)
					);
				}

				if(in_array('image', $this->option_template_keys)) {
					$repeater->add_control(
						'media_image_template',
						array (
							'label' => esc_html__( 'Choose Image', 'wdt-elementor-addon' ),
							'type' => \Elementor\Controls_Manager::MEDIA,
							'default' => array (
								'url' => \Elementor\Utils::get_placeholder_image_src(),
							),
							'condition' => $this->option_template_condition
						)
					);
				}
				if(in_array('description', $this->option_template_keys)) {
					$repeater->add_control( 'item_description_template', array(
						'label'       => $this->options_default['description'],
						'type'        => \Elementor\Controls_Manager::TEXTAREA,
						'label_block' => true,
						'placeholder' => esc_html__( 'Item Description', 'wdt-elementor-addon' ),
						'default'     => esc_html__( 'Sed ut perspiciatis unde omnis iste natus error sit, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae.', 'wdt-elementor-addon' ),
						'condition'   => $this->option_template_condition
					) );
				}
				if(in_array('link', $this->option_template_keys)) {
					$repeater->add_control( 'item_link_template', array(
						'label'       => esc_html__( 'Link', 'wdt-elementor-addon' ),
						'type'        => \Elementor\Controls_Manager::URL,
						'label_block' => true,
						'placeholder' => esc_html__( 'https://your-link.com', 'wdt-elementor-addon' ),
						'condition'   => $this->option_template_condition
					) );
				}
				if(in_array('button', $this->option_template_keys)) {
					$repeater->add_control( 'item_button_text_template', array(
						'label'     => esc_html__( 'Button Text', 'wdt-elementor-addon' ),
						'type'      => \Elementor\Controls_Manager::TEXT,
						'default'   => '',
						'condition' => $this->option_template_condition
					) );
				}
				
				$repeater->add_control('item_template', array(
					'label'     => esc_html__( 'Select Template', 'wdt-elementor-addon' ),
					'type'      => \Elementor\Controls_Manager::SELECT,
					'options'   => $elementor_object->get_elementor_page_list(),
					'condition' => $this->option_template_condition
				) );
			}

			$elementor_object->add_control( 'item_contents', array(
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'label'       => $this->module_details['title'],
				'description' => $this->module_details['description'],
				'fields'      => $repeater->get_controls(),
				'default' => $this->option_defaults,
				'title_field' => '{{{item_title}}}'
			) );

		$elementor_object->end_controls_section();

	}

    public function render_html($widget_object, $settings) {

        $output = '';

        if(is_array($settings['item_contents']) && !empty($settings['item_contents'])) {
            foreach( $settings['item_contents'] as $key => $item ) {

				if(isset($settings['module_layout_class']) && $settings['module_layout_class'] != '') {
					$output.= '<div class="'.esc_attr($settings['module_layout_class']).'">';
				}

					$output .= '<div class="wdt-content-item">';

						if( $item['item_type'] == 'default' ) {

							$link_start = $link_end = '';
							if( !empty( $item['item_link']['url'] ) ){
								$target = ( $item['item_link']['is_external'] == 'on' ) ? ' target="_blank" ' : '';
								$nofollow = ( $item['item_link']['nofollow'] == 'on' ) ? 'rel="nofollow" ' : '';
								$link_start = '<a href="'.esc_url( $item['item_link']['url'] ).'"'. $target . $nofollow.'>';
								$link_end = '</a>';
							}

							$group1_content_positions = $this->content_position_items($settings['group1_content_positions']);
							$group2_content_positions = $this->content_position_items($settings['group2_content_positions']);

							$output .= $this->render_contents($widget_object, $key, $item, $link_start, $link_end, $group1_content_positions, $settings, 'group1');
							$output .= $this->render_contents($widget_object, $key, $item, $link_start, $link_end, $group2_content_positions, $settings, 'group2');

						}

						if( $item['item_type'] == 'template' ) {
							$frontend = Elementor\Frontend::instance();
							$output .= $frontend->get_builder_content( $item['item_template'], true );
						}

					$output .= '</div>';

				if(isset($settings['module_layout_class']) && $settings['module_layout_class'] != '') {
					$output .= '</div>';
				}

            }
        }

        return $output;

    }

    public function content_position_items($content_position_items) {
		$content_positions = array();
		if(is_array($content_position_items) && !empty($content_position_items)){
			foreach($content_position_items as $content_position_item) {
				array_push($content_positions, $content_position_item['element_value']);
			}
		}
		return $content_positions;
	}

    protected function render_contents($widget_object, $key, $item, $link_start, $link_end, $content_positions, $settings, $group) {

		$output = '';
		if(is_array($content_positions) && !empty($content_positions)) {
			if($group == 'group1'){
				$output .= '<div class="wdt-content-media-group">';
			}
			if($group == 'group2'){
				$output .= '<div class="wdt-content-detail-group">';
			}
			foreach($content_positions as $content_position) {
				if($content_position == 'image_or_icon') {
					$output .= $this->render_image($item, $link_start, $link_end);
					$output .= $this->render_icon($key, $item, $widget_object);
				} else if($content_position == 'image') {
					$output .= $this->render_image($item, $link_start, $link_end);
				} else if($content_position == 'icon') {
					$output .= $this->render_icon($key, $item, $widget_object);
				} else if($content_position == 'title') {
					$output .= $this->render_title($item['item_title'], $link_start, $link_end);
				} else if($content_position == 'additional_title') {
					$output .= $this->render_additional_title($item['item_additional_title'], $link_start, $link_end);
				} else if($content_position == 'sub_title') {
					$output .= $this->render_sub_title($item['item_sub_title']);
				} else if($content_position == 'title_sub_title') {
					$output .= '<div class="wdt-content-title-group '.esc_attr($settings['title_subtitle_position']).'">';
						$output .= $this->render_title($item['item_title'], $link_start, $link_end);
						$output.= '<span></span>';
						$output .= $this->render_sub_title($item['item_sub_title']);
					$output .= '</div>';
				} else if($content_position == 'title_description') {
					$output .= '<div class="wdt-content-title-description-group">';
						$output .= $this->render_title($item['item_title'], $link_start, $link_end);
						$output .= $this->render_description($item['item_description']);
					$output .= '</div>';
				} else if($content_position == 'testimonial_template') {
					$output .= '<div class="wdt-content-testimonial-media-group">';
						$output .= $this->render_image($item, $link_start, $link_end);
						$output .= '<div class="wdt-content-testimonial-text">';
							$output .= $this->render_title($item['item_title'], $link_start, $link_end);
							$output .= $this->render_sub_title($item['item_sub_title']);
						$output .= '</div>';
					$output .= '</div>';
				} else if($content_position == 'separator_1') {
					$output .= $this->render_separator('separator-1');
				} else if($content_position == 'separator_2') {
					$output .= $this->render_separator('separator-2');
				} else if($content_position == 'description') {
					$output .= $this->render_description($item['item_description']);
				} else if($content_position == 'button') {
					$output .= $this->render_button($item['item_button_text'], $link_start, $link_end);
				} else if($content_position == 'social_icons') {
					$output .= $this->render_social_icons($item);
				} else if($content_position == 'rating') {
					$output .= $this->cc_rating->render_html($item['rating']);
				} else if($content_position == 'elements_group') {
					$output .= $this->render_elements_group($widget_object, $key, $item, $link_start, $link_end, $settings, $group);
				} else if($content_position == 'custom') {
					$output .= apply_filters($this->options_default['custom']['render_filter'], '', $widget_object, $key, $item, $link_start, $link_end, $settings);
				}
			}
			if($group == 'group1' || $group == 'group2'){
				$output .= '</div>';
			}
		}

		return $output;

	}

    protected function render_elements_group($widget_object, $key, $item, $link_start, $link_end, $settings, $group) {

		$output = $class = '';

		if($group == 'group1') {
			$content_positions = $this->content_position_items($settings['group1_element_group_content_positions']);
			$group_class = 'wdt-media-group';
			if(isset($settings['media_image_type']) && !empty($settings['media_image_type'])) {
				$class = 'wdt-media-image-'.$settings['media_image_type'];
			}
		}
		if($group == 'group2') {
			$content_positions = $this->content_position_items($settings['group2_element_group_content_positions']);
			$group_class = 'wdt-content-group';
		}

		if(is_array($content_positions) && !empty($content_positions)) {
			$output .= '<div class="wdt-content-elements-group '.esc_attr($group_class).' '.esc_attr($class).'">';
				if($group == 'group1' && (isset($settings['media_image_type']) && ($settings['media_image_type'] == 'overlay' || $settings['media_image_type'] == 'cover'))) {
					if(in_array('image_or_icon', $content_positions)) {
						$output .= $this->render_image($item, $link_start, $link_end);
						$output .= $this->render_icon($key, $item, $widget_object);
					} else if(in_array('image', $content_positions)) {
						$output .= $this->render_image($item, $link_start, $link_end);
					}
					$output .= '<div class="wdt-media-image-'.esc_attr($settings['media_image_type']).'-container">';
				}
				foreach($content_positions as $content_position) {
					if(!isset($settings['media_image_type']) && $content_position == 'image_or_icon') {
						$output .= $this->render_image($item, $link_start, $link_end);
						$output .= $this->render_icon($key, $item, $widget_object);
					} else if(!isset($settings['media_image_type']) && $content_position == 'image') {
						$output .= $this->render_image($item, $link_start, $link_end);
					} else if($content_position == 'icon') {
						$output .= $this->render_icon($key, $item, $widget_object);
					} else if($content_position == 'title') {
						$output .= $this->render_title($item['item_title'], $link_start, $link_end);
					} else if($content_position == 'additional_title') {
						$output .= $this->render_additional_title($item['item_additional_title'], $link_start, $link_end);
					}  else if($content_position == 'sub_title') {
						$output .= $this->render_sub_title($item['item_sub_title']);
					} else if($content_position == 'title_sub_title') {
						$output .= '<div class="wdt-content-title-group '.esc_attr($settings['title_subtitle_position']).'">';
							$output .= $this->render_title($item['item_title'], $link_start, $link_end);
							$output .= '<span></span>';
							$output .= $this->render_sub_title($item['item_sub_title']);
						$output .= '</div>';
					} else if($content_position == 'title_description') {
						$output .= '<div class="wdt-content-title-description-group">';
							$output .= $this->render_title($item['item_title'], $link_start, $link_end);
							$output .= $this->render_description($item['item_description']);
						$output .= '</div>';
					} else if($content_position == 'testimonial_template') {
						$output .= '<div class="wdt-content-testimonial-media-group">';
							$output .= $this->render_image($item, $link_start, $link_end);
							$output .= '<div class="wdt-content-testimonial-text">';
								$output .= $this->render_title($item['item_title'], $link_start, $link_end);
								$output .= $this->render_sub_title($item['item_sub_title']);
							$output .= '</div>';
						$output .= '</div>';
					} else if($content_position == 'separator_1') {
						$output .= $this->render_separator('separator-1');
					} else if($content_position == 'separator_2') {
						$output .= $this->render_separator('separator-2');
					} else if($content_position == 'description') {
						$output .= $this->render_description($item['item_description']);
					} else if($content_position == 'button') {
						$output .= $this->render_button($item['item_button_text'], $link_start, $link_end);
					} else if($content_position == 'social_icons') {
						$output .= $this->render_social_icons($item);
					} else if($content_position == 'rating') {
						$output .= $this->cc_rating->render_html($item['rating']);
					} else if($content_position == 'custom') {
						$output .= apply_filters($this->options_default['custom']['render_filter'], '', $widget_object, $key, $item, $link_start, $link_end, $settings);
					}
				}
				if($group == 'group1' && (isset($settings['media_image_type']) && ($settings['media_image_type'] == 'overlay' || $settings['media_image_type'] == 'cover'))) {
					$output .= '</div>';
				}
			$output .= '</div>';
		}

		return $output;

	}

	public function render_title($item_title, $link_start, $link_end) {
		$output = '';
		if( !empty( $item_title ) ) {
			$output .= '<div class="wdt-content-title">';
				$output .= '<h5>';
					$output .= $link_start;
					$output .= esc_html( $item_title );
					$output .= $link_end;
				$output .= '</h5>';
			$output .= '</div>';
		}
		return $output;
	}

	public function render_additional_title($item_additional_title, $link_start, $link_end) {
		$output = '';
		if( !empty( $item_additional_title ) ) {
			$output .= '<div class="wdt-content-additional-title">';
				$output .= '<span>';
					$output .= $link_start;
					$output .= esc_html( $item_additional_title );
					$output .= $link_end;
				$output .= '</span>';
			$output .= '</div>';
		}
		return $output;
	}

	public function render_sub_title($item_sub_title) {
		$output = '';
		if( !empty( $item_sub_title ) ) {
			$output .= '<div class="wdt-content-subtitle">';
				$output .= esc_html( $item_sub_title );
			$output .= '</div>';
		}
		return $output;
	}

	public function render_description($item_description) {
		$output = '';
		if( !empty( $item_description ) ) {
			$output .= '<div class="wdt-content-description">';
				$output .= $item_description;
			$output .= '</div>';
		}
		return $output;
	}

	public function render_separator($separator) {
		$output = '<div class="wdt-content-separator '.esc_attr($separator).'"><span></span></div>';
		return $output;
	}

    public function render_button($item_button_text, $link_start, $link_end) {
		$output = '';
		if( !empty($item_button_text) && !empty($link_start) ) {
			$output .= '<div class="wdt-content-button wdt-button-clone">';
				$output .= $link_start;
				$output .= esc_html( $item_button_text );
				$output .= $link_end;
			$output .= '</div>';
		}
		return $output;
	}

	public function render_social_icons($item) {
		$output = '';
		if($item['facebook_link']['url'] != '' || $item['twitter_link']['url'] != '' || $item['youtube_link']['url'] != '' || $item['linkedin_link']['url'] != '') {
			$output .= '<div class="wdt-social-icons-container">';
				$output .= '<ul class="wdt-social-icons-list">';
					if($item['facebook_link']['url'] != '') {

						$target = ( $item['facebook_link']['is_external'] == 'on' ) ? ' target="_blank" ' : '';
						$nofollow = ( $item['facebook_link']['nofollow'] == 'on' ) ? 'rel="nofollow" ' : '';
						$link_start = '<a href="'.esc_url( $item['facebook_link']['url'] ).'"'. $target . $nofollow.'>';
						$link_end = '</a>';

						$output .= '<li>';
							$output .= $link_start;
								$output .= '<i class="wdticon-facebook"></i>';
							$output .= $link_end;
						$output .= '</li>';

					}
					if($item['twitter_link']['url'] != '') {

						$target = ( $item['twitter_link']['is_external'] == 'on' ) ? ' target="_blank" ' : '';
						$nofollow = ( $item['twitter_link']['nofollow'] == 'on' ) ? 'rel="nofollow" ' : '';
						$link_start = '<a href="'.esc_url( $item['twitter_link']['url'] ).'"'. $target . $nofollow.'>';
						$link_end = '</a>';

						$output .= '<li>';
							$output .= $link_start;
								$output .= '<i class="wdt-icon-ext-x-icon"></i>';
							$output .= $link_end;
						$output .= '</li>';

					}
					if($item['youtube_link']['url'] != '') {

						$target = ( $item['youtube_link']['is_external'] == 'on' ) ? ' target="_blank" ' : '';
						$nofollow = ( $item['youtube_link']['nofollow'] == 'on' ) ? 'rel="nofollow" ' : '';
						$link_start = '<a href="'.esc_url( $item['youtube_link']['url'] ).'"'. $target . $nofollow.'>';
						$link_end = '</a>';

						$output .= '<li>';
							$output .= $link_start;
								$output .= '<i class="wdticon-youtube"></i>';
							$output .= $link_end;
						$output .= '</li>';

					}
					if($item['linkedin_link']['url'] != '') {

						$target = ( $item['linkedin_link']['is_external'] == 'on' ) ? ' target="_blank" ' : '';
						$nofollow = ( $item['linkedin_link']['nofollow'] == 'on' ) ? 'rel="nofollow" ' : '';
						$link_start = '<a href="'.esc_url( $item['linkedin_link']['url'] ).'"'. $target . $nofollow.'>';
						$link_end = '</a>';

						$output .= '<li>';
							$output .= $link_start;
								$output .= '<i class="wdticon-linkedin"></i>';
							$output .= $link_end;
						$output .= '</li>';

					}
				$output .= '</ul>';
			$output .= '</div>';
		}
		return $output;
	}

	public function render_image($item, $link_start, $link_end) {
		$output = '';
		if ( ! empty( $item['media_image']['url'] ) ) :
			$class = '';
			$output .= '<div class="wdt-content-image-wrapper '.esc_attr($class).'">';
				$output .= '<div class="wdt-content-image">';

					$media_image_setting = array ();
					$media_image_setting['image'] = $item['media_image'];
					$media_image_setting['image_size'] = 'full';
					$media_image_setting['image_custom_dimension'] = isset($item['media_image_custom_dimension']) ? $item['media_image_custom_dimension'] : array ();

					$output .=  ($link_start != '') ? $link_start : '<span>';
						$output .= \Elementor\Group_Control_Image_Size::get_attachment_image_html( $media_image_setting );
					$output .=  ($link_end != '') ? $link_end : '</span>';

				$output .= '</div>';
			$output .= '</div>';

		endif;
		return $output;
	}

	public function render_icon($key, $item, $widget_object) {
		$output = '';
		if ( ! empty( $item['media_icon']['value'] ) ) :

			$output .= '<div class="wdt-content-icon-wrapper">';
				$output .= '<div class="wdt-content-icon"><span>';
					ob_start();
					\Elementor\Icons_Manager::render_icon( $item['media_icon'], [ 'aria-hidden' => 'true' ] );
					$output .= ob_get_clean();
				$output .= '</span></div>';
			$output .= '</div>';

		endif;
		return $output;
	}

	public function render_template_icon($key, $item, $widget_object) {
		$output = '';
		if ( ! empty( $item['media_icon_template']['value'] ) ) :

			$output .= '<div class="wdt-content-icon-wrapper">';
				$output .= '<div class="wdt-content-icon"><span>';
					$output .= ($item['media_icon_template']['library'] === 'svg') ? '<i>' : '';
						ob_start();
						\Elementor\Icons_Manager::render_icon( $item['media_icon_template'], [ 'aria-hidden' => 'true' ] );
						$output .= ob_get_clean();
						$output .= ($item['media_icon_template']['library'] === 'svg') ? '</i>' : '';
				$output .= '</span></div>';
			$output .= '</div>';

		endif;
		return $output;
	}

}