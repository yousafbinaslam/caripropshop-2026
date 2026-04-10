<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CPS_Analytics_Admin {

    private $stats;

    public function __construct() {
        $this->stats = new CPS_Stats();

        add_action( 'admin_menu', array( $this, 'add_menu_pages' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
        add_action( 'wp_ajax_cps_export_csv', array( $this, 'handle_export_csv' ) );
        add_action( 'wp_ajax_cps_get_chart_data', array( $this, 'handle_chart_data' ) );
    }

    public function add_menu_pages() {
        add_menu_page(
            __( 'Analytics', 'cari-prop-shop-analytics' ),
            __( 'Analytics', 'cari-prop-shop-analytics' ),
            'manage_options',
            'cps-analytics',
            array( $this, 'render_dashboard_page' ),
            'dashicons-chart-bar',
            30
        );

        add_submenu_page(
            'cps-analytics',
            __( 'Overview', 'cari-prop-shop-analytics' ),
            __( 'Overview', 'cari-prop-shop-analytics' ),
            'manage_options',
            'cps-analytics',
            array( $this, 'render_dashboard_page' )
        );

        add_submenu_page(
            'cps-analytics',
            __( 'Property Performance', 'cari-prop-shop-analytics' ),
            __( 'Properties', 'cari-prop-shop-analytics' ),
            'manage_options',
            'cps-analytics-properties',
            array( $this, 'render_properties_page' )
        );

        add_submenu_page(
            'cps-analytics',
            __( 'Lead Sources', 'cari-prop-shop-analytics' ),
            __( 'Lead Sources', 'cari-prop-shop-analytics' ),
            'manage_options',
            'cps-analytics-leads',
            array( $this, 'render_leads_page' )
        );

        add_submenu_page(
            'cps-analytics',
            __( 'Search Analytics', 'cari-prop-shop-analytics' ),
            __( 'Search Queries', 'cari-prop-shop-analytics' ),
            'manage_options',
            'cps-analytics-searches',
            array( $this, 'render_searches_page' )
        );

        add_submenu_page(
            'cps-analytics',
            __( 'Export Reports', 'cari-prop-shop-analytics' ),
            __( 'Export', 'cari-prop-shop-analytics' ),
            'manage_options',
            'cps-analytics-export',
            array( $this, 'render_export_page' )
        );
    }

    public function enqueue_assets( $hook ) {
        $screen = get_current_screen();

        if ( ! strpos( $hook, 'cps-analytics' ) ) {
            return;
        }

        wp_enqueue_style( 'cps-analytics-admin', CPS_ANALYTICS_URL . 'assets/css/admin.css', array(), CPS_ANALYTICS_VERSION );
        wp_enqueue_script( 'cps-analytics-admin', CPS_ANALYTICS_URL . 'assets/js/admin.js', array( 'jquery' ), CPS_ANALYTICS_VERSION, true );

        wp_localize_script( 'cps-analytics-admin', 'cpsAnalytics', array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce'  => wp_create_nonce( 'cps_analytics_nonce' ),
        ) );
    }

    public function render_dashboard_page() {
        $period = isset( $_GET['period'] ) ? sanitize_text_field( wp_unslash( $_GET['period'] ) ) : '30days';
        
        $overview = $this->stats->get_overview_stats( $period );
        $detailed = $this->stats->get_detailed_stats( $period );
        
        ?>
        <div class="wrap cps-analytics-admin">
            <h1><?php _e( 'CariPropShop Analytics', 'cari-prop-shop-analytics' ); ?></h1>
            
            <div class="cps-toolbar">
                <form method="get">
                    <input type="hidden" name="page" value="cps-analytics">
                    <select name="period" onchange="this.form.submit()">
                        <option value="7days" <?php selected( $period, '7days' ); ?>><?php _e( 'Last 7 days', 'cari-prop-shop-analytics' ); ?></option>
                        <option value="30days" <?php selected( $period, '30days' ); ?>><?php _e( 'Last 30 days', 'cari-prop-shop-analytics' ); ?></option>
                        <option value="90days" <?php selected( $period, '90days' ); ?>><?php _e( 'Last 90 days', 'cari-prop-shop-analytics' ); ?></option>
                        <option value="365days" <?php selected( $period, '365days' ); ?>><?php _e( 'Last 365 days', 'cari-prop-shop-analytics' ); ?></option>
                    </select>
                </form>
            </div>

            <div class="cps-stats-overview">
                <div class="cps-stat-box">
                    <span class="cps-stat-number"><?php echo esc_html( number_format( $overview['total_views'] ) ); ?></span>
                    <span class="cps-stat-label"><?php _e( 'Property Views', 'cari-prop-shop-analytics' ); ?></span>
                </div>
                <div class="cps-stat-box">
                    <span class="cps-stat-number"><?php echo esc_html( number_format( $overview['total_leads'] ) ); ?></span>
                    <span class="cps-stat-label"><?php _e( 'Total Leads', 'cari-prop-shop-analytics' ); ?></span>
                </div>
                <div class="cps-stat-box">
                    <span class="cps-stat-number"><?php echo esc_html( number_format( $overview['total_searches'] ) ); ?></span>
                    <span class="cps-stat-label"><?php _e( 'Search Queries', 'cari-prop-shop-analytics' ); ?></span>
                </div>
                <div class="cps-stat-box">
                    <span class="cps-stat-number"><?php echo esc_html( $overview['conversion_rate'] ); ?>%</span>
                    <span class="cps-stat-label"><?php _e( 'Conversion Rate', 'cari-prop-shop-analytics' ); ?></span>
                </div>
                <div class="cps-stat-box">
                    <span class="cps-stat-number"><?php echo esc_html( number_format( $overview['unique_viewers'] ) ); ?></span>
                    <span class="cps-stat-label"><?php _e( 'Unique Viewers', 'cari-prop-shop-analytics' ); ?></span>
                </div>
            </div>

            <div class="cps-charts-row">
                <div class="cps-chart-container">
                    <h2><?php _e( 'Views Over Time', 'cari-prop-shop-analytics' ); ?></h2>
                    <div class="cps-chart" id="cps-views-chart"></div>
                </div>
                <div class="cps-chart-container">
                    <h2><?php _e( 'Leads Over Time', 'cari-prop-shop-analytics' ); ?></h2>
                    <div class="cps-chart" id="cps-leads-chart"></div>
                </div>
            </div>

            <div class="cps-grid-row">
                <div class="cps-grid-box">
                    <h2><?php _e( 'Top Properties', 'cari-prop-shop-analytics' ); ?></h2>
                    <table class="widefat striped">
                        <thead>
                            <tr>
                                <th><?php _e( 'Property', 'cari-prop-shop-analytics' ); ?></th>
                                <th><?php _e( 'Views', 'cari-prop-shop-analytics' ); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ( $overview['top_properties'] as $property ) : ?>
                            <tr>
                                <td><a href="<?php echo get_edit_post_link( $property['property_id'] ); ?>"><?php echo esc_html( $property['title'] ); ?></a></td>
                                <td><?php echo esc_html( number_format( $property['views'] ) ); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="cps-grid-box">
                    <h2><?php _e( 'Lead Sources', 'cari-prop-shop-analytics' ); ?></h2>
                    <table class="widefat striped">
                        <thead>
                            <tr>
                                <th><?php _e( 'Source', 'cari-prop-shop-analytics' ); ?></th>
                                <th><?php _e( 'Leads', 'cari-prop-shop-analytics' ); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ( $detailed['leads_by_source'] as $source ) : ?>
                            <tr>
                                <td><?php echo esc_html( $source['source'] ); ?></td>
                                <td><?php echo esc_html( number_format( $source['count'] ) ); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="cps-grid-row">
                <div class="cps-grid-box">
                    <h2><?php _e( 'Device Breakdown', 'cari-prop-shop-analytics' ); ?></h2>
                    <table class="widefat striped">
                        <thead>
                            <tr>
                                <th><?php _e( 'Device', 'cari-prop-shop-analytics' ); ?></th>
                                <th><?php _e( 'Views', 'cari-prop-shop-analytics' ); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ( $detailed['views_by_device'] as $device ) : ?>
                            <tr>
                                <td><?php echo esc_html( ucfirst( $device['device_type'] ) ); ?></td>
                                <td><?php echo esc_html( number_format( $device['views'] ) ); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="cps-grid-box">
                    <h2><?php _e( 'Lead Types', 'cari-prop-shop-analytics' ); ?></h2>
                    <table class="widefat striped">
                        <thead>
                            <tr>
                                <th><?php _e( 'Type', 'cari-prop-shop-analytics' ); ?></th>
                                <th><?php _e( 'Count', 'cari-prop-shop-analytics' ); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ( $detailed['leads_by_type'] as $type ) : ?>
                            <tr>
                                <td><?php echo esc_html( $type['type'] ); ?></td>
                                <td><?php echo esc_html( number_format( $type['count'] ) ); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
    }

    public function render_properties_page() {
        $period = isset( $_GET['period'] ) ? sanitize_text_field( wp_unslash( $_GET['period'] ) ) : '30days';
        
        $property_views = new CPS_Property_Views();
        $most_viewed = $property_views->get_most_viewed_properties( 20, $this->parse_period( $period ) );
        
        ?>
        <div class="wrap cps-analytics-admin">
            <h1><?php _e( 'Property Performance', 'cari-prop-shop-analytics' ); ?></h1>
            
            <div class="cps-toolbar">
                <form method="get">
                    <input type="hidden" name="page" value="cps-analytics-properties">
                    <select name="period" onchange="this.form.submit()">
                        <option value="7days" <?php selected( $period, '7days' ); ?>><?php _e( 'Last 7 days', 'cari-prop-shop-analytics' ); ?></option>
                        <option value="30days" <?php selected( $period, '30days' ); ?>><?php _e( 'Last 30 days', 'cari-prop-shop-analytics' ); ?></option>
                        <option value="90days" <?php selected( $period, '90days' ); ?>><?php _e( 'Last 90 days', 'cari-prop-shop-analytics' ); ?></option>
                        <option value="365days" <?php selected( $period, '365days' ); ?>><?php _e( 'Last 365 days', 'cari-prop-shop-analytics' ); ?></option>
                    </select>
                </form>
            </div>

            <table class="widefat striped">
                <thead>
                    <tr>
                        <th><?php _e( 'Property', 'cari-prop-shop-analytics' ); ?></th>
                        <th><?php _e( 'Views', 'cari-prop-shop-analytics' ); ?></th>
                        <th><?php _e( 'Actions', 'cari-prop-shop-analytics' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $most_viewed as $property ) : ?>
                    <tr>
                        <td><a href="<?php echo get_edit_post_link( $property['property_id'] ); ?>"><?php echo esc_html( $property['title'] ); ?></a></td>
                        <td><?php echo esc_html( number_format( $property['views'] ) ); ?></td>
                        <td><a href="<?php echo get_permalink( $property['property_id'] ); ?>" target="_blank" class="button button-small"><?php _e( 'View', 'cari-prop-shop-analytics' ); ?></a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    public function render_leads_page() {
        $period = isset( $_GET['period'] ) ? sanitize_text_field( wp_unslash( $_GET['period'] ) ) : '30days';
        $days = $this->parse_period( $period );
        
        $lead_metrics = $this->stats->get_lead_metrics( $days );
        
        ?>
        <div class="wrap cps-analytics-admin">
            <h1><?php _e( 'Lead Source Reports', 'cari-prop-shop-analytics' ); ?></h1>
            
            <div class="cps-toolbar">
                <form method="get">
                    <input type="hidden" name="page" value="cps-analytics-leads">
                    <select name="period" onchange="this.form.submit()">
                        <option value="7days" <?php selected( $period, '7days' ); ?>><?php _e( 'Last 7 days', 'cari-prop-shop-analytics' ); ?></option>
                        <option value="30days" <?php selected( $period, '30days' ); ?>><?php _e( 'Last 30 days', 'cari-prop-shop-analytics' ); ?></option>
                        <option value="90days" <?php selected( $period, '90days' ); ?>><?php _e( 'Last 90 days', 'cari-prop-shop-analytics' ); ?></option>
                        <option value="365days" <?php selected( $period, '365days' ); ?>><?php _e( 'Last 365 days', 'cari-prop-shop-analytics' ); ?></option>
                    </select>
                </form>
            </div>

            <div class="cps-stats-overview">
                <div class="cps-stat-box">
                    <span class="cps-stat-number"><?php echo esc_html( number_format( $lead_metrics['total_leads'] ) ); ?></span>
                    <span class="cps-stat-label"><?php _e( 'Total Leads', 'cari-prop-shop-analytics' ); ?></span>
                </div>
                <div class="cps-stat-box">
                    <span class="cps-stat-number"><?php echo esc_html( number_format( $lead_metrics['converted_leads'] ) ); ?></span>
                    <span class="cps-stat-label"><?php _e( 'Converted', 'cari-prop-shop-analytics' ); ?></span>
                </div>
                <div class="cps-stat-box">
                    <span class="cps-stat-number"><?php echo esc_html( $lead_metrics['conversion_rate'] ); ?>%</span>
                    <span class="cps-stat-label"><?php _e( 'Conversion Rate', 'cari-prop-shop-analytics' ); ?></span>
                </div>
            </div>

            <div class="cps-grid-row">
                <div class="cps-grid-box">
                    <h2><?php _e( 'Leads by Source', 'cari-prop-shop-analytics' ); ?></h2>
                    <table class="widefat striped">
                        <thead>
                            <tr>
                                <th><?php _e( 'Source', 'cari-prop-shop-analytics' ); ?></th>
                                <th><?php _e( 'Count', 'cari-prop-shop-analytics' ); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ( $lead_metrics['leads_by_source'] as $source ) : ?>
                            <tr>
                                <td><?php echo esc_html( $source['source'] ); ?></td>
                                <td><?php echo esc_html( number_format( $source['count'] ) ); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="cps-grid-box">
                    <h2><?php _e( 'Leads by Type', 'cari-prop-shop-analytics' ); ?></h2>
                    <table class="widefat striped">
                        <thead>
                            <tr>
                                <th><?php _e( 'Type', 'cari-prop-shop-analytics' ); ?></th>
                                <th><?php _e( 'Count', 'cari-prop-shop-analytics' ); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ( $lead_metrics['leads_by_type'] as $type ) : ?>
                            <tr>
                                <td><?php echo esc_html( $type['type'] ); ?></td>
                                <td><?php echo esc_html( number_format( $type['count'] ) ); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <h2><?php _e( 'Recent Leads', 'cari-prop-shop-analytics' ); ?></h2>
            <table class="widefat striped">
                <thead>
                    <tr>
                        <th><?php _e( 'Date', 'cari-prop-shop-analytics' ); ?></th>
                        <th><?php _e( 'Property', 'cari-prop-shop-analytics' ); ?></th>
                        <th><?php _e( 'Type', 'cari-prop-shop-analytics' ); ?></th>
                        <th><?php _e( 'Source', 'cari-prop-shop-analytics' ); ?></th>
                        <th><?php _e( 'Converted', 'cari-prop-shop-analytics' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $lead_metrics['recent_leads'] as $lead ) : ?>
                    <tr>
                        <td><?php echo esc_html( $lead['created_at'] ); ?></td>
                        <td><?php echo esc_html( $lead['property_title'] ); ?></td>
                        <td><?php echo esc_html( $lead['lead_type'] ); ?></td>
                        <td><?php echo esc_html( $lead['lead_source'] ); ?></td>
                        <td><?php echo $lead['converted'] ? '<span class="dashicons dashicons-yes-alt" style="color:green;"></span>' : '<span class="dashicons dashicons-no-alt" style="color:red;"></span>'; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    public function render_searches_page() {
        $period = isset( $_GET['period'] ) ? sanitize_text_field( wp_unslash( $_GET['period'] ) ) : '30days';
        $days = $this->parse_period( $period );
        
        $search_metrics = $this->stats->get_search_metrics( $days );
        
        ?>
        <div class="wrap cps-analytics-admin">
            <h1><?php _e( 'Search Analytics', 'cari-prop-shop-analytics' ); ?></h1>
            
            <div class="cps-toolbar">
                <form method="get">
                    <input type="hidden" name="page" value="cps-analytics-searches">
                    <select name="period" onchange="this.form.submit()">
                        <option value="7days" <?php selected( $period, '7days' ); ?>><?php _e( 'Last 7 days', 'cari-prop-shop-analytics' ); ?></option>
                        <option value="30days" <?php selected( $period, '30days' ); ?>><?php _e( 'Last 30 days', 'cari-prop-shop-analytics' ); ?></option>
                        <option value="90days" <?php selected( $period, '90days' ); ?>><?php _e( 'Last 90 days', 'cari-prop-shop-analytics' ); ?></option>
                        <option value="365days" <?php selected( $period, '365days' ); ?>><?php _e( 'Last 365 days', 'cari-prop-shop-analytics' ); ?></option>
                    </select>
                </form>
            </div>

            <div class="cps-stats-overview">
                <div class="cps-stat-box">
                    <span class="cps-stat-number"><?php echo esc_html( number_format( $search_metrics['total_searches'] ) ); ?></span>
                    <span class="cps-stat-label"><?php _e( 'Total Searches', 'cari-prop-shop-analytics' ); ?></span>
                </div>
                <div class="cps-stat-box">
                    <span class="cps-stat-number"><?php echo esc_html( number_format( $search_metrics['zero_results'] ) ); ?></span>
                    <span class="cps-stat-label"><?php _e( 'Zero Results', 'cari-prop-shop-analytics' ); ?></span>
                </div>
                <div class="cps-stat-box">
                    <span class="cps-stat-number"><?php echo esc_html( $search_metrics['zero_result_rate'] ); ?>%</span>
                    <span class="cps-stat-label"><?php _e( 'Zero Result Rate', 'cari-prop-shop-analytics' ); ?></span>
                </div>
                <div class="cps-stat-box">
                    <span class="cps-stat-number"><?php echo esc_html( $search_metrics['average_results'] ); ?></span>
                    <span class="cps-stat-label"><?php _e( 'Avg Results', 'cari-prop-shop-analytics' ); ?></span>
                </div>
            </div>

            <h2><?php _e( 'Top Search Queries', 'cari-prop-shop-analytics' ); ?></h2>
            <table class="widefat striped">
                <thead>
                    <tr>
                        <th><?php _e( 'Query', 'cari-prop-shop-analytics' ); ?></th>
                        <th><?php _e( 'Times Searched', 'cari-prop-shop-analytics' ); ?></th>
                        <th><?php _e( 'Total Results', 'cari-prop-shop-analytics' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $search_metrics['top_queries'] as $query ) : ?>
                    <tr>
                        <td><?php echo esc_html( $query['query'] ); ?></td>
                        <td><?php echo esc_html( number_format( $query['count'] ) ); ?></td>
                        <td><?php echo esc_html( number_format( $query['total_results'] ) ); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h2><?php _e( 'Recent Searches', 'cari-prop-shop-analytics' ); ?></h2>
            <table class="widefat striped">
                <thead>
                    <tr>
                        <th><?php _e( 'Date', 'cari-prop-shop-analytics' ); ?></th>
                        <th><?php _e( 'Query', 'cari-prop-shop-analytics' ); ?></th>
                        <th><?php _e( 'Results', 'cari-prop-shop-analytics' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $search_metrics['recent_searches'] as $search ) : ?>
                    <tr>
                        <td><?php echo esc_html( $search['search_datetime'] ); ?></td>
                        <td><?php echo esc_html( $search['search_query'] ); ?></td>
                        <td><?php echo esc_html( number_format( $search['results_count'] ) ); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    public function render_export_page() {
        ?>
        <div class="wrap cps-analytics-admin">
            <h1><?php _e( 'Export Reports', 'cari-prop-shop-analytics' ); ?></h1>
            
            <div class="cps-export-options">
                <div class="card">
                    <h2><?php _e( 'Export Property Views', 'cari-prop-shop-analytics' ); ?></h2>
                    <p><?php _e( 'Download property view statistics as CSV.', 'cari-prop-shop-analytics' ); ?></p>
                    <form method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>">
                        <input type="hidden" name="action" value="cps_export_csv">
                        <input type="hidden" name="export_type" value="views">
                        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'cps_export_nonce' ); ?>">
                        <select name="period">
                            <option value="7"><?php _e( 'Last 7 days', 'cari-prop-shop-analytics' ); ?></option>
                            <option value="30" selected><?php _e( 'Last 30 days', 'cari-prop-shop-analytics' ); ?></option>
                            <option value="90"><?php _e( 'Last 90 days', 'cari-prop-shop-analytics' ); ?></option>
                            <option value="365"><?php _e( 'Last 365 days', 'cari-prop-shop-analytics' ); ?></option>
                        </select>
                        <button type="submit" class="button button-primary"><?php _e( 'Export CSV', 'cari-prop-shop-analytics' ); ?></button>
                    </form>
                </div>

                <div class="card">
                    <h2><?php _e( 'Export Leads', 'cari-prop-shop-analytics' ); ?></h2>
                    <p><?php _e( 'Download lead tracking data as CSV.', 'cari-prop-shop-analytics' ); ?></p>
                    <form method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>">
                        <input type="hidden" name="action" value="cps_export_csv">
                        <input type="hidden" name="export_type" value="leads">
                        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'cps_export_nonce' ); ?>">
                        <select name="period">
                            <option value="7"><?php _e( 'Last 7 days', 'cari-prop-shop-analytics' ); ?></option>
                            <option value="30" selected><?php _e( 'Last 30 days', 'cari-prop-shop-analytics' ); ?></option>
                            <option value="90"><?php _e( 'Last 90 days', 'cari-prop-shop-analytics' ); ?></option>
                            <option value="365"><?php _e( 'Last 365 days', 'cari-prop-shop-analytics' ); ?></option>
                        </select>
                        <button type="submit" class="button button-primary"><?php _e( 'Export CSV', 'cari-prop-shop-analytics' ); ?></button>
                    </form>
                </div>

                <div class="card">
                    <h2><?php _e( 'Export Searches', 'cari-prop-shop-analytics' ); ?></h2>
                    <p><?php _e( 'Download search query data as CSV.', 'cari-prop-shop-analytics' ); ?></p>
                    <form method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>">
                        <input type="hidden" name="action" value="cps_export_csv">
                        <input type="hidden" name="export_type" value="searches">
                        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'cps_export_nonce' ); ?>">
                        <select name="period">
                            <option value="7"><?php _e( 'Last 7 days', 'cari-prop-shop-analytics' ); ?></option>
                            <option value="30" selected><?php _e( 'Last 30 days', 'cari-prop-shop-analytics' ); ?></option>
                            <option value="90"><?php _e( 'Last 90 days', 'cari-prop-shop-analytics' ); ?></option>
                            <option value="365"><?php _e( 'Last 365 days', 'cari-prop-shop-analytics' ); ?></option>
                        </select>
                        <button type="submit" class="button button-primary"><?php _e( 'Export CSV', 'cari-prop-shop-analytics' ); ?></button>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }

    private function parse_period( $period ) {
        $period = strtolower( $period );
        
        switch ( $period ) {
            case '7days': return 7;
            case '30days': return 30;
            case '90days': return 90;
            case '365days': return 365;
            default: return 30;
        }
    }

    public function handle_export_csv() {
        check_admin_referer( 'cps_export_nonce', 'nonce' );
        
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( __( 'Unauthorized', 'cari-prop-shop-analytics' ) );
        }

        $export_type = isset( $_POST['export_type'] ) ? sanitize_text_field( wp_unslash( $_POST['export_type'] ) ) : 'views';
        $days = isset( $_POST['period'] ) ? absint( $_POST['period'] ) : 30;

        switch ( $export_type ) {
            case 'views':
                $this->export_views_csv( $days );
                break;
            case 'leads':
                $this->export_leads_csv( $days );
                break;
            case 'searches':
                $this->export_searches_csv( $days );
                break;
            default:
                wp_die( __( 'Invalid export type', 'cari-prop-shop-analytics' ) );
        }
    }

    private function export_views_csv( $days ) {
        global $wpdb;

        $date = date( 'Y-m-d', strtotime( "-{$days} days" ) );

        $results = $wpdb->get_results( $wpdb->prepare(
            "SELECT p.post_title as property_title, v.view_date as date, COUNT(*) as views
             FROM {$wpdb->prefix}" . CPS_ANALYTICS_TABLE_VIEWS . " v
             INNER JOIN {$wpdb->posts} p ON v.property_id = p.ID
             WHERE v.view_date >= %s
             GROUP BY v.property_id, v.view_date
             ORDER BY v.view_date DESC",
            $date
        ), ARRAY_A );

        $this->send_csv_file( 'property-views.csv', $results );
    }

    private function export_leads_csv( $days ) {
        global $wpdb;

        $date = date( 'Y-m-d H:i:s', strtotime( "-{$days} days" ) );

        $results = $wpdb->get_results( $wpdb->prepare(
            "SELECT l.lead_type, l.lead_source, l.referrer, l.created_at as date,
                    CASE WHEN l.converted = 1 THEN 'Yes' ELSE 'No' END as converted,
                    p.post_title as property_title
             FROM {$wpdb->prefix}" . CPS_ANALYTICS_TABLE_LEADS . " l
             LEFT JOIN {$wpdb->posts} p ON l.property_id = p.ID
             WHERE l.created_at >= %s
             ORDER BY l.created_at DESC",
            $date
        ), ARRAY_A );

        $this->send_csv_file( 'leads.csv', $results );
    }

    private function export_searches_csv( $days ) {
        global $wpdb;

        $date = date( 'Y-m-d', strtotime( "-{$days} days" ) );

        $results = $wpdb->get_results( $wpdb->prepare(
            "SELECT s.search_query, s.results_count, s.filters, s.search_datetime as date
             FROM {$wpdb->prefix}" . CPS_ANALYTICS_TABLE_SEARCHES . " s
             WHERE s.search_date >= %s
             ORDER BY s.search_datetime DESC",
            $date
        ), ARRAY_A );

        $this->send_csv_file( 'search-queries.csv', $results );
    }

    private function send_csv_file( $filename, $data ) {
        header( 'Content-Type: text/csv' );
        header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
        header( 'Pragma: no-cache' );
        header( 'Expires: 0' );

        $output = fopen( 'php://output', 'w' );

        if ( ! empty( $data ) ) {
            fputcsv( $output, array_keys( $data[0] ) );
            
            foreach ( $data as $row ) {
                fputcsv( $output, $row );
            }
        }

        fclose( $output );
        exit;
    }

    public function handle_chart_data() {
        check_ajax_referer( 'cps_analytics_nonce', 'nonce' );
        
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( __( 'Unauthorized', 'cari-prop-shop-analytics' ) );
        }

        $chart_type = isset( $_GET['chart_type'] ) ? sanitize_text_field( wp_unslash( $_GET['chart_type'] ) ) : '';
        $period = isset( $_GET['period'] ) ? sanitize_text_field( wp_unslash( $_GET['period'] ) ) : '30days';
        
        $detailed = $this->stats->get_detailed_stats( $period );
        
        $response_data = array();
        
        switch ( $chart_type ) {
            case 'views':
                $response_data = $detailed['views_by_date'];
                break;
            case 'leads':
                $response_data = $detailed['leads_by_date'];
                break;
            case 'searches':
                $response_data = $detailed['searches_by_date'];
                break;
            default:
                wp_send_json_error( __( 'Invalid chart type', 'cari-prop-shop-analytics' ) );
        }
        
        wp_send_json_success( $response_data );
    }
}