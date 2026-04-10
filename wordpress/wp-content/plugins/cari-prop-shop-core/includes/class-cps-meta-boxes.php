<?php
/**
 * Meta Boxes Class
 * 
 * Handles custom meta boxes for properties
 *
 * @package CariPropShop
 */

if (!defined('ABSPATH')) {
    exit;
}

class CPS_Meta_Boxes {

    /**
     * Constructor
     */
    public function __construct() {
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_boxes'));
    }

    /**
     * Add meta boxes
     */
    public function add_meta_boxes() {
        add_meta_box(
            'cps_property_details',
            __('Property Details', 'cari-prop-shop'),
            array($this, 'render_property_details_meta_box'),
            'property',
            'normal',
            'high'
        );

        add_meta_box(
            'cps_property_location',
            __('Location', 'cari-prop-shop'),
            array($this, 'render_property_location_meta_box'),
            'property',
            'normal',
            'high'
        );

        add_meta_box(
            'cps_property_media',
            __('Media', 'cari-prop-shop'),
            array($this, 'render_property_media_meta_box'),
            'property',
            'normal',
            'high'
        );

        add_meta_box(
            'cps_property_agent',
            __('Agent Information', 'cari-prop-shop'),
            array($this, 'render_property_agent_meta_box'),
            'property',
            'side',
            'default'
        );
    }

    /**
     * Render property details meta box
     */
    public function render_property_details_meta_box($post) {
        wp_nonce_field('cps_property_meta', 'cps_property_nonce');
        
        $fields = array(
            'price' => array(
                'label' => __('Price', 'cari-prop-shop'),
                'type' => 'number',
                'placeholder' => 'Enter price',
            ),
            'price_label' => array(
                'label' => __('Price Label', 'cari-prop-shop'),
                'type' => 'text',
                'placeholder' => 'e.g., /month',
            ),
            'area' => array(
                'label' => __('Area (sq ft)', 'cari-prop-shop'),
                'type' => 'number',
                'placeholder' => 'Enter area',
            ),
            'land_area' => array(
                'label' => __('Land Area (sq ft)', 'cari-prop-shop'),
                'type' => 'number',
                'placeholder' => 'Enter land area',
            ),
            'bedrooms' => array(
                'label' => __('Bedrooms', 'cari-prop-shop'),
                'type' => 'number',
                'placeholder' => '0',
            ),
            'bathrooms' => array(
                'label' => __('Bathrooms', 'cari-prop-shop'),
                'type' => 'number',
                'placeholder' => '0',
            ),
            'garages' => array(
                'label' => __('Garages', 'cari-prop-shop'),
                'type' => 'number',
                'placeholder' => '0',
            ),
            'year_built' => array(
                'label' => __('Year Built', 'cari-prop-shop'),
                'type' => 'number',
                'placeholder' => '2020',
            ),
            'property_id' => array(
                'label' => __('Property ID', 'cari-prop-shop'),
                'type' => 'text',
                'placeholder' => 'Auto-generated',
            ),
        );
        
        echo '<div class="cps-meta-box">';
        echo '<table class="form-table">';
        echo '<tbody>';
        
        foreach ($fields as $key => $field) {
            $value = get_post_meta($post->ID, 'cps_' . $key, true);
            echo '<tr>';
            echo '<th><label for="cps_' . $key . '">' . esc_html($field['label']) . '</label></th>';
            echo '<td>';
            echo '<input type="' . esc_attr($field['type']) . '" id="cps_' . $key . '" name="cps_' . $key . '" value="' . esc_attr($value) . '" placeholder="' . esc_attr($field['placeholder']) . '" class="regular-text">';
            echo '</td>';
            echo '</tr>';
        }
        
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    }

    /**
     * Render property location meta box
     */
    public function render_property_location_meta_box($post) {
        $fields = array(
            'address' => array(
                'label' => __('Address', 'cari-prop-shop'),
                'type' => 'text',
            ),
            'city' => array(
                'label' => __('City', 'cari-prop-shop'),
                'type' => 'text',
            ),
            'state' => array(
                'label' => __('State/Province', 'cari-prop-shop'),
                'type' => 'text',
            ),
            'zip' => array(
                'label' => __('ZIP/Postal Code', 'cari-prop-shop'),
                'type' => 'text',
            ),
            'country' => array(
                'label' => __('Country', 'cari-prop-shop'),
                'type' => 'text',
            ),
            'latitude' => array(
                'label' => __('Latitude', 'cari-prop-shop'),
                'type' => 'text',
            ),
            'longitude' => array(
                'label' => __('Longitude', 'cari-prop-shop'),
                'type' => 'text',
            ),
        );
        
        echo '<div class="cps-meta-box">';
        echo '<table class="form-table">';
        echo '<tbody>';
        
        foreach ($fields as $key => $field) {
            $value = get_post_meta($post->ID, 'cps_' . $key, true);
            echo '<tr>';
            echo '<th><label for="cps_' . $key . '">' . esc_html($field['label']) . '</label></th>';
            echo '<td>';
            echo '<input type="' . esc_attr($field['type']) . '" id="cps_' . $key . '" name="cps_' . $key . '" value="' . esc_attr($value) . '" class="regular-text">';
            echo '</td>';
            echo '</tr>';
        }
        
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    }

