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

        add_meta_box(
            'cps_agent_details',
            __('Agent Details', 'cari-prop-shop'),
            array($this, 'render_agent_details_meta_box'),
            'agent',
            'normal',
            'high'
        );

        add_meta_box(
            'cps_agent_social',
            __('Social Links', 'cari-prop-shop'),
            array($this, 'render_agent_social_meta_box'),
            'agent',
            'normal',
            'default'
        );

        add_meta_box(
            'cps_testimonial_details',
            __('Testimonial Details', 'cari-prop-shop'),
            array($this, 'render_testimonial_details_meta_box'),
            'cps_testimonial',
            'normal',
            'high'
        );
    }

    /**
     * Render property details meta box
     */
    public function render_property_details_meta_box($post) {
        wp_nonce_field('cps_property_meta', 'cps_property_nonce');
        
        $status = get_post_meta($post->ID, 'cps_status', true) ?: 'For Sale';
        $statuses = array('For Sale', 'For Rent', 'Pending', 'Sold');
        
        $fields = array(
            'price' => array(
                'label' => __('Price (IDR)', 'cari-prop-shop'),
                'type' => 'number',
                'placeholder' => '500000000',
            ),
            'price_label' => array(
                'label' => __('Price Label', 'cari-prop-shop'),
                'type' => 'text',
                'placeholder' => 'e.g., /month',
            ),
            'sqft' => array(
                'label' => __('Area (m²)', 'cari-prop-shop'),
                'type' => 'number',
                'placeholder' => '150',
            ),
            'land_area' => array(
                'label' => __('Land Area (m²)', 'cari-prop-shop'),
                'type' => 'number',
                'placeholder' => '200',
            ),
            'bedrooms' => array(
                'label' => __('Bedrooms', 'cari-prop-shop'),
                'type' => 'number',
                'placeholder' => '3',
            ),
            'bathrooms' => array(
                'label' => __('Bathrooms', 'cari-prop-shop'),
                'type' => 'number',
                'placeholder' => '2',
            ),
            'garage' => array(
                'label' => __('Garages', 'cari-prop-shop'),
                'type' => 'number',
                'placeholder' => '1',
            ),
            'year_built' => array(
                'label' => __('Year Built', 'cari-prop-shop'),
                'type' => 'number',
                'placeholder' => '2020',
            ),
            'property_id' => array(
                'label' => __('Property ID', 'cari-prop-shop'),
                'type' => 'text',
                'placeholder' => 'CPS-001',
            ),
        );
        
        echo '<div class="cps-meta-box">';
        echo '<table class="form-table">';
        echo '<tbody>';
        
        echo '<tr>';
        echo '<th><label for="cps_status">' . __('Status', 'cari-prop-shop') . '</label></th>';
        echo '<td>';
        echo '<select id="cps_status" name="cps_status" class="regular-text">';
        foreach ($statuses as $s) {
            echo '<option value="' . esc_attr($s) . '"' . selected($status, $s, false) . '>' . esc_html($s) . '</option>';
        }
        echo '</select>';
        echo '</td>';
        echo '</tr>';
        
        foreach ($fields as $key => $field) {
            $cps_key = 'cps_' . $key;
            $value = get_post_meta($post->ID, $cps_key, true);
            echo '<tr>';
            echo '<th><label for="' . esc_attr($cps_key) . '">' . esc_html($field['label']) . '</label></th>';
            echo '<td>';
            echo '<input type="' . esc_attr($field['type']) . '" id="' . esc_attr($cps_key) . '" name="' . esc_attr($cps_key) . '" value="' . esc_attr($value) . '" placeholder="' . esc_attr($field['placeholder']) . '" class="regular-text">';
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
                'label' => __('Latitude (for Google Maps)', 'cari-prop-shop'),
                'type' => 'text',
                'placeholder' => '-6.2088',
            ),
            'longitude' => array(
                'label' => __('Longitude (for Google Maps)', 'cari-prop-shop'),
                'type' => 'text',
                'placeholder' => '106.8456',
            ),
        );
        
        echo '<div class="cps-meta-box">';
        echo '<table class="form-table">';
        echo '<tbody>';
        
        foreach ($fields as $key => $field) {
            $cps_key = 'cps_' . $key;
            $value = get_post_meta($post->ID, $cps_key, true);
            echo '<tr>';
            echo '<th><label for="' . esc_attr($cps_key) . '">' . esc_html($field['label']) . '</label></th>';
            echo '<td>';
            echo '<input type="' . esc_attr($field['type']) . '" id="' . esc_attr($cps_key) . '" name="' . esc_attr($cps_key) . '" value="' . esc_attr($value) . '" placeholder="' . esc_attr($field['placeholder'] ?? '') . '" class="regular-text">';
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
        echo '<input type="url" id="cps_video_url" name="cps_video_url" value="' . esc_url($video_url) . '" class="regular-text" placeholder="https://youtube.com/watch?v=...">';
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
        echo '<input type="tel" id="cps_agent_phone" name="cps_agent_phone" value="' . esc_attr($agent_phone) . '" class="widefat" placeholder="+62 xxx xxxx xxxx">';
        echo '</p>';
        
        echo '<p>';
        echo '<label for="cps_agent_email">' . __('Agent Email', 'cari-prop-shop') . '</label>';
        echo '<input type="email" id="cps_agent_email" name="cps_agent_email" value="' . esc_attr($agent_email) . '" class="widefat" placeholder="agent@caripropshop.com">';
        echo '</p>';
        echo '</div>';
    }

    /**
     * Render agent details meta box
     */
    public function render_agent_details_meta_box($post) {
        wp_nonce_field('cps_agent_meta', 'cps_agent_nonce');
        
        $fields = array(
            'email' => array(
                'label' => __('Email', 'cari-prop-shop'),
                'type' => 'email',
                'placeholder' => 'agent@example.com',
            ),
            'phone' => array(
                'label' => __('Phone', 'cari-prop-shop'),
                'type' => 'text',
                'placeholder' => '+62 xxx xxxx xxxx',
            ),
            'mobile' => array(
                'label' => __('Mobile', 'cari-prop-shop'),
                'type' => 'text',
                'placeholder' => '+62 xxx xxxx xxxx',
            ),
            'whatsapp' => array(
                'label' => __('WhatsApp', 'cari-prop-shop'),
                'type' => 'text',
                'placeholder' => '+62 xxx xxxx xxxx',
            ),
            'position' => array(
                'label' => __('Position/Title', 'cari-prop-shop'),
                'type' => 'text',
                'placeholder' => 'Senior Property Agent',
            ),
            'license' => array(
                'label' => __('License Number', 'cari-prop-shop'),
                'type' => 'text',
                'placeholder' => 'License #',
            ),
            'experience' => array(
                'label' => __('Years of Experience', 'cari-prop-shop'),
                'type' => 'number',
                'placeholder' => '5',
            ),
            'specialties' => array(
                'label' => __('Specialties', 'cari-prop-shop'),
                'type' => 'text',
                'placeholder' => 'Residential, Commercial, Luxury',
            ),
        );
        
        echo '<div class="cps-meta-box">';
        echo '<table class="form-table">';
        echo '<tbody>';
        
        foreach ($fields as $key => $field) {
            $value = get_post_meta($post->ID, 'cps_agent_' . $key, true);
            echo '<tr>';
            echo '<th><label for="cps_agent_' . $key . '">' . esc_html($field['label']) . '</label></th>';
            echo '<td>';
            echo '<input type="' . esc_attr($field['type']) . '" id="cps_agent_' . $key . '" name="cps_agent_' . $key . '" value="' . esc_attr($value) . '" placeholder="' . esc_attr($field['placeholder']) . '" class="regular-text">';
            echo '</td>';
            echo '</tr>';
        }
        
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    }

    /**
     * Render agent social meta box
     */
    public function render_agent_social_meta_box($post) {
        $social_fields = array(
            'facebook' => array('label' => 'Facebook', 'icon' => 'fab fa-facebook'),
            'twitter' => array('label' => 'Twitter', 'icon' => 'fab fa-twitter'),
            'linkedin' => array('label' => 'LinkedIn', 'icon' => 'fab fa-linkedin'),
            'instagram' => array('label' => 'Instagram', 'icon' => 'fab fa-instagram'),
            'youtube' => array('label' => 'YouTube', 'icon' => 'fab fa-youtube'),
            'tiktok' => array('label' => 'TikTok', 'icon' => 'fab fa-tiktok'),
        );
        
        echo '<div class="cps-meta-box">';
        echo '<table class="form-table">';
        echo '<tbody>';
        
        foreach ($social_fields as $key => $field) {
            $value = get_post_meta($post->ID, 'cps_agent_' . $key, true);
            echo '<tr>';
            echo '<th><label for="cps_agent_' . $key . '"><i class="' . esc_attr($field['icon']) . '"></i> ' . esc_html($field['label']) . '</label></th>';
            echo '<td>';
            echo '<input type="url" id="cps_agent_' . $key . '" name="cps_agent_' . $key . '" value="' . esc_url($value) . '" placeholder="https://" class="regular-text">';
            echo '</td>';
            echo '</tr>';
        }
        
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    }

    /**
     * Render testimonial details meta box
     */
    public function render_testimonial_details_meta_box($post) {
        wp_nonce_field('cps_testimonial_meta', 'cps_testimonial_nonce');
        
        $role = get_post_meta($post->ID, 'cps_testimonial_role', true);
        $company = get_post_meta($post->ID, 'cps_testimonial_company', true);
        $rating = get_post_meta($post->ID, 'cps_testimonial_rating', true);
        $property = get_post_meta($post->ID, 'cps_testimonial_property', true);
        
        echo '<div class="cps-meta-box">';
        echo '<table class="form-table">';
        echo '<tbody>';
        echo '<tr>';
        echo '<th><label for="cps_testimonial_role">' . __('Role/Position', 'cari-prop-shop') . '</label></th>';
        echo '<td><input type="text" id="cps_testimonial_role" name="cps_testimonial_role" value="' . esc_attr($role) . '" class="regular-text" placeholder="e.g., Business Owner"></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<th><label for="cps_testimonial_company">' . __('Company', 'cari-prop-shop') . '</label></th>';
        echo '<td><input type="text" id="cps_testimonial_company" name="cps_testimonial_company" value="' . esc_attr($company) . '" class="regular-text"></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<th><label for="cps_testimonial_rating">' . __('Rating (1-5)', 'cari-prop-shop') . '</label></th>';
        echo '<td>';
        echo '<select id="cps_testimonial_rating" name="cps_testimonial_rating">';
        for ($i = 1; $i <= 5; $i++) {
            echo '<option value="' . esc_attr($i) . '"' . selected($rating, $i, false) . '>' . esc_html($i) . ' Star' . ($i > 1 ? 's' : '') . '</option>';
        }
        echo '</select>';
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<th><label for="cps_testimonial_property">' . __('Property Referenced', 'cari-prop-shop') . '</label></th>';
        echo '<td>';
        $properties = get_posts(array('post_type' => 'property', 'posts_per_page' => -1, 'orderby' => 'title'));
        echo '<select id="cps_testimonial_property" name="cps_testimonial_property">';
        echo '<option value="">' . __('Select Property', 'cari-prop-shop') . '</option>';
        foreach ($properties as $prop) {
            echo '<option value="' . esc_attr($prop->ID) . '"' . selected($property, $prop->ID, false) . '>' . esc_html($prop->post_title) . '</option>';
        }
        echo '</select>';
        echo '</td>';
        echo '</tr>';
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    }

    /**
     * Save meta boxes
     */
    public function save_meta_boxes($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        $post_type = get_post_type($post_id);

        if ($post_type === 'property') {
            if (!isset($_POST['cps_property_nonce']) || !wp_verify_nonce($_POST['cps_property_nonce'], 'cps_property_meta')) {
                return;
            }

            if (isset($_POST['cps_status'])) {
                update_post_meta($post_id, 'cps_status', sanitize_text_field($_POST['cps_status']));
            }

            $fields = array(
                'price', 'price_label', 'sqft', 'land_area', 'bedrooms', 'bathrooms',
                'garage', 'year_built', 'property_id', 'address', 'city', 'state',
                'zip', 'country', 'latitude', 'longitude', 'gallery', 'video_url',
                'agent', 'agent_phone', 'agent_email'
            );

            foreach ($fields as $field) {
                $key = 'cps_' . $field;
                if (isset($_POST[$key])) {
                    update_post_meta($post_id, $key, sanitize_text_field($_POST[$key]));
                }
            }
        }

        if ($post_type === 'agent') {
            if (!isset($_POST['cps_agent_nonce']) || !wp_verify_nonce($_POST['cps_agent_nonce'], 'cps_agent_meta')) {
                return;
            }

            $agent_fields = array('email', 'phone', 'mobile', 'whatsapp', 'position', 'license', 'experience', 'specialties');
            $social_fields = array('facebook', 'twitter', 'linkedin', 'instagram', 'youtube', 'tiktok');

            foreach ($agent_fields as $field) {
                if (isset($_POST['cps_agent_' . $field])) {
                    update_post_meta($post_id, 'cps_agent_' . $field, sanitize_text_field($_POST['cps_agent_' . $field]));
                }
            }

            foreach ($social_fields as $field) {
                if (isset($_POST['cps_agent_' . $field])) {
                    update_post_meta($post_id, 'cps_agent_' . $field, esc_url_raw($_POST['cps_agent_' . $field]));
                }
            }
        }

        if ($post_type === 'cps_testimonial') {
            if (!isset($_POST['cps_testimonial_nonce']) || !wp_verify_nonce($_POST['cps_testimonial_nonce'], 'cps_testimonial_meta')) {
                return;
            }

            if (isset($_POST['cps_testimonial_role'])) {
                update_post_meta($post_id, 'cps_testimonial_role', sanitize_text_field($_POST['cps_testimonial_role']));
            }
            if (isset($_POST['cps_testimonial_company'])) {
                update_post_meta($post_id, 'cps_testimonial_company', sanitize_text_field($_POST['cps_testimonial_company']));
            }
            if (isset($_POST['cps_testimonial_rating'])) {
                update_post_meta($post_id, 'cps_testimonial_rating', intval($_POST['cps_testimonial_rating']));
            }
            if (isset($_POST['cps_testimonial_property'])) {
                update_post_meta($post_id, 'cps_testimonial_property', intval($_POST['cps_testimonial_property']));
            }
        }
    }
}

// Initialize meta boxes
new CPS_Meta_Boxes();
