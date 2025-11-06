<?php
    get_header();

    echo '<section id="primary" class="' . esc_attr(wefix_get_primary_classes()) . '">';

    do_action('wefix_before_single_page_content_wrap');

    if (have_posts()) :
        while (have_posts()) : the_post();

            echo '<div id="post-' . get_the_ID() . '" class="' . esc_attr(implode(' ', get_post_class())) . '">';

            do_action('wefix_before_single_page_content');

            echo '<div class="wdt_services_single-wrapper">';

                $service_settings = get_post_meta(get_the_ID(), '_wefix_service_settings', true);
                // @Main Content

                    echo '<div class="featured_image_wrap">';

                        if (has_post_thumbnail()) {
                            echo '<div class="services-featured-image">';
                            the_post_thumbnail('large');
                            echo '</div>';
                        }
                    echo '</div>';

                    the_content();

            echo '</div>';

            do_action('wefix_after_single_page_content');

            echo '</div><!-- #post-' . get_the_ID() . ' -->';

        endwhile;
    endif;

    do_action('wefix_after_single_page_content_wrap');

    echo '</section><!-- Primary End -->';
    if ( wefix_get_secondary_classes() !== "content-full-width" && !empty(wefix_get_secondary_classes())){
        echo '<section id="secondary" class="' . esc_attr(wefix_get_secondary_classes()) . '"><div class="wdt-sidebar-wrapper">';
            do_action( 'wefix_before_single_sidebar_wrap' );

            get_sidebar();

            do_action( 'wefix_after_single_sidebar_wrap' );
        echo '</div></section><!-- Secondary End -->';
    }

    get_footer();

?>
