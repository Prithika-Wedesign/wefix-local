<?php
use WeFixElementor\Widgets\WeFixElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Elementor_Post_Meta_Group extends WeFixElementorWidgetBase {

    public function get_name() {
        return 'wdt-post-meta-group';
    }

    public function get_title() {
        return esc_html__('Post - Meta Group', 'wefix-pro');
    }

    protected function register_controls() {

        $this->start_controls_section( 'wdt_section_general', array(
            'label' => esc_html__( 'General', 'wefix-pro'),
        ) );

            $content = new Repeater();
            $content->add_control( 'element_value', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Element', 'wefix-pro'),
                'default' => 'author',
                'options' => array(
                    'author'      => esc_html__('Author', 'wefix-pro'),
                    'date'        => esc_html__('Date', 'wefix-pro'),
                    'comment'     => esc_html__('Comments', 'wefix-pro'),
                    'category'    => esc_html__('Categories', 'wefix-pro'),
                    'tag'         => esc_html__('Tags', 'wefix-pro'),
                    'social'      => esc_html__('Social Share', 'wefix-pro'),
                    'likes_views' => esc_html__('Likes & Views', 'wefix-pro'),
                ),
            ) );

            $this->add_control( 'blog_meta_position', array(
                'type'        => Controls_Manager::REPEATER,
                'label'       => esc_html__('Meta Group Positioning', 'wefix-pro'),
                'fields'      => array_values( $content->get_controls() ),
                'default'     => array(
                    array( 'element_value' => 'author' ),
                ),
                'title_field' => '{{{ element_value.replace( \'_\', \' \' ).replace( /\b\w/g, function( letter ){ return letter.toUpperCase() } ) }}}'
            ) );

            $this->add_control( 'style', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Style', 'wefix-pro'),
                'default' => 'metagroup-space-separator',
                'options' => array(
                    'metagroup-space-separator'  => esc_html__('Space', 'wefix-pro'),
                    'metagroup-slash-separator'  => esc_html__('Slash', 'wefix-pro'),
                    'metagroup-vertical-separator'  => esc_html__('Vertical', 'wefix-pro'),
                    'metagroup-horizontal-separator'  => esc_html__('Horizontal', 'wefix-pro'),
                    'metagroup-dot-separator'  => esc_html__('Dot', 'wefix-pro'),
                    'metagroup-comma-separator'  => esc_html__('Comma', 'wefix-pro'),
                    'metagroup-elements-boxed'  => esc_html__('Boxed', 'wefix-pro'),
                    'metagroup-elements-boxed-curvy'  => esc_html__('Boxed Curvy', 'wefix-pro'),
                    'metagroup-elements-boxed-round'  => esc_html__('Boxed Round', 'wefix-pro'),
                    'metagroup-elements-filled'  => esc_html__('Filled', 'wefix-pro'),
                    'metagroup-elements-filled-curvy'  => esc_html__('Filled Curvy', 'wefix-pro'),
                    'metagroup-elements-filled-round'  => esc_html__('Filled Round', 'wefix-pro'),
                ),
                'description' => esc_html__('Select any one of meta group styling.', 'wefix-pro'),
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

		$newMEles = array();
		$meta_group_position = !empty( $blog_meta_position ) ? $blog_meta_position : explode( ',', $blog_meta_position );

		if( is_array( $meta_group_position[0] ) ) {
			foreach($meta_group_position as $key => $items) {
				$newMEles[$items['element_value']] = $items['element_value'];
			}
		} else {
			foreach($meta_group_position as $item) {
				$newMEles[$item] = $item;
			}
		}

		if( count( $newMEles ) >= 1 ) {

			$out .= '<div class="wdt-posts-meta-group '.$style.' '.$el_class.'">';

                $Post_Style = wefix_get_single_post_style( $post_id );

                $template_args['post_ID'] = $post_id;
                $template_args['post_Style'] = $Post_Style;
                $template_args = array_merge( $template_args, wefix_single_post_params() );

				foreach( $newMEles as $value ):

                    switch( $value ):

                        case 'likes_views':
                        case 'social':
                            $out .= wefix_get_template_part( 'post', 'templates/post-extra/'.$value, '', $template_args );
                            break;

                        default:
                            $out .= wefix_get_template_part( 'post', 'templates/'.$Post_Style.'/parts/'.$value, '', $template_args );
                            break;

                    endswitch;

				endforeach;

			$out .= '</div>';
		}

		echo $out;
    }

}