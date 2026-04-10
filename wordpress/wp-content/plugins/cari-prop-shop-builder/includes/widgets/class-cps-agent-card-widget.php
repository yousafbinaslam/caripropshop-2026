<?php
/**
 * Agent Card Widget - Displays agent/team member profile card
 */

class CPS_Agent_Card_Widget extends CPS_Base_Widget {

    public function get_name() {
        return 'cps_agent_card';
    }

    public function get_title() {
        return __('Agent Card', 'cari-prop-shop-builder');
    }

    public function get_icon() {
        return 'eicon-person';
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
            'agent',
            [
                'label' => __('Select Agent', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $this->get_agents_list(),
            ]
        );

        $this->add_control(
            'agent_name',
            [
                'label' => __('Custom Name', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'agent_title',
            [
                'label' => __('Title/Position', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Real Estate Agent', 'cari-prop-shop-builder'),
            ]
        );

        $this->add_control(
            'agent_photo',
            [
                'label' => __('Photo', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'agent_email',
            [
                'label' => __('Email', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'agent_phone',
            [
                'label' => __('Phone', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'agent_website',
            [
                'label' => __('Website', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'agent_bio',
            [
                'label' => __('Biography', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
            ]
        );

        $this->add_control(
            'show_social_links',
            [
                'label' => __('Show Social Links', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'social_section',
            [
                'label' => __('Social Links', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => ['show_social_links' => 'yes'],
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'social_icon',
            [
                'label' => __('Icon', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fab fa-facebook',
                    'library' => 'fa-brands',
                ],
            ]
        );

        $repeater->add_control(
            'social_url',
            [
                'label' => __('URL', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::URL,
            ]
        );

        $this->add_control(
            'social_links',
            [
                'label' => __('Social Links', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['social_icon' => ['value' => 'fab fa-facebook']],
                    ['social_icon' => ['value' => 'fab fa-twitter']],
                    ['social_icon' => ['value' => 'fab fa-linkedin']],
                ],
                'condition' => ['show_social_links' => 'yes'],
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
                    '{{WRAPPER}} .cps-agent-card' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .cps-agent-card' => 'border-radius: {{SIZE}}{{UNIT}}',
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
                    '{{WRAPPER}} .cps-agent-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'card_box_shadow',
            [
                'label' => __('Box Shadow', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::BOX_SHADOW,
                'selectors' => [
                    '{{WRAPPER}} .cps-agent-card' => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'photo_style_section',
            [
                'label' => __('Photo Style', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'photo_size',
            [
                'label' => __('Size', 'cari-prop_shop'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 120,
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 80,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .cps-agent-photo' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'photo_border_radius',
            [
                'label' => __('Border Radius', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 50,
                    'unit' => '%',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .cps-agent-photo img' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'name_style_section',
            [
                'label' => __('Name Style', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label' => __('Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1a1a1a',
                'selectors' => [
                    '{{WRAPPER}} .cps-agent-name' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'selector' => '{{WRAPPER}} .cps-agent-name',
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
                'default' => '#1a73e8',
                'selectors' => [
                    '{{WRAPPER}} .cps-agent-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .cps-agent-title',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'bio_style_section',
            [
                'label' => __('Bio Style', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bio_color',
            [
                'label' => __('Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .cps-agent-bio' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'bio_typography',
                'selector' => '{{WRAPPER}} .cps-agent-bio',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'social_style_section',
            [
                'label' => __('Social Style', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'social_color',
            [
                'label' => __('Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .cps-agent-social a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'social_hover_color',
            [
                'label' => __('Hover Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1a73e8',
                'selectors' => [
                    '{{WRAPPER}} .cps-agent-social a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if (!empty($settings['agent'])) {
            $agent = get_post($settings['agent']);
            $name = $agent->post_title;
            $bio = $agent->post_content;
            $photo = get_the_post_thumbnail_url($agent->ID, 'large');
            $email = get_post_meta($agent->ID, 'agent_email', true);
            $phone = get_post_meta($agent->ID, 'agent_phone', true);
        } else {
            $name = $settings['agent_name'];
            $bio = $settings['agent_bio'];
            $photo = $settings['agent_photo']['url'] ?? '';
            $email = $settings['agent_email'];
            $phone = $settings['agent_phone'];
        }
        ?>
        <div class="cps-agent-card">
            <?php if ($photo) : ?>
                <div class="cps-agent-photo">
                    <img src="<?php echo esc_url($photo); ?>" alt="<?php echo esc_attr($name); ?>">
                </div>
            <?php endif; ?>

            <div class="cps-agent-info">
                <?php if ($name) : ?>
                    <h4 class="cps-agent-name"><?php echo esc_html($name); ?></h4>
                <?php endif; ?>

                <?php if ($settings['agent_title']) : ?>
                    <p class="cps-agent-title"><?php echo esc_html($settings['agent_title']); ?></p>
                <?php endif; ?>

                <?php if ($bio) : ?>
                    <p class="cps-agent-bio"><?php echo esc_html($bio); ?></p>
                <?php endif; ?>

                <div class="cps-agent-contact">
                    <?php if ($email) : ?>
                        <a href="mailto:<?php echo esc_attr($email); ?>" class="cps-contact-link">
                            <i class="eicon-envelope"></i>
                            <?php echo esc_html($email); ?>
                        </a>
                    <?php endif; ?>
                    <?php if ($phone) : ?>
                        <a href="tel:<?php echo esc_attr($phone); ?>" class="cps-contact-link">
                            <i class="eicon-phone"></i>
                            <?php echo esc_html($phone); ?>
                        </a>
                    <?php endif; ?>
                </div>

                <?php if ($settings['show_social_links'] === 'yes' && !empty($settings['social_links'])) : ?>
                    <div class="cps-agent-social">
                        <?php foreach ($settings['social_links'] as $link) : ?>
                            <a href="<?php echo esc_url($link['social_url']['url']); ?>" target="_blank">
                                <?php \Elementor\Icons_Manager::render_icon($link['social_icon'], ['aria-hidden' => 'true']); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    protected function get_agents_list() {
        $agents = get_posts([
            'post_type' => 'agent',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ]);

        $options = ['' => __('Select Agent', 'cari-prop-shop-builder')];
        foreach ($agents as $agent) {
            $options[$agent->ID] = $agent->post_title;
        }

        return $options;
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CPS_Agent_Card_Widget());