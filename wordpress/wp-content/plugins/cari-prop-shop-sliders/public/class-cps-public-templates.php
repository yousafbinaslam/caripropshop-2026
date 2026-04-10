/**
 * Public Templates
 * Template functions for displaying sliders
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CPS_Public_Templates {

    public function __construct() {
        add_filter( 'template_include', array( $this, 'load_template' ), 99 );
    }

    public function load_template( $template ) {
        return $template;
    }

    public static function get_hero_slider_template( $slider_id ) {
        $template = locate_template( 'cari-prop-shop/hero-slider.php' );
        if ( ! $template ) {
            $template = CPS_PLUGIN_DIR . 'public/templates/hero-slider.php';
        }

        if ( file_exists( $template ) ) {
            include $template;
        }
    }

    public static function get_property_slider_template() {
        $template = locate_template( 'cari-prop-shop/property-slider.php' );
        if ( ! $template ) {
            $template = CPS_PLUGIN_DIR . 'public/templates/property-slider.php';
        }

        if ( file_exists( $template ) ) {
            include $template;
        }
    }

    public static function get_testimonial_slider_template() {
        $template = locate_template( 'cari-prop-shop/testimonial-slider.php' );
        if ( ! $template ) {
            $template = CPS_PLUGIN_DIR . 'public/templates/testimonial-slider.php';
        }

        if ( file_exists( $template ) ) {
            include $template;
        }
    }
}

new CPS_Public_Templates();