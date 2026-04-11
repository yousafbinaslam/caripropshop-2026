<?php
/**
 * Plugin Name: CariPropShop Payments
 * Plugin URI: https://caripropshop.com
 * Description: Payment and subscription system for CariPropShop
 * Version: 1.0.0
 * Author: CariPropShop
 */

if (!defined('ABSPATH')) {
    exit;
}

define('CPS_PAYMENTS_VERSION', '1.0.0');
define('CPS_PAYMENTS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CPS_PAYMENTS_PLUGIN_URL', plugin_dir_url(__FILE__));

class CPS_Payments {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->register_post_types();
        $this->init_hooks();
    }

    private function register_post_types() {
        register_post_type('cps_package', array(
            'labels' => array(
                'name' => __('Packages', 'cari-prop-shop-payments'),
                'singular_name' => __('Package', 'cari-prop-shop-payments'),
            ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 25,
            'menu_icon' => 'dashicons-money-alt',
            'supports' => array('title', 'editor', 'thumbnail'),
        ));

        register_post_type('cps_subscription', array(
            'labels' => array(
                'name' => __('Subscriptions', 'cari-prop-shop-payments'),
                'singular_name' => __('Subscription', 'cari-prop-shop-payments'),
            ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 26,
            'menu_icon' => 'dashicons-tickets-alt',
            'supports' => array('title', 'custom-fields'),
        ));

        register_post_type('cps_transaction', array(
            'labels' => array(
                'name' => __('Transactions', 'cari-prop-shop-payments'),
                'singular_name' => __('Transaction', 'cari-prop-shop-payments'),
            ),
            'public' => false,
            'show_ui' => false,
            'capabilities' => array('create_posts' => 'do_not_allow'),
        ));
    }

    private function init_hooks() {
        add_shortcode('cps_pricing_table', array($this, 'render_pricing_table'));
        add_shortcode('cps_featured_pricing', array($this, 'render_featured_pricing'));
        
        add_action('wp_ajax_cps_create_subscription', array($this, 'ajax_create_subscription'));
        add_action('wp_ajax_nopriv_cps_create_subscription', array($this, 'ajax_create_subscription'));
        
        add_action('wp_ajax_cps_process_payment', array($this, 'ajax_process_payment'));
        add_action('wp_ajax_nopriv_cps_process_payment', array($this, 'ajax_process_payment'));

        add_action('admin_menu', array($this, 'add_admin_menu'));
    }

    public function add_admin_menu() {
        add_submenu_page(
            'cari-prop-shop',
            __('Pricing Packages', 'cari-prop-shop-payments'),
            __('Packages', 'cari-prop-shop-payments'),
            'manage_options',
            'edit.php?post_type=cps_package',
            null
        );

        add_submenu_page(
            'cari-prop-shop',
            __('Subscriptions', 'cari-prop-shop-payments'),
            __('Subscriptions', 'cari-prop-shop-payments'),
            'manage_options',
            'edit.php?post_type=cps_subscription',
            null
        );
    }

    public function render_pricing_table($atts) {
        $atts = shortcode_atts(array(
            'title' => __('Pricing Plans', 'cari-prop-shop-payments'),
            'subtitle' => __('Choose the plan that works for you', 'cari-prop-shop-payments'),
            'show_annual' => 'true',
        ), $atts);

        $packages = $this->get_packages();

        ob_start();
        include CPS_PAYMENTS_PLUGIN_DIR . 'templates/pricing-table.php';
        return ob_get_clean();
    }

    public function render_featured_pricing($atts) {
        $atts = shortcode_atts(array(
            'package_id' => '',
            'show_form' => 'true',
        ), $atts);

        if (!$atts['package_id']) {
            return '';
        }

        $package = get_post($atts['package_id']);
        if (!$package) {
            return '';
        }

        $features = get_post_meta($package->ID, 'cps_package_features', true);
        $price = get_post_meta($package->ID, 'cps_package_price', true);
        $billing = get_post_meta($package->ID, 'cps_package_billing', true);
        $listings = get_post_meta($package->ID, 'cps_package_listings', true);
        $duration = get_post_meta($package->ID, 'cps_package_duration', true);

        ob_start();
        include CPS_PAYMENTS_PLUGIN_DIR . 'templates/featured-package.php';
        return ob_get_clean();
    }

    private function get_packages() {
        return get_posts(array(
            'post_type' => 'cps_package',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC',
        ));
    }

    public function ajax_create_subscription() {
        check_ajax_referer('cps_payments_nonce', 'nonce');

        $package_id = isset($_POST['package_id']) ? intval($_POST['package_id']) : 0;
        $user_id = get_current_user_id();

        if (!$package_id || !$user_id) {
            wp_send_json_error(array('message' => __('Invalid request', 'cari-prop-shop-payments')));
        }

        $package = get_post($package_id);
        if (!$package) {
            wp_send_json_error(array('message' => __('Package not found', 'cari-prop-shop-payments')));
        }

        $subscription_id = $this->create_subscription($user_id, $package_id);

        if ($subscription_id) {
            wp_send_json_success(array(
                'subscription_id' => $subscription_id,
                'redirect_url' => $this->get_payment_url($subscription_id),
            ));
        } else {
            wp_send_json_error(array('message' => __('Failed to create subscription', 'cari-prop-shop-payments')));
        }
    }

    public function ajax_process_payment() {
        check_ajax_referer('cps_payments_nonce', 'nonce');

        $subscription_id = isset($_POST['subscription_id']) ? intval($_POST['subscription_id']) : 0;
        $payment_method = isset($_POST['payment_method']) ? sanitize_text_field($_POST['payment_method']) : '';

        if (!$subscription_id) {
            wp_send_json_error(array('message' => __('Invalid subscription', 'cari-prop-shop-payments')));
        }

        $result = $this->process_payment($subscription_id, $payment_method);

        if ($result['success']) {
            wp_send_json_success($result);
        } else {
            wp_send_json_error($result);
        }
    }

    private function create_subscription($user_id, $package_id) {
        $package = get_post($package_id);
        $duration = get_post_meta($package_id, 'cps_package_duration', true) ?: 30;
        $start_date = current_time('mysql');
        $end_date = date('Y-m-d H:i:s', strtotime('+' . $duration . ' days'));

        $subscription_id = wp_insert_post(array(
            'post_type' => 'cps_subscription',
            'post_title' => sprintf(__('Subscription for %s', 'cari-prop-shop-payments'), get_userdata($user_id)->display_name),
            'post_status' => 'pending',
            'post_author' => $user_id,
            'meta_input' => array(
                'cps_subscription_user' => $user_id,
                'cps_subscription_package' => $package_id,
                'cps_subscription_start' => $start_date,
                'cps_subscription_end' => $end_date,
                'cps_subscription_status' => 'pending',
                'cps_subscription_listings_used' => 0,
            ),
        ));

        return $subscription_id;
    }

    private function get_payment_url($subscription_id) {
        return add_query_arg(array(
            'action' => 'cps_payment_form',
            'subscription_id' => $subscription_id,
        ), home_url('/checkout/'));
    }

    private function process_payment($subscription_id, $payment_method) {
        $subscription = get_post($subscription_id);
        $package_id = get_post_meta($subscription_id, 'cps_subscription_package', true);
        $price = get_post_meta($package_id, 'cps_package_price', true);

        $result = array(
            'success' => false,
            'transaction_id' => 0,
            'message' => '',
        );

        switch ($payment_method) {
            case 'bank_transfer':
                $result = $this->process_bank_transfer($subscription_id, $price);
                break;
            case 'credit_card':
                $result = $this->process_credit_card($subscription_id, $price);
                break;
            case 'midtrans':
                $result = $this->process_midtrans($subscription_id, $price);
                break;
            case 'xendit':
                $result = $this->process_xendit($subscription_id, $price);
                break;
            default:
                $result['message'] = __('Invalid payment method', 'cari-prop-shop-payments');
        }

        if ($result['success']) {
            update_post_meta($subscription_id, 'cps_subscription_status', 'active');
            $this->grant_package_features($subscription_id);
        }

        return $result;
    }

    private function process_bank_transfer($subscription_id, $amount) {
        $va_number = $this->generate_va_number();
        $expiry = date('Y-m-d H:i:s', strtotime('+24 hours'));

        $transaction_id = $this->create_transaction($subscription_id, 'bank_transfer', $amount, 'pending', array(
            'va_number' => $va_number,
            'expiry' => $expiry,
        ));

        return array(
            'success' => true,
            'transaction_id' => $transaction_id,
            'message' => sprintf(__('Please transfer %s to Virtual Account: %s', 'cari-prop-shop-payments'), number_format($amount), $va_number),
            'payment_details' => array(
                'va_number' => $va_number,
                'expiry' => $expiry,
            ),
        );
    }

    private function process_credit_card($subscription_id, $amount) {
        return array(
            'success' => true,
            'redirect_url' => add_query_arg(array(
                'subscription_id' => $subscription_id,
                'processor' => 'stripe',
            ), home_url('/payment-process/')),
        );
    }

    private function process_midtrans($subscription_id, $amount) {
        $midtrans_server_key = get_option('cps_midtrans_server_key', '');
        $midtrans_client_key = get_option('cps_midtrans_client_key', '');
        $is_production = get_option('cps_midtrans_production', false);

        $snap_url = $is_production ? 'https://app.midtrans.com/snap/v1/transactions' : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        $user_id = get_post_meta($subscription_id, 'cps_subscription_user', true);
        $user = get_userdata($user_id);

        $body = array(
            'transaction_details' => array(
                'order_id' => 'ORD-' . $subscription_id . '-' . time(),
                'gross_amount' => intval($amount),
            ),
            'customer_details' => array(
                'first_name' => $user->first_name ?: $user->display_name,
                'last_name' => $user->last_name ?: '',
                'email' => $user->user_email,
                'phone' => get_user_meta($user_id, 'billing_phone', true) ?: '',
            ),
        );

        $response = wp_remote_post($snap_url, array(
            'headers' => array(
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($midtrans_server_key . ':'),
            ),
            'body' => json_encode($body),
        ));

        if (is_wp_error($response)) {
            return array('success' => false, 'message' => $response->get_error_message());
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);

        if (!empty($body['token'])) {
            $transaction_id = $this->create_transaction($subscription_id, 'midtrans', $amount, 'pending', array('token' => $body['token']));

            return array(
                'success' => true,
                'transaction_id' => $transaction_id,
                'snap_token' => $body['token'],
                'client_key' => $midtrans_client_key,
            );
        }

        return array('success' => false, 'message' => __('Failed to create Midtrans transaction', 'cari-prop-shop-payments'));
    }

    private function process_xendit($subscription_id, $amount) {
        $xendit_api_key = get_option('cps_xendit_api_key', '');
        $xendit_callback_key = get_option('cps_xendit_callback_key', '');

        $user_id = get_post_meta($subscription_id, 'cps_subscription_user', true);
        $user = get_userdata($user_id);

        $external_id = 'ORD-' . $subscription_id . '-' . time();

        $body = array(
            'external_id' => $external_id,
            'amount' => intval($amount),
            'payer_email' => $user->user_email,
            'description' => sprintf(__('CariPropShop Subscription #%d', 'cari-prop-shop-payments'), $subscription_id),
            'preferred_method' => 'VIRTUAL_ACCOUNT',
        );

        $response = wp_remote_post('https://api.xendit.co/v2/invoices', array(
            'headers' => array(
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($xendit_api_key . ':'),
            ),
            'body' => json_encode($body),
        ));

        if (is_wp_error($response)) {
            return array('success' => false, 'message' => $response->get_error_message());
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);

        if (!empty($body['id'])) {
            $transaction_id = $this->create_transaction($subscription_id, 'xendit', $amount, 'pending', array(
                'invoice_id' => $body['id'],
                'invoice_url' => $body['invoice_url'],
            ));

            return array(
                'success' => true,
                'transaction_id' => $transaction_id,
                'invoice_url' => $body['invoice_url'],
            );
        }

        return array('success' => false, 'message' => __('Failed to create Xendit invoice', 'cari-prop-shop-payments'));
    }

    private function create_transaction($subscription_id, $method, $amount, $status, $details = array()) {
        return wp_insert_post(array(
            'post_type' => 'cps_transaction',
            'post_title' => sprintf(__('Transaction %s', 'cari-prop-shop-payments'), strtoupper(substr($method, 0, 3)) . '-' . time()),
            'post_status' => 'publish',
            'meta_input' => array(
                'cps_transaction_subscription' => $subscription_id,
                'cps_transaction_method' => $method,
                'cps_transaction_amount' => $amount,
                'cps_transaction_status' => $status,
                'cps_transaction_details' => json_encode($details),
                'cps_transaction_date' => current_time('mysql'),
            ),
        ));
    }

    private function generate_va_number() {
        return '88' . str_pad(mt_rand(1000000, 9999999), 10, '0', STR_PAD_LEFT);
    }

    private function grant_package_features($subscription_id) {
        $package_id = get_post_meta($subscription_id, 'cps_subscription_package', true);
        $user_id = get_post_meta($subscription_id, 'cps_subscription_user', true);

        $listings = get_post_meta($package_id, 'cps_package_listings', true);
        $featured = get_post_meta($package_id, 'cps_package_featured', true);
        $featured_duration = get_post_meta($package_id, 'cps_package_featured_duration', true);

        update_user_meta($user_id, 'cps_user_listing_limit', intval($listings));
        update_user_meta($user_id, 'cps_user_featured_limit', intval($featured));

        if ($featured && $featured_duration) {
            update_user_meta($user_id, 'cps_user_featured_until', date('Y-m-d H:i:s', strtotime('+' . $featured_duration . ' days')));
        }

        $role = get_post_meta($package_id, 'cps_package_role', true);
        if ($role) {
            $user = get_user_by('id', $user_id);
            if ($user) {
                $user->set_role($role);
            }
        }
    }

    public static function activate() {
        flush_rewrite_rules();
        
        $default_packages = array(
            array(
                'title' => 'Basic',
                'price' => 299000,
                'billing' => 'monthly',
                'duration' => 30,
                'listings' => 5,
                'featured' => 1,
                'featured_duration' => 7,
            ),
            array(
                'title' => 'Professional',
                'price' => 599000,
                'billing' => 'monthly',
                'duration' => 30,
                'listings' => 25,
                'featured' => 5,
                'featured_duration' => 14,
            ),
            array(
                'title' => 'Enterprise',
                'price' => 1499000,
                'billing' => 'monthly',
                'duration' => 30,
                'listings' => -1,
                'featured' => -1,
                'featured_duration' => 30,
            ),
        );

        $existing = get_posts(array('post_type' => 'cps_package', 'posts_per_page' => 1));
        if (empty($existing)) {
            foreach ($default_packages as $pkg) {
                $post_id = wp_insert_post(array(
                    'post_type' => 'cps_package',
                    'post_title' => $pkg['title'],
                    'post_status' => 'publish',
                    'meta_input' => array(
                        'cps_package_price' => $pkg['price'],
                        'cps_package_billing' => $pkg['billing'],
                        'cps_package_duration' => $pkg['duration'],
                        'cps_package_listings' => $pkg['listings'],
                        'cps_package_featured' => $pkg['featured'],
                        'cps_package_featured_duration' => $pkg['featured_duration'],
                    ),
                ));
            }
        }
    }

    public static function deactivate() {
        flush_rewrite_rules();
    }
}

register_activation_hook(__FILE__, array('CPS_Payments', 'activate'));
register_deactivation_hook(__FILE__, array('CPS_Payments', 'deactivate'));

add_action('plugins_loaded', array('CPS_Payments', 'get_instance'));
