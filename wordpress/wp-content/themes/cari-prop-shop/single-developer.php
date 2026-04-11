<?php
/**
 * Single Developer Template
 */

get_header();

while (have_posts()) : the_post();
    $developer_id = get_the_ID();
    $logo = get_the_post_thumbnail_url($developer_id, 'medium');
    $address = get_post_meta($developer_id, 'cps_developer_address', true);
    $phone = get_post_meta($developer_id, 'cps_developer_phone', true);
    $email = get_post_meta($developer_id, 'cps_developer_email', true);
    $website = get_post_meta($developer_id, 'cps_developer_website', true);
    $founded = get_post_meta($developer_id, 'cps_developer_founded', true);
    $projects_completed = get_post_meta($developer_id, 'cps_developer_projects_completed', true);
    $experience = get_post_meta($developer_id, 'cps_developer_experience', true);
?>

<div class="single-developer-page">
    <div class="developer-header">
        <div class="container">
            <div class="developer-header-inner">
                <?php if ($logo) : ?>
                    <div class="developer-logo">
                        <img src="<?php echo esc_url($logo); ?>" alt="<?php the_title(); ?>">
                    </div>
                <?php endif; ?>
                <div class="developer-info">
                    <h1 class="developer-title"><?php the_title(); ?></h1>
                    <?php if ($address) : ?>
                        <p class="developer-address"><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($address); ?></p>
                    <?php endif; ?>
                    <div class="developer-stats">
                        <?php if ($projects_completed) : ?>
                            <div class="stat">
                                <span class="stat-number"><?php echo esc_html($projects_completed); ?></span>
                                <span class="stat-label"><?php _e('Projects Completed', 'cari-prop-shop'); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ($experience) : ?>
                            <div class="stat">
                                <span class="stat-number"><?php echo esc_html($experience); ?></span>
                                <span class="stat-label"><?php _e('Years Experience', 'cari-prop-shop'); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="developer-contact">
                        <?php if ($phone) : ?>
                            <a href="tel:<?php echo esc_attr($phone); ?>" class="contact-item"><i class="fas fa-phone"></i> <?php echo esc_html($phone); ?></a>
                        <?php endif; ?>
                        <?php if ($email) : ?>
                            <a href="mailto:<?php echo esc_attr($email); ?>" class="contact-item"><i class="fas fa-envelope"></i> <?php echo esc_html($email); ?></a>
                        <?php endif; ?>
                        <?php if ($website) : ?>
                            <a href="<?php echo esc_url($website); ?>" target="_blank" class="contact-item"><i class="fas fa-globe"></i> <?php _e('Visit Website', 'cari-prop-shop'); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="developer-content">
            <div class="developer-description">
                <h2><?php _e('About Developer', 'cari-prop-shop'); ?></h2>
                <?php the_content(); ?>
            </div>

            <div class="developer-projects">
                <h3><?php _e('Our Projects', 'cari-prop-shop'); ?></h3>
                <?php
                $projects = new WP_Query(array(
                    'post_type' => 'project',
                    'posts_per_page' => 6,
                    'meta_query' => array(
                        array(
                            'key' => 'cps_project_developer',
                            'value' => $developer_id,
                            'compare' => '='
                        )
                    )
                ));

                if ($projects->have_posts()) :
                    echo '<div class="projects-grid">';
                    while ($projects->have_posts()) : $projects->the_post();
                        $completion = get_post_meta(get_the_ID(), 'cps_project_completion', true);
                        $launch = get_post_meta(get_the_ID(), 'cps_project_launch', true);
                        $units = get_post_meta(get_the_ID(), 'cps_project_units', true);
                        ?>
                        <div class="project-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="project-image">
                                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
                                    <?php if ($completion) : ?>
                                        <span class="project-status"><?php echo esc_html($completion); ?>% <?php _e('Complete', 'cari-prop-shop'); ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <div class="project-content">
                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                <div class="project-meta">
                                    <?php if ($units) : ?>
                                        <span><i class="fas fa-building"></i> <?php echo esc_html($units); ?> <?php _e('Units', 'cari-prop-shop'); ?></span>
                                    <?php endif; ?>
                                    <?php if ($launch) : ?>
                                        <span><i class="fas fa-calendar"></i> <?php _e('Launch:', 'cari-prop-shop'); ?> <?php echo esc_html($launch); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    endwhile;
                    echo '</div>';
                    wp_reset_postdata();
                else :
                    echo '<p>' . __('No projects found.', 'cari-prop-shop') . '</p>';
                endif;
                ?>
            </div>

            <div class="developer-listings">
                <h3><?php _e('Properties by This Developer', 'cari-prop-shop'); ?></h3>
                <?php
                $listings = new WP_Query(array(
                    'post_type' => 'property',
                    'posts_per_page' => 6,
                    'meta_query' => array(
                        array(
                            'key' => 'cps_property_developer',
                            'value' => $developer_id,
                            'compare' => '='
                        )
                    )
                ));

                if ($listings->have_posts()) :
                    echo '<div class="listings-grid">';
                    while ($listings->have_posts()) : $listings->the_post();
                        get_template_part('template-parts/property', 'card');
                    endwhile;
                    echo '</div>';
                    wp_reset_postdata();
                else :
                    echo '<p>' . __('No listings found.', 'cari-prop-shop') . '</p>';
                endif;
                ?>
            </div>
        </div>
    </div>
</div>

<?php
endwhile;
get_footer();
