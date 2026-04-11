<?php
/**
 * Pricing Table Template
 */

if (!defined('ABSPATH')) {
    exit;
}

$packages = $this->get_packages();
$currency_symbol = 'Rp ';
$currency_position = 'before';
$show_annual = filter_var($atts['show_annual'], FILTER_VALIDATE_BOOLEAN);
$annual_discount = 0.2;
?>

<div class="cps-pricing-section">
    <div class="cps-pricing-header">
        <?php if ($atts['title']) : ?>
            <h2 class="cps-pricing-title"><?php echo esc_html($atts['title']); ?></h2>
        <?php endif; ?>
        <?php if ($atts['subtitle']) : ?>
            <p class="cps-pricing-subtitle"><?php echo esc_html($atts['subtitle']); ?></p>
        <?php endif; ?>
        
        <?php if ($show_annual) : ?>
            <div class="cps-billing-toggle">
                <span class="billing-label monthly active"><?php _e('Monthly', 'cari-prop-shop-payments'); ?></span>
                <label class="switch">
                    <input type="checkbox" id="annualBillingToggle">
                    <span class="slider"></span>
                </label>
                <span class="billing-label annual"><?php _e('Annual', 'cari-prop-shop-payments'); ?>
                    <span class="discount-badge">-<?php echo intval($annual_discount * 100); ?>%</span>
                </span>
            </div>
        <?php endif; ?>
    </div>

    <div class="cps-pricing-grid">
        <?php foreach ($packages as $index => $package) : 
            $package_id = $package->ID;
            $price = get_post_meta($package_id, 'cps_package_price', true);
            $billing = get_post_meta($package_id, 'cps_package_billing', true);
            $features_raw = get_post_meta($package_id, 'cps_package_features', true);
            $listings = get_post_meta($package_id, 'cps_package_listings', true);
            $featured = get_post_meta($package_id, 'cps_package_featured', true);
            $duration = get_post_meta($package_id, 'cps_package_duration', true);
            $is_featured = get_post_meta($package_id, 'cps_package_featured', true);
            $is_popular = get_post_meta($package_id, 'cps_package_popular', true);
            
            $features = $features_raw ? explode("\n", $features_raw) : array();
            
            $annual_price = $price * 12 * (1 - $annual_discount);
            
            $unlimited_listings = $listings == -1;
            $unlimited_featured = $featured == -1;
        ?>
            <div class="cps-pricing-card <?php echo $is_popular ? 'popular' : ''; ?> <?php echo $index === 1 ? 'featured' : ''; ?>">
                <?php if ($is_popular) : ?>
                    <div class="popular-badge"><?php _e('Most Popular', 'cari-prop-shop-payments'); ?></div>
                <?php endif; ?>
                
                <div class="pricing-header">
                    <h3 class="package-name"><?php echo esc_html($package->post_title); ?></h3>
                    <div class="price-wrapper">
                        <span class="currency <?php echo $currency_position; ?>"><?php echo esc_html($currency_symbol); ?></span>
                        <span class="price monthly-price" data-monthly="<?php echo esc_attr($price); ?>" data-annual="<?php echo esc_attr($annual_price); ?>">
                            <?php echo number_format($price, 0, ',', '.'); ?>
                        </span>
                        <span class="price annual-price" style="display: none;" data-monthly="<?php echo esc_attr($price); ?>" data-annual="<?php echo esc_attr($annual_price); ?>">
                            <?php echo number_format($annual_price, 0, ',', '.'); ?>
                        </span>
                        <span class="period">/<?php echo esc_html($billing === 'annual' ? __('year', 'cari-prop-shop-payments') : __('mo', 'cari-prop-shop-payments')); ?></span>
                    </div>
                    <?php if ($show_annual) : ?>
                        <p class="annual-note"><?php _e('Billed annually', 'cari-prop-shop-payments'); ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="pricing-features">
                    <ul>
                        <li class="<?php echo $unlimited_listings ? 'unlimited' : ''; ?>">
                            <i class="fas <?php echo $unlimited_listings ? 'fa-infinity' : 'fa-check'; ?>"></i>
                            <?php echo $unlimited_listings ? __('Unlimited', 'cari-prop-shop-payments') . ' ' . __('Property Listings', 'cari-prop-shop-payments') : number_format($listings) . ' ' . __('Property Listings', 'cari-prop-shop-payments'); ?>
                        </li>
                        <li class="<?php echo $unlimited_featured ? 'unlimited' : ''; ?>">
                            <i class="fas <?php echo $unlimited_featured ? 'fa-infinity' : 'fa-check'; ?>"></i>
                            <?php echo $unlimited_featured ? __('Unlimited', 'cari-prop-shop-payments') . ' ' . __('Featured Listings', 'cari-prop-shop-payments') : number_format($featured) . ' ' . __('Featured Listings', 'cari-prop-shop-payments'); ?>
                        </li>
                        <?php if ($duration) : ?>
                            <li>
                                <i class="fas fa-check"></i>
                                <?php echo $duration . ' ' . __('Days Duration', 'cari-prop-shop-payments'); ?>
                            </li>
                        <?php endif; ?>
                        <?php foreach ($features as $feature) : 
                            $feature = trim($feature);
                            if (empty($feature)) continue;
                            $disabled = strpos($feature, '~') === 0;
                            $feature_text = $disabled ? substr($feature, 1) : $feature;
                        ?>
                            <li class="<?php echo $disabled ? 'disabled' : ''; ?>">
                                <i class="fas <?php echo $disabled ? 'fa-times' : 'fa-check'; ?>"></i>
                                <?php echo esc_html($feature_text); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="pricing-footer">
                    <?php if (is_user_logged_in()) : ?>
                        <button class="cps-btn-pricing" data-package-id="<?php echo esc_attr($package_id); ?>">
                            <?php _e('Subscribe Now', 'cari-prop-shop-payments'); ?>
                        </button>
                    <?php else : ?>
                        <a href="<?php echo esc_url(wp_login_url(get_permalink())); ?>" class="cps-btn-pricing">
                            <?php _e('Login to Subscribe', 'cari-prop-shop-payments'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
.cps-pricing-section {
    padding: 60px 0;
    background: #f8f9fa;
}

.cps-pricing-header {
    text-align: center;
    margin-bottom: 50px;
}

.cps-pricing-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 10px;
}

.cps-pricing-subtitle {
    font-size: 1.2rem;
    color: #7f8c8d;
    margin-bottom: 30px;
}

.cps-billing-toggle {
    display: inline-flex;
    align-items: center;
    gap: 15px;
}

.billing-label {
    font-size: 1rem;
    color: #7f8c8d;
    transition: color 0.3s;
}

.billing-label.active {
    color: #2c3e50;
    font-weight: 600;
}

.discount-badge {
    background: #27ae60;
    color: #fff;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    margin-left: 5px;
}

.switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 26px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
    border-radius: 34px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: 0.4s;
    border-radius: 50%;
}

input:checked + .slider {
    background-color: #3498db;
}

input:checked + .slider:before {
    transform: translateX(24px);
}

.cps-pricing-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.cps-pricing-card {
    background: #fff;
    border-radius: 16px;
    padding: 40px 30px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    transition: transform 0.3s, box-shadow 0.3s;
    position: relative;
    overflow: hidden;
}

.cps-pricing-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(0,0,0,0.15);
}

.cps-pricing-card.featured {
    border: 2px solid #3498db;
}

.cps-pricing-card.popular {
    transform: scale(1.05);
    z-index: 2;
}

.popular-badge {
    position: absolute;
    top: 0;
    right: 0;
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: #fff;
    padding: 8px 20px;
    font-size: 0.85rem;
    font-weight: 600;
    border-radius: 0 14px 0 20px;
}

.pricing-header {
    text-align: center;
    margin-bottom: 30px;
}

.package-name {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 15px;
}

.price-wrapper {
    display: flex;
    align-items: baseline;
    justify-content: center;
    gap: 4px;
}

.currency {
    font-size: 1.5rem;
    font-weight: 600;
    color: #3498db;
}

.currency.before {
    order: -1;
}

.price {
    font-size: 3rem;
    font-weight: 700;
    color: #2c3e50;
}

.period {
    font-size: 1rem;
    color: #7f8c8d;
}

.annual-note {
    font-size: 0.85rem;
    color: #95a5a6;
    margin-top: 5px;
}

.pricing-features ul {
    list-style: none;
    padding: 0;
    margin: 0 0 30px 0;
}

.pricing-features li {
    padding: 12px 0;
    border-bottom: 1px solid #ecf0f1;
    display: flex;
    align-items: center;
    gap: 10px;
}

.pricing-features li:last-child {
    border-bottom: none;
}

.pricing-features li i {
    color: #27ae60;
    width: 20px;
    text-align: center;
}

.pricing-features li.disabled {
    color: #95a5a6;
    text-decoration: line-through;
}

.pricing-features li.disabled i {
    color: #95a5a6;
}

.pricing-features li.unlimited i {
    color: #9b59b6;
}

.pricing-footer {
    text-align: center;
}

.cps-btn-pricing {
    display: inline-block;
    width: 100%;
    padding: 15px 30px;
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
}

.cps-btn-pricing:hover {
    background: linear-gradient(135deg, #2980b9, #2471a3);
    transform: scale(1.02);
}

.cps-pricing-card.featured .cps-btn-pricing {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
}

.cps-pricing-card.featured .cps-btn-pricing:hover {
    background: linear-gradient(135deg, #c0392b, #a93226);
}

@media (max-width: 768px) {
    .cps-pricing-card.popular {
        transform: scale(1);
    }
    
    .cps-pricing-grid {
        grid-template-columns: 1fr;
        max-width: 400px;
    }
}
</style>

<script>
(function($) {
    'use strict';

    $(document).ready(function() {
        $('#annualBillingToggle').on('change', function() {
            const isAnnual = $(this).is(':checked');
            const $cards = $('.cps-pricing-card');

            if (isAnnual) {
                $('.monthly-price').hide();
                $('.annual-price').show();
                $('.billing-label.monthly').removeClass('active');
                $('.billing-label.annual').addClass('active');
            } else {
                $('.monthly-price').show();
                $('.annual-price').hide();
                $('.billing-label.monthly').addClass('active');
                $('.billing-label.annual').removeClass('active');
            }
        });

        $('.cps-btn-pricing').on('click', function() {
            const packageId = $(this).data('package-id');
            
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'cps_create_subscription',
                    nonce: '<?php echo wp_create_nonce('cps_payments_nonce'); ?>',
                    package_id: packageId
                },
                success: function(response) {
                    if (response.success && response.data.redirect_url) {
                        window.location.href = response.data.redirect_url;
                    } else if (response.success) {
                        alert('<?php _e('Subscription created successfully!', 'cari-prop-shop-payments'); ?>');
                    } else {
                        alert(response.data.message || '<?php _e('Error creating subscription', 'cari-prop-shop-payments'); ?>');
                    }
                },
                error: function() {
                    alert('<?php _e('An error occurred. Please try again.', 'cari-prop-shop-payments'); ?>');
                }
            });
        });
    });
})(jQuery);
</script>
