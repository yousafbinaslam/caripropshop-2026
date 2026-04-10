<?php
/**
 * Property Search Widget - Advanced search form for properties
 */

class CPS_Property_Search_Widget extends CPS_Base_Widget {

    public function get_name() {
        return 'cps_property_search';
    }

    public function get_title() {
        return __('Property Search', 'cari-prop-shop-builder');
    }

    public function get_icon() {
        return 'eicon-search';
    }

    public function get_categories() {
        return ['cari_prop_shop_category'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'general_section',
            [
                'label' => __('General', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'search_layout',
            [
                'label' => __('Search Layout', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => __('Horizontal', 'cari-prop-shop-builder'),
                    'vertical' => __('Vertical', 'cari-prop-shop-builder'),
                    'compact' => __('Compact', 'cari-prop-shop-builder'),
                ],
            ]
        );

        $this->add_control(
            'search_columns',
            [
                'label' => __('Columns', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '4',
                'options' => [
                    '2' => __('2 Columns', 'cari-prop-shop-builder'),
                    '3' => __('3 Columns', 'cari-prop-shop-builder'),
                    '4' => __('4 Columns', 'cari-prop-shop-builder'),
                ],
                'condition' => ['search_layout' => 'horizontal'],
            ]
        );

        $this->add_control(
            'search_placeholder',
            [
                'label' => __('Search Placeholder', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Search by location, address, or ZIP...', 'cari-prop-shop-builder'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'search_fields_section',
            [
                'label' => __('Search Fields', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_keyword',
            [
                'label' => __('Keyword Search', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Show', 'cari-prop-shop-builder'),
                'label_off' => __('Hide', 'cari-prop-shop-builder'),
            ]
        );

        $this->add_control(
            'show_location',
            [
                'label' => __('Location Dropdown', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Show', 'cari-prop-shop-builder'),
                'label_off' => __('Hide', 'cari-prop-shop-builder'),
            ]
        );

        $this->add_control(
            'location_options',
            [
                'label' => __('Locations', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 5,
                'description' => __('Enter locations (one per line)', 'cari-prop-shop-builder'),
                'condition' => ['show_location' => 'yes'],
            ]
        );

        $this->add_control(
            'show_property_type',
            [
                'label' => __('Property Type', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Show', 'cari-prop-shop-builder'),
                'label_off' => __('Hide', 'cari-prop-shop-builder'),
            ]
        );

        $this->add_control(
            'show_status',
            [
                'label' => __('Status', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Show', 'cari-prop-shop-builder'),
                'label_off' => __('Hide', 'cari-prop-shop-builder'),
            ]
        );

        $this->add_control(
            'show_price_range',
            [
                'label' => __('Price Range', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Show', 'cari-prop-shop-builder'),
                'label_off' => __('Hide', 'cari-prop-shop-builder'),
            ]
        );

        $this->add_control(
            'price_min',
            [
                'label' => __('Min Price', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 0,
                'condition' => ['show_price_range' => 'yes'],
            ]
        );

        $this->add_control(
            'price_max',
            [
                'label' => __('Max Price', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 1000000,
                'condition' => ['show_price_range' => 'yes'],
            ]
        );

        $this->add_control(
            'price_step',
            [
                'label' => __('Price Step', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 50000,
                'condition' => ['show_price_range' => 'yes'],
            ]
        );

        $this->add_control(
            'show_bedrooms',
            [
                'label' => __('Bedrooms', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Show', 'cari-prop-shop-builder'),
                'label_off' => __('Hide', 'cari-prop-shop-builder'),
            ]
        );

        $this->add_control(
            'show_bathrooms',
            [
                'label' => __('Bathrooms', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Show', 'cari-prop-shop-builder'),
                'label_off' => __('Hide', 'cari-prop-shop-builder'),
            ]
        );

        $this->add_control(
            'show_sqft',
            [
                'label' => __('Square Feet', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Show', 'cari-prop-shop-builder'),
                'label_off' => __('Hide', 'cari-prop-shop-builder'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'search_button_section',
            [
                'label' => __('Search Button', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_search_button',
            [
                'label' => __('Show Button', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Show', 'cari-prop-shop-builder'),
                'label_off' => __('Hide', 'cari-prop-shop-builder'),
            ]
        );

        $this->add_control(
            'search_button_text',
            [
                'label' => __('Button Text', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Search', 'cari-prop-shop-builder'),
                'condition' => ['show_search_button' => 'yes'],
            ]
        );

        $this->add_control(
            'search_button_icon',
            [
                'label' => __('Icon', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::ICON,
                'default' => 'fa fa-search',
                'condition' => ['show_search_button' => 'yes'],
            ]
        );

        $this->add_control(
            'search_results_page',
            [
                'label' => __('Results Page', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $this->get_pages_list(),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'form_style_section',
            [
                'label' => __('Form Style', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'form_background',
            [
                'label' => __('Background', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .cps-search-form' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'form_border_radius',
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
                    '{{WRAPPER}} .cps-search-form' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'form_padding',
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
                    '{{WRAPPER}} .cps-search-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'form_box_shadow',
            [
                'label' => __('Shadow', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::BOX_SHADOW,
                'selectors' => [
                    '{{WRAPPER}} .cps-search-form' => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'input_style_section',
            [
                'label' => __('Input Style', 'cari-prop-shop-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'input_background',
            [
                'label' => __('Background', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f5f5f5',
                'selectors' => [
                    '{{WRAPPER}} .cps-search-form input' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .cps-search-form select' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'input_color',
            [
                'label' => __('Text Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .cps-search-form input' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .cps-search-form select' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'input_border_color',
            [
                'label' => __('Border Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#e0e0e0',
                'selectors' => [
                    '{{WRAPPER}} .cps-search-form input' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .cps-search-form select' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'input_border_radius',
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
                    '{{WRAPPER}} .cps-search-form input' => 'border-radius: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .cps-search-form select' => 'border-radius: {{SIZE}}{{UNIT}}',
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
                'label' => __('Text Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .cps-search-btn' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .cps-search-btn' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label' => __('Hover Text Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .cps-search-btn:hover' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .cps-search-btn:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $currency = $this->get_currency_symbol();

        $cols = isset($settings['search_columns']) ? (int) $settings['search_columns'] : 4;
        ?>
        <form class="cps-search-form cps-search-layout-<?php echo esc_attr($settings['search_layout']); ?>" role="search" method="get" action="<?php echo esc_url($settings['search_results_page'] ? get_permalink($settings['search_results_page']) : home_url('/')); ?>">
            <input type="hidden" name="post_type" value="property">
            
            <div class="cps-search-fields cps-cols-<?php echo esc_attr($cols); ?>">
                <?php if ($settings['show_keyword'] === 'yes') : ?>
                    <div class="cps-search-field">
                        <label class="cps-field-label"><?php _e('Keyword', 'cari-prop-shop-builder'); ?></label>
                        <input type="text" name="s" placeholder="<?php echo esc_attr($settings['search_placeholder']); ?>" class="cps-search-input">
                    </div>
                <?php endif; ?>

                <?php if ($settings['show_location'] === 'yes') : ?>
                    <div class="cps-search-field">
                        <label class="cps-field-label"><?php _e('Location', 'cari-prop-shop-builder'); ?></label>
                        <select name="location" class="cps-search-select">
                            <option value=""><?php _e('All Locations', 'cari-prop-shop-builder'); ?></option>
                            <?php
                            if (!empty($settings['location_options'])) {
                                $locations = explode("\n", $settings['location_options']);
                                foreach ($locations as $location) {
                                    $location = trim($location);
                                    if ($location) {
                                        echo '<option value="' . esc_attr($location) . '">' . esc_html($location) . '</option>';
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                <?php endif; ?>

                <?php if ($settings['show_property_type'] === 'yes') : ?>
                    <div class="cps-search-field">
                        <label class="cps-field-label"><?php _e('Property Type', 'cari-prop-shop-builder'); ?></label>
                        <select name="property_type" class="cps-search-select">
                            <option value=""><?php _e('All Types', 'cari-prop-shop-builder'); ?></option>
                            <?php
                            $property_types = $this->get_property_types();
                            foreach ($property_types as $id => $name) {
                                echo '<option value="' . esc_attr($id) . '">' . esc_html($name) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                <?php endif; ?>

                <?php if ($settings['show_status'] === 'yes') : ?>
                    <div class="cps-search-field">
                        <label class="cps-field-label"><?php _e('Status', 'cari-prop-shop-builder'); ?></label>
                        <select name="property_status" class="cps-search-select">
                            <option value=""><?php _e('All Status', 'cari-prop-shop-builder'); ?></option>
                            <?php
                            $statuses = $this->get_property_statuses();
                            foreach ($statuses as $key => $label) {
                                echo '<option value="' . esc_attr($key) . '">' . esc_html($label) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                <?php endif; ?>

                <?php if ($settings['show_price_range'] === 'yes') : ?>
                    <div class="cps-search-field cps-search-field-price">
                        <label class="cps-field-label"><?php _e('Price Range', 'cari-prop-shop-builder'); ?></label>
                        <select name="min_price" class="cps-search-select">
                            <option value=""><?php _e('Min Price', 'cari-prop-shop-builder'); ?></option>
                            <?php
                            $price = $settings['price_min'];
                            $max = $settings['price_max'];
                            $step = $settings['price_step'];
                            while ($price <= $max) {
                                echo '<option value="' . esc_attr($price) . '">' . esc_html($currency . number_format($price)) . '</option>';
                                $price += $step;
                            }
                            ?>
                        </select>
                        <select name="max_price" class="cps-search-select">
                            <option value=""><?php _e('Max Price', 'cari-prop-shop-builder'); ?></option>
                            <?php
                            $price = $settings['price_min'];
                            $max = $settings['price_max'];
                            $step = $settings['price_step'];
                            while ($price <= $max) {
                                echo '<option value="' . esc_attr($price) . '">' . esc_html($currency . number_format($price)) . '</option>';
                                $price += $step;
                            }
                            ?>
                        </select>
                    </div>
                <?php endif; ?>

                <?php if ($settings['show_bedrooms'] === 'yes') : ?>
                    <div class="cps-search-field">
                        <label class="cps-field-label"><?php _e('Bedrooms', 'cari-prop-shop-builder'); ?></label>
                        <select name="bedrooms" class="cps-search-select">
                            <option value=""><?php _e('Any', 'cari-prop-shop-builder'); ?></option>
                            <option value="1">1+</option>
                            <option value="2">2+</option>
                            <option value="3">3+</option>
                            <option value="4">4+</option>
                            <option value="5">5+</option>
                        </select>
                    </div>
                <?php endif; ?>

                <?php if ($settings['show_bathrooms'] === 'yes') : ?>
                    <div class="cps-search-field">
                        <label class="cps-field-label"><?php _e('Bathrooms', 'cari-prop-shop-builder'); ?></label>
                        <select name="bathrooms" class="cps-search-select">
                            <option value=""><?php _e('Any', 'cari-prop-shop-builder'); ?></option>
                            <option value="1">1+</option>
                            <option value="2">2+</option>
                            <option value="3">3+</option>
                            <option value="4">4+</option>
                        </select>
                    </div>
                <?php endif; ?>

                <?php if ($settings['show_sqft'] === 'yes') : ?>
                    <div class="cps-search-field cps-search-field-sqft">
                        <label class="cps-field-label"><?php _e('Square Feet', 'cari-prop-shop-builder'); ?></label>
                        <input type="number" name="min_sqft" placeholder="<?php _e('Min sqft', 'cari-prop-shop-builder'); ?>" class="cps-search-input">
                        <input type="number" name="max_sqft" placeholder="<?php _e('Max sqft', 'cari-prop-shop-builder'); ?>" class="cps-search-input">
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($settings['show_search_button'] === 'yes') : ?>
                <div class="cps-search-button-wrapper">
                    <button type="submit" class="cps-search-btn">
                        <?php if ($settings['search_button_icon']) : ?>
                            <i class="<?php echo esc_attr($settings['search_button_icon']); ?>"></i>
                        <?php endif; ?>
                        <span><?php echo esc_html($settings['search_button_text']); ?></span>
                    </button>
                </div>
            <?php endif; ?>
        </form>
        <?php
    }

    protected function get_pages_list() {
        $pages = get_pages();
        $options = ['' => __('Select Page', 'cari-prop-shop-builder')];
        foreach ($pages as $page) {
            $options[$page->ID] = $page->post_title;
        }
        return $options;
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CPS_Property_Search_Widget());