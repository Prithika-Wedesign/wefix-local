<form method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>">
	<input id="s" name="s" type="text"
		value="<?php echo get_search_query(); ?>" placeholder="<?php echo esc_attr__("Enter Keyword", 'wefix'); ?>" class="text_input" />
	<ul class="quick_search_results"></ul>
	<input type="hidden" id="search_security_nonce" name="search_security_nonce" value="<?php echo wp_create_nonce('search_data_fetch_nonce'); ?>" />
	<input name="submit" type="submit" value="<?php esc_attr_e('Go', 'wefix'); ?>" />
</form>