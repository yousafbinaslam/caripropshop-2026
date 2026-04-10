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
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'CPS_VERSION', '1.0.0' );
define( 'CPS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CPS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'CPS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

require_once CPS_PLUGIN_DIR . 'includes/class-cps-slider-manager.php';
require_once CPS_PLUGIN_DIR . 'admin/class-cps-admin-sliders.php';
require_once CPS_PLUGIN_DIR . 'admin/class-cps-admin-slider-editor.php';
require_once CPS_PLUGIN_DIR . 'admin/class-cps-admin-meta-boxes.php';
require_once CPS_PLUGIN_DIR . 'admin/class-cps-admin-settings.php';
require_once CPS_PLUGIN_DIR . 'public/class-cps-public-templates.php';

class CariPropShop_Sliders {

    private static $instance = null;
    public $slider_manager;

    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->slider_manager = new CPS_Slider_Manager();
        $this->init_hooks();
    }

    private function init_hooks() {
        add_action( 'init', array( $this, 'register_post_types' ) );
        add_action( 'init', array( $this, 'register_shortcodes' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_assets' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
        add_filter( 'post_updated_messages', array( $this, 'post_updated_messages' ) );
    }

    public function register_post_types() {
        register_post_type(
            'cps_slider',
            array(
                'labels' => array(
                    'name'               => __( 'Sliders', 'cari-prop-shop-sliders' ),
                    'singular_name'      => __( 'Slider', 'cari-prop-shop-sliders' ),
                    'menu_name'          => __( 'CariPropShop Sliders', 'cari-prop-shop-sliders' ),
                    'add_new'            => __( 'Add New Slider', 'cari-prop-shop-sliders' ),
                    'add_new_item'       => __( 'Add New Slider', 'cari-prop-shop-sliders' ),
                    'edit_item'          => __( 'Edit Slider', 'cari-prop-shop-sliders' ),
                    'new_item'           => __( 'New Slider', 'cari-prop-shop-sliders' ),
                    'view_item'          => __( 'View Slider', 'cari-prop-shop-sliders' ),
                    'search_items'       => __( 'Search Sliders', 'cari-prop-shop-sliders' ),
                    'not_found'          => __( 'No sliders found', 'cari-prop-shop-sliders' ),
                    'not_found_in_trash' => __( 'No sliders found in trash', 'cari-prop-shop-sliders' ),
                ),
                'public'             => false,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'menu_icon'          => 'dashicons-images-alt2',
                'capability_type'    => 'post',
                'supports'           => array( 'title', 'custom-fields' ),
                'rewrite'            => false,
                'show_in_rest'       => false,
                'has_archive'       => false,
            )
        );
    }

    public function register_shortcodes() {
        add_shortcode( 'cps_hero_slider', array( $this, 'render_hero_slider' ) );
        add_shortcode( 'cps_property_slider', array( $this, 'render_property_slider' ) );
        add_shortcode( 'cps_testimonial_slider', array( $this, 'render_testimonial_slider' ) );
    }

    public function render_hero_slider( $atts ) {
        $atts = shortcode_atts(
            array(
                'id'    => 0,
                'slug'  => '',
            ),
            $atts,
            'cps_hero_slider'
        );

        if ( empty( $atts['id'] ) && empty( $atts['slug'] ) ) {
            return '<p class="cps-error">' . esc_html__( 'Please specify a slider ID or slug.', 'cari-prop-shop-sliders' ) . '</p>';
        }

        $slider_id = 0;
        if ( ! empty( $atts['id'] ) ) {
            $slider_id = intval( $atts['id'] );
        } elseif ( ! empty( $atts['slug'] ) ) {
            $slider = get_page_by_path( $atts['slug'], OBJECT, 'cps_slider' );
            $slider_id = $slider ? $slider->ID : 0;
        }

        if ( ! $slider_id ) {
            return '<p class="cps-error">' . esc_html__( 'Slider not found.', 'cari-prop-shop-sliders' ) . '</p>';
        }

        $slides = $this->slider_manager->get_slides( $slider_id );
        if ( empty( $slides ) ) {
            return '';
        }

        $settings = $this->slider_manager->get_settings( $slider_id );
        $unique_id = 'cps-hero-' . $slider_id . '-' . uniqid();

        ob_start();
        ?>
        <div id="<?php echo esc_attr( $unique_id ); ?>" class="cps-hero-slider-wrapper">
            <div class="cps-hero-slider cps-slick-slider"
                 data-slick='<?php echo json_encode( $this->get_slick_settings( $settings ) ); ?>'>
                <?php foreach ( $slides as $slide ) : ?>
                    <?php
                    $slide_settings = maybe_unserialize( get_post_meta( $slide->ID, 'cps_slide_settings', true ) );
                    $bg_type = isset( $slide_settings['bg_type'] ) ? $slide_settings['bg_type'] : 'image';
                    $bg_image = isset( $slide_settings['background_image'] ) ? wp_get_attachment_url( $slide_settings['background_image'] ) : '';
                    $bg_color = isset( $slide_settings['background_color'] ) ? $slide_settings['background_color'] : '#000000';
                    $overlay_opacity = isset( $slide_settings['overlay_opacity'] ) ? floatval( $slide_settings['overlay_opacity'] ) / 100 : 0.5;
                    $title = isset( $slide_settings['title'] ) ? $slide_settings['title'] : $slide->post_title;
                    $subtitle = isset( $slide_settings['subtitle'] ) ? $slide_settings['subtitle'] : '';
                    $cta_text = isset( $slide_settings['cta_text'] ) ? $slide_settings['cta_text'] : '';
                    $cta_link = isset( $slide_settings['cta_link'] ) ? $slide_settings['cta_link'] : '#';
                    $alignment = isset( $slide_settings['alignment'] ) ? $slide_settings['alignment'] : 'center';
                    ?>
                    <div class="cps-hero-slide" data-bg-type="<?php echo esc_attr( $bg_type ); ?>">
                        <?php if ( 'video' === $bg_type && isset( $slide_settings['video_url'] ) ) : ?>
                            <video class="cps-hero-video" autoplay muted loop playsinline>
                                <source src="<?php echo esc_url( $slide_settings['video_url'] ); ?>" type="video/mp4">
                            </video>
                        <?php elseif ( 'image' === $bg_type && $bg_image ) : ?>
                            <div class="cps-hero-bg" style="background-image: url('<?php echo esc_url( $bg_image ); ?>');"></div>
                        <?php else : ?>
                            <div class="cps-hero-bg" style="background-color: <?php echo esc_attr( $bg_color ); ?>;"></div>
                        <?php endif; ?>
                        <div class="cps-hero-overlay" style="opacity: <?php echo esc_attr( $overlay_opacity ); ?>;"></div>
                        <div class="cps-hero-content" data-alignment="<?php echo esc_attr( $alignment ); ?>">
                            <div class="cps-hero-content-inner">
                                <?php if ( $title ) : ?>
                                    <h2 class="cps-hero-title"><?php echo esc_html( $title ); ?></h2>
                                <?php endif; ?>
                                <?php if ( $subtitle ) : ?>
                                    <p class="cps-hero-subtitle"><?php echo esc_html( $subtitle ); ?></p>
                                <?php endif; ?>
                                <?php if ( $cta_text ) : ?>
                                    <a href="<?php echo esc_url( $cta_link ); ?>" class="cps-hero-cta">
                                        <?php echo esc_html( $cta_text ); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    public function render_property_slider( $atts ) {
        $atts = shortcode_atts(
            array(
                'posts_per_page' => 6,
                'columns'       => 3,
                'category'      => '',
                'show_arrows'   => 'true',
                'show_dots'     => 'false',
                'autoplay'      => 'true',
            ),
            $atts,
            'cps_property_slider'
        );

        $query_args = array(
            'post_type'      => 'property',
            'posts_per_page' => intval( $atts['posts_per_page'] ),
            'post_status'    => 'publish',
        );

        if ( ! empty( $atts['category'] ) ) {
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'property_category',
                    'field'    => 'slug',
                    'terms'    => explode( ',', $atts['category'] ),
                ),
            );
        }

        $query = new WP_Query( $query_args );
        if ( ! $query->have_posts() ) {
            return '<p class="cps-error">' . esc_html__( 'No properties found.', 'cari-prop-shop-sliders' ) . '</p>';
        }

        $unique_id = 'cps-property-' . uniqid();
        $columns = intval( $atts['columns'] );

        ob_start();
        ?>
        <div id="<?php echo esc_attr( $unique_id ); ?>" class="cps-property-slider-wrapper">
            <div class="cps-property-slider cps-slick-slider"
                 data-slick='<?php echo json_encode( array(
                     'slidesToShow'  => min( $columns, 3 ),
                     'slidesToScroll' => 1,
                     'autoplay'     => 'true' === $atts['autoplay'],
                     'arrows'      => 'true' === $atts['show_arrows'],
                     'dots'        => 'true' === $atts['show_dots'],
                     'responsive'  => array(
                         array(
                             'breakpoint' => 1024,
                             'settings'  => array( 'slidesToShow' => min( $columns - 1, 2 ) ),
                         ),
                         array(
                             'breakpoint' => 768,
                             'settings'  => array( 'slidesToShow' => 1 ),
                         ),
                     ),
                 ) ); ?>'>
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <?php
                    $price = get_post_meta( get_the_ID(), 'property_price', true );
                    $address = get_post_meta( get_the_ID(), 'property_address', true );
                    $beds = get_post_meta( get_the_ID(), 'property_bedrooms', true );
                    $baths = get_post_meta( get_the_ID(), 'property_bathrooms', true );
                    $sqft = get_post_meta( get_the_ID(), 'property_sqft', true );
                    $status = get_post_meta( get_the_ID(), 'property_status', true );
                    ?>
                    <div class="cps-property-slide">
                        <div class="cps-property-card">
                            <div class="cps-property-image">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'property-thumbnail', array( 'class' => 'cps-property-featured-image' ) ); ?>
                                <?php else : ?>
                                    <div class="cps-property-no-image"><?php esc_html_e( 'No Image', 'cari-prop-shop-sliders' ); ?></div>
                                <?php endif; ?>
                                <?php if ( $status ) : ?>
                                    <span class="cps-property-status"><?php echo esc_html( $status ); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="cps-property-details">
                                <?php if ( $price ) : ?>
                                    <div class="cps-property-price"><?php echo esc_html( $price ); ?></div>
                                <?php endif; ?>
                                <h3 class="cps-property-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <?php if ( $address ) : ?>
                                    <p class="cps-property-address"><?php echo esc_html( $address ); ?></p>
                                <?php endif; ?>
                                <div class="cps-property-meta">
                                    <?php if ( $beds ) : ?>
                                        <span class="cps-property-beds"><?php echo esc_html( $beds ); ?> <?php esc_html_e( 'Beds', 'cari-prop-shop-sliders' ); ?></span>
                                    <?php endif; ?>
                                    <?php if ( $baths ) : ?>
                                        <span class="cps-property-baths"><?php echo esc_html( $baths ); ?> <?php esc_html_e( 'Baths', 'cari-prop-shop-sliders' ); ?></span>
                                    <?php endif; ?>
                                    <?php if ( $sqft ) : ?>
                                        <span class="cps-property-sqft"><?php echo esc_html( $sqft ); ?> <?php esc_html_e( 'sqft', 'cari-prop-shop-sliders' ); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    public function render_testimonial_slider( $atts ) {
        $atts = shortcode_atts(
            array(
                'posts_per_page' => 5,
                'show_arrows'   => 'true',
                'show_dots'    => 'true',
                'autoplay'      => 'true',
            ),
            $atts,
            'cps_testimonial_slider'
        );

        $query_args = array(
            'post_type'      => 'testimonial',
            'posts_per_page' => intval( $atts['posts_per_page'] ),
            'post_status'   => 'publish',
        );

        $query = new WP_Query( $query_args );
        if ( ! $query->have_posts() ) {
            return '<p class="cps-error">' . esc_html__( 'No testimonials found.', 'cari-prop-shop-sliders' ) . '</p>';
        }

        $unique_id = 'cps-testimonial-' . uniqid();

        ob_start();
        ?>
        <div id="<?php echo esc_attr( $unique_id ); ?>" class="cps-testimonial-slider-wrapper">
            <div class="cps-testimonial-slider cps-slick-slider"
                 data-slick='<?php echo json_encode( array(
                     'slidesToShow'  => 1,
                     'slidesToScroll' => 1,
                     'autoplay'     => 'true' === $atts['autoplay'],
                     'arrows'      => 'true' === $atts['show_arrows'],
                     'dots'        => 'true' === $atts['show_dots'],
                     'responsive'  => array(
                         array(
                             'breakpoint' => 768,
                             'settings'  => array( 'slidesToShow' => 1 ),
                         ),
                     ),
                 ) ); ?>'>
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <?php
                    $client_name = get_post_meta( get_the_ID(), 'testimonial_client_name', true );
                    $client_title = get_post_meta( get_the_ID(), 'testimonial_client_title', true );
                    $client_rating = get_post_meta( get_the_ID(), 'testimonial_rating', true );
                    ?>
                    <div class="cps-testimonial-slide">
                        <div class="cps-testimonial-card">
                            <div class="cps-testimonial-content">
                                <?php if ( $client_rating ) : ?>
                                    <div class="cps-testimonial-rating">
                                        <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                                            <span class="cps-star<?php echo $i <= intval( $client_rating ) ? ' filled' : ''; ?>">&#9733;</span>
                                        <?php endfor; ?>
                                    </div>
                                <?php endif; ?>
                                <blockquote class="cps-testimonial-text">
                                    <?php the_content(); ?>
                                </blockquote>
                                <?php if ( $client_name ) : ?>
                                    <cite class="cps-testimonial-author">
                                        <strong><?php echo esc_html( $client_name ); ?></strong>
                                        <?php if ( $client_title ) : ?>
                                            <span class="cps-testimonial-title"><?php echo esc_html( $client_title ); ?></span>
                                        <?php endif; ?>
                                    </cite>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    private function get_slick_settings( $settings ) {
        $slick_settings = array(
            'slidesToShow'  => 1,
            'slidesToScroll' => 1,
            'autoplay'     => isset( $settings['autoplay'] ) ? (bool) $settings['autoplay'] : true,
            'arrows'      => isset( $settings['show_arrows'] ) ? (bool) $settings['show_arrows'] : true,
            'dots'        => isset( $settings['show_dots'] ) ? (bool) $settings['show_dots'] : true,
            'fade'       => true,
            'cssEase'    => 'linear',
        );

        if ( isset( $settings['autoplay_speed'] ) ) {
            $slick_settings['autoplaySpeed'] = intval( $settings['autoplay_speed'] ) * 1000;
        }

        if ( isset( $settings['transition_speed'] ) ) {
            $slick_settings['speed'] = intval( $settings['transition_speed'] ) * 1000;
        }

        return $slick_settings;
    }

    public function enqueue_public_assets() {
        wp_enqueue_style(
            'cps-slick',
            'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css',
            array(),
            '1.8.1'
        );

        wp_enqueue_style(
            'cps-slick-theme',
            'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css',
            array( 'cps-slick' ),
            '1.8.1'
        );

        wp_enqueue_style(
            'cps-public',
            CPS_PLUGIN_URL . 'assets/css/public.css',
            array( 'cps-slick-theme' ),
            CPS_VERSION
        );

        wp_enqueue_script(
            'cps-slick',
            'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',
            array( 'jquery' ),
            '1.8.1',
            true
        );

        wp_enqueue_script(
            'cps-public',
            CPS_PLUGIN_URL . 'assets/js/public.js',
            array( 'jquery', 'cps-slick' ),
            CPS_VERSION,
            true
        );
    }

    public function enqueue_admin_assets( $hook_suffix ) {
        global $post_type;

        if ( 'cps_slider' !== $post_type ) {
            return;
        }

        wp_enqueue_media();

        wp_enqueue_style(
            'cps-admin',
            CPS_PLUGIN_URL . 'assets/css/admin.css',
            array(),
            CPS_VERSION
        );

        wp_enqueue_script(
            'cps-admin',
            CPS_PLUGIN_URL . 'assets/js/admin.js',
            array( 'jquery', 'wp-util' ),
            CPS_VERSION,
            true
        );

        wp_localize_script(
            'cps-admin',
            'cpsAdmin',
            array(
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                'nonce'  => wp_create_nonce( 'cps_admin_nonce' ),
            )
        );
    }

    public function post_updated_messages( $messages ) {
        global $post;

        $messages['cps_slider'] = array(
            0  => '',
            1  => __( 'Slider updated.', 'cari-prop-shop-sliders' ),
            2  => __( 'Custom field updated.', 'cari-prop-shop-sliders' ),
            3  => __( 'Custom field deleted.', 'cari-prop-shop-sliders' ),
            4  => __( 'Slider updated.', 'cari-prop-shop-sliders' ),
            5  => isset( $_GET['revision'] ) ? sprintf( __( 'Slider restored to revision from %s.', 'cari-prop-shop-sliders' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
            6  => __( 'Slider published.', 'cari-prop-shop-sliders' ),
            7  => __( 'Slider saved.', 'cari-prop-shop-sliders' ),
            8  => __( 'Slider submitted.', 'cari-prop-shop-sliders' ),
            9  => sprintf( __( 'Slider scheduled for: <strong>%s</strong>.', 'cari-prop-shop-sliders' ), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ) ),
            10 => __( 'Slider draft updated.', 'cari-prop-shop-sliders' ),
        );

        return $messages;
    }
}

function CPS() {
    return CariPropShop_Sliders::get_instance();
}

CPS();