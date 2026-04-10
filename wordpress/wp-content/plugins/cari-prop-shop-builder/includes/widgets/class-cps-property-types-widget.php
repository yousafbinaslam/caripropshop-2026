<?php
/**
 * Property Types Widget - Property type categories display
 */

class CPS_Property_Types_Widget extends CPS_Base_Widget {

    public function get_name() {
        return 'cps_property_types';
    }

    public function get_title() {
        return __('Property Types', 'cari-prop-shop-builder');
    }

    public function get_icon() {
        return 'eicon-folder';
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
            'property_types',
            [
                'label' => __('Property Types', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->get_property_types_terms(),
            ]
        );

        $this->add_control(
            'show_count',
            [
                'label' => __('Show Property Count', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_description',
            [
                'label' => __('Show Description', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'layout',
            [
                'label' => __('Layout', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => [
                    'grid' => __('Grid', 'cari-prop-shop-builder'),
                    'list' => __('List', 'cari-prop-shop-builder'),
                    'carousel' => __('Carousel', 'cari-prop-shop-builder'),
                ],
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
                'condition' => ['layout' => 'grid'],
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
            'image_source',
            [
                'label' => __('Image Source', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'icon',
                'options' => [
                    'icon' => __('Taxonomy Image', 'cari-prop-shop-builder'),
                    'featured' => __('Featured Property', 'cari-prop-shop-builder'),
                ],
                'condition' => ['show_image' => 'yes'],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'cari-prop-shop-builder'),
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
                    '{{WRAPPER}} .cps-type-card' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .cps-type-card' => 'border-radius: {{SIZE}}{{UNIT}}',
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
                    'top' => 24,
                    'right' => 24,
                    'bottom' => 24,
                    'left' => 24,
                ],
                'selectors' => [
                    '{{WRAPPER}} .cps-type-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'card_hover_background',
            [
                'label' => __('Hover Background', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cps-type-card:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __('Icon Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1a73e8',
                'selectors' => [
                    '{{WRAPPER}} .cps-type-icon' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1a1a1a',
                'selectors' => [
                    '{{WRAPPER}} .cps-type-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'count_color',
            [
                'label' => __('Count Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .cps-type-count' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $args = [
            'taxonomy' => 'property_type',
            'hide_empty' => true,
        ];

        if (!empty($settings['property_types'])) {
            $args['include'] = $settings['property_types'];
        }

        $terms = get_terms($args);

        if (is_wp_error($terms) || empty($terms)) {
            echo '<p>' . __('No property types found.', 'cari-prop-shop-builder') . '</p>';
            return;
        }
        ?>
        <div class="cps-property-types cps-layout-<?php echo esc_attr($settings['layout']); ?> cps-cols-<?php echo esc_attr($settings['columns']); ?>">
            <?php foreach ($terms as $term) :
                $image = '';
                $icon = get_term_meta($term->term_id, 'property_type_icon', true);
                $count = $term->count;

                if ($settings['show_image'] === 'yes' && $settings['image_source'] === 'icon') {
                    $icon = $icon ?: 'eicon-folder';
                } elseif ($settings['show_image'] === 'yes' && $settings['image_source'] === 'featured') {
                    $featured_args = [
                        'post_type' => 'property',
                        'posts_per_page' => 1,
                        'post_status' => 'publish',
                        'tax_query' => [
                            [
                                'taxonomy' => 'property_type',
                                'field' => 'term_id',
                                'terms' => $term->term_id,
                            ],
                        ],
                    ];
                    $featured_query = new \WP_Query($featured_args);
                    if ($featured_query->have_posts()) {
                        $featured_query->the_post();
                        $image = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
                        wp_reset_postdata();
                    }
                }

                $term_link = get_term_link($term);
                ?>
                <div class="cps-type-card">
                    <a href="<?php echo esc_url($term_link); ?>">
                        <?php if ($settings['show_image'] === 'yes') : ?>
                            <div class="cps-type-image">
                                <?php if ($image) : ?>
                                    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($term->name); ?>">
                                <?php elseif ($icon) : ?>
                                    <div class="cps-type-icon">
                                        <i class="<?php echo esc_attr($icon); ?>"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <h4 class="cps-type-title"><?php echo esc_html($term->name); ?></h4>

                        <?php if ($settings['show_description'] === 'yes' && $term->description) : ?>
                            <p class="cps-type-description"><?php echo esc_html($term->description); ?></p>
                        <?php endif; ?>

                        <?php if ($settings['show_count'] === 'yes') : ?>
                            <span class="cps-type-count">
                                <?php printf(_n('%d Property', '%d Properties', $count, 'cari-prop-shop-builder'), $count); ?>
                            </span>
                        <?php endif; ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }

    protected function get_property_types_terms() {
        $terms = get_terms([
            'taxonomy' => 'property_type',
            'hide_empty' => true,
        ]);

        $options = [];
        if (!is_wp_error($terms)) {
            foreach ($terms as $term) {
                $options[$term->term_id] = $term->name;
            }
        }

        return $options;
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CPS_Property_Types_Widget());