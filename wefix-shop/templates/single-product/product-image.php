<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
	'woocommerce-product-gallery',
	'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
	'woocommerce-product-gallery--columns-' . absint( $columns ),
	'images',
) );
?>
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
	<figure class="woocommerce-product-gallery__wrapper">
		<?php
		$attachment_id = '';
		 if(!empty($product)){
			 $attachment_id = $product->get_image_id();
		 }
$html = '';
$_featured_video = get_post_meta( get_the_ID(), '_featured_video', true);
$video_type = $_featured_video['video_input_type'] ?? '';
$video_file = $_featured_video['product_featured_video_upload'] ?? '';
$video_fallbackimage = $_featured_video['product_featured_video_fallbackimage'] ?? '';
$video_url  = $_featured_video['product_featured_video_url'] ?? ''; 
$raw_value = $_featured_video['default_playfeatured_video'] ?? false;
$default_playfeatured_video = ($raw_value === true || $raw_value === 'true' || $raw_value === 1 || $raw_value === '1') ? 1 : 0; 
if($default_playfeatured_video == 1){ $autooplay = 'autoplay'; } else {  $autooplay =''; }
		// if ( $product->get_image_id() ) {
		  
		// 	$html = wc_get_gallery_image_html( $post_thumbnail_id, true );
		// } else {
		
		// 	$html  = '<div class="woocommerce-product-gallery__image--placeholder" data-variant_id = "'.$attachment_id.'">';
		// 	$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" title="%s"/>', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'wefix-shop' ) );
		// 	$html .= '</div>';
		// }

		if ($product->get_image_id()) {
    // Video or image based on conditions
    // if ($video_type === 'upload' && !empty($video_file)) {
    //     $html = generate_video_html($video_file, $autooplay, $default_playfeatured_video, 'video');
    // } elseif ($video_type === 'url' && !empty($video_url)) {
    //     $html = generate_embed_html($video_url, $default_playfeatured_video);
    // } else {
        $html = wc_get_gallery_image_html($post_thumbnail_id, true);
    // }
} else {
    // No product image - show video or placeholder
    if ($video_type === 'upload' && !empty($video_file)) {
        $html = generate_video_html($video_file, $autooplay, $default_playfeatured_video, 'video');
    } elseif ($video_type === 'url' && !empty($video_url)) {
        $html = generate_embed_html($video_url, $default_playfeatured_video);
    } else {
        $html = '<div class="woocommerce-product-gallery__image--placeholder" data-variant_id="'.$attachment_id.'">';
        $html .= sprintf('<img src="%s" alt="%s" class="wp-post-image" title="%s"/>', 
                        esc_url(wc_placeholder_img_src('woocommerce_single')), 
                        esc_html__('Awaiting product image', 'wefix-shop'));
        $html .= '</div>';
    }
}

// Helper function for video HTML
function generate_video_html($video_file, $autooplay, $default_playfeatured_video, $type) {
    $html = '<div class="wdt-product-video swiper-slide" data-videotype="'.$type.'">';
    $html .= '<video '.$autooplay.' muted width="100%"><source src="'.esc_url($video_file).'" type="video/mp4">';
    $html .= 'Your browser does not support the video tag.</video>';
    $html .= generate_video_controls($default_playfeatured_video);
    $html .= '</div>';
    return $html;
}

// Helper function for embed HTML
function generate_embed_html($video_url, $default_playfeatured_video) {
    $html = '<div class="wdt-product-video swiper-slide" data-videotype="video_link">';
    
    if (strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false) {
        preg_match("/(youtu\.be\/|v=)([a-zA-Z0-9_-]+)/", $video_url, $matches);
        $youtube_id = $matches[2] ?? '';
        if ($youtube_id) {
            $embed_url = 'https://www.youtube.com/embed/'.$youtube_id.'?autoplay='.$default_playfeatured_video.'&mute=1&loop=1&controls=0&playlist='.$youtube_id;
            $html .= '<iframe width="100%" height="400" src="'.esc_url($embed_url).'" class="wdt-youtube-video" frameborder="0" allow="autoplay; fullscreen; encrypted-media" allowfullscreen></iframe>';
        }
    } elseif (strpos($video_url, 'vimeo.com') !== false) {
        preg_match("/vimeo\.com\/([0-9]+)/", $video_url, $matches);
        $vimeo_id = $matches[1] ?? '';
        if ($vimeo_id) {
            $embed_url = 'https://player.vimeo.com/video/'.$vimeo_id.'?autoplay='.$default_playfeatured_video.'&loop=1&muted=1&background=1';
            $html .= '<iframe width="100%" height="400" src="'.esc_url($embed_url).'" class="wdt-vimeo-video" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
        }
    } else {
        $html .= wp_oembed_get(esc_url($video_url));
    }
    
    $html .= generate_video_controls($default_playfeatured_video);
    $html .= '</div>';
    return $html;
}

// Helper function for video controls
function generate_video_controls($default_playfeatured_video) {
    if ($default_playfeatured_video == 1) {
        return '<div class="wdt_video_controls">
                <div class="wdt-product-play" style="display:none;"><i class="wdt_play_icon"></i></div>
                <div class="wdt-product-pause"><i class="wdt_pause_icon"></i></div>
                </div>';
    } else {
        return '<div class="wdt_video_controls">
                <div class="wdt-product-play"><i class="wdt_play_icon"></i></div>
                <div class="wdt-product-pause" style="display:none;"><i class="wdt_pause_icon"></i></div>
                </div>';
    }
}

		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped

		do_action( 'woocommerce_product_thumbnails' );
		?>
	</figure>
	<?php do_action( 'wefix_woo_loop_product_additional_labels' ); /* Customized script */ ?>
</div>
