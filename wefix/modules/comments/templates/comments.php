<div id="comments" class="comments-area">
<?php
    if ( have_comments() ) {
        echo '<h3>';
            comments_number(esc_html__('No Comments','wefix'), esc_html__('1 Comments','wefix'), esc_html__('% Comments','wefix') );
        echo '</h3>';

        the_comments_navigation();

        echo '<ul class="commentlist">';
            wp_list_comments( array( 'avatar_size' => 50 ) );
        echo '</ul>';

        the_comments_navigation();
    }

    if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) {
        echo '<p class="nocomments">';
            esc_html_e( 'Comments are closed.','wefix');
        echo '</p>';
    }

    comment_form( apply_filters('wefix_comment_form_args', array() ) );?>
</div>