<?php
/**
 * REST API Class
 * 
 * Handles REST API endpoints for properties
 *
 * @package CariPropShop
 */

if (!defined('ABSPATH')) {
    exit;
}

class CPS_API {

    /**
     * Constructor
     */
    public function __construct() {
        add_action('rest_api_init', array($this, 'register_routes'));
    }

    /**
     * Register REST API routes
     */
    public function register_routes() {
        register_rest_route('cps/v1', '/properties', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_properties'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('cps/v1', '/properties/(?P<id>\d+)', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_property'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('cps/v1', '/property-types', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_property_types'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('cps/v1', '/agents', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_agents'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('cps/v1', '/inquiry', array(
            'methods' => 'POST',
            'callback' => array($this, 'submit_inquiry'),
            'permission_callback' => '__return_true',
        ));
    }

    /**
     * Get properties
     */
    public function get_properties($request) {
        $args = array(
            'post_type' => 'property',
            'posts_per_page' => $request->get_param('per_page') ?: 10,
            'paged' => $request->get_param('page') ?: 1,
        );

        // Filter by type
        if ($type = $request->get_param('type')) {
            $args['tax_query'][] = array(
                'taxonomy' => 'property_type',
                'field' => 'slug',
                'terms' => sanitize_text_field($type),
            );
        }

        // Filter by status
        if ($status = $request->get_param('status')) {
            $args['tax_query'][] = array(
                'taxonomy' => 'property_status',
                'field' => 'slug',
                'terms' => sanitize_text_field($status),
            );
        }

        // Filter by location
        if ($location = $request->get_param('location')) {
            $args['tax_query'][] = array(
                'taxonomy' => 'property_location',
                'field' => 'slug',
                'terms' => sanitize_text_field($location),
            );
        }

        // Filter by price range
        if ($min_price = $request->get_param('min_price')) {
            $args['meta_query'][] = array(
                'key' => 'cps_price',
                'value' => intval($min_price),
                'compare' => '>=',
                'type' => 'NUMERIC',
            );
        }

        if ($max_price = $request->get_param('max_price')) {
            $args['meta_query'][] = array(
                'key' => 'cps_price',
                'value' => intval($max_price),
                'compare' => '<=',
                'type' => 'NUMERIC',
            );
        }

        // Filter by bedrooms
        if ($bedrooms = $request->get_param('bedrooms')) {
            $args['meta_query'][] = array(
                'key' => 'cps_bedrooms',
                'value' => intval($bedrooms),
                'compare' => '>=',
                'type' => 'NUMERIC',
            );
        }

        // Search
        if ($search = $request->get_param('search')) {
            $args['s'] = sanitize_text_field($search);
        }

        $query = new WP_Query($args);
        $properties = array();

        foreach ($query->posts as $post) {
            $properties[] = $this->prepare_property_data($post);
        }

        return new WP_REST_Response(array(
            'properties' => $properties,
            'total' => $query->found_posts,
            'pages' => $query->max_num_pages,
        ), 200);
    }

    /**
     * Get single property
     */
    public function get_property($request) {
        $post = get_post($request->get_param('id'));

        if (!$post || $post->post_type !== 'property') {
            return new WP_Error('not_found', __('Property not found', 'cari-prop-shop'), array('status' => 404));
        }

        return new WP_REST_Response($this->prepare_property_data($post), 200);
    }

    /**
     * Get property types
     */
    public function get_property_types($request) {
        $types = get_terms(array(
            'taxonomy' => 'property_type',
            'hide_empty' => true,
        ));

        $data = array();
        foreach ($types as $type) {
            $data[] = array(
                'id' => $type->term_id,
                'name' => $type->name,
                'slug' => $type->slug,
                'count' => $type->count,
            );
        }

        return new WP_REST_Response($data, 200);
    }

    /**
     * Get agents
     */
    public function get_agents($request) {
        $agents = get_posts(array(
            'post_type' => 'agent',
            'posts_per_page' => $request->get_param('per_page') ?: 10,
        ));

        $data = array();
        foreach ($agents as $agent) {
            $data[] = array(
                'id' => $agent->ID,
                'name' => $agent->post_title,
                'description' => $agent->post_content,
                'photo' => get_the_post_thumbnail_url($agent->ID, 'medium'),
                'email' => get_post_meta($agent->ID, 'cps_agent_email', true),
                'phone' => get_post_meta($agent->ID, 'cps_agent_phone', true),
            );
        }

        return new WP_REST_Response($data, 200);
    }

    /**
     * Submit inquiry
     */
    public function submit_inquiry($request) {
        $data = $request->get_json_params();

        // Validate required fields
        $required = array('name', 'email', 'phone', 'message');
        foreach ($required as $field) {
            if (empty($data[$field])) {
                return new WP_Error('missing_field', sprintf(__('%s is required', 'cari-prop-shop'), $field), array('status' => 400));
            }
        }

        // Create inquiry post
        $inquiry_id = wp_insert_post(array(
            'post_type' => 'cps_inquiry',
            'post_title' => sprintf(__('Inquiry from %s', 'cari-prop-shop'), sanitize_text_field($data['name'])),
            'post_content' => sanitize_textarea_field($data['message']),
            'post_status' => 'publish',
            'meta_input' => array(
                'cps_inquiry_name' => sanitize_text_field($data['name']),
                'cps_inquiry_email' => sanitize_email($data['email']),
                'cps_inquiry_phone' => sanitize_text_field($data['phone']),
                'cps_inquiry_type' => isset($data['inquiry_type']) ? sanitize_text_field($data['inquiry_type']) : '',
                'cps_inquiry_property' => isset($data['property_id']) ? intval($data['property_id']) : 0,
            ),
        ));

        if (is_wp_error($inquiry_id)) {
            return new WP_Error('create_failed', __('Failed to create inquiry', 'cari-prop-shop'), array('status' => 500));
        }

        return new WP_REST_Response(array(
            'success' => true,
            'message' => __('Inquiry submitted successfully', 'cari-prop-shop'),
            'inquiry_id' => $inquiry_id,
        ), 200);
    }

    /**
     * Prepare property data for REST response
     */
    private function prepare_property_data($post) {
        $types = get_the_terms($post->ID, 'property_type');
        $status = get_the_terms($post->ID, 'property_status');
        $features = get_the_terms($post->ID, 'property_feature');

        return array(
            'id' => $post->ID,
            'title' => $post->post_title,
            'slug' => $post->post_name,
            'content' => $post->post_content,
            'excerpt' => $post->post_excerpt,
            'featured_image' => get_the_post_thumbnail_url($post->ID, 'large'),
            'thumbnail' => get_the_post_thumbnail_url($post->ID, 'medium'),
            'price' => get_post_meta($post->ID, 'cps_price', true),
            'price_label' => get_post_meta($post->ID, 'cps_price_label', true),
            'area' => get_post_meta($post->ID, 'cps_area', true),
            'land_area' => get_post_meta($post->ID, 'cps_land_area', true),
            'bedrooms' => get_post_meta($post->ID, 'cps_bedrooms', true),
            'bathrooms' => get_post_meta($post->ID, 'cps_bathrooms', true),
            'garages' => get_post_meta($post->ID, 'cps_garages', true),
            'year_built' => get_post_meta($post->ID, 'cps_year_built', true),
            'property_id' => get_post_meta($post->ID, 'cps_property_id', true),
            'address' => get_post_meta($post->ID, 'cps_address', true),
            'city' => get_post_meta($post->ID, 'cps_city', true),
            'state' => get_post_meta($post->ID, 'cps_state', true),
            'zip' => get_post_meta($post->ID, 'cps_zip', true),
            'country' => get_post_meta($post->ID, 'cps_country', true),
            'latitude' => get_post_meta($post->ID, 'cps_latitude', true),
            'longitude' => get_post_meta($post->ID, 'cps_longitude', true),
            'types' => $types ? array_map(function($t) { return array('id' => $t->term_id, 'name' => $t->name, 'slug' => $t->slug); }, $types) : array(),
            'status' => $status ? array_map(function($s) { return array('id' => $s->term_id, 'name' => $s->name, 'slug' => $s->slug); }, $status) : array(),
            'features' => $features ? array_map(function($f) { return array('id' => $f->term_id, 'name' => $f->name, 'slug' => $f->slug); }, $features) : array(),
            'date' => get_the_date('Y-m-d H:i:s', $post),
            'url' => get_permalink($post->ID),
        );
    }
}

// Initialize API
new CPS_API();
