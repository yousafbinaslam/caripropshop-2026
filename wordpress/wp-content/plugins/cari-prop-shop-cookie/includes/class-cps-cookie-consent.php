<?php
if (!defined('ABSPATH')) {
    exit;
}

class CPS_Cookie_Consent {
    private static $instance = null;
    private $cookie_name = 'cps_cookie_consent';
    private $consent_log_table;

    private function __construct() {
        $this->init_table();
    }

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function init_table() {
        global $wpdb;
        $this->consent_log_table = $wpdb->prefix . 'cps_cookie_consent_log';
    }

    public function get_consent() {
        if (isset($_COOKIE[$this->cookie_name])) {
            return json_decode(wp_unslash($_COOKIE[$this->cookie_name]), true);
        }
        return null;
    }

    public function save_consent($consent_data) {
        $cookie_value = json_encode($consent_data);
        
        setcookie(
            $this->cookie_name,
            $cookie_value,
            time() + (365 * 24 * 60 * 60),
            '/'
        );

        $_COOKIE[$this->cookie_name] = $cookie_value;

        $this->log_consent($consent_data);
        
        do_action('cps_cookie_consent_saved', $consent_data);
    }

    private function log_consent($consent_data) {
        global $wpdb;

        $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$this->consent_log_table'");
        
        if (!$table_exists) {
            $this->create_log_table();
        }

        $user_id = get_current_user_id() ? get_current_user_id() : 0;
        
        $wpdb->insert(
            $this->consent_log_table,
            array(
                'user_id' => $user_id,
                'consent_given' => $consent_data['consent_given'] ? 1 : 0,
                'categories' => json_encode($consent_data['categories']),
                'ip_address' => $consent_data['ip_address'],
                'user_agent' => $consent_data['user_agent'],
                'timestamp' => current_time('mysql')
            ),
            array('%d', '%d', '%s', '%s', '%s', '%s')
        );
    }

    private function create_log_table() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS {$this->consent_log_table} (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            user_id bigint(20) NOT NULL DEFAULT 0,
            consent_given tinyint(1) NOT NULL DEFAULT 0,
            categories text NOT NULL,
            ip_address varchar(45) NOT NULL,
            user_agent varchar(255) NOT NULL,
            timestamp datetime NOT NULL,
            PRIMARY KEY  (id),
            KEY user_id (user_id),
            KEY timestamp (timestamp)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    public function has_consent($category = null) {
        $consent = $this->get_consent();
        
        if (!$consent || !isset($consent['consent_given']) || !$consent['consent_given']) {
            return false;
        }

        if ($category === null) {
            return true;
        }

        return isset($consent['categories'][$category]) && $consent['categories'][$category];
    }

    public function revoke_consent() {
        setcookie(
            $this->cookie_name,
            '',
            time() - 3600,
            '/'
        );
        
        unset($_COOKIE[$this->cookie_name]);
        
        do_action('cps_cookie_consent_revoked');
    }

    public static function install() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'cps_cookie_consent_log';
        
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            user_id bigint(20) NOT NULL DEFAULT 0,
            consent_given tinyint(1) NOT NULL DEFAULT 0,
            categories text NOT NULL,
            ip_address varchar(45) NOT NULL,
            user_agent varchar(255) NOT NULL,
            timestamp datetime NOT NULL,
            PRIMARY KEY  (id),
            KEY user_id (user_id),
            KEY timestamp (timestamp)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

register_activation_hook(__FILE__, array('CPS_Cookie_Consent', 'install'));