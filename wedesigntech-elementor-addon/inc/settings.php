<?php

if (! class_exists ( 'WeDesignTechElementorSettings' )) {

	class WeDesignTechElementorSettings {

		private static $_instance = null;

		public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		function __construct() {

            add_action( 'elementor/admin/after_create_settings/' . Elementor\Settings::PAGE_ID, array( $this, 'register_elementor_settings_tab' ) );
            add_action( 'elementor/admin/after_create_settings/' . Elementor\Settings::PAGE_ID, array( $this, 'register_elementor_settings_fields' ) );

		}

        function register_elementor_settings_tab( Elementor\Settings $settings ) {

            $settings->add_tab('wedesigntech', array(
                'label' => esc_html__( 'WeDesignTech', 'wdt-elementor-addon' ),
                'sections' => array (
                    'wedesigntech_google_map_section' => array(
                        'label' => esc_html__( 'Google Map', 'wdt-elementor-addon' )
                    ),
                    'wedesigntech_mailchimp_section' => array(
                        'label' => esc_html__( 'Mailchimp', 'wdt-elementor-addon' )
                    ),
                    'wedesigntech_instagram_section' => array(
                        'label'    => esc_html__( 'Instagram', 'wdt-elementor-addon' ),
                        'callback' => function() {
                            echo sprintf( esc_html__( 'You can create your instagram application settings %1$s', 'wdt-elementor-addon' ), '<a href="https://developers.facebook.com/docs/instagram-basic-display-api/getting-started" target="_blank">'.esc_html__( 'here.', 'wdt-elementor-addon' ).'</a>' );
                        }
                    )
                )
            ) );

        }

        function register_elementor_settings_fields( Elementor\Settings $settings ) {

            // Google Map
            $settings->add_field( 'wedesigntech', 'wedesigntech_google_map_section', 'wdt_google_map_api_key', array(
                'label'      => esc_html__('API Key', 'wdt-elementor-addon' ),
                'field_args' => array(
                    'type' => 'text',
                    'desc' => sprintf(
                        esc_html__('Please set Google maps API key before using Google Map widget. You can create own API key %1$s.','wdt-elementor-addon'),
                        '<a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key">' . esc_html__( 'here', 'wdt-elementor-addon' ) . '</a>'
                    )
                )
            ) );

            // Mailchimp
            $settings->add_field( 'wedesigntech', 'wedesigntech_mailchimp_section', 'wdt_mailchimp_api_key', array(
                'label'      => esc_html__('API Key', 'wdt-elementor-addon' ),
                'field_args' => array(
                    'type' => 'text',
                    'desc' => esc_html__('Please set Mailchimp API key before using Mailchimp widget.','wdt-elementor-addon'),
                )
            ));

             // Instagram
            $settings->add_field( 'wedesigntech', 'wedesigntech_instagram_section', 'wdt_instagram_app_id', array(
                'label'      => esc_html__('Instagram App ID', 'wdt-elementor-addon'),
                'field_args' => array(
                    'type' => 'text',
                )
            ));

            $settings->add_field( 'wedesigntech', 'wedesigntech_instagram_section', 'wdt_instagram_app_secret', array(
                'label'      => esc_html__('Instagram App Secret', 'wdt-elementor-addon'),
                'field_args' => array(
                    'type' => 'text',
                )
            ));

            $settings->add_field( 'wedesigntech', 'wedesigntech_instagram_section', 'wdt_instagram_app_access_token', array(
                'label'      => esc_html__('Instagram App Access Token', 'wdt-elementor-addon'),
                'field_args' => array(
                    'type' => 'text',
                )
            ));

        }

	}

}


if( !function_exists('wedesigntech_elementor_settings') ) {
	function wedesigntech_elementor_settings() {
		return WeDesignTechElementorSettings::instance();
	}
}

wedesigntech_elementor_settings();
?>