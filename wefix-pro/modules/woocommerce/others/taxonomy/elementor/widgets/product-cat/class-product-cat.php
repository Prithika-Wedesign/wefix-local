<?php

namespace WeFixElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class WeFix_Shop_Widget_Product_Cat extends Widget_Base
{

	public function get_categories()
	{
		return ['wdt-shop-widgets'];
	}

	public function get_name()
	{
		return 'wdt-shop-product-cat';
	}

	public function get_title()
	{
		return esc_html__('Product Categories', 'wefix-pro');
	}

	public function get_style_depends()
	{
		return array('wdt-shop-product-cat-css-swiper', 'wdt-shop-product-cat');
	}

	public function get_script_depends()
	{
		return array('wdt-shop-product-cat-js-swiper', 'wdt-shop-product-cat-js');
	}

	protected function register_controls()
	{
		$this->start_controls_section('product_cat_section', array(
			'label' => esc_html__('General', 'wefix-pro'),
		));
		// Add the repeater control to the main controls

		$this->add_control('type', array(
			'label'       => esc_html__('Type', 'wefix-pro'),
			'type'        => Controls_Manager::SELECT,
			'description' => esc_html__('Choose type that you like yo use.', 'wefix-pro'),
			'options'     => array(
				'type1' => esc_html__('Type 1', 'wefix-pro'),
				'type2' => esc_html__('Type 2', 'wefix-pro')
			),
			'default'     => 'type1',
		));
		$this->add_control('layout', array(
			'label'       => esc_html__('Layout Type', 'wefix-pro'),
			'type'        => Controls_Manager::SELECT,
			'description' => esc_html__('Choose type that you like yo use.', 'wefix-pro'),
			'options'     => array(
				'column' => esc_html__('Column', 'wefix-pro'),
				'carousel' => esc_html__('Carousel', 'wefix-pro')
			),
			'default'     => 'column',
		));

		$this->add_control('columns', array(
			'label'       => esc_html__('Columns', 'wefix-pro'),
			'type'        => Controls_Manager::SELECT,
			'options'     => array(
				1  => esc_html__('I Column', 'wefix-pro'),
				2  => esc_html__('II Columns', 'wefix-pro'),
				3  => esc_html__('III Columns', 'wefix-pro')
			),
			'description' => esc_html__('Number of columns you like to display your taxonomies.', 'wefix-pro'),
			'default'      => 3,
			'condition' => array('layout' => 'column'),
		));
		$this->add_control('carousel_arrowpagination', array(
			'label'        => esc_html__('Enable Arrow Pagination', 'wefix-pro'),
			'type'         => Controls_Manager::SWITCHER,
			'description'  => esc_html__('To enable arrow pagination.', 'wefix-pro'),
			'label_on'     => esc_html__('yes', 'wefix-pro'),
			'label_off'    => esc_html__('no', 'wefix-pro'),
			'default'      => '',
			'return_value' => 'true',
			'condition' => array('layout' => 'carousel'),
		));
		$slides_per_view = range(1, 6);
		$slides_per_view = array_combine($slides_per_view, $slides_per_view);

		$this->add_responsive_control('slides_to_show_opts', array(
			'type' => \Elementor\Controls_Manager::SELECT,
			'label' => esc_html__('Slides to Show', 'wdt-elementor-addon'),
			'options' => $slides_per_view,
			'desktop_default'      => 4,
			'laptop_default'       => 4,
			'tablet_default'       => 2,
			'tablet_extra_default' => 2,
			'mobile_default'       => 1,
			'mobile_extra_default' => 1,
			'frontend_available'   => true,
			'condition' => array('layout' => 'carousel')
		));
		$this->add_responsive_control(
			'gap',
			array(
				'label' => esc_html__('Gap', 'wdt-elementor-addon'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => array(
					'size' => 20,
					'unit' => 'dpt',
				),
				'size_units' => array('dpt'),
				'range' => array(
					'dpt' => array(
						'min' => 0,
						'step' => 1,
						'max' => 100
					)
				),
				'frontend_available' => true,
				'condition' => array('layout' => 'carousel')
			)
		);
		$this->add_control('carousel_loopmode', array(
			'label'        => esc_html__('Enable Loop Mode', 'wefix-pro'),
			'type'         => Controls_Manager::SWITCHER,
			'description'  => esc_html__('If you wish, you can enable continuous loop mode for your carousel.', 'wefix-pro'),
			'label_on'     => esc_html__('yes', 'wefix-pro'),
			'label_off'    => esc_html__('no', 'wefix-pro'),
			'default'      => '',
			'return_value' => 'true',
			'condition' => array('layout' => 'carousel'),
		));
		$this->add_control('carousel_bulletpagination', array(
			'label'        => esc_html__('Enable Bullet Pagination', 'wefix-pro'),
			'type'         => Controls_Manager::SWITCHER,
			'description'  => esc_html__('To enable bullet pagination.', 'wefix-pro'),
			'label_on'     => esc_html__('yes', 'wefix-pro'),
			'label_off'    => esc_html__('no', 'wefix-pro'),
			'default'      => '',
			'return_value' => 'true',
			'condition' => array('layout' => 'carousel'),
		));

		$this->add_control('include', array(
			'label'   => esc_html__('Include', 'wefix-pro'),
			'type'    => Controls_Manager::TEXT,
			'description' => esc_html__('Category ids separated by comma.', 'wefix-pro'),
			'default' => ''
		));

		$this->add_control('show_starting_price', array(
			'label'       => esc_html__('Show Starting Price', 'wefix-pro'),
			'type'        => Controls_Manager::SELECT,
			'description' => esc_html__('Choose true if you like to show starting price.', 'wefix-pro'),
			'options'     => array(
				'false' => esc_html__('False', 'wefix-pro'),
				'true'  => esc_html__('True', 'wefix-pro'),
			),
			'condition'   => array('type' => 'type1'),
			'default'     => 'false',
		));

		$this->add_control('show_button', array(
			'label'       => esc_html__('Show Button', 'wefix-pro'),
			'type'        => Controls_Manager::SELECT,
			'description' => esc_html__('Choose true if you like to show button.', 'wefix-pro'),
			'options'     => array(
				'false' => esc_html__('False', 'wefix-pro'),
				'true'  => esc_html__('True', 'wefix-pro'),
			),
			'default'     => 'false',
		));

		$this->add_control('class', array(
			'label'   => esc_html__('Class', 'wefix-pro'),
			'type'    => Controls_Manager::TEXT,
			'description' => esc_html__('If you wish you can add additional class name here.', 'wefix-pro'),
			'default' => ''
		));

		$this->end_controls_section();
	}
	public function get_thumb_carousel_attributes($settings)
	{

		extract($settings);

		$slides_to_show = $slides_to_show_opts;
		$slides_to_scroll = $slides_to_show;
		$carousel_settings = array(
			'slides_to_scroll'      	=> $slides_to_scroll,
			'slides_to_show' 			=> $slides_to_show,
			'loop'						=> $carousel_loopmode,
			'arrows'					=> $carousel_arrowpagination,
			'bulletpagination'			=> $carousel_bulletpagination,
			'gap' 						=> isset($gap['size']) ? $gap['size'] : 20
		);

		$active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();
		$breakpoint_keys = array_keys($active_breakpoints);

		$space_between_gaps = array('desktop' => isset($gap['size']) ? $gap['size'] : 20);

		$swiper_breakpoints = array();
		$swiper_breakpoints[] = array(
			'breakpoint' => 319
		);
		$swiper_breakpoints_slides = array();

		foreach ($breakpoint_keys as $breakpoint) {

			$breakpoint_show_str = 'slides_to_show_opts_' . $breakpoint;
			$breakpoint_toshow = $$breakpoint_show_str;
			if ($breakpoint_toshow == '') {
				if ($breakpoint == 'mobile') {
					$breakpoint_toshow = 1;
				} else if ($breakpoint == 'mobile_extra') {
					$breakpoint_toshow = 1;
				} else if ($breakpoint == 'tablet') {
					$breakpoint_toshow = 2;
				} else if ($breakpoint == 'tablet_extra') {
					$breakpoint_toshow = 2;
				} else if ($breakpoint == 'laptop') {
					$breakpoint_toshow = 4;
				} else if ($breakpoint == 'widescreen') {
					$breakpoint_toshow = 4;
				} else {
					$breakpoint_toshow = 4;
				}
			}
			$breakpoint_toscroll = $breakpoint_toshow;

			$breakpoint_gap_str = 'gap_' . $breakpoint;
			$breakpoint_gap = $$breakpoint_gap_str;
			$breakpoint_gap = ($breakpoint_gap['size'] != '') ? $breakpoint_gap['size'] : $gap['size'];

			$space_between_gaps[$breakpoint] = $breakpoint_gap;


			array_push(
				$swiper_breakpoints,
				array(
					'breakpoint' => $active_breakpoints[$breakpoint]->get_value() + 1
				)
			);
			array_push(
				$swiper_breakpoints_slides,
				array(
					'toshow' => (int)$breakpoint_toshow,
					'toscroll' => (int)$breakpoint_toscroll
				)
			);
		}

		array_push(
			$swiper_breakpoints_slides,
			array(
				'toshow' => (int)$slides_to_show,
				'toscroll' => (int)$slides_to_scroll
			)
		);

		$responsive_breakpoints = array();
		if (is_array($swiper_breakpoints) && !empty($swiper_breakpoints)) {
			foreach ($swiper_breakpoints as $key => $swiper_breakpoint) {
				$responsive_breakpoints[] = array_merge($swiper_breakpoint, $swiper_breakpoints_slides[$key]);
			}
		}

		$carousel_settings['responsive'] = $responsive_breakpoints;
		$carousel_settings['space_between_gaps'] = $space_between_gaps;
		return wp_json_encode($carousel_settings);
	}
	protected function render()
	{
		$settings = $this->get_settings();
		$output = '';
		$settings_attr = $this->get_thumb_carousel_attributes($settings);

		// Determine column class
		if ($settings['layout'] == 'column') {
			if ($settings['columns'] == 1) {
				$column_class = 'column wdt-one-column';
			} else if ($settings['columns'] == 2) {
				$column_class = 'column wdt-one-half';
			} else {
				$column_class = 'column wdt-one-third';
			}
		} else {
			$column_class = 'swiper-slide';
		}

		$cat_args = array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => 1,
		);
		if ($settings['include'] != '') {
			$cat_args['include'] = $settings['include'];
		}

		$categories = get_categories($cat_args);

		if (is_array($categories) && !empty($categories)) {
			if ($settings['layout'] == 'carousel') {
				// Swiper container
				$output .= '<div class="wdt-taxonomy-swiper swiper-container"';
				$output .= 'data-settings="' . esc_attr($settings_attr) . '"';
				$output .= '>';
				$output .= '<div class="swiper-wrapper">';
			}

			$i = 1;
			foreach ($categories as $category) {
				$first_class = ($i == 1) ? 'first' : '';
				$term_id = $category->term_id;
				$thumbnail_id = get_term_meta($term_id, 'thumbnail_id', true);
				$image_url = wp_get_attachment_image_src($thumbnail_id, 'full');
				$cat_image = $image_url ? $image_url[0] : false;

				if ($settings['type'] == 'type2') {
					// Custom layout for type2
					$output .= '<div class="wdt-shop-category-listing-item ' . $column_class . ' ' . $first_class . ' type2">';
					$output .= '<div class="wdt-shop-category-listing-inner">';
					if ($cat_image) {
						$output .= '<div class="wdt-shop-category-listing-image">';
						$output .= '<a href="' . get_term_link($category->term_id) . '"><img src="' . esc_url($cat_image) . '" alt="' . esc_html__('Category Image', 'wefix-pro') . '" /></a>';
						$output .= '</div>';
					}
					$output .= '<div class="wdt-shop-category-meta-data">';
					$output .= '<h3><a href="' . get_term_link($category->term_id) . '">' . esc_html($category->cat_name) . '</a></h3>';
					$output .= '<div class="wdt-shop-category-total-items">-' . sprintf(esc_html__('%1$s Items', 'wefix-pro'), '<span>' . $category->count . '</span>') . '-</div>';
					if ($settings['show_button'] == 'true') {
						$output .= '<a href="' . get_term_link($category->term_id) . '" class="wdt-shop-cat-button button">' . esc_html__('View Details', 'wefix-pro') . '</a>';
					}
					$output .= '</div>';
					$output .= '</div>';
					$output .= '</div>';
				} else {
					// Default layout
					$output .= '<div class="wdt-shop-category-listing-item ' . $column_class . ' ' . $first_class . '">';
					$output .= '<div class="wdt-shop-category-listing-inner">';
					if ($cat_image) {
						$output .= '<div class="wdt-shop-category-listing-image">';
						$output .= '<a href="' . get_term_link($category->term_id) . '"><img src="' . esc_url($cat_image) . '" alt="' . esc_html__('Category Image', 'wefix-pro') . '" /></a>';
						$output .= '</div>';
					}
					$output .= '<div class="wdt-shop-category-meta-data">';
					$output .= '<h3><a href="' . get_term_link($category->term_id) . '">' . esc_html($category->cat_name) . '</a></h3>';
					if ($settings['show_button'] == 'true') {
						$output .= '<a href="' . get_term_link($category->term_id) . '" class="wdt-shop-cat-button button">' . esc_html__('View Details', 'wefix-pro') . '</a>';
					}
					$output .= '</div>';
					$output .= '</div>';
					$output .= '</div>';
				}

				$i = ($i == $settings['columns']) ? 1 : $i + 1;
			}

			if ($settings['layout'] == 'carousel') {
				$output .= '</div>'; // End swiper-wrapper

				// Add pagination if enabled
				$output .= '<div class="wdt-taxonomy-pagination-wrapper">';
					if ($settings['carousel_arrowpagination'] == 'true') {
						$output .= '<div class="wdt-taxonomy-swiper-button-next"></div>';
						$output .= '<div class="wdt-taxonomy-swiper-button-prev"></div>';
					}
					if ($settings['carousel_bulletpagination'] == 'true') {
						$output .= '<div class="swiper-pagination"></div>';
					}
				$output .= '</div>';

				$output .= '</div>'; // End swiper-container
			}
		}

		echo wefix_html_output($output);

	}
}