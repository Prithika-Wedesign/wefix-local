<?php
	$template_args['post_ID'] = $ID;
	$template_args['post_Style'] = $Post_Style;
	$template_args = array_merge( $template_args, wefix_single_post_params() ); ?>

	<!-- Post Header -->
	<div class="post-header">

		<div class="post-header-wrapper">
			<?php wefix_template_part( 'post', 'templates/'.$Post_Style.'/parts/category', '', $template_args ); ?>
			<?php wefix_template_part( 'post', 'templates/'.$Post_Style.'/parts/date', '', $template_args ); ?>
		</div>
	   	<?php if( $template_args['enable_title'] ) : ?>
		        <?php wefix_template_part( 'post', 'templates/'.$Post_Style.'/parts/title', '', $template_args ); ?>
		<?php endif; ?>

		<?php wefix_template_part( 'post', 'templates/'.$Post_Style.'/parts/image', '', $template_args ); ?>

	</div><!-- Post Header -->

    <!-- Post Dynamic -->
    <?php echo apply_filters( 'wefix_single_post_dynamic_template_part', wefix_get_template_part( 'post', 'templates/'.$Post_Style.'/parts/dynamic', '', $template_args ) ); ?><!-- Post Dynamic -->