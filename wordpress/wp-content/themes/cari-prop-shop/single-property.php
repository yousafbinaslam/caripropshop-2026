<?php
/**
 * Single Property Template - CariPropShop
 */

get_header();

while (have_posts()) :
    the_post();
    
    $property_id = get_the_ID();
    $price = get_post_meta($property_id, 'cps_price', true);
    $address = get_post_meta($property_id, 'cps_address', true);
    $city = get_post_meta($property_id, 'cps_city', true);
    $bedrooms = get_post_meta($property_id, 'cps_bedrooms', true);
    $bathrooms = get_post_meta($property_id, 'cps_bathrooms', true);
    $area = get_post_meta($property_id, 'cps_area', true);
    $land_area = get_post_meta($property_id, 'cps_land_area', true);
    $garage = get_post_meta($property_id, 'cps_garage', true);
    $year_built = get_post_meta($property_id, 'cps_year_built', true);
    $video_url = get_post_meta($property_id, 'cps_video_url', true);
    $gallery_ids = get_post_meta($property_id, 'cps_gallery', true);
    $latitude = get_post_meta($property_id, 'cps_latitude', true);
    $longitude = get_post_meta($property_id, 'cps_longitude', true);
    $status = get_post_meta($property_id, 'cps_status', true);
    $property_id_display = get_post_meta($property_id, 'cps_property_id', true);
    $garage = get_post_meta($property_id, 'cps_garage', true) ?: '0';
    
    $types = get_the_terms($property_id, 'property_type');
    $features = get_the_terms($property_id, 'property_feature');
    $status_terms = get_the_terms($property_id, 'property_status');
    $status_name = $status ?: ($status_terms && !is_wp_error($status_terms) ? $status_terms[0]->name : 'For Sale');
    $type_name = $types && !is_wp_error($types) ? $types[0]->name : '';
    
    $agent_id = get_post_meta($property_id, 'cps_agent', true);
    $agent = $agent_id ? get_user_by('id', $agent_id) : null;
    
    $formatted_price = $price ? 'Rp ' . number_format((int)$price, 0, ',', '.') : 'Price on Request';
    $formatted_area = $area ? number_format((int)$area, 0, ',', '.') : '';
    $formatted_land_area = $land_area ? number_format((int)$land_area, 0, ',', '.') : '';
    
    $gallery_images = array();
    if ($gallery_ids) {
        $gallery_ids_array = is_array($gallery_ids) ? $gallery_ids : explode(',', $gallery_ids);
        foreach ($gallery_ids_array as $img_id) {
            $img_id = trim($img_id);
            if (is_numeric($img_id)) {
                $full_url = wp_get_attachment_image_url($img_id, 'full');
                $thumb_url = wp_get_attachment_image_url($img_id, 'medium');
                if ($full_url) {
                    $gallery_images[] = array('full' => $full_url, 'thumb' => $thumb_url);
                }
            }
        }
    }
    
    $featured_image = get_the_post_thumbnail_url($property_id, 'large');
    if ($featured_image) {
        array_unshift($gallery_images, array('full' => $featured_image, 'thumb' => $featured_image));
    }
?>

