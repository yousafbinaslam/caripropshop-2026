<div id="cps-cookie-banner" class="cps-cookie-banner cps-banner-<?php echo esc_attr($settings['position']); ?>" role="dialog" aria-labelledby="cps-cookie-title" aria-describedby="cps-cookie-description">
    <div class="cps-cookie-content">
        <h2 id="cps-cookie-title"><?php _e('Cookie Consent', 'cari-prop-shop-cookie'); ?></h2>
        <p id="cps-cookie-description">
            <?php echo esc_html(get_option('cps_cookie_banner_text', __('We use cookies to enhance your browsing experience, serve personalized content, and analyze our traffic. By clicking "Accept All", you consent to our use of cookies.', 'cari-prop-shop-cookie'))); ?>
            <?php if ($settings['privacyLink']): ?>
                <a href="<?php echo esc_url($settings['privacyLink']); ?>" target="_blank"><?php _e('Learn more', 'cari-prop-shop-cookie'); ?></a>
            <?php endif; ?>
        </p>
        
        <?php if (get_option('cps_cookie_show_category_toggles', '1')): ?>
        <div class="cps-cookie-categories">
            <div class="cps-category cps-category-necessary">
                <div class="cps-category-info">
                    <span class="cps-category-name"><?php _e('Necessary', 'cari-prop-shop-cookie'); ?></span>
                    <span class="cps-category-desc"><?php _e('Essential for the website to function properly', 'cari-prop-shop-cookie'); ?></span>
                </div>
                <div class="cps-category-toggle">
                    <input type="checkbox" checked disabled>
                    <span class="cps-toggle-slider"></span>
                </div>
            </div>
            <div class="cps-category cps-category-analytics">
                <div class="cps-category-info">
                    <span class="cps-category-name"><?php _e('Analytics', 'cari-prop-shop-cookie'); ?></span>
                    <span class="cps-category-desc"><?php _e('Help us understand how visitors interact with our website', 'cari-prop-shop-cookie'); ?></span>
                </div>
                <div class="cps-category-toggle">
                    <input type="checkbox" data-category="analytics">
                    <span class="cps-toggle-slider"></span>
                </div>
            </div>
            <div class="cps-category cps-category-marketing">
                <div class="cps-category-info">
                    <span class="cps-category-name"><?php _e('Marketing', 'cari-prop-shop-cookie'); ?></span>
                    <span class="cps-category-desc"><?php _e('Used to deliver personalized advertisements', 'cari-prop-shop-cookie'); ?></span>
                </div>
                <div class="cps-category-toggle">
                    <input type="checkbox" data-category="marketing">
                    <span class="cps-toggle-slider"></span>
                </div>
            </div>
            <div class="cps-category cps-category-functional">
                <div class="cps-category-info">
                    <span class="cps-category-name"><?php _e('Functional', 'cari-prop-shop-cookie'); ?></span>
                    <span class="cps-category-desc"><?php _e('Enable enhanced functionality and personalization', 'cari-prop-shop-cookie'); ?></span>
                </div>
                <div class="cps-category-toggle">
                    <input type="checkbox" data-category="functional">
                    <span class="cps-toggle-slider"></span>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="cps-cookie-buttons">
            <button type="button" class="cps-btn cps-btn-accept" id="cps-accept-all">
                <?php _e('Accept All', 'cari-prop-shop-cookie'); ?>
            </button>
            <?php if (get_option('cps_cookie_show_reject_all', '1')): ?>
            <button type="button" class="cps-btn cps-btn-reject" id="cps-reject-all">
                <?php _e('Reject All', 'cari-prop-shop-cookie'); ?>
            </button>
            <?php endif; ?>
            <button type="button" class="cps-btn cps-btn-settings" id="cps-show-settings">
                <?php _e('Customize', 'cari-prop-shop-cookie'); ?>
            </button>
        </div>
    </div>
</div>

<div id="cps-cookie-settings-modal" class="cps-cookie-modal">
    <div class="cps-cookie-modal-content">
        <div class="cps-cookie-modal-header">
            <h3><?php _e('Cookie Preferences', 'cari-prop-shop-cookie'); ?></h3>
            <button type="button" class="cps-modal-close" id="cps-close-settings">&times;</button>
        </div>
        <div class="cps-cookie-modal-body">
            <div class="cps-preference-category">
                <div class="cps-preference-header">
                    <div class="cps-preference-info">
                        <span class="cps-preference-name"><?php _e('Necessary', 'cari-prop-shop-cookie'); ?></span>
                        <span class="cps-preference-desc"><?php _e('These cookies are essential for the website to function properly and cannot be disabled.', 'cari-prop-shop-cookie'); ?></span>
                    </div>
                    <label class="cps-switch cps-switch-disabled">
                        <input type="checkbox" checked disabled>
                        <span class="cps-switch-slider"></span>
                    </label>
                </div>
            </div>
            <div class="cps-preference-category">
                <div class="cps-preference-header">
                    <div class="cps-preference-info">
                        <span class="cps-preference-name"><?php _e('Analytics Cookies', 'cari-prop-shop-cookie'); ?></span>
                        <span class="cps-preference-desc"><?php _e('These cookies help us understand how visitors interact with our website by collecting and reporting information anonymously.', 'cari-prop-shop-cookie'); ?></span>
                    </div>
                    <label class="cps-switch">
                        <input type="checkbox" id="cps-analytics-toggle">
                        <span class="cps-switch-slider"></span>
                    </label>
                </div>
            </div>
            <div class="cps-preference-category">
                <div class="cps-preference-header">
                    <div class="cps-preference-info">
                        <span class="cps-preference-name"><?php _e('Marketing Cookies', 'cari-prop-shop-cookie'); ?></span>
                        <span class="cps-preference-desc"><?php _e('These cookies are used to track visitors across websites to display relevant advertisements.', 'cari-prop-shop-cookie'); ?></span>
                    </div>
                    <label class="cps-switch">
                        <input type="checkbox" id="cps-marketing-toggle">
                        <span class="cps-switch-slider"></span>
                    </label>
                </div>
            </div>
            <div class="cps-preference-category">
                <div class="cps-preference-header">
                    <div class="cps-preference-info">
                        <span class="cps-preference-name"><?php _e('Functional Cookies', 'cari-prop-shop-cookie'); ?></span>
                        <span class="cps-preference-desc"><?php _e('These cookies enable enhanced functionality and personalization, such as remembering your preferences.', 'cari-prop-shop-cookie'); ?></span>
                    </div>
                    <label class="cps-switch">
                        <input type="checkbox" id="cps-functional-toggle">
                        <span class="cps-switch-slider"></span>
                    </label>
                </div>
            </div>
        </div>
        <div class="cps-cookie-modal-footer">
            <button type="button" class="cps-btn cps-btn-primary" id="cps-save-preferences">
                <?php _e('Save Preferences', 'cari-prop-shop-cookie'); ?>
            </button>
        </div>
    </div>
</div>

<a href="#" id="cps-cookie-settings-link" class="cps-settings-link" style="display: none;">
    <?php _e('Cookie Settings', 'cari-prop-shop-cookie'); ?>
</a>