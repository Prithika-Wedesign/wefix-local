<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
	$template_args['post_ID'] = $post_ID;
	$template_args = array_merge( $template_args, wefix_single_post_params() );

    foreach ( $post_dynamic_elements as $key => $value ) {

		switch( $value ) {

			case 'title':
			case 'content':
			case 'comment_box':
			case 'navigation':
			case 'likes_views':
			case 'related_posts':
			case 'social':
				wefix_template_part( 'post', 'templates/post-extra/'.$value, '', $template_args );
				break;

			default:
				wefix_template_part( 'post', 'templates/'.$post_Style.'/parts/'.$value, '', $template_args );
				break;
		}
	}