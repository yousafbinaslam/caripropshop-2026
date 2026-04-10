<?php
/**
 * Shortcodes Class
 * 
 * Handles custom shortcodes for property display
 *
 * @package CariPropShop
 */

if (!defined('ABSPATH')) {
    exit;
}

class CPS_Shortcodes {

    /**
     * Constructor
     */
    public function __construct() {
        add_shortcode('cps_properties', array($this, 'properties_shortcode'));
        add_shortcode('cps_property_search', array($this, 'property_search_shortcode'));
        add_shortcode('cps_property_slider', array($this, 'property_slider_shortcode'));
        add_shortcode('cps_agents', array($this, 'agents_shortcode'));
        add_shortcode('cps_property_types', array($this, 'property_types_shortcode'));
    }

    /**
     * Properties shortcode
     */
    public function properties_shortcode($atts) {
        $atts = shortcode_atts(array(
            'count' => 6,
            'type' => '',
            'status' => '',
            'location' => '',
            'orderby' => 'date',
            'order' => 'DESC',
            'columns' => 3,
        ), $atts, 'cps_properties');

        $args = array(
            'post_type' => 'property',
            'posts_per_page' => intval($atts['count']),
            'orderby' => $atts['orderby'],
            'order' => $atts['order'],
        );

        if (!empty($atts['type'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'property_type',
                'field' => 'slug',
                'terms' => $atts['type'],
            );
        }

        if (!empty($atts['status'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'property_status',
                'field' => 'slug',
                'terms' => $atts['status'],
            );
        }

        if (!empty($atts['location'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'property_location',
                'field' => 'slug',
                'terms' => $atts['location'],
            );
        }

        $properties = new WP_Query($args);
        
        if (!$properties->have_posts()) {
            return '<p class="cps-no-properties">' . __('No properties found.', 'cari-prop-shop') . '</p>';
        }

        ob_start();
        
        echo '<div class="cps-properties-grid cps-columns-' . esc_attr($atts['columns']) . '">';
        
        while ($properties->have_posts()) {
            $properties->the_post();
            $this->render_property_card(get_post());
        }
        
        echo '</div>';
        
        wp_reset_postdata();
        
        return ob_get_clean();
    }

    /**
     * Render property card
     */
    private function render_property_card($post) {
        $price = get_post_meta($post->ID, 'cps_price', true);
        $bedrooms = get_post_meta($post->ID, 'cps_bedrooms', true);
        $bathrooms = get_post_meta($post->ID, 'cps_bathrooms', true);
        $area = get_post_meta($post->ID, 'cps_area', true);
        $image = get_the_post_thumbnail_url($post->ID, 'medium');
        $types = get_the_terms($post->ID, 'property_type');
        $status = get_the_terms($post->ID, 'property_status');
        ?>
        
        <article class="cps-property-card">
            <div class="cps-property-image">
                <?php if (has_post_thumbnail($post->ID)) : ?>
                    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($post->post_title); ?>">
                <?php else : ?>
                    <div class="cps-property-placeholder">
                        <span><?php esc_html_e('No Image', 'cari-prop-shop'); ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if ($status) : ?>
                    <span class="cps-property-status">
                        <?php echo esc_html($status[0]->name); ?>
                    </span>
                <?php endif; ?>
            </div>
            
            <div class="cps-property-content">
                <h3 class="cps-property-title">
                    <a href="<?php echo esc_url(get_permalink($post->ID)); ?>">
                        <?php echo esc_html($post->post_title); ?>
                    </a>
                </h3>
                
                <?php if ($price) : ?>
                    <div class="cps-property-price">
                        <?php echo esc_html(number_format_i18n($price)); ?>
                        <?php echo esc_html(get_post_meta($post->ID, 'cps_price_label', true)); ?>
                    </div>
                <?php endif; ?>
                
                <div class="cps-property-meta">
                    <?php if ($bedrooms) : ?>
                        <span><i class="dashicons dashicons-bed"></i> <?php echo esc_html($bedrooms); ?></span>
                    <?php endif; ?>
                    <?php if ($bathrooms) : ?>
                        <span><i class="dashicons dashicons-bath"></i> <?php echo esc_html($bathrooms); ?></span>
                    <?php endif; ?>
                    <?php if ($area) : ?>
                        <span><i class="dashicons dashicons-grid-view"></i> <?php echo esc_html($area); ?> sq ft</span>
                    <?php endif; ?>
                </div>
                
                <?php if ($types) : ?>
                    <div class="cps-property-types">
                        <?php foreach (array_slice($types, 0, 2) as $type) : ?>
                            <a href="<?php echo esc_url(get_term_link($type)); ?>">
                                <?php echo esc_html($type->name); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </article>
        
        <?php
    }

    /**
     * Property search shortcode
     */
    public function property_search_shortcode($atts) {
        $atts = shortcode_atts(array(
            'layout' => 'horizontal',
        ), $atts, 'cps_property_search');

        ob_start();
        ?>
        <div class="cps-property-search cps-search-<?php echo esc_attr($atts['layout']); ?>">
            <form action="<?php echo esc_url(home_url('/properties')); ?>" method="get">
                <div class="cps-search-fields">
                    <div class="cps-search-field">
                        <label><?php esc_html_e('Keyword', 'cari-prop-shop'); ?></label>
                        <input type="text" name="s" placeholder="<?php esc_attr_e('Search properties...', 'cari-prop-shop'); ?>">
                    </div>
                    
                    <div class="cps-search-field">
                        <label><?php esc_html_e('Property Type', 'cari-prop-shop'); ?></label>
                        <?php 
                        wp_dropdown_categories(array(
                            'taxonomy' => 'property_type',
                            'name' => 'property_type',
                            'show_option_all' => __('All Types', 'cari-prop-shop'),
                            'class' => 'cps-select',
                        ));
                        ?>
                    </div>
                    
                    <div class="cps-search-field">
                        <label><?php esc_html_e('Status', 'cari-prop-shop'); ?></label>
                        <?php 
                        wp_dropdown_categories(array(
                            'taxonomy' => 'property_status',
                            'name' => 'property_status',
                            'show_option_all' => __('Any Status', 'cari-prop-shop'),
                            'class' => 'cps-select',
                        ));
                        ?>
                    </div>
                    
                    <div class="cps-search-field cps-search-field-price">
                        <label><?php esc_html_e('Price Range', 'cari-prop-shop'); ?></label>
                        <div class="cps-price-range">
                            <input type="number" name="min_price" placeholder="<?php esc_attr_e('Min', 'cari-prop-shop'); ?>">
                            <span>-</span>
                            <input type="number" name="max_price" placeholder="<?php esc_attr_e('Max', 'cari-prop-shop'); ?>">
                        </div>
                    </div>
                    
                    <div class="cps-search-field">
                        <label><?php esc_html_e('Bedrooms', 'cari-prop-shop'); ?></label>
                        <select name="bedrooms" class="cps-select">
                            <option value=""><?php esc_html_e('Any', 'cari-prop-shop'); ?></option>
                            <?php for ($i = 1; $i <= 10; $i++) : ?>
                                <option value="<?php echo esc_attr($i); ?>"><?php echo esc_html($i); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    
                    <div class="cps-search-field">
                        <button type="submit" class="cps-search-btn">
                            <i class="dashicons dashicons-search"></i>
                            <?php esc_html_e('Search', 'cari-prop-shop'); ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <?php
        
        return ob_get_clean();
    }

    /**
     * Property slider shortcode
     */
    public function property_slider_shortcode($atts) {
        $atts = shortcode_atts(array(
            'count' => 6,
            'type' => 'featured',
        ), $atts, 'cps_property_slider');

        $args = array(
            'post_type' => 'property',
            'posts_per_page' => intval($atts['count']),
            'orderby' => 'rand',
        );

        if ($atts['type'] === 'featured') {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'property_status',
                    'field' => 'slug',
                    'terms' => 'featured',
                ),
            );
        }

        $properties = new WP_Query($args);
        
        if (!$properties->have_posts()) {
            return '';
        }

        ob_start();
        ?>
        <div class="cps-property-slider">
            <div class="cps-slider-container">
                <div class="cps-slider-track">
                    <?php 
                    while ($properties->have_posts()) {
                        $properties->the_post();
                        $this->render_slider_card(get_post());
                    }
                    ?>
                </div>
                <div class="cps-slider-nav">
                    <button class="cps-slider-prev">
                        <span class="dashicons dashicons-arrow-left-alt2"></span>
                    </button>
                    <button class="cps-slider-next">
                        <span class="dashicons dashicons-arrow-right-alt2"></span>
                    </button>
                </div>
            </div>
        </div>
        <?php
        
        wp_reset_postdata();
        
        return ob_get_clean();
    }

    /**
     * Render slider card
     */
    private function render_slider_card($post) {
        $price = get_post_meta($post->ID, 'cps_price', true);
        $image = get_the_post_thumbnail_url($post->ID, 'large');
        ?>
        
        <div class="cps-slider-item">
            <article class="cps-property-card cps-slider-card">
                <div class="cps-property-image">
                    <?php if (has_post_thumbnail($post->ID)) : ?>
                        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($post->post_title); ?>">
                    <?php endif; ?>
                </div>
                
                <div class="cps-property-content">
                    <h3 class="cps-property-title">
                        <a href="<?php echo esc_url(get_permalink($post->ID)); ?>">
                            <?php echo esc_html($post->post_title); ?>
                        </a>
                    </h3>
                    
                    <?php if ($price) : ?>
                        <div class="cps-property-price">
                            <?php echo esc_html(number_format_i18n($price)); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </article>
        </div>
        
        <?php
    }

    /**
     * Agents shortcode
     */
    public function agents_shortcode($atts) {
        $atts = shortcode_atts(array(
            'count' => 4,
        ), $atts, 'cps_agents');

        $agents = get_posts(array(
            'post_type' => 'agent',
            'posts_per_page' => intval($atts['count']),
            'orderby' => 'rand',
        ));

        if (!$agents) {
            return '<p class="cps-no-agents">' . __('No agents found.', 'cari-prop-shop') . '</p>';
        }

        ob_start();
        
        echo '<div class="cps-agents-grid">';
        
        foreach ($agents as $agent) {
            $photo = get_the_post_thumbnail_url($agent->ID, 'medium');
            $email = get_post_meta($agent->ID, 'cps_agent_email', true);
            $phone = get_post_meta($agent->ID, 'cps_agent_phone', true);
            ?>
            
            <article class="cps-agent-card">
                <div class="cps-agent-photo">
                    <?php if ($photo) : ?>
                        <img src="<?php echo esc_url($photo); ?>" alt="<?php echo esc_attr($agent->post_title); ?>">
                    <?php else : ?>
                        <div class="cps-agent-placeholder">
                            <span class="dashicons dashicons-admin-users"></span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="cps-agent-content">
                    <h3 class="cps-agent-name">
                        <a href="<?php echo esc_url(get_permalink($agent->ID)); ?>">
                            <?php echo esc_html($agent->post_title); ?>
                        </a>
                    </h3>
                    
                    <?php if ($phone) : ?>
                        <div class="cps-agent-phone">
                            <i class="dashicons dashicons-phone"></i>
                            <?php echo esc_html($phone); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($email) : ?>
                        <div class="cps-agent-email">
                            <i class="dashicons dashicons-email"></i>
                            <a href="mailto:<?php echo esc_attr($email); ?>">
                                <?php echo esc_html($email); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </article>
            
            <?php
        }
        
        echo '</div>';
        
        return ob_get_clean();
    }

    /**
     * Property types shortcode
     */
    public function property_types_shortcode($atts) {
        $types = get_terms(array(
            'taxonomy' => 'property_type',
            'hide_empty' => true,
            'number' => 6,
        ));

        if (!$types || is_wp_error($types)) {
            return '';
        }

        ob_start();
        
        echo '<div class="cps-property-types-grid">';
        
        foreach ($types as $type) {
            $image = get_term_meta($type->term_id, 'cps_type_image', true);
            $count = $type->count;
            ?>
            
            <article class="cps-type-card">
                <a href="<?php echo esc_url(get_term_link($type)); ?>">
                    <?php if ($image) : ?>
                        <div class="cps-type-image">
                            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($type->name); ?>">
                        </div>
                    <?php else : ?>
                        <div class="cps-type-icon">
                            <span class="dashicons dashicons-building"></span>
                        </div>
                    <?php endif; ?>
                    
                    <h3 class="cps-type-name"><?php echo esc_html($type->name); ?></h3>
                    <span class="cps-type-count"><?php echo esc_html($count); ?> <?php esc_html_e('Property', 'cari-prop-shop'); ?></span>
                </a>
            </article>
            
            <?php
        }
        
        echo '</div>';
        
        return ob_get_clean();
    }
}

// Initialize shortcodes
new CPS_Shortcodes();
