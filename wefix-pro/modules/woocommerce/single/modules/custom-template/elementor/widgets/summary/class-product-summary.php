<?php
namespace WeFixElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

class WeFix_Shop_Widget_Product_Summary extends Widget_Base {

	public function get_categories() {
		return [ 'wdt-shop-widgets' ];
	}

	public function get_name() {
		return 'wdt-shop-product-single-summary';
	}

	public function get_title() {
		return esc_html__( 'Product Single - Summary', 'wefix-pro' );
	}

	public function get_style_depends() {
		$styles = apply_filters( 'wefix_shop_woo_single_summary_styles',  array ( 'wdt-shop-product-single-summary' ) );
		return $styles;
	}

	public function get_script_depends() {
		$scripts = apply_filters( 'wefix_shop_woo_single_summary_scripts',  array ( 'wdt-shop-product-single-summary' ) );
		return $scripts;
	}

	public function dynamic_register_controls() {
	}

	protected function register_controls() {

		$this->start_controls_section( 'product_summary_section', array(
			'label' => esc_html__( 'General', 'wefix-pro' ),
		) );

			$this->add_control( 'product_id', array(
				'label'       => esc_html__( 'Product Id', 'wefix-pro' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__('Provide product id for which you have to display product summary items. No need to provide ID if it is used in Product single page.', 'wefix-pro'),
			) );


			$repeater = new Repeater();

			$repeater->add_control( 'summary_item', array(
				'label'       => esc_html__( 'Summary Item', 'wefix-pro' ),
				'type'        => Controls_Manager::SELECT,
				'default'     =>'title',
				'options'     => apply_filters( 'wefix_shop_woo_single_summary_options',
					array (
						'title'              => esc_html__('Summary Title', 'wefix-pro'),
						'rating'             => esc_html__('Summary Rating', 'wefix-pro'),
						'price'              => esc_html__('Summary Price', 'wefix-pro'),
						'excerpt'            => esc_html__('Summary Excerpt', 'wefix-pro'),
						'addtocart'          => esc_html__('Summary Add To Cart', 'wefix-pro'),
						'buttons'            => esc_html__('Summary Buttons', 'wefix-pro'),
						'meta'               => esc_html__('Summary Meta', 'wefix-pro'),
						'meta_sku'           => esc_html__('Summary Meta SKU', 'wefix-pro'),
						'meta_category'      => esc_html__('Summary Meta Category', 'wefix-pro'),
						'meta_tag'           => esc_html__('Summary Meta Tag', 'wefix-pro'),
						'meta_brand'         => esc_html__('Summary Meta Brand', 'wefix-pro'),
						'additional_content' => esc_html__('Summary Additional Content', 'wefix-pro'),
						'separator1'         => esc_html__('Summary Separator 1', 'wefix-pro'),
						'separator2'         => esc_html__('Summary Separator 2', 'wefix-pro'),
						'clear1'             => esc_html__('Summary Clear 1', 'wefix-pro'),
						'clear2'         	 => esc_html__('Summary Clear 2', 'wefix-pro'),
						'stock'              => esc_html__('Summary Stock', 'wefix-pro')
					)
				)
	        ) );

			$this->add_control(
				'items',
				array (
					'label' => esc_html__( 'Items', 'wefix-pro' ),
					'type' => Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' =>  array (
						array (
							'summary_item' => 'title'
						),
						array (
							'summary_item' => 'stock'
						),
						array (
							'summary_item' => 'rating'
						),
						array (
							'summary_item' => 'price'
						),
						array (
							'summary_item' => 'excerpt'
						),
						array (
							'summary_item' => 'addtocart'
						),
						array (
							'summary_item' => 'meta'
						),
					),
					'title_field' => '{{{ summary_item }}}',
				)
			);

			$repeater = new Repeater();

			$repeater->add_control( 'button_item', array(
				'label'       => esc_html__( 'Button Item', 'wefix-pro' ),
				'type'        => Controls_Manager::SELECT,
				'default'     =>'',
				'options'     => apply_filters( 'wefix_shop_woo_single_summary_button_options',
					array (
						''          => esc_html__('None', 'wefix-pro'),
						'btaddtocart'  => esc_html__('Button Add to Cart', 'wefix-pro'),
						'wishlist'  => esc_html__('Button Wishlist', 'wefix-pro'),
						'compare'   => esc_html__('Button Compare', 'wefix-pro'),
						'buynow' 	=> esc_html__('Button Buy Now', 'wefix-pro')
					)
				)
	        ) );

			$this->add_control(
				'button_items',
				array (
					'label' => esc_html__( 'Button Items', 'wefix-pro' ),
					'type' => Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' =>  array (),
					'title_field' => '{{{ button_item }}}',
				)
			);

			$this->add_control( 'content', array(
				'label' => esc_html__( 'Additional Content', 'wefix-pro' ),
				'type'  => Controls_Manager::WYSIWYG,
			) );

			$this->add_control( 'alignment', array(
				'label'   => esc_html__( 'Alignment', 'wefix-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''            => esc_html__('Left', 'wefix-pro'),
					'aligncenter' => esc_html__('Center', 'wefix-pro'),
					'alignright'  => esc_html__('Right', 'wefix-pro'),
				),
				'description' => esc_html__( 'Choose alignment you would like to use for your product summary.', 'wefix-pro' ),
			) );

			$this->add_control( 'button_style', array(
				'label'   => esc_html__( 'Button Style', 'wefix-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'simple',
				'options' => array(
					'simple'        => esc_html__( 'Simple', 'wefix-pro' ),
					'bgfill'        => esc_html__( 'BG Fill', 'wefix-pro' ),
					'brdrfill'      => esc_html__( 'Border Fill', 'wefix-pro' ),
					'skin-bgfill'   => esc_html__( 'Skin BG Fill', 'wefix-pro' ),
					'skin-brdrfill' => esc_html__( 'Skin Border Fill', 'wefix-pro' ),
				),
				'description' => esc_html__( 'This option is applicable for all buttons used in product summary.', 'wefix-pro' ),
			) );

			$this->add_control( 'button_radius', array(
				'label'   => esc_html__( 'Button Radius', 'wefix-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					'square'  => esc_html__( 'Square', 'wefix-pro' ),
					'rounded' => esc_html__( 'Rounded', 'wefix-pro' ),
					'circle'  => esc_html__( 'Circle', 'wefix-pro' ),
				),
				'condition'   => array( 'button_style' => array ('bgfill', 'brdrfill', 'skin-bgfill', 'skin-brdrfill') ),
				'description' => esc_html__( 'This option is applicable for all buttons used in product summary.', 'wefix-pro' ),
			) );

            $this->add_control( 'button_apply_design_to_cart', array(
				'label'        => esc_html__( 'Button Apply Design to Cart', 'wefix-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'yes', 'wefix-pro' ),
				'label_off'    => esc_html__( 'no', 'wefix-pro' ),
				'default'      => '',
				'return_value' => 'true',
				'description'  => esc_html__( 'Use this option if you want to apply button design to Cart button also.', 'wefix-pro' ),
			) );

			$this->add_control( 'button_inline_alignment', array(
				'label'        => esc_html__( 'Button Inline Alignment', 'wefix-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'yes', 'wefix-pro' ),
				'label_off'    => esc_html__( 'no', 'wefix-pro' ),
				'default'      => '',
				'return_value' => 'true',
				'description'  => esc_html__( 'This option is applicable for all buttons used in product summary.', 'wefix-pro' ),
			) );

			$this->add_control( 'button_hide_text', array(
				'label'        => esc_html__( 'Button Hide Text', 'wefix-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'yes', 'wefix-pro' ),
				'label_off'    => esc_html__( 'no', 'wefix-pro' ),
				'default'      => 'false',
				'return_value' => 'true',
				'description'  => esc_html__( 'This option is applicable for all buttons used in product summary.', 'wefix-pro' ),
			) );

			$this->add_control( 'meta_inline_alignment', array(
				'label'        => esc_html__( 'Meta Inline Alignment', 'wefix-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'yes', 'wefix-pro' ),
				'label_off'    => esc_html__( 'no', 'wefix-pro' ),
				'default'      => '',
				'return_value' => 'true',
				'description'  => esc_html__( 'This option is applicable for all buttons used in product summary.', 'wefix-pro' ),
			) );

			$this->add_control(
				'class',
				array (
					'label' => esc_html__( 'Class', 'wefix-pro' ),
					'type'  => Controls_Manager::TEXT
				)
			);

		$this->end_controls_section();

		$this->dynamic_register_controls();

	}

	protected function render() {

		$settings = $this->get_settings();

		$output = '';

		if($settings['product_id'] == '' && is_singular('product')) {
			global $post;
			$settings['product_id'] = $post->ID;
		}

		if($settings['product_id'] != '' && $settings['items'] != '') {

			global $product;
			$product = wc_get_product( $settings['product_id'] );
			if(!is_object($product)) {
				return $output;
			}

			/* Load Other Modules */

			$sub_modules = array (
				'includes' => 'listings/includes/index'
			);

			if( is_array( $sub_modules ) && !empty( $sub_modules ) ) {
				foreach( $sub_modules as $sub_module ) {

					if( $file_content = wefix_woo_locate_file( $sub_module ) ) {
						include_once $file_content;
					}

				}
			}

			/* Shortcode Options */

			$items = array ();
			$summary_items = $settings['items'];
			if(is_array($summary_items) && !empty($summary_items)) {
				foreach($summary_items as $summary_item) {
					array_push($items, $summary_item['summary_item']);
				}
			}

			$button_items = array ();
			$summary_button_items = $settings['button_items'];
			if(is_array($summary_button_items) && !empty($summary_button_items)) {
				foreach($summary_button_items as $summary_button_item) {
					array_push($button_items, $summary_button_item['button_item']);
				}
			}

			$button_style_cls = '';
			if($settings['button_style'] != '') {
				$button_style_cls = 'style-'.$settings['button_style'];
			}

			$button_radius_cls = '';
			if($settings['button_radius'] != '') {
				$button_radius_cls = 'radius-'.$settings['button_radius'];
			}

			$button_inline_alignment_cls = '';
			if($settings['button_inline_alignment'] == 'true') {
				$button_inline_alignment_cls = 'align-inline';
			}

			$button_hide_text_cls = '';
			if($settings['button_hide_text'] == 'true') {
				$button_hide_text_cls = 'hide-button-text';
			}

			$meta_inline_alignment_cls = '';
			if($settings['meta_inline_alignment'] == 'true') {
				$meta_inline_alignment_cls = 'align-inline';
			}


			if(!is_product()) {
				$output .= '<div class="woocommerce single-product">';
					$output .= '<div class="product">';
			}
					$output .= '<div class="wdt-product-summary summary entry-summary '.esc_attr($settings['class']).' '.esc_attr($settings['alignment']).'">';

						// Title
						$title = '';
						if(in_array('title', $items)) {
							ob_start();
							woocommerce_template_single_title();
							$woocommerce_template_single_title = ob_get_clean();
							$woocommerce_template_single_title = trim($woocommerce_template_single_title);
							$title = '<div class="wdt-single-product-title">'.$woocommerce_template_single_title.'</div>';
						}
 
						// Stock
						$stock = '';
						if ( in_array( 'stock', $items ) ) {  
							$stock_qty = $product->get_stock_quantity();  

							if ( $product->is_in_stock() && $product->managing_stock() && $stock_qty !== null ) {

								$total_stock = get_post_meta( $product->get_id(), '_total_stock', true );

								if ( empty( $total_stock ) ) {
									$total_stock = $stock_qty;
								}
								$percentage  = ( $total_stock > 0 ) ? ( $stock_qty / $total_stock ) * 100 : 0;

								$stock  = '<div class="wdt-single-product-stock in_stock pro-page">';
								$stock .= '<div class="stock-message">Hurry! Only ' . esc_html( $stock_qty ) . ' items left in stock!</div>';

								$stock .= '<div class="stock-progress">';
								$stock .= '<div class="stock-progress-bar" style="width:' . esc_attr( $percentage ) . '%;"></div>';
								$stock .= '</div>';

								$stock .= '</div>';

							}
						}


						// Rating
						$rating = '';
						if ( in_array( 'rating', $items ) ) {
							global $product;

							if ( $product && $product->get_review_count() ) {
								$average = (float) $product->get_average_rating();
								$count   = (int) $product->get_review_count();
								$stars   = wc_get_rating_html( $average ); // HTML for stars

								$rating  = '<div class="custom-rating">';
									$rating .= $stars;
									$rating .= ' <span class="average-rating">' . esc_html( number_format_i18n( $average, 1 ) ) . '</span>';
									$rating .= ' <span class="review-count">' . esc_html( $count ) . ' ' . esc_html( _n( 'review', 'reviews', $count, 'wefix-pro' ) ) . '</span>';
								$rating .= '</div>';
							}
						}


						// Price
						$price = '';
						if(in_array('price', $items)) {
							ob_start();
							woocommerce_template_single_price();
							$woocommerce_template_single_price = ob_get_clean();
							$woocommerce_template_single_price = trim($woocommerce_template_single_price);
							$price = '<div class="wdt-single-product-price">'.$woocommerce_template_single_price.'</div>';
						}

						// Countdown
						$countdown = '';
						if(in_array('countdown', $items)) {
							ob_start();
							if ( function_exists( 'wefix_shop_products_sale_countdown_timer' ) ) {
								wefix_shop_products_sale_countdown_timer();
							}
							$woocommerce_template_countdown = ob_get_clean();
							$countdown = $woocommerce_template_countdown;
						}

						// Excerpt
						$excerpt = '';
						if(is_product()) {
							if(in_array('excerpt', $items)) {
								ob_start();
								woocommerce_template_single_excerpt();
								$woocommerce_template_single_excerpt = ob_get_clean();
								$excerpt = $woocommerce_template_single_excerpt;
							}
						} else {
							$excerpt = '<div class="woocommerce-product-details__short-description">'.$product->get_short_description().'</div>';
						}

						// Add to cart
						$addtocart = '';
						if(in_array('addtocart', $items)) {
							ob_start();
                            if($settings['button_apply_design_to_cart'] == 'true') {
							    echo '<div class="product-buttons-wrapper product-button product-button-cart '.esc_attr($button_style_cls).' '.esc_attr($button_radius_cls).' '.esc_attr($button_inline_alignment_cls).' '.esc_attr($button_hide_text_cls).'">';
                            } else {
							    echo '<div class="product-buttons-wrapper product-button product-button-cart '.esc_attr($button_inline_alignment_cls).' '.esc_attr($button_hide_text_cls).'">';
                            }
								echo '<div class="wc_inline_buttons">';
									echo '<div class="wcwl_btn_wrapper wc_btn_inline">';
										woocommerce_template_single_add_to_cart();
									echo '</div>';
								echo '</div>';
							echo '</div>';
							$woocommerce_template_single_add_to_cart = ob_get_clean();
							$addtocart = $woocommerce_template_single_add_to_cart;
						}

						// Wishlist, Compare, Quick View, Size Guide
						$buttons = '';
						if(in_array('buttons', $items)) {

							$btaddtocart = $wishlist = $compare = $quickview = $sizeguide = $buynow = '';
							if(in_array('btaddtocart', $button_items)) {
								ob_start();
								woocommerce_template_single_add_to_cart();
								$woocommerce_template_single_add_to_cart = ob_get_clean();
								$btaddtocart = $woocommerce_template_single_add_to_cart;
							}
							if(in_array('wishlist', $button_items)) {
								ob_start();
								do_action( 'wefix_woo_loop_product_button_elements_wishlist' );
								$wishlist = ob_get_clean();
								$wishlist = $wishlist;
							}
							if(in_array('compare', $button_items)) {
								ob_start();
								do_action( 'wefix_woo_loop_product_button_elements_compare' );
								$compare = ob_get_clean();
								$compare = $compare;
							}
							if(in_array('quickview', $button_items)) {
								ob_start();
								do_action( 'wefix_woo_loop_product_button_elements_quickview' );
								$quickview = ob_get_clean();
								$quickview = $quickview;
							}
							if(in_array('sizeguide', $button_items)) {
								ob_start();
								do_action( 'wefix_woo_loop_product_button_elements_sizeguide' );
								$sizeguide = ob_get_clean();
								$sizeguide = $sizeguide;
							}

							if(in_array('buynow', $button_items)) {
								ob_start();
								do_action( 'wefix_woo_loop_product_button_elements_buynow' );
								$buynow = ob_get_clean();
								$buynow = $buynow;
							}

							ob_start();
							echo '<div class="product-buttons-wrapper product-button '.esc_attr($button_style_cls).' '.esc_attr($button_radius_cls).' '.esc_attr($button_inline_alignment_cls).' '.esc_attr($button_hide_text_cls).'">';
								echo '<div class="wc_inline_buttons">';
									// Build selected items
									foreach ($button_items as $key => $value) {
										if($value == 'btaddtocart') {
											echo '<div class="wcwl_btn_wrapper wc_btn_inline" data-tooltip="'.esc_attr__('Add to Cart', 'wefix-pro').'">';
												echo $$value;
											echo '</div>';
										} else {
											echo $$value;
										}
									}
								echo '</div>';
							echo '</div>';

							$woocommerce_buttons = ob_get_clean();
							$buttons = $woocommerce_buttons;

						}

						// Meta
						$meta = '';
						if(in_array('meta', $items)) {
							ob_start();
							echo '<div class="product_meta_wrapper '.esc_attr($meta_inline_alignment_cls).'">';
								woocommerce_template_single_meta();
							echo '</div>';
							$woocommerce_template_single_meta = ob_get_clean();
							$meta = $woocommerce_template_single_meta;
						}

						// Meta SKU
						$meta_sku = '';
						if(in_array('meta_sku', $items)) {
							if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) {
								$meta_data_sku = ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'wefix-pro' );
								$meta_sku = '<div class="product_meta_wrapper '.esc_attr($meta_inline_alignment_cls).'"><div class="product_meta"><span class="sku_wrapper"><strong>'.esc_html__( 'SKU:', 'wefix-pro' ).'</strong><span class="sku"> ' . $meta_data_sku . ' </span></span></div></div>';
							}
						}

						// Meta Category
						$meta_category = '';
						if(in_array('meta_category', $items)) {
							$meta_category = '<div class="product_meta_wrapper '.esc_attr($meta_inline_alignment_cls).'"><div class="product_meta">'.wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in"><strong>' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'wefix-pro' ) . '</strong> ', '</span>' ).'</div></div>';
						}

						// Meta Tag
						$meta_tag = '';
						if(in_array('meta_tag', $items)) {
							$meta_tag = '<div class="product_meta_wrapper '.esc_attr($meta_inline_alignment_cls).'"><div class="product_meta">'.wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as"><strong>' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'wefix-pro' ) . '</strong> ', '</span>' ).'</div></div>';
						}

						// Meta Brand
                        $meta_brand = '';
                        if(in_array('meta_brand', $items)) {
                            $meta_brand = '<div class="product_meta_wrapper '.esc_attr($meta_inline_alignment_cls).'"><div class="product_meta">'.do_shortcode('[yith_wcbr_product_brand product_id="'.esc_attr($settings['product_id']).' show_logo="yes" show_title="no" ]').'</div></div>';
                        }

						// Share / Follow
						$share_follow = '';
						if(in_array('share_follow', $items) && function_exists('wefix_shop_single_product_sociable_share_follow')) {
							$share_follow = wefix_shop_single_product_sociable_share_follow($settings['product_id'], $settings['share_follow_type'], $settings['social_icon_style'], $settings['social_icon_radius'], $settings['social_icon_inline_alignment']);
						}

						// Additional Content
						$additional_content = '';
						if(in_array('additional_content', $items)) {
							if(isset($settings['content']) && !empty($settings['content'])) {
								$additional_content = '<div class="wdt-product-summary-additional-content">';
									$additional_content .= do_shortcode($settings['content']);
								$additional_content .= '</div>';
							}
						}

						// Additional Info

						$settings = wefix_woo_single_core()->woo_default_settings();
						extract($settings);

						$additional_info = '';
						if(in_array('additional_info', $items)) {
							ob_start();
							if ( function_exists( 'wefix_shop_products_additional_info' ) ) {
								wefix_shop_products_additional_info();
							}
							$products_additional_info = ob_get_clean();
							$additional_info = $products_additional_info;
						}

						// Additional Info - Delivery Period
						$additional_info_delivery_period = '';
						if(in_array('additional_info_delivery_period', $items)) {
							ob_start();
							if ( function_exists( 'wefix_shop_products_ai_delivery_period' ) ) {
								wefix_shop_products_ai_delivery_period(true, $product_ai_delivery_period);
							}
							$products_additional_info_delivery_period = ob_get_clean();
							$additional_info_delivery_period = $products_additional_info_delivery_period;
						}

						// Additional Info - Real Time Visitors
						$additional_info_realtime_visitors = '';
						if(in_array('additional_info_realtime_visitors', $items)) {
							ob_start();
							if ( function_exists( 'wefix_shop_products_ai_realtime_visitors' ) ) {
								wefix_shop_products_ai_realtime_visitors(true, $product_ai_visitors_min_value, $product_ai_visitors_max_value);
							}
							$products_additional_info_realtime_visitors = ob_get_clean();
							$additional_info_realtime_visitors = $products_additional_info_realtime_visitors;
						}

						// Additional Info - Shipping Offer
						$additional_info_shipping_offer = '';
						if(in_array('additional_info_shipping_offer', $items)) {
							ob_start();
							if ( function_exists( 'wefix_shop_products_ai_shipping_offer' ) ) {
								wefix_shop_products_ai_shipping_offer(true);
							}
							$products_additional_info_shipping_offer = ob_get_clean();
							$additional_info_shipping_offer = $products_additional_info_shipping_offer;
						}

						// Additional Info - Weight
						$additional_info_weight = '';
						if(in_array('additional_info_weight', $items)) {
							$additional_info_weight = '<div class="product_additional_info_wrapper"><div class="product_additional_info"><span class="weight_wrapper"><strong>'.esc_html__('Weight:', 'wefix-pro').'</strong><span class="product_weight"> ' . esc_html( $product->get_weight() ) .  esc_html( get_option('woocommerce_weight_unit') ). ' </span></span></div></div>';
						}

						// Additional Info - Dimensions
						$additional_info_dimensions = '';
						if(in_array('additional_info_dimensions', $items)) {
							$dimensions = wc_format_dimensions($product->get_dimensions(false));
							if ( $product->has_dimensions() ) {
								$additional_info_dimensions = '<div class="product_additional_info_wrapper"><div class="product_additional_info"><span class="dimensions_wrapper"><strong>'.esc_html__('Dimensions:', 'wefix-pro').'</strong><span class="product_dimensions"> ' . esc_html( $dimensions ) . ' </span></span></div></div>';
							}
						}

						// Additional Info - Color
						$additional_info_color = '';
						if(in_array('additional_info_color', $items)) {
							ob_start();
							if ( function_exists( 'wefix_shop_products_ai_color' ) ) {
								wefix_shop_products_ai_color(true);
							}
							$products_additional_info_color = ob_get_clean();
							$additional_info_color = $products_additional_info_color;
						}

						// Additional Info - Size
						$additional_info_size = '';
						if(in_array('additional_info_size', $items)) {
							ob_start();
							if ( function_exists( 'wefix_shop_products_ai_size' ) ) {
								wefix_shop_products_ai_size(true);
							}
							$products_additional_info_size = ob_get_clean();
							$additional_info_size = $products_additional_info_size;
						}

						// Buy Now

						$buy_now = '';
						if(in_array('buy_now', $items)) {
							ob_start();
							if ( function_exists( 'wefix_shop_products_buy_now' ) ) {
								wefix_shop_products_buy_now();
							}
							$products_buy_now = ob_get_clean();
							$buy_now = $products_buy_now;
						}

						// Separator 1
						$separator1 = '';
						if(in_array('separator1', $items)) {
							$separator1 = '<div class="wdt-single-product-separator"></div>';
						}

						// Separator 2
						$separator2 = '';
						if(in_array('separator2', $items)) {
							$separator2 = '<div class="wdt-single-product-separator"></div>';
						}

						// Separator 1
						$clear1 = '';
						if(in_array('clear1', $items)) {
							$clear1 = '<div class="wdt-single-product-clear"></div>';
						}

						// Separator 2
						$clear2 = '';
						if(in_array('clear2', $items)) {
							$clear2 = '<div class="wdt-single-product-clear"></div>';
						}

						// Build selected items
						foreach ($items as $key => $value) {
							$output .= $$value;
						}

					$output .= '</div>';
			if(!is_product()) {
					$output .= '</div>';
				$output .= '</div>';
			}

			wp_register_style( 'wefix-woo-product-summary', '', array (), WEFIX_PRO_VERSION, 'all' );
			wp_enqueue_style( 'wefix-woo-product-summary' );

			$css = '';

			// Load common styles
			if( !is_shop() && !is_product_category() && !is_product_tag() && !is_product() && !is_cart() && !is_checkout() ) {

				$css_file_path = WEFIX_MODULE_DIR . '/woocommerce/assets/css/common.css';

				if(!isset($GLOBALS['wdt_shop_loaded_files']) || (isset($GLOBALS['wdt_shop_loaded_files']) && !in_array($css_file_path, $GLOBALS['wdt_shop_loaded_files']))) {

					if(file_exists($css_file_path)) {
						ob_start();
						include( $css_file_path );
						$css .= "\n\n".ob_get_clean();
					}

					if(!isset($GLOBALS['wdt_shop_loaded_files'])) {
						$GLOBALS['wdt_shop_loaded_files'] = array ();
					}

					array_push($GLOBALS['wdt_shop_loaded_files'], $css_file_path);

				}

				$css_file_path = WEFIX_MODULE_DIR . '/woocommerce/single/assets/css/common.css';

				if(!isset($GLOBALS['wdt_shop_loaded_files']) || (isset($GLOBALS['wdt_shop_loaded_files']) && !in_array($css_file_path, $GLOBALS['wdt_shop_loaded_files']))) {

					if(file_exists($css_file_path)) {
						ob_start();
						include( $css_file_path );
						$css .= "\n\n".ob_get_clean();
					}

					if(!isset($GLOBALS['wdt_shop_loaded_files'])) {
						$GLOBALS['wdt_shop_loaded_files'] = array ();
					}

					array_push($GLOBALS['wdt_shop_loaded_files'], $css_file_path);

				}

			}

			if( !empty($css) ) {
				wp_add_inline_style( 'wefix-woo-product-summary', $css );
			}


		} else {

			$output .= esc_html__('Please provide product id to display corresponding data!', 'wefix-pro');

		}

		echo $output;

	}

}
