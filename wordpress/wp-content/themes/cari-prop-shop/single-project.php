<?php
/**
 * Single Project Template
 */

get_header();

while (have_posts()) : the_post();
    $project_id = get_the_ID();
    $developer_id = get_post_meta($project_id, 'cps_project_developer', true);
    $developer = $developer_id ? get_post($developer_id) : null;
    $location = get_post_meta($project_id, 'cps_project_location', true);
    $address = get_post_meta($project_id, 'cps_project_address', true);
    $launch = get_post_meta($project_id, 'cps_project_launch', true);
    $completion = get_post_meta($project_id, 'cps_project_completion', true);
    $units = get_post_meta($project_id, 'cps_project_units', true);
    $floors = get_post_meta($project_id, 'cps_project_floors', true);
    $tower = get_post_meta($project_id, 'cps_project_tower', true);
    $price_start = get_post_meta($project_id, 'cps_project_price_start', true);
    $latitude = get_post_meta($project_id, 'cps_project_latitude', true);
    $longitude = get_post_meta($project_id, 'cps_project_longitude', true);
    $video = get_post_meta($project_id, 'cps_project_video', true);
    
    $gallery = get_post_meta($project_id, 'cps_project_gallery', true);
    $gallery_images = $gallery ? explode(',', $gallery) : array();
?>

