<?php
/**
 * Stats Widget - Statistics counter display
 */

class CPS_Stats_Widget extends CPS_Base_Widget {

    public function get_name() {
        return 'cps_stats';
    }

    public function get_title() {
        return __('Stats Counter', 'cari-prop-shop-builder');
    }

    public function get_icon() {
        return 'eicon-counter';
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
            'stat_number',
            [
                'label' => __('Number', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'stat_suffix',
            [
                'label' => __('Suffix', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'stat_prefix',
            [
                'label' => __('Prefix', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'stat_label',
            [
                'label' => __('Label', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'stat_icon',
            [
                'label' => __('Icon', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::ICONS,
            ]
        );

        $repeater->add_control(
            'stat_image',
            [
                'label' => __('Custom Image', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'stats_items',
            [
                'label' => __('Stats Items', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['stat_number' => '500', 'stat_label' => __('Properties Sold', 'cari-prop-shop-builder')],
                    ['stat_number' => '120', 'stat_label' => __('Happy Clients', 'cari-prop-shop-builder')],
                    ['stat_number' => '15', 'stat_label' => __('Years Experience', 'cari-prop-shop-builder')],
                    ['stat_number' => '25', 'stat_label' => __('Awards Won', 'cari-prop-shop-builder')],
                ],
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
                'default' => '4',
                'options' => [
                    '1' => __('1 Column', 'cari-prop-shop-builder'),
                    '2' => __('2 Columns', 'cari-prop-shop-builder'),
                    '3' => __('3 Columns', 'cari-prop-shop-builder'),
                    '4' => __('4 Columns', 'cari-prop-shop-builder'),
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'counter_section',
            [
                'label' => __('Counter Animation', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'enable_counter',
            [
                'label' => __('Enable Counter Animation', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'counter_duration',
            [
                'label' => __('Duration (ms)', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 2000,
                'condition' => ['enable_counter' => 'yes'],
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
                    '{{WRAPPER}} .cps-stat-item' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .cps-stat-item' => 'border-radius: {{SIZE}}{{UNIT}}',
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
                    'top' => 20,
                    'right' => 20,
                    'bottom' => 20,
                    'left' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .cps-stat-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'icon_style_section',
            [
                'label' => __('Icon Style', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __('Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1a73e8',
                'selectors' => [
                    '{{WRAPPER}} .cps-stat-icon' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => __('Size', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 40,
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .cps-stat-icon' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'number_style_section',
            [
                'label' => __('Number Style', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'number_color',
            [
                'label' => __('Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1a1a1a',
                'selectors' => [
                    '{{WRAPPER}} .cps-stat-number' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'number_typography',
                'selector' => '{{WRAPPER}} .cps-stat-number',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'label_style_section',
            [
                'label' => __('Label Style', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => __('Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .cps-stat-label' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'selector' => '{{WRAPPER}} .cps-stat-label',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $columns = $settings['columns'] ?? 4;
        ?>
        <div class="cps-stats-widget cps-cols-<?php echo esc_attr($columns); ?>">
            <?php foreach ($settings['stats_items'] as $index => $item) :
                $number = !empty($item['stat_number']) ? $item['stat_number'] : '0';
                $data_attr = '';
                if ($settings['enable_counter'] === 'yes') {
                    $data_attr = ' data-number="' . esc_attr($number) . '"';
                    $data_attr .= ' data-duration="' . esc_attr($settings['counter_duration']) . '"';
                }
                ?>
                <div class="cps-stat-item"<?php echo $data_attr; ?>>
                    <?php if (!empty($item['stat_icon'])) : ?>
                        <div class="cps-stat-icon">
                            <?php \Elementor\Icons_Manager::render_icon($item['stat_icon'], ['aria-hidden' => 'true']); ?>
                        </div>
                    <?php elseif (!empty($item['stat_image'])) : ?>
                        <div class="cps-stat-image">
                            <img src="<?php echo esc_url($item['stat_image']['url']); ?>" alt="<?php echo esc_attr($item['stat_label']); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="cps-stat-content">
                        <span class="cps-stat-number">
                            <?php
                            if (!empty($item['stat_prefix'])) {
                                echo esc_html($item['stat_prefix']);
                            }
                            if ($settings['enable_counter'] !== 'yes') {
                                echo esc_html($number);
                            } else {
                                echo '0';
                            }
                            if (!empty($item['stat_suffix'])) {
                                echo esc_html($item['stat_suffix']);
                            }
                            ?>
                        </span>
                        <?php if (!empty($item['stat_label'])) : ?>
                            <span class="cps-stat-label"><?php echo esc_html($item['stat_label']); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CPS_Stats_Widget());