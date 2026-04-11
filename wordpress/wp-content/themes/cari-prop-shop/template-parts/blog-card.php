<?php
/**
 * Template part for displaying blog cards
 */

$post_id = get_the_ID();
$thumb_url = get_the_post_thumbnail_url($post_id, 'medium_large');
$title = get_the_title();
$excerpt = get_the_excerpt();
$permalink = get_permalink();
$author_name = get_the_author();
$author_avatar = get_avatar_url(get_the_author_meta('ID'));
$date = get_the_date();
$category = get_the_category();
$reading_time = reading_time();
?>

<article class="blog-card">
    <?php if ($thumb_url) : ?>
        <div class="blog-card-image">
            <a href="<?php echo esc_url($permalink); ?>">
                <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy">
            </a>
            
            <?php if ($category) : ?>
                <span class="blog-card-category">
                    <a href="<?php echo esc_url(get_category_link($category[0]->term_id)); ?>">
                        <?php echo esc_html($category[0]->name); ?>
                    </a>
                </span>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    
    <div class="blog-card-content">
        <div class="blog-card-meta">
            <span class="meta-date">
                <i class="far fa-calendar"></i>
                <?php echo esc_html($date); ?>
            </span>
            <span class="meta-reading">
                <i class="far fa-clock"></i>
                <?php echo esc_html($reading_time); ?>
            </span>
        </div>
        
        <h3 class="blog-card-title">
            <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a>
        </h3>
        
        <p class="blog-card-excerpt">
            <?php echo esc_html(wp_trim_words($excerpt, 20, '...')); ?>
        </p>
        
        <div class="blog-card-footer">
            <div class="blog-card-author">
                <img src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr($author_name); ?>" class="author-avatar">
                <span><?php echo esc_html($author_name); ?></span>
            </div>
            
            <a href="<?php echo esc_url($permalink); ?>" class="read-more">
                <?php _e('Read More', 'cari-prop-shop'); ?>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</article>
