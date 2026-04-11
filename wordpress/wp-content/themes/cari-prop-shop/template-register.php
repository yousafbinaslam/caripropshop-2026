<?php
/**
 * Template Name: Register
 */

if (is_user_logged_in()) {
    wp_redirect(home_url('/dashboard'));
    exit;
}

$redirect = isset($_GET['redirect']) ? esc_url($_GET['redirect']) : home_url('/dashboard');
$login_url = add_query_arg('redirect', $redirect, home_url('/login'));
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account - CariPropShop</title>
    <?php wp_head(); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="register-page">
<div class="register-container">
    <div class="register-card">
        <div class="register-header">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/logo.png" alt="CariPropShop" class="register-logo" onerror="this.style.display='none'">
            <h1>Create Account</h1>
            <p>Join CariPropShop to find your dream property</p>
        </div>

        <form id="registerform" method="post">
            <input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect); ?>">
            <?php wp_nonce_field('cps_register', 'cps_register_nonce'); ?>
            
            <div class="form-group">
                <label for="user_login">Username</label>
                <div class="input-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" name="user_login" id="user_login" required autocomplete="username">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" id="first_name" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" id="last_name" required>
                </div>
            </div>

            <div class="form-group">
                <label for="user_email">Email</label>
                <div class="input-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="user_email" id="user_email" required autocomplete="email">
                </div>
            </div>

            <div class="form-group">
                <label for="user_pass">Password</label>
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="user_pass" id="user_pass" required autocomplete="new-password">
                </div>
                <div class="password-strength" id="passwordStrength">
                    <div class="strength-bar"></div>
                    <span class="strength-text"></span>
                </div>
            </div>

            <div class="form-group">
                <label for="user_pass_confirm">Confirm Password</label>
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="user_pass_confirm" id="user_pass_confirm" required autocomplete="new-password">
                </div>
            </div>

            <div class="form-group">
                <label for="user_phone">Phone Number</label>
                <div class="input-icon">
                    <i class="fas fa-phone"></i>
                    <input type="tel" name="cps_phone" id="user_phone" placeholder="+62 xxx xxxx xxxx">
                </div>
            </div>

            <div class="form-group">
                <label>I am a:</label>
                <div class="role-options">
                    <label class="role-option">
                        <input type="radio" name="cps_user_role" value="cps_buyer" checked>
                        <span class="role-card">
                            <i class="fas fa-home"></i>
                            <span>Buyer</span>
                        </span>
                    </label>
                    <label class="role-option">
                        <input type="radio" name="cps_user_role" value="cps_agent">
                        <span class="role-card">
                            <i class="fas fa-user-tie"></i>
                            <span>Agent</span>
                        </span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="terms" id="terms" required>
                    <span>I agree to the <a href="<?php echo esc_url(home_url('/terms')); ?>" target="_blank">Terms of Service</a> and <a href="<?php echo esc_url(home_url('/privacy')); ?>" target="_blank">Privacy Policy</a></span>
                </label>
            </div>

            <button type="submit" name="wp-submit" id="wp-submit" class="btn-register">
                <span>Create Account</span>
                <i class="fas fa-arrow-right"></i>
            </button>

            <div class="form-message" id="formMessage"></div>
        </form>

        <div class="register-footer">
            <p>Already have an account? <a href="<?php echo esc_url($login_url); ?>">Sign in</a></p>
        </div>
    </div>
</div>

<style>
body.register-page {
    margin: 0;
    padding: 0;
    background: linear-gradient(135deg, #1a365d 0%, #2c5282 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.register-container {
    width: 100%;
    max-width: 480px;
    padding: 20px;
}

.register-card {
    background: white;
    border-radius: 16px;
    padding: 40px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    max-height: 90vh;
    overflow-y: auto;
}

.register-header {
    text-align: center;
    margin-bottom: 25px;
}

.register-logo {
    max-height: 50px;
    margin-bottom: 20px;
}

.register-header h1 {
    margin: 0 0 10px;
    font-size: 28px;
    color: #1a365d;
}

.register-header p {
    margin: 0;
    color: #718096;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #4a5568;
    font-size: 14px;
}

.input-icon {
    position: relative;
}

.input-icon i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #a0aec0;
}

.input-icon input {
    width: 100%;
    padding: 14px 15px 14px 45px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 15px;
    box-sizing: border-box;
}

.input-icon input:focus {
    outline: none;
    border-color: #3182ce;
    box-shadow: 0 0 0 3px rgba(49,130,206,0.1);
}

