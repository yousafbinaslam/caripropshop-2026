<?php
/**
 * Plugin Name: CariPropShop Login/Register
 * Plugin URI: https://caripropshop.com
 * Description: Complete login, registration, and user management system for CariPropShop with agent/agency support and social login integration.
 * Version: 1.0.0
 * Author: CariPropShop Team
 * Author URI: https://caripropshop.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: cari-prop-shop-login
 * Domain Path: /languages
 * Network: false
 * Requires at least: 5.8
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CPS_LOGIN_VERSION', '1.0.0' );
define( 'CPS_LOGIN_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CPS_LOGIN_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'CPS_LOGIN_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

define( 'CPS_ROLE_BUYER', 'cps_buyer' );
define( 'CPS_ROLE_AGENT', 'cps_agent' );
define( 'CPS_ROLE_AGENCY', 'cps_agency' );

class CariPropShop_Login {

	private static $instance = null;
	private $user_management;
	private $form_handler;
	private $validation;
	private $admin_settings;

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct() {
		$this->init_includes();
		$this->init_hooks();
		$this->init_shortcodes();
	}

	private function init_includes() {
		require_once CPS_LOGIN_PLUGIN_DIR . 'includes/class-cps-user-management.php';
		require_once CPS_LOGIN_PLUGIN_DIR . 'includes/class-cps-form-handler.php';
		require_once CPS_LOGIN_PLUGIN_DIR . 'includes/class-cps-validation.php';
		require_once CPS_LOGIN_PLUGIN_DIR . 'admin/class-cps-admin-settings.php';

		$this->user_management = new CPS_User_Management();
		$this->form_handler    = new CPS_Form_Handler();
		$this->validation      = new CPS_Validation();
		$this->admin_settings = new CPS_Admin_Settings();
	}

	private function init_hooks() {
		add_action( 'init', array( $this, 'register_custom_roles' ) );
		add_action( 'init', array( $this, 'handle_form_submissions' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_assets' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
		add_filter( 'wp_login_errors', array( $this, 'custom_login_messages' ) );
		add_action( 'password_reset', array( $this, 'handle_password_reset' ), 10, 2 );
		add_action( 'user_register', array( $this, 'handle_user_registration_meta' ) );
		add_action( 'profile_update', array( $this, 'handle_profile_update' ), 10, 2 );
	}

	private function init_shortcodes() {
		add_shortcode( 'cps_login_form', array( $this, 'render_login_form' ) );
		add_shortcode( 'cps_register_form', array( $this, 'render_register_form' ) );
		add_shortcode( 'cps_password_reset', array( $this, 'render_password_reset_form' ) );
	}

	public function register_custom_roles() {
		add_role( CPS_ROLE_BUYER, __( 'Buyer', 'cari-prop-shop-login' ), array(
			'read'         => true,
			'edit_posts'   => false,
			'delete_posts' => false,
		) );

		add_role( CPS_ROLE_AGENT, __( 'Agent', 'cari-prop-shop-login' ), array(
			'read'         => true,
			'edit_posts'   => true,
			'delete_posts' => false,
			'upload_files' => true,
		) );

		add_role( CPS_ROLE_AGENCY, __( 'Agency', 'cari-prop-shop-login' ), array(
			'read'         => true,
			'edit_posts'   => true,
			'delete_posts' => true,
			'upload_files' => true,
			'edit_others_posts' => true,
		) );
	}

	public function handle_form_submissions() {
		if ( isset( $_POST['cps_action'] ) && isset( $_POST['cps_nonce'] ) ) {
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cps_nonce'] ) ), 'cps_form_action' ) ) {
				return;
			}

			$action = sanitize_text_field( wp_unslash( $_POST['cps_action'] ) );

			switch ( $action ) {
				case 'login':
					$this->form_handler->handle_login();
					break;
				case 'register':
					$this->form_handler->handle_registration();
					break;
				case 'password_reset':
					$this->form_handler->handle_password_reset_request();
					break;
				case 'set_new_password':
					$this->form_handler->handle_set_new_password();
					break;
			}
		}
	}

	public function enqueue_public_assets() {
		wp_enqueue_style( 'cps-login-public', CPS_LOGIN_PLUGIN_URL . 'assets/css/public.css', array(), CPS_LOGIN_VERSION );
		wp_enqueue_script( 'cps-login-public', CPS_LOGIN_PLUGIN_URL . 'assets/js/public.js', array( 'jquery' ), CPS_LOGIN_VERSION, true );

		wp_localize_script( 'cps-login-public', 'cpsLogin', array(
			'ajaxUrl'       => admin_url( 'admin-ajax.php' ),
			'nonce'         => wp_create_nonce( 'cps_ajax_nonce' ),
			'loginUrl'      => wp_login_url(),
			'homeUrl'       => home_url(),
			'i18n'          => array(
				'loading'    => __( 'Loading...', 'cari-prop-shop-login' ),
				'success'    => __( 'Success!', 'cari-prop-shop-login' ),
				'error'      => __( 'An error occurred.', 'cari-prop-shop-login' ),
				'validEmail' => __( 'Please enter a valid email address.', 'cari-prop-shop-login' ),
				'passMismatch' => __( 'Passwords do not match.', 'cari-prop-shop-login' ),
				'fieldRequired' => __( 'This field is required.', 'cari-prop-shop-login' ),
			),
		) );
	}

	public function enqueue_admin_assets( $hook ) {
		if ( 'settings_page_cps-login-settings' !== $hook ) {
			return;
		}

		wp_enqueue_style( 'cps-login-admin', CPS_LOGIN_PLUGIN_URL . 'assets/css/admin.css', array(), CPS_LOGIN_VERSION );
		wp_enqueue_script( 'cps-login-admin', CPS_LOGIN_PLUGIN_URL . 'assets/js/admin.js', array( 'jquery' ), CPS_LOGIN_VERSION, true );
	}

	public function render_login_form( $atts ) {
		$atts = shortcode_atts( array(
			'redirect' => '',
			'show_title' => 'true',
			'show_social' => 'true',
		), $atts );

		ob_start();
		include CPS_LOGIN_PLUGIN_DIR . 'public/templates/login-form.php';
		return ob_get_clean();
	}

	public function render_register_form( $atts ) {
		$atts = shortcode_atts( array(
			'role' => 'buyer',
			'show_title' => 'true',
			'show_social' => 'true',
		), $atts );

		ob_start();
		include CPS_LOGIN_PLUGIN_DIR . 'public/templates/register-form.php';
		return ob_get_clean();
	}

	public function render_password_reset_form() {
		ob_start();
		include CPS_LOGIN_PLUGIN_DIR . 'public/templates/password-reset-form.php';
		return ob_get_clean();
	}

	public function custom_login_messages( $errors ) {
		if ( isset( $_GET[' cps_registered'] ) && $_GET['cps_registered'] == 'true' ) {
			$errors = new WP_Error();
			$errors->add( 'registration_complete', __( 'Registration successful! Please check your email to activate your account.', 'cari-prop-shop-login' ), 'message' );
		}
		return $errors;
	}

	public function handle_password_reset( $user, $new_pass ) {
		do_action( 'cps_password_reset_notification', $user, $new_pass );
	}

	public function handle_user_registration_meta( $user_id ) {
		if ( isset( $_POST['cps_user_role'] ) ) {
			$role = sanitize_text_field( wp_unslash( $_POST['cps_user_role'] ) );
			$valid_roles = array( CPS_ROLE_BUYER, CPS_ROLE_AGENT, CPS_ROLE_AGENCY );
			if ( in_array( $role, $valid_roles, true ) ) {
				$user = new WP_User( $user_id );
				$user->set_role( $role );
			}
		}

		$extra_fields = array( 'cps_phone', 'cps_company_name', 'cps_license_number', 'cps_agency_name', 'cps_address', 'cps_city', 'cps_state', 'cps_zip_code', 'cps_country' );
		foreach ( $extra_fields as $field ) {
			if ( isset( $_POST[ $field ] ) ) {
				update_user_meta( $user_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
			}
		}

		update_user_meta( $user_id, 'cps_registration_date', current_time( 'mysql' ) );
		update_user_meta( $user_id, 'cps_account_status', 'active' );
	}

	public function handle_profile_update( $user_id, $old_user ) {
		$extra_fields = array( 'cps_phone', 'cps_company_name', 'cps_license_number', 'cps_agency_name', 'cps_address', 'cps_city', 'cps_state', 'cps_zip_code', 'cps_country' );
		foreach ( $extra_fields as $field ) {
			if ( isset( $_POST[ $field ] ) ) {
				update_user_meta( $user_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
			}
		}
	}

	public function get_user_management() {
		return $this->user_management;
	}

	public function get_validation() {
		return $this->validation;
	}

	public function get_settings() {
		return $this->admin_settings->get_settings();
	}
}

function cps_login() {
	return CariPropShop_Login::instance();
}

cps_login();