<?php
/**
 * Template Name: Custom Homepage
 */

get_header();

// Get hero background image from theme options or use default
$hero_image = get_theme_mod('cps_hero_image', 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=1920');
$hero_title = get_theme_mod('cps_hero_title', __('Find Your Dream Property', 'cari-prop-shop'));
$hero_subtitle = get_theme_mod('cps_hero_subtitle', __('Discover thousands of properties for sale and rent across Indonesia', 'cari-prop-shop'));
?>

<main id="main" class="site-main">
    
    <!-- Hero Section -->
    <section class="hero-section" style="background: linear-gradient(135deg, rgba(37, 99, 235, 0.9), rgba(124, 58, 237, 0.9)), url('<?php echo esc_url($hero_image); ?>') center/cover no-repeat;">
        <div class="container">
            <div class="hero-content">
                <h1><?php echo esc_html($hero_title); ?></h1>
                <p class="hero-subtitle"><?php echo esc_html($hero_subtitle); ?></p>
                
                <div class="hero-search">
                    <form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="hero-search-form">
                        <input type="hidden" name="post_type" value="property">
                        <div class="search-row">
                            <input type="text" name="s" placeholder="<?php esc_attr_e('Search by location, property name...', 'cari-prop-shop'); ?>" class="search-input">
                            <select name="type" class="search-select">
                                <option value=""><?php _e('Property Type', 'cari-prop-shop'); ?></option>
                                <option value="house"><?php _e('House', 'cari-prop-shop'); ?></option>
                                <option value="apartment"><?php _e('Apartment', 'cari-prop-shop'); ?></option>
                                <option value="villa"><?php _e('Villa', 'cari-prop-shop'); ?></option>
                                <option value="land"><?php _e('Land', 'cari-prop-shop'); ?></option>
                                <option value="commercial"><?php _e('Commercial', 'cari-prop-shop'); ?></option>
                            </select>
                            <select name="status" class="search-select">
                                <option value=""><?php _e('Status', 'cari-prop-shop'); ?></option>
                                <option value="sale"><?php _e('For Sale', 'cari-prop-shop'); ?></option>
                                <option value="rent"><?php _e('For Rent', 'cari-prop-shop'); ?></option>
                            </select>
                            <button type="submit" class="btn btn-primary search-btn">
                                <i class="fas fa-search"></i> <?php _e('Search', 'cari-prop-shop'); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Property Types -->
    <section class="section section-light">
        <div class="container">
            <div class="section-header text-center">
                <h2><?php _e('Browse by Property Type', 'cari-prop-shop'); ?></h2>
                <p><?php _e('Find exactly what you are looking for', 'cari-prop-shop'); ?></p>
            </div>
            
            <div class="property-types-grid">
                <?php
                $types = array(
                    array('slug' => 'house', 'icon' => 'fa-home', 'name' => 'Houses'),
                    array('slug' => 'apartment', 'icon' => 'fa-building', 'name' => 'Apartments'),
                    array('slug' => 'villa', 'icon' => 'fa-swimming-pool', 'name' => 'Villas'),
                    array('slug' => 'land', 'icon' => 'fa-mountain', 'name' => 'Land'),
                    array('slug' => 'commercial', 'icon' => 'fa-store', 'name' => 'Commercial'),
                );
                foreach ($types as $type) :
                ?>
                    <a href="<?php echo esc_url(add_query_arg(array('type' => $type['slug']), home_url('/'))); ?>" class="property-type-card">
                        <div class="type-icon">
                            <i class="fas <?php echo esc_attr($type['icon']); ?>"></i>
                        </div>
                        <h3><?php echo esc_html($type['name']); ?></h3>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <!-- Featured Properties -->
    <section class="section section-white">
        <div class="container">
            <div class="section-header">
                <h2><?php _e('Featured Properties', 'cari-prop-shop'); ?></h2>
                <a href="<?php echo esc_url(home_url('/?post_type=property')); ?>" class="view-all-link">
                    <?php _e('View All Properties', 'cari-prop-shop'); ?> <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
            <?php
            $featured_properties = new WP_Query(array(
                'post_type' => 'property',
                'posts_per_page' => 6,
            ));
            
            if ($featured_properties->have_posts()) :
            ?>
                <div class="property-grid property-grid-3">
                    <?php while ($featured_properties->have_posts()) : $featured_properties->the_post(); ?>
                        <article class="property-card">
                            <div class="property-card-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('property-thumbnail'); ?>
                                    </a>
                                <?php else : ?>
                                    <div class="property-placeholder">
                                        <i class="fas fa-home"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="property-card-overlay">
                                    <?php
                                    $status = get_the_terms(get_the_ID(), 'property_status');
                                    if ($status && !is_wp_error($status)) {
                                        echo '<span class="property-status status-' . esc_attr($status[0]->slug) . '">' . esc_html($status[0]->name) . '</span>';
                                    }
                                    ?>
                                </div>
                            </div>
                            
                            <div class="property-card-content">
                                <div class="property-card-price">
                                    <?php echo cps_get_property_price(); ?>
                                </div>
                                <h3 class="property-card-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <?php $location = cps_get_property_location(); ?>
                                <?php if ($location) : ?>
                                    <div class="property-card-location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span><?php echo esc_html($location); ?></span>
                                    </div>
                                <?php endif; ?>
                                <div class="property-card-meta">
                                    <?php $bedrooms = get_post_meta(get_the_ID(), 'cps_bedrooms', true); ?>
                                    <?php if ($bedrooms) : ?>
                                        <span class="meta-item"><i class="fas fa-bed"></i> <?php echo esc_html($bedrooms); ?></span>
                                    <?php endif; ?>
                                    <?php $bathrooms = get_post_meta(get_the_ID(), 'cps_bathrooms', true); ?>
                                    <?php if ($bathrooms) : ?>
                                        <span class="meta-item"><i class="fas fa-bath"></i> <?php echo esc_html($bathrooms); ?></span>
                                    <?php endif; ?>
                                    <?php $area = get_post_meta(get_the_ID(), 'cps_area', true); ?>
                                    <?php if ($area) : ?>
                                        <span class="meta-item"><i class="fas fa-ruler-combined"></i> <?php echo esc_html($area); ?> m²</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <div class="empty-state">
                    <i class="fas fa-home"></i>
                    <h3><?php _e('No properties yet', 'cari-prop-shop'); ?></h3>
                    <p><?php _e('Demo content will be available after running the demo content generator.', 'cari-prop-shop'); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- Services Section -->
    <section class="section section-gradient">
        <div class="container">
            <div class="section-header text-center">
                <h2><?php _e('Our Services', 'cari-prop-shop'); ?></h2>
                <p><?php _e('Professional real estate services tailored for you', 'cari-prop-shop'); ?></p>
            </div>
            
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-search"></i></div>
                    <h3><?php _e('Property Search', 'cari-prop-shop'); ?></h3>
                    <p><?php _e('Find your perfect property from our extensive listings database.', 'cari-prop-shop'); ?></p>
                </div>
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-chart-line"></i></div>
                    <h3><?php _e('Market Analysis', 'cari-prop-shop'); ?></h3>
                    <p><?php _e('Get detailed market insights and property valuations.', 'cari-prop-shop'); ?></p>
                </div>
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-handshake"></i></div>
                    <h3><?php _e('Buying & Selling', 'cari-prop-shop'); ?></h3>
                    <p><?php _e('Expert assistance through every step of the transaction.', 'cari-prop-shop'); ?></p>
                </div>
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-key"></i></div>
                    <h3><?php _e('Property Management', 'cari-prop-shop'); ?></h3>
                    <p><?php _e('Full-service property management for landlords and investors.', 'cari-prop-shop'); ?></p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Stats Section -->
    <section class="section section-dark">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-number">500+</span>
                    <span class="stat-label"><?php _e('Properties Listed', 'cari-prop-shop'); ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">100+</span>
                    <span class="stat-label"><?php _e('Happy Clients', 'cari-prop-shop'); ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">50+</span>
                    <span class="stat-label"><?php _e('Expert Agents', 'cari-prop-shop'); ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">10+</span>
                    <span class="stat-label"><?php _e('Years Experience', 'cari-prop-shop'); ?></span>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="section cta-section" style="background: linear-gradient(135deg, var(--cps-primary), var(--cps-secondary));">
        <div class="container text-center">
            <h2><?php _e('Ready to Find Your Dream Property?', 'cari-prop-shop'); ?></h2>
            <p><?php _e('Contact us today and let our experts help you find the perfect property.', 'cari-prop-shop'); ?></p>
            <div class="cta-buttons">
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-white">
                    <i class="fas fa-envelope"></i> <?php _e('Contact Us', 'cari-prop-shop'); ?>
                </a>
                <a href="<?php echo esc_url(home_url('/register')); ?>" class="btn btn-outline-white">
                    <?php _e('Create Account', 'cari-prop-shop'); ?>
                </a>
            </div>
        </div>
    </section>
    
</main>

<style>
.hero-search-form .search-row {
    display: flex;
    gap: 10px;
    background: white;
    padding: 10px;
    border-radius: 10px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
}
.hero-search-form .search-input {
    flex: 2;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
}
.hero-search-form .search-select {
    flex: 1;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
    background: white;
}
.hero-search-form .search-btn { padding: 15px 30px; }
.property-types-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 20px;
}
.property-type-card {
    background: white;
    padding: 30px 20px;
    border-radius: 10px;
    text-align: center;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}
.property-type-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}
.property-type-card .type-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, var(--cps-primary), var(--cps-secondary));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    font-size: 1.5rem;
    color: white;
}
.property-type-card h3 { margin: 0; font-size: 1rem; }
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
    text-align: center;
}
.stat-item .stat-number {
    display: block;
    font-size: 3rem;
    font-weight: 700;
    color: white;
    margin-bottom: 10px;
}
.stat-item .stat-label { color: rgba(255,255,255,0.8); font-size: 1rem; }
.btn-white { background: white; color: var(--cps-primary); }
.btn-outline-white { background: transparent; color: white; border: 2px solid white; }
.btn-outline-white:hover { background: white; color: var(--cps-primary); }
.cta-buttons { display: flex; gap: 15px; justify-content: center; margin-top: 30px; }
@media (max-width: 768px) {
    .hero-search-form .search-row { flex-direction: column; }
    .property-types-grid { grid-template-columns: repeat(2, 1fr); }
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>

<?php get_footer(); ?>
