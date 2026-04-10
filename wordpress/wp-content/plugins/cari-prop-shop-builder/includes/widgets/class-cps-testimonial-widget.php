<?php
/**
 * Testimonial Widget - Client testimonials display
 */

class CPS_Testimonial_Widget extends CPS_Base_Widget {

    public function get_name() {
        return 'cps_testimonial';
    }

    public function get_title() {
        return __('Testimonials', 'cari-prop-shop-builder');
    }

    public function get_icon() {
        return 'eicon-testimonial';
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

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'testimonial_content',
            [
                'label' => __('Content', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 4,
            ]
        );

        $repeater->add_control(
            'testimonial_author',
            [
                'label' => __('Author', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'testimonial_role',
            [
                'label' => __('Role/Position', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'testimonial_avatar',
            [
                'label' => __('Avatar', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::MEDIA,
            ]
        );

        $repeater->add_control(
            'testimonial_rating',
            [
                'label' => __('Rating', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 5,
                'default' => 5,
            ]
        );

        $this->add_control(
            'testimonials',
            [
                'label' => __('Testimonials', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'testimonial_content' => __('The team made my first home buying experience amazing! They were patient, knowledgeable, and always available to answer my questions.', 'cari-prop-shop-builder'),
                        'testimonial_author' => __('Sarah Johnson', 'cari-prop-shop-builder'),
                        'testimonial_role' => __('Homeowner', 'cari-prop-shop-builder'),
                        'testimonial_rating' => 5,
                    ],
                    [
                        'testimonial_content' => __('Professional and efficient service. Found my dream apartment within weeks. Highly recommend!', 'cari-prop-shop-builder'),
                        'testimonial_author' => __('Michael Chen', 'cari-prop-shop-builder'),
                        'testimonial_role' => __('Property Investor', 'cari-prop-shop-builder'),
                        'testimonial_rating' => 5,
                    ],
                ],
            ]
        );

        $this->add_control(
            'layout',
            [
                'label' => __('Layout', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'slider',
                'options' => [
                    'slider' => __('Slider', 'cari-prop-shop-builder'),
                    'grid' => __('Grid', 'cari-prop-shop-builder'),
                ],
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => __('Columns', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 2,
                'options' => [
                    '1' => __('1 Column', 'cari-prop-shop-builder'),
                    '2' => __('2 Columns', 'cari-prop-shop-builder'),
                    '3' => __('3 Columns', 'cari-prop-shop-builder'),
                ],
                'condition' => ['layout' => 'grid'],
            ]
        );

        $this->add_control(
            'show_rating',
            [
                'label' => __('Show Rating', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_avatar',
            [
                'label' => __('Show Avatar', 'cari-prop-shop-builder'),
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
                'condition' => ['layout' => 'slider'],
            ]
        );

        $this->add_control(
            'slides_to_show',
            [
                'label' => __('Slides to Show', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 2,
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
                'label' => __('Autoplay Speed', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5000,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'box_style_section',
            [
                'label' => __('Box Style', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'box_background',
            [
                'label' => __('Background', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .cps-testimonial-item' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label' => __('Border Radius', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 8,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .cps-testimonial-item' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'box_padding',
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
                    '{{WRAPPER}} .cps-testimonial-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'box_shadow',
            [
                'label' => __('Shadow', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::BOX_SHADOW,
                'selectors' => [
                    '{{WRAPPER}} .cps-testimonial-item' => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'content_style_section',
            [
                'label' => __('Content Style', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => __('Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .cps-testimonial-content' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .cps-testimonial-content',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'author_style_section',
            [
                'label' => __('Author Style', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'author_color',
            [
                'label' => __('Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1a1a1a',
                'selectors' => [
                    '{{WRAPPER}} .cps-testimonial-author' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'role_color',
            [
                'label' => __('Role Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#999999',
                'selectors' => [
                    '{{WRAPPER}} .cps-testimonial-role' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'rating_color',
            [
                'label' => __('Rating Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fbbc04',
                'selectors' => [
                    '{{WRAPPER}} .cps-testimonial-rating i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="cps-testimonial-widget cps-testimonial-layout-<?php echo esc_attr($settings['layout']); ?>">
            <?php if ($settings['layout'] === 'slider') : ?>
                <div class="cps-testimonial-slider" data-slides="<?php echo esc_attr($settings['slides_to_show']); ?>" data-autoplay="<?php echo esc_attr($settings['autoplay']); ?>" data-speed="<?php echo esc_attr($settings['autoplay_speed']); ?>">
                    <?php foreach ($settings['testimonials'] as $testimonial) : ?>
                        <div class="cps-testimonial-item">
                            <?php if ($settings['show_rating'] === 'yes' && !empty($testimonial['testimonial_rating'])) : ?>
                                <div class="cps-testimonial-rating">
                                    <?php for ($i = 0; $i < $testimonial['testimonial_rating']; $i++) : ?>
                                        <i class="eicon-star"></i>
                                    <?php endfor; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($testimonial['testimonial_content'])) : ?>
                                <p class="cps-testimonial-content"><?php echo esc_html($testimonial['testimonial_content']); ?></p>
                            <?php endif; ?>

                            <div class="cps-testimonial-author-info">
                                <?php if ($settings['show_avatar'] === 'yes' && !empty($testimonial['testimonial_avatar']['url'])) : ?>
                                    <div class="cps-testimonial-avatar">
                                        <img src="<?php echo esc_url($testimonial['testimonial_avatar']['url']); ?>" alt="<?php echo esc_attr($testimonial['testimonial_author']); ?>">
                                    </div>
                                <?php endif; ?>

                                <div class="cps-testimonial-author-meta">
                                    <?php if (!empty($testimonial['testimonial_author'])) : ?>
                                        <span class="cps-testimonial-author"><?php echo esc_html($testimonial['testimonial_author']); ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($testimonial['testimonial_role'])) : ?>
                                        <span class="cps-testimonial-role"><?php echo esc_html($testimonial['testimonial_role']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="cps-testimonial-grid cps-cols-<?php echo esc_attr($settings['columns']); ?>">
                    <?php foreach ($settings['testimonials'] as $testimonial) : ?>
                        <div class="cps-testimonial-item">
                            <?php if ($settings['show_rating'] === 'yes' && !empty($testimonial['testimonial_rating'])) : ?>
                                <div class="cps-testimonial-rating">
                                    <?php for ($i = 0; $i < $testimonial['testimonial_rating']; $i++) : ?>
                                        <i class="eicon-star"></i>
                                    <?php endfor; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($testimonial['testimonial_content'])) : ?>
                                <p class="cps-testimonial-content"><?php echo esc_html($testimonial['testimonial_content']); ?></p>
                            <?php endif; ?>

                            <div class="cps-testimonial-author-info">
                                <?php if ($settings['show_avatar'] === 'yes' && !empty($testimonial['testimonial_avatar']['url'])) : ?>
                                    <div class="cps-testimonial-avatar">
                                        <img src="<?php echo esc_url($testimonial['testimonial_avatar']['url']); ?>" alt="<?php echo esc_attr($testimonial['testimonial_author']); ?>">
                                    </div>
                                <?php endif; ?>

                                <div class="cps-testimonial-author-meta">
                                    <?php if (!empty($testimonial['testimonial_author'])) : ?>
                                        <span class="cps-testimonial-author"><?php echo esc_html($testimonial['testimonial_author']); ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($testimonial['testimonial_role'])) : ?>
                                        <span class="cps-testimonial-role"><?php echo esc_html($testimonial['testimonial_role']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CPS_Testimonial_Widget());