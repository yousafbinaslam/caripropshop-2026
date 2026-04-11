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
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
    
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'cari-prop-shop'),
        'footer' => __('Footer Menu', 'cari-prop-shop'),
        'mobile' => __('Mobile Menu', 'cari-prop-shop'),
    ));
    
    add_image_size('property-thumbnail', 400, 300, true);
    add_image_size('property-featured', 800, 600, true);
    add_image_size('property-grid', 600, 450, true);
    add_image_size('agent-avatar', 300, 300, true);
}
add_action('after_setup_theme', 'cari_prop_shop_setup');

// Enqueue Scripts and Styles
function cari_prop_shop_scripts() {
    // Main theme stylesheet
    wp_enqueue_style('cari-prop-shop-style', get_stylesheet_uri(), array(), CPS_THEME_VERSION);
    
    // Main CSS from assets
    wp_enqueue_style('cps-main', get_template_directory_uri() . '/assets/css/main.css', array(), CPS_THEME_VERSION);
    
    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
    
    // Google Fonts
    wp_enqueue_style('cps-google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap', array(), null);
    
    // Swiper CSS (for sliders)
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css', array(), '10.0.0');
    
    // jQuery (already bundled with WordPress)
    wp_enqueue_script('jquery');
    
    // Swiper JS (for sliders)
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', array('jquery'), '10.0.0', true);
    
    // Main theme JavaScript
    wp_enqueue_script('cari-prop-shop-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), CPS_THEME_VERSION, true);
    
    // Half-map functionality (only on map pages)
    if (is_page_template('template-half-map.php') || is_singular('property')) {
        wp_enqueue_script('cari-prop-shop-half-map', get_template_directory_uri() . '/assets/js/half-map.js', array('jquery'), CPS_THEME_VERSION, true);
    }
    
    // PWA functionality
    wp_enqueue_script('cari-prop-shop-pwa', get_template_directory_uri() . '/assets/js/pwa.js', array(), CPS_THEME_VERSION, true);
    
    // Google Maps API
    $google_maps_api_key = get_option('cps_google_maps_api_key', '');
    if (!empty($google_maps_api_key)) {
        wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=' . $google_maps_api_key . '&libraries=places,drawing', array(), null, true);
    }
    
    // Localize script data
    wp_localize_script('cari-prop-shop-main', 'cpsData', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('cps_nonce'),
        'homeUrl' => home_url('/'),
        'currencySymbol' => 'Rp',
        'currencyFormat' => 'Rp {price}',
        'strings' => array(
            'loading' => __('Loading...', 'cari-prop-shop'),
            'error' => __('An error occurred', 'cari-prop-shop'),
            'addedToFavorites' => __('Added to favorites', 'cari-prop-shop'),
            'removedFromFavorites' => __('Removed from favorites', 'cari-prop-shop'),
            'addedToCompare' => __('Added to compare', 'cari-prop-shop'),
            'loginRequired' => __('Please login to continue', 'cari-prop-shop'),
        )
    ));
    
    // Add inline styles for customizer options
    $custom_css = cari_prop_shop_get_custom_css();
    wp_add_inline_style('cps-main', $custom_css);
}
add_action('wp_enqueue_scripts', 'cari_prop_shop_scripts');

// Admin scripts and styles
function cari_prop_shop_admin_scripts($hook) {
    wp_enqueue_style('cps-admin-style', get_template_directory_uri() . '/assets/css/admin.css', array(), CPS_THEME_VERSION);
    wp_enqueue_script('cps-admin-script', get_template_directory_uri() . '/assets/js/admin.js', array('jquery'), CPS_THEME_VERSION, true);
}
add_action('admin_enqueue_scripts', 'cari_prop_shop_admin_scripts');

// Login page styles
function cari_prop_shop_login_styles() {
    wp_enqueue_style('cps-login-style', get_template_directory_uri() . '/assets/css/login.css', array(), CPS_THEME_VERSION);
}
add_action('login_enqueue_scripts', 'cari_prop_shop_login_styles');

