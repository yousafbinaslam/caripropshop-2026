<div class="cps-form-wrapper cps-mortgage-calculator-form">
    <h2 class="cps-form-title"><?php echo esc_html($atts['title']); ?></h2>
    
    <form class="cps-form" data-form-type="mortgage_calculator">
        <div class="cps-form-row cps-form-row-half">
            <div class="cps-form-group">
                <label for="cps_first_name"><?php _e('First Name', 'cari-prop-shop-forms'); ?> <span class="required">*</span></label>
                <input type="text" id="cps_first_name" name="first_name" class="cps-input" required>
            </div>
            <div class="cps-form-group">
                <label for="cps_last_name"><?php _e('Last Name', 'cari-prop-shop-forms'); ?> <span class="required">*</span></label>
                <input type="text" id="cps_last_name" name="last_name" class="cps-input" required>
            </div>
        </div>
        
        <div class="cps-form-row">
            <div class="cps-form-group">
                <label for="cps_email"><?php _e('Email', 'cari-prop-shop-forms'); ?> <span class="required">*</span></label>
                <input type="email" id="cps_email" name="email" class="cps-input" required>
            </div>
        </div>
        
        <div class="cps-form-row">
            <div class="cps-form-group">
                <label for="cps_phone"><?php _e('Phone', 'cari-prop-shop-forms'); ?></label>
                <input type="tel" id="cps_phone" name="phone" class="cps-input">
            </div>
        </div>
        
        <hr class="cps-form-divider">
        
        <h3><?php _e('Mortgage Details', 'cari-prop-shop-forms'); ?></h3>
        
        <div class="cps-form-row">
            <div class="cps-form-group">
                <label for="cps_property_price"><?php _e('Property Price', 'cari-prop-shop-forms'); ?> <span class="required">*</span></label>
                <div class="cps-input-with-prefix">
                    <span class="input-prefix">$</span>
                    <input type="number" id="cps_property_price" name="property_price" class="cps-input" placeholder="250000" required>
                </div>
            </div>
        </div>
        
        <div class="cps-form-row cps-form-row-half">
            <div class="cps-form-group">
                <label for="cps_down_payment"><?php _e('Down Payment', 'cari-prop-shop-forms'); ?> <span class="required">*</span></label>
                <div class="cps-input-with-prefix">
                    <span class="input-prefix">$</span>
                    <input type="number" id="cps_down_payment" name="down_payment" class="cps-input" placeholder="50000" required>
                </div>
            </div>
            <div class="cps-form-group">
                <label for="cps_down_payment_percent"><?php _e('Down Payment %', 'cari-prop-shop-forms'); ?></label>
                <input type="number" id="cps_down_payment_percent" class="cps-input" value="20" min="0" max="100">
            </div>
        </div>
        
        <div class="cps-form-row cps-form-row-half">
            <div class="cps-form-group">
                <label for="cps_loan_term"><?php _e('Loan Term', 'cari-prop-shop-forms'); ?> <span class="required">*</span></label>
                <select id="cps_loan_term" name="loan_term" class="cps-select" required>
                    <option value="15"><?php _e('15 Years', 'cari-prop-shop-forms'); ?></option>
                    <option value="20"><?php _e('20 Years', 'cari-prop-shop-forms'); ?></option>
                    <option value="30" selected><?php _e('30 Years', 'cari-prop-shop-forms'); ?></option>
                </select>
            </div>
            <div class="cps-form-group">
                <label for="cps_interest_rate"><?php _e('Interest Rate (%)', 'cari-prop-shop-forms'); ?></label>
                <input type="number" id="cps_interest_rate" name="interest_rate" class="cps-input" value="6.5" step="0.125" min="0" max="30">
            </div>
        </div>
        
        <div class="cps-mortgage-results" style="display: none;">
            <h3><?php _e('Estimated Monthly Payment', 'cari-prop-shop-forms'); ?></h3>
            <div class="cps-monthly-payment">
                <span class="cps-currency">$</span>
                <span class="cps-amount">0</span>
                <span class="cps-period">/month</span>
            </div>
            
            <div class="cps-payment-breakdown">
                <div class="cps-breakdown-row">
                    <span><?php _e('Principal & Interest', 'cari-prop-shop-forms'); ?></span>
                    <span class="cps-pi">$0</span>
                </div>
                <div class="cps-breakdown-row">
                    <span><?php _e('Est. Property Tax', 'cari-prop-shop-forms'); ?></span>
                    <span class="cps-tax">$0</span>
                </div>
                <div class="cps-breakdown-row">
                    <span><?php _e('Est. Insurance', 'cari-prop-shop-forms'); ?></span>
                    <span class="cps-insurance">$0</span>
                </div>
                <div class="cps-breakdown-row cps-total">
                    <span><?php _e('Total Monthly', 'cari-prop-shop-forms'); ?></span>
                    <span class="cps-total-amount">$0</span>
                </div>
            </div>
        </div>
        
        <div class="cps-form-row">
            <button type="button" id="cps_calculate_btn" class="cps-calc-btn"><?php _e('Calculate', 'cari-prop-shop-forms'); ?></button>
        </div>
        
        <div class="cps-form-row">
            <button type="submit" class="cps-submit-btn"><?php echo esc_html($atts['submit_text']); ?></button>
        </div>
        
        <div class="cps-form-message"></div>
    </form>
</div>