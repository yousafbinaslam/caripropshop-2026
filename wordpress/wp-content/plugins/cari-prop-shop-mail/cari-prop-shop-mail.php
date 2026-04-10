<?php
/**
 * Plugin Name: CariPropShop Mail
 * Plugin URI: https://caripropshop.com
 * Description: Email marketing and newsletter system for CariPropShop. Manage subscribers, send campaigns, and customize email templates.
 * Version: 1.0.0
 * Author: CariPropShop
 * Author URI: https://caripropshop.com
 * Text Domain: cari-prop-shop-mail
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP: 8.0
 */

if (!defined('ABSPATH')) {
    exit;
}

define('CPS_MAIL_VERSION', '1.0.0');
define('CPS_MAIL_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CPS_MAIL_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CPS_MAIL_PLUGIN_BASENAME', plugin_basename(__FILE__));

require_once CPS_MAIL_PLUGIN_DIR . 'includes/class-cps-subscriber-manager.php';
require_once CPS_MAIL_PLUGIN_DIR . 'includes/class-cps-mail-handler.php';

if (is_admin()) {
    require_once CPS_MAIL_PLUGIN_DIR . 'admin/class-cps-admin-mail.php';
}

require_once CPS_MAIL_PLUGIN_DIR . 'public/class-cps-public-mail.php';

final class CariPropShop_Mail {

    private static $instance = null;

