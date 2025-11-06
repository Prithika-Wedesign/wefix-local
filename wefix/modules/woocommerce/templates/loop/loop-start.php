<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Customized script - 'wefix_shop_products_list_class' function */
$columns = wc_get_loop_prop('columns');

$classes = apply_filters( 'wefix_woo_listings_class', array () );
$classes = ( is_array ($classes) && !empty ($classes) ) ? implode( ' ', $classes ) : '';

$settings = wefix_woo_listing_shop()->woo_default_settings();
extract($settings);


$apply_isotope = ( isset($apply_isotope) && !empty($apply_isotope) && ($apply_isotope == 1) ) ? 'products-apply-isotope' : '';
$newvar='';
?>

<ul class="products <?php echo esc_attr($apply_isotope); echo esc_attr($newvar);?> columns-<?php echo esc_attr( wc_get_loop_prop( 'columns' ) ); ?> <?php echo esc_attr($classes ); ?> wefix-related-product-carousel">

<?php
if( function_exists ( 'wefix_woo_loop_column_class' ) ) {
	?>
	
	<li class="product isotope-grid-sizer">
		<div class="<?php echo wefix_woo_loop_column_class ( $columns ); ?>"></div>
	</li>
	<?php
}