<?php
use WeFixElementor\Widgets\WeFixElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Elementor_Post_Title extends WeFixElementorWidgetBase {

    public function get_name() {
        return 'wdt-post-title';
    }

    public function get_title() {
        return esc_html__('Post - Title', 'wefix-pro');
    }

    protected function register_controls() {

        $this->start_controls_section( 'wdt_section_general', array(
            'label' => esc_html__( 'General', 'wefix-pro'),
        ) );

            $this->add_control( 'el_class', array(
                'type'        => Controls_Manager::TEXT,
                'label'       => esc_html__('Extra class name', 'wefix-pro'),
                'description' => esc_html__('Style particular element differently - add a class name and refer to it in custom CSS', 'wefix-pro')
            ) );

        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        extract($settings);

		$out = '';

        global $post;
        $post_id =  $post->ID;

        $template_args['post_ID'] = $post_id;

		$out .= '<div class="entry-title-wrapper '.$el_class.'">';
            $out .= wefix_get_template_part( 'post', 'templates/post-extra/title', '', $template_args );
		$out .= '</div>';

		echo $out;
	}

}