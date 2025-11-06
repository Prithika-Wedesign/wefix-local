<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<section class="commententries <?php echo esc_attr($post_commentlist_style); ?>">
	<?php comments_template('', true); ?>
</section>