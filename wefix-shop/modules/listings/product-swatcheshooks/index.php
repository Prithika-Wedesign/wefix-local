<?php

/**
 * Listing Framework Hooks Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Woo_Listing_Swatches_Hooks_Settings' ) ) {

    class WeFix_Woo_Listing_Swatches_Hooks_Settings {

        private static $_instance = null;

        private $template_hooks_page_top = false;
        private $template_hooks_page_bottom = false;
        private $template_hooks_content_top = false;
        private $template_hooks_content_bottom = false;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {            
            add_action('woocommerce_product_after_variable_attributes', array($this, 'add_color_picker_to_variations'), 10, 3);
            add_action('woocommerce_save_product_variation', array($this, 'save_variation_color_meta'), 10, 2);
            add_action('woocommerce_save_product_variation', array($this, 'save_variation_material_image'), 10, 2);

            add_action('woocommerce_after_add_attribute_fields', array($this, 'custom_attribute_extra_field'));
            add_action('woocommerce_after_edit_attribute_fields', array($this, 'custom_attribute_extra_field'));

            add_action('woocommerce_attribute_added', array($this, 'save_custom_attribute_fieldvariant'), 10, 2);
            add_action('woocommerce_attribute_updated', array($this, 'save_custom_attribute_fieldvariant'), 10, 2);
            add_action('init',  array($this, 'add_allextrafields'), 10, 2) ;

            add_action('wp_ajax_woocommerce_ajax_add_to_cart', array($this, 'woocommerce_ajax_add_to_cart_handler'));
            add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', array($this, 'woocommerce_ajax_add_to_cart_handler'));

            add_action('wp_ajax_swatches_shop', array($this, 'swatches_shop'));
            add_action('wp_ajax_nopriv_swatches_shop', array($this, 'swatches_shop'));
            add_action('wp_ajax_getproduct_details', array($this, 'getproduct_details'));
            add_action('wp_ajax_nopriv_getproduct_details', array($this, 'getproduct_details'));

        }


        public function add_allextrafields(){     

            $attribute_taxonomies = wc_get_attribute_taxonomies();

            foreach ($attribute_taxonomies as $attribute) {
                $taxonomy = 'pa_' . $attribute->attribute_name; 
                add_action("{$taxonomy}_add_form_fields", array($this, 'custom_attribute_term_add_field'), 10, 1);
                add_action("{$taxonomy}_edit_form_fields", array($this, 'custom_attribute_term_extra_field'), 10, 2);
                add_action("create_{$taxonomy}", array($this, 'save_custom_attribute_term_extra_field'), 10, 2);
                add_action("edited_{$taxonomy}", array($this, 'save_custom_attribute_term_extra_field'), 10, 2);
            }

        }

        public function custom_attribute_term_add_field($taxonomy) {

            global $wpdb;

            $attribute_name = str_replace('pa_', '', $taxonomy);
            $attribute_type = $wpdb->get_var($wpdb->prepare(
                "SELECT attribute_type FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_name = %s",
                $attribute_name
            ));

            $custom_field_value = strtolower($attribute_type);
            ?>

            <div class="form-field">
                <label for="custom_fieldvariant"><?php esc_html_e('Variant Type', 'wefix-shop'); ?></label>

                <?php if ($custom_field_value === 'color') : ?>
                    <input type="text" name="custom_fieldvariant_color" id="custom_fieldvariant" class="color-picker" data-default-color="#ffffff" />
                    <p class="description"><?php esc_html_e('Choose a color for the variant.', 'wefix-shop'); ?></p>

                <?php elseif ($custom_field_value === 'image') : ?>
                    <input type="hidden" name="custom_field_image" id="custom_field_image" value="" />
                    <div id="custom_field_image_preview"></div>
                    <button type="button" class="button" id="upload_image_button"><?php esc_html_e('Upload Image', 'wefix-shop'); ?></button>
                    <button type="button" class="button" id="remove_image_button"><?php esc_html_e('Remove Image', 'wefix-shop'); ?></button>
                    <p class="description"><?php esc_html_e('Upload an image for the variant.', 'wefix-shop'); ?></p>

                <?php else : ?>
                    <p><?php esc_html_e('No variant field required for this attribute type.', 'wefix-shop'); ?></p>
                <?php endif; ?>
            </div>

            <?php

        }

        public function add_color_picker_to_variations($loop, $variation_data, $variation) {  
            $product_id = get_the_ID(); 
            $product = wc_get_product($product_id);  
            $attributes = $product->get_attributes(); 

            if (isset($attributes['color']) && !empty($attributes['color'])) {   
                $saved_color = get_post_meta($variation->ID, 'variation_color', true);
                $saved_color = $saved_color ? $saved_color : '#000000';  
                $saved_color = '<div class="form-row form-row-full"><label for="variation_color_'. $variation->ID.'">Color</label>
                    <input type="color" class="color-picker-field" name="variation_color['.$variation->ID.']" value="'.esc_attr($saved_color).'" />
                </div>';
                echo $saved_color;
                
            } 
            
            if (isset($attributes['image']) && !empty($attributes['Image'])) { 
                $saved_image = get_post_meta($variation->ID, 'variation_material_image', true);
                $saved_images = '<div class="form-row form-row-full">
                            <label for="variation_material_image_' . $variation->ID . '">Material Image</label>
                            <input type="hidden" class="material-image-field" id="variation_material_image_' . $variation->ID . '" name="variation_material_image[' . $variation->ID . ']" value="' . esc_attr($saved_image) . '"/>
                            <button type="button" class="button upload-material-image" data-target="#variation_material_image_' . $variation->ID . '">'
                                . ($saved_image ? 'Change Image' : 'Upload Image') .
                            '</button>
                            <div class="existing-image">';

                        if ($saved_image) {
                            $saved_images .= '<img src="' . esc_url($saved_image) . '" alt="Material Image" title="Material Image"/>';
                        }

                $saved_images .= '</div></div>';
                echo $saved_images;

                
            }
            else {  
            }

        }

        public function save_variation_color_meta($variation_id, $i) {
            if (isset($_POST['variation_color'][$variation_id])) {
                update_post_meta($variation_id, 'variation_color', sanitize_text_field($_POST['variation_color'][$variation_id]));
            }
        }

        public function save_variation_material_image($variation_id) {
            if (!empty($_POST['variation_material_image']) && is_array($_POST['variation_material_image'])) { 
                if (isset($_POST['variation_material_image'][$variation_id])) {
                    $image_url = sanitize_text_field($_POST['variation_material_image'][$variation_id]); 
                    update_post_meta($variation_id, 'variation_material_image', $image_url);
                } 
            }
        }
    
        public function custom_attribute_extra_field($attribute) {
            global $wpdb;
            
            $attribute_id = isset($_GET['edit']) ? absint($_GET['edit']) : 0;
            if (isset($attribute->attribute_id)) {
                $attribute_id = $attribute->attribute_id;
            }

            $custom_field_value = '';
            if ($attribute_id) { 
                $attribute_type = $wpdb->get_var(
                    $wpdb->prepare(
                        "SELECT attribute_type FROM {$wpdb->prefix}woocommerce_attribute_taxonomies 
                        WHERE attribute_id = %d",
                        $attribute_id
                    )
                );
                
                $custom_field_value = strtolower($attribute_type);  
            }

            $table_con = '<tr class="form-field">
                <th scope="row" valign="top">
                    <label for="custom_fieldvariant">' . esc_html__('Variant Type', 'wefix-shop') . '</label>
                </th>
                <td>
                    <select name="custom_fieldvariant" id="custom_fieldvariant">
                        <option value="" ' . selected($custom_field_value, '', false) . '>' . esc_html__('Select', 'wefix-shop') . '</option>
                        <option value="color" ' . selected($custom_field_value, 'color', false) . '>' . esc_html__('Color', 'wefix-shop') . '</option>
                        <option value="image" ' . selected($custom_field_value, 'image', false) . '>' . esc_html__('Image', 'wefix-shop') . '</option>
                        <option value="button" ' . selected($custom_field_value, 'button', false) . '>' . esc_html__('Button', 'wefix-shop') . '</option>
                        <option value="dropdown" ' . selected($custom_field_value, 'dropdown', false) . '>' . esc_html__('Dropdown', 'wefix-shop') . '</option>
                    </select>
                    <p class="description">' . esc_html__('Its based on the variant appearance.', 'wefix-shop') . '</p>
                </td>
            </tr>';

            echo $table_con;
        }

        public function save_custom_attribute_fieldvariant($attribute_id, $data) {
            global $wpdb;
            
            if (isset($_POST['custom_fieldvariant'])) {
                $value = sanitize_text_field($_POST['custom_fieldvariant']); 
                $wpdb->update(
                    "{$wpdb->prefix}woocommerce_attribute_taxonomies",
                    array('attribute_type' => ucfirst($value)),  
                    array('attribute_id' => $attribute_id),
                    array('%s'),
                    array('%d')
                );
                
                wp_cache_delete('woocommerce_attribute_taxonomies');
                
            }
        }

        /* swatches code starts */
        public function swatches_shop() {
            $selected_attributes = $_POST['selected_attributes'] ?? [];
            $product_id = sanitize_text_field($_POST['product_id']);
            $product = wc_get_product($product_id);

            if ($product && $product->is_type('variable')) {
                $available_variations = $product->get_available_variations();
                $possible_attributes = [];

                foreach ($available_variations as $variation) {
                    $variation_attributes = $variation['attributes'];

                    $is_match = true;
                    foreach ($selected_attributes as $attr_name => $attr_value) {
                        $key = 'attribute_' . $attr_name;
                        if (!isset($variation_attributes[$key]) || $variation_attributes[$key] !== $attr_value) {
                            $is_match = false;
                            break;
                        }
                    }

                    if ($is_match) {
                        foreach ($variation_attributes as $key => $value) {
                            // Only return options that haven't been selected yet
                            $attr_name = str_replace('attribute_', '', $key);
                            if (!isset($selected_attributes[$attr_name])) {
                                if (!isset($possible_attributes[$key])) {
                                    $possible_attributes[$key] = [];
                                }
                                if (!in_array($value, $possible_attributes[$key])) {
                                    $possible_attributes[$key][] = $value;
                                }
                            }
                        }
                    }
                }

                // Optional: Implode for easier frontend parsing
                foreach ($possible_attributes as $key => $values) {
                    $possible_attributes[$key] = implode(', ', $values);
                }

                wp_send_json_success([
                    'next_attributes' => $possible_attributes
                ]);
            }

            wp_send_json_error(['message' => 'No matching variation found.']);
        } 

        public function getproduct_details() {
            if (!isset($_POST['product_id'])) {
                wp_send_json_error(array('message' => 'Product ID is missing.'));
                wp_die();
            }

            $product_id = sanitize_text_field($_POST['product_id']);
            $variant_id = isset($_POST['variant_id']) ? sanitize_text_field($_POST['variant_id']) : '';

            $product = wc_get_product($product_id);

            if (!$product || !$product->is_type('variable')) {
                wp_send_json_error(array('message' => 'Invalid product.'));
                wp_die();
            }

            // Get variation product
            $variation = $variant_id ? wc_get_product($variant_id) : null;

            // If the provided variant ID is invalid or missing, fetch the first available variation
            if (!$variation || !$variation->is_type('variation')) {
                $variations = $product->get_available_variations();
                if (!empty($variations)) {
                    $variant_id = $variations[0]['variation_id'];
                    $variation = wc_get_product($variant_id);
                }
            }

            // If no valid variation is found, return an error
            if (!$variation || !$variation->is_type('variation')) {
                wp_send_json_error(array('message' => 'No valid variation found.'));
                wp_die();
            }

            $variant_image_id = $variation->get_image_id();
            $variant_image_url = $variant_image_id ? wp_get_attachment_url($variant_image_id) : '';
            $variation_data = $variation->get_data();
        

            // Get price details
            $display_regular_price = $variation->get_regular_price();
            $display_price = $variation->get_price();
            $symbol = html_entity_decode(get_woocommerce_currency_symbol());

            if ($display_price == $display_regular_price) {
                $dis_price = $symbol . $display_price . ".00";
            } else {
                $dis_price = $symbol . $display_price . ".00 - " . $symbol . $display_regular_price . ".00";
            } 

            // $stock_status = $variation->is_in_stock() ? 'In Stock' : 'Out of Stock'; 
            $attachment_id = $variation->get_image_id();
            $image_url = wp_get_attachment_url($attachment_id); 
            $cart_url = get_site_url() . "/cart/?product_id=" . $product_id . "&variation_id=" . $variant_id;
            $variation_attributes = $variation->get_attributes();

            // wishlist code 
            $in_wishlist  = false;   
            global $wpdb;
            $table_name = $wpdb->prefix . 'tinvwl_items';
            $result = $wpdb->get_row(
                $wpdb->prepare(
                    "SELECT * FROM $table_name 
                    WHERE product_id = %d AND variation_id = %d",
                    $product_id,
                    $variant_id
                )
            );

            if ($result) {
                $in_wishlist = true;
            }


            // Return the response
            wp_send_json_success(array(
                'price' => $dis_price,
                'variation_data' => $variation_data,
                'image_url' => $image_url,
                'variant_image'  => $variant_image_url,
                'cart_url' => $cart_url,
                'attributes' => $variation_attributes,
                'in_wishlist' => $in_wishlist
            ));
        }

        /* swatches code end */
        
        public function custom_attribute_term_extra_field($term, $taxonomy) {
            $term_id = $term->term_id;  
            $custom_field_value = get_term_meta($term_id, 'custom_fieldvariant', true); 
        
            $form_field_html = '
            <tr class="form-field">
                <th scope="row" valign="top">
                    <label for="custom_fieldvariant">' . esc_html__('Variant Type', 'wefix-shop') . '</label>
                </th>
                <td>';

            global $wpdb; 

            $attribute_id = $wpdb->get_var($wpdb->prepare(
                "SELECT attribute_id FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_name = %s",
                str_replace('pa_', '', get_term($term_id)->taxonomy)
            ));

            $custom_field_value = '';
            if ($attribute_id) { 
                $attribute_type = $wpdb->get_var(
                    $wpdb->prepare(
                        "SELECT attribute_type FROM {$wpdb->prefix}woocommerce_attribute_taxonomies 
                        WHERE attribute_id = %d",
                        $attribute_id
                    )
                );
                
                $custom_field_value = strtolower($attribute_type);  
            }
            //$custom_field_value = '';
            if ($attribute_id) {
            //  $custom_field_value = get_term_meta($attribute_id, 'custom_fieldvariant', true);
                $custom_fieldvariant_color = get_term_meta($term_id, 'custom_fieldvariant_color', true);
                $image_id = get_term_meta($term_id, 'custom_field_image', true);
                $image_url = wp_get_attachment_url($image_id);
            } 

        

            if ($custom_field_value === 'color' || $custom_field_value === 'Color') {  
                $form_field_html .= '
                <input type="text" name="custom_fieldvariant_color" id="custom_fieldvariant" 
                value="' . esc_attr($custom_fieldvariant_color) . '" 
                class="color-picker" data-default-color="' . esc_attr($custom_fieldvariant_color) . '" />
                <p class="description">' . esc_html__('Its based on the variant appearance.', 'wefix-shop') . '</p>';
            } else if($custom_field_value === 'image' || $custom_field_value === 'Image') {
                $form_field_html .= '
                <input type="hidden" name="custom_field_image" id="custom_field_image" value="' . esc_attr($image_id) . '" />
                <div id="custom_field_image_preview">';
                
                if ($image_url) {
                    $form_field_html .= '<img src="' . esc_url($image_url) . '" alt="' . esc_attr__('Variant Image', 'wefix-shop') . '" title="' . esc_attr__('Variant Image', 'wefix-shop') . '"/>';
                }
                
                $form_field_html .= '
                </div>
                <button type="button" class="button" id="upload_image_button">' . esc_html__('Upload Image', 'wefix-shop') . '</button>
                <button type="button" class="button" id="remove_image_button">' . esc_html__('Remove Image', 'wefix-shop') . '</button>
                <p class="description">' . esc_html__('Upload an image for the variant.', 'wefix-shop') . '</p>';
            } else {
                $form_field_html .= 'button';
            }

            $form_field_html .= '
                </td>
            </tr>'; 
            echo $form_field_html;
        }

        public function save_custom_attribute_term_extra_field($term_id, $tt_id) {

            if (isset($_POST['custom_fieldvariant_color'])) {
                update_term_meta($term_id, 'custom_fieldvariant_color', sanitize_text_field($_POST['custom_fieldvariant_color']));
            }

            // if (isset($_POST['custom_field_image'])) {
                update_term_meta($term_id, 'custom_field_image', absint($_POST['custom_field_image']));
            //}
        }
        
        public function woocommerce_ajax_add_to_cart_handler() {
            $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
            $quantity   = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
            $variation_id = absint($_POST['variation_id']);
            $variations = isset($_POST['variation']) ? (array) $_POST['variation'] : [];

            $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);

            if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variations)) {
                do_action('woocommerce_ajax_added_to_cart', $product_id);
                WC_AJAX::get_refreshed_fragments();
            } else {
                $data = array(
                    'error'       => true,
                    'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
                );
                wp_send_json($data);
            }

            wp_die();
        }

    }

}


if( !function_exists('WeFix_Woo_Listing_Swatches_Hooks_Settings') ) {
	function WeFix_Woo_Listing_Swatches_Hooks_Settings() {
		return WeFix_Woo_Listing_Swatches_Hooks_Settings::instance();
	}
}

WeFix_Woo_Listing_Swatches_Hooks_Settings();