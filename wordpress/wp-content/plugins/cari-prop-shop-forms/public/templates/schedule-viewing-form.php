<div class="cps-form-wrapper cps-schedule-viewing-form">
    <h2 class="cps-form-title"><?php echo esc_html($atts['title']); ?></h2>
    
    <form class="cps-form" data-form-type="schedule_viewing">
        <?php if (!empty($atts['property_id'])) : ?>
        <input type="hidden" name="property_id" value="<?php echo esc_attr($atts['property_id']); ?>">
        <?php endif; ?>
        
        <div class="cps-form-row cps-form-row-half">
            <div class="cps-form-group">
                <label for="cps_first_name"><?php _e('First Name', 'cari-prop-shop-forms'); ?> <span class="required">*</span></label>
                <input type="text" id="cps_first_name" name="first_name" class="cps-input" required>
            </div>
            <div class="cps-form-group">
                <label for="cps_last_name"><?php _e('Last Name', 'cari-prop-shop-forms'); ?> <span class="required">*</span></label>
                <input type="text" id="cps_last_name" name="last_name" class="cps-input" required>
            </div>
        </div>
        
        <div class="cps-form-row">
            <div class="cps-form-group">
                <label for="cps_email"><?php _e('Email', 'cari-prop-shop-forms'); ?> <span class="required">*</span></label>
                <input type="email" id="cps_email" name="email" class="cps-input" required>
            </div>
        </div>
        
        <div class="cps-form-row">
            <div class="cps-form-group">
                <label for="cps_phone"><?php _e('Phone', 'cari-prop-shop-forms'); ?> <span class="required">*</span></label>
                <input type="tel" id="cps_phone" name="phone" class="cps-input" required>
            </div>
        </div>
        
        <div class="cps-form-row cps-form-row-half">
            <div class="cps-form-group">
                <label for="cps_preferred_date"><?php _e('Preferred Date', 'cari-prop-shop-forms'); ?> <span class="required">*</span></label>
                <input type="date" id="cps_preferred_date" name="preferred_date" class="cps-input" required>
            </div>
            <div class="cps-form-group">
                <label for="cps_preferred_time"><?php _e('Preferred Time', 'cari-prop-shop-forms'); ?> <span class="required">*</span></label>
                <select id="cps_preferred_time" name="preferred_time" class="cps-select" required>
                    <option value=""><?php _e('Select time', 'cari-prop-shop-forms'); ?></option>
                    <option value="morning"><?php _e('Morning (9am - 12pm)', 'cari-prop-shop-forms'); ?></option>
                    <option value="afternoon"><?php _e('Afternoon (12pm - 5pm)', 'cari-prop-shop-forms'); ?></option>
                    <option value="evening"><?php _e('Evening (5pm - 8pm)', 'cari-prop-shop-forms'); ?></option>
                </select>
            </div>
        </div>
        
        <div class="cps-form-row">
            <div class="cps-form-group">
                <label for="cps_message"><?php _e('Additional Notes', 'cari-prop-shop-forms'); ?></label>
                <textarea id="cps_message" name="message" class="cps-textarea" rows="4"></textarea>
            </div>
        </div>
        
        <div class="cps-form-row">
            <button type="submit" class="cps-submit-btn"><?php echo esc_html($atts['submit_text']); ?></button>
        </div>
        
        <div class="cps-form-message"></div>
    </form>
</div>