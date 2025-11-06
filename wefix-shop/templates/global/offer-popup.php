<?php
global $product;
//Ad media in product page
$product_id = get_the_ID();
$ad_url = get_post_meta($product_id, '_ad_media_url', true);
$show_popup = false;
$popup_content = '';

// Determine type
if (strpos($ad_url, 'youtu') !== false) {
    preg_match('/(?:youtu\.be\/|youtube\.com\/watch\?v=)([^&]+)/', $ad_url, $matches);
    $video_id = isset($matches[1]) ? $matches[1] : '';
    if ($video_id) {
        $embed_url = 'https://www.youtube.com/embed/' . esc_attr($video_id) . '?autoplay=1&mute=1&controls=1';
        $popup_content = '<iframe width="560" height="315" src="' . esc_url($embed_url) . '" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
        $show_popup = true;
    }

} elseif (strpos($ad_url, 'vimeo.com') !== false) {
    preg_match('/vimeo\.com\/(\d+)/', $ad_url, $matches);
    $video_id = isset($matches[1]) ? $matches[1] : '';
    if ($video_id) {
        $embed_url = 'https://player.vimeo.com/video/' . esc_attr($video_id) . '?autoplay=0&muted=0';
        $popup_content = '<iframe width="560" height="315" src="' . esc_url($embed_url) . '" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';
        $show_popup = true;
    }

} else {
    $ext = strtolower(pathinfo($ad_url, PATHINFO_EXTENSION));
    if ($ext === 'mp4') {
        $popup_content = '<video controls autoplay muted><source src="' . esc_url($ad_url) . '" type="video/mp4">Your browser does not support the video tag.</video>';
        $show_popup = true;
    } elseif (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
        $attachment_id = attachment_url_to_postid($ad_url);
        $alt_text = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
        $popup_content = '<img src="' . esc_url($ad_url) . '" alt="' . esc_attr($alt_text) . '">';
        $show_popup = true;
    }
}
?>
 

<?php if ($show_popup): ?>
  <div id="custom-ad-popup" class="ad-popup">
    <button class="close-ad"><i class="fa fa-window-close"></i></button>
    <?php echo $popup_content; ?>
  </div>
<?php endif; ?>
