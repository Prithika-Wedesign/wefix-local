<?php

if( !function_exists('wefix_archive_blog_post_defaults') ) {
    function wefix_archive_blog_post_defaults() {
        $defaults = array(
            'post-layout'      => 'entry-grid',
            'post-gl-style'    => 'wdt-simple',
            'list-type'        => 'entry-left-thumb',
            'hover-style'      => 'wdt-scaleout',
            'overlay-style'    => 'wdt-default',
            'post-align'       => 'alignnone',
            'post-column'      => 'one-half-column'
        );

        return $defaults;
    }
}

if( !function_exists('wefix_archive_blog_post_misc_defaults') ) {
    function wefix_archive_blog_post_misc_defaults() {
        $defaults = array(
            'enable-equal-height' => 0,
            'enable-no-space' => 0
        );

        return $defaults;
    }
}

if( !function_exists('wefix_archive_blog_post_params_default') ) {
    function wefix_archive_blog_post_params_default() {
        $params = array(
            'enable_video_audio' 	 => 0,
            'enable_gallery_slider'  => 0,
            'archive_media_elements' => array('feature_image','date'),
            'archive_post_elements'  => array('meta_group', 'title', 'read_more' ),
            'archive_meta_elements'  => array('category', 'author' ),
            'archive_readmore_text'  => esc_html__('Read More', 'wefix'),
            'enable_excerpt_text'	 => 0,
            'archive_excerpt_length' => 60,
            'archive_blog_pagination'=> 'pagination-numbered',
            'enable_disqus_comments' => 0,
            'post_disqus_shortname'  => ''
        );

        return $params;
    }
}

if( !function_exists('wefix_archive_blog_post_defaults_filter') ) {
    function wefix_archive_blog_post_defaults_filter() {
        $defaults = wefix_archive_blog_post_defaults();
        return apply_filters( 'wefix_archive_post_cmb_class', $defaults );
    }
}

if( !function_exists('wefix_archive_blog_post_misc_defaults_filter') ) {
    function wefix_archive_blog_post_misc_defaults_filter() {
        $defaults = wefix_archive_blog_post_misc_defaults();
        return apply_filters( 'wefix_archive_post_hld_class', $defaults );
    }
}

if( !function_exists('wefix_archive_blog_post_params') ) {
    function wefix_archive_blog_post_params() {
        $params = wefix_archive_blog_post_params_default();
        return apply_filters( 'wefix_archive_blog_post_params', $params );
    }
}

if( !function_exists('wefix_get_archive_post_combine_class') ) {
	function wefix_get_archive_post_combine_class() {

        $blog_defaults = wefix_archive_blog_post_defaults_filter();

		$combine_class[] = '';

		$post_layout = $blog_defaults['post-layout'];
		$combine_class[] = $post_layout.'-layout';
		$combine_class[] = $blog_defaults['post-gl-style'].'-style';

		if( $post_layout == 'entry-list' ) {
			$combine_class[] = $blog_defaults['list-type'];
		}

		$combine_class[] = $blog_defaults['hover-style'].'-hover';
		$combine_class[] = $blog_defaults['overlay-style'].'-overlay';

		if( $post_layout == 'entry-grid') {
			$combine_class[] = $blog_defaults['post-align'];
		}

		$post_columns = $blog_defaults['post-column'];
		// if( $post_layout == 'entry-list' ) {
		// 	$post_columns = 'one-column';
		// }

        switch( $post_columns ):

            default:
			case 'one-column':
				$post_class = "column wdt-one-column wdt-post-entry ";
            break;

            case 'one-half-column':
				$post_class = "column wdt-one-half wdt-post-entry ";
            break;

            case 'one-third-column':
				$post_class = "column wdt-one-third wdt-post-entry ";
            break;

            case 'one-fourth-column':
				$post_class = "column wdt-one-fourth wdt-post-entry ";
            break;
        endswitch;

        $combine_class[] = $post_class;

        return apply_filters( 'wefix_get_archive_post_combine_class', implode( ' ', $combine_class ) );
	}
}

if( !function_exists('wefix_get_archive_post_holder_class') ) {
	function wefix_get_archive_post_holder_class() {

        $blog_defaults = wefix_archive_blog_post_defaults_filter();
        $blog_misc_defaults = wefix_archive_blog_post_misc_defaults_filter();

		$holder_class[] = '';

        $post_layout = $blog_defaults['post-layout'];
        $post_equal_height = $blog_misc_defaults['enable-equal-height'];
        $post_no_space = $blog_misc_defaults['enable-no-space'];

		if( ( $post_layout == 'entry-grid') && $post_equal_height ):
			$holder_class[] = 'apply-equal-height';
		elseif( $post_layout == 'entry-grid'):
			$holder_class[] = 'apply-isotope';
		elseif( $post_layout == 'entry-list' ):
			$holder_class[] = 'apply-isotope';
		endif;

		if( ( $post_layout == 'entry-grid') && $post_no_space ):
			$holder_class[] = 'apply-no-space';
		elseif( $post_layout == 'entry-list' ):
			$holder_class[] = '';
		endif;

        return apply_filters( 'wefix_get_archive_post_holder_class', implode( ' ', $holder_class ) );
	}
}

