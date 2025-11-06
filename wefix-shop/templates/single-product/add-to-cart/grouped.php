<?php
/**
 * Grouped product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/grouped.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.2.0
 */

defined( 'ABSPATH' ) || exit;

global $product, $post;

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="cart grouped_form accordion" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>

    <div class="accordion-item">
        <button type="button" class="wdt-accordion-header">
            <?php echo esc_html__( 'Popular Upgrades', 'wefix-shop' ); ?>
        </button>
        <div class="accordion-body">
            <?php
            $quantites_required = false;
            $previous_post = $post;

            foreach ( $grouped_products as $grouped_product_child ) {
                $post_object = get_post( $grouped_product_child->get_id() );
                $quantites_required = $quantites_required || ( $grouped_product_child->is_purchasable() && ! $grouped_product_child->has_options() );
                $post = $post_object;
                setup_postdata( $post );
                ?>
                
                <div class="upgrade-item">
                    <label for="quantity-<?php echo esc_attr( $grouped_product_child->get_id() ); ?>" class="upgrade-label">
                        <?php if ( has_post_thumbnail( $grouped_product_child->get_id() ) ) : ?>
                            <div class="upgrade-thumb"><?php echo get_the_post_thumbnail( $grouped_product_child->get_id(), 'thumbnail' ); ?></div>
                        <?php endif; ?>
                        <span class="upgrade-title">
                            <a href="<?php echo esc_url( get_permalink( $grouped_product_child->get_id() ) ); ?>">
                                <?php echo $grouped_product_child->get_name(); ?>
                            </a>
                        </span>
                        
                        <div class="upgrade-info">
                            <span class="upgrade-price"><?php echo $grouped_product_child->get_price_html(); ?></span>
                            <span class="upgrade-stock"><?php echo wc_get_stock_html( $grouped_product_child ); ?></span>
                        </div>
                    </label>

                    <div class="upgrade-checkbox">
                        <?php if ( $grouped_product_child->is_purchasable() && $grouped_product_child->is_in_stock() ) : ?>
                            <input type="checkbox" name="quantity[<?php echo esc_attr( $grouped_product_child->get_id() ); ?>]" value="1" id="quantity-<?php echo esc_attr( $grouped_product_child->get_id() ); ?>" />
                        <?php else : ?>
                            <span class="sold-out"><?php echo esc_html__( 'Sold Out', 'wefix-shop' ); ?></span>  
                        <?php endif; ?>
                    </div>
                </div>
                
                <?php
            }
            $post = $previous_post;
            setup_postdata( $post );
            ?>
        </div>
    </div>

    <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />
    <button type="submit" class="single_add_to_cart_button button alt">
        <?php echo esc_html( $product->single_add_to_cart_text() ); ?>
    </button>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>