    public static function get_instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->init_hooks();
        $this->init_database();
    }

    private function init_hooks() {
        add_action('init', array($this, 'load_textdomain'));
        add_action('init', array($this, 'register_shortcodes'));
        
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        
        add_action('wp_ajax_cps_subscribe', array($this, 'handle_subscribe'));
        add_action('wp_ajax_nopriv_cps_subscribe', array($this, 'handle_subscribe'));
        
        add_action('init', array($this, 'handle_confirm_subscription'));
        add_action('init', array($this, 'handle_unsubscribe'));
        
        add_filter('plugin_action_links_' . CPS_MAIL_PLUGIN_BASENAME, array($this, 'plugin_action_links'));
    }

    public function load_textdomain() {
        load_plugin_textdomain(
            'cari-prop-shop-mail',
            false,
            dirname(CPS_MAIL_PLUGIN_BASENAME) . '/languages/'
        );
    }

    public function register_shortcodes() {
        add_shortcode('cps_newsletter', array($this, 'newsletter_shortcode'));
    }

    public function newsletter_shortcode($atts) {
        $atts = shortcode_atts(array(
            'title' => __('Subscribe to our Newsletter', 'cari-prop-shop-mail'),
            'subtitle' => __('Get the latest property updates delivered to your inbox.', 'cari-prop-shop-mail'),
            'placeholder' => __('Enter your email address', 'cari-prop-shop-mail'),
            'button_text' => __('Subscribe', 'cari-prop-shop-mail'),
            'show_name' => 'false',
        ), $atts);

        ob_start();
        cps_mail()->public()->render_newsletter_form($atts);
        return ob_get_clean();
    }

    public function handle_subscribe() {
        check_ajax_referer('cps_mail_nonce', 'nonce');
        
        $email = sanitize_email($_POST['email']);
        $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $double_optin = get_option('cps_mail_double_optin', true);
        
        if (!is_email($email)) {
            wp_send_json_error(array('message' => __('Invalid email address.', 'cari-prop-shop-mail')));
        }
        
        $subscriber_manager = cps_mail()->subscriber_manager();
        
        $exists = $subscriber_manager->get_subscriber_by_email($email);
        
        if ($exists) {
            if ($exists->status === 'unsubscribed') {
                $subscriber_manager->update_subscriber($exists->id, array('status' => 'pending'));
                if (!$double_optin) {
                    $subscriber_manager->update_subscriber($exists->id, array('status' => 'subscribed'));
                }
                wp_send_json_success(array('message' => __('You have been re-subscribed.', 'cari-prop-shop-mail')));
            } else {
                wp_send_json_error(array('message' => __('This email is already subscribed.', 'cari-prop-shop-mail')));
            }
        }
        
        $subscriber_id = $subscriber_manager->add_subscriber(array(
            'email' => $email,
            'name' => $name,
            'status' => $double_optin ? 'pending' : 'subscribed',
            'subscribe_date' => current_time('mysql'),
        ));
        
        if ($double_optin) {
            $subscriber_manager->send_confirmation_email($subscriber_id);
            wp_send_json_success(array('message' => __('Please check your email to confirm your subscription.', 'cari-prop-shop-mail')));
        } else {
            wp_send_json_success(array('message' => __('Thank you for subscribing!', 'cari-prop-shop-mail')));
        }
    }

    public function handle_confirm_subscription() {
        if (!isset($_GET['cps_confirm']) || !isset($_GET['token'])) {
            return;
        }
        
        $subscriber_id = absint($_GET['cps_confirm']);
        $token = sanitize_text_field($_GET['token']);
        
        $subscriber_manager = cps_mail()->subscriber_manager();
        $subscriber = $subscriber_manager->get_subscriber($subscriber_id);
        
        if (!$subscriber) {
            wp_die(__('Invalid confirmation link.', 'cari-prop-shop-mail'));
        }
        
        $expected_token = wp_hash($subscriber->email . $subscriber->subscribe_date);
        
        if (!wp_verify_nonce($token, 'confirm_' . $subscriber_id)) {
            wp_die(__('Invalid confirmation token.', 'cari-prop-shop-mail'));
        }
        
        $subscriber_manager->update_subscriber($subscriber_id, array('status' => 'subscribed'));
        
        $redirect_url = add_query_arg('subscribed', 'true', remove_query_arg(array('cps_confirm', 'token')));
        wp_redirect($redirect_url);
        exit;
    }

    public function handle_unsubscribe() {
        if (!isset($_GET['cps_unsubscribe']) || !isset($_GET['token'])) {
            return;
        }
        
        $subscriber_id = absint($_GET['cps_unsubscribe']);
        $token = sanitize_text_field($_GET['token']);
        
        $subscriber_manager = cps_mail()->subscriber_manager();
        $subscriber = $subscriber_manager->get_subscriber($subscriber_id);
        
        if (!$subscriber) {
            wp_die(__('Invalid unsubscribe link.', 'cari-prop-shop-mail'));
        }
        
        if (!wp_verify_nonce($token, 'unsubscribe_' . $subscriber_id)) {
            wp_die(__('Invalid unsubscribe token.', 'cari-prop-shop-mail'));
        }
        
        $subscriber_manager->update_subscriber($subscriber_id, array('status' => 'unsubscribed'));
        
        $redirect_url = add_query_arg('unsubscribed', 'true', remove_query_arg(array('cps_unsubscribe', 'token')));
        wp_redirect($redirect_url);
        exit;
    }

    public function enqueue_frontend_assets() {
        wp_enqueue_style(
            'cps-mail-frontend',
            CPS_MAIL_PLUGIN_URL . 'assets/css/frontend.css',
            array(),
            CPS_MAIL_VERSION
        );

        wp_enqueue_script(
            'cps-mail-frontend',
            CPS_MAIL_PLUGIN_URL . 'assets/js/frontend.js',
            array('jquery'),
            CPS_MAIL_VERSION,
            true
        );

        wp_localize_script('cps-mail-frontend', 'cpsMailData', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('cps_mail_nonce'),
            'strings' => array(
                'subscribe' => __('Subscribe', 'cari-prop-shop-mail'),
                'subscribing' => __('Subscribing...', 'cari-prop-shop-mail'),
                'success' => __('Thank you for subscribing!', 'cari-prop-shop-mail'),
                'error' => __('Something went wrong. Please try again.', 'cari-prop-shop-mail'),
                'invalid_email' => __('Please enter a valid email address.', 'cari-prop-shop-mail'),
            ),
        ));
    }

    public function enqueue_admin_assets($hook) {
        wp_enqueue_style(
            'cps-mail-admin',
            CPS_MAIL_PLUGIN_URL . 'assets/css/admin.css',
            array(),
            CPS_MAIL_VERSION
        );

        wp_enqueue_script(
            'cps-mail-admin',
            CPS_MAIL_PLUGIN_URL . 'assets/js/admin.js',
            array('jquery', 'wp-util'),
            CPS_MAIL_VERSION,
            true
        );

        wp_localize_script('cps-mail-admin', 'cpsMailAdminData', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('cps_mail_admin_nonce'),
            'strings' => array(
                'confirm_delete' => __('Are you sure you want to delete this?', 'cari-prop-shop-mail'),
                'confirm_send' => __('Are you sure you want to send this campaign?', 'cari-prop-shop-mail'),
                'sending' => __('Sending...', 'cari-prop-shop-mail'),
                'send' => __('Send', 'cari-prop-shop-mail'),
                'error' => __('An error occurred.', 'cari-prop-shop-mail'),
            ),
        ));
    }

    public function plugin_action_links($links) {
        $settings_link = '<a href="' . admin_url('admin.php?page=cps-mail-settings') . '">' . __('Settings', 'cari-prop-shop-mail') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    private function init_database() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        
        $table_subscribers = $wpdb->prefix . 'cps_mail_subscribers';
        $table_campaigns = $wpdb->prefix . 'cps_mail_campaigns';
        $table_sent = $wpdb->prefix . 'cps_mail_sent';
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        
        $sql_subscribers = "CREATE TABLE IF NOT EXISTS $table_subscribers (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            email varchar(255) NOT NULL,
            name varchar(255) DEFAULT '',
            status varchar(20) DEFAULT 'subscribed',
            subscribe_date datetime NOT NULL,
            confirm_date datetime DEFAULT NULL,
            unsubscribe_date datetime DEFAULT NULL,
            PRIMARY KEY  (id),
            KEY email (email(191)),
            KEY status (status)
        ) $charset_collate;";
        
        $sql_campaigns = "CREATE TABLE IF NOT EXISTS $table_campaigns (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            title varchar(255) NOT NULL,
            subject varchar(255) NOT NULL,
            content longtext NOT NULL,
            template varchar(50) DEFAULT 'default',
            status varchar(20) DEFAULT 'draft',
            scheduled_date datetime DEFAULT NULL,
            sent_date datetime DEFAULT NULL,
            total_sent int(11) DEFAULT 0,
            opens int(11) DEFAULT 0,
            clicks int(11) DEFAULT 0,
            created_at datetime NOT NULL,
            updated_at datetime NOT NULL,
            PRIMARY KEY  (id),
            KEY status (status)
        ) $charset_collate;";
        
        $sql_sent = "CREATE TABLE IF NOT EXISTS $table_sent (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            campaign_id bigint(20) NOT NULL,
            subscriber_id bigint(20) NOT NULL,
            sent_date datetime NOT NULL,
            open_date datetime DEFAULT NULL,
            click_date datetime DEFAULT NULL,
            PRIMARY KEY  (id),
            KEY campaign_id (campaign_id),
            KEY subscriber_id (subscriber_id)
        ) $charset_collate;";
        
        dbDelta($sql_subscribers);
        dbDelta($sql_campaigns);
        dbDelta($sql_sent);
    }

    public function subscriber_manager() {
        return CPS_Subscriber_Manager::get_instance();
    }

    public function mail_handler() {
        return CPS_Mail_Handler::get_instance();
    }

    public function public() {
        return CPS_Public_Mail::get_instance();
    }
}

function cps_mail() {
    return CariPropShop_Mail::get_instance();
}

cps_mail();