.form-group input[type="text"],
.form-group input[type="email"],
.form-group input[type="tel"] {
    width: 100%;
    padding: 14px 15px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 15px;
    box-sizing: border-box;
}

.form-group input:focus {
    outline: none;
    border-color: #3182ce;
    box-shadow: 0 0 0 3px rgba(49,130,206,0.1);
}

.password-strength {
    margin-top: 8px;
}

.strength-bar {
    height: 4px;
    background: #e2e8f0;
    border-radius: 2px;
    overflow: hidden;
}

.strength-text {
    font-size: 12px;
    color: #718096;
}

.role-options {
    display: flex;
    gap: 15px;
}

.role-option {
    flex: 1;
    cursor: pointer;
}

.role-option input {
    display: none;
}

.role-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 20px;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.role-card i {
    font-size: 24px;
    color: #a0aec0;
}

.role-card span {
    font-size: 14px;
    font-weight: 500;
    color: #4a5568;
}

.role-option input:checked + .role-card {
    border-color: #3182ce;
    background: #ebf8ff;
}

.role-option input:checked + .role-card i {
    color: #3182ce;
}

.checkbox-label {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    cursor: pointer;
    font-size: 14px;
    color: #4a5568;
    line-height: 1.5;
}

.checkbox-label a {
    color: #3182ce;
    text-decoration: none;
}

.checkbox-label a:hover {
    text-decoration: underline;
}

.btn-register {
    width: 100%;
    padding: 16px;
    background: #3182ce;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.3s ease;
}

.btn-register:hover {
    background: #2c5282;
    transform: translateY(-2px);
}

.form-message {
    margin-top: 15px;
    padding: 15px;
    border-radius: 8px;
    font-size: 14px;
    display: none;
    text-align: center;
}

.form-message.success {
    background: #c6f6d5;
    color: #276749;
    display: block;
}

.form-message.error {
    background: #fed7d7;
    color: #c53030;
    display: block;
}

.register-footer {
    text-align: center;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #e2e8f0;
}

.register-footer p {
    margin: 0;
    color: #718096;
}

.register-footer a {
    color: #3182ce;
    font-weight: 600;
    text-decoration: none;
}

.register-footer a:hover {
    text-decoration: underline;
}

@media (max-width: 480px) {
    .register-card {
        padding: 25px;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    $('#user_pass').on('input', function() {
        var password = $(this).val();
        var strength = 0;
        var text = '';
        
        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password)) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^a-zA-Z0-9]/.test(password)) strength++;
        
        switch(strength) {
            case 0:
            case 1: text = 'Weak'; color = '#e53e3e'; break;
            case 2: text = 'Fair'; color = '#ed8936'; break;
            case 3: text = 'Good'; color = '#38a169'; break;
            case 4:
            case 5: text = 'Strong'; color = '#276749'; break;
        }
        
        var percent = (strength / 5) * 100;
        $('#passwordStrength .strength-bar').css({
            'width': percent + '%',
            'background': color
        });
        $('#passwordStrength .strength-text').text(text).css('color', color);
    });

    $('#registerform').on('submit', function(e) {
        e.preventDefault();
        
        var $form = $(this);
        var $btn = $form.find('#wp-submit');
        var $msg = $('#formMessage');
        
        var password = $('#user_pass').val();
        var confirm = $('#user_pass_confirm').val();
        
        if (password !== confirm) {
            $msg.removeClass('success').addClass('error').text('Passwords do not match');
            return;
        }
        
        if (password.length < 8) {
            $msg.removeClass('success').addClass('error').text('Password must be at least 8 characters');
            return;
        }
        
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Creating account...');
        
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: $form.serialize() + '&action=cps_ajax_register',
            success: function(response) {
                if (response.success) {
                    $msg.removeClass('error').addClass('success').text('Account created! Redirecting...');
                    setTimeout(function() {
                        window.location.href = '<?php echo esc_url($redirect); ?>';
                    }, 1500);
                } else {
                    $msg.removeClass('success').addClass('error').text(response.data || 'Registration failed');
                    $btn.prop('disabled', false).html('<span>Create Account</span><i class="fas fa-arrow-right"></i>');
                }
            },
            error: function() {
                $msg.removeClass('success').addClass('error').text('An error occurred. Please try again.');
                $btn.prop('disabled', false).html('<span>Create Account</span><i class="fas fa-arrow-right"></i>');
            }
        });
    });
});
</script>

<?php wp_footer(); ?>
</body>
</html>
