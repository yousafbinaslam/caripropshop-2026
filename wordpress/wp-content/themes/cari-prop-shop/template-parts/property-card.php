<?php
/**
 * Template part for displaying property cards
 */

$property_id = get_the_ID();
$thumb_url = get_the_post_thumbnail_url($property_id, 'property-thumbnail');
$title = get_the_title();
$price = cps_get_property_price($property_id);
$location = cps_get_property_location($property_id);
$type = cps_get_property_type($property_id);
$bedrooms = get_post_meta($property_id, 'cps_bedrooms', true);
$bathrooms = get_post_meta($property_id, 'cps_bathrooms', true);
$area = get_post_meta($property_id, 'cps_area', true);
$status = cps_get_property_status($property_id);
$is_favorite = cps_is_favorite($property_id);
$agent = cps_get_property_agent($property_id);
$permalink = get_permalink();
$property_type = get_post_type();
?>

<article class="property-card" data-property-id="<?php echo esc_attr($property_id); ?>">
    <div class="property-card-image">
        <?php if ($thumb_url) : ?>
            <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy">
        <?php else : ?>
            <div class="property-placeholder">
                <i class="fas fa-home"></i>
            </div>
        <?php endif; ?>
        
        <div class="property-card-overlay">
            <?php echo $status; ?>
            
            <div class="property-card-actions">
                <button class="favorite-btn <?php echo $is_favorite ? 'favorited' : ''; ?>" 
                        data-property-id="<?php echo esc_attr($property_id); ?>"
                        title="<?php echo $is_favorite ? __('Remove from favorites', 'cari-prop-shop') : __('Add to favorites', 'cari-prop-shop'); ?>">
                    <i class="<?php echo $is_favorite ? 'fas' : 'far'; ?> fa-heart"></i>
                </button>
                
                <button class="compare-btn" 
                        data-property-id="<?php echo esc_attr($property_id); ?>"
                        title="<?php esc_attr_e('Add to compare', 'cari-prop-shop'); ?>">
                    <i class="far fa-plus-square"></i>
                </button>
                
                <button class="share-btn" data-platform="facebook" title="<?php esc_attr_e('Share on Facebook', 'cari-prop-shop'); ?>">
                    <i class="fab fa-facebook-f"></i>
                </button>
            </div>
        </div>
        
        <?php if ($agent) : ?>
            <div class="property-card-agent">
                <?php echo get_the_post_thumbnail($agent->ID, 'agent-avatar', array('class' => 'agent-thumb')); ?>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="property-card-content">
        <div class="property-card-price">
            <?php echo $price; ?>
        </div>
        
        <h3 class="property-card-title">
            <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a>
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
                </div>
            <?php endif; ?>
            
            <?php if ($bathrooms) : ?>
                <div class="meta-item">
                    <i class="fas fa-bath"></i>
                    <span><?php echo esc_html($bathrooms); ?></span>
                </div>
            <?php endif; ?>
            
            <?php if ($area) : ?>
                <div class="meta-item">
                    <i class="fas fa-ruler-combined"></i>
                    <span><?php echo esc_html($area); ?> m²</span>
                </div>
            <?php endif; ?>
        </div>
        
        <?php if ($type) : ?>
            <div class="property-card-type">
                <?php echo esc_html($type); ?>
            </div>
        <?php endif; ?>
    </div>
</article>
