<?php
/**
 * Template Name: Blog
 */

get_header();
?>

<div class="blog-page">
    <div class="blog-hero">
        <div class="container">
            <h1>Our Blog</h1>
            <p>Latest news, tips, and insights about Indonesian real estate</p>
        </div>
    </div>

    <div class="blog-container">
        <div class="blog-main">
            <?php if (have_posts()) : ?>
                <div class="posts-grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <article class="post-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium_large'); ?>
                                    </a>
                                    <span class="post-category">
                                        <?php
                                        $categories = get_the_category();
                                        if (!empty($categories)) {
                                            echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a>';
                                        }
                                        ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="post-content">
                                <div class="post-meta">
                                    <span class="post-date">
                                        <i class="far fa-calendar"></i>
                                        <?php echo get_the_date(); ?>
                                    </span>
                                    <span class="post-author">
                                        <i class="far fa-user"></i>
                                        <?php the_author(); ?>
                                    </span>
                                    <span class="post-comments">
                                        <i class="far fa-comment"></i>
                                        <?php comments_number('0', '1', '%'); ?>
                                    </span>
                                </div>
                                
                                <h2 class="post-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                
                                <div class="post-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                                
                                <a href="<?php the_permalink(); ?>" class="read-more">
                                    Read More <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <div class="pagination">
                    <?php
                    echo paginate_links(array(
                        'prev_text' => '<i class="fas fa-chevron-left"></i> Previous',
                        'next_text' => 'Next <i class="fas fa-chevron-right"></i>',
                    ));
                    ?>
                </div>
            <?php else : ?>
                <div class="no-posts">
                    <i class="far fa-newspaper"></i>
                    <h2>No posts found</h2>
                    <p>Check back soon for new content!</p>
                </div>
            <?php endif; ?>
        </div>

        <aside class="blog-sidebar">
            <div class="sidebar-widget">
                <h3 class="widget-title">Search</h3>
                <form class="search-form" action="<?php echo esc_url(home_url('/')); ?>" method="get">
                    <input type="hidden" name="post_type" value="post">
                    <input type="text" name="s" placeholder="Search posts...">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>

            <div class="sidebar-widget">
                <h3 class="widget-title">Categories</h3>
                <ul class="category-list">
                    <?php
                    wp_list_categories(array(
                        'title_li' => '',
                        'show_count' => true,
                    ));
                    ?>
                </ul>
            </div>

            <div class="sidebar-widget">
                <h3 class="widget-title">Recent Posts</h3>
                <ul class="recent-posts">
                    <?php
                    $recent_posts = wp_get_recent_posts(array('numberposts' => 5));
                    foreach ($recent_posts as $post) :
                    ?>
                        <li>
                            <a href="<?php echo esc_url(get_permalink($post['ID'])); ?>">
                                <?php if (has_post_thumbnail($post['ID'])) : ?>
                                    <div class="recent-thumb">
                                        <?php echo get_the_post_thumbnail($post['ID'], 'thumbnail'); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="recent-info">
                                    <span class="recent-title"><?php echo esc_html($post['post_title']); ?></span>
                                    <span class="recent-date"><?php echo get_the_date('M j, Y', $post['ID']); ?></span>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="sidebar-widget">
                <h3 class="widget-title">Tags</h3>
                <div class="tag-cloud">
                    <?php wp_tag_cloud(array(
                        'smallest' => 12,
                        'largest' => 18,
                        'unit' => 'px',
                        'format' => 'flat',
                    )); ?>
                </div>
            </div>

            <div class="sidebar-widget cta-widget">
                <h3>Looking for Property?</h3>
                <p>Let us help you find your dream home in Indonesia.</p>
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-sidebar">Contact Us</a>
            </div>
        </aside>
    </div>
</div>

<style>
.blog-page {
    background: #f8f9fa;
}

.blog-hero {
    background: linear-gradient(135deg, #1a365d 0%, #2c5282 100%);
    color: white;
    padding: 60px 0;
    text-align: center;
}

.blog-hero h1 {
    font-size: 42px;
    margin-bottom: 15px;
}

.blog-hero p {
    font-size: 18px;
    opacity: 0.9;
    margin: 0;
}

.blog-container {
    display: flex;
    max-width: 1200px;
    margin: 0 auto;
    padding: 60px 20px;
    gap: 40px;
}

.blog-main {
    flex: 1;
}

.posts-grid {
    display: grid;
    gap: 30px;
}

.post-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.post-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.12);
}

