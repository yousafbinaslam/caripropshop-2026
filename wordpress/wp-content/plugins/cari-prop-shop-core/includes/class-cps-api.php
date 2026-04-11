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

        register_rest_route('cps/v1', '/agents/(?P<id>\d+)', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_agent'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('cps/v1', '/testimonials', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_testimonials'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('cps/v1', '/inquiry', array(
            'methods' => 'POST',
            'callback' => array($this, 'submit_inquiry'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('cps/v1', '/search-alerts', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_search_alerts'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('cps/v1', '/search-alerts/(?P<id>\d+)', array(
            'methods' => 'DELETE',
            'callback' => array($this, 'delete_search_alert'),
            'permission_callback' => function() {
                return is_user_logged_in();
            },
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
                'key' => 'property_price',
                'value' => intval($min_price),
                'compare' => '>=',
                'type' => 'NUMERIC',
            );
        }

        if ($max_price = $request->get_param('max_price')) {
            $args['meta_query'][] = array(
                'key' => 'property_price',
                'value' => intval($max_price),
                'compare' => '<=',
                'type' => 'NUMERIC',
            );
        }

        // Filter by bedrooms
        if ($bedrooms = $request->get_param('bedrooms')) {
            $args['meta_query'][] = array(
                'key' => 'property_bedrooms',
                'value' => intval($bedrooms),
                'compare' => '>=',
                'type' => 'NUMERIC',
            );
        }

        // Filter by bathrooms
        if ($bathrooms = $request->get_param('bathrooms')) {
            $args['meta_query'][] = array(
                'key' => 'property_bathrooms',
                'value' => intval($bathrooms),
                'compare' => '>=',
                'type' => 'NUMERIC',
            );
        }

        // Filter by area
        if ($min_area = $request->get_param('min_area')) {
            $args['meta_query'][] = array(
                'key' => 'property_sqft',
                'value' => intval($min_area),
                'compare' => '>=',
                'type' => 'NUMERIC',
            );
        }

        if ($max_area = $request->get_param('max_area')) {
            $args['meta_query'][] = array(
                'key' => 'property_sqft',
                'value' => intval($max_area),
                'compare' => '<=',
                'type' => 'NUMERIC',
            );
        }

        // Filter by features
        if ($features = $request->get_param('features')) {
            if (!is_array($features)) {
                $features = explode(',', $features);
            }
            $args['tax_query'][] = array(
                'taxonomy' => 'property_feature',
                'field' => 'slug',
                'terms' => $features,
                'operator' => 'AND',
            );
        }

        // Filter by garage
        if ($garage = $request->get_param('garage')) {
            $args['meta_query'][] = array(
                'key' => 'property_garage',
                'value' => intval($garage),
                'compare' => '>=',
                'type' => 'NUMERIC',
            );
        }

        // Filter by year built
        if ($min_year = $request->get_param('min_year')) {
            $args['meta_query'][] = array(
                'key' => 'property_year',
                'value' => intval($min_year),
                'compare' => '>=',
                'type' => 'NUMERIC',
            );
        }

        // Filter by latitude/longitude for radius search
        if ($lat = $request->get_param('lat') && $lng = $request->get_param('lng') && $radius = $request->get_param('radius')) {
            add_filter('posts_join', function($join) {
                global $wpdb;
                return $join . " INNER JOIN {$wpdb->postmeta} mtlat ON {$wpdb->posts}.ID = mtlat.post_id AND mtlat.meta_key = 'property_latitude' INNER JOIN {$wpdb->postmeta} mtlng ON {$wpdb->posts}.ID = mtlng.post_id AND mtlng.meta_key = 'property_longitude'";
            });

            add_filter('posts_where', function($where) use ($lat, $lng, $radius) {
                global $wpdb;
                $radius = intval($radius);
                $where .= $wpdb->prepare(" AND (3956 * 2 * ASIN(SQRT(POWER(SIN((%s - mtlat.meta_value) * 0.017453292519943295 / 2), 2) + COS(%s * 0.017453292519943295 / 2) * COS(mtlat.meta_value * 0.017453292519943295 / 2) * POWER(SIN((%s - mtlng.meta_value) * 0.017453292519943295 / 2), 2)))) <= %d", $lat, $lat, $lng, $radius);
                return $where;
            });
        }

        // Sort by
        if ($orderby = $request->get_param('orderby')) {
            $order = $request->get_param('order') ?: 'DESC';
            if ($orderby === 'price') {
                $args['meta_key'] = 'property_price';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = $order;
            } elseif ($orderby === 'date') {
                $args['orderby'] = 'date';
                $args['order'] = $order;
            } elseif ($orderby === 'sqft') {
                $args['meta_key'] = 'property_sqft';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = $order;
            }
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
            $data[] = $this->prepare_agent_data($agent);
        }

        return new WP_REST_Response($data, 200);
    }

    /**
     * Get single agent
     */
    public function get_agent($request) {
        $agent = get_post($request->get_param('id'));

        if (!$agent || $agent->post_type !== 'agent') {
            return new WP_Error('not_found', __('Agent not found', 'cari-prop-shop'), array('status' => 404));
        }

        return new WP_REST_Response($this->prepare_agent_data($agent), 200);
    }

    /**
     * Get testimonials
     */
    public function get_testimonials($request) {
        $testimonials = get_posts(array(
            'post_type' => 'cps_testimonial',
            'posts_per_page' => $request->get_param('per_page') ?: 10,
            'orderby' => 'rand',
        ));

        $data = array();
        foreach ($testimonials as $testimonial) {
            $data[] = array(
                'id' => $testimonial->ID,
                'content' => $testimonial->post_content,
                'author' => $testimonial->post_title,
                'photo' => get_the_post_thumbnail_url($testimonial->ID, 'thumbnail'),
                'role' => get_post_meta($testimonial->ID, 'cps_testimonial_role', true),
                'company' => get_post_meta($testimonial->ID, 'cps_testimonial_company', true),
                'rating' => get_post_meta($testimonial->ID, 'cps_testimonial_rating', true),
            );
        }

        return new WP_REST_Response($data, 200);
    }

    /**
     * Get search alerts for current user
     */
    public function get_search_alerts($request) {
        if (!is_user_logged_in()) {
            return new WP_Error('unauthorized', __('Please login to view search alerts', 'cari-prop-shop'), array('status' => 401));
        }

        $alerts = get_posts(array(
            'post_type' => 'cps_search_alert',
            'posts_per_page' => -1,
            'author' => get_current_user_id(),
            'post_status' => 'publish',
        ));

        $data = array();
        foreach ($alerts as $alert) {
            $data[] = array(
                'id' => $alert->ID,
                'name' => $alert->post_title,
                'filters' => json_decode(get_post_meta($alert->ID, 'cps_alert_filters', true), true),
                'frequency' => get_post_meta($alert->ID, 'cps_alert_frequency', true),
                'last_sent' => get_post_meta($alert->ID, 'cps_alert_last_sent', true),
                'created' => $alert->post_date,
            );
        }

        return new WP_REST_Response($data, 200);
    }

    /**
     * Delete search alert
     */
    public function delete_search_alert($request) {
        if (!is_user_logged_in()) {
            return new WP_Error('unauthorized', __('Please login', 'cari-prop-shop'), array('status' => 401));
        }

        $alert = get_post($request->get_param('id'));
        if (!$alert || $alert->post_author != get_current_user_id()) {
            return new WP_Error('not_found', __('Alert not found', 'cari-prop-shop'), array('status' => 404));
        }

        wp_delete_post($alert->ID, true);

        return new WP_REST_Response(array('success' => true), 200);
    }

    /**
     * Prepare agent data
     */
    private function prepare_agent_data($agent) {
        return array(
            'id' => $agent->ID,
            'name' => $agent->post_title,
            'description' => $agent->post_content,
            'photo' => get_the_post_thumbnail_url($agent->ID, 'medium'),
            'email' => get_post_meta($agent->ID, 'cps_agent_email', true),
            'phone' => get_post_meta($agent->ID, 'cps_agent_phone', true),
            'mobile' => get_post_meta($agent->ID, 'cps_agent_mobile', true),
            'whatsapp' => get_post_meta($agent->ID, 'cps_agent_whatsapp', true),
            'position' => get_post_meta($agent->ID, 'cps_agent_position', true),
            'license' => get_post_meta($agent->ID, 'cps_agent_license', true),
            'experience' => get_post_meta($agent->ID, 'cps_agent_experience', true),
            'specialties' => get_post_meta($agent->ID, 'cps_agent_specialties', true),
            'facebook' => get_post_meta($agent->ID, 'cps_agent_facebook', true),
            'twitter' => get_post_meta($agent->ID, 'cps_agent_twitter', true),
            'linkedin' => get_post_meta($agent->ID, 'cps_agent_linkedin', true),
            'instagram' => get_post_meta($agent->ID, 'cps_agent_instagram', true),
            'youtube' => get_post_meta($agent->ID, 'cps_agent_youtube', true),
            'tiktok' => get_post_meta($agent->ID, 'cps_agent_tiktok', true),
            'url' => get_permalink($agent->ID),
        );
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
        $status_terms = get_the_terms($post->ID, 'property_status');
        $features = get_the_terms($post->ID, 'property_feature');

        $status_slug = '';
        $status_name = '';
        if ($status_terms && !is_wp_error($status_terms)) {
            $status_slug = $status_terms[0]->slug;
            $status_name = $status_terms[0]->name;
        }

        return array(
            'id' => $post->ID,
            'title' => $post->post_title,
            'slug' => $post->post_name,
            'content' => $post->post_content,
            'excerpt' => $post->post_excerpt,
            'featured_image' => get_the_post_thumbnail_url($post->ID, 'large'),
            'thumbnail' => get_the_post_thumbnail_url($post->ID, 'medium'),
            'image' => get_the_post_thumbnail_url($post->ID, 'medium'),
            'price' => get_post_meta($post->ID, 'property_price', true),
            'price_label' => get_post_meta($post->ID, 'property_price_label', true),
            'area' => get_post_meta($post->ID, 'property_sqft', true),
            'sqft' => get_post_meta($post->ID, 'property_sqft', true),
            'land_area' => get_post_meta($post->ID, 'property_land_area', true),
            'bedrooms' => get_post_meta($post->ID, 'property_bedrooms', true),
            'bathrooms' => get_post_meta($post->ID, 'property_bathrooms', true),
            'garage' => get_post_meta($post->ID, 'property_garage', true),
            'garages' => get_post_meta($post->ID, 'property_garage', true),
            'year_built' => get_post_meta($post->ID, 'property_year', true),
            'year' => get_post_meta($post->ID, 'property_year', true),
            'property_id' => get_post_meta($post->ID, 'property_listing_id', true),
            'listing_id' => get_post_meta($post->ID, 'property_listing_id', true),
            'address' => get_post_meta($post->ID, 'property_address', true),
            'city' => get_post_meta($post->ID, 'property_city', true),
            'state' => get_post_meta($post->ID, 'property_state', true),
            'zip' => get_post_meta($post->ID, 'property_zip', true),
            'country' => get_post_meta($post->ID, 'property_country', true),
            'lat' => get_post_meta($post->ID, 'property_latitude', true),
            'lng' => get_post_meta($post->ID, 'property_longitude', true),
            'latitude' => get_post_meta($post->ID, 'property_latitude', true),
            'longitude' => get_post_meta($post->ID, 'property_longitude', true),
            'status' => $status_slug,
            'status_label' => $status_name,
            'types' => $types ? array_map(function($t) { return array('id' => $t->term_id, 'name' => $t->name, 'slug' => $t->slug); }, $types) : array(),
            'features' => $features ? array_map(function($f) { return array('id' => $f->term_id, 'name' => $f->name, 'slug' => $f->slug); }, $features) : array(),
            'date' => get_the_date('Y-m-d H:i:s', $post),
            'url' => get_permalink($post->ID),
            'permalink' => get_permalink($post->ID),
        );
    }
}

// Initialize API
new CPS_API();
