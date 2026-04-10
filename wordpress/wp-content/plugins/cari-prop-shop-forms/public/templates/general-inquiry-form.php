<div class="cps-form-wrapper cps-general-inquiry-form">
    <h2 class="cps-form-title"><?php echo esc_html($atts['title']); ?></h2>
    
    <form class="cps-form" data-form-type="general_inquiry">
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
                <label for="cps_phone"><?php _e('Phone', 'cari-prop-shop-forms'); ?></label>
                <input type="tel" id="cps_phone" name="phone" class="cps-input">
            </div>
        </div>
        
        <div class="cps-form-row">
            <div class="cps-form-group">
                <label for="cps_inquiry_type"><?php _e('Inquiry Type', 'cari-prop-shop-forms'); ?> <span class="required">*</span></label>
                <select id="cps_inquiry_type" name="inquiry_type" class="cps-select" required>
                    <option value=""><?php _e('Select inquiry type', 'cari-prop-shop-forms'); ?></option>
                    <option value="general"><?php _e('General Question', 'cari-prop-shop-forms'); ?></option>
                    <option value="selling"><?php _e('Selling a Property', 'cari-prop-shop-forms'); ?></option>
                    <option value="buying"><?php _e('Buying a Property', 'cari-prop-shop-forms'); ?></option>
                    <option value="renting"><?php _e('Renting a Property', 'cari-prop-shop-forms'); ?></option>
                    <option value="partnership"><?php _e('Business Partnership', 'cari-prop-shop-forms'); ?></option>
                    <option value="other"><?php _e('Other', 'cari-prop-shop-forms'); ?></option>
                </select>
            </div>
        </div>
        
        <div class="cps-form-row">
            <div class="cps-form-group">
                <label for="cps_message"><?php _e('Message', 'cari-prop-shop-forms'); ?> <span class="required">*</span></label>
                <textarea id="cps_message" name="message" class="cps-textarea" rows="5" required></textarea>
            </div>
        </div>
        
        <div class="cps-form-row">
            <button type="submit" class="cps-submit-btn"><?php echo esc_html($atts['submit_text']); ?></button>
        </div>
        
        <div class="cps-form-message"></div>
    </form>
</div>