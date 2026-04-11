<?php
/**
 * Post Types Class
 * 
 * Handles custom post type registration for properties
 *
 * @package CariPropShop
 */

if (!defined('ABSPATH')) {
    exit;
}

class CPS_Post_Types {

    /**
     * Register post types
     */
    public function register_post_types() {
        $this->register_property_post_type();
        $this->register_agent_post_type();
        $this->register_agency_post_type();
        $this->register_developer_post_type();
        $this->register_project_post_type();
        $this->register_neighborhood_post_type();
    }

    /**
     * Register Property post type
     */
    private function register_property_post_type() {
        $labels = array(
            'name'                  => _x('Properties', 'Post Type General Name', 'cari-prop-shop'),
            'singular_name'         => _x('Property', 'Post Type Singular Name', 'cari-prop-shop'),
            'menu_name'             => __('Properties', 'cari-prop-shop'),
            'name_admin_bar'        => __('Property', 'cari-prop-shop'),
            'archives'              => __('Property Archives', 'cari-prop-shop'),
            'attributes'            => __('Property Attributes', 'cari-prop-shop'),
            'parent_item_colon'     => __('Parent Property:', 'cari-prop-shop'),
            'all_items'             => __('All Properties', 'cari-prop-shop'),
            'add_new_item'          => __('Add New Property', 'cari-prop-shop'),
            'add_new'               => __('Add New', 'cari-prop-shop'),
            'new_item'              => __('New Property', 'cari-prop-shop'),
            'edit_item'             => __('Edit Property', 'cari-prop-shop'),
            'update_item'           => __('Update Property', 'cari-prop-shop'),
            'view_item'             => __('View Property', 'cari-prop-shop'),
            'view_items'            => __('View Properties', 'cari-prop-shop'),
            'search_items'          => __('Search Property', 'cari-prop-shop'),
            'not_found'             => __('Not found', 'cari-prop-shop'),
            'not_found_in_trash'    => __('Not found in Trash', 'cari-prop-shop'),
            'featured_image'        => __('Featured Image', 'cari-prop-shop'),
            'set_featured_image'    => __('Set featured image', 'cari-prop-shop'),
            'remove_featured_image' => __('Remove featured image', 'cari-prop-shop'),
            'use_featured_image'    => __('Use as featured image', 'cari-prop-shop'),
            'insert_into_item'      => __('Insert into property', 'cari-prop-shop'),
            'uploaded_to_this_item' => __('Uploaded to this property', 'cari-prop-shop'),
            'items_list'            => __('Properties list', 'cari-prop-shop'),
            'items_list_navigation' => __('Properties list navigation', 'cari-prop-shop'),
            'filter_items_list'     => __('Filter properties list', 'cari-prop-shop'),
        );
        
        $args = array(
            'label'               => __('Property', 'cari-prop-shop'),
            'description'          => __('Real estate property listings', 'cari-prop-shop'),
            'labels'              => $labels,
            'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'comments', 'revisions'),
            'taxonomies'          => array('property_type', 'property_status', 'property_location', 'property_feature'),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-building',
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
            'show_in_rest'        => true,
            'rewrite'             => array(
                'slug'       => 'property',
                'with_front' => true,
                'pages'      => true,
                'feeds'      => true,
            ),
        );
        
        register_post_type('property', $args);
    }

