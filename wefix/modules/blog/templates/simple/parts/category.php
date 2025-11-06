<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<!-- Entry Categories -->
<div class="entry-categories"><?php
	$cats = wp_get_post_categories($post_ID);
	if( !empty($cats) ):
		$count = count($cats);
		$out = '';
		foreach( $cats as $key => $cat_id ) {
			$term = get_term( $cat_id, 'category' );
			if ( is_wp_error( $term ) ) {
				continue;
			}
			$meta  = get_term_meta( $term->term_id, '_wefix_post_category_options', true );
			$color = isset( $meta['category-color'] ) ? $meta['category-color'] : '';
	
			$out .= '<a href="'.get_term_link( $term->slug ,'category').'" style="color:'.esc_attr($color).'">'.esc_html( $term->name ).'</a>';
			$key += 1;
	
			if( $key !== $count ){
				$out .= ' ';
			}
		}
		echo wefix_html_output($out);
	endif; ?></div><!-- Entry Categories -->