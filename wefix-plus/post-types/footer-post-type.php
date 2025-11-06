<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'WeFixPlusFooterPostType' ) ) {

	class WeFixPlusFooterPostType {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

		function __construct() {

			add_action ( 'init', array( $this, 'wefix_register_cpt' ) );
			add_filter ( 'template_include', array ( $this, 'wefix_template_include' ) );
		}

		function wefix_register_cpt() {

			$labels = array (
				'name'				 => __( 'Footers', 'wefix-plus' ),
				'singular_name'		 => __( 'Footer', 'wefix-plus' ),
				'menu_name'			 => __( 'Footers', 'wefix-plus' ),
				'add_new'			 => __( 'Add Footer', 'wefix-plus' ),
				'add_new_item'		 => __( 'Add New Footer', 'wefix-plus' ),
				'edit'				 => __( 'Edit Footer', 'wefix-plus' ),
				'edit_item'			 => __( 'Edit Footer', 'wefix-plus' ),
				'new_item'			 => __( 'New Footer', 'wefix-plus' ),
				'view'				 => __( 'View Footer', 'wefix-plus' ),
				'view_item' 		 => __( 'View Footer', 'wefix-plus' ),
				'search_items' 		 => __( 'Search Footers', 'wefix-plus' ),
				'not_found' 		 => __( 'No Footers found', 'wefix-plus' ),
				'not_found_in_trash' => __( 'No Footers found in Trash', 'wefix-plus' ),
			);

			$args = array (
				'labels' 				=> $labels,
				'public' 				=> true,
				'exclude_from_search'	=> true,
				'show_in_nav_menus' 	=> false,
				'show_in_rest' 			=> true,
				'menu_position'			=> 26,
				'menu_icon' 			=> 'dashicons-editor-insertmore',
				'hierarchical' 			=> false,
				'supports' 				=> array ( 'title', 'editor', 'revisions' ),
			);

			register_post_type ( 'wdt_footers', $args );
		}

		function wefix_template_include($template) {
			if ( is_singular( 'wdt_footers' ) ) {
				if ( ! file_exists ( get_stylesheet_directory () . '/single-wdt_footers.php' ) ) {
					$template = WEFIX_PLUS_DIR_PATH . 'post-types/templates/single-wdt_footers.php';
				}
			}

			return $template;
		}
	}
}

WeFixPlusFooterPostType::instance();