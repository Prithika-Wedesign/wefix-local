<?php

/* Product Tabs Exploaded - Shortcodes */

if(!function_exists('wefix_shop_product_additional_tabs_exploded_html')) {
	function wefix_shop_product_additional_tabs_exploded_html($attrs, $content = null) {

		extract ( shortcode_atts ( array (
			'product_id'    => '',
			'tab'           => '',
			'hide_title'    => '',
			'apply_scroll'  => '',
			'scroll_height' => '',
			'class'         => ''
		), $attrs ) );

		$out = wefix_shop_product_additional_tabs_exploded_render_html($attrs);

		return $out;

	}
	add_shortcode( 'wefix_shop_product_additional_tabs_exploded', 'wefix_shop_product_additional_tabs_exploded_html' );
}


if(!function_exists('wefix_shop_product_additional_tabs_exploded_render_html')) {
	function wefix_shop_product_additional_tabs_exploded_render_html($settings) {

		$output = '';

		if(is_singular('product') && (!isset($settings['product_id']) || $settings['product_id'] == '')) {
			global $post;
			$settings['product_id'] = $post->ID;
		}

		if(isset($settings['product_id']) && $settings['product_id'] != '') {

			$hide_title_class = '';
			if($settings['hide_title'] == 'true') {
				$hide_title_class = 'wdt-product-hide-tab-title';
			}

			$scroll_class = $scroll_height_style_attr = '';
			if(isset($settings['apply_scroll']) && $settings['apply_scroll'] == 'true') {
				$scroll_class             = 'wdt-content-scroll';
				$scroll_height            = ($settings['scroll_height'] != '') ? $settings['scroll_height'] : 400;
				$scroll_height_style_attr = 'style = "height:'.esc_attr($scroll_height).'px"';
			}

            $class = '';
            if(isset($settings['class']) && $settings['class'] != '') {
                $class = $settings['class'];
            }

			$output .= '<div class="wdt-product-tabs wdt-product-tabs-exploded '.$class.' '.$hide_title_class.' '.$scroll_class.'" '.$scroll_height_style_attr.'>';

				// Custom Tabs

				if($settings['tab'] == 'custom_tab_1' || $settings['tab'] == 'custom_tab_2' || $settings['tab'] == 'custom_tab_3' || $settings['tab'] == 'custom_tab_4' || $settings['tab'] == 'custom_tab_5') {

					$custom_settings = get_post_meta( $settings['product_id'], '_custom_settings', true );
					$product_additional_tabs = (is_array($custom_settings['product-additional-tabs']) && !empty($custom_settings['product-additional-tabs'])) ? $custom_settings['product-additional-tabs'] : array ();

					// Tab 1
					if($settings['tab'] == 'custom_tab_1' && isset($product_additional_tabs[1])) {

						ob_start();
						$tab_title = $product_additional_tabs[1]['tab_title'];
						$tab_title = preg_replace('/[^A-Za-z0-9\-]/', '', $tab_title);
						$tab_key = 'wefix_'.strtolower(str_replace(' ', '', $tab_title));
						wefix_shop_woo_additional_product_tabs_content( $tab_key );
						$output .= ob_get_clean();

					}

					// Tab 2
					if($settings['tab'] == 'custom_tab_2' && isset($product_additional_tabs[2])) {

						ob_start();
						$tab_title = $product_additional_tabs[2]['tab_title'];
						$tab_title = preg_replace('/[^A-Za-z0-9\-]/', '', $tab_title);
						$tab_key = 'wefix_'.strtolower(str_replace(' ', '', $tab_title));
						wefix_shop_woo_additional_product_tabs_content( $tab_key );
						$output .= ob_get_clean();

					}

					// Tab 3
					if($settings['tab'] == 'custom_tab_3' && isset($product_additional_tabs[3])) {

						ob_start();
						$tab_title = $product_additional_tabs[3]['tab_title'];
						$tab_title = preg_replace('/[^A-Za-z0-9\-]/', '', $tab_title);
						$tab_key = 'wefix_'.strtolower(str_replace(' ', '', $tab_title));
						wefix_shop_woo_additional_product_tabs_content( $tab_key );
						$output .= ob_get_clean();

					}

					// Tab 4
					if($settings['tab'] == 'custom_tab_4' && isset($product_additional_tabs[4])) {

						ob_start();
						$tab_title = $product_additional_tabs[4]['tab_title'];
						$tab_title = preg_replace('/[^A-Za-z0-9\-]/', '', $tab_title);
						$tab_key = 'wefix_'.strtolower(str_replace(' ', '', $tab_title));
						wefix_shop_woo_additional_product_tabs_content( $tab_key );
						$output .= ob_get_clean();

					}

					// Tab 5
					if($settings['tab'] == 'custom_tab_5' && isset($product_additional_tabs[5])) {

						ob_start();
						$tab_title = $product_additional_tabs[5]['tab_title'];
						$tab_title = preg_replace('/[^A-Za-z0-9\-]/', '', $tab_title);
						$tab_key = 'wefix_'.strtolower(str_replace(' ', '', $tab_title));
						wefix_shop_woo_additional_product_tabs_content( $tab_key );
						$output .= ob_get_clean();

					}

				}

			$output .= '</div>';

		} else {

			$output .= esc_html__('Please provide product id to display corresponding data!', 'wefix-pro');

		}

		return $output;

	}
}