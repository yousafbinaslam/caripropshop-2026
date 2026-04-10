<?php
/**
 * Property Slider Widget - Carousel/Slider widget for property listings
 */

class CPS_Property_Slider_Widget extends CPS_Base_Widget {

    public function get_name() {
        return 'cps_property_slider';
    }

    public function get_title() {
        return __('Property Slider', 'cari-prop-shop-builder');
    }

    public function get_icon() {
        return 'eicon-slider-album';
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
            'post_type',
            [
                'label' => __('Post Type', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'property',
                'options' => $this->get_post_types(),
            ]
        );

        $this->add_control(
            'selected_posts',
            [
                'label' => __('Select Properties', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->get_properties_list(),
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Posts Per Page', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => __('Order By', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date' => __('Date', 'cari-prop-shop-builder'),
                    'title' => __('Title', 'cari-prop-shop-builder'),
                    'modified' => __('Modified', 'cari-prop-shop-builder'),
                    'rand' => __('Random', 'cari-prop-shop-builder'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __('Order', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'DESC' => __('Descending', 'cari-prop-shop-builder'),
                    'ASC' => __('Ascending', 'cari-prop-shop-builder'),
                ],
            ]
        );

        $this->add_control(
            'show_image',
            [
                'label' => __('Show Image', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_price',
            [
                'label' => __('Show Price', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => __('Show Title', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_address',
            [
                'label' => __('Show Address', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_features',
            [
                'label' => __('Show Features', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'slider_section',
            [
                'label' => __('Slider Settings', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'slides_to_show',
            [
                'label' => __('Slides to Show', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 3,
            ]
        );

        $this->add_control(
            'slides_to_scroll',
            [
                'label' => __('Slides to Scroll', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 1,
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => __('Autoplay', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => __('Autoplay Speed (ms)', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 3000,
                'condition' => ['autoplay' => 'yes'],
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label' => __('Pause on Hover', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => ['autoplay' => 'yes'],
            ]
        );

        $this->add_control(
            'infinite',
            [
                'label' => __('Infinite Loop', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_arrows',
            [
                'label' => __('Show Arrows', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_dots',
            [
                'label' => __('Show Dots', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'center_mode',
            [
                'label' => __('Center Mode', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
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
                'label' => __('Background', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .cps-slider-card' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'card_border_radius',
            [
                'label' => __('Border Radius', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 8,
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .cps-slider-card' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'card_padding',
            [
                'label' => __('Padding', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .cps-slider-card-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'card_margin',
            [
                'label' => __('Margin', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default' => [
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .cps-slider-card' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'card_box_shadow',
            [
                'label' => __('Shadow', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::BOX_SHADOW,
                'selectors' => [
                    '{{WRAPPER}} .cps-slider-card' => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}}',
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
                'label' => __('Height', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 220,
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 150,
                        'max' => 400,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .cps-slider-image' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'navigation_style_section',
            [
                'label' => __('Navigation Style', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'arrow_color',
            [
                'label' => __('Arrow Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'arrow_background',
            [
                'label' => __('Arrow Background', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'arrow_hover_color',
            [
                'label' => __('Arrow Hover Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'arrow_hover_background',
            [
                'label' => __('Arrow Hover Background', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1a73e8',
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'dots_color',
            [
                'label' => __('Dots Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#cccccc',
                'selectors' => [
                    '{{WRAPPER}} .slick-dots li button' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'active_dots_color',
            [
                'label' => __('Active Dots Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1a73e8',
                'selectors' => [
                    '{{WRAPPER}} .slick-dots li.slick-active button' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $args = [
            'post_type' => $settings['post_type'],
            'posts_per_page' => $settings['posts_per_page'],
            'post_status' => 'publish',
        ];

        if (!empty($settings['selected_posts'])) {
            $args['post__in'] = $settings['selected_posts'];
            $args['orderby'] = 'post__in';
        } else {
            $args['orderby'] = $settings['orderby'];
            $args['order'] = $settings['order'];
        }

        $query = new \WP_Query($args);

        if (!$query->have_posts()) {
            echo '<p>' . __('No properties found.', 'cari-prop-shop-builder') . '</p>';
            return;
        }

        $slider_config = [
            'slidesToShow' => $settings['slides_to_show'] ?? 3,
            'slidesToScroll' => $settings['slides_to_scroll'] ?? 1,
            'autoplay' => $settings['autoplay'] === 'yes',
            'autoplaySpeed' => $settings['autoplay_speed'] ?? 3000,
            'pauseOnHover' => $settings['pause_on_hover'] === 'yes',
            'infinite' => $settings['infinite'] === 'yes',
            'arrows' => $settings['show_arrows'] === 'yes',
            'dots' => $settings['show_dots'] === 'yes',
            'centerMode' => $settings['center_mode'] === 'yes',
            'responsive' => [
                [
                    'breakpoint' => 1024,
                    'settings' => [
                        'slidesToShow' => 2,
                        'slidesToScroll' => 1,
                    ],
                ],
                [
                    'breakpoint' => 768,
                    'settings' => [
                        'slidesToShow' => 1,
                        'slidesToScroll' => 1,
                    ],
                ],
            ],
        ];
        ?>
        <div class="cps-property-slider" data-slider-config='<?php echo json_encode($slider_config); ?>'>
            <?php while ($query->have_posts()) : $query->the_post();
                global $post;
                $thumbnail = get_the_post_thumbnail_url($post->ID, 'medium_large');
                $price = get_post_meta($post->ID, 'property_price', true);
                $address = get_post_meta($post->ID, 'property_address', true);
                $bedrooms = get_post_meta($post->ID, 'property_bedrooms', true);
                $bathrooms = get_post_meta($post->ID, 'property_bathrooms', true);
                $sqft = get_post_meta($post->ID, 'property_sqft', true);
                ?>
                <div class="cps-slider-card">
                    <?php if ($settings['show_image'] === 'yes') : ?>
                        <div class="cps-slider-image">
                            <?php if ($thumbnail) : ?>
                                <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($post->post_title); ?>">
                            <?php else : ?>
                                <div class="cps-placeholder">
                                    <i class="eicon-image"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="cps-slider-card-inner">
                        <?php if ($settings['show_price'] === 'yes' && $price) : ?>
                            <span class="cps-slider-price">
                                <?php $this->render_property_price($price, $settings); ?>
                            </span>
                        <?php endif; ?>

                        <?php if ($settings['show_title'] === 'yes') : ?>
                            <h4 class="cps-slider-title">
                                <a href="<?php the_permalink(); ?>"><?php echo esc_html($post->post_title); ?></a>
                            </h4>
                        <?php endif; ?>

                        <?php if ($settings['show_address'] === 'yes' && $address) : ?>
                            <p class="cps-slider-address">
                                <i class="eicon-map-pin"></i>
                                <?php echo esc_html($address); ?>
                            </p>
                        <?php endif; ?>

                        <?php if ($settings['show_features'] === 'yes') : ?>
                            <div class="cps-slider-features">
                                <?php
                                $features = [];
                                if ($bedrooms) {
                                    $features[] = ['feature_icon' => 'fa fa-bed', 'feature_value' => $bedrooms, 'feature_label' => __('Beds', 'cari-prop-shop-builder')];
                                }
                                if ($bathrooms) {
                                    $features[] = ['feature_icon' => 'fa fa-bath', 'feature_value' => $bathrooms, 'feature_label' => __('Baths', 'cari-prop-shop-builder')];
                                }
                                if ($sqft) {
                                    $features[] = ['feature_icon' => 'fa fa-arrows-alt', 'feature_value' => number_format((int) $sqft), 'feature_label' => __('sqft', 'cari-prop-shop-builder')];
                                }
                                $this->render_property_features($features);
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php
        wp_reset_postdata();
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

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CPS_Property_Slider_Widget());