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
