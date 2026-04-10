<div class="cps-form-wrapper cps-property-inquiry-form">
    <h2 class="cps-form-title"><?php echo esc_html($atts['title']); ?></h2>
    
    <form class="cps-form" data-form-type="property_inquiry">
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
        
        <div class="cps-form-row">
            <div class="cps-form-group">
                <label for="cps_inquiry_type"><?php _e('Inquiry Type', 'cari-prop-shop-forms'); ?> <span class="required">*</span></label>
                <select id="cps_inquiry_type" name="inquiry_type" class="cps-select" required>
                    <option value=""><?php _e('Select inquiry type', 'cari-prop-shop-forms'); ?></option>
                    <option value="buying"><?php _e('Interested in Buying', 'cari-prop-shop-forms'); ?></option>
                    <option value="renting"><?php _e('Interested in Renting', 'cari-prop-shop-forms'); ?></option>
                    <option value="information"><?php _e('Request More Information', 'cari-prop-shop-forms'); ?></option>
                    <option value="showing"><?php _e('Request a Showing', 'cari-prop-shop-forms'); ?></option>
                    <option value="other"><?php _e('Other', 'cari-prop-shop-forms'); ?></option>
                </select>
            </div>
        </div>
        
        <div class="cps-form-row">
            <div class="cps-form-group">
                <label for="cps_message"><?php _e('Message', 'cari-prop-shop-forms'); ?></label>
                <textarea id="cps_message" name="message" class="cps-textarea" rows="5"></textarea>
            </div>
        </div>
        
        <div class="cps-form-row">
            <button type="submit" class="cps-submit-btn"><?php echo esc_html($atts['submit_text']); ?></button>
        </div>
        
        <div class="cps-form-message"></div>
    </form>
</div>