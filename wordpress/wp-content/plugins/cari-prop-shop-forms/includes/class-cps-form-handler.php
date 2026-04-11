<?php
if (!defined('ABSPATH')) {
    exit;
}

class CPS_Forms_Handler {

    private static $instance = null;
    private $form_storage;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->form_storage = CPS_Form_Storage::get_instance();
        $this->form_handler_instance = null;
    }

    public function handle_submission($form_type, $form_data) {
        $validation_result = $this->validate_form($form_type, $form_data);
        
        if (is_wp_error($validation_result)) {
            return $validation_result;
        }

        $submission_id = $this->form_storage->save_submission($form_type, $form_data);
        
        if (!$submission_id) {
            return new WP_Error('save_failed', __('Failed to save submission.', 'cari-prop-shop-forms'));
        }

        $this->send_notifications($form_type, $form_data, $submission_id);

        return array(
            'submission_id' => $submission_id,
            'message' => $this->get_success_message($form_type),
        );
    }

    private function validate_form($form_type, $form_data) {
        $errors = new WP_Error();
        $fields = $this->get_form_fields($form_type);
        $form_settings = $this->get_form_settings($form_type);

        foreach ($fields as $field) {
            if (!$this->is_field_visible($field, $form_data, $form_settings)) {
                continue;
            }

            if (!empty($field['required'])) {
                $value = isset($form_data[$field['name']]) ? $form_data[$field['name']] : '';
                
                if (empty($value) || (is_array($value) && empty($value[0]))) {
                    $errors->add('required_field', $field['label'] . ' is required.', $field['name']);
                }
            }

            if (!empty($field['type']) && $field['type'] === 'email') {
                $value = isset($form_data[$field['name']]) ? $form_data[$field['name']] : '';
                if (!empty($value) && !is_email($value)) {
                    $errors->add('invalid_email', 'Please enter a valid email address.', $field['name']);
                }
            }

            if (!empty($field['type']) && $field['type'] === 'tel') {
                $value = isset($form_data[$field['name']]) ? $form_data[$field['name']] : '';
                if (!empty($value) && !$this->validate_phone($value)) {
                    $errors->add('invalid_phone', 'Please enter a valid phone number.', $field['name']);
                }
            }

            if (!empty($field['min_length'])) {
                $value = isset($form_data[$field['name']]) ? $form_data[$field['name']] : '';
                if (!empty($value) && strlen($value) < $field['min_length']) {
                    $errors->add('min_length', $field['label'] . ' must be at least ' . $field['min_length'] . ' characters.', $field['name']);
                }
            }

            if (!empty($field['max_length'])) {
                $value = isset($form_data[$field['name']]) ? $form_data[$field['name']] : '';
                if (!empty($value) && strlen($value) > $field['max_length']) {
                    $errors->add('max_length', $field['label'] . ' must not exceed ' . $field['max_length'] . ' characters.', $field['name']);
                }
            }
        }

        $recaptcha_enabled = $this->is_recaptcha_enabled();
        if ($recaptcha_enabled) {
            $recaptcha_result = $this->validate_recaptcha($form_data);
            if (is_wp_error($recaptcha_result)) {
                return $recaptcha_result;
            }
        }

        if ($errors->get_error_code()) {
            return $errors;
        }

        return true;
    }

    private function is_field_visible($field, $form_data, $form_settings) {
        if (empty($field['conditions'])) {
            return true;
        }

        $conditions = $field['conditions'];
        $logic = !empty($field['condition_logic']) ? $field['condition_logic'] : 'and';

        foreach ($conditions as $condition) {
            $field_value = isset($form_data[$condition['field']]) ? $form_data[$condition['field']] : '';
            $condition_value = $condition['value'];
            $operator = $condition['operator'];

            $matches = false;
            switch ($operator) {
                case 'equals':
                    $matches = $field_value === $condition_value;
                    break;
                case 'not_equals':
                    $matches = $field_value !== $condition_value;
                    break;
                case 'contains':
                    $matches = stripos($field_value, $condition_value) !== false;
                    break;
                case 'not_contains':
                    $matches = stripos($field_value, $condition_value) === false;
                    break;
                case 'greater_than':
                    $matches = floatval($field_value) > floatval($condition_value);
                    break;
                case 'less_than':
                    $matches = floatval($field_value) < floatval($condition_value);
                    break;
                case 'is_empty':
                    $matches = empty($field_value);
                    break;
                case 'is_not_empty':
                    $matches = !empty($field_value);
                    break;
            }

            if ($logic === 'and' && !$matches) {
                return false;
            } elseif ($logic === 'or' && $matches) {
                return true;
            }
        }

        return $logic === 'and' ? true : false;
    }

    private function get_form_settings($form_type) {
        $all_settings = get_option('cps_forms_custom_settings', array());
        return isset($all_settings[$form_type]) ? $all_settings[$form_type] : array();
    }

    private function get_form_fields($form_type) {
        $forms = array(
            'contact' => array(
                array('name' => 'first_name', 'label' => 'First Name', 'required' => true),
                array('name' => 'last_name', 'label' => 'Last Name', 'required' => true),
                array('name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true),
                array('name' => 'phone', 'label' => 'Phone', 'type' => 'tel', 'required' => false),
                array('name' => 'subject', 'label' => 'Subject', 'required' => false),
                array('name' => 'message', 'label' => 'Message', 'required' => true, 'type' => 'textarea'),
            ),
            'property_inquiry' => array(
                array('name' => 'first_name', 'label' => 'First Name', 'required' => true),
                array('name' => 'last_name', 'label' => 'Last Name', 'required' => true),
                array('name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true),
                array('name' => 'phone', 'label' => 'Phone', 'type' => 'tel', 'required' => true),
                array('name' => 'property_id', 'label' => 'Property ID', 'type' => 'hidden', 'required' => false),
                array(
                    'name' => 'inquiry_type',
                    'label' => 'Inquiry Type',
                    'type' => 'select',
                    'required' => true,
                    'options' => array(
                        '' => 'Select an option',
                        'schedule_viewing' => 'Schedule a Viewing',
                        'request_info' => 'Request More Information',
                        'make_offer' => 'Make an Offer',
                        'ask_question' => 'Ask a Question',
                        'other' => 'Other'
                    )
                ),
                array(
                    'name' => 'financing',
                    'label' => 'Need Financing?',
                    'type' => 'radio',
                    'options' => array(
                        'yes' => 'Yes',
                        'no' => 'No',
                        'unsure' => 'Not Sure'
                    ),
                    'conditions' => array(
                        array('field' => 'inquiry_type', 'operator' => 'equals', 'value' => 'make_offer')
                    )
                ),
                array('name' => 'message', 'label' => 'Message', 'type' => 'textarea', 'required' => false),
            ),
            'general_inquiry' => array(
                array('name' => 'first_name', 'label' => 'First Name', 'required' => true),
                array('name' => 'last_name', 'label' => 'Last Name', 'required' => true),
                array('name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true),
                array('name' => 'phone', 'label' => 'Phone', 'type' => 'tel', 'required' => false),
                array(
                    'name' => 'inquiry_type',
                    'label' => 'Inquiry Type',
                    'type' => 'select',
                    'required' => true,
                    'options' => array(
                        '' => 'Select a topic',
                        'buying' => 'Buying a Property',
                        'selling' => 'Selling a Property',
                        'renting' => 'Renting',
                        'investment' => 'Investment Opportunities',
                        'agent' => 'Become an Agent',
                        'partnership' => 'Partnership',
                        'other' => 'Other'
                    )
                ),
                array('name' => 'budget_range', 'label' => 'Budget Range', 'type' => 'select', 'options' => array(
                    '' => 'Select budget',
                    'under_500m' => 'Under Rp 500 Million',
                    '500m_1b' => 'Rp 500 Million - 1 Billion',
                    '1b_5b' => 'Rp 1 - 5 Billion',
                    '5b_10b' => 'Rp 5 - 10 Billion',
                    'above_10b' => 'Above Rp 10 Billion',
                )),
                array('name' => 'message', 'label' => 'Message', 'type' => 'textarea', 'required' => true),
            ),
            'schedule_viewing' => array(
                array('name' => 'first_name', 'label' => 'First Name', 'required' => true),
                array('name' => 'last_name', 'label' => 'Last Name', 'required' => true),
                array('name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true),
                array('name' => 'phone', 'label' => 'Phone', 'type' => 'tel', 'required' => true),
                array('name' => 'property_id', 'label' => 'Property ID', 'type' => 'hidden', 'required' => false),
                array('name' => 'preferred_date', 'label' => 'Preferred Date', 'type' => 'date', 'required' => true),
                array('name' => 'preferred_time', 'label' => 'Preferred Time', 'type' => 'time', 'required' => true),
                array('name' => 'viewing_type', 'label' => 'Viewing Type', 'type' => 'radio', 'options' => array(
                    'in_person' => 'In Person',
                    'virtual' => 'Virtual Tour',
                    'both' => 'Either'
                )),
                array('name' => 'message', 'label' => 'Additional Notes', 'type' => 'textarea', 'required' => false),
            ),
            'mortgage_calculator' => array(
                array('name' => 'first_name', 'label' => 'First Name', 'required' => true),
                array('name' => 'last_name', 'label' => 'Last Name', 'required' => true),
                array('name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true),
                array('name' => 'phone', 'label' => 'Phone', 'type' => 'tel', 'required' => false),
                array('name' => 'property_price', 'label' => 'Property Price (IDR)', 'type' => 'number', 'required' => true, 'min' => 0),
                array('name' => 'down_payment', 'label' => 'Down Payment (%)', 'type' => 'number', 'required' => true, 'min' => 5, 'max' => 95),
                array('name' => 'loan_term', 'label' => 'Loan Term (Years)', 'type' => 'select', 'required' => true, 'options' => array(
                    '5' => '5 Years',
                    '10' => '10 Years',
                    '15' => '15 Years',
                    '20' => '20 Years',
                    '25' => '25 Years',
                    '30' => '30 Years'
                )),
                array('name' => 'interest_rate', 'label' => 'Interest Rate (%)', 'type' => 'number', 'min' => 0, 'max' => 30, 'step' => 0.1),
                array('name' => 'contact_mortgage', 'label' => 'I would like to be contacted by a mortgage specialist', 'type' => 'checkbox'),
            ),
            'service_request' => array(
                array('name' => 'first_name', 'label' => 'First Name', 'required' => true),
                array('name' => 'last_name', 'label' => 'Last Name', 'required' => true),
                array('name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true),
                array('name' => 'phone', 'label' => 'Phone', 'type' => 'tel', 'required' => true),
                array('name' => 'property_address', 'label' => 'Property Address', 'type' => 'textarea', 'required' => false),
                array(
                    'name' => 'service_type',
                    'label' => 'Service Type',
                    'type' => 'select',
                    'required' => true,
                    'options' => array(
                        '' => 'Select a service',
                        'notary' => 'Notary Services',
                        'interior' => 'Interior Design',
                        'construction' => 'Construction',
                        'legal' => 'Legal Services',
                        'appraisal' => 'Property Appraisal',
                        'management' => 'Property Management'
                    )
                ),
                array(
                    'name' => 'property_type',
                    'label' => 'Property Type',
                    'type' => 'checkbox_group',
                    'options' => array(
                        'house' => 'House',
                        'apartment' => 'Apartment',
                        'land' => 'Land',
                        'commercial' => 'Commercial'
                    ),
                    'conditions' => array(
                        array('field' => 'service_type', 'operator' => 'not_equals', 'value' => '')
                    )
                ),
                array('name' => 'preferred_contact', 'label' => 'Preferred Contact Method', 'type' => 'radio', 'options' => array(
                    'email' => 'Email',
                    'phone' => 'Phone Call',
                    'whatsapp' => 'WhatsApp'
                )),
                array('name' => 'message', 'label' => 'Project Details', 'type' => 'textarea', 'required' => true),
            ),
        );

        return isset($forms[$form_type]) ? $forms[$form_type] : array();
    }

    private function validate_phone($phone) {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        return strlen($phone) >= 10 && strlen($phone) <= 15;
    }

    private function is_recaptcha_enabled() {
        $settings = get_option('cps_forms_settings', array());
        return !empty($settings['recaptcha']['enable']);
    }

    private function validate_recaptcha($form_data) {
        $settings = get_option('cps_forms_settings', array());
        $secret_key = isset($settings['recaptcha']['secret_key']) ? $settings['recaptcha']['secret_key'] : '';
        
        if (empty($secret_key)) {
            return true;
        }

        $recaptcha_token = isset($form_data['recaptcha_token']) ? $form_data['recaptcha_token'] : '';
        
        if (empty($recaptcha_token)) {
            return new WP_Error('recaptcha_failed', 'reCAPTCHA verification failed.');
        }

        $response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', array(
            'body' => array(
                'secret' => $secret_key,
                'response' => $recaptcha_token,
            ),
        ));

        if (is_wp_error($response)) {
            return new WP_Error('recaptcha_failed', 'reCAPTCHA verification failed.');
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);
        
        if (empty($body['success'])) {
            return new WP_Error('recaptcha_failed', 'reCAPTCHA verification failed.');
        }

        return true;
    }

    private function send_notifications($form_type, $form_data, $submission_id) {
        $settings = get_option('cps_forms_settings', array());
        
        if (!empty($settings['email_notifications']['enable'])) {
            $this->send_admin_notification($form_type, $form_data, $submission_id);
        }

        if (!empty($settings['auto_responder']['enable']) && !empty($form_data['email'])) {
            $this->send_auto_responder($form_type, $form_data);
        }
    }

    private function send_admin_notification($form_type, $form_data, $submission_id) {
        $settings = get_option('cps_forms_settings', array());
        $email_to = isset($settings['email_notifications']['email_to']) ? $settings['email_notifications']['email_to'] : get_option('admin_email');
        $email_from = isset($settings['email_notifications']['email_from']) ? $settings['email_notifications']['email_from'] : get_option('admin_email');
        $email_from_name = isset($settings['email_notifications']['email_from_name']) ? $settings['email_notifications']['email_from_name'] : get_bloginfo('name');

        $subject = sprintf(__('New %s Submission', 'cari-prop-shop-forms'), ucfirst(str_replace('_', ' ', $form_type)));
        
        $message = $this->format_submission_email($form_type, $form_data, $submission_id);

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . $email_from_name . ' <' . $email_from . '>',
        );

        wp_mail($email_to, $subject, $message, $headers);
    }

    private function send_auto_responder($form_type, $form_data) {
        $settings = get_option('cps_forms_settings', array());
        
        $to = $form_data['email'];
        $subject = isset($settings['auto_responder']['subject']) ? $settings['auto_responder']['subject'] : __('Thank you for your inquiry', 'cari-prop-shop-forms');
        $message = isset($settings['auto_responder']['message']) ? $settings['auto_responder']['message'] : __('Thank you for contacting us. We will get back to you shortly.', 'cari-prop-shop-forms');
        
        $email_from = isset($settings['email_notifications']['email_from']) ? $settings['email_notifications']['email_from'] : get_option('admin_email');
        $email_from_name = isset($settings['email_notifications']['email_from_name']) ? $settings['email_notifications']['email_from_name'] : get_bloginfo('name');

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . $email_from_name . ' <' . $email_from . '>',
        );

        wp_mail($to, $subject, wpautop($message), $headers);
    }

    private function format_submission_email($form_type, $form_data, $submission_id) {
        $html = '<html><body>';
        $html .= '<h2>' . sprintf(__('New %s Submission', 'cari-prop-shop-forms'), ucfirst(str_replace('_', ' ', $form_type))) . '</h2>';
        $html .= '<p><strong>Submission ID:</strong> ' . $submission_id . '</p>';
        $html .= '<p><strong>Date:</strong> ' . date('F j, Y g:i a') . '</p>';
        $html .= '<hr>';
        $html .= '<table style="width:100%; border-collapse: collapse;">';
        
        foreach ($form_data as $key => $value) {
            if (is_array($value)) {
                $value = implode(', ', $value);
            }
            $label = ucwords(str_replace('_', ' ', $key));
            $html .= '<tr>';
            $html .= '<td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">' . esc_html($label) . '</td>';
            $html .= '<td style="padding: 8px; border: 1px solid #ddd;">' . esc_html($value) . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</table>';
        $html .= '</body></html>';
        
        return $html;
    }

    private function get_success_message($form_type) {
        $messages = array(
            'contact' => __('Thank you! Your message has been sent successfully. We will get back to you shortly.', 'cari-prop-shop-forms'),
            'property_inquiry' => __('Thank you for your inquiry! Our team will contact you shortly.', 'cari-prop-shop-forms'),
            'general_inquiry' => __('Thank you! Your inquiry has been submitted. We will respond soon.', 'cari-prop-shop-forms'),
            'schedule_viewing' => __('Your viewing request has been submitted. We will confirm your appointment shortly.', 'cari-prop-shop-forms'),
            'mortgage_calculator' => __('Thank you! A mortgage specialist will contact you with your personalized calculation.', 'cari-prop-shop-forms'),
        );

        return isset($messages[$form_type]) ? $messages[$form_type] : __('Thank you! Your submission has been received.', 'cari-prop-shop-forms');
    }
}