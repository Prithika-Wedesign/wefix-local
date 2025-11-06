<?php

/**
 * Listing Framework Archive Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Woo_Listing_Fw_Archive_Settings' ) ) {

    class WeFix_Woo_Listing_Fw_Archive_Settings {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            /* Load Modules */
                $this->load_modules();

            /* Archive Options Filter */
                add_action( 'cs_framework_options', array ( $this, 'woo_cs_fw_archive_options' ), 10 );


        }

        /*
        Load Modules
        */
            function load_modules() {

                $shop_custom_options = array ();

                if(isset($_REQUEST['opts'])) {

                    $opts = $_REQUEST['opts'];

                    $cs_options = get_option( CS_OPTION );

                    if( is_array( $cs_options ) && !empty( $cs_options ) ) {
                        foreach( $cs_options as $cs_option_key => $cs_option ) {

                           if( strpos($cs_option_key, 'wefix-woo-product-style-archives') !== false ) {
                                if( is_array( $cs_option ) && !empty( $cs_option ) ) {
                                    foreach( $cs_option as $cs_custom_option_key => $cs_custom_option ) {
                                        $cs_custom_option_slug = str_replace(' ', '-', strtolower($cs_custom_option['product-archive-id']));
                                        if($opts == $cs_custom_option_slug) {
                                            $shop_custom_options = $cs_custom_option;
                                        }
                                    }
                                }
                            }

                        }
                    }

                }

                if(is_array($shop_custom_options) && !empty($shop_custom_options)) {
                    include_once WEFIX_SHOP_MODULE_PATH . 'listings/product-archive/general-settings.php';
                    $general_settings = new WeFix_Woo_Listing_Fw_Archive_General_Settings($shop_custom_options);
                    include_once WEFIX_SHOP_MODULE_PATH . 'listings/product-archive/sidebar-settings.php';
                    $sidebar_settings = new WeFix_Woo_Listing_Fw_Archive_Sidebar_Settings($shop_custom_options);
                    include_once WEFIX_SHOP_MODULE_PATH . 'listings/product-archive/hook-settings.php';
                    $hook_settings = new WeFix_Woo_Listing_Fw_Archive_Hook_Settings($shop_custom_options);
                }

            }


        /*
        Archive Options
        */
            function woo_cs_fw_archive_options( $options ) {

                $product_templates_list = array ();
                $product_templates_list[-1] = esc_html__('Admin Option', 'wefix-shop');

                $cs_options = get_option( CS_OPTION );

                if( is_array( $cs_options ) && !empty( $cs_options ) ) {
                    foreach( $cs_options as $cs_option_key => $cs_option ) {

                        if( strpos($cs_option_key, 'wefix-woo-product-style-template-') !== false ) {

                            $product_templates_list[str_replace('wefix-woo-product-style-template-', 'predefined-template-', $cs_option_key)] = $cs_option[0]['product-template-id'];

                        } else if( strpos($cs_option_key, 'wefix-woo-product-style-templates') !== false ) {

                            if( is_array( $cs_option ) && !empty( $cs_option ) ) {
                                foreach( $cs_option as $cs_custom_option_key => $cs_custom_option ) {
                                    $product_templates_list['custom-template-'.$cs_custom_option_key] = $cs_custom_option['product-template-id'];
                                }
                            }

                        }

                    }
                }


                # Archive Name
                    $custom_archive_options = array(
                        array(
                            'id'    => 'product-archive-id',
                            'type'  => 'text',
                            'title' => esc_html__('Title', 'wefix-shop'),
                            'slugify_title' => true
                        ),
                        array(
                            'id'    => 'product-template',
                            'type'  => 'select',
                            'title' => esc_html__('Product Template', 'wefix-shop'),
                            'options' => $product_templates_list
                        ),
                        array(
                            'id'    => 'product-per-page',
                            'type'  => 'text',
                            'title' => esc_html__('Product Per Page', 'wefix-shop'),
                            'default'  => -1
                        ),
                        array(
                            'id'    => 'product-layout',
                            'type'  => 'select',
                            'title' => esc_html__('Product Layout', 'wefix-shop'),
                            'options' => array (
                                1 => esc_html__( 'One Column', 'wefix-shop' ),
                                2 => esc_html__( 'Two Column', 'wefix-shop' ),
                                3 => esc_html__( 'Three Column', 'wefix-shop' ),
                                4 => esc_html__( 'Four Column', 'wefix-shop' )
                            )
                        ),
                        array(
                            'id'    => 'disable-breadcrumb',
                            'type'  => 'switcher',
                            'title' => esc_html__('Disable Breadcrumb', 'wefix-shop')
                        ),
                        array(
                            'id'    => 'show-sorter-on-header',
                            'type'  => 'switcher',
                            'title' => esc_html__('Show Sorter On Header', 'wefix-shop')
                        ),
                        array(
                            'id'    => 'sorter-header-elements',
                            'type'  => 'sorter',
                            'title' => esc_html__('Sorter Header Elements', 'wefix-shop'),
                            'default' => array (
                                'enabled' => array(
                                    'filter'               => esc_html__( 'Filter - OrderBy', 'wefix-shop' ),
                                    'filters_widget_area'  => esc_html__( 'Filters - Widget Area', 'wefix-shop' ),
                                    'result_count'         => esc_html__( 'Result Count', 'wefix-shop' ),
                                    'pagination'           => esc_html__( 'Pagination', 'wefix-shop' ),
                                    'display_mode'         => esc_html__( 'Display Mode', 'wefix-shop' ),
                                    'display_mode_options' => esc_html__( 'Display Mode Options', 'wefix-shop' )
                                ),
                                'disabled' => array()
                            )
                            ),
                        array(
                            'id'    => 'show-sorter-on-footer',
                            'type'  => 'switcher',
                            'title' => esc_html__('Show Sorter On Footer', 'wefix-shop')
                        ),
                        array(
                            'id'    => 'sorter-footer-elements',
                            'type'  => 'sorter',
                            'title' => esc_html__('Sorter Footer Elements', 'wefix-shop'),
                            'default' => array (
                                'enabled'            => array(
                                    'filter'               => esc_html__( 'Filter - OrderBy', 'wefix-shop' ),
                                    'filters_widget_area'  => esc_html__( 'Filters - Widget Area', 'wefix-shop' ),
                                    'result_count'         => esc_html__( 'Result Count', 'wefix-shop' ),
                                    'pagination'           => esc_html__( 'Pagination', 'wefix-shop' ),
                                    'display_mode'         => esc_html__( 'Display Mode', 'wefix-shop' ),
                                    'display_mode_options' => esc_html__( 'Display Mode Options', 'wefix-shop' )
                                ),
                                'disabled' => array()
                            )
                        ),
                        array(
                            'id'      => 'layout',
                            'type'    => 'image_select',
                            'title'   => esc_html__('Sidebar Layout', 'wefix-shop'),
                            'options' => array(
                                'global-sidebar-layout' => WEFIX_PRO_DIR_URL . 'modules/sidebar/customizer/images/global-sidebar.png',
                                'content-full-width'    => WEFIX_PRO_DIR_URL . 'modules/sidebar/customizer/images/without-sidebar.png',
                                'with-left-sidebar'     => WEFIX_PRO_DIR_URL . 'modules/sidebar/customizer/images/left-sidebar.png',
                                'with-right-sidebar'    => WEFIX_PRO_DIR_URL . 'modules/sidebar/customizer/images/right-sidebar.png',
                            ),
                            'default'    => 'global-sidebar-layout'
                        ),
                        array(
                            'id'         => 'sidebars',
                            'type'       => 'select',
                            'title'      => esc_html__('Sidebar Widget Areas', 'wefix-shop'),
                            'class'      => 'chosen',
                            'options'    => $this->registered_widget_areas(),
                            'attributes' => array(
                                'multiple' => 'multiple',
                                'data-placeholder' => esc_html__('Select Widget Area(s)','wefix-shop'),
                                'style' => 'width: 400px;'
                            )
                        ),
                        array(
                            'id'    => 'product-hook-page-top',
                            'type'  => 'select',
                            'title' => esc_html__('Product Hook - Page Top', 'wefix-shop'),
                            'desc'  => esc_html__('Choose elementor template that you want to display in Shop page top position.', 'wefix-shop'),
                            'options' => wefix_elementor_page_list()
                        ),
                        array(
                            'id'    => 'product-hook-page-bottom',
                            'type'  => 'select',
                            'title' => esc_html__('Product Hook - Page Bottom', 'wefix-shop'),
                            'desc'  => esc_html__('Choose elementor template that you want to display in Shop page bottom position.', 'wefix-shop'),
                            'options' => wefix_elementor_page_list()
                        ),
                        array(
                            'id'    => 'product-hook-content-top',
                            'type'  => 'select',
                            'title' => esc_html__('Product Hook - Content Top', 'wefix-shop'),
                            'desc'  => esc_html__('Choose elementor template that you want to display in Shop content top position.', 'wefix-shop'),
                            'options' => wefix_elementor_page_list()
                        ),
                        array(
                            'id'    => 'product-hook-content-bottom',
                            'type'  => 'select',
                            'title' => esc_html__('Product Hook - Content Bottom', 'wefix-shop'),
                            'desc'  => esc_html__('Choose elementor template that you want to display in Shop content bottom position.', 'wefix-shop'),
                            'options' => wefix_elementor_page_list()
                        )
                    );

                # Default & Custom Archive Section

                    $product_archive_section = array (
                        array (
                            'name'   => 'product_archive_section',
                            'title'  => esc_html__('Shop - Product Archive', 'wefix-shop'),
                            'icon'   => 'fa fa-shopping-basket',
                            'fields' => array_merge (
                                apply_filters( 'wefix_woo_default_product_archives', array () ),
                                array (
                                    array (
                                        'id'              => 'wefix-woo-product-style-archives',
                                        'type'            => 'group',
                                        'title'           => esc_html__( 'Product Style Archives', 'wefix-shop' ),
                                        'button_title'    => esc_html__('Add New', 'wefix-shop'),
                                        'accordion_title' => esc_html__('Add New Archive', 'wefix-shop'),
                                        'fields'          => $custom_archive_options
                                    )
                                )
                            )
                        )
                    );

                return array_merge ( $options, $product_archive_section );

            }

        /*
        Registered widget areas
        */
            function registered_widget_areas() {

                $widgets = array ();

                $widgets['wefix-standard-sidebar-1'] = esc_html__( 'Standard Sidebar', 'wefix-shop' );

                $widget_areas = get_option( 'wefix-widget-areas' );
                if( $widget_areas ) {
                    $widget_areas = $widget_areas['widget-areas'];

                    if( is_array( $widget_areas ) && count( $widget_areas ) > 0 ) {
                        foreach ( $widget_areas as $widget ){
                            $id = mb_convert_case($widget, MB_CASE_LOWER, "UTF-8");
                            $id = str_replace(" ", "", $id);
                            $widgets[$id] = $widget;
                        }
                        return $widgets;
                    }
                }

                return $widgets;

            }

    }

}


if( !function_exists('wefix_woo_listing_fw_archive_settings') ) {
	function wefix_woo_listing_fw_archive_settings() {
		return WeFix_Woo_Listing_Fw_Archive_Settings::instance();
	}
}

wefix_woo_listing_fw_archive_settings();