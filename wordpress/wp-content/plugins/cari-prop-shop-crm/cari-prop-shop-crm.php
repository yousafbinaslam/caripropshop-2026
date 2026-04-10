<?php
/**
 * Plugin Name: CariPropShop CRM
 * Plugin URI: https://caripropshop.com
 * Description: Customer Relationship Management for CariPropShop - leads, favorites, inquiries
 * Version: 1.0.0
 * Author: CariPropShop
 * License: GPL v2 or later
 */

if (!defined('ABSPATH')) {
    exit;
}

define('CPS_CRM_VERSION', '1.0.0');
define('CPS_CRM_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CPS_CRM_PLUGIN_URL', plugin_dir_url(__FILE__));

class CariPropShop_CRM {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('init', array($this, 'register_post_types'));
        add_action('wp_ajax_cps_save_lead', array($this, 'save_lead'));
        add_action('wp_ajax_nopriv_cps_save_lead', array($this, 'save_lead'));
    }

    public function register_post_types() {
        register_post_type('cps_lead', array(
            'labels' => array(
                'name' => __('Leads', 'cari-prop-shop-crm'),
                'singular_name' => __('Lead', 'cari-prop-shop-crm'),
            ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => 'cari-prop-shop',
            'capability_type' => 'post',
            'supports' => array('title', 'editor'),
        ));

        register_post_type('cps_favorite', array(
            'labels' => array(
                'name' => __('Favorites', 'cari-prop-shop-crm'),
                'singular_name' => __('Favorite', 'cari-prop-shop-crm'),
            ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => 'cari-prop-shop',
        ));
    }

    public function save_lead() {
        check_ajax_referer('cps_nonce', 'nonce');

        $lead_data = array(
            'post_type' => 'cps_lead',
            'post_title' => sanitize_text_field($_POST['name']),
            'post_content' => '',
            'post_status' => 'publish',
        );

        $lead_id = wp_insert_post($lead_data);

        if ($lead_id) {
            update_post_meta($lead_id, 'email', sanitize_email($_POST['email']));
            update_post_meta($lead_id, 'phone', sanitize_text_field($_POST['phone']));
            update_post_meta($lead_id, 'message', sanitize_textarea_field($_POST['message']));
            update_post_meta($lead_id, 'property_id', intval($_POST['property_id']));
            update_post_meta($lead_id, 'source', 'website');

            wp_send_json_success(array('lead_id' => $lead_id));
        }

        wp_send_json_error(array('message' => 'Failed to save lead'));
    }
}

add_action('plugins_loaded', array('CariPropShop_CRM', 'get_instance'));
