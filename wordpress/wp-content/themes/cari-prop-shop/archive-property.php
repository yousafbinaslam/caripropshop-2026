<?php
/**
 * Property Archive Template - CariPropShop
 * Property listing with filters, grid/list view, and sorting
 */

get_header();

$property_types = get_terms(array(
    'taxonomy' => 'property_type',
    'hide_empty' => true,
));

$locations = get_terms(array(
    'taxonomy' => 'property_location',
    'hide_empty' => true,
));

$statuses = array('For Sale', 'For Rent', 'Pending', 'Sold');
$bedrooms_options = array(1, 2, 3, 4, 5, 6);
$bathrooms_options = array(1, 2, 3, 4);

$sort_options = array(
    'date-desc' => 'Newest First',
    'date-asc' => 'Oldest First',
    'price-asc' => 'Price (Low to High)',
    'price-desc' => 'Price (High to Low)',
    'title-asc' => 'Title (A-Z)',
    'title-desc' => 'Title (Z-A)',
);

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$posts_per_page = 12;

$args = array(
    'post_type' => 'property',
    'posts_per_page' => $posts_per_page,
    'paged' => $paged,
    'orderby' => 'date',
    'order' => 'DESC',
);

$filter_status = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : '';
$filter_type = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : '';
$filter_beds = isset($_GET['beds']) ? intval($_GET['beds']) : '';
$filter_baths = isset($_GET['baths']) ? intval($_GET['baths']) : '';
$filter_min_price = isset($_GET['min_price']) ? intval($_GET['min_price']) : '';
$filter_max_price = isset($_GET['max_price']) ? intval($_GET['max_price']) : '';
$filter_location = isset($_GET['location']) ? sanitize_text_field($_GET['location']) : '';
$sort_by = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : 'date-desc';

if ($filter_status) {
    $args['meta_query'][] = array(
        'key' => 'cps_status',
        'value' => $filter_status,
        'compare' => '='
    );
}

if ($filter_beds) {
    $args['meta_query'][] = array(
        'key' => 'cps_bedrooms',
        'value' => $filter_beds,
        'compare' => '>='
    );
}

if ($filter_baths) {
    $args['meta_query'][] = array(
        'key' => 'cps_bathrooms',
        'value' => $filter_baths,
        'compare' => '>='
    );
}

if ($filter_min_price) {
    $args['meta_query'][] = array(
        'key' => 'cps_price',
        'value' => $filter_min_price,
        'compare' => '>='
    );
}

if ($filter_max_price) {
    $args['meta_query'][] = array(
        'key' => 'cps_price',
        'value' => $filter_max_price,
        'compare' => '<='
    );
}

if ($filter_type) {
    $args['tax_query'][] = array(
        'taxonomy' => 'property_type',
        'field' => 'slug',
        'terms' => $filter_type
    );
}

if ($filter_location) {
    $args['tax_query'][] = array(
        'taxonomy' => 'property_location',
        'field' => 'slug',
        'terms' => $filter_location
    );
}

switch ($sort_by) {
    case 'date-asc':
        $args['orderby'] = 'date';
        $args['order'] = 'ASC';
        break;
    case 'price-asc':
        $args['meta_key'] = 'cps_price';
        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'ASC';
        break;
    case 'price-desc':
        $args['meta_key'] = 'cps_price';
        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'DESC';
        break;
    case 'title-asc':
        $args['orderby'] = 'title';
        $args['order'] = 'ASC';
        break;
    case 'title-desc':
        $args['orderby'] = 'title';
        $args['order'] = 'DESC';
        break;
    default:
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
}

$properties_query = new WP_Query($args);

