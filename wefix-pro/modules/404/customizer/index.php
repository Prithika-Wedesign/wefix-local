<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixProCustomizerSite404' ) ) {
    class WeFixProCustomizerSite404 {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'wefix_pro_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 15);
        }

        function default( $option ) {

            $option['enable_404message']   = '1';
            $option['notfound_style']      = 'type1';
            $option['notfound_darkbg']     = '1';
            $option['notfound_pageid']     = '';
            $option['notfound_background'] = array(
                'background-color'      => 'rgb(0,0,0)',
                'background-repeat'     => 'repeat',
                'background-position'   => 'center center',
                'background-size'       => 'cover',
                'background-attachment' => 'inherit'
            );
            $option['notfound_bg_style'] = '';

            return $option;
        }

        function register( $wp_customize ) {

            /**
             * Option : 404 Meaage
             */
                $wp_customize->add_setting(
                    WEFIX_CUSTOMISER_VAL . '[enable_404message]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WeFix_Customize_Control_Switch(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[enable_404message]', array(
                            'type'        => 'wdt-switch',
                            'label'       => esc_html__( 'Enable Message', 'wefix-pro'),
                            'description' => esc_html__('YES! to enable not-found page message.', 'wefix-pro'),
                            'section'     => 'site-404-page-section',
                            'choices'     => array(
                                'on'  => esc_attr__( 'Yes', 'wefix-pro' ),
                                'off' => esc_attr__( 'No', 'wefix-pro' )
                            )
                        )
                    )
                );

            /**
             * Option : Template Style
             */
                $wp_customize->add_setting(
                    WEFIX_CUSTOMISER_VAL . '[notfound_style]', array(
                        'default' => 'type1',
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WeFix_Customize_Control(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[notfound_style]', array(
                            'type'    => 'select',
                            'section' => 'site-404-page-section',
                            'label'   => esc_html__( 'Template Style', 'wefix-pro' ),
                            'choices' => array(
                                'type1'  => esc_html__('Classic', 'wefix-pro'),
                            ),
                            'description' => esc_html__('Choose the style of not-found template page.', 'wefix-pro'),
                        )
                    )
                );

            /**
             * Option : Notfound Dark BG
             */
                $wp_customize->add_setting(
                    WEFIX_CUSTOMISER_VAL . '[notfound_darkbg]', array(
                        'default' => '',
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WeFix_Customize_Control_Switch(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[notfound_darkbg]', array(
                            'type'        => 'wdt-switch',
                            'label'       => esc_html__( '404 Dark BG', 'wefix-pro'),
                            'description' => esc_html__('YES! to use dark bg notfound page for this site.', 'wefix-pro'),
                            'section'     => 'site-404-page-section',
                            'choices'     => array(
                                'on'  => esc_attr__( 'Yes', 'wefix-pro' ),
                                'off' => esc_attr__( 'No', 'wefix-pro' )
                            )
                        )
                    )
                );

            /**
             * Option : Custom Page
             */
                $wp_customize->add_setting(
                    WEFIX_CUSTOMISER_VAL . '[notfound_pageid]', array(
                        'default' => '',
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WeFix_Customize_Control(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[notfound_pageid]', array(
                            'type'        => 'select',
                            'section'     => 'site-404-page-section',
                            'label'       => esc_html__( 'Custom Page', 'wefix-pro' ),
                            'choices'     => $this->pages_list(),
                            'description' => esc_html__('Choose the page for not-found content.', 'wefix-pro'),
                        )
                    )
                );

            /**
             * Option : 404 Background
             */
                $wp_customize->add_setting(
                    WEFIX_CUSTOMISER_VAL . '[notfound_background]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WeFix_Customize_Control_Background(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[notfound_background]', array(
                            'type'    => 'wdt-background',
                            'section' => 'site-404-page-section',
                            'label'   => esc_html__( 'Background', 'wefix-pro' ),
                        )
                    )
                );

            /**
             * Option : Custom Styles
             */
            $wp_customize->add_setting(
                WEFIX_CUSTOMISER_VAL . '[notfound_bg_style]', array(
                    'type'    => 'option',
                )
            );

            $wp_customize->add_control(
                new WeFix_Customize_Control(
                    $wp_customize, WEFIX_CUSTOMISER_VAL . '[notfound_bg_style]', array(
                        'type'    	  => 'textarea',
                        'section'     => 'site-404-page-section',
                        'label'       => esc_html__( 'Custom Inline Styles', 'wefix-pro' ),
                        'description' => esc_html__('Paste custom CSS styles for not found page.', 'wefix-pro'),
                        'input_attrs' => array(
                            'placeholder' => esc_html__( 'color:#ff00bb; text-align:left;', 'wefix-pro' ),
                        ),
                    )
                )
            );

        }

        function pages_list() {
            $choices     = array();
            $choices[''] = esc_html__('Choose the page', 'wefix-pro');

            $args  = array(
                'post_type'   => 'page',
                'post_status' => 'publish'
            );
            $pages = get_pages($args);

            foreach( $pages as $page ):
                $choices[$page->ID]	= $page->post_title;
            endforeach;

            return $choices;
        }

    }
}

WeFixProCustomizerSite404::instance();