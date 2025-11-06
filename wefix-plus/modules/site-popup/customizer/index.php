<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixPlusCustomizerSitePopup' ) ) {
    class WeFixPlusCustomizerSitePopup {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'wefix_plus_customizer_default', array( $this, 'default' ) );
            add_action( 'wefix_general_cutomizer_options', array( $this, 'register_general' ), 30 );
        }

        function default( $option ) {

            $option['show_site_popup'] = '1';
            $option['site_popup']      = '';
            $option['site_popup_conditions'] = 'all_pages';
            $option['site_popup_specific_pages'] = array();
            $option['site_popup_exclude_specific_pages'] = array();
            return $option;
        }

        function register_general( $wp_customize ) {

            $wp_customize->add_section(
                new WeFix_Customize_Section(
                    $wp_customize,
                    'site-popup-section',
                    array(
                        'title'    => esc_html__('Popup', 'wefix-plus'),
                        'panel'    => 'site-general-main-panel',
                        'priority' => 30,
                    )
                )
            );

                /**
                 * Option : Enable Site Popup
                 */
                $wp_customize->add_setting(
                    WEFIX_CUSTOMISER_VAL . '[show_site_popup]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WeFix_Customize_Control_Switch(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[show_site_popup]', array(
                            'type'    => 'wdt-switch',
                            'section' => 'site-popup-section',
                            'label'   => esc_html__( 'Enable Popup', 'wefix-plus' ),
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'wefix-plus' ),
                                'off' => esc_attr__( 'No', 'wefix-plus' )
                            )
                        )
                    )
                );

                /**
                 * Option :Site Popup
                 */
            
                $elementor_templates = [];
                $templates = get_posts([
                    'post_type' => 'elementor_library',
                    'posts_per_page' => -1,
                ]);

                if ($templates) {
                    foreach ($templates as $template) {
                        $elementor_templates[$template->ID] = $template->post_title;
                    }
                }
                $wp_customize->add_setting(
                    WEFIX_CUSTOMISER_VAL . '[site_popup]',
                    array(
                        'type' => 'option'
                    )
                );
                
                $wp_customize->add_control(
                    new WeFix_Customize_Control(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[site_popup]', array(
                            'type'       => 'select',
                            'section'    => 'site-popup-section',
                            'label'      => esc_html__( 'Select Popup', 'wefix-plus' ),
                            'choices' => $elementor_templates,
                            'dependency' => array( 'show_site_popup', '!=', '' ),
                        )
                    )
                );

                /**
                 * Option : Popup Display Conditions
                 */
                $wp_customize->add_setting(
                    WEFIX_CUSTOMISER_VAL . '[site_popup_conditions]', array(
                        'type' => 'option',
                    )
                );  
                $wp_customize->add_control(
                    new WeFix_Customize_Control(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[site_popup_conditions]', array(
                            'type'       => 'select',
                            'section'    => 'site-popup-section',
                            'label'      => esc_html__( 'Popup Display Conditions', 'wefix-plus' ),
                            'choices'    => array(
                                'all_pages' => esc_html__( 'All Pages', 'wefix-plus' ),
                                'specific_pages' => esc_html__( 'Specific Pages', 'wefix-plus' ),
                            ),
                            'dependency' => array( 'show_site_popup', '!=', '' ),
                        )
                    )
                );
                /**
                 * Option : Specific Pages
                 */

                // Get all published pages
                $wefix_get_all_pages = array();
                $pages = get_pages( array(
                    'post_type'      => 'page',
                    'post_status'    => 'publish',
                    'sort_order'     => 'ASC',
                    'sort_column'    => 'post_title',
                    'number'         => 0 // no limit
                ) );

                if ( ! empty( $pages ) ) {
                    foreach ( $pages as $page ) {
                        $wefix_get_all_pages[ $page->ID ] = $page->post_title;
                    }
                }

                $wp_customize->add_setting(
                    WEFIX_CUSTOMISER_VAL . '[site_popup_specific_pages]', array(
                        'type' => 'option',
                    )
                );
                $wp_customize->add_control(
                    new WeFix_Customize_Control(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[site_popup_specific_pages]', array(
                            'type'       => 'select',
                            'section'    => 'site-popup-section',
                            'label'      => esc_html__( 'Select Specific Pages', 'wefix-plus' ),
                            'choices'    => $wefix_get_all_pages,
                            'multiple'   => true,
                            'dependency' => array( 'site_popup_conditions', '==', 'specific_pages' ),
                        )
                    )
                );
                /**
                 * Option : if its all select Specific Pages for exclude
                 */
                $wp_customize->add_setting(
                    WEFIX_CUSTOMISER_VAL . '[site_popup_exclude_specific_pages]', array(
                        'type' => 'option',
                    )
                );
                $wp_customize->add_control(
                    new WeFix_Customize_Control(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[site_popup_exclude_specific_pages]', array(
                            'type'       => 'select',
                            'section'    => 'site-popup-section',
                            'label'      => esc_html__( 'Exclude Specific Pages', 'wefix-plus' ),
                            'choices'    => $wefix_get_all_pages,
                            'multiple'   => true,
                            'dependency' => array( 'site_popup_conditions', '==', 'all_pages' ),
                        )
                    )
                );
                

            }

        }
    }

WeFixPlusCustomizerSitePopup::instance();