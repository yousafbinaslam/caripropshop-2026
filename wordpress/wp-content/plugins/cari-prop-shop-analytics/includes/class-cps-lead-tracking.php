<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CPS_Lead_Tracking {

    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . CPS_ANALYTICS_TABLE_LEADS;
    }

    public function init() {
        add_action( 'wp', array( $this, 'capture_referrer' ) );
    }

    public function capture_referrer() {
        if ( is_admin() || wp_doing_cron() ) {
            return;
        }
    }

    public function track_lead( $property_id = null, $lead_type ) {
        global $wpdb;

        $session_id = $this->get_session_id();
        $user_ip   = $this->get_user_ip();
        $user_agent = isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';
        $referrer  = isset( $_SERVER['HTTP_REFERER'] ) ? esc_url_raw( wp_unslash( $_SERVER['HTTP_REFERER'] ) ) : '';

        $utm_source   = isset( $_GET['utm_source'] ) ? sanitize_text_field( wp_unslash( $_GET['utm_source'] ) ) : '';
        $utm_medium   = isset( $_GET['utm_medium'] ) ? sanitize_text_field( wp_unslash( $_GET['utm_medium'] ) ) : '';
        $utm_campaign = isset( $_GET['utm_campaign'] ) ? sanitize_text_field( wp_unslash( $_GET['utm_campaign'] ) ) : '';
        $utm_term    = isset( $_GET['utm_term'] ) ? sanitize_text_field( wp_unslash( $_GET['utm_term'] ) ) : '';
        $utm_content = isset( $_GET['utm_content'] ) ? sanitize_text_field( wp_unslash( $_GET['utm_content'] ) ) : '';

        $lead_source = $this->determine_lead_source( $referrer, $utm_source );

        $result = $wpdb->insert(
            $this->table_name,
            array(
                'property_id'    => $property_id,
                'user_id'        => get_current_user_id() ? get_current_user_id() : null,
                'session_id'     => $session_id,
                'lead_type'      => $lead_type,
                'lead_source'   => $lead_source,
                'referrer'       => $referrer,
                'utm_source'    => $utm_source,
                'utm_medium'    => $utm_medium,
                'utm_campaign'  => $utm_campaign,
                'utm_term'       => $utm_term,
                'utm_content'   => $utm_content,
                'ip_address'    => $user_ip,
                'user_agent'    => $user_agent,
                'converted'     => 0,
                'created_at'    => current_time( 'Y-m-d H:i:s' ),
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
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
            )
        );

        return $result !== false;
    }

    public function track_conversion( $lead_id ) {
        global $wpdb;

        return $wpdb->update(
            $this->table_name,
            array(
                'converted'            => 1,
                'conversion_datetime' => current_time( 'Y-m-d H:i:s' ),
            ),
            array( 'id' => $lead_id ),
            array( '%d', '%s' ),
            array( '%d' )
        );
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

    private function determine_lead_source( $referrer, $utm_source ) {
        if ( ! empty( $utm_source ) ) {
            return $utm_source;
        }

        if ( empty( $referrer ) ) {
            return 'direct';
        }

        $referrer_parts = parse_url( $referrer );
        $referer_host = isset( $referrer_parts['host'] ) ? $referrer_parts['host'] : '';

        $site_url = get_site_url();
        $site_parts = parse_url( $site_url );
        $site_host = isset( $site_parts['host'] ) ? $site_parts['host'] : '';

        if ( empty( $referer_host ) || $referer_host === $site_host ) {
            return 'internal';
        }

        $search_engines = array(
            'google'   => 'google',
            'bing'    => 'bing',
            'yahoo'   => 'yahoo',
            'duckduckgo' => 'duckduckgo',
        );

        foreach ( $search_engines as $engine => $source ) {
            if ( strpos( $referer_host, $engine ) !== false ) {
                return 'organic_' . $source;
            }
        }

        return 'external_' . sanitize_title_for_query( $referer_host );
    }

    public function get_total_leads( $days = 30 ) {
        global $wpdb;

        $date = date( 'Y-m-d H:i:s', strtotime( "-{$days} days" ) );

        return (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM {$this->table_name} 
             WHERE created_at >= %s",
            $date
        ) );
    }

    public function get_converted_leads( $days = 30 ) {
        global $wpdb;

        $date = date( 'Y-m-d H:i:s', strtotime( "-{$days} days" ) );

        return (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM {$this->table_name} 
             WHERE converted = 1 AND conversion_datetime >= %s",
            $date
        ) );
    }

    public function get_leads_by_source( $days = 30 ) {
        global $wpdb;

        $date = date( 'Y-m-d H:i:s', strtotime( "-{$days} days" ) );

        $results = $wpdb->get_results( $wpdb->prepare(
            "SELECT lead_source, COUNT(*) as count
             FROM {$this->table_name}
             WHERE created_at >= %s
             GROUP BY lead_source
             ORDER BY count DESC",
            $date
        ), ARRAY_A );

        return array_map( function( $row ) {
            return array(
                'source' => esc_html( $row['lead_source'] ),
                'count'  => absint( $row['count'] ),
            );
        }, $results );
    }

    public function get_leads_by_type( $days = 30 ) {
        global $wpdb;

        $date = date( 'Y-m-d H:i:s', strtotime( "-{$days} days" ) );

        $results = $wpdb->get_results( $wpdb->prepare(
            "SELECT lead_type, COUNT(*) as count
             FROM {$this->table_name}
             WHERE created_at >= %s
             GROUP BY lead_type
             ORDER BY count DESC",
            $date
        ), ARRAY_A );

        return array_map( function( $row ) {
            return array(
                'type'  => esc_html( $row['lead_type'] ),
                'count' => absint( $row['count'] ),
            );
        }, $results );
    }

    public function get_leads_by_property( $property_id, $days = 30 ) {
        global $wpdb;

        $date = date( 'Y-m-d H:i:s', strtotime( "-{$days} days" ) );

        return (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM {$this->table_name} 
             WHERE property_id = %d AND created_at >= %s",
            $property_id,
            $date
        ) );
    }

    public function get_recent_leads( $limit = 20 ) {
        global $wpdb;

        $results = $wpdb->get_results( $wpdb->prepare(
            "SELECT l.*, p.post_title as property_title
             FROM {$this->table_name} l
             LEFT JOIN {$wpdb->posts} p ON l.property_id = p.ID
             ORDER BY l.created_at DESC
             LIMIT %d",
            $limit
        ), ARRAY_A );

        return array_map( function( $row ) {
            return array(
                'id'                => absint( $row['id'] ),
                'property_id'      => absint( $row['property_id'] ),
                'property_title'   => ! empty( $row['property_title'] ) ? esc_html( $row['property_title'] ) : '',
                'lead_type'        => esc_html( $row['lead_type'] ),
                'lead_source'      => esc_html( $row['lead_source'] ),
                'converted'        => (bool) $row['converted'],
                'created_at'      => esc_html( $row['created_at'] ),
            );
        }, $results );
    }

    public function get_leads_by_date( $days = 30 ) {
        global $wpdb;

        $date = date( 'Y-m-d', strtotime( "-{$days} days" ) );

        $results = $wpdb->get_results( $wpdb->prepare(
            "SELECT DATE(created_at) as date, COUNT(*) as leads
             FROM {$this->table_name}
             WHERE created_at >= %s
             GROUP BY DATE(created_at)
             ORDER BY date ASC",
            $date
        ), ARRAY_A );

        return array_map( function( $row ) {
            return array(
                'date'  => esc_html( $row['date'] ),
                'leads' => absint( $row['leads'] ),
            );
        }, $results );
    }
}