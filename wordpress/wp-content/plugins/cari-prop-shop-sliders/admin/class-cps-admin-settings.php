<?php
/**
 * Admin Settings Page
 * Global plugin settings
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CPS_Admin_Settings {

    const OPTION_NAME = 'cps_plugin_options';

    public function __construct() {
        add_action( 'admin_init', array( $this, 'register_settings' ) );
    }

    public function register_settings() {
        register_setting(
            'cps_settings_group',
            self::OPTION_NAME,
            array( $this, 'sanitize_options' )
        );

        add_settings_section(
            'cps_general_section',
            __( 'General Settings', 'cari-prop-shop-sliders' ),
            array( $this, 'render_general_section' ),
            'cps_settings'
        );

        add_settings_field(
            'load_slick_from_cdn',
            __( 'Load Slick from CDN', 'cari-prop-shop-sliders' ),
            array( $this, 'render_load_slick_field' ),
            'cps_settings',
            'cps_general_section'
        );

        add_settings_field(
            'slick_version',
            __( 'Slick Version', 'cari-prop-shop-sliders' ),
            array( $this, 'render_slick_version_field' ),
            'cps_settings',
            'cps_general_section'
        );

        add_settings_field(
            'default_slider_height',
            __( 'Default Slider Height', 'cari-prop-shop-sliders' ),
            array( $this, 'render_default_height_field' ),
            'cps_settings',
            'cps_general_section'
        );

        add_settings_section(
            'cps_frontend_section',
            __( 'Frontend Settings', 'cari-prop-shop-sliders' ),
            array( $this, 'render_frontend_section' ),
            'cps_settings'
        );

        add_settings_field(
            'enable_lazy_load',
            __( 'Enable Lazy Load', 'cari-prop-shop-sliders' ),
            array( $this, 'render_lazy_load_field' ),
            'cps_settings',
            'cps_frontend_section'
        );

        add_settings_field(
            'enable_cache',
            __( 'Enable Cache', 'cari-prop-shop-sliders' ),
            array( $this, 'render_cache_field' ),
            'cps_settings',
            'cps_frontend_section'
        );

        add_settings_section(
            'cps_advanced_section',
            __( 'Advanced Settings', 'cari-prop-shop-sliders' ),
            array( $this, 'render_advanced_section' ),
            'cps_settings'
        );

        add_settings_field(
            'custom_css',
            __( 'Custom CSS', 'cari-prop-shop-sliders' ),
            array( $this, 'render_custom_css_field' ),
            'cps_settings',
            'cps_advanced_section'
        );
    }

    public function render_general_section() {
        echo '<p>' . esc_html__( 'Configure general plugin settings.', 'cari-prop-shop-sliders' ) . '</p>';
    }

    public function render_frontend_section() {
        echo '<p>' . esc_html__( 'Settings for frontend display.', 'cari-prop-shop-sliders' ) . '</p>';
    }

    public function render_advanced_section() {
        echo '<p>' . esc_html__( 'Advanced configuration options.', 'cari-prop-shop-sliders' ) . '</p>';
    }

    public function render_load_slick_field() {
        $options = get_option( self::OPTION_NAME, array() );
        ?>
        <input type="checkbox" id="load_slick_from_cdn" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[load_slick_from_cdn]" value="1" <?php checked( isset( $options['load_slick_from_cdn'] ) ? $options['load_slick_from_cdn'] : 1, 1 ); ?> />
        <label for="load_slick_from_cdn"><?php esc_html_e( 'Load Slick carousel library from CDN', 'cari-prop-shop-sliders' ); ?></label>
        <p class="description"><?php esc_html_e( 'Uncheck to use local copy of Slick', 'cari-prop-shop-sliders' ); ?></p>
        <?php
    }

    public function render_slick_version_field() {
        $options = get_option( self::OPTION_NAME, array() );
        $version = isset( $options['slick_version'] ) ? $options['slick_version'] : '1.8.1';
        ?>
        <input type="text" id="slick_version" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[slick_version]" value="<?php echo esc_attr( $version ); ?>" class="small-text" />
        <p class="description"><?php esc_html_e( 'Slick carousel version to load', 'cari-prop-shop-sliders' ); ?></p>
        <?php
    }

    public function render_default_height_field() {
        $options = get_option( self::OPTION_NAME, array() );
        $height = isset( $options['default_slider_height'] ) ? $options['default_slider_height'] : 600;
        ?>
        <input type="number" id="default_slider_height" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[default_slider_height]" value="<?php echo esc_attr( $height ); ?>" min="200" max="2000" class="small-text" />
        <span><?php esc_html_e( 'px', 'cari-prop-shop-sliders' ); ?></span>
        <p class="description"><?php esc_html_e( 'Default height for new sliders', 'cari-prop-shop-sliders' ); ?></p>
        <?php
    }

    public function render_lazy_load_field() {
        $options = get_option( self::OPTION_NAME, array() );
        ?>
        <input type="checkbox" id="enable_lazy_load" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[enable_lazy_load]" value="1" <?php checked( isset( $options['enable_lazy_load'] ) ? $options['enable_lazy_load'] : 1, 1 ); ?> />
        <label for="enable_lazy_load"><?php esc_html_e( 'Lazy load slider images', 'cari-prop-shop-sliders' ); ?></label>
        <p class="description"><?php esc_html_e( 'Improve page load time by lazy loading images', 'cari-prop-shop-sliders' ); ?></p>
        <?php
    }

    public function render_cache_field() {
        $options = get_option( self::OPTION_NAME, array() );
        ?>
        <input type="checkbox" id="enable_cache" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[enable_cache]" value="1" <?php checked( isset( $options['enable_cache'] ) ? $options['enable_cache'] : 0, 1 ); ?> />
        <label for="enable_cache"><?php esc_html_e( 'Enable slider output caching', 'cari-prop-shop-sliders' ); ?></label>
        <p class="description"><?php esc_html_e( 'Cache rendered sliders for better performance', 'cari-prop-shop-sliders' ); ?></p>
        <?php
    }

    public function render_custom_css_field() {
        $options = get_option( self::OPTION_NAME, array() );
        ?>
        <textarea id="custom_css" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[custom_css]" rows="10" class="large-text code"><?php echo esc_textarea( isset( $options['custom_css'] ) ? $options['custom_css'] : '' ); ?></textarea>
        <p class="description"><?php esc_html_e( 'Add custom CSS that will be loaded on all pages', 'cari-prop-shop-sliders' ); ?></p>
        <?php
    }

    public function sanitize_options( $input ) {
        $sanitized = array();

        if ( isset( $input['load_slick_from_cdn'] ) ) {
            $sanitized['load_slick_from_cdn'] = 1;
        }

        if ( isset( $input['slick_version'] ) ) {
            $sanitized['slick_version'] = sanitize_text_field( $input['slick_version'] );
        }

        if ( isset( $input['default_slider_height'] ) ) {
            $sanitized['default_slider_height'] = absint( $input['default_slider_height'] );
        }

        if ( isset( $input['enable_lazy_load'] ) ) {
            $sanitized['enable_lazy_load'] = 1;
        }

        if ( isset( $input['enable_cache'] ) ) {
            $sanitized['enable_cache'] = 1;
        }

        if ( isset( $input['custom_css'] ) ) {
            $sanitized['custom_css'] = wp_strip_all_tags( $input['custom_css'] );
        }

        return $sanitized;
    }
}

new CPS_Admin_Settings();