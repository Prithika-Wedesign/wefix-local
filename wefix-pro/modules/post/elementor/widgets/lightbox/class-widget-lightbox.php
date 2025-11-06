<?php
use WeFixElementor\Widgets\WeFixElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Elementor_Lightbox extends WeFixElementorWidgetBase {

    public function get_name() {
        return 'wdt-lightbox';
    }

    public function get_title() {
        return esc_html__('Lightbox Image', 'wefix-pro');
    }

    protected function register_controls() {

        $this->start_controls_section( 'wdt_section_general', array(
            'label' => esc_html__( 'General', 'wefix-pro'),
        ) );

            $this->add_control( 'url', array(
                'type'        => Controls_Manager::MEDIA,
                'label'       => esc_html__('Choose Image', 'wefix-pro'),
				'default'	  => array( 'url' => \Elementor\Utils::get_placeholder_image_src(), ),
                'description' => esc_html__( 'Choose any one image from media.', 'wefix-pro' ),
            ) );

            $this->add_control( 'title', array(
                'type'        => Controls_Manager::TEXT,
                'label'       => esc_html__('Title', 'wefix-pro'),
                'default'     => '',
				'description' => esc_html__('Put the image title on preview.', 'wefix-pro'),
            ) );

            $this->add_control( 'align', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Alignment', 'wefix-pro'),
                'default' => 'alignnone',
                'options' => array(
                    'alignnone'   => esc_html__('None', 'wefix-pro'),
                    'alignleft'	  => esc_html__('Left', 'wefix-pro'),
                    'aligncenter' => esc_html__('Center', 'wefix-pro'),
                    'alignright'  => esc_html__('Right', 'wefix-pro'),
                ),
            ) );

            $this->add_control( 'class', array(
                'type'        => Controls_Manager::TEXT,
                'label'       => esc_html__('Extra class name', 'wefix-pro'),
                'description' => esc_html__('Style particular element differently - add a class name and refer to it in custom CSS', 'wefix-pro')
            ) );

        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        extract($settings);

        $image = wp_get_attachment_image( $url['id'], 'full' );
        $lurl = wp_get_attachment_image_url( $url['id'], 'full' );
        $url = $image;

		if( !empty( $url ) ):
			if( !empty($class) ):
				$url = str_replace(' class="', ' class="'.$class.' ', $url);
			endif;

			if( !empty($align) ):
				$url = str_replace(' class="', ' class="'.$align.' ', $url);
			endif;

            #if( get_option('elementor_global_image_lightbox') ) :
                echo '<a href="'.$lurl.'" title="'.$title.'">'.$url.'</a>';
            #else:
            #    echo '<a href="'.$lurl.'" title="'.$title.'" class="lightbox-preview-img">'.$url.'</a>';
            #endif;
		endif;
	}

}