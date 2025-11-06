<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Donations {

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
		return 'wdt-donations';
	}

	public function title() {
		return esc_html__( 'Donations', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'wdt-widget-icon';
	}

	public function init_styles() {
		return array_merge(
			$this->cc_layout->init_styles(),
			array (
                'wdt-progress-bar' =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/progress-bar/assets/css/style.css',
				$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/donations/assets/css/style.css'
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
			array (
                'jquery-progress-bar' => WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'inc/widgets/donations/assets/js/progressbar.min.js',
                $this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/donations/assets/js/script.js'
            )
		);
	}

	public function create_elementor_controls($elementor_object) {

		$elementor_object->start_controls_section( 'wdt_section_settings', array(
			'label' => esc_html__( 'Donations Settings', 'wdt-elementor-addon'),
		) );

			$elementor_object->add_control( 'query_posts_by', array(
				'type'    => \Elementor\Controls_Manager::SELECT,
				'label'   => esc_html__('Query posts by', 'wdt-elementor-addon'),
				'default' => 'ids',
				'options' => array(
					// 'category'  => esc_html__('From Category (for Posts only)', 'wdt-elementor-addon'),
					'ids'       => esc_html__('By Specific IDs', 'wdt-elementor-addon'),
				)
			) );

			$elementor_object->add_control( '_post_ids', array(
				'label'       => esc_html__( 'Select Specific Posts', 'wdt-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => $this->wdt_donation_post_ids(),
				'condition' => array( 'query_posts_by' => 'ids' )
			) );

			$elementor_object->add_control( 'limit', array(
				'label'   => esc_html__('Limit', 'wdt-elementor-addon'),
				'type'    => \Elementor\Controls_Manager::SLIDER,
				'range'   => array(
					'px' => array( 'min' => 1, 'max' => 10, 'step' => 1 )
				),
				'separator' => 'before',
				'default' => array(
					'size' => 4
				)
        	) );

            $elementor_object->add_control( 'single_page_link', array(
                'label'   => esc_html__( 'Single Page Link', 'wdt-elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => array(
                    ''  => esc_html__( 'Default', 'wdt-elementor-addon' ),
                    'custom_redirection' => esc_html__( 'Custom Redirection', 'wdt-elementor-addon' )
                )
            ));

			$elementor_object->add_control( 'progress_bar_design', array(
                'label'   => esc_html__( 'Progress Bar Design', 'wdt-elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => array(
                    'horizontal'  	=> esc_html__( 'Horizontal', 'wdt-elementor-addon' ),
                    'circle' 		=> esc_html__( 'Circle', 'wdt-elementor-addon' )
                )
            ));

		$elementor_object->end_controls_section();

		$this->cc_layout->get_controls($elementor_object);

		// Arrow
		$this->cc_layout->get_carousel_style_controls($elementor_object, array ('layout' => 'carousel'));

		$elementor_object->start_controls_section( 'wdt_style_section_bar', array(
        	'label'      => esc_html__( 'Bar', 'wdt-elementor-addon' ),
			'tab'        => \Elementor\Controls_Manager::TAB_STYLE
		) );

			$elementor_object->add_control(
				'bar_active_thickness',
				array (
					'label' => esc_html__( 'Active Thickeness', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 0.1,
					'max' => 100,
					'step' => 0.1,
					'default' => 2
				)
			);

			$elementor_object->add_control(
				'bar_inactive_thickness',
				array (
					'label' => esc_html__( 'Inactive Thickeness', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 0.1,
					'max' => 100,
					'step' => 0.1,
					'default' => 2
				)
			);

			$elementor_object->add_control(
				'bar_active_color',
				array (
					'label' => esc_html__( 'Active Color', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => wedesigntech_elementor_global_colors( 'system_colors', 0 ),
					'global' => array (
						'active' => false,
					)
				)
			);

			$elementor_object->add_control(
				'bar_inactive_color',
				array (
					'label' => esc_html__( 'Inactive Color', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => wedesigntech_elementor_global_colors( 'system_colors', 2 ),
					'global' => array (
						'active' => false,
					)
				)
			);

            $elementor_object->add_control(
				'enable_gradient',
				array(
					'label'              => esc_html__( 'Enable Gradient', 'wdt-elementor-addon' ),
					'type'               => \Elementor\Controls_Manager::SWITCHER,
					'frontend_available' => true,
					'default'            => '',
					'return_value'       => 'true'
				)
			);

			$elementor_object->add_control(
				'gradient_color',
				array (
					'label' => esc_html__( 'Gradient Color', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'global' => array (
						'active' => false,
					),
					'default' => wedesigntech_elementor_global_colors( 'system_colors', 3 ),
					'condition' => array(
						'enable_gradient' => 'true'
					)
				)
			);

		$elementor_object->end_controls_section();

	}

    public function get_attributes($settings) {

        $bar_settings = array();
		$bar_settings['module_id'] = $settings['module_id'];
        $bar_settings['bar_active_thickness'] = $settings['bar_active_thickness'];
		$bar_settings['bar_inactive_thickness'] = $settings['bar_inactive_thickness'];
		$bar_settings['bar_active_color'] = !empty($settings['bar_active_color']) ? $settings['bar_active_color'] : '';
		$bar_settings['bar_inactive_color'] = !empty($settings['bar_inactive_color']) ? $settings['bar_inactive_color'] : '';
        $bar_settings_attr = wp_json_encode($bar_settings);

        return $bar_settings_attr;

    }

	public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}

		$classes = array ();

        $settings['module_id'] = $widget_object->get_id();
        $settings['module_class'] = 'donations';
        $settings['classes'] = $classes;

        $bar_settings = array();
		$bar_settings['module_id'] = $settings['module_id'];
        $bar_settings['bar_active_thickness'] = $settings['bar_active_thickness'];
		$bar_settings['bar_inactive_thickness'] = $settings['bar_inactive_thickness'];
		$bar_settings['bar_active_color'] = !empty($settings['bar_active_color']) ? $settings['bar_active_color'] : '';
		$bar_settings['bar_inactive_color'] = !empty($settings['bar_inactive_color']) ? $settings['bar_inactive_color'] : '';
        $bar_settings['enable_gradient'] = (isset($settings['enable_gradient']) && $settings['enable_gradient'] == 'true') ? true : false;
		$bar_settings['gradient_color'] = !empty($settings['gradient_color']) ? $settings['gradient_color'] : '';
		$bar_settings['progress_bar_design'] = ( isset($settings['progress_bar_design']) && !empty($settings['progress_bar_design']) ) ? $settings['progress_bar_design'] : 'horizontal';

        $settings['custom_attributes'] = $bar_settings;

        $this->cc_layout->set_settings($settings);
        $module_layout_class = $this->cc_layout->get_item_class();

       // Arguments to only fetch forms with goal enabled.
        $form_args = array(
            'post_type'      => 'give_forms',
            'post_status'    => 'publish',
			'post__in' 		 => ( isset($settings['_post_ids']) && !empty($settings['_post_ids']) ? $settings['_post_ids'] : '' ),
            'posts_per_page' => (isset($settings['limit']['size']) && !empty($settings['limit']['size'])) ? $settings['limit']['size'] : 4,
            'orderby'        => 'date',
            'order'          => 'ASC',
            'meta_key'       => '_give_goal_option',
            'meta_value'     => 'enabled',
        );

 
		$output = ''; 
		if (!empty($settings['_post_ids'])) {
			$form_args = array(
				'post_type'      => 'give_forms',
				'post__in'       => $settings['_post_ids'],
				'posts_per_page' => -1,
				'orderby'       => 'post__in',
			);
		} else { 
			$form_args = array(
				'post_type'      => 'give_forms',
				'posts_per_page' => -1,
				'post_status'   => 'publish',
				'orderby'       => isset($settings['orderby']) ? $settings['orderby'] : 'date',
				'order'         => isset($settings['order']) ? $settings['order'] : 'ASC',
			);
		}

		$form_query = new WP_Query($form_args);

		if ($form_query->have_posts()) {
			$output .= $this->cc_layout->get_wrapper_start();
			
			while ($form_query->have_posts()) {
				$form_query->the_post();

				$donation_id = get_the_ID();
				$donation_permalink = get_the_permalink();
				$donation_title = get_the_title();
	
				global $wpdb;
				$campaigns = $wpdb->get_results(
					$wpdb->prepare("SELECT * FROM {$wpdb->prefix}give_campaigns WHERE form_id = %d", $donation_id)
				); 
				$goal_stats = give_goal_progress_stats($donation_id);
				$donor_count = '';
				$args = array(
					'number' => 20,
					'id'     => $donation_id,
				);
				$donor_query = new Give_Donors_Query($args);
				$donor_query = $donor_query->get_donors();
				foreach ($donor_query as $donor) {
					$donor_count = $donor->purchase_count;
				}

				if($settings['single_page_link'] == 'custom_redirection') {
					$page_link = get_post_meta($donation_id, '_give_form_grid_redirect_url', true);
					$page_link = (isset($page_link) && !empty($page_link)) ? $page_link : '#';
				} else {
					$page_link = get_permalink($donation_id);
				}
				
				$total_received = give_get_meta($donation_id, '_give_form_earnings', true);
				
				$output .= '<div class="'.esc_attr($module_layout_class).'">';
					$output .= '<div class="wdt-donation-item">'; 
						if(has_post_thumbnail($donation_id)) {
							$output .= '<div class="wdt-donation-item-media"><a href="'.esc_url($page_link).'">';
								$output .= get_the_post_thumbnail($donation_id, 'full', array('title' => $donation_title));
							$output .= '</a></div>';
						}
						if(!empty($campaigns)) {
							$output .= '<div class="wdt-donation-item-media">';
							foreach ($campaigns as $campaign) {
								$campaign_image_url = $campaign->campaign_image;
								if ($campaign_image_url) {
									$output .= '<img src="' . esc_url($campaign_image_url) . '" alt="' . esc_attr($campaign->post_title) . '">';
								}
							}
							$output .= '</div>';
						}
						$output .= '<div class="wdt-donation-item-detail">';
							$output .= '<h4 class="wdt-donation-item-title"><a href="'.esc_url($page_link).'">'.$donation_title.'</a></h4>';
							$output .= '<p class="wdt-donation-item-description">'.esc_html($campaign->short_desc).'</p>';
							$output .= '<div class="wdt-donation-item-gf-wrapper">';
								$output .= '<div class="wdt-donation-item-goal-detail">';
									$output .= '<div class="wdt-donation-item-goal">'.esc_html__('Goal: ', 'wdt-elementor-addon').$goal_stats['goal'].'</div>';
									$output .= '<div class="wdt-donation-item-donor-count">'.esc_html__('donors: ', 'wdt-elementor-addon').$donor_count.'</div>';
								$output .= '</div>';
								$output .= '<div class="wdt-donation-item-fund-details">';
									$progress_bar_class_name = 'wdt-progressbar-circle';
									if($settings['progress_bar_design'] == 'horizontal') {
										$progress_bar_class_name = 'wdt-progressbar-horizontal';
									}
									
									$output .= '<div class="wdt-progressbar-container '.esc_attr($progress_bar_class_name).' wdt-progressbar-content-floating" id="wdt-progressbar-'.esc_attr($donation_id).'" data-donation-id="'.esc_attr($donation_id).'" data-percentage="'.esc_js($goal_stats['progress']).'">';
										$output .= '<div class="wdt-progressbar-content">';
											$output .= '<div class="wdt-progressbar-value"></div>';
										$output .= '</div>';
										$output .= '<div class="wdt-progressbar"></div>';
									$output .= '</div>';
								$output .= '</div>';
							$output .= '</div>';
							
							$output .= '<div class="wdt-donation-item-group-wrapper">';
								$output .= '<div class="wdt-donation-item-wrapper">
								<div class="wdt-donation-item-total">'.esc_html__('Fund raised: ', 'wdt-elementor-addon').'</div><div class="wdt-give-total-wrap">'.number_format($total_received, 2).'</div></div>';
								$output .= '<a href="'.esc_url($page_link).'" class="wdt-donation-item-button button">'.esc_html__('Donate Now', 'wdt-elementor-addon').'<svg class="icon-arrow-aft-btn" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										viewBox="0 0 100 63" style="enable-background:new 0 0 100 63;" xml:space="preserve">
								<polygon style="fill:currentColor;" points="63.2,6.3 84.3,27.4 -77.1,27.4 -77.1,35.6 84.3,35.6 63.2,56.7 69,62.5 100,31.5 69,0.5 "/>
								</svg></a>';
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
			}
			
			wp_reset_postdata();
			$output .= $this->cc_layout->get_column_edit_mode_css();
			$output .= $this->cc_layout->get_wrapper_end();
		}
		else {
		$output .= '<p>'.esc_html__('No donation forms found', 'wdt-elementor-addon').'</p>';
		}


		return $output;

	}

	public function wdt_donation_post_ids(){
		$posts = get_posts( array(
			'post_type'   => 'give_forms',
			'post_status' => 'publish',
			'numberposts' => -1
		));
		$options = array();
		if ( ! empty( $posts ) && ! is_wp_error( $posts ) ){
			foreach ( $posts as $post ) {
				$options[ $post->ID ] = $post->post_title;
			}
		}

		return $options;
	}

}

if( !function_exists( 'wedesigntech_widget_base_donations' ) ) {
    function wedesigntech_widget_base_donations() {
        return WeDesignTech_Widget_Base_Donations::instance();
    }
}