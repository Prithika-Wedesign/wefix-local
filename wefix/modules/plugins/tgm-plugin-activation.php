<?php
/**
 * Recommends plugins for use with the theme via the TGMA Script
 *
 * @package WeFix WordPress theme
 */

function wefix_tgmpa_plugins_register() {

	// Get array of recommended plugins.

	$plugins_list = array(

		array(
			'name' => esc_html__('WeFix Plus', 'wefix'),
			'slug' => 'wefix-plus',
			'source' => WEFIX_MODULE_DIR . '/plugins/wefix-plus.rar',
			'required' => true,
			'version' => '1.0.0',
			'force_activation' => false,
			'force_deactivation' => false,
		),
		array(
			'name' => esc_html__('WeFix Pro', 'wefix'),
			'slug' => 'wefix-pro',
			'source' => WEFIX_MODULE_DIR . '/plugins/wefix-pro.rar',
			'required' => true,
			'version' => '1.0.0',
			'force_activation' => false,
			'force_deactivation' => false,
		),
		array(
			'name' => esc_html__('WeFix Shop', 'wefix'),
			'slug' => 'wefix-shop',
			'source' => WEFIX_MODULE_DIR . '/plugins/wefix-shop.rar',
			'required' => true,
			'version' => '1.0.0',
			'force_activation' => false,
			'force_deactivation' => false,
		),
		array(
			'name' => esc_html__('Elementor', 'wefix'),
			'slug' => 'elementor',
			'required' => true,
		),
		array(
			'name' => esc_html__('WeDesignTech Elementor Addon', 'wefix'),
			'slug' => 'wedesigntech-elementor-addon',
			'source' => WEFIX_MODULE_DIR . '/plugins/wedesigntech-elementor-addon.rar',
			'required' => true,
			'version' => '1.0.0',
			'force_activation' => false,
			'force_deactivation' => false,
		),
		array(
			'name' => esc_html__('WeDesignTech Portfolio', 'wefix'),
			'slug' => 'wedesigntech-portfolio',
			'source' => WEFIX_MODULE_DIR . '/plugins/wedesigntech-portfolio.rar',
			'required' => true,
			'version' => '1.0.0',
			'force_activation' => false,
			'force_deactivation' => false,
		),
		array(
			'name' => esc_html__('WooCommerce', 'wefix'),
			'slug' => 'woocommerce',
			'required' => true,
		),
		array(
			'name' => esc_html__('Contact Form 7', 'wefix'),
			'slug' => 'contact-form-7',
			'required' => true,
		),
		array(
			'name' => esc_html__('One Click Demo Import', 'techai'),
			'slug' => 'one-click-demo-import',
			'required' => true,
		)
	);

    $plugins = apply_filters('wefix_required_plugins_list', $plugins_list);

	// Register notice
	tgmpa( $plugins, array(
		'id'           => 'wefix_theme',
		'domain'       => 'wefix',
		'menu'         => 'install-required-plugins',
		'has_notices'  => true,
		'is_automatic' => true,
		'dismissable'  => true,
	) );

}
add_action( 'tgmpa_register', 'wefix_tgmpa_plugins_register' );