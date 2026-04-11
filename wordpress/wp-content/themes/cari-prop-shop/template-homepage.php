<?php
/**
 * Template Name: Homepage CariPropShop
 */

get_header();

// Get settings
$hero_title = get_theme_mod('cps_hero_title', 'TRUSTED PARTNER IN EVERY PROPERTY JOURNEY');
$hero_subtitle = get_theme_mod('cps_hero_subtitle', 'Find your dream property with us');
?>

<main id="main" class="site-main">
    
    <!-- Hero Section -->
    <section class="hero-wrap" style="background: linear-gradient(135deg, rgba(0, 66, 116, 0.85), rgba(0, 66, 116, 0.7)), url('https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=1920') center/cover no-repeat fixed;">
        <div class="container">
            <div class="hero-content text-center">
                <h1><?php echo esc_html($hero_title); ?></h1>
                
                <!-- Search Tabs -->
                <div class="search-tabs-wrap">
                    <ul class="nav search-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#for-sale" role="tab"><?php _e('For Sale', 'cari-prop-shop'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#for-rent" role="tab"><?php _e('For Rent', 'cari-prop-shop'); ?></a>
                        </li>
                    </ul>
                    
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="for-sale" role="tabpanel">
                            <form action="<?php echo esc_url(home_url('/properties/')); ?>" method="get" class="search-form">
                                <input type="hidden" name="status" value="sale">
                                <div class="search-fields">
                                    <div class="search-field">
                                        <input type="text" name="s" placeholder="<?php esc_attr_e('Keyword...', 'cari-prop-shop'); ?>">
                                    </div>
                                    <div class="search-field">
                                        <select name="type">
                                            <option value=""><?php _e('Property Type', 'cari-prop-shop'); ?></option>
                                            <option value="house"><?php _e('House', 'cari-prop-shop'); ?></option>
                                            <option value="apartment"><?php _e('Apartment', 'cari-prop-shop'); ?></option>
                                            <option value="villa"><?php _e('Villa', 'cari-prop-shop'); ?></option>
                                            <option value="land"><?php _e('Land', 'cari-prop-shop'); ?></option>
                                            <option value="commercial"><?php _e('Commercial', 'cari-prop-shop'); ?></option>
                                        </select>
                                    </div>
                                    <div class="search-field">
                                        <select name="city">
                                            <option value=""><?php _e('Location', 'cari-prop-shop'); ?></option>
                                            <option value="jakarta-selatan">Jakarta Selatan</option>
                                            <option value="jakarta-pusat">Jakarta Pusat</option>
                                            <option value="jakarta-barat">Jakarta Barat</option>
                                            <option value="jakarta-timur">Jakarta Timur</option>
                                            <option value="jakarta-utara">Jakarta Utara</option>
                                            <option value="tangerang">Tangerang</option>
                                            <option value="bandung">Bandung</option>
                                            <option value="bali">Bali</option>
                                        </select>
                                    </div>
                                    <div class="search-field">
                                        <select name="bedrooms">
                                            <option value=""><?php _e('Beds', 'cari-prop-shop'); ?></option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5+</option>
                                        </select>
                                    </div>
                                    <div class="search-field search-btn">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> <?php _e('Search', 'cari-prop-shop'); ?>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <div class="tab-pane fade" id="for-rent" role="tabpanel">
                            <form action="<?php echo esc_url(home_url('/properties/')); ?>" method="get" class="search-form">
                                <input type="hidden" name="status" value="rent">
                                <div class="search-fields">
                                    <div class="search-field">
                                        <input type="text" name="s" placeholder="<?php esc_attr_e('Keyword...', 'cari-prop-shop'); ?>">
                                    </div>
                                    <div class="search-field">
                                        <select name="type">
                                            <option value=""><?php _e('Property Type', 'cari-prop-shop'); ?></option>
                                            <option value="house"><?php _e('House', 'cari-prop-shop'); ?></option>
                                            <option value="apartment"><?php _e('Apartment', 'cari-prop-shop'); ?></option>
                                            <option value="villa"><?php _e('Villa', 'cari-prop-shop'); ?></option>
                                            <option value="commercial"><?php _e('Commercial', 'cari-prop-shop'); ?></option>
                                        </select>
                                    </div>
                                    <div class="search-field">
                                        <select name="city">
                                            <option value=""><?php _e('Location', 'cari-prop-shop'); ?></option>
                                            <option value="jakarta-selatan">Jakarta Selatan</option>
                                            <option value="jakarta-pusat">Jakarta Pusat</option>
                                            <option value="tangerang">Tangerang</option>
                                            <option value="bandung">Bandung</option>
                                            <option value="bali">Bali</option>
                                        </select>
                                    </div>
                                    <div class="search-field">
                                        <select name="bedrooms">
                                            <option value=""><?php _e('Beds', 'cari-prop-shop'); ?></option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                    </div>
                                    <div class="search-field search-btn">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> <?php _e('Search', 'cari-prop-shop'); ?>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Services Section -->
    <section class="section services-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="service-block">
                        <div class="service-icon">
                            <i class="fas fa-home"></i>
                        </div>
                        <h3><?php _e('Sell your home', 'cari-prop-shop'); ?></h3>
                        <p><?php _e('Get the best value for your property with our expert selling services.', 'cari-prop-shop'); ?></p>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4">
                    <a href="<?php echo esc_url(add_query_arg(array('status' => 'rent'), home_url('/properties/'))); ?>" class="service-block">
                        <div class="service-icon">
                            <i class="fas fa-key"></i>
                        </div>
                        <h3><?php _e('Rent a place', 'cari-prop-shop'); ?></h3>
                        <p><?php _e('Find your perfect rental property from our extensive listings.', 'cari-prop-shop'); ?></p>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4">
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="service-block">
                        <div class="service-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3><?php _e('Need Help?', 'cari-prop-shop'); ?></h3>
                        <p><?php _e('Our team is here to assist you with all your property needs.', 'cari-prop-shop'); ?></p>
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Featured Properties -->
    <section class="section featured-properties">
        <div class="container">
            <div class="section-title text-center">
                <h2><?php _e('Featured Properties', 'cari-prop-shop'); ?></h2>
                <p><?php _e('Homes and investment opportunities', 'cari-prop-shop'); ?></p>
            </div>
            
            <?php
            $featured = new WP_Query(array(
                'post_type' => 'property',
                'posts_per_page' => 8,
                'meta_key' => 'cps_price',
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
            ));
            
            if ($featured->have_posts()) :
            ?>
                <div class="property-grid">
                    <?php while ($featured->have_posts()) : $featured->the_post(); 
                        $price = get_post_meta(get_the_ID(), 'cps_price', true);
                        $bedrooms = get_post_meta(get_the_ID(), 'cps_bedrooms', true);
                        $bathrooms = get_post_meta(get_the_ID(), 'cps_bathrooms', true);
                        $area = get_post_meta(get_the_ID(), 'cps_area', true);
                        $status = get_the_terms(get_the_ID(), 'property_status');
                        $city = get_the_terms(get_the_ID(), 'property_city');
                    ?>
                        <article class="property-item">
                            <div class="property-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                <?php else : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <div class="property-placeholder">
                                            <i class="fas fa-home"></i>
                                        </div>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($status) : ?>
                                    <span class="property-label <?php echo esc_attr($status[0]->slug); ?>">
                                        <?php echo esc_html($status[0]->name); ?>
                                    </span>
                                <?php endif; ?>
                                
                                <div class="property-actions">
                                    <button class="btn-favorite" data-id="<?php the_ID(); ?>">
                                        <i class="far fa-heart"></i>
                                    </button>
                                    <button class="btn-compare" data-id="<?php the_ID(); ?>">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="property-content">
                                <div class="property-price">
                                    <?php if ($price) : ?>
                                        Rp <?php echo number_format($price, 0, ',', '.'); ?>
                                    <?php else : ?>
                                        <?php _e('Price on Request', 'cari-prop-shop'); ?>
                                    <?php endif; ?>
                                </div>
                                
                                <h3 class="property-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                
                                <div class="property-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <?php if ($city) echo esc_html($city[0]->name); ?>
                                </div>
                                
                                <div class="property-meta">
                                    <?php if ($bedrooms) : ?>
                                        <span><i class="fas fa-bed"></i> <?php echo esc_html($bedrooms); ?></span>
                                    <?php endif; ?>
                                    <?php if ($bathrooms) : ?>
                                        <span><i class="fas fa-bath"></i> <?php echo esc_html($bathrooms); ?></span>
                                    <?php endif; ?>
                                    <?php if ($area) : ?>
                                        <span><i class="fas fa-ruler-combined"></i> <?php echo esc_html($area); ?> m²</span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="property-footer">
                                    <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-block">
                                        <?php _e('View Details', 'cari-prop-shop'); ?>
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
                <?php wp_reset_postdata(); ?>
                
                <div class="text-center" style="margin-top: 40px;">
                    <a href="<?php echo esc_url(home_url('/properties/')); ?>" class="btn btn-outline btn-lg">
                        <?php _e('View All Properties', 'cari-prop-shop'); ?>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            <?php else : ?>
                <div class="empty-state text-center">
                    <i class="fas fa-home fa-3x"></i>
                    <h3><?php _e('No Properties Found', 'cari-prop-shop'); ?></h3>
                    <p><?php _e('Check back soon for new listings!', 'cari-prop-shop'); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="section cta-section" style="background: linear-gradient(135deg, #004274, #00365e);">
        <div class="container">
            <div class="cta-content text-center">
                <h2><?php _e('Ready to Find Your Dream Property?', 'cari-prop-shop'); ?></h2>
                <p><?php _e('Contact us today and let our experts help you find the perfect property.', 'cari-prop-shop'); ?></p>
                <div class="cta-buttons">
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-primary btn-lg">
                        <i class="fas fa-envelope"></i> <?php _e('Contact Us', 'cari-prop-shop'); ?>
                    </a>
                    <a href="tel:+622112345678" class="btn btn-outline btn-lg" style="border-color: #fff; color: #fff;">
                        <i class="fas fa-phone"></i> <?php _e('Call Now', 'cari-prop-shop'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>

<style>
/* Hero Section */
.hero-wrap {
    min-height: 600px;
    display: flex;
    align-items: center;
    padding: 100px 0;
}

.hero-content h1 {
    font-size: 3rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 10px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.hero-content h1::before {
    content: 'TRUSTED PARTNER IN EVERY PROPERTY JOURNEY';
    display: block;
    font-size: 0.4em;
    font-weight: 400;
    letter-spacing: 2px;
    margin-bottom: 15px;
}

/* Search Tabs */
.search-tabs-wrap {
    background: #fff;
    border-radius: 8px;
    padding: 30px;
    margin-top: 40px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
}

.search-tabs {
    border-bottom: 2px solid #eee;
    margin-bottom: 20px;
    justify-content: center;
}

.search-tabs .nav-link {
    font-family: var(--cps-font-nav);
    font-size: 16px;
    text-transform: uppercase;
    color: var(--cps-gray-700);
    padding: 12px 40px;
    border: none;
    border-bottom: 3px solid transparent;
    border-radius: 0;
}

.search-tabs .nav-link.active {
    color: var(--cps-primary);
    border-bottom-color: var(--cps-primary);
    background: transparent;
}

.search-fields {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.search-field {
    flex: 1;
    min-width: 150px;
}

.search-field input,
.search-field select {
    width: 100%;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.search-field.search-btn {
    flex: 0 0 auto;
}

.search-field.search-btn .btn {
    padding: 15px 30px;
    width: 100%;
}

/* Services Section */
.services-section {
    padding: 60px 0;
    background: #fff;
}

.service-block {
    display: block;
    text-align: center;
    padding: 40px 20px;
    border-radius: 8px;
    transition: all 0.3s;
    border: 1px solid #eee;
}

.service-block:hover {
    border-color: var(--cps-primary);
    box-shadow: 0 10px 30px rgba(0,174,239,0.1);
    transform: translateY(-5px);
}

.service-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--cps-primary), #0095cc);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.service-icon i {
    font-size: 30px;
    color: #fff;
}

.service-block h3 {
    font-size: 18px;
    margin-bottom: 10px;
    color: var(--cps-gray-900);
}

.service-block p {
    font-size: 14px;
    color: var(--cps-gray-600);
    margin: 0;
}

/* Property Grid */
.property-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 25px;
    margin-top: 40px;
}

.property-item {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: all 0.3s;
}

.property-item:hover {
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transform: translateY(-5px);
}

.property-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.property-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.property-placeholder {
    width: 100%;
    height: 100%;
    background: #eee;
    display: flex;
    align-items: center;
    justify-content: center;
}

.property-placeholder i {
    font-size: 50px;
    color: #ccc;
}

.property-label {
    position: absolute;
    top: 15px;
    left: 15px;
    padding: 5px 15px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    color: #fff;
}

.property-label.sale { background: var(--cps-primary); }
.property-label.rent { background: var(--cps-secondary); }
.property-label.featured { background: #61ce70; }

.property-actions {
    position: absolute;
    top: 15px;
    right: 15px;
    display: flex;
    gap: 5px;
}

.property-actions button {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: #fff;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
}

.property-actions button:hover {
    background: var(--cps-primary);
    color: #fff;
}

.property-content {
    padding: 20px;
}

.property-price {
    font-size: 20px;
    font-weight: 700;
    color: var(--cps-primary);
    margin-bottom: 10px;
}

.property-title {
    font-size: 16px;
    margin-bottom: 10px;
}

.property-title a {
    color: var(--cps-gray-900);
    transition: color 0.3s;
}

.property-title a:hover {
    color: var(--cps-primary);
}

.property-location {
    font-size: 13px;
    color: var(--cps-gray-500);
    margin-bottom: 15px;
}

.property-location i {
    color: var(--cps-primary);
    margin-right: 5px;
}

.property-meta {
    display: flex;
    gap: 15px;
    font-size: 13px;
    color: var(--cps-gray-600);
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
    margin-bottom: 15px;
}

.property-meta span {
    display: flex;
    align-items: center;
    gap: 5px;
}

.property-meta i {
    color: var(--cps-primary);
}

.property-footer .btn {
    padding: 12px;
}

/* CTA Section */
.cta-section {
    padding: 80px 0;
}

.cta-content h2 {
    font-size: 2.5rem;
    color: #fff;
    margin-bottom: 15px;
}

.cta-content p {
    font-size: 1.1rem;
    color: rgba(255,255,255,0.9);
    margin-bottom: 30px;
}

.cta-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
}

.btn-outline {
    background: transparent;
    border: 2px solid var(--cps-primary);
    color: var(--cps-primary);
}

.btn-outline:hover {
    background: var(--cps-primary);
    color: #fff;
}

/* Section Title */
.section-title {
    margin-bottom: 40px;
}

.section-title h2 {
    font-size: 2rem;
    color: var(--cps-gray-900);
    margin-bottom: 10px;
}

.section-title p {
    font-size: 1.1rem;
    color: var(--cps-gray-500);
}

/* Responsive */
@media (max-width: 1200px) {
    .property-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 992px) {
    .property-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .hero-content h1 {
        font-size: 2.5rem;
    }
}

@media (max-width: 768px) {
    .property-grid {
        grid-template-columns: 1fr;
    }
    
    .search-fields {
        flex-direction: column;
    }
    
    .search-field {
        min-width: 100%;
    }
    
    .hero-content h1 {
        font-size: 2rem;
    }
    
    .hero-wrap {
        min-height: auto;
        padding: 60px 0;
    }
}
</style>

<?php get_footer(); ?>
