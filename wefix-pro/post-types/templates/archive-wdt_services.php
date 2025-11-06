<?php
/**
 * Archive template for wdt_services post type
 */

get_header();

echo '<section id="primary" class="' . esc_attr(wefix_get_primary_classes()) . '">';
// Get global settings
$global_settings = get_option('_wefix_service_settings', []);
$currency_symbol = esc_html($global_settings['currency_symbol'] ?? '');
$column_count = isset($global_settings['layout']) ? absint($global_settings['layout']) : 3;
$column_class = 'wdt-columns-' . max(1, min(5, $column_count));

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

?>

<div class="wdt-service-archive-wrapper <?php echo esc_attr($column_class); ?>">
    
    <?php if (have_posts()) : ?>
        
        <?php while (have_posts()) : the_post(); ?>
            <?php
            $service_id = get_the_ID();
            $meta = get_post_meta($service_id, '_wefix_service_settings', true);
            $meta = is_array($meta) ? $meta : [];

            $price = $meta['service_price'] ?? '';
            $offerprice = $meta['service_offer_price'] ?? '';
            $duration = $meta['service_price_duration'] ?? '';
            ?>
            
            <div class="wdt-service-item">

                <div class="wdt-service-media-group">
                    <div class="wdt-service-image">
                        <?php
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('medium_large');
                        } else {
                            $title = get_the_title();
                            $placeholder_url = 'https://dummyimage.com/1200x800/cccccc/999999.jpg?text=' . esc_attr($title);
                            echo '<img src="' . esc_url($placeholder_url) . '" alt="' . esc_attr($title) . '" />';
                        }
                        ?>
                    </div>
                </div>

                <div class="wdt-service-detail-group">

                    <div class="wdt-service-title">
                        <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                    </div>

                    <?php if ($price || $offerprice) : ?>
                        <div class="wdt-service-price-group">
                            <div class="wdt-service-price">
                                <?php
                                if ($offerprice) {
                                    echo '<del>' . esc_html($currency_symbol . $price) . '</del>';
                                } else {
                                    echo esc_html($currency_symbol . $price . ' / ' . $duration);
                                }
                                ?>
                            </div>

                            <?php if ($offerprice) : ?>
                                <div class="wdt-service-offerprice">
                                    <?php echo esc_html($currency_symbol . $offerprice . ' / ' . $duration); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="wdt-service-excerpt">
                        <?php the_excerpt(); ?>
                    </div>

                    <div class="wdt-service-button">
                        <a href="<?php the_permalink(); ?>">
                            <?php esc_html_e('Read More', 'wefix-pro'); ?>
                        </a>
                    </div>

                </div>

            </div>

        <?php endwhile; ?>

    <?php else : ?>

        <p><?php esc_html_e('No services found.', 'wefix-pro'); ?></p>

    <?php endif; ?>

</div>

<?php
echo '</section><!-- Primary End -->';
    get_footer();
?>