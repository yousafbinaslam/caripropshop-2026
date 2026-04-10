<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CPS_Search_Analytics {

    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . CPS_ANALYTICS_TABLE_SEARCHES;
    }

    public function init() {
    }

    public function track_search( $search_query, $filters = array(), $results_count = 0 ) {
        global $wpdb;

        $session_id = $this->get_session_id();
        $user_ip   = $this->get_user_ip();

        $filters_json = '';
        if ( is_array( $filters ) && ! empty( $filters ) ) {
            $filters_json = wp_json_encode( $filters );
        }

        $result = $wpdb->insert(
            $this->table_name,
            array(
                'session_id'     => $session_id,
                'search_query'  => $search_query,
                'filters'       => $filters_json,
                'results_count' => $results_count,
                'ip_address'   => $user_ip,
                'search_date'   => current_time( 'Y-m-d' ),
                'search_datetime' => current_time( 'Y-m-d H:i:s' ),
            ),
            array(
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
            )
        );

        return $result !== false;
    }

    private function get_session_id() {
        if ( ! session_id() ) {
            session_start();
        }

        if ( ! isset( $_SESSION['cps_session_id'] ) ) {
            $_SESSION['cps_session_id'] = $this->generate_session_id();
        }

        return $_SESSION['cps_session_id'];
    }

    private function generate_session_id() {
        return bin2hex( random_bytes( 32 ) );
    }

    private function get_user_ip() {
        $ip_headers = array(
            'HTTP_CF_CONNECTING_IP',
            'HTTP_X_REAL_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR',
        );

        foreach ( $ip_headers as $header ) {
            if ( ! empty( $_SERVER[ $header ] ) ) {
                $ip = sanitize_text_field( wp_unslash( $_SERVER[ $header ] ) );
                $ip = explode( ',', $ip );
                $ip = trim( $ip[0] );

                if ( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE ) ) {
                    return $ip;
                }
            }
        }

        return '';
    }

    public function get_total_searches( $days = 30 ) {
        global $wpdb;

        $date = date( 'Y-m-d', strtotime( "-{$days} days" ) );

        return (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM {$this->table_name} 
             WHERE search_date >= %s",
            $date
        ) );
    }

    public function get_most_searched_queries( $limit = 20, $days = 30 ) {
        global $wpdb;

        $date = date( 'Y-m-d', strtotime( "-{$days} days" ) );

        $results = $wpdb->get_results( $wpdb->prepare(
            "SELECT search_query, COUNT(*) as count, 
                    SUM(results_count) as total_results
             FROM {$this->table_name}
             WHERE search_date >= %s
             GROUP BY search_query
             ORDER BY count DESC
             LIMIT %d",
            $date,
            $limit
        ), ARRAY_A );

        return array_map( function( $row ) {
            return array(
                'query'        => esc_html( $row['search_query'] ),
                'count'       => absint( $row['count'] ),
                'total_results' => absint( $row['total_results'] ),
            );
        }, $results );
    }

    public function get_searches_by_date( $days = 30 ) {
        global $wpdb;

        $date = date( 'Y-m-d', strtotime( "-{$days} days" ) );

        $results = $wpdb->get_results( $wpdb->prepare(
            "SELECT search_date as date, COUNT(*) as searches
             FROM {$this->table_name}
             WHERE search_date >= %s
             GROUP BY search_date
             ORDER BY date ASC",
            $date
        ), ARRAY_A );

        return array_map( function( $row ) {
            return array(
                'date'      => esc_html( $row['date'] ),
                'searches'  => absint( $row['searches'] ),
            );
        }, $results );
    }

    public function get_average_results() {
        global $wpdb;

        return (float) $wpdb->get_var(
            "SELECT AVG(results_count) FROM {$this->table_name}"
        );
    }

    public function get_zero_result_searches( $days = 30 ) {
        global $wpdb;

        $date = date( 'Y-m-d', strtotime( "-{$days} days" ) );

        return (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM {$this->table_name} 
             WHERE search_date >= %s AND results_count = 0",
            $date
        ) );
    }

    public function get_recent_searches( $limit = 20 ) {
        global $wpdb;

        $results = $wpdb->get_results( $wpdb->prepare(
            "SELECT * FROM {$this->table_name}
             ORDER BY search_datetime DESC
             LIMIT %d",
            $limit
        ), ARRAY_A );

        return array_map( function( $row ) {
            return array(
                'id'             => absint( $row['id'] ),
                'search_query'   => esc_html( $row['search_query'] ),
                'filters'       => ! empty( $row['filters'] ) ? json_decode( $row['filters'], true ) : array(),
                'results_count' => absint( $row['results_count'] ),
                'search_datetime' => esc_html( $row['search_datetime'] ),
            );
        }, $results );
    }

    public function get_popular_filters( $days = 30 ) {
        global $wpdb;

        $date = date( 'Y-m-d', strtotime( "-{$days} days" ) );

        $results = $wpdb->get_results( $wpdb->prepare(
            "SELECT filters, COUNT(*) as count
             FROM {$this->table_name}
             WHERE search_date >= %s AND filters != ''
             GROUP BY filters
             ORDER BY count DESC
             LIMIT 20",
            $date
        ), ARRAY_A );

        return array_map( function( $row ) {
            return array(
                'filters' => ! empty( $row['filters'] ) ? json_decode( $row['filters'], true ) : array(),
                'count'  => absint( $row['count'] ),
            );
        }, $results );
    }
}