<?php
/**
 * The main template file
 */

get_header();
?>

<main id="main" class="site-main">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            the_content();
        endwhile;
    else :
        ?>
        <div class="container">
            <h1>Welcome to CariPropShop</h1>
            <p>Find your dream home with our comprehensive real estate platform.</p>
            
            <h2>Featured Properties</h2>
            <?php
            $properties = new WP_Query(array(
                'post_type' => 'property',
                'posts_per_page' => 3,
            ));
            
            if ($properties->have_posts()) {
                echo '<div class="property-grid">';
                while ($properties->have_posts()) {
                    $properties->the_post();
                    $price = get_post_meta(get_the_ID(), 'property_price', true);
                    $address = get_post_meta(get_the_ID(), 'property_address', true);
                    $beds = get_post_meta(get_the_ID(), 'property_bedrooms', true);
                    $baths = get_post_meta(get_the_ID(), 'property_bathrooms', true);
                    ?>
                    <div class="property-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="property-image">
                                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
                            </div>
                        <?php endif; ?>
                        <div class="property-details">
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <?php if ($price) : ?>
                                <p class="property-price"><?php echo esc_html($price); ?></p>
                            <?php endif; ?>
                            <?php if ($address) : ?>
                                <p class="property-address"><?php echo esc_html($address); ?></p>
                            <?php endif; ?>
                            <div class="property-meta">
                                <?php if ($beds) : ?>
                                    <span><?php echo esc_html($beds); ?> Beds</span>
                                <?php endif; ?>
                                <?php if ($baths) : ?>
                                    <span><?php echo esc_html($baths); ?> Baths</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                echo '</div>';
                wp_reset_postdata();
            }
            ?>
            
            <h2>Contact Us</h2>
            <?php echo do_shortcode('[cps_contact_form]'); ?>
        </div>
        <?php
    endif;
    ?>
</main>

<?php
get_footer();
