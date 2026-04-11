<?php
/**
 * CariPropShop CRM
 * Enhanced with complete admin dashboard
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
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        
        add_action('wp_ajax_cps_save_lead', array($this, 'save_lead'));
        add_action('wp_ajax_nopriv_cps_save_lead', array($this, 'save_lead'));
        add_action('wp_ajax_cps_update_lead_status', array($this, 'update_lead_status'));
        add_action('wp_ajax_cps_delete_lead', array($this, 'delete_lead'));
        add_action('wp_ajax_cps_get_lead_details', array($this, 'get_lead_details'));
        add_action('wp_ajax_cps_add_lead_note', array($this, 'add_lead_note'));
        add_action('wp_ajax_cps_export_leads', array($this, 'export_leads'));
        add_action('wp_ajax_cps_assign_lead', array($this, 'assign_lead'));
        add_action('wp_ajax_cps_schedule_followup', array($this, 'schedule_followup'));
        add_action('wp_ajax_cps_merge_leads', array($this, 'merge_leads'));
        
        add_action('wp_ajax_cps_save_favorite', array($this, 'save_favorite'));
        add_action('wp_ajax_nopriv_cps_save_favorite', array($this, 'save_favorite'));
        add_action('wp_ajax_cps_remove_favorite', array($this, 'remove_favorite'));
        
        add_action('init', array($this, 'check_followup_reminders'));
        add_action('admin_init', array($this, 'register_crm_settings'));
    }

    public function register_post_types() {
        register_post_type('cps_lead', array(
            'labels' => array(
                'name' => __('Leads', 'cari-prop-shop-crm'),
                'singular_name' => __('Lead', 'cari-prop-shop-crm'),
                'add_new' => __('Add Lead', 'cari-prop-shop-crm'),
                'add_new_item' => __('Add New Lead', 'cari-prop-shop-crm'),
                'edit_item' => __('Edit Lead', 'cari-prop-shop-crm'),
                'new_item' => __('New Lead', 'cari-prop-shop-crm'),
                'view_item' => __('View Lead', 'cari-prop-shop-crm'),
                'search_items' => __('Search Leads', 'cari-prop-shop-crm'),
                'not_found' => __('No leads found', 'cari-prop-shop-crm'),
            ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => 'cari-prop-shop',
            'capability_type' => 'post',
            'supports' => array('title', 'editor', 'custom-fields'),
            'menu_icon' => 'dashicons-groups',
        ));

        register_post_type('cps_favorite', array(
            'labels' => array(
                'name' => __('Favorites', 'cari-prop-shop-crm'),
                'singular_name' => __('Favorite', 'cari-prop-shop-crm'),
            ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => 'cari-prop-shop',
            'capability_type' => 'post',
            'supports' => array('title', 'custom-fields'),
            'menu_icon' => 'dashicons-heart',
        ));

        register_post_type('cps_testimonial', array(
            'labels' => array(
                'name' => __('Testimonials', 'cari-prop-shop-crm'),
                'singular_name' => __('Testimonial', 'cari-prop-shop-crm'),
                'add_new' => __('Add Testimonial', 'cari-prop-shop-crm'),
                'add_new_item' => __('Add New Testimonial', 'cari-prop-shop-crm'),
                'edit_item' => __('Edit Testimonial', 'cari-prop-shop-crm'),
            ),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => 'cari-prop-shop',
            'supports' => array('title', 'editor', 'thumbnail'),
            'menu_icon' => 'dashicons-testimonial',
            'has_archive' => true,
            'show_in_rest' => true,
        ));
    }

    public function add_admin_menu() {
        add_menu_page(
            'CariPropShop CRM',
            'CariPropShop',
            'manage_options',
            'cari-prop-shop',
            array($this, 'render_dashboard'),
            'dashicons-building',
            30
        );

        add_submenu_page(
            'cari-prop-shop',
            'Dashboard',
            'Dashboard',
            'manage_options',
            'cari-prop-shop',
            array($this, 'render_dashboard')
        );

        add_submenu_page(
            'cari-prop-shop',
            'Leads',
            'Leads',
            'manage_options',
            'cps-leads',
            array($this, 'render_leads_page')
        );

        add_submenu_page(
            'cari-prop-shop',
            'Testimonials',
            'Testimonials',
            'manage_options',
            'edit.php?post_type=cps_testimonial',
            null
        );

        add_submenu_page(
            'cari-prop-shop',
            'Settings',
            'Settings',
            'manage_options',
            'cps-crm-settings',
            array($this, 'render_settings_page')
        );
    }

    public function enqueue_admin_assets($hook) {
        if (strpos($hook, 'cari-prop-shop') === false && strpos($hook, 'cps-leads') === false) {
            return;
        }

        wp_enqueue_style('cps-crm-admin', CPS_CRM_PLUGIN_URL . 'assets/css/admin-crm.css', array(), CPS_CRM_VERSION);
        wp_enqueue_script('cps-crm-admin', CPS_CRM_PLUGIN_URL . 'assets/js/admin-crm.js', array('jquery'), CPS_CRM_VERSION, true);

        wp_localize_script('cps-crm-admin', 'cpsCrmData', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('cps_crm_nonce'),
        ));
    }

    public function render_dashboard() {
        $stats = $this->get_dashboard_stats();
        $recent_leads = $this->get_recent_leads(5);
        $leads_by_status = $this->get_leads_by_status();
        ?>
        <div class="wrap cps-crm-dashboard">
            <h1>CRM Dashboard</h1>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <div class="stat-content">
                        <h3><?php echo esc_html($stats['total_leads']); ?></h3>
                        <p>Total Leads</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon new"><i class="fas fa-user-plus"></i></div>
                    <div class="stat-content">
                        <h3><?php echo esc_html($stats['new_leads']); ?></h3>
                        <p>New (This Week)</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon contact"><i class="fas fa-phone-alt"></i></div>
                    <div class="stat-content">
                        <h3><?php echo esc_html($stats['contacted']); ?></h3>
                        <p>Contacted</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon qualified"><i class="fas fa-user-check"></i></div>
                    <div class="stat-content">
                        <h3><?php echo esc_html($stats['qualified']); ?></h3>
                        <p>Qualified</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon converted"><i class="fas fa-handshake"></i></div>
                    <div class="stat-content">
                        <h3><?php echo esc_html($stats['converted']); ?></h3>
                        <p>Converted</p>
                    </div>
                </div>
            </div>

            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <h2>Recent Leads</h2>
                    <table class="wp-list-table widefat fixed striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($recent_leads) : ?>
                                <?php foreach ($recent_leads as $lead) : ?>
                                    <tr>
                                        <td><a href="<?php echo admin_url('admin.php?page=cps-leads&action=view&id=' . $lead->ID); ?>"><?php echo esc_html($lead->post_title); ?></a></td>
                                        <td><?php echo esc_html(get_post_meta($lead->ID, 'email', true)); ?></td>
                                        <td><?php echo esc_html(get_post_meta($lead->ID, 'phone', true)); ?></td>
                                        <td><span class="status-badge status-<?php echo esc_attr(get_post_meta($lead->ID, 'status', true) ?: 'new'); ?>"><?php echo esc_html(ucfirst(get_post_meta($lead->ID, 'status', true) ?: 'New')); ?></span></td>
                                        <td><?php echo esc_html(get_the_date('M j, Y', $lead->ID)); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr><td colspan="5">No leads yet</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="dashboard-card">
                    <h2>Leads by Status</h2>
                    <div class="status-chart">
                        <?php foreach ($leads_by_status as $status => $count) : ?>
                            <div class="status-bar">
                                <span class="status-label"><?php echo esc_html(ucfirst($status)); ?></span>
                                <div class="bar-container">
                                    <div class="bar status-<?php echo esc_attr($status); ?>" style="width: <?php echo $stats['total_leads'] > 0 ? ($count / $stats['total_leads'] * 100) : 0; ?>%"></div>
                                </div>
                                <span class="status-count"><?php echo esc_html($count); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public function render_leads_page() {
        $action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : 'list';
        $lead_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($action === 'view' && $lead_id > 0) {
            $this->render_lead_detail($lead_id);
        } else {
            $this->render_leads_list();
        }
    }

    private function render_leads_list() {
        $leads = $this->get_all_leads();
        $statuses = array('new', 'contacted', 'qualified', 'proposal', 'negotiation', 'converted', 'lost');
        ?>
        <div class="wrap cps-crm-leads">
            <div class="leads-header">
                <h1>Leads</h1>
                <button class="page-title-action" id="addNewLead">Add New Lead</button>
            </div>

            <div class="leads-filters">
                <select id="filterStatus" class="postform">
                    <option value="">All Statuses</option>
                    <?php foreach ($statuses as $status) : ?>
                        <option value="<?php echo esc_attr($status); ?>"><?php echo esc_html(ucfirst($status)); ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" id="searchLeads" placeholder="Search leads..." class="search-input">
                <button class="button" id="exportLeads"><i class="fas fa-download"></i> Export</button>
            </div>

            <table class="wp-list-table widefat fixed striped display" id="leadsTable">
                <thead>
                    <tr>
                        <th width="20"><input type="checkbox" id="selectAll"></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Property Interest</th>
                        <th>Status</th>
                        <th>Source</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($leads) : ?>
                        <?php foreach ($leads as $lead) : 
                            $status = get_post_meta($lead->ID, 'status', true) ?: 'new';
                            $email = get_post_meta($lead->ID, 'email', true);
                            $phone = get_post_meta($lead->ID, 'phone', true);
                            $property_id = get_post_meta($lead->ID, 'property_id', true);
                            $source = get_post_meta($lead->ID, 'source', true);
                            $property_title = $property_id ? get_the_title($property_id) : '-';
                        ?>
                            <tr data-status="<?php echo esc_attr($status); ?>">
                                <td><input type="checkbox" class="lead-checkbox" value="<?php echo esc_attr($lead->ID); ?>"></td>
                                <td><a href="<?php echo admin_url('admin.php?page=cps-leads&action=view&id=' . $lead->ID); ?>"><?php echo esc_html($lead->post_title); ?></a></td>
                                <td><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></td>
                                <td><a href="tel:<?php echo esc_attr($phone); ?>"><?php echo esc_html($phone); ?></a></td>
                                <td><?php echo esc_html($property_title); ?></td>
                                <td>
                                    <select class="status-select" data-lead-id="<?php echo esc_attr($lead->ID); ?>">
                                        <?php foreach ($statuses as $s) : ?>
                                            <option value="<?php echo esc_attr($s); ?>" <?php selected($status, $s); ?>><?php echo esc_html(ucfirst($s)); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td><?php echo esc_html(ucfirst($source ?: 'Website')); ?></td>
                                <td><?php echo esc_html(get_the_date('M j, Y', $lead->ID)); ?></td>
                                <td>
                                    <a href="<?php echo admin_url('admin.php?page=cps-leads&action=view&id=' . $lead->ID); ?>" class="button button-small"><i class="fas fa-eye"></i></a>
                                    <button class="button button-small delete-lead" data-lead-id="<?php echo esc_attr($lead->ID); ?>"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr><td colspan="9">No leads found</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Add/Edit Lead Modal -->
        <div id="leadModal" class="cps-modal" style="display:none;">
            <div class="cps-modal-content">
                <span class="cps-modal-close">&times;</span>
                <h2 id="modalTitle">Add New Lead</h2>
                <form id="leadForm">
                    <input type="hidden" name="lead_id" id="leadId" value="">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Name *</label>
                            <input type="text" name="name" id="leadName" required>
                        </div>
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" name="email" id="leadEmail" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Phone *</label>
                            <input type="tel" name="phone" id="leadPhone" required>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" id="leadStatus">
                                <option value="new">New</option>
                                <option value="contacted">Contacted</option>
                                <option value="qualified">Qualified</option>
                                <option value="proposal">Proposal</option>
                                <option value="negotiation">Negotiation</option>
                                <option value="converted">Converted</option>
                                <option value="lost">Lost</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Property Interest</label>
                        <input type="text" name="property_interest" id="leadProperty">
                    </div>
                    <div class="form-group">
                        <label>Inquiry Type</label>
                        <select name="inquiry_type" id="leadInquiryType">
                            <option value="purchase">Purchase</option>
                            <option value="rent">Rent</option>
                            <option value="sell">Sell</option>
                            <option value="valuation">Valuation</option>
                            <option value="mortgage">Mortgage</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea name="message" id="leadMessage" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Notes</label>
                        <textarea name="notes" id="leadNotes" rows="3"></textarea>
                    </div>
                    <button type="submit" class="button button-primary">Save Lead</button>
                </form>
            </div>
        </div>
        <?php
    }

    private function render_lead_detail($lead_id) {
        $lead = get_post($lead_id);
        if (!$lead) {
            wp_die('Lead not found');
        }

        $email = get_post_meta($lead_id, 'email', true);
        $phone = get_post_meta($lead_id, 'phone', true);
        $status = get_post_meta($lead_id, 'status', true) ?: 'new';
        $property_id = get_post_meta($lead_id, 'property_id', true);
        $source = get_post_meta($lead_id, 'source', true);
        $inquiry_type = get_post_meta($lead_id, 'inquiry_type', true);
        $notes = get_post_meta($lead_id, 'notes', true);
        $property_title = $property_id ? get_the_title($property_id) : '-';
        ?>
        <div class="wrap cps-lead-detail">
            <h1>
                <a href="<?php echo admin_url('admin.php?page=cps-leads'); ?>" class="page-title-return">← Back to Leads</a>
                <?php echo esc_html($lead->post_title); ?>
                <span class="status-badge status-<?php echo esc_attr($status); ?>"><?php echo esc_html(ucfirst($status)); ?></span>
            </h1>

            <div class="lead-detail-grid">
                <div class="lead-info-card">
                    <h2>Contact Information</h2>
                    <div class="info-row">
                        <i class="fas fa-envelope"></i>
                        <span><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></span>
                    </div>
                    <div class="info-row">
                        <i class="fas fa-phone"></i>
                        <span><a href="tel:<?php echo esc_attr($phone); ?>"><?php echo esc_html($phone); ?></a></span>
                    </div>
                    <div class="info-row">
                        <i class="fas fa-building"></i>
                        <span>Property: <?php echo esc_html($property_title); ?></span>
                    </div>
                    <div class="info-row">
                        <i class="fas fa-tag"></i>
                        <span>Inquiry: <?php echo esc_html(ucfirst($inquiry_type ?: 'N/A')); ?></span>
                    </div>
                    <div class="info-row">
                        <i class="fas fa-globe"></i>
                        <span>Source: <?php echo esc_html(ucfirst($source ?: 'Website')); ?></span>
                    </div>
                    <div class="info-row">
                        <i class="fas fa-calendar"></i>
                        <span>Created: <?php echo esc_html(get_the_date('F j, Y g:i a', $lead_id)); ?></span>
                    </div>
                </div>

                <div class="lead-actions-card">
                    <h2>Quick Actions</h2>
                    <div class="action-buttons">
                        <button class="button button-primary update-status" data-status="contacted"><i class="fas fa-phone"></i> Mark Contacted</button>
                        <button class="button update-status" data-status="qualified"><i class="fas fa-check"></i> Qualify</button>
                        <button class="button update-status" data-status="converted"><i class="fas fa-handshake"></i> Convert</button>
                        <button class="button button-secondary" id="editLead"><i class="fas fa-edit"></i> Edit</button>
                    </div>
                    <div class="status-change-form">
                        <label>Change Status:</label>
                        <select id="quickStatusChange">
                            <option value="new">New</option>
                            <option value="contacted">Contacted</option>
                            <option value="qualified">Qualified</option>
                            <option value="proposal">Proposal</option>
                            <option value="negotiation">Negotiation</option>
                            <option value="converted">Converted</option>
                            <option value="lost">Lost</option>
                        </select>
                        <button class="button" id="applyStatusChange">Apply</button>
                    </div>
                </div>
            </div>

            <div class="lead-notes-section">
                <h2>Notes & History</h2>
                <div class="notes-list" id="notesList">
                    <?php 
                    $notes_array = get_post_meta($lead_id, 'lead_notes', true);
                    if (is_array($notes_array)) {
                        foreach (array_reverse($notes_array) as $note) : 
                    ?>
                        <div class="note-item">
                            <div class="note-content"><?php echo esc_html($note['content']); ?></div>
                            <div class="note-meta">
                                <span class="note-date"><?php echo esc_html($note['date']); ?></span>
                            </div>
                        </div>
                    <?php 
                        endforeach;
                    }
                    ?>
                </div>
                <form id="addNoteForm" class="add-note-form">
                    <textarea id="newNoteContent" placeholder="Add a note..." rows="3"></textarea>
                    <button type="submit" class="button button-primary"><i class="fas fa-plus"></i> Add Note</button>
                </form>
            </div>
        </div>
        <?php
    }

    public function render_settings_page() {
        $agents = get_posts(array('post_type' => 'agent', 'posts_per_page' => -1));
        ?>
        <div class="wrap cps-crm-settings">
            <h1>CRM Settings</h1>
            <form method="post" action="options.php">
                <?php settings_fields('cps_crm_settings'); ?>
                <table class="form-table">
                    <tr>
                        <th scope="row">Lead Notification Email</th>
                        <td>
                            <input type="email" name="cps_crm_notification_email" value="<?php echo esc_attr(get_option('cps_crm_notification_email', get_option('admin_email'))); ?>" class="regular-text">
                            <p class="description">Email to receive new lead notifications</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Auto-assign Leads</th>
                        <td>
                            <input type="checkbox" name="cps_crm_auto_assign" value="1" <?php checked(get_option('cps_crm_auto_assign'), 1); ?>>
                            <label>Auto-assign new leads to agents</label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Default Assignee</th>
                        <td>
                            <select name="cps_crm_default_agent">
                                <option value="">No default</option>
                                <?php foreach ($agents as $agent) : ?>
                                    <option value="<?php echo esc_attr($agent->ID); ?>" <?php selected(get_option('cps_crm_default_agent'), $agent->ID); ?>>
                                        <?php echo esc_html($agent->post_title); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <p class="description">Assign new leads to this agent by default</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Email Notifications</th>
                        <td>
                            <input type="checkbox" name="cps_crm_notify_new_lead" value="1" <?php checked(get_option('cps_crm_notify_new_lead'), 1); ?>>
                            <label>Notify on new lead</label><br>
                            <input type="checkbox" name="cps_crm_notify_status_change" value="1" <?php checked(get_option('cps_crm_notify_status_change'), 1); ?>>
                            <label>Notify on status change</label><br>
                            <input type="checkbox" name="cps_crm_notify_followup" value="1" <?php checked(get_option('cps_crm_notify_followup'), 1); ?>>
                            <label>Notify on follow-up reminders</label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Follow-up Reminder Days</th>
                        <td>
                            <input type="number" name="cps_crm_followup_days" value="<?php echo esc_attr(get_option('cps_crm_followup_days', 3)); ?>" class="small-text" min="1" max="30">
                            <p class="description">Days before sending follow-up reminder (default: 3)</p>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    public function register_crm_settings() {
        register_setting('cps_crm_settings', 'cps_crm_notification_email');
        register_setting('cps_crm_settings', 'cps_crm_auto_assign');
        register_setting('cps_crm_settings', 'cps_crm_default_agent');
        register_setting('cps_crm_settings', 'cps_crm_notify_new_lead');
        register_setting('cps_crm_settings', 'cps_crm_notify_status_change');
        register_setting('cps_crm_settings', 'cps_crm_notify_followup');
        register_setting('cps_crm_settings', 'cps_crm_followup_days');
    }

    public function assign_lead() {
        check_ajax_referer('cps_crm_nonce', 'nonce');

        $lead_id = intval($_POST['lead_id']);
        $agent_id = intval($_POST['agent_id']);

        update_post_meta($lead_id, 'assigned_agent', $agent_id);
        update_post_meta($lead_id, 'assigned_date', current_time('Y-m-d H:i:s'));

        $agent = get_post($agent_id);
        $agent_name = $agent ? $agent->post_title : 'Unknown';

        $this->add_lead_activity($lead_id, 'assigned', 'Lead assigned to ' . $agent_name);

        wp_send_json_success(array('message' => 'Lead assigned to ' . $agent_name));
    }

    public function schedule_followup() {
        check_ajax_referer('cps_crm_nonce', 'nonce');

        $lead_id = intval($_POST['lead_id']);
        $followup_date = sanitize_text_field($_POST['followup_date']);
        $followup_note = sanitize_textarea_field($_POST['followup_note']);

        update_post_meta($lead_id, 'followup_date', $followup_date);
        
        $followups = get_post_meta($lead_id, 'scheduled_followups', true) ?: array();
        $followups[] = array(
            'date' => $followup_date,
            'note' => $followup_note,
            'created' => current_time('Y-m-d H:i:s'),
        );
        update_post_meta($lead_id, 'scheduled_followups', $followups);

        $this->add_lead_activity($lead_id, 'followup_scheduled', 'Follow-up scheduled for ' . date('M j, Y', strtotime($followup_date)));

        wp_send_json_success(array('message' => 'Follow-up scheduled'));
    }

    public function merge_leads() {
        check_ajax_referer('cps_crm_nonce', 'nonce');

        $keep_id = intval($_POST['keep_id']);
        $merge_id = intval($_POST['merge_id']);

        $merge_fields = array('email', 'phone', 'message', 'property_id', 'inquiry_type', 'source', 'assigned_agent');
        foreach ($merge_fields as $field) {
            $keep_value = get_post_meta($keep_id, $field, true);
            $merge_value = get_post_meta($merge_id, $field, true);
            if (empty($keep_value) && !empty($merge_value)) {
                update_post_meta($keep_id, $field, $merge_value);
            }
        }

        $keep_notes = get_post_meta($keep_id, 'lead_notes', true) ?: array();
        $merge_notes = get_post_meta($merge_id, 'lead_notes', true) ?: array();
        $all_notes = array_merge($keep_notes, $merge_notes);
        update_post_meta($keep_id, 'lead_notes', $all_notes);

        $this->add_lead_activity($keep_id, 'merged', 'Merged with lead ID ' . $merge_id);

        wp_delete_post($merge_id, true);

        wp_send_json_success(array('message' => 'Leads merged successfully'));
    }

    private function add_lead_activity($lead_id, $type, $description) {
        $activities = get_post_meta($lead_id, 'lead_activities', true) ?: array();
        $activities[] = array(
            'type' => $type,
            'description' => $description,
            'date' => current_time('Y-m-d H:i:s'),
            'user' => get_current_user_id(),
        );
        update_post_meta($lead_id, 'lead_activities', $activities);
    }

    public function check_followup_reminders() {
        if (!wp_doing_cron()) return;

        $followup_days = get_option('cps_crm_followup_days', 3);
        $notify_email = get_option('cps_crm_notification_email', get_option('admin_email'));
        $send_notification = get_option('cps_crm_notify_followup', 1);

        if (!$send_notification) return;

        $leads = get_posts(array(
            'post_type' => 'cps_lead',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => 'followup_date',
                    'value' => date('Y-m-d', strtotime('+' . $followup_days . ' days')),
                    'compare' => '<=',
                ),
                array(
                    'key' => 'followup_reminder_sent',
                    'compare' => 'NOT EXISTS',
                ),
            ),
        ));

        foreach ($leads as $lead) {
            $followup_date = get_post_meta($lead->ID, 'followup_date', true);
            $status = get_post_meta($lead->ID, 'status', true);

            if ($status === 'converted' || $status === 'lost') {
                update_post_meta($lead->ID, 'followup_reminder_sent', 1);
                continue;
            }

            $subject = sprintf('[CariPropShop CRM] Follow-up Reminder: %s', $lead->post_title);
            $message = sprintf(
                "Follow-up reminder for lead:\n\nName: %s\nEmail: %s\nPhone: %s\nStatus: %s\nFollow-up Date: %s\n\nView lead: %s",
                $lead->post_title,
                get_post_meta($lead->ID, 'email', true),
                get_post_meta($lead->ID, 'phone', true),
                ucfirst($status),
                date('F j, Y', strtotime($followup_date)),
                admin_url('admin.php?page=cps-leads&action=view&id=' . $lead->ID)
            );

            wp_mail($notify_email, $subject, $message);
            update_post_meta($lead->ID, 'followup_reminder_sent', 1);
        }
    }

    private function send_lead_notification($lead_id, $type = 'new') {
        $notify_email = get_option('cps_crm_notification_email', get_option('admin_email'));
        $send_notification = get_option('cps_crm_notify_new_lead', 1);

        if (!$send_notification && $type === 'new') return;

        $lead = get_post($lead_id);
        $subject = sprintf('[CariPropShop CRM] New Lead: %s', $lead->post_title);
        $message = sprintf(
            "New lead received:\n\nName: %s\nEmail: %s\nPhone: %s\nProperty: %s\nInquiry Type: %s\nMessage: %s\n\nView lead: %s",
            $lead->post_title,
            get_post_meta($lead->ID, 'email', true),
            get_post_meta($lead->ID, 'phone', true),
            get_the_title(get_post_meta($lead->ID, 'property_id', true)),
            ucfirst(get_post_meta($lead->ID, 'inquiry_type', true)),
            get_post_meta($lead->ID, 'message', true),
            admin_url('admin.php?page=cps-leads&action=view&id=' . $lead->ID)
        );

        wp_mail($notify_email, $subject, $message);
    }

    private function get_dashboard_stats() {
        $args = array(
            'post_type' => 'cps_lead',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        );
        
        $leads = get_posts($args);
        $total = count($leads);
        
        $week_ago = date('Y-m-d', strtotime('-7 days'));
        $new_this_week = 0;
        $statuses = array('new' => 0, 'contacted' => 0, 'qualified' => 0, 'proposal' => 0, 'negotiation' => 0, 'converted' => 0, 'lost' => 0);
        
        foreach ($leads as $lead) {
            $status = get_post_meta($lead->ID, 'status', true) ?: 'new';
            if (!isset($statuses[$status])) $status = 'new';
            $statuses[$status]++;
            
            if (get_the_date('Y-m-d', $lead->ID) >= $week_ago) {
                $new_this_week++;
            }
        }
        
        return array(
            'total_leads' => $total,
            'new_leads' => $new_this_week,
            'contacted' => $statuses['contacted'],
            'qualified' => $statuses['qualified'],
            'converted' => $statuses['converted'],
            'statuses' => $statuses,
        );
    }

    private function get_recent_leads($limit = 5) {
        return get_posts(array(
            'post_type' => 'cps_lead',
            'posts_per_page' => $limit,
            'orderby' => 'date',
            'order' => 'DESC',
        ));
    }

    private function get_leads_by_status() {
        $args = array(
            'post_type' => 'cps_lead',
            'posts_per_page' => -1,
        );
        
        $leads = get_posts($args);
        $statuses = array('new' => 0, 'contacted' => 0, 'qualified' => 0, 'proposal' => 0, 'negotiation' => 0, 'converted' => 0, 'lost' => 0);
        
        foreach ($leads as $lead) {
            $status = get_post_meta($lead->ID, 'status', true) ?: 'new';
            if (isset($statuses[$status])) {
                $statuses[$status]++;
            }
        }
        
        return $statuses;
    }

    private function get_all_leads() {
        return get_posts(array(
            'post_type' => 'cps_lead',
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC',
        ));
    }

    public function save_lead() {
        check_ajax_referer('cps_crm_nonce', 'nonce');

        $lead_id = isset($_POST['lead_id']) && !empty($_POST['lead_id']) ? intval($_POST['lead_id']) : 0;
        $is_new = $lead_id === 0;
        
        $lead_data = array(
            'post_type' => 'cps_lead',
            'post_title' => sanitize_text_field($_POST['name']),
            'post_status' => 'publish',
        );

        if ($lead_id > 0) {
            $lead_data['ID'] = $lead_id;
            wp_update_post($lead_data);
        } else {
            $lead_id = wp_insert_post($lead_data);
        }

        if ($lead_id && !is_wp_error($lead_id)) {
            update_post_meta($lead_id, 'email', sanitize_email($_POST['email']));
            update_post_meta($lead_id, 'phone', sanitize_text_field($_POST['phone']));
            update_post_meta($lead_id, 'status', sanitize_text_field($_POST['status'] ?? 'new'));
            update_post_meta($lead_id, 'property_id', intval($_POST['property_id'] ?? 0));
            update_post_meta($lead_id, 'inquiry_type', sanitize_text_field($_POST['inquiry_type'] ?? ''));
            update_post_meta($lead_id, 'message', sanitize_textarea_field($_POST['message'] ?? ''));
            update_post_meta($lead_id, 'source', sanitize_text_field($_POST['source'] ?? 'website'));

            if ($is_new && get_option('cps_crm_auto_assign') && get_option('cps_crm_default_agent')) {
                update_post_meta($lead_id, 'assigned_agent', get_option('cps_crm_default_agent'));
                update_post_meta($lead_id, 'assigned_date', current_time('Y-m-d H:i:s'));
            }

            if ($is_new) {
                $this->send_lead_notification($lead_id, 'new');
                $this->add_lead_activity($lead_id, 'created', 'Lead created');
            }

            wp_send_json_success(array('lead_id' => $lead_id, 'message' => 'Lead saved successfully'));
        }

        wp_send_json_error(array('message' => 'Failed to save lead'));
    }

    public function update_lead_status() {
        check_ajax_referer('cps_crm_nonce', 'nonce');

        $lead_id = intval($_POST['lead_id']);
        $status = sanitize_text_field($_POST['status']);
        $old_status = get_post_meta($lead_id, 'status', true);

        update_post_meta($lead_id, 'status', $status);

        if ($old_status !== $status) {
            $this->add_lead_activity($lead_id, 'status_changed', 'Status changed from ' . ucfirst($old_status) . ' to ' . ucfirst($status));
        }

        wp_send_json_success(array('message' => 'Status updated'));
    }

    public function delete_lead() {
        check_ajax_referer('cps_crm_nonce', 'nonce');

        $lead_id = intval($_POST['lead_id']);
        wp_delete_post($lead_id, true);

        wp_send_json_success(array('message' => 'Lead deleted'));
    }

    public function get_lead_details() {
        check_ajax_referer('cps_crm_nonce', 'nonce');

        $lead_id = intval($_POST['lead_id']);
        $lead = get_post($lead_id);

        if ($lead) {
            $details = array(
                'id' => $lead->ID,
                'name' => $lead->post_title,
                'email' => get_post_meta($lead_id, 'email', true),
                'phone' => get_post_meta($lead_id, 'phone', true),
                'status' => get_post_meta($lead_id, 'status', true) ?: 'new',
                'property_id' => get_post_meta($lead_id, 'property_id', true),
                'inquiry_type' => get_post_meta($lead_id, 'inquiry_type', true),
                'message' => get_post_meta($lead_id, 'message', true),
                'source' => get_post_meta($lead_id, 'source', true),
            );

            wp_send_json_success($details);
        }

        wp_send_json_error(array('message' => 'Lead not found'));
    }

    public function add_lead_note() {
        check_ajax_referer('cps_crm_nonce', 'nonce');

        $lead_id = intval($_POST['lead_id']);
        $note_content = sanitize_textarea_field($_POST['note']);

        $notes = get_post_meta($lead_id, 'lead_notes', true) ?: array();
        $notes[] = array(
            'content' => $note_content,
            'date' => current_time('Y-m-d H:i:s'),
        );

        update_post_meta($lead_id, 'lead_notes', $notes);

        wp_send_json_success(array('message' => 'Note added'));
    }

    public function export_leads() {
        check_ajax_referer('cps_crm_nonce', 'nonce');

        $leads = $this->get_all_leads();
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="leads-export-' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Name', 'Email', 'Phone', 'Property', 'Status', 'Source', 'Date'));
        
        foreach ($leads as $lead) {
            fputcsv($output, array(
                $lead->post_title,
                get_post_meta($lead->ID, 'email', true),
                get_post_meta($lead->ID, 'phone', true),
                get_the_title(get_post_meta($lead->ID, 'property_id', true)),
                get_post_meta($lead->ID, 'status', true) ?: 'new',
                get_post_meta($lead->ID, 'source', true) ?: 'website',
                get_the_date('Y-m-d', $lead->ID),
            ));
        }
        
        fclose($output);
        exit;
    }

    public function save_favorite() {
        check_ajax_referer('cps_nonce', 'nonce');

        $property_id = intval($_POST['property_id']);
        $user_id = get_current_user_id();

        $existing = get_posts(array(
            'post_type' => 'cps_favorite',
            'meta_query' => array(
                array('key' => 'property_id', 'value' => $property_id),
                array('key' => 'user_id', 'value' => $user_id),
            ),
        ));

        if (empty($existing)) {
            $favorite_id = wp_insert_post(array(
                'post_type' => 'cps_favorite',
                'post_title' => 'Favorite: ' . get_the_title($property_id),
                'post_status' => 'publish',
            ));

            update_post_meta($favorite_id, 'property_id', $property_id);
            update_post_meta($favorite_id, 'user_id', $user_id);

            wp_send_json_success(array('message' => 'Added to favorites'));
        }

        wp_send_json_error(array('message' => 'Already in favorites'));
    }

    public function remove_favorite() {
        check_ajax_referer('cps_nonce', 'nonce');

        $property_id = intval($_POST['property_id']);
        $user_id = get_current_user_id();

        $favorites = get_posts(array(
            'post_type' => 'cps_favorite',
            'meta_query' => array(
                array('key' => 'property_id', 'value' => $property_id),
                array('key' => 'user_id', 'value' => $user_id),
            ),
        ));

        foreach ($favorites as $fav) {
            wp_delete_post($fav->ID, true);
        }

        wp_send_json_success(array('message' => 'Removed from favorites'));
    }
}

add_action('plugins_loaded', array('CariPropShop_CRM', 'get_instance'));
