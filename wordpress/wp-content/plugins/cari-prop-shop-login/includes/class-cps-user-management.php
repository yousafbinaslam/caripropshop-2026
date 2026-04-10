<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CPS_User_Management {

	private $db;
	private $table_name;

	public function __construct() {
		global $wpdb;
		$this->db         = $wpdb;
		$this->table_name = $wpdb->prefix . 'cps_users';
	}

	public function create_user( $data ) {
		$defaults = array(
			'user_login'      => '',
			'user_pass'       => '',
			'user_email'      => '',
			'user_nicename'   => '',
			'display_name'    => '',
			'user_nicename'   => '',
			'user_registered' => current_time( 'mysql' ),
			'role'            => CPS_ROLE_BUYER,
			'user_status'     => 0,
		);

		$data = wp_parse_args( $data, $defaults );

		if ( empty( $data['user_login'] ) || empty( $data['user_email'] ) ) {
			return new WP_Error( 'missing_fields', __( 'Username and email are required.', 'cari-prop-shop-login' ) );
		}

		if ( ! is_email( $data['user_email'] ) ) {
			return new WP_Error( 'invalid_email', __( 'Invalid email address.', 'cari-prop-shop-login' ) );
		}

		if ( username_exists( $data['user_login'] ) ) {
			return new WP_Error( 'username_exists', __( 'Username already exists.', 'cari-prop-shop-login' ) );
		}

		if ( email_exists( $data['user_email'] ) ) {
			return new WP_Error( 'email_exists', __( 'Email already exists.', 'cari-prop-shop-login' ) );
		}

		$result = wp_insert_user( $data );

		if ( is_wp_error( $result ) ) {
			return $result;
		}

		do_action( 'cps_after_user_creation', $result, $data );

		return $result;
	}

	public function update_user( $user_id, $data ) {
		$data['ID'] = absint( $user_id );

		$result = wp_update_user( $data );

		if ( is_wp_error( $result ) ) {
			return $result;
		}

		do_action( 'cps_after_user_update', $user_id, $data );

		return $result;
	}

	public function delete_user( $user_id ) {
		$user_id = absint( $user_id );

		if ( ! $user_id || ! get_userdata( $user_id ) ) {
			return new WP_Error( 'invalid_user', __( 'Invalid user ID.', 'cari-prop-shop-login' ) );
		}

		require_once ABSPATH . 'wp-admin/includes/user.php';
		$result = wp_delete_user( $user_id );

		if ( ! $result ) {
			return new WP_Error( 'delete_failed', __( 'Failed to delete user.', 'cari-prop-shop-login' ) );
		}

		do_action( 'cps_after_user_deletion', $user_id );

		return true;
	}

	public function get_user_by_field( $field, $value ) {
		if ( 'id' === $field || 'ID' === $field ) {
			$user = get_userdata( absint( $value ) );
		} else {
			$user = get_user_by( $field, $value );
		}

		return $user ?: false;
	}

	public function get_users_by_role( $role, $args = array() ) {
		$defaults = array(
			'role'    => $role,
			'number'  => -1,
			'fields'  => 'all',
		);

		$args = wp_parse_args( $args, $defaults );

		$users = get_users( $args );

		return $users;
	}

	public function get_all_agents() {
		return $this->get_users_by_role( CPS_ROLE_AGENT );
	}

	public function get_all_agencies() {
		return $this->get_users_by_role( CPS_ROLE_AGENCY );
	}

	public function get_user_meta( $user_id, $meta_key, $single = true ) {
		$user_id = absint( $user_id );
		return get_user_meta( $user_id, $meta_key, $single );
	}

	public function update_user_meta( $user_id, $meta_key, $meta_value ) {
		$user_id = absint( $user_id );
		return update_user_meta( $user_id, $meta_key, $meta_value );
	}

	public function delete_user_meta( $user_id, $meta_key ) {
		$user_id = absint( $user_id );
		return delete_user_meta( $user_id, $meta_key );
	}

	public function verify_user_credentials( $username, $password ) {
		$creds = array(
			'user_login'    => $username,
			'user_password'  => $password,
			'remember'      => true,
		);

		$user = wp_signon( $creds, false );

		if ( is_wp_error( $user ) ) {
			return $user;
		}

		return $user;
	}

	public function change_user_password( $user_id, $new_password ) {
		$user_id = absint( $user_id );

		if ( ! $user_id || ! get_userdata( $user_id ) ) {
			return new WP_Error( 'invalid_user', __( 'Invalid user.', 'cari-prop-shop-login' ) );
		}

		wp_set_password( $new_password, $user_id );

		do_action( 'cps_password_changed', $user_id );

		return true;
	}

	public function set_user_verification( $user_id, $verified = true ) {
		$user_id = absint( $user_id );
		$status  = $verified ? 'verified' : 'pending';
		update_user_meta( $user_id, 'cps_email_verified', $status );
		update_user_meta( $user_id, 'cps_verified_at', current_time( 'mysql' ) );
	}

	public function is_user_verified( $user_id ) {
		$status = $this->get_user_meta( $user_id, 'cps_email_verified', true );
		return 'verified' === $status;
	}

	public function set_user_status( $user_id, $status ) {
		$valid_statuses = array( 'active', 'inactive', 'suspended', 'pending' );
		if ( ! in_array( $status, $valid_statuses, true ) ) {
			return new WP_Error( 'invalid_status', __( 'Invalid status.', 'cari-prop-shop-login' ) );
		}

		update_user_meta( absint( $user_id ), 'cps_account_status', $status );
		return true;
	}

	public function get_user_status( $user_id ) {
		$status = $this->get_user_meta( $user_id, 'cps_account_status', true );
		return $status ?: 'pending';
	}

	public function get_user_profile_data( $user_id ) {
		$user_id = absint( $user_id );
		$user    = get_userdata( $user_id );

		if ( ! $user ) {
			return false;
		}

		$profile_data = array(
			'ID'              => $user->ID,
			'username'        => $user->user_login,
			'email'           => $user->user_email,
			'first_name'      => $user->first_name,
			'last_name'       => $user->last_name,
			'display_name'   => $user->display_name,
			'role'            => $user->roles[0] ?? '',
			'phone'           => $this->get_user_meta( $user_id, 'cps_phone', true ),
			'company_name'    => $this->get_user_meta( $user_id, 'cps_company_name', true ),
			'license_number' => $this->get_user_meta( $user_id, 'cps_license_number', true ),
			'agency_name'    => $this->get_user_meta( $user_id, 'cps_agency_name', true ),
			'address'         => $this->get_user_meta( $user_id, 'cps_address', true ),
			'city'            => $this->get_user_meta( $user_id, 'cps_city', true ),
			'state'           => $this->get_user_meta( $user_id, 'cps_state', true ),
			'zip_code'        => $this->get_user_meta( $user_id, 'cps_zip_code', true ),
			'country'         => $this->get_user_meta( $user_id, 'cps_country', true ),
			'registration_date' => $this->get_user_meta( $user_id, 'cps_registration_date', true ),
			'account_status'  => $this->get_user_status( $user_id ),
			'is_verified'     => $this->is_user_verified( $user_id ),
			'avatar'          => get_avatar_url( $user_id ),
		);

		return apply_filters( 'cps_user_profile_data', $profile_data, $user_id );
	}

	public function search_users( $search_term, $args = array() ) {
		$defaults = array(
			'search'         => $search_term,
			'search_columns' => array( 'user_login', 'user_email', 'display_name' ),
			'number'         => 20,
			'fields'         => 'all',
		);

		$args = wp_parse_args( $args, $defaults );

		$users = get_users( $args );

		return $users;
	}

	public function count_users_by_role( $role = '' ) {
		if ( empty( $role ) ) {
			return count_users()['total_users'];
		}

		$users = get_users( array(
			'role'   => $role,
			'fields' => 'ID',
		) );

		return count( $users );
	}

	public function get_user_avatar_url( $user_id ) {
		$user_id = absint( $user_id );
		$avatar_id = get_user_meta( $user_id, 'cps_avatar_id', true );

		if ( $avatar_id ) {
			$image = wp_get_attachment_image_src( $avatar_id, 'full' );
			if ( $image ) {
				return $image[0];
			}
		}

		return get_avatar_url( $user_id );
	}

	public function set_user_avatar( $user_id, $attachment_id ) {
		$user_id       = absint( $user_id );
		$attachment_id = absint( $attachment_id );

		if ( ! $user_id || ! $attachment_id ) {
			return false;
		}

		update_user_meta( $user_id, 'cps_avatar_id', $attachment_id );
		return true;
	}
}