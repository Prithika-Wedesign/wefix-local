<?php
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (! class_exists('WeFixProServicesPostType')) {

	class WeFixProServicesPostType
	{

		private static $_instance = null;

		public static function instance()
		{
			if (is_null(self::$_instance)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		function __construct()
		{
			add_action('init', array($this, 'wefix_register_cpt'));
			add_filter('template_include', array($this, 'wefix_template_include'));
			add_action('init', array($this, 'register_wdt_service_category_taxonomy'));
			add_action('init', array($this, 'add_excerpt_support'));
            add_filter('cs_metabox_options', array($this, 'services_metabox'));
			add_filter('manage_wdt_services_posts_columns', array($this, 'add_price_column'));
			add_filter('wefix_breadcrumbs', array($this, 'breadcrumbs_wefixpro_module'), 10, 1 );
			add_action('manage_wdt_services_posts_custom_column', array($this, 'render_price_column'), 10, 2);

			add_action('admin_menu', array($this, 'wefix_add_services_settings_submenu') );
			add_action('pre_get_posts', array($this, 'modify_wdt_services_archive_query') );

        }

		function wefix_register_cpt()
		{

			$labels = array(
				'name'               => __('Services', 'wefix-pro'),
				'singular_name'      => __('Services', 'wefix-pro'),
				'menu_name'          => __('Services', 'wefix-pro'),
				'add_new'            => __('Add Services', 'wefix-pro'),
				'add_new_item'       => __('Add New Services', 'wefix-pro'),
				'edit'               => __('Edit Services', 'wefix-pro'),
				'edit_item'          => __('Edit Services', 'wefix-pro'),
				'new_item'           => __('New Services', 'wefix-pro'),
				'view'               => __('View Services', 'wefix-pro'),
				'view_item'          => __('View Services', 'wefix-pro'),
				'search_items'       => __('Search Services', 'wefix-pro'),
				'not_found'          => __('No Services found', 'wefix-pro'),
				'not_found_in_trash' => __('No Services found in Trash', 'wefix-pro'),
			);
			$args = array(
				'labels'             => $labels,
				'public' 			 => true,
			    'publicly_queryable' => true,
        		'has_archive'        => true,
        		'rewrite'            => array('slug' => 'wdt_services'),
				'exclude_from_search'=> false,
				'show_in_nav_menus'  => true,
				'show_in_rest'       => true,
				'menu_position'      => 26,
				'menu_icon'          => 'dashicons-editor-insertmore',
				'hierarchical'       => false,
				'supports'           => array('title', 'editor', 'author', 'revisions', 'thumbnail', 'post-formats', 'excerpt', 'page-attributes', 'custom-fields'),
				'taxonomies'         => array('wdt_service_category'),
			);
			register_post_type('wdt_services', $args);
		}

		function register_wdt_service_category_taxonomy()
		{
			$labels = array(
				'name'              => __('Service Categories', 'wefix-pro'),
				'singular_name'     => __('Service Category', 'wefix-pro'),
				'search_items'      => __('Search Service Categories', 'wefix-pro'),
				'all_items'         => __('All Service Categories', 'wefix-pro'),
				'parent_item'       => __('Parent Service Category', 'wefix-pro'),
				'parent_item_colon' => __('Parent Service Category:', 'wefix-pro'),
				'edit_item'         => __('Edit Service Category', 'wefix-pro'),
				'update_item'       => __('Update Service Category', 'wefix-pro'),
				'add_new_item'      => __('Add New Service Category', 'wefix-pro'),
				'new_item_name'     => __('New Service Category Name', 'wefix-pro'),
			);

			$args = array(
				'labels'            => $labels,
				'hierarchical'      => true,
				'public'            => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array('slug' => 'service-category'),
			);

			register_taxonomy('wdt_service_category', array('wdt_services'), $args);
		}

		function add_excerpt_support() {
        	add_post_type_support('wdt_services', 'excerpt');
    	}

		function services_metabox($options) {

			$times = array( '' => esc_html__('Select', 'wefix-pro') );
			for ( $i = 0; $i < 12; $i++ ) :
				for ( $j = 15; $j <= 60; $j += 15 ) :
					$duration = ( $i * 3600 ) + ( $j * 60 );
					$duration_output = wefix_pro_duration_to_string( $duration );
					$times[$duration] = $duration_output;
				endfor;
			endfor;

			$options[] = array(
				'id'        => '_wefix_service_settings',
				'title'     => esc_html__('Service Settings', 'wefix-pro'),
				'post_type' => 'wdt_services',
				'context'   => 'advanced',
				'priority'  => 'high',
				'sections'  => array(
					array(
						'name'   => 'service_options_section',
						'fields' => array(

							array(
								'id'    => 'service_icon',
								'type'  => 'upload',
								'title' => esc_html__('Service Icon', 'wefix-pro'),
								'desc'  => esc_html__('Upload or select a service icon.', 'wefix-pro'),
							),

							array(
								'id'      => 'service_icon_preview',
								'type'    => 'content',
								'content' => '<div id="csf-icon-preview" style="margin-top:10px;"></div>',
							),

							array(
								'id'      => 'enable_service_price',
								'type'    => 'select',
								'title'   => esc_html__('Enable Price', 'wefix-pro'),
								'options' => array(
									'no'  => esc_html__('Disable', 'wefix-pro'),
									'yes' => esc_html__('Enable', 'wefix-pro'),
								),
								'default' => 'no',
							),

							array(
								'id'         => 'service_price',
								'type'       => 'text',
								'title'      => esc_html__('Service Price', 'wefix-pro'),
								'dependency' => array('enable_service_price', '==', 'yes'),
							),

							array(
								'id'         => 'service_offer_price',
								'type'  	 => 'text',	
								'title' 	 => esc_html__('Service Offer Price', 'wefix-pro'),
								'desc'  	 => esc_html__('Optional: You can set an offer price for the service.', 'wefix-pro'),
								'dependency' => array('enable_service_price', '==', 'yes'),
							),

							array(
								'id'         => 'service_price_duration',
								'type'       => 'select',
								'title'      => esc_html__('Price Duration', 'wefix-pro'),
								'desc'       => esc_html__('Select whether the price is per day, month, or year.', 'wefix-pro'),
								'options'    => array(
									'day'   => esc_html__('Day', 'wefix-pro'),
									'month' => esc_html__('Month', 'wefix-pro'),
									'year'  => esc_html__('Year', 'wefix-pro'),
								),
								'default'    => 'month',
								'dependency' => array('enable_service_price', '==', 'yes'),
							),

							array(
								'id'      => 'service-duration',
								'type'    => 'select',
								'title'   => esc_html__('Delivery Hours', 'wefix-pro'),
								'after'   => '<p class="cs-text-muted">'.esc_html__('Select delivery hours here', 'wefix-pro').'</p>',
								'options' => $times,
								'class'   => 'chosen'
							),

							//Service Features Section
							array(
								'type'  => 'subheading',
								'content' => esc_html__('Service Features', 'wefix-pro'),
							),

							array(
								'id'     => 'service_features',
								'type'   => 'group',
								'title'  => esc_html__('Service Features', 'wefix-pro'),
								'desc'   => esc_html__('Add multiple service features.', 'wefix-pro'),
								'button_title' => esc_html__('Add Feature', 'wefix-pro'),
								'fields' => array(
									array(
										'id'    => 'feature_icon',
										'type'  => 'upload',
										'title' => esc_html__('Feature Icon', 'wefix-pro'),
									),
									array(
										'id'    => 'feature_image',
										'type'  => 'upload',
										'title' => esc_html__('Feature Image', 'wefix-pro'),
									),
									array(
										'id'    => 'feature_description',
										'type'  => 'textarea',
										'title' => esc_html__('Feature Description', 'wefix-pro'),
									),
								),
								'clone' => true,
							),

							// Contact Details Section
							array(
								'type'  => 'subheading',
								'content' => esc_html__('Contact Details', 'wefix-pro'),
							),

							array(
								'id'       => 'contact_email',
								'type'     => 'text',
								'title'    => esc_html__('Email Address', 'wefix-pro'),
								'validate' => 'email',
							),
							array(
								'id'    => 'contact_phone',
								'type'  => 'text',
								'title' => esc_html__('Phone Number', 'wefix-pro'),
							),
							array(
								'id'    => 'contact_address',
								'type'  => 'textarea',
								'title' => esc_html__('Address', 'wefix-pro'),
							),
							array(
								'id'     => 'contact_socials',
								'type'   => 'group',
								'title'  => esc_html__('Social Icons', 'wefix-pro'),
								'desc'   => esc_html__('Add multiple social media links.', 'wefix-pro'),
								'button_title' => esc_html__('Add Social Link', 'wefix-pro'),
								'fields' => array(
									array(
									'id'      => 'social_icon',
									'type'    => 'select',
									'title'   => esc_html__('Social Icon', 'wefix-pro'),
									'options' => array(
										'wdticon-dribble'       => 'Dribbble',
										'wdticon-flickr'        => 'Flickr',
										'wdticon-github'        => 'GitHub',
										'wdticon-pinterest'     => 'Pinterest',
										'wdt-icon-ext-x-icon'   => 'Twitter',
										'wdticon-youtube-play'  => 'YouTube',
										'wdticon-dropbox'       => 'Dropbox',
										'wdticon-instagram'     => 'Instagram',
										'wdticon-facebook'      => 'Facebook',
										'wdticon-linkedin'      => 'LinkedIn',
										'wdticon-vimeo'         => 'Vimeo',
									),
									'chosen'  => true,
									),
									array(
									'id'    => 'social_url',
									'type'  => 'text',
									'title' => esc_html__('Social URL', 'wefix-pro'),
									'desc'  => esc_html__('Enter full URL (e.g., https://facebook.com/yourpage)', 'wefix-pro'),
									),
								),
							),
						
						),
					),
				),
			);

			return $options;
		}

		function wefix_render_services_settings_page() {
			
			$settings_file = WEFIX_PRO_DIR_PATH . 'post-types/services-global-settings.php';

			if (file_exists($settings_file)) {

				include_once $settings_file;
				$settings_instance = WeFixProServiceGlogalSettings::instance();
				$settings_instance->render_settings_page();
				
			} else {
				echo '<div class="wrap"><h1>Settings</h1><p>Settings file not found at: ' . esc_html($settings_file) . '</p></div>';
			}
		}

		function wefix_add_services_settings_submenu() {
			add_submenu_page(
				'edit.php?post_type=wdt_services',
				'Services Settings',              
				'Settings',                       
				'manage_options',                 
				'services-settings',              
				[$this, 'wefix_render_services_settings_page']
			);
		}

		function render_service_icon_metabox($post)
		{
			$service_icon = get_post_meta($post->ID, 'service_icon', true);
				wp_nonce_field('save_service_metabox_nonce', 'service_metabox_nonce');
			?>
			<div class="wdt-custom-box">
				<p>
					<label><strong><?php esc_html_e('Icon', 'wefix-pro'); ?></strong></label><br>
					<button type="button" class="button" id="upload_service_icon"><?php esc_html_e('Upload from Media Library', 'wefix-pro'); ?></button>
					<input type="text" name="service_icon" id="service_icon_input" value="<?php echo esc_url($service_icon); ?>" class="widefat" placeholder="Or paste media URL here">
				</p>

				<div id="service_icon_preview" style="margin-top: 10px; max-height: 100px; max-width: 100px; overflow: hidden;">
					<?php if ($service_icon): ?>
						<?php
							$ext = pathinfo($service_icon, PATHINFO_EXTENSION);
							if (strtolower($ext) === 'svg') {
								echo '<div class="service_icon">' . file_get_contents($service_icon) . '</div>';
							} else {
								echo '<img class="service_icon" src="' . esc_url($service_icon) . '" alt="' . esc_attr__('Service Icon', 'wefix-pro') . '" style="max-width:100%;"/>';
							}
						?>
						<br>
						<button type="button" class="button" id="remove_service_icon"><?php esc_html_e('Remove Icon', 'wefix-pro'); ?></button>
					<?php endif; ?>
				</div>
			</div>
			<?php
		}

		function render_service_price_metabox($post)
		{
			$service_price = get_post_meta($post->ID, 'service_price', true);
			$enable_price = get_post_meta($post->ID, 'enable_service_price', true);

			wp_nonce_field('save_service_metabox_nonce', 'service_metabox_nonce');
			?>
			<div class="services_price">
				<p>
					<label for="enable_service_price"><strong><?php esc_html_e('Enable Price', 'wefix-pro'); ?></strong></label><br>
					<select name="enable_service_price" id="enable_service_price" class="widefat">
						<option value="no" <?php selected($enable_price, 'no'); ?>><?php esc_html_e('Disable', 'wefix-pro'); ?></option>
						<option value="yes" <?php selected($enable_price, 'yes'); ?>><?php esc_html_e('Enable', 'wefix-pro'); ?></option>
					</select>
				</p>

				<p id="price_field_wrapper" style="<?php echo ($enable_price !== 'yes') ? 'display:none;' : ''; ?>">
					<label for="class_price"><strong><?php esc_html_e('Price', 'wefix-pro'); ?></strong></label><br>
					<input type="text" id="class_price" name="service_price" value="<?php echo esc_attr($service_price); ?>" class="widefat">
				</p>
			</div>
			<?php
		}


		function render_category_metabox($post)
		{
			$taxonomy = 'wdt_service_category';
			?>
			<div class="categorydiv">
				<h2><?php _e('Service Categories', 'wefix-pro'); ?></h2>
				<ul>
					<?php wp_terms_checklist($post->ID, array('taxonomy' => $taxonomy)); ?>
				</ul>
			</div>
        	<?php
		}

		function wefix_template_include($template)
		{
			if (is_singular('wdt_services')) {
				if (! file_exists(get_stylesheet_directory() . '/single-wdt_services.php')) {
					$template = WEFIX_PRO_DIR_PATH . 'post-types/templates/single-wdt_services.php';
				}
			}

			if (is_post_type_archive('wdt_services')) {
				if (!file_exists(get_stylesheet_directory() . '/archive-wdt_services.php')) {
					$template = WEFIX_PRO_DIR_PATH . 'post-types/templates/archive-wdt_services.php';
				}
			}
			return $template;
		}

		/**
		 * Modify the main query for wdt_services archive
		 */
		function modify_wdt_services_archive_query($query) {

			if (!is_admin() && $query->is_main_query() && is_post_type_archive('wdt_services')) {
				$global_settings = get_option('_wefix_service_settings', []);
				$post_count = isset($global_settings['count']) ? absint($global_settings['count']) : 6;
				
				$query->set('posts_per_page', $post_count);
				$query->set('post_type', 'wdt_services');
			}
		}

		function add_price_column($columns)
		{
			$price_column = [];
			foreach ($columns as $key => $value) {
				$price_column[$key] = $value;
				if ($key === 'title') {
					$price_column['service_price'] = __('Price', 'wefix-pro');
				}
			}
			return $price_column;
		}

		function render_price_column($column, $post_id)
		{
			if ($column === 'service_price') {
				$settings = get_post_meta($post_id, 'service_settings', true);
				$price = $settings['service_price'] ?? '';
				echo $price ? esc_html($price) : __('N/A', 'wefix-pro');
			}
		}

		function breadcrumbs_wefixpro_module( $breadcrumbs ) {

			if (is_singular( 'wdt_services' )) {

				global $post;

				$terms = get_the_terms(
					$post->ID,
					'wdt_service_category'
				);

				if(isset($terms[0]) && !empty($terms[0])) {
					$breadcrumbs[] = '<a href="'.get_term_link( $terms[0] ).'">'.$terms[0]->name.'</a>';
				}
				$breadcrumbs[] = '<span class="current">'.get_the_title($post->ID).'</span>';

			} elseif (is_tax ( 'wdt_service_category' )) {

				$breadcrumbs[] = '<span class="current">'.single_term_title( '', false ).'</span>';

			}

			return $breadcrumbs;

		}

	}
}

WeFixProServicesPostType::instance();