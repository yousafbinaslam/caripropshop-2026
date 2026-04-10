<?php
/**
 * Admin Sliders List Page
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CPS_Admin_Sliders {

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_menu_pages' ) );
    }

    public function add_menu_pages() {
        add_submenu_page(
            'edit.php?post_type=cps_slider',
            __( 'All Sliders', 'cari-prop-shop-sliders' ),
            __( 'All Sliders', 'cari-prop-shop-sliders' ),
            'manage_options',
            'cps-sliders',
            array( $this, 'render_sliders_page' )
        );

        add_submenu_page(
            'edit.php?post_type=cps_slider',
            __( 'Add New', 'cari-prop-shop-sliders' ),
            __( 'Add New', 'cari-prop-shop-sliders' ),
            'manage_options',
            'cps-new-slider',
            array( $this, 'render_new_slider_page' )
        );

        add_submenu_page(
            'edit.php?post_type=cps_slider',
            __( 'Settings', 'cari-prop-shop-sliders' ),
            __( 'Settings', 'cari-prop-shop-sliders' ),
            'manage_options',
            'cps-slider-settings',
            array( $this, 'render_settings_page' )
        );
    }

    public function render_sliders_page() {
        $sliders = get_posts(
            array(
                'post_type'      => 'cps_slider',
                'post_status'   => 'any',
                'posts_per_page' => -1,
                'orderby'       => 'date',
                'order'         => 'DESC',
            )
        );
        ?>
        <div class="wrap cps-sliders-page">
            <h1 class="wp-heading-inline"><?php esc_html_e( 'CariPropShop Sliders', 'cari-prop-shop-sliders' ); ?>
                <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=cps_slider' ) ); ?>" class="page-title-action">
                    <?php esc_html_e( 'Add New Slider', 'cari-prop-shop-sliders' ); ?>
                </a>
            </h1>
            <?php if ( ! empty( $sliders ) ) : ?>
                <table class="wp-list-table widefat fixed striped posts">
                    <thead>
                        <tr>
                            <th><?php esc_html_e( 'Title', 'cari-prop-shop-sliders' ); ?></th>
                            <th><?php esc_html_e( 'Shortcode', 'cari-prop-shop-sliders' ); ?></th>
                            <th><?php esc_html_e( 'Slides', 'cari-prop-shop-sliders' ); ?></th>
                            <th><?php esc_html_e( 'Date', 'cari-prop-shop-sliders' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( $sliders as $slider ) : ?>
                            <?php
                            $slides = get_children(
                                array(
                                    'post_parent'    => $slider->ID,
                                    'post_type'     => 'cps_slide',
                                    'post_status'   => 'publish',
                                    'posts_per_page' => -1,
                                )
                            );
                            ?>
                            <tr>
                                <td>
                                    <strong>
                                        <a href="<?php echo esc_url( get_edit_post_link( $slider->ID ) ); ?>">
                                            <?php echo esc_html( $slider->post_title ); ?>
                                        </a>
                                    </strong>
                                    <div class="row-actions">
                                        <span class="edit">
                                            <a href="<?php echo esc_url( get_edit_post_link( $slider->ID ) ); ?>">
                                                <?php esc_html_e( 'Edit', 'cari-prop-shop-sliders' ); ?>
                                            </a>
                                        </span>
                                        <span class="trash">
                                            <a href="<?php echo esc_url( get_delete_post_link( $slider->ID ) ); ?>" class="submitdelete">
                                                <?php esc_html_e( 'Trash', 'cari-prop-shop-sliders' ); ?>
                                            </a>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <code>[cps_hero_slider id="<?php echo esc_attr( $slider->ID ); ?>"]</code>
                                </td>
                                <td>
                                    <?php echo count( $slides ); ?>
                                </td>
                                <td>
                                    <?php echo esc_html( get_the_date( 'F j, Y', $slider->ID ) ); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p><?php esc_html_e( 'No sliders found. Create your first slider!', 'cari-prop-shop-sliders' ); ?></p>
                <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=cps_slider' ) ); ?>" class="button button-primary">
                    <?php esc_html_e( 'Create Slider', 'cari-prop-shop-sliders' ); ?>
                </a>
            <?php endif; ?>
        </div>
        <?php
    }

    public function render_new_slider_page() {
        $action = admin_url( 'admin.php?page=cps-new-slider' );
        ?>
        <div class="wrap cps-new-slider-page">
            <h1><?php esc_html_e( 'Create New Slider', 'cari-prop-shop-sliders' ); ?></h1>
            <form method="post" action="<?php echo esc_url( $action ); ?>">
                <?php wp_nonce_field( 'cps_create_slider', 'cps_nonce' ); ?>
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="slider_title"><?php esc_html_e( 'Slider Name', 'cari-prop-shop-sliders' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="slider_title" name="slider_title" class="regular-text" required />
                            <p class="description"><?php esc_html_e( 'Enter a name for your slider', 'cari-prop-shop-sliders' ); ?></p>
                        </td>
                    </tr>
                </table>
                <p class="submit">
                    <button type="submit" name="cps_create_slider" class="button button-primary">
                        <?php esc_html_e( 'Create Slider', 'cari-prop-shop-sliders' ); ?>
                    </button>
                </p>
            </form>
        </div>
        <?php

        if ( isset( $_POST['cps_create_slider'] ) && check_admin_referer( 'cps_create_slider', 'cps_nonce' ) ) {
            $title = isset( $_POST['slider_title'] ) ? sanitize_text_field( $_POST['slider_title'] ) : '';

            if ( ! empty( $title ) ) {
                $slider_id = wp_insert_post(
                    array(
                        'post_title'  => $title,
                        'post_type'   => 'cps_slider',
                        'post_status' => 'publish',
                        'post_author' => get_current_user_id(),
                    )
                );

                if ( $slider_id && ! is_wp_error( $slider_id ) ) {
                    update_post_meta( $slider_id, 'cps_slider_settings', array() );
                    wp_redirect( get_edit_post_link( $slider_id ) );
                    exit;
                }
            }
        }
    }

    public function render_settings_page() {
        $options = get_option( 'cps_slider_options', array() );

        if ( isset( $_POST['cps_save_settings'] ) && check_admin_referer( 'cps_save_settings', 'cps_nonce' ) ) {
            $settings = array(
                'default_autoplay'    => isset( $_POST['default_autoplay'] ) ? 1 : 0,
                'default_autoplay_speed' => intval( $_POST['default_autoplay_speed'] ),
                'default_slides'      => intval( $_POST['default_slides'] ),
                'enable_cache'        => isset( $_POST['enable_cache'] ) ? 1 : 0,
                'load_assets_everywhere' => isset( $_POST['load_assets_everywhere'] ) ? 1 : 0,
            );

            update_option( 'cps_slider_options', $settings );
            $options = $settings;

            echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Settings saved.', 'cari-prop-shop-sliders' ) . '</p></div>';
        }
        ?>
        <div class="wrap cps-settings-page">
            <h1><?php esc_html_e( 'Slider Settings', 'cari-prop-shop-sliders' ); ?></h1>
            <form method="post" action="">
                <?php wp_nonce_field( 'cps_save_settings', 'cps_nonce' ); ?>
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="default_autoplay"><?php esc_html_e( 'Default Auto Play', 'cari-prop-shop-sliders' ); ?></label>
                        </th>
                        <td>
                            <input type="checkbox" id="default_autoplay" name="default_autoplay" value="1" <?php checked( $options['default_autoplay'], 1 ); ?> />
                            <p class="description"><?php esc_html_e( 'Enable auto play by default for new sliders', 'cari-prop-shop-sliders' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="default_autoplay_speed"><?php esc_html_e( 'Default Auto Play Speed', 'cari-prop-shop-sliders' ); ?></label>
                        </th>
                        <td>
                            <input type="number" id="default_autoplay_speed" name="default_autoplay_speed" value="<?php echo esc_attr( isset( $options['default_autoplay_speed'] ) ? $options['default_autoplay_speed'] : 5 ); ?>" min="1" max="60" class="small-text" />
                            <p class="description"><?php esc_html_e( 'Default delay between slides (in seconds)', 'cari-prop-shop-sliders' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="default_slides"><?php esc_html_e( 'Slides Per View', 'cari-prop-shop-sliders' ); ?></label>
                        </th>
                        <td>
                            <input type="number" id="default_slides" name="default_slides" value="<?php echo esc_attr( isset( $options['default_slides'] ) ? $options['default_slides'] : 3 ); ?>" min="1" max="6" class="small-text" />
                            <p class="description"><?php esc_html_e( 'Default number of slides to show at once', 'cari-prop-shop-sliders' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="enable_cache"><?php esc_html_e( 'Enable Cache', 'cari-prop-shop-sliders' ); ?></label>
                        </th>
                        <td>
                            <input type="checkbox" id="enable_cache" name="enable_cache" value="1" <?php checked( $options['enable_cache'], 1 ); ?> />
                            <p class="description"><?php esc_html_e( 'Cache slider output for better performance', 'cari-prop-shop-sliders' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="load_assets_everywhere"><?php esc_html_e( 'Load Assets Everywhere', 'cari-prop-shop-sliders' ); ?></label>
                        </th>
                        <td>
                            <input type="checkbox" id="load_assets_everywhere" name="load_assets_everywhere" value="1" <?php checked( $options['load_assets_everywhere'], 1 ); ?> />
                            <p class="description"><?php esc_html_e( 'Load CSS and JS on all pages (not just when slider is used)', 'cari-prop-shop-sliders' ); ?></p>
                        </td>
                    </tr>
                </table>
                <p class="submit">
                    <button type="submit" name="cps_save_settings" class="button button-primary">
                        <?php esc_html_e( 'Save Settings', 'cari-prop-shop-sliders' ); ?>
                    </button>
                </p>
            </form>
        </div>
        <?php
    }
}

new CPS_Admin_Sliders();