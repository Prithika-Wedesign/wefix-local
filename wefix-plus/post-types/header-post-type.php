<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'WeFixPlusHeaderPostType' ) ) {

	class WeFixPlusHeaderPostType {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

		function __construct() {

			add_action ( 'init', array( $this, 'wefix_register_cpt' ), 5 );
			add_filter ( 'template_include', array ( $this, 'wefix_template_include' ) );
		}

		function wefix_register_cpt() {

			$labels = array (
				'name'				 => __( 'Headers', 'wefix-plus' ),
				'singular_name'		 => __( 'Header', 'wefix-plus' ),
				'menu_name'			 => __( 'Headers', 'wefix-plus' ),
				'add_new'			 => __( 'Add Header', 'wefix-plus' ),
				'add_new_item'		 => __( 'Add New Header', 'wefix-plus' ),
				'edit'				 => __( 'Edit Header', 'wefix-plus' ),
				'edit_item'			 => __( 'Edit Header', 'wefix-plus' ),
				'new_item'			 => __( 'New Header', 'wefix-plus' ),
				'view'				 => __( 'View Header', 'wefix-plus' ),
				'view_item' 		 => __( 'View Header', 'wefix-plus' ),
				'search_items' 		 => __( 'Search Headers', 'wefix-plus' ),
				'not_found' 		 => __( 'No Headers found', 'wefix-plus' ),
				'not_found_in_trash' => __( 'No Headers found in Trash', 'wefix-plus' ),
			);

			$args = array (
				'labels' 				=> $labels,
				'public' 				=> true,
				'exclude_from_search'	=> true,
				'show_in_nav_menus' 	=> false,
				'show_in_rest' 			=> true,
				'menu_position'			=> 25,
				'menu_icon' 			=> 'dashicons-heading',
				'hierarchical' 			=> false,
				'supports' 				=> array ( 'title', 'editor', 'revisions' ),
			);

			register_post_type ( 'wdt_headers', $args );
		}

		function wefix_template_include($template) {
			if ( is_singular( 'wdt_headers' ) ) {
				if ( ! file_exists ( get_stylesheet_directory () . '/single-wdt_headers.php' ) ) {
					$template = WEFIX_PLUS_DIR_PATH . 'post-types/templates/single-wdt_headers.php';
				}
			}

			return $template;
		}
	}
}

WeFixPlusHeaderPostType::instance();