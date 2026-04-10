<?php
/**
 * Property Map Widget - Map display for properties
 */

class CPS_Property_Map_Widget extends CPS_Base_Widget {

    public function get_name() {
        return 'cps_property_map';
    }

    public function get_title() {
        return __('Property Map', 'cari-prop-shop-builder');
    }

    public function get_icon() {
        return 'eicon-map-marker';
    }

    public function get_categories() {
        return ['cari_prop_shop_category'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'map_provider',
            [
                'label' => __('Map Provider', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'google',
                'options' => [
                    'google' => __('Google Maps', 'cari-prop-shop-builder'),
                    'mapbox' => __('Mapbox', 'cari-prop-shop-builder'),
                ],
            ]
        );

        $this->add_control(
            'properties',
            [
                'label' => __('Properties', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->get_properties_list(),
            ]
        );

        $this->add_control(
            'map_height',
            [
                'label' => __('Map Height', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 500,
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 300,
                        'max' => 800,
                    ],
                ],
            ]
        );

        $this->add_control(
            'map_zoom',
            [
                'label' => __('Default Zoom', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 12,
            ]
        );

        $this->add_control(
            'map_style',
            [
                'label' => __('Map Style', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => __('Default', 'cari-prop-shop-builder'),
                    'silver' => __('Silver', 'cari-prop-shop-builder'),
                    'retro' => __('Retro', 'cari-prop-shop-builder'),
                    'dark' => __('Dark', 'cari-prop-shop-builder'),
                    'night' => __('Night', 'cari-prop-shop-builder'),
                    'standard' => __('Standard (Mapbox)', 'cari-prop-shop-builder'),
                ],
            ]
        );

        $this->add_control(
            'show_marker_tooltip',
            [
                'label' => __('Show Marker Tooltip', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'marker_icon_type',
            [
                'label' => __('Marker Icon', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => __('Default', 'cari-prop-shop-builder'),
                    'custom' => __('Custom Image', 'cari-prop-shop-builder'),
                    'price' => __('Show Price', 'cari-prop-shop-builder'),
                ],
            ]
        );

        $this->add_control(
            'custom_marker',
            [
                'label' => __('Custom Marker Image', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'condition' => ['marker_icon_type' => 'custom'],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'controls_section',
            [
                'label' => __('Map Controls', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_zoom',
            [
                'label' => __('Show Zoom Controls', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_type',
            [
                'label' => __('Show Map Type', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_fullscreen',
            [
                'label' => __('Show Fullscreen', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $map_height = $settings['map_height']['size'] ?? 500;
        ?>
        <div class="cps-property-map-widget">
            <div class="cps-map-container" 
                 data-provider="<?php echo esc_attr($settings['map_provider']); ?>"
                 data-map-style="<?php echo esc_attr($settings['map_style']); ?>"
                 data-zoom="<?php echo esc_attr($settings['map_zoom']); ?>"
                 data-show-tooltip="<?php echo esc_attr($settings['show_marker_tooltip']); ?>"
                 data-marker-type="<?php echo esc_attr($settings['marker_icon_type']); ?>"
                 data-zoom-control="<?php echo esc_attr($settings['show_zoom']); ?>"
                 data-type-control="<?php echo esc_attr($settings['show_type']); ?>"
                 data-fullscreen="<?php echo esc_attr($settings['show_fullscreen']); ?>"
                 style="height: <?php echo esc_attr($map_height); ?>px;">
                
                <?php if (!empty($settings['properties'])) : ?>
                    <div class="cps-map-markers" style="display: none;">
                        <?php foreach ($settings['properties'] as $property_id) : ?>
                            <?php
                            $lat = get_post_meta($property_id, 'property_latitude', true);
                            $lng = get_post_meta($property_id, 'property_longitude', true);
                            $price = get_post_meta($property_id, 'property_price', true);
                            $address = get_post_meta($property_id, 'property_address', true);
                            $title = get_post_title($property_id);
                            $thumbnail = get_the_post_thumbnail_url($property_id, 'medium');
                            
                            if ($lat && $lng) :
                            ?>
                            <div class="cps-map-marker" 
                                 data-lat="<?php echo esc_attr($lat); ?>" 
                                 data-lng="<?php echo esc_attr($lng); ?>"
                                 data-title="<?php echo esc_attr($title); ?>"
                                 data-price="<?php echo esc_attr($price); ?>"
                                 data-address="<?php echo esc_attr($address); ?>"
                                 data-image="<?php echo esc_url($thumbnail); ?>"
                                 data-url="<?php echo esc_url(get_permalink($property_id)); ?>">
                            </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <div class="cps-map-placeholder">
                    <i class="eicon-map-marker"></i>
                    <p><?php _e('Map will display here', 'cari-prop-shop-builder'); ?></p>
                </div>
            </div>
            
            <?php if ($settings['show_marker_tooltip'] === 'yes') : ?>
                <div class="cps-map-tooltip" style="display: none;">
                    <div class="cps-tooltip-image">
                        <img src="" alt="">
                    </div>
                    <div class="cps-tooltip-content">
                        <h4></h4>
                        <p class="cps-tooltip-address"></p>
                        <span class="cps-tooltip-price"></span>
                        <a href=""><?php _e('View Details', 'cari-prop-shop-builder'); ?></a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }

    protected function get_properties_list() {
        $posts = get_posts([
            'post_type' => 'property',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ]);

        $options = [];
        foreach ($posts as $post) {
            $options[$post->ID] = $post->post_title;
        }

        return $options;
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CPS_Property_Map_Widget());