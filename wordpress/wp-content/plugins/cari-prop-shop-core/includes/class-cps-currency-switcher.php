<?php
if (!defined('ABSPATH')) {
    exit;
}

class CPS_Currency_Switcher {

    private static $instance = null;

    public $currencies = array(
        'IDR' => array(
            'name' => 'Indonesian Rupiah',
            'symbol' => 'Rp ',
            'code' => 'IDR',
            'rate' => 1,
            'position' => 'before',
            'decimals' => 0,
            'thousand_sep' => '.',
            'decimal_sep' => ',',
        ),
        'USD' => array(
            'name' => 'US Dollar',
            'symbol' => '$',
            'code' => 'USD',
            'rate' => 0.000063,
            'position' => 'before',
            'decimals' => 2,
            'thousand_sep' => ',',
            'decimal_sep' => '.',
        ),
        'EUR' => array(
            'name' => 'Euro',
            'symbol' => '€',
            'code' => 'EUR',
            'rate' => 0.000058,
            'position' => 'before',
            'decimals' => 2,
            'thousand_sep' => ',',
            'decimal_sep' => '.',
        ),
        'SGD' => array(
            'name' => 'Singapore Dollar',
            'symbol' => 'S$',
            'code' => 'SGD',
            'rate' => 0.000085,
            'position' => 'before',
            'decimals' => 2,
            'thousand_sep => ',',
            'decimal_sep' => '.',
        ),
    );

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('init', array($this, 'init'));
        add_shortcode('cps_currency_switcher', array($this, 'render_currency_switcher'));
        add_filter('cps_format_price', array($this, 'format_price'), 10, 3);
        add_action('wp_ajax_cps_change_currency', array($this, 'ajax_change_currency'));
        add_action('wp_ajax_nopriv_cps_change_currency', array($this, 'ajax_change_currency'));
        add_action('wp_footer', array($this, 'output_currency_cookie_script'));
    }

    public function init() {
        $saved_currency = isset($_COOKIE['cps_currency']) ? sanitize_text_field($_COOKIE['cps_currency']) : 'IDR';
        
        if (!array_key_exists($saved_currency, $this->currencies)) {
            $saved_currency = 'IDR';
        }
        
        $this->current_currency = $saved_currency;
    }

    public function get_current_currency() {
        if (!isset($this->current_currency)) {
            $this->init();
        }
        return $this->current_currency;
    }

    public function get_currency_data($currency_code = '') {
        if (empty($currency_code)) {
            $currency_code = $this->get_current_currency();
        }
        return isset($this->currencies[$currency_code]) ? $this->currencies[$currency_code] : $this->currencies['IDR'];
    }

    public function format_price($price, $currency_code = '', $show_symbol = true) {
        if (empty($currency_code)) {
            $currency_code = $this->get_current_currency();
        }

        $currency = $this->get_currency_data($currency_code);
        
        if (!is_numeric($price)) {
            $price = preg_replace('/[^0-9.]/', '', $price);
        }
        
        if (!is_numeric($price)) {
            return $price;
        }

        $converted_price = $price * $currency['rate'];

        $formatted = number_format(
            $converted_price,
            $currency['decimals'],
            $currency['decimal_sep'],
            $currency['thousand_sep']
        );

        if (!$show_symbol) {
            return $formatted;
        }

        if ($currency['position'] === 'before') {
            return $currency['symbol'] . $formatted;
        } else {
            return $formatted . ' ' . $currency['symbol'];
        }
    }

    public function convert_price($price, $from_currency = 'IDR', $to_currency = '') {
        if (empty($to_currency)) {
            $to_currency = $this->get_current_currency();
        }

        $from_data = $this->get_currency_data($from_currency);
        $to_data = $this->get_currency_data($to_currency);

        $idr_amount = $price / $from_data['rate'];
        return $idr_amount * $to_data['rate'];
    }

    public function render_currency_switcher($atts = array()) {
        $atts = shortcode_atts(array(
            'show_flag' => 'true',
            'dropdown' => 'false',
            'label' => 'Currency',
        ), $atts);

        $current = $this->get_current_currency();
        $show_flag = filter_var($atts['show_flag'], FILTER_VALIDATE_BOOLEAN);
        $is_dropdown = filter_var($atts['dropdown'], FILTER_VALIDATE_BOOLEAN);

        ob_start();
        ?>
        <div class="cps-currency-switcher <?php echo $is_dropdown ? 'dropdown' : 'inline'; ?>">
            <?php if (!$is_dropdown) : ?>
                <span class="currency-label"><?php echo esc_html($atts['label']); ?>:</span>
            <?php endif; ?>
            
            <?php if ($is_dropdown) : ?>
                <div class="currency-dropdown">
                    <button class="currency-dropdown-btn">
                        <?php if ($show_flag) : ?>
                            <span class="currency-flag"><?php echo $this->get_currency_flag($current); ?></span>
                        <?php endif; ?>
                        <span class="currency-code"><?php echo esc_html($current); ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="currency-dropdown-content">
                        <?php foreach ($this->currencies as $code => $data) : ?>
                            <a href="#" class="currency-option <?php echo $code === $current ? 'active' : ''; ?>" data-currency="<?php echo esc_attr($code); ?>">
                                <?php if ($show_flag) : ?>
                                    <span class="currency-flag"><?php echo $this->get_currency_flag($code); ?></span>
                                <?php endif; ?>
                                <span class="currency-info">
                                    <span class="currency-code"><?php echo esc_html($code); ?></span>
                                    <span class="currency-name"><?php echo esc_html($data['name']); ?></span>
                                </span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else : ?>
                <div class="currency-buttons">
                    <?php foreach ($this->currencies as $code => $data) : ?>
                        <button class="currency-btn <?php echo $code === $current ? 'active' : ''; ?>" data-currency="<?php echo esc_attr($code); ?>">
                            <?php if ($show_flag) : ?>
                                <span class="currency-flag"><?php echo $this->get_currency_flag($code); ?></span>
                            <?php endif; ?>
                            <span class="currency-code"><?php echo esc_html($code); ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
    }

    private function get_currency_flag($currency_code) {
        $flags = array(
            'IDR' => '<span class="flag-icon flag-icon-id"></span>',
            'USD' => '<span class="flag-icon flag-icon-us"></span>',
            'EUR' => '<span class="flag-icon flag-icon-eu"></span>',
            'SGD' => '<span class="flag-icon flag-icon-sg"></span>',
        );
        
        $country_codes = array(
            'IDR' => 'id',
            'USD' => 'us',
            'EUR' => 'eu',
            'SGD' => 'sg',
        );

        $code = isset($country_codes[$currency_code]) ? $country_codes[$currency_code] : 'un';
        return '<span class="cps-flag flag-' . esc_attr($code) . '"></span>';
    }

    public function ajax_change_currency() {
        check_ajax_referer('cps_currency_nonce', 'nonce');

        $currency = isset($_POST['currency']) ? sanitize_text_field($_POST['currency']) : 'IDR';

        if (!array_key_exists($currency, $this->currencies)) {
            wp_send_json_error(array('message' => 'Invalid currency'));
        }

        setcookie('cps_currency', $currency, time() + (86400 * 30), '/');

        wp_send_json_success(array(
            'currency' => $currency,
            'symbol' => $this->currencies[$currency]['symbol'],
        ));
    }

    public function output_currency_cookie_script() {
        ?>
        <script>
        (function($) {
            'use strict';
            
            $(document).ready(function() {
                $(document).on('click', '.cps-currency-switcher .currency-btn, .cps-currency-switcher .currency-option', function(e) {
                    e.preventDefault();
                    
                    var $btn = $(this);
                    var currency = $btn.data('currency');
                    
                    $.ajax({
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                        type: 'POST',
                        data: {
                            action: 'cps_change_currency',
                            nonce: '<?php echo wp_create_nonce('cps_currency_nonce'); ?>',
                            currency: currency
                        },
                        success: function(response) {
                            if (response.success) {
                                $('.cps-currency-switcher .currency-btn, .cps-currency-switcher .currency-option').removeClass('active');
                                $('.cps-currency-switcher [data-currency="' + currency + '"]').addClass('active');
                                
                                location.reload();
                            }
                        }
                    });
                });
            });
        })(jQuery);
        </script>
        <style>
        .cps-currency-switcher {
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .currency-label {
            font-size: 0.9rem;
            color: #666;
        }

        .currency-buttons {
            display: flex;
            gap: 5px;
        }

        .currency-btn {
            padding: 6px 12px;
            border: 1px solid #ddd;
            background: #fff;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            transition: all 0.3s;
        }

        .currency-btn:hover {
            border-color: #3498db;
            background: #f0f8ff;
        }

        .currency-btn.active {
            background: #3498db;
            color: #fff;
            border-color: #3498db;
        }

        .currency-flag {
            font-size: 1rem;
        }

        .currency-dropdown {
            position: relative;
        }

        .currency-dropdown-btn {
            padding: 8px 15px;
            border: 1px solid #ddd;
            background: #fff;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
        }

        .currency-dropdown-content {
            position: absolute;
            top: 100%;
            right: 0;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: none;
            min-width: 200px;
            z-index: 1000;
        }

        .currency-dropdown:hover .currency-dropdown-content {
            display: block;
        }

        .currency-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            transition: background 0.2s;
        }

        .currency-option:hover {
            background: #f5f5f5;
        }

        .currency-option.active {
            background: #e8f4fc;
            color: #3498db;
        }

        .currency-info {
            display: flex;
            flex-direction: column;
        }

        .currency-info .currency-code {
            font-weight: 600;
        }

        .currency-info .currency-name {
            font-size: 0.8rem;
            color: #666;
        }

        .cps-flag {
            display: inline-block;
            width: 20px;
            height: 14px;
            background-size: cover;
            background-position: center;
            border-radius: 2px;
        }

        .cps-flag.flag-id { background: linear-gradient(#ff0000 50%, #fff 50%); }
        .cps-flag.flag-us { background: linear-gradient(#002868 25%, #fff 25%, #fff 50%, #bf0a30 50%, #bf0a30 75%, #fff 75%); }
        .cps-flag.flag-eu { background: linear-gradient(#003399 25%, #fff 25%, #fff 50%, #ffcc00 50%, #ffcc00 75%, #fff 75%); }
        .cps-flag.flag-sg { background: linear-gradient(#fff 25%, #ed2939 25%, #ed2939 50%, #fff 50%, #fff 75%, #ed2939 75%); }
        </style>
        <?php
    }

    public function enqueue_styles() {
        wp_enqueue_style('cps-currency-switcher', get_template_directory_uri() . '/assets/css/currency-switcher.css', array(), '1.0.0');
    }

    public function update_exchange_rates() {
        $api_urls = array(
            'idr_usd' => 'https://api.exchangerate-api.com/v4/latest/IDR',
        );

        $response = wp_remote_get($api_urls['idr_usd']);
        
        if (is_wp_error($response)) {
            return false;
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);
        
        if (!empty($body['rates'])) {
            $this->currencies['USD']['rate'] = $body['rates']['USD'];
            $this->currencies['EUR']['rate'] = $body['rates']['EUR'];
            $this->currencies['SGD']['rate'] = $body['rates']['SGD'];
            
            update_option('cps_currency_rates', $this->currencies);
            update_option('cps_currency_rates_updated', current_time('mysql'));
            
            return true;
        }

        return false;
    }
}

CPS_Currency_Switcher::get_instance();
