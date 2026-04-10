<div class="cps-form-wrapper cps-contact-form">
    <h2 class="cps-form-title"><?php echo esc_html($atts['title']); ?></h2>
    
    <form class="cps-form" data-form-type="contact">
        <?php if ($atts['show_name']) : ?>
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
        <?php endif; ?>
        
        <div class="cps-form-row">
            <div class="cps-form-group">
                <label for="cps_email"><?php _e('Email', 'cari-prop-shop-forms'); ?> <span class="required">*</span></label>
                <input type="email" id="cps_email" name="email" class="cps-input" required>
            </div>
        </div>
        
        <?php if ($atts['show_phone']) : ?>
        <div class="cps-form-row">
            <div class="cps-form-group">
                <label for="cps_phone"><?php _e('Phone', 'cari-prop-shop-forms'); ?></label>
                <input type="tel" id="cps_phone" name="phone" class="cps-input">
            </div>
        </div>
        <?php endif; ?>
        
        <?php if ($atts['show_subject']) : ?>
        <div class="cps-form-row">
            <div class="cps-form-group">
                <label for="cps_subject"><?php _e('Subject', 'cari-prop-shop-forms'); ?></label>
                <input type="text" id="cps_subject" name="subject" class="cps-input">
            </div>
        </div>
        <?php endif; ?>
        
        <?php if ($atts['show_message']) : ?>
        <div class="cps-form-row">
            <div class="cps-form-group">
                <label for="cps_message"><?php _e('Message', 'cari-prop-shop-forms'); ?> <span class="required">*</span></label>
                <textarea id="cps_message" name="message" class="cps-textarea" rows="5" required></textarea>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="cps-form-row">
            <button type="submit" class="cps-submit-btn"><?php echo esc_html($atts['submit_text']); ?></button>
        </div>
        
        <div class="cps-form-message"></div>
    </form>
</div>