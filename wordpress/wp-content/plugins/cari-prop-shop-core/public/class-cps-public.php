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
