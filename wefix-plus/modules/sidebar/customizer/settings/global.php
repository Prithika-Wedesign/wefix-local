<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixPlusGlobalSibarSettings' ) ) {
    class WeFixPlusGlobalSibarSettings {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'wefix_plus_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 15);
        }

        function default( $option ) {
            $option['global_sidebar_layout'] = 'content-full-width';
            $option['global_sidebar']        = '';
            $option['hide_standard_sidebar'] = '';
             $option['hide_toogle_sidebar'] = '';
            $option['hide_sidebardisabletoogle'] = '';
            return $option;
        }

        function register( $wp_customize ) {

            /**
             * Global Sidebar Panel
             */
            $wp_customize->add_section(
                new WeFix_Customize_Section(
                    $wp_customize,
                    'site-global-sidebar-section',
                    array(
                        'title'    => esc_html__('Global Sidebar', 'wefix-plus'),
                        'panel'    => 'site-widget-main-panel',
                        'priority' => 5
                    )
                )
            );

                /**
                 * Option: Global Sidebar Layout
                 */
                    $wp_customize->add_setting(
                        WEFIX_CUSTOMISER_VAL . '[global_sidebar_layout]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control( new WeFix_Customize_Control_Radio_Image(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[global_sidebar_layout]', array(
                            'type'    => 'wdt-radio-image',
                            'label'   => esc_html__( 'Global Sidebar Layout', 'wefix-plus'),
                            'section' => 'site-global-sidebar-section',
                            'choices' => apply_filters( 'wefix_global_sidebar_layouts', array(
                                'content-full-width' => array(
                                    'label' => esc_html__( 'Without Sidebar', 'wefix-plus' ),
                                    'path'  =>  WEFIX_PLUS_DIR_URL . 'modules/sidebar/customizer/images/without-sidebar.png'
                                ),
                                'with-left-sidebar'  => array(
                                    'label' => esc_html__( 'With Left Sidebar', 'wefix-plus' ),
                                    'path'  =>  WEFIX_PLUS_DIR_URL . 'modules/sidebar/customizer/images/left-sidebar.png'
                                ),
                                'with-right-sidebar' => array(
                                    'label' => esc_html__( 'With Right Sidebar', 'wefix-plus' ),
                                    'path'  =>  WEFIX_PLUS_DIR_URL . 'modules/sidebar/customizer/images/right-sidebar.png'
                                ),
                            ) )
                        )
                    ) );

                /**
                 * Option : Hide Standard Sidebar
                 */
                $wp_customize->add_setting(
                    WEFIX_CUSTOMISER_VAL . '[hide_standard_sidebar]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WeFix_Customize_Control_Switch(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[hide_standard_sidebar]', array(
                            'type'    => 'wdt-switch',
                            'section' => 'site-global-sidebar-section',
                            'label'   => esc_html__( 'Hide Standard Sidebar', 'wefix-plus' ),
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'wefix-plus' ),
                                'off' => esc_attr__( 'No', 'wefix-plus' )
                            )
                        )
                    )
                );

                  /**
                 * Option : Hide Toggle on  Sidebar
                 */
                $wp_customize->add_setting(
                    WEFIX_CUSTOMISER_VAL . '[hide_toogle_sidebar]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new wefix_Customize_Control_Switch(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[hide_toogle_sidebar]', array(
                            'type'    => 'wdt-switch',
                            'section' => 'site-global-sidebar-section',
                            'label'   => esc_html__( 'Enable Toggle Sidebar', 'wefix-plus' ),
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'wefix-plus' ),
                                'off' => esc_attr__( 'No', 'wefix-plus' )
                            )
                        )
                    )
                );

                  /**
                 * Option : Disable Sidebartoggle
                 */
                $wp_customize->add_setting(
                    WEFIX_CUSTOMISER_VAL . '[hide_sidebardisabletoogle]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new wefix_Customize_Control_Switch(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[hide_sidebardisabletoogle]', array(
                            'type'    => 'wdt-switch',
                            'section' => 'site-global-sidebar-section',
                            'description' => esc_html__( 'Enable option for toggle open', 'wefix-plus' ),
                            'label'   => esc_html__( 'Toogle View', 'wefix-plus' ),
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'wefix-plus' ),
                                'off' => esc_attr__( 'No', 'wefix-plus' )
                            ),
                            'dependency'  => array( 'hide_toogle_sidebar', '==', 'true' ),
                        )
                    )
                );

                if ( ! defined( 'WEFIX_PRO_VERSION' ) ) {
                    $wp_customize->add_control(
                        new WeFix_Customize_Control_Separator(
                            $wp_customize, WEFIX_CUSTOMISER_VAL . '[wefix-plus-site-global-sidebar-separator]',
                            array(
                                'type'        => 'wdt-separator',
                                'section'     => 'site-global-sidebar-section',
                                'settings'    => array(),
                                'caption'     => WEFIX_PLUS_REQ_CAPTION,
                                'description' => WEFIX_PLUS_REQ_DESC,
                            )
                        )
                    );
                }

        }
    }
}

WeFixPlusGlobalSibarSettings::instance();