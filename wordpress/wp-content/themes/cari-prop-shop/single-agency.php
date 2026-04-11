<?php
/**
 * Single Agency Template
 */

get_header();

while (have_posts()) : the_post();
    $agency_id = get_the_ID();
    $logo = get_the_post_thumbnail_url($agency_id, 'medium');
    $address = get_post_meta($agency_id, 'cps_agency_address', true);
    $phone = get_post_meta($agency_id, 'cps_agency_phone', true);
    $email = get_post_meta($agency_id, 'cps_agency_email', true);
    $website = get_post_meta($agency_id, 'cps_agency_website', true);
    $license = get_post_meta($agency_id, 'cps_agency_license', true);
    $founded = get_post_meta($agency_id, 'cps_agency_founded', true);
    $agents = get_post_meta($agency_id, 'cps_agency_agents', true);
    $facebook = get_post_meta($agency_id, 'cps_agency_facebook', true);
    $twitter = get_post_meta($agency_id, 'cps_agency_twitter', true);
    $linkedin = get_post_meta($agency_id, 'cps_agency_linkedin', true);
    $instagram = get_post_meta($agency_id, 'cps_agency_instagram', true);
?>

<div class="single-agency-page">
    <div class="agency-header">
        <div class="container">
            <div class="agency-header-inner">
                <?php if ($logo) : ?>
                    <div class="agency-logo">
                        <img src="<?php echo esc_url($logo); ?>" alt="<?php the_title(); ?>">
                    </div>
                <?php endif; ?>
                <div class="agency-info">
                    <h1 class="agency-title"><?php the_title(); ?></h1>
                    <?php if ($address) : ?>
                        <p class="agency-address"><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($address); ?></p>
                    <?php endif; ?>
                    <div class="agency-contact">
                        <?php if ($phone) : ?>
                            <a href="tel:<?php echo esc_attr($phone); ?>" class="contact-item"><i class="fas fa-phone"></i> <?php echo esc_html($phone); ?></a>
                        <?php endif; ?>
                        <?php if ($email) : ?>
                            <a href="mailto:<?php echo esc_attr($email); ?>" class="contact-item"><i class="fas fa-envelope"></i> <?php echo esc_html($email); ?></a>
                        <?php endif; ?>
                        <?php if ($website) : ?>
                            <a href="<?php echo esc_url($website); ?>" target="_blank" class="contact-item"><i class="fas fa-globe"></i> <?php echo esc_html($website); ?></a>
                        <?php endif; ?>
                    </div>
                    <div class="agency-social">
                        <?php if ($facebook) : ?>
                            <a href="<?php echo esc_url($facebook); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <?php endif; ?>
                        <?php if ($twitter) : ?>
                            <a href="<?php echo esc_url($twitter); ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                        <?php endif; ?>
                        <?php if ($linkedin) : ?>
                            <a href="<?php echo esc_url($linkedin); ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        <?php endif; ?>
                        <?php if ($instagram) : ?>
                            <a href="<?php echo esc_url($instagram); ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="agency-content-grid">
            <div class="agency-main">
                <div class="agency-description">
                    <h2><?php _e('About Us', 'cari-prop-shop'); ?></h2>
                    <?php the_content(); ?>
                </div>

                <?php if ($license || $founded) : ?>
                    <div class="agency-details">
                        <h3><?php _e('Agency Details', 'cari-prop-shop'); ?></h3>
                        <ul>
                            <?php if ($license) : ?>
                                <li><strong><?php _e('License:', 'cari-prop-shop'); ?></strong> <?php echo esc_html($license); ?></li>
                            <?php endif; ?>
                            <?php if ($founded) : ?>
                                <li><strong><?php _e('Founded:', 'cari-prop-shop'); ?></strong> <?php echo esc_html($founded); ?></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="agency-listings">
                    <h3><?php _e('Our Listings', 'cari-prop-shop'); ?></h3>
                    <?php
                    $listings = new WP_Query(array(
                        'post_type' => 'property',
                        'posts_per_page' => 6,
                        'meta_query' => array(
                            array(
                                'key' => 'cps_property_agent',
                                'value' => $agency_id,
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

            <div class="agency-sidebar">
                <div class="widget agency-contact-form">
                    <h3><?php _e('Contact Agency', 'cari-prop-shop'); ?></h3>
                    <form id="agencyContactForm" class="contact-form">
                        <input type="hidden" name="agency_id" value="<?php echo esc_attr($agency_id); ?>">
                        <div class="form-group">
                            <input type="text" name="name" placeholder="<?php _e('Your Name', 'cari-prop-shop'); ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" placeholder="<?php _e('Your Email', 'cari-prop-shop'); ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="tel" name="phone" placeholder="<?php _e('Your Phone', 'cari-prop-shop'); ?>">
                        </div>
                        <div class="form-group">
                            <textarea name="message" rows="4" placeholder="<?php _e('Message', 'cari-prop-shop'); ?>" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary"><?php _e('Send Message', 'cari-prop-shop'); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
endwhile;
get_footer();
