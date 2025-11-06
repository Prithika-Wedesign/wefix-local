<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
if(  ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
	<!-- Entry Comment -->
		<div class="single-entry-comments">
		<div class="comment-wrap"><?php
			comments_popup_link(
				esc_html__('No Comments', 'wefix-pro'),
				esc_html__('1 Comment', 'wefix-pro'),
				esc_html__('% Comments', 'wefix-pro'),
				'',
				esc_html__('Comments Off', 'wefix-pro')
			); ?>
		</div>
	</div><!-- Entry Comment --><?php
}
?>