<?php
if ( ! function_exists( 'wefix_template_part' ) ) {
	/**
	 * Function that echo module template part.
	 */
	function wefix_template_part( $module, $template, $slug = '', $params = array() ) {
		echo wefix_get_template_part( $module, $template, $slug, $params );
	}
}

if ( ! function_exists( 'wefix_get_template_part' ) ) {
	/**
	 * Function that load module template part.
	 */
	function wefix_get_template_part( $module, $template, $slug = '', $params = array() ) {
        $file_path = '';
        $html      = '';
        $template_path = WEFIX_MODULE_DIR . '/' . $module;
        $temp_path = $template_path . '/' . $template;
        if ( ! empty( $temp_path ) ) {
            if ( ! empty( $slug ) ) {
                $file_path = "{$temp_path}-{$slug}.php";
                if ( ! file_exists( $file_path ) ) {
                    $file_path = $temp_path . '.php';
                }
            } else {
                $file_path = $temp_path . '.php';
            }
        }
        $file_path = apply_filters( 'wefix_get_template_plugin_part', $file_path, $module, $template, $slug );
        if ( $file_path && file_exists( $file_path ) ) {
            ob_start();
            if ( is_array( $params ) && count( $params ) ) {
                extract( $params, EXTR_SKIP );
            }
            include $file_path;
            $html = ob_get_clean();
        }
        return $html;
    }
}

if ( ! function_exists( 'wefix_get_page_id' ) ) {
	function wefix_get_page_id() {

		$page_id = get_queried_object_id();

		if( is_archive() || is_search() || is_404() || ( is_front_page() && is_home() ) ) {
			$page_id = -1;
		}

		return $page_id;
	}
}

/* Convert hexdec color string to rgb(a) string */
if ( ! function_exists( 'wefix_hex2rgba' ) ) {
	function wefix_hex2rgba($color, $opacity = false) {

		$default = 'rgb(0,0,0)';

		if(empty($color)) {
			return $default;
		}

		if ($color[0] == '#' ) {
			$color = substr( $color, 1 );
		}

		if (strlen($color) == 6) {
				$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) == 3 ) {
				$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
				return $default;
		}

		$rgb =  array_map('hexdec', $hex);

		if($opacity){
			if(abs($opacity) > 1) {
				$opacity = 1.0;
			}
			$output = implode(",",$rgb).','.$opacity;
		} else {
			$output = implode(",",$rgb);
		}

		return $output;

	}
}

if ( ! function_exists( 'wefix_html_output' ) ) {
	function wefix_html_output( $html ) {
		return apply_filters( 'wefix_html_output', $html );
	}
}


if ( ! function_exists( 'wefix_theme_defaults' ) ) {
	/**
	 * Function to load default values
	 */
	function wefix_theme_defaults() {

		$defaults = array (
			'primary_color' => '#EF644C',
			'primary_color_rgb' => wefix_hex2rgba('#EF644C', false),
			'secondary_color' => '#1f1f1f',
			'secondary_color_rgb' => wefix_hex2rgba('#1f1f1f', false),
			'tertiary_color' => '#f6f6f6',
			'tertiary_color_rgb' => wefix_hex2rgba('#f6f6f6', false),
			'body_bg_color' => '#ffffff',
			'body_bg_color_rgb' => wefix_hex2rgba('#ffffff', false),
			'body_text_color' => '#636363',
			'body_text_color_rgb' => wefix_hex2rgba('#636363', false),
			'headalt_color' => '#1f1f1f',
			'headalt_color_rgb' => wefix_hex2rgba('#1f1f1f', false),
			'link_color' => '#1f1f1f',
			'link_color_rgb' => wefix_hex2rgba('#1f1f1f', false),
			'link_hover_color' => '#EF644C',
			'link_hover_color_rgb' => wefix_hex2rgba('#EF644C', false),
			'border_color' => '#dedede',
			'border_color_rgb' => wefix_hex2rgba('#dedede', false),
			'accent_text_color' => '#ffffff',
			'accent_text_color_rgb' => wefix_hex2rgba('#ffffff', false),

			'body_typo' => array (
				'font-family' => "Manrope",
				'font-fallback' => '"Manrope", sans-serif',
				'font-weight' => 500,
				'fs-desktop' => 16,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.6,
				'lh-desktop-unit' => ''
			),
			'h1_typo' => array (
				'font-family' => "Space Grotesk",
				'font-fallback' => '"Space Grotesk", sans-serif',
				'font-weight' => 500,
				'fs-desktop' => 80,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.1,
				'lh-desktop-unit' => ''
			),
			'h2_typo' => array (
				'font-family' => "Space Grotesk",
				'font-fallback' => '"Space Grotesk", sans-serif',
				'font-weight' => 500,
				'fs-desktop' => 60,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.1,
				'lh-desktop-unit' => ''
			),
			'h3_typo' => array (
				'font-family' => "Space Grotesk",
				'font-fallback' => '"Space Grotesk", sans-serif',
				'font-weight' => 500,
				'fs-desktop' => 45,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.2,
				'lh-desktop-unit' => ''
			),
			'h4_typo' => array (
				'font-family' => "Space Grotesk",
				'font-fallback' => '"Space Grotesk", sans-serif',
				'font-weight' => 500,
				'fs-desktop' => 30,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.1,
				'lh-desktop-unit' => ''
			),
			'h5_typo' => array (
				'font-family' => "Space Grotesk",
				'font-fallback' => '"Space Grotesk", sans-serif',
				'font-weight' => 500,
				'fs-desktop' => 24,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.1,
				'lh-desktop-unit' => ''
			),
			'h6_typo' => array (
				'font-family' => "Manrope",
				'font-fallback' => '"Manrope", sans-serif',
				'font-weight' => 600,
				'fs-desktop' => 18,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.15,
				'lh-desktop-unit' => ''
			),
			'extra_typo' => array (
				'font-family' => "Manrope",
				'font-fallback' => '"Manrope", sans-serif',
				'font-weight' => 500,
				'fs-desktop' => 14,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.3,
				'lh-desktop-unit' => ''
			),

		);

		return $defaults;

	}
}