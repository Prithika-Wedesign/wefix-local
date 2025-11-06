<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( $max_value && $min_value === $max_value ) {
	?>
	<div class="quantity hidden">
		<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
	</div>
	<?php
} else {
	/* translators: %s: Quantity. */
	$label = ! empty( $args['product_name'] ) ? sprintf( esc_html__( '%s quantity', 'wefix' ), wp_strip_all_tags( $args['product_name'] ) ) : esc_html__( 'Quantity', 'wefix' );

	/* Customized script */

	$settings = wefix_woo_others()->woo_default_settings();
	extract($settings);

	 
	$woo_quantity_plusnminus = isset($enable_quantity_plusminus) ? $enable_quantity_plusminus : false;
	$enable_quantity_modern  = isset($enable_quantity_modern) ? $enable_quantity_modern : false;

	 $enable_quantity_modern = function_exists('wefix_customizer_settings') ? $enable_quantity_modern : false;



	$plusminus_class = 'quantity-with-arrows';
	if($woo_quantity_plusnminus) {
		$plusminus_class = 'quantity-with-plusminus';
	}

	?>
	<div class="quantity <?php if($enable_quantity_modern){ echo 'quantity_modern '; } echo esc_attr($plusminus_class); ?>">
		<?php
		/* Customized script */
		if($woo_quantity_plusnminus) {
			?>
			<input type="button" value="-" class="minus" />
			<?php
		}
		?>
		<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_html( $label ); ?></label>
		<?php
		if ( $enable_quantity_modern ) {
				$managing_stock = $product->managing_stock();
				$stock_quantity = $managing_stock ? $product->get_stock_quantity() : null;

				if ( $managing_stock && ! $is_sold_individually && $stock_quantity >= 1 ) {
					// Show select dropdown for tracked products with available stock
					?>
					<select id="quanity_modern" class="no-select2" data-select2="false" style="display:none">
						<?php 
						$max = min( 10, $stock_quantity );  
						for ( $i = 1; $i <= $max; $i++ ) {
							$label = $i == 10 ? "$i+" : $i;
							echo '<option value="' . $i . '">' . $label . '</option>';
						}
						?>
					</select>
					<?php
	} else {
        // Show number input for out-of-stock, not managing stock, or sold individually
        ?>
        <input
            type="number" 
			
            id="<?php echo esc_attr( $input_id ); ?>"
            class="<?php echo esc_attr( join( ' ', (array) $classes ) );  if($enable_quantity_modern) { echo ' quantity_modern'; } ?>"
            step="<?php echo esc_attr( $step ); ?>"
            min="<?php echo esc_attr( $min_value ); ?>"
            max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
            name="<?php echo esc_attr( $input_name ); ?>"
            value="<?php echo esc_attr( $input_value ); ?>"
            title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'wefix' ); ?>"
            placeholder="<?php echo esc_attr( $placeholder ); ?>"
            inputmode="<?php echo esc_attr( $inputmode ); ?>" />
        <?php
    }
}
?>
		 <input
            type="number" 
			
            id="<?php echo esc_attr( $input_id ); ?>"
            class="<?php echo esc_attr( join( ' ', (array) $classes ) );  if($enable_quantity_modern) { echo ' quantity_modern'; } ?>"
            step="<?php echo esc_attr( $step ); ?>"
            min="<?php echo esc_attr( $min_value ); ?>"
            max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
            name="<?php echo esc_attr( $input_name ); ?>"
            value="<?php echo esc_attr( $input_value ); ?>"
            title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'wefix' ); ?>"
            placeholder="<?php echo esc_attr( $placeholder ); ?>"
            inputmode="<?php echo esc_attr( $inputmode ); ?>" />
		<?php
		/* Customized script */
		if(!$woo_quantity_plusnminus) {
			?>
	        <a class="plus arrow-plus" href="#"><i class="wdticon-caret-up"></i></a>
	        <a class="minus arrow-minus" href="#"><i class="wdticon-caret-down"></i></a>
			<?php
		}
		?>

		<?php
		/* Customized script */
		if($woo_quantity_plusnminus) {
			?>
			<input type="button" value="+" class="plus" />
			<?php
		}
		?>
	</div><?php
}
?>