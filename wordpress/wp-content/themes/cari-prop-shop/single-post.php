<?php
/**
 * Template Name: Single Post
 */

get_header();

$author_id = get_the_author_meta('ID');
$author_name = get_the_author();
$author_bio = get_the_author_meta('description');
$author_avatar = get_avatar_url($author_id, array('size' => 100));
$categories = get_the_category();
$tags = get_the_tags();
?>

<div class="single-post-page">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    
    <article class="post-article">
        <header class="post-header">
            <div class="container">
                <?php if (!empty($categories)) : ?>
                    <div class="post-category">
                        <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>">
                            <?php echo esc_html($categories[0]->name); ?>
                        </a>
                    </div>
                <?php endif; ?>
                
                <h1 class="post-title"><?php the_title(); ?></h1>
                
                <div class="post-meta">
                    <div class="post-author">
                        <img src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr($author_name); ?>" class="author-avatar">
                        <div class="author-info">
                            <span class="author-name"><?php the_author(); ?></span>
                            <span class="post-date"><?php echo get_the_date(); ?></span>
                        </div>
                    </div>
                    <div class="post-stats">
                        <span><i class="far fa-clock"></i> <?php echo esc_html(reading_time()); ?></span>
                        <span><i class="far fa-comment"></i> <?php comments_number('0 comments'); ?></span>
                    </div>
                </div>
            </div>
        </header>

        <?php if (has_post_thumbnail()) : ?>
        <div class="post-featured-image">
            <div class="container">
                <?php the_post_thumbnail('large', array('class' => 'featured-img')); ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="post-content-wrapper">
            <div class="container">
                <div class="content-grid">
                    <div class="post-content">
                        <?php the_content(); ?>
                        
                        <?php if ($tags) : ?>
                        <div class="post-tags">
                            <span>Tags:</span>
                            <?php foreach ($tags as $tag) : ?>
                                <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="tag">
                                    <?php echo esc_html($tag->name); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>

                        <div class="post-share">
                            <span>Share:</span>
                            <a href="https://facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="share-btn facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share-btn twitter"><i class="fab fa-twitter"></i></a>
                            <a href="https://wa.me/?text=<?php echo urlencode(get_the_title() . ' ' . get_permalink()); ?>" target="_blank" class="share-btn whatsapp"><i class="fab fa-whatsapp"></i></a>
                            <a href="https://linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share-btn linkedin"><i class="fab fa-linkedin-in"></i></a>
                        </div>

                        <nav class="post-navigation">
                            <?php
                            $prev_post = get_previous_post();
                            $next_post = get_next_post();
                            ?>
                            <?php if ($prev_post) : ?>
                                <a href="<?php echo esc_url(get_permalink($prev_post)); ?>" class="nav-link prev">
                                    <span><i class="fas fa-chevron-left"></i> Previous</span>
                                    <span class="nav-title"><?php echo esc_html($prev_post->post_title); ?></span>
                                </a>
                            <?php endif; ?>
                            <?php if ($next_post) : ?>
                                <a href="<?php echo esc_url(get_permalink($next_post)); ?>" class="nav-link next">
                                    <span>Next <i class="fas fa-chevron-right"></i></span>
                                    <span class="nav-title"><?php echo esc_html($next_post->post_title); ?></span>
                                </a>
                            <?php endif; ?>
                        </nav>
                    </div>

                    <aside class="post-sidebar">
                        <div class="sidebar-widget">
                            <h3>About the Author</h3>
                            <div class="author-card">
                                <img src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr($author_name); ?>" class="author-photo">
                                <h4><?php echo esc_html($author_name); ?></h4>
                                <?php if ($author_bio) : ?>
                                    <p><?php echo esc_html($author_bio); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="sidebar-widget">
                            <h3>Related Posts</h3>
                            <?php
                            $related = get_posts(array(
                                'category__in' => wp_get_post_categories(get_the_ID()),
                                'numberposts' => 3,
                                'post__not_in' => array(get_the_ID()),
                            ));
                            if ($related) :
                            ?>
                                <ul class="related-posts">
                                    <?php foreach ($related as $post) : setup_postdata($post); ?>
                                        <li>
                                            <a href="<?php the_permalink(); ?>">
                                                <?php if (has_post_thumbnail()) : ?>
                                                    <div class="related-thumb">
                                                        <?php the_post_thumbnail('thumbnail'); ?>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="related-info">
                                                    <span class="related-title"><?php the_title(); ?></span>
                                                    <span class="related-date"><?php echo get_the_date('M j, Y'); ?></span>
                                                </div>
                                            </a>
                                        </li>
                                    <?php endforeach; wp_reset_postdata(); ?>
                                </ul>
                            <?php else : ?>
                                <p>No related posts found.</p>
                            <?php endif; ?>
                        </div>
                    </aside>
                </div>
            </div>
        </div>

        <?php if (comments_open() || get_comments_number()) : ?>
        <div class="comments-section">
            <div class="container">
                <h3>Comments (<?php comments_number('0', '1', '%'); ?>)</h3>
                <?php comments_template(); ?>
            </div>
        </div>
        <?php endif; ?>
    </article>

    <?php endwhile; endif; ?>
