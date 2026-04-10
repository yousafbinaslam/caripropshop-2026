<?php
/**
 * Property Card Widget - Displays a single property listing
 */

class CPS_Property_Card_Widget extends CPS_Base_Widget {

    public function get_name() {
        return 'cps_property_card';
    }

    public function get_title() {
        return __('Property Card', 'cari-prop-shop-builder');
    }

    public function get_icon() {
        return 'eicon-image-box';
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
            'property_post',
            [
                'label' => __('Select Property', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $this->get_property_posts_list(),
                'multiple' => false,
            ]
        );

        $this->add_control(
            'show_image',
            [
                'label' => __('Show Image', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Show', 'cari-prop-shop-builder'),
                'label_off' => __('Hide', 'cari-prop-shop-builder'),
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => __('Show Title', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Show', 'cari-prop-shop-builder'),
                'label_off' => __('Hide', 'cari-prop-shop-builder'),
            ]
        );

        $this->add_control(
            'show_price',
            [
                'label' => __('Show Price', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Show', 'cari-prop-shop-builder'),
                'label_off' => __('Hide', 'cari-prop-shop-builder'),
            ]
        );

        $this->add_control(
            'show_status',
            [
                'label' => __('Show Status', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Show', 'cari-prop-shop-builder'),
                'label_off' => __('Hide', 'cari-prop-shop-builder'),
            ]
        );

        $this->add_control(
            'show_features',
            [
                'label' => __('Show Features', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Show', 'cari-prop-shop-builder'),
                'label_off' => __('Hide', 'cari-prop-shop-builder'),
            ]
        );

        $this->add_control(
            'show_address',
            [
                'label' => __('Show Address', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Show', 'cari-prop-shop-builder'),
                'label_off' => __('Hide', 'cari-prop-shop-builder'),
            ]
        );

        $this->add_control(
            'show_button',
            [
                'label' => __('Show View Details Button', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Show', 'cari-prop-shop-builder'),
                'label_off' => __('Hide', 'cari-prop-shop-builder'),
            ]
        );

        $this->add_control(
            'show_badge',
            [
                'label' => __('Show Badge', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Show', 'cari-prop-shop-builder'),
                'label_off' => __('Hide', 'cari-prop-shop-builder'),
            ]
        );

        $this->add_control(
            'badge_text',
            [
                'label' => __('Badge Text', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Featured', 'cari-prop-shop-builder'),
                'condition' => ['show_badge' => 'yes'],
            ]
        );

        $this->add_control(
            'badge_style',
            [
                'label' => __('Badge Style', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'featured',
                'options' => [
                    'featured' => __('Featured', 'cari-prop-shop-builder'),
                    'new' => __('New', 'cari-prop-shop-builder'),
                    'hot' => __('Hot', 'cari-prop-shop-builder'),
                    'sale' => __('Sale', 'cari-prop-shop-builder'),
                ],
                'condition' => ['show_badge' => 'yes'],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'price_section',
            [
                'label' => __('Price Settings', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'price_prefix',
            [
                'label' => __('Currency Position', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => __('Before Price', 'cari-prop-shop-builder'),
                    'no' => __('After Price', 'cari-prop-shop-builder'),
                ],
            ]
        );

        $this->add_control(
            'price_suffix',
            [
                'label' => __('Price Suffix', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => __('e.g., /month, /sqft', 'cari-prop-shop-builder'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'card_style_section',
            [
                'label' => __('Card Style', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_background',
            [
                'label' => __('Background Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .cps-property-card' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'card_border_radius',
            [
                'label' => __('Border Radius', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => 8,
                    'right' => 8,
                    'bottom' => 8,
                    'left' => 8,
                ],
                'selectors' => [
                    '{{WRAPPER}} .cps-property-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'card_padding',
            [
                'label' => __('Padding', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .cps-property-card-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'card_box_shadow',
            [
                'label' => __('Box Shadow', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::BOX_SHADOW,
                'default' => [
                    'color' => 'rgba(0, 0, 0, 0.1)',
                    'horizontal' => 0,
                    'vertical' => 4,
                    'blur' => 10,
                    'spread' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .cps-property-card' => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'image_style_section',
            [
                'label' => __('Image Style', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'image_height',
            [
                'label' => __('Image Height', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 240,
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 150,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .cps-property-image' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label' => __('Border Radius', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => 8,
                    'right' => 8,
                    'bottom' => 0,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .cps-property-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'title_style_section',
            [
                'label' => __('Title Style', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1a1a1a',
                'selectors' => [
                    '{{WRAPPER}} .cps-property-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .cps-property-title',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'price_style_section',
            [
                'label' => __('Price Style', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label' => __('Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#2d2d2d',
                'selectors' => [
                    '{{WRAPPER}} .cps-property-price' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'selector' => '{{WRAPPER}} .cps-property-price',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'features_style_section',
            [
                'label' => __('Features Style', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'features_color',
            [
                'label' => __('Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .cps-features' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'features_icon_color',
            [
                'label' => __('Icon Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1a73e8',
                'selectors' => [
                    '{{WRAPPER}} .cps-feature-item i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'button_style_section',
            [
                'label' => __('Button Style', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => __('Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .cps-property-btn' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_background',
            [
                'label' => __('Background Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1a73e8',
                'selectors' => [
                    '{{WRAPPER}} .cps-property-btn' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label' => __('Hover Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .cps-property-btn:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_hover_background',
            [
                'label' => __('Hover Background', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1557b0',
                'selectors' => [
                    '{{WRAPPER}} .cps-property-btn:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => __('Border Radius', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 4,
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .cps-property-btn' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if (empty($settings['property_post'])) {
            echo $this->render_empty_state();
            return;
        }

        $property = get_post($settings['property_post']);
        if (!$property) {
            echo $this->render_empty_state();
            return;
        }

        $thumbnail = get_the_post_thumbnail_url($property->ID, 'large');
        $price = get_post_meta($property->ID, 'property_price', true);
        $status = get_post_meta($property->ID, 'property_status', true);
        $address = get_post_meta($property->ID, 'property_address', true);
        $bedrooms = get_post_meta($property->ID, 'property_bedrooms', true);
        $bathrooms = get_post_meta($property->ID, 'property_bathrooms', true);
        $sqft = get_post_meta($property->ID, 'property_sqft', true);
        $property_url = get_permalink($property->ID);
        ?>
        <div class="cps-property-card">
            <?php if ($settings['show_image'] === 'yes') : ?>
                <div class="cps-property-image">
                    <?php if ($thumbnail) : ?>
                        <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($property->post_title); ?>">
                    <?php else : ?>
                        <div class="cps-placeholder-image">
                            <i class="eicon-image"></i>
                        </div>
                    <?php endif; ?>
                    <?php $this->render_property_badge($settings); ?>
                </div>
            <?php endif; ?>

            <div class="cps-property-card-inner">
                <?php if ($settings['show_status'] === 'yes' && $status) : ?>
                    <div class="cps-property-status-wrapper">
                        <?php $this->render_property_status($status); ?>
                    </div>
                <?php endif; ?>

                <?php if ($settings['show_price'] === 'yes' && $price) : ?>
                    <div class="cps-property-price-wrapper">
                        <?php $this->render_property_price($price, $settings); ?>
                    </div>
                <?php endif; ?>

                <?php if ($settings['show_title'] === 'yes') : ?>
                    <h3 class="cps-property-title">
                        <a href="<?php echo esc_url($property_url); ?>">
                            <?php echo esc_html($property->post_title); ?>
                        </a>
                    </h3>
                <?php endif; ?>

                <?php if ($settings['show_address'] === 'yes' && $address) : ?>
                    <p class="cps-property-address">
                        <i class="eicon-map-pin"></i>
                        <?php echo esc_html($address); ?>
                    </p>
                <?php endif; ?>

                <?php if ($settings['show_features'] === 'yes') : ?>
                    <div class="cps-features">
                        <?php
                        $features = [];
                        if ($bedrooms) {
                            $features[] = [
                                'feature_icon' => 'eicon-heart',
                                'feature_value' => $bedrooms,
                                'feature_label' => __('bed', 'cari-prop-shop-builder'),
                            ];
                        }
                        if ($bathrooms) {
                            $features[] = [
                                'feature_icon' => 'eicon-snap中立',
                                'feature_value' => $bathrooms,
                                'feature_label' => __('bath', 'cari-prop-shop-builder'),
                            ];
                        }
                        if ($sqft) {
                            $features[] = [
                                'feature_icon' => 'eicon-maximize',
                                'feature_value' => number_format((int) $sqft),
                                'feature_label' => __('sqft', 'cari-prop-shop-builder'),
                            ];
                        }
                        $this->render_property_features($features);
                        ?>
                    </div>
                <?php endif; ?>

                <?php if ($settings['show_button'] === 'yes') : ?>
                    <a href="<?php echo esc_url($property_url); ?>" class="cps-property-btn">
                        <?php _e('View Details', 'cari-prop-shop-builder'); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    protected function render_empty_state() {
        ?>
        <div class="cps-property-card cps-empty">
            <div class="cps-empty-state">
                <i class="eicon-image-box"></i>
                <p><?php _e('Select a property from the widget settings', 'cari-prop-shop-builder'); ?></p>
            </div>
        </div>
        <?php
    }

    protected function get_property_posts_list() {
        $posts = get_posts([
            'post_type' => 'property',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ]);

        $options = ['' => __('Select a property', 'cari-prop-shop-builder')];
        foreach ($posts as $post) {
            $options[$post->ID] = $post->post_title;
        }

        return $options;
    }

    protected function content_template() {
        ?>

        <?php
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CPS_Property_Card_Widget());