    /**
     * Render property media meta box
     */
    public function render_property_media_meta_box($post) {
        $gallery = get_post_meta($post->ID, 'cps_gallery', true);
        $video_url = get_post_meta($post->ID, 'cps_video_url', true);
        
        echo '<div class="cps-meta-box">';
        echo '<p>';
        echo '<label>' . __('Property Gallery', 'cari-prop-shop') . '</label>';
        echo '</p>';
        echo '<input type="hidden" id="cps_gallery" name="cps_gallery" value="' . esc_attr($gallery) . '">';
        echo '<button type="button" class="button button-secondary" id="cps_gallery_button">' . __('Add Gallery Images', 'cari-prop-shop') . '</button>';
        echo '<div id="cps_gallery_preview" class="cps-gallery-preview"></div>';
        
        echo '<p style="margin-top: 20px;">';
        echo '<label for="cps_video_url">' . __('Video URL (YouTube/Vimeo)', 'cari-prop-shop') . '</label>';
        echo '</p>';
        echo '<input type="url" id="cps_video_url" name="cps_video_url" value="' . esc_url($video_url) . '" class="regular-text" placeholder="https://">';
        echo '</div>';
    }

    /**
     * Render property agent meta box
     */
    public function render_property_agent_meta_box($post) {
        $agents = get_posts(array(
            'post_type' => 'agent',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
        ));
        
        $selected_agent = get_post_meta($post->ID, 'cps_agent', true);
        
        echo '<div class="cps-meta-box">';
        echo '<p>';
        echo '<label for="cps_agent">' . __('Select Agent', 'cari-prop-shop') . '</label>';
        echo '</p>';
        echo '<select id="cps_agent" name="cps_agent" class="widefat">';
        echo '<option value="">' . __('Select an Agent', 'cari-prop-shop') . '</option>';
        
        foreach ($agents as $agent) {
            echo '<option value="' . esc_attr($agent->ID) . '"' . selected($selected_agent, $agent->ID, false) . '>' . esc_html($agent->post_title) . '</option>';
        }
        
        echo '</select>';
        
        $agent_phone = get_post_meta($post->ID, 'cps_agent_phone', true);
        $agent_email = get_post_meta($post->ID, 'cps_agent_email', true);
        
        echo '<p style="margin-top: 15px;">';
        echo '<label for="cps_agent_phone">' . __('Agent Phone', 'cari-prop-shop') . '</label>';
        echo '<input type="tel" id="cps_agent_phone" name="cps_agent_phone" value="' . esc_attr($agent_phone) . '" class="widefat">';
        echo '</p>';
        
        echo '<p>';
        echo '<label for="cps_agent_email">' . __('Agent Email', 'cari-prop-shop') . '</label>';
        echo '<input type="email" id="cps_agent_email" name="cps_agent_email" value="' . esc_attr($agent_email) . '" class="widefat">';
        echo '</p>';
        echo '</div>';
    }

    /**
     * Save meta boxes
     */
    public function save_meta_boxes($post_id) {
        if (!isset($_POST['cps_property_nonce']) || !wp_verify_nonce($_POST['cps_property_nonce'], 'cps_property_meta')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        $fields = array(
            'price', 'price_label', 'area', 'land_area', 'bedrooms', 'bathrooms',
            'garages', 'year_built', 'property_id', 'address', 'city', 'state',
            'zip', 'country', 'latitude', 'longitude', 'gallery', 'video_url',
            'agent', 'agent_phone', 'agent_email'
        );

        foreach ($fields as $field) {
            if (isset($_POST['cps_' . $field])) {
                update_post_meta($post_id, 'cps_' . $field, sanitize_text_field($_POST['cps_' . $field]));
            }
        }
    }
}

// Initialize meta boxes
new CPS_Meta_Boxes();
