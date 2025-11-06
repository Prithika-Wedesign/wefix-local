<?php
function wdt_settings_price_content() {

	$output = '';

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );
	$listing_plural_label = apply_filters( 'listing_label', 'plural' );

	$output .= '<form name="formOptionSettings" class="formOptionSettings" method="post">';

		$output .= '<div class="wdt-settings-options-holder">';
			$output .= '<div class="wdt-column wdt-one-fifth first">';
				$output .= '<label>'.esc_html__('Default Currency Symbol','wdt-portfolio').'</label>';
			$output .= '</div>';
			$output .= '<div class="wdt-column wdt-four-fifth">';
	            $currency_symbol = wdt_option('price','currency-symbol');
	            $output .= '<input id="currency-symbol" name="wdt[price][currency-symbol]" type="text" value="'.esc_attr( $currency_symbol ).'" />';
	            $output .= '<div class="wdt-note">'.esc_html__('Add currency symbol here. This option will be used for search form - price range shorcode and single page - price shortcode.','wdt-portfolio').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="wdt-settings-options-holder">';
			$output .= '<div class="wdt-column wdt-one-fifth first">';
				$output .= '<label>'.esc_html__('Default Currency Symbol - Position','wdt-portfolio').'</label>';
			$output .= '</div>';
			$output .= '<div class="wdt-column wdt-four-fifth">';

				$currency_symbol_position = wdt_option('price','currency-symbol-position');
	            $currency_symbol_positions = array ('left' => esc_html__('Left','wdt-portfolio'), 'right' => esc_html__('Right','wdt-portfolio'), 'left_space' => esc_html__('Left With Space','wdt-portfolio'), 'right_space' => esc_html__('Right With Space','wdt-portfolio'));

	            $output .= '<select id="currency-symbol-position" name="wdt[price][currency-symbol-position]" class="wdt-chosen-select">';
				foreach($currency_symbol_positions as $currency_symbol_position_key => $currency_symbol_position_item) {
					$output .= '<option value="'.esc_attr( $currency_symbol_position_key ).'" '.selected($currency_symbol_position_key, $currency_symbol_position, false ).'>';
						$output .= esc_html( $currency_symbol_position_item );
					$output .= '</option>';
				}
				$output .= '</select>';

	            $output .= '<div class="wdt-note">'.esc_html__('Add currency symbol position here. This option will be used for search form - price range shorcode and single page - price shortcode.','wdt-portfolio').'</div>';

			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="wdt-option-settings-response-holder"></div>';

		$output .= '<a href="#" class="custom-button-style wdt-save-options-settings" data-settings="price">'.esc_html__('Save Settings','wdt-portfolio').'</a>';

	$output .= '</form>';

	return $output;

}

echo wdt_settings_price_content();
?>