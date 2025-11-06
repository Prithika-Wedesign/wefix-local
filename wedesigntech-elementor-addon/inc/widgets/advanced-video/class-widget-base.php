<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Advanced_Video {

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
		return 'wdt-advanced-video';
	}

    public function title() {
		return esc_html__( 'Advanced Video', 'wdt-elementor-addon' );
	}

    public function icon() {
		return 'wdt-widget-icon';
	}

    public function init_styles() {
		return array (
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/advanced-video/assets/css/style.css'
		);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array (
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/advanced-video/assets/js/script.js'
		);
	}

    public function create_elementor_controls($elementor_object) {

		$elementor_object->start_controls_section( 'wdt_section_content', array(
			'label' => esc_html__( 'Content', 'wdt-elementor-addon'),
		));
       

        $elementor_object->add_control('external_url',array(
            'label' => esc_html__( 'Video Link', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::URL,
			'placeholder' => esc_html__( 'https://your-link.com', 'wdt-elementor-addon' ),
			'options' => array( 'url', 'is_external', 'nofollow' ),
			'default' => array(
				'url' => '#',
				'is_external' => false,
				'nofollow' => false,
			
			),
			'label_block' => true,   
        ) );

		$elementor_object->add_control(
			'paly_icon',
			array (
				'label' => esc_html__( 'Play Icon', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'label_block' => false,
				'skin' => 'inline',
				'default' => array( 'value' => 'fas fa-arrow-left', 'library' => 'fa-solid', )
			)
		);

		$elementor_object->add_control(
			'pause_icon',
			array (
				'label' => esc_html__( 'Pause Icon', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'label_block' => false,
				'skin' => 'inline',
				'default' => array( 'value' => 'fas fa-arrow-right', 'library' => 'fa-solid', )
			)
		);

        $elementor_object->end_controls_section();
    }

    public function render_html($widget_object, $settings){

        if($widget_object->widget_type != 'elementor') {
			return;
		}

		if ( ! empty( $settings['external_url'] ) ) {
			$video_url = $settings['external_url']['url'];
		}

		$paly_icon = $pause_icon = '';
		if(!empty($settings['paly_icon']['value'])) {
			$paly_icon .= ($settings['paly_icon']['library'] === 'svg') ? '<i>' : '';
				ob_start();
				\Elementor\Icons_Manager::render_icon( $settings['paly_icon'], [ 'aria-hidden' => 'true' ] );
				$paly_icon .= ob_get_clean();
			$paly_icon .= ($settings['paly_icon']['library'] === 'svg') ? '</i>' : '';
		}
		if(!empty($settings['pause_icon']['value'])) {
			$pause_icon .= ($settings['pause_icon']['library'] === 'svg') ? '<i>' : '';
				ob_start();
				\Elementor\Icons_Manager::render_icon( $settings['pause_icon'], [ 'aria-hidden' => 'true' ] );
				$pause_icon .= ob_get_clean();
			$pause_icon .= ($settings['pause_icon']['library'] === 'svg') ? '</i>' : '';
		}

        $output = '';
            $output .=  '<div class="wdt-advanced-video-container">';
				$output .= '<div class="wdt-advanced-video">';
					$output .= '<div class="wdt-play-button"><span class="wdt-control-icons"><i class="wdticon-play"></i></span></div>';
            		$output .= '<video class="advanced-video" src="'.esc_attr( $video_url ).'"></video>';
					$output .= '<input type="hidden" name="wdt_video_paly" value="'.esc_attr($paly_icon).'" />';
					$output .= '<input type="hidden" name="wdt_video_pause" value="'.esc_attr($pause_icon).'" />';
			    $output .= '</div>';
				
			$output .=  '</div>';

			
        return $output;

    }

}

if( !function_exists( 'wedesigntech_widget_base_advanced_video' ) ) {
    function wedesigntech_widget_base_advanced_video() {
        return WeDesignTech_Widget_Base_Advanced_Video::instance();
    }
}
