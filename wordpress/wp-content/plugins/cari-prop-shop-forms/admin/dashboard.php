<div class="wrap cps-forms-admin">
    <h1><?php _e('CariPropShop Forms', 'cari-prop-shop-forms'); ?></h1>
    
    <div class="cps-forms-stats">
        <?php
        $storage = CPS_Form_Storage::get_instance();
        $total_submissions = $storage->get_submissions_count();
        $new_submissions = $storage->get_submissions_count(array('status' => 'new'));
        $form_types = $storage->get_form_types();
        ?>
        
        <div class="cps-stat-card">
            <div class="cps-stat-number"><?php echo esc_html($total_submissions); ?></div>
            <div class="cps-stat-label"><?php _e('Total Submissions', 'cari-prop-shop-forms'); ?></div>
        </div>
        
        <div class="cps-stat-card cps-stat-new">
            <div class="cps-stat-number"><?php echo esc_html($new_submissions); ?></div>
            <div class="cps-stat-label"><?php _e('New', 'cari-prop-shop-forms'); ?></div>
        </div>
        
        <div class="cps-stat-card">
            <div class="cps-stat-number"><?php echo count($form_types); ?></div>
            <div class="cps-stat-label"><?php _e('Form Types', 'cari-prop-shop-forms'); ?></div>
        </div>
    </div>
    
    <div class="cps-forms-cards">
        <div class="cps-forms-card">
            <h2><?php _e('Shortcodes', 'cari-prop-shop-forms'); ?></h2>
            <p><?php _e('Use these shortcodes to display forms on your site:', 'cari-prop-shop-forms'); ?></p>
            <ul class="cps-shortcode-list">
                <li><code>[cps_contact_form]</code> - <?php _e('Contact Form', 'cari-prop-shop-forms'); ?></li>
                <li><code>[cps_property_inquiry]</code> - <?php _e('Property Inquiry Form', 'cari-prop-shop-forms'); ?></li>
                <li><code>[cps_inquiry_form]</code> - <?php _e('General Inquiry Form', 'cari-prop-shop-forms'); ?></li>
                <li><code>[cps_schedule_viewing]</code> - <?php _e('Schedule Viewing Form', 'cari-prop-shop-forms'); ?></li>
                <li><code>[cps_mortgage_calculator]</code> - <?php _e('Mortgage Calculator Form', 'cari-prop-shop-forms'); ?></li>
            </ul>
        </div>
        
        <div class="cps-forms-card">
            <h2><?php _e('Quick Links', 'cari-prop-shop-forms'); ?></h2>
            <ul>
                <li><a href="<?php echo admin_url('admin.php?page=cps-form-submissions'); ?>" class="button button-primary"><?php _e('View Submissions', 'cari-prop-shop-forms'); ?></a></li>
                <li><a href="<?php echo admin_url('admin.php?page=cps-form-settings'); ?>" class="button"><?php _e('Settings', 'cari-prop-shop-forms'); ?></a></li>
            </ul>
        </div>
    </div>
</div>