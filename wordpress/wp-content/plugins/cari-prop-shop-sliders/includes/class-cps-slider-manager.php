<?php
/**
 * Slider Manager Class
 * 
 * Handles CRUD operations for sliders and slides
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CPS_Slider_Manager {

    private $post_type = 'cps_slider';
    private $slide_post_type = 'cps_slide';

    public function __construct() {
        $this->init_hooks();
    }

    private function init_hooks() {
        add_action( 'init', array( $this, 'register_slide_post_type' ) );
        add_action( 'add_meta_boxes', array( $this, 'add_slider_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'save_slider_meta' ), 10, 2 );
        add_action( 'wp_ajax_cps_get_slides', array( $this, 'ajax_get_slides' ) );
        add_action( 'wp_ajax_cps_save_slide', array( $this, 'ajax_save_slide' ) );
        add_action( 'wp_ajax_cps_delete_slide', array( $this, 'ajax_delete_slide' ) );
        add_action( 'wp_ajax_cps_reorder_slides', array( $this, 'ajax_reorder_slides' ) );
        add_filter( 'manage_' . $this->post_type . '_posts_columns', array( $this, 'add_columns' ) );
        add_filter( 'manage_' . $this->post_type . '_posts_custom_column', array( $this, 'render_columns' ), 10, 2 );
    }

    public function register_slide_post_type() {
        register_post_type(
            $this->slide_post_type,
            array(
                'labels' => array(
                    'name'          => __( 'Slides', 'cari-prop-shop-sliders' ),
                    'singular_name' => __( 'Slide', 'cari-prop-shop-sliders' ),
                ),
                'public'       => false,
                'show_ui'      => false,
                'show_in_menu' => false,
            )
        );
    }

    public function get_sliders( $args = array() ) {
        $defaults = array(
            'post_type'      => $this->post_type,
            'post_status'   => 'publish',
            'posts_per_page' => -1,
            'orderby'       => 'menu_order',
            'order'         => 'ASC',
        );

        $args = wp_parse_args( $args, $defaults );
        $query = new WP_Query( $args );

        return $query->posts;
    }

    public function get_slider( $slider_id ) {
        return get_post( $slider_id );
    }

    public function get_slides( $slider_id ) {
        $slides = get_children(
            array(
                'post_parent'    => $slider_id,
                'post_type'     => $this->slide_post_type,
                'post_status'   => 'publish',
                'posts_per_page' => -1,
                'orderby'       => 'menu_order',
                'order'         => 'ASC',
            )
        );

        return array_values( $slides );
    }

    public function get_settings( $slider_id ) {
        $settings = get_post_meta( $slider_id, 'cps_slider_settings', true );
        return wp_parse_args(
            (array) $settings,
            $this->get_default_settings()
        );
    }

    public function get_default_settings() {
        return array(
            'autoplay'         => true,
            'autoplay_speed'   => 5,
            'transition_speed' => 0.5,
            'show_arrows'      => true,
            'show_dots'       => true,
            'pause_on_hover'   => true,
            'loop'             => true,
            'effect'           => 'fade',
            'height'           => 600,
            'full_height'     => false,
        );
    }

    public function create_slider( $title, $settings = array() ) {
        $slider_data = array(
            'post_title'  => $title,
            'post_type'   => $this->post_type,
            'post_status' => 'publish',
            'post_author' => get_current_user_id(),
        );

        $slider_id = wp_insert_post( $slider_data );

        if ( ! is_wp_error( $slider_id ) ) {
            update_post_meta( $slider_id, 'cps_slider_settings', $settings );
        }

        return $slider_id;
    }

    public function update_slider( $slider_id, $title, $settings = array() ) {
        $slider_data = array(
            'ID'          => $slider_id,
            'post_title' => $title,
        );

        wp_update_post( $slider_data );

        if ( ! empty( $settings ) ) {
            update_post_meta( $slider_id, 'cps_slider_settings', $settings );
        }

        return $slider_id;
    }

    public function delete_slider( $slider_id ) {
        $slides = $this->get_slides( $slider_id );
        foreach ( $slides as $slide ) {
            wp_delete_post( $slide->ID, true );
        }

        return wp_delete_post( $slider_id, true );
    }

    public function create_slide( $slider_id, $slide_data = array() ) {
        $defaults = array(
            'post_title'   => isset( $slide_data['title'] ) ? $slide_data['title'] : '',
            'post_type'   => $this->slide_post_type,
            'post_status' => 'publish',
            'post_parent' => $slider_id,
            'post_author' => get_current_user_id(),
        );

        $slide_id = wp_insert_post( $slide_data + $defaults );

        if ( ! is_wp_error( $slide_id ) && ! empty( $slide_data['settings'] ) ) {
            update_post_meta( $slide_id, 'cps_slide_settings', $slide_data['settings'] );
        }

        return $slide_id;
    }

    public function update_slide_settings( $slide_id, $settings ) {
        update_post_meta( $slide_id, 'cps_slide_settings', $settings );
    }

    public function delete_slide( $slide_id ) {
        return wp_delete_post( $slide_id, true );
    }

    public function reorder_slides( $slider_id, $slide_order ) {
        foreach ( $slide_order as $position => $slide_id ) {
            wp_update_post(
                array(
                    'ID'        => intval( $slide_id ),
                    'menu_order' => intval( $position ),
                )
            );
        }
    }

    public function add_slider_meta_boxes() {
        add_meta_box(
            'cps_slider_settings',
            __( 'Slider Settings', 'cari-prop-shop-sliders' ),
            array( $this, 'render_settings_meta_box' ),
            $this->post_type,
            'normal',
            'high'
        );

        add_meta_box(
            'cps_slides_list',
            __( 'Slides', 'cari-prop-shop-sliders' ),
            array( $this, 'render_slides_meta_box' ),
            $this->post_type,
            'normal',
            'high'
        );
    }

    public function render_settings_meta_box( $post ) {
        $settings = $this->get_settings( $post->ID );
        ?>
        <div class="cps-settings-meta-box">
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="cps_autoplay"><?php esc_html_e( 'Auto Play', 'cari-prop-shop-sliders' ); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" id="cps_autoplay" name="cps_settings[autoplay]" value="1" <?php checked( $settings['autoplay'], true ); ?> />
                        <span class="description"><?php esc_html_e( 'Automatically advance slides', 'cari-prop-shop-sliders' ); ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="cps_autoplay_speed"><?php esc_html_e( 'Auto Play Speed (seconds)', 'cari-prop-shop-sliders' ); ?></label>
                    </th>
                    <td>
                        <input type="number" id="cps_autoplay_speed" name="cps_settings[autoplay_speed]" value="<?php echo esc_attr( $settings['autoplay_speed'] ); ?>" min="1" max="60" step="0.5" class="small-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="cps_transition_speed"><?php esc_html_e( 'Transition Speed (seconds)', 'cari-prop-shop-sliders' ); ?></label>
                    </th>
                    <td>
                        <input type="number" id="cps_transition_speed" name="cps_settings[transition_speed]" value="<?php echo esc_attr( $settings['transition_speed'] ); ?>" min="0.1" max="5" step="0.1" class="small-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="cps_show_arrows"><?php esc_html_e( 'Show Arrows', 'cari-prop-shop-sliders' ); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" id="cps_show_arrows" name="cps_settings[show_arrows]" value="1" <?php checked( $settings['show_arrows'], true ); ?> />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="cps_show_dots"><?php esc_html_e( 'Show Dots', 'cari-prop-shop-sliders' ); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" id="cps_show_dots" name="cps_settings[show_dots]" value="1" <?php checked( $settings['show_dots'], true ); ?> />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="cps_pause_on_hover"><?php esc_html_e( 'Pause on Hover', 'cari-prop-shop-sliders' ); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" id="cps_pause_on_hover" name="cps_settings[pause_on_hover]" value="1" <?php checked( $settings['pause_on_hover'], true ); ?> />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="cps_loop"><?php esc_html_e( 'Loop', 'cari-prop-shop-sliders' ); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" id="cps_loop" name="cps_settings[loop]" value="1" <?php checked( $settings['loop'], true ); ?> />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="cps_effect"><?php esc_html_e( 'Effect', 'cari-prop-shop-sliders' ); ?></label>
                    </th>
                    <td>
                        <select id="cps_effect" name="cps_settings[effect]">
                            <option value="fade" <?php selected( $settings['effect'], 'fade' ); ?>><?php esc_html_e( 'Fade', 'cari-prop-shop-sliders' ); ?></option>
                            <option value="slide" <?php selected( $settings['effect'], 'slide' ); ?>><?php esc_html_e( 'Slide', 'cari-prop-shop-sliders' ); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="cps_height"><?php esc_html_e( 'Height (px)', 'cari-prop-shop-sliders' ); ?></label>
                    </th>
                    <td>
                        <input type="number" id="cps_height" name="cps_settings[height]" value="<?php echo esc_attr( $settings['height'] ); ?>" min="200" max="2000" step="10" class="small-text" />
                        <span class="description"><?php esc_html_e( 'Slider height in pixels', 'cari-prop-shop-sliders' ); ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="cps_full_height"><?php esc_html_e( 'Full Screen Height', 'cari-prop-shop-sliders' ); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" id="cps_full_height" name="cps_settings[full_height]" value="1" <?php checked( $settings['full_height'], true ); ?> />
                        <span class="description"><?php esc_html_e( 'Make slider full viewport height', 'cari-prop-shop-sliders' ); ?></span>
                    </td>
                </tr>
            </table>
        </div>
        <?php
    }

    public function render_slides_meta_box( $post ) {
        $slides = $this->get_slides( $post->ID );
        ?>
        <div class="cps-slides-meta-box">
            <div id="cps_slides_container" class="cps-slides-container">
                <?php if ( ! empty( $slides ) ) : ?>
                    <?php foreach ( $slides as $index => $slide ) : ?>
                        <?php $this->render_slide_card( $slide, $index ); ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <button type="button" class="button button-primary" id="cps_add_slide">
                <?php esc_html_e( 'Add Slide', 'cari-prop-shop-sliders' ); ?>
            </button>
        </div>
        <?php
    }

    private function render_slide_card( $slide, $index ) {
        $settings = maybe_unserialize( get_post_meta( $slide->ID, 'cps_slide_settings', true ) );
        $bg_type = isset( $settings['bg_type'] ) ? $settings['bg_type'] : 'image';
        $bg_image = isset( $settings['background_image'] ) ? wp_get_attachment_url( $settings['background_image'] ) : '';
        ?>
        <div class="cps-slide-card" data-slide-id="<?php echo esc_attr( $slide->ID ); ?>" data-slide-index="<?php echo esc_attr( $index ); ?>">
            <div class="cps-slide-card-header">
                <span class="dashicons dashicons-menu drag-handle"></span>
                <span class="cps-slide-number"><?php echo esc_html( $index + 1 ); ?></span>
                <button type="button" class="button-link cps-slide-delete" title="<?php esc_attr_e( 'Delete slide', 'cari-prop-shop-sliders' ); ?>">
                    <span class="dashicons dashicons-trash"></span>
                </button>
            </div>
            <div class="cps-slide-card-body">
                <div class="cps-slide-preview">
                    <?php if ( $bg_image ) : ?>
                        <img src="<?php echo esc_url( $bg_image ); ?>" alt="" />
                    <?php else : ?>
                        <div class="cps-slide-no-image"><?php esc_html_e( 'No image', 'cari-prop-shop-sliders' ); ?></div>
                    <?php endif; ?>
                </div>
                <div class="cps-slide-fields">
                    <p>
                        <label><?php esc_html_e( 'Background Type', 'cari-prop-shop-sliders' ); ?></label>
                        <select name="cps_slides[<?php echo esc_attr( $slide->ID ); ?>][bg_type]" class="cps-bg-type-select">
                            <option value="image" <?php selected( $bg_type, 'image' ); ?>><?php esc_html_e( 'Image', 'cari-prop-shop-sliders' ); ?></option>
                            <option value="color" <?php selected( $bg_type, 'color' ); ?>><?php esc_html_e( 'Color', 'cari-prop-shop-sliders' ); ?></option>
                            <option value="video" <?php selected( $bg_type, 'video' ); ?>><?php esc_html_e( 'Video', 'cari-prop-shop-sliders' ); ?></option>
                        </select>
                    </p>
                    <p class="cps-bg-image-field">
                        <label><?php esc_html_e( 'Background Image', 'cari-prop-shop-sliders' ); ?></label>
                        <input type="hidden" name="cps_slides[<?php echo esc_attr( $slide->ID ); ?>][background_image]" value="<?php echo esc_attr( isset( $settings['background_image'] ) ? $settings['background_image'] : '' ); ?>" class="cps-image-id" />
                        <button type="button" class="button cps-upload-image"><?php esc_html_e( 'Choose Image', 'cari-prop-shop-sliders' ); ?></button>
                        <button type="button" class="button cps-remove-image<?php echo empty( $settings['background_image'] ) ? ' hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'cari-prop-shop-sliders' ); ?></button>
                    </p>
                    <p class="cps-bg-color-field">
                        <label><?php esc_html_e( 'Background Color', 'cari-prop-shop-sliders' ); ?></label>
                        <input type="text" name="cps_slides[<?php echo esc_attr( $slide->ID ); ?>][background_color]" value="<?php echo esc_attr( isset( $settings['background_color'] ) ? $settings['background_color'] : '#000000' ); ?>" class="cps-color-picker" />
                    </p>
                    <p class="cps-video-field">
                        <label><?php esc_html_e( 'Video URL', 'cari-prop-shop-sliders' ); ?></label>
                        <input type="url" name="cps_slides[<?php echo esc_attr( $slide->ID ); ?>][video_url]" value="<?php echo esc_attr( isset( $settings['video_url'] ) ? $settings['video_url'] : '' ); ?>" class="regular-text" placeholder="https://example.com/video.mp4" />
                    </p>
                    <p>
                        <label><?php esc_html_e( 'Overlay Opacity (%)', 'cari-prop-shop-sliders' ); ?></label>
                        <input type="number" name="cps_slides[<?php echo esc_attr( $slide->ID ); ?>][overlay_opacity]" value="<?php echo esc_attr( isset( $settings['overlay_opacity'] ) ? $settings['overlay_opacity'] : 50 ); ?>" min="0" max="100" class="small-text" />
                    </p>
                    <p>
                        <label><?php esc_html_e( 'Title', 'cari-prop-shop-sliders' ); ?></label>
                        <input type="text" name="cps_slides[<?php echo esc_attr( $slide->ID ); ?>][title]" value="<?php echo esc_attr( isset( $settings['title'] ) ? $settings['title'] : '' ); ?>" class="regular-text" />
                    </p>
                    <p>
                        <label><?php esc_html_e( 'Subtitle', 'cari-prop-shop-sliders' ); ?></label>
                        <input type="text" name="cps_slides[<?php echo esc_attr( $slide->ID ); ?>][subtitle]" value="<?php echo esc_attr( isset( $settings['subtitle'] ) ? $settings['subtitle'] : '' ); ?>" class="regular-text" />
                    </p>
                    <p>
                        <label><?php esc_html_e( 'CTA Text', 'cari-prop-shop-sliders' ); ?></label>
                        <input type="text" name="cps_slides[<?php echo esc_attr( $slide->ID ); ?>][cta_text]" value="<?php echo esc_attr( isset( $settings['cta_text'] ) ? $settings['cta_text'] : '' ); ?>" class="regular-text" placeholder="Learn More" />
                    </p>
                    <p>
                        <label><?php esc_html_e( 'CTA Link', 'cari-prop-shop-sliders' ); ?></label>
                        <input type="url" name="cps_slides[<?php echo esc_attr( $slide->ID ); ?>][cta_link]" value="<?php echo esc_attr( isset( $settings['cta_link'] ) ? $settings['cta_link'] : '' ); ?>" class="regular-text" />
                    </p>
                    <p>
                        <label><?php esc_html_e( 'Content Alignment', 'cari-prop-shop-sliders' ); ?></label>
                        <select name="cps_slides[<?php echo esc_attr( $slide->ID ); ?>][alignment]">
                            <option value="left" <?php selected( isset( $settings['alignment'] ) ? $settings['alignment'] : 'center', 'left' ); ?>><?php esc_html_e( 'Left', 'cari-prop-shop-sliders' ); ?></option>
                            <option value="center" <?php selected( isset( $settings['alignment'] ) ? $settings['alignment'] : 'center', 'center' ); ?>><?php esc_html_e( 'Center', 'cari-prop-shop-sliders' ); ?></option>
                            <option value="right" <?php selected( isset( $settings['alignment'] ) ? $settings['alignment'] : 'center', 'right' ); ?>><?php esc_html_e( 'Right', 'cari-prop-shop-sliders' ); ?></option>
                        </select>
                    </p>
                </div>
            </div>
        </div>
        <?php
    }

    public function save_slider_meta( $post_id, $post ) {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( $this->post_type !== $post->post_type ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        if ( isset( $_POST['cps_settings'] ) ) {
            update_post_meta( $post_id, 'cps_slider_settings', $_POST['cps_settings'] );
        }

        if ( isset( $_POST['cps_slides'] ) && is_array( $_POST['cps_slides'] ) ) {
            foreach ( $_POST['cps_slides'] as $slide_id => $slide_data ) {
                if ( ! empty( $slide_data['title'] ) ) {
                    wp_update_post(
                        array(
                            'ID'         => $slide_id,
                            'post_title' => sanitize_text_field( $slide_data['title'] ),
                        )
                    );
                }

                $settings = array(
                    'bg_type'           => isset( $slide_data['bg_type'] ) ? sanitize_text_field( $slide_data['bg_type'] ) : 'image',
                    'background_image' => isset( $slide_data['background_image'] ) ? intval( $slide_data['background_image'] ) : 0,
                    'background_color' => isset( $slide_data['background_color'] ) ? sanitize_hex_color( $slide_data['background_color'] ) : '#000000',
                    'video_url'        => isset( $slide_data['video_url'] ) ? esc_url_raw( $slide_data['video_url'] ) : '',
                    'overlay_opacity'  => isset( $slide_data['overlay_opacity'] ) ? intval( $slide_data['overlay_opacity'] ) : 50,
                    'title'           => isset( $slide_data['title'] ) ? sanitize_text_field( $slide_data['title'] ) : '',
                    'subtitle'         => isset( $slide_data['subtitle'] ) ? sanitize_text_field( $slide_data['subtitle'] ) : '',
                    'cta_text'         => isset( $slide_data['cta_text'] ) ? sanitize_text_field( $slide_data['cta_text'] ) : '',
                    'cta_link'        => isset( $slide_data['cta_link'] ) ? esc_url_raw( $slide_data['cta_link'] ) : '#',
                    'alignment'       => isset( $slide_data['alignment'] ) ? sanitize_text_field( $slide_data['alignment'] ) : 'center',
                );

                update_post_meta( $slide_id, 'cps_slide_settings', $settings );
            }
        }
    }

    public function add_columns( $columns ) {
        $columns['cps_slides_count'] = __( 'Slides', 'cari-prop-shop-sliders' );
        $columns['cps_shortcode']   = __( 'Shortcode', 'cari-prop-shop-sliders' );
        return $columns;
    }

    public function render_columns( $column, $post_id ) {
        switch ( $column ) {
            case 'cps_slides_count':
                $slides = $this->get_slides( $post_id );
                echo esc_html( count( $slides ) );
                break;
            case 'cps_shortcode':
                echo '<code>[cps_hero_slider id="' . esc_attr( $post_id ) . '"]</code>';
                break;
        }
    }

    public function ajax_get_slides() {
        check_ajax_referer( 'cps_admin_nonce', 'nonce' );

        if ( ! current_user_can( 'edit_posts' ) ) {
            wp_send_json_error( array( 'message' => 'Permission denied' ), 403 );
        }

        $slider_id = isset( $_POST['slider_id'] ) ? intval( $_POST['slider_id'] ) : 0;

        if ( ! $slider_id ) {
            wp_send_json_error( array( 'message' => 'Invalid slider ID' ), 400 );
        }

        $slides = $this->get_slides( $slider_id );
        $slides_data = array();

        foreach ( $slides as $slide ) {
            $settings = maybe_unserialize( get_post_meta( $slide->ID, 'cps_slide_settings', true ) );
            $slides_data[] = array(
                'id'       => $slide->ID,
                'title'   => $slide->post_title,
                'settings' => $settings,
            );
        }

        wp_send_json_success( $slides_data );
    }

    public function ajax_save_slide() {
        check_ajax_referer( 'cps_admin_nonce', 'nonce' );

        if ( ! current_user_can( 'edit_posts' ) ) {
            wp_send_json_error( array( 'message' => 'Permission denied' ), 403 );
        }

        $slider_id = isset( $_POST['slider_id'] ) ? intval( $_POST['slider_id'] ) : 0;
        $slide_data = isset( $_POST['slide'] ) ? $_POST['slide'] : array();

        if ( ! $slider_id ) {
            wp_send_json_error( array( 'message' => 'Invalid slider ID' ), 400 );
        }

        $slide_id = $this->create_slide( $slider_id, $slide_data );

        if ( is_wp_error( $slide_id ) ) {
            wp_send_json_error( array( 'message' => $slide_id->get_error_message() ), 500 );
        }

        wp_send_json_success( array( 'slide_id' => $slide_id ) );
    }

    public function ajax_delete_slide() {
        check_ajax_referer( 'cps_admin_nonce', 'nonce' );

        if ( ! current_user_can( 'delete_posts' ) ) {
            wp_send_json_error( array( 'message' => 'Permission denied' ), 403 );
        }

        $slide_id = isset( $_POST['slide_id'] ) ? intval( $_POST['slide_id'] ) : 0;

        if ( ! $slide_id ) {
            wp_send_json_error( array( 'message' => 'Invalid slide ID' ), 400 );
        }

        $result = $this->delete_slide( $slide_id );

        if ( ! $result ) {
            wp_send_json_error( array( 'message' => 'Failed to delete slide' ), 500 );
        }

        wp_send_json_success();
    }

    public function ajax_reorder_slides() {
        check_ajax_referer( 'cps_admin_nonce', 'nonce' );

        if ( ! current_user_can( 'edit_posts' ) ) {
            wp_send_json_error( array( 'message' => 'Permission denied' ), 403 );
        }

        $slider_id = isset( $_POST['slider_id'] ) ? intval( $_POST['slider_id'] ) : 0;
        $slide_order = isset( $_POST['slide_order'] ) ? $_POST['slide_order'] : array();

        if ( ! $slider_id ) {
            wp_send_json_error( array( 'message' => 'Invalid slider ID' ), 400 );
        }

        $this->reorder_slides( $slider_id, $slide_order );

        wp_send_json_success();
    }
}