<div class="property-single-page">
    <section class="property-gallery-section">
        <div class="gallery-container">
            <div class="gallery-main" id="gallery-main">
                <?php if ($featured_image) : ?>
                    <img src="<?php echo esc_url($featured_image); ?>" alt="<?php the_title_attribute(); ?>" id="main-image">
                <?php else : ?>
                    <div class="gallery-placeholder">
                        <i class="fas fa-home"></i>
                        <span>No Image Available</span>
                    </div>
                <?php endif; ?>
                
                <div class="gallery-overlay" id="gallery-overlay">
                    <button class="btn-view-gallery" id="open-gallery">
                        <i class="fas fa-images"></i>
                        <span><?php esc_html_e('View Gallery', 'cari-prop-shop'); ?></span>
                        <?php if (count($gallery_images) > 1) : ?>
                            <span class="photo-count"><?php echo count($gallery_images); ?> <?php esc_html_e('Photos', 'cari-prop-shop'); ?></span>
                        <?php endif; ?>
                    </button>
                </div>
                
                <?php if ($status) : ?>
                    <span class="property-status-badge status-<?php echo esc_attr(strtolower(str_replace(' ', '-', $status))); ?>">
                        <?php echo esc_html($status); ?>
                    </span>
                <?php endif; ?>
            </div>
            
            <?php if (count($gallery_images) > 1) : ?>
                <div class="gallery-thumbnails">
                    <?php foreach (array_slice($gallery_images, 1, 5) as $index => $img) : ?>
                        <div class="thumb-item" data-index="<?php echo $index + 1; ?>">
                            <img src="<?php echo esc_url($img['thumb']); ?>" alt="">
                        </div>
                    <?php endforeach; ?>
                    <?php if (count($gallery_images) > 6) : ?>
                        <div class="thumb-item thumb-more" id="open-gallery-thumb">
                            <span>+<?php echo count($gallery_images) - 6; ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="property-content-section">
        <div class="container">
            <div class="property-layout">
                <div class="property-main-content">
                    <div class="property-header-area">
                        <div class="property-header-info">
                            <?php if ($type_name) : ?>
                                <span class="property-type-badge"><?php echo esc_html($type_name); ?></span>
                            <?php endif; ?>
                            <h1 class="property-title"><?php the_title(); ?></h1>
                            <div class="property-location-info">
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?php echo esc_html($address); ?><?php echo $city ? ', ' . esc_html($city) : ''; ?></span>
                            </div>
                            <?php if ($property_id_display) : ?>
                                <div class="property-id-info">
                                    <span class="property-id-label"><?php esc_html_e('Property ID:', 'cari-prop-shop'); ?></span>
                                    <span class="property-id-value"><?php echo esc_html($property_id_display); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="property-header-actions">
                            <div class="property-price-box">
                                <span class="price-label"><?php echo esc_html($status_name); ?></span>
                                <span class="price-value"><?php echo esc_html($formatted_price); ?></span>
                                <?php if ($status === 'For Rent') : ?>
                                    <span class="price-period">/ <?php esc_html_e('month', 'cari-prop-shop'); ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="action-buttons">
                                <button class="btn-action favorite-btn <?php echo cps_is_favorite($property_id) ? 'favorited' : ''; ?>" data-property-id="<?php echo esc_attr($property_id); ?>">
                                    <i class="<?php echo cps_is_favorite($property_id) ? 'fas' : 'far'; ?> fa-heart"></i>
                                    <span><?php echo cps_is_favorite($property_id) ? __('Saved', 'cari-prop-shop') : __('Save', 'cari-prop-shop'); ?></span>
                                </button>
                                
                                <button class="btn-action compare-btn" data-property-id="<?php echo esc_attr($property_id); ?>">
                                    <i class="fas fa-balance-scale"></i>
                                    <span><?php esc_html_e('Compare', 'cari-prop-shop'); ?></span>
                                </button>
                                
                                <div class="share-dropdown">
                                    <button class="btn-action share-trigger">
                                        <i class="fas fa-share-alt"></i>
                                        <span><?php esc_html_e('Share', 'cari-prop-shop'); ?></span>
                                    </button>
                                    <div class="share-menu">
                                        <a href="#" class="share-btn" data-platform="facebook"><i class="fab fa-facebook-f"></i> Facebook</a>
                                        <a href="#" class="share-btn" data-platform="twitter"><i class="fab fa-twitter"></i> Twitter</a>
                                        <a href="#" class="share-btn" data-platform="whatsapp"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                                        <a href="#" class="share-btn" data-platform="telegram"><i class="fab fa-telegram-plane"></i> Telegram</a>
                                        <a href="#" class="share-btn" data-platform="email"><i class="fas fa-envelope"></i> Email</a>
                                        <a href="#" class="share-btn" data-platform="copy"><i class="fas fa-link"></i> Copy Link</a>
                                    </div>
                                </div>
                                
                                <button class="btn-action" onclick="window.print()">
                                    <i class="fas fa-print"></i>
                                    <span><?php esc_html_e('Print', 'cari-prop-shop'); ?></span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="property-specs-section">
                        <div class="specs-grid">
                            <?php if ($bedrooms) : ?>
                                <div class="spec-item">
                                    <div class="spec-icon"><i class="fas fa-bed"></i></div>
                                    <div class="spec-content">
                                        <span class="spec-value"><?php echo esc_html($bedrooms); ?></span>
                                        <span class="spec-label"><?php esc_html_e('Bedrooms', 'cari-prop-shop'); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($bathrooms) : ?>
                                <div class="spec-item">
                                    <div class="spec-icon"><i class="fas fa-bath"></i></div>
                                    <div class="spec-content">
                                        <span class="spec-value"><?php echo esc_html($bathrooms); ?></span>
                                        <span class="spec-label"><?php esc_html_e('Bathrooms', 'cari-prop-shop'); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($formatted_area) : ?>
                                <div class="spec-item">
                                    <div class="spec-icon"><i class="fas fa-ruler-combined"></i></div>
                                    <div class="spec-content">
                                        <span class="spec-value"><?php echo esc_html($formatted_area); ?></span>
                                        <span class="spec-label">m² <?php esc_html_e('Floor Area', 'cari-prop-shop'); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($formatted_land_area) : ?>
                                <div class="spec-item">
                                    <div class="spec-icon"><i class="fas fa-vector-square"></i></div>
                                    <div class="spec-content">
                                        <span class="spec-value"><?php echo esc_html($formatted_land_area); ?></span>
                                        <span class="spec-label">m² <?php esc_html_e('Land Area', 'cari-prop-shop'); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($garage && $garage !== '0') : ?>
                                <div class="spec-item">
                                    <div class="spec-icon"><i class="fas fa-car"></i></div>
                                    <div class="spec-content">
                                        <span class="spec-value"><?php echo esc_html($garage); ?></span>
                                        <span class="spec-label"><?php esc_html_e('Garage', 'cari-prop-shop'); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($year_built) : ?>
                                <div class="spec-item">
                                    <div class="spec-icon"><i class="fas fa-calendar-alt"></i></div>
                                    <div class="spec-content">
                                        <span class="spec-value"><?php echo esc_html($year_built); ?></span>
                                        <span class="spec-label"><?php esc_html_e('Year Built', 'cari-prop-shop'); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="property-description-section">
                        <h2 class="section-title"><?php esc_html_e('Description', 'cari-prop-shop'); ?></h2>
                        <div class="description-content">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <?php if ($features && !is_wp_error($features)) : ?>
                        <div class="property-features-section">
                            <h2 class="section-title"><?php esc_html_e('Features & Amenities', 'cari-prop-shop'); ?></h2>
                            <div class="features-grid">
                                <?php foreach ($features as $feature) : ?>
                                    <div class="feature-item">
                                        <i class="fas fa-check-circle"></i>
                                        <span><?php echo esc_html($feature->name); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($video_url) : ?>
                        <div class="property-video-section">
                            <h2 class="section-title"><?php esc_html_e('Video Tour', 'cari-prop-shop'); ?></h2>
                            <div class="video-container">
                                <?php
                                $video_id = '';
                                if (strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false) {
                                    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video_url, $matches)) {
                                        $video_id = $matches[1];
                                        echo '<iframe src="https://www.youtube.com/embed/' . esc_attr($video_id) . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                                    }
                                } elseif (strpos($video_url, 'vimeo.com') !== false) {
                                    if (preg_match('/vimeo\.com\/(\d+)/', $video_url, $matches)) {
                                        $video_id = $matches[1];
                                        echo '<iframe src="https://player.vimeo.com/video/' . esc_attr($video_id) . '" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($latitude && $longitude) : ?>
                        <div class="property-map-section">
                            <h2 class="section-title"><?php esc_html_e('Location', 'cari-prop-shop'); ?></h2>
                            <div class="map-container">
                                <div class="property-map" id="property-map" data-lat="<?php echo esc_attr($latitude); ?>" data-lng="<?php echo esc_attr($longitude); ?>"></div>
                                <div class="map-address">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span><?php echo esc_html($address); ?><?php echo $city ? ', ' . esc_html($city) : ''; ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <aside class="property-sidebar">
                    <div class="sidebar-sticky">
                        <?php if ($agent) : ?>
                            <div class="agent-card-widget">
                                <div class="agent-card-header">
                                    <h3><?php esc_html_e('Listed By', 'cari-prop-shop'); ?></h3>
                                </div>
                                <div class="agent-card-body">
                                    <div class="agent-profile">
                                        <div class="agent-avatar">
                                            <?php echo get_avatar($agent->ID, 100, '', $agent->display_name); ?>
                                        </div>
                                        <div class="agent-info">
                                            <h4 class="agent-name"><?php echo esc_html($agent->display_name); ?></h4>
                                            <?php 
                                            $agent_phone = get_user_meta($agent->ID, 'phone', true);
                                            $agent_email = $agent->user_email;
                                            if ($agent_phone) : ?>
                                                <p class="agent-phone"><i class="fas fa-phone"></i> <?php echo esc_html($agent_phone); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="agent-stats">
                                        <div class="stat-item">
                                            <span class="stat-value"><?php echo esc_html($agent->cps_properties_count ?? '0'); ?></span>
                                            <span class="stat-label"><?php esc_html_e('Listings', 'cari-prop-shop'); ?></span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-value"><?php echo esc_html($agent->cps_views_count ?? '0'); ?></span>
                                            <span class="stat-label"><?php esc_html_e('Views', 'cari-prop-shop'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="contact-form-widget">
                            <div class="widget-header">
                                <h3><?php esc_html_e('Request Information', 'cari-prop-shop'); ?></h3>
                            </div>
                            <div class="widget-body">
                                <?php echo do_shortcode('[cps_inquiry_form property_id="' . $property_id . '"]'); ?>
                            </div>
                        </div>

                        <div class="schedule-tour-widget">
                            <div class="widget-header">
                                <h3><i class="fas fa-calendar-check"></i> <?php esc_html_e('Schedule a Tour', 'cari-prop-shop'); ?></h3>
                            </div>
                            <div class="widget-body">
                                <form id="schedule-tour-form" class="ajax-form">
                                    <input type="hidden" name="action" value="cps_schedule_tour">
                                    <input type="hidden" name="property_id" value="<?php echo esc_attr($property_id); ?>">
                                    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('cps_nonce'); ?>">
                                    
                                    <div class="form-group">
                                        <input type="text" name="name" placeholder="<?php esc_attr_e('Your Name', 'cari-prop-shop'); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" placeholder="<?php esc_attr_e('Email Address', 'cari-prop-shop'); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="tel" name="phone" placeholder="<?php esc_attr_e('Phone Number', 'cari-prop-shop'); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="date" name="tour_date" min="<?php echo date('Y-m-d'); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <select name="tour_time" required>
                                            <option value=""><?php esc_html_e('Select Time', 'cari-prop-shop'); ?></option>
                                            <option value="09:00">09:00 AM</option>
                                            <option value="10:00">10:00 AM</option>
                                            <option value="11:00">11:00 AM</option>
                                            <option value="12:00">12:00 PM</option>
                                            <option value="13:00">01:00 PM</option>
                                            <option value="14:00">02:00 PM</option>
                                            <option value="15:00">03:00 PM</option>
                                            <option value="16:00">04:00 PM</option>
                                            <option value="17:00">05:00 PM</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <textarea name="message" rows="3" placeholder="<?php esc_attr_e('Additional Notes', 'cari-prop-shop'); ?>"></textarea>
                                    </div>
                                    <button type="submit" class="btn-submit-tour">
                                        <i class="fas fa-calendar-plus"></i>
                                        <?php esc_html_e('Schedule Tour', 'cari-prop-shop'); ?>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="mortgage-calculator-widget">
                            <div class="widget-header">
                                <h3><i class="fas fa-calculator"></i> <?php esc_html_e('Mortgage Calculator', 'cari-prop-shop'); ?></h3>
                            </div>
                            <div class="widget-body">
                                <?php echo do_shortcode('[cps_mortgage_calculator price="' . esc_attr($price) . '"]'); ?>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <?php
    $related_args = array(
        'post_type' => 'property',
        'posts_per_page' => 3,
        'post__not_in' => array($property_id),
        'meta_query' => array(
            'relation' => 'OR',
            array('key' => 'cps_status', 'value' => $status),
            array('key' => 'cps_city', 'value' => $city),
        )
    );
    $related_properties = new WP_Query($related_args);
    
    if ($related_properties->have_posts()) :
    ?>
        <section class="related-properties-section">
            <div class="container">
                <h2 class="section-title"><?php esc_html_e('Similar Properties', 'cari-prop-shop'); ?></h2>
                <div class="related-properties-grid">
                    <?php while ($related_properties->have_posts()) : $related_properties->the_post(); ?>
                        <?php get_template_part('template-parts/property-card'); ?>
                    <?php endwhile; ?>
                </div>
                <?php wp_reset_postdata(); ?>
            </div>
        </section>
    <?php endif; ?>
</div>

<div class="gallery-lightbox" id="gallery-lightbox">
    <div class="lightbox-header">
        <span class="lightbox-counter"><span id="current-index">1</span> / <?php echo count($gallery_images); ?></span>
        <button class="lightbox-close"><i class="fas fa-times"></i></button>
    </div>
    <div class="lightbox-body">
        <button class="lightbox-nav prev"><i class="fas fa-chevron-left"></i></button>
        <div class="lightbox-image-container">
            <img src="" alt="" id="lightbox-image">
        </div>
        <button class="lightbox-nav next"><i class="fas fa-chevron-right"></i></button>
    </div>
</div>

<script>
var galleryImages = <?php echo json_encode(array_map(function($img) { return $img['full']; }, $gallery_images)); ?>;
var currentIndex = 0;

function openLightbox(index) {
    currentIndex = index || 0;
    updateLightboxImage();
    document.getElementById('gallery-lightbox').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('gallery-lightbox').classList.remove('active');
    document.body.style.overflow = '';
}

function updateLightboxImage() {
    document.getElementById('lightbox-image').src = galleryImages[currentIndex];
    document.getElementById('current-index').textContent = currentIndex + 1;
}

function navigateLightbox(direction) {
    currentIndex += direction;
    if (currentIndex < 0) currentIndex = galleryImages.length - 1;
    if (currentIndex >= galleryImages.length) currentIndex = 0;
    updateLightboxImage();
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('open-gallery').addEventListener('click', function() { openLightbox(0); });
    document.getElementById('open-gallery-thumb') && document.getElementById('open-gallery-thumb').addEventListener('click', function() { openLightbox(0); });
    document.querySelector('.lightbox-close').addEventListener('click', closeLightbox);
    document.querySelector('.lightbox-nav.prev').addEventListener('click', function() { navigateLightbox(-1); });
    document.querySelector('.lightbox-nav.next').addEventListener('click', function() { navigateLightbox(1); });
    document.getElementById('gallery-lightbox').addEventListener('click', function(e) { if (e.target === this) closeLightbox(); });
    
    document.addEventListener('keydown', function(e) {
        if (!document.getElementById('gallery-lightbox').classList.contains('active')) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') navigateLightbox(-1);
        if (e.key === 'ArrowRight') navigateLightbox(1);
    });
    
    document.querySelectorAll('.thumb-item[data-index]').forEach(function(thumb) {
        thumb.addEventListener('click', function() {
            openLightbox(parseInt(this.dataset.index));
        });
    });
});
</script>

<?php endwhile; ?>
<?php get_footer(); ?>
