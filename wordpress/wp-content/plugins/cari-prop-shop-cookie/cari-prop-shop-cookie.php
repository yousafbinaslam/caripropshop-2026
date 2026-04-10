<?php
/**
 * Plugin Name: CariPropShop Cookie
 * Plugin URI: https://caripropshop.com
 * Description: GDPR compliant cookie consent banner with preference center
 * Version: 1.0.0
 * Author: CariPropShop
 * Author URI: https://caripropshop.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: cari-prop-shop-cookie
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
    exit;
}

define('CPS_COOKIE_VERSION', '1.0.0');
define('CPS_COOKIE_PATH', plugin_dir_path(__FILE__));
define('CPS_COOKIE_URL', plugin_dir_url(__FILE__));

require_once CPS_COOKIE_PATH . 'includes/class-cps-cookie-consent.php';

class CariPropShopCookie {
    private static $instance = null;
    private $consent;

    private function __construct() {
        $this->consent = CPS_Cookie_Consent::get_instance();
        $this->init_hooks();
    }

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function init_hooks() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_public_assets'));
        add_action('wp_footer', array($this, 'render_cookie_banner'));
        add_action('wp_ajax_cps_cookie_consent', array($this, 'handle_ajax_consent'));
        add_action('wp_ajax_nopriv_cps_cookie_consent', array($this, 'handle_ajax_consent'));
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'plugin_settings_link'));
    }

    public function enqueue_public_assets() {
        wp_enqueue_style(
            'cps-cookie-banner',
            CPS_COOKIE_URL . 'assets/css/cookie-banner.css',
            array(),
            CPS_COOKIE_VERSION
        );

        wp_enqueue_script(
            'cps-cookie-banner',
            CPS_COOKIE_URL . 'assets/js/cookie-banner.js',
            array('jquery'),
            CPS_COOKIE_VERSION,
            true
        );

        wp_localize_script('cps-cookie-banner', 'cpsCookieData', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('cps_cookie_nonce'),
            'consent' => $this->consent->get_consent(),
            'settings' => $this->get_banner_settings()
        ));
    }

    private function get_banner_settings() {
        return array(
            'position' => get_option('cps_cookie_position', 'bottom'),
            'theme' => get_option('cps_cookie_theme', 'light'),
            'primaryColor' => get_option('cps_cookie_primary_color', '#2563eb'),
            'backgroundColor' => get_option('cps_cookie_bg_color', '#ffffff'),
            'textColor' => get_option('cps_cookie_text_color', '#1f2937'),
            'borderRadius' => get_option('cps_cookie_border_radius', '8'),
            'privacyLink' => get_option('cps_cookie_privacy_link', ''),
            'companyName' => get_option('cps_cookie_company_name', get_bloginfo('name'))
        );
    }

    public function render_cookie_banner() {
        $consent = $this->consent->get_consent();
        
        if ($consent && isset($consent['consent_given']) && $consent['consent_given']) {
            return;
        }

        $settings = $this->get_banner_settings();
        $categories = $this->get_cookie_categories();
        
        include CPS_COOKIE_PATH . 'public/cookie-banner.php';
    }

    private function get_cookie_categories() {
        return array(
            'necessary' => array(
                'name' => __('Necessary', 'cari-prop-shop-cookie'),
                'description' => __('Essential for the website to function properly. Cannot be disabled.', 'cari-prop-shop-cookie'),
                'required' => true,
                'enabled' => true
            ),
            'analytics' => array(
                'name' => __('Analytics', 'cari-prop-shop-cookie'),
                'description' => __('Help us understand how visitors interact with our website.', 'cari-prop-shop-cookie'),
                'required' => false,
                'enabled' => isset($consent['categories']['analytics']) ? $consent['categories']['analytics'] : false
            ),
            'marketing' => array(
                'name' => __('Marketing', 'cari-prop-shop-cookie'),
                'description' => __('Used to deliver personalized advertisements.', 'cari-prop-shop-cookie'),
                'required' => false,
                'enabled' => isset($consent['categories']['marketing']) ? $consent['categories']['marketing'] : false
            ),
            'functional' => array(
                'name' => __('Functional', 'cari-prop-shop-cookie'),
                'description' => __('Enable enhanced functionality and personalization.', 'cari-prop-shop-cookie'),
                'required' => false,
                'enabled' => isset($consent['categories']['functional']) ? $consent['categories']['functional'] : false
            )
        );
    }

    public function handle_ajax_consent() {
        check_ajax_referer('cps_cookie_nonce', 'nonce');

        $action = isset($_POST['action_type']) ? sanitize_text_field($_POST['action_type']) : '';
        
        switch ($action) {
            case 'accept_all':
                $this->consent->save_consent(array(
                    'consent_given' => true,
                    'categories' => array(
                        'necessary' => true,
                        'analytics' => true,
                        'marketing' => true,
                        'functional' => true
                    ),
                    'timestamp' => current_time('mysql'),
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                    'user_agent' => $_SERVER['HTTP_USER_AGENT']
                ));
                wp_send_json_success(array('message' => 'All cookies accepted'));
                break;

            case 'reject_all':
                $this->consent->save_consent(array(
                    'consent_given' => true,
                    'categories' => array(
                        'necessary' => true,
                        'analytics' => false,
                        'marketing' => false,
                        'functional' => false
                    ),
                    'timestamp' => current_time('mysql'),
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                    'user_agent' => $_SERVER['HTTP_USER_AGENT']
                ));
                wp_send_json_success(array('message' => 'All optional cookies rejected'));
                break;

            case 'save_preferences':
                $categories = isset($_POST['categories']) ? json_decode(stripslashes($_POST['categories']), true) : array();
                
                $consent_data = array(
                    'consent_given' => true,
                    'categories' => array(
                        'necessary' => true,
                        'analytics' => isset($categories['analytics']) ? (bool) $categories['analytics'] : false,
                        'marketing' => isset($categories['marketing']) ? (bool) $categories['marketing'] : false,
                        'functional' => isset($categories['functional']) ? (bool) $categories['functional'] : false
                    ),
                    'timestamp' => current_time('mysql'),
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                    'user_agent' => $_SERVER['HTTP_USER_AGENT']
                );
                
                $this->consent->save_consent($consent_data);
                wp_send_json_success(array('message' => 'Preferences saved'));
                break;

            default:
                wp_send_json_error(array('message' => 'Invalid action'));
                break;
        }
    }

    public function plugin_settings_link($links) {
        $settings_link = '<a href="' . admin_url('admin.php?page=cps-cookie-settings') . '">' . __('Settings', 'cari-prop-shop-cookie') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }
}

function cps_cookie_init() {
    return CariPropShopCookie::get_instance();
}

add_action('plugins_loaded', 'cps_cookie_init');

require_once CPS_COOKIE_PATH . 'admin/class-cps-cookie-admin.php';