</div>

<style>
.single-post-page {
    background: #f8f9fa;
}

.post-header {
    background: white;
    padding: 50px 0;
    text-align: center;
}

.post-category a {
    display: inline-block;
    background: #3182ce;
    color: white;
    padding: 6px 18px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    margin-bottom: 20px;
}

.post-title {
    font-size: 42px;
    color: #1a365d;
    margin: 0 0 25px;
    line-height: 1.3;
}

.post-meta {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 40px;
}

.post-author {
    display: flex;
    align-items: center;
    gap: 12px;
}

.author-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
}

.author-info {
    text-align: left;
}

.author-name {
    display: block;
    font-weight: 600;
    color: #1a365d;
}

.post-date {
    font-size: 13px;
    color: #718096;
}

.post-stats {
    display: flex;
    gap: 20px;
    color: #718096;
    font-size: 14px;
}

.post-stats span {
    display: flex;
    align-items: center;
    gap: 6px;
}

.post-featured-image {
    padding: 30px 0;
    background: white;
}

.featured-img {
    width: 100%;
    max-height: 500px;
    object-fit: cover;
    border-radius: 12px;
}

.post-content-wrapper {
    padding: 50px 0;
}

.content-grid {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 50px;
}

.post-content {
    background: white;
    padding: 40px;
    border-radius: 12px;
}

.post-content p {
    line-height: 1.8;
    color: #4a5568;
    margin-bottom: 20px;
}

.post-content h2 {
    color: #1a365d;
    margin: 35px 0 20px;
}

.post-content h3 {
    color: #1a365d;
    margin: 30px 0 15px;
}

.post-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 20px 0;
}

.post-content blockquote {
    background: #ebf8ff;
    border-left: 4px solid #3182ce;
    padding: 20px 25px;
    margin: 25px 0;
    font-style: italic;
    color: #2c5282;
}

.post-tags {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 30px;
    padding-top: 25px;
    border-top: 1px solid #edf2f7;
}

.post-tags span {
    font-weight: 600;
    color: #4a5568;
}

.post-tags .tag {
    background: #edf2f7;
    color: #4a5568;
    padding: 6px 15px;
    border-radius: 20px;
    font-size: 13px;
    text-decoration: none;
}

.post-tags .tag:hover {
    background: #3182ce;
    color: white;
}

.post-share {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: 25px;
}

.post-share span {
    font-weight: 600;
    color: #4a5568;
}

.share-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: transform 0.3s ease;
}

.share-btn:hover {
    transform: translateY(-3px);
}

.share-btn.facebook { background: #1877f2; }
.share-btn.twitter { background: #1da1f2; }
.share-btn.whatsapp { background: #25d366; }
.share-btn.linkedin { background: #0a66c2; }

.post-navigation {
    display: flex;
    gap: 20px;
    margin-top: 40px;
    padding-top: 30px;
    border-top: 1px solid #edf2f7;
}

.nav-link {
    flex: 1;
    padding: 20px;
    background: #f8fafc;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.nav-link:hover {
    background: #ebf8ff;
}

.nav-link span:first-child {
    display: block;
    color: #718096;
    font-size: 13px;
    margin-bottom: 8px;
}

.nav-link.next {
    text-align: right;
}

.nav-title {
    display: block;
    color: #1a365d;
    font-weight: 600;
}

.post-sidebar {
    position: sticky;
    top: 100px;
    height: fit-content;
}

.sidebar-widget {
    background: white;
    padding: 25px;
    border-radius: 12px;
    margin-bottom: 25px;
}

.sidebar-widget h3 {
    margin: 0 0 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #edf2f7;
    color: #1a365d;
}

.author-card {
    text-align: center;
}

.author-photo {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    margin-bottom: 15px;
}

.author-card h4 {
    margin: 0 0 10px;
    color: #1a365d;
}

.author-card p {
    color: #718096;
    font-size: 14px;
    margin: 0;
}

.related-posts {
    list-style: none;
    padding: 0;
    margin: 0;
}

.related-posts li {
    padding: 12px 0;
    border-bottom: 1px solid #edf2f7;
}

.related-posts li:last-child {
    border-bottom: none;
}

.related-posts a {
    display: flex;
    gap: 12px;
    text-decoration: none;
}

.related-thumb {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
}

.related-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.related-info {
    display: flex;
    flex-direction: column;
}

.related-title {
    color: #1a365d;
    font-weight: 500;
    line-height: 1.4;
    margin-bottom: 5px;
}

.related-date {
    color: #a0aec0;
    font-size: 12px;
}

.comments-section {
    background: white;
    padding: 50px 0;
}

.comments-section h3 {
    margin: 0 0 30px;
    color: #1a365d;
}

@media (max-width: 968px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
    
    .post-sidebar {
        position: static;
    }
    
    .post-title {
        font-size: 28px;
    }
    
    .post-meta {
        flex-direction: column;
        gap: 15px;
    }
}
</style>

<?php get_footer(); ?>
