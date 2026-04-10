<?php
/**
 * Property Grid Widget - Grid layout for property listings
 */

class CPS_Property_Grid_Widget extends CPS_Base_Widget {

    public function get_name() {
        return 'cps_property_grid';
    }

    public function get_title() {
        return __('Property Grid', 'cari-prop-shop-builder');
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
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
            'show_pagination',
            [
                'label' => __('Show Pagination', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'grid_section',
            [
                'label' => __('Grid Settings', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => __('Columns', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '2' => __('2 Columns', 'cari-prop-shop-builder'),
                    '3' => __('3 Columns', 'cari-prop-shop-builder'),
                    '4' => __('4 Columns', 'cari-prop-shop-builder'),
                ],
            ]
        );

        $this->add_control(
            'column_gap',
            [
                'label' => __('Column Gap', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 20,
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
            ]
        );

        $this->add_control(
            'row_gap',
            [
                'label' => __('Row Gap', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 20,
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'card_section',
            [
                'label' => __('Card Settings', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
            'show_title',
            [
                'label' => __('Show Title', 'cari-prop-shop-builder'),
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

        $this->add_control(
            'show_button',
            [
                'label' => __('Show Button', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'image_size',
            [
                'label' => __('Image Size', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'medium_large',
                'options' => [
                    'thumbnail' => __('Thumbnail', 'cari-prop-shop-builder'),
                    'medium' => __('Medium', 'cari-prop-shop-builder'),
                    'medium_large' => __('Medium Large', 'cari-prop-shop-builder'),
                    'large' => __('Large', 'cari-prop-shop-builder'),
                ],
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
                    '{{WRAPPER}} .cps-grid-card' => 'background-color: {{VALUE}}',
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
                'selectors' => [
                    '{{WRAPPER}} .cps-grid-card' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'card_padding',
            [
                'label' => __('Padding', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .cps-grid-card-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'card_box_shadow',
            [
                'label' => __('Shadow', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::BOX_SHADOW,
                'selectors' => [
                    '{{WRAPPER}} .cps-grid-card' => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}}',
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
        $column_gap = $settings['column_gap']['size'] ?? 20;
        $row_gap = $settings['row_gap']['size'] ?? 20;

        if (!$query->have_posts()) {
            echo '<p>' . __('No properties found.', 'cari-prop-shop-builder') . '</p>';
            return;
        }
        ?>
        <div class="cps-property-grid cps-cols-<?php echo esc_attr($settings['columns']); ?>" style="--column-gap: <?php echo esc_attr($column_gap); ?>px; --row-gap: <?php echo esc_attr($row_gap); ?>px;">
            <?php while ($query->have_posts()) : $query->the_post();
                global $post;
                $thumbnail = get_the_post_thumbnail_url($post->ID, $settings['image_size']);
                $price = get_post_meta($post->ID, 'property_price', true);
                $status = get_post_meta($post->ID, 'property_status', true);
                $address = get_post_meta($post->ID, 'property_address', true);
                $bedrooms = get_post_meta($post->ID, 'property_bedrooms', true);
                $bathrooms = get_post_meta($post->ID, 'property_bathrooms', true);
                $sqft = get_post_meta($post->ID, 'property_sqft', true);
                ?>
                <div class="cps-grid-card">
                    <?php if ($settings['show_image'] === 'yes') : ?>
                        <div class="cps-grid-image">
                            <?php if ($thumbnail) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($post->post_title); ?>">
                                </a>
                            <?php else : ?>
                                <div class="cps-placeholder">
                                    <i class="eicon-image"></i>
                                </div>
                            <?php endif; ?>
                            <?php if ($status) : ?>
                                <span class="cps-property-status"><?php echo esc_html($status); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="cps-grid-card-inner">
                        <?php if ($settings['show_price'] === 'yes' && $price) : ?>
                            <span class="cps-grid-price">
                                <?php $this->render_property_price($price, $settings); ?>
                            </span>
                        <?php endif; ?>

                        <?php if ($settings['show_title'] === 'yes') : ?>
                            <h4 class="cps-grid-title">
                                <a href="<?php the_permalink(); ?>"><?php echo esc_html($post->post_title); ?></a>
                            </h4>
                        <?php endif; ?>

                        <?php if ($settings['show_address'] === 'yes' && $address) : ?>
                            <p class="cps-grid-address">
                                <i class="eicon-map-pin"></i>
                                <?php echo esc_html($address); ?>
                            </p>
                        <?php endif; ?>

                        <?php if ($settings['show_features'] === 'yes') : ?>
                            <div class="cps-grid-features">
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

                        <?php if ($settings['show_button'] === 'yes') : ?>
                            <a href="<?php the_permalink(); ?>" class="cps-grid-btn">
                                <?php _e('View Details', 'cari-prop-shop-builder'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <?php if ($settings['show_pagination'] === 'yes') : ?>
            <div class="cps-pagination">
                <?php
                echo paginate_links([
                    'total' => $query->max_num_pages,
                    'current' => max(1, get_query_var('paged')),
                    'prev_text' => __('&laquo;', 'cari-prop-shop-builder'),
                    'next_text' => __('&raquo;', 'cari-prop-shop-builder'),
                ]);
                ?>
            </div>
        <?php endif; ?>

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

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CPS_Property_Grid_Widget());