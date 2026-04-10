<?php
/**
 * Chat Storage Class - Database operations for chat messages and conversations
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CPS_Chat_Storage {

	private static $table_conversations = 'cps_chat_conversations';
	private static $table_messages = 'cps_chat_messages';

	public static function create_tables() {
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		$sql_conversations = "CREATE TABLE {$wpdb->prefix}" . self::$table_conversations . " (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			session_id varchar(100) NOT NULL,
			visitor_name varchar(255) DEFAULT 'Visitor',
			visitor_email varchar(255) DEFAULT '',
			status varchar(20) DEFAULT 'active',
			unread_count int(11) DEFAULT 0,
			last_activity datetime DEFAULT CURRENT_TIMESTAMP,
			created_at datetime DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY  (id),
			KEY session_id (session_id),
			KEY status (status),
			KEY last_activity (last_activity)
		) $charset_collate;";

		$sql_messages = "CREATE TABLE {$wpdb->prefix}" . self::$table_messages . " (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			conversation_id bigint(20) NOT NULL,
			message text NOT NULL,
			sender_type varchar(20) NOT NULL,
			is_read tinyint(1) DEFAULT 0,
			created_at datetime DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY  (id),
			KEY conversation_id (conversation_id),
			KEY created_at (created_at)
		) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql_conversations );
		dbDelta( $sql_messages );
	}

	public static function create_conversation( $session_id, $visitor_name = '', $visitor_email = '' ) {
		global $wpdb;

		$existing = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT id FROM {$wpdb->prefix}" . self::$table_conversations . " WHERE session_id = %s",
				$session_id
			)
		);

		if ( $existing ) {
			return $existing->id;
		}

		$wpdb->insert(
			$wpdb->prefix . self::$table_conversations,
			array(
				'session_id'    => $session_id,
				'visitor_name'  => $visitor_name,
				'visitor_email' => $visitor_email,
				'status'        => 'active',
				'unread_count'  => 0,
			),
			array( '%s', '%s', '%s', '%s', '%d' )
		);

		return $wpdb->insert_id;
	}

	public static function get_or_create_conversation( $session_id, $visitor_name = '', $visitor_email = '' ) {
		global $wpdb;

		$conversation = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM {$wpdb->prefix}" . self::$table_conversations . " WHERE session_id = %s",
				$session_id
			)
		);

		if ( ! $conversation ) {
			$conversation_id = self::create_conversation( $session_id, $visitor_name, $visitor_email );
			$conversation = $wpdb->get_row(
				$wpdb->prepare(
					"SELECT * FROM {$wpdb->prefix}" . self::$table_conversations . " WHERE id = %d",
					$conversation_id
				)
			);
		}

		return $conversation;
	}

	public static function add_message( $conversation_id, $message, $sender_type, $is_read = 0 ) {
		global $wpdb;

		$wpdb->insert(
			$wpdb->prefix . self::$table_messages,
			array(
				'conversation_id' => $conversation_id,
				'message'         => $message,
				'sender_type'     => $sender_type,
				'is_read'         => $is_read,
			),
			array( '%d', '%s', '%s', '%d' )
		);

		if ( $sender_type === 'visitor' ) {
			$wpdb->query(
				$wpdb->prepare(
					"UPDATE {$wpdb->prefix}" . self::$table_conversations . " 
					SET unread_count = unread_count + 1, 
					    last_activity = NOW() 
					WHERE id = %d",
					$conversation_id
				)
			);
		} else {
			$wpdb->query(
				$wpdb->prepare(
					"UPDATE {$wpdb->prefix}" . self::$table_conversations . " 
					SET last_activity = NOW() 
					WHERE id = %d",
					$conversation_id
				)
			);
		}

		return $wpdb->insert_id;
	}

	public static function get_messages( $session_id, $last_id = 0 ) {
		global $wpdb;

		$conversation = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT id FROM {$wpdb->prefix}" . self::$table_conversations . " WHERE session_id = %s",
				$session_id
			)
		);

		if ( ! $conversation ) {
			return array();
		}

		$where = $wpdb->prepare( "conversation_id = %d", $conversation->id );

		if ( $last_id > 0 ) {
			$where .= $wpdb->prepare( " AND id > %d", $last_id );
		}

		$messages = $wpdb->get_results(
			"SELECT * FROM {$wpdb->prefix}" . self::$table_messages . " 
			WHERE $where 
			ORDER BY created_at ASC",
			ARRAY_A
		);

		return $messages ? $messages : array();
	}

	public static function get_conversation_messages( $conversation_id ) {
		global $wpdb;

		$messages = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM {$wpdb->prefix}" . self::$table_messages . " 
				WHERE conversation_id = %d 
				ORDER BY created_at ASC",
				$conversation_id
			),
			ARRAY_A
		);

		return $messages ? $messages : array();
	}

	public static function get_all_conversations( $page = 1, $per_page = 20 ) {
		global $wpdb;

		$offset = ( $page - 1 ) * $per_page;

		$conversations = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM {$wpdb->prefix}" . self::$table_conversations . " 
				ORDER BY last_activity DESC 
				LIMIT %d OFFSET %d",
				$per_page,
				$offset
			),
			ARRAY_A
		);

		return $conversations ? $conversations : array();
	}

	public static function get_conversation( $conversation_id ) {
		global $wpdb;

		$conversation = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM {$wpdb->prefix}" . self::$table_conversations . " WHERE id = %d",
				$conversation_id
			),
			ARRAY_A
		);

		return $conversation;
	}

	public static function mark_conversation_read( $conversation_id ) {
		global $wpdb;

		$wpdb->update(
			$wpdb->prefix . self::$table_conversations,
			array( 'unread_count' => 0 ),
			array( 'id' => $conversation_id ),
			array( '%d' ),
			array( '%d' )
		);

		$wpdb->update(
			$wpdb->prefix . self::$table_messages,
			array( 'is_read' => 1 ),
			array( 'conversation_id' => $conversation_id, 'sender_type' => 'visitor' ),
			array( '%d' ),
			array( '%d', '%s' )
		);
	}

	public static function get_unread_count() {
		global $wpdb;

		$count = $wpdb->get_var(
			"SELECT SUM(unread_count) FROM {$wpdb->prefix}" . self::$table_conversations
		);

		return intval( $count );
	}

	public static function get_statistics() {
		global $wpdb;

		$total_conversations = $wpdb->get_var(
			"SELECT COUNT(*) FROM {$wpdb->prefix}" . self::$table_conversations
		);

		$active_conversations = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT COUNT(*) FROM {$wpdb->prefix}" . self::$table_conversations . " WHERE status = %s",
				'active'
			)
		);

		$unread_messages = $wpdb->get_var(
			"SELECT COUNT(*) FROM {$wpdb->prefix}" . self::$table_messages . " WHERE is_read = 0 AND sender_type = 'visitor'"
		);

		$today = date( 'Y-m-d' );
		$today_conversations = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT COUNT(*) FROM {$wpdb->prefix}" . self::$table_conversations . " WHERE DATE(created_at) = %s",
				$today
			)
		);

		return array(
			'total_conversations'   => intval( $total_conversations ),
			'active_conversations' => intval( $active_conversations ),
			'unread_messages'      => intval( $unread_messages ),
			'today_conversations'  => intval( $today_conversations ),
		);
	}

	public static function update_visitor_info( $session_id, $visitor_name, $visitor_email ) {
		global $wpdb;

		$wpdb->update(
			$wpdb->prefix . self::$table_conversations,
			array(
				'visitor_name'  => $visitor_name,
				'visitor_email' => $visitor_email,
			),
			array( 'session_id' => $session_id ),
			array( '%s', '%s' ),
			array( '%s' )
		);
	}

	public static function close_conversation( $conversation_id ) {
		global $wpdb;

		$wpdb->update(
			$wpdb->prefix . self::$table_conversations,
			array( 'status' => 'closed' ),
			array( 'id' => $conversation_id ),
			array( '%s' ),
			array( '%d' )
		);
	}

	public static function delete_conversation( $conversation_id ) {
		global $wpdb;

		$wpdb->delete(
			$wpdb->prefix . self::$table_messages,
			array( 'conversation_id' => $conversation_id ),
			array( '%d' )
		);

		$wpdb->delete(
			$wpdb->prefix . self::$table_conversations,
			array( 'id' => $conversation_id ),
			array( '%d' )
		);
	}
}