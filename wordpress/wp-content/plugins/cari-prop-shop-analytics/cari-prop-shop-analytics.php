<?php
/**
 * Plugin Name: CariPropShop Analytics
 * Plugin URI: https://caripropshop.com
 * Description: Property analytics and tracking system for CariPropShop - tracks property views, leads, searches, and conversions.
 * Version: 1.0.0
 * Author: CariPropShop
 * Author URI: https://caripropshop.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: cari-prop-shop-analytics
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'CPS_ANALYTICS_VERSION', '1.0.0' );
define( 'CPS_ANALYTICS_PATH', plugin_dir_path( __FILE__ ) );
define( 'CPS_ANALYTICS_URL', plugin_dir_url( __FILE__ ) );
define( 'CPS_ANALYTICS_TABLE_VIEWS', 'cps_property_views' );
define( 'CPS_ANALYTICS_TABLE_LEADS', 'cps_lead_tracking' );
define( 'CPS_ANALYTICS_TABLE_SEARCHES', 'cps_search_queries' );

require_once CPS_ANALYTICS_PATH . 'includes/class-cps-property-views.php';
require_once CPS_ANALYTICS_PATH . 'includes/class-cps-lead-tracking.php';
require_once CPS_ANALYTICS_PATH . 'includes/class-cps-search-analytics.php';
require_once CPS_ANALYTICS_PATH . 'includes/class-cps-stats.php';

class CariPropShop_Analytics {

    private static $instance = null;
    private $property_views;
    private $lead_tracking;
    private $search_analytics;
    private $stats;

    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->property_views  = new CPS_Property_Views();
        $this->lead_tracking   = new CPS_Lead_Tracking();
        $this->search_analytics = new CPS_Search_Analytics();
        $this->stats          = new CPS_Stats();

        add_action( 'init', array( $this, 'init' ) );
        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
    }

    public function init() {
        load_plugin_textdomain( 'cari-prop-shop-analytics', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

        $this->property_views->init();
        $this->lead_tracking->init();
        $this->search_analytics->init();

        $this->register_rest_api();
        $this->register_admin_hooks();
        $this->register_dashboard_widgets();
    }

    public function activate() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $wpdb->query( "
            CREATE TABLE IF NOT EXISTS {$wpdb->prefix}" . CPS_ANALYTICS_TABLE_VIEWS . " (
                id bigint(20) unsigned NOT NULL auto_increment,
                property_id bigint(20) unsigned NOT NULL,
                user_id bigint(20) unsigned default NULL,
                session_id varchar(64) NOT NULL,
                ip_address varchar(45) default NULL,
                user_agent text,
                referrer varchar(255) default NULL,
                view_date date NOT NULL,
                view_datetime datetime NOT NULL,
                viewport_width int(5) default NULL,
                device_type varchar(20) default NULL,
                PRIMARY KEY  (id),
                KEY property_id (property_id),
                KEY view_date (view_date),
                KEY session_id (session_id)
            ) $charset_collate
        " );

        $wpdb->query( "
            CREATE TABLE IF NOT EXISTS {$wpdb->prefix}" . CPS_ANALYTICS_TABLE_LEADS . " (
                id bigint(20) unsigned NOT NULL auto_increment,
                property_id bigint(20) unsigned default NULL,
                user_id bigint(20) unsigned default NULL,
                session_id varchar(64) NOT NULL,
                lead_type varchar(50) NOT NULL,
                lead_source varchar(100) default NULL,
                referrer varchar(255) default NULL,
                utm_source varchar(100) default NULL,
                utm_medium varchar(100) default NULL,
                utm_campaign varchar(100) default NULL,
                utm_term varchar(100) default NULL,
                utm_content varchar(100) default NULL,
                ip_address varchar(45) default NULL,
                user_agent text,
                converted tinyint(1) default 0,
                conversion_datetime datetime default NULL,
                created_at datetime NOT NULL,
                PRIMARY KEY  (id),
                KEY property_id (property_id),
                KEY lead_type (lead_type),
                KEY converted (converted),
                KEY session_id (session_id)
            ) $charset_collate
        " );

        $wpdb->query( "
            CREATE TABLE IF NOT EXISTS {$wpdb->prefix}" . CPS_ANALYTICS_TABLE_SEARCHES . " (
                id bigint(20) unsigned NOT NULL auto_increment,
                session_id varchar(64) NOT NULL,
                search_query text NOT NULL,
                filters text,
                results_count int(11) default 0,
                ip_address varchar(45) default NULL,
                search_date date NOT NULL,
                search_datetime datetime NOT NULL,
                PRIMARY KEY  (id),
                KEY session_id (session_id),
                KEY search_date (search_date)
            ) $charset_collate
        " );

        set_transient( 'cps_analytics_activated', true, 30 );
    }

    public function deactivate() {
        flush_rewrite_rules();
    }

    private function register_rest_api() {
        register_rest_route( 'cps-analytics/v1', '/track-view', array(
            'methods'  => 'POST',
            'callback' => array( $this, 'api_track_view' ),
            'permission_callback' => '__return_true',
        ) );

        register_rest_route( 'cps-analytics/v1', '/track-lead', array(
            'methods'  => 'POST',
            'callback' => array( $this, 'api_track_lead' ),
            'permission_callback' => '__return_true',
        ) );

        register_rest_route( 'cps-analytics/v1', '/track-search', array(
            'methods'  => 'POST',
            'callback' => array( $this, 'api_track_search' ),
            'permission_callback' => '__return_true',
        ) );

        register_rest_route( 'cps-analytics/v1', '/stats', array(
            'methods'  => 'GET',
            'callback' => array( $this, 'api_get_stats' ),
            'permission_callback' => array( $this, 'api_permission_check' ),
        ) );
    }

    public function api_track_view( WP_REST_Request $request ) {
        $property_id = absint( $request->get_param( 'property_id' ) );
        
        if ( ! $property_id ) {
            return new WP_Error( 'missing_property_id', __( 'Property ID is required', 'cari-prop-shop-analytics' ), array( 'status' => 400 ) );
        }

        $result = $this->property_views->track_view( $property_id );
        
        return rest_ensure_response( array(
            'success' => $result,
            'message' => $result ? __( 'View tracked', 'cari-prop-shop-analytics' ) : __( 'Failed to track view', 'cari-prop-shop-analytics' )
        ) );
    }

    public function api_track_lead( WP_REST_Request $request ) {
        $property_id = absint( $request->get_param( 'property_id' ) );
        $lead_type   = sanitize_text_field( $request->get_param( 'lead_type' ) );
        
        if ( ! $lead_type ) {
            return new WP_Error( 'missing_lead_type', __( 'Lead type is required', 'cari-prop-shop-analytics' ), array( 'status' => 400 ) );
        }

        $result = $this->lead_tracking->track_lead( $property_id, $lead_type );
        
        return rest_ensure_response( array(
            'success' => $result,
            'message' => $result ? __( 'Lead tracked', 'cari-prop-shop-analytics' ) : __( 'Failed to track lead', 'cari-prop-shop-analytics' )
        ) );
    }

    public function api_track_search( WP_REST_Request $request ) {
        $search_query = sanitize_text_field( $request->get_param( 'search_query' ) );
        $filters      = $request->get_param( 'filters' );
        $results_count = absint( $request->get_param( 'results_count' ) );
        
        if ( ! $search_query ) {
            return new WP_Error( 'missing_search_query', __( 'Search query is required', 'cari-prop-shop-analytics' ), array( 'status' => 400 ) );
        }

        $result = $this->search_analytics->track_search( $search_query, $filters, $results_count );
        
        return rest_ensure_response( array(
            'success' => $result,
            'message' => $result ? __( 'Search tracked', 'cari-prop-shop-analytics' ) : __( 'Failed to track search', 'cari-prop-shop-analytics' )
        ) );
    }

    public function api_get_stats( WP_REST_Request $request ) {
        if ( ! current_user_can( 'manage_options' ) ) {
            return new WP_Error( 'rest_forbidden', __( 'You don\'t have access to this endpoint', 'cari-prop-shop-analytics' ), array( 'status' => 403 ) );
        }

        $period = $request->get_param( 'period' );
        $stats  = $this->stats->get_overview_stats( $period );

        return rest_ensure_response( $stats );
    }

    public function api_permission_check() {
        return current_user_can( 'manage_options' );
    }

    private function register_admin_hooks() {
        if ( is_admin() ) {
            require_once CPS_ANALYTICS_PATH . 'admin/class-cps-analytics-admin.php';
            new CPS_Analytics_Admin();
        }
    }

    private function register_dashboard_widgets() {
        add_action( 'wp_dashboard_setup', array( $this, 'register_dashboard_widget' ) );
    }

    public function register_dashboard_widget() {
        wp_add_dashboard_widget(
            'cps_analytics_overview',
            __( 'CariPropShop Analytics Overview', 'cari-prop-shop-analytics' ),
            array( $this, 'render_dashboard_widget' )
        );
    }

    public function render_dashboard_widget() {
        $stats = $this->stats->get_overview_stats( '7days' );
        ?>
        <div class="cps-analytics-widget">
            <div class="cps-stats-grid">
                <div class="cps-stat-card">
                    <h3><?php echo esc_html( $stats['total_views'] ); ?></h3>
                    <p><?php _e( 'Property Views', 'cari-prop-shop-analytics' ); ?></p>
                </div>
                <div class="cps-stat-card">
                    <h3><?php echo esc_html( $stats['total_leads'] ); ?></h3>
                    <p><?php _e( 'Total Leads', 'cari-prop-shop-analytics' ); ?></p>
                </div>
                <div class="cps-stat-card">
                    <h3><?php echo esc_html( $stats['total_searches'] ); ?></h3>
                    <p><?php _e( 'Search Queries', 'cari-prop-shop-analytics' ); ?></p>
                </div>
                <div class="cps-stat-card">
                    <h3><?php echo esc_html( $stats['conversion_rate'] ); ?>%</h3>
                    <p><?php _e( 'Conversion Rate', 'cari-prop-shop-analytics' ); ?></p>
                </div>
            </div>
            <?php if ( ! empty( $stats['top_properties'] ) ) : ?>
            <h4><?php _e( 'Top Viewed Properties', 'cari-prop-shop-analytics' ); ?></h4>
            <ul class="cps-top-properties">
                <?php foreach ( $stats['top_properties'] as $property ) : ?>
                <li>
                    <span class="property-title"><?php echo esc_html( $property['title'] ); ?></span>
                    <span class="property-views"><?php echo esc_html( $property['views'] ); ?> <?php _e( 'views', 'cari-prop-shop-analytics' ); ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            <p class="cps-widget-footer">
                <a href="<?php echo admin_url( 'admin.php?page=cps-analytics' ); ?>"><?php _e( 'View Full Analytics', 'cari-prop-shop-analytics' ); ?></a>
            </p>
        </div>
        <?php
    }
}

function cps_analytics() {
    return CariPropShop_Analytics::get_instance();
}

add_action( 'plugins_loaded', 'cps_analytics' );