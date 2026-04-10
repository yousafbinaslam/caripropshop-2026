<div class="wrap cps-forms-admin">
    <h1><?php _e('Form Submissions', 'cari-prop-shop-forms'); ?>
        <a href="<?php echo admin_url('admin.php?page=cps-form-submissions&action=export'); ?>" class="page-title-action"><?php _e('Export CSV', 'cari-prop-shop-forms'); ?></a>
    </h1>
    
    <?php
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    
    if ($action === 'export') {
        $this->handle_export();
    }
    
    $storage = CPS_Form_Storage::get_instance();
    
    $form_type = isset($_GET['form_type']) ? sanitize_text_field($_GET['form_type']) : '';
    $status = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : '';
    $paged = isset($_GET['paged']) ? absint($_GET['paged']) : 1;
    
    $per_page = 20;
    $submissions = $storage->get_submissions(array(
        'form_type' => $form_type,
        'status' => $status,
        'per_page' => $per_page,
        'page' => $paged,
    ));
    
    $total = $storage->get_submissions_count(array(
        'form_type' => $form_type,
        'status' => $status,
    ));
    
    $total_pages = ceil($total / $per_page);
    ?>
    
    <form method="get" action="<?php echo admin_url('admin.php'); ?>">
        <input type="hidden" name="page" value="cps-form-submissions">
        
        <div class="tablenav top">
            <div class="alignleft actions">
                <select name="form_type">
                    <option value=""><?php _e('All Form Types', 'cari-prop-shop-forms'); ?></option>
                    <?php
                    $form_types = $storage->get_form_types();
                    foreach ($form_types as $type) {
                        echo '<option value="' . esc_attr($type->form_type) . '" ' . selected($form_type, $type->form_type, false) . '>' . esc_html(ucfirst(str_replace('_', ' ', $type->form_type))) . '</option>';
                    }
                    ?>
                </select>
                
                <select name="status">
                    <option value=""><?php _e('All Statuses', 'cari-prop-shop-forms'); ?></option>
                    <?php
                    $statuses = $storage->get_statuses();
                    foreach ($statuses as $s) {
                        echo '<option value="' . esc_attr($s) . '" ' . selected($status, $s, false) . '>' . esc_html(ucfirst($s)) . '</option>';
                    }
                    ?>
                </select>
                
                <input type="submit" class="button" value="<?php _e('Filter', 'cari-prop-shop-forms'); ?>">
            </div>
        </div>
        
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th class="column-primary"><?php _e('ID', 'cari-prop-shop-forms'); ?></th>
                    <th><?php _e('Form Type', 'cari-prop-shop-forms'); ?></th>
                    <th><?php _e('Name', 'cari-prop-shop-forms'); ?></th>
                    <th><?php _e('Email', 'cari-prop-shop-forms'); ?></th>
                    <th><?php _e('Date', 'cari-prop-shop-forms'); ?></th>
                    <th><?php _e('Status', 'cari-prop-shop-forms'); ?></th>
                    <th><?php _e('Actions', 'cari-prop-shop-forms'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($submissions)) : ?>
                    <tr>
                        <td colspan="7"><?php _e('No submissions found.', 'cari-prop-shop-forms'); ?></td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($submissions as $submission) : ?>
                        <?php
                        $data = maybe_unserialize($submission->form_data);
                        $name = '';
                        if (!empty($data['first_name']) || !empty($data['last_name'])) {
                            $name = trim($data['first_name'] . ' ' . $data['last_name']);
                        }
                        $email = isset($data['email']) ? $data['email'] : '';
                        ?>
                        <tr>
                            <td><?php echo esc_html($submission->id); ?></td>
                            <td><?php echo esc_html(ucfirst(str_replace('_', ' ', $submission->form_type))); ?></td>
                            <td><?php echo esc_html($name); ?></td>
                            <td><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></td>
                            <td><?php echo esc_html(date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($submission->submission_date))); ?></td>
                            <td>
                                <span class="cps-status cps-status-<?php echo esc_attr($submission->status); ?>">
                                    <?php echo esc_html(ucfirst($submission->status)); ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=cps-form-submissions&action=view&submission_id=' . $submission->id); ?>" class="button button-small"><?php _e('View', 'cari-prop-shop-forms'); ?></a>
                                <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=cps-form-submissions&action=delete&submission_id=' . $submission->id), 'cps_delete_submission_' . $submission->id); ?>" class="button button-small" onclick="return confirm('<?php _e('Are you sure you want to delete this submission?', 'cari-prop-shop-forms'); ?>');"><?php _e('Delete', 'cari-prop-shop-forms'); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        
        <div class="tablenav bottom">
            <?php
            $page_links = paginate_links(array(
                'base' => add_query_arg('paged', '%#%'),
                'format' => '',
                'prev_text' => __('&laquo;'),
                'next_text' => __('&raquo;'),
                'total' => $total_pages,
                'current' => $paged,
            ));
            
            if ($page_links) {
                echo '<div class="tablenav-pages">' . $page_links . '</div>';
            }
            ?>
        </div>
    </form>
</div>

<?php
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['submission_id'])) {
    check_admin_referer('cps_delete_submission_' . $_GET['submission_id']);
    
    $id = absint($_GET['submission_id']);
    $storage->delete_submission($id);
    
    wp_redirect(remove_query_arg(array('action', 'submission_id', '_wpnonce')));
    exit;
}

function handle_export() {
    $storage = CPS_Form_Storage::get_instance();
    $csv_data = $storage->export_to_csv();
    
    if (empty($csv_data)) {
        return;
    }
    
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="form-submissions-' . date('Y-m-d') . '.csv"');
    
    $output = fopen('php://output', 'w');
    
    foreach ($csv_data as $row) {
        fputcsv($output, $row);
    }
    
    fclose($output);
    exit;
}
?>