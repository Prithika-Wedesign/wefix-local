<?php if (! defined('ABSPATH')) {
	exit;
} ?>
<?php
$content = trim(get_the_content('', false, $post_ID));
if (empty($content)) {
	$qoute_text = (isset($meta['fieldset_link1']) && $meta['fieldset_link1']['fieldset_qoute_text'] != '') ? $meta['fieldset_link1']['fieldset_qoute_text'] :'Quote Text';
	$qoute_author  = (isset($meta['fieldset_link1']) && $meta['fieldset_link1']['fieldset_qoute_author'] != '') ? $meta['fieldset_link1']['fieldset_qoute_author'] : 'Quote Author';
?>
	<div class="entry-quote-inner">
		<div class="entry-quote-wrapper">
			<span class="wdticon-quote"></span>
			<blockquote>
				<p class="quote-text"><?php echo esc_html($qoute_text); ?></p>
				<cite class="quote-author"><?php echo esc_html($qoute_author); ?></cite>
			</blockquote>
		</div>
	</div>
<?php
} else {
	preg_match('/<blockquote>(.*?)<\/blockquote>/s', $content, $match);
	$quote_string = isset( $match[0] ) ? $match[0] : '';
	if (!empty($quote_string)) : ?>
		<div class="entry-quote-inner">
			<div class="entry-quote-text">
				<span class="wdticon-quote-left"></span>
				<?php echo "{$quote_string}"; ?>
			</div><!-- Quote Text -->
		</div><!-- Quote Inner -->
	<?php endif;
} ?>