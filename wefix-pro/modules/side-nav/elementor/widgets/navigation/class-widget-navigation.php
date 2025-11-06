<?php
use WeFixElementor\Widgets\WeFixElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Elementor_Side_Nav_Navigation extends WeFixElementorWidgetBase {

    public function get_name() {
        return 'wdt-side-nav-navigation';
    }

    public function get_title() {
        return esc_html__('Side Nav - Navigation', 'wefix-pro');
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

		$output = '';

        global $post;
        $page_id =  $post->ID;

        $args   = array('child_of' => $page_id,'title_li' => '','sort_order'=> 'ASC','sort_column' => 'menu_order');
        $parent = wp_get_post_parent_id( $page_id );

        if( $parent ) {
            $args = array('child_of' => $parent,'title_li' => '','sort_order'=> 'ASC','sort_column' => 'menu_order');
        }

        $pages = get_pages( $args );
        $page_ids = array();

        foreach($pages as $page) {
            $page_ids[] = $page->ID;
        }

        $key = array_search ($page_id, $page_ids);
        $prev_page_key = $this->get_previous_key_array($page_ids, $key);
        $prev_page_id = isset($page_ids[$prev_page_key]) ? $page_ids[$prev_page_key] : -1;
        $next_page_key = $this->get_next_key_array($page_ids, $key);
        $next_page_id = isset($page_ids[$next_page_key]) ? $page_ids[$next_page_key] : -1;

        $output .= '<div class="wdt-sidenav-navigation-container '.esc_attr( $el_class ).'">';

            if($prev_page_id >= 0) {

                $output .= '<div class="wdt-sidenav-navigation-prev-wrapper">';
                    if(has_post_thumbnail($prev_page_id)) {
                        $url = get_the_post_thumbnail_url($prev_page_id, 'full');
                        $output .= '<a href="'.get_permalink($prev_page_id).'" style="background-image:url('.esc_url($url).');" class="wdt-sidenav-navigation-prev-bgimg"></a>';
                    }
                    $output .= '<div class="wdt-sidenav-navigation-title-wrapper">';
                        $output .= '<p><a href="'.get_permalink($prev_page_id).'" title="'.esc_attr(get_the_title($prev_page_id)).'">'.esc_html__('Previous Page','wefix-pro').'</a></p>';
                        $output .= '<span class="zmdi zmdi-long-arrow-left zmdi-hc-fw"></span>';
                        $output .= '<h3><a href="'.get_permalink($prev_page_id).'" title="'.esc_attr(get_the_title($prev_page_id)).'">';
                            if(get_the_title($prev_page_id)) {
                                $output .= (get_the_title($prev_page_id));
                            } else {
                                $output .= esc_html__('Previous Page', 'wefix-pro');
                            }
                        $output .= '</a></h3>';
                    $output .= '</div>';
                $output .= '</div>';

            } else {

                $output .= '<div class="wdt-sidenav-navigation-prev-wrapper no-post">';
                    $output .= '<a href="#" style="background-image:url('.esc_url(WEFIX_ROOT_URI.'/assets/images/no-post.jpg').');" class="wdt-sidenav-navigation-prev-bgimg"></a>';
                    $output .= '<div class="wdt-sidenav-navigation-title-wrapper">';
                        $output .= '<span class="zmdi zmdi-long-arrow-left zmdi-hc-fw"></span>';
                        $output .= '<h3>'.esc_html__('No previous page to show!', 'wefix-pro').'</h3>';
                    $output .= '</div>';
                $output .= '</div>';

            }

            if($next_page_id >= 0) {

                $output .= '<div class="wdt-sidenav-navigation-next-wrapper">';
                    if(has_post_thumbnail($next_page_id)) {
                        $url = get_the_post_thumbnail_url($next_page_id, 'full');
                        $output .= '<a href="'.get_permalink($next_page_id).'" style="background-image:url('.esc_url($url).')" class="wdt-sidenav-navigation-next-bgimg"></a>';
                    }
                    $output .= '<div class="wdt-sidenav-navigation-title-wrapper">';
                        $output .= '<p><a href="'.get_permalink($next_page_id).'" title="'.esc_attr(get_the_title($next_page_id)).'">'.esc_html__('Next Page','wefix-pro').'</a></p>';
                        $output .= '<span class="zmdi zmdi-long-arrow-left zmdi-hc-fw"></span>';
                        $output .= '<h3><a href="'.get_permalink($next_page_id).'" title="'.esc_attr(get_the_title($next_page_id)).'">';
                            if(get_the_title($next_page_id)) {
                                $output .= (get_the_title($next_page_id));
                            } else {
                                $output .= esc_html__('Next Page', 'wefix-pro');
                            }
                        $output .= '</a></h3>';
                    $output .= '</div>';
                $output .= '</div>';

            } else {

                $output .= '<div class="wdt-sidenav-navigation-next-wrapper no-post">';
                    $output .= '<a href="#" style="background-image:url('.esc_url(WEFIX_ROOT_URI.'/assets/images/no-post.jpg').');"  class="wdt-sidenav-navigation-next-bgimg"></a>';
                    $output .= '<div class="wdt-sidenav-navigation-title-wrapper">';
                        $output .= '<span class="zmdi zmdi-long-arrow-left zmdi-hc-fw"></span>';
                        $output .= '<h3>'.esc_html__('No next page to show!', 'wefix-pro').'</h3>';
                    $output .= '</div>';
                $output .= '</div>';

            }

        $output .= '</div>';

		echo $output;

	}

    protected function get_next_key_array($array, $key) {
        $nextKey = -1;
        $keys = array_keys($array);
        $position = array_search($key, $keys);
        if (isset($keys[$position + 1])) {
            $nextKey = $keys[$position + 1];
        }
        return $nextKey;
    }

    protected function get_previous_key_array($array, $key) {
        $previousKey = -1;
        $keys = array_keys($array);
        $position = array_search($key, $keys);
        if (isset($keys[$position - 1])) {
            $previousKey = $keys[$position - 1];
        }
        return $previousKey;
    }

}