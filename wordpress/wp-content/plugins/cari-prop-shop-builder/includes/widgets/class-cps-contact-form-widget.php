<?php
/**
 * Contact Form Widget - Property inquiry/contact form
 */

class CPS_Contact_Form_Widget extends CPS_Base_Widget {

    public function get_name() {
        return 'cps_contact_form';
    }

    public function get_title() {
        return __('Contact Form', 'cari-prop-shop-builder');
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
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
            'form_title',
            [
                'label' => __('Title', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Get in Touch', 'cari-prop-shop-builder'),
            ]
        );

        $this->add_control(
            'form_subtitle',
            [
                'label' => __('Subtitle', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Fill out the form below and we will get back to you shortly.', 'cari-prop-shop-builder'),
                'rows' => 2,
            ]
        );

        $this->add_control(
            'form_layout',
            [
                'label' => __('Layout', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'vertical',
                'options' => [
                    'vertical' => __('Vertical', 'cari-prop-shop-builder'),
                    'horizontal' => __('Horizontal', 'cari-prop-shop-builder'),
                ],
            ]
        );

        $this->add_control(
            'show_name',
            [
                'label' => __('Show Name Field', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'name_required',
            [
                'label' => __('Name Required', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => ['show_name' => 'yes'],
            ]
        );

        $this->add_control(
            'show_email',
            [
                'label' => __('Show Email Field', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'email_required',
            [
                'label' => __('Email Required', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => ['show_email' => 'yes'],
            ]
        );

        $this->add_control(
            'show_phone',
            [
                'label' => __('Show Phone Field', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_subject',
            [
                'label' => __('Show Subject Field', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_property',
            [
                'label' => __('Show Property Dropdown', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_message',
            [
                'label' => __('Show Message Field', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'message_required',
            [
                'label' => __('Message Required', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => ['show_message' => 'yes'],
            ]
        );

        $this->add_control(
            'submit_text',
            [
                'label' => __('Submit Button Text', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Send Message', 'cari-prop-shop-builder'),
            ]
        );

        $this->add_control(
            'show_success_message',
            [
                'label' => __('Success Message', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Thank you for your message. We will get back to you soon!', 'cari-prop-shop-builder'),
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
                    '{{WRAPPER}} .cps-contact-form' => 'background-color: {{VALUE}}',
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
                'selectors' => [
                    '{{WRAPPER}} .cps-contact-form' => 'border-radius: {{SIZE}}{{UNIT}}',
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
                    'top' => 30,
                    'right' => 30,
                    'bottom' => 30,
                    'left' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .cps-contact-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'form_box_shadow',
            [
                'label' => __('Shadow', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::BOX_SHADOW,
                'selectors' => [
                    '{{WRAPPER}} .cps-contact-form' => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}}',
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
                'default' => '#f9f9f9',
                'selectors' => [
                    '{{WRAPPER}} .cps-form-group input' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .cps-form-group textarea' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .cps-form-group select' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .cps-form-group input' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .cps-form-group textarea' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .cps-form-group select' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .cps-form-group input' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .cps-form-group textarea' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .cps-form-group select' => 'border-color: {{VALUE}}',
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
                'selectors' => [
                    '{{WRAPPER}} .cps-form-group input' => 'border-radius: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .cps-form-group textarea' => 'border-radius: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .cps-form-group select' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'input_padding',
            [
                'label' => __('Padding', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default' => [
                    'top' => 12,
                    'right' => 15,
                    'bottom' => 12,
                    'left' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .cps-form-group input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    '{{WRAPPER}} .cps-form-group textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    '{{WRAPPER}} .cps-form-group select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
                    '{{WRAPPER}} .cps-submit-btn' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .cps-submit-btn' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label' => __('Hover Color', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cps-submit-btn:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_hover_background',
            [
                'label' => __('Hover Background', 'cari-prop-shop-builder'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cps-submit-btn:hover' => 'background-color: {{VALUE}}',
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
                'selectors' => [
                    '{{WRAPPER}} .cps-submit-btn' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="cps-contact-form-widget">
            <?php if ($settings['form_title']) : ?>
                <h3 class="cps-form-title"><?php echo esc_html($settings['form_title']); ?></h3>
            <?php endif; ?>

            <?php if ($settings['form_subtitle']) : ?>
                <p class="cps-form-subtitle"><?php echo esc_html($settings['form_subtitle']); ?></p>
            <?php endif; ?>

            <form class="cps-contact-form cps-form-<?php echo esc_attr($settings['form_layout']); ?>" method="post">
                <div class="cps-form-fields">
                    <?php if ($settings['show_name'] === 'yes') : ?>
                        <div class="cps-form-group">
                            <label for="cps_name"><?php _e('Name', 'cari-prop-shop-builder'); ?><?php if ($settings['name_required'] === 'yes') echo ' *'; ?></label>
                            <input type="text" id="cps_name" name="name" <?php echo $settings['name_required'] === 'yes' ? 'required' : ''; ?>>
                        </div>
                    <?php endif; ?>

                    <?php if ($settings['show_email'] === 'yes') : ?>
                        <div class="cps-form-group">
                            <label for="cps_email"><?php _e('Email', 'cari-prop-shop-builder'); ?><?php if ($settings['email_required'] === 'yes') echo ' *'; ?></label>
                            <input type="email" id="cps_email" name="email" <?php echo $settings['email_required'] === 'yes' ? 'required' : ''; ?>>
                        </div>
                    <?php endif; ?>

                    <?php if ($settings['show_phone'] === 'yes') : ?>
                        <div class="cps-form-group">
                            <label for="cps_phone"><?php _e('Phone', 'cari-prop-shop-builder'); ?></label>
                            <input type="tel" id="cps_phone" name="phone">
                        </div>
                    <?php endif; ?>

                    <?php if ($settings['show_subject'] === 'yes') : ?>
                        <div class="cps-form-group">
                            <label for="cps_subject"><?php _e('Subject', 'cari-prop-shop-builder'); ?></label>
                            <input type="text" id="cps_subject" name="subject">
                        </div>
                    <?php endif; ?>

                    <?php if ($settings['show_property'] === 'yes') : ?>
                        <div class="cps-form-group">
                            <label for="cps_property"><?php _e('Interested Property', 'cari-prop-shop-builder'); ?></label>
                            <select id="cps_property" name="property_id">
                                <option value=""><?php _e('Select a property', 'cari-prop-shop-builder'); ?></option>
                                <?php
                                $properties = get_posts([
                                    'post_type' => 'property',
                                    'posts_per_page' => -1,
                                    'post_status' => 'publish',
                                ]);
                                foreach ($properties as $property) {
                                    echo '<option value="' . esc_attr($property->ID) . '">' . esc_html($property->post_title) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <?php if ($settings['show_message'] === 'yes') : ?>
                        <div class="cps-form-group">
                            <label for="cps_message"><?php _e('Message', 'cari-prop-shop-builder'); ?><?php if ($settings['message_required'] === 'yes') echo ' *'; ?></label>
                            <textarea id="cps_message" name="message" rows="5" <?php echo $settings['message_required'] === 'yes' ? 'required' : ''; ?>></textarea>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="cps-form-footer">
                    <button type="submit" class="cps-submit-btn">
                        <?php echo esc_html($settings['submit_text']); ?>
                    </button>
                </div>

                <div class="cps-form-response"></div>
            </form>
        </div>
        <?php
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CPS_Contact_Form_Widget());