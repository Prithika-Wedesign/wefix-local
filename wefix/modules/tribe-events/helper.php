<?php

if (! function_exists('wefix_event_breadcrumb_title')) {
    function wefix_event_breadcrumb_title($title)
    {
        if (get_post_type() == 'tribe_events' && is_single()) {
            $etitle = esc_html__('Event Detail', 'wefix');
            return '<h1>' . $etitle . '</h1>';
        } else {
            return $title;
        }
    }

    add_filter('wefix_breadcrumb_title', 'wefix_event_breadcrumb_title', 20, 1);
    add_filter('wefix_breadcrumbs', 'breadcrumbs_event_module');
    function breadcrumbs_event_module($breadcrumbs)
    {
        global $post;
        if (is_singular('tribe_events')) {
            $breadcrumbs[] = '<span class="current">' . esc_html(get_the_title($post->ID)) . '</span>';
        }
        return $breadcrumbs;
    }
}
