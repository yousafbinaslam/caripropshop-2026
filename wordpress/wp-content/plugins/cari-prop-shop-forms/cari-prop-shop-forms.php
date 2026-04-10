<?php
/**
 * Plugin Name: CariPropShop Forms
 * Plugin URI: https://caripropshop.com
 * Description: Contact and inquiry forms system for CariPropShop
 * Version: 1.0.0
 * Author: CariPropShop
 * Author URI: https://caripropshop.com
 * Text Domain: cari-prop-shop-forms
 * Domain Path: /languages
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('ABSPATH')) {
    exit;
}

define('CPS_FORMS_VERSION', '1.0.0');
define('CPS_FORMS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CPS_FORMS_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CPS_FORMS_DB_VERSION', '1.0.0');

class CariPropShop_Forms {

    private static $instance = null;
    private $form_handler;
    private $form_storage;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->init_hooks();
        $this->load_dependencies();
    }

    private function load_dependencies() {
        require_once CPS_FORMS_PLUGIN_DIR . 'includes/class-cps-form-handler.php';
        require_once CPS_FORMS_PLUGIN_DIR . 'includes/class-cps-form-storage.php';

        $this->form_storage = CPS_Form_Storage::get_instance();
        $this->form_handler = CPS_Forms_Handler::get_instance();
    }

    private function init_hooks() {
        add_action('init', array($this, 'register_post_type'));
        add_action('init', array($this, 'register_shortcodes'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_public_assets'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        add_action('wp_ajax_cps_form_submission', array($this, 'handle_ajax_submission'));
        add_action('wp_ajax_nopriv_cps_form_submission', array($this, 'handle_ajax_submission'));
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'plugin_action_links'));
    }

    public function register_post_type() {
        register_post_type('cps_submission', array(
            'labels' => array(
                'name' => __('Form Submissions', 'cari-prop-shop-forms'),
                'singular_name' => __('Submission', 'cari-prop-shop-forms'),
            ),
            'public' => false,
            'show_ui' => false,
            'capabilities' => array('create_posts' => 'do_not_allow'),
            'map_meta_cap' => true,
            'show_in_menu' => false,
        ));
    }

    public function register_shortcodes() {
        add_shortcode('cps_contact_form', array($this, 'render_contact_form'));
        add_shortcode('cps_property_inquiry', array($this, 'render_property_inquiry_form'));
        add_shortcode('cps_inquiry_form', array($this, 'render_general_inquiry_form'));
        add_shortcode('cps_schedule_viewing', array($this, 'render_schedule_viewing_form'));
        add_shortcode('cps_mortgage_calculator', array($this, 'render_mortgage_calculator_form'));
    }

    public function enqueue_public_assets() {
        $settings = get_option('cps_forms_settings', array());
        
        wp_enqueue_style('cps-forms-public', CPS_FORMS_PLUGIN_URL . 'assets/css/public.css', array(), CPS_FORMS_VERSION);
        wp_enqueue_script('cps-forms-public', CPS_FORMS_PLUGIN_URL . 'assets/js/public.js', array('jquery'), CPS_FORMS_VERSION, true);
        
        wp_localize_script('cps-forms-public', 'cpsForms', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('cps_form_nonce'),
            'strings' => array(
                'submitting' => __('Submitting...', 'cari-prop-shop-forms'),
                'success' => __('Thank you! Your message has been sent successfully.', 'cari-prop-shop-forms'),
                'error' => __('Something went wrong. Please try again.', 'cari-prop-shop-forms'),
                'required' => __('This field is required.', 'cari-prop-shop-forms'),
                'invalid_email' => __('Please enter a valid email address.', 'cari-prop-shop-forms'),
                'invalid_phone' => __('Please enter a valid phone number.', 'cari-prop-shop-forms'),
            ),
            'settings' => array(
                'recaptcha' => array(
                    'enable' => !empty($settings['recaptcha']['enable']),
                    'site_key' => !empty($settings['recaptcha']['site_key']) ? $settings['recaptcha']['site_key'] : '',
                ),
                'styling' => !empty($settings['form_styling']) ? $settings['form_styling'] : array(),
            )
        ));
    }

    public function enqueue_admin_assets($hook) {
        if (strpos($hook, 'cari-prop-shop-forms') === false) {
            return;
        }

        wp_enqueue_style('cps-forms-admin', CPS_FORMS_PLUGIN_URL . 'assets/css/admin.css', array(), CPS_FORMS_VERSION);
        wp_enqueue_script('cps-forms-admin', CPS_FORMS_PLUGIN_URL . 'assets/js/admin.js', array('jquery'), CPS_FORMS_VERSION, true);
    }

    public function add_admin_menu() {
        add_menu_page(
            __('CariPropShop Forms', 'cari-prop-shop-forms'),
            __('Forms', 'cari-prop-shop-forms'),
            'manage_options',
            'cari-prop-shop-forms',
            array($this, 'render_admin_dashboard'),
            'dashicons-email-alt',
            30
        );

        add_submenu_page(
            'cari-prop-shop-forms',
            __('Submissions', 'cari-prop-shop-forms'),
            __('Submissions', 'cari-prop-shop-forms'),
            'manage_options',
            'cps-form-submissions',
            array($this, 'render_submissions_page')
        );

        add_submenu_page(
            'cari-prop-shop-forms',
            __('Settings', 'cari-prop-shop-forms'),
            __('Settings', 'cari-prop-shop-forms'),
            'manage_options',
            'cps-form-settings',
            array($this, 'render_settings_page')
        );
    }

    public function render_admin_dashboard() {
        include CPS_FORMS_PLUGIN_DIR . 'admin/dashboard.php';
    }

    public function render_submissions_page() {
        $action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : 'list';
        
        if ($action === 'view' && isset($_GET['submission_id'])) {
            include CPS_FORMS_PLUGIN_DIR . 'admin/view-submission.php';
        } else {
            include CPS_FORMS_PLUGIN_DIR . 'admin/submissions-list.php';
        }
    }

    public function render_settings_page() {
        include CPS_FORMS_PLUGIN_DIR . 'admin/settings.php';
    }

    public function handle_ajax_submission() {
        check_ajax_referer('cps_form_nonce', 'nonce');

        $form_type = isset($_POST['form_type']) ? sanitize_text_field($_POST['form_type']) : '';
        $form_data = isset($_POST['form_data']) ? $_POST['form_data'] : array();

        $result = $this->form_handler->handle_submission($form_type, $form_data);

        if (is_wp_error($result)) {
            wp_send_json_error(array(
                'message' => $result->get_error_message(),
                'errors' => $result->get_error_data()
            ));
        }

        wp_send_json_success($result);
    }

    public function render_contact_form($atts) {
        $atts = shortcode_atts(array(
            'title' => __('Contact Us', 'cari-prop-shop-forms'),
            'show_name' => true,
            'show_phone' => true,
            'show_subject' => true,
            'show_message' => true,
            'submit_text' => __('Send Message', 'cari-prop-shop-forms'),
        ), $atts, 'cps_contact_form');

        ob_start();
        include CPS_FORMS_PLUGIN_DIR . 'public/templates/contact-form.php';
        return ob_get_clean();
    }

    public function render_property_inquiry_form($atts) {
        $atts = shortcode_atts(array(
            'title' => __('Property Inquiry', 'cari-prop-shop-forms'),
            'property_id' => '',
            'submit_text' => __('Send Inquiry', 'cari-prop-shop-forms'),
        ), $atts, 'cps_property_inquiry');

        ob_start();
        include CPS_FORMS_PLUGIN_DIR . 'public/templates/property-inquiry-form.php';
        return ob_get_clean();
    }

    public function render_general_inquiry_form($atts) {
        $atts = shortcode_atts(array(
            'title' => __('General Inquiry', 'cari-prop-shop-forms'),
            'inquiry_type' => '',
            'submit_text' => __('Submit Inquiry', 'cari-prop-shop-forms'),
        ), $atts, 'cps_inquiry_form');

        ob_start();
        include CPS_FORMS_PLUGIN_DIR . 'public/templates/general-inquiry-form.php';
        return ob_get_clean();
    }

    public function render_schedule_viewing_form($atts) {
        $atts = shortcode_atts(array(
            'title' => __('Schedule a Viewing', 'cari-prop-shop-forms'),
            'property_id' => '',
            'submit_text' => __('Request Viewing', 'cari-prop-shop-forms'),
        ), $atts, 'cps_schedule_viewing');

        ob_start();
        include CPS_FORMS_PLUGIN_DIR . 'public/templates/schedule-viewing-form.php';
        return ob_get_clean();
    }

    public function render_mortgage_calculator_form($atts) {
        $atts = shortcode_atts(array(
            'title' => __('Mortgage Calculator', 'cari-prop-shop-forms'),
            'submit_text' => __('Calculate', 'cari-prop-shop-forms'),
        ), $atts, 'cps_mortgage_calculator');

        ob_start();
        include CPS_FORMS_PLUGIN_DIR . 'public/templates/mortgage-calculator-form.php';
        return ob_get_clean();
    }

    public function plugin_action_links($links) {
        $settings_link = '<a href="' . admin_url('admin.php?page=cps-form-settings') . '">' . __('Settings', 'cari-prop-shop-forms') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    public static function activate() {
        require_once CPS_FORMS_PLUGIN_DIR . 'includes/class-cps-form-storage.php';
        require_once CPS_FORMS_PLUGIN_DIR . 'includes/class-cps-form-handler.php';
        CPS_Form_Storage::get_instance()->create_tables();
        update_option('cps_forms_db_version', CPS_FORMS_DB_VERSION);
        
        $default_settings = array(
            'email_notifications' => array(
                'enable' => true,
                'email_to' => get_option('admin_email'),
                'email_from' => get_option('admin_email'),
                'email_from_name' => get_bloginfo('name'),
            ),
            'auto_responder' => array(
                'enable' => true,
                'subject' => __('Thank you for your inquiry', 'cari-prop-shop-forms'),
                'message' => __('Thank you for contacting us. We will get back to you shortly.', 'cari-prop-shop-forms'),
            ),
            'recaptcha' => array(
                'enable' => false,
                'site_key' => '',
                'secret_key' => '',
            ),
            'form_styling' => array(
                'primary_color' => '#007bff',
                'button_color' => '#007bff',
                'button_text_color' => '#ffffff',
                'border_radius' => '4',
            ),
        );
        
        if (!get_option('cps_forms_settings')) {
            update_option('cps_forms_settings', $default_settings);
        }
    }

    public static function deactivate() {
        flush_rewrite_rules();
    }
}

register_activation_hook(__FILE__, array('CariPropShop_Forms', 'activate'));
register_deactivation_hook(__FILE__, array('CariPropShop_Forms', 'deactivate'));

add_action('plugins_loaded', array('CariPropShop_Forms', 'get_instance'));