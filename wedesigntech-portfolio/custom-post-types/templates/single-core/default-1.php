<?php
$listing_id = get_the_ID();
$listing_taxonomies = wp_get_post_terms($listing_id, 'wdt_listings_category', array ('orderby' => 'parent'));
$term_ids = array_column($listing_taxonomies, 'term_id');
$term_ids_str =  implode(',', $term_ids);
?>

<div class="wdt-portfolio-single-default ">
    <div class="wdt-portfolio-single-image-area">
            <?php echo do_shortcode('[wdt_sp_media_images_list columns="3" include_featured_image="true" with_space="true"  listing_id="'.$listing_id.'"]'); ?>
            <?php
            echo '<div class="wdt-listings-utils-container">';
            echo '<div class="wdt-listings-utils-item wdt-listings-utils-title">';
                echo '<h3 class="wdt-listings-utils-title-item">'.get_the_title($listing_id).'</h3>';
            echo '</div></div>';
            ?>
            
            <?php the_content(); ?>
    </div>

    <div class="wdt-portfolio-single-content">
        <div class="wdt-portfolio-single-wrapper">       
            <div class="wdt-portfolio-content-group">
                <div class="wdt-sticky-wrapper">
                    <?php echo do_shortcode('[wdt_sp_contact_details type="listing" include_client="true" include_category="true"  include_estimation="true" include_place="true" include_duration="true" include_social="true" listing_id="'.$listing_id.'" ]'); ?>
                </div>
            </div>
        </div>
       
    </div> 
</div>