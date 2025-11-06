<?php

/**
 * Listing Customizer - Shop Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Shop_Listing_Customizer_Shop' ) ) {

    class WeFix_Shop_Listing_Customizer_Shop {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'wefix_woo_shop_page_default_settings', array( $this, 'shop_page_default_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 40);
            add_action( 'wefix_hook_content_before', array( $this, 'woo_handle_product_breadcrumb' ), 10);

        }

        function shop_page_default_settings( $settings ) {

            $disable_breadcrumb             = wefix_customizer_settings('wdt-woo-shop-page-disable-breadcrumb' );
            $settings['disable_breadcrumb'] = $disable_breadcrumb;

            $disable_listingswiper           = wefix_customizer_settings('wdt-woo-shop-page-enable-listingswiper' );
            $settings['disable_listingswiper'] = $disable_listingswiper;

            $disable_listingswiperscrollbar           = wefix_customizer_settings('wdt-woo-shop-page-enable-listingswiperscrollbar' );
            $settings['disable_listingswiperscrollbar'] = $disable_listingswiperscrollbar;

            $apply_isotope                  = wefix_customizer_settings('wdt-woo-shop-page-apply-isotope' );
            $settings['apply_isotope']      = $apply_isotope;

            $show_sorter_on_header              = wefix_customizer_settings('wdt-woo-shop-page-show-sorter-on-header' );
            $settings['show_sorter_on_header']  = $show_sorter_on_header;

            $sorter_header_elements             = wefix_customizer_settings('wdt-woo-shop-page-sorter-header-elements' );
            $settings['sorter_header_elements'] = (is_array($sorter_header_elements) && !empty($sorter_header_elements) ) ? $sorter_header_elements : array ();

            $show_sorter_on_footer              = wefix_customizer_settings('wdt-woo-shop-page-show-sorter-on-footer' );
            $settings['show_sorter_on_footer']  = $show_sorter_on_footer;

            $sorter_footer_elements             = wefix_customizer_settings('wdt-woo-shop-page-sorter-footer-elements' );
            $settings['sorter_footer_elements'] = (is_array($sorter_footer_elements) && !empty($sorter_footer_elements) ) ? $sorter_footer_elements : array ();

            return $settings;

        }

        function register( $wp_customize ) {

                /**
                * Option : Disable Breadcrumb
                */
                    $wp_customize->add_setting(
                        WEFIX_CUSTOMISER_VAL . '[wdt-woo-shop-page-disable-breadcrumb]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new WeFix_Customize_Control_Switch(
                            $wp_customize, WEFIX_CUSTOMISER_VAL . '[wdt-woo-shop-page-disable-breadcrumb]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Disable Breadcrumb', 'wefix-shop'),
                                'section' => 'woocommerce-shop-page-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'wefix-shop' ),
                                    'off' => esc_attr__( 'No', 'wefix-shop' )
                                )
                            )
                        )
                    );



               /**
                * Option : Enable Swiper
                */
                    $wp_customize->add_setting(
                        WEFIX_CUSTOMISER_VAL . '[wdt-woo-shop-page-enable-listingswiper]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new WeFix_Customize_Control_Switch(
                            $wp_customize, WEFIX_CUSTOMISER_VAL . '[wdt-woo-shop-page-enable-listingswiper]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Enable Swiper Option', 'wefix-shop'),
                                'section' => 'woocommerce-shop-page-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'wefix-shop' ),
                                    'off' => esc_attr__( 'No', 'wefix-shop' )
                                ) 
                            )
                        )
                    );



              /**
                * Option : Enable Swiper Scrollbar
                */
                    $wp_customize->add_setting(
                        WEFIX_CUSTOMISER_VAL . '[wdt-woo-shop-page-enable-listingswiperscrollbar]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new WeFix_Customize_Control_Switch(
                            $wp_customize, WEFIX_CUSTOMISER_VAL . '[wdt-woo-shop-page-enable-listingswiperscrollbar]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Default Scrollbar On Swiper', 'wefix-shop'),
                                'section' => 'woocommerce-shop-page-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Show', 'wefix-shop' ),
                                    'off' => esc_attr__( 'Hide', 'wefix-shop' )
                                ),
                                'dependency'  => array( 'wdt-woo-shop-page-enable-listingswiper', '==', 'true' ),
                            )
                        )
                    );


                       
                /**
                * Option : Apply Isotope
                */
                $wp_customize->add_setting(
                    WEFIX_CUSTOMISER_VAL . '[wdt-woo-shop-page-apply-isotope]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WeFix_Customize_Control_Switch(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[wdt-woo-shop-page-apply-isotope]', array(
                            'type'    => 'wdt-switch',
                            'label'   => esc_html__( 'Apply Isotope', 'wefix-shop'),
                            'section' => 'woocommerce-shop-page-section',
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'wefix-shop' ),
                                'off' => esc_attr__( 'No', 'wefix-shop' )
                            )
                        )
                    )
                );

                /**
                 * Option : Show Sorter On Header
                 */
                    $wp_customize->add_setting(
                        WEFIX_CUSTOMISER_VAL . '[wdt-woo-shop-page-show-sorter-on-header]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new WeFix_Customize_Control_Switch(
                            $wp_customize, WEFIX_CUSTOMISER_VAL . '[wdt-woo-shop-page-show-sorter-on-header]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Sorter On Header', 'wefix-shop'),
                                'section' => 'woocommerce-shop-page-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'wefix-shop' ),
                                    'off' => esc_attr__( 'No', 'wefix-shop' )
                                )
                            )
                        )
                    );

                /**
                 * Option : Sorter Header Elements
                 */
                    $wp_customize->add_setting(
                        WEFIX_CUSTOMISER_VAL . '[wdt-woo-shop-page-sorter-header-elements]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control( new WeFix_Customize_Control_Sortable(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[wdt-woo-shop-page-sorter-header-elements]', array(
                            'type' => 'wdt-sortable',
                            'label' => esc_html__( 'Sorter Header Elements', 'wefix-shop'),
                            'section' => 'woocommerce-shop-page-section',
                            'choices' => apply_filters( 'wefix_shop_header_sorter_elements', array(
                                'filter'               => esc_html__( 'Filter - OrderBy', 'wefix-shop' ),
                                'filters_widget_area'  => esc_html__( 'Filters - Widget Area', 'wefix-shop' ),
                                'result_count'         => esc_html__( 'Result Count', 'wefix-shop' ),
                                'pagination'           => esc_html__( 'Pagination', 'wefix-shop' ),
                                'display_mode'         => esc_html__( 'Display Mode', 'wefix-shop' ),
                                'display_mode_options' => esc_html__( 'Display Mode Options', 'wefix-shop' )
                            )),
                        )
                    ));

                /**
                 * Option : Show Sorter On Footer
                 */
                    $wp_customize->add_setting(
                        WEFIX_CUSTOMISER_VAL . '[wdt-woo-shop-page-show-sorter-on-footer]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new WeFix_Customize_Control_Switch(
                            $wp_customize, WEFIX_CUSTOMISER_VAL . '[wdt-woo-shop-page-show-sorter-on-footer]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Sorter On Footer', 'wefix-shop'),
                                'section' => 'woocommerce-shop-page-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'wefix-shop' ),
                                    'off' => esc_attr__( 'No', 'wefix-shop' )
                                )
                            )
                        )
                    );

                /**
                 * Option : Sorter Footer Elements
                 */
                    $wp_customize->add_setting(
                        WEFIX_CUSTOMISER_VAL . '[wdt-woo-shop-page-sorter-footer-elements]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control( new WeFix_Customize_Control_Sortable(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[wdt-woo-shop-page-sorter-footer-elements]', array(
                            'type' => 'wdt-sortable',
                            'label' => esc_html__( 'Sorter Footer Elements', 'wefix-shop'),
                            'section' => 'woocommerce-shop-page-section',
                            'choices' => apply_filters( 'wefix_shop_footer_sorter_elements', array(
                                'filter'               => esc_html__( 'Filter', 'wefix-shop' ),
                                'result_count'         => esc_html__( 'Result Count', 'wefix-shop' ),
                                'pagination'           => esc_html__( 'Pagination', 'wefix-shop' ),
                                'display_mode'         => esc_html__( 'Display Mode', 'wefix-shop' ),
                                'display_mode_options' => esc_html__( 'Display Mode Options', 'wefix-shop' )
                            )),
                        )
                    ));

                /**
                 * Option : Hooks - Page Top
                 */
                    $wp_customize->add_setting(
                        WEFIX_CUSTOMISER_VAL . '[wdt-woo-shop-page-template-hooks-page-top]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new WeFix_Customize_Control(
                            $wp_customize, WEFIX_CUSTOMISER_VAL . '[wdt-woo-shop-page-template-hooks-page-top]', array(
                                'type'     => 'select',
                                'label'    => esc_html__( 'Template Hooks - Page Top', 'wefix-shop'),
                                'description'   => esc_html__('Choose elementor template that you want to display in Shop page top position.', 'wefix-shop'),
                                'section'  => 'woocommerce-shop-page-section',
                                'choices'  => wefix_elementor_page_list()
                            )
                        )
                    );

                /**
                 * Option : Hooks - Page Bottom
                 */
                    $wp_customize->add_setting(
                        WEFIX_CUSTOMISER_VAL . '[wdt-woo-shop-page-template-hooks-page-bottom]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new WeFix_Customize_Control(
                            $wp_customize, WEFIX_CUSTOMISER_VAL . '[wdt-woo-shop-page-template-hooks-page-bottom]', array(
                                'type'     => 'select',
                                'label'    => esc_html__( 'Template Hooks - Page Bottom', 'wefix-shop'),
                                'description'   => esc_html__('Choose elementor template that you want to display in Shop page bottom position.', 'wefix-shop'),
                                'section'  => 'woocommerce-shop-page-section',
                                'choices'  => wefix_elementor_page_list()
                            )
                        )
                    );

                /**
                 * Option : Hooks - Content Top
                 */
                    $wp_customize->add_setting(
                        WEFIX_CUSTOMISER_VAL . '[wdt-woo-shop-page-template-hooks-content-top]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new WeFix_Customize_Control(
                            $wp_customize, WEFIX_CUSTOMISER_VAL . '[wdt-woo-shop-page-template-hooks-content-top]', array(
                                'type'     => 'select',
                                'label'    => esc_html__( 'Template Hooks - Content Top', 'wefix-shop'),
                                'description'   => esc_html__('Choose elementor template that you want to display in Shop page content top position.', 'wefix-shop'),
                                'section'  => 'woocommerce-shop-page-section',
                                'choices'  => wefix_elementor_page_list()
                            )
                        )
                    );

                /**
                 * Option : Hooks - Content Bottom
                 */
                    $wp_customize->add_setting(
                        WEFIX_CUSTOMISER_VAL . '[wdt-woo-shop-page-template-hooks-content-bottom]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new WeFix_Customize_Control(
                            $wp_customize, WEFIX_CUSTOMISER_VAL . '[wdt-woo-shop-page-template-hooks-content-bottom]', array(
                                'type'     => 'select',
                                'label'    => esc_html__( 'Template Hooks - Content Bottom', 'wefix-shop'),
                                'description'   => esc_html__('Choose elementor template that you want to display in Shop page content bottom position.', 'wefix-shop'),
                                'section'  => 'woocommerce-shop-page-section',
                                'choices'  => wefix_elementor_page_list()
                            )
                        )
                    );

        }

        function woo_handle_product_breadcrumb() {

            if(is_shop() && wefix_customizer_settings('wdt-woo-shop-page-disable-breadcrumb' )) {
                remove_action('wefix_breadcrumb', 'wefix_breadcrumb_template');
            }

        }

    }

}


if( !function_exists('wefix_shop_listing_customizer_shop') ) {
	function wefix_shop_listing_customizer_shop() {
		return WeFix_Shop_Listing_Customizer_Shop::instance();
	}
}

wefix_shop_listing_customizer_shop();