<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if (! class_exists ( 'WeFixProMegaMenuPostType' ) ) {

	class WeFixProMegaMenuPostType {

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

            add_action ( 'admin_print_styles', array( $this, 'wefix_admin_print_styles') );

            add_action( 'wp_nav_menu_item_custom_fields', array( $this, 'custom_fields' ), 10, 4 );
        	add_action( 'wp_update_nav_menu_item', array( $this, 'wefix_update_menu_item'), 10, 2 );
   			add_filter( 'wp_setup_nav_menu_item', array( $this, 'wefix_add_custom_nav_fields' ) );
   			add_filter( 'wp_nav_menu_objects', array( $this, 'wefix_nav_menu_objects' ),10, 2 );

   			add_filter( 'nav_menu_css_class', array( $this, 'add_classes' ), 10, 4 );
            add_filter( 'nav_menu_li_attributes', array( $this, 'add_li_attribute' ), 10, 4 );
            add_filter( 'walker_nav_menu_start_el', array( $this, 'mega_menu_output' ), 10, 4 );
        }

		function wefix_register_cpt() {

			$labels = array (
				'name'				 => __( 'Mega Menus', 'wefix-pro' ),
				'singular_name'		 => __( 'Mega Menu', 'wefix-pro' ),
				'menu_name'			 => __( 'Mega Menus', 'wefix-pro' ),
				'add_new'			 => __( 'Add Mega Menu', 'wefix-pro' ),
				'add_new_item'		 => __( 'Add New Mega Menu', 'wefix-pro' ),
				'edit'				 => __( 'Edit Mega Menu', 'wefix-pro' ),
				'edit_item'			 => __( 'Edit Mega Menu', 'wefix-pro' ),
				'new_item'			 => __( 'New Mega Menu', 'wefix-pro' ),
				'view'				 => __( 'View Mega Menu', 'wefix-pro' ),
				'view_item' 		 => __( 'View Mega Menu', 'wefix-pro' ),
				'search_items' 		 => __( 'Search Mega Menus', 'wefix-pro' ),
				'not_found' 		 => __( 'No Mega Menus found', 'wefix-pro' ),
				'not_found_in_trash' => __( 'No Mega Menus found in Trash', 'wefix-pro' ),
			);

			$args = array (
				'labels'              => $labels,
				'public'              => true,
				'exclude_from_search' => true,
				'menu_position'       => 27,
				'menu_icon'           => 'dashicons-editor-table',
				'hierarchical'        => false,
				'show_in_rest'        => true,
				'supports'            => array ( 'title', 'editor', 'revisions' ),
			);

			register_post_type ( 'wdt_mega_menus', $args );
		}

		function wefix_template_include($template) {
			if ( is_singular( 'wdt_mega_menus' ) ) {
				if ( ! file_exists ( get_stylesheet_directory () . '/single-wdt_mega_menus.php' ) ) {
					$template = WEFIX_PRO_DIR_PATH . 'post-types/templates/single-wdt_mega_menus.php';
				}
			}

			return $template;
		}

        function wefix_admin_print_styles() {

            global $pagenow;

            if( $pagenow == 'nav-menus.php' ) {

                echo '<style id="wdt-nav-menu">';
                echo 'li.menu-item.menu-item-wdt_mega_menus p.field-wdt-menu-icon,li.menu-item.menu-item-wdt_mega_menus p.field-wdt-menu-image,li.menu-item.menu-item-wdt_mega_menus p.field-wdt-menu-image-position,li.menu-item.menu-item-wdt_mega_menus p.field-wdt-menu-child-animation { display:none; }';
                echo 'li.menu-item:not(.menu-item-wdt_mega_menus) .field-wdt-mega-menu-width, li.menu-item:not(.menu-item-wdt_mega_menus) .field-wdt-mega-menu-position { display: none; }';
                echo '</style>';
            }
        }

        function custom_fields( $item_id, $item, $depth, $args ) {

			$settings = get_post_meta( $item->ID, '_wdt_mega_menu_settings',true);
			$settings = is_array( $settings ) ? $settings : array();

			$width    = isset( $settings['width'] ) ? $settings['width'] : '';
			$position = isset( $settings['position'] ) ? $settings['position'] : ''; ?>
        	<p class="field-wdt-mega-menu-width description description-thin">
        		<label for="edit-menu-item-wdt-mega-menu-width-<?php echo esc_attr( $item_id ); ?>">
        			<?php esc_html_e( 'Mega Menu Width (px)','wefix-pro' ); ?><br />
        			<input type="text" id="edit-menu-wdt-mega-menu-width-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-wdt-mega-menu-width" name="menu-item-wdt-mega-menu-width[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $width ); ?>"/>
                    <span class="description"><?php esc_html_e('Please set Mega Menu Width',  'wefix-pro'); ?></span>
        		</label>
        	</p>

        	<p class="field-wdt-mega-menu-position description description-wide">
        		<label for="edit-menu-item-wdt-mega-menu-position-<?php echo esc_attr( $item_id ); ?>">
        			<?php esc_html_e( 'Mega Menu Position','wefix-pro' ); ?><br />
        			<select id="edit-menu-wdt-mega-menu-position-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-wdt-mega-menu-position" name="menu-item-wdt-mega-menu-position[<?php echo esc_attr( $item_id ); ?>]">
                        <option value="none" <?php selected( $position, '' );?>><?php esc_html_e('None','wefix-pro');?></option>
                        <option value="left" <?php selected( $position, 'left' );?>><?php esc_html_e('Left','wefix-pro');?></option>
                        <option value="right" <?php selected( $position, 'right' );?>><?php esc_html_e('Right','wefix-pro');?></option>
                        <option value="center" <?php selected( $position, 'center' );?>><?php esc_html_e('Top - Center','wefix-pro');?></option>
        			</select>
                    <span class="description"><?php esc_html_e('Please set Mega Menu Position',  'wefix-pro'); ?></span>
        		</label>
        	</p><?php
        }

        function wefix_update_menu_item( $menu_id, $menu_item_db_id ) {

        	if( isset( $_POST['menu-item-wdt-mega-menu-position'][$menu_item_db_id] ) ) {
	        	foreach( (array) $_POST['menu-item-wdt-mega-menu-position'][$menu_item_db_id] as $position ){

	        		$data = array( 'position' => $position, 'width' => $_POST['menu-item-wdt-mega-menu-width'][$menu_item_db_id] );
	        		$data = array_filter( $data );

	        		if( $data ) {
	        			update_post_meta( $menu_item_db_id, '_wdt_mega_menu_settings', $data );
	        		} else {
	        			delete_post_meta( $menu_item_db_id, '_wdt_mega_menu_settings' );
	        		}
	        	}
        	}
        }

        function wefix_add_custom_nav_fields( $menu_item ) {

			$settings = get_post_meta( $menu_item->ID, '_wdt_mega_menu_settings', true );
			$settings = is_array( $settings ) ? $settings : array();

			if( isset( $settings['width'] ) ) {
				$menu_item->mm_width =  $settings['width'];
			}

			if( isset( $settings['position'] ) ) {
				$menu_item->mm_position =  $settings['position'];
			}

            return $menu_item;
        }

        function wefix_nav_menu_objects( $items, $args ) {

            $itemsMega = array();
            $itemsMegaCustomWidth = array();

            foreach ( $items as $item ) {

                // find all parents with mega menu siblings
                if ( $item->object == 'wdt_mega_menus' ) {
                    $itemsMega[] = $item->menu_item_parent;
                }

                // find all parents with mega menu siblings with custom width
                if ( $item->mm_width ) {
                    $itemsMegaCustomWidth[] = $item->menu_item_parent;
                }
            }

            // if li has child mega menu add class
            foreach ( $items as $item ) {
                if( is_a( $args->walker, 'WeFix_Walker_Nav_Menu' ) || is_a( $args->walker, 'WeFix_Default_Header_Walker_Nav_Menu' ) ) {
                    in_array( $item->ID, $itemsMega ) && $item->classes[] = 'has-mega-menu';
                }
            }

            // if custom width is presented add class to parent to make relative position
            foreach ( $items as $item ) {
                if( is_a( $args->walker, 'WeFix_Walker_Nav_Menu' ) || is_a( $args->walker, 'WeFix_Default_Header_Walker_Nav_Menu' ) ) {
                    in_array( $item->ID, $itemsMegaCustomWidth ) && $item->classes[] = 'mega-menu-custom-width';
                }
            }

        	return $items;
        }

        function add_classes( $classes, $item, $args, $depth  ) {

        	if ($item->object == 'wdt_mega_menus' && $depth == 1) {

                if( is_a( $args->walker, 'WeFix_Walker_Nav_Menu' ) || $args->theme_location == 'main-menu' || is_a( $args->walker, 'WeFix_Default_Header_Walker_Nav_Menu' ) ) {
            		if( $item->mm_position != 'none' ) {
            			array_push( $classes, 'mega-position-'.$item->mm_position );
            		}
                }
        	}

        	return $classes;
        }

        function add_li_attribute( $attrs, $item, $args, $depth ) {

            if ($item->object == 'wdt_mega_menus' && $depth == 1) {
                if( !empty( $item->mm_width ) ) {
                    $attrs['style'] = $item->mm_width.'px;';
                }
            }

            return $attrs;
        }

        function mega_menu_output( $item_output, $item, $depth, $args ) {

            if ($item->object == 'wdt_mega_menus' && $depth == 1) {

                if( is_a( $args->walker, 'WeFix_Walker_Nav_Menu' ) || is_a( $args->walker, 'WeFix_Default_Header_Walker_Nav_Menu' ) ) {

                    if( class_exists( '\Elementor\Plugin' ) ) {

					   if( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
						  // Load elementor styles.
						  $css_file = new \Elementor\Core\Files\CSS\Post( $item->object_id );
						  $css_file->enqueue();
					   }

					   $elementor_instance = Elementor\Plugin::instance();
					   $item_output = $elementor_instance->frontend->get_builder_content_for_display( $item->object_id );
				    } else {
    					$item_output = do_shortcode( get_post_field( 'post_content', $item->object_id ) );
				    }
                }
            }

            return $item_output;
        }

    }
}

WeFixProMegaMenuPostType::instance();