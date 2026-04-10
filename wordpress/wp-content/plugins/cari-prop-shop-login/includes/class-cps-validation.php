<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CPS_Validation {

	public function validate_login( $username, $password ) {
		if ( empty( $username ) ) {
			return new WP_Error( 'empty_username', __( 'Username is required.', 'cari-prop-shop-login' ) );
		}

		if ( empty( $password ) ) {
			return new WP_Error( 'empty_password', __( 'Password is required.', 'cari-prop-shop-login' ) );
		}

		$user = is_email( $username ) ? get_user_by( 'email', $username ) : get_user_by( 'login', $username );

		if ( ! $user ) {
			return new WP_Error( 'invalid_user', __( 'Invalid username or email.', 'cari-prop-shop-login' ) );
		}

		if ( ! wp_check_password( $password, $user->user_pass, $user->ID ) ) {
			return new WP_Error( 'invalid_password', __( 'Incorrect password.', 'cari-prop-shop-login' ) );
		}

		$verification_required = get_option( 'cps_require_email_verification', 1 );
		if ( $verification_required ) {
			$email_verified = get_user_meta( $user->ID, 'cps_email_verified', true );
			if ( 'verified' !== $email_verified ) {
				return new WP_Error( 'email_not_verified', __( 'Please verify your email address before logging in.', 'cari-prop-shop-login' ) );
			}
		}

		return true;
	}

	public function validate_registration( $username, $email, $password, $confirm_password, $role = '' ) {
		if ( empty( $username ) ) {
			return new WP_Error( 'empty_username', __( 'Username is required.', 'cari-prop-shop-login' ) );
		}

		if ( ! validate_username( $username ) ) {
			return new WP_Error( 'invalid_username', __( 'Invalid username format. Only letters, numbers, and underscores are allowed.', 'cari-prop-shop-login' ) );
		}

		if ( strlen( $username ) < 4 ) {
			return new WP_Error( 'short_username', __( 'Username must be at least 4 characters.', 'cari-prop-shop-login' ) );
		}

		if ( username_exists( $username ) ) {
			return new WP_Error( 'username_exists', __( 'Username already taken.', 'cari-prop-shop-login' ) );
		}

		if ( empty( $email ) ) {
			return new WP_Error( 'empty_email', __( 'Email is required.', 'cari-prop-shop-login' ) );
		}

		if ( ! is_email( $email ) ) {
			return new WP_Error( 'invalid_email', __( 'Invalid email address.', 'cari-prop-shop-login' ) );
		}

		if ( email_exists( $email ) ) {
			return new WP_Error( 'email_exists', __( 'Email already registered.', 'cari-prop-shop-login' ) );
		}

		$password_validation = $this->validate_password( $password );
		if ( is_wp_error( $password_validation ) ) {
			return $password_validation;
		}

		if ( $password !== $confirm_password ) {
			return new WP_Error( 'password_mismatch', __( 'Passwords do not match.', 'cari-prop-shop-login' ) );
		}

		$allowed_roles = array( CPS_ROLE_BUYER, CPS_ROLE_AGENT, CPS_ROLE_AGENCY );
		if ( ! empty( $role ) && ! in_array( $role, $allowed_roles, true ) ) {
			return new WP_Error( 'invalid_role', __( 'Invalid user role.', 'cari-prop-shop-login' ) );
		}

		$require_approval = get_option( 'cps_require_admin_approval', 0 );
		if ( $require_approval && in_array( $role, array( CPS_ROLE_AGENT, CPS_ROLE_AGENCY ), true ) ) {
			update_user_meta( get_current_user_id(), 'cps_account_status', 'pending_approval' );
		}

		return true;
	}

	public function validate_password( $password ) {
		if ( empty( $password ) ) {
			return new WP_Error( 'empty_password', __( 'Password is required.', 'cari-prop-shop-login' ) );
		}

		$min_length = get_option( 'cps_password_min_length', 8 );
		if ( strlen( $password ) < $min_length ) {
			return new WP_Error( 'short_password', sprintf( __( 'Password must be at least %d characters.', 'cari-prop-shop-login' ), $min_length ) );
		}

		$require_uppercase = get_option( 'cps_password_require_uppercase', 0 );
		if ( $require_uppercase && ! preg_match( '/[A-Z]/', $password ) ) {
			return new WP_Error( 'no_uppercase', __( 'Password must contain at least one uppercase letter.', 'cari-prop-shop-login' ) );
		}

		$require_lowercase = get_option( 'cps_password_require_lowercase', 0 );
		if ( $require_lowercase && ! preg_match( '/[a-z]/', $password ) ) {
			return new WP_Error( 'no_lowercase', __( 'Password must contain at least one lowercase letter.', 'cari-prop-shop-login' ) );
		}

		$require_number = get_option( 'cps_password_require_number', 0 );
		if ( $require_number && ! preg_match( '/[0-9]/', $password ) ) {
			return new WP_Error( 'no_number', __( 'Password must contain at least one number.', 'cari-prop-shop-login' ) );
		}

		$require_special = get_option( 'cps_password_require_special', 0 );
		if ( $require_special && ! preg_match( '/[!@#$%^&*(),.?":{}|<>]/', $password ) ) {
			return new WP_Error( 'no_special', __( 'Password must contain at least one special character.', 'cari-prop-shop-login' ) );
		}

		return true;
	}

	public function validate_phone( $phone ) {
		if ( empty( $phone ) ) {
			return true;
		}

		$phone = preg_replace( '/[^0-9]/', '', $phone );

		$min_length = get_option( 'cps_phone_min_length', 7 );
		$max_length = get_option( 'cps_phone_max_length', 15 );

		if ( strlen( $phone ) < $min_length || strlen( $phone ) > $max_length ) {
			return new WP_Error( 'invalid_phone', sprintf( __( 'Phone number must be between %d and %d digits.', 'cari-prop-shop-login' ), $min_length, $max_length ) );
		}

		return true;
	}

	public function validate_license_number( $license_number, $role ) {
		if ( ! in_array( $role, array( CPS_ROLE_AGENT, CPS_ROLE_AGENCY ), true ) ) {
			return true;
		}

		$required = get_option( 'cps_require_license_number', 1 );
		if ( $required && empty( $license_number ) ) {
			return new WP_Error( 'no_license', __( 'License number is required for agents and agencies.', 'cari-prop-shop-login' ) );
		}

		return true;
	}

	public function validate_zip_code( $zip_code, $country ) {
		if ( empty( $zip_code ) ) {
			return true;
		}

		$country = strtoupper( $country );

		$patterns = array(
			'US' => '/^\d{5}(-\d{4})?$/',
			'CA' => '/^[A-Z]\d[A-Z] \d[A-Z]\d$/',
			'UK' => '/^[A-Z]{1,2}\d{1,2}[A-Z]?\s?\d[A-Z]{2}$/',
		);

		if ( isset( $patterns[ $country ] ) && ! preg_match( $patterns[ $country ], $zip_code ) ) {
			return new WP_Error( 'invalid_zip', __( 'Invalid postal code format for selected country.', 'cari-prop-shop-login' ) );
		}

		return true;
	}

	public function sanitize_username( $username ) {
		$username = sanitize_user( $username );
		$username = preg_replace( '/[^a-z0-9_]/', '', strtolower( $username ) );
		return $username;
	}

	public function sanitize_phone( $phone ) {
		return preg_replace( '/[^0-9+]/', '', $phone );
	}

	public function is_valid_username_chars( $username ) {
		return (bool) preg_match( '/^[a-zA-Z0-9_]+$/', $username );
	}

	public function check_username_availability( $username ) {
		if ( username_exists( $username ) ) {
			return new WP_Error( 'username_taken', __( 'This username is already taken.', 'cari-prop-shop-login' ) );
		}
		return true;
	}

	public function check_email_availability( $email ) {
		if ( ! is_email( $email ) ) {
			return new WP_Error( 'invalid_email', __( 'Invalid email address.', 'cari-prop-shop-login' ) );
		}

		if ( email_exists( $email ) ) {
			return new WP_Error( 'email_taken', __( 'This email is already registered.', 'cari-prop-shop-login' ) );
		}
		return true;
	}

	public function validate_required_fields( $fields, $required_fields ) {
		foreach ( $required_fields as $field ) {
			if ( ! isset( $fields[ $field ] ) || empty( $fields[ $field ] ) ) {
				return new WP_Error( 'required_field', sprintf( __( 'The field %s is required.', 'cari-prop-shop-login' ), $field ) );
			}
		}
		return true;
	}

	public function validate_profile_update( $user_id, $data ) {
		if ( isset( $data['user_email'] ) ) {
			$current_user = get_userdata( $user_id );
			if ( $data['user_email'] !== $current_user->user_email ) {
				$email_validation = $this->check_email_availability( $data['user_email'] );
				if ( is_wp_error( $email_validation ) ) {
					return $email_validation;
				}
			}
		}

		if ( isset( $data['cps_phone'] ) ) {
			$phone_validation = $this->validate_phone( $data['cps_phone'] );
			if ( is_wp_error( $phone_validation ) ) {
				return $phone_validation;
			}
		}

		return true;
	}
}