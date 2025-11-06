<div class="side-navigation <?php echo esc_attr($classes); ?>">
    <div class="side-nav-container">
        <ul class="side-nav"><?php
            $args   = array('child_of' => $id,'title_li' => '','sort_order'=> 'ASC','sort_column' => 'menu_order');
            $parent = wp_get_post_parent_id( $id );

            if( $parent ) {
                $args = array('child_of' => $parent,'title_li' => '','sort_order'=> 'ASC','sort_column' => 'menu_order');
            }

            $pages = get_pages( $args );
            $ids   = array();

            foreach($pages as $page) {
                $ids[] = $page->ID;
            }

            $css = '';
            foreach( $ids as $pid ) {
                $title     = get_the_title($pid);
                $permalink = get_permalink( $pid );
                $current   = ( $id ===  $pid) ? "current_page_item" : "";

                echo '<li class="side-nav-page-'.esc_attr($pid).' '.esc_attr( $current ).'">';
                    echo '<a href="'.esc_url( $permalink ).'">';
                        echo esc_html( $title );
                    echo '</a>';
                echo '</li>';

                $settings = get_post_meta( $pid, '_wefix_sidenav_settings', true );
                $settings = is_array( $settings ) ? array_filter( $settings ) : array();
                $icon_prefix = isset( $settings['icon_prefix'] ) ? wp_get_attachment_image_src( $settings['icon_prefix'], 'full' ) : false;
                if(isset($settings['style']) && $settings['style'] == 'type4' && $icon_prefix) {
                    $css .= '.side-navigation.type4 ul.side-nav li.side-nav-page-'.esc_attr($pid).' a:before {';
                        $css .= 'mask-image:url('.esc_url($icon_prefix[0]).');';
                        $css .= '-webkit-mask-image:url('.esc_url($icon_prefix[0]).');';
                    $css .= '}';
                }

            }
            ?>
        </ul>
    </div><?php

    if($css != '') {
        echo '<style type="text/css">'.$css.'</style>';
    }

    if( !empty( $show_content ) && !empty( $content_id ) ){
        if( class_exists( '\Elementor\Plugin' ) ) {
            $elementor_instance = Elementor\Plugin::instance();

            if( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
                $css_file = new \Elementor\Core\Files\CSS\Post( $content_id );
                $css_file->enqueue();
            }

            if( !empty( $elementor_instance ) ) {
                echo wefix_html_output($elementor_instance->frontend->get_builder_content_for_display( $content_id ));
            }

        } else {
            $content = get_the_content( '', false, $content_id );
            echo do_shortcode( $content );
        }
    }?>
</div>