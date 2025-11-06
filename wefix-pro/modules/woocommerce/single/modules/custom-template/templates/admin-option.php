<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

global $product;

get_header('shop'); ?>

<?php
/**
 * woocommerce_before_main_content hook.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 */
do_action('woocommerce_before_main_content');
?>

<?php while (have_posts()):
	the_post(); ?>

	<?php
	/**
	 * Hook: woocommerce_before_single_product.
	 *
	 * @hooked wc_print_notices - 10
	 */
	do_action('woocommerce_before_single_product');

	if (post_password_required()) {
		echo get_the_password_form(); // Display password form if the post is protected.
		return;
	}
	?>

	<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>
		<?php
		// Retrieve template ID from options
		$options = get_option(WEFIX_CUSTOMISER_VAL);
		$template_id = isset($options['wdt-single-product-default-elementortemplate'])
			? $options['wdt-single-product-default-elementortemplate']
			: '';
		?>

		<?php
		// Display the Elementor template content
		if (!empty($template_id) && class_exists('Elementor\Plugin')) {
			echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display($template_id);
		} else {
			echo '<p>Unable to load Elementor template. Please ensure Elementor is active and the template ID is valid.</p>';
		}
		?>

		<?php
		// Display post content (optional)
		// echo do_shortcode(get_the_content());
		?>
	</div>

	<?php do_action('woocommerce_after_single_product'); ?>

<?php endwhile; // End of the loop. ?>

<?php
/**
 * woocommerce_after_main_content hook.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');
?>

<?php
/**
 * woocommerce_sidebar hook.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action('woocommerce_sidebar');
?>

<?php get_footer('shop');

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
