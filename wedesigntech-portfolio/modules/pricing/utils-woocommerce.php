<?php

if(!function_exists('wdt_on_order_status_completion_from_listings_module')) {
	function wdt_on_order_status_completion_from_listings_module($order_id) {
		$order   = new WC_Order( $order_id );
		$user_id = get_post_meta($order_id, '_customer_user', true);

		$items = $order->get_items();
		foreach ( $items as $item_id => $item ) {

			$wdt_item_id = wc_get_order_item_meta($item_id, 'wdt_item_id');
			$post_type = get_post_type($wdt_item_id);

			// For Listing
			if(in_array($post_type, array('wdt_listings'))) {

				$listing_id = $wdt_item_id;

				$current_timestamp = strtotime(current_time(get_option('date_format')));

				// Update listings
				$purchased_users = get_post_meta($listing_id, 'purchased_users', true);
				$purchased_users = (is_array($purchased_users) && !empty($purchased_users)) ? $purchased_users : array();

				$purchased_users[$user_id] = array ( 'purchased-date' => $current_timestamp );
				update_post_meta($listing_id, 'purchased_users', $purchased_users);

				$purchased_users_timestamp = get_post_meta($listing_id, 'purchased_users_timestamp', true);
				$purchased_users_timestamp = (is_array($purchased_users_timestamp) && !empty($purchased_users_timestamp)) ? $purchased_users_timestamp : array();
				$purchased_users_timestamp[$current_timestamp][] = $user_id;
				update_post_meta($listing_id, 'purchased_users_timestamp', $purchased_users_timestamp);

				// Update users
				$purchased_listings = get_user_meta($user_id, 'purchased_listings', true);
				$purchased_listings = (is_array($purchased_listings) && !empty($purchased_listings)) ? $purchased_listings : array();
				$purchased_listings[$listing_id] = array ( 'purchased-date' => $current_timestamp );
				update_user_meta($user_id, 'purchased_listings', $purchased_listings);

				$purchased_listings_timestamp = get_user_meta($user_id, 'purchased_listings_timestamp', true);
				$purchased_listings_timestamp = (is_array($purchased_listings_timestamp) && !empty($purchased_listings_timestamp)) ? $purchased_listings_timestamp : array();
				$purchased_listings_timestamp[$current_timestamp][] = $listing_id;
				update_user_meta($user_id, 'purchased_listings_timestamp', $purchased_listings_timestamp);

			}

		}

	}
	add_action('woocommerce_order_status_completed','wdt_on_order_status_completion_from_listings_module');
}

if(!function_exists('wdt_on_order_status_cancellation_from_listings_module')) {
	function wdt_on_order_status_cancellation_from_listings_module($order_id) {

		$order = new WC_Order( $order_id );
		$user_id = get_post_meta($order_id, '_customer_user', true);

		$items = $order->get_items();
		foreach ( $items as $item_id => $item ) {

			$wdt_item_id = wc_get_order_item_meta($item_id, 'wdt_item_id');
			$post_type = get_post_type($wdt_item_id);

			// For Listings
			if(in_array($post_type, array('wdt_listings'))) {

				$listing_id = $wdt_item_id;

				// Update listings

				$purchased_users = get_post_meta($listing_id, 'purchased_users', true);
				$purchased_users = (is_array($purchased_users) && !empty($purchased_users)) ? $purchased_users : array();
				if(array_key_exists($user_id, $purchased_users)) {
				    unset($purchased_users[$user_id]);
				}
				update_post_meta($listing_id, 'purchased_users', $purchased_users);

				$purchased_users_timestamp = get_post_meta($listing_id, 'purchased_users_timestamp', true);
				$purchased_users_timestamp = (is_array($purchased_users_timestamp) && !empty($purchased_users_timestamp)) ? $purchased_users_timestamp : array();
				foreach($purchased_users_timestamp as $purchased_users_timestamp_key => $purchased_users_timestamp_data) {
					if(in_array($user_id, $purchased_users_timestamp_data)) {
					    unset($purchased_users_timestamp[$purchased_users_timestamp_key][array_search($user_id, $purchased_users_timestamp_data)]);
					}
				}
				update_post_meta($listing_id, 'purchased_users_timestamp', $purchased_users_timestamp);


				// Update users

				$purchased_listings = get_user_meta($user_id, 'purchased_listings', true);
				$purchased_listings = (is_array($purchased_listings) && !empty($purchased_listings)) ? $purchased_listings : array();
				if(array_key_exists($listing_id, $purchased_listings)) {
					unset($purchased_listings[$listing_id]);
				}
				update_user_meta($user_id, 'purchased_listings', $purchased_listings);

				$purchased_listings_timestamp = get_user_meta($user_id, 'purchased_listings_timestamp', true);
				$purchased_listings_timestamp = (is_array($purchased_listings_timestamp) && !empty($purchased_listings_timestamp)) ? $purchased_listings_timestamp : array();
				foreach($purchased_listings_timestamp as $purchased_listings_timestamp_key => $purchased_listings_timestamp_data) {
					if(in_array($listing_id, $purchased_listings_timestamp_data)) {
						unset($purchased_listings_timestamp[$purchased_listings_timestamp_key][array_search($listing_id, $purchased_listings_timestamp_data)]);
					}
				}
				update_user_meta($user_id, 'purchased_listings_timestamp', $purchased_listings_timestamp);

			}

		}

	}
	add_action('woocommerce_order_status_cancelled','wdt_on_order_status_cancellation_from_listings_module');
	add_action('woocommerce_order_status_refunded','wdt_on_order_status_cancellation_from_listings_module');
}

// While deleting user
if(!function_exists('wdt_on_user_deletion_from_listings_module')) {
    function wdt_on_user_deletion_from_listings_module($user_id) {

		$args = array (
			'posts_per_page' => -1,
			'post_type'      => 'wdt_listings',
			'meta_query'     => array (),
			'tax_query'      => array (),
		);

		$listings_query = new WP_Query( $args );

		if ( $listings_query->have_posts() ) :

			$i = 1;
			while ( $listings_query->have_posts() ) :
				$listings_query->the_post();

				$listing_id = get_the_ID();

				// Remove user from listing

				$purchased_users = get_post_meta($listing_id, 'purchased_users', true);
				$purchased_users = (is_array($purchased_users) && !empty($purchased_users)) ? $purchased_users : array();
				if(array_key_exists($user_id, $purchased_users)) {
				    unset($purchased_users[$user_id]);
				}
				update_post_meta($listing_id, 'purchased_users', $purchased_users);

				$purchased_users_timestamp = get_post_meta($listing_id, 'purchased_users_timestamp', true);
				$purchased_users_timestamp = (is_array($purchased_users_timestamp) && !empty($purchased_users_timestamp)) ? $purchased_users_timestamp : array();
				foreach($purchased_users_timestamp as $purchased_users_timestamp_key => $purchased_users_timestamp_data) {
					if(in_array($user_id, $purchased_users_timestamp_data)) {
					    unset($purchased_users_timestamp[$purchased_users_timestamp_key][array_search($user_id, $purchased_users_timestamp_data)]);
					}
				}
				update_post_meta($listing_id, 'purchased_users_timestamp', $purchased_users_timestamp);

			endwhile;
			wp_reset_postdata();

		endif;

    }
    add_action('delete_user', 'wdt_on_user_deletion_from_listings_module');
}

?>