$view_mode = isset($_COOKIE['property_view']) ? sanitize_text_field($_COOKIE['property_view']) : 'grid';
?>
<div class="property-archive-page">
    <section class="page-header">
        <div class="container">
            <div class="page-header-inner">
                <div class="page-header-content">
                    <h1 class="page-title"><?php esc_html_e('Find Your Perfect Property', 'cari-prop-shop'); ?></h1>
                    <p class="page-subtitle"><?php esc_html_e('Browse through our extensive collection of properties', 'cari-prop-shop'); ?></p>
                </div>
                <div class="breadcrumb">
                    <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'cari-prop-shop'); ?></a>
                    <span class="separator">/</span>
                    <span class="current"><?php esc_html_e('Properties', 'cari-prop-shop'); ?></span>
                </div>
            </div>
        </div>
    </section>

    <section class="property-listings-section">
        <div class="container">
            <div class="property-toolbar">
                <div class="toolbar-left">
                    <div class="results-count">
                        <span class="count-number"><?php echo esc_html($properties_query->found_posts); ?></span>
                        <span class="count-label"><?php esc_html_e('Properties Found', 'cari-prop-shop'); ?></span>
                    </div>
                </div>
                
                <div class="toolbar-right">
                    <div class="sort-dropdown">
                        <label for="sort-select"><?php esc_html_e('Sort by:', 'cari-prop-shop'); ?></label>
                        <select id="sort-select" class="sort-select" onchange="window.location.href=this.value;">
                            <?php foreach ($sort_options as $value => $label) : 
                                $current_url = add_query_arg('sort', $value);
                                $selected = ($sort_by === $value) ? 'selected' : '';
                            ?>
                                <option value="<?php echo esc_url($current_url); ?>" <?php echo $selected; ?>><?php echo esc_html($label); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="view-toggle">
                        <button class="view-btn grid-view <?php echo ($view_mode === 'grid') ? 'active' : ''; ?>" data-view="grid" title="<?php esc_attr_e('Grid View', 'cari-prop-shop'); ?>">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button class="view-btn list-view <?php echo ($view_mode === 'list') ? 'active' : ''; ?>" data-view="list" title="<?php esc_attr_e('List View', 'cari-prop-shop'); ?>">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                    
                    <button class="filter-toggle-btn" id="filter-toggle">
                        <i class="fas fa-sliders-h"></i>
                        <?php esc_html_e('Filters', 'cari-prop-shop'); ?>
                    </button>
                </div>
            </div>

            <div class="filter-panel" id="filter-panel">
                <div class="filter-panel-header">
                    <h3><?php esc_html_e('Filter Properties', 'cari-prop-shop'); ?></h3>
                    <button class="filter-close" id="filter-close"><i class="fas fa-times"></i></button>
                </div>
                
                <form id="property-filter-form" class="filter-form" method="get" action="<?php echo esc_url(get_post_type_archive_link('property')); ?>">
                    <div class="filter-grid">
                        <div class="filter-group">
                            <label for="filter-status"><?php esc_html_e('Status', 'cari-prop-shop'); ?></label>
                            <select name="status" id="filter-status" class="filter-select">
                                <option value=""><?php esc_html_e('All Status', 'cari-prop-shop'); ?></option>
                                <?php foreach ($statuses as $status) : 
                                    $selected = ($filter_status === $status) ? 'selected' : '';
                                ?>
                                    <option value="<?php echo esc_attr($status); ?>" <?php echo $selected; ?>><?php echo esc_html($status); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="filter-type"><?php esc_html_e('Property Type', 'cari-prop-shop'); ?></label>
                            <select name="type" id="filter-type" class="filter-select">
                                <option value=""><?php esc_html_e('All Types', 'cari-prop-shop'); ?></option>
                                <?php if ($property_types) : foreach ($property_types as $type) : 
                                    $selected = ($filter_type === $type->slug) ? 'selected' : '';
                                ?>
                                    <option value="<?php echo esc_attr($type->slug); ?>" <?php echo $selected; ?>><?php echo esc_html($type->name); ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="filter-location"><?php esc_html_e('Location', 'cari-prop-shop'); ?></label>
                            <select name="location" id="filter-location" class="filter-select">
                                <option value=""><?php esc_html_e('All Locations', 'cari-prop-shop'); ?></option>
                                <?php if ($locations) : foreach ($locations as $loc) : 
                                    $selected = ($filter_location === $loc->slug) ? 'selected' : '';
                                ?>
                                    <option value="<?php echo esc_attr($loc->slug); ?>" <?php echo $selected; ?>><?php echo esc_html($loc->name); ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="filter-beds"><?php esc_html_e('Bedrooms', 'cari-prop-shop'); ?></label>
                            <select name="beds" id="filter-beds" class="filter-select">
                                <option value=""><?php esc_html_e('Any', 'cari-prop-shop'); ?></option>
                                <?php foreach ($bedrooms_options as $bed) : 
                                    $selected = ($filter_beds == $bed) ? 'selected' : '';
                                ?>
                                    <option value="<?php echo esc_attr($bed); ?>" <?php echo $selected; ?>><?php echo esc_html($bed); ?>+</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="filter-baths"><?php esc_html_e('Bathrooms', 'cari-prop-shop'); ?></label>
                            <select name="baths" id="filter-baths" class="filter-select">
                                <option value=""><?php esc_html_e('Any', 'cari-prop-shop'); ?></option>
                                <?php foreach ($bathrooms_options as $bath) : 
                                    $selected = ($filter_baths == $bath) ? 'selected' : '';
                                ?>
                                    <option value="<?php echo esc_attr($bath); ?>" <?php echo $selected; ?>><?php echo esc_html($bath); ?>+</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="filter-group filter-group-price">
                            <label><?php esc_html_e('Price Range', 'cari-prop-shop'); ?></label>
                            <div class="price-range-inputs">
                                <input type="number" name="min_price" id="min-price" placeholder="Min" value="<?php echo esc_attr($filter_min_price); ?>" class="price-input">
                                <span class="price-separator">-</span>
                                <input type="number" name="max_price" id="max-price" placeholder="Max" value="<?php echo esc_attr($filter_max_price); ?>" class="price-input">
                            </div>
                        </div>
                    </div>
                    
                    <div class="filter-actions">
                        <button type="submit" class="btn-filter-apply">
                            <i class="fas fa-search"></i>
                            <?php esc_html_e('Apply Filters', 'cari-prop-shop'); ?>
                        </button>
                        <a href="<?php echo esc_url(get_post_type_archive_link('property')); ?>" class="btn-filter-reset">
                            <i class="fas fa-redo"></i>
                            <?php esc_html_e('Reset', 'cari-prop-shop'); ?>
                        </a>
                    </div>
                </form>
            </div>

            <div class="property-content-area">
                <div class="property-grid-view property-<?php echo esc_attr($view_mode); ?>">
                    <?php if ($properties_query->have_posts()) : ?>
                        <?php while ($properties_query->have_posts()) : $properties_query->the_post();
                            $property_id = get_the_ID();
                            $thumb_url = get_the_post_thumbnail_url($property_id, 'large');
                            $price = cps_get_property_price($property_id);
                            $location = cps_get_property_location($property_id);
                            $bedrooms = get_post_meta($property_id, 'cps_bedrooms', true);
                            $bathrooms = get_post_meta($property_id, 'cps_bathrooms', true);
                            $area = get_post_meta($property_id, 'cps_area', true);
                            $status = get_post_meta($property_id, 'cps_status', true);
                            $is_favorite = cps_is_favorite($property_id);
                            $agent_id = get_post_meta($property_id, 'cps_agent', true);
                            $agent = $agent_id ? get_user_by('id', $agent_id) : null;
                            $garage = get_post_meta($property_id, 'cps_garage', true);
                            $year_built = get_post_meta($property_id, 'cps_year_built', true);
                            $property_type = wp_get_post_terms($property_id, 'property_type');
                            $type_name = !empty($property_type) ? $property_type[0]->name : '';
                        ?>
                            <article class="property-card" data-property-id="<?php echo esc_attr($property_id); ?>">
                                <div class="property-card-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php if ($thumb_url) : ?>
                                            <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                                        <?php else : ?>
                                            <div class="property-placeholder">
                                                <i class="fas fa-home"></i>
                                            </div>
                                        <?php endif; ?>
                                    </a>
                                    
                                    <?php if ($status) : ?>
                                        <span class="property-status-badge status-<?php echo esc_attr(strtolower(str_replace(' ', '-', $status))); ?>">
                                            <?php echo esc_html($status); ?>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <div class="property-card-actions">
                                        <button class="favorite-btn <?php echo $is_favorite ? 'favorited' : ''; ?>" 
                                                data-property-id="<?php echo esc_attr($property_id); ?>"
                                                title="<?php echo $is_favorite ? __('Remove from favorites', 'cari-prop-shop') : __('Add to favorites', 'cari-prop-shop'); ?>">
                                            <i class="<?php echo $is_favorite ? 'fas' : 'far'; ?> fa-heart"></i>
                                        </button>
                                        
                                        <button class="compare-btn" data-property-id="<?php echo esc_attr($property_id); ?>" title="<?php esc_attr_e('Add to compare', 'cari-prop-shop'); ?>">
                                            <i class="far fa-plus-square"></i>
                                        </button>
                                        
                                        <div class="share-dropdown">
                                            <button class="share-trigger" title="<?php esc_attr_e('Share', 'cari-prop-shop'); ?>">
                                                <i class="fas fa-share-alt"></i>
                                            </button>
                                            <div class="share-menu">
                                                <a href="#" class="share-btn" data-platform="facebook"><i class="fab fa-facebook-f"></i></a>
                                                <a href="#" class="share-btn" data-platform="twitter"><i class="fab fa-twitter"></i></a>
                                                <a href="#" class="share-btn" data-platform="whatsapp"><i class="fab fa-whatsapp"></i></a>
                                                <a href="#" class="share-btn" data-platform="copy"><i class="fas fa-link"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <?php if ($agent) : ?>
                                        <div class="property-card-agent">
                                            <?php echo get_avatar($agent->ID, 50, '', $agent->display_name, array('class' => 'agent-avatar')); ?>
                                            <span class="agent-name"><?php echo esc_html($agent->display_name); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="property-card-content">
                                    <div class="property-card-header">
                                        <div class="property-card-price">
                                            <?php echo $price; ?>
                                        </div>
                                        <?php if ($type_name) : ?>
                                            <span class="property-type-label"><?php echo esc_html($type_name); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <h3 class="property-card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    
                                    <?php if ($location) : ?>
                                        <div class="property-card-location">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span><?php echo esc_html($location); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="property-card-meta">
                                        <?php if ($bedrooms) : ?>
                                            <div class="meta-item">
                                                <i class="fas fa-bed"></i>
                                                <span><?php echo esc_html($bedrooms); ?></span>
                                                <span class="meta-label"><?php esc_html_e('Beds', 'cari-prop-shop'); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($bathrooms) : ?>
                                            <div class="meta-item">
                                                <i class="fas fa-bath"></i>
                                                <span><?php echo esc_html($bathrooms); ?></span>
                                                <span class="meta-label"><?php esc_html_e('Baths', 'cari-prop-shop'); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($area) : ?>
                                            <div class="meta-item">
                                                <i class="fas fa-ruler-combined"></i>
                                                <span><?php echo esc_html($area); ?></span>
                                                <span class="meta-label">m²</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="property-card-footer">
                                        <div class="property-features">
                                            <?php if ($garage) : ?>
                                                <span class="feature-tag"><i class="fas fa-car"></i> <?php echo esc_html($garage); ?></span>
                                            <?php endif; ?>
                                            <?php if ($year_built) : ?>
                                                <span class="feature-tag"><i class="far fa-calendar"></i> <?php echo esc_html($year_built); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <a href="<?php the_permalink(); ?>" class="btn-view-property">
                                            <?php esc_html_e('View Details', 'cari-prop-shop'); ?>
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <div class="no-properties-found">
                            <div class="no-properties-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h3><?php esc_html_e('No Properties Found', 'cari-prop-shop'); ?></h3>
                            <p><?php esc_html_e('Try adjusting your filters or search criteria to find more properties.', 'cari-prop-shop'); ?></p>
                            <a href="<?php echo esc_url(get_post_type_archive_link('property')); ?>" class="btn-reset-filters">
                                <?php esc_html_e('Reset Filters', 'cari-prop-shop'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($properties_query->max_num_pages > 1) : ?>
                    <div class="pagination-wrapper">
                        <?php
                        $big = 999999999;
                        echo paginate_links(array(
                            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                            'format' => '?paged=%#%',
                            'current' => max(1, get_query_var('paged')),
                            'total' => $properties_query->max_num_pages,
                            'prev_text' => '<i class="fas fa-chevron-left"></i>',
                            'next_text' => '<i class="fas fa-chevron-right"></i>',
                            'mid_size' => 2,
                        ));
                        ?>
                    </div>
                <?php endif; ?>

                <?php wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var viewBtns = document.querySelectorAll('.view-btn');
    var viewMode = '<?php echo esc_js($view_mode); ?>';
    
    viewBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var view = this.dataset.view;
            
            viewBtns.forEach(function(b) { b.classList.remove('active'); });
            this.classList.add('active');
            
            var grid = document.querySelector('.property-grid-view');
            grid.classList.remove('property-grid', 'property-list');
            grid.classList.add('property-' + view);
            
            var d = new Date();
            d.setTime(d.getTime() + (30 * 24 * 60 * 60 * 1000));
            document.cookie = 'property_view=' + view + ';expires=' + d.toUTCString() + ';path=/';
        });
    });
    
    var filterToggle = document.getElementById('filter-toggle');
    var filterClose = document.getElementById('filter-close');
    var filterPanel = document.getElementById('filter-panel');
    
    if (filterToggle && filterPanel) {
        filterToggle.addEventListener('click', function() {
            filterPanel.classList.toggle('active');
            document.body.classList.toggle('filter-panel-open');
        });
    }
    
    if (filterClose && filterPanel) {
        filterClose.addEventListener('click', function() {
            filterPanel.classList.remove('active');
            document.body.classList.remove('filter-panel-open');
        });
    }
    
    var sortSelect = document.getElementById('sort-select');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            window.location.href = this.value;
        });
    }
});
</script>

<?php get_footer(); ?>
