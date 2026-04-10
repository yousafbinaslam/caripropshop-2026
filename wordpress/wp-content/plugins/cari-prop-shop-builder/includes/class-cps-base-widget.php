<?php
/**
 * Base Widget class for CariPropShop Builder
 * 
 * Provides common functionality for all custom Elementor widgets
 */

abstract class CPS_Base_Widget extends \Elementor\Widget_Base {

    protected function get_currency_symbol() {
        return get_option('cps_builder_currency_symbol', '$');
    }

    protected function render_property_badge($settings) {
        if ($settings['show_badge'] !== 'yes') {
            return;
        }

        $badge_text = $settings['badge_text'];
        if (empty($badge_text)) {
            $badge_text = __('Featured', 'cari-prop-shop-builder');
        }
        ?>
        <span class="cps-property-badge cps-badge-<?php echo esc_attr($settings['badge_style']); ?>">
            <?php echo esc_html($badge_text); ?>
        </span>
        <?php
    }

    protected function render_property_status($status) {
        if (empty($status)) {
            return;
        }
        ?>
        <span class="cps-property-status">
            <?php echo esc_html($status); ?>
        </span>
        <?php
    }

    protected function render_property_price($price, $settings) {
        if (empty($price)) {
            return;
        }

        $currency = $this->get_currency_symbol();
        $price_display = number_format((float) $price, 0, '.', ',');

        if ($settings['price_prefix'] === 'yes') {
            $price_display = $currency . $price_display;
        } else {
            $price_display = $price_display . $currency;
        }

        if ($settings['price_suffix']) {
            $price_display .= ' ' . $settings['price_suffix'];
        }
        ?>
        <span class="cps-property-price">
            <?php echo esc_html($price_display); ?>
        </span>
        <?php
    }

    protected function render_property_features($features) {
        if (empty($features) || !is_array($features)) {
            return;
        }

        foreach ($features as $feature) {
            if (empty($feature['feature_icon']) || empty($feature['feature_value'])) {
                continue;
            }
            ?>
            <span class="cps-feature-item">
                <?php if (!empty($feature['feature_icon'])) : ?>
                    <i class="<?php echo esc_attr($feature['feature_icon']); ?>"></i>
                <?php endif; ?>
                <span><?php echo esc_html($feature['feature_value']); ?></span>
                <?php if (!empty($feature['feature_label'])) : ?>
                    <span class="cps-feature-label"><?php echo esc_html($feature['feature_label']); ?></span>
                <?php endif; ?>
            </span>
            <?php
        }
    }

    protected function get_post_types() {
        $post_types = get_post_types(['public' => true], 'objects');
        $exclude = ['attachment', 'elementor_library'];

        $types = [];
        foreach ($post_types as $post_type) {
            if (in_array($post_type->name, $exclude)) {
                continue;
            }
            $types[$post_type->name] = $post_type->label;
        }

        return $types;
    }

    protected function get_property_posts($settings) {
        $args = [
            'post_type' => $settings['post_type'],
            'posts_per_page' => $settings['posts_per_page'],
            'post_status' => 'publish',
        ];

        if (!empty($settings['selected_posts'])) {
            $args['post__in'] = $settings['selected_posts'];
            $args['orderby'] = 'post__in';
        } else {
            if (!empty($settings['categories'])) {
                $args['tax_query'] = [
                    [
                        'taxonomy' => 'property_category',
                        'field' => 'term_id',
                        'terms' => $settings['categories'],
                    ],
                ];
            }

            $args['orderby'] = $settings['orderby'];
            $args['order'] = $settings['order'];
        }

        $query = new \WP_Query($args);
        return $query;
    }

    protected function get_property_types() {
        $types = get_terms([
            'taxonomy' => 'property_type',
            'hide_empty' => true,
        ]);

        $options = [];
        if (!is_wp_error($types)) {
            foreach ($types as $type) {
                $options[$type->term_id] = $type->name;
            }
        }

        return $options;
    }

    protected function get_property_statuses() {
        return [
            'for_sale' => __('For Sale', 'cari-prop-shop-builder'),
            'for_rent' => __('For Rent', 'cari-prop-shop-builder'),
            'sold' => __('Sold', 'cari-prop-shop-builder'),
            'pending' => __('Pending', 'cari-prop-shop-builder'),
            'new' => __('New', 'cari-prop-shop-builder'),
            'reduced' => __('Reduced', 'cari-prop-shop-builder'),
        ];
    }

    protected function get_agents() {
        $agents = get_posts([
            'post_type' => 'agent',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ]);

        $options = [];
        foreach ($agents as $agent) {
            $options[$agent->ID] = $agent->post_title;
        }

        return $options;
    }

    protected function render_inquiry_form($property_id = 0) {
        ?>
        <form class="cps-inquiry-form" method="post">
            <input type="hidden" name="property_id" value="<?php echo esc_attr($property_id); ?>">
            <div class="cps-form-group">
                <label for="cps_inquiry_name"><?php _e('Name *', 'cari-prop-shop-builder'); ?></label>
                <input type="text" id="cps_inquiry_name" name="name" required>
            </div>
            <div class="cps-form-group">
                <label for="cps_inquiry_email"><?php _e('Email *', 'cari-prop-shop-builder'); ?></label>
                <input type="email" id="cps_inquiry_email" name="email" required>
            </div>
            <div class="cps-form-group">
                <label for="cps_inquiry_phone"><?php _e('Phone', 'cari-prop-shop-builder'); ?></label>
                <input type="tel" id="cps_inquiry_phone" name="phone">
            </div>
            <div class="cps-form-group">
                <label for="cps_inquiry_message"><?php _e('Message *', 'cari-prop-shop-builder'); ?></label>
                <textarea id="cps_inquiry_message" name="message" rows="4" required></textarea>
            </div>
            <button type="submit" class="cps-submit-btn">
                <?php _e('Send Inquiry', 'cari-prop-shop-builder'); ?>
            </button>
            <div class="cps-form-response"></div>
        </form>
        <?php
    }

    protected function render_button_html($settings, $classes = '') {
        $this->add_render_attribute('button', 'class', 'elementor-button ' . $classes);
        $this->add_render_attribute('button', 'href', $settings['button_url']);

        if ($settings['button_animation']) {
            $this->add_render_attribute('button', 'data-animation', $settings['button_animation']);
        }
        ?>
        <a <?php echo $this->get_render_attribute_string('button'); ?>>
            <?php if ($settings['button_icon']) : ?>
                <i class="<?php echo esc_attr($settings['button_icon']); ?>"></i>
            <?php endif; ?>
            <span><?php echo esc_html($settings['button_text']); ?></span>
        </a>
        <?php
    }
}