    /**
     * Register Agent post type
     */
    private function register_agent_post_type() {
        $labels = array(
            'name'                  => _x('Agents', 'Post Type General Name', 'cari-prop-shop'),
            'singular_name'         => _x('Agent', 'Post Type Singular Name', 'cari-prop-shop'),
            'menu_name'             => __('Agents', 'cari-prop-shop'),
            'name_admin_bar'        => __('Agent', 'cari-prop-shop'),
            'archives'              => __('Agent Archives', 'cari-prop-shop'),
            'attributes'            => __('Agent Attributes', 'cari-prop-shop'),
            'parent_item_colon'     => __('Parent Agent:', 'cari-prop-shop'),
            'all_items'             => __('All Agents', 'cari-prop-shop'),
            'add_new_item'          => __('Add New Agent', 'cari-prop-shop'),
            'add_new'               => __('Add New', 'cari-prop-shop'),
            'new_item'              => __('New Agent', 'cari-prop-shop'),
            'edit_item'             => __('Edit Agent', 'cari-prop-shop'),
            'update_item'           => __('Update Agent', 'cari-prop-shop'),
            'view_item'             => __('View Agent', 'cari-prop-shop'),
            'view_items'            => __('View Agents', 'cari-prop-shop'),
            'search_items'          => __('Search Agent', 'cari-prop-shop'),
            'not_found'             => __('Not found', 'cari-prop-shop'),
            'not_found_in_trash'    => __('Not found in Trash', 'cari-prop-shop'),
            'featured_image'        => __('Profile Photo', 'cari-prop-shop'),
            'set_featured_image'    => __('Set profile photo', 'cari-prop-shop'),
            'remove_featured_image' => __('Remove profile photo', 'cari-prop-shop'),
            'use_featured_image'    => __('Use as profile photo', 'cari-prop-shop'),
            'insert_into_item'      => __('Insert into agent', 'cari-prop-shop'),
            'uploaded_to_this_item' => __('Uploaded to this agent', 'cari-prop-shop'),
            'items_list'            => __('Agents list', 'cari-prop-shop'),
            'items_list_navigation' => __('Agents list navigation', 'cari-prop-shop'),
            'filter_items_list'     => __('Filter agents list', 'cari-prop-shop'),
        );
        
        $args = array(
            'label'               => __('Agent', 'cari-prop-shop'),
            'description'          => __('Real estate agent profiles', 'cari-prop-shop'),
            'labels'              => $labels,
            'supports'            => array('title', 'editor', 'thumbnail', 'custom-fields'),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 6,
            'menu_icon'           => 'dashicons-admin-users',
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
            'show_in_rest'        => true,
            'rewrite'             => array(
                'slug'       => 'agent',
                'with_front' => true,
                'pages'      => true,
                'feeds'      => true,
            ),
        );
        
        register_post_type('agent', $args);
    }

    /**
     * Register Agency post type
     */
    private function register_agency_post_type() {
        $labels = array(
            'name'                  => _x('Agencies', 'Post Type General Name', 'cari-prop-shop'),
            'singular_name'         => _x('Agency', 'Post Type Singular Name', 'cari-prop-shop'),
            'menu_name'             => __('Agencies', 'cari-prop-shop'),
            'name_admin_bar'        => __('Agency', 'cari-prop-shop'),
            'archives'              => __('Agency Archives', 'cari-prop-shop'),
            'attributes'            => __('Agency Attributes', 'cari-prop-shop'),
            'parent_item_colon'     => __('Parent Agency:', 'cari-prop-shop'),
            'all_items'             => __('All Agencies', 'cari-prop-shop'),
            'add_new_item'          => __('Add New Agency', 'cari-prop-shop'),
            'add_new'               => __('Add New', 'cari-prop-shop'),
            'new_item'              => __('New Agency', 'cari-prop-shop'),
            'edit_item'             => __('Edit Agency', 'cari-prop-shop'),
            'update_item'           => __('Update Agency', 'cari-prop-shop'),
            'view_item'             => __('View Agency', 'cari-prop-shop'),
            'view_items'            => __('View Agencies', 'cari-prop-shop'),
            'search_items'          => __('Search Agency', 'cari-prop-shop'),
            'not_found'             => __('Not found', 'cari-prop-shop'),
            'not_found_in_trash'    => __('Not found in Trash', 'cari-prop-shop'),
            'featured_image'        => __('Logo', 'cari-prop-shop'),
            'set_featured_image'    => __('Set logo', 'cari-prop-shop'),
            'remove_featured_image' => __('Remove logo', 'cari-prop-shop'),
            'use_featured_image'    => __('Use as logo', 'cari-prop-shop'),
            'insert_into_item'      => __('Insert into agency', 'cari-prop-shop'),
            'uploaded_to_this_item' => __('Uploaded to this agency', 'cari-prop-shop'),
            'items_list'            => __('Agencies list', 'cari-prop-shop'),
            'items_list_navigation' => __('Agencies list navigation', 'cari-prop-shop'),
            'filter_items_list'     => __('Filter agencies list', 'cari-prop-shop'),
        );
        
        $args = array(
            'label'               => __('Agency', 'cari-prop-shop'),
            'description'          => __('Real estate agency profiles', 'cari-prop-shop'),
            'labels'              => $labels,
            'supports'            => array('title', 'editor', 'thumbnail', 'custom-fields'),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 7,
            'menu_icon'           => 'dashicons-networking',
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
            'show_in_rest'       => true,
            'rewrite'             => array(
                'slug'       => 'agency',
                'with_front' => true,
                'pages'      => true,
                'feeds'      => true,
            ),
        );
        
        register_post_type('agency', $args);
    }

