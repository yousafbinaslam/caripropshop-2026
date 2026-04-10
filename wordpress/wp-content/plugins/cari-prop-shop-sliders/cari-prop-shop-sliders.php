<?php
/**
 * Plugin Name: CariPropShop Sliders
 * Plugin URI: https://caripropshop.com
 * Description: Hero and property slider system for CariPropShop WordPress sites
 * Version: 1.0.0
 * Author: CariPropShop
 * Author URI: https://caripropshop.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: cari-prop-shop-sliders
 */

if (!defined('ABSPATH')) {
    exit;
}

define('CPS_SLIDERS_VERSION', '1.0.0');
define('CPS_SLIDERS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CPS_SLIDERS_PLUGIN_URL', plugin_dir_url(__FILE__));

class CariPropShop_Sliders {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('init', array($this, 'register_post_types'));
        add_action('init', array($this, 'register_shortcodes'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
    }

    public function register_post_types() {
        register_post_type('cps_slider', array(
            'labels' => array(
                'name' => __('Sliders', 'cari-prop-shop-sliders'),
                'singular_name' => __('Slider', 'cari-prop-shop-sliders'),
            ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_icon' => 'dashicons-images-alt2',
            'supports' => array('title'),
        ));
    }

    public function register_shortcodes() {
        add_shortcode('cps_hero_slider', array($this, 'render_hero_slider'));
        add_shortcode('cps_property_slider', array($this, 'render_property_slider'));
    }

    public function enqueue_assets() {
        wp_enqueue_style('cps-slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), '1.8.1');
        wp_enqueue_style('cps-slick-theme', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css', array('cps-slick'), '1.8.1');
        wp_enqueue_script('cps-slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '1.8.1', true);
    }

    public function render_hero_slider($atts) {
        $atts = shortcode_atts(array('id' => 0), $atts, 'cps_hero_slider');
        if (empty($atts['id'])) {
            return '<p>Please specify a slider ID.</p>';
        }
        $slides = get_post_meta($atts['id'], 'cps_slides', true);
        if (empty($slides)) {
            return '';
        }
        $unique_id = 'cps-hero-' . $atts['id'];
        ob_start();
        ?>
        <div class="cps-hero-slider" id="<?php echo esc_attr($unique_id); ?>">
            <?php foreach ($slides as $slide) : ?>
                <div class="cps-hero-slide">
                    <?php if (!empty($slide['image'])) : ?>
                        <img src="<?php echo esc_url($slide['image']); ?>" alt="" />
                    <?php endif; ?>
                    <div class="cps-hero-overlay"></div>
                    <div class="cps-hero-content">
                        <?php if (!empty($slide['title'])) : ?>
                            <h2><?php echo esc_html($slide['title']); ?></h2>
                        <?php endif; ?>
                        <?php if (!empty($slide['subtitle'])) : ?>
                            <p><?php echo esc_html($slide['subtitle']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($slide['cta_text'])) : ?>
                            <a href="<?php echo esc_url($slide['cta_link']); ?>" class="cps-cta-btn">
                                <?php echo esc_html($slide['cta_text']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <script>
            jQuery(document).ready(function($) {
                $('#<?php echo esc_js($unique_id); ?>').slick({
                    autoplay: true,
                    dots: true,
                    fade: true
                });
            });
        </script>
        <?php
        return ob_get_clean();
    }

    public function render_property_slider($atts) {
        $atts = shortcode_atts(array('count' => 6), $atts, 'cps_property_slider');
        $query = new WP_Query(array(
            'post_type' => 'property',
            'posts_per_page' => intval($atts['count']),
            'post_status' => 'publish',
        ));
        if (!$query->have_posts()) {
            return '<p>No properties found.</p>';
        }
        $unique_id = 'cps-property-' . uniqid();
        ob_start();
        ?>
        <div class="cps-property-slider" id="<?php echo esc_attr($unique_id); ?>">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="cps-property-slide">
                    <?php if (has_post_thumbnail()) : the_post_thumbnail('medium'); endif; ?>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <?php $price = get_post_meta(get_the_ID(), 'property_price', true); ?>
                    <?php if ($price) : ?><p class="price"><?php echo esc_html($price); ?></p><?php endif; ?>
                </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
        <script>
            jQuery(document).ready(function($) {
                $('#<?php echo esc_js($unique_id); ?>').slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    autoplay: true,
                    responsive: [{breakpoint: 768, settings: {slidesToShow: 1}}]
                });
            });
        </script>
        <?php
        return ob_get_clean();
    }
}

add_action('plugins_loaded', function() {
    return CariPropShop_Sliders::get_instance();
});
