<?php

if(!function_exists('wefix_shop_product_images_360viewer_html')) {
	function wefix_shop_product_images_360viewer_html($attrs, $content = null) {

		extract ( shortcode_atts ( array (
			'product_id'          => '',
			'enable_popup_viewer' => '',
			'source'              => '',
			'class'               => ''
		), $attrs ) );

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '';
		wp_enqueue_style( 'wdt-shop-product-single-images-360-viewer', wefix_shop_single_module_360_viewer()->module_dir_url() . 'elementor/widgets/assets/css/style'.$suffix.'.css', array (), false, 'all' );

		wp_enqueue_script('jquery-360viewer', wefix_shop_single_module_360_viewer()->module_dir_url() . 'elementor/widgets/assets/js/360-viewer'.$suffix.'.js', array ('jquery'), false, true);
		wp_enqueue_script('wdt-shop-product-single-images-360-viewer', wefix_shop_single_module_360_viewer()->module_dir_url() . 'elementor/widgets/assets/js/script'.$suffix.'.js', array ('jquery'), false, true);

		$output = wefix_shop_product_images_360viewer_render_html($attrs);

		return $output;

	}
	add_shortcode( 'wefix_shop_product_images_360viewer', 'wefix_shop_product_images_360viewer_html' );
}

if(!function_exists('wefix_shop_product_images_360viewer_render_html')) {
	function wefix_shop_product_images_360viewer_render_html($settings) {

		$output = '';

		if($settings['product_id'] == '' && is_singular('product')) {
			global $post;
			$settings['product_id'] = $post->ID;
		}

		if($settings['product_id'] != '') {

			if($settings['enable_popup_viewer'] == 'true') {

				$viewer360_gallery_ids = get_post_meta ( $settings['product_id'], '_360viewer_gallery', true );
				$viewer360_gallery_ids = (isset($viewer360_gallery_ids['product-360view-gallery']) && $viewer360_gallery_ids['product-360view-gallery'] != '') ? explode(',', $viewer360_gallery_ids['product-360view-gallery']) : array ();

				if(isset($viewer360_gallery_ids[0])) {

					$output .= '<div class="wdt-product-image-360-viewer-holder wdt-product-image-360-popup-viewer-holder '.$settings['class'].'">';

						$output .= '<div class="wdt-product-image-360-viewer-enlarger">A</div>';

						if($settings['source'] != 'single-product') {

							$image = wp_get_attachment_image( $viewer360_gallery_ids[0], 'full', false );
							$output .= $image;

						}

						$output .= '<div class="wdt-product-image-360-viewer-container">';

							$output .= '<div class="wdt-product-image-360-viewer" data-count="'.count($viewer360_gallery_ids).'">';

			                    if(is_array($viewer360_gallery_ids) && !empty($viewer360_gallery_ids)) {
			                    	$i = 1;
			                        foreach($viewer360_gallery_ids as $viewer360_gallery_id) {

										$image = wp_get_attachment_image( $viewer360_gallery_id, 'full', false, array (
													'data-index' => $i,
												) );

										$output .= $image;

										$i++;

			                        }
			                    }

					   		$output .= '</div>';

					   		$output .= '<div class="wdt-product-image-360-viewer-close">'.esc_html__( 'Close', 'wefix-pro' ).'</div>';

					   	$output .= '</div>';

					$output .= '</div>';

				}

			} else {

				$output .= '<div class="wdt-product-image-360-viewer-holder '.$settings['class'].'">';

					$output .= '<div class="wdt-product-image-360-viewer-container">';

						$viewer360_gallery_ids = get_post_meta ( $settings['product_id'], '_360viewer_gallery', true );
						$viewer360_gallery_ids = (isset($viewer360_gallery_ids['product-360view-gallery']) && $viewer360_gallery_ids['product-360view-gallery'] != '') ? explode(',', $viewer360_gallery_ids['product-360view-gallery']) : array ();

						$output .= '<div class="wdt-product-image-360-viewer" id="wdt-product-image-360-viewer" data-count="'.count($viewer360_gallery_ids).'">';

		                    if(is_array($viewer360_gallery_ids) && !empty($viewer360_gallery_ids)) {
		                    	$i = 1;
		                        foreach($viewer360_gallery_ids as $viewer360_gallery_id) {

									$image = wp_get_attachment_image( $viewer360_gallery_id, 'full', false, array (
												'data-index' => $i,
											) );

									$output .= $image;

									$i++;

		                        }
		                    }

				   		$output .= '</div>';

				   	$output .= '</div>';

			   	$output .= '</div>';

		   }

		} else {

			$output .= esc_html__('Please provide product id to display corresponding data!', 'wefix-pro');

		}

		return $output;

	}
}