<?php
/**
 * The template for displaying single property
 */

get_header();

while (have_posts()) :
    the_post();
    
    $price = get_post_meta(get_the_ID(), 'property_price', true);
    $address = get_post_meta(get_the_ID(), 'property_address', true);
    $bedrooms = get_post_meta(get_the_ID(), 'property_bedrooms', true);
    $bathrooms = get_post_meta(get_the_ID(), 'property_bathrooms', true);
    $sqft = get_post_meta(get_the_ID(), 'property_sqft', true);
    $status = get_post_meta(get_the_ID(), 'property_status', true);
    $garage = get_post_meta(get_the_ID(), 'property_garage', true);
    $year = get_post_meta(get_the_ID(), 'property_year', true);
?>

<div class="property-single">
    <div class="property-hero">
        <?php if (has_post_thumbnail()) : ?>
            <div class="property-hero-image">
                <?php the_post_thumbnail('property-featured'); ?>
            </div>
        <?php endif; ?>
        
        <div class="property-hero-overlay">
            <div class="container">
                <span class="property-status"><?php echo esc_html($status ?: 'For Sale'); ?></span>
                <h1 class="property-title"><?php the_title(); ?></h1>
                <p class="property-address"><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($address); ?></p>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="property-content-wrapper">
            <div class="property-main">
                <div class="property-details-card">
                    <div class="property-price-row">
                        <span class="property-price"><?php echo esc_html($price); ?></span>
                    </div>
                    
                    <div class="property-specs">
                        <div class="spec-item">
                            <i class="fas fa-bed"></i>
                            <span class="spec-value"><?php echo esc_html($bedrooms); ?></span>
                            <span class="spec-label">Bedrooms</span>
                        </div>
                        <div class="spec-item">
                            <i class="fas fa-bath"></i>
                            <span class="spec-value"><?php echo esc_html($bathrooms); ?></span>
                            <span class="spec-label">Bathrooms</span>
                        </div>
                        <div class="spec-item">
                            <i class="fas fa-ruler-combined"></i>
                            <span class="spec-value"><?php echo esc_html($sqft); ?></span>
                            <span class="spec-label">Sq Ft</span>
                        </div>
                        <?php if ($garage) : ?>
                        <div class="spec-item">
                            <i class="fas fa-car"></i>
                            <span class="spec-value"><?php echo esc_html($garage); ?></span>
                            <span class="spec-label">Garage</span>
                        </div>
                        <?php endif; ?>
                        <?php if ($year) : ?>
                        <div class="spec-item">
                            <i class="fas fa-calendar"></i>
                            <span class="spec-value"><?php echo esc_html($year); ?></span>
                            <span class="spec-label">Year Built</span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="property-description">
                    <h2>Property Description</h2>
                    <?php the_content(); ?>
                </div>
                
                <div class="property-features">
                    <h2>Features</h2>
                    <ul class="features-list">
                        <?php
                        $features = get_post_meta(get_the_ID(), 'property_features', true);
                        if ($features && is_array($features)) :
                            foreach ($features as $feature) :
                                echo '<li><i class="fas fa-check"></i> ' . esc_html($feature) . '</li>';
                            endforeach;
                        else :
                            echo '<li><i class="fas fa-check"></i> Central Air Conditioning</li>';
                            echo '<li><i class="fas fa-check"></i> Hardwood Floors</li>';
                            echo '<li><i class="fas fa-check"></i> Updated Kitchen</li>';
                            echo '<li><i class="fas fa-check"></i> Large Closets</li>';
                            echo '<li><i class="fas fa-check"></i> Laundry In-Unit</li>';
                            echo '<li><i class="fas fa-check"></i> Pet Friendly</li>';
                        endif;
                        ?>
                    </ul>
                </div>
            </div>
            
            <aside class="property-sidebar">
                <div class="sidebar-widget agent-card">
                    <h3>Contact Agent</h3>
                    <div class="agent-info">
                        <div class="agent-avatar">
                            <img src="https://ui-avatars.com/api/?name=CariPropShop+Agent&background=2563eb&color=fff&size=100" alt="Agent">
                        </div>
                        <h4>CariPropShop Agent</h4>
                        <p>Your trusted real estate professional</p>
                    </div>
                    <?php echo do_shortcode('[cps_contact_form property_id="' . get_the_ID() . '"]'); ?>
                </div>
                
                <div class="sidebar-widget mortgage-calculator">
                    <h3>Mortgage Calculator</h3>
                    <?php echo do_shortcode('[cps_mortgage_calculator]'); ?>
                </div>
            </aside>
        </div>
        
        <div class="property-navigation">
            <div class="prev-property">
                <?php
                $prev_post = get_previous_post();
                if (!empty($prev_post)) {
                    echo '<a href="' . get_permalink($prev_post->ID) . '">&larr; ' . esc_html($prev_post->post_title) . '</a>';
                }
                ?>
            </div>
            <div class="next-property">
                <?php
                $next_post = get_next_post();
                if (!empty($next_post)) {
                    echo '<a href="' . get_permalink($next_post->ID) . '">' . esc_html($next_post->post_title) . ' &rarr;</a>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
endwhile;
get_footer();
