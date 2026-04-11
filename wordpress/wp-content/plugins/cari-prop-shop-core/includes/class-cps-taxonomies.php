<?php
/**
 * Taxonomies Class
 * 
 * Handles custom taxonomy registration for properties
 *
 * @package CariPropShop
 */

if (!defined('ABSPATH')) {
    exit;
}

class CPS_Taxonomies {

    /**
     * Register taxonomies
     */
    public function register_taxonomies() {
        $this->register_property_type_taxonomy();
        $this->register_property_status_taxonomy();
        $this->register_property_location_taxonomy();
        $this->register_property_feature_taxonomy();
        $this->register_property_currency_taxonomy();
    }

    /**
     * Register Property Type taxonomy
     */
    private function register_property_type_taxonomy() {
        $labels = array(
            'name'                       => _x('Property Types', 'Taxonomy General Name', 'cari-prop-shop'),
            'singular_name'              => _x('Property Type', 'Taxonomy Singular Name', 'cari-prop-shop'),
            'menu_name'                  => __('Property Types', 'cari-prop-shop'),
            'all_items'                  => __('All Property Types', 'cari-prop-shop'),
            'parent_item'                => __('Parent Property Type', 'cari-prop-shop'),
            'parent_item_colon'          => __('Parent Property Type:', 'cari-prop-shop'),
            'new_item_name'              => __('New Property Type Name', 'cari-prop-shop'),
            'add_new_item'               => __('Add New Property Type', 'cari-prop-shop'),
            'new_item'                   => __('New Property Type', 'cari-prop-shop'),
            'edit_item'                  => __('Edit Property Type', 'cari-prop-shop'),
            'update_item'                => __('Update Property Type', 'cari-prop-shop'),
            'view_item'                  => __('View Property Type', 'cari-prop-shop'),
            'separate_items_with_commas' => __('Separate property types with commas', 'cari-prop-shop'),
            'add_or_remove_items'        => __('Add or remove property types', 'cari-prop-shop'),
            'choose_from_most_used'       => __('Choose from the most used', 'cari-prop-shop'),
            'popular_items'              => __('Popular Property Types', 'cari-prop-shop'),
            'search_items'               => __('Search Property Types', 'cari-prop-shop'),
            'not_found'                  => __('Not Found', 'cari-prop-shop'),
            'no_terms'                   => __('No property types', 'cari-prop-shop'),
            'items_list'                 => __('Property Types list', 'cari-prop-shop'),
            'items_list_navigation'       => __('Property Types list navigation', 'cari-prop-shop'),
        );
        
        $args = array(
            'labels'             => $labels,
            'hierarchical'       => true,
            'public'             => true,
            'show_ui'            => true,
            'show_admin_column'  => true,
            'show_in_nav_menus'  => true,
            'show_tagcloud'       => true,
            'show_in_rest'       => true,
            'query_var'          => true,
            'rewrite'            => array(
                'slug'         => 'property-type',
                'with_front'   => true,
                'hierarchical' => true,
            ),
        );
        
        register_taxonomy('property_type', array('property'), $args);
        
        // Register default property types (11 types from Houzez)
        $default_types = array(
            'studio' => 'Studio',
            'apartment' => 'Apartment',
            'single-family-home' => 'Single Family Home',
            'shop' => 'Shop',
            'office' => 'Office',
            'villa' => 'Villa',
            'condo' => 'Condo',
            'lot' => 'Lot',
            'multi-family-home' => 'Multi Family Home',
            'commercial' => 'Commercial',
            'residential' => 'Residential',
        );
        
        foreach ($default_types as $slug => $name) {
            if (!term_exists($name, 'property_type')) {
                wp_insert_term($name, 'property_type', array('slug' => $slug));
            }
        }
    }

