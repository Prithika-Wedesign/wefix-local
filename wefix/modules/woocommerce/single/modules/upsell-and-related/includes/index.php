<?php

/*
 * Upsell Products
 */

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

if( ! function_exists( 'wefix_shop_woo_show_upsell' ) ) {

	function wefix_shop_woo_show_upsell() {

		global $product;

        $settings = wefix_woo_single_core()->woo_default_settings();
        $settings = apply_filters( 'wefix_woo_single_upsell_related_settings', $settings );

		if( $settings['product_upsell_display'] ) {

			wefix_shop_single_module_upsell_related()->woo_load_listing( $settings['product_upsell_style_template'], $settings['product_upsell_style_custom_template'] );

			$product_display_type = wc_get_loop_prop( 'product-display-type', 'grid' );
			if($product_display_type == 'list') {
				$settings['product_upsell_column'] = 1;
			}

			wc_set_loop_prop( 'columns', $settings['product_upsell_column']);

			woocommerce_upsell_display( $limit = $settings['product_upsell_limit'], $columns = $settings['product_upsell_column'], $orderby = 'rand', $order = 'desc' );

			wefix_shop_product_style_reset_loop_prop(); /* Reset Product Style Loop Prop */

		}

	}

	add_action( 'woocommerce_after_single_product_summary', 'wefix_shop_woo_show_upsell', 15 );

}


/*
 * Related Products
 */

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

if( ! function_exists( 'wefix_shop_woo_show_related_products' ) ) {

	function wefix_shop_woo_show_related_products() {

		global $product;

        $settings = wefix_woo_single_core()->woo_default_settings();
        $settings = apply_filters( 'wefix_woo_single_upsell_related_settings', $settings );

		if( $settings['product_related_display'] ) {

			wefix_shop_single_module_upsell_related()->woo_load_listing( $settings['product_related_style_template'], $settings['product_related_style_custom_template'] );

			$product_display_type = wc_get_loop_prop( 'product-display-type', 'grid' );
			if($product_display_type == 'list') {
				$settings['product_related_column'] = 1;
			}

			wc_set_loop_prop( 'columns', $settings['product_related_column']);

			woocommerce_related_products(array(
				'posts_per_page' => $settings['product_related_limit'],
				'columns'        => $settings['product_related_column'],
				'orderby'        => 'rand'
			) );

			wefix_shop_product_style_reset_loop_prop(); /* Reset Product Style Loop Prop */

		}

	}

	add_action( 'woocommerce_after_single_product_summary', 'wefix_shop_woo_show_related_products', 20 );

}


/*
 * Filter for  Default Settings
 */

if( ! function_exists( 'wefix_shop_woo_single_upsell_related_settings' ) ) {

	function wefix_shop_woo_single_upsell_related_settings( $settings ) {

        if( !function_exists( 'wefix_pro' ) ) {
            return $settings; // If Theme-Plugin is not activated
        }

        global $product;

        $product_id = $product->get_id();

        $custom_settings = get_post_meta( $product_id, '_custom_settings', true );

        if( is_array( $custom_settings ) ) {
            $custom_settings = array_filter( $custom_settings );
        } else {
            $custom_settings = array(
                'show-upsell'    => 'admin-option',
                'upsell-column'  => 'admin-option',
                'upsell-limit'   => 'admin-option',
                'show-related'   => 'admin-option',
                'related-column' => 'admin-option',
                'related-limit'  => 'admin-option'
            );
        }

        // Upsell

        if( isset( $custom_settings['show-upsell'] ) && $custom_settings['show-upsell'] == 'admin-option' ) {

            $settings['product_upsell_display'] = wefix_customizer_settings('wdt-single-product-upsell-display' );
            $settings['product_upsell_column']  = wefix_customizer_settings('wdt-single-product-upsell-column' );
            $settings['product_upsell_limit']   = wefix_customizer_settings('wdt-single-product-upsell-limit' );

        } else if( isset( $custom_settings['show-upsell'] ) && $custom_settings['show-upsell'] == 'true' ) {

            $settings['product_upsell_display'] = true;

            if( $custom_settings['upsell-column'] == 'admin-option' ) {
                $settings['product_upsell_column']  = wefix_customizer_settings('wdt-single-product-upsell-column' );
            } else {
                $settings['product_upsell_column']  = $custom_settings['upsell-column'];
            }

            if( $custom_settings['upsell-limit'] == 'admin-option' ) {
                $settings['product_upsell_limit']   = wefix_customizer_settings('wdt-single-product-upsell-limit' );
            } else {
                $settings['product_upsell_limit']   = $custom_settings['upsell-limit'];
            }

        }

        $product_upsell_style_custom_template = wefix_customizer_settings('wdt-single-product-upsell-style-template' );
        if( isset($product_upsell_style_custom_template) && !empty($product_upsell_style_custom_template) ) {
            $settings['product_upsell_style_template']        = 'custom';
            $settings['product_upsell_style_custom_template'] = $product_upsell_style_custom_template;
        }


        // Related

        if( isset( $custom_settings['show-related'] ) && $custom_settings['show-related'] == 'admin-option' ) {

            $settings['product_related_display'] = wefix_customizer_settings('wdt-single-product-related-display' );
            $settings['product_related_column']  = wefix_customizer_settings('wdt-single-product-related-column' );
            $settings['product_related_limit']   = wefix_customizer_settings('wdt-single-product-related-limit' );

        } else if( isset( $custom_settings['show-related'] ) && $custom_settings['show-related'] == 'true' ) {

            $settings['product_related_display'] = true;

            if( $custom_settings['related-column'] == 'admin-option' ) {
                $settings['product_related_column']  = wefix_customizer_settings('wdt-single-product-related-column' );
            } else {
                $settings['product_related_column']  = $custom_settings['related-column'];
            }

            if( $custom_settings['related-limit'] == 'admin-option' ) {
                $settings['product_related_limit']   = wefix_customizer_settings('wdt-single-product-related-limit' );
            } else {
                $settings['product_related_limit']   = $custom_settings['related-limit'];
            }

        }

        $product_related_style_custom_template = wefix_customizer_settings('wdt-single-product-related-style-template' );
        if( isset($product_related_style_custom_template) && !empty($product_related_style_custom_template) ) {
            $settings['product_related_style_template']        = 'custom';
            $settings['product_related_style_custom_template'] = $product_related_style_custom_template;
        }

        return $settings;

	}

	add_filter( 'wefix_woo_single_upsell_related_settings', 'wefix_shop_woo_single_upsell_related_settings', 10, 1 );

}


