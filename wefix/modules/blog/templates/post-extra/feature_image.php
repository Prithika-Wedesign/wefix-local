<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
	$post_meta = get_post_meta( $post_ID, '_wefix_post_settings', TRUE );
	$post_meta = is_array( $post_meta ) ? $post_meta  : array();
	$post_format = !empty( $post_meta['post-format-type'] ) ? $post_meta['post-format-type'] : get_post_format();
	$template_args['post_ID'] = $post_ID;
	$template_args['meta'] = $post_meta;
	$template_args['enable_video_audio'] = $enable_video_audio;
	$template_args['enable_gallery_slider'] = $enable_gallery_slider; ?>

	<!-- Featured Image -->
	<div class="entry-thumb">
		<?php wefix_template_part( 'blog', 'templates/post-format/post', $post_format, $template_args ); ?>
	</div>