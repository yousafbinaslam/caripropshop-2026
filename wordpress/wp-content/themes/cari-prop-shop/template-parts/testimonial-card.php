<?php
/**
 * Template part for displaying testimonial cards
 */

$testimonial_id = $testimonial->ID ?? get_the_ID();
$content = get_the_content($testimonial_id);
$name = get_the_title($testimonial_id);
$thumb_url = get_the_post_thumbnail_url($testimonial_id, 'thumbnail');
$company = get_post_meta($testimonial_id, 'cps_company', true);
$rating = get_post_meta($testimonial_id, 'cps_rating', true) ?: 5;
$property_link = get_post_meta($testimonial_id, 'cps_property_link', true);
?>

<div class="testimonial-card">
    <div class="testimonial-rating">
        <?php for ($i = 1; $i <= 5; $i++) : ?>
            <i class="fas fa-star <?php echo $i <= $rating ? 'active' : ''; ?>"></i>
        <?php endfor; ?>
    </div>
    
    <blockquote class="testimonial-content">
        <?php echo esc_html($content); ?>
    </blockquote>
    
    <div class="testimonial-author">
        <?php if ($thumb_url) : ?>
            <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($name); ?>" class="author-image">
        <?php else : ?>
            <div class="author-placeholder">
                <i class="fas fa-user"></i>
            </div>
        <?php endif; ?>
        
        <div class="author-info">
            <h4 class="author-name"><?php echo esc_html($name); ?></h4>
            <?php if ($company) : ?>
                <p class="author-company"><?php echo esc_html($company); ?></p>
            <?php endif; ?>
        </div>
    </div>
    
    <?php if ($property_link) : ?>
        <a href="<?php echo esc_url($property_link); ?>" class="testimonial-property-link">
            <i class="fas fa-home"></i>
            <?php _e('View Property', 'cari-prop-shop'); ?>
        </a>
    <?php endif; ?>
</div>
