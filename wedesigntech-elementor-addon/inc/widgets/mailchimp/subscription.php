<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeDesignTech_Mailchimp_Subscription' ) ) {
    class WeDesignTech_Mailchimp_Subscription {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
             add_action( 'wp_ajax_wedesigntech_mailchimp_subscribe', array( $this, 'wedesigntech_mailchimp_subscribe' ) );
            add_action( 'wp_ajax_nopriv_wedesigntech_mailchimp_subscribe', array( $this, 'wedesigntech_mailchimp_subscribe' ) );
        }

        function wedesigntech_mailchimp_subscribe() {

            $output = '';

            $apiKey = wedesigntech_sanitization($_REQUEST['mc_apikey']);
            $listId = wedesigntech_sanitization($_REQUEST['mc_listid']);
            $mc_emailid = wedesigntech_sanitization($_REQUEST['mc_emailid']);
            $mc_fname = wedesigntech_sanitization($_REQUEST['mc_fname']);

            if($apiKey != '' && $listId != '') {
                $data = array();

                if($mc_fname == ''):
                    $data = array('email' => sanitize_email($mc_emailid), 'status' => 'subscribed');
                else:
                    $data = array('email' => sanitize_email($mc_emailid), 'status' => 'subscribed', 'merge_fields' => array ( 'FNAME' => $mc_fname ));
                endif;

                if($this->wedesigntech_mailchimp_check_member_already_registered($data, $apiKey, $listId)) {
                    $output .= '<div class="wdt-mailchimp-subscription-msg-inner error">'.esc_html__('Error: You have already subscribed with us !', 'wdt-elementor-addon').'</div>';
                } else {
                    $output .= $this->wedesigntech_mailchimp_register_member($data, $apiKey, $listId);
                }
            } else {
                $output .= '<div class="wdt-mailchimp-subscription-msg-inner error">'.esc_html__('Error: Please make sure valid mailchimp details are provided.', 'wdt-elementor-addon').'</div>';
            }

            echo wedesigntech_html_output($output);

            wp_die();

        }

        function wedesigntech_mailchimp_check_member_already_registered($data, $apiKey, $listId) {

            $memberId = md5(strtolower($data['email']));
            $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
            $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId;

            $args = array(
				'headers' => array(
					'Authorization' => 'user: ' .  $apiKey
				)
			);
			$response = wp_remote_get( esc_url($url), $args );
			$results = json_decode(wp_remote_retrieve_body( $response ));

            if($results->status == 'subscribed') {
                return true;
            }

            return false;

        }

        function wedesigntech_mailchimp_register_member($data, $apiKey, $listId) {

            $json = $output = '';

            if(array_key_exists('merge_fields', $data)):
                $json = json_encode( array( 'email_address' => $data['email'], 'status' => $data['status'], 'merge_fields' => array ( 'FNAME' => $data['merge_fields']['FNAME'] ) ));
            else:
                $json = json_encode( array( 'email_address' => $data['email'], 'status' => $data['status'] ));
            endif;

            $args = array (
                'method' => 'PUT',
                'headers' => array (
                    'Authorization' => 'Basic ' . base64_encode( 'user:'. esc_attr($apiKey) )
                ),
                'body' => $json
            );

            $response = wp_remote_post( 'https://' . substr($apiKey,strpos($apiKey,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . md5(strtolower($data['email'])), $args );
            $results = json_decode(wp_remote_retrieve_body( $response ));

            if($results->status == 'subscribed') {
                $output .= '<div class="wdt-mailchimp-subscription-msg-inner success">'.esc_html__('Success! Please check your inbox or spam folder.', 'wdt-elementor-addon').'</div>';
            } else {
                $output .= '<div class="wdt-mailchimp-subscription-msg-inner error">'.esc_html__('Error: Something went wrong!', 'wdt-elementor-addon').'</div>';
            }

            return $output;

        }

    }
}

if( !function_exists( 'wedesigntech_mailchimp_subscription' ) ) {
    function wedesigntech_mailchimp_subscription() {
        return WeDesignTech_Mailchimp_Subscription::instance();
    }
}

wedesigntech_mailchimp_subscription();