    /**
     * Register Developer post type
     */
    private function register_developer_post_type() {
        $labels = array(
            'name'                  => _x('Developers', 'Post Type General Name', 'cari-prop-shop'),
            'singular_name'         => _x('Developer', 'Post Type Singular Name', 'cari-prop-shop'),
            'menu_name'             => __('Developers', 'cari-prop-shop'),
            'name_admin_bar'        => __('Developer', 'cari-prop-shop'),
            'archives'              => __('Developer Archives', 'cari-prop-shop'),
            'attributes'            => __('Developer Attributes', 'cari-prop-shop'),
            'all_items'             => __('All Developers', 'cari-prop-shop'),
            'add_new_item'          => __('Add New Developer', 'cari-prop-shop'),
            'add_new'               => __('Add New', 'cari-prop-shop'),
            'new_item'              => __('New Developer', 'cari-prop-shop'),
            'edit_item'             => __('Edit Developer', 'cari-prop-shop'),
            'update_item'           => __('Update Developer', 'cari-prop-shop'),
            'view_item'             => __('View Developer', 'cari-prop-shop'),
            'search_items'          => __('Search Developer', 'cari-prop-shop'),
            'not_found'             => __('Not found', 'cari-prop-shop'),
            'not_found_in_trash'    => __('Not found in Trash', 'cari-prop-shop'),
            'featured_image'        => __('Logo', 'cari-prop-shop'),
            'set_featured_image'    => __('Set logo', 'cari-prop-shop'),
            'remove_featured_image' => __('Remove logo', 'cari-prop-shop'),
            'use_featured_image'    => __('Use as logo', 'cari-prop-shop'),
        );

        $args = array(
            'label'               => __('Developer', 'cari-prop-shop'),
            'description'          => __('Property developers and builders', 'cari-prop-shop'),
            'labels'              => $labels,
            'supports'            => array('title', 'editor', 'thumbnail', 'custom-fields'),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 8,
            'menu_icon'           => 'dashicons-admin-home',
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
            'show_in_rest'        => true,
            'rewrite'             => array(
                'slug'       => 'developer',
                'with_front' => true,
            ),
        );

        register_post_type('developer', $args);
    }