// Custom CSS from theme options
function cari_prop_shop_get_custom_css() {
    $primary_color = get_option('cps_primary_color', '#2563eb');
    $secondary_color = get_option('cps_secondary_color', '#7c3aed');
    $custom_css = get_option('cps_custom_css', '');
    
    $css = "
        :root {
            --cps-primary: {$primary_color};
            --cps-primary-dark: " . cps_adjust_brightness($primary_color, -20) . ";
            --cps-primary-light: " . cps_adjust_brightness($primary_color, 20) . ";
            --cps-secondary: {$secondary_color};
        }
        {$custom_css}
    ";
    
    return $css;
}

// Adjust color brightness helper
function cps_adjust_brightness($hex, $steps) {
    $steps = max(-255, min(255, $steps));
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
    }
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    $r = max(0, min(255, $r + $steps));
    $g = max(0, min(255, $g + $steps));
    $b = max(0, min(255, $b + $steps));
    return '#' . sprintf('%02x%02x%02x', $r, $g, $b);
}

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
        'name' => __('Property Sidebar', 'cari-prop-shop'),
        'id' => 'property-sidebar',
        'description' => __('Widgets for property detail pages.', 'cari-prop-shop'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Column 1', 'cari-prop-shop'),
        'id' => 'footer-1',
        'description' => __('Footer widget area.', 'cari-prop-shop'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Column 2', 'cari-prop-shop'),
        'id' => 'footer-2',
        'description' => __('Footer widget area.', 'cari-prop-shop'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Column 3', 'cari-prop-shop'),
        'id' => 'footer-3',
        'description' => __('Footer widget area.', 'cari-prop-shop'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Column 4', 'cari-prop-shop'),
        'id' => 'footer-4',
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
            background: linear-gradient(135deg, ' . get_option('cps_primary_color', '#2563eb') . ' 0%, ' . get_option('cps_secondary_color', '#7c3aed') . ' 100%);
            color: white;
            padding: 20px;
            margin: -20px -12px 20px -12px;
        }
        .cps-admin-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .cps-admin-header p {
            margin: 5px 0 0;
            opacity: 0.9;
        }
    </style>';
}
add_action('admin_head', 'cari_prop_shop_admin_styles');

// Reading time helper
function reading_time() {
    $content = get_post_field('post_content', get_the_ID());
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200);
    return $reading_time . ' min read';
}

// Get property price
function cps_get_property_price($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    $price = get_post_meta($post_id, 'cps_price', true);
    $price_label = get_post_meta($post_id, 'cps_price_label', true);
    $price_suffix = get_post_meta($post_id, 'cps_price_suffix', true);
    
    if (empty($price)) {
        return __('Price on Request', 'cari-prop-shop');
    }
    
    $formatted_price = 'Rp ' . number_format((float)$price, 0, ',', '.');
    
    if ($price_label) {
        $formatted_price = $price_label . ' ' . $formatted_price;
    }
    
    if ($price_suffix) {
        $formatted_price .= ' / ' . $price_suffix;
    }
    
    return $formatted_price;
}

// Get property location
function cps_get_property_location($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $terms = get_the_terms($post_id, 'property_city');
    if ($terms && !is_wp_error($terms)) {
        $cities = array();
        foreach ($terms as $term) {
            $cities[] = $term->name;
        }
        return implode(', ', $cities);
    }
    
    return '';
}

// Get property status
function cps_get_property_status($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $terms = get_the_terms($post_id, 'property_status');
    if ($terms && !is_wp_error($terms)) {
        foreach ($terms as $term) {
            return '<span class="property-status status-' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</span>';
        }
    }
    
    return '';
}

// Get property type
function cps_get_property_type($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $terms = get_the_terms($post_id, 'property_type');
    if ($terms && !is_wp_error($terms)) {
        foreach ($terms as $term) {
            return esc_html($term->name);
        }
    }
    
    return '';
}

// Check if property is favorite
function cps_is_favorite($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    if (!is_user_logged_in()) {
        return false;
    }
    
    $user_id = get_current_user_id();
    $favorites = get_user_meta($user_id, 'cps_favorites', true);
    
    return is_array($favorites) && in_array($post_id, $favorites);
}

// Get property agent
function cps_get_property_agent($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $agent_id = get_post_meta($post_id, 'cps_agent', true);
    
    if ($agent_id) {
        return get_post($agent_id);
    }
    
    return null;
}

// Excerpt length
function cps_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'cps_excerpt_length');

// Excerpt more
function cps_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'cps_excerpt_more');

