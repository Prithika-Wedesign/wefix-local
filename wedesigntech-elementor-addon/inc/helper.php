<?php

if ( ! function_exists( 'wedesigntech_elemento_get_elementor_instance' ) ) {
	function wedesigntech_elemento_get_elementor_instance() {
		return \Elementor\Plugin::instance();
	}
}

if ( ! function_exists( 'wedesigntech_elementor_get_elementor_widgets_manager' ) ) {
	function wedesigntech_elementor_get_elementor_widgets_manager() {
		return wedesigntech_elemento_get_elementor_instance()->widgets_manager;
	}
}

if ( ! function_exists( 'wedesigntech_elementor_format_repeater_values' ) ) {
	function wedesigntech_elementor_format_repeater_values($content_position_elements) {

		$content_positions = array ();

		if(is_array($content_position_elements) && !empty($content_position_elements)) {
			$content_position_keys = array_keys($content_position_elements);
			foreach($content_position_keys as $item_element) {
				array_push($content_positions, array(
					'element_value' => $item_element
				));
			}
		}

		return $content_positions;

	}
}

if ( ! function_exists( 'wedesigntech_elementor_global_colors' ) ) {
	function wedesigntech_elementor_global_colors( $type, $value ) {

		$kit = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend();
		$kit_settings = $kit->get_settings_for_display( $type );

		if($type == 'system_colors') {
			return $kit_settings[$value]['color'];
        } else if($type == 'custom_colors') {
			return isset($kit_settings[$value]['color']) ? $kit_settings[$value]['color'] : '';
		} else if($type == 'system_typography') {
			return $kit_settings[$value];
		}

	}
}