/*
 * Reset Loop Prop
 */

if( ! function_exists( 'wefix_shop_product_style_reset_loop_prop' ) ) {

	function wefix_shop_product_style_reset_loop_prop() {

		$wefix_shop_loop_prop = wc_get_loop_prop('wdt-shop-loop-prop', array ());

		if( is_array($wefix_shop_loop_prop) && !empty($wefix_shop_loop_prop) ) {
			foreach( $wefix_shop_loop_prop as $loop_prop ) {
				unset($GLOBALS['woocommerce_loop'][$loop_prop]);
			}
		}

		unset($GLOBALS['woocommerce_loop']['columns']);
		unset($GLOBALS['woocommerce_loop']['wdt-shop-loop-prop']);

	}

}


/*
 * Related Products Heading
 */

if( ! function_exists( 'wefix_shop_woo_related_products_heading' ) ) {

	function wefix_shop_woo_related_products_heading($heading) {

        if( !function_exists( 'wefix_pro' ) ) {
            return $heading; // If Theme-Plugin is not activated
        }

		$product_related_hide_title = wc_get_loop_prop('product_related_hide_title');
		$product_template = wefix_shop_woo_product_single_template_option();
        
		if( ( $product_template == 'custom-template' && $product_related_hide_title != 'true' ) || $product_template == 'woo-default' || ( $product_template == 'admin-template' && $product_related_hide_title != 'true' )  ) {

			$title = wefix_customizer_settings( 'wdt-single-product-related-title' );
			$heading = ( isset($title) && !empty($title) ) ? $title : $heading;

		} else if( ( $product_template == 'custom-template' ||  $product_template == 'admin-template' ) && $product_related_hide_title == 'true' ) {

            $heading = '';

        } 

        return $heading;

	}

	add_filter( 'woocommerce_product_related_products_heading', 'wefix_shop_woo_related_products_heading', 1 );

}


/*
 * Upsell Products Heading
 */

if( ! function_exists( 'wefix_shop_woo_upsells_products_heading' ) ) {

	function wefix_shop_woo_upsells_products_heading($heading) {

        if( !function_exists( 'wefix_pro' ) ) {
            return $heading; // If Theme-Plugin is not activated
        }

		$product_upsell_hide_title = wc_get_loop_prop('product_upsell_hide_title');
		$product_template = wefix_shop_woo_product_single_template_option();
		if( ( $product_template == 'custom-template' && $product_upsell_hide_title != 'true' ) || $product_template == 'woo-default' ) {

			$title = wefix_customizer_settings( 'wdt-single-product-upsell-title' );
            $heading = ( isset($title) && !empty($title) ) ? $title : $heading;

		} else if( $product_template == 'custom-template' && $product_upsell_hide_title == 'true' ) {

            $heading = '';

		}

		return $heading;

	}

	add_filter( 'woocommerce_product_upsells_products_heading', 'wefix_shop_woo_upsells_products_heading', 1 );

}