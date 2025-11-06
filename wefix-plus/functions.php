<?php

if( !function_exists('wefix_plus_get_template_plugin_part') ) {
    function wefix_plus_get_template_plugin_part( $file_path, $module, $template, $slug ) {

        $html             = '';
        $template_path    = WEFIX_PLUS_DIR_PATH . 'modules/' . esc_attr($module);
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
    add_filter( 'wefix_get_template_plugin_part', 'wefix_plus_get_template_plugin_part', 10, 4 );
}

if( !function_exists( 'wefix_customizer_panel_priority' ) ) {
    /**
     *  Get : Customizer Panel Priority based on panel name.
     */
    function wefix_customizer_panel_priority( $panel ) {
        $priority = 10;

        switch( $panel ) {

            case 'general':
                $priority = 10;
            break;

            case 'idenity':
                $priority = 15;
            break;

            case 'breadcrumb':
                $priority = 20;
                break;

            case 'header':
                $priority = 40;
            break;

            case 'typography':
                $priority = 50;
            break;

            case 'blog':
                $priority = 52;
            break;

            case 'hooks':
                $priority = 55;
            break;

            case 'layout':
                $priority = 65;
            break;

            case '404':
                $priority = 60;
            break;

            case 'skin':
                $priority = 70;
            break;

            case 'sidebar':
                $priority = 100;
            break;

            case 'standard-footer':
                $priority = 130;
            break;

            case 'js':
                $priority = 150;
            break;

            case 'woocommerce':
                $priority = 160;
            break;


        }

        return apply_filters( 'wefix_customizer_panel_priority', $priority, $panel );
    }
}

if( !function_exists( 'wefix_customizer_settings' ) ) {
    /**
     * Get : Customizer settings value
     */
    function wefix_customizer_settings( $option ) {
        $settings = get_option( WEFIX_CUSTOMISER_VAL, array() );
        $settings = isset( $settings[ $option ] ) ? $settings[ $option ] : false;
        return $settings;
    }
}

if( !function_exists( 'wefix_customizer_dynamic_style') ) {
    /**
     * Get : Generate style based on selector and property
     */
    function wefix_customizer_dynamic_style( $selectors, $properties ) {
        $output = '';
        if( !empty( $selectors ) && !empty( $properties ) ) {
            if( is_array( $selectors ) ) {
                $output .= implode( ', ', $selectors );
            }else {
                $output .= $selectors;
            }

            $output .= ' { ' . wefix_html_output($properties) . ' } ' . "\n";
        }
        return $output;
    }
}


if( !function_exists( 'wefix_customizer_responsive_typography_settings' ) ) {

    /**
     * Get : Typography Responsive CSS based on option and responsive mode.
     */
    function wefix_customizer_responsive_typography_settings( $option, $mode = 'tablet' ) {
        $css = '';

        $font_size      = 'fs-'.esc_attr($mode);
        $line_height    = 'lh-'.esc_attr($mode);
        $letter_spacing = 'ls-'.esc_attr($mode);

        if( isset( $option[ $font_size ] ) && !empty( $option[ $font_size ] ) ) {
            $css .= 'font-size:'.esc_attr($option[$font_size].$option[$font_size.'-unit']).';';
        }

        if( isset( $option[ $line_height ] ) && !empty( $option[ $line_height ] ) ) {
            $css .= 'line-height:'.esc_attr($option[$line_height].$option[$line_height.'-unit']).';';
        }

        if( isset( $option[ $letter_spacing ] ) && !empty( $option[ $letter_spacing ] ) ) {
            $css .= 'letter-spacing:'.esc_attr($option[$letter_spacing].$option[$letter_spacing.'-unit']).';';
        }

        return $css;
    }
}


if( !function_exists( 'wefix_customizer_typography_settings' ) ) {
    /**
     * Get : Typography CSS based on option.
     */
    function wefix_customizer_typography_settings( $option ) {
        $option = is_array( $option ) ? array_filter( $option ) : array();

        $css = '';

        if( isset( $option['font-fallback'] ) && !empty( $option['font-fallback'] ) ) {
            $css .= 'font-family: '.$option['font-fallback'].';';
        } else if( isset( $option['font-family'] ) && !empty( $option['font-family'] ) ) {
            $css .= 'font-family:"'.esc_attr($option['font-family']).'"';
            if( isset( $option['font-family-fallback'] ) && !empty( $option['font-family-fallback'] ) ) {
                $css .= ','.esc_attr($option['font-family-fallback']).';';
            }
        }

        if( isset( $option['font-weight'] ) && !empty( $option['font-weight'] ) ) {
            $css .= 'font-weight:'.esc_attr($option['font-weight']).';';
        }

        if( isset( $option['font-style'] ) && !empty( $option['font-style'] ) ) {
            $css .= 'font-style:'.esc_attr($option['font-style']).';';
        }

        if( isset( $option['text-transform'] ) && !empty( $option['text-transform'] ) ) {
            $css .= 'text-transform:'.esc_attr($option['text-transform']).';';
        }

        if( isset( $option['text-align'] ) && !empty( $option['text-align'] ) ) {
            $css .= 'text-align:'.esc_attr($option['text-align']).';';
        }

        if( isset( $option['text-decoration'] ) && !empty( $option['text-decoration'] ) ) {
            $css .= 'text-decoration:'.esc_attr($option['text-decoration']).';';
        }

        if( isset( $option['fs-desktop'] ) && !empty( $option['fs-desktop'] ) ) {
            $css .= 'font-size:'.esc_attr($option['fs-desktop'].$option['fs-desktop-unit']).';';
        }

        if( isset( $option['lh-desktop'] ) && !empty( $option['lh-desktop'] ) ) {
            $css .= 'line-height:'.esc_attr($option['lh-desktop']);
            if(isset($option['lh-desktop-unit'])) {
                $css .= $option['lh-desktop-unit'];
            }
            $css .= ';';
        }

        if( isset( $option['ls-desktop'] ) && !empty( $option['ls-desktop'] ) ) {
            $css .= 'letter-spacing:'.esc_attr($option['ls-desktop'].$option['ls-desktop-unit']).';';
        }

        return $css;
    }
}

if( !function_exists( 'wefix_customizer_frontend_font' ) ) {
    /**
     * Load fonts in frontend
     */
    function wefix_customizer_frontend_font( $settings, $fonts ) {
        $font = '';

        $font_keys = array ();
        if(is_array($fonts) && !empty($fonts)) {
            $font_keys = array_map(function($font_item) {
                return explode(':', $font_item)[0];
            }, $fonts);
        }

        if( isset( $settings['font-family'] ) ){
            $font_key = explode(':', $settings['font-family'])[0];
            if(!in_array($font_key, $font_keys)) {
                $font .= $settings['font-family'];
                $font .= isset( $settings['font-weight'] ) && ( $settings['font-weight'] !== 'inherit' )  ? ':'.esc_attr($settings['font-weight']) : '';
            }
        }

        if( !empty( $font ) ) {
            array_push( $fonts, $font );
        }

        return $fonts;
    }
}

if( !function_exists( 'wefix_customizer_color_settings' ) ) {
    function wefix_customizer_color_settings( $color ) {
        $css = '';

        if( !empty( $color ) ) {
            $css .= 'color:'.esc_attr($color).';';
        }

        return $css;
    }
}

if( !function_exists( 'wefix_customizer_bg_color_settings' ) ) {
    function wefix_customizer_bg_color_settings( $color ) {
        $css = '';

        if( !empty( $color ) ) {
            $css .= 'background-color:'.esc_attr($color).';';
        }

        return $css;
    }
}

if( !function_exists( 'wefix_customizer_bg_settings' ) ) {
    function wefix_customizer_bg_settings( $bg ) {
        $css = '';

        $css .= !empty($bg['background-image']) ? 'background-image: url("'.esc_attr($bg['background-image']).'");':'';
        $css .= (!empty($bg['background-image']) && !empty($bg['background-attachment'])) ? 'background-attachment:'.esc_attr($bg['background-attachment']).';':'';
        $css .= (!empty($bg['background-image']) && !empty($bg['background-position'])) ? 'background-position:'.esc_attr($bg['background-position']).';':'';
        $css .= (!empty($bg['background-image']) && !empty($bg['background-size'])) ? 'background-size:'.esc_attr($bg['background-size']).';':'';
        $css .= (!empty($bg['background-image']) && !empty($bg['background-repeat'])) ? 'background-repeat:'.esc_attr($bg['background-repeat']).';':'';

        if(isset($bg['breadcrumb_overlay_bg_color']) && $bg['breadcrumb_overlay_bg_color'] == true) {

            $gradient_background_color = (isset($bg['gradient-background-color']) && !empty($bg['gradient-background-color'])) ? $bg['gradient-background-color'] : false;
            $background_color = (isset($bg['background-color']) && !empty($bg['background-color'])) ? $bg['background-color'] : false;

            if($gradient_background_color && $background_color) {
                $css .= 'background-image: linear-gradient(180deg, '.$gradient_background_color.' 0%, '.$background_color.' 100%);';
            } else if($gradient_background_color) {
                $css .= 'background-image: linear-gradient(180deg, transparent 0%, '.$gradient_background_color.' 100%);';
            } else if($background_color) {
                $css .= 'background-image: linear-gradient(180deg, transparent 0%, '.$background_color.' 100%);';
            }
            $css .= 'opacity:0.5;';

        } else if((isset($bg['background-color']) && !empty($bg['background-color']))) {
            $css .= 'background-color:'.esc_attr($bg['background-color']).';';
        }

        return $css;
    }
}

# Field Sanitization
if(!function_exists('wefix_sanitization')) {
	function wefix_sanitization($data) {
		if ( is_array( $data ) && !empty( $data ) ) {
			foreach ( $data as $key => &$value ) {
				if ( is_array( $value ) ) {
					$data[$key] = wefix_sanitization($value);
				} else {
					$data[$key] = sanitize_text_field( $value );
				}
			}
		}
		else {
			$data = sanitize_text_field( $data );
		}
    	return $data;
    }
}

# Filter HTML Output
if(!function_exists('wefix_html_output')) {
	function wefix_html_output( $html ) {
		return apply_filters( 'wefix_html_output', $html );
	}
}

# SVG file upload compatability
if(!function_exists('add_fonts_to_allowed_mimes')) {
    function add_fonts_to_allowed_mimes($mimes) {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }
    add_filter( 'upload_mimes', 'add_fonts_to_allowed_mimes', 10, 1 );
}