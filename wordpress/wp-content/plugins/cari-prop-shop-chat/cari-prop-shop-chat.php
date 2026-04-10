<?php
/**
 * Plugin Name: CariPropShop Chat
 * Plugin URI: https://caripropshop.com
 * Description: Live chat functionality for CariPropShop - Real-time customer chat widget with admin dashboard
 * Version: 1.0.0
 * Author: CariPropShop
 * Author URI: https://caripropshop.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: cari-prop-shop-chat
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CPS_CHAT_VERSION', '1.0.0' );
define( 'CPS_CHAT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CPS_CHAT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'CPS_CHAT_DB_VERSION', '1.0.0' );

class CariPropShop_Chat {

	private static $instance = null;
	private $options;
	private $db_version_option = 'cps_chat_db_version';

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		$this->options = get_option( 'cps_chat_options', array() );

		$this->load_dependencies();
		$this->init_hooks();
		$this->create_tables();
	}

	private function load_dependencies() {
		require_once CPS_CHAT_PLUGIN_DIR . 'includes/class-cps-chat-storage.php';
		require_once CPS_CHAT_PLUGIN_DIR . 'includes/class-cps-chat-handler.php';
	}

	private function init_hooks() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_assets' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'wp_ajax_cps_chat_send_message', array( $this, 'handle_ajax_send_message' ) );
		add_action( 'wp_ajax_nopriv_cps_chat_send_message', array( $this, 'handle_ajax_send_message' ) );
		add_action( 'wp_ajax_cps_chat_get_messages', array( $this, 'handle_ajax_get_messages' ) );
		add_action( 'wp_ajax_nopriv_cps_chat_get_messages', array( $this, 'handle_ajax_get_messages' ) );
		add_action( 'wp_ajax_cps_chat_get_conversations', array( $this, 'handle_ajax_get_conversations' ) );
		add_action( 'wp_ajax_cps_chat_get_conversation', array( $this, 'handle_ajax_get_conversation' ) );
		add_action( 'wp_ajax_cps_chat_send_admin_reply', array( $this, 'handle_ajax_admin_reply' ) );
		add_action( 'wp_ajax_cps_chat_save_settings', array( $this, 'handle_ajax_save_settings' ) );
		add_action( 'wp_ajax_cps_chat_mark_read', array( $this, 'handle_ajax_mark_read' ) );
		add_action( 'wp_footer', array( $this, 'output_chat_widget' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugin_action_links' ) );
	}

	private function create_tables() {
		$installed_version = get_option( $this->db_version_option );

		if ( $installed_version !== CPS_CHAT_DB_VERSION ) {
			CPS_Chat_Storage::create_tables();
			update_option( $this->db_version_option, CPS_CHAT_DB_VERSION );
		}
	}

	public function register_settings() {
		register_setting(
			'cps_chat_settings',
			'cps_chat_options',
			array(
				'sanitize_callback' => array( $this, 'sanitize_settings' ),
			)
		);
	}

	public function sanitize_settings( $input ) {
		$sanitized = array();

		$sanitized['enabled'] = isset( $input['enabled'] ) ? 1 : 0;
		$sanitized['position'] = isset( $input['position'] ) ? sanitize_text_field( $input['position'] ) : 'right';
		$sanitized['button_color'] = isset( $input['button_color'] ) ? sanitize_hex_color( $input['button_color'] ) : '#4a90d9';
		$sanitized['header_color'] = isset( $input['header_color'] ) ? sanitize_hex_color( $input['header_color'] ) : '#4a90d9';
		$sanitized['chat_bg_color'] = isset( $input['chat_bg_color'] ) ? sanitize_hex_color( $input['chat_bg_color'] ) : '#ffffff';
		$sanitized['user_message_color'] = isset( $input['user_message_color'] ) ? sanitize_hex_color( $input['user_message_color'] ) : '#4a90d9';
		$sanitized['bot_message_color'] = isset( $input['bot_message_color'] ) ? sanitize_hex_color( $input['bot_message_color'] ) : '#f0f0f0';
		$sanitized['auto_open'] = isset( $input['auto_open'] ) ? 1 : 0;
		$sanitized['auto_open_delay'] = isset( $input['auto_open_delay'] ) ? intval( $input['auto_open_delay'] ) : 5000;
		$sanitized['show_on_mobile'] = isset( $input['show_on_mobile'] ) ? 1 : 0;
		$sanitized['enable_sound'] = isset( $input['enable_sound'] ) ? 1 : 0;
		$sanitized['enable_notifications'] = isset( $input['enable_notifications'] ) ? 1 : 0;
		$sanitized['notification_email'] = isset( $input['notification_email'] ) ? sanitize_email( $input['notification_email'] ) : get_option( 'admin_email' );
		$sanitized['welcome_message'] = isset( $input['welcome_message'] ) ? sanitize_textarea_field( $input['welcome_message'] ) : __( 'Hello! How can we help you today?', 'cari-prop-shop-chat' );
		$sanitized['company_name'] = isset( $input['company_name'] ) ? sanitize_text_field( $input['company_name'] ) : get_bloginfo( 'name' );
		$sanitized['bot_responses'] = isset( $input['bot_responses'] ) ? wp_kses_post( $input['bot_responses'] ) : $this->get_default_bot_responses();
		$sanitized['initial_delay'] = isset( $input['initial_delay'] ) ? intval( $input['initial_delay'] ) : 1000;
		$sanitized['typing_indicator'] = isset( $input['typing_indicator'] ) ? 1 : 0;

		return $sanitized;
	}

	private function get_default_bot_responses() {
		$defaults = array(
			array(
				'keywords' => 'hello,hi,hey,greetings',
				'response' => 'Hello! Welcome to CariPropShop. How can we assist you today?',
			),
			array(
				'keywords' => 'property,house,home,listing',
				'response' => 'We have many great properties available! Would you like me to show you our featured listings?',
			),
			array(
				'keywords' => 'contact,email,phone,reach',
				'response' => 'You can reach us at support@caripropshop.com or call us at (555) 123-4567.',
			),
			array(
				'keywords' => 'help,support,assist',
				'response' => 'I\'m here to help! Please let us know what you need assistance with.',
			),
			array(
				'keywords' => 'default',
				'response' => 'Thank you for your message! An agent will be with you shortly. In the meantime, feel free to browse our properties.',
			),
		);

		return json_encode( $defaults );
	}

	public function add_admin_menu() {
		add_menu_page(
			__( 'Chat Dashboard', 'cari-prop-shop-chat' ),
			__( 'CariPropShop Chat', 'cari-prop-shop-chat' ),
			'manage_options',
			'cps-chat-dashboard',
			array( $this, 'render_admin_dashboard' ),
			'dashicons-testimonial',
			30
		);

		add_submenu_page(
			'cps-chat-dashboard',
			__( 'Conversations', 'cari-prop-shop-chat' ),
			__( 'Conversations', 'cari-prop-shop-chat' ),
			'manage_options',
			'cps-chat-conversations',
			array( $this, 'render_admin_conversations' )
		);

		add_submenu_page(
			'cps-chat-dashboard',
			__( 'Settings', 'cari-prop-shop-chat' ),
			__( 'Settings', 'cari-prop-shop-chat' ),
			'manage_options',
			'cps-chat-settings',
			array( $this, 'render_admin_settings' )
		);
	}

	public function render_admin_dashboard() {
		$stats = CPS_Chat_Storage::get_statistics();
		include CPS_CHAT_PLUGIN_DIR . 'admin/views/dashboard.php';
	}

	public function render_admin_conversations() {
		$conversations = CPS_Chat_Storage::get_all_conversations();
		include CPS_CHAT_PLUGIN_DIR . 'admin/views/conversations.php';
	}

	public function render_admin_settings() {
		$options = get_option( 'cps_chat_options', array() );
		include CPS_CHAT_PLUGIN_DIR . 'admin/views/settings.php';
	}

	public function enqueue_frontend_assets() {
		if ( ! $this->is_chat_enabled() ) {
			return;
		}

		if ( $this->is_mobile() && ! $this->options['show_on_mobile'] ) {
			return;
		}

		wp_enqueue_style(
			'cps-chat-frontend',
			CPS_CHAT_PLUGIN_URL . 'assets/css/chat-frontend.css',
			array(),
			CPS_CHAT_VERSION
		);

		wp_enqueue_script(
			'cps-chat-frontend',
			CPS_CHAT_PLUGIN_URL . 'assets/js/chat-frontend.js',
			array( 'jquery' ),
			CPS_CHAT_VERSION,
			true
		);

		wp_localize_script(
			'cps-chat-frontend',
			'cpsChatData',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'cps_chat_nonce' ),
				'options' => $this->options,
			)
		);
	}

	public function enqueue_admin_assets( $hook ) {
		if ( strpos( $hook, 'cps-chat' ) === false ) {
			return;
		}

		wp_enqueue_style(
			'cps-chat-admin',
			CPS_CHAT_PLUGIN_URL . 'assets/css/chat-admin.css',
			array(),
			CPS_CHAT_VERSION
		);

		wp_enqueue_script(
			'cps-chat-admin',
			CPS_CHAT_PLUGIN_URL . 'assets/js/chat-admin.js',
			array( 'jquery' ),
			CPS_CHAT_VERSION,
			true
		);

		wp_localize_script(
			'cps-chat-admin',
			'cpsChatAdminData',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'cps_chat_nonce' ),
			)
		);
	}

	private function is_chat_enabled() {
		$options = get_option( 'cps_chat_options', array() );
		return isset( $options['enabled'] ) && $options['enabled'];
	}

	private function is_mobile() {
		return wp_is_mobile();
	}

	public function output_chat_widget() {
		if ( ! $this->is_chat_enabled() ) {
			return;
		}

		if ( $this->is_mobile() && ! $this->options['show_on_mobile'] ) {
			return;
		}

		include CPS_CHAT_PLUGIN_DIR . 'public/templates/chat-widget.php';
	}

	public function handle_ajax_send_message() {
		check_ajax_referer( 'cps_chat_nonce', 'nonce' );

		$sender_type = isset( $_POST['sender_type'] ) ? sanitize_text_field( $_POST['sender_type'] ) : 'visitor';
		$session_id  = isset( $_POST['session_id'] ) ? sanitize_text_field( $_POST['session_id'] ) : '';
		$message     = isset( $_POST['message'] ) ? sanitize_textarea_field( $_POST['message'] ) : '';
		$visitor_name = isset( $_POST['visitor_name'] ) ? sanitize_text_field( $_POST['visitor_name'] ) : 'Visitor';
		$visitor_email = isset( $_POST['visitor_email'] ) ? sanitize_email( $_POST['visitor_email'] ) : '';

		if ( empty( $message ) || empty( $session_id ) ) {
			wp_send_json_error( array( 'message' => 'Invalid request' ) );
		}

		$result = CPS_Chat_Handler::handle_incoming_message(
			$session_id,
			$message,
			$sender_type,
			$visitor_name,
			$visitor_email
		);

		if ( $result ) {
			wp_send_json_success( array(
				'message' => 'Message sent successfully',
				'conversation_id' => $result['conversation_id'],
			) );
		} else {
			wp_send_json_error( array( 'message' => 'Failed to send message' ) );
		}
	}

	public function handle_ajax_get_messages() {
		check_ajax_referer( 'cps_chat_nonce', 'nonce' );

		$session_id = isset( $_POST['session_id'] ) ? sanitize_text_field( $_POST['session_id'] ) : '';
		$last_id    = isset( $_POST['last_id'] ) ? intval( $_POST['last_id'] ) : 0;

		if ( empty( $session_id ) ) {
			wp_send_json_error( array( 'message' => 'Invalid session' ) );
		}

		$messages = CPS_Chat_Storage::get_messages( $session_id, $last_id );

		wp_send_json_success( array(
			'messages' => $messages,
		) );
	}

	public function handle_ajax_get_conversations() {
		check_ajax_referer( 'cps_chat_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => 'Unauthorized' ) );
		}

		$page = isset( $_POST['page'] ) ? intval( $_POST['page'] ) : 1;
		$per_page = 20;

		$conversations = CPS_Chat_Storage::get_all_conversations( $page, $per_page );

		wp_send_json_success( array(
			'conversations' => $conversations,
		) );
	}

	public function handle_ajax_get_conversation() {
		check_ajax_referer( 'cps_chat_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => 'Unauthorized' ) );
		}

		$conversation_id = isset( $_POST['conversation_id'] ) ? intval( $_POST['conversation_id'] ) : 0;

		if ( empty( $conversation_id ) ) {
			wp_send_json_error( array( 'message' => 'Invalid conversation ID' ) );
		}

		$conversation = CPS_Chat_Storage::get_conversation( $conversation_id );
		$messages = CPS_Chat_Storage::get_conversation_messages( $conversation_id );

		wp_send_json_success( array(
			'conversation' => $conversation,
			'messages'     => $messages,
		) );
	}

	public function handle_ajax_admin_reply() {
		check_ajax_referer( 'cps_chat_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => 'Unauthorized' ) );
		}

		$conversation_id = isset( $_POST['conversation_id'] ) ? intval( $_POST['conversation_id'] ) : 0;
		$message         = isset( $_POST['message'] ) ? sanitize_textarea_field( $_POST['message'] ) : '';

		if ( empty( $conversation_id ) || empty( $message ) ) {
			wp_send_json_error( array( 'message' => 'Invalid request' ) );
		}

		$result = CPS_Chat_Handler::send_admin_reply( $conversation_id, $message );

		if ( $result ) {
			wp_send_json_success( array( 'message' => 'Reply sent successfully' ) );
		} else {
			wp_send_json_error( array( 'message' => 'Failed to send reply' ) );
		}
	}

	public function handle_ajax_save_settings() {
		check_ajax_referer( 'cps_chat_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => 'Unauthorized' ) );
		}

		$options = isset( $_POST['options'] ) ? $_POST['options'] : array();

		update_option( 'cps_chat_options', $options );

		wp_send_json_success( array( 'message' => 'Settings saved successfully' ) );
	}

	public function handle_ajax_mark_read() {
		check_ajax_referer( 'cps_chat_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => 'Unauthorized' ) );
		}

		$conversation_id = isset( $_POST['conversation_id'] ) ? intval( $_POST['conversation_id'] ) : 0;

		if ( empty( $conversation_id ) ) {
			wp_send_json_error( array( 'message' => 'Invalid conversation ID' ) );
		}

		CPS_Chat_Storage::mark_conversation_read( $conversation_id );

		wp_send_json_success( array( 'message' => 'Marked as read' ) );
	}

	public function plugin_action_links( $links ) {
		$settings_link = '<a href="' . admin_url( 'admin.php?page=cps-chat-settings' ) . '">' . __( 'Settings', 'cari-prop-shop-chat' ) . '</a>';
		array_unshift( $links, $settings_link );
		return $links;
	}
}

function CPS_Chat() {
	return CariPropShop_Chat::get_instance();
}

CPS_Chat();