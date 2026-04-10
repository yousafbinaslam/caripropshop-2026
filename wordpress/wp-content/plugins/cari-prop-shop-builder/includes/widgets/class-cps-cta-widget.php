<?php
/**
 * CTA Widget - Call to Action widget
 */

class CPS_CTA_Widget extends CPS_Base_Widget {

    public function get_name() {
        return 'cps_cta';
    }

    public function get_title() {
        return __('Call to Action', 'cari-prop-shop-builder');
    }

    public function get_icon() {
        return 'eicon-call-to-action';
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
            'cta_style',
            [
                'label' => __('Style', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => __('Default', 'cari-prop-shop-builder'),
                    'centered' => __('Centered', 'cari-prop-shop-builder'),
                    'split' => __('Split Layout', 'cari-prop-shop-builder'),
                ],
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Find Your Dream Home Today', 'cari-prop-shop-builder'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label' => __('Subtitle', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Browse our collection of premium properties and find the perfect home for you and your family.', 'cari-prop-shop-builder'),
                'rows' => 3,
            ]
        );

        $this->add_control(
            'show_bg_image',
            [
                'label' => __('Background Image', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'bg_image',
            [
                'label' => __('Image', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'condition' => ['show_bg_image' => 'yes'],
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('View Properties', 'cari-prop-shop-builder'),
            ]
        );

        $this->add_control(
            'button_url',
            [
                'label' => __('Button URL', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => ['url' => get_post_type_archive_link('property')],
            ]
        );

        $this->add_control(
            'button_icon',
            [
                'label' => __('Button Icon', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => ['value' => 'fas fa-arrow-right', 'library' => 'fa-solid'],
            ]
        );

        $this->add_control(
            'secondary_button',
            [
                'label' => __('Show Secondary Button', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );

        $this->add_control(
            'secondary_button_text',
            [
                'label' => __('Secondary Button Text', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Contact Us', 'cari-prop-shop-builder'),
                'condition' => ['secondary_button' => 'yes'],
            ]
        );

        $this->add_control(
            'secondary_button_url',
            [
                'label' => __('Secondary Button URL', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::URL,
                'condition' => ['secondary_button' => 'yes'],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'overlay_section',
            [
                'label' => __('Overlay', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'overlay_color',
            [
                'label' => __('Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0.6)',
                'selectors' => [
                    '{{WRAPPER}} .cps-cta-overlay' => 'background-color: {{VALUE}}',
                ],
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
                'selectors' => [
                    '{{WRAPPER}} .cps-cta-box' => 'background-color: {{VALUE}}',
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
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .cps-cta-box' => 'border-radius: {{SIZE}}{{UNIT}}',
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
                    'top' => 40,
                    'right' => 40,
                    'bottom' => 40,
                    'left' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .cps-cta-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .cps-cta-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .cps-cta-title',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'subtitle_style_section',
            [
                'label' => __('Subtitle Style', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label' => __('Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(255,255,255,0.9)',
                'selectors' => [
                    '{{WRAPPER}} .cps-cta-subtitle' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typography',
                'selector' => '{{WRAPPER}} .cps-cta-subtitle',
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
                    '{{WRAPPER}} .cps-cta-button' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_background',
            [
                'label' => __('Background', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1a73e8',
                'selectors' => [
                    '{{WRAPPER}} .cps-cta-button' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label' => __('Hover Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cps-cta-button:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_hover_background',
            [
                'label' => __('Hover Background', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cps-cta-button:hover' => 'background-color: {{VALUE}}',
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
                        'max' => 30,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .cps-cta-button' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="cps-cta-widget cps-cta-style-<?php echo esc_attr($settings['cta_style']); ?>">
            <?php if ($settings['show_bg_image'] === 'yes' && !empty($settings['bg_image']['url'])) : ?>
                <div class="cps-cta-bg">
                    <img src="<?php echo esc_url($settings['bg_image']['url']); ?>" alt="<?php echo esc_attr($settings['title']); ?>">
                    <div class="cps-cta-overlay"></div>
                </div>
            <?php endif; ?>

            <div class="cps-cta-box">
                <?php if ($settings['title']) : ?>
                    <h3 class="cps-cta-title"><?php echo esc_html($settings['title']); ?></h3>
                <?php endif; ?>

                <?php if ($settings['subtitle']) : ?>
                    <p class="cps-cta-subtitle"><?php echo esc_html($settings['subtitle']); ?></p>
                <?php endif; ?>

                <div class="cps-cta-buttons">
                    <?php if ($settings['button_text']) : ?>
                        <a href="<?php echo esc_url($settings['button_url']['url']); ?>" class="cps-cta-button">
                            <span><?php echo esc_html($settings['button_text']); ?></span>
                            <?php if (!empty($settings['button_icon'])) : ?>
                                <?php \Elementor\Icons_Manager::render_icon($settings['button_icon'], ['aria-hidden' => 'true']); ?>
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($settings['secondary_button'] === 'yes' && $settings['secondary_button_text']) : ?>
                        <a href="<?php echo esc_url($settings['secondary_button_url']['url']); ?>" class="cps-cta-button cps-cta-secondary">
                            <span><?php echo esc_html($settings['secondary_button_text']); ?></span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CPS_CTA_Widget());