if( !function_exists('wefix_get_archive_post_style') ) {
	function wefix_get_archive_post_style() {

        $blog_defaults = wefix_archive_blog_post_defaults_filter();

        $post_layout = $blog_defaults['post-layout'];

		$post_style = '';
		if( $post_layout == 'entry-grid'  || $post_layout == 'entry-list' ) {
			$post_style = $blog_defaults['post-gl-style'];
		}

		$post_style = str_replace( 'wdt-', '', $post_style );

		return apply_filters( 'wefix_get_archive_post_style', $post_style );
	}
}

if( !function_exists('wefix_get_archive_post_column') ) {
	function wefix_get_archive_post_column() {

        $blog_defaults = wefix_archive_blog_post_defaults_filter();

		$post_columns = $blog_defaults['post-column'];
		$post_layout = $blog_defaults['post-layout'];

		// if( $post_layout == 'entry-list' ) {
		// 	$post_columns = 'one-column';
		// }

		return apply_filters( 'wefix_get_archive_post_column', $post_columns );
	}
}

add_filter('post_class', 'wefix_archive_set_post_class', 10, 3);
if( !function_exists('wefix_archive_set_post_class') ) {
    function wefix_archive_set_post_class( $classes, $class, $post_id ) {

        if( is_post_type_archive('post') || is_search() || is_category() || is_tag() || is_home() || is_author() || is_year() || is_month() || is_day() || is_time() || is_tax('post_format') || ( defined('DOING_AJAX') && DOING_AJAX ) ) {
			$post_meta = get_post_meta( $post_id, '_wefix_post_settings', TRUE );
			$post_meta = is_array( $post_meta ) ? $post_meta  : array();

            $post_format = !empty( $post_meta['post-format-type'] ) ? $post_meta['post-format-type'] : get_post_format($post_id);
            $classes[] = 'blog-entry';
            $classes[] = !empty( $post_format ) ? 'format-'.$post_format : 'format-standard';

            $blog_params = wefix_archive_blog_post_params();

            if( $blog_params['enable_video_audio'] && ( $post_format === 'video' || $post_format === 'audio' ) ) {
            	$classes[] = 'has-post-media';
            }

            if( get_the_title( $post_id ) == '' ) {
                $classes[] = 'post-without-title';
            }
        }

        return $classes;
    }
}

add_action( 'wefix_after_main_css', 'wefix_blog_enqueue_css', 10 );
if( !function_exists( 'wefix_blog_enqueue_css' ) ) {
	function wefix_blog_enqueue_css() {
		wp_enqueue_style( 'wdt-blog', get_theme_file_uri('/modules/blog/assets/css/blog.css'), false, WEFIX_THEME_VERSION, 'all');

        $post_style = wefix_get_archive_post_style();
        if ( file_exists( get_theme_file_path('/modules/blog/templates/'.$post_style.'/assets/css/blog-archive-'.$post_style.'.css') ) ) {
            wp_enqueue_style( 'wdt-blog-archive-'.$post_style, get_theme_file_uri('/modules/blog/templates/'.$post_style.'/assets/css/blog-archive-'.$post_style.'.css'), false, WEFIX_THEME_VERSION, 'all');
        }

		wp_enqueue_style( 'jquery-bxslider', get_theme_file_uri('/modules/blog/assets/css/jquery.bxslider.css'), false, WEFIX_THEME_VERSION, 'all' );
	}
}

add_action( 'wefix_before_enqueue_js', 'wefix_blog_enqueue_js' );
if( !function_exists( 'wefix_blog_enqueue_js' ) ) {
	function wefix_blog_enqueue_js() {

		wp_enqueue_script('isotope-pkgd', get_theme_file_uri('/modules/blog/assets/js/isotope.pkgd.js'), array(), false, true);
		wp_enqueue_script('matchheight', get_theme_file_uri('/modules/blog/assets/js/matchHeight.js'), array(), false, true);
		wp_enqueue_script('jquery-bxslider', get_theme_file_uri('/modules/blog/assets/js/jquery.bxslider.js'), array(), false, true);
		wp_enqueue_script('jquery-fitvids', get_theme_file_uri('/modules/blog/assets/js/jquery.fitvids.js'), array(), false, true);
		wp_enqueue_script('jquery-debouncedresize', get_theme_file_uri('/modules/blog/assets/js/jquery.debouncedresize.js'), array(), false, true);
	}
}

if( !function_exists( 'after_blog_post_content_pagination' ) ) {
    function after_blog_post_content_pagination() {

    	$pagination_template = wefix_archive_blog_post_params();
    	$pagination_template = $pagination_template['archive_blog_pagination'];

        echo apply_filters( 'wefix_blog_archive_pagination', wefix_get_template_part( 'pagination', 'templates/'.$pagination_template ) );
    }
    add_action( 'wefix_after_blog_post_content_wrap', 'after_blog_post_content_pagination' );
}

if( !function_exists( 'wefix_excerpt' ) ) {
	function wefix_excerpt( $limit = NULL ) {

		$limit = !empty($limit) ? $limit : 10;

		$excerpt = explode(' ', get_the_excerpt(), $limit);
		$excerpt = array_filter($excerpt);

		if (!empty($excerpt)) {
			if (count($excerpt) >= $limit) {
				array_pop($excerpt);
				$excerpt = implode(" ", $excerpt).'...';
			} else {
				$excerpt = implode(" ", $excerpt);
			}
			$excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);
			$excerpt = str_replace('&nbsp;', '', $excerpt);
			if(!empty ($excerpt))
				return "<p>{$excerpt}</p>";
		}
	}
}