<?php
/**
 * The template for displaying the header
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/manifest.json">
    <meta name="theme-color" content="#004274">
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/logo.jpg" sizes="32x32">
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/logo.jpg" sizes="192x192">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/logo.jpg">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="wrapper" class="houzez-wrapper">
    
    <header id="header-v4" class="header-wrap header-v4">
        <div class="header-top">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="header-contact-left">
                        <span class="header-contact-item">
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:info@caripropshop.com">info@caripropshop.com</a>
                        </span>
                    </div>
                    <div class="header-contact-right">
                        <div class="header-social-icons">
                            <a href="#" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="#" target="_blank" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="header-bottom">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="site-logo">
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.jpg" alt="<?php bloginfo('name'); ?>" style="max-height: 50px;">
                        </a>
                    </div>
                    
                    <nav class="main-nav">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'menu_class' => 'nav-menu',
                            'container' => false,
                            'fallback_cb' => false,
                            'items_wrap' => '<ul class="navbar-nav">%3$s</ul>',
                        ));
                        ?>
                    </nav>
                    
                    <div class="header-actions">
                        <?php if (is_user_logged_in()) : ?>
                            <div class="logged-in-nav">
                                <a href="<?php echo esc_url(home_url('/user-dashboard/')); ?>" class="btn btn-primary">
                                    <i class="fas fa-user"></i> Dashboard
                                </a>
                            </div>
                        <?php else : ?>
                            <div class="login-register">
                                <a href="<?php echo esc_url(home_url('/login/')); ?>" class="btn btn-outline">
                                    <i class="fas fa-user"></i> <?php _e('Login', 'cari-prop-shop'); ?>
                                </a>
                                <a href="<?php echo esc_url(home_url('/register/')); ?>" class="btn btn-create-listing">
                                    <i class="fas fa-plus"></i> <?php _e('Create Listing', 'cari-prop-shop'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <button class="mobile-menu-toggle" aria-label="Menu">
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <nav class="mobile-navigation">
        <div class="container">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'mobile',
                'menu_class' => 'mobile-menu',
                'container' => false,
                'fallback_cb' => function() {
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_class' => 'mobile-menu',
                        'container' => false,
                    ));
                },
            ));
            ?>
            <?php if (!is_user_logged_in()) : ?>
                <div class="mobile-auth-buttons">
                    <a href="<?php echo esc_url(home_url('/login/')); ?>" class="btn btn-outline btn-block"><?php _e('Login', 'cari-prop-shop'); ?></a>
                    <a href="<?php echo esc_url(home_url('/register/')); ?>" class="btn btn-primary btn-block"><?php _e('Register', 'cari-prop-shop'); ?></a>
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <main id="main" class="site-main site-content-wrap">


<style>
/* Header Styles */
.header-v4 {
    background-color: var(--cps-header-bg);
    position: relative;
    z-index: 999;
}

.header-v4 .header-top {
    background-color: var(--cps-header-bg);
    border-bottom: 1px solid rgba(255,255,255,0.1);
    padding: 10px 0;
    font-family: 'Plus Jakarta Sans', var(--cps-font-sans);
    font-size: 14px;
}

.header-v4 .header-contact-left {
    color: #ffffff;
}

.header-v4 .header-contact-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.header-v4 .header-contact-item i {
    color: var(--cps-primary);
}

.header-v4 .header-contact-item a {
    color: #ffffff;
    transition: color 0.3s;
}

.header-v4 .header-contact-item a:hover {
    color: var(--cps-primary);
}

.header-v4 .header-social-icons a {
    color: #ffffff;
    margin-left: 15px;
    font-size: 14px;
    transition: color 0.3s;
}

.header-v4 .header-social-icons a:hover {
    color: var(--cps-primary);
}

.header-v4 .header-bottom {
    padding: 15px 0;
}

.header-v4 .site-logo img {
    height: 50px;
    width: auto;
}

.header-v4 .main-nav .navbar-nav {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 5px;
}

.header-v4 .main-nav .navbar-nav li a {
    color: #ffffff;
    font-family: var(--cps-font-nav);
    font-size: 14px;
    font-weight: 400;
    text-transform: uppercase;
    padding: 10px 15px;
    transition: all 0.3s;
    display: block;
}

.header-v4 .main-nav .navbar-nav li a:hover,
.header-v4 .main-nav .navbar-nav li.current-menu-item a {
    color: var(--cps-primary);
    background-color: rgba(255,255,255,0.1);
}

.header-v4 .header-actions {
    display: flex;
    align-items: center;
    gap: 15px;
}

.header-v4 .btn {
    font-family: var(--cps-font-nav);
    font-size: 14px;
    text-transform: uppercase;
    padding: 10px 20px;
    border-radius: 4px;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.header-v4 .btn-outline {
    color: #ffffff;
    border: 1px solid rgba(255,255,255,0.5);
    background: transparent;
}

.header-v4 .btn-outline:hover {
    border-color: var(--cps-primary);
    color: var(--cps-primary);
}

.header-v4 .btn-create-listing,
.header-v4 .btn-primary {
    background-color: var(--cps-primary);
    color: #ffffff;
    border: 1px solid var(--cps-primary);
}

.header-v4 .btn-create-listing:hover,
.header-v4 .btn-primary:hover {
    background-color: #0095cc;
    border-color: #0095cc;
}

.mobile-menu-toggle {
    display: none;
    background: transparent;
    border: none;
    padding: 10px;
    cursor: pointer;
}

.mobile-menu-toggle span,
.mobile-menu-toggle span:before,
.mobile-menu-toggle span:after {
    display: block;
    width: 25px;
    height: 2px;
    background: #ffffff;
    position: relative;
    transition: all 0.3s;
}

.mobile-menu-toggle span:before,
.mobile-menu-toggle span:after {
    content: '';
    position: absolute;
    left: 0;
}

.mobile-menu-toggle span:before {
    top: -8px;
}

.mobile-menu-toggle span:after {
    top: 8px;
}

.mobile-navigation {
    display: none;
    background: #ffffff;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    z-index: 1000;
}

.mobile-navigation.active {
    display: block;
}

.mobile-menu {
    list-style: none;
    margin: 0;
    padding: 0;
}

.mobile-menu li {
    border-bottom: 1px solid #eee;
}

.mobile-menu li a {
    display: block;
    padding: 15px 0;
    color: var(--cps-gray-800);
    font-family: var(--cps-font-nav);
    text-transform: uppercase;
}

.mobile-menu li a:hover {
    color: var(--cps-primary);
}

.mobile-auth-buttons {
    margin-top: 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

@media (max-width: 991px) {
    .header-v4 .main-nav {
        display: none;
    }
    
    .mobile-menu-toggle {
        display: block;
    }
    
    .header-v4 .login-register .btn-outline {
        display: none;
    }
}

@media (max-width: 767px) {
    .header-v4 .header-top {
        display: none;
    }
}
</style>
