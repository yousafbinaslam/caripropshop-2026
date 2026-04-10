<?php
if (!defined('ABSPATH')) {
    exit;
}

class CPS_Admin_Mail {

    private static $instance = null;

    public static function get_instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('wp_ajax_cps_mail_delete_subscriber', array($this, 'delete_subscriber'));
        add_action('wp_ajax_cps_mail_delete_campaign', array($this, 'delete_campaign'));
        add_action('wp_ajax_cps_mail_send_campaign', array($this, 'send_campaign'));
        add_action('admin_init', array($this, 'handle_export'));
    }

    public function handle_export() {
        if (!isset($_GET['page']) || $_GET['page'] !== 'cps-mail-subscribers') {
            return;
        }
        
        if (!isset($_GET['action']) || $_GET['action'] !== 'export') {
            return;
        }
        
        if (!current_user_can('manage_options')) {
            return;
        }
        
        $subscriber_manager = cps_mail()->subscriber_manager();
        $subscribers = $subscriber_manager->export_subscribers();
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename=subscribers-' . date('Y-m-d') . '.csv');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Email', 'Name', 'Status', 'Subscribed Date'));
        
        foreach ($subscribers as $subscriber) {
            fputcsv($output, array(
                $subscriber->email,
                $subscriber->name,
                $subscriber->status,
                $subscriber->subscribe_date,
            ));
        }
        
        fclose($output);
        exit;
    }

    public function add_admin_menu() {
        add_menu_page(
            __('CariPropShop Mail', 'cari-prop-shop-mail'),
            __('CariPropShop Mail', 'cari-prop-shop-mail'),
            'manage_options',
            'cps-mail-dashboard',
            array($this, 'render_dashboard'),
            'dashicons-email',
            30
        );

        add_submenu_page(
            'cps-mail-dashboard',
            __('Subscribers', 'cari-prop-shop-mail'),
            __('Subscribers', 'cari-prop-shop-mail'),
            'manage_options',
            'cps-mail-subscribers',
            array($this, 'render_subscribers')
        );

        add_submenu_page(
            'cps-mail-dashboard',
            __('Campaigns', 'cari-prop-shop-mail'),
            __('Campaigns', 'cari-prop-shop-mail'),
            'manage_options',
            'cps-mail-campaigns',
            array($this, 'render_campaigns')
        );

        add_submenu_page(
            'cps-mail-dashboard',
            __('New Campaign', 'cari-prop-shop-mail'),
            __('New Campaign', 'cari-prop-shop-mail'),
            'manage_options',
            'cps-mail-campaign-new',
            array($this, 'render_campaign_editor')
        );

        add_submenu_page(
            'cps-mail-dashboard',
            __('Settings', 'cari-prop-shop-mail'),
            __('Settings', 'cari-prop-shop-mail'),
            'manage_options',
            'cps-mail-settings',
            array($this, 'render_settings')
        );
    }

    public function register_settings() {
        register_setting('cps_mail_general', 'cps_mail_double_optin');
        register_setting('cps_mail_general', 'cps_mail_from_email');
        register_setting('cps_mail_general', 'cps_mail_from_name');
        register_setting('cps_mail_general', 'cps_mail_confirm_subject');
        register_setting('cps_mail_general', 'cps_mail_confirm_message');
        register_setting('cps_mail_general', 'cps_mail_template');

        register_setting('cps_mail_smtp', 'cps_mail_smtp_enabled');
        register_setting('cps_mail_smtp', 'cps_mail_smtp_host');
        register_setting('cps_mail_smtp', 'cps_mail_smtp_port');
        register_setting('cps_mail_smtp', 'cps_mail_smtp_secure');
        register_setting('cps_mail_smtp', 'cps_mail_smtp_username');
        register_setting('cps_mail_smtp', 'cps_mail_smtp_password');
        register_setting('cps_mail_smtp', 'cps_mail_smtp_from_email');
        register_setting('cps_mail_smtp', 'cps_mail_smtp_from_name');

        add_settings_section('cps_mail_general_section', __('General Settings', 'cari-prop-shop-mail'), null, 'cps_mail_general');
        add_settings_section('cps_mail_smtp_section', __('SMTP Settings', 'cari-prop-shop-mail'), null, 'cps_mail_smtp');
    }

    public function render_dashboard() {
        $subscriber_manager = cps_mail()->subscriber_manager();
        
        $total_subscribers = $subscriber_manager->get_subscribers_count();
        $active_subscribers = $subscriber_manager->get_subscribers_count('subscribed');
        $pending_subscribers = $subscriber_manager->get_subscribers_count('pending');
        $total_campaigns = $subscriber_manager->get_campaigns_count();
        $sent_campaigns = $subscriber_manager->get_campaigns_count('sent');
        
        ?>
        <div class="wrap cps-mail-admin">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            
            <div class="cps-mail-stats">
                <div class="cps-mail-stat-box">
                    <h3><?php _e('Total Subscribers', 'cari-prop-shop-mail'); ?></h3>
                    <p class="stat-number"><?php echo number_format($total_subscribers); ?></p>
                </div>
                <div class="cps-mail-stat-box">
                    <h3><?php _e('Active Subscribers', 'cari-prop-shop-mail'); ?></h3>
                    <p class="stat-number"><?php echo number_format($active_subscribers); ?></p>
                </div>
                <div class="cps-mail-stat-box">
                    <h3><?php _e('Pending', 'cari-prop-shop-mail'); ?></h3>
                    <p class="stat-number"><?php echo number_format($pending_subscribers); ?></p>
                </div>
                <div class="cps-mail-stat-box">
                    <h3><?php _e('Campaigns Sent', 'cari-prop-shop-mail'); ?></h3>
                    <p class="stat-number"><?php echo number_format($sent_campaigns); ?></p>
                </div>
            </div>
            
            <div class="cps-mail-quick-actions">
                <a href="<?php echo admin_url('admin.php?page=cps-mail-campaign-new'); ?>" class="button button-primary button-large">
                    <?php _e('Create New Campaign', 'cari-prop-shop-mail'); ?>
                </a>
                <a href="<?php echo admin_url('admin.php?page=cps-mail-subscribers'); ?>" class="button button-large">
                    <?php _e('View Subscribers', 'cari-prop-shop-mail'); ?>
                </a>
            </div>
        </div>
        <?php
    }

    public function render_subscribers() {
        $subscriber_manager = cps_mail()->subscriber_manager();
        
        $page = isset($_GET['paged']) ? absint($_GET['paged']) : 1;
        $status = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : '';
        $search = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
        
        $subscribers = $subscriber_manager->get_subscribers(array(
            'page' => $page,
            'per_page' => 20,
            'status' => $status,
            'search' => $search,
        ));
        
        $total = $subscriber_manager->get_subscribers_count($status);
        $total_pages = ceil($total / 20);
        
        ?>
        <div class="wrap cps-mail-admin">
            <h1><?php _e('Subscribers', 'cari-prop-shop-mail'); ?>
                <a href="<?php echo admin_url('admin.php?page=cps-mail-subscribers&action=export'); ?>" class="button" style="margin-left:10px;">
                    <?php _e('Export CSV', 'cari-prop-shop-mail'); ?>
                </a>
            </h1>
            
            <form method="get" action="<?php echo admin_url('admin.php'); ?>">
                <input type="hidden" name="page" value="cps-mail-subscribers">
                <p class="search-box">
                    <label class="screen-reader-text" for="post-search-input"><?php _e('Search subscribers', 'cari-prop-shop-mail'); ?></label>
                    <input type="search" id="post-search-input" name="s" value="<?php echo esc_attr($search); ?>" placeholder="<?php esc_attr_e('Search by email or name', 'cari-prop-shop-mail'); ?>">
                    <input type="submit" class="button" value="<?php esc_attr_e('Search', 'cari-prop-shop-mail'); ?>">
                </p>
            </form>
            
            <ul class="subscribers-tabs">
                <li><a href="<?php echo admin_url('admin.php?page=cps-mail-subscribers'); ?>" class="<?php echo empty($status) ? 'active' : ''; ?>"><?php _e('All', 'cari-prop-shop-mail'); ?></a></li>
                <li><a href="<?php echo admin_url('admin.php?page=cps-mail-subscribers&status=subscribed'); ?>" class="<?php echo $status === 'subscribed' ? 'active' : ''; ?>"><?php _e('Active', 'cari-prop-shop-mail'); ?></a></li>
                <li><a href="<?php echo admin_url('admin.php?page=cps-mail-subscribers&status=pending'); ?>" class="<?php echo $status === 'pending' ? 'active' : ''; ?>"><?php _e('Pending', 'cari-prop-shop-mail'); ?></a></li>
                <li><a href="<?php echo admin_url('admin.php?page=cps-mail-subscribers&status=unsubscribed'); ?>" class="<?php echo $status === 'unsubscribed' ? 'active' : ''; ?>"><?php _e('Unsubscribed', 'cari-prop-shop-mail'); ?></a></li>
            </ul>
            
            <table class="widefat fixed striped">
                <thead>
                    <tr>
                        <th><?php _e('Email', 'cari-prop-shop-mail'); ?></th>
                        <th><?php _e('Name', 'cari-prop-shop-mail'); ?></th>
                        <th><?php _e('Status', 'cari-prop-shop-mail'); ?></th>
                        <th><?php _e('Subscribed', 'cari-prop-shop-mail'); ?></th>
                        <th><?php _e('Actions', 'cari-prop-shop-mail'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($subscribers)): ?>
                        <tr>
                            <td colspan="5"><?php _e('No subscribers found.', 'cari-prop-shop-mail'); ?></td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($subscribers as $subscriber): ?>
                            <tr data-id="<?php echo esc_attr($subscriber->id); ?>">
                                <td><?php echo esc_html($subscriber->email); ?></td>
                                <td><?php echo esc_html($subscriber->name); ?></td>
                                <td><span class="status-badge status-<?php echo esc_attr($subscriber->status); ?>"><?php echo esc_html(ucfirst($subscriber->status)); ?></span></td>
                                <td><?php echo esc_html(date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($subscriber->subscribe_date))); ?></td>
                                <td>
                                    <button class="button-link delete-subscriber" data-id="<?php echo esc_attr($subscriber->id); ?>"><?php _e('Delete', 'cari-prop-shop-mail'); ?></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <?php if ($total_pages > 1): ?>
                <div class="tablenav">
                    <div class="tablenav-pages">
                        <?php
                        echo paginate_links(array(
                            'base' => add_query_arg('paged', '%d'),
                            'format' => '',
                            'current' => $page,
                            'total' => $total_pages,
                        ));
                        ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }

    public function render_campaigns() {
        $subscriber_manager = cps_mail()->subscriber_manager();
        
        $page = isset($_GET['paged']) ? absint($_GET['paged']) : 1;
        $status = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : '';
        
        $campaigns = $subscriber_manager->get_campaigns(array(
            'page' => $page,
            'per_page' => 20,
            'status' => $status,
        ));
        
        $total = $subscriber_manager->get_campaigns_count($status);
        $total_pages = ceil($total / 20);
        
        ?>
        <div class="wrap cps-mail-admin">
            <h1><?php _e('Email Campaigns', 'cari-prop-shop-mail'); ?>
                <a href="<?php echo admin_url('admin.php?page=cps-mail-campaign-new'); ?>" class="button button-primary"><?php _e('New Campaign', 'cari-prop-shop-mail'); ?></a>
            </h1>
            
            <ul class="campaigns-tabs">
                <li><a href="<?php echo admin_url('admin.php?page=cps-mail-campaigns'); ?>" class="<?php echo empty($status) ? 'active' : ''; ?>"><?php _e('All', 'cari-prop-shop-mail'); ?></a></li>
                <li><a href="<?php echo admin_url('admin.php?page=cps-mail-campaigns&status=draft'); ?>" class="<?php echo $status === 'draft' ? 'active' : ''; ?>"><?php _e('Drafts', 'cari-prop-shop-mail'); ?></a></li>
                <li><a href="<?php echo admin_url('admin.php?page=cps-mail-campaigns&status=sent'); ?>" class="<?php echo $status === 'sent' ? 'active' : ''; ?>"><?php _e('Sent', 'cari-prop-shop-mail'); ?></a></li>
            </ul>
            
            <table class="widefat fixed striped">
                <thead>
                    <tr>
                        <th><?php _e('Title', 'cari-prop-shop-mail'); ?></th>
                        <th><?php _e('Subject', 'cari-prop-shop-mail'); ?></th>
                        <th><?php _e('Status', 'cari-prop-shop-mail'); ?></th>
                        <th><?php _e('Sent', 'cari-prop-shop-mail'); ?></th>
                        <th><?php _e('Opens', 'cari-prop-shop-mail'); ?></th>
                        <th><?php _e('Clicks', 'cari-prop-shop-mail'); ?></th>
                        <th><?php _e('Date', 'cari-prop-shop-mail'); ?></th>
                        <th><?php _e('Actions', 'cari-prop-shop-mail'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($campaigns)): ?>
                        <tr>
                            <td colspan="8"><?php _e('No campaigns found.', 'cari-prop-shop-mail'); ?></td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($campaigns as $campaign): ?>
                            <tr data-id="<?php echo esc_attr($campaign->id); ?>">
                                <td><?php echo esc_html($campaign->title); ?></td>
                                <td><?php echo esc_html($campaign->subject); ?></td>
                                <td><span class="status-badge status-<?php echo esc_attr($campaign->status); ?>"><?php echo esc_html(ucfirst($campaign->status)); ?></span></td>
                                <td><?php echo number_format($campaign->total_sent); ?></td>
                                <td><?php echo number_format($campaign->opens); ?></td>
                                <td><?php echo number_format($campaign->clicks); ?></td>
                                <td><?php echo esc_html(date_i18n(get_option('date_format'), strtotime($campaign->created_at))); ?></td>
                                <td>
                                    <?php if ($campaign->status === 'draft'): ?>
                                        <a href="<?php echo admin_url('admin.php?page=cps-mail-campaign-new&campaign_id=' . $campaign->id); ?>" class="button"><?php _e('Edit', 'cari-prop-shop-mail'); ?></a>
                                        <button class="button button-primary send-campaign" data-id="<?php echo esc_attr($campaign->id); ?>"><?php _e('Send', 'cari-prop-shop-mail'); ?></button>
                                    <?php endif; ?>
                                    <button class="button-link delete-campaign" data-id="<?php echo esc_attr($campaign->id); ?>"><?php _e('Delete', 'cari-prop-shop-mail'); ?></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <?php if ($total_pages > 1): ?>
                <div class="tablenav">
                    <div class="tablenav-pages">
                        <?php
                        echo paginate_links(array(
                            'base' => add_query_arg('paged', '%d'),
                            'format' => '',
                            'current' => $page,
                            'total' => $total_pages,
                        ));
                        ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }

    public function render_campaign_editor() {
        $campaign_id = isset($_GET['campaign_id']) ? absint($_GET['campaign_id']) : 0;
        $campaign = null;
        
        if ($campaign_id) {
            $subscriber_manager = cps_mail()->subscriber_manager();
            $campaign = $subscriber_manager->get_campaign($campaign_id);
        }
        
        ?>
        <div class="wrap cps-mail-admin">
            <h1><?php echo $campaign ? __('Edit Campaign', 'cari-prop-shop-mail') : __('New Campaign', 'cari-prop-shop-mail'); ?></h1>
            
            <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" id="cps-mail-campaign-form">
                <?php wp_nonce_field('cps_mail_campaign_save', 'cps_mail_nonce'); ?>
                <input type="hidden" name="action" value="cps_mail_save_campaign">
                <?php if ($campaign): ?>
                    <input type="hidden" name="campaign_id" value="<?php echo esc_attr($campaign->id); ?>">
                <?php endif; ?>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="title"><?php _e('Campaign Title', 'cari-prop-shop-mail'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="title" name="title" class="regular-text" value="<?php echo $campaign ? esc_attr($campaign->title) : ''; ?>" required>
                            <p class="description"><?php _e('For internal use only.', 'cari-prop-shop-mail'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="subject"><?php _e('Email Subject', 'cari-prop-shop-mail'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="subject" name="subject" class="large-text" value="<?php echo $campaign ? esc_attr($campaign->subject) : ''; ?>" required>
                            <p class="description"><?php _e('This will appear in the email subject line.', 'cari-prop-shop-mail'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="template"><?php _e('Email Template', 'cari-prop-shop-mail'); ?></label>
                        </th>
                        <td>
                            <select id="template" name="template">
                                <option value="default" <?php selected($campaign ? $campaign->template : 'default', 'default'); ?>><?php _e('Default', 'cari-prop-shop-mail'); ?></option>
                                <option value="minimal" <?php selected($campaign ? $campaign->template : '', 'minimal'); ?>><?php _e('Minimal', 'cari-prop-shop-mail'); ?></option>
                                <option value="promo" <?php selected($campaign ? $campaign->template : '', 'promo'); ?>><?php _e('Promotional', 'cari-prop-shop-mail'); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="content"><?php _e('Email Content', 'cari-prop-shop-mail'); ?></label>
                        </th>
                        <td>
                            <?php
                            wp_editor(
                                $campaign ? $campaign->content : '',
                                'content',
                                array(
                                    'textarea_name' => 'content',
                                    'textarea_rows' => 15,
                                    'media_buttons' => true,
                                    'teeny' => false,
                                )
                            );
                            ?>
                            <p class="description">
                                <button type="button" class="button" id="cps-insert-properties"><?php _e('Insert Property Updates', 'cari-prop-shop-mail'); ?></button>
                                <button type="button" class="button" id="cps-insert-unsubscribe"><?php _e('Insert Unsubscribe Link', 'cari-prop-shop-mail'); ?></button>
                            </p>
                        </td>
                    </tr>
                </table>
                
                <p class="submit">
                    <button type="submit" class="button button-primary" name="save_draft"><?php _e('Save Draft', 'cari-prop-shop-mail'); ?></button>
                    <?php if ($campaign && $campaign->status === 'draft'): ?>
                        <button type="submit" class="button button-primary" name="send_campaign"><?php _e('Send Now', 'cari-prop-shop-mail'); ?></button>
                    <?php endif; ?>
                </p>
            </form>
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            $('#cps-insert-properties').on('click', function() {
                var content = wp.editor.getContent('content');
                content += '\n[property_updates]';
                wp.editor.setContent('content', content);
            });
            
            $('#cps-insert-unsubscribe').on('click', function() {
                var content = wp.editor.getContent('content');
                content += '\n<a href="{unsubscribe_url}">Unsubscribe</a>';
                wp.editor.setContent('content', content);
            });
            
            $('#cps-mail-campaign-form').on('submit', function(e) {
                if (tinyMCE.activeEditor && !tinyMCE.activeEditor.isHidden()) {
                    $('#content').val(tinyMCE.activeEditor.getContent());
                }
            });
        });
        </script>
        <?php
    }

    public function render_settings() {
        $active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'general';
        
        ?>
        <div class="wrap cps-mail-admin">
            <h1><?php _e('Mail Settings', 'cari-prop-shop-mail'); ?></h1>
            
            <h2 class="nav-tab-wrapper">
                <a href="<?php echo admin_url('admin.php?page=cps-mail-settings&tab=general'); ?>" class="nav-tab <?php echo $active_tab === 'general' ? 'nav-tab-active' : ''; ?>"><?php _e('General', 'cari-prop-shop-mail'); ?></a>
                <a href="<?php echo admin_url('admin.php?page=cps-mail-settings&tab=smtp'); ?>" class="nav-tab <?php echo $active_tab === 'smtp' ? 'nav-tab-active' : ''; ?>"><?php _e('SMTP', 'cari-prop-shop-mail'); ?></a>
                <a href="<?php echo admin_url('admin.php?page=cps-mail-settings&tab=templates'); ?>" class="nav-tab <?php echo $active_tab === 'templates' ? 'nav-tab-active' : ''; ?>"><?php _e('Templates', 'cari-prop-shop-mail'); ?></a>
            </h2>
            
            <form method="post" action="options.php">
                <?php
                if ($active_tab === 'general') {
                    settings_fields('cps_mail_general');
                    do_settings_fields('cps_mail_general', 'cps_mail_general_section');
                    ?>
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="cps_mail_double_optin"><?php _e('Double Opt-in', 'cari-prop-shop-mail'); ?></label>
                            </th>
                            <td>
                                <input type="checkbox" id="cps_mail_double_optin" name="cps_mail_double_optin" value="1" <?php checked(get_option('cps_mail_double_optin', true)); ?>>
                                <p class="description"><?php _e('Require subscribers to confirm their email before being added.', 'cari-prop-shop-mail'); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="cps_mail_from_email"><?php _e('From Email', 'cari-prop-shop-mail'); ?></label>
                            </th>
                            <td>
                                <input type="email" id="cps_mail_from_email" name="cps_mail_from_email" class="regular-text" value="<?php echo esc_attr(get_option('cps_mail_from_email', get_option('admin_email'))); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="cps_mail_from_name"><?php _e('From Name', 'cari-prop-shop-mail'); ?></label>
                            </th>
                            <td>
                                <input type="text" id="cps_mail_from_name" name="cps_mail_from_name" class="regular-text" value="<?php echo esc_attr(get_option('cps_mail_from_name', get_bloginfo('name'))); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="cps_mail_confirm_subject"><?php _e('Confirmation Email Subject', 'cari-prop-shop-mail'); ?></label>
                            </th>
                            <td>
                                <input type="text" id="cps_mail_confirm_subject" name="cps_mail_confirm_subject" class="large-text" value="<?php echo esc_attr(get_option('cps_mail_confirm_subject', __('Confirm your subscription', 'cari-prop-shop-mail'))); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="cps_mail_confirm_message"><?php _e('Confirmation Message', 'cari-prop-shop-mail'); ?></label>
                            </th>
                            <td>
                                <textarea id="cps_mail_confirm_message" name="cps_mail_confirm_message" class="large-text" rows="6"><?php echo esc_textarea(get_option('cps_mail_confirm_message')); ?></textarea>
                                <p class="description"><?php _e('Available tags: {confirm_url}, {name}', 'cari-prop-shop-mail'); ?></p>
                            </td>
                        </tr>
                    </table>
                    <?php
                } elseif ($active_tab === 'smtp') {
                    settings_fields('cps_mail_smtp');
                    do_settings_fields('cps_mail_smtp', 'cps_mail_smtp_section');
                    ?>
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="cps_mail_smtp_enabled"><?php _e('Enable SMTP', 'cari-prop-shop-mail'); ?></label>
                            </th>
                            <td>
                                <input type="checkbox" id="cps_mail_smtp_enabled" name="cps_mail_smtp_enabled" value="1" <?php checked(get_option('cps_mail_smtp_enabled')); ?>>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="cps_mail_smtp_host"><?php _e('SMTP Host', 'cari-prop-shop-mail'); ?></label>
                            </th>
                            <td>
                                <input type="text" id="cps_mail_smtp_host" name="cps_mail_smtp_host" class="regular-text" value="<?php echo esc_attr(get_option('cps_mail_smtp_host')); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="cps_mail_smtp_port"><?php _e('SMTP Port', 'cari-prop-shop-mail'); ?></label>
                            </th>
                            <td>
                                <input type="number" id="cps_mail_smtp_port" name="cps_mail_smtp_port" class="small-text" value="<?php echo esc_attr(get_option('cps_mail_smtp_port', 587)); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="cps_mail_smtp_secure"><?php _e('Encryption', 'cari-prop-shop-mail'); ?></label>
                            </th>
                            <td>
                                <select id="cps_mail_smtp_secure" name="cps_mail_smtp_secure">
                                    <option value="tls" <?php selected(get_option('cps_mail_smtp_secure', 'tls'), 'tls'); ?>>TLS</option>
                                    <option value="ssl" <?php selected(get_option('cps_mail_smtp_secure'), 'ssl'); ?>>SSL</option>
                                    <option value="" <?php selected(get_option('cps_mail_smtp_secure'), ''); ?>><?php _e('None', 'cari-prop-shop-mail'); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="cps_mail_smtp_username"><?php _e('Username', 'cari-prop-shop-mail'); ?></label>
                            </th>
                            <td>
                                <input type="text" id="cps_mail_smtp_username" name="cps_mail_smtp_username" class="regular-text" value="<?php echo esc_attr(get_option('cps_mail_smtp_username')); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="cps_mail_smtp_password"><?php _e('Password', 'cari-prop-shop-mail'); ?></label>
                            </th>
                            <td>
                                <input type="password" id="cps_mail_smtp_password" name="cps_mail_smtp_password" class="regular-text" value="<?php echo esc_attr(get_option('cps_mail_smtp_password')); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="cps_mail_smtp_from_email"><?php _e('From Email', 'cari-prop-shop-mail'); ?></label>
                            </th>
                            <td>
                                <input type="email" id="cps_mail_smtp_from_email" name="cps_mail_smtp_from_email" class="regular-text" value="<?php echo esc_attr(get_option('cps_mail_smtp_from_email')); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="cps_mail_smtp_from_name"><?php _e('From Name', 'cari-prop-shop-mail'); ?></label>
                            </th>
                            <td>
                                <input type="text" id="cps_mail_smtp_from_name" name="cps_mail_smtp_from_name" class="regular-text" value="<?php echo esc_attr(get_option('cps_mail_smtp_from_name')); ?>">
                            </td>
                        </tr>
                    </table>
                    <?php
                } elseif ($active_tab === 'templates') {
                    ?>
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="cps_mail_template"><?php _e('Email Template', 'cari-prop-shop-mail'); ?></label>
                            </th>
                            <td>
                                <select id="cps_mail_template" name="cps_mail_template">
                                    <option value="default" <?php selected(get_option('cps_mail_template', 'default'), 'default'); ?>><?php _e('Default', 'cari-prop-shop-mail'); ?></option>
                                    <option value="minimal" <?php selected(get_option('cps_mail_template'), 'minimal'); ?>><?php _e('Minimal', 'cari-prop-shop-mail'); ?></option>
                                    <option value="promo" <?php selected(get_option('cps_mail_template'), 'promo'); ?>><?php _e('Promotional', 'cari-prop-shop-mail'); ?></option>
                                </select>
                                <p class="description"><?php _e('Choose the default template for outgoing emails.', 'cari-prop-shop-mail'); ?></p>
                            </td>
                        </tr>
                    </table>
                    <?php
                }
                
                submit_button(__('Save Settings', 'cari-prop-shop-mail'));
                ?>
            </form>
        </div>
        <?php
    }

    public function delete_subscriber() {
        check_ajax_referer('cps_mail_admin_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => __('Unauthorized', 'cari-prop-shop-mail')));
        }
        
        $id = absint($_POST['id']);
        
        $subscriber_manager = cps_mail()->subscriber_manager();
        $result = $subscriber_manager->delete_subscriber($id);
        
        if ($result) {
            wp_send_json_success();
        } else {
            wp_send_json_error(array('message' => __('Failed to delete subscriber', 'cari-prop-shop-mail')));
        }
    }

    public function delete_campaign() {
        check_ajax_referer('cps_mail_admin_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => __('Unauthorized', 'cari-prop-shop-mail')));
        }
        
        $id = absint($_POST['id']);
        
        $subscriber_manager = cps_mail()->subscriber_manager();
        $result = $subscriber_manager->delete_campaign($id);
        
        if ($result) {
            wp_send_json_success();
        } else {
            wp_send_json_error(array('message' => __('Failed to delete campaign', 'cari-prop-shop-mail')));
        }
    }

    public function send_campaign() {
        check_ajax_referer('cps_mail_admin_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => __('Unauthorized', 'cari-prop-shop-mail')));
        }
        
        $id = absint($_POST['id']);
        
        $mail_handler = cps_mail()->mail_handler();
        $result = $mail_handler->send_campaign($id);
        
        if (is_wp_error($result)) {
            wp_send_json_error(array('message' => $result->get_error_message()));
        } else {
            wp_send_json_success(array(
                'message' => sprintf(__('Campaign sent to %d subscribers', 'cari-prop-shop-mail'), $result['sent']),
                'sent' => $result['sent'],
                'failed' => $result['failed'],
            ));
        }
    }
}

add_action('admin_post_cps_mail_save_campaign', 'cps_mail_save_campaign_handler');

function cps_mail_save_campaign_handler() {
    check_admin_referer('cps_mail_campaign_save', 'cps_mail_nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die(__('Unauthorized', 'cari-prop-shop-mail'));
    }
    
    $campaign_id = isset($_POST['campaign_id']) ? absint($_POST['campaign_id']) : 0;
    $title = sanitize_text_field($_POST['title']);
    $subject = sanitize_text_field($_POST['subject']);
    $content = wp_kses_post($_POST['content']);
    $template = sanitize_text_field($_POST['template']);
    
    $subscriber_manager = cps_mail()->subscriber_manager();
    
    $data = array(
        'title' => $title,
        'subject' => $subject,
        'content' => $content,
        'template' => $template,
        'status' => 'draft',
    );
    
    if ($campaign_id) {
        $subscriber_manager->update_campaign($campaign_id, $data);
    } else {
        $campaign_id = $subscriber_manager->add_campaign($data);
    }
    
    if (isset($_POST['send_campaign'])) {
        $mail_handler = cps_mail()->mail_handler();
        $result = $mail_handler->send_campaign($campaign_id);
        
        if (is_wp_error($result)) {
            wp_redirect(add_query_arg('message', 'error', admin_url('admin.php?page=cps-mail-campaigns')));
        } else {
            wp_redirect(add_query_arg('message', 'sent', admin_url('admin.php?page=cps-mail-campaigns')));
        }
    } else {
        wp_redirect(add_query_arg('message', 'saved', admin_url('admin.php?page=cps-mail-campaigns')));
    }
    
    exit;
}