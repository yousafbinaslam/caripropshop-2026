<?php
/**
 * Template Name: User Dashboard - CariPropShop
 */

if (!is_user_logged_in()) {
    wp_redirect(home_url('/login'));
    exit;
}

$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$user_role = cps_get_user_role($user_id);
$is_agent = in_array('agent', (array)$current_user->roles) || in_array('administrator', (array)$current_user->roles);

$active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'dashboard';

$favorites = get_posts(array(
    'post_type' => 'property',
    'posts_per_page' => -1,
    'meta_query' => array(
        array('key' => 'cps_favorites', 'value' => '"' . $user_id . '"', 'compare' => 'LIKE')
    )
));

$saved_searches = get_user_meta($user_id, 'cps_saved_searches', true) ?: array();

$user_leads = get_posts(array(
    'post_type' => 'cps_lead',
    'posts_per_page' => -1,
    'meta_query' => array(
        array('key' => 'cps_user_id', 'value' => $user_id)
    )
));

$user_messages = get_posts(array(
    'post_type' => 'cps_message',
    'posts_per_page' => -1,
    'meta_query' => array(
        array('key' => 'cps_recipient_id', 'value' => $user_id)
    ),
    'orderby' => 'date',
    'order' => 'DESC'
));

if ($is_agent) {
    $user_properties = get_posts(array(
        'post_type' => 'property',
        'posts_per_page' => -1,
        'author' => $user_id
    ));
    
    $user_invoices = get_posts(array(
        'post_type' => 'cps_invoice',
        'posts_per_page' => -1,
        'meta_query' => array(
            array('key' => 'cps_user_id', 'value' => $user_id)
        )
    ));
    
    $user_package = get_user_meta($user_id, 'cps_package', true);
    $package_features = cps_get_package_features($user_package);
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php esc_html_e('My Dashboard', 'cari-prop-shop'); ?> - CariPropShop</title>
    <?php wp_head(); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="cps-dashboard-page">
<?php get_header(); ?>

<div class="cps-dashboard">
    <aside class="cps-sidebar">
        <div class="cps-user-profile">
            <div class="cps-avatar">
                <?php echo get_avatar($user_id, 100); ?>
                <span class="cps-online-status"></span>
            </div>
            <div class="cps-user-info">
                <h3><?php echo esc_html($current_user->display_name); ?></h3>
                <p><?php echo esc_html($current_user->user_email); ?></p>
                <?php if ($is_agent) : ?>
                    <span class="cps-user-badge"><?php esc_html_e('Agent', 'cari-prop-shop'); ?></span>
                <?php endif; ?>
            </div>
        </div>
        
        <nav class="cps-nav">
            <div class="cps-nav-section">
                <span class="cps-nav-label"><?php esc_html_e('Main Menu', 'cari-prop-shop'); ?></span>
                <a href="<?php echo esc_url(add_query_arg('tab', 'dashboard')); ?>" class="cps-nav-item <?php echo $active_tab === 'dashboard' ? 'active' : ''; ?>">
                    <i class="fas fa-home"></i>
                    <span><?php esc_html_e('Dashboard', 'cari-prop-shop'); ?></span>
                </a>
                <?php if ($is_agent) : ?>
                    <a href="<?php echo esc_url(add_query_arg('tab', 'properties')); ?>" class="cps-nav-item <?php echo $active_tab === 'properties' ? 'active' : ''; ?>">
                        <i class="fas fa-building"></i>
                        <span><?php esc_html_e('My Properties', 'cari-prop-shop'); ?></span>
                        <span class="cps-badge"><?php echo count($user_properties); ?></span>
                    </a>
                    <a href="<?php echo esc_url(add_query_arg('tab', 'add-property')); ?>" class="cps-nav-item <?php echo $active_tab === 'add-property' ? 'active' : ''; ?>">
                        <i class="fas fa-plus-circle"></i>
                        <span><?php esc_html_e('Add Property', 'cari-prop-shop'); ?></span>
                    </a>
                <?php endif; ?>
                <a href="<?php echo esc_url(add_query_arg('tab', 'favorites')); ?>" class="cps-nav-item <?php echo $active_tab === 'favorites' ? 'active' : ''; ?>">
                    <i class="fas fa-heart"></i>
                    <span><?php esc_html_e('Favorites', 'cari-prop-shop'); ?></span>
                    <?php if (count($favorites) > 0) : ?>
                        <span class="cps-badge"><?php echo count($favorites); ?></span>
                    <?php endif; ?>
                </a>
                <a href="<?php echo esc_url(add_query_arg('tab', 'searches')); ?>" class="cps-nav-item <?php echo $active_tab === 'searches' ? 'active' : ''; ?>">
                    <i class="fas fa-search"></i>
                    <span><?php esc_html_e('Saved Searches', 'cari-prop-shop'); ?></span>
                    <?php if (count($saved_searches) > 0) : ?>
                        <span class="cps-badge"><?php echo count($saved_searches); ?></span>
                    <?php endif; ?>
                </a>
            </div>
            
            <div class="cps-nav-section">
                <span class="cps-nav-label"><?php esc_html_e('Communication', 'cari-prop-shop'); ?></span>
                <a href="<?php echo esc_url(add_query_arg('tab', 'messages')); ?>" class="cps-nav-item <?php echo $active_tab === 'messages' ? 'active' : ''; ?>">
                    <i class="fas fa-envelope"></i>
                    <span><?php esc_html_e('Messages', 'cari-prop-shop'); ?></span>
                    <?php 
                    $unread_count = count(array_filter($user_messages, function($m) { 
                        return get_post_meta($m->ID, 'cps_read', true) !== '1'; 
                    }));
                    if ($unread_count > 0) : ?>
                        <span class="cps-badge cps-badge-primary"><?php echo $unread_count; ?></span>
                    <?php endif; ?>
                </a>
                <a href="<?php echo esc_url(add_query_arg('tab', 'inquiries')); ?>" class="cps-nav-item <?php echo $active_tab === 'inquiries' ? 'active' : ''; ?>">
                    <i class="fas fa-paper-plane"></i>
                    <span><?php esc_html_e('Inquiries', 'cari-prop-shop'); ?></span>
                    <span class="cps-badge"><?php echo count($user_leads); ?></span>
                </a>
            </div>
            
            <?php if ($is_agent) : ?>
                <div class="cps-nav-section">
                    <span class="cps-nav-label"><?php esc_html_e('Billing', 'cari-prop-shop'); ?></span>
                    <a href="<?php echo esc_url(add_query_arg('tab', 'packages')); ?>" class="cps-nav-item <?php echo $active_tab === 'packages' ? 'active' : ''; ?>">
                        <i class="fas fa-box"></i>
                        <span><?php esc_html_e('Packages', 'cari-prop-shop'); ?></span>
                    </a>
                    <a href="<?php echo esc_url(add_query_arg('tab', 'invoices')); ?>" class="cps-nav-item <?php echo $active_tab === 'invoices' ? 'active' : ''; ?>">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span><?php esc_html_e('Invoices', 'cari-prop-shop'); ?></span>
                    </a>
                </div>
            <?php endif; ?>
            
            <div class="cps-nav-section">
                <span class="cps-nav-label"><?php esc_html_e('Account', 'cari-prop-shop'); ?></span>
                <a href="<?php echo esc_url(add_query_arg('tab', 'profile')); ?>" class="cps-nav-item <?php echo $active_tab === 'profile' ? 'active' : ''; ?>">
                    <i class="fas fa-user-cog"></i>
                    <span><?php esc_html_e('Profile Settings', 'cari-prop-shop'); ?></span>
                </a>
                <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="cps-nav-item cps-logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span><?php esc_html_e('Logout', 'cari-prop-shop'); ?></span>
                </a>
            </div>
        </nav>
    </aside>

    <main class="cps-main-content">
        <?php if ($active_tab === 'dashboard') : ?>
            <div class="cps-panel">
                <div class="cps-panel-header">
                    <div class="cps-welcome">
                        <h1><?php esc_html_e('Welcome back,', 'cari-prop-shop'); ?> <?php echo esc_html($current_user->first_name ?: $current_user->display_name); ?>!</h1>
                        <p><?php esc_html_e('Here\'s what\'s happening with your account today.', 'cari-prop-shop'); ?></p>
                    </div>
                    <div class="cps-panel-actions">
                        <?php if ($is_agent) : ?>
                            <a href="<?php echo esc_url(add_query_arg('tab', 'add-property')); ?>" class="cps-btn cps-btn-primary">
                                <i class="fas fa-plus"></i>
                                <?php esc_html_e('Add New Property', 'cari-prop-shop'); ?>
                            </a>
                        <?php else : ?>
                            <a href="<?php echo esc_url(get_post_type_archive_link('property')); ?>" class="cps-btn cps-btn-primary">
                                <i class="fas fa-search"></i>
                                <?php esc_html_e('Browse Properties', 'cari-prop-shop'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="cps-stats-grid">
                    <div class="cps-stat-card">
                        <div class="cps-stat-icon" style="background: rgba(255, 107, 107, 0.1);">
                            <i class="fas fa-heart" style="color: #ff6b6b;"></i>
                        </div>
                        <div class="cps-stat-content">
                            <span class="cps-stat-value"><?php echo count($favorites); ?></span>
                            <span class="cps-stat-label"><?php esc_html_e('Favorite Properties', 'cari-prop-shop'); ?></span>
                        </div>
                    </div>
                    
                    <div class="cps-stat-card">
                        <div class="cps-stat-icon" style="background: rgba(108, 117, 125, 0.1);">
                            <i class="fas fa-search" style="color: #6c757d;"></i>
                        </div>
                        <div class="cps-stat-content">
                            <span class="cps-stat-value"><?php echo count($saved_searches); ?></span>
                            <span class="cps-stat-label"><?php esc_html_e('Saved Searches', 'cari-prop-shop'); ?></span>
                        </div>
                    </div>
                    
                    <div class="cps-stat-card">
                        <div class="cps-stat-icon" style="background: rgba(0, 174, 239, 0.1);">
                            <i class="fas fa-envelope" style="color: #00aeef;"></i>
                        </div>
                        <div class="cps-stat-content">
                            <span class="cps-stat-value"><?php echo count($user_leads); ?></span>
                            <span class="cps-stat-label"><?php esc_html_e('Inquiries Sent', 'cari-prop-shop'); ?></span>
                        </div>
                    </div>
                    
                    <?php if ($is_agent) : ?>
                        <div class="cps-stat-card">
                            <div class="cps-stat-icon" style="background: rgba(97, 206, 112, 0.1);">
                                <i class="fas fa-building" style="color: #61ce70;"></i>
                            </div>
                            <div class="cps-stat-content">
                                <span class="cps-stat-value"><?php echo count($user_properties); ?></span>
                                <span class="cps-stat-label"><?php esc_html_e('My Properties', 'cari-prop-shop'); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="cps-recent-section">
                    <h2 class="cps-section-title"><?php esc_html_e('Recent Activity', 'cari-prop-shop'); ?></h2>
                    <?php if (empty($favorites) && empty($user_leads)) : ?>
                        <div class="cps-empty-state">
                            <div class="cps-empty-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h3><?php esc_html_e('No Activity Yet', 'cari-prop-shop'); ?></h3>
                            <p><?php esc_html_e('Start exploring properties to see your activity here!', 'cari-prop-shop'); ?></p>
                            <a href="<?php echo esc_url(get_post_type_archive_link('property')); ?>" class="cps-btn cps-btn-primary">
                                <?php esc_html_e('Browse Properties', 'cari-prop-shop'); ?>
                            </a>
                        </div>
                    <?php else : ?>
                        <div class="cps-activity-list">
                            <?php foreach (array_merge($favorites, $user_leads) as $item) : 
                                $property_id = is_object($item) ? (get_post_type($item->ID) === 'property' ? $item->ID : get_post_meta($item->ID, 'cps_property_id', true)) : $item;
                                if (!$property_id || !get_post($property_id)) continue;
                            ?>
                                <div class="cps-activity-item">
                                    <div class="cps-activity-icon">
                                        <i class="fas fa-heart"></i>
                                    </div>
                                    <div class="cps-activity-content">
                                        <p><?php esc_html_e('You favorited', 'cari-prop-shop'); ?> <a href="<?php echo esc_url(get_permalink($property_id)); ?>"><?php echo esc_html(get_the_title($property_id)); ?></a></p>
                                        <span class="cps-activity-date"><?php echo get_the_date('M j, Y', $property_id); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($active_tab === 'properties' && $is_agent) : ?>
            <div class="cps-panel">
                <div class="cps-panel-header">
                    <h1><?php esc_html_e('My Properties', 'cari-prop-shop'); ?></h1>
                    <a href="<?php echo esc_url(add_query_arg('tab', 'add-property')); ?>" class="cps-btn cps-btn-primary">
                        <i class="fas fa-plus"></i>
                        <?php esc_html_e('Add New', 'cari-prop-shop'); ?>
                    </a>
                </div>
                
                <?php if (empty($user_properties)) : ?>
                    <div class="cps-empty-state">
                        <div class="cps-empty-icon"><i class="fas fa-building"></i></div>
                        <h3><?php esc_html_e('No Properties Yet', 'cari-prop-shop'); ?></h3>
                        <p><?php esc_html_e('Start by adding your first property listing.', 'cari-prop-shop'); ?></p>
                        <a href="<?php echo esc_url(add_query_arg('tab', 'add-property')); ?>" class="cps-btn cps-btn-primary">
                            <?php esc_html_e('Add Property', 'cari-prop-shop'); ?>
                        </a>
                    </div>
                <?php else : ?>
                    <div class="cps-properties-table-wrapper">
                        <table class="cps-properties-table">
                            <thead>
                                <tr>
                                    <th><?php esc_html_e('Property', 'cari-prop-shop'); ?></th>
                                    <th><?php esc_html_e('Status', 'cari-prop-shop'); ?></th>
                                    <th><?php esc_html_e('Views', 'cari-prop-shop'); ?></th>
                                    <th><?php esc_html_e('Date', 'cari-prop-shop'); ?></th>
                                    <th><?php esc_html_e('Actions', 'cari-prop-shop'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($user_properties as $prop) : 
                                    $status = get_post_meta($prop->ID, 'cps_status', true) ?: 'For Sale';
                                    $views = get_post_meta($prop->ID, 'cps_views', true) ?: 0;
                                ?>
                                    <tr>
                                        <td>
                                            <div class="cps-property-cell">
                                                <?php if (has_post_thumbnail($prop->ID)) : ?>
                                                    <?php echo get_the_post_thumbnail($prop->ID, 'thumbnail', array('class' => 'cps-property-thumb')); ?>
                                                <?php else : ?>
                                                    <div class="cps-property-thumb cps-no-thumb"><i class="fas fa-home"></i></div>
                                                <?php endif; ?>
                                                <div>
                                                    <a href="<?php echo esc_url(get_permalink($prop->ID)); ?>" class="cps-property-title"><?php echo esc_html($prop->post_title); ?></a>
                                                    <span class="cps-property-price"><?php echo cps_get_property_price($prop->ID); ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="cps-status-badge cps-status-<?php echo esc_attr(strtolower(str_replace(' ', '-', $status))); ?>"><?php echo esc_html($status); ?></span></td>
                                        <td><?php echo esc_html($views); ?></td>
                                        <td><?php echo get_the_date('M j, Y', $prop->ID); ?></td>
                                        <td>
                                            <div class="cps-action-btns">
                                                <a href="<?php echo esc_url(get_edit_post_link($prop->ID)); ?>" class="cps-btn-icon" title="<?php esc_attr_e('Edit', 'cari-prop-shop'); ?>">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?php echo esc_url(get_permalink($prop->ID)); ?>" class="cps-btn-icon" title="<?php esc_attr_e('View', 'cari-prop-shop'); ?>">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($active_tab === 'add-property' && $is_agent) : ?>
            <div class="cps-panel">
                <div class="cps-panel-header">
                    <h1><?php esc_html_e('Add New Property', 'cari-prop-shop'); ?></h1>
                </div>
                
                <form id="add-property-form" class="cps-property-form">
                    <div class="cps-form-section">
                        <h3><i class="fas fa-info-circle"></i> <?php esc_html_e('Basic Information', 'cari-prop-shop'); ?></h3>
                        <div class="cps-form-grid">
                            <div class="cps-form-group cps-full-width">
                                <label><?php esc_html_e('Property Title', 'cari-prop-shop'); ?> *</label>
                                <input type="text" name="post_title" required placeholder="<?php esc_attr_e('e.g., Modern Apartment in Central Jakarta', 'cari-prop-shop'); ?>">
                            </div>
                            <div class="cps-form-group">
                                <label><?php esc_html_e('Status', 'cari-prop-shop'); ?></label>
                                <select name="cps_status">
                                    <option value="For Sale"><?php esc_html_e('For Sale', 'cari-prop-shop'); ?></option>
                                    <option value="For Rent"><?php esc_html_e('For Rent', 'cari-prop-shop'); ?></option>
                                    <option value="Pending"><?php esc_html_e('Pending', 'cari-prop-shop'); ?></option>
                                    <option value="Sold"><?php esc_html_e('Sold', 'cari-prop-shop'); ?></option>
                                </select>
                            </div>
                            <div class="cps-form-group">
                                <label><?php esc_html_e('Price', 'cari-prop-shop'); ?> *</label>
                                <input type="number" name="cps_price" required placeholder="0">
                            </div>
                            <div class="cps-form-group">
                                <label><?php esc_html_e('Property Type', 'cari-prop-shop'); ?></label>
                                <select name="property_type">
                                    <option value=""><?php esc_html_e('Select Type', 'cari-prop-shop'); ?></option>
                                    <?php 
                                    $types = get_terms(array('taxonomy' => 'property_type', 'hide_empty' => false));
                                    foreach ($types as $type) : ?>
                                        <option value="<?php echo esc_attr($type->slug); ?>"><?php echo esc_html($type->name); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="cps-form-group">
                                <label><?php esc_html_e('Location', 'cari-prop-shop'); ?></label>
                                <input type="text" name="cps_address" placeholder="<?php esc_attr_e('Property Address', 'cari-prop-shop'); ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="cps-form-section">
                        <h3><i class="fas fa-ruler-combined"></i> <?php esc_html_e('Property Details', 'cari-prop-shop'); ?></h3>
                        <div class="cps-form-grid cps-form-grid-3">
                            <div class="cps-form-group">
                                <label><?php esc_html_e('Bedrooms', 'cari-prop-shop'); ?></label>
                                <input type="number" name="cps_bedrooms" min="0" placeholder="0">
                            </div>
                            <div class="cps-form-group">
                                <label><?php esc_html_e('Bathrooms', 'cari-prop-shop'); ?></label>
                                <input type="number" name="cps_bathrooms" min="0" placeholder="0">
                            </div>
                            <div class="cps-form-group">
                                <label><?php esc_html_e('Area (m²)', 'cari-prop-shop'); ?></label>
                                <input type="number" name="cps_area" min="0" placeholder="0">
                            </div>
                            <div class="cps-form-group">
                                <label><?php esc_html_e('Land Area (m²)', 'cari-prop-shop'); ?></label>
                                <input type="number" name="cps_land_area" min="0" placeholder="0">
                            </div>
                            <div class="cps-form-group">
                                <label><?php esc_html_e('Garage', 'cari-prop-shop'); ?></label>
                                <input type="number" name="cps_garage" min="0" placeholder="0">
                            </div>
                            <div class="cps-form-group">
                                <label><?php esc_html_e('Year Built', 'cari-prop-shop'); ?></label>
                                <input type="number" name="cps_year_built" min="1900" max="<?php echo date('Y'); ?>" placeholder="<?php echo date('Y'); ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="cps-form-section">
                        <h3><i class="fas fa-align-left"></i> <?php esc_html_e('Description', 'cari-prop-shop'); ?></h3>
                        <div class="cps-form-group">
                            <label><?php esc_html_e('Property Description', 'cari-prop-shop'); ?></label>
                            <?php wp_editor('', 'post_content', array('textarea_name' => 'post_content', 'media_buttons' => false, 'quicktags' => false)); ?>
                        </div>
                    </div>
                    
                    <div class="cps-form-actions">
                        <input type="hidden" name="action" value="cps_save_property">
                        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('cps_nonce'); ?>">
                        <button type="submit" class="cps-btn cps-btn-primary">
                            <i class="fas fa-save"></i>
                            <?php esc_html_e('Publish Property', 'cari-prop-shop'); ?>
                        </button>
                    </div>
                </form>
            </div>
        <?php endif; ?>

        <?php if ($active_tab === 'favorites') : ?>
            <div class="cps-panel">
                <div class="cps-panel-header">
                    <h1><?php esc_html_e('My Favorites', 'cari-prop-shop'); ?></h1>
                    <span class="cps-count-badge"><?php echo count($favorites); ?> <?php esc_html_e('Properties', 'cari-prop-shop'); ?></span>
                </div>
                
                <?php if (empty($favorites)) : ?>
                    <div class="cps-empty-state">
                        <div class="cps-empty-icon"><i class="fas fa-heart-broken"></i></div>
                        <h3><?php esc_html_e('No Favorites Yet', 'cari-prop-shop'); ?></h3>
                        <p><?php esc_html_e('Save properties you like to see them here.', 'cari-prop-shop'); ?></p>
                        <a href="<?php echo esc_url(get_post_type_archive_link('property')); ?>" class="cps-btn cps-btn-primary">
                            <?php esc_html_e('Browse Properties', 'cari-prop-shop'); ?>
                        </a>
                    </div>
                <?php else : ?>
                    <div class="cps-favorites-grid">
                        <?php foreach ($favorites as $fav) : 
                            $price = cps_get_property_price($fav->ID);
                            $address = get_post_meta($fav->ID, 'cps_address', true);
                            $bedrooms = get_post_meta($fav->ID, 'cps_bedrooms', true);
                            $bathrooms = get_post_meta($fav->ID, 'cps_bathrooms', true);
                            $area = get_post_meta($fav->ID, 'cps_area', true);
                        ?>
                            <div class="cps-favorite-card">
                                <div class="cps-favorite-image">
                                    <?php if (has_post_thumbnail($fav->ID)) : ?>
                                        <?php the_post_thumbnail('medium', array('alt' => get_the_title($fav->ID), 'data-property-id' => $fav->ID)); ?>
                                    <?php else : ?>
                                        <div class="cps-no-image"><i class="fas fa-home"></i></div>
                                    <?php endif; ?>
                                    <button class="cps-remove-favorite" data-property-id="<?php echo esc_attr($fav->ID); ?>">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="cps-favorite-content">
                                    <h3><a href="<?php echo esc_url(get_permalink($fav->ID)); ?>"><?php echo esc_html($fav->post_title); ?></a></h3>
                                    <?php if ($address) : ?>
                                        <p class="cps-favorite-address"><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($address); ?></p>
                                    <?php endif; ?>
                                    <div class="cps-favorite-meta">
                                        <?php if ($bedrooms) : ?><span><i class="fas fa-bed"></i> <?php echo esc_html($bedrooms); ?></span><?php endif; ?>
                                        <?php if ($bathrooms) : ?><span><i class="fas fa-bath"></i> <?php echo esc_html($bathrooms); ?></span><?php endif; ?>
                                        <?php if ($area) : ?><span><i class="fas fa-ruler-combined"></i> <?php echo esc_html($area); ?> m²</span><?php endif; ?>
                                    </div>
                                    <div class="cps-favorite-price"><?php echo $price; ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($active_tab === 'searches') : ?>
            <div class="cps-panel">
                <div class="cps-panel-header">
                    <h1><?php esc_html_e('Saved Searches', 'cari-prop-shop'); ?></h1>
                </div>
                
                <?php if (empty($saved_searches)) : ?>
                    <div class="cps-empty-state">
                        <div class="cps-empty-icon"><i class="fas fa-search"></i></div>
                        <h3><?php esc_html_e('No Saved Searches', 'cari-prop-shop'); ?></h3>
                        <p><?php esc_html_e('Save your property searches to quickly access them later.', 'cari-prop-shop'); ?></p>
                        <a href="<?php echo esc_url(get_post_type_archive_link('property')); ?>" class="cps-btn cps-btn-primary">
                            <?php esc_html_e('Search Properties', 'cari-prop-shop'); ?>
                        </a>
                    </div>
                <?php else : ?>
                    <div class="cps-searches-list">
                        <?php foreach ($saved_searches as $index => $search) : ?>
                            <div class="cps-search-item" data-index="<?php echo esc_attr($index); ?>">
                                <div class="cps-search-icon"><i class="fas fa-search"></i></div>
                                <div class="cps-search-content">
                                    <h3><?php echo esc_html($search['name'] ?: 'Search ' . ($index + 1)); ?></h3>
                                    <p><?php echo esc_html($search['url']); ?></p>
                                    <span class="cps-search-date"><?php esc_html_e('Saved on', 'cari-prop-shop'); ?> <?php echo esc_html($search['date']); ?></span>
                                </div>
                                <div class="cps-search-actions">
                                    <a href="<?php echo esc_url($search['url']); ?>" class="cps-btn cps-btn-secondary">
                                        <i class="fas fa-play"></i>
                                        <?php esc_html_e('Run Search', 'cari-prop-shop'); ?>
                                    </a>
                                    <button class="cps-btn-icon cps-btn-delete" data-index="<?php echo esc_attr($index); ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($active_tab === 'messages') : ?>
            <div class="cps-panel">
                <div class="cps-panel-header">
                    <h1><?php esc_html_e('Messages', 'cari-prop-shop'); ?></h1>
                </div>
                
                <?php if (empty($user_messages)) : ?>
                    <div class="cps-empty-state">
                        <div class="cps-empty-icon"><i class="fas fa-comments"></i></div>
                        <h3><?php esc_html_e('No Messages', 'cari-prop-shop'); ?></h3>
                        <p><?php esc_html_e('Your messages will appear here.', 'cari-prop-shop'); ?></p>
                    </div>
                <?php else : ?>
                    <div class="cps-messages-list">
                        <?php foreach ($user_messages as $msg) : 
                            $sender_id = get_post_meta($msg->ID, 'cps_sender_id', true);
                            $sender = $sender_id ? get_user_by('id', $sender_id) : null;
                            $is_read = get_post_meta($msg->ID, 'cps_read', true) === '1';
                        ?>
                            <div class="cps-message-item <?php echo $is_read ? '' : 'unread'; ?>">
                                <div class="cps-message-avatar">
                                    <?php echo $sender ? get_avatar($sender->ID, 50) : '<i class="fas fa-user"></i>'; ?>
                                </div>
                                <div class="cps-message-content">
                                    <div class="cps-message-header">
                                        <h4><?php echo $sender ? esc_html($sender->display_name) : esc_html__('Unknown User', 'cari-prop-shop'); ?></h4>
                                        <span class="cps-message-date"><?php echo get_the_date('M j, Y H:i', $msg->ID); ?></span>
                                    </div>
                                    <p><?php echo esc_html($msg->post_title); ?></p>
                                </div>
                                <?php if (!$is_read) : ?>
                                    <span class="cps-unread-badge"></span>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($active_tab === 'inquiries') : ?>
            <div class="cps-panel">
                <div class="cps-panel-header">
                    <h1><?php esc_html_e('My Inquiries', 'cari-prop-shop'); ?></h1>
                </div>
                
                <?php if (empty($user_leads)) : ?>
                    <div class="cps-empty-state">
                        <div class="cps-empty-icon"><i class="fas fa-paper-plane"></i></div>
                        <h3><?php esc_html_e('No Inquiries', 'cari-prop-shop'); ?></h3>
                        <p><?php esc_html_e('Inquiries you send to agents will appear here.', 'cari-prop-shop'); ?></p>
                        <a href="<?php echo esc_url(get_post_type_archive_link('property')); ?>" class="cps-btn cps-btn-primary">
                            <?php esc_html_e('Browse Properties', 'cari-prop-shop'); ?>
                        </a>
                    </div>
                <?php else : ?>
                    <table class="cps-data-table">
                        <thead>
                            <tr>
                                <th><?php esc_html_e('Date', 'cari-prop-shop'); ?></th>
                                <th><?php esc_html_e('Subject', 'cari-prop-shop'); ?></th>
                                <th><?php esc_html_e('Property', 'cari-prop-shop'); ?></th>
                                <th><?php esc_html_e('Status', 'cari-prop-shop'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($user_leads as $lead) : 
                                $property_id = get_post_meta($lead->ID, 'cps_property_id', true);
                                $status = get_post_meta($lead->ID, 'cps_status', true) ?: 'new';
                            ?>
                                <tr>
                                    <td><?php echo get_the_date('M j, Y', $lead->ID); ?></td>
                                    <td><?php echo esc_html($lead->post_title); ?></td>
                                    <td>
                                        <?php if ($property_id && get_post($property_id)) : ?>
                                            <a href="<?php echo esc_url(get_permalink($property_id)); ?>"><?php echo esc_html(get_the_title($property_id)); ?></a>
                                        <?php else : ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td><span class="cps-status-badge cps-status-<?php echo esc_attr($status); ?>"><?php echo ucfirst($status); ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($active_tab === 'packages' && $is_agent) : ?>
            <div class="cps-panel">
                <div class="cps-panel-header">
                    <h1><?php esc_html_e('Membership Packages', 'cari-prop-shop'); ?></h1>
                </div>
                
                <div class="cps-packages-grid">
                    <?php
                    $packages = array(
                        array(
                            'name' => 'Basic',
                            'price' => 'Rp 500,000',
                            'duration' => '30 days',
                            'listings' => '5',
                            'features' => array('5 Property Listings', 'Basic Support', 'Standard Exposure')
                        ),
                        array(
                            'name' => 'Professional',
                            'price' => 'Rp 1,500,000',
                            'duration' => '90 days',
                            'listings' => '20',
                            'features' => array('20 Property Listings', 'Priority Support', 'Featured Listings', 'Analytics Dashboard'),
                            'recommended' => true
                        ),
                        array(
                            'name' => 'Enterprise',
                            'price' => 'Rp 3,000,000',
                            'duration' => '365 days',
                            'listings' => 'Unlimited',
                            'features' => array('Unlimited Listings', '24/7 Support', 'Featured Listings', 'Premium Exposure', 'API Access')
                        )
                    );
                    
                    foreach ($packages as $pkg) :
                        $is_current = ($user_package === strtolower($pkg['name']));
                    ?>
                        <div class="cps-package-card <?php echo isset($pkg['recommended']) ? 'recommended' : ''; ?> <?php echo $is_current ? 'current' : ''; ?>">
                            <?php if (isset($pkg['recommended'])) : ?>
                                <span class="cps-package-badge"><?php esc_html_e('Recommended', 'cari-prop-shop'); ?></span>
                            <?php endif; ?>
                            <?php if ($is_current) : ?>
                                <span class="cps-package-current"><?php esc_html_e('Current Plan', 'cari-prop-shop'); ?></span>
                            <?php endif; ?>
                            <h3 class="cps-package-name"><?php echo esc_html($pkg['name']); ?></h3>
                            <div class="cps-package-price">
                                <span class="price"><?php echo esc_html($pkg['price']); ?></span>
                                <span class="duration">/ <?php echo esc_html($pkg['duration']); ?></span>
                            </div>
                            <div class="cps-package-listings">
                                <i class="fas fa-building"></i>
                                <?php echo esc_html($pkg['listings']); ?> <?php esc_html_e('Listings', 'cari-prop-shop'); ?>
                            </div>
                            <ul class="cps-package-features">
                                <?php foreach ($pkg['features'] as $feature) : ?>
                                    <li><i class="fas fa-check"></i> <?php echo esc_html($feature); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <?php if (!$is_current) : ?>
                                <a href="#" class="cps-btn cps-btn-primary cps-btn-block cps-select-package" data-package="<?php echo esc_attr(strtolower($pkg['name'])); ?>">
                                    <?php esc_html_e('Select Package', 'cari-prop-shop'); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($active_tab === 'invoices' && $is_agent) : ?>
            <div class="cps-panel">
                <div class="cps-panel-header">
                    <h1><?php esc_html_e('Invoices', 'cari-prop-shop'); ?></h1>
                </div>
                
                <?php if (empty($user_invoices)) : ?>
                    <div class="cps-empty-state">
                        <div class="cps-empty-icon"><i class="fas fa-file-invoice"></i></div>
                        <h3><?php esc_html_e('No Invoices', 'cari-prop-shop'); ?></h3>
                        <p><?php esc_html_e('Your invoices will appear here.', 'cari-prop-shop'); ?></p>
                    </div>
                <?php else : ?>
                    <table class="cps-data-table">
                        <thead>
                            <tr>
                                <th><?php esc_html_e('Invoice #', 'cari-prop-shop'); ?></th>
                                <th><?php esc_html_e('Date', 'cari-prop-shop'); ?></th>
                                <th><?php esc_html_e('Amount', 'cari-prop-shop'); ?></th>
                                <th><?php esc_html_e('Status', 'cari-prop-shop'); ?></th>
                                <th><?php esc_html_e('Actions', 'cari-prop-shop'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($user_invoices as $invoice) : 
                                $amount = get_post_meta($invoice->ID, 'cps_amount', true);
                                $status = get_post_meta($invoice->ID, 'cps_status', true) ?: 'pending';
                            ?>
                                <tr>
                                    <td><?php echo esc_html($invoice->post_title); ?></td>
                                    <td><?php echo get_the_date('M j, Y', $invoice->ID); ?></td>
                                    <td><?php echo $amount ? 'Rp ' . number_format((int)$amount, 0, ',', '.') : '-'; ?></td>
                                    <td><span class="cps-status-badge cps-status-<?php echo esc_attr($status); ?>"><?php echo ucfirst($status); ?></span></td>
                                    <td>
                                        <a href="#" class="cps-btn-icon"><i class="fas fa-download"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($active_tab === 'profile') : ?>
            <div class="cps-panel">
                <div class="cps-panel-header">
                    <h1><?php esc_html_e('Profile Settings', 'cari-prop-shop'); ?></h1>
                </div>
                
                <form id="cps-profile-form" class="cps-profile-form">
                    <div class="cps-form-section">
                        <h3><i class="fas fa-user"></i> <?php esc_html_e('Personal Information', 'cari-prop-shop'); ?></h3>
                        <div class="cps-form-grid">
                            <div class="cps-form-group">
                                <label><?php esc_html_e('First Name', 'cari-prop-shop'); ?></label>
                                <input type="text" name="first_name" value="<?php echo esc_attr($current_user->first_name); ?>">
                            </div>
                            <div class="cps-form-group">
                                <label><?php esc_html_e('Last Name', 'cari-prop-shop'); ?></label>
                                <input type="text" name="last_name" value="<?php echo esc_attr($current_user->last_name); ?>">
                            </div>
                            <div class="cps-form-group">
                                <label><?php esc_html_e('Display Name', 'cari-prop-shop'); ?></label>
                                <input type="text" name="display_name" value="<?php echo esc_attr($current_user->display_name); ?>">
                            </div>
                            <div class="cps-form-group">
                                <label><?php esc_html_e('Email', 'cari-prop-shop'); ?></label>
                                <input type="email" name="email" value="<?php echo esc_attr($current_user->user_email); ?>" required>
                            </div>
                        </div>
                    </div>
                    
                    <?php if ($is_agent) : ?>
                        <div class="cps-form-section">
                            <h3><i class="fas fa-phone"></i> <?php esc_html_e('Contact Information', 'cari-prop-shop'); ?></h3>
                            <div class="cps-form-grid">
                                <div class="cps-form-group">
                                    <label><?php esc_html_e('Phone', 'cari-prop-shop'); ?></label>
                                    <input type="tel" name="cps_phone" value="<?php echo esc_attr(get_user_meta($user_id, 'cps_phone', true)); ?>">
                                </div>
                                <div class="cps-form-group">
                                    <label><?php esc_html_e('WhatsApp', 'cari-prop-shop'); ?></label>
                                    <input type="tel" name="cps_whatsapp" value="<?php echo esc_attr(get_user_meta($user_id, 'cps_whatsapp', true)); ?>">
                                </div>
                                <div class="cps-form-group cps-full-width">
                                    <label><?php esc_html_e('Bio', 'cari-prop-shop'); ?></label>
                                    <textarea name="cps_bio" rows="4"><?php echo esc_textarea(get_user_meta($user_id, 'cps_bio', true)); ?></textarea>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="cps-form-section">
                        <h3><i class="fas fa-lock"></i> <?php esc_html_e('Change Password', 'cari-prop-shop'); ?></h3>
                        <div class="cps-form-grid">
                            <div class="cps-form-group">
                                <label><?php esc_html_e('New Password', 'cari-prop-shop'); ?></label>
                                <input type="password" name="new_password" placeholder="<?php esc_attr_e('Leave blank to keep current', 'cari-prop-shop'); ?>">
                            </div>
                            <div class="cps-form-group">
                                <label><?php esc_html_e('Confirm Password', 'cari-prop-shop'); ?></label>
                                <input type="password" name="confirm_password" placeholder="<?php esc_attr_e('Confirm new password', 'cari-prop-shop'); ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="cps-form-actions">
                        <button type="submit" class="cps-btn cps-btn-primary">
                            <i class="fas fa-save"></i>
                            <?php esc_html_e('Save Changes', 'cari-prop-shop'); ?>
                        </button>
                    </div>
                    <div class="cps-form-message" id="cps-profile-message"></div>
                </form>
            </div>
        <?php endif; ?>
    </main>
</div>

<script>
jQuery(document).ready(function($) {
    $('.cps-remove-favorite').on('click', function() {
        var $card = $(this).closest('.cps-favorite-card');
        var propertyId = $(this).data('property-id');
        
        $.post(cpsData.ajaxUrl, {
            action: 'cps_remove_favorite',
            property_id: propertyId,
            nonce: cpsData.nonce
        }, function(response) {
            if (response.success) {
                $card.fadeOut(300, function() {
                    $(this).remove();
                    if ($('.cps-favorite-card').length === 0) {
                        location.reload();
                    }
                });
            }
        });
    });
    
    $('.cps-btn-delete').on('click', function() {
        var index = $(this).data('index');
        var $item = $(this).closest('.cps-search-item');
        
        $.post(cpsData.ajaxUrl, {
            action: 'cps_delete_saved_search',
            index: index,
            nonce: cpsData.nonce
        }, function(response) {
            if (response.success) {
                $item.fadeOut(300, function() {
                    $(this).remove();
                });
            }
        });
    });
    
    $('#cps-profile-form').on('submit', function(e) {
        e.preventDefault();
        var $form = $(this);
        var $msg = $('#cps-profile-message');
        
        $.post(cpsData.ajaxUrl, $form.serialize(), function(response) {
            if (response.success) {
                $msg.removeClass('error').addClass('success').text(response.data.message);
            } else {
                $msg.removeClass('success').addClass('error').text(response.data || 'Error');
            }
        });
    });
    
    $('#add-property-form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        
        $.ajax({
            url: cpsData.ajaxUrl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    window.location.href = response.data.redirect;
                } else {
                    alert(response.data || 'Error saving property');
                }
            }
        });
    });
});
</script>

<?php wp_footer(); ?>
</body>
</html>
