<?php
/**
 * Public Class
 * 
 * Handles public-facing functionality
 *
 * @package CariPropShop
 */

if (!defined('ABSPATH')) {
    exit;
}

class CPS_Public {

    /**
     * Constructor
     */
    public function __construct() {
        add_action('wp_head', array($this, 'output_schema_markup'));
        add_filter('excerpt_length', array($this, 'excerpt_length'));
        add_filter('excerpt_more', array($this, 'excerpt_more'));
        
        add_action('wp_ajax_cps_get_properties', array($this, 'ajax_get_properties'));
        add_action('wp_ajax_nopriv_cps_get_properties', array($this, 'ajax_get_properties'));

        add_action('wp_ajax_cps_subscribe_search_alert', array($this, 'ajax_subscribe_search_alert'));
        add_action('wp_ajax_nopriv_cps_subscribe_search_alert', array($this, 'ajax_subscribe_search_alert'));

        add_action('wp_ajax_cps_save_search', array($this, 'ajax_save_search'));
        add_action('wp_ajax_cps_get_saved_searches', array($this, 'ajax_get_saved_searches'));
        add_action('wp_ajax_cps_delete_saved_search', array($this, 'ajax_delete_saved_search'));

        add_action('wp_ajax_cps_add_favorite', array($this, 'ajax_add_favorite'));
        add_action('wp_ajax_nopriv_cps_add_favorite', array($this, 'ajax_add_favorite'));
        add_action('wp_ajax_cps_remove_favorite', array($this, 'ajax_remove_favorite'));

        add_action('wp_ajax_cps_compare_add', array($this, 'ajax_compare_add'));
        add_action('wp_ajax_nopriv_cps_compare_add', array($this, 'ajax_compare_add'));
        add_action('wp_ajax_cps_compare_remove', array($this, 'ajax_compare_remove'));
        add_action('wp_ajax_cps_compare_clear', array($this, 'ajax_compare_clear'));
        add_action('wp_ajax_cps_get_compare', array($this, 'ajax_get_compare'));
    }

