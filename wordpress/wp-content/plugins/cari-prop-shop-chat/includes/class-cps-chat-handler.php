<?php
/**
 * Chat Handler Class - Message processing and bot responses
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CPS_Chat_Handler {

	public static function handle_incoming_message( $session_id, $message, $sender_type = 'visitor', $visitor_name = '', $visitor_email = '' ) {
		$options = get_option( 'cps_chat_options', array() );

		$conversation = CPS_Chat_Storage::get_or_create_conversation( $session_id, $visitor_name, $visitor_email );

		CPS_Chat_Storage::add_message( $conversation->id, $message, $sender_type );

		if ( $sender_type === 'visitor' ) {
			self::send_notification_email( $conversation, $message, $options );

			if ( isset( $options['enable_notifications'] ) && $options['enable_notifications'] ) {
				self::process_and_respond( $conversation->id, $message, $options );
			}
		}

		return array(
			'conversation_id' => $conversation->id,
			'message_id'      => $wpdb->insert_id ?? 0,
		);
	}

	private static function send_notification_email( $conversation, $message, $options ) {
		if ( ! isset( $options['enable_notifications'] ) || ! $options['enable_notifications'] ) {
			return;
		}

		$to = isset( $options['notification_email'] ) && $options['notification_email'] 
			? $options['notification_email'] 
			: get_option( 'admin_email' );

		$subject = sprintf( '[%s] New Chat Message from %s', 
			get_bloginfo( 'name' ), 
			$conversation->visitor_name 
		);

		$message_body = sprintf(
			"New chat message received:\n\n"
			. "Visitor: %s\n"
			. "Email: %s\n"
			. "Message: %s\n\n"
			. "View conversation: %s",
			$conversation->visitor_name,
			$conversation->visitor_email,
			$message,
			admin_url( 'admin.php?page=cps-chat-conversations&conversation_id=' . $conversation->id )
		);

		wp_mail( $to, $subject, $message_body );
	}

	private static function process_and_respond( $conversation_id, $user_message, $options ) {
		$bot_responses = isset( $options['bot_responses'] ) ? json_decode( $options['bot_responses'], true ) : array();
		
		if ( empty( $bot_responses ) ) {
			return;
		}

		$response = self::generate_bot_response( $user_message, $bot_responses );

		$initial_delay = isset( $options['initial_delay'] ) ? intval( $options['initial_delay'] ) : 1000;

		CPS_Chat_Storage::add_message( $conversation_id, $response, 'bot' );
	}

	private static function generate_bot_response( $user_message, $bot_responses ) {
		$user_message_lower = strtolower( $user_message );

		foreach ( $bot_responses as $bot_response ) {
			if ( ! isset( $bot_response['keywords'] ) || ! isset( $bot_response['response'] ) ) {
				continue;
			}

			$keywords = explode( ',', $bot_response['keywords'] );
			$keywords = array_map( 'trim', $keywords );

			foreach ( $keywords as $keyword ) {
				if ( $keyword === 'default' ) {
					continue;
				}

				if ( strpos( $user_message_lower, strtolower( $keyword ) ) !== false ) {
					return $bot_response['response'];
				}
			}
		}

		foreach ( $bot_responses as $bot_response ) {
			if ( isset( $bot_response['keywords'] ) && $bot_response['keywords'] === 'default' ) {
				return $bot_response['response'];
			}
		}

		return __( 'Thank you for your message! An agent will be with you shortly.', 'cari-prop-shop-chat' );
	}

	public static function send_admin_reply( $conversation_id, $message ) {
		$conversation = CPS_Chat_Storage::get_conversation( $conversation_id );

		if ( ! $conversation ) {
			return false;
		}

		CPS_Chat_Storage::add_message( $conversation_id, $message, 'admin', 1 );

		return true;
	}

	public static function format_message_time( $datetime ) {
		$timestamp = strtotime( $datetime );
		$now = current_time( 'timestamp' );
		$diff = $now - $timestamp;

		if ( $diff < 60 ) {
			return __( 'Just now', 'cari-prop-shop-chat' );
		} elseif ( $diff < 3600 ) {
			$mins = floor( $diff / 60 );
			return sprintf( _n( '%d minute ago', '%d minutes ago', $mins, 'cari-prop-shop-chat' ), $mins );
		} elseif ( $diff < 86400 ) {
			$hours = floor( $diff / 3600 );
			return sprintf( _n( '%d hour ago', '%d hours ago', $hours, 'cari-prop-shop-chat' ), $hours );
		} else {
			return date( 'M j, g:i a', $timestamp );
		}
	}
}