// Pagination
function cps_pagination($query = null) {
    global $wp_query;
    if (!$query) {
        $query = $wp_query;
    }
    
    $total_pages = $query->max_num_pages;
    
    if ($total_pages > 1) {
        $current_page = max(1, get_query_var('paged'));
        
        echo '<nav class="cps-pagination">';
        echo paginate_links(array(
            'base' => get_pagenum_link(1) . '%_%',
            'format' => 'page/%#%',
            'current' => $current_page,
            'total' => $total_pages,
            'prev_text' => '<i class="fas fa-chevron-left"></i>',
            'next_text' => '<i class="fas fa-chevron-right"></i>',
            'mid_size' => 2,
            'end_size' => 1,
        ));
        echo '</nav>';
    }
}

// Breadcrumbs
function cps_breadcrumbs() {
    if (!is_front_page()) {
        echo '<nav class="cps-breadcrumbs">';
        echo '<a href="' . home_url('/') . '">' . __('Home', 'cari-prop-shop') . '</a>';
        
        if (is_singular('property')) {
            echo '<span class="separator">/</span>';
            $terms = get_the_terms(get_the_ID(), 'property_type');
            if ($terms) {
                echo '<a href="' . get_term_link($terms[0]) . '">' . $terms[0]->name . '</a>';
                echo '<span class="separator">/</span>';
            }
            echo '<span class="current">' . get_the_title() . '</span>';
        } elseif (is_singular()) {
            echo '<span class="separator">/</span>';
            echo '<span class="current">' . get_the_title() . '</span>';
        } elseif (is_post_type_archive('property')) {
            echo '<span class="separator">/</span>';
            echo '<span class="current">' . __('Properties', 'cari-prop-shop') . '</span>';
        } elseif (is_tax()) {
            echo '<span class="separator">/</span>';
            echo '<span class="current">' . single_term_title('', false) . '</span>';
        } elseif (is_page()) {
            echo '<span class="separator">/</span>';
            echo '<span class="current">' . get_the_title() . '</span>';
        }
        
        echo '</nav>';
    }
}

// Flush rewrite rules on theme activation
function cari_prop_shop_rewrite_flush() {
    cari_prop_shop_setup();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'cari_prop_shop_rewrite_flush');

// Add PWA manifest and service worker
function cari_prop_shop_pwa_tags() {
    echo '<link rel="manifest" href="' . get_template_directory_uri() . '/manifest.json">' . "\n";
    echo '<meta name="theme-color" content="' . get_option('cps_primary_color', '#2563eb') . '">' . "\n";
}
add_action('wp_head', 'cari_prop_shop_pwa_tags');

// Remove hentry class
function cps_remove_hentry_class($classes) {
    $classes = array_diff($classes, array('hentry'));
    return $classes;
}
add_filter('post_class', 'cps_remove_hentry_class');

// Custom login logo
function cps_login_logo() {
    $logo_url = get_option('cps_logo_url', '');
    if ($logo_url) {
        echo '<style type="text/css">
            #login h1 a, .login h1 a {
                background-image: url(' . esc_url($logo_url) . ');
                background-size: contain;
                width: 320px;
            }
        </style>';
    }
}
add_action('login_enqueue_scripts', 'cps_login_logo');

// Custom login logo URL
function cps_login_logo_url() {
    return home_url();
}
add_filter('login_headerurl', 'cps_login_logo_url');

