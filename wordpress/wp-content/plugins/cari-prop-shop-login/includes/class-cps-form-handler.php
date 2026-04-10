<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CPS_Form_Handler {

	private $validation;

	public function __construct() {
		$this->validation = new CPS_Validation();
	}

	public function handle_login() {
		if ( ! isset( $_POST['cps_login_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cps_login_nonce'] ) ), 'cps_login_action' ) ) {
			$this->set_transient_message( 'login', __( 'Security check failed. Please try again.', 'cari-prop-shop-login' ), 'error' );
			return;
		}

		$username = isset( $_POST['log'] ) ? sanitize_text_field( wp_unslash( $_POST['log'] ) ) : '';
		$password = isset( $_POST['pwd'] ) ? $_POST['pwd'] : '';
		$remember = isset( $_POST['rememberme'] ) ? (bool) $_POST['rememberme'] : false;
		$redirect = isset( $_POST['redirect_to'] ) ? esc_url_raw( wp_unslash( $_POST['redirect_to'] ) ) : '';

		if ( empty( $username ) || empty( $password ) ) {
			$this->set_transient_message( 'login', __( 'Username and password are required.', 'cari-prop-shop-login' ), 'error' );
			$this->redirect_with_message( $redirect, 'login' );
			return;
		}

		$validation = $this->validation->validate_login( $username, $password );
		if ( is_wp_error( $validation ) ) {
			$this->set_transient_message( 'login', $validation->get_error_message(), 'error' );
			$this->redirect_with_message( $redirect, 'login' );
			return;
		}

		$creds = array(
			'user_login'    => $username,
			'user_password'  => $password,
			'remember'      => $remember,
		);

		$user = wp_signon( $creds, false );

		if ( is_wp_error( $user ) ) {
			$this->set_transient_message( 'login', $user->get_error_message(), 'error' );
			$this->redirect_with_message( $redirect, 'login' );
			return;
		}

		$account_status = get_user_meta( $user->ID, 'cps_account_status', true );
		if ( 'suspended' === $account_status ) {
			wp_logout();
			$this->set_transient_message( 'login', __( 'Your account has been suspended. Please contact support.', 'cari-prop-shop-login' ), 'error' );
			$this->redirect_with_message( $redirect, 'login' );
			return;
		}

		do_action( 'cps_after_login', $user );

		$redirect = $redirect ? $redirect : apply_filters( 'cps_login_redirect', home_url(), $user );
		wp_redirect( $redirect );
		exit;
	}

	public function handle_registration() {
		if ( ! isset( $_POST['cps_register_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cps_register_nonce'] ) ), 'cps_register_action' ) ) {
			$this->set_transient_message( 'register', __( 'Security check failed. Please try again.', 'cari-prop-shop-login' ), 'error' );
			return;
		}

		$username   = isset( $_POST['cps_username'] ) ? sanitize_user( wp_unslash( $_POST['cps_username'] ) ) : '';
		$email      = isset( $_POST['cps_email'] ) ? sanitize_email( wp_unslash( $_POST['cps_email'] ) ) : '';
		$password   = isset( $_POST['cps_password'] ) ? $_POST['cps_password'] : '';
		$confirm_password = isset( $_POST['cps_confirm_password'] ) ? $_POST['cps_confirm_password'] : '';
		$first_name = isset( $_POST['cps_first_name'] ) ? sanitize_text_field( wp_unslash( $_POST['cps_first_name'] ) ) : '';
		$last_name  = isset( $_POST['cps_last_name'] ) ? sanitize_text_field( wp_unslash( $_POST['cps_last_name'] ) ) : '';
		$role       = isset( $_POST['cps_user_role'] ) ? sanitize_text_field( wp_unslash( $_POST['cps_user_role'] ) ) : CPS_ROLE_BUYER;

		$validation = $this->validation->validate_registration( $username, $email, $password, $confirm_password, $role );
		if ( is_wp_error( $validation ) ) {
			$this->set_transient_message( 'register', $validation->get_error_message(), 'error' );
			return;
		}

		$user_data = array(
			'user_login'   => $username,
			'user_email'   => $email,
			'user_pass'    => $password,
			'user_nicename' => sanitize_title( $username ),
			'display_name' => $first_name . ' ' . $last_name,
			'first_name'   => $first_name,
			'last_name'    => $last_name,
			'role'         => in_array( $role, array( CPS_ROLE_BUYER, CPS_ROLE_AGENT, CPS_ROLE_AGENCY ), true ) ? $role : CPS_ROLE_BUYER,
		);

		$user_id = wp_insert_user( $user_data );

		if ( is_wp_error( $user_id ) ) {
			$this->set_transient_message( 'register', $user_id->get_error_message(), 'error' );
			return;
		}

		$this->save_registration_meta( $user_id );

		$this->send_registration_email( $user_id );

		$auto_login = get_option( 'cps_auto_login_after_registration', 0 );
		if ( $auto_login ) {
			wp_set_auth_cookie( $user_id, true );
			$redirect = apply_filters( 'cps_registration_redirect', home_url(), $user_id );
			wp_redirect( $redirect );
			exit;
		}

		$this->set_transient_message( 'register', __( 'Registration successful! Please check your email to activate your account.', 'cari-prop-shop-login' ), 'success' );
	}

	private function save_registration_meta( $user_id ) {
		$meta_fields = array(
			'cps_phone',
			'cps_company_name',
			'cps_license_number',
			'cps_agency_name',
			'cps_address',
			'cps_city',
			'cps_state',
			'cps_zip_code',
			'cps_country',
		);

		foreach ( $meta_fields as $field ) {
			if ( isset( $_POST[ $field ] ) ) {
				$sanitized_value = sanitize_text_field( wp_unslash( $_POST[ $field ] ) );
				if ( ! empty( $sanitized_value ) ) {
					update_user_meta( $user_id, $field, $sanitized_value );
				}
			}
		}

		update_user_meta( $user_id, 'cps_registration_date', current_time( 'mysql' ) );
		update_user_meta( $user_id, 'cps_account_status', 'active' );

		$verification_required = get_option( 'cps_require_email_verification', 1 );
		if ( $verification_required ) {
			update_user_meta( $user_id, 'cps_email_verified', 'pending' );
			$this->send_verification_email( $user_id );
		} else {
			update_user_meta( $user_id, 'cps_email_verified', 'verified' );
		}

		do_action( 'cps_after_registration', $user_id );
	}

	private function send_registration_email( $user_id ) {
		$user = get_userdata( $user_id );
		if ( ! $user ) {
			return;
		}

		$to      = $user->user_email;
		$subject = get_option( 'cps_registration_email_subject', __( 'Welcome to CariPropShop!', 'cari-prop-shop-login' ) );
		
		$message_template = get_option( 'cps_registration_email_template', '' );
		if ( empty( $message_template ) ) {
			$message_template = __( "Hi {first_name},\n\nWelcome to CariPropShop! Your account has been created successfully.\n\nUsername: {username}\nEmail: {email}\n\nThank you for joining us!", 'cari-prop-shop-login' );
		}

		$message = str_replace(
			array( '{first_name}', '{last_name}', '{username}', '{email}', '{site_name}', '{site_url}' ),
			array( $user->first_name, $user->last_name, $user->user_login, $user->user_email, get_bloginfo( 'name' ), home_url() ),
			$message_template
		);

		$headers = array( 'Content-Type: text/html; charset=UTF-8' );
		wp_mail( $to, $subject, wpautop( $message ), $headers );
	}

	private function send_verification_email( $user_id ) {
		$user = get_userdata( $user_id );
		if ( ! $user ) {
			return;
		}

		$verification_key = wp_generate_password( 32, false );
		update_user_meta( $user_id, 'cps_verification_key', $verification_key );

		$verification_url = add_query_arg(
			array(
				'cps_action' => 'verify_email',
				'user_id'    => $user_id,
				'key'        => $verification_key,
			),
			home_url()
		);

		$to      = $user->user_email;
		$subject = get_option( 'cps_verification_email_subject', __( 'Verify your email address', 'cari-prop-shop-login' ) );
		
		$message_template = get_option( 'cps_verification_email_template', '' );
		if ( empty( $message_template ) ) {
			$message_template = __( "Hi {first_name},\n\nPlease verify your email address by clicking the link below:\n\n{verification_url}\n\nIf you did not create this account, please ignore this email.", 'cari-prop-shop-login' );
		}

		$message = str_replace(
			array( '{first_name}', '{verification_url}', '{site_name}' ),
			array( $user->first_name, $verification_url, get_bloginfo( 'name' ) ),
			$message_template
		);

		$headers = array( 'Content-Type: text/html; charset=UTF-8' );
		wp_mail( $to, $subject, wpautop( $message ), $headers );
	}

	public function handle_password_reset_request() {
		if ( ! isset( $_POST['cps_password_reset_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cps_password_reset_nonce'] ) ), 'cps_password_reset_action' ) ) {
			$this->set_transient_message( 'password_reset', __( 'Security check failed. Please try again.', 'cari-prop-shop-login' ), 'error' );
			return;
		}

		$user_login = isset( $_POST['cps_user_login'] ) ? sanitize_text_field( wp_unslash( $_POST['cps_user_login'] ) ) : '';

		if ( empty( $user_login ) ) {
			$this->set_transient_message( 'password_reset', __( 'Please enter your username or email address.', 'cari-prop-shop-login' ), 'error' );
			return;
		}

		$user = is_email( $user_login ) ? get_user_by( 'email', $user_login ) : get_user_by( 'login', $user_login );

		if ( ! $user ) {
			$this->set_transient_message( 'password_reset', __( 'No user found with that username or email.', 'cari-prop-shop-login' ), 'error' );
			return;
		}

		$reset_key = get_password_reset_key( $user );
		if ( is_wp_error( $reset_key ) ) {
			$this->set_transient_message( 'password_reset', $reset_key->get_error_message(), 'error' );
			return;
		}

		$reset_url = add_query_arg(
			array(
				'action' => 'rp',
				'key'    => $reset_key,
				'login'  => rawurlencode( $user->user_login ),
			),
			wp_login_url()
		);

		$to      = $user->user_email;
		$subject = get_option( 'cps_password_reset_email_subject', __( 'Password Reset Request', 'cari-prop-shop-login' ) );

		$message_template = get_option( 'cps_password_reset_email_template', '' );
		if ( empty( $message_template ) ) {
			$message_template = __( "Hi {first_name},\n\nYou requested a password reset. Click the link below to reset your password:\n\n{reset_url}\n\nIf you did not request this, please ignore this email.", 'cari-prop-shop-login' );
		}

		$message = str_replace(
			array( '{first_name}', '{reset_url}', '{site_name}' ),
			array( $user->first_name, $reset_url, get_bloginfo( 'name' ) ),
			$message_template
		);

		$headers = array( 'Content-Type: text/html; charset=UTF-8' );
		$sent = wp_mail( $to, $subject, wpautop( $message ), $headers );

		if ( $sent ) {
			$this->set_transient_message( 'password_reset', __( 'Check your email for the password reset link.', 'cari-prop-shop-login' ), 'success' );
		} else {
			$this->set_transient_message( 'password_reset', __( 'Failed to send reset email. Please try again.', 'cari-prop-shop-login' ), 'error' );
		}
	}

	public function handle_set_new_password() {
		if ( ! isset( $_POST['cps_set_password_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cps_set_password_nonce'] ) ), 'cps_set_password_action' ) ) {
			$this->set_transient_message( 'password_reset', __( 'Security check failed. Please try again.', 'cari-prop-shop-login' ), 'error' );
			return;
		}

		$key   = isset( $_POST['key'] ) ? sanitize_text_field( wp_unslash( $_POST['key'] ) ) : '';
		$login = isset( $_POST['login'] ) ? sanitize_text_field( wp_unslash( $_POST['login'] ) ) : '';
		$password = isset( $_POST['cps_new_password'] ) ? $_POST['cps_new_password'] : '';
		$confirm_password = isset( $_POST['cps_confirm_new_password'] ) ? $_POST['cps_confirm_new_password'] : '';

		if ( empty( $key ) || empty( $login ) ) {
			$this->set_transient_message( 'password_reset', __( 'Invalid reset key.', 'cari-prop-shop-login' ), 'error' );
			return;
		}

		if ( empty( $password ) || empty( $confirm_password ) ) {
			$this->set_transient_message( 'password_reset', __( 'Password fields cannot be empty.', 'cari-prop-shop-login' ), 'error' );
			return;
		}

		if ( $password !== $confirm_password ) {
			$this->set_transient_message( 'password_reset', __( 'Passwords do not match.', 'cari-prop-shop-login' ), 'error' );
			return;
		}

		$validation = $this->validation->validate_password( $password );
		if ( is_wp_error( $validation ) ) {
			$this->set_transient_message( 'password_reset', $validation->get_error_message(), 'error' );
			return;
		}

		$user = check_password_reset_key( $key, $login );

		if ( is_wp_error( $user ) ) {
			$this->set_transient_message( 'password_reset', $user->get_error_message(), 'error' );
			return;
		}

		wp_set_password( $password, $user->ID );

		delete_user_meta( $user->ID, 'cps_verification_key' );

		$this->set_transient_message( 'login', __( 'Your password has been reset. Please log in with your new password.', 'cari-prop-shop-login' ), 'success' );

		$redirect_url = get_option( 'cps_login_page', wp_login_url() );
		$this->redirect_with_message( $redirect_url, 'login' );
	}

	public function handle_social_login( $provider, $user_data ) {
		$allowed_providers = array( 'facebook', 'google', 'apple' );
		if ( ! in_array( $provider, $allowed_providers, true ) ) {
			return new WP_Error( 'invalid_provider', __( 'Invalid social login provider.', 'cari-prop-shop-login' ) );
		}

		$email    = isset( $user_data['email'] ) ? sanitize_email( $user_data['email'] ) : '';
		$username = isset( $user_data['username'] ) ? sanitize_user( $user_data['username'] ) : '';
		$first_name = isset( $user_data['first_name'] ) ? sanitize_text_field( $user_data['first_name'] ) : '';
		$last_name  = isset( $user_data['last_name'] ) ? sanitize_text_field( $user_data['last_name'] ) : '';

		if ( empty( $email ) ) {
			return new WP_Error( 'no_email', __( 'Email not provided by social provider.', 'cari-prop-shop-login' ) );
		}

		$user = get_user_by( 'email', $email );

		if ( $user ) {
			update_user_meta( $user->ID, 'cps_social_' . $provider . '_id', isset( $user_data['id'] ) ? $user_data['id'] : '' );
			wp_set_auth_cookie( $user->ID, true );
			do_action( 'cps_social_login', $user, $provider );
			return $user;
		}

		if ( empty( $username ) ) {
			$username = sanitize_user( explode( '@', $email )[0] );
			$username = _truncate_post_title( $username, 60 );
			$username = sanitize_user( $username );
			$counter  = 1;
			while ( username_exists( $username ) ) {
				$username = sanitize_user( explode( '@', $email )[0] ) . $counter;
				$counter++;
			}
		}

		$password = wp_generate_password( 16, true );

		$user_id = wp_create_user( $username, $password, $email );

		if ( is_wp_error( $user_id ) ) {
			return $user_id;
		}

		wp_update_user( array(
			'ID'         => $user_id,
			'first_name' => $first_name,
			'last_name'  => $last_name,
			'role'       => CPS_ROLE_BUYER,
		) );

		update_user_meta( $user_id, 'cps_social_' . $provider . '_id', isset( $user_data['id'] ) ? $user_data['id'] : '' );
		update_user_meta( $user_id, 'cps_social_login_provider', $provider );
		update_user_meta( $user_id, 'cps_email_verified', 'verified' );
		update_user_meta( $user_id, 'cps_account_status', 'active' );
		update_user_meta( $user_id, 'cps_registration_date', current_time( 'mysql' ) );

		wp_set_auth_cookie( $user_id, true );

		do_action( 'cps_social_login', $user_id, $provider );

		return get_userdata( $user_id );
	}

	private function set_transient_message( $form, $message, $type ) {
		set_transient( 'cps_message_' . $form, array(
			'message' => $message,
			'type'    => $type,
		), 3600 );
	}

	private function redirect_with_message( $url, $form ) {
		if ( empty( $url ) ) {
			$url = add_query_arg( 'cps_message', $form, wp_get_referer() );
		} else {
			$url = add_query_arg( 'cps_message', $form, $url );
		}
		wp_redirect( $url );
		exit;
	}

	public static function ajax_check_username() {
		check_ajax_referer( 'cps_ajax_nonce', 'nonce' );

		$username = isset( $_POST['username'] ) ? sanitize_text_field( wp_unslash( $_POST['username'] ) ) : '';

		if ( empty( $username ) ) {
			wp_send_json_error( array( 'message' => __( 'Username is required.', 'cari-prop-shop-login' ) ) );
		}

		if ( username_exists( $username ) ) {
			wp_send_json_error( array( 'message' => __( 'Username already exists.', 'cari-prop-shop-login' ) ) );
		}

		if ( ! validate_username( $username ) ) {
			wp_send_json_error( array( 'message' => __( 'Invalid username format.', 'cari-prop-shop-login' ) ) );
		}

		wp_send_json_success( array( 'message' => __( 'Username is available.', 'cari-prop-shop-login' ) ) );
	}

	public static function ajax_check_email() {
		check_ajax_referer( 'cps_ajax_nonce', 'nonce' );

		$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';

		if ( empty( $email ) ) {
			wp_send_json_error( array( 'message' => __( 'Email is required.', 'cari-prop-shop-login' ) ) );
		}

		if ( ! is_email( $email ) ) {
			wp_send_json_error( array( 'message' => __( 'Invalid email format.', 'cari-prop-shop-login' ) ) );
		}

		if ( email_exists( $email ) ) {
			wp_send_json_error( array( 'message' => __( 'Email already exists.', 'cari-prop-shop-login' ) ) );
		}

		wp_send_json_success( array( 'message' => __( 'Email is available.', 'cari-prop-shop-login' ) ) );
	}
}

add_action( 'wp_ajax_cps_check_username', array( 'CPS_Form_Handler', 'ajax_check_username' ) );
add_action( 'wp_ajax_nopriv_cps_check_username', array( 'CPS_Form_Handler', 'ajax_check_username' ) );
add_action( 'wp_ajax_cps_check_email', array( 'CPS_Form_Handler', 'ajax_check_email' ) );
add_action( 'wp_ajax_nopriv_cps_check_email', array( 'CPS_Form_Handler', 'ajax_check_email' ) );