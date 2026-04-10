<?php
/**
 * Plugin Name: CariPropShop Builder
 * Plugin URI: https://caripropshop.com
 * Description: Custom Elementor widgets for real estate websites. Create stunning property listings, agent profiles, and search functionality.
 * Version: 1.0.0
 * Author: CariPropShop
 * Author URI: https://caripropshop.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: cari-prop-shop-builder
 * Domain Path: /languages
 * Elementor requires at least: 3.0.0
 * Elementor tested up to: 3.22.0
 */

if (!defined('ABSPATH')) {
    exit;
}

define('CPS_BUILDER_VERSION', '1.0.0');
define('CPS_BUILDER_PATH', plugin_dir_path(__FILE__));
define('CPS_BUILDER_ASSETS', plugin_dir_url(__FILE__) . 'assets/');
define('CPS_BUILDER_BASE_FILE', __FILE__);

class CariPropShop_Builder_Plugin {

    private static $instance = null;
    private $components = [];

    public static function instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->init_hooks();
    }

    private function init_hooks() {
        add_action('plugins_loaded', [$this, 'init_plugin'], 100);
        add_action('elementor/init', [$this, 'register_widgets']);
        add_action('elementor/frontend/before_register_scripts', [$this, 'register_scripts']);
        add_action('elementor/frontend/before_register_styles', [$this, 'register_styles']);
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('wp_ajax_cps_property_inquiry', [$this, 'handle_property_inquiry']);
        add_action('wp_ajax_nopriv_cps_property_inquiry', [$this, 'handle_property_inquiry']);
    }

    public function init_plugin() {
        load_plugin_textdomain(
            'cari-prop-shop-builder',
            false,
            dirname(plugin_basename(__FILE__)) . '/languages'
        );
    }

    public function register_widgets() {
        $this->components['widgets_manager'] = \Elementor\Plugin::instance()->widgets_manager;

        require_once CPS_BUILDER_PATH . 'includes/class-cps-base-widget.php';
        require_once CPS_BUILDER_PATH . 'includes/widgets/class-cps-property-card-widget.php';
        require_once CPS_BUILDER_PATH . 'includes/widgets/class-cps-property-search-widget.php';
        require_once CPS_BUILDER_PATH . 'includes/widgets/class-cps-agent-card-widget.php';
        require_once CPS_BUILDER_PATH . 'includes/widgets/class-cps-property-slider-widget.php';
        require_once CPS_BUILDER_PATH . 'includes/widgets/class-cps-stats-widget.php';
        require_once CPS_BUILDER_PATH . 'includes/widgets/class-cps-cta-widget.php';
        require_once CPS_BUILDER_PATH . 'includes/widgets/class-cps-testimonial-widget.php';
        require_once CPS_BUILDER_PATH . 'includes/widgets/class-cps-contact-form-widget.php';
        require_once CPS_BUILDER_PATH . 'includes/widgets/class-cps-property-map-widget.php';
        require_once CPS_BUILDER_PATH . 'includes/widgets/class-cps-property-grid-widget.php';
        require_once CPS_BUILDER_PATH . 'includes/widgets/class-cps-property-types-widget.php';

        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CPS_Property_Card_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CPS_Property_Search_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CPS_Agent_Card_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CPS_Property_Slider_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CPS_Stats_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CPS_CTA_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CPS_Testimonial_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CPS_Contact_Form_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CPS_Property_Map_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CPS_Property_Grid_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CPS_Property_Types_Widget());
    }

    public function register_scripts() {
        wp_register_script(
            'cps-builder-slick',
            CPS_BUILDER_ASSETS . 'js/slick.min.js',
            ['jquery'],
            CPS_BUILDER_VERSION,
            true
        );

        wp_register_script(
            'cps-builder-main',
            CPS_BUILDER_ASSETS . 'js/main.js',
            ['jquery', 'cps-builder-slick'],
            CPS_BUILDER_VERSION,
            true
        );

        wp_localize_script('cps-builder-main', 'cpsBuilderAjax', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('cps_builder_nonce'),
        ]);
    }

    public function register_styles() {
        wp_register_style(
            'cps-builder-frontend',
            CPS_BUILDER_ASSETS . 'css/frontend.css',
            [],
            CPS_BUILDER_VERSION
        );

        wp_register_style(
            'cps-builder-slick',
            CPS_BUILDER_ASSETS . 'css/slick.css',
            [],
            CPS_BUILDER_VERSION
        );
    }

    public function add_admin_menu() {
        add_menu_page(
            __('CariPropShop Builder', 'cari-prop-shop-builder'),
            __('CariPropShop Builder', 'cari-prop-shop-builder'),
            'manage_options',
            'cari-prop-shop-builder',
            [$this, 'admin_settings_page'],
            'dashicons-building',
            6
        );
    }

    public function register_settings() {
        register_setting(
            'cps_builder_settings',
            'cps_builder_google_maps_api_key',
            ['sanitize_callback' => 'sanitize_text_field']
        );

        register_setting(
            'cps_builder_settings',
            'cps_builder_mapbox_token',
            ['sanitize_callback' => 'sanitize_text_field']
        );

        register_setting(
            'cps_builder_settings',
            'cps_builder_google_places_api',
            ['sanitize_callback' => 'sanitize_text_field']
        );

        register_setting(
            'cps_builder_settings',
            'cps_builder_email_notifications',
            ['sanitize_callback' => 'sanitize_email']
        );

        register_setting(
            'cps_builder_settings',
            'cps_builder_currency_symbol',
            ['sanitize_callback' => 'sanitize_text_field']
        );
    }

    public function admin_settings_page() {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('cps_builder_settings');
                do_settings_sections('cps_builder_settings');
                ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">
                            <label for="cps_builder_google_maps_api_key"><?php _e('Google Maps API Key', 'cari-prop-shop-builder'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="cps_builder_google_maps_api_key" name="cps_builder_google_maps_api_key" value="<?php echo esc_attr(get_option('cps_builder_google_maps_api_key')); ?>" class="regular-text" />
                            <p class="description"><?php _e('Enter your Google Maps API key for map functionality.', 'cari-prop-shop-builder'); ?></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="cps_builder_mapbox_token"><?php _e('Mapbox Access Token', 'cari-prop-shop-builder'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="cps_builder_mapbox_token" name="cps_builder_mapbox_token" value="<?php echo esc_attr(get_option('cps_builder_mapbox_token')); ?>" class="regular-text" />
                            <p class="description"><?php _e('Enter your Mapbox access token as an alternative to Google Maps.', 'cari-prop-shop-builder'); ?></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="cps_builder_google_places_api"><?php _e('Google Places API Key', 'cari-prop-shop-builder'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="cps_builder_google_places_api" name="cps_builder_google_places_api" value="<?php echo esc_attr(get_option('cps_builder_google_places_api')); ?>" class="regular-text" />
                            <p class="description"><?php _e('Enter your Google Places API key for address autocomplete.', 'cari-prop-shop-builder'); ?></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="cps_builder_email_notifications"><?php _e('Notification Email', 'cari-prop-shop-builder'); ?></label>
                        </th>
                        <td>
                            <input type="email" id="cps_builder_email_notifications" name="cps_builder_email_notifications" value="<?php echo esc_attr(get_option('cps_builder_email_notifications')); ?>" class="regular-text" />
                            <p class="description"><?php _e('Email address to receive property inquiry notifications.', 'cari-prop-shop-builder'); ?></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="cps_builder_currency_symbol"><?php _e('Currency Symbol', 'cari-prop-shop-builder'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="cps_builder_currency_symbol" name="cps_builder_currency_symbol" value="<?php echo esc_attr(get_option('cps_builder_currency_symbol', '$')); ?>" class="regular-text" />
                            <p class="description"><?php _e('Default currency symbol for property prices.', 'cari-prop-shop-builder'); ?></p>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    public function handle_property_inquiry() {
        check_ajax_referer('cps_builder_nonce', 'nonce');

        $property_id = isset($_POST['property_id']) ? absint($_POST['property_id']) : 0;
        $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
        $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';

        if (empty($name) || empty($email) || empty($message)) {
            wp_send_json_error(['message' => __('Please fill in all required fields.', 'cari-prop-shop-builder')]);
        }

        $to = get_option('cps_builder_email_notifications', get_option('admin_email'));
        $subject = sprintf(__('Property Inquiry - Property #%d', 'cari-prop-shop-builder'), $property_id);
        $body = sprintf(
            "New property inquiry received:\n\nName: %s\nEmail: %s\nPhone: %s\nMessage: %s\nProperty ID: %d",
            $name,
            $email,
            $phone,
            $message,
            $property_id
        );

        $headers = ['Content-Type: text/plain; charset=UTF-8', 'From: ' . $email];

        $sent = wp_mail($to, $subject, $body, $headers);

        if ($sent) {
            wp_send_json_success(['message' => __('Thank you for your inquiry! We will contact you shortly.', 'cari-prop-shop-builder')]);
        } else {
            wp_send_json_error(['message' => __('Failed to send inquiry. Please try again.', 'cari-prop-shop-builder')]);
        }
    }

    public static function activate() {
        if (!did_action('elementor/init')) {
            deactivate_plugins(plugin_basename(__FILE__));
            wp_die(
                sprintf(
                    __('<strong>%s</strong> requires Elementor to be installed and activated.', 'cari-prop-shop-builder'),
                    __('CariPropShop Builder', 'cari-prop-shop-builder')
                ),
                'Plugin activation error',
                ['back_link' => true]
            );
        }

        flush_rewrite_rules();
    }

    public static function deactivate() {
        flush_rewrite_rules();
    }
}

function cari_prop_shop_builder() {
    return CariPropShop_Builder_Plugin::instance();
}

register_activation_hook(__FILE__, ['CariPropShop_Builder_Plugin', 'activate']);
register_deactivation_hook(__FILE__, ['CariPropShop_Builder_Plugin', 'deactivate']);

cari_prop_shop_builder();