    /**
     * Register Property Status taxonomy
     */
    private function register_property_status_taxonomy() {
        $labels = array(
            'name'                       => _x('Property Status', 'Taxonomy General Name', 'cari-prop-shop'),
            'singular_name'              => _x('Status', 'Taxonomy Singular Name', 'cari-prop-shop'),
            'menu_name'                  => __('Property Status', 'cari-prop-shop'),
            'all_items'                  => __('All Status', 'cari-prop-shop'),
            'parent_item'                => __('Parent Status', 'cari-prop-shop'),
            'parent_item_colon'          => __('Parent Status:', 'cari-prop-shop'),
            'new_item_name'              => __('New Status Name', 'cari-prop-shop'),
            'add_new_item'               => __('Add New Status', 'cari-prop-shop'),
            'new_item'                   => __('New Status', 'cari-prop-shop'),
            'edit_item'                  => __('Edit Status', 'cari-prop-shop'),
            'update_item'                => __('Update Status', 'cari-prop-shop'),
            'view_item'                  => __('View Status', 'cari-prop-shop'),
            'separate_items_with_commas' => __('Separate status with commas', 'cari-prop-shop'),
            'add_or_remove_items'        => __('Add or remove status', 'cari-prop-shop'),
            'choose_from_most_used'       => __('Choose from the most used', 'cari-prop-shop'),
            'popular_items'              => __('Popular Status', 'cari-prop-shop'),
            'search_items'               => __('Search Status', 'cari-prop-shop'),
            'not_found'                  => __('Not Found', 'cari-prop-shop'),
            'no_terms'                   => __('No status', 'cari-prop-shop'),
            'items_list'                 => __('Status list', 'cari-prop-shop'),
            'items_list_navigation'       => __('Status list navigation', 'cari-prop-shop'),
        );
        
        $args = array(
            'labels'             => $labels,
            'hierarchical'       => true,
            'public'             => true,
            'show_ui'            => true,
            'show_admin_column'  => true,
            'show_in_nav_menus'  => true,
            'show_tagcloud'       => true,
            'show_in_rest'       => true,
            'query_var'          => true,
            'rewrite'            => array(
                'slug'         => 'property-status',
                'with_front'   => true,
                'hierarchical' => true,
            ),
        );
        
        register_taxonomy('property_status', array('property'), $args);
        
        // Register default status (from Houzez)
        $default_status = array(
            'for-sale' => 'For Sale',
            'for-rent' => 'For Rent',
            'foreclosures' => 'Foreclosures',
            'new-construction' => 'New Construction',
            'new-listing' => 'New Listing',
            'open-house' => 'Open House',
            'reduced-price' => 'Reduced Price',
            'resale' => 'Resale',
            'sold' => 'Sold',
            'leased' => 'Leased',
            'pending' => 'Pending',
            'featured' => 'Featured',
        );
        
        foreach ($default_status as $slug => $name) {
            if (!term_exists($name, 'property_status')) {
                wp_insert_term($name, 'property_status', array('slug' => $slug));
            }
        }
    }

