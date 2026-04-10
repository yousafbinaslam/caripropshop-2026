<?php
if (!defined('ABSPATH')) {
    exit;
}

class CPS_Mail_Handler {

    private static $instance = null;

    public static function get_instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('phpmailer_init', array($this, 'configure_smtp'));
    }

    public function configure_smtp($phpmailer) {
        $smtp_enabled = get_option('cps_mail_smtp_enabled', false);
        
        if (!$smtp_enabled) {
            return;
        }
        
        $phpmailer->isSMTP();
        
        $phpmailer->Host = get_option('cps_mail_smtp_host', '');
        $phpmailer->Port = get_option('cps_mail_smtp_port', 587);
        $phpmailer->SMTPSecure = get_option('cps_mail_smtp_secure', 'tls');
        $phpmailer->SMTPAuth = true;
        $phpmailer->Username = get_option('cps_mail_smtp_username', '');
        $phpmailer->Password = get_option('cps_mail_smtp_password', '');
        $phpmailer->From = get_option('cps_mail_smtp_from_email', get_option('admin_email'));
        $phpmailer->FromName = get_option('cps_mail_smtp_from_name', get_bloginfo('name'));
    }

    public function send_email($to, $subject, $message, $headers = array(), $attachments = array()) {
        $from_email = get_option('cps_mail_from_email', get_option('admin_email'));
        $from_name = get_option('cps_mail_from_name', get_bloginfo('name'));
        
        $default_headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . $from_name . ' <' . $from_email . '>',
        );
        
        $headers = array_merge($default_headers, $headers);
        
        $message = $this->wrap_in_template($message, $subject);
        
        return wp_mail($to, $subject, $message, $headers, $attachments);
    }

    public function wrap_in_template($content, $subject = '') {
        $template = get_option('cps_mail_template', 'default');
        
        $template_file = CPS_MAIL_PLUGIN_DIR . 'public/templates/email-' . $template . '.php';
        
        if (!file_exists($template_file)) {
            $template_file = CPS_MAIL_PLUGIN_DIR . 'public/templates/email-default.php';
        }
        
        ob_start();
        include $template_file;
        return ob_get_clean();
    }

    public function send_campaign($campaign_id) {
        $subscriber_manager = CPS_Subscriber_Manager::get_instance();
        
        $campaign = $subscriber_manager->get_campaign($campaign_id);
        
        if (!$campaign) {
            return new WP_Error('no_campaign', __('Campaign not found.', 'cari-prop-shop-mail'));
        }
        
        $subscribers = $subscriber_manager->get_all_subscribers_emails('subscribed');
        
        if (empty($subscribers)) {
            return new WP_Error('no_subscribers', __('No subscribers found.', 'cari-prop-shop-mail'));
        }
        
        $sent_count = 0;
        $failed_count = 0;
        
        foreach ($subscribers as $email) {
            $result = $this->send_email(
                $email,
                $campaign->subject,
                $campaign->content
            );
            
            if ($result) {
                $subscriber = $subscriber_manager->get_subscriber_by_email($email);
                if ($subscriber) {
                    $subscriber_manager->record_sent_email($campaign_id, $subscriber->id);
                }
                $sent_count++;
            } else {
                $failed_count++;
            }
        }
        
        $subscriber_manager->update_campaign($campaign_id, array(
            'status' => 'sent',
            'sent_date' => current_time('mysql'),
            'total_sent' => $sent_count,
        ));
        
        return array(
            'sent' => $sent_count,
            'failed' => $failed_count,
            'total' => count($subscribers),
        );
    }

    public function send_test_email($to, $subject, $message) {
        return $this->send_email($to, $subject, $message);
    }

    public function test_smtp_connection() {
        $smtp_host = get_option('cps_mail_smtp_host', '');
        $smtp_port = get_option('cps_mail_smtp_port', 587);
        $smtp_username = get_option('cps_mail_smtp_username', '');
        $smtp_password = get_option('cps_mail_smtp_password', '');
        
        if (empty($smtp_host) || empty($smtp_username) || empty($smtp_password)) {
            return new WP_Error('missing_settings', __('SMTP settings are incomplete.', 'cari-prop-shop-mail'));
        }
        
        $socket = @fsockopen($smtp_host, $smtp_port, $errno, $errstr, 10);
        
        if (!$socket) {
            return new WP_Error('connection_failed', sprintf(__('Could not connect to SMTP server: %s', 'cari-prop-shop-mail'), $errstr));
        }
        
        fclose($socket);
        
        return true;
    }

    public function get_property_updates_content($limit = 5) {
        $properties = get_posts(array(
            'post_type' => 'property',
            'posts_per_page' => $limit,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
        ));
        
        if (empty($properties)) {
            return '';
        }
        
        $content = '<h2>' . __('Latest Properties', 'cari-prop-shop-mail') . '</h2>';
        $content .= '<table style="width:100%;border-collapse:collapse;">';
        
        foreach ($properties as $property) {
            $price = get_post_meta($property->ID, 'property_price', true);
            $location = get_post_meta($property->ID, 'property_location', true);
            $bedrooms = get_post_meta($property->ID, 'property_bedrooms', true);
            $bathrooms = get_post_meta($property->ID, 'property_bathrooms', true);
            $image = get_the_post_thumbnail_url($property->ID, 'medium');
            
            $content .= '<tr>';
            $content .= '<td style="padding:10px;border-bottom:1px solid #eee;">';
            if ($image) {
                $content .= '<img src="' . esc_attr($image) . '" alt="' . esc_attr($property->post_title) . '" style="width:100px;height:auto;vertical-align:middle;margin-right:10px;">';
            }
            $content .= '<strong>' . esc_html($property->post_title) . '</strong>';
            if ($price) {
                $content .= '<br><span style="color:#2ecc71;font-weight:bold;">' . esc_html($price) . '</span>';
            }
            if ($location) {
                $content .= '<br><small>' . esc_html($location) . '</small>';
            }
            if ($bedrooms || $bathrooms) {
                $content .= '<br><small>' . $bedrooms . __(' beds', 'cari-prop-shop-mail') . ', ' . $bathrooms . __(' baths', 'cari-prop-shop-mail') . '</small>';
            }
            $content .= '<br><a href="' . get_permalink($property->ID) . '">' . __('View Property', 'cari-prop-shop-mail') . '</a>';
            $content .= '</td>';
            $content .= '</tr>';
        }
        
        $content .= '</table>';
        
        return $content;
    }
}