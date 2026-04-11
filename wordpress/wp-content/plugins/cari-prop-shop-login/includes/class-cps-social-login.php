<?php
/**
 * CariPropShop Social Login & User Enhancement
 */

if (!defined('ABSPATH')) {
    exit;
}

class CPS_Social_Login {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('init', array($this, 'init_hooks'));
        add_action('wp_ajax_cps_social_login', array($this, 'handle_social_login'));
        add_action('wp_ajax_nopriv_cps_social_login', array($this, 'handle_social_login'));
        add_action('wp_ajax_cps_verify_email', array($this, 'verify_email'));
        add_action('wp_ajax_cps_resend_verification', array($this, 'resend_verification'));
        add_action('wp_ajax_cps_update_profile', array($this, 'update_profile'));
        add_filter(' registration_errors', array($this, 'custom_registration_errors'), 10, 3);
        add_action('user_register', array($this, 'handle_new_user_registration'));
    }

    public function init_hooks() {
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'add_settings_link'));
    }

    public function add_settings_link($links) {
        $settings_link = '<a href="' . admin_url('admin.php?page=cps-social-login-settings') . '">Settings</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    public function handle_social_login() {
        check_ajax_referer('cps_social_nonce', 'nonce');

        $provider = sanitize_text_field($_POST['provider']);
        $provider_id = sanitize_text_field($_POST['id']);
        $email = sanitize_email($_POST['email']);
        $name = sanitize_text_field($_POST['name']);
        $avatar = esc_url_raw($_POST['avatar']);

        $user = get_user_by('email', $email);

        if (!$user) {
            $username = $this->generate_username($name, $email);
            $user_id = wp_create_user($username, wp_generate_password(24, false), $email);

            if (is_wp_error($user_id)) {
                wp_send_json_error(array('message' => 'Registration failed. Please try again.'));
            }

            wp_update_user(array(
                'ID' => $user_id,
                'display_name' => $name,
                'first_name' => explode(' ', $name)[0],
                'last_name' => implode(' ', array_slice(explode(' ', $name), 1)),
                'role' => 'subscriber',
            ));

            update_user_meta($user_id, 'cps_social_provider', $provider);
            update_user_meta($user_id, 'cps_social_provider_id', $provider_id);
            update_user_meta($user_id, 'cps_avatar', $avatar);
            update_user_meta($user_id, 'cps_email_verified', 1);
            update_user_meta($user_id, 'cps_verification_key', '');

            $user = get_user_by('id', $user_id);
        }

        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID, true);

        wp_send_json_success(array(
            'message' => 'Login successful',
            'redirect' => home_url('/dashboard'),
        ));
    }

    private function generate_username($name, $email) {
        $username = sanitize_user(explode('@', $email)[0]);
        $username = preg_replace('/[^a-z0-9]/', '', strtolower($username));

        if (username_exists($username)) {
            $counter = 1;
            while (username_exists($username . $counter)) {
                $counter++;
            }
            $username .= $counter;
        }

        return $username;
    }

    public function handle_new_user_registration($user_id) {
        $verification_key = wp_generate_uuid4();
        update_user_meta($user_id, 'cps_verification_key', $verification_key);
        update_user_meta($user_id, 'cps_email_verified', 0);
        update_user_meta($user_id, 'cps_registration_date', current_time('mysql'));

        $this->send_verification_email($user_id);
    }

    public function verify_email() {
        check_ajax_referer('cps_verify_nonce', 'nonce');

        $user_id = intval($_POST['user_id']);
        $key = sanitize_text_field($_POST['key']);

        $stored_key = get_user_meta($user_id, 'cps_verification_key', true);

        if ($stored_key === $key) {
            update_user_meta($user_id, 'cps_email_verified', 1);
            update_user_meta($user_id, 'cps_verification_key', '');

            wp_send_json_success(array('message' => 'Email verified successfully!'));
        }

        wp_send_json_error(array('message' => 'Invalid verification key.'));
    }

    public function resend_verification() {
        check_ajax_referer('cps_resend_nonce', 'nonce');

        $user_id = intval($_POST['user_id']);
        $user = get_user_by('id', $user_id);

        if (!$user) {
            wp_send_json_error(array('message' => 'User not found.'));
        }

        if (get_user_meta($user_id, 'cps_email_verified', true)) {
            wp_send_json_success(array('message' => 'Email already verified.'));
        }

        $this->send_verification_email($user_id);

        wp_send_json_success(array('message' => 'Verification email resent.'));
    }

    private function send_verification_email($user_id) {
        $user = get_user_by('id', $user_id);
        $key = get_user_meta($user_id, 'cps_verification_key', true);
        $verify_url = add_query_arg(array(
            'action' => 'cps_verify',
            'user_id' => $user_id,
            'key' => $key,
        ), wp_login_url());

        $subject = 'Verify your CariPropShop account';
        $message = sprintf(
            "Hi %s,\n\nPlease verify your email address by clicking the link below:\n\n%s\n\nIf you didn't create an account, please ignore this email.",
            $user->display_name,
            $verify_url
        );

        wp_mail($user->user_email, $subject, $message);
    }

    public function update_profile() {
        check_ajax_referer('cps_profile_nonce', 'nonce');

        $user_id = get_current_user_id();
        if (!$user_id) {
            wp_send_json_error(array('message' => 'Please log in first.'));
        }

        parse_str($_POST['data'], $data);

        $userdata = array('ID' => $user_id);

        if (!empty($data['first_name'])) {
            $userdata['first_name'] = sanitize_text_field($data['first_name']);
        }
        if (!empty($data['last_name'])) {
            $userdata['last_name'] = sanitize_text_field($data['last_name']);
        }
        if (!empty($data['display_name'])) {
            $userdata['display_name'] = sanitize_text_field($data['display_name']);
        }
        if (!empty($data['email']) && $data['email'] !== get_userdata($user_id)->user_email) {
            if (!is_email($data['email'])) {
                wp_send_json_error(array('message' => 'Invalid email address.'));
            }
            if (email_exists($data['email']) && email_exists($data['email']) !== $user_id) {
                wp_send_json_error(array('message' => 'Email already in use.'));
            }
            $userdata['user_email'] = sanitize_email($data['email']);
            update_user_meta($user_id, 'cps_email_verified', 0);
            $this->send_verification_email($user_id);
        }

        wp_update_user($userdata);

        if (!empty($data['cps_phone'])) {
            update_user_meta($user_id, 'cps_phone', sanitize_text_field($data['cps_phone']));
        }
        if (!empty($data['cps_address'])) {
            update_user_meta($user_id, 'cps_address', sanitize_text_field($data['cps_address']));
        }
        if (!empty($data['cps_city'])) {
            update_user_meta($user_id, 'cps_city', sanitize_text_field($data['cps_city']));
        }

        if (!empty($data['new_password'])) {
            if (empty($data['current_password'])) {
                wp_send_json_error(array('message' => 'Current password required to change password.'));
            }
            $user = get_user_by('id', $user_id);
            if (!wp_check_password($data['current_password'], $user->user_pass, $user_id)) {
                wp_send_json_error(array('message' => 'Current password incorrect.'));
            }
            if ($data['new_password'] !== $data['confirm_password']) {
                wp_send_json_error(array('message' => 'Passwords do not match.'));
            }
            wp_set_password($data['new_password'], $user_id);
        }

        wp_send_json_success(array('message' => 'Profile updated successfully.'));
    }

    public function custom_registration_errors($errors, $sanitized_user_login, $user_email) {
        if (get_option('cps_enable_phone_registration') && empty($_POST['cps_phone'])) {
            $errors->add('phone_required', '<strong>Error:</strong> Phone number is required.');
        }

        if (!empty($_POST['cps_phone']) && !preg_match('/^[\+\d\s\-\(\)]{8,20}$/', $_POST['cps_phone'])) {
            $errors->add('invalid_phone', '<strong>Error:</strong> Please enter a valid phone number.');
        }

        return $errors;
    }

    public function render_social_login_buttons() {
        $google_client_id = get_option('cps_google_client_id');
        $facebook_app_id = get_option('cps_facebook_app_id');
        ?>
        <div class="social-login-buttons">
            <?php if ($google_client_id) : ?>
                <button type="button" class="btn-social google" onclick="cpsSocialLogin('google')">
                    <i class="fab fa-google"></i>
                    <span>Continue with Google</span>
                </button>
            <?php endif; ?>
            <?php if ($facebook_app_id) : ?>
                <button type="button" class="btn-social facebook" onclick="cpsSocialLogin('facebook')">
                    <i class="fab fa-facebook-f"></i>
                    <span>Continue with Facebook</span>
                </button>
            <?php endif; ?>
        </div>

        <script>
        function cpsSocialLogin(provider) {
            if (provider === 'google') {
                const clientId = '<?php echo esc_js($google_client_id); ?>';
                const redirectUri = '<?php echo esc_url(home_url('/?social=google')); ?>';
                window.location.href = `https://accounts.google.com/o/oauth2/v2/auth?client_id=${clientId}&redirect_uri=${redirectUri}&response_type=code&scope=email%20profile`;
            } else if (provider === 'facebook') {
                const appId = '<?php echo esc_js($facebook_app_id); ?>';
                const redirectUri = '<?php echo esc_url(home_url('/?social=facebook')); ?>';
                window.location.href = `https://www.facebook.com/v12.0/dialog/oauth?client_id=${appId}&redirect_uri=${redirectUri}&scope=email,public_profile`;
            }
        }
        </script>
        <?php
    }
}

CPS_Social_Login::get_instance();

function cps_render_social_login_buttons() {
    CPS_Social_Login::get_instance()->render_social_login_buttons();
}