    /**
     * Register Property Location taxonomy (Indonesian Cities)
     */
    private function register_property_location_taxonomy() {
        $labels = array(
            'name'                       => _x('Locations', 'Taxonomy General Name', 'cari-prop-shop'),
            'singular_name'              => _x('Location', 'Taxonomy Singular Name', 'cari-prop-shop'),
            'menu_name'                  => __('Locations', 'cari-prop-shop'),
            'all_items'                  => __('All Locations', 'cari-prop-shop'),
            'parent_item'                => __('Parent Location', 'cari-prop-shop'),
            'parent_item_colon'          => __('Parent Location:', 'cari-prop-shop'),
            'new_item_name'              => __('New Location Name', 'cari-prop-shop'),
            'add_new_item'               => __('Add New Location', 'cari-prop-shop'),
            'new_item'                   => __('New Location', 'cari-prop-shop'),
            'edit_item'                  => __('Edit Location', 'cari-prop-shop'),
            'update_item'                => __('Update Location', 'cari-prop-shop'),
            'view_item'                  => __('View Location', 'cari-prop-shop'),
            'separate_items_with_commas' => __('Separate locations with commas', 'cari-prop-shop'),
            'add_or_remove_items'        => __('Add or remove locations', 'cari-prop-shop'),
            'choose_from_most_used'       => __('Choose from the most used', 'cari-prop-shop'),
            'popular_items'              => __('Popular Locations', 'cari-prop-shop'),
            'search_items'               => __('Search Locations', 'cari-prop-shop'),
            'not_found'                  => __('Not Found', 'cari-prop-shop'),
            'no_terms'                   => __('No locations', 'cari-prop-shop'),
            'items_list'                 => __('Locations list', 'cari-prop-shop'),
            'items_list_navigation'       => __('Locations list navigation', 'cari-prop-shop'),
        );
        
        $args = array(
            'labels'             => $labels,
            'hierarchical'       => true,
            'public'             => true,
            'show_ui'            => true,
            'show_admin_column'  => true,
            'show_in_nav_menus'  => true,
            'show_tagcloud'       => true,
            'show_in_rest'       => true,
            'query_var'          => true,
            'rewrite'            => array(
                'slug'         => 'location',
                'with_front'   => true,
                'hierarchical' => true,
            ),
        );
        
        register_taxonomy('property_location', array('property'), $args);
        
        // Register default locations (Indonesian cities from Houzez)
        $default_locations = array(
            'aceh' => 'Aceh',
            'bali' => 'Bali',
            'bangka-belitung' => 'Bangka Belitung Islands',
            'bengkulu' => 'Bengkulu',
            'jambi' => 'Jambi',
            'north-sumatra' => 'North Sumatra',
            'riau' => 'Riau',
            'riau-islands' => 'Riau Islands',
            'south-sumatra' => 'South Sumatra',
            'west-sumatra' => 'West Sumatra',
        );
        
        foreach ($default_locations as $slug => $name) {
            if (!term_exists($name, 'property_location')) {
                wp_insert_term($name, 'property_location', array('slug' => $slug));
            }
        }
    }

