<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Advanced_Gallery {

	private static $_instance = null;

	private $cc_layout;
	private $cc_style;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	function __construct() { }

	public function name() {
		return 'wdt-advanced-gallery';
	}

	public function title() {
		return esc_html__( 'Advanced Gallery', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'wdt-widget-icon';
	}

	public function init_styles() {
		return array_merge(
			array (
				$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/advanced-gallery/assets/css/style.css'
			)
		);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array (
			'imagesloaded' => WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/advanced-gallery/assets/js/imagesloaded.pkgd.min.js', // Add imagesLoaded
			'isotope' =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/advanced-gallery/assets/js/isotope.pkgd.js',
			'masonry' =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/advanced-gallery/assets/js/masonry.pkgd.js',
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/advanced-gallery/assets/js/script.js'
		);
	}

	public function create_elementor_controls($elementor_object) {

		$elementor_object->start_controls_section( 'wdt_section_images', array(
			'label' => esc_html__( 'Content', 'wdt-elementor-addon'),
		));
	
			$repeater = new \Elementor\Repeater();

			$repeater->add_control( 'list_title', array(
				'type'    => \Elementor\Controls_Manager::TEXT,
				'label' => esc_html__( 'Title', 'wdt-elementor-addon' ),
				'default' => 'Gallery Item'
			));

			$repeater->add_control('list_description', array(
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'label' => esc_html__('Description', 'wdt-elementor-addon'),
				'default' => 'Gallery Item'
			));

			$repeater->add_control( 'list_icon', array(
				'type' => \Elementor\Controls_Manager::ICONS,
				'label' => esc_html__('Icon', 'wdt-elementor-addon'),
				'default' => array('value' => 'fas fa-paper-plane', 'library' => 'fa-solid')
			));

			$repeater->add_control( 'image', array(
				'type' => \Elementor\Controls_Manager::MEDIA,
				'label' => esc_html__( 'Image', 'wdt-elementor-addon' ),
				'default' => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
			));
	
			$elementor_object->add_control( 'images_content', array(
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'label'       => esc_html__('Gallery Items', 'wdt-elementor-addon'), // Changed from "Banner Items"
				'description' => esc_html__('Add your gallery items here', 'wdt-elementor-addon' ),
				'fields'      => $repeater->get_controls(),
				'default' => array (
					array (
						'list_title' => esc_html__('Gallery Item 1', 'wdt-elementor-addon' ),
						'list_description' => esc_html__('Donec sit amet turpis tincidunt eros, nam porttitor massa leo porta maecenas reque.', 'wdt-elementor-addon' ),
					),
					array (
						'list_title' => esc_html__('Gallery Item 2', 'wdt-elementor-addon' ),
						'list_description' => esc_html__('Donec sit amet turpis tincidunt eros, nam porttitor massa leo porta maecenas reque.', 'wdt-elementor-addon' ),
					),
					array (
						'list_title' => esc_html__('Gallery Item 3', 'wdt-elementor-addon' ),
						'list_description' => esc_html__('Donec sit amet turpis tincidunt eros, nam porttitor massa leo porta maecenas reque.', 'wdt-elementor-addon' ),
					)       
				),
				'title_field' => '{{{list_title}}}'
			));
	
			$elementor_object->end_controls_section();

		$elementor_object->start_controls_section( 'wdt_section_settings', array(
			'label' => esc_html__( 'Settings', 'wdt-elementor-addon'),
		));

			$elementor_object->add_control( 'show_content', array(
				'label'              => esc_html__( 'Show Content', 'wdt-elementor-addon' ),
				'type'               => \Elementor\Controls_Manager::SWITCHER,
				'frontend_available' => true,
				'default'            => 'false',
				'return_value'       => 'true',
				'condition' => array ()
			));

			$elementor_object->add_control('enable_isotope', array(
				'label'              => esc_html__('Enable Isotope', 'wdt-elementor-addon'),
				'type'               => \Elementor\Controls_Manager::SWITCHER,
				'frontend_available' => true,
				'default'            => 'true', // Changed default to true
				'return_value'       => 'true',
			));

			$elementor_object->add_control( 'column_count', array(
				'label'   => esc_html__( 'Number Of Columns', 'wdt-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'wdt-column-3',
				'options' => array(
					'wdt-column-1'   => esc_html__( 'Column 1', 'wdt-elementor-addon' ),
					'wdt-column-2'   => esc_html__( 'Column 2', 'wdt-elementor-addon' ),
					'wdt-column-3'   => esc_html__( 'Column 3', 'wdt-elementor-addon' ),
					'wdt-column-4'   => esc_html__( 'Column 4', 'wdt-elementor-addon' ),
					'wdt-column-5'   => esc_html__( 'Column 5', 'wdt-elementor-addon' ),
					'wdt-column-6'   => esc_html__( 'Column 6', 'wdt-elementor-addon' )
				)
			));
			

		$elementor_object->end_controls_section();
		
		$elementor_object->start_controls_section('listing_masonary_section', array(
			'label' => esc_html__('Masonry Options', 'wdt-elementor-addon'), // Fixed spelling
			'condition' => array(
				'enable_isotope' => 'true' // Only show when isotope is enabled
			)
		));

		$elementor_object->add_control('masonary_one_items', array(
			'label'       => esc_html__('Full Width Items (100%)', 'wdt-elementor-addon'),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'description' => esc_html__('Enter item positions separated by commas (e.g., 1,3,5).', 'wdt-elementor-addon'),
			'default'     => '',
			'placeholder' => '1,3,5'
		));

		$elementor_object->add_control('masonary_one_half_items', array(
			'label'       => esc_html__('Half Width Items (50%)', 'wdt-elementor-addon'),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'description' => esc_html__('Enter item positions separated by commas (e.g., 2,4,6).', 'wdt-elementor-addon'),
			'default'     => '',
			'placeholder' => '2,4,6'
		));

		$elementor_object->add_control('masonary_one_third_items', array(
			'label'       => esc_html__('One Third Width Items (33.33%)', 'wdt-elementor-addon'),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'description' => esc_html__('Enter item positions separated by commas (e.g., 1,4,7).', 'wdt-elementor-addon'),
			'default'     => '',
			'placeholder' => '1,4,7'
		));

		$elementor_object->add_control('masonary_two_third_items', array(
			'label'       => esc_html__('Two Third Width Items (66.66%)', 'wdt-elementor-addon'),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'description' => esc_html__('Enter item positions separated by commas (e.g., 2,5,8).', 'wdt-elementor-addon'),
			'default'     => '',
			'placeholder' => '2,5,8'
		));

		$elementor_object->add_control('masonary_one_fourth_items', array(
			'label'       => esc_html__('One Fourth Width Items (25%)', 'wdt-elementor-addon'),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'description' => esc_html__('Enter item positions separated by commas (e.g., 3,6,9).', 'wdt-elementor-addon'),
			'default'     => '',
			'placeholder' => '3,6,9'
		));

		$elementor_object->add_control('masonary_three_fourth_items', array(
			'label'       => esc_html__('Three Fourth Width Items (75%)', 'wdt-elementor-addon'),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'description' => esc_html__('Enter item positions separated by commas (e.g., 1,5,9).', 'wdt-elementor-addon'),
			'default'     => '',
			'placeholder' => '1,5,9'
		));

		$elementor_object->end_controls_section();
	}

	public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}
		
		$output = '';
		$settings['module_id'] = $widget_object->get_id();
		$settings['module_class'] = 'wdt-gallery-';
		
		$masonary_options = array(
			'one_items' => !empty($settings['masonary_one_items']) ? array_map('trim', explode(',', $settings['masonary_one_items'])) : array(),
			'one_half_items' => !empty($settings['masonary_one_half_items']) ? array_map('trim', explode(',', $settings['masonary_one_half_items'])) : array(),
			'one_third_items' => !empty($settings['masonary_one_third_items']) ? array_map('trim', explode(',', $settings['masonary_one_third_items'])) : array(),
			'two_third_items' => !empty($settings['masonary_two_third_items']) ? array_map('trim', explode(',', $settings['masonary_two_third_items'])) : array(),
			'one_fourth_items' => !empty($settings['masonary_one_fourth_items']) ? array_map('trim', explode(',', $settings['masonary_one_fourth_items'])) : array(),
			'three_fourth_items' => !empty($settings['masonary_three_fourth_items']) ? array_map('trim', explode(',', $settings['masonary_three_fourth_items'])) : array(),
		);

		$widget_data = array(
			'enable_isotope' => $settings['enable_isotope'],
			'column_count' => $settings['column_count'],
			'show_content' => $settings['show_content'],
			'masonry_options' => $masonary_options
		);
		
		$output .= '<div class="wdt-gallery wdt-'.esc_attr($settings['module_class']).esc_attr($settings['module_id']).' wdt-grid" data-settings="'.esc_attr(json_encode($widget_data)).'" data-id="'.esc_attr($settings['module_id']).'">';
			$output .= '<div class="wdt-grid-sizer wdt-sizer-' . esc_attr($settings['column_count']) . '"></div>';

			foreach ( $settings['images_content'] as $index => $item ) {
				$additional_class = '';
				$item_position = $index + 1;
				
				foreach ($masonary_options as $key => $positions) {
					if (in_array($item_position, array_map('intval', $positions))) {
						$additional_class .= ' ' . $key;
						break; 
					}
				}
				
				$output .= '<div class="wdt-gallery-item ' . esc_attr($settings['column_count']) . ' wdt-grid-item' . esc_attr($additional_class) . '">';

					$output .= '<div class="wdt-gallery-item-inner">';
						$output .= '<div class="wdt-gallery-item-image wdt-hover-effect">';

							$output .= '<a class="wdt-gallery-pop-img" href="' . esc_url($item['image']['url']) . '" data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="' . esc_attr($settings['module_id']) . '" data-elementor-lightbox-title="gallery item-' . $item_position . '">';
								$alt_text = !empty($item['image']['alt']) ? esc_attr($item['image']['alt']) : ( !empty($item['list_title']) ? esc_attr($item['list_title']) : 'gallery item-' . $item_position );
								$output .= '<img src="' . esc_url($item['image']['url']) . '" alt="' . $alt_text . '" title="gallery item-' . $item_position . '"/>';
							$output .= '</a>';

							$output .= '<div class="wdt-hover-overlay">';
								$output .= '<div class="wdt-hover-overlay-content">';
									if (!empty($item['list_icon']['value'])) {
										$output .= '<div class="wdt-gallery-icon">';
											ob_start();
											\Elementor\Icons_Manager::render_icon($item['list_icon'], ['aria-hidden' => 'true']);
											$contents = ob_get_contents();
											ob_end_clean();
											$output .= $contents;
										$output .= '</div>';
									}
									if ($settings['show_content'] == 'true') :
										$output .= '<div class="wdt-gallery-item-content">';
											if (!empty($item['list_title'])) {
												$output .= '<h6 class="wdt-gallery-item-content-title">';
													$output .= esc_html($item['list_title']);
												$output .= '</h6>';
											}
											if (!empty($item['list_description'])) {
												$output .= '<div class="wdt-gallery-item-content-description">';
													$output .= wp_kses_post($item['list_description']);
												$output .= '</div>';
											}
										$output .= '</div>';
									endif;
								$output .= '</div>';
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
			}
		$output .= '</div>';

		return $output;
	}
}

if( !function_exists( 'wedesigntech_widget_base_Advanced_Gallery' ) ) {
    function wedesigntech_widget_base_Advanced_Gallery() {
        return WeDesignTech_Widget_Base_Advanced_Gallery::instance();
    }
}
