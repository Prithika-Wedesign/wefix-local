<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixProAuthSocial' ) ) {
    class WeFixProAuthSocial {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'wefix_pro_customizer_default', array( $this, 'default' ) );
            add_action( 'wefix_general_cutomizer_options', array( $this, 'register_general' ), 30 );
        }

        function default( $option ) {

            $option['enable_social_logins']  = '0';
            $option['enable_facebook_login'] = '0';
            $option['enable_google_login']   = '0';

            return $option;
        }

        function register_general( $wp_customize ) {

            $wp_customize->add_section(
                new WeFix_Customize_Section(
                    $wp_customize,
                    'auth-social-section',
                    array(
                        'title'    => esc_html__('Social Logins Authentication', 'wefix-pro'),
                        'panel'    => 'site-general-main-panel',
                        'priority' => 30,
                    )
                )
            );

                /**
                 * Option : Enable Social Logins
                 */
                $wp_customize->add_setting(
                    WEFIX_CUSTOMISER_VAL . '[enable_social_logins]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WeFix_Customize_Control_Switch(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[enable_social_logins]', array(
                            'type'    => 'wdt-switch',
                            'section' => 'auth-social-section',
                            'label'   => esc_html__( 'Enable Social Logins', 'wefix-pro' ),
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'wefix-pro' ),
                                'off' => esc_attr__( 'No', 'wefix-pro' )
                            )
                        )
                    )
                );

                
                /**
                 * Option : Enable Facebook Logins
                 */
                $wp_customize->add_setting(
                    WEFIX_CUSTOMISER_VAL . '[enable_facebook_login]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WeFix_Customize_Control_Switch(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[enable_facebook_login]', array(
                            'type'    => 'wdt-switch',
                            'section' => 'auth-social-section',
                            'label'   => esc_html__( 'Enable Facebook Login', 'wefix-pro' ),
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'wefix-pro' ),
                                'off' => esc_attr__( 'No', 'wefix-pro' )
                            ),
                            'dependency' => array( 'enable_social_logins', '!=', '' )
                        )
                    )
                );
                /**
                 * Option : Facebook App Id
                 */
                $wp_customize->add_setting(
                    WEFIX_CUSTOMISER_VAL . '[facebook_app_id]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WeFix_Customize_Control(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[facebook_app_id]', array(
                            'type'    	  => 'text',
                            'section'     => 'auth-social-section',
                            'label'       => esc_html__( 'App Id', 'wefix-pro' ),
                            'description' => esc_html__( 'Put the facebook app id here', 'wefix-pro' ),
                            'input_attrs' => array(
                                'value'	=> esc_html__('App Id', 'wefix-pro'),
                            ),
                            'dependency' => array( 'enable_facebook_login|enable_social_logins', '!=|!=', '' )
                        )
                    )
                );
                /**
                 * Option : Facebook Secret
                 */
                $wp_customize->add_setting(
                    WEFIX_CUSTOMISER_VAL . '[facebook_app_secret]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WeFix_Customize_Control(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[facebook_app_secret]', array(
                            'type'    	  => 'text',
                            'section'     => 'auth-social-section',
                            'label'       => esc_html__( 'Secret Id', 'wefix-pro' ),
                            'description' => esc_html__( 'Put the facebook app secret here', 'wefix-pro' ),
                            'input_attrs' => array(
                                'value'	=> esc_html__('Secret Id', 'wefix-pro'),
                            ),
                            'dependency' => array( 'enable_facebook_login|enable_social_logins', '!=|!=', '' )
                        )
                    )
                );

                /**
                 * Option : Enable Google Logins
                 */
                $wp_customize->add_setting(
                    WEFIX_CUSTOMISER_VAL . '[enable_google_login]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WeFix_Customize_Control_Switch(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[enable_google_login]', array(
                            'type'    => 'wdt-switch',
                            'section' => 'auth-social-section',
                            'label'   => esc_html__( 'Enable Google Login', 'wefix-pro' ),
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'wefix-pro' ),
                                'off' => esc_attr__( 'No', 'wefix-pro' )
                            ),
                            'dependency' => array( 'enable_social_logins', '!=', '' )
                        )
                    )
                );
                /**
                 * Option : Google Client Id
                 */
                $wp_customize->add_setting(
                    WEFIX_CUSTOMISER_VAL . '[google_client_id]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WeFix_Customize_Control(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[google_client_id]', array(
                            'type'    	  => 'text',
                            'section'     => 'auth-social-section',
                            'label'       => esc_html__( 'Client Id', 'wefix-pro' ),
                            'description' => esc_html__( 'Put the google client id here', 'wefix-pro' ),
                            'input_attrs' => array(
                                'value'	=> esc_html__('Client Id', 'wefix-pro'),
                            ),
                            'dependency' => array( 'enable_google_login|enable_social_logins', '!=|!=', '' )
                        )
                    )
                );
                /**
                 * Option : Google Client Secret
                 */
                $wp_customize->add_setting(
                    WEFIX_CUSTOMISER_VAL . '[google_client_secret]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WeFix_Customize_Control(
                        $wp_customize, WEFIX_CUSTOMISER_VAL . '[google_client_secret]', array(
                            'type'    	  => 'text',
                            'section'     => 'auth-social-section',
                            'label'       => esc_html__( 'Client Secret', 'wefix-pro' ),
                            'description' => esc_html__( 'Put the google client secret here', 'wefix-pro' ),
                            'input_attrs' => array(
                                'value'	=> esc_html__('Client Secret', 'wefix-pro'),
                            ),
                            'dependency' => array( 'enable_google_login|enable_social_logins', '!=|!=', '' )
                        )
                    )
                );
        }

    }
}

WeFixProAuthSocial::instance();