    /**
     * AJAX: Get properties for half map
     */
    public function ajax_get_properties() {
        check_ajax_referer('cps_nonce', 'nonce');

        $args = array(
            'post_type' => 'property',
            'posts_per_page' => 50,
        );

        if (!empty($_GET['search'])) {
            $args['s'] = sanitize_text_field($_GET['search']);
        }

        if (!empty($_GET['type'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'property_type',
                'field' => 'slug',
                'terms' => sanitize_text_field($_GET['type']),
            );
        }

        if (!empty($_GET['location'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'property_location',
                'field' => 'slug',
                'terms' => sanitize_text_field($_GET['location']),
            );
        }

        if (!empty($_GET['status'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'property_status',
                'field' => 'slug',
                'terms' => sanitize_text_field($_GET['status']),
            );
        }

        if (!empty($_GET['min_price'])) {
            $args['meta_query'][] = array(
                'key' => 'cps_price',
                'value' => intval($_GET['min_price']),
                'compare' => '>=',
                'type' => 'NUMERIC',
            );
        }

        if (!empty($_GET['max_price'])) {
            $args['meta_query'][] = array(
                'key' => 'cps_price',
                'value' => intval($_GET['max_price']),
                'compare' => '<=',
                'type' => 'NUMERIC',
            );
        }

        if (!empty($_GET['bedrooms'])) {
            $args['meta_query'][] = array(
                'key' => 'cps_bedrooms',
                'value' => intval($_GET['bedrooms']),
                'compare' => '>=',
                'type' => 'NUMERIC',
            );
        }

        $query = new WP_Query($args);
        $properties = array();

        foreach ($query->posts as $post) {
            $properties[] = array(
                'id' => $post->ID,
                'title' => $post->post_title,
                'price' => get_post_meta($post->ID, 'cps_price', true),
                'price_numeric' => get_post_meta($post->ID, 'cps_price', true),
                'address' => get_post_meta($post->ID, 'cps_address', true),
                'bedrooms' => get_post_meta($post->ID, 'cps_bedrooms', true),
                'bathrooms' => get_post_meta($post->ID, 'cps_bathrooms', true),
                'sqft' => get_post_meta($post->ID, 'cps_sqft', true),
                'lat' => get_post_meta($post->ID, 'cps_latitude', true),
                'lng' => get_post_meta($post->ID, 'cps_longitude', true),
                'image' => get_the_post_thumbnail_url($post->ID, 'medium'),
                'permalink' => get_permalink($post->ID),
                'status' => $this->get_property_status_slug($post->ID),
                'status_label' => $this->get_property_status_name($post->ID),
            );
        }

        wp_send_json($properties);
    }

    private function get_property_status_slug($post_id) {
        $status = get_the_terms($post_id, 'property_status');
        return $status && !is_wp_error($status) ? $status[0]->slug : '';
    }

    private function get_property_status_name($post_id) {
        $status = get_the_terms($post_id, 'property_status');
        return $status && !is_wp_error($status) ? $status[0]->name : '';
    }

    /**
     * AJAX: Subscribe to search alert
     */
    public function ajax_subscribe_search_alert() {
        check_ajax_referer('cps_nonce', 'nonce');

        $search_name = sanitize_text_field($_POST['search_name']);
        $search_filters = stripslashes($_POST['search_filters']);

        if (is_user_logged_in()) {
            $post_id = wp_insert_post(array(
                'post_type' => 'cps_search_alert',
                'post_title' => $search_name,
                'post_status' => 'publish',
                'post_author' => get_current_user_id(),
                'meta_input' => array(
                    'cps_alert_filters' => $search_filters,
                    'cps_alert_frequency' => 'daily',
                    'cps_alert_active' => 1,
                ),
            ));

            wp_send_json_success(array('message' => 'Search alert created', 'alert_id' => $post_id));
        } else {
            $email = sanitize_email($_POST['email']);
            if (!$email) {
                $email = $_POST['guest_email'];
            }

            if ($email) {
                $guest_alerts = get_option('cps_guest_alerts', array());
                $guest_alerts[$email][] = array(
                    'name' => $search_name,
                    'filters' => $search_filters,
                    'created' => current_time('mysql'),
                );
                update_option('cps_guest_alerts', $guest_alerts);
                wp_send_json_success(array('message' => 'Alert subscribed'));
            } else {
                wp_send_json_error(array('message' => 'Email required for guest alerts'));
            }
        }
    }

    /**
     * AJAX: Save search for logged in user
     */
    public function ajax_save_search() {
        check_ajax_referer('cps_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(array('message' => 'Please login to save searches'));
        }

        $search_name = sanitize_text_field($_POST['search_name']);
        $search_filters = stripslashes($_POST['search_filters']);

        $post_id = wp_insert_post(array(
            'post_type' => 'cps_saved_search',
            'post_title' => $search_name,
            'post_status' => 'publish',
            'post_author' => get_current_user_id(),
            'meta_input' => array(
                'cps_search_filters' => $search_filters,
            ),
        ));

        wp_send_json_success(array('message' => 'Search saved', 'search_id' => $post_id));
    }

    /**
     * AJAX: Get saved searches
     */
    public function ajax_get_saved_searches() {
        check_ajax_referer('cps_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(array('message' => 'Please login'));
        }

        $searches = get_posts(array(
            'post_type' => 'cps_saved_search',
            'author' => get_current_user_id(),
            'posts_per_page' => 20,
        ));

        $data = array();
        foreach ($searches as $search) {
            $data[] = array(
                'id' => $search->ID,
                'name' => $search->post_title,
                'filters' => get_post_meta($search->ID, 'cps_search_filters', true),
                'date' => $search->post_date,
            );
        }

        wp_send_json_success($data);
    }

    /**
     * AJAX: Delete saved search
     */
    public function ajax_delete_saved_search() {
        check_ajax_referer('cps_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(array('message' => 'Please login'));
        }

        $search_id = intval($_POST['search_id']);
        $search = get_post($search_id);

        if ($search && $search->post_author == get_current_user_id()) {
            wp_delete_post($search_id, true);
            wp_send_json_success(array('message' => 'Search deleted'));
        } else {
            wp_send_json_error(array('message' => 'Search not found'));
        }
    }

    /**
     * AJAX: Add to favorites
     */
    public function ajax_add_favorite() {
        check_ajax_referer('cps_nonce', 'nonce');

        $property_id = intval($_POST['property_id']);

        if (!is_user_logged_in()) {
            $favorites = isset($_COOKIE['cps_favorites']) ? json_decode($_COOKIE['cps_favorites'], true) : array();
            if (!in_array($property_id, $favorites)) {
                $favorites[] = $property_id;
            }
            setcookie('cps_favorites', json_encode($favorites), time() + (86400 * 30), '/');
            wp_send_json_success(array('message' => 'Added to favorites', 'count' => count($favorites)));
        } else {
            $user_favorites = get_user_meta(get_current_user_id(), 'cps_favorites', true) ?: array();
            if (!in_array($property_id, $user_favorites)) {
                $user_favorites[] = $property_id;
                update_user_meta(get_current_user_id(), 'cps_favorites', $user_favorites);
            }
            wp_send_json_success(array('message' => 'Added to favorites', 'count' => count($user_favorites)));
        }
    }

    /**
     * AJAX: Remove from favorites
     */
    public function ajax_remove_favorite() {
        check_ajax_referer('cps_nonce', 'nonce');

        $property_id = intval($_POST['property_id']);

        if (!is_user_logged_in()) {
            $favorites = isset($_COOKIE['cps_favorites']) ? json_decode($_COOKIE['cps_favorites'], true) : array();
            $favorites = array_diff($favorites, array($property_id));
            setcookie('cps_favorites', json_encode(array_values($favorites)), time() + (86400 * 30), '/');
            wp_send_json_success(array('message' => 'Removed from favorites', 'count' => count($favorites)));
        } else {
            $user_favorites = get_user_meta(get_current_user_id(), 'cps_favorites', true) ?: array();
            $user_favorites = array_diff($user_favorites, array($property_id));
            update_user_meta(get_current_user_id(), 'cps_favorites', array_values($user_favorites));
            wp_send_json_success(array('message' => 'Removed from favorites', 'count' => count($user_favorites)));
        }
    }

    /**
     * AJAX: Add to compare
     */
    public function ajax_compare_add() {
        check_ajax_referer('cps_nonce', 'nonce');

        $property_id = intval($_POST['property_id']);
        $compare = isset($_COOKIE['cps_compare']) ? json_decode($_COOKIE['cps_compare'], true) : array();

        if (count($compare) >= 4) {
            wp_send_json_error(array('message' => 'Maximum 4 properties can be compared'));
        }

        if (!in_array($property_id, $compare)) {
            $compare[] = $property_id;
            setcookie('cps_compare', json_encode($compare), time() + (86400 * 7), '/');
        }

        wp_send_json_success(array('message' => 'Added to compare', 'count' => count($compare)));
    }

    /**
     * AJAX: Remove from compare
     */
    public function ajax_compare_remove() {
        check_ajax_referer('cps_nonce', 'nonce');

        $property_id = intval($_POST['property_id']);
        $compare = isset($_COOKIE['cps_compare']) ? json_decode($_COOKIE['cps_compare'], true) : array();
        $compare = array_diff($compare, array($property_id));
        setcookie('cps_compare', json_encode(array_values($compare)), time() + (86400 * 7), '/');

        wp_send_json_success(array('message' => 'Removed from compare', 'count' => count($compare)));
    }

    /**
     * AJAX: Clear compare
     */
    public function ajax_compare_clear() {
        check_ajax_referer('cps_nonce', 'nonce');
        setcookie('cps_compare', json_encode(array()), time() + (86400 * 7), '/');
        wp_send_json_success(array('message' => 'Compare cleared'));
    }

    /**
     * AJAX: Get compare items
     */
    public function ajax_get_compare() {
        $compare = isset($_COOKIE['cps_compare']) ? json_decode($_COOKIE['cps_compare'], true) : array();

        $properties = array();
        foreach ($compare as $id) {
            $post = get_post($id);
            if ($post) {
                $properties[] = array(
                    'id' => $post->ID,
                    'title' => $post->post_title,
                    'price' => get_post_meta($post->ID, 'cps_price', true),
                    'image' => get_the_post_thumbnail_url($post->ID, 'medium'),
                    'permalink' => get_permalink($post->ID),
                    'bedrooms' => get_post_meta($post->ID, 'cps_bedrooms', true),
                    'bathrooms' => get_post_meta($post->ID, 'cps_bathrooms', true),
                    'sqft' => get_post_meta($post->ID, 'cps_sqft', true),
                    'address' => get_post_meta($post->ID, 'cps_address', true),
                );
            }
        }

        wp_send_json_success($properties);
    }

    /**
     * Output schema markup for properties
     */
    public function output_schema_markup() {
        if (!is_singular('property')) {
            return;
        }

        global $post;
        $price = get_post_meta($post->ID, 'cps_price', true);
        $address = get_post_meta($post->ID, 'cps_address', true);
        $city = get_post_meta($post->ID, 'cps_city', true);
        $latitude = get_post_meta($post->ID, 'cps_latitude', true);
        $longitude = get_post_meta($post->ID, 'cps_longitude', true);

        if (!$price) {
            return;
        }

        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'RealEstateListing',
            'name' => get_the_title($post->ID),
            'description' => get_the_excerpt($post->ID),
            'url' => get_permalink($post->ID),
            'image' => get_the_post_thumbnail_url($post->ID, 'large'),
        );

        if ($address || $city) {
            $schema['address'] = array(
                '@type' => 'PostalAddress',
                'streetAddress' => $address,
                'addressLocality' => $city,
            );
        }

        if ($latitude && $longitude) {
            $schema['geo'] = array(
                '@type' => 'GeoCoordinates',
                'latitude' => $latitude,
                'longitude' => $longitude,
            );
        }

        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
    }

    /**
     * Custom excerpt length
     */
    public function excerpt_length($length) {
        return 25;
    }

    /**
     * Custom excerpt more
     */
    public function excerpt_more($more) {
        return '...';
    }
}

// Initialize public
new CPS_Public();
