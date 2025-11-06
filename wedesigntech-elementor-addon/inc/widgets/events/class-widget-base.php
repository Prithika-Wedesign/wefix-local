<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/* if ( ! class_exists( 'Tribe__Events__Main' ) ) {
    exit; // Exit if accessed directly.
}
 */
class WeDesignTech_Widget_Base_Events {

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
		return 'wdt-events';
	}

	public function title() {
		return esc_html__( 'Events', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'wdt-widget-icon';
	}

	public function init_styles() {
		return array_merge(
			$this->cc_layout->init_styles(),
			array (
				$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/events/assets/css/style.css'
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
			'label' => esc_html__( 'Events Settings', 'wdt-elementor-addon'),
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
				'options'     => $this->wdt_event_post_ids(),
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

		$elementor_object->end_controls_section();

		$this->cc_layout->get_controls($elementor_object);

	}

	public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}

		$output = '';

		$classes = array ();

        $settings['module_id'] = $widget_object->get_id();
        $settings['module_class'] = 'events';
        $settings['classes'] = $classes;
        $this->cc_layout->set_settings($settings);
        $module_layout_class = $this->cc_layout->get_item_class();

        $events_arg = array (
            'start_date' => 'now',
			'post__in' 		 => ( isset($settings['_post_ids']) && !empty($settings['_post_ids']) ? $settings['_post_ids'] : '' ),
            'posts_per_page' => (isset($settings['limit']['size']) && !empty($settings['limit']['size'])) ? $settings['limit']['size'] : 4
        );
        $events_list = tribe_get_events($events_arg);

        if(is_array($events_list) && !empty($events_list)) {
            $output .= $this->cc_layout->get_wrapper_start();

                foreach($events_list as $event_item) {
                    $event_id = $event_item->ID;
                    $event_title = $event_item->post_title;

                    $output .= '<div class="wdt-event-item '.esc_attr($module_layout_class).'">';
                        if(has_post_thumbnail($event_id)) {
                            $output .= '<div class="wdt-event-item-media">';
                                $output .= get_the_post_thumbnail($event_id, 'full', array ('title' => $event_title));
                            $output .= '</div>';
                        }
                        $output .= '<h2><a href="'.get_permalink($event_id).'">'.$event_title.'</a></h2>';
                        $output .= tribe_events_event_schedule_details( $event_id, '<p><i class="fa fa-calendar-o"></i>', '</p>' );
                        $output .=  '<p><i class="fa fa-calendar-o"></i>'.tribe_get_venue($event_id).', '.tribe_get_country($event_id).'</p>';
                        $output .= '<a href="'.get_permalink($event_id).'" class="wdt-event-item-button">'.esc_html__('Join Now', 'wdt-elementor-addon').'</a>';
                    $output .= '</div>';

                }

                $output .= $this->cc_layout->get_column_edit_mode_css();
            $output .= $this->cc_layout->get_wrapper_end();
        }

		return $output;

	}

	public function wdt_event_post_ids(){
		$posts = get_posts( array(
			'post_type'   => 'tribe_events',
			'post_status' => 'publish',
			'numberposts' => -1
		));

		if ( ! empty( $posts ) && ! is_wp_error( $posts ) ){
			foreach ( $posts as $post ) {
				$options[ $post->ID ] = $post->post_title;
			}
		}

		return $options;
	}

}

if( !function_exists( 'wedesigntech_widget_base_events' ) ) {
    function wedesigntech_widget_base_events() {
        if ( class_exists( 'Tribe__Events__Main' ) ) {
            return WeDesignTech_Widget_Base_Events::instance();
        }
    }
}