<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
	if( has_post_thumbnail( $post_ID ) ) :
		if( $enable_image_lightbox ):
			if( get_option('elementor_global_image_lightbox') ) : ?>
            	<a href="<?php echo get_the_post_thumbnail_url( $post_ID, 'full' );?>" title="<?php the_title_attribute();?>"><?php
            else: ?>
            	<a href="<?php echo get_the_post_thumbnail_url( $post_ID, 'full' );?>" title="<?php the_title_attribute();?>" class="mag-pop"><?php
            endif;
            	echo get_the_post_thumbnail( $post_ID, 'full' ); ?>
            </a><?php
		else:
    		echo get_the_post_thumbnail( $post_ID, 'full' );
		endif;
	endif;
?>