    /**
     * Register Project post type (new developments)
     */
    private function register_project_post_type() {
        $labels = array(
            'name'                  => _x('Projects', 'Post Type General Name', 'cari-prop-shop'),
            'singular_name'         => _x('Project', 'Post Type Singular Name', 'cari-prop-shop'),
            'menu_name'             => __('Projects', 'cari-prop-shop'),
            'name_admin_bar'        => __('Project', 'cari-prop-shop'),
            'archives'              => __('Project Archives', 'cari-prop-shop'),
            'attributes'            => __('Project Attributes', 'cari-prop-shop'),
            'all_items'             => __('All Projects', 'cari-prop-shop'),
            'add_new_item'          => __('Add New Project', 'cari-prop-shop'),
            'add_new'               => __('Add New', 'cari-prop-shop'),
            'new_item'              => __('New Project', 'cari-prop-shop'),
            'edit_item'             => __('Edit Project', 'cari-prop-shop'),
            'update_item'           => __('Update Project', 'cari-prop-shop'),
            'view_item'             => __('View Project', 'cari-prop-shop'),
            'search_items'          => __('Search Project', 'cari-prop-shop'),
            'not_found'             => __('Not found', 'cari-prop-shop'),
            'not_found_in_trash'    => __('Not found in Trash', 'cari-prop-shop'),
            'featured_image'        => __('Project Image', 'cari-prop-shop'),
            'set_featured_image'    => __('Set project image', 'cari-prop-shop'),
            'remove_featured_image' => __('Remove project image', 'cari-prop-shop'),
            'use_featured_image'    => __('Use as project image', 'cari-prop-shop'),
        );

        $args = array(
            'label'               => __('Project', 'cari-prop-shop'),
            'description'          => __('New property developments and projects', 'cari-prop-shop'),
            'labels'              => $labels,
            'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'gallery'),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 9,
            'menu_icon'           => 'dashicons-layout',
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
            'show_in_rest'        => true,
            'rewrite'             => array(
                'slug'       => 'project',
                'with_front' => true,
            ),
        );

        register_post_type('project', $args);
    }

    /**
     * Register Neighborhood post type
     */
    private function register_neighborhood_post_type() {
        $labels = array(
            'name'                  => _x('Neighborhoods', 'Post Type General Name', 'cari-prop-shop'),
            'singular_name'         => _x('Neighborhood', 'Post Type Singular Name', 'cari-prop-shop'),
            'menu_name'             => __('Neighborhoods', 'cari-prop-shop'),
            'name_admin_bar'        => __('Neighborhood', 'cari-prop-shop'),
            'archives'              => __('Neighborhood Archives', 'cari-prop-shop'),
            'attributes'            => __('Neighborhood Attributes', 'cari-prop-shop'),
            'all_items'             => __('All Neighborhoods', 'cari-prop-shop'),
            'add_new_item'          => __('Add New Neighborhood', 'cari-prop-shop'),
            'add_new'               => __('Add New', 'cari-prop-shop'),
            'new_item'              => __('New Neighborhood', 'cari-prop-shop'),
            'edit_item'             => __('Edit Neighborhood', 'cari-prop-shop'),
            'update_item'           => __('Update Neighborhood', 'cari-prop-shop'),
            'view_item'             => __('View Neighborhood', 'cari-prop-shop'),
            'search_items'          => __('Search Neighborhood', 'cari-prop-shop'),
            'not_found'             => __('Not found', 'cari-prop-shop'),
            'not_found_in_trash'    => __('Not found in Trash', 'cari-prop-shop'),
            'featured_image'        => __('Cover Image', 'cari-prop-shop'),
            'set_featured_image'    => __('Set cover image', 'cari-prop-shop'),
            'remove_featured_image' => __('Remove cover image', 'cari-prop-shop'),
            'use_featured_image'    => __('Use as cover image', 'cari-prop-shop'),
        );

        $args = array(
            'label'               => __('Neighborhood', 'cari-prop-shop'),
            'description'          => __('Areas and neighborhoods guide', 'cari-prop-shop'),
            'labels'              => $labels,
            'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 10,
            'menu_icon'           => 'dashicons-location',
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
            'show_in_rest'        => true,
            'rewrite'             => array(
                'slug'       => 'neighborhood',
                'with_front' => true,
            ),
        );

        register_post_type('neighborhood', $args);
    }
}
