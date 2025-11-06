<?php
namespace WeFixElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class WeFix_Shop_Widget_Menu_Icon extends Widget_Base {

	public function get_categories() {
		return [ 'wdt-shop-widgets' ];
	}

	public function get_name() {
		return 'wdt-shop-menu-icon';
	}

	public function get_title() {
		return esc_html__( 'Menu Icon', 'wefix-pro' );
	}

	public function get_style_depends() {
		return array( 'wdt-shop-cart-widgets', 'wdt-shop-menu-icon' );
	}

	public function get_script_depends() {
		return array( 'jquery-nicescroll', 'wdt-shop-menu-icon' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'cart_icon_section', array(
			'label' => esc_html__( 'Cart Icon', 'wefix-pro' ),
		) );

			$this->add_control( 'cart_action', array(
				'label'       => esc_html__( 'Cart Action', 'wefix-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose how you want to display the cart content.', 'wefix-pro'),
				'default'     => '',
				'options'     => array(
					''                    => esc_html__( 'None', 'wefix-pro'),
					'notification_widget' => esc_html__( 'Notification Widget', 'wefix-pro' ),
					'sidebar_widget'      => esc_html__( 'Sidebar Widget', 'wefix-pro' ),
	            ),
	        ) );

			$this->add_control(
				'class',
				array (
					'label' => esc_html__( 'Class', 'wefix-pro' ),
					'type'  => Controls_Manager::TEXT
				)
			);

		$this->end_controls_section();

	}

	protected function render() {

		$output = '';

		$settings = $this->get_settings();

		$output .= '<div class="wdt-shop-menu-icon '.$settings['class'].'">';

			$output .= '<a href="'.esc_url( wc_get_cart_url() ).'">';
				$output .= '<span class="wdt-shop-menu-icon-wrapper">';
					$output .= '<span class="wdt-shop-menu-cart-inner">';
						$output .= '<span class="wdt-shop-menu-cart-icon"></span>';
						$output .= '<span class="wdt-shop-menu-cart-number">0</span>';
					$output .= '</span>';
					$output .= '<span class="wdt-shop-menu-cart-totals"></span>';
				$output .= '</span>';
			$output .= '</a>';

			if($settings['cart_action'] == 'notification_widget') {

				$output .= '<div class="wdt-shop-menu-cart-content-wrapper">';
					$output .= '<div class="wdt-shop-menu-cart-content">'.esc_html__('No products added!', 'wefix-pro').'</div>';
				$output .= '</div>';

				set_site_transient( 'cart_action', 'notification_widget', 360 );

			} else if($settings['cart_action'] == 'sidebar_widget') {

				set_site_transient( 'cart_action', 'sidebar_widget', 360 );

			} else {

				set_site_transient( 'cart_action', 'none', 360 );

			}

		$output .= '</div>';

		echo wefix_html_output($output);

	}

}