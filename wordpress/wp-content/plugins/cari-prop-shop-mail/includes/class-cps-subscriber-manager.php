<?php
if (!defined('ABSPATH')) {
    exit;
}

class CPS_Subscriber_Manager {

    private static $instance = null;
    protected $table_subscribers;
    protected $table_campaigns;
    protected $table_sent;

    public static function get_instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        global $wpdb;
        $this->table_subscribers = $wpdb->prefix . 'cps_mail_subscribers';
        $this->table_campaigns = $wpdb->prefix . 'cps_mail_campaigns';
        $this->table_sent = $wpdb->prefix . 'cps_mail_sent';
    }

    public function add_subscriber($data) {
        global $wpdb;
        
        $result = $wpdb->insert(
            $this->table_subscribers,
            array(
                'email' => $data['email'],
                'name' => isset($data['name']) ? $data['name'] : '',
                'status' => isset($data['status']) ? $data['status'] : 'subscribed',
                'subscribe_date' => isset($data['subscribe_date']) ? $data['subscribe_date'] : current_time('mysql'),
            ),
            array('%s', '%s', '%s', '%s')
        );
        
        if ($result) {
            return $wpdb->insert_id;
        }
        return false;
    }

    public function get_subscriber($id) {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM {$this->table_subscribers} WHERE id = %d", $id));
    }

    public function get_subscriber_by_email($email) {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM {$this->table_subscribers} WHERE email = %s", $email));
    }

    public function update_subscriber($id, $data) {
        global $wpdb;
        
        $update_data = array();
        $format = array();
        
        foreach ($data as $key => $value) {
            $update_data[$key] = $value;
            $format[] = '%s';
        }
        
        return $wpdb->update(
            $this->table_subscribers,
            $update_data,
            array('id' => $id),
            $format,
            array('%d')
        );
    }

    public function delete_subscriber($id) {
        global $wpdb;
        return $wpdb->delete($this->table_subscribers, array('id' => $id), array('%d'));
    }

    public function get_subscribers($args = array()) {
        global $wpdb;
        
        $defaults = array(
            'status' => '',
            'search' => '',
            'per_page' => 20,
            'page' => 1,
            'orderby' => 'subscribe_date',
            'order' => 'DESC',
        );
        
        $args = wp_parse_args($args, $defaults);
        
        $where = '1=1';
        $params = array();
        
        if (!empty($args['status'])) {
            $where .= ' AND status = %s';
            $params[] = $args['status'];
        }
        
        if (!empty($args['search'])) {
            $where .= ' AND (email LIKE %s OR name LIKE %s)';
            $search_term = '%' . $wpdb->esc_like($args['search']) . '%';
            $params[] = $search_term;
            $params[] = $search_term;
        }
        
        $offset = ($args['page'] - 1) * $args['per_page'];
        
        $orderby = sanitize_sql_orderby($args['orderby'] . ' ' . $args['order']);
        
        $query = "SELECT * FROM {$this->table_subscribers} WHERE {$where} ORDER BY {$orderby} LIMIT %d OFFSET %d";
        $params[] = $args['per_page'];
        $params[] = $offset;
        
        if (!empty($params)) {
            $subscribers = $wpdb->get_results($wpdb->prepare($query, $params));
        } else {
            $subscribers = $wpdb->get_results($query);
        }
        
        return $subscribers;
    }

    public function get_subscribers_count($status = '') {
        global $wpdb;
        
        if (empty($status)) {
            return $wpdb->get_var("SELECT COUNT(*) FROM {$this->table_subscribers}");
        }
        
        return $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$this->table_subscribers} WHERE status = %s", $status));
    }

    public function get_all_subscribers_emails($status = 'subscribed') {
        global $wpdb;
        
        return $wpdb->get_col($wpdb->prepare(
            "SELECT email FROM {$this->table_subscribers} WHERE status = %s",
            $status
        ));
    }

    public function export_subscribers($status = '') {
        global $wpdb;
        
        $where = '1=1';
        $params = array();
        
        if (!empty($status)) {
            $where .= ' AND status = %s';
            $params[] = $status;
        }
        
        if (!empty($params)) {
            return $wpdb->get_results($wpdb->prepare(
                "SELECT email, name, status, subscribe_date FROM {$this->table_subscribers} WHERE {$where}",
                $params
            ));
        }
        
        return $wpdb->get_results("SELECT email, name, status, subscribe_date FROM {$this->table_subscribers}");
    }

    public function send_confirmation_email($subscriber_id) {
        $subscriber = $this->get_subscriber($subscriber_id);
        
        if (!$subscriber) {
            return false;
        }
        
        $confirm_url = add_query_arg(array(
            'cps_confirm' => $subscriber_id,
            'token' => wp_create_nonce('confirm_' . $subscriber_id),
        ), home_url());
        
        $subject = get_option('cps_mail_confirm_subject', __('Confirm your subscription', 'cari-prop-shop-mail'));
        $message = get_option('cps_mail_confirm_message', '');
        
        if (empty($message)) {
            $message = __('Hi there,<br><br>Thank you for subscribing! Please confirm your email by clicking the link below:<br><br><a href="{confirm_url}">Confirm Subscription</a><br><br>If you didn\'t sign up for this, please ignore this email.', 'cari-prop-shop-mail');
        }
        
        $message = str_replace('{confirm_url}', $confirm_url, $message);
        $message = str_replace('{name}', $subscriber->name, $message);
        
        $mail_handler = CPS_Mail_Handler::get_instance();
        return $mail_handler->send_email($subscriber->email, $subject, $message);
    }

    public function add_campaign($data) {
        global $wpdb;
        
        return $wpdb->insert(
            $this->table_campaigns,
            array(
                'title' => $data['title'],
                'subject' => $data['subject'],
                'content' => $data['content'],
                'template' => isset($data['template']) ? $data['template'] : 'default',
                'status' => isset($data['status']) ? $data['status'] : 'draft',
                'created_at' => current_time('mysql'),
                'updated_at' => current_time('mysql'),
            ),
            array('%s', '%s', '%s', '%s', '%s', '%s', '%s')
        );
    }

    public function get_campaign($id) {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM {$this->table_campaigns} WHERE id = %d", $id));
    }

    public function update_campaign($id, $data) {
        global $wpdb;
        
        $data['updated_at'] = current_time('mysql');
        
        $update_data = array();
        $format = array();
        
        foreach ($data as $key => $value) {
            $update_data[$key] = $value;
            $format[] = '%s';
        }
        
        return $wpdb->update(
            $this->table_campaigns,
            $update_data,
            array('id' => $id),
            $format,
            array('%d')
        );
    }

    public function delete_campaign($id) {
        global $wpdb;
        
        $wpdb->delete($this->table_sent, array('campaign_id' => $id), array('%d'));
        
        return $wpdb->delete($this->table_campaigns, array('id' => $id), array('%d'));
    }

    public function get_campaigns($args = array()) {
        global $wpdb;
        
        $defaults = array(
            'status' => '',
            'per_page' => 20,
            'page' => 1,
            'orderby' => 'created_at',
            'order' => 'DESC',
        );
        
        $args = wp_parse_args($args, $defaults);
        
        $where = '1=1';
        
        if (!empty($args['status'])) {
            $where .= $wpdb->prepare(' AND status = %s', $args['status']);
        }
        
        $offset = ($args['page'] - 1) * $args['per_page'];
        
        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$this->table_campaigns} WHERE {$where} ORDER BY {$args['orderby']} {$args['order']} LIMIT %d OFFSET %d",
            $args['per_page'],
            $offset
        ));
    }

    public function get_campaigns_count($status = '') {
        global $wpdb;
        
        if (empty($status)) {
            return $wpdb->get_var("SELECT COUNT(*) FROM {$this->table_campaigns}");
        }
        
        return $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$this->table_campaigns} WHERE status = %s", $status));
    }

    public function record_sent_email($campaign_id, $subscriber_id) {
        global $wpdb;
        
        return $wpdb->insert(
            $this->table_sent,
            array(
                'campaign_id' => $campaign_id,
                'subscriber_id' => $subscriber_id,
                'sent_date' => current_time('mysql'),
            ),
            array('%d', '%d', '%s')
        );
    }

    public function record_open($campaign_id, $subscriber_id) {
        global $wpdb;
        
        $record = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$this->table_sent} WHERE campaign_id = %d AND subscriber_id = %d",
            $campaign_id,
            $subscriber_id
        ));
        
        if ($record && is_null($record->open_date)) {
            $wpdb->update(
                $this->table_sent,
                array('open_date' => current_time('mysql')),
                array('id' => $record->id),
                array('%s'),
                array('%d')
            );
            
            $wpdb->query($wpdb->prepare(
                "UPDATE {$this->table_campaigns} SET opens = opens + 1 WHERE id = %d",
                $campaign_id
            ));
        }
    }

    public function record_click($campaign_id, $subscriber_id) {
        global $wpdb;
        
        $record = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$this->table_sent} WHERE campaign_id = %d AND subscriber_id = %d",
            $campaign_id,
            $subscriber_id
        ));
        
        if ($record) {
            $update_data = array('click_date' => current_time('mysql'));
            $format = array('%s');
            
            if (is_null($record->open_date)) {
                $update_data['open_date'] = current_time('mysql');
                $format[] = '%s';
            }
            
            $wpdb->update(
                $this->table_sent,
                $update_data,
                array('id' => $record->id),
                $format,
                array('%d')
            );
            
            $wpdb->query($wpdb->prepare(
                "UPDATE {$this->table_campaigns} SET clicks = clicks + 1 WHERE id = %d",
                $campaign_id
            ));
        }
    }
}