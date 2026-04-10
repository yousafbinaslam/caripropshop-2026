<?php
/**
 * The main template file
 * Serves React app on homepage, WordPress content elsewhere
 */

get_header();

// Check if this is the front page
if (is_front_page()) {
    // Serve React app
    $react_app_path = get_template_directory() . '/react-app/index.html';
    if (file_exists($react_app_path)) {
        include $react_app_path;
        get_footer();
        return;
    }
}
?>

<main id="main" class="site-main cps-main-content">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            get_template_part('template-parts/content', get_post_type());
        endwhile;
        
        the_posts_pagination();
    else :
        get_template_part('template-parts/content', 'none');
    endif;
    ?>
</main>

<?php
get_sidebar();
get_footer();
