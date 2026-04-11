<?php
/**
 * Single Neighborhood Template
 */

get_header();

while (have_posts()) : the_post();
    $neighborhood_id = get_the_ID();
    $cover_image = get_the_post_thumbnail_url($neighborhood_id, 'large');
    $region = get_post_meta($neighborhood_id, 'cps_neighborhood_region', true);
    $city = get_post_meta($neighborhood_id, 'cps_neighborhood_city', true);
    $population = get_post_meta($neighborhood_id, 'cps_neighborhood_population', true);
    $avg_price = get_post_meta($neighborhood_id, 'cps_neighborhood_avg_price', true);
    $latitude = get_post_meta($neighborhood_id, 'cps_neighborhood_latitude', true);
    $longitude = get_post_meta($neighborhood_id, 'cps_neighborhood_longitude', true);
    $highlights = get_post_meta($neighborhood_id, 'cps_neighborhood_highlights', true);
    $highlights_array = $highlights ? explode("\n", $highlights) : array();
?>

<div class="single-neighborhood-page">
    <div class="neighborhood-hero" style="<?php echo $cover_image ? 'background-image: url(' . esc_url($cover_image) . ')' : ''; ?>">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="container">
                <h1 class="neighborhood-title"><?php the_title(); ?></h1>
                <?php if ($city || $region) : ?>
                    <p class="neighborhood-location">
                        <i class="fas fa-map-marker-alt"></i> 
                        <?php echo esc_html(($city ? $city : '') . ($region ? ', ' . $region : '')); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="neighborhood-content-grid">
            <div class="neighborhood-main">
                <div class="neighborhood-description">
                    <h2><?php _e('About This Area', 'cari-prop-shop'); ?></h2>
                    <?php the_content(); ?>
                </div>

                <?php if ($highlights_array) : ?>
                    <div class="neighborhood-highlights">
                        <h3><?php _e('Highlights', 'cari-prop-shop'); ?></h3>
                        <ul class="highlights-list">
                            <?php foreach ($highlights_array as $highlight) : 
                                $highlight = trim($highlight);
                                if ($highlight) :
                            ?>
                                <li><i class="fas fa-star"></i> <?php echo esc_html($highlight); ?></li>
                            <?php endif; endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="neighborhood-stats">
                    <h3><?php _e('Area Statistics', 'cari-prop-shop'); ?></h3>
                    <div class="stats-grid">
                        <?php if ($population) : ?>
                            <div class="stat-card">
                                <i class="fas fa-users"></i>
                                <span class="stat-value"><?php echo esc_html($population); ?></span>
                                <span class="stat-label"><?php _e('Population', 'cari-prop-shop'); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ($avg_price) : ?>
                            <div class="stat-card">
                                <i class="fas fa-home"></i>
                                <span class="stat-value"><?php echo esc_html($avg_price); ?></span>
                                <span class="stat-label"><?php _e('Avg. Property Price', 'cari-prop-shop'); ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="stat-card">
                            <i class="fas fa-building"></i>
                            <span class="stat-value">
                                <?php 
                                $property_count = wp_count_posts('property');
                                echo esc_html($property_count->publish);
                                ?>
                            </span>
                            <span class="stat-label"><?php _e('Properties', 'cari-prop-shop'); ?></span>
                        </div>
                    </div>
                </div>

                <?php if ($latitude && $longitude) : ?>
                    <div class="neighborhood-map-section">
                        <h3><?php _e('Explore the Area', 'cari-prop-shop'); ?></h3>
                        <div id="neighborhoodMap" class="neighborhood-map" style="height: 400px;"></div>
                        <div class="map-tools">
                            <button id="findSchoolsMap" class="btn btn-sm"><i class="fas fa-school"></i> <?php _e('Schools', 'cari-prop-shop'); ?></button>
                            <button id="findHospitalsMap" class="btn btn-sm"><i class="fas fa-hospital"></i> <?php _e('Hospitals', 'cari-prop-shop'); ?></button>
                            <button id="findTransitMap" class="btn btn-sm"><i class="fas fa-bus"></i> <?php _e('Transit', 'cari-prop-shop'); ?></button>
                            <button id="findRestaurantsMap" class="btn btn-sm"><i class="fas fa-utensils"></i> <?php _e('Restaurants', 'cari-prop-shop'); ?></button>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="neighborhood-properties">
                    <h3><?php _e('Properties in This Area', 'cari-prop-shop'); ?></h3>
                    <?php
                    $properties = new WP_Query(array(
                        'post_type' => 'property',
                        'posts_per_page' => 6,
                        'meta_query' => array(
                            array(
                                'key' => 'property_city',
                                'value' => $city ?: get_the_title(),
                                'compare' => 'LIKE'
                            )
                        )
                    ));

                    if ($properties->have_posts()) :
                        echo '<div class="listings-grid">';
                        while ($properties->have_posts()) : $properties->the_post();
                            get_template_part('template-parts/property', 'card');
                        endwhile;
                        echo '</div>';
                        wp_reset_postdata();
                    else :
                        echo '<p>' . __('No properties found in this area.', 'cari-prop-shop') . '</p>';
                    endif;
                    ?>
                </div>
            </div>

            <div class="neighborhood-sidebar">
                <div class="widget area-guide">
                    <h3><?php _e('Area Guide', 'cari-prop-shop'); ?></h3>
                    <ul class="guide-links">
                        <li><a href="#overview"><i class="fas fa-info-circle"></i> <?php _e('Overview', 'cari-prop-shop'); ?></a></li>
                        <li><a href="#highlights"><i class="fas fa-star"></i> <?php _e('Highlights', 'cari-prop-shop'); ?></a></li>
                        <li><a href="#statistics"><i class="fas fa-chart-bar"></i> <?php _e('Statistics', 'cari-prop-shop'); ?></a></li>
                        <li><a href="#map"><i class="fas fa-map"></i> <?php _e('Map', 'cari-prop-shop'); ?></a></li>
                        <li><a href="#properties"><i class="fas fa-home"></i> <?php _e('Properties', 'cari-prop-shop'); ?></a></li>
                    </ul>
                </div>

                <div class="widget similar-areas">
                    <h3><?php _e('Similar Areas', 'cari-prop-shop'); ?></h3>
                    <?php
                    $similar = new WP_Query(array(
                        'post_type' => 'neighborhood',
                        'posts_per_page' => 4,
                        'post__not_in' => array($neighborhood_id),
                        'meta_query' => array(
                            array(
                                'key' => 'cps_neighborhood_city',
                                'value' => $city ?: '',
                                'compare' => $city ? '=' : 'NOT EXISTS'
                            )
                        )
                    ));

                    if ($similar->have_posts()) :
                        while ($similar->have_posts()) : $similar->the_post();
                            $thumb = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
                    ?>
                            <a href="<?php the_permalink(); ?>" class="similar-item">
                                <?php if ($thumb) : ?>
                                    <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title(); ?>">
                                <?php endif; ?>
                                <span><?php the_title(); ?></span>
                            </a>
                        <?php endwhile;
                        wp_reset_postdata();
                    else :
                        echo '<p>' . __('No similar areas found.', 'cari-prop-shop') . '</p>';
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($latitude && $longitude) : ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof google !== 'undefined' && document.getElementById('neighborhoodMap')) {
        const map = new google.maps.Map(document.getElementById('neighborhoodMap'), {
            center: { lat: <?php echo floatval($latitude); ?>, lng: <?php echo floatval($longitude); ?> },
            zoom: 14
        });
        
        new google.maps.Marker({
            position: { lat: <?php echo floatval($latitude); ?>, lng: <?php echo floatval($longitude); ?> },
            map: map,
            title: '<?php echo esc_js(get_the_title()); ?>'
        });
    }
});
</script>
<?php endif; ?>

<?php
endwhile;
get_footer();
