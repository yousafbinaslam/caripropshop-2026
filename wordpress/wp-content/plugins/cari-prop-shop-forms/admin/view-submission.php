<div class="wrap cps-forms-admin">
    <?php
    $submission_id = isset($_GET['submission_id']) ? absint($_GET['submission_id']) : 0;
    $storage = CPS_Form_Storage::get_instance();
    $submission = $storage->get_submission($submission_id);

    if (!$submission) {
        echo '<div class="error"><p>' . __('Submission not found.', 'cari-prop-shop-forms') . '</p></div>';
        return;
    }

    if ($submission->status === 'new') {
        $storage->update_submission_status($submission_id, 'read');
    }

    $data = maybe_unserialize($submission->form_data);
    ?>
    
    <h1><?php _e('Submission Details', 'cari-prop-shop-forms'); ?>
        <a href="<?php echo admin_url('admin.php?page=cps-form-submissions'); ?>" class="button button-secondary"><?php _e('Back to Submissions', 'cari-prop-shop-forms'); ?></a>
    </h1>
    
    <div class="cps-submission-header">
        <div class="cps-submission-meta">
            <p><strong><?php _e('Submission ID:', 'cari-prop-shop-forms'); ?></strong> <?php echo esc_html($submission->id); ?></p>
            <p><strong><?php _e('Form Type:', 'cari-prop-shop-forms'); ?></strong> <?php echo esc_html(ucfirst(str_replace('_', ' ', $submission->form_type))); ?></p>
            <p><strong><?php _e('Date:', 'cari-prop-shop-forms'); ?></strong> <?php echo esc_html(date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($submission->submission_date))); ?></p>
            <p><strong><?php _e('Status:', 'cari-prop-shop-forms'); ?></strong> 
                <span class="cps-status cps-status-<?php echo esc_attr($submission->status); ?>">
                    <?php echo esc_html(ucfirst($submission->status)); ?>
                </span>
            </p>
        </div>
        
        <div class="cps-submission-actions">
            <form method="post" action="">
                <?php wp_nonce_field('cps_update_status_' . $submission_id); ?>
                <input type="hidden" name="submission_id" value="<?php echo esc_attr($submission_id); ?>">
                <select name="status">
                    <?php
                    $statuses = $storage->get_statuses();
                    foreach ($statuses as $s) {
                        echo '<option value="' . esc_attr($s) . '" ' . selected($submission->status, $s, false) . '>' . esc_html(ucfirst($s)) . '</option>';
                    }
                    ?>
                </select>
                <input type="submit" name="update_status" class="button button-primary" value="<?php _e('Update Status', 'cari-prop-shop-forms'); ?>">
            </form>
        </div>
    </div>
    
    <div class="cps-submission-data">
        <h2><?php _e('Submission Data', 'cari-prop-shop-forms'); ?></h2>
        
        <table class="widefat fixed striped">
            <tbody>
                <?php foreach ($data as $key => $value) : ?>
                    <?php
                    if (is_array($value)) {
                        $value = implode(', ', $value);
                    }
                    $label = ucwords(str_replace('_', ' ', $key));
                    ?>
                    <tr>
                        <th scope="row"><?php echo esc_html($label); ?></th>
                        <td><?php echo esc_html($value); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div class="cps-submission-technical">
        <h2><?php _e('Technical Details', 'cari-prop-shop-forms'); ?></h2>
        <table class="widefat fixed striped">
            <tbody>
                <tr>
                    <th scope="row"><?php _e('IP Address', 'cari-prop-shop-forms'); ?></th>
                    <td><?php echo esc_html($submission->ip_address); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('User Agent', 'cari-prop-shop-forms'); ?></th>
                    <td><?php echo esc_html($submission->user_agent); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <?php
    if (isset($_POST['update_status']) && check_admin_referer('cps_update_status_' . $submission_id)) {
        $new_status = sanitize_text_field($_POST['status']);
        $storage->update_submission_status($submission_id, $new_status);
        wp_redirect(add_query_arg('submission_id', $submission_id, admin_url('admin.php?page=cps-form-submissions&action=view')));
        exit;
    }
    ?>
</div>