// Comment form fields
function cps_comment_form_fields($fields) {
    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true' required" : '');
    
    $fields['author'] = '<p class="comment-form-author"><label for="author">' . __('Name', 'cari-prop-shop') . ($req ? ' *' : '') . '</label><input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" maxlength="245"' . $aria_req . ' class="form-control" /></p>';
    
    $fields['email'] = '<p class="comment-form-email"><label for="email">' . __('Email', 'cari-prop-shop') . ($req ? ' *' : '') . '</label><input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" maxlength="100" aria-describedby="email-notes"' . $aria_req . ' class="form-control" /></p>';
    
    $fields['url'] = '<p class="comment-form-url"><label for="url">' . __('Website', 'cari-prop-shop') . '</label><input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" maxlength="200" class="form-control" /></p>';
    
    return $fields;
}
add_filter('comment_form_default_fields', 'cps_comment_form_fields');

// Demo Content Setup
require_once get_template_directory() . '/demo-content/setup-page.php';

// =============================================
// MISSING HELPER FUNCTIONS
// =============================================

function cps_get_user_role($user_id = null) {
    if (!$user_id) {
        $user_id = get_current_user_id();
    }
    
    if (!$user_id) {
        return 'guest';
    }
    
    $user = get_userdata($user_id);
    if (!$user) {
        return 'guest';
    }
    
    if (in_array('administrator', $user->roles)) {
        return 'administrator';
    }
    if (in_array('agent', $user->roles)) {
        return 'agent';
    }
    if (in_array('editor', $user->roles)) {
        return 'editor';
    }
    
    return 'subscriber';
}

function cps_get_package_features($package = null) {
    $packages = array(
        'basic' => array(
            'name' => 'Basic',
            'listings' => 5,
            'featured' => 0,
            'duration' => 30,
            'price' => 500000
        ),
        'professional' => array(
            'name' => 'Professional',
            'listings' => 20,
            'featured' => 5,
            'duration' => 90,
            'price' => 1500000
        ),
        'enterprise' => array(
            'name' => 'Enterprise',
            'listings' => -1,
            'featured' => -1,
            'duration' => 365,
            'price' => 3000000
        )
    );
    
    if ($package && isset($packages[$package])) {
        return $packages[$package];
    }
    
    return $packages;
}

function cps_format_currency($amount, $currency = 'IDR') {
    $symbols = array(
        'IDR' => 'Rp',
        'USD' => '$',
        'EUR' => '€',
        'SGD' => 'S$'
    );
    
    $symbol = isset($symbols[$currency]) ? $symbols[$currency] : 'Rp';
    
    if ($currency === 'IDR') {
        return $symbol . ' ' . number_format((float)$amount, 0, ',', '.');
    }
    
    return $symbol . number_format((float)$amount, 2);
}

// =============================================
// MISSING AJAX HANDLERS
// =============================================

add_action('wp_ajax_cps_request_callback', 'cps_handle_request_callback');
add_action('wp_ajax_nopriv_cps_request_callback', 'cps_handle_request_callback');
function cps_handle_request_callback() {
    check_ajax_referer('cps_nonce', 'nonce');
    
    $name = sanitize_text_field($_POST['name'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $topic = sanitize_text_field($_POST['topic'] ?? '');
    
    if (empty($name) || empty($phone)) {
        wp_send_json_error(array('message' => __('Please fill in all required fields.', 'cari-prop-shop')));
    }
    
    $post_id = wp_insert_post(array(
        'post_type' => 'cps_callback',
        'post_title' => sprintf(__('Callback Request from %s', 'cari-prop-shop'), $name),
        'post_status' => 'publish',
        'meta_input' => array(
            'cps_name' => $name,
            'cps_phone' => $phone,
            'cps_topic' => $topic,
            'cps_status' => 'pending',
            'cps_date' => current_time('mysql')
        )
    ));
    
    if ($post_id) {
        $admin_email = get_option('admin_email');
        $subject = sprintf(__('[CariPropShop] Callback Request from %s', 'cari-prop-shop'), $name);
        $message = sprintf(
            __("Name: %s\nPhone: %s\nTopic: %s\nDate: %s", 'cari-prop-shop'),
            $name, $phone, $topic, current_time('Y-m-d H:i:s')
        );
        
        wp_mail($admin_email, $subject, $message);
        
        wp_send_json_success(array('message' => __('Thank you! We will call you back shortly.', 'cari-prop-shop')));
    } else {
        wp_send_json_error(array('message' => __('Error processing request. Please try again.', 'cari-prop-shop')));
    }
}

add_action('wp_ajax_cps_schedule_tour', 'cps_handle_schedule_tour');
add_action('wp_ajax_nopriv_cps_schedule_tour', 'cps_handle_schedule_tour');
function cps_handle_schedule_tour() {
    check_ajax_referer('cps_nonce', 'nonce');
    
    $property_id = intval($_POST['property_id'] ?? 0);
    $name = sanitize_text_field($_POST['name'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $tour_date = sanitize_text_field($_POST['tour_date'] ?? '');
    $tour_time = sanitize_text_field($_POST['tour_time'] ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');
    
    if (empty($property_id) || empty($name) || empty($email) || empty($tour_date) || empty($tour_time)) {
        wp_send_json_error(array('message' => __('Please fill in all required fields.', 'cari-prop-shop')));
    }
    
    $post_id = wp_insert_post(array(
        'post_type' => 'cps_tour',
        'post_title' => sprintf(__('Tour Request: %s', 'cari-prop-shop'), get_the_title($property_id)),
        'post_status' => 'publish',
        'meta_input' => array(
            'cps_property_id' => $property_id,
            'cps_name' => $name,
            'cps_email' => $email,
            'cps_phone' => $phone,
            'cps_tour_date' => $tour_date,
            'cps_tour_time' => $tour_time,
            'cps_message' => $message,
            'cps_status' => 'pending',
            'cps_date' => current_time('mysql')
        )
    ));
    
    if ($post_id) {
        $admin_email = get_option('admin_email');
        $property_title = get_the_title($property_id);
        
        $subject = sprintf(__('[CariPropShop] Tour Request for %s', 'cari-prop-shop'), $property_title);
        $message = sprintf(
            __("Property: %s\nName: %s\nEmail: %s\nPhone: %s\nDate: %s\nTime: %s\nMessage: %s", 'cari-prop-shop'),
            $property_title, $name, $email, $phone, $tour_date, $tour_time, $message
        );
        
        wp_mail($admin_email, $subject, $message);
        
        wp_send_json_success(array('message' => __('Tour scheduled successfully! We will contact you to confirm.', 'cari-prop-shop')));
    } else {
        wp_send_json_error(array('message' => __('Error scheduling tour. Please try again.', 'cari-prop-shop')));
    }
}

add_action('wp_ajax_cps_save_property', 'cps_handle_save_property');
function cps_handle_save_property() {
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => __('Please login to add properties.', 'cari-prop-shop'), 'require_login' => true));
    }
    
    check_ajax_referer('cps_nonce', 'nonce');
    
    $user_id = get_current_user_id();
    $user_package = get_user_meta($user_id, 'cps_package', true) ?: 'basic';
    $package_features = cps_get_package_features($user_package);
    
    $user_properties = count(get_posts(array(
        'post_type' => 'property',
        'author' => $user_id,
        'posts_per_page' => -1,
        'post_status' => array('publish', 'pending', 'draft')
    )));
    
    if ($package_features['listings'] > 0 && $user_properties >= $package_features['listings']) {
        wp_send_json_error(array('message' => __('You have reached your listing limit. Please upgrade your package.', 'cari-prop-shop')));
    }
    
    $title = sanitize_text_field($_POST['post_title'] ?? '');
    $content = wp_kses_post($_POST['post_content'] ?? '');
    $status = sanitize_text_field($_POST['cps_status'] ?? 'pending');
    $price = floatval($_POST['cps_price'] ?? 0);
    
    $post_data = array(
        'post_type' => 'property',
        'post_title' => $title,
        'post_content' => $content,
        'post_status' => current_user_can('publish_posts') ? $status : 'pending',
        'post_author' => $user_id
    );
    
    $post_id = wp_insert_post($post_data);
    
    if ($post_id && !is_wp_error($post_id)) {
        if (isset($_POST['cps_status'])) {
            update_post_meta($post_id, 'cps_status', sanitize_text_field($_POST['cps_status']));
        }
        if (isset($_POST['cps_price'])) {
            update_post_meta($post_id, 'cps_price', floatval($_POST['cps_price']));
        }
        if (isset($_POST['cps_address'])) {
            update_post_meta($post_id, 'cps_address', sanitize_text_field($_POST['cps_address']));
        }
        if (isset($_POST['cps_city'])) {
            update_post_meta($post_id, 'cps_city', sanitize_text_field($_POST['cps_city']));
        }
        if (isset($_POST['cps_bedrooms'])) {
            update_post_meta($post_id, 'cps_bedrooms', intval($_POST['cps_bedrooms']));
        }
        if (isset($_POST['cps_bathrooms'])) {
            update_post_meta($post_id, 'cps_bathrooms', intval($_POST['cps_bathrooms']));
        }
        if (isset($_POST['cps_area'])) {
            update_post_meta($post_id, 'cps_area', intval($_POST['cps_area']));
        }
        if (isset($_POST['cps_land_area'])) {
            update_post_meta($post_id, 'cps_land_area', intval($_POST['cps_land_area']));
        }
        if (isset($_POST['cps_garage'])) {
            update_post_meta($post_id, 'cps_garage', intval($_POST['cps_garage']));
        }
        if (isset($_POST['cps_year_built'])) {
            update_post_meta($post_id, 'cps_year_built', intval($_POST['cps_year_built']));
        }
        if (isset($_POST['cps_agent'])) {
            update_post_meta($post_id, 'cps_agent', intval($_POST['cps_agent']));
        }
        
        if (isset($_POST['property_type']) && !empty($_POST['property_type'])) {
            wp_set_object_terms($post_id, sanitize_text_field($_POST['property_type']), 'property_type');
        }
        
        wp_send_json_success(array(
            'message' => __('Property saved successfully!', 'cari-prop-shop'),
            'redirect' => get_permalink($post_id)
        ));
    } else {
        wp_send_json_error(array('message' => __('Error saving property. Please try again.', 'cari-prop-shop')));
    }
}

add_action('wp_ajax_cps_submit_contact', 'cps_handle_submit_contact');
add_action('wp_ajax_nopriv_cps_submit_contact', 'cps_handle_submit_contact');
function cps_handle_submit_contact() {
    check_ajax_referer('cps_nonce', 'nonce');
    
    $first_name = sanitize_text_field($_POST['first_name'] ?? '');
    $last_name = sanitize_text_field($_POST['last_name'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $subject = sanitize_text_field($_POST['subject'] ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');
    $property_id = intval($_POST['property_id'] ?? 0);
    
    if (empty($first_name) || empty($email) || empty($message)) {
        wp_send_json_error(array('message' => __('Please fill in all required fields.', 'cari-prop-shop')));
    }
    
    $post_id = wp_insert_post(array(
        'post_type' => 'cps_inquiry',
        'post_title' => sprintf(__('Contact from %s %s', 'cari-prop-shop'), $first_name, $last_name),
        'post_status' => 'publish',
        'meta_input' => array(
            'cps_first_name' => $first_name,
            'cps_last_name' => $last_name,
            'cps_email' => $email,
            'cps_phone' => $phone,
            'cps_subject' => $subject,
            'cps_message' => $message,
            'cps_property_id' => $property_id,
            'cps_status' => 'new',
            'cps_date' => current_time('mysql')
        )
    ));
    
    if ($post_id) {
        $admin_email = get_option('admin_email');
        $subject_line = $subject ?: sprintf(__('New Contact from %s', 'cari-prop-shop'), $first_name);
        
        $message_body = sprintf(
            __("Name: %s %s\nEmail: %s\nPhone: %s\nSubject: %s\nMessage: %s", 'cari-prop-shop'),
            $first_name, $last_name, $email, $phone, $subject_line, $message
        );
        
        if ($property_id) {
            $message_body .= sprintf(__("\n\nProperty: %s\nLink: %s", 'cari-prop-shop'), get_the_title($property_id), get_permalink($property_id));
        }
        
        wp_mail($admin_email, '[CariPropShop] ' . $subject_line, $message_body);
        
        if (isset($_POST['newsletter']) && $_POST['newsletter']) {
            $existing = get_posts(array(
                'post_type' => 'cps_subscriber',
                'meta_query' => array(array('key' => 'cps_email', 'value' => $email))
            ));
            if (empty($existing)) {
                wp_insert_post(array(
                    'post_type' => 'cps_subscriber',
                    'post_title' => $email,
                    'post_status' => 'publish',
                    'meta_input' => array('cps_email' => $email, 'cps_subscribed' => current_time('mysql'))
                ));
            }
        }
        
        wp_send_json_success(array('message' => __('Thank you for your message! We will get back to you soon.', 'cari-prop-shop')));
    } else {
        wp_send_json_error(array('message' => __('Error sending message. Please try again.', 'cari-prop-shop')));
    }
}

add_action('wp_ajax_cps_delete_saved_search', 'cps_handle_delete_saved_search');
function cps_handle_delete_saved_search() {
    check_ajax_referer('cps_nonce', 'nonce');
    
    $index = intval($_POST['index'] ?? -1);
    $user_id = get_current_user_id();
    
    if ($index < 0) {
        wp_send_json_error(array('message' => __('Invalid search index.', 'cari-prop-shop')));
    }
    
    $saved_searches = get_user_meta($user_id, 'cps_saved_searches', true) ?: array();
    
    if (isset($saved_searches[$index])) {
        unset($saved_searches[$index]);
        $saved_searches = array_values($saved_searches);
        update_user_meta($user_id, 'cps_saved_searches', $saved_searches);
        wp_send_json_success(array('message' => __('Saved search deleted.', 'cari-prop-shop')));
    } else {
        wp_send_json_error(array('message' => __('Saved search not found.', 'cari-prop-shop')));
    }
}

add_action('wp_ajax_cps_update_profile', 'cps_handle_update_profile');
function cps_handle_update_profile() {
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => __('Please login to update profile.', 'cari-prop-shop')));
    }
    
    check_ajax_referer('cps_nonce', 'nonce');
    
    $user_id = get_current_user_id();
    parse_str($_POST['data'], $data);
    
    $userdata = array('ID' => $user_id);
    
    if (isset($data['first_name'])) {
        $userdata['first_name'] = sanitize_text_field($data['first_name']);
    }
    if (isset($data['last_name'])) {
        $userdata['last_name'] = sanitize_text_field($data['last_name']);
    }
    if (isset($data['display_name'])) {
        $userdata['display_name'] = sanitize_text_field($data['display_name']);
    }
    if (isset($data['email'])) {
        $userdata['user_email'] = sanitize_email($data['email']);
    }
    
    $result = wp_update_user($userdata);
    
    if (is_wp_error($result)) {
        wp_send_json_error(array('message' => $result->get_error_message()));
    }
    
    if (isset($data['cps_phone'])) {
        update_user_meta($user_id, 'cps_phone', sanitize_text_field($data['cps_phone']));
    }
    if (isset($data['cps_whatsapp'])) {
        update_user_meta($user_id, 'cps_whatsapp', sanitize_text_field($data['cps_whatsapp']));
    }
    if (isset($data['cps_bio'])) {
        update_user_meta($user_id, 'cps_bio', sanitize_textarea_field($data['cps_bio']));
    }
    
    if (!empty($data['new_password']) && !empty($data['confirm_password'])) {
        if ($data['new_password'] === $data['confirm_password']) {
            wp_set_password($data['new_password'], $user_id);
        } else {
            wp_send_json_error(array('message' => __('Passwords do not match.', 'cari-prop-shop')));
        }
    }
    
    wp_send_json_success(array('message' => __('Profile updated successfully!', 'cari-prop-shop')));
}
