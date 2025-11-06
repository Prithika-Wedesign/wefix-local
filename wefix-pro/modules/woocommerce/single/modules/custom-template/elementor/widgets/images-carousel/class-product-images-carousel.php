<?php
namespace WeFixElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class WeFix_Shop_Widget_Product_Images_Carousel extends Widget_Base {

	public function get_categories() {
		return [ 'wdt-shop-widgets' ];
	}

	public function get_name() {
		return 'wdt-shop-product-single-images-carousel';
	}

	public function get_title() {
		return esc_html__( 'Product Single - Images Carousel', 'wefix-pro' );
	}

	public function get_style_depends() {
		return array( 'css-swiper', 'wdt-shop-products-carousel', 'wdt-shop-product-single-images-carousel' );
	}

	public function get_script_depends() {
		return array( 'single-product-jquery-swiper', 'wdt-shop-product-single-images-carousel' );
	}

	protected function register_controls() {

		$this->product_section();
		$this->carousel_section();
	}

	public function product_section() {

		$this->start_controls_section( 'product_images_carousel_section', array(
			'label' => esc_html__( 'General', 'wefix-pro' ),
		) );

			$this->add_control( 'product_id', array(
				'label'       => esc_html__( 'Product Id', 'wefix-pro' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__('Provide product id for which you have to display product iamges carousel. No need to provide ID if it is used in Product single page.', 'wefix-pro'),
			) );

			$this->add_control( 'include_featured_image', array(
				'label'        => esc_html__( 'Include Feature Image', 'wefix-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish, you can include featured image in this gallery.', 'wefix-pro'),
				'label_on'     => esc_html__( 'yes', 'wefix-pro' ),
				'label_off'    => esc_html__( 'no', 'wefix-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'include_variant_image', array(
				'label'        => esc_html__( 'Include Variant Image', 'wefix-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish, you can only include Variant images in this gallery.', 'wefix-pro'),
				'label_on'     => esc_html__( 'yes', 'wefix-pro' ),
				'label_off'    => esc_html__( 'no', 'wefix-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'include_product_labels', array(
				'label'        => esc_html__( 'Include Product Labels', 'wefix-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish, you can include product labels in this gallery.', 'wefix-pro'),
				'label_on'     => esc_html__( 'yes', 'wefix-pro' ),
				'label_off'    => esc_html__( 'no', 'wefix-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'enable_thumb_enlarger', array(
				'label'        => esc_html__( 'Enable Thumb Enlarger', 'wefix-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish, you can enable thumbnail enlarger in this gallery.', 'wefix-pro'),
				'label_on'     => esc_html__( 'yes', 'wefix-pro' ),
				'label_off'    => esc_html__( 'no', 'wefix-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control(
				'class',
				array (
					'label' => esc_html__( 'Class', 'wefix-pro' ),
					'type'  => Controls_Manager::TEXT
				)
			);

		$this->end_controls_section();
	}

	public function carousel_section() {

		$this->start_controls_section( 'product_carousel_section', array(
			'label' => esc_html__( 'Carousel Settings', 'wefix-pro' ),
		) );

			$this->add_control( 'carousel_effect', array(
				'label'       => esc_html__( 'Effect', 'wefix-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose effect for your carousel. Slides Per View has to be 1 for Fade effect.', 'wefix-pro' ),
				'default'     => '',
				'options'     => array(
					''     => esc_html__( 'Default', 'wefix-pro' ),
					'fade' => esc_html__( 'Fade', 'wefix-pro' ),
	            ),
	        ) );

			$this->add_responsive_control( 'carousel_slidesperview', array(
				'label'       => esc_html__( 'Slides Per View', 'wefix-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Number slides of to show in view port.', 'wefix-pro' ),
				'options'     => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4 ),
				'desktop_default'      => 4,
				'laptop_default'       => 4,
				'tablet_default'       => 2,
				'tablet_extra_default' => 2,
				'mobile_default'       => 1,
				'mobile_extra_default' => 1,
				'frontend_available'   => true,
				'condition'   => array( 'carousel_verticaldirection' => '' ),
	        ) );

			$this->add_control( 'carousel_loopmode', array(
				'label'        => esc_html__( 'Enable Loop Mode', 'wefix-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish, you can enable continuous loop mode for your carousel.', 'wefix-pro'),
				'label_on'     => esc_html__( 'yes', 'wefix-pro' ),
				'label_off'    => esc_html__( 'no', 'wefix-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_mousewheelcontrol', array(
				'label'        => esc_html__( 'Enable Mousewheel Control', 'wefix-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish, you can enable mouse wheel control for your carousel.', 'wefix-pro'),
				'label_on'     => esc_html__( 'yes', 'wefix-pro' ),
				'label_off'    => esc_html__( 'no', 'wefix-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_verticaldirection', array(
				'label'        => esc_html__( 'Enable Vertical Direction', 'wefix-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To make your slides to navigate vertically.', 'wefix-pro'),
				'label_on'     => esc_html__( 'yes', 'wefix-pro' ),
				'label_off'    => esc_html__( 'no', 'wefix-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_bulletpagination', array(
				'label'        => esc_html__( 'Enable Bullet Pagination', 'wefix-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To enable bullet pagination.', 'wefix-pro'),
				'label_on'     => esc_html__( 'yes', 'wefix-pro' ),
				'label_off'    => esc_html__( 'no', 'wefix-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_thumbnailpagination', array(
				'label'        => esc_html__( 'Enable Thumbnail Pagination', 'wefix-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To enable thumbnail pagination.', 'wefix-pro'),
				'label_on'     => esc_html__( 'yes', 'wefix-pro' ),
				'label_off'    => esc_html__( 'no', 'wefix-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_thumbnail_position', array(
				'label'       => esc_html__( 'Thumbnail Position', 'wefix-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Number slides of to show in view port.', 'wefix-pro' ),
				'options'     => array(
					''      => esc_html__('Bottom', 'wefix-pro'),
					'left'  => esc_html__('Left', 'wefix-pro'),
					'right' => esc_html__('Right', 'wefix-pro'),
				),
				'condition'   => array( 'carousel_thumbnailpagination' => 'true' ),
				'default'     => '',
	        ) );

			$this->add_control( 'carousel_slidesperview_thumbnail', array(
				'label'       => esc_html__( 'Number Of Images - Thumbnail', 'wefix-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Number of images to show in thumbnails.', 'wefix-pro' ),
				'options'     => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4 ),
				'condition'   => array( 'carousel_thumbnailpagination' => 'true' ),
				'default'     => '4',
	        ) );

			$this->add_control( 'carousel_arrowpagination', array(
				'label'        => esc_html__( 'Enable Arrow Pagination', 'wefix-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To enable arrow pagination.', 'wefix-pro'),
				'label_on'     => esc_html__( 'yes', 'wefix-pro' ),
				'label_off'    => esc_html__( 'no', 'wefix-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_arrowpagination_type', array(
				'label'       => esc_html__( 'Arrow Type', 'wefix-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose arrow pagination type for your carousel.', 'wefix-pro' ),
				'options'     => array(
					''      => esc_html__('Default', 'wefix-pro'),
					'type2' => esc_html__('Type 2', 'wefix-pro'),
				),
				'condition'   => array( 'carousel_arrowpagination' => 'true' ),
				'default'     => '',
	        ) );

			$this->add_control( 'carousel_scrollbar', array(
				'label'        => esc_html__( 'Enable Scrollbar', 'wefix-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To enable scrollbar for your carousel.', 'wefix-pro'),
				'label_on'     => esc_html__( 'yes', 'wefix-pro' ),
				'label_off'    => esc_html__( 'no', 'wefix-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_responsive_control('carousel_spacebetween', array(
				'label' => esc_html__('Space Between Sliders', 'wefix-pro'),
				'type' => Controls_Manager::TEXT,
				'default' => 20,
				'description' => esc_html__('Space between sliders can be given here.', 'wefix-pro'),
			));

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings();

		$output = '';

		$settings['module_id'] = $this->get_id();

		if($settings['product_id'] == '' && is_singular('product')) {
			global $post;
			$settings['product_id'] = $post->ID;
		}

		$slides_to_show = $settings['carousel_slidesperview'];
				$slides_to_scroll = 1;

				extract($settings);
					// Responsive control carousel
					$carousel_settings = array (
						'carousel_slidesperview' 			=> $slides_to_show
					);

					$active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();
					$breakpoint_keys = array_keys($active_breakpoints);

					$swiper_breakpoints = array ();
					$swiper_breakpoints[] = array (
						'breakpoint' => 319
					);
					$swiper_breakpoints_slides = array ();

					foreach($breakpoint_keys as $breakpoint) {
						$breakpoint_show_str = 'carousel_slidesperview_'.$breakpoint;
						$breakpoint_space_between = isset($settings['carousel_spacebetween_' . $breakpoint]) ? $settings['carousel_spacebetween_' . $breakpoint] : 10;
						$breakpoint_toshow = $$breakpoint_show_str;
						if($breakpoint_toshow == '') {
							if($breakpoint == 'mobile') {
								$breakpoint_toshow = 1;
							} else if($breakpoint == 'mobile_extra') {
								$breakpoint_toshow = 1;
							} else if($breakpoint == 'tablet') {
								$breakpoint_toshow = 2;
							} else if($breakpoint == 'tablet_extra') {
								$breakpoint_toshow = 2;
							} else if($breakpoint == 'laptop') {
								$breakpoint_toshow = 4;
							} else if($breakpoint == 'widescreen') {
								$breakpoint_toshow = 4;
							} else {
								$breakpoint_toshow = 4;
							}
						}

						$breakpoint_toscroll = 1;

						array_push($swiper_breakpoints, array (
								'breakpoint' => $active_breakpoints[$breakpoint]->get_value() + 1
							)
						);
						array_push($swiper_breakpoints_slides, array (
								'toshow' => (int)$breakpoint_toshow,
								'toscroll' => (int)$breakpoint_toscroll,
								'space_between' => (int) $breakpoint_space_between
							)
						);

					}

					array_push($swiper_breakpoints_slides, array (
							'toshow' => (int)$slides_to_show,
							'toscroll' => (int)$slides_to_scroll,
							'space_between' => isset($settings['carousel_spacebetween']) ? (int) $settings['carousel_spacebetween'] : 10
					)
					);

					$responsive_breakpoints = array ();

					if(is_array($swiper_breakpoints) && !empty($swiper_breakpoints)) {
						foreach($swiper_breakpoints as $key => $swiper_breakpoint) {
							$responsive_breakpoints[] = array_merge($swiper_breakpoint, $swiper_breakpoints_slides[$key]);
						}
					}

					$carousel_settings['responsive'] = $responsive_breakpoints;

					$carousel_settings_value = wp_json_encode($carousel_settings);

		if($settings['product_id'] != '') {

			$media_carousel_attributes = array ();

			array_push($media_carousel_attributes, 'data-carouseleffect="'.$settings['carousel_effect'].'"');
			array_push($media_carousel_attributes, 'data-carouselslidesperview="'.$settings['carousel_slidesperview'].'"');
			array_push($media_carousel_attributes, 'data-carouselloopmode="'.$settings['carousel_loopmode'].'"');
			array_push($media_carousel_attributes, 'data-carouselmousewheelcontrol="'.$settings['carousel_mousewheelcontrol'].'"');
			array_push($media_carousel_attributes, 'data-carouselverticaldirection="'.$settings['carousel_verticaldirection'].'"');
			array_push($media_carousel_attributes, 'data-carouselbulletpagination="'.$settings['carousel_bulletpagination'].'"');
			array_push($media_carousel_attributes, 'data-carouselthumbnailpagination="'.$settings['carousel_thumbnailpagination'].'"');
			array_push($media_carousel_attributes, 'data-carouselthumbnailposition="'.$settings['carousel_thumbnail_position'].'"');
			array_push($media_carousel_attributes, 'data-carouselslidesperviewthumbnail="'.$settings['carousel_slidesperview_thumbnail'].'"');
			array_push($media_carousel_attributes, 'data-carouselarrowpagination="'.$settings['carousel_arrowpagination'].'"');
			array_push($media_carousel_attributes, 'data-carouselscrollbar="'.$settings['carousel_scrollbar'].'"');
			array_push($media_carousel_attributes, 'data-carouselspacebetween="'.$settings['carousel_spacebetween'].'"');
			array_push($media_carousel_attributes, 'data-moduleid="'.$settings['module_id'].'"');
			array_push($media_carousel_attributes, 'data-carouselresponsive="'.esc_js($carousel_settings_value).'"');

			if(!empty($media_carousel_attributes)) {
				$media_carousel_attributes_string = implode(' ', $media_carousel_attributes);
			}

			$product = wc_get_product( $settings['product_id'] );

			$gallery_holder_class = '';
			if($settings['carousel_thumbnailpagination'] == 'true' && ($settings['carousel_thumbnail_position'] == 'left' || $settings['carousel_thumbnail_position'] == 'right')) {
				$gallery_holder_class = 'wdt-product-vertical-thumb';
			}
			$gallery_holder_thumb_class = '';
			if($settings['carousel_thumbnail_position'] == 'left' || $settings['carousel_thumbnail_position'] == 'right') {
				$gallery_holder_thumb_class = 'wdt-product-vertical-thumb-'.$settings['carousel_thumbnail_position'];
			}

			$output .= '<div class="wdt-product-image-gallery-holder '.$settings['class'].' '.$gallery_holder_class.' '.$gallery_holder_thumb_class.'">';

				// Gallery Images
				$output .= '<div class="wdt-product-image-gallery-container wdt-product-image-gallery-'.$settings['module_id'].' swiper-container" '.$media_carousel_attributes_string.'>';

			    	if($settings['enable_thumb_enlarger'] == 'true') {
						$output .= '<div class="wdt-product-image-gallery-thumb-enlarger"></div>';
					}

			    	if($settings['include_product_labels'] == 'true') {

						ob_start();
						wefix_shop_woo_show_product_additional_labels($product);
						$product_sale_flash = ob_get_clean();

						$output .= $product_sale_flash;

					}

				    $output .= '<div class="wdt-product-image-gallery swiper-wrapper">';
/* video code start here */
$_featured_video = get_post_meta( $settings['product_id'], '_featured_video', true);
$video_type = $_featured_video['video_input_type'] ?? '';
$video_file = $_featured_video['product_featured_video_upload'] ?? '';
$video_fallbackimage = $_featured_video['product_featured_video_fallbackimage'] ?? '';
$video_url  = $_featured_video['product_featured_video_url'] ?? ''; 
$raw_value = $_featured_video['default_playfeatured_video'] ?? false;
$default_playfeatured_video = ($raw_value === true || $raw_value === 'true' || $raw_value === 1 || $raw_value === '1') ? 1 : 0; 
if($default_playfeatured_video == 1){ $autooplay = 'autoplay'; } else {  $autooplay =''; }


if ($video_type === 'upload' && !empty($video_file)) {
	$output .= '<div class="wdt-product-video swiper-slide" data-videotype="video">'; 
			$output .= '<video '.$autooplay.'  muted width="100%"><source src="' . esc_url($video_file) . '" type="video/mp4">
					Your browser does not support the video tag.</video>';
			//$output .= '<div class="wdt-product-play">Play</div><div class="wdt-product-pause">Pause</div>';
			if($default_playfeatured_video == 1){ 
				$output .=  '<div class="wdt_video_controls"><div class="wdt-product-play" style="display:none;"><i class="wdt_play_icon"></i></div><div class="wdt-product-pause"><i class="wdt_pause_icon"></i></div></div>'; 
			}
				else { $output .=  '<div class="wdt_video_controls"><div class="wdt-product-play"><i class="wdt_play_icon"></i></div><div class="wdt-product-pause" style="display:none;"><i class="wdt_pause_icon"></i></div></div>'; }
			$output .= '</div>';
		} elseif ($video_type === 'url' && !empty($video_url)) {
    $output .= '<div class="wdt-product-video swiper-slide" data-videotype="video_link">'; 
    $custom_embed_url = ''; 
	$wdt_class_common = '';
    if (strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false) { 
        preg_match("/(youtu\.be\/|v=)([a-zA-Z0-9_-]+)/", $video_url, $matches);
        $youtube_id = $matches[2] ?? '';
        if ($youtube_id) {
			$wdt_class_common = 'wdt-youtube-video';
            $custom_embed_url = 'https://www.youtube.com/embed/' . $youtube_id . '?autoplay='. $default_playfeatured_video .'&mute=1&loop=1&controls=0&playlist=' . $youtube_id;
        }
    } elseif (strpos($video_url, 'vimeo.com') !== false) { 
        preg_match("/vimeo\.com\/([0-9]+)/", $video_url, $matches);
        $vimeo_id = $matches[1] ?? '';
        if ($vimeo_id) {
			$wdt_class_common = 'wdt-vimeo-video';
            $custom_embed_url = 'https://player.vimeo.com/video/' . $vimeo_id . '?autoplay='. $default_playfeatured_video .'&loop=1&muted=1&background=1';
        }
    } 
    if (!empty($custom_embed_url)) {
        $output .= '<iframe width="100%" height="400" src="' . esc_url($custom_embed_url) . '" class="' . $wdt_class_common .'"  
                     frameborder="0" allow="autoplay; fullscreen; encrypted-media" allowfullscreen></iframe>';
					 
    } else { 
        $output .= wp_oembed_get(esc_url($video_url));
    }
 if($default_playfeatured_video == 1){ 
				$output .=  '<div class="wdt_video_controls"><div class="wdt-product-play"><div class="wdt-product-play" style="display:none;"><i class="wdt_play_icon"></i></div><div class="wdt-product-pause"><i class="wdt_pause_icon"></i></div></div></div>'; 
			}
else { $output .=  '<div class="wdt_video_controls"><div class="wdt-product-play"><i class="wdt_play_icon"></i></div><div class="wdt-product-pause" style="display:none;"><i class="wdt_pause_icon"></i></div></div>'; }
			
    //$output .= '<div class="wdt-product-play">Play</div><div class="wdt-product-pause">Pause</div>';
    $output .= '</div>';
}


 /* video code ends here */

	    		 	if($settings['include_featured_image'] == 'true') {
 								$attachment_id = '';
								if(!empty($product)){
									$attachment_id = $product->get_image_id();
								}
								$output .= '<div class="wdt-product-image swiper-slide" data-variant_id = "'.$attachment_id.'" >';

								$image_size               = apply_filters( 'woocommerce_gallery_image_size', 'woocommerce_single' );
								$full_size                = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
								$full_src                 = wp_get_attachment_image_src( $attachment_id, $full_size );
								$image                    = wp_get_attachment_image( $attachment_id, $image_size, false, array(
									'title'                   => get_post_field( 'post_title', $attachment_id ),
									'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
									'data-src'                => $full_src[0],
									'data-large_image'        => $full_src[0],
									'data-large_image_width'  => $full_src[1],
									'data-large_image_height' => $full_src[2],
									'data-variant_id' => $attachment_id, 
									'class'                   => 'wp-post-image',
								) );

								$output .= $image;

							$output .= '</div>';

						}

						if($settings['include_variant_image'] == 'true') {
 								$attachment_id = '';
								if(!empty($product)){
									$attachment_id = $product->get_image_id();
								}
								 
						if ( ! empty( $product ) && $product->is_type( 'variable' ) ) {
							$variation_ids = $product->get_children(); // Get all variation IDs

							foreach ( $variation_ids as $variation_id ) {
								$variation = wc_get_product( $variation_id );
								$attachment_id = $variation->get_image_id();

								if ( $attachment_id ) {
									$output .= '<div class="wdt-product-image swiper-slide" data-variant_id="' . esc_attr( $variation_id ) . '">';

									$image_size = apply_filters( 'woocommerce_gallery_image_size', 'woocommerce_single' );
									$full_size = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
									$full_src = wp_get_attachment_image_src( $attachment_id, $full_size );

									$image = wp_get_attachment_image( $attachment_id, $image_size, false, array(
										'title'                   => get_post_field( 'post_title', $attachment_id ),
										'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
										'data-src'                => $full_src[0],
										'data-large_image'        => $full_src[0],
										'data-large_image_width'  => $full_src[1],
										'data-large_image_height' => $full_src[2],
										'data-variant_id'         => $variation_id,
										'class'                   => 'wp-post-image',
									) );

									$output .= $image;
									$output .= '</div>';
								}
							}

						}
					}

						$attachment_ids = '';
						if(!empty($product)){
							$attachment_ids = $product->get_gallery_image_ids();
						}

	                    if(is_array($attachment_ids) && !empty($attachment_ids)) {
	                        $i = 0;
	                        foreach($attachment_ids as $attachment_id) {

								$output .= '<div class="wdt-product-image swiper-slide" data-variant_id = "'.$attachment_id.'">';

									$image_size               = apply_filters( 'woocommerce_gallery_image_size', 'woocommerce_single' );
									$full_size                = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
									$full_src                 = wp_get_attachment_image_src( $attachment_id, $full_size );
									$image                    = wp_get_attachment_image( $attachment_id, $image_size, false, array(
										'title'                   => get_post_field( 'post_title', $attachment_id ),
										'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
										'data-src'                => $full_src[0],
										'data-large_image'        => $full_src[0],
										'data-large_image_width'  => $full_src[1],
										'data-large_image_height' => $full_src[2],
										'data-variant_id' => $attachment_id,
										'class'                   => '',
									) );

									$output .= $image;

                               	$output .= '</div>';

                                $i++;

	                        }
	                    }

		    		$output .= '</div>';

					$output .= '<div class="wdt-product-image-gallery-pagination-holder">';

						if($settings['carousel_bulletpagination'] == 'true') {
							$output .= '<div class="wdt-product-image-gallery-bullet-pagination"></div>';
						}

						if($settings['carousel_scrollbar'] == 'true') {
							$output .= '<div class="wdt-product-image-gallery-scrollbar"></div>';
						}

						if($settings['carousel_arrowpagination'] == 'true') {
							$output .= '<div class="wdt-product-image-gallery-arrow-pagination '.$settings['carousel_arrowpagination_type'].'">';
								$output .= '<a href="#" class="wdt-product-image-gallery-arrow-prev">'.esc_html__('Prev', 'wefix-pro').'</a>';
								$output .= '<a href="#" class="wdt-product-image-gallery-arrow-next">'.esc_html__('Next', 'wefix-pro').'</a>';
							$output .= '</div>';
						}

					$output .= '</div>';
		   		$output .= '</div>';

		   		if($settings['carousel_thumbnailpagination'] == 'true') {

			   		// Gallery Thumb
					$output .= '<div class="wdt-product-image-gallery-thumb-container swiper-container">';
					    $output .= '<div class="wdt-product-image-gallery-thumb swiper-wrapper">';
					 

$_featured_video = get_post_meta( get_the_ID(), '_featured_video', true); 
						 
$video_type = $_featured_video['video_input_type'] ?? '';
$video_file = $_featured_video['product_featured_video_upload'] ?? '';
$video_fallbackimage = $_featured_video['product_featured_video_fallbackimage'] ?? '';
$video_url  = $_featured_video['product_featured_video_url'] ?? '';
$raw_value = $_featured_video['default_playfeatured_video'] ?? false; 
$thumbnail_url = '';

if (strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false) {
    preg_match('/(youtu\.be\/|v=|embed\/)([a-zA-Z0-9_-]+)/', $video_url, $matches);
    $youtube_id = $matches[2] ?? '';

    if ($youtube_id) {
        $thumbnail_url = 'https://img.youtube.com/vi/' . $youtube_id . '/hqdefault.jpg';
    }
}
 
elseif (strpos($video_url, 'vimeo.com') !== false) {
    preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $video_url, $matches);
    $vimeo_id = $matches[1] ?? '';

    if ($vimeo_id) { 
        $response = wp_remote_get("https://vimeo.com/api/oembed.json?url=https://vimeo.com/" . $vimeo_id);
        if (!is_wp_error($response)) {
            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body);
            if (!empty($data->thumbnail_url)) {
                $thumbnail_url = $data->thumbnail_url;
            }
        }
    }
}
 
elseif (!empty($video_file)) { 
    $thumbnail_url = $video_fallbackimage;  
}
 
    if (!empty($thumbnail_url)) {
        $output .= '<div class="swiper-slide">';
        $output .= '<img src="'.esc_url($thumbnail_url).'" title="'.esc_attr__('Video Preview', 'wefix-pro').'" alt="'.esc_attr__('Video Preview', 'wefix-pro').'" />';
        $output .= '</div>';
    }
 


		    				if($settings['include_featured_image'] == 'true') {
								$featured_image_id = get_post_thumbnail_id($settings['product_id']);
								$image_details = wp_get_attachment_image_src($featured_image_id, 'woocommerce_single');

								$output .= '<div class="swiper-slide"><img src="'.esc_url($image_details[0]).'" title="'.esc_html__('Gallery Thumb', 'wefix-pro').'" alt="'.esc_html__('Gallery Thumb', 'wefix-pro').'" /></div>';
							}
							if($settings['include_variant_image'] == 'true') { 
								$product_id = $settings['product_id']; 

								if ( $product && $product->is_type('variable') ) {
									$available_variations = $product->get_children(); // Gets variation IDs

									foreach ( $available_variations as $variation_id ) {
										$variation = wc_get_product( $variation_id );
										$variation_image_id = $variation->get_image_id();

										if ( $variation_image_id ) {
											$image_details = wp_get_attachment_image_src( $variation_image_id, 'woocommerce_single' );

											if ( $image_details ) {
												$output .= '<div class="swiper-slide">
													<img src="' . esc_url( $image_details[0] ) . '" title="' . esc_attr__( 'Variant Image', 'wefix-pro' ) . '" alt="' . esc_attr__( 'Variant Image', 'wefix-pro' ) . '" />
												</div>';
											}
										}
									}
								}
								
							}

		                    if(is_array($attachment_ids) && !empty($attachment_ids)) {
		                        $i = 0;
		                        foreach($attachment_ids as $attachment_id) {
	                                $image_details = wp_get_attachment_image_src($attachment_id, 'woocommerce_single');
	                               	$output .= '<div class="swiper-slide"><img src="'.esc_url($image_details[0]).'" alt="'.esc_html__('Gallery Thumb', 'wefix-pro').'" title="'.esc_html__('Gallery Thumb', 'wefix-pro').'"/></div>';
	                                $i++;
		                        }
		                    }

			    		$output .= '</div>';
			    	$output .= '</div>';

			    }

		   	$output .= '</div>';

		} else {

			$output .= esc_html__('Please provide product id to display corresponding data!', 'wefix-pro');

		}

		echo $output;

	}

}