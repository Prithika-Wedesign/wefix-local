<?php
if ( post_password_required() || !post_type_supports( get_post_type(), 'comments' ) ) {
	return;
}

if ( comments_open() || get_comments_number() ) {

    do_action( 'wefix_comments_template' );
}?>