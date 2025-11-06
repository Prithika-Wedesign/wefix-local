<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixProAuth' ) ) {

	class WeFixProAuth {
		
		private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
			add_filter ( 'theme_page_templates', array( $this, 'wefix_auth_template_attribute' ) );
			add_filter ( 'template_include', array( $this, 'wefix_registration_template' ) );

			$this->load_modules();
			$this->frontend();

			add_action('wp_ajax_wefix_pro_register_user_front_end', array( $this, 'wefix_pro_register_user_front_end', 0 ) );
			add_action('wp_ajax_nopriv_wefix_pro_register_user_front_end', array( $this, 'wefix_pro_register_user_front_end' ) );


				// Google login template support
			add_filter( 'theme_page_templates', array( $this, 'wefix_register_google_callback_template' ) );
			add_filter( 'template_include', array( $this, 'wefix_load_google_callback_template' ) );

			// Auto-create Google login callback page
			add_action( 'admin_init', array( $this, 'wefix_create_google_callback_page' ) );
		
        }

		public function wefix_register_google_callback_template( $templates ) {
			$templates['page-google-login-callback.php'] = __( 'Google Login Callback', 'wefix-pro' );
			return $templates;
		}
		// Load the template from plugin folder
		public function wefix_load_google_callback_template( $template ) {
			if ( is_page() ) {
				$page_template = get_page_template_slug( get_queried_object_id() );
				if ( $page_template === 'page-google-login-callback.php' ) {
					$plugin_template = plugin_dir_path( __FILE__ ) . 'templates/page-google-login-callback.php';
					if ( file_exists( $plugin_template ) ) {
						return $plugin_template;
					}
				}
			}
			return $template;
		}

		public	function wefix_get_registration_template_url() {
			$args = array(
				'post_type'      => 'page',
				'posts_per_page' => 1,
				'meta_key'       => '_wp_page_template',
				'meta_value'     => 'tpl-registration.php',
				'post_status'    => 'publish',
			);
			$pages = get_posts($args);
			if (!empty($pages)) {
				return get_permalink($pages[0]->ID);
			}
			return false; 
		}

		// Auto-create the callback page
		public function wefix_create_google_callback_page() {
			$page_slug  = 'google-login-callback';
			$page_title = 'Google Login Callback';

			$existing = get_page_by_path( $page_slug );
			if ( $existing ) {
				return;
			}

			$page_id = wp_insert_post( array(
				'post_title'   => $page_title,
				'post_name'    => $page_slug,
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '[wefix_google_callback_handler]', // Use shortcode
			) );

			if ( $page_id && ! is_wp_error( $page_id ) ) {
				update_post_meta( $page_id, '_wp_page_template', 'page-google-login-callback.php' );
			}
		}
	




		/**
		 * Add Custom Templates to page template array
		*/
		function wefix_auth_template_attribute($templates) {
			$templates = array_merge($templates, array(
				'tpl-registration.php' => esc_html__('Registration Page Template', 'wefix-pro') ,
			));
			return $templates;
		}

		/**
		 * Include Custom Templates page from plugin
		*/
		function wefix_registration_template($template){

			global $post;
			$id = get_the_ID();
			$file = get_post_meta($id, '_wp_page_template', true);
			if ('tpl-registration.php' == $file){
				$template = WEFIX_PRO_DIR_PATH . 'modules/auth/templates/tpl-registration.php';
			}
			return $template;

		}

		function load_modules() {
			include_once WEFIX_PRO_DIR_PATH.'modules/auth/customizer/index.php';
		}

		function frontend() {
			add_action( 'wefix_after_main_css', array( $this, 'enqueue_css_assets' ), 30 );
			add_action( 'wefix_before_enqueue_js', array( $this, 'enqueue_js_assets' ) );
		}

		function enqueue_css_assets() {
			wp_enqueue_style( 'wefix-pro-auth', WEFIX_PRO_DIR_URL . 'modules/auth/assets/css/style.css', false, WEFIX_PRO_VERSION, 'all');
		}

		function enqueue_js_assets() {
			wp_enqueue_script( 'wefix-pro-auth', WEFIX_PRO_DIR_URL . 'modules/auth/assets/js/script.js', array(), WEFIX_PRO_VERSION, true );
			wp_localize_script('wefix-pro-auth', 'wefix_pro_ajax_object', array(
				'ajax_url' => admin_url('admin-ajax.php')
			));
			$facebook_app_id  = wefix_customizer_settings( 'facebook_app_id' );
			$google_client_id = wefix_customizer_settings( 'google_client_id' );
			$ajax_url         = admin_url( 'admin-ajax.php' );
			$new_user_redirect = add_query_arg('profileupdate', '1',wefix_get_registration_template_url());
			if (!$new_user_redirect) {
				$new_user_redirect = home_url('login/?profileupdate=1');
			}
			$redirect_url     = home_url();
			if ( ! empty( $google_client_id ) ) {
				wp_enqueue_script('google-identity-sdk','https://accounts.google.com/gsi/client',array(),null,true);
			}
			if ( ! empty( $facebook_app_id ) || ! empty( $google_client_id ) ) {
				wp_enqueue_script('wefix-social-api',WEFIX_PRO_DIR_URL . 'modules/auth/assets/js/social-login-apis.js',array( 'google-identity-sdk' ),WEFIX_PRO_VERSION,true);
				wp_localize_script( 'wefix-social-api', 'wefix_social_api', array(
					'facebook_app_id'     => $facebook_app_id,
					'google_client_id'    => $google_client_id,
					'ajax_url'            => $ajax_url,
					'redirect_url'        => $redirect_url,
					'new_user_redirect'   => $new_user_redirect,
				) );
				wp_enqueue_script('wefix-social-login',WEFIX_PRO_DIR_URL . 'modules/auth/assets/js/social-login.js',array('wefix-social-api'),WEFIX_PRO_VERSION,true);
			}
		}
		/**
		 * User Registration Save Data
		 */

		function wefix_pro_register_user_front_end() {

			$first_name = isset( $_POST['first_name'] ) ? wefix_sanitization($_POST['first_name']) : '';
			$last_name  = isset( $_POST['last_name'] )  ? wefix_sanitization($_POST['last_name'])  : '';
			$password   = isset( $_POST['password'] )   ? wefix_sanitization($_POST['password'] )  : '';
			$cpassword  = isset( $_POST['cpassword'] )  ? wefix_sanitization($_POST['cpassword'] ) : '';
			$user_name  = isset( $_POST['user_name'] )  ? wefix_sanitization($_POST['user_name'])  : '';
			$user_email = isset( $_POST['user_email'] ) ? wefix_sanitization($_POST['user_email']) : '';
			if ( empty($password) || empty($cpassword) || $password !== $cpassword ) {
				echo 'Error: Password and Confirm Password do not match!';
				exit();
			}
			$user = array(
				'user_login'  =>  $user_name,
				'user_email'  =>  $user_email,
				'user_pass'   =>  $password,
				'first_name'  =>  $first_name,
				'last_name'   =>  $last_name
			);

			$result = wp_insert_user( $user );
			if (!is_wp_error($result)) {
				echo 'Your registration is completed successfully! To get your credential please check you mail!.';
				$wefix_to = $user_email;
				$wefix_subject = 'Welcome to Our Website';

			   // Email content
			   $wefix_body =  "Hello $user_name, <br><br>";
			   $wefix_body .= "Welcome to our website! Here are your account details: <br>";
			   $wefix_body .= "Username: $user_name <br>";
			   $wefix_body .= "Password: $password <br>";
			   $wefix_body .= "Please log in using this information and consider changing your password for security reasons. <br><br>";
			   $wefix_body .= "Thank you for joining us! <br>";
			   $wefix_body .= "Best regards, <br>";
			   $wefix_body .= get_site_url();
			   $wefix_headers = array('Content-Type: text/html; charset=UTF-8');

				wp_mail($wefix_to, $wefix_subject, $wefix_body, $wefix_headers);
			} else {
				echo 'Error creating user: ' . $result->get_error_message();
			}
			exit();
		}	
		
	}

	add_action( 'wp_ajax_wefix_pro_show_login_form_popup', 'wefix_pro_show_login_form_popup' );
	add_action( 'wp_ajax_nopriv_wefix_pro_show_login_form_popup', 'wefix_pro_show_login_form_popup' );
	function wefix_pro_show_login_form_popup() {
		echo wefix_pro_login_form();

		die();
	}

	if(!function_exists('wefix_pro_login_form')) {
		function wefix_pro_login_form() {

			$out = '<div class="wefix-pro-login-form-container">';

				$out .= '<div class="wefix-pro-login-form">';

					$out .= '<div class="wefix-pro-login-form-wrapper">';
						$out .= '<div class="wefix-pro-title wefix-pro-login-title"><h2><span class="wefix-pro-login-title"><strong>'.esc_html__('Create Your Account', 'wefix-pro').'</strong></span></h2>
							<span class="wefix-pro-login-description">'.esc_html__('Please enter your login credentials to access your account.', 'wefix-pro').'</span></div>';
						$enable_google_login = (wefix_customizer_settings( 'enable_google_login' ) !== null) && !empty( wefix_customizer_settings( 'enable_google_login' ) ) ? wefix_customizer_settings( 'enable_google_login' ) : 0;
						$social_logins = (wefix_customizer_settings( 'enable_social_logins' ) !== null) && !empty(wefix_customizer_settings( 'enable_social_logins' )) ? wefix_customizer_settings( 'enable_social_logins' ) : 0;
						$enable_facebook_login = (wefix_customizer_settings( 'enable_facebook_login' ) !== null) && !empty(wefix_customizer_settings( 'enable_facebook_login' )) ? wefix_customizer_settings( 'enable_facebook_login' ) : 0;
						$facebook_app_id = (wefix_customizer_settings( 'facebook_app_id' ) !== null) && !empty(wefix_customizer_settings( 'facebook_app_id' )) ? wefix_customizer_settings( 'facebook_app_id' ) : '';
						$facebook_app_secret = (wefix_customizer_settings( 'facebook_app_secret' ) !== null) && !empty(wefix_customizer_settings( 'facebook_app_secret' )) ? wefix_customizer_settings( 'facebook_app_secret' ) : '';
						

						if( $social_logins ) {

							if( $enable_facebook_login || $enable_google_login ) {
								$out .= '<div class="wefix-pro-social-logins-container">';
								
								if($enable_facebook_login) { 
									$out .= '<div id="fb-root"></div>';
									$out .= '<a href="javascript:void(0);" onclick="fbLogin();" class="wefix-pro-social-facebook-connect"><i class="fab fa-facebook-f"></i> ' . esc_html__('Facebook', 'wefix-pro') . '</a>';
								}
							
								if ( $enable_google_login ) {
										$out .= '<a href="javascript:void(0);" onclick="googleLogin()" class="wefix-pro-social-google-connect" role="button" aria-label="Login with Google">
										<i class="fab fa-google"></i> ' . esc_html__( 'Login with Google', 'wefix-pro' ) . '
									</a>';
								}

								$out .= '<div class="wefix-pro-social-logins-divider">'.esc_html__('Or Login With', 'wefix-pro').'</div>';

								$out .= '</div>';
		
							}
						}
						
						$out .= '<div class="wefix-pro-login-form-holder">';
							$is_admin = is_admin() || is_super_admin();
							$redirect_url = $is_admin ? admin_url() : home_url();

								$out .= '<form id="loginform" method="post" onsubmit="return customLogin(event)">';

								$out .= '<label for="user_login">' . esc_html__('Username', 'wefix-pro') . '</label>';
								$out .= '<input type="text" name="log" id="user_login" required>';

								$out .= '<label for="user_pass">' . esc_html__('Password', 'wefix-pro') . '</label>';
								$out .= '<input type="password" name="pwd" id="user_pass" required>';

								$out .= '<label for="rememberme">';
								$out .= '<input name="rememberme" type="checkbox" id="rememberme" value="forever">';
								$out .= esc_html__('Remember Me', 'wefix-pro');
								$out .= '</label>';

								$out .= '<button type="submit" id="wp-submit">' . esc_html__('Sign In', 'wefix-pro') . '</button>';

								$out .= '</form>';

								$out .= '<p class="tpl-forget-pwd"><a href="' . esc_url(wp_lostpassword_url(get_permalink())) . '">' . esc_html__('Forgot password ?', 'wefix-pro') . '</a></p>';

								$out .= '<div id="login-message"></div>';
						$out .= '</div>';


					
					$out .= '</div>';
				$out .= '</div>';

			$out .= '</div>';

			$out .= '<div class="wefix-pro-login-form-overlay"></div>';

			return $out;

		}
	}

	function wefix_pro_validate_login() {
		$data = $_POST['data'];
		$username = $data['user_name'];
		$password = $data['user_password'];

		$user = get_user_by('login', $username);
		if (!$user) {
			wp_send_json_error(array('message' => __('Username does not exist.')));
		}
		if (!wp_check_password($password, $user->user_pass, $user->ID)) {
			wp_send_json_error(array('message' => __('Incorrect password.')));
		}
	
		wp_set_current_user($user->ID, $user->user_login);
		wp_set_auth_cookie($user->ID);
		do_action('wp_login', $user->user_login, $user);
		if (isset($_POST['is_wp_dashboard']) && $_POST['is_wp_dashboard'] === 'true') {
			$redirect_url = admin_url();
		} else {
			$redirect_url = home_url('/my-account');
		}
		
		wp_send_json_success(array('message' => __('Login successful, redirecting...'), 'redirect_url' => $redirect_url));
	}

	add_action('wp_ajax_nopriv_wefix_pro_validate_login', 'wefix_pro_validate_login');
	add_action('wp_ajax_wefix_pro_validate_login', 'wefix_pro_validate_login');

	/* ---------------------------------------------------------------------------
	* Google login utils
	* --------------------------------------------------------------------------- */

	// if( !function_exists( 'wefix_pro_google_login_url' ) ) {
	// 	function wefix_pro_google_login_url() {
	// 		return site_url('wp-login.php') . '?dtLMSGoogleLogin=1';
	// 	}
	// }

	// function wefix_pro_google_login() {

	// 	$dtLMSGoogleLogin = isset($_REQUEST['dtLMSGoogleLogin']) ? wefix_sanitization($_REQUEST['dtLMSGoogleLogin']) : '';
	// 	if ($dtLMSGoogleLogin == '1') {
	// 		wefix_pro_google_login_action();
	// 	}
	
	// }
	// add_action('login_init', 'wefix_pro_google_login');

	// if( !function_exists('wefix_pro_google_login_action') ) {
	// 	function wefix_pro_google_login_action() {

	// 		require_once WEFIX_PRO_DIR_URL.'modules/auth/apis/google/Google_Client.php';
	// 		require_once WEFIX_PRO_DIR_URL.'modules/auth/apis/google/contrib/Google_Oauth2Service.php';
			
	// 		$google_client_id = (wefix_customizer_settings( 'google_client_id' ) !== null) && !empty(wefix_customizer_settings( 'google_client_id' )) ? wefix_customizer_settings( 'google_client_id' ) : '';
	// 		$google_client_secret = (wefix_customizer_settings( 'google_client_secret' ) !== null) && !empty(wefix_customizer_settings( 'google_client_secret' )) ? wefix_customizer_settings( 'google_client_secret' ) : '';

	// 		$clientId     = $google_client_id; //Google CLIENT ID
	// 		$clientSecret = $google_client_secret; //Google CLIENT SECRET
	// 		$redirectUrl  = wefix_pro_google_login_url();  //return url (url to script)
		
	// 		$gClient = new Google_Client();
	// 		$gClient->setApplicationName(esc_html__('Login To Website', 'wefix-pro'));
	// 		$gClient->setClientId($clientId);
	// 		$gClient->setClientSecret($clientSecret);
	// 		$gClient->setRedirectUri($redirectUrl);
		
	// 		$google_oauthV2 = new Google_Oauth2Service($gClient);
		
	// 		if(isset($google_oauthV2)){
		
	// 			$gClient->authenticate();
	// 			$_SESSION['token'] = $gClient->getAccessToken();
		
	// 			if (isset($_SESSION['token'])) {
	// 				$gClient->setAccessToken($_SESSION['token']);
	// 			}
		
	// 			$user_profile = $google_oauthV2->userinfo->get();
		
	// 			$args = array(
	// 				'meta_key'     => 'google_id',
	// 				'meta_value'   => $user_profile['id'],
	// 				'meta_compare' => '=',
	// 			 );
	// 			$users = get_users( $args );
		
	// 			if(is_array($users) && !empty($users)) {
	// 				$ID = $users[0]->data->ID;
	// 			} else {
	// 				$ID = NULL;
	// 			}
		
	// 			if ($ID == NULL) {
		
	// 				if (!isset($user_profile['email'])) {
	// 					$user_profile['email'] = $user_profile['id'] . '@gmail.com';
	// 				}
		
	// 				$random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
		
	// 				$username = strtolower($user_profile['name']);
	// 				$username = trim(str_replace(' ', '', $username));
		
	// 				$sanitized_user_login = sanitize_user('google-'.$username);
		
	// 				if (!validate_username($sanitized_user_login)) {
	// 					$sanitized_user_login = sanitize_user('google-' . $user_profile['id']);
	// 				}
		
	// 				$defaul_user_name = $sanitized_user_login;
	// 				$i = 1;
	// 				while (username_exists($sanitized_user_login)) {
	// 				  $sanitized_user_login = $defaul_user_name . $i;
	// 				  $i++;
	// 				}
		
	// 				$ID = wp_create_user($sanitized_user_login, $random_password, $user_profile['email']);
		
	// 				if (!is_wp_error($ID)) {
		
	// 					wp_new_user_notification($ID, $random_password);
	// 					$user_info = get_userdata($ID);
	// 					wp_update_user(array(
	// 						'ID' => $ID,
	// 						'display_name' => $user_profile['name'],
	// 						'first_name' => $user_profile['name'],
	// 					));
		
	// 					update_user_meta($ID, 'google_id', $user_profile['id']);
		
	// 				}
		
	// 			}
	// 			if ($ID) {	
	// 			  $secure_cookie = is_ssl();
	// 			  $secure_cookie = apply_filters('secure_signon_cookie', $secure_cookie, array());
	// 			  global $auth_secure_cookie;
	
	// 			  $auth_secure_cookie = $secure_cookie;
	// 			  wp_set_auth_cookie($ID, false, $secure_cookie);
	// 			  $user_info = get_userdata($ID);
	// 			  update_user_meta($ID, 'google_profile_picture', $user_profile['picture']);
	// 			  do_action('wp_login', $user_info->user_login, $user_info, 10, 2);
	// 			  update_user_meta($ID, 'google_user_access_token', $_SESSION['token']);
	
	// 			wp_redirect(home_url());
		
	// 			}
		
	// 		} else {
		
	// 			$authUrl = $gClient->createAuthUrl();
	// 			header('Location: ' . $authUrl);
	// 			exit;
		
	// 		}
		
	// 	}
	// }

	/* if( !function_exists( 'wefix_pro_get_login_redirect_url' ) ) {
		function wefix_pro_get_login_redirect_url($user_info) {

			$dtlms_redirect_url = '';
			if(isset($user_info->data->ID)) {
				$current_user = $user_info;

			}

		}
	} */

	/* ---------------------------------------------------------------------------
	* FaceBook login utils JsSdk
	* --------------------------------------------------------------------------- */
	add_action('wp_ajax_facebook_login_callback', 'wefix_facebook_login_callback');
	add_action('wp_ajax_nopriv_facebook_login_callback', 'wefix_facebook_login_callback');
	function wefix_facebook_login_callback() {

		if ( empty($_POST['name']) || empty($_POST['id']) || empty($_POST['token']) ) {
			wp_send_json_error(['message' => 'Missing Facebook data.']);
		}
		$name     = sanitize_text_field($_POST['name']);
		$fb_id    = sanitize_text_field($_POST['id']);
		$token    = sanitize_text_field($_POST['token']);
		$email = ( isset($_POST['email']) && is_email($_POST['email']) ) ? sanitize_email($_POST['email']) : '';
		$generated_email = 'user_' . $fb_id . '@facebook.local';
		$login_email     = !empty($email) ? $email : $generated_email;
		$users = get_users([
			'meta_key'   => 'facebook_id',
			'meta_value' => $fb_id,
			'number'     => 1,
		]);
		$user = !empty($users) ? $users[0] : null;
		if ( !$user ) {
			$user = get_user_by('email', $login_email);
			if ( $user && !get_user_meta($user->ID, 'facebook_id', true) ) {
				update_user_meta($user->ID, 'facebook_id', $fb_id);
			}
		}
		$is_new_user = false;
		if ( !$user ) {
			$is_new_user = true;
			$base_username = sanitize_user(str_replace(' ', '_', strtolower($name)));
			$username = $base_username;
			$i = 1;
			while ( username_exists($username) ) {
				$username = $base_username . '_' . $i;
				$i++;
			}
			$password = wp_generate_password();
			$user_id = wp_create_user($username, $password, $login_email);

			if ( is_wp_error($user_id) ) {
				wp_send_json_error(['message' => 'User creation failed: ' . $user_id->get_error_message()]);
			}
			update_user_meta($user_id, 'facebook_id', $fb_id);
			update_user_meta($user_id, 'facebook_access_token', $token);
			update_user_meta($user_id, 'facebook_real_email', $email); 

			wp_update_user([
				'ID'           => $user_id,
				'display_name' => $name,
				'first_name' => $name,
				'last_name' => $name,
			]);

			$user = get_user_by('ID', $user_id);
			
		} else {
			update_user_meta($user->ID, 'facebook_access_token', $token);
			if ( !get_user_meta($user->ID, 'facebook_real_email', true) && $email ) {
				update_user_meta($user->ID, 'facebook_real_email', $email);
			}
		}
		wp_set_current_user($user->ID);
		wp_set_auth_cookie($user->ID, true);
		do_action('wp_login', $user->user_login, $user);
		$redirect = home_url('/my-account');
		if ( isset($_COOKIE['wefix_fb_redirect']) ) {
			$redirect = esc_url_raw($_COOKIE['wefix_fb_redirect']);
			setcookie('wefix_fb_redirect', '', time() - 3600, '/'); 
		}

		$is_fallback_email = ( $user->user_email === $generated_email );

		wp_send_json_success([
			'status'           => true,
			'message'          => 'Login successful.',
			'newuser'          => $is_new_user,
			'profileupdate'    => $is_new_user,
			'redirect_url'     => $is_new_user ? (wefix_get_registration_template_url() ? add_query_arg('profileupdate', '1',wefix_get_registration_template_url()) : home_url('login/?profileupdate=1') ) : home_url(),
			'user_id'          => $user->ID,
			'user_email'       => $user->user_email,
			'user_displayname' => $user->display_name,
		]);
	}
	add_action('wp_ajax_wefix_update_fb_profile', 'wefix_update_fb_profile_callback');
	function wefix_update_fb_profile_callback() {

		 check_ajax_referer('wefix_social_login_nonce', 'nonce', false) || wp_send_json_error('Security check failed.');
		
		if (empty($_POST['email']) || empty($_POST['first_name']) || empty($_POST['last_name'])) {
			wp_send_json_error('Missing required fields.');
		}

		$current_user_id = get_current_user_id();

		if (!$current_user_id) {
			wp_send_json_error('User not logged in.');
		}

		$email      = sanitize_email($_POST['email']);
		$first_name = sanitize_text_field($_POST['first_name']);
		$last_name  = sanitize_text_field($_POST['last_name']);

		if (!is_email($email)) {
			wp_send_json_error('Invalid email address.');
		}

		$user = get_user_by('ID', $current_user_id);
		if (!$user) {
			wp_send_json_error('User not found.');
		}

		wp_update_user([
			'ID'         => $current_user_id,
			'user_email' => $email,
			'first_name' => $first_name,
			'last_name'  => $last_name,
		]);

		if (strpos($user->user_email, '@facebook.local') !== false) {
			update_user_meta($current_user_id, 'facebook_real_email', $email);
		}

		wp_send_json_success([
			'message'      => 'Profile updated.',
			'redirect_url' => home_url('/'),
		]);
	}
	/* ---------------------------------------------------------------------------
	* Google login utils JsSdk
	* --------------------------------------------------------------------------- */
	add_action('wp_ajax_google_login_handler', 'wefix_handle_google_login_handler');
	add_action('wp_ajax_nopriv_google_login_handler', 'wefix_handle_google_login_handler');
	function wefix_handle_google_login_handler() {
		if (empty($_POST['id_token'])) {
			wp_send_json_error('Missing Google ID token');
		}
		$id_token = sanitize_text_field($_POST['id_token']);
		$response = wp_remote_get("https://oauth2.googleapis.com/tokeninfo?id_token={$id_token}");
		if (is_wp_error($response)) {
			wp_send_json_error('Failed to connect to Google.');
		}
		$body = json_decode(wp_remote_retrieve_body($response), true);
		if (
			empty($body['email']) ||
			empty($body['sub']) ||
			empty($body['aud']) ||
			empty($body['iss'])
		) {
			wp_send_json_error('Invalid Google token response.');
		}
		$expected_client_id = wefix_customizer_settings('google_client_id');
		if ($body['aud'] !== $expected_client_id || ! in_array($body['iss'], ['https://accounts.google.com', 'accounts.google.com'])) {
			wp_send_json_error('Invalid token audience or issuer.');
		}
		$email      = sanitize_email($body['email']);
		$google_id  = sanitize_text_field($body['sub']);
		$name       = sanitize_text_field($body['name'] ?? '');
		$avatar_url = esc_url_raw($body['picture'] ?? '');
		$new_user   = false;
		$user = get_user_by('email', $email);
		if (!$user) {
			$username = sanitize_user(current(explode('@', $email)), true);
			$base_username = $username;
			$counter = 1;
			while (username_exists($username)) {
				$username = $base_username . $counter;
				$counter++;
			}
			$password = wp_generate_password();
			$user_id = wp_create_user($username, $password, $email);
			if (is_wp_error($user_id)) {
				wp_send_json_error('Failed to create user.');
			}
			wp_update_user([
				'ID'           => $user_id,
				'display_name' => $name,
				'first_name' => $name,
				'last_name' => $name,
			]);
			update_user_meta($user_id, 'wefix_google_id', $google_id);
			update_user_meta($user_id, 'wefix_google_avatar', $avatar_url);
			$user     = get_user_by('ID', $user_id);
			$new_user = true;
		} else {
			update_user_meta($user->ID, 'wefix_google_id', $google_id);
			update_user_meta($user->ID, 'wefix_google_avatar', $avatar_url);
		}
		wp_set_current_user($user->ID);
		wp_set_auth_cookie($user->ID, true);
		wp_send_json_success([
			'status'           => true,
			'message'          => 'Login successful.',
			'newuser'          => $new_user,
			'profileupdate'    => $new_user,
			'redirect_url'     => $new_user ? (wefix_get_registration_template_url() ? add_query_arg('profileupdate', '1',wefix_get_registration_template_url()) : home_url('login/?profileupdate=1') ) : home_url(),
			'user_id'          => $user->ID,
			'user_email'       => $email,
			'user_displayname' => $user->display_name,
			'avatar'           => $avatar_url,
		]);
	}
	add_shortcode( 'wefix_google_callback_handler', function () {
		ob_start();
		?>
		<script>
			(function () {
				function sendIdTokenToParent() {
					const params = new URLSearchParams(window.location.hash.slice(1));
					const idToken = params.get("id_token");
					if (idToken && window.opener) {
						window.opener.postMessage({ type: "google_id_token", token: idToken }, window.location.origin);
						window.close();
					} else {
						document.body.innerHTML = "Google login failed or token missing.";
					}
				}
				window.onload = sendIdTokenToParent;
			})();
		</script>
		<p>Processing Google login...</p>
		<?php
		return ob_get_clean();
	} );
	/* ---------------------------------------------------------------------------
	* Common login utils JsSdk
	* --------------------------------------------------------------------------- */
	add_action('wp_ajax_wefix_get_fresh_nonce', 'wefix_get_fresh_nonce_callback');
	add_action('wp_ajax_nopriv_wefix_get_fresh_nonce', 'wefix_get_fresh_nonce_callback');

	function wefix_get_fresh_nonce_callback() {
		wp_send_json_success(array(
			'nonce' => wp_create_nonce('wefix_social_login_nonce')
		));
	}

}

WeFixProAuth::instance();