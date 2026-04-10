<?php
if (!defined('ABSPATH')) {
    exit;
}

class CPS_Public_Mail {

    private static $instance = null;

    public static function get_instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('wp', array($this, 'check_subscription_status'));
        add_shortcode('property_updates', array($this, 'property_updates_shortcode'));
    }

    public function property_updates_shortcode($atts) {
        $atts = shortcode_atts(array(
            'limit' => 5,
        ), $atts);
        
        $mail_handler = CPS_Mail_Handler::get_instance();
        return $mail_handler->get_property_updates_content($atts['limit']);
    }

    public function check_subscription_status() {
        if (isset($_GET['subscribed']) && $_GET['subscribed'] === 'true') {
            add_action('wp_footer', array($this, 'show_subscribed_message'));
        }
        
        if (isset($_GET['unsubscribed']) && $_GET['unsubscribed'] === 'true') {
            add_action('wp_footer', array($this, 'show_unsubscribed_message'));
        }
    }

    public function show_subscribed_message() {
        echo '<div id="cps-subscription-message" class="cps-subscription-message success">' . 
             __('Thank you for subscribing! Your subscription is now active.', 'cari-prop-shop-mail') . 
             '</div>';
    }

    public function show_unsubscribed_message() {
        echo '<div id="cps-subscription-message" class="cps-subscription-message">' . 
             __('You have been unsubscribed from our newsletter.', 'cari-prop-shop-mail') . 
             '</div>';
    }

    public function render_newsletter_form($atts = array()) {
        $defaults = array(
            'title' => __('Subscribe to our Newsletter', 'cari-prop-shop-mail'),
            'subtitle' => __('Get the latest property updates delivered to your inbox.', 'cari-prop-shop-mail'),
            'placeholder' => __('Enter your email address', 'cari-prop-shop-mail'),
            'button_text' => __('Subscribe', 'cari-prop-shop-mail'),
            'show_name' => 'false',
        );
        
        $atts = wp_parse_args($atts, $defaults);
        
        $show_name = filter_var($atts['show_name'], FILTER_VALIDATE_BOOLEAN);
        ?>
        <div class="cps-newsletter-form-wrapper">
            <?php if (!empty($atts['title'])): ?>
                <h3 class="cps-newsletter-title"><?php echo esc_html($atts['title']); ?></h3>
            <?php endif; ?>
            
            <?php if (!empty($atts['subtitle'])): ?>
                <p class="cps-newsletter-subtitle"><?php echo esc_html($atts['subtitle']); ?></p>
            <?php endif; ?>
            
            <form class="cps-newsletter-form" method="post">
                <?php if ($show_name): ?>
                    <div class="cps-form-group">
                        <input type="text" name="name" class="cps-input" placeholder="<?php esc_attr_e('Your Name', 'cari-prop-shop-mail'); ?>" value="">
                    </div>
                <?php endif; ?>
                
                <div class="cps-form-group">
                    <input type="email" name="email" class="cps-input" placeholder="<?php echo esc_attr($atts['placeholder']); ?>" required>
                </div>
                
                <button type="submit" class="cps-submit-button">
                    <?php echo esc_html($atts['button_text']); ?>
                </button>
                
                <div class="cps-message"></div>
            </form>
            
            <p class="cps-privacy-notice">
                <?php _e('We respect your privacy. Unsubscribe at any time.', 'cari-prop-shop-mail'); ?>
            </p>
        </div>
        <?php
    }

    public function render_unsubscribe_form($subscriber_id, $token) {
        ?>
        <div class="cps-unsubscribe-wrapper">
            <h2><?php _e('Unsubscribe', 'cari-prop-shop-mail'); ?></h2>
            <p><?php _e('Are you sure you want to unsubscribe from our newsletter?', 'cari-prop-shop-mail'); ?></p>
            
            <form method="post" action="">
                <input type="hidden" name="subscriber_id" value="<?php echo esc_attr($subscriber_id); ?>">
                <input type="hidden" name="token" value="<?php echo esc_attr($token); ?>">
                <input type="hidden" name="cps_do_unsubscribe" value="1">
                
                <button type="submit" class="button button-primary">
                    <?php _e('Yes, Unsubscribe', 'cari-prop-shop-mail'); ?>
                </button>
                <a href="<?php echo home_url(); ?>" class="button">
                    <?php _e('Cancel', 'cari-prop-shop-mail'); ?>
                </a>
            </form>
        </div>
        <?php
    }
}