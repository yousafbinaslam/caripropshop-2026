<?php
if (!defined('ABSPATH')) {
    exit;
}

class CPS_Cookie_Admin {
    private static $instance = null;

    private function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
    }

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function add_admin_menu() {
        add_menu_page(
            __('Cookie Settings', 'cari-prop-shop-cookie'),
            __('Cookie Settings', 'cari-prop-shop-cookie'),
            'manage_options',
            'cps-cookie-settings',
            array($this, 'render_settings_page'),
            'dashicons-admin-generic',
            100
        );
    }

    public function register_settings() {
        register_setting('cps_cookie_settings', 'cps_cookie_position');
        register_setting('cps_cookie_settings', 'cps_cookie_theme');
        register_setting('cps_cookie_settings', 'cps_cookie_primary_color');
        register_setting('cps_cookie_settings', 'cps_cookie_bg_color');
        register_setting('cps_cookie_settings', 'cps_cookie_text_color');
        register_setting('cps_cookie_settings', 'cps_cookie_border_radius');
        register_setting('cps_cookie_settings', 'cps_cookie_privacy_link');
        register_setting('cps_cookie_settings', 'cps_cookie_company_name');
        register_setting('cps_cookie_settings', 'cps_cookie_banner_text');
        register_setting('cps_cookie_settings', 'cps_cookie_show_reject_all');
        register_setting('cps_cookie_settings', 'cps_cookie_show_category_toggles');

        add_settings_section(
            'cps_cookie_general',
            __('General Settings', 'cari-prop-shop-cookie'),
            array($this, 'render_general_section'),
            'cps-cookie-settings'
        );

        add_settings_field(
            'cps_cookie_position',
            __('Banner Position', 'cari-prop-shop-cookie'),
            array($this, 'render_position_field'),
            'cps-cookie-settings',
            'cps_cookie_general'
        );

        add_settings_field(
            'cps_cookie_theme',
            __('Theme', 'cari-prop-shop-cookie'),
            array($this, 'render_theme_field'),
            'cps-cookie-settings',
            'cps_cookie_general'
        );

        add_settings_section(
            'cps_cookie_appearance',
            __('Appearance', 'cari-prop-shop-cookie'),
            array($this, 'render_appearance_section'),
            'cps-cookie-settings'
        );

        add_settings_field(
            'cps_cookie_primary_color',
            __('Primary Color', 'cari-prop-shop-cookie'),
            array($this, 'render_color_field'),
            'cps-cookie-settings',
            'cps_cookie_appearance',
            array('field' => 'cps_cookie_primary_color')
        );

        add_settings_field(
            'cps_cookie_bg_color',
            __('Background Color', 'cari-prop-shop-cookie'),
            array($this, 'render_color_field'),
            'cps-cookie-settings',
            'cps_cookie_appearance',
            array('field' => 'cps_cookie_bg_color')
        );

        add_settings_field(
            'cps_cookie_text_color',
            __('Text Color', 'cari-prop-shop-cookie'),
            array($this, 'render_color_field'),
            'cps-cookie-settings',
            'cps_cookie_appearance',
            array('field' => 'cps_cookie_text_color')
        );

        add_settings_field(
            'cps_cookie_border_radius',
            __('Border Radius', 'cari-prop-shop-cookie'),
            array($this, 'render_border_radius_field'),
            'cps-cookie-settings',
            'cps_cookie_appearance'
        );

        add_settings_section(
            'cps_cookie_content',
            __('Content', 'cari-prop-shop-cookie'),
            array($this, 'render_content_section'),
            'cps-cookie-settings'
        );

        add_settings_field(
            'cps_cookie_company_name',
            __('Company Name', 'cari-prop-shop-cookie'),
            array($this, 'render_text_field'),
            'cps-cookie-settings',
            'cps_cookie_content',
            array('field' => 'cps_cookie_company_name', 'placeholder' => get_bloginfo('name'))
        );

        add_settings_field(
            'cps_cookie_banner_text',
            __('Banner Message', 'cari-prop-shop-cookie'),
            array($this, 'render_textarea_field'),
            'cps-cookie-settings',
            'cps_cookie_content',
            array('field' => 'cps_cookie_banner_text', 'default' => __('We use cookies to enhance your browsing experience, serve personalized content, and analyze our traffic. By clicking "Accept All", you consent to our use of cookies.', 'cari-prop-shop-cookie'))
        );

        add_settings_field(
            'cps_cookie_privacy_link',
            __('Privacy Policy URL', 'cari-prop-shop-cookie'),
            array($this, 'render_privacy_link_field'),
            'cps-cookie-settings',
            'cps_cookie_content'
        );

        add_settings_section(
            'cps_cookie_options',
            __('Options', 'cari-prop-shop-cookie'),
            array($this, 'render_options_section'),
            'cps-cookie-settings'
        );

        add_settings_field(
            'cps_cookie_show_reject_all',
            __('Show "Reject All" Button', 'cari-prop-shop-cookie'),
            array($this, 'render_checkbox_field'),
            'cps-cookie-settings',
            'cps_cookie_options',
            array('field' => 'cps_cookie_show_reject_all')
        );

        add_settings_field(
            'cps_cookie_show_category_toggles',
            __('Show Category Toggles', 'cari-prop-shop-cookie'),
            array($this, 'render_checkbox_field'),
            'cps-cookie-settings',
            'cps_cookie_options',
            array('field' => 'cps_cookie_show_category_toggles', 'default' => '1')
        );
    }

    public function render_settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
        ?>
        <div class="wrap cps-cookie-admin">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('cps_cookie_settings');
                do_settings_sections('cps-cookie-settings');
                submit_button(__('Save Settings', 'cari-prop-shop-cookie'));
                ?>
            </form>

            <hr>

            <h2><?php _e('Consent Log', 'cari-prop-shop-cookie'); ?></h2>
            <?php $this->render_consent_log(); ?>
        </div>
        <?php
    }

    private function render_consent_log() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'cps_cookie_consent_log';

        $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'");
        
        if (!$table_exists) {
            echo '<p>' . __('No consent logs yet.', 'cari-prop-shop-cookie') . '</p>';
            return;
        }

        $per_page = 20;
        $current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
        $offset = ($current_page - 1) * $per_page;

        $total = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name ORDER BY timestamp DESC LIMIT %d OFFSET %d", $per_page, $offset));

        ?>
        <table class="widefat fixed striped">
            <thead>
                <tr>
                    <th><?php _e('Date', 'cari-prop-shop-cookie'); ?></th>
                    <th><?php _e('User', 'cari-prop-shop-cookie'); ?></th>
                    <th><?php _e('Consent Given', 'cari-prop-shop-cookie'); ?></th>
                    <th><?php _e('Categories', 'cari-prop-shop-cookie'); ?></th>
                    <th><?php _e('IP Address', 'cari-prop-shop-cookie'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($results)): ?>
                    <tr><td colspan="5"><?php _e('No logs found.', 'cari-prop-shop-cookie'); ?></td></tr>
                <?php else: ?>
                    <?php foreach ($results as $row): ?>
                        <tr>
                            <td><?php echo esc_html($row->timestamp); ?></td>
                            <td><?php echo $row->user_id ? esc_html($row->user_id) : __('Guest', 'cari-prop-shop-cookie'); ?></td>
                            <td><?php echo $row->consent_given ? __('Yes', 'cari-prop-shop-cookie') : __('No', 'cari-prop-shop-cookie'); ?></td>
                            <td>
                                <?php
                                $categories = json_decode($row->categories, true);
                                if ($categories) {
                                    $cats = array();
                                    foreach ($categories as $cat => $enabled) {
                                        if ($enabled) {
                                            $cats[] = ucfirst($cat);
                                        }
                                    }
                                    echo esc_html(implode(', ', $cats));
                                }
                                ?>
                            </td>
                            <td><?php echo esc_html($row->ip_address); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <?php
        $total_pages = ceil($total / $per_page);
        if ($total_pages > 1) {
            echo '<div class="tablenav">';
            echo '<span class="displaying-num">' . sprintf(__('%d items', 'cari-prop-shop-cookie'), $total) . '</span>';
            
            $base = admin_url('admin.php?page=cps-cookie-settings');
            $page_links = paginate_links(array(
                'base' => add_query_arg('paged', '%#%', $base),
                'format' => '',
                'prev_text' => __('&laquo;'),
                'next_text' => __('&raquo;'),
                'total' => $total_pages,
                'current' => $current_page,
                'type' => 'plain'
            ));
            
            if ($page_links) {
                echo '<div class="tablenav-pages">' . $page_links . '</div>';
            }
            echo '</div>';
        }
    }

    public function render_general_section() {
        echo '<p>' . __('Configure the general behavior of the cookie banner.', 'cari-prop-shop-cookie') . '</p>';
    }

    public function render_appearance_section() {
        echo '<p>' . __('Customize the visual appearance of the cookie banner.', 'cari-prop-shop-cookie') . '</p>';
    }

    public function render_content_section() {
        echo '<p>' . __('Configure the content displayed in the cookie banner.', 'cari-prop-shop-cookie') . '</p>';
    }

    public function render_options_section() {
        echo '<p>' . __('Enable or disable additional options.', 'cari-prop-shop-cookie') . '</p>';
    }

    public function render_position_field() {
        $value = get_option('cps_cookie_position', 'bottom');
        ?>
        <select name="cps_cookie_position" id="cps_cookie_position">
            <option value="bottom" <?php selected($value, 'bottom'); ?>><?php _e('Bottom', 'cari-prop-shop-cookie'); ?></option>
            <option value="top" <?php selected($value, 'top'); ?>><?php _e('Top', 'cari-prop-shop-cookie'); ?></option>
            <option value="bottom-left" <?php selected($value, 'bottom-left'); ?>><?php _e('Bottom Left', 'cari-prop-shop-cookie'); ?></option>
            <option value="bottom-right" <?php selected($value, 'bottom-right'); ?>><?php _e('Bottom Right', 'cari-prop-shop-cookie'); ?></option>
        </select>
        <?php
    }

    public function render_theme_field() {
        $value = get_option('cps_cookie_theme', 'light');
        ?>
        <select name="cps_cookie_theme" id="cps_cookie_theme">
            <option value="light" <?php selected($value, 'light'); ?>><?php _e('Light', 'cari-prop-shop-cookie'); ?></option>
            <option value="dark" <?php selected($value, 'dark'); ?>><?php _e('Dark', 'cari-prop-shop-cookie'); ?></option>
            <option value="custom" <?php selected($value, 'custom'); ?>><?php _e('Custom', 'cari-prop-shop-cookie'); ?></option>
        </select>
        <p class="description"><?php _e('Select "Custom" to enable color customization below.', 'cari-prop-shop-cookie'); ?></p>
        <?php
    }

    public function render_color_field($args) {
        $field = $args['field'];
        $value = get_option($field, '');
        ?>
        <input type="color" name="<?php echo esc_attr($field); ?>" id="<?php echo esc_attr($field); ?>" value="<?php echo esc_attr($value); ?>" class="color-picker">
        <?php
    }

    public function render_border_radius_field() {
        $value = get_option('cps_cookie_border_radius', '8');
        ?>
        <input type="number" name="cps_cookie_border_radius" id="cps_cookie_border_radius" value="<?php echo esc_attr($value); ?>" min="0" max="50">
        <span class="description"><?php _e('px', 'cari-prop-shop-cookie'); ?></span>
        <?php
    }

    public function render_text_field($args) {
        $field = $args['field'];
        $placeholder = isset($args['placeholder']) ? $args['placeholder'] : '';
        $value = get_option($field, '');
        ?>
        <input type="text" name="<?php echo esc_attr($field); ?>" id="<?php echo esc_attr($field); ?>" value="<?php echo esc_attr($value); ?>" class="regular-text" placeholder="<?php echo esc_attr($placeholder); ?>">
        <?php
    }

    public function render_textarea_field($args) {
        $field = $args['field'];
        $default = isset($args['default']) ? $args['default'] : '';
        $value = get_option($field, $default);
        ?>
        <textarea name="<?php echo esc_attr($field); ?>" id="<?php echo esc_attr($field); ?>" rows="3" class="large-text"><?php echo esc_textarea($value); ?></textarea>
        <?php
    }

    public function render_privacy_link_field() {
        $value = get_option('cps_cookie_privacy_link', '');
        $pages = get_pages(array('number' => 0));
        ?>
        <select name="cps_cookie_privacy_link" id="cps_cookie_privacy_link">
            <option value=""><?php _e('-- Select Page --', 'cari-prop-shop-cookie'); ?></option>
            <?php foreach ($pages as $page): ?>
                <option value="<?php echo esc_attr(get_permalink($page->ID)); ?>" <?php selected($value, get_permalink($page->ID)); ?>>
                    <?php echo esc_html($page->post_title); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <p class="description"><?php _e('Select a page or enter a custom URL below.', 'cari-prop-shop-cookie'); ?></p>
        <input type="url" name="cps_cookie_privacy_link_custom" id="cps_cookie_privacy_link_custom" value="<?php echo esc_attr($value); ?>" class="regular-text" placeholder="https://example.com/privacy-policy">
        <?php
    }

    public function render_checkbox_field($args) {
        $field = $args['field'];
        $default = isset($args['default']) ? $args['default'] : '';
        $value = get_option($field, $default);
        ?>
        <input type="checkbox" name="<?php echo esc_attr($field); ?>" id="<?php echo esc_attr($field); ?>" value="1" <?php checked($value, '1'); ?>>
        <?php
    }

    public function enqueue_admin_assets($hook) {
        if ('toplevel_page_cps-cookie-settings' !== $hook) {
            return;
        }

        wp_enqueue_style(
            'cps-cookie-admin',
            CPS_COOKIE_URL . 'assets/css/admin.css',
            array(),
            CPS_COOKIE_VERSION
        );
    }
}

CPS_Cookie_Admin::get_instance();