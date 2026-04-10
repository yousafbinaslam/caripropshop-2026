<div class="wrap cps-forms-admin">
    <h1><?php _e('Form Settings', 'cari-prop-shop-forms'); ?></h1>
    
    <?php
    if (isset($_POST['cps_save_settings']) && check_admin_referer('cps_settings_nonce')) {
        $settings = array(
            'email_notifications' => array(
                'enable' => isset($_POST['email_notifications_enable']),
                'email_to' => sanitize_email($_POST['email_notifications_email_to']),
                'email_from' => sanitize_email($_POST['email_notifications_email_from']),
                'email_from_name' => sanitize_text_field($_POST['email_notifications_email_from_name']),
            ),
            'auto_responder' => array(
                'enable' => isset($_POST['auto_responder_enable']),
                'subject' => sanitize_text_field($_POST['auto_responder_subject']),
                'message' => wp_kses_post($_POST['auto_responder_message']),
            ),
            'recaptcha' => array(
                'enable' => isset($_POST['recaptcha_enable']),
                'site_key' => sanitize_text_field($_POST['recaptcha_site_key']),
                'secret_key' => sanitize_text_field($_POST['recaptcha_secret_key']),
            ),
            'form_styling' => array(
                'primary_color' => sanitize_hex_color($_POST['form_styling_primary_color']),
                'button_color' => sanitize_hex_color($_POST['form_styling_button_color']),
                'button_text_color' => sanitize_hex_color($_POST['form_styling_button_text_color']),
                'border_radius' => absint($_POST['form_styling_border_radius']),
            ),
        );
        
        update_option('cps_forms_settings', $settings);
        echo '<div class="notice notice-success"><p>' . __('Settings saved successfully.', 'cari-prop-shop-forms') . '</p></div>';
    }
    
    $settings = get_option('cps_forms_settings', array());
    ?>
    
    <form method="post" action="">
        <?php wp_nonce_field('cps_settings_nonce'); ?>
        
        <div class="cps-settings-tabs">
            <h2 class="nav-tab-wrapper">
                <a href="#email" class="nav-tab nav-tab-active"><?php _e('Email Notifications', 'cari-prop-shop-forms'); ?></a>
                <a href="#auto-responder" class="nav-tab"><?php _e('Auto Responder', 'cari-prop-shop-forms'); ?></a>
                <a href="#recaptcha" class="nav-tab"><?php _e('reCAPTCHA', 'cari-prop-shop-forms'); ?></a>
                <a href="#styling" class="nav-tab"><?php _e('Form Styling', 'cari-prop-shop-forms'); ?></a>
            </h2>
            
            <div id="email" class="cps-settings-panel">
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php _e('Enable Email Notifications', 'cari-prop-shop-forms'); ?></th>
                        <td>
                            <input type="checkbox" name="email_notifications_enable" id="email_notifications_enable" value="1" <?php checked(!empty($settings['email_notifications']['enable'])); ?>>
                            <label for="email_notifications_enable"><?php _e('Send email to admin when a new form is submitted', 'cari-prop-shop-forms'); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="email_notifications_email_to"><?php _e('Notification Email To', 'cari-prop-shop-forms'); ?></label></th>
                        <td>
                            <input type="email" name="email_notifications_email_to" id="email_notifications_email_to" value="<?php echo esc_attr(!empty($settings['email_notifications']['email_to']) ? $settings['email_notifications']['email_to'] : get_option('admin_email')); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="email_notifications_email_from"><?php _e('Email From Address', 'cari-prop-shop-forms'); ?></label></th>
                        <td>
                            <input type="email" name="email_notifications_email_from" id="email_notifications_email_from" value="<?php echo esc_attr(!empty($settings['email_notifications']['email_from']) ? $settings['email_notifications']['email_from'] : get_option('admin_email')); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="email_notifications_email_from_name"><?php _e('Email From Name', 'cari-prop-shop-forms'); ?></label></th>
                        <td>
                            <input type="text" name="email_notifications_email_from_name" id="email_notifications_email_from_name" value="<?php echo esc_attr(!empty($settings['email_notifications']['email_from_name']) ? $settings['email_notifications']['email_from_name'] : get_bloginfo('name')); ?>" class="regular-text">
                        </td>
                    </tr>
                </table>
            </div>
            
            <div id="auto-responder" class="cps-settings-panel" style="display:none;">
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php _e('Enable Auto Responder', 'cari-prop-shop-forms'); ?></th>
                        <td>
                            <input type="checkbox" name="auto_responder_enable" id="auto_responder_enable" value="1" <?php checked(!empty($settings['auto_responder']['enable'])); ?>>
                            <label for="auto_responder_enable"><?php _e('Send automatic confirmation email to user', 'cari-prop-shop-forms'); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="auto_responder_subject"><?php _e('Email Subject', 'cari-prop-shop-forms'); ?></label></th>
                        <td>
                            <input type="text" name="auto_responder_subject" id="auto_responder_subject" value="<?php echo esc_attr(!empty($settings['auto_responder']['subject']) ? $settings['auto_responder']['subject'] : __('Thank you for your inquiry', 'cari-prop-shop-forms')); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="auto_responder_message"><?php _e('Email Message', 'cari-prop-shop-forms'); ?></label></th>
                        <td>
                            <textarea name="auto_responder_message" id="auto_responder_message" rows="5" class="large-text"><?php echo esc_textarea(!empty($settings['auto_responder']['message']) ? $settings['auto_responder']['message'] : __('Thank you for contacting us. We will get back to you shortly.', 'cari-prop-shop-forms')); ?></textarea>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div id="recaptcha" class="cps-settings-panel" style="display:none;">
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php _e('Enable reCAPTCHA', 'cari-prop-shop-forms'); ?></th>
                        <td>
                            <input type="checkbox" name="recaptcha_enable" id="recaptcha_enable" value="1" <?php checked(!empty($settings['recaptcha']['enable'])); ?>>
                            <label for="recaptcha_enable"><?php _e('Protect forms from spam using Google reCAPTCHA', 'cari-prop-shop-forms'); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="recaptcha_site_key"><?php _e('Site Key', 'cari-prop-shop-forms'); ?></label></th>
                        <td>
                            <input type="text" name="recaptcha_site_key" id="recaptcha_site_key" value="<?php echo esc_attr(!empty($settings['recaptcha']['site_key']) ? $settings['recaptcha']['site_key'] : ''); ?>" class="regular-text">
                            <p class="description"><?php _e('Get your keys from', 'cari-prop-shop-forms'); ?> <a href="https://www.google.com/recaptcha/admin" target="_blank">Google reCAPTCHA</a></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="recaptcha_secret_key"><?php _e('Secret Key', 'cari-prop-shop-forms'); ?></label></th>
                        <td>
                            <input type="text" name="recaptcha_secret_key" id="recaptcha_secret_key" value="<?php echo esc_attr(!empty($settings['recaptcha']['secret_key']) ? $settings['recaptcha']['secret_key'] : ''); ?>" class="regular-text">
                        </td>
                    </tr>
                </table>
            </div>
            
            <div id="styling" class="cps-settings-panel" style="display:none;">
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="form_styling_primary_color"><?php _e('Primary Color', 'cari-prop-shop-forms'); ?></label></th>
                        <td>
                            <input type="color" name="form_styling_primary_color" id="form_styling_primary_color" value="<?php echo esc_attr(!empty($settings['form_styling']['primary_color']) ? $settings['form_styling']['primary_color'] : '#007bff'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="form_styling_button_color"><?php _e('Button Color', 'cari-prop-shop-forms'); ?></label></th>
                        <td>
                            <input type="color" name="form_styling_button_color" id="form_styling_button_color" value="<?php echo esc_attr(!empty($settings['form_styling']['button_color']) ? $settings['form_styling']['button_color'] : '#007bff'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="form_styling_button_text_color"><?php _e('Button Text Color', 'cari-prop-shop-forms'); ?></label></th>
                        <td>
                            <input type="color" name="form_styling_button_text_color" id="form_styling_button_text_color" value="<?php echo esc_attr(!empty($settings['form_styling']['button_text_color']) ? $settings['form_styling']['button_text_color'] : '#ffffff'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="form_styling_border_radius"><?php _e('Border Radius (px)', 'cari-prop-shop-forms'); ?></label></th>
                        <td>
                            <input type="number" name="form_styling_border_radius" id="form_styling_border_radius" value="<?php echo esc_attr(!empty($settings['form_styling']['border_radius']) ? $settings['form_styling']['border_radius'] : '4'); ?>" min="0" max="20">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
        <p class="submit">
            <input type="submit" name="cps_save_settings" class="button button-primary" value="<?php _e('Save Settings', 'cari-prop-shop-forms'); ?>">
        </p>
    </form>
</div>

<script>
jQuery(document).ready(function($) {
    $('.nav-tab').click(function(e) {
        e.preventDefault();
        $('.nav-tab').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');
        $('.cps-settings-panel').hide();
        $($(this).attr('href')).show();
    });
});
</script>