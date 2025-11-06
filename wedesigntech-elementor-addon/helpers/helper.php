<?php

# Field Sanitization
if(!function_exists('wedesigntech_sanitization')) {
	function wedesigntech_sanitization($data) {
		if ( is_array( $data ) && !empty( $data ) ) {
			foreach ( $data as $key => &$value ) {
				if ( is_array( $value ) ) {
					$data[$key] = wedesigntech_sanitization($value);
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

# Filter html output
if(!function_exists('wedesigntech_html_output')) {
	function wedesigntech_html_output( $html ) {
		return apply_filters( 'wedesigntech_html_output', $html );
	}
}


/* Convert hexdec color string to rgb(a) string */
if ( ! function_exists( 'wedesigntech_hex2rgba' ) ) {
	function wedesigntech_hex2rgba($color, $opacity = false) {

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




