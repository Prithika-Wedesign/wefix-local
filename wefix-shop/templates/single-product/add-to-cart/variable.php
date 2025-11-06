<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 6.1.0
 */

defined( 'ABSPATH' ) || exit;

global $product; 

$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

do_action( 'woocommerce_before_add_to_cart_form' );

	global $product, $wpdb;
		
		$attributes = $product->get_variation_attributes();
		$custom_field_values = []; // store all results here

		foreach ($attributes as $attribute_name => $options) { 
			$attribute_id = wc_attribute_taxonomy_id_by_name($attribute_name);
			
			if ($attribute_id) { 
				$attribute_type = $wpdb->get_var(
					$wpdb->prepare(
						"SELECT attribute_type 
						FROM {$wpdb->prefix}woocommerce_attribute_taxonomies 
						WHERE attribute_id = %d",
						$attribute_id
					)
				); 
				$value = strtolower($attribute_type); 
				$custom_field_values[$attribute_name] = $value;  
			}
		} 
		
		if ( $attribute_type == 'Dropdown'  )  { ?>
			
			<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">
				<?php do_action( 'woocommerce_before_variations_form' ); ?>

				<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
					<p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'wefix-shop' ) ) ); ?></p>
				<?php else : ?>
					<table class="variations" cellspacing="0" role="presentation">
						<tbody>
							<?php foreach ( $attributes as $attribute_name => $options ) : ?>
								<tr>
									<th class="label"><label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?></label></th>
									<td class="value">
										<?php
											wc_dropdown_variation_attribute_options(
												array(
													'options'   => $options,
													'attribute' => $attribute_name,
													'product'   => $product,
												)
											);
											/**
											 * Filters the reset variation button.
											 *
											 * @since 2.5.0
											 *
											 * @param string  $button The reset variation button HTML.
											 */
											echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#" aria-label="' . esc_attr__( 'Clear options', 'wefix-shop' ) . '">' . esc_html__( 'Clear', 'wefix-shop' ) . '</a>' ) ) : '';
										?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					<div class="reset_variations_alert screen-reader-text" role="alert" aria-live="polite" aria-relevant="all"></div>
					<?php do_action( 'woocommerce_after_variations_table' ); ?>

					<div class="single_variation_wrap">
						<?php
							/**
							 * Hook: woocommerce_before_single_variation.
							 */
							do_action( 'woocommerce_before_single_variation' );

							/**
							 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
							 *
							 * @since 2.4.0
							 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
							 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
							 */
							do_action( 'woocommerce_single_variation' );

							/**
							 * Hook: woocommerce_after_single_variation.
							 */
							do_action( 'woocommerce_after_single_variation' );
						?>
					</div>
				<?php endif; ?>

				<?php do_action( 'woocommerce_after_variations_form' ); ?>
			</form>
		<?php } else { ?> 

			<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">
				<?php do_action( 'woocommerce_before_variations_form' ); ?>

				<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
					<p class="wdt-single-product-stock out_of_stock stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'wefix-shop' ) ) ); ?></p>
				<?php else : ?>
			
					<?php
					wp_enqueue_style( 'variation-swatches-css', get_theme_file_uri('/modules/woocommerce/assets/css/variation-swatches.css'), false, WEFIX_THEME_VERSION, 'all');  
					wp_enqueue_script('variation-swatches-js', get_theme_file_uri('/assets/js/variation-swatches.js'), array('jquery'), false, true); 
					wp_localize_script('variation-swatches-js', 'ajax_object', array(
						'ajaxurl' => admin_url('admin-ajax.php')
					)); 
					global $product;

					$product_id = get_the_ID();
			
					if ($product->is_type('variable')) {
						$attributes = $product->get_variation_attributes();
						$available_variations = $product->get_available_variations();
						
						echo '<div class="attribute-swatchesselect" data-product-id="'.$product_id.'" hidden >';
							echo '<label for="all-attributes">' . __('Choose a Variant', 'wefix-shop') . '</label>';
							
							echo '<select class="all-attributes-' . $product_id . '" name="all_attributes">';  
								$default_price = $product->get_price();
								$default_regular_price = $product->get_regular_price();
								$symbol = html_entity_decode(get_woocommerce_currency_symbol());

								$formatted_default = number_format((float)$default_price, 2, '.', '');
								$formatted_default_regular = number_format((float)$default_regular_price, 2, '.', '');

								if ($default_price == $default_regular_price || empty($default_regular_price)) {
									$default_dis_price = $symbol . $formatted_default;
								} else {
									$default_dis_price = $symbol . $formatted_default . ' - ' . $symbol . $formatted_default_regular;
								} 
								echo '<option value="0" data-price="' . esc_attr($default_dis_price) . '">' . __('Choose an option', 'wefix-shop') . '</option>';


								$options_combined = []; 
								$available_variations = $product->get_available_variations();

								foreach ($available_variations as $variation) {
									$formatted_attributes = [];

									foreach ($variation['attributes'] as $key => $value) {
										if (!empty($value)) {
											$formatted_attributes[] = ucfirst($value);
										}
									}

									if (!empty($formatted_attributes)) {
										$option_label = implode(', ', $formatted_attributes);
										$variation_id = $variation['variation_id']; 
										$variation_obj = new WC_Product_Variation($variation_id);

										// Get prices
										$display_price = $variation_obj->get_price();
										$display_regular_price = $variation_obj->get_regular_price();

										// Format
										$symbol = html_entity_decode(get_woocommerce_currency_symbol());

										$formatted_regular = number_format((float)$display_regular_price, 2, '.', '');
										$formatted_price = number_format((float)$display_price, 2, '.', '');

										if ($display_price == $display_regular_price || empty($display_regular_price)) {
											$dis_price = $symbol . $formatted_price;
										} else {
											$dis_price = $symbol . $formatted_price . ' - ' . $symbol . $formatted_regular;
										}

										if (!in_array($option_label, $options_combined)) {
											$options_combined[] = $option_label;
											echo '<option data-price="' . esc_attr($dis_price) . '" value="' . esc_attr($variation_id) . '">' . esc_html($option_label) . '</option>';
										}
									}
								}

							echo '</select>';

						echo '</div>';
			
						echo '<div class="wdt-swatch-product-price"> </div>'; 
						echo '<div class="variation-swatches">';  
							foreach ($attributes as $attribute_name => $options) {
							
								$class = 'proswatch ';
								if (isset($custom_field_values[$attribute_name])) {
									if ($custom_field_values[$attribute_name] === 'color') {
										$class = 'wdt-proswatch-color ';
									} elseif ($custom_field_values[$attribute_name] === 'image') {
										$class = 'wdt-proswatch-material ';
									} else {
										$class = 'wdt-proswatch-button ';
									}
								}

								$taxonomy_label = wc_attribute_label( $attribute_name );
				
								echo '<div class="' . $class . 'attribute-swatches attribute-swatches-' . $product_id . '">';
								echo '<div class="wdt-swatches-title"><div class="wdt-swatches-label">'. esc_html( $taxonomy_label ).'</div><span>:</span><span class="wdt-swatches-support"></span></div>';
								echo '<div class="wdt-swatches-container">';

									foreach ($options as $option) {
										$variation_found = false;
										$variation_id = ''; 
										foreach ($available_variations as $variation) {
											if (isset($variation['attributes']['attribute_' . $attribute_name]) &&
												$variation['attributes']['attribute_' . $attribute_name] === $option) {
												$variation_found = true;
												$variation_id = $variation['variation_id'];
												break;
											}
										}

										if (!$variation_found) {
											continue; 
										}

										$term = get_term_by('slug', sanitize_title($option), $attribute_name);
										$term_id = ($term) ? $term->term_id : ''; 
										$custom_color = $term_id ? get_term_meta($term_id, 'custom_fieldvariant_color', true) : '';
										$custom_image_id = $term_id ? get_term_meta($term_id, 'custom_field_image', true) : '';
										$material_image = $custom_image_id ? wp_get_attachment_url($custom_image_id) : ''; 
										$variation_obj = new WC_Product_Variation($variation_id);
										$attachment_id = $variation_obj->get_image_id();

										if (empty($attachment_id)) {
											$attachment_id = get_post_thumbnail_id($variation_id) ?: get_post_thumbnail_id($product_id);
										} 
										if (!empty($custom_color)) {
											echo '<div class="available product_swatch proswatch-' . esc_attr($product_id) . ' proswatch-color" data-attach-id="' . esc_attr($variation_id) . '" data-attribute-id="' . esc_attr($variation_id) . '" data-product="' . esc_attr($product_id) . '" data-attribute-name="' . esc_attr($attribute_name) . '" data-attribute-value="' . esc_attr($option) . '">
													<div style="background:' . esc_attr($custom_color) . '"></div>
												</div>';
										} elseif (!empty($material_image)) {
											echo '<div class="available product_swatch proswatch-' . esc_attr($product_id) . ' proswatch-material" data-attach-id="' . esc_attr($variation_id) . '" data-attribute-id="' . esc_attr($variation_id) . '" data-product="' . esc_attr($product_id) . '" data-attribute-name="' . esc_attr($attribute_name) . '" data-attribute-value="' . esc_attr($option) . '">
													<div style="background-image:url(' . esc_url($material_image) . ')"></div>
												</div>';
										} else {
											echo '<div class="available product_swatch proswatch-' . esc_attr($product_id) . '" data-attach-id="' . esc_attr($variation_id) . '" data-attribute-id="' . esc_attr($variation_id) . '" data-product="' . esc_attr($product_id) . '" data-attribute-name="' . esc_attr($attribute_name) . '" data-attribute-value="' . esc_attr($option) . '">';
											echo esc_html($option);
											echo '</div>';
										}
									}

								echo '</div></div>';
								
							}  
							echo '<div class="clear_swatchespro" data-product-id ="'.$product_id.'" >clear</div>';
						echo '</div>';  
					} ?>

					<?php do_action( 'woocommerce_after_variations_table' ); ?>

					<div class="single_variation_wrap">
						<?php
							/**
							 * Hook: woocommerce_before_single_variation.
							 */
							do_action( 'woocommerce_before_single_variation' );

							/**
							 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
							 *
							 * @since 2.4.0
							 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
							 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
							 */
							do_action( 'woocommerce_single_variation' );

							/**
							 * Hook: woocommerce_after_single_variation.
							 */
							do_action( 'woocommerce_after_single_variation' );
						?>
					</div>
				<?php endif; ?>
				
				<input type="hidden" name="variation_id" class="variation-id-field" />
				<input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product_id); ?>" />
				<?php do_action( 'woocommerce_after_variations_form' ); ?>
			</form>
		<?php } ?>
<?php
do_action( 'woocommerce_after_add_to_cart_form' );