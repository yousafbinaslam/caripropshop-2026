<?php
/**
 * Template Name: Login
 */

if (is_user_logged_in()) {
    wp_redirect(home_url('/dashboard'));
    exit;
}

$redirect = isset($_GET['redirect']) ? esc_url($_GET['redirect']) : home_url('/dashboard');
$register_url = add_query_arg('redirect', $redirect, home_url('/register'));
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - CariPropShop</title>
    <?php wp_head(); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="login-page">
<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/logo.png" alt="CariPropShop" class="login-logo" onerror="this.style.display='none'">
            <h1>Welcome Back</h1>
            <p>Sign in to your CariPropShop account</p>
        </div>

        <?php 
        $errors = login_header_errors();
        if ($errors && !empty($errors->errors)) : 
            foreach ($errors->errors as $error) :
        ?>
            <div class="alert alert-error"><?php echo esc_html($error[0]); ?></div>
        <?php 
            endforeach;
        endif; 
        ?>

        <?php if (isset($_GET['registered'])) : ?>
            <div class="alert alert-success">Registration successful! Please check your email to activate your account.</div>
        <?php endif; ?>

        <?php if (isset($_GET['reset'])) : ?>
            <div class="alert alert-success">Check your email for the password reset link.</div>
        <?php endif; ?>

        <form name="loginform" id="loginform" action="<?php echo esc_url(wp_login_url()); ?>" method="post">
            <input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect); ?>">
            
            <div class="form-group">
                <label for="user_login">Email or Username</label>
                <div class="input-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="text" name="log" id="user_login" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label for="user_pass">Password</label>
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="pwd" id="user_pass" required>
                </div>
            </div>

            <div class="form-row">
                <label class="checkbox-label">
                    <input type="checkbox" name="rememberme" id="rememberme" value="forever">
                    <span>Remember me</span>
                </label>
                <a href="<?php echo esc_url(home_url('/reset-password')); ?>" class="forgot-link">Forgot password?</a>
            </div>

            <button type="submit" name="wp-submit" id="wp-submit" class="btn-login">
                <span>Sign In</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </form>

        <div class="login-divider">
            <span>or continue with</span>
        </div>

        <div class="social-login">
            <a href="#" class="social-btn google">
                <i class="fab fa-google"></i>
                <span>Google</span>
            </a>
            <a href="#" class="social-btn facebook">
                <i class="fab fa-facebook-f"></i>
                <span>Facebook</span>
            </a>
        </div>

        <div class="login-footer">
            <p>Don't have an account? <a href="<?php echo esc_url($register_url); ?>">Sign up</a></p>
        </div>
    </div>
</div>

<style>
body.login-page {
    margin: 0;
    padding: 0;
    background: linear-gradient(135deg, #1a365d 0%, #2c5282 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.login-container {
    width: 100%;
    max-width: 440px;
    padding: 20px;
}

.login-card {
    background: white;
    border-radius: 16px;
    padding: 40px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
}

.login-header {
    text-align: center;
    margin-bottom: 30px;
}

.login-logo {
    max-height: 50px;
    margin-bottom: 20px;
}

.login-header h1 {
    margin: 0 0 10px;
    font-size: 28px;
    color: #1a365d;
}

.login-header p {
    margin: 0;
    color: #718096;
}

.alert {
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-size: 14px;
}

.alert-error {
    background: #fed7d7;
    color: #c53030;
}

.alert-success {
    background: #c6f6d5;
    color: #276749;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #4a5568;
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

.form-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    font-size: 14px;
    color: #4a5568;
}

.forgot-link {
    color: #3182ce;
    font-size: 14px;
    text-decoration: none;
}

.forgot-link:hover {
    text-decoration: underline;
}

.btn-login {
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

.btn-login:hover {
    background: #2c5282;
    transform: translateY(-2px);
}

.login-divider {
    text-align: center;
    margin: 25px 0;
    position: relative;
}

.login-divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: #e2e8f0;
}

.login-divider span {
    background: white;
    padding: 0 15px;
    position: relative;
    color: #718096;
    font-size: 14px;
}

.social-login {
    display: flex;
    gap: 15px;
}

.social-btn {
    flex: 1;
    padding: 12px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    color: #4a5568;
    text-decoration: none;
    font-size: 14px;
    transition: all 0.3s ease;
}

.social-btn:hover {
    background: #f7fafc;
    border-color: #cbd5e0;
}

.social-btn.google i {
    color: #ea4335;
}

.social-btn.facebook i {
    color: #1877f2;
}

.login-footer {
    text-align: center;
    margin-top: 25px;
    padding-top: 25px;
    border-top: 1px solid #e2e8f0;
}

.login-footer p {
    margin: 0;
    color: #718096;
}

.login-footer a {
    color: #3182ce;
    font-weight: 600;
    text-decoration: none;
}

.login-footer a:hover {
    text-decoration: underline;
}
</style>

<?php wp_footer(); ?>
</body>
</html>
