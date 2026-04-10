<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CPS_Stats {

    private $property_views;
    private $lead_tracking;
    private $search_analytics;

    public function __construct() {
        $this->property_views   = new CPS_Property_Views();
        $this->lead_tracking   = new CPS_Lead_Tracking();
        $this->search_analytics = new CPS_Search_Analytics();
    }

    public function get_overview_stats( $period = '30days' ) {
        $days = $this->parse_period( $period );

        $total_views    = $this->get_total_views( $days );
        $total_leads    = $this->lead_tracking->get_total_leads( $days );
        $converted_leads = $this->lead_tracking->get_converted_leads( $days );
        $total_searches = $this->search_analytics->get_total_searches( $days );

        $unique_viewers = $this->property_views->get_unique_viewers( $days );

        $conversion_rate = 0;
        if ( $total_leads > 0 ) {
            $conversion_rate = round( ( $converted_leads / $total_leads ) * 100, 1 );
        }

        $top_properties = $this->property_views->get_most_viewed_properties( 5, $days );

        return array(
            'total_views'       => $total_views,
            'total_leads'       => $total_leads,
            'converted_leads'   => $converted_leads,
            'total_searches'    => $total_searches,
            'unique_viewers'     => $unique_viewers,
            'conversion_rate'   => $conversion_rate,
            'top_properties'    => $top_properties,
            'period'           => $period,
        );
    }

    public function get_detailed_stats( $period = '30days' ) {
        $days = $this->parse_period( $period );

        $views_by_date  = $this->property_views->get_views_by_date( $days );
        $leads_by_date  = $this->lead_tracking->get_leads_by_date( $days );
        $searches_by_date = $this->search_analytics->get_searches_by_date( $days );

        $leads_by_source   = $this->lead_tracking->get_leads_by_source( $days );
        $leads_by_type    = $this->lead_tracking->get_leads_by_type( $days );
        $views_by_device  = $this->property_views->get_views_by_device( $days );

        $top_searches  = $this->search_analytics->get_most_searched_queries( 10, $days );
        $zero_result_searches = $this->search_analytics->get_zero_result_searches( $days );
        $avg_results  = $this->search_analytics->get_average_results();

        return array(
            'views_by_date'      => $views_by_date,
            'leads_by_date'     => $leads_by_date,
            'searches_by_date'  => $searches_by_date,
            'leads_by_source'   => $leads_by_source,
            'leads_by_type'     => $leads_by_type,
            'views_by_device'   => $views_by_device,
            'top_searches'      => $top_searches,
            'zero_results'      => $zero_result_searches,
            'avg_results'       => round( $avg_results, 1 ),
            'period'            => $period,
        );
    }

    private function get_total_views( $days ) {
        global $wpdb;

        if ( $days === 0 ) {
            return (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}" . CPS_ANALYTICS_TABLE_VIEWS );
        }

        $date = date( 'Y-m-d', strtotime( "-{$days} days" ) );

        return (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->prefix}" . CPS_ANALYTICS_TABLE_VIEWS . " WHERE view_date >= %s",
            $date
        ) );
    }

    private function parse_period( $period ) {
        $period = strtolower( $period );
        
        switch ( $period ) {
            case '7days':
                return 7;
            case '30days':
                return 30;
            case '90days':
                return 90;
            case '365days':
                return 365;
            case 'all':
                return 0;
            default:
                if ( is_numeric( $period ) ) {
                    return absint( $period );
                }
                return 30;
        }
    }

    public function get_property_performance( $property_id, $days = 30 ) {
        $views = $this->property_views->get_property_views( $property_id, $days );
        $leads = $this->lead_tracking->get_leads_by_property( $property_id, $days );

        return array(
            'property_id' => $property_id,
            'views'      => $views,
            'leads'      => $leads,
            'days'       => $days,
        );
    }

    public function get_lead_metrics( $days = 30 ) {
        $total_leads      = $this->lead_tracking->get_total_leads( $days );
        $converted_leads  = $this->lead_tracking->get_converted_leads( $days );
        $leads_by_source = $this->lead_tracking->get_leads_by_source( $days );
        $leads_by_type   = $this->lead_tracking->get_leads_by_type( $days );
        $recent_leads   = $this->lead_tracking->get_recent_leads( 20 );

        $conversion_rate = 0;
        if ( $total_leads > 0 ) {
            $conversion_rate = round( ( $converted_leads / $total_leads ) * 100, 1 );
        }

        return array(
            'total_leads'      => $total_leads,
            'converted_leads' => $converted_leads,
            'conversion_rate' => $conversion_rate,
            'leads_by_source'  => $leads_by_source,
            'leads_by_type'   => $leads_by_type,
            'recent_leads'    => $recent_leads,
            'period'          => $days,
        );
    }

    public function get_search_metrics( $days = 30 ) {
        $total_searches     = $this->search_analytics->get_total_searches( $days );
        $zero_results       = $this->search_analytics->get_zero_result_searches( $days );
        $top_queries       = $this->search_analytics->get_most_searched_queries( 20, $days );
        $average_results   = $this->search_analytics->get_average_results();
        $recent_searches   = $this->search_analytics->get_recent_searches( 20 );

        $zero_rate = 0;
        if ( $total_searches > 0 ) {
            $zero_rate = round( ( $zero_results / $total_searches ) * 100, 1 );
        }

        return array(
            'total_searches'    => $total_searches,
            'zero_results'     => $zero_results,
            'zero_result_rate' => $zero_rate,
            'average_results'  => round( $average_results, 1 ),
            'top_queries'      => $top_queries,
            'recent_searches'  => $recent_searches,
            'period'           => $days,
        );
    }
}