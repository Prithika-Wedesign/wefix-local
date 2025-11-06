<?php
add_action( 'wefix_after_main_css', 'footer_style' );
function footer_style() {
    wp_enqueue_style( 'wefix-footer', get_theme_file_uri('/modules/footer/assets/css/footer.css'), false, WEFIX_THEME_VERSION, 'all');
}

add_action( 'wefix_footer', 'footer_content' );
function footer_content() {
    wefix_template_part( 'content', 'content', 'footer' );
}