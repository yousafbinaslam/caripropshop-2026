<?php
/**
 * Admin Class
 * 
 * Handles admin functionality
 *
 * @package CariPropShop
 */

if (!defined('ABSPATH')) {
    exit;
}

class CPS_Admin {

    /**
     * Constructor
     */
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_menu_page(
            __('CariPropShop', 'cari-prop-shop'),
            __('CariPropShop', 'cari-prop-shop'),
            'manage_options',
            'cari-prop-shop',
            array($this, 'render_admin_page'),
            'dashicons-building',
            30
        );

        add_submenu_page(
            'cari-prop-shop',
            __('Settings', 'cari-prop-shop'),
            __('Settings', 'cari-prop-shop'),
            'manage_options',
            'cps-settings',
            array($this, 'render_settings_page')
        );

        add_submenu_page(
            'cari-prop-shop',
            __('Import/Export', 'cari-prop-shop'),
            __('Import/Export', 'cari-prop-shop'),
            'manage_options',
            'cps-import-export',
            array($this, 'render_import_export_page')
        );
    }

    /**
     * Register settings
     */
    public function register_settings() {
        register_setting('cps_settings', 'cps_general_settings');
        register_setting('cps_settings', 'cps_api_settings');
        register_setting('cps_settings', 'cps_map_settings');
    }

    /**
     * Render admin page
     */
    public function render_admin_page() {
        ?>
        <div class="wrap cps-admin-wrap">
            <h1><?php esc_html_e('CariPropShop Dashboard', 'cari-prop-shop'); ?></h1>
            
            <div class="cps-admin-dashboard">
                <div class="cps-admin-card">
                    <h2><?php esc_html_e('Quick Stats', 'cari-prop-shop'); ?></h2>
                    <div class="cps-stats-grid">
                        <?php
                        $properties_count = wp_count_posts('property')->publish;
                        $agents_count = wp_count_posts('agent')->publish;
                        $types_count = wp_count_terms('property_type');
                        ?>
                        <div class="cps-stat">
                            <span class="cps-stat-number"><?php echo esc_html($properties_count); ?></span>
                            <span class="cps-stat-label"><?php esc_html_e('Properties', 'cari-prop-shop'); ?></span>
                        </div>
                        <div class="cps-stat">
                            <span class="cps-stat-number"><?php echo esc_html($agents_count); ?></span>
                            <span class="cps-stat-label"><?php esc_html_e('Agents', 'cari-prop-shop'); ?></span>
                        </div>
                        <div class="cps-stat">
                            <span class="cps-stat-number"><?php echo esc_html($types_count); ?></span>
                            <span class="cps-stat-label"><?php esc_html_e('Property Types', 'cari-prop-shop'); ?></span>
                        </div>
                    </div>
                </div>

                <div class="cps-admin-card">
                    <h2><?php esc_html_e('Quick Links', 'cari-prop-shop'); ?></h2>
                    <ul class="cps-quick-links">
                        <li><a href="<?php echo esc_url(admin_url('post-new.php?post_type=property')); ?>" class="button button-primary"><?php esc_html_e('Add New Property', 'cari-prop-shop'); ?></a></li>
                        <li><a href="<?php echo esc_url(admin_url('post-new.php?post_type=agent')); ?>" class="button"><?php esc_html_e('Add New Agent', 'cari-prop-shop'); ?></a></li>
                        <li><a href="<?php echo esc_url(admin_url('edit-tags.php?taxonomy=property_type&post_type=property')); ?>" class="button"><?php esc_html_e('Manage Property Types', 'cari-prop-shop'); ?></a></li>
                        <li><a href="<?php echo esc_url(admin_url('options-general.php?page=cps-settings')); ?>" class="button"><?php esc_html_e('Plugin Settings', 'cari-prop-shop'); ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Render settings page
     */
    public function render_settings_page() {
        $general = get_option('cps_general_settings', array());
        $api = get_option('cps_api_settings', array());
        $map = get_option('cps_map_settings', array());
        ?>
        <div class="wrap cps-admin-wrap">
            <h1><?php esc_html_e('CariPropShop Settings', 'cari-prop-shop'); ?></h1>
            
            <form method="post" action="options.php">
                <?php settings_fields('cps_settings'); ?>
                
                <div class="cps-settings-tabs">
                    <button type="button" class="cps-tab-link active" data-tab="general"><?php esc_html_e('General', 'cari-prop-shop'); ?></button>
                    <button type="button" class="cps-tab-link" data-tab="api"><?php esc_html_e('API', 'cari-prop-shop'); ?></button>
                    <button type="button" class="cps-tab-link" data-tab="map"><?php esc_html_e('Map', 'cari-prop-shop'); ?></button>
                </div>

                <div id="general" class="cps-tab-content active">
                    <table class="form-table">
                        <tr>
                            <th><?php esc_html_e('Currency Symbol', 'cari-prop-shop'); ?></th>
                            <td>
                                <input type="text" name="cps_general_settings[currency_symbol]" value="<?php echo esc_attr($general['currency_symbol'] ?? 'IDR'); ?>" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e('Currency Position', 'cari-prop-shop'); ?></th>
                            <td>
                                <select name="cps_general_settings[currency_position]">
                                    <option value="before" <?php selected($general['currency_position'] ?? 'before', 'before'); ?>><?php esc_html_e('Before amount', 'cari-prop-shop'); ?></option>
                                    <option value="after" <?php selected($general['currency_position'] ?? 'before', 'after'); ?>><?php esc_html_e('After amount', 'cari-prop-shop'); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e('Properties Per Page', 'cari-prop-shop'); ?></th>
                            <td>
                                <input type="number" name="cps_general_settings[properties_per_page]" value="<?php echo esc_attr($general['properties_per_page'] ?? 12); ?>" class="small-text">
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e('Default Property Image', 'cari-prop-shop'); ?></th>
                            <td>
                                <input type="text" name="cps_general_settings[default_image]" value="<?php echo esc_url($general['default_image'] ?? ''); ?>" class="regular-text">
                                <p class="description"><?php esc_html_e('Enter URL to default property image', 'cari-prop-shop'); ?></p>
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="api" class="cps-tab-content">
                    <table class="form-table">
                        <tr>
                            <th><?php esc_html_e('API Key', 'cari-prop-shop'); ?></th>
                            <td>
                                <input type="text" name="cps_api_settings[api_key]" value="<?php echo esc_attr($api['api_key'] ?? ''); ?>" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e('Enable REST API', 'cari-prop-shop'); ?></th>
                            <td>
                                <input type="checkbox" name="cps_api_settings[enable_rest]" value="1" <?php checked($api['enable_rest'] ?? true, true); ?>>
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="map" class="cps-tab-content">
                    <table class="form-table">
                        <tr>
                            <th><?php esc_html_e('Google Maps API Key', 'cari-prop-shop'); ?></th>
                            <td>
                                <input type="text" name="cps_map_settings[google_api_key]" value="<?php echo esc_attr($map['google_api_key'] ?? ''); ?>" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e('Default Map Zoom', 'cari-prop-shop'); ?></th>
                            <td>
                                <input type="number" name="cps_map_settings[default_zoom]" value="<?php echo esc_attr($map['default_zoom'] ?? 12); ?>" class="small-text" min="1" max="20">
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e('Default Map Center', 'cari-prop-shop'); ?></th>
                            <td>
                                <input type="text" name="cps_map_settings[default_lat]" placeholder="Latitude" value="<?php echo esc_attr($map['default_lat'] ?? ''); ?>">
                                <input type="text" name="cps_map_settings[default_lng]" placeholder="Longitude" value="<?php echo esc_attr($map['default_lng'] ?? ''); ?>">
                            </td>
                        </tr>
                    </table>
                </div>

                <?php submit_button(); ?>
            </form>
        </div>

        <style>
            .cps-settings-tabs { margin: 20px 0; }
            .cps-tab-link { 
                padding: 10px 20px; 
                background: #f0f0f1; 
                border: none; 
                cursor: pointer;
                margin-right: 5px;
            }
            .cps-tab-link.active { 
                background: #2271b1; 
                color: white;
            }
            .cps-tab-content { 
                display: none; 
                padding: 20px; 
                background: white; 
                border: 1px solid #ccc;
            }
            .cps-tab-content.active { 
                display: block; 
            }
        </style>

        <script>
            jQuery(document).ready(function($) {
                $('.cps-tab-link').on('click', function() {
                    $('.cps-tab-link').removeClass('active');
                    $('.cps-tab-content').removeClass('active');
                    $(this).addClass('active');
                    $('#' + $(this).data('tab')).addClass('active');
                });
            });
        </script>
        <?php
    }

    /**
     * Render import/export page
     */
    public function render_import_export_page() {
        ?>
        <div class="wrap cps-admin-wrap">
            <h1><?php esc_html_e('Import / Export', 'cari-prop-shop'); ?></h1>
            
            <div class="cps-admin-card">
                <h2><?php esc_html_e('Import Properties', 'cari-prop-shop'); ?></h2>
                <form method="post" enctype="multipart/form-data">
                    <input type="file" name="cps_import_file" accept=".csv,.json">
                    <select name="cps_import_type">
                        <option value="csv">CSV</option>
                        <option value="json">JSON</option>
                    </select>
                    <?php submit_button(__('Import', 'cari-prop-shop')); ?>
                </form>
            </div>

            <div class="cps-admin-card">
                <h2><?php esc_html_e('Export Properties', 'cari-prop-shop'); ?></h2>
                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php?action=cps_export')); ?>">
                    <select name="cps_export_type">
                        <option value="csv">CSV</option>
                        <option value="json">JSON</option>
                    </select>
                    <?php submit_button(__('Export', 'cari-prop-shop')); ?>
                </form>
            </div>
        </div>
        <?php
    }
}

// Initialize admin
new CPS_Admin();