.post-image {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.post-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.post-card:hover .post-image img {
    transform: scale(1.05);
}

.post-category {
    position: absolute;
    top: 15px;
    left: 15px;
}

.post-category a {
    background: #3182ce;
    color: white;
    padding: 6px 15px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
}

.post-content {
    padding: 25px;
}

.post-meta {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
    color: #718096;
    font-size: 13px;
}

.post-meta span {
    display: flex;
    align-items: center;
    gap: 5px;
}

.post-title {
    margin: 0 0 15px;
    font-size: 22px;
}

.post-title a {
    color: #1a365d;
    text-decoration: none;
}

.post-title a:hover {
    color: #3182ce;
}

.post-excerpt {
    color: #4a5568;
    line-height: 1.7;
    margin-bottom: 20px;
}

.read-more {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #3182ce;
    font-weight: 600;
    text-decoration: none;
}

.read-more:hover {
    color: #2c5282;
}

.read-more i {
    transition: transform 0.3s ease;
}

.read-more:hover i {
    transform: translateX(5px);
}

.pagination {
    margin-top: 40px;
}

.pagination .page-numbers {
    display: inline-flex;
    gap: 8px;
}

.pagination .page-numbers a,
.pagination .page-numbers span {
    padding: 10px 18px;
    background: white;
    color: #4a5568;
    border-radius: 6px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.pagination .page-numbers a:hover,
.pagination .page-numbers current {
    background: #3182ce;
    color: white;
}

.no-posts {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 12px;
}

.no-posts i {
    font-size: 64px;
    color: #cbd5e0;
    margin-bottom: 20px;
}

.no-posts h2 {
    color: #4a5568;
    margin-bottom: 10px;
}

.blog-sidebar {
    width: 320px;
    flex-shrink: 0;
}

.sidebar-widget {
    background: white;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.widget-title {
    margin: 0 0 20px;
    font-size: 18px;
    color: #1a365d;
    padding-bottom: 15px;
    border-bottom: 2px solid #edf2f7;
}

.search-form {
    display: flex;
    gap: 10px;
}

.search-form input {
    flex: 1;
    padding: 12px 15px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
}

.search-form button {
    padding: 12px 18px;
    background: #3182ce;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.category-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.category-list li {
    padding: 10px 0;
    border-bottom: 1px solid #edf2f7;
}

.category-list li:last-child {
    border-bottom: none;
}

.category-list a {
    color: #4a5568;
    text-decoration: none;
    display: flex;
    justify-content: space-between;
}

.category-list a:hover {
    color: #3182ce;
}

.recent-posts {
    list-style: none;
    padding: 0;
    margin: 0;
}

.recent-posts li {
    padding: 10px 0;
    border-bottom: 1px solid #edf2f7;
}

.recent-posts li:last-child {
    border-bottom: none;
}

.recent-posts a {
    display: flex;
    gap: 15px;
    text-decoration: none;
}

.recent-thumb {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
}

.recent-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.recent-info {
    display: flex;
    flex-direction: column;
}

.recent-title {
    color: #1a365d;
    font-weight: 500;
    line-height: 1.4;
    margin-bottom: 5px;
}

.recent-date {
    color: #a0aec0;
    font-size: 12px;
}

.tag-cloud {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.tag-cloud a {
    background: #edf2f7;
    color: #4a5568;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    text-decoration: none;
}

.tag-cloud a:hover {
    background: #3182ce;
    color: white;
}

.cta-widget {
    background: linear-gradient(135deg, #3182ce 0%, #2c5282 100%);
    color: white;
    text-align: center;
}

.cta-widget h3 {
    margin: 0 0 15px;
}

.cta-widget p {
    margin: 0 0 20px;
    opacity: 0.9;
}

.btn-sidebar {
    display: inline-block;
    padding: 12px 30px;
    background: white;
    color: #1a365d;
    border-radius: 6px;
    font-weight: 600;
    text-decoration: none;
}

@media (max-width: 968px) {
    .blog-container {
        flex-direction: column;
    }
    
    .blog-sidebar {
        width: 100%;
    }
}
</style>

<?php get_footer(); ?>
