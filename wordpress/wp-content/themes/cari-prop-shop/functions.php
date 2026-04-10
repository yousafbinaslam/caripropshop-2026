<?php
/**
 * CariPropShop Theme Functions
 */

if (!defined('ABSPATH')) {
    exit;
}

define('CPS_THEME_VERSION', '1.0.0');

// Theme Setup
function cari_prop_shop_setup() {
    load_theme_textdomain('cari-prop-shop', get_template_directory() . '/languages');
    
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('custom-background');
    add_theme_support('custom-logo', array(
        'height' => 100,
        'width' => 300,
        'flex-height' => true,
        'flex-width' => true,
    ));
    
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'cari-prop-shop'),
        'footer' => __('Footer Menu', 'cari-prop-shop'),
        'mobile' => __('Mobile Menu', 'cari-prop-shop'),
    ));
    
    add_image_size('property-thumbnail', 400, 300, true);
    add_image_size('property-featured', 800, 600, true);
}
add_action('after_setup_theme', 'cari_prop_shop_setup');

// Enqueue Scripts and Styles
function cari_prop_shop_scripts() {
    wp_enqueue_style('cari-prop-shop-style', get_stylesheet_uri(), array(), CPS_THEME_VERSION);
    
    wp_enqueue_script('cari-prop-shop-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), CPS_THEME_VERSION, true);
    
    wp_localize_script('cari-prop-shop-main', 'cpsData', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('cps_nonce'),
        'homeUrl' => home_url('/'),
    ));
}
add_action('wp_enqueue_scripts', 'cari_prop_shop_scripts');

// Register Widget Areas
function cari_prop_shop_widgets() {
    register_sidebar(array(
        'name' => __('Sidebar', 'cari-prop-shop'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here.', 'cari-prop-shop'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer', 'cari-prop-shop'),
        'id' => 'footer-1',
        'description' => __('Footer widget area.', 'cari-prop-shop'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
}
add_action('widgets_init', 'cari_prop_shop_widgets');

// Custom CSS for admin
function cari_prop_shop_admin_styles() {
    echo '<style>
        .cps-admin-header {
            background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
            color: white;
            padding: 20px;
            margin: -20px -12px 20px -12px;
        }
        .cps-admin-header h1 {
            margin: 0;
            font-size: 24px;
        }
    </style>';
}
add_action('admin_head', 'cari_prop_shop_admin_styles');
