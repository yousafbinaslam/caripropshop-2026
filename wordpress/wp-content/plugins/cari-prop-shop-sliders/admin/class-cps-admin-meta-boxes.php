<?php
/**
 * Slide Meta Boxes
 * Additional meta boxes for slide customization
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CPS_Admin_Meta_Boxes {

    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'save_meta' ), 10, 2 );
    }

    public function add_meta_boxes() {
        add_meta_box(
            'cps_slide_design',
            __( 'Slide Design', 'cari-prop-shop-sliders' ),
            array( $this, 'render_design_meta_box' ),
            'cps_slider',
            'side',
            'default'
        );

        add_meta_box(
            'cps_slide_animation',
            __( 'Slide Animation', 'cari-prop-shop-sliders' ),
            array( $this, 'render_animation_meta_box' ),
            'cps_slider',
            'side',
            'default'
        );

        add_meta_box(
            'cps_shortcode_info',
            __( 'Shortcode', 'cari-prop-shop-sliders' ),
            array( $this, 'render_shortcode_info' ),
            'cps_slider',
            'side',
            'low'
        );
    }

    public function render_design_meta_box( $post ) {
        $settings = maybe_unserialize( get_post_meta( $post->ID, 'cps_slider_settings', true ) );
        ?>
        <div class="cps-meta-box">
            <p>
                <label for="cps_custom_css"><?php esc_html_e( 'Custom CSS', 'cari-prop-shop-sliders' ); ?></label>
                <textarea id="cps_custom_css" name="cps_settings[custom_css]" rows="6" class="large-text code"><?php echo esc_textarea( isset( $settings['custom_css'] ) ? $settings['custom_css'] : '' ); ?></textarea>
            </p>
            <p>
                <label for="cps_custom_class"><?php esc_html_e( 'Custom Class', 'cari-prop-shop-sliders' ); ?></label>
                <input type="text" id="cps_custom_class" name="cps_settings[custom_class]" value="<?php echo esc_attr( isset( $settings['custom_class'] ) ? $settings['custom_class'] : '' ); ?>" class="regular-text" />
            </p>
            <p>
                <label for="cps_padding"><?php esc_html_e( 'Content Padding', 'cari-prop-shop-sliders' ); ?></label>
                <input type="text" id="cps_padding" name="cps_settings[padding]" value="<?php echo esc_attr( isset( $settings['padding'] ) ? $settings['padding'] : '60px' ); ?>" class="regular-text" placeholder="60px" />
            </p>
        </div>
        <?php
    }

    public function render_animation_meta_box( $post ) {
        $settings = maybe_unserialize( get_post_meta( $post->ID, 'cps_slider_settings', true ) );
        ?>
        <div class="cps-meta-box">
            <p>
                <label for="cps_animation_in"><?php esc_html_e( 'In Animation', 'cari-prop-shop-sliders' ); ?></label>
                <select id="cps_animation_in" name="cps_settings[animation_in]">
                    <option value="" <?php selected( isset( $settings['animation_in'] ) ? $settings['animation_in'] : '', '' ); ?>><?php esc_html_e( 'None', 'cari-prop-shop-sliders' ); ?></option>
                    <option value="fadeIn" <?php selected( isset( $settings['animation_in'] ) ? $settings['animation_in'] : '', 'fadeIn' ); ?>><?php esc_html_e( 'Fade In', 'cari-prop-shop-sliders' ); ?></option>
                    <option value="fadeInUp" <?php selected( isset( $settings['animation_in'] ) ? $settings['animation_in'] : '', 'fadeInUp' ); ?>><?php esc_html_e( 'Fade In Up', 'cari-prop-shop-sliders' ); ?></option>
                    <option value="fadeInDown" <?php selected( isset( $settings['animation_in'] ) ? $settings['animation_in'] : '', 'fadeInDown' ); ?>><?php esc_html_e( 'Fade In Down', 'cari-prop-shop-sliders' ); ?></option>
                    <option value="fadeInLeft" <?php selected( isset( $settings['animation_in'] ) ? $settings['animation_in'] : '', 'fadeInLeft' ); ?>><?php esc_html_e( 'Fade In Left', 'cari-prop-shop-sliders' ); ?></option>
                    <option value="fadeInRight" <?php selected( isset( $settings['animation_in'] ) ? $settings['animation_in'] : '', 'fadeInRight' ); ?>><?php esc_html_e( 'Fade In Right', 'cari-prop-shop-sliders' ); ?></option>
                    <option value="zoomIn" <?php selected( isset( $settings['animation_in'] ) ? $settings['animation_in'] : '', 'zoomIn' ); ?>><?php esc_html_e( 'Zoom In', 'cari-prop-shop-sliders' ); ?></option>
                </select>
            </p>
            <p>
                <label for="cps_animation_out"><?php esc_html_e( 'Out Animation', 'cari-prop-shop-sliders' ); ?></label>
                <select id="cps_animation_out" name="cps_settings[animation_out]">
                    <option value="" <?php selected( isset( $settings['animation_out'] ) ? $settings['animation_out'] : '', '' ); ?>><?php esc_html_e( 'None', 'cari-prop-shop-sliders' ); ?></option>
                    <option value="fadeOut" <?php selected( isset( $settings['animation_out'] ) ? $settings['animation_out'] : '', 'fadeOut' ); ?>><?php esc_html_e( 'Fade Out', 'cari-prop-shop-sliders' ); ?></option>
                    <option value="fadeOutUp" <?php selected( isset( $settings['animation_out'] ) ? $settings['animation_out'] : '', 'fadeOutUp' ); ?>><?php esc_html_e( 'Fade Out Up', 'cari-prop-shop-sliders' ); ?></option>
                    <option value="fadeOutDown" <?php selected( isset( $settings['animation_out'] ) ? $settings['animation_out'] : '', 'fadeOutDown' ); ?>><?php esc_html_e( 'Fade Out Down', 'cari-prop-shop-sliders' ); ?></option>
                    <option value="fadeOutLeft" <?php selected( isset( $settings['animation_out'] ) ? $settings['animation_out'] : '', 'fadeOutLeft' ); ?>><?php esc_html_e( 'Fade Out Left', 'cari-prop-shop-sliders' ); ?></option>
                    <option value="fadeOutRight" <?php selected( isset( $settings['animation_out'] ) ? $settings['animation_out'] : '', 'fadeOutRight' ); ?>><?php esc_html_e( 'Fade Out Right', 'cari-prop-shop-sliders' ); ?></option>
                    <option value="zoomOut" <?php selected( isset( $settings['animation_out'] ) ? $settings['animation_out'] : '', 'zoomOut' ); ?>><?php esc_html_e( 'Zoom Out', 'cari-prop-shop-sliders' ); ?></option>
                </select>
            </p>
            <p>
                <label for="cps_animation_speed"><?php esc_html_e( 'Animation Duration (ms)', 'cari-prop-shop-sliders' ); ?></label>
                <input type="number" id="cps_animation_speed" name="cps_settings[animation_speed]" value="<?php echo esc_attr( isset( $settings['animation_speed'] ) ? $settings['animation_speed'] : 600 ); ?>" min="100" max="2000" step="100" class="small-text" />
            </p>
        </div>
        <?php
    }

    public function render_shortcode_info( $post ) {
        ?>
        <div class="cps-meta-box">
            <p><?php esc_html_e( 'Use this shortcode to display the slider:', 'cari-prop-shop-sliders' ); ?></p>
            <code>[cps_hero_slider id="<?php echo esc_attr( $post->ID ); ?>"]</code>
            <hr />
            <p><?php esc_html_e( 'Or use by slug:', 'cari-prop-shop-sliders' ); ?></p>
            <code>[cps_hero_slider slug="<?php echo esc_attr( $post->post_name ); ?>"]</code>
        </div>
        <?php
    }

    public function save_meta( $post_id, $post ) {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( 'cps_slider' !== $post->post_type ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        if ( isset( $_POST['cps_settings'] ) ) {
            $settings = get_post_meta( $post_id, 'cps_slider_settings', true );
            if ( ! is_array( $settings ) ) {
                $settings = array();
            }

            $new_settings = array_map_recursive( 'sanitize_text_field', $_POST['cps_settings'] );
            $settings = array_merge( $settings, $new_settings );

            update_post_meta( $post_id, 'cps_slider_settings', $settings );
        }
    }

    private function array_map_recursive( $callback, $array ) {
        foreach ( $array as $key => $value ) {
            if ( is_array( $value ) ) {
                $array[ $key ] = array_map_recursive( $callback, $value );
            } else {
                $array[ $key ] = call_user_func( $callback, $value );
            }
        }
        return $array;
    }
}

new CPS_Admin_Meta_Boxes();