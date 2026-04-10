<?php
/**
 * The template for displaying property archive
 */

get_header();

$args = array(
    'post_type' => 'property',
    'posts_per_page' => 12,
    'orderby' => 'date',
    'order' => 'DESC',
);

$properties_query = new WP_Query($args);
?>

<div class="property-archive">
    <div class="archive-header">
        <div class="container">
            <h1 class="archive-title">Properties</h1>
            <p class="archive-subtitle">Browse our collection of properties</p>
        </div>
    </div>
    
    <div class="container">
        <div class="property-filters">
            <form id="property-filter-form" method="get">
                <div class="filter-row">
                    <select name="status" id="filter-status">
                        <option value="">All Status</option>
                        <option value="For Sale">For Sale</option>
                        <option value="For Rent">For Rent</option>
                        <option value="Pending">Pending</option>
                    </select>
                    
                    <select name="type" id="filter-type">
                        <option value="">All Types</option>
                        <option value="For Sale">For Sale</option>
                        <option value="For Rent">For Rent</option>
                    </select>
                    
                    <select name="beds" id="filter-beds">
                        <option value="">Beds</option>
                        <option value="1">1+</option>
                        <option value="2">2+</option>
                        <option value="3">3+</option>
                        <option value="4">4+</option>
                        <option value="5">5+</option>
                    </select>
                    
                    <select name="baths" id="filter-baths">
                        <option value="">Baths</option>
                        <option value="1">1+</option>
                        <option value="2">2+</option>
                        <option value="3">3+</option>
                    </select>
                    
                    <button type="submit" class="filter-btn">Filter</button>
                </div>
            </form>
        </div>
        
        <div class="property-count">
            <p><?php echo $properties_query->found_posts; ?> Properties Found</p>
        </div>
        
        <div class="property-grid">
            <?php
            if ($properties_query->have_posts()) :
                while ($properties_query->have_posts()) :
                    $properties_query->the_post();
                    
                    $price = get_post_meta(get_the_ID(), 'property_price', true);
                    $address = get_post_meta(get_the_ID(), 'property_address', true);
                    $bedrooms = get_post_meta(get_the_ID(), 'property_bedrooms', true);
                    $bathrooms = get_post_meta(get_the_ID(), 'property_bathrooms', true);
                    $sqft = get_post_meta(get_the_ID(), 'property_sqft', true);
                    $status = get_post_meta(get_the_ID(), 'property_status', true);
            ?>
                    <article class="property-card">
                        <a href="<?php the_permalink(); ?>" class="property-card-link">
                            <div class="property-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('property-thumbnail'); ?>
                                <?php else : ?>
                                    <img src="https://via.placeholder.com/400x300?text=No+Image" alt="Property">
                                <?php endif; ?>
                                <span class="property-status-badge"><?php echo esc_html($status ?: 'For Sale'); ?></span>
                            </div>
                            
                            <div class="property-content">
                                <h3 class="property-title"><?php the_title(); ?></h3>
                                <p class="property-price"><?php echo esc_html($price); ?></p>
                                <p class="property-address"><?php echo esc_html($address); ?></p>
                                
                                <div class="property-specs">
                                    <?php if ($bedrooms) : ?>
                                        <span class="spec"><i class="fas fa-bed"></i> <?php echo esc_html($bedrooms); ?> Beds</span>
                                    <?php endif; ?>
                                    <?php if ($bathrooms) : ?>
                                        <span class="spec"><i class="fas fa-bath"></i> <?php echo esc_html($bathrooms); ?> Baths</span>
                                    <?php endif; ?>
                                    <?php if ($sqft) : ?>
                                        <span class="spec"><i class="fas fa-ruler-combined"></i> <?php echo esc_html($sqft); ?> Sq Ft</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    </article>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
            ?>
                <p class="no-properties">No properties found.</p>
            <?php endif; ?>
        </div>
        
        <?php if ($properties_query->max_num_pages > 1) : ?>
            <div class="pagination">
                <?php
                echo paginate_links(array(
                    'base' => get_pagenum_link(1) . '%_%',
                    'format' => 'page/%#%',
                    'current' => max(1, get_query_var('paged')),
                    'total' => $properties_query->max_num_pages,
                    'prev_text' => '&laquo; Previous',
                    'next_text' => 'Next &raquo;',
                ));
                ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