<div class="single-project-page">
    <div class="project-hero">
        <?php if (has_post_thumbnail()) : ?>
            <div class="hero-image">
                <?php the_post_thumbnail('full'); ?>
                <div class="hero-overlay"></div>
            </div>
        <?php endif; ?>
        <div class="hero-content">
            <div class="container">
                <div class="project-header-info">
                    <h1 class="project-title"><?php the_title(); ?></h1>
                    <?php if ($location) : ?>
                        <p class="project-location"><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($location); ?></p>
                    <?php endif; ?>
                    <?php if ($developer) : ?>
                        <p class="project-developer"><?php _e('By', 'cari-prop-shop'); ?> <a href="<?php echo get_permalink($developer->ID); ?>"><?php echo esc_html($developer->post_title); ?></a></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="project-content-grid">
            <div class="project-main">
                <div class="project-nav-tabs">
                    <button class="tab-btn active" data-tab="overview"><?php _e('Overview', 'cari-prop-shop'); ?></button>
                    <button class="tab-btn" data-tab="amenities"><?php _e('Amenities', 'cari-prop-shop'); ?></button>
                    <button class="tab-btn" data-tab="gallery"><?php _e('Gallery', 'cari-prop-shop'); ?></button>
                    <button class="tab-btn" data-tab="location"><?php _e('Location', 'cari-prop-shop'); ?></button>
                </div>

                <div class="tab-content active" id="overview">
                    <div class="project-description">
                        <h2><?php _e('About This Project', 'cari-prop-shop'); ?></h2>
                        <?php the_content(); ?>
                    </div>

                    <div class="project-details">
                        <h3><?php _e('Project Details', 'cari-prop-shop'); ?></h3>
                        <div class="details-grid">
                            <?php if ($launch) : ?>
                                <div class="detail-item">
                                    <span class="detail-label"><?php _e('Launch Date', 'cari-prop-shop'); ?></span>
                                    <span class="detail-value"><?php echo esc_html($launch); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if ($completion) : ?>
                                <div class="detail-item">
                                    <span class="detail-label"><?php _e('Completion', 'cari-prop-shop'); ?></span>
                                    <span class="detail-value"><?php echo esc_html($completion); ?>%</span>
                                </div>
                            <?php endif; ?>
                            <?php if ($units) : ?>
                                <div class="detail-item">
                                    <span class="detail-label"><?php _e('Total Units', 'cari-prop-shop'); ?></span>
                                    <span class="detail-value"><?php echo esc_html($units); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if ($tower) : ?>
                                <div class="detail-item">
                                    <span class="detail-label"><?php _e('Towers', 'cari-prop-shop'); ?></span>
                                    <span class="detail-value"><?php echo esc_html($tower); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if ($floors) : ?>
                                <div class="detail-item">
                                    <span class="detail-label"><?php _e('Floors', 'cari-prop-shop'); ?></span>
                                    <span class="detail-value"><?php echo esc_html($floors); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if ($price_start) : ?>
                                <div class="detail-item">
                                    <span class="detail-label"><?php _e('Price Start From', 'cari-prop-shop'); ?></span>
                                    <span class="detail-value"><?php echo esc_html($price_start); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if ($video) : ?>
                        <div class="project-video">
                            <h3><?php _e('Video Tour', 'cari-prop-shop'); ?></h3>
                            <div class="video-container">
                                <?php echo wp_oembed_get($video); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="tab-content" id="amenities">
                    <h3><?php _e('Amenities & Facilities', 'cari-prop-shop'); ?></h3>
                    <div class="amenities-grid">
                        <?php
                        $amenities = get_the_terms($project_id, 'property_feature');
                        if ($amenities) :
                            foreach ($amenities as $amenity) :
                                echo '<div class="amenity-item"><i class="fas fa-check"></i> ' . esc_html($amenity->name) . '</div>';
                            endforeach;
                        else :
                            echo '<p>' . __('No amenities listed.', 'cari-prop-shop') . '</p>';
                        endif;
                        ?>
                    </div>
                </div>

                <div class="tab-content" id="gallery">
                    <h3><?php _e('Photo Gallery', 'cari-prop-shop'); ?></h3>
                    <?php if (has_post_thumbnail() || $gallery_images) : ?>
                        <div class="gallery-grid">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_post_thumbnail_url('full'); ?>" class="gallery-item" data-lightbox="project-gallery">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                            <?php endif; ?>
                            <?php foreach ($gallery_images as $img_id) : 
                                $img_url = wp_get_attachment_image_url($img_id, 'medium');
                                $full_url = wp_get_attachment_image_url($img_id, 'full');
                                if ($img_url) :
                            ?>
                                <a href="<?php echo esc_url($full_url); ?>" class="gallery-item" data-lightbox="project-gallery">
                                    <img src="<?php echo esc_url($img_url); ?>" alt="">
                                </a>
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </div>
                    <?php else : ?>
                        <p><?php _e('No gallery images available.', 'cari-prop-shop'); ?></p>
                    <?php endif; ?>
                </div>

                <div class="tab-content" id="location">
                    <h3><?php _e('Project Location', 'cari-prop-shop'); ?></h3>
                    <?php if ($address) : ?>
                        <p class="location-address"><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($address); ?></p>
                    <?php endif; ?>
                    <div id="projectMap" class="project-map" style="height: 400px;"></div>
                </div>

                <div class="project-listings">
                    <h3><?php _e('Available Units', 'cari-prop-shop'); ?></h3>
                    <?php
                    $units = new WP_Query(array(
                        'post_type' => 'property',
                        'posts_per_page' => 6,
                        'meta_query' => array(
                            array(
                                'key' => 'cps_property_project',
                                'value' => $project_id,
                                'compare' => '='
                            )
                        )
                    ));

                    if ($units->have_posts()) :
                        echo '<div class="listings-grid">';
                        while ($units->have_posts()) : $units->the_post();
                            get_template_part('template-parts/property', 'card');
                        endwhile;
                        echo '</div>';
                        wp_reset_postdata();
                    else :
                        echo '<p>' . __('No units available yet.', 'cari-prop-shop') . '</p>';
                    endif;
                    ?>
                </div>
            </div>

            <div class="project-sidebar">
                <div class="widget project-inquiry-form">
                    <h3><?php _e('Interested in This Project?', 'cari-prop-shop'); ?></h3>
                    <p><?php _e('Fill out the form below and our team will contact you.', 'cari-prop-shop'); ?></p>
                    <form id="projectInquiryForm" class="inquiry-form">
                        <input type="hidden" name="project_id" value="<?php echo esc_attr($project_id); ?>">
                        <div class="form-group">
                            <input type="text" name="name" placeholder="<?php _e('Your Name', 'cari-prop-shop'); ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" placeholder="<?php _e('Your Email', 'cari-prop-shop'); ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="tel" name="phone" placeholder="<?php _e('Phone Number', 'cari-prop-shop'); ?>" required>
                        </div>
                        <div class="form-group">
                            <select name="interest">
                                <option value=""><?php _e('Select Interest', 'cari-prop-shop'); ?></option>
                                <option value="1bed"><?php _e('1 Bedroom Unit', 'cari-prop-shop'); ?></option>
                                <option value="2bed"><?php _e('2 Bedroom Unit', 'cari-prop-shop'); ?></option>
                                <option value="3bed"><?php _e('3 Bedroom Unit', 'cari-prop-shop'); ?></option>
                                <option value="penthouse"><?php _e('Penthouse', 'cari-prop-shop'); ?></option>
                                <option value="info"><?php _e('General Information', 'cari-prop-shop'); ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea name="message" rows="3" placeholder="<?php _e('Additional Message', 'cari-prop-shop'); ?>"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block"><?php _e('Request Information', 'cari-prop-shop'); ?></button>
                    </form>
                </div>

                <?php if ($developer) : ?>
                    <div class="widget developer-card">
                        <h3><?php _e('Developer', 'cari-prop-shop'); ?></h3>
                        <div class="developer-info">
                            <h4><?php echo esc_html($developer->post_title); ?></h4>
                            <a href="<?php echo get_permalink($developer->ID); ?>" class="btn btn-outline btn-sm"><?php _e('View Profile', 'cari-prop-shop'); ?></a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php if ($latitude && $longitude) : ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof google !== 'undefined' && document.getElementById('projectMap')) {
        const map = new google.maps.Map(document.getElementById('projectMap'), {
            center: { lat: <?php echo floatval($latitude); ?>, lng: <?php echo floatval($longitude); ?> },
            zoom: 15
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const tabId = this.dataset.tab;
            tabBtns.forEach(function(b) { b.classList.remove('active'); });
            tabContents.forEach(function(c) { c.classList.remove('active'); });
            this.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        });
    });
});
</script>

<?php
endwhile;
get_footer();
