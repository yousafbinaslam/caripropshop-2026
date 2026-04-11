<?php
/**
 * Plugin Name: CariPropShop Core
 * Plugin URI: https://caripropshop.com
 * Description: Core functionality plugin for CariPropShop real estate website. Handles property post types, taxonomies, and core features.
 * Version: 1.0.0
 * Author: CariPropShop
 * Author URI: https://caripropshop.com
 * Text Domain: cari-prop-shop
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP: 8.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// Plugin constants
define('CPS_CORE_VERSION', '1.0.0');
define('CPS_CORE_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CPS_CORE_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CPS_CORE_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Main plugin class
 */
final class CariPropShop_Core {

    /**
     * Single instance
     */
    private static $instance = null;

    /**
     * Get instance
     */
    public static function get_instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        $this->load_dependencies();
        $this->init_hooks();
    }

    /**
     * Load dependencies
     */
    private function load_dependencies() {
        require_once CPS_CORE_PLUGIN_DIR . 'includes/class-cps-post-types.php';
        require_once CPS_CORE_PLUGIN_DIR . 'includes/class-cps-taxonomies.php';
        require_once CPS_CORE_PLUGIN_DIR . 'includes/class-cps-meta-boxes.php';
        require_once CPS_CORE_PLUGIN_DIR . 'includes/class-cps-shortcodes.php';
        require_once CPS_CORE_PLUGIN_DIR . 'includes/class-cps-api.php';
        
        if (is_admin()) {
            require_once CPS_CORE_PLUGIN_DIR . 'admin/class-cps-admin.php';
        }
        
        require_once CPS_CORE_PLUGIN_DIR . 'public/class-cps-public.php';
    }

    /**
     * Initialize hooks
     */
    private function init_hooks() {
        add_action('init', array($this, 'load_textdomain'));
        add_action('init', array($this, 'init_post_types'));
        add_action('init', array($this, 'init_taxonomies'));
        
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        
        add_filter('template_include', array($this, 'template_include'));
    }

    /**
     * Load plugin textdomain
     */
    public function load_textdomain() {
        load_plugin_textdomain(
            'cari-prop-shop',
            false,
            dirname(CPS_CORE_PLUGIN_BASENAME) . '/languages/'
        );
    }

    /**
     * Initialize post types
     */
    public function init_post_types() {
        $post_types = new CPS_Post_Types();
        $post_types->register_post_types();
    }

    /**
     * Initialize taxonomies
     */
    public function init_taxonomies() {
        $taxonomies = new CPS_Taxonomies();
        $taxonomies->register_taxonomies();
    }

    /**
     * Enqueue frontend assets
     */
    public function enqueue_frontend_assets() {
        wp_enqueue_style(
            'cps-frontend',
            CPS_CORE_PLUGIN_URL . 'assets/css/frontend.css',
            array(),
            CPS_CORE_VERSION
        );

        wp_enqueue_script(
            'cps-frontend',
            CPS_CORE_PLUGIN_URL . 'assets/js/frontend.js',
            array('jquery'),
            CPS_CORE_VERSION,
            true
        );

        wp_localize_script('cps-frontend', 'cpsData', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('cps_nonce'),
            'homeUrl' => home_url('/'),
        ));
    }

    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets($hook) {
        wp_enqueue_style(
            'cps-admin',
            CPS_CORE_PLUGIN_URL . 'assets/css/admin.css',
            array(),
            CPS_CORE_VERSION
        );

        wp_enqueue_script(
            'cps-admin',
            CPS_CORE_PLUGIN_URL . 'assets/js/admin.js',
            array('jquery'),
            CPS_CORE_VERSION,
            true
        );
    }

    /**
     * Template include filter
     */
    public function template_include($template) {
        if (is_singular('property')) {
            $custom_template = locate_template('single-property.php');
            if ($custom_template) {
                return $custom_template;
            }
        }
        
        if (is_post_type_archive('property')) {
            $custom_template = locate_template('archive-property.php');
            if ($custom_template) {
                return $custom_template;
            }
        }
        
        if (is_singular('agent')) {
            $custom_template = locate_template('single-agent.php');
            if ($custom_template) {
                return $custom_template;
            }
        }
        
        if (is_post_type_archive('agent')) {
            $custom_template = locate_template('archive-agent.php');
            if ($custom_template) {
                return $custom_template;
            }
        }
        
        return $template;
    }
}

// Initialize plugin
CariPropShop_Core::get_instance();

/**
 * Helper function to get plugin instance
 */
function cps_core() {
    return CariPropShop_Core::get_instance();
}
