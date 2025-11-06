<?php

if( !function_exists('wefix_pro_get_template_plugin_part') ) {
    function wefix_pro_get_template_plugin_part( $file_path, $module, $template, $slug ) {

        $html             = '';
        $template_path    = WEFIX_PRO_DIR_PATH . 'modules/' . esc_attr($module);
        $temp_path        = $template_path . '/' . esc_attr($template);
        $plugin_file_path = '';

        if ( ! empty( $temp_path ) ) {
            if ( ! empty( $slug ) ) {
                $plugin_file_path = "{$temp_path}-{$slug}.php";
                if ( ! file_exists( $plugin_file_path ) ) {
                    $plugin_file_path = $temp_path . '.php';
                }
            } else {
                $plugin_file_path = $temp_path . '.php';
            }
        }

        if ( $plugin_file_path && file_exists( $plugin_file_path ) ) {
            return $plugin_file_path;
        }

        return $file_path;

    }
    add_filter( 'wefix_get_template_plugin_part', 'wefix_pro_get_template_plugin_part', 20, 4 );
}

if( !function_exists('wefix_pro_before_after_widget') ) {
    function wefix_pro_before_after_widget ( $content ) {
        $allowed_html = array(
            'aside' => array(
                'id'    => array(),
                'class' => array()
            ),
            'div' => array(
                'id'    => array(),
                'class' => array(),
            )
        );

        $data = wp_kses( $content, $allowed_html );

        return $data;
    }
}

if( !function_exists('wefix_pro_widget_title') ) {
    function wefix_pro_widget_title( $content ) {

        $allowed_html = array(
            'div' => array(
                'id'    => array(),
                'class' => array()
            ),
            'h2' => array(
                'class' => array()
            ),
            'h3' => array(
                'class' => array()
            ),
            'h4' => array(
                'class' => array()
            ),
            'h5' => array(
                'class' => array()
            ),
            'h6' => array(
                'class' => array()
            ),
            'span' => array(
                'id'    => array(),
                'class' => array()
            ),
            'p' => array(
                'id'    => array(),
                'class' => array()
            ),
        );

        $data = wp_kses( $content, $allowed_html );

        return $data;
    }
}

/** Function for Enabling Header and Footer Options in Elementor -> Settings */
if( !function_exists('wefix_custom_post_type_elementor_support') ) {
    function wefix_custom_post_type_elementor_support() {
      
        $custom_post_types = array('wdt_headers', 'wdt_footers');
     
        $elementor_supported_post_types = get_option('elementor_cpt_support', array('page', 'post'));
        
        $supported_post_types = array_merge($elementor_supported_post_types, $custom_post_types);
        $supported_post_types = array_unique($supported_post_types);
        
        update_option('elementor_cpt_support', $supported_post_types);
    }
}
add_action('init', 'wefix_custom_post_type_elementor_support');

# Filter HTML Output
if(!function_exists('wefix_html_output')) {
	function wefix_html_output( $html ) {
		return apply_filters( 'wefix_html_output', $html );
	}
}


/**
 * Returns string for time duration.
 */
if ( ! function_exists( 'wefix_pro_duration_to_string' ) ) {
	
    function wefix_pro_duration_to_string( $duration ) {
        
        if ( !is_numeric( $duration ) || $duration < 0 ) {
            return ''; 
        }

        $hours   = (int)( $duration / 3600 );
        $minutes = (int)( ( $duration % 3600 ) / 60 );
        $result  = '';

        if ( $hours > 0 ) {
            $result = ( $hours == 1 ) ? sprintf( esc_html__( '%d hr', 'wefix-pro' ), $hours ) : sprintf( esc_html__( '%d hrs', 'wefix-pro' ), $hours );
            if ( $minutes > 0 ) {
                $result .= ' ';
            }
        }

        if ( $minutes > 0 ) {
            $result .= sprintf( esc_html__( '%d mins', 'wefix-pro' ), $minutes );
        }

        return $result;
    }
}

if ( ! function_exists( 'wefix_get_registration_template_url' ) ) {
	function wefix_get_registration_template_url() {
		$args = array(
			'post_type'      => 'page',
			'posts_per_page' => 1,
			'meta_key'       => '_wp_page_template',
			'meta_value'     => 'tpl-registration.php',
			'post_status'    => 'publish',
		);
		$pages = get_posts($args);
		if (!empty($pages)) {
			return get_permalink($pages[0]->ID);
		}
		return false;
	}
}