    /**
     * Register Property Feature taxonomy (30+ amenities from Houzez)
     */
    private function register_property_feature_taxonomy() {
        $labels = array(
            'name'                       => _x('Features', 'Taxonomy General Name', 'cari-prop-shop'),
            'singular_name'              => _x('Feature', 'Taxonomy Singular Name', 'cari-prop-shop'),
            'menu_name'                  => __('Features', 'cari-prop-shop'),
            'all_items'                  => __('All Features', 'cari-prop-shop'),
            'parent_item'                => __('Parent Feature', 'cari-prop-shop'),
            'parent_item_colon'          => __('Parent Feature:', 'cari-prop-shop'),
            'new_item_name'              => __('New Feature Name', 'cari-prop-shop'),
            'add_new_item'               => __('Add New Feature', 'cari-prop-shop'),
            'new_item'                   => __('New Feature', 'cari-prop-shop'),
            'edit_item'                  => __('Edit Feature', 'cari-prop-shop'),
            'update_item'                => __('Update Feature', 'cari-prop-shop'),
            'view_item'                  => __('View Feature', 'cari-prop-shop'),
            'separate_items_with_commas' => __('Separate features with commas', 'cari-prop-shop'),
            'add_or_remove_items'        => __('Add or remove features', 'cari-prop-shop'),
            'choose_from_most_used'       => __('Choose from the most used', 'cari-prop-shop'),
            'popular_items'              => __('Popular Features', 'cari-prop-shop'),
            'search_items'               => __('Search Features', 'cari-prop-shop'),
            'not_found'                  => __('Not Found', 'cari-prop-shop'),
            'no_terms'                   => __('No features', 'cari-prop-shop'),
            'items_list'                 => __('Features list', 'cari-prop-shop'),
            'items_list_navigation'       => __('Features list navigation', 'cari-prop-shop'),
        );
        
        $args = array(
            'labels'             => $labels,
            'hierarchical'       => false,
            'public'             => true,
            'show_ui'            => true,
            'show_admin_column'  => true,
            'show_in_nav_menus'  => true,
            'show_tagcloud'       => true,
            'show_in_rest'       => true,
            'query_var'          => true,
            'rewrite'            => array(
                'slug'         => 'feature',
                'with_front'   => true,
                'hierarchical' => false,
            ),
        );
        
        register_taxonomy('property_feature', array('property'), $args);
        
        // Register all features from Houzez (32 features)
        $default_features = array(
            'air-conditioning' => 'Air Conditioning',
            'balcony' => 'Balcony',
            'barbeque' => 'Barbeque',
            'compact-kitchen' => 'Compact Kitchen',
            'dryer' => 'Dryer',
            'elevator' => 'Elevator',
            'energy-efficient-lighting' => 'Energy Efficient Lighting',
            'facilities-convenience' => 'Facilities & Convenience',
            'fireplace' => 'Fireplace',
            'garage' => 'Garage',
            'gym' => 'Gym',
            'interior-features' => 'Interior Features',
            'laundry' => 'Laundry',
            'lawn' => 'Lawn',
            'microwave' => 'Microwave',
            'mini-oven' => 'Mini Oven',
            'outdoor-leisure' => 'Outdoor & Leisure',
            'outdoor-shower' => 'Outdoor Shower',
            'patio' => 'Patio',
            'refrigerator' => 'Refrigerator',
            'sauna' => 'Sauna',
            'security-system' => 'Security System',
            'smart-lock' => 'Smart Lock',
            'solar-panels' => 'Solar Panels',
            'soundproof-walls' => 'Soundproof Walls',
            'swimming-pool' => 'Swimming Pool',
            'technology-efficiency' => 'Technology & Efficiency',
            'tv-cable' => 'TV Cable',
            'washer' => 'Washer',
            'wifi' => 'WiFi',
            'window-coverings' => 'Window Coverings',
            'work-desk' => 'Work Desk',
        );
        
        foreach ($default_features as $slug => $name) {
            if (!term_exists($name, 'property_feature')) {
                wp_insert_term($name, 'property_feature', array('slug' => $slug));
            }
        }
    }

    /**
     * Register Currency taxonomy
     */
    private function register_property_currency_taxonomy() {
        $labels = array(
            'name'                       => _x('Currencies', 'Taxonomy General Name', 'cari-prop-shop'),
            'singular_name'              => _x('Currency', 'Taxonomy Singular Name', 'cari-prop-shop'),
            'menu_name'                  => __('Currencies', 'cari-prop-shop'),
            'all_items'                  => __('All Currencies', 'cari-prop-shop'),
            'edit_item'                  => __('Edit Currency', 'cari-prop-shop'),
            'update_item'                => __('Update Currency', 'cari-prop-shop'),
            'add_new_item'               => __('Add New Currency', 'cari-prop-shop'),
            'new_item_name'              => __('New Currency Name', 'cari-prop-shop'),
            'view_item'                  => __('View Currency', 'cari-prop-shop'),
            'separate_items_with_commas' => __('Separate currencies with commas', 'cari-prop-shop'),
            'add_or_remove_items'        => __('Add or remove currencies', 'cari-prop-shop'),
            'choose_from_most_used'       => __('Choose from the most used', 'cari-prop-shop'),
            'not_found'                  => __('Not Found', 'cari-prop-shop'),
        );
        
        $args = array(
            'labels'             => $labels,
            'hierarchical'       => true,
            'public'             => true,
            'show_ui'            => true,
            'show_admin_column'  => true,
            'show_in_rest'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'currency'),
        );
        
        register_taxonomy('property_currency', array('property'), $args);
        
        // Default currencies
        $default_currencies = array(
            'idr' => 'IDR',
            'usd' => 'USD',
            'eur' => 'EUR',
            'sgd' => 'SGD',
        );
        
        foreach ($default_currencies as $slug => $name) {
            if (!term_exists($name, 'property_currency')) {
                wp_insert_term($name, 'property_currency', array('slug' => $slug));
            }
        }
    }
}
