<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ordering_display_type = isset($ordering_display_type) ? $ordering_display_type : '';
if($ordering_display_type == 'list') {
    $class = 'woocommerce-ordering-list';
} else {
    $class = 'woocommerce-ordering';
}

?>
<form class="<?php echo esc_attr($class); ?>" method="get">
    <?php
    if($ordering_display_type == 'list') {

        if(is_shop()) {
            $shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
        } elseif (is_tax('product_cat') || is_tax('product_tag')) {
            $term = get_queried_object();
            $shop_page_url = get_term_link( $term );
        }
        $modified_query_string = $orderby_value = '';
        $query_string = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : array ();
        if(!empty($query_string)) {
            $query_vars = explode('&', $query_string);
            foreach($query_vars as $key => $query_var) {
                $query_single_var = explode('=', $query_var);
                if(isset($query_single_var[0]) && $query_single_var[0] != 'orderby') {
                    $modified_query_string .= $query_var.'&';
                } else if(isset($query_single_var[0]) && $query_single_var[0] == 'orderby') {
                    $orderby_value = $query_single_var[1];
                }
            }
        }

        $href = $shop_page_url.'?'.trim($modified_query_string, '&');
        ?>
        <ul>
            <?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
                <li>
                    <a href="<?php echo esc_attr( $href.'&orderby='.$id ); ?>" class="<?php echo ($orderby_value == $id) ? 'selected' : ''; ?>"><?php echo esc_html( $name ); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
        <input type="hidden" name="paged" value="1" />
        <?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
    <?php } else { ?>
        <select name="orderby" class="orderby" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>">
            <?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
                <option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="hidden" name="paged" value="1" />
        <?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
    <?php } ?>
</form>
