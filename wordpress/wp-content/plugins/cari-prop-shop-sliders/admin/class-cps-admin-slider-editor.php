<?php
/**
 * Admin Slider Editor
 * Handles the slide editing interface in the admin
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CPS_Admin_Slider_Editor {

    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_slide_editor_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'save_slide_editor' ) );
    }

    public function add_slide_editor_meta_boxes() {
        add_meta_box(
            'cps_slide_editor',
            __( 'Slide Editor', 'cari-prop-shop-sliders' ),
            array( $this, 'render_slide_editor' ),
            'cps_slider',
            'normal',
            'high'
        );
    }

    public function render_slide_editor( $post ) {
        $slider_manager = CPS()->slider_manager;
        $slides = $slider_manager->get_slides( $post->ID );
        $settings = $slider_manager->get_settings( $post->ID );
        ?>
        <div class="cps-slide-editor" id="cps-slide-editor">
            <div class="cps-slide-editor-header">
                <h2><?php esc_html_e( 'Slides', 'cari-prop-shop-sliders' ); ?></h2>
                <button type="button" class="button button-primary" id="cps-add-new-slide">
                    <?php esc_html_e( 'Add New Slide', 'cari-prop-shop-sliders' ); ?>
                </button>
            </div>

            <div class="cps-slide-editor-content">
                <?php if ( empty( $slides ) ) : ?>
                    <div class="cps-empty-slides">
                        <p><?php esc_html_e( 'No slides yet. Click "Add New Slide" to create your first slide.', 'cari-prop-shop-sliders' ); ?></p>
                    </div>
                <?php else : ?>
                    <ul class="cps-slides-list" id="cps-sortable-slides">
                        <?php foreach ( $slides as $index => $slide ) : ?>
                            <?php $this->render_slide_item( $slide, $index ); ?>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

        <div id="cps-slide-modal" class="cps-modal" style="display: none;">
            <div class="cps-modal-backdrop"></div>
            <div class="cps-modal-content">
                <div class="cps-modal-header">
                    <h3><?php esc_html_e( 'Add/Edit Slide', 'cari-prop-shop-sliders' ); ?></h3>
                    <button type="button" class="cps-modal-close">&times;</button>
                </div>
                <div class="cps-modal-body">
                    <input type="hidden" id="cps-edit-slide-id" value="" />
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="cps_slide_title"><?php esc_html_e( 'Title', 'cari-prop-shop-sliders' ); ?></label>
                            </th>
                            <td>
                                <input type="text" id="cps_slide_title" name="cps_slide_title" class="regular-text" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="cps_slide_bg_type"><?php esc_html_e( 'Background Type', 'cari-prop-shop-sliders' ); ?></label>
                            </th>
                            <td>
                                <select id="cps_slide_bg_type" name="cps_slide_bg_type">
                                    <option value="image"><?php esc_html_e( 'Image', 'cari-prop-shop-sliders' ); ?></option>
                                    <option value="color"><?php esc_html_e( 'Color', 'cari-prop-shop-sliders' ); ?></option>
                                    <option value="video"><?php esc_html_e( 'Video', 'cari-prop-shop-sliders' ); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr class="cps-bg-image-row">
                            <th scope="row">
                                <label><?php esc_html_e( 'Background Image', 'cari-prop-shop-sliders' ); ?></label>
                            </th>
                            <td>
                                <div class="cps-image-upload">
                                    <input type="hidden" id="cps_slide_bg_image" name="cps_slide_bg_image" value="" />
                                    <button type="button" class="button" id="cps_upload_bg_image">
                                        <?php esc_html_e( 'Select Image', 'cari-prop-shop-sliders' ); ?>
                                    </button>
                                    <div class="cps-image-preview" id="cps-bg-image-preview"></div>
                                </div>
                            </td>
                        </tr>
                        <tr class="cps-bg-color-row" style="display: none;">
                            <th scope="row">
                                <label for="cps_slide_bg_color"><?php esc_html_e( 'Background Color', 'cari-prop-shop-sliders' ); ?></label>
                            </th>
                            <td>
                                <input type="text" id="cps_slide_bg_color" name="cps_slide_bg_color" class="cps-color-picker" value="#000000" />
                            </td>
                        </tr>
                        <tr class="cps-bg-video-row" style="display: none;">
                            <th scope="row">
                                <label for="cps_slide_video"><?php esc_html_e( 'Video URL', 'cari-prop-shop-sliders' ); ?></label>
                            </th>
                            <td>
                                <input type="url" id="cps_slide_video" name="cps_slide_video" class="regular-text" placeholder="https://example.com/video.mp4" />
                                <p class="description"><?php esc_html_e( 'MP4 video URL for background', 'cari-prop-shop-sliders' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="cps_slide_overlay"><?php esc_html_e( 'Overlay Opacity (%)', 'cari-prop-shop-sliders' ); ?></label>
                            </th>
                            <td>
                                <input type="number" id="cps_slide_overlay" name="cps_slide_overlay" value="50" min="0" max="100" class="small-text" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="cps_slide_subtitle"><?php esc_html_e( 'Subtitle', 'cari-prop-shop-sliders' ); ?></label>
                            </th>
                            <td>
                                <input type="text" id="cps_slide_subtitle" name="cps_slide_subtitle" class="regular-text" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="cps_slide_cta_text"><?php esc_html_e( 'CTA Text', 'cari-prop-shop-sliders' ); ?></label>
                            </th>
                            <td>
                                <input type="text" id="cps_slide_cta_text" name="cps_slide_cta_text" class="regular-text" placeholder="Learn More" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="cps_slide_cta_link"><?php esc_html_e( 'CTA Link', 'cari-prop-shop-sliders' ); ?></label>
                            </th>
                            <td>
                                <input type="url" id="cps_slide_cta_link" name="cps_slide_cta_link" class="regular-text" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="cps_slide_alignment"><?php esc_html_e( 'Content Alignment', 'cari-prop-shop-sliders' ); ?></label>
                            </th>
                            <td>
                                <select id="cps_slide_alignment" name="cps_slide_alignment">
                                    <option value="left"><?php esc_html_e( 'Left', 'cari-prop-shop-sliders' ); ?></option>
                                    <option value="center" selected><?php esc_html_e( 'Center', 'cari-prop-shop-sliders' ); ?></option>
                                    <option value="right"><?php esc_html_e( 'Right', 'cari-prop-shop-sliders' ); ?></option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="cps-modal-footer">
                    <button type="button" class="button" id="cps-cancel-slide"><?php esc_html_e( 'Cancel', 'cari-prop-shop-sliders' ); ?></button>
                    <button type="button" class="button button-primary" id="cps-save-slide"><?php esc_html_e( 'Save Slide', 'cari-prop-shop-sliders' ); ?></button>
                </div>
            </div>
        </div>
        <?php
    }

    private function render_slide_item( $slide, $index ) {
        $settings = maybe_unserialize( get_post_meta( $slide->ID, 'cps_slide_settings', true ) );
        $bg_type = isset( $settings['bg_type'] ) ? $settings['bg_type'] : 'image';
        $bg_image = isset( $settings['background_image'] ) ? wp_get_attachment_url( $settings['background_image'] ) : '';
        ?>
        <li class="cps-slide-item" data-slide-id="<?php echo esc_attr( $slide->ID ); ?>">
            <div class="cps-slide-item-handle">
                <span class="dashicons dashicons-menu"></span>
            </div>
            <div class="cps-slide-item-preview">
                <?php if ( $bg_image ) : ?>
                    <img src="<?php echo esc_url( $bg_image ); ?>" alt="" />
                <?php else : ?>
                    <div class="cps-slide-no-image" style="background-color: <?php echo esc_attr( isset( $settings['background_color'] ) ? $settings['background_color'] : '#000000' ); ?>;">
                        <?php if ( 'video' === $bg_type ) : ?>
                            <span class="dashicons dashicons-video-alt3"></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="cps-slide-item-content">
                <h4><?php echo esc_html( ! empty( $settings['title'] ) ? $settings['title'] : $slide->post_title ); ?></h4>
                <p><?php echo esc_html( ! empty( $settings['subtitle'] ) ? $settings['subtitle'] : '' ); ?></p>
            </div>
            <div class="cps-slide-item-actions">
                <button type="button" class="button button-small cps-edit-slide" data-slide-id="<?php echo esc_attr( $slide->ID ); ?>">
                    <?php esc_html_e( 'Edit', 'cari-prop-shop-sliders' ); ?>
                </button>
                <button type="button" class="button button-small button-link cps-delete-slide" data-slide-id="<?php echo esc_attr( $slide->ID ); ?>">
                    <?php esc_html_e( 'Delete', 'cari-prop-shop-sliders' ); ?>
                </button>
            </div>
        </li>
        <?php
    }

    public function save_slide_editor( $post_id ) {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        if ( isset( $_POST['cps_slide_nonce'] ) && wp_verify_nonce( $_POST['cps_slide_nonce'], 'cps_save_slide_' . $post_id ) ) {
            $slides = isset( $_POST['cps_slides'] ) ? $_POST['cps_slides'] : array();

            foreach ( $slides as $slide_id => $slide_data ) {
                $settings = array(
                    'bg_type'          => isset( $slide_data['bg_type'] ) ? sanitize_text_field( $slide_data['bg_type'] ) : 'image',
                    'background_image' => isset( $slide_data['background_image'] ) ? intval( $slide_data['background_image'] ) : 0,
                    'background_color' => isset( $slide_data['background_color'] ) ? sanitize_hex_color( $slide_data['background_color'] ) : '#000000',
                    'video_url'        => isset( $slide_data['video_url'] ) ? esc_url_raw( $slide_data['video_url'] ) : '',
                    'overlay_opacity'  => isset( $slide_data['overlay_opacity'] ) ? intval( $slide_data['overlay_opacity'] ) : 50,
                    'title'            => isset( $slide_data['title'] ) ? sanitize_text_field( $slide_data['title'] ) : '',
                    'subtitle'        => isset( $slide_data['subtitle'] ) ? sanitize_text_field( $slide_data['subtitle'] ) : '',
                    'cta_text'        => isset( $slide_data['cta_text'] ) ? sanitize_text_field( $slide_data['cta_text'] ) : '',
                    'cta_link'       => isset( $slide_data['cta_link'] ) ? esc_url_raw( $slide_data['cta_link'] ) : '#',
                    'alignment'      => isset( $slide_data['alignment'] ) ? sanitize_text_field( $slide_data['alignment'] ) : 'center',
                );

                update_post_meta( $slide_id, 'cps_slide_settings', $settings );
            }
        }
    }
}

new CPS_Admin_Slider_Editor();