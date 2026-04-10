<?php
if (!defined('ABSPATH')) {
    exit;
}

class CPS_Form_Storage {

    private static $instance = null;
    private $table_name;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'cps_form_submissions';
    }

    public function create_tables() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS {$this->table_name} (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            form_type varchar(50) NOT NULL,
            form_data longtext NOT NULL,
            submission_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            ip_address varchar(45) DEFAULT NULL,
            user_agent text DEFAULT NULL,
            status varchar(20) NOT NULL DEFAULT 'new',
            PRIMARY KEY  (id),
            KEY form_type (form_type),
            KEY submission_date (submission_date),
            KEY status (status)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    public function save_submission($form_type, $form_data) {
        global $wpdb;

        $form_data = array_map('sanitize_text_field', $form_data);

        $result = $wpdb->insert(
            $this->table_name,
            array(
                'form_type' => sanitize_text_field($form_type),
                'form_data' => maybe_serialize($form_data),
                'submission_date' => current_time('mysql'),
                'ip_address' => $this->get_client_ip(),
                'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field($_SERVER['HTTP_USER_AGENT']) : '',
                'status' => 'new',
            ),
            array('%s', '%s', '%s', '%s', '%s', '%s')
        );

        if ($result) {
            return $wpdb->insert_id;
        }

        return false;
    }

    public function get_submissions($args = array()) {
        global $wpdb;

        $defaults = array(
            'form_type' => '',
            'status' => '',
            'per_page' => 20,
            'page' => 1,
            'orderby' => 'submission_date',
            'order' => 'DESC',
        );

        $args = wp_parse_args($args, $defaults);

        $where = array('1=1');

        if (!empty($args['form_type'])) {
            $where[] = $wpdb->prepare('form_type = %s', $args['form_type']);
        }

        if (!empty($args['status'])) {
            $where[] = $wpdb->prepare('status = %s', $args['status']);
        }

        $where_clause = implode(' AND ', $where);

        $offset = ($args['page'] - 1) * $args['per_page'];
        $order = sanitize_sql_orderby($args['orderby'] . ' ' . $args['order']);

        $sql = "SELECT * FROM {$this->table_name} WHERE {$where_clause} ORDER BY {$order} LIMIT %d OFFSET %d";
        
        $submissions = $wpdb->get_results($wpdb->prepare($sql, $args['per_page'], $offset));

        return $submissions;
    }

    public function get_submission($id) {
        global $wpdb;

        $submission = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$this->table_name} WHERE id = %d", $id));

        if ($submission) {
            $submission->form_data = maybe_unserialize($submission->form_data);
        }

        return $submission;
    }

    public function update_submission_status($id, $status) {
        global $wpdb;

        return $wpdb->update(
            $this->table_name,
            array('status' => sanitize_text_field($status)),
            array('id' => $id),
            array('%s'),
            array('%d')
        );
    }

    public function delete_submission($id) {
        global $wpdb;

        return $wpdb->delete(
            $this->table_name,
            array('id' => $id),
            array('%d')
        );
    }

    public function get_submissions_count($args = array()) {
        global $wpdb;

        $defaults = array(
            'form_type' => '',
            'status' => '',
        );

        $args = wp_parse_args($args, $defaults);

        $where = array('1=1');

        if (!empty($args['form_type'])) {
            $where[] = $wpdb->prepare('form_type = %s', $args['form_type']);
        }

        if (!empty($args['status'])) {
            $where[] = $wpdb->prepare('status = %s', $args['status']);
        }

        $where_clause = implode(' AND ', $where);

        return (int) $wpdb->get_var("SELECT COUNT(*) FROM {$this->table_name} WHERE {$where_clause}");
    }

    public function export_to_csv($args = array()) {
        $submissions = $this->get_submissions(array_merge($args, array('per_page' => -1)));

        if (empty($submissions)) {
            return false;
        }

        $csv_data = array();

        $csv_data[] = array('ID', 'Form Type', 'Submission Date', 'Status', 'First Name', 'Last Name', 'Email', 'Phone', 'Message');

        foreach ($submissions as $submission) {
            $data = maybe_unserialize($submission->form_data);
            
            $csv_data[] = array(
                $submission->id,
                $submission->form_type,
                $submission->submission_date,
                $submission->status,
                isset($data['first_name']) ? $data['first_name'] : '',
                isset($data['last_name']) ? $data['last_name'] : '',
                isset($data['email']) ? $data['email'] : '',
                isset($data['phone']) ? $data['phone'] : '',
                isset($data['message']) ? $data['message'] : '',
            );
        }

        return $csv_data;
    }

    public function get_form_types() {
        global $wpdb;

        return $wpdb->get_results("SELECT DISTINCT form_type FROM {$this->table_name} ORDER BY form_type");
    }

    public function get_statuses() {
        return array('new', 'read', 'replied', 'archived');
    }

    private function get_client_ip() {
        $ip = '';
        
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return sanitize_text_field($ip);
    }
}