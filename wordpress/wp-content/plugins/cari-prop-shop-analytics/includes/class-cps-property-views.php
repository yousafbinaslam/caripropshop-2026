<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CPS_Property_Views {

    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . CPS_ANALYTICS_TABLE_VIEWS;
    }

    public function init() {
        add_action( 'wp', array( $this, 'track_current_view' ) );
        add_action( ' template_redirect', array( $this, 'track_current_view' ), 5 );
    }

    public function track_current_view() {
        if ( ! is_singular( 'property' ) && ! is_singular( 'listing' ) ) {
            return;
        }

        $object = get_queried_object();
        if ( ! $object || ! isset( $object->ID ) ) {
            return;
        }

        $property_id = absint( $object->ID );
        if ( $property_id ) {
            $this->track_view( $property_id );
        }
    }

    public function track_view( $property_id ) {
        global $wpdb;

        $session_id = $this->get_session_id();
        $user_ip   = $this->get_user_ip();
        $user_agent = isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';
        $referrer  = isset( $_SERVER['HTTP_REFERER'] ) ? esc_url_raw( wp_unslash( $_SERVER['HTTP_REFERER'] ) ) : '';

        $result = $wpdb->insert(
            $this->table_name,
            array(
                'property_id'   => $property_id,
                'user_id'       => get_current_user_id() ? get_current_user_id() : null,
                'session_id'    => $session_id,
                'ip_address'    => $user_ip,
                'user_agent'    => $user_agent,
                'referrer'      => $referrer,
                'view_date'     => current_time( 'Y-m-d' ),
                'view_datetime' => current_time( 'Y-m-d H:i:s' ),
                'device_type'  => $this->get_device_type( $user_agent ),
            ),
            array(
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
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

    private function get_device_type( $user_agent ) {
        if ( empty( $user_agent ) ) {
            return 'unknown';
        }

        $user_agent = strtolower( $user_agent );

        if ( preg_match( '/mobile|android|iphone|ipod|blackberry|windows phone/i', $user_agent ) ) {
            return 'mobile';
        }

        if ( preg_match( '/tablet|ipad|android(?!.*mobile)/i', $user_agent ) ) {
            return 'tablet';
        }

        return 'desktop';
    }

    public function get_property_views( $property_id, $days = 30 ) {
        global $wpdb;

        $date = date( 'Y-m-d', strtotime( "-{$days} days" ) );

        return (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM {$this->table_name} 
             WHERE property_id = %d AND view_date >= %s",
            $property_id,
            $date
        ) );
    }

    public function get_most_viewed_properties( $limit = 10, $days = 30 ) {
        global $wpdb;

        $date = date( 'Y-m-d', strtotime( "-{$days} days" ) );

        $results = $wpdb->get_results( $wpdb->prepare(
            "SELECT p.ID as property_id, p.post_title as title, COUNT(v.id) as view_count
             FROM {$wpdb->posts} p
             INNER JOIN {$this->table_name} v ON p.ID = v.property_id
             WHERE v.view_date >= %s AND p.post_status = 'publish'
             GROUP BY p.ID
             ORDER BY view_count DESC
             LIMIT %d",
            $date,
            $limit
        ), ARRAY_A );

        return array_map( function( $row ) {
            return array(
                'property_id' => absint( $row['property_id'] ),
                'title'      => esc_html( $row['title'] ),
                'views'      => absint( $row['view_count'] ),
            );
        }, $results );
    }

    public function get_views_by_date( $days = 30 ) {
        global $wpdb;

        $date = date( 'Y-m-d', strtotime( "-{$days} days" ) );

        $results = $wpdb->get_results( $wpdb->prepare(
            "SELECT view_date as date, COUNT(*) as views
             FROM {$this->table_name}
             WHERE view_date >= %s
             GROUP BY view_date
             ORDER BY view_date ASC",
            $date
        ), ARRAY_A );

        return array_map( function( $row ) {
            return array(
                'date'  => esc_html( $row['date'] ),
                'views' => absint( $row['views'] ),
            );
        }, $results );
    }

    public function get_views_by_device( $days = 30 ) {
        global $wpdb;

        $date = date( 'Y-m-d', strtotime( "-{$days} days" ) );

        $results = $wpdb->get_results( $wpdb->prepare(
            "SELECT device_type, COUNT(*) as views
             FROM {$this->table_name}
             WHERE view_date >= %s
             GROUP BY device_type
             ORDER BY views DESC",
            $date
        ), ARRAY_A );

        return array_map( function( $row ) {
            return array(
                'device_type' => esc_html( $row['device_type'] ),
                'views'      => absint( $row['views'] ),
            );
        }, $results );
    }

    public function get_unique_viewers( $days = 30 ) {
        global $wpdb;

        $date = date( 'Y-m-d', strtotime( "-{$days} days" ) );

        return (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(DISTINCT session_id) FROM {$this->table_name} 
             WHERE view_date >= %s",
            $date
        ) );
    }
}