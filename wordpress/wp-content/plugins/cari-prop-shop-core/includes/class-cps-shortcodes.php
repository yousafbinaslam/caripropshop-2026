<?php
/**
 * Shortcodes Class
 * 
 * Handles custom shortcodes for property display
 *
 * @package CariPropShop
 */

if (!defined('ABSPATH')) {
    exit;
}

class CPS_Shortcodes {

    /**
     * Constructor
     */
    public function __construct() {
        add_shortcode('cps_properties', array($this, 'properties_shortcode'));
        add_shortcode('cps_property_grid', array($this, 'properties_shortcode'));
        add_shortcode('cps_property_search', array($this, 'property_search_shortcode'));
        add_shortcode('cps_property_slider', array($this, 'property_slider_shortcode'));
        add_shortcode('cps_agents', array($this, 'agents_shortcode'));
        add_shortcode('cps_property_types', array($this, 'property_types_shortcode'));
        add_shortcode('cps_testimonials', array($this, 'testimonials_shortcode'));
        add_shortcode('cps_mortgage_calculator', array($this, 'mortgage_calculator_shortcode'));
        add_shortcode('cps_contact_form', array($this, 'contact_form_shortcode'));
    }

    /**
     * Properties shortcode
     */
    public function properties_shortcode($atts) {
        $atts = shortcode_atts(array(
            'count' => 6,
            'type' => '',
            'status' => '',
            'location' => '',
            'orderby' => 'date',
            'order' => 'DESC',
            'columns' => 3,
        ), $atts, 'cps_properties');

        $args = array(
            'post_type' => 'property',
            'posts_per_page' => intval($atts['count']),
            'orderby' => $atts['orderby'],
            'order' => $atts['order'],
        );

        if (!empty($atts['type'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'property_type',
                'field' => 'slug',
                'terms' => $atts['type'],
            );
        }

        if (!empty($atts['status'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'property_status',
                'field' => 'slug',
                'terms' => $atts['status'],
            );
        }

        if (!empty($atts['location'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'property_location',
                'field' => 'slug',
                'terms' => $atts['location'],
            );
        }

        $properties = new WP_Query($args);
        
        if (!$properties->have_posts()) {
            return '<p class="cps-no-properties">' . __('No properties found.', 'cari-prop-shop') . '</p>';
        }

        ob_start();
        
        echo '<div class="cps-properties-grid cps-columns-' . esc_attr($atts['columns']) . '">';
        
        while ($properties->have_posts()) {
            $properties->the_post();
            $this->render_property_card(get_post());
        }
        
        echo '</div>';
        
        wp_reset_postdata();
        
        return ob_get_clean();
    }

    /**
     * Render property card
     */
    private function render_property_card($post) {
        $price = get_post_meta($post->ID, 'cps_price', true);
        $address = get_post_meta($post->ID, 'cps_address', true);
        $bedrooms = get_post_meta($post->ID, 'cps_bedrooms', true);
        $bathrooms = get_post_meta($post->ID, 'cps_bathrooms', true);
        $sqft = get_post_meta($post->ID, 'cps_sqft', true);
        $status = get_post_meta($post->ID, 'cps_status', true);
        $image = get_the_post_thumbnail_url($post->ID, 'medium');
        $types = get_the_terms($post->ID, 'property_type');
        $status_terms = get_the_terms($post->ID, 'property_status');
        ?>
        
        <article class="cps-property-card">
            <a href="<?php echo esc_url(get_permalink($post->ID)); ?>" class="property-card-link">
                <div class="cps-property-image">
                    <?php if (has_post_thumbnail($post->ID)) : ?>
                        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($post->post_title); ?>">
                    <?php else : ?>
                        <div class="cps-property-placeholder">
                            <span><?php esc_html_e('No Image', 'cari-prop-shop'); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($status) : ?>
                        <span class="cps-property-status">
                            <?php echo esc_html($status); ?>
                        </span>
                    <?php elseif ($status_terms) : ?>
                        <span class="cps-property-status">
                            <?php echo esc_html($status_terms[0]->name); ?>
                        </span>
                    <?php else : ?>
                        <span class="cps-property-status">For Sale</span>
                    <?php endif; ?>
                </div>
                
                <div class="cps-property-content">
                    <h3 class="cps-property-title">
                        <?php echo esc_html($post->post_title); ?>
                    </h3>
                    
                    <?php if ($price) : ?>
                        <div class="cps-property-price">
                            <?php echo 'Rp ' . number_format((int)$price, 0, ',', '.'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($address) : ?>
                        <p class="cps-property-address">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo esc_html($address); ?>
                        </p>
                    <?php endif; ?>
                    
                    <div class="cps-property-specs">
                        <?php if ($bedrooms) : ?>
                            <span><i class="fas fa-bed"></i> <?php echo esc_html($bedrooms); ?> Beds</span>
                        <?php endif; ?>
                        <?php if ($bathrooms) : ?>
                            <span><i class="fas fa-bath"></i> <?php echo esc_html($bathrooms); ?> Baths</span>
                        <?php endif; ?>
                        <?php if ($sqft) : ?>
                            <span><i class="fas fa-ruler-combined"></i> <?php echo esc_html($sqft); ?> sqft</span>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
        </article>
        
        <?php
    }

    /**
     * Property search shortcode
     */
    public function property_search_shortcode($atts) {
        $atts = shortcode_atts(array(
            'layout' => 'horizontal',
        ), $atts, 'cps_property_search');

        ob_start();
        ?>
        <div class="cps-property-search cps-search-<?php echo esc_attr($atts['layout']); ?>">
            <form action="<?php echo esc_url(home_url('/properties')); ?>" method="get">
                <div class="cps-search-fields">
                    <div class="cps-search-field">
                        <label><?php esc_html_e('Keyword', 'cari-prop-shop'); ?></label>
                        <input type="text" name="s" placeholder="<?php esc_attr_e('Search properties...', 'cari-prop-shop'); ?>">
                    </div>
                    
                    <div class="cps-search-field">
                        <label><?php esc_html_e('Property Type', 'cari-prop-shop'); ?></label>
                        <?php 
                        wp_dropdown_categories(array(
                            'taxonomy' => 'property_type',
                            'name' => 'property_type',
                            'show_option_all' => __('All Types', 'cari-prop-shop'),
                            'class' => 'cps-select',
                        ));
                        ?>
                    </div>
                    
                    <div class="cps-search-field">
                        <label><?php esc_html_e('Location', 'cari-prop-shop'); ?></label>
                        <?php 
                        wp_dropdown_categories(array(
                            'taxonomy' => 'property_location',
                            'name' => 'property_location',
                            'show_option_all' => __('All Locations', 'cari-prop-shop'),
                            'class' => 'cps-select',
                        ));
                        ?>
                    </div>
                    
                    <div class="cps-search-field cps-search-field-price">
                        <label><?php esc_html_e('Min Price', 'cari-prop-shop'); ?></label>
                        <select name="min_price" class="cps-select">
                            <option value=""><?php esc_html_e('No Min', 'cari-prop-shop'); ?></option>
                            <option value="100000000">IDR 100M</option>
                            <option value="250000000">IDR 250M</option>
                            <option value="500000000">IDR 500M</option>
                            <option value="1000000000">IDR 1B</option>
                            <option value="2000000000">IDR 2B</option>
                            <option value="5000000000">IDR 5B</option>
                        </select>
                    </div>
                    
                    <div class="cps-search-field">
                        <label><?php esc_html_e('Bedrooms', 'cari-prop-shop'); ?></label>
                        <select name="bedrooms" class="cps-select">
                            <option value=""><?php esc_html_e('Any', 'cari-prop-shop'); ?></option>
                            <?php for ($i = 1; $i <= 10; $i++) : ?>
                                <option value="<?php echo esc_attr($i); ?>"><?php echo esc_html($i); ?>+</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    
                    <div class="cps-search-field">
                        <button type="submit" class="cps-search-btn">
                            <i class="fas fa-search"></i>
                            <?php esc_html_e('Search', 'cari-prop-shop'); ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <?php
        
        return ob_get_clean();
    }

    /**
     * Property slider shortcode
     */
    public function property_slider_shortcode($atts) {
        $atts = shortcode_atts(array(
            'count' => 6,
            'type' => 'featured',
        ), $atts, 'cps_property_slider');

        $args = array(
            'post_type' => 'property',
            'posts_per_page' => intval($atts['count']),
            'orderby' => 'rand',
        );

        if ($atts['type'] === 'featured') {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'property_status',
                    'field' => 'slug',
                    'terms' => 'featured',
                ),
            );
        }

        $properties = new WP_Query($args);
        
        if (!$properties->have_posts()) {
            return '';
        }

        ob_start();
        ?>
        <div class="cps-property-slider">
            <div class="cps-slider-container">
                <div class="cps-slider-track" id="propertySliderTrack">
                    <?php 
                    while ($properties->have_posts()) {
                        $properties->the_post();
                        $this->render_slider_card(get_post());
                    }
                    ?>
                </div>
                <div class="cps-slider-nav">
                    <button class="cps-slider-prev" id="sliderPrev">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="cps-slider-next" id="sliderNext">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
        <?php
        
        wp_reset_postdata();
        
        return ob_get_clean();
    }

    /**
     * Render slider card
     */
    private function render_slider_card($post) {
        $price = get_post_meta($post->ID, 'property_price', true);
        $image = get_the_post_thumbnail_url($post->ID, 'large');
        ?>
        
        <div class="cps-slider-item">
            <a href="<?php echo esc_url(get_permalink($post->ID)); ?>">
                <div class="cps-slider-image">
                    <?php if (has_post_thumbnail($post->ID)) : ?>
                        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($post->post_title); ?>">
                    <?php else : ?>
                        <div class="cps-slider-placeholder">
                            <i class="fas fa-home"></i>
                        </div>
                    <?php endif; ?>
                    <div class="cps-slider-overlay">
                        <h3><?php echo esc_html($post->post_title); ?></h3>
                        <?php if ($price) : ?>
                            <p class="cps-slider-price"><?php echo esc_html($price); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
        </div>
        
        <?php
    }

    /**
     * Agents shortcode
     */
    public function agents_shortcode($atts) {
        $atts = shortcode_atts(array(
            'count' => 4,
        ), $atts, 'cps_agents');

        $agents = get_posts(array(
            'post_type' => 'agent',
            'posts_per_page' => intval($atts['count']),
            'orderby' => 'rand',
        ));

        if (!$agents) {
            return '<p class="cps-no-agents">' . __('No agents found.', 'cari-prop-shop') . '</p>';
        }

        ob_start();
        
        echo '<div class="cps-agents-grid">';
        
        foreach ($agents as $agent) {
            $photo = get_the_post_thumbnail_url($agent->ID, 'medium');
            $email = get_post_meta($agent->ID, 'cps_agent_email', true);
            $phone = get_post_meta($agent->ID, 'cps_agent_phone', true);
            ?>
            
            <article class="cps-agent-card">
                <div class="cps-agent-photo">
                    <?php if ($photo) : ?>
                        <img src="<?php echo esc_url($photo); ?>" alt="<?php echo esc_attr($agent->post_title); ?>">
                    <?php else : ?>
                        <div class="cps-agent-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="cps-agent-content">
                    <h3 class="cps-agent-name">
                        <?php echo esc_html($agent->post_title); ?>
                    </h3>
                    
                    <?php if ($phone) : ?>
                        <div class="cps-agent-phone">
                            <i class="fas fa-phone"></i>
                            <?php echo esc_html($phone); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($email) : ?>
                        <div class="cps-agent-email">
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:<?php echo esc_attr($email); ?>">
                                <?php echo esc_html($email); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </article>
            
            <?php
        }
        
        echo '</div>';
        
        return ob_get_clean();
    }

    /**
     * Property types shortcode
     */
    public function property_types_shortcode($atts) {
        $types = get_terms(array(
            'taxonomy' => 'property_type',
            'hide_empty' => true,
        ));

        if (!$types || is_wp_error($types)) {
            return '';
        }

        ob_start();
        ?>
        <div class="cps-property-types-section">
            <div class="container">
                <div class="cps-property-types-grid">
                    <?php foreach ($types as $type) : 
                        $icon = $this->get_property_type_icon($type->slug);
                        $count = $type->count;
                    ?>
                        <a href="<?php echo esc_url(get_term_link($type)); ?>" class="cps-type-card">
                            <div class="cps-type-icon">
                                <i class="<?php echo esc_attr($icon); ?>"></i>
                            </div>
                            <h3 class="cps-type-name"><?php echo esc_html($type->name); ?></h3>
                            <span class="cps-type-count"><?php echo esc_html($count); ?> <?php esc_html_e('Properties', 'cari-prop-shop'); ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php
        
        return ob_get_clean();
    }

    /**
     * Get property type icon
     */
    private function get_property_type_icon($slug) {
        $icons = array(
            'studio' => 'fas fa-door-open',
            'apartment' => 'fas fa-building',
            'single-family-home' => 'fas fa-home',
            'shop' => 'fas fa-store',
            'office' => 'fas fa-briefcase',
            'villa' => 'fas fa-place-of-worship',
            'condo' => 'fas fa-city',
            'lot' => 'fas fa-map',
            'multi-family-home' => 'fas fa-hotel',
            'commercial' => 'fas fa-store-alt',
            'residential' => 'fas fa-house-user',
        );
        
        return isset($icons[$slug]) ? $icons[$slug] : 'fas fa-building';
    }

    /**
     * Testimonials shortcode
     */
    public function testimonials_shortcode($atts) {
        $atts = shortcode_atts(array(
            'count' => 6,
            'style' => 'grid',
        ), $atts, 'cps_testimonials');

        $testimonials = get_posts(array(
            'post_type' => 'cps_testimonial',
            'posts_per_page' => intval($atts['count']),
            'orderby' => 'rand',
        ));

        if (!$testimonials) {
            $testimonials = get_posts(array(
                'post_type' => 'testimonial',
                'posts_per_page' => intval($atts['count']),
                'orderby' => 'rand',
            ));
        }

        if (!$testimonials) {
            return '';
        }

        ob_start();
        
        if ($atts['style'] === 'carousel') :
        ?>
        <div class="cps-testimonials-carousel">
            <div class="testimonial-slider" id="testimonialSlider">
                <?php foreach ($testimonials as $testimonial) : 
                    $photo = get_the_post_thumbnail_url($testimonial->ID, 'thumbnail');
                    $role = get_post_meta($testimonial->ID, 'cps_testimonial_role', true);
                    $company = get_post_meta($testimonial->ID, 'cps_testimonial_company', true);
                    $rating = get_post_meta($testimonial->ID, 'cps_testimonial_rating', true);
                ?>
                    <div class="testimonial-slide">
                        <div class="testimonial-card">
                            <?php if ($rating) : ?>
                                <div class="testimonial-rating">
                                    <?php for ($i = 0; $i < 5; $i++) : ?>
                                        <i class="fas fa-star<?php echo $i < $rating ? '' : '-half-alt'; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            <?php endif; ?>
                            <div class="testimonial-content">
                                <i class="fas fa-quote-left"></i>
                                <p><?php echo esc_html($testimonial->post_content); ?></p>
                            </div>
                            <div class="testimonial-author">
                                <?php if ($photo) : ?>
                                    <img src="<?php echo esc_url($photo); ?>" alt="<?php echo esc_attr($testimonial->post_title); ?>">
                                <?php else : ?>
                                    <div class="author-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="author-info">
                                    <h4><?php echo esc_html($testimonial->post_title); ?></h4>
                                    <?php if ($role || $company) : ?>
                                        <span><?php echo esc_html($role); ?><?php echo $role && $company ? ' at ' : ''; ?><?php echo esc_html($company); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="slider-nav">
                <button class="slider-prev" id="testimonialPrev"><i class="fas fa-chevron-left"></i></button>
                <button class="slider-next" id="testimonialNext"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="slider-dots" id="testimonialDots"></div>
        </div>
        <?php else : ?>
        <div class="cps-testimonials-section">
            <h2 class="section-title"><?php esc_html_e('What Our Clients Say', 'cari-prop-shop'); ?></h2>
            <div class="cps-testimonials-grid">
                <?php foreach ($testimonials as $testimonial) : 
                    $photo = get_the_post_thumbnail_url($testimonial->ID, 'thumbnail');
                    $role = get_post_meta($testimonial->ID, 'cps_testimonial_role', true);
                    $rating = get_post_meta($testimonial->ID, 'cps_testimonial_rating', true);
                ?>
                    <div class="cps-testimonial-card">
                        <?php if ($rating) : ?>
                            <div class="testimonial-rating">
                                <?php for ($i = 0; $i < 5; $i++) : ?>
                                    <i class="fas fa-star<?php echo $i < $rating ? '' : '-half-alt'; ?>"></i>
                                <?php endfor; ?>
                            </div>
                        <?php endif; ?>
                        <div class="cps-testimonial-content">
                            <i class="fas fa-quote-left"></i>
                            <p><?php echo esc_html($testimonial->post_content); ?></p>
                        </div>
                        <div class="cps-testimonial-author">
                            <?php if ($photo) : ?>
                                <img src="<?php echo esc_url($photo); ?>" alt="<?php echo esc_attr($testimonial->post_title); ?>">
                            <?php else : ?>
                                <div class="cps-author-placeholder">
                                    <i class="fas fa-user"></i>
                                </div>
                            <?php endif; ?>
                            <div class="cps-author-info">
                                <h4><?php echo esc_html($testimonial->post_title); ?></h4>
                                <?php if ($role) : ?>
                                    <span><?php echo esc_html($role); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php 
        endif;
        
        return ob_get_clean();
    }

    /**
     * Mortgage calculator shortcode
     */
    public function mortgage_calculator_shortcode($atts) {
        ob_start();
        ?>
        <div class="cps-mortgage-calculator">
            <h3><?php esc_html_e('Mortgage Calculator', 'cari-prop-shop'); ?></h3>
            <form id="mortgageCalculator">
                <div class="calc-field">
                    <label><?php esc_html_e('Property Price', 'cari-prop-shop'); ?></label>
                    <input type="number" id="calcPrice" placeholder="Enter price" value="500000000">
                </div>
                <div class="calc-field">
                    <label><?php esc_html_e('Down Payment (%)', 'cari-prop-shop'); ?></label>
                    <input type="range" id="calcDown" min="5" max="50" value="20">
                    <span id="downPercent">20%</span>
                </div>
                <div class="calc-field">
                    <label><?php esc_html_e('Loan Term (Years)', 'cari-prop-shop'); ?></label>
                    <select id="calcTerm">
                        <option value="5">5 years</option>
                        <option value="10">10 years</option>
                        <option value="15" selected>15 years</option>
                        <option value="20">20 years</option>
                        <option value="25">25 years</option>
                    </select>
                </div>
                <div class="calc-field">
                    <label><?php esc_html_e('Interest Rate (%)', 'cari-prop-shop'); ?></label>
                    <input type="number" id="calcRate" step="0.1" value="10">
                </div>
                <button type="button" onclick="calculateMortgage()">
                    <?php esc_html_e('Calculate', 'cari-prop-shop'); ?>
                </button>
            </form>
            <div class="calc-result" id="calcResult" style="display:none;">
                <div class="result-item">
                    <span><?php esc_html_e('Loan Amount', 'cari-prop-shop'); ?></span>
                    <strong id="loanAmount">-</strong>
                </div>
                <div class="result-item">
                    <span><?php esc_html_e('Monthly Payment', 'cari-prop-shop'); ?></span>
                    <strong id="monthlyPayment">-</strong>
                </div>
                <div class="result-item">
                    <span><?php esc_html_e('Total Interest', 'cari-prop-shop'); ?></span>
                    <strong id="totalInterest">-</strong>
                </div>
            </div>
        </div>
        <script>
        function calculateMortgage() {
            const price = parseFloat(document.getElementById('calcPrice').value) || 0;
            const downPercent = parseFloat(document.getElementById('calcDown').value) || 20;
            const term = parseInt(document.getElementById('calcTerm').value) || 15;
            const rate = parseFloat(document.getElementById('calcRate').value) || 10;
            
            const downPayment = price * (downPercent / 100);
            const loanAmount = price - downPayment;
            const monthlyRate = (rate / 100) / 12;
            const numPayments = term * 12;
            
            let monthlyPayment = 0;
            if (monthlyRate > 0) {
                monthlyPayment = loanAmount * (monthlyRate * Math.pow(1 + monthlyRate, numPayments)) / (Math.pow(1 + monthlyRate, numPayments) - 1);
            } else {
                monthlyPayment = loanAmount / numPayments;
            }
            
            const totalPayment = monthlyPayment * numPayments;
            const totalInterest = totalPayment - loanAmount;
            
            document.getElementById('loanAmount').textContent = 'IDR ' + formatNumber(loanAmount);
            document.getElementById('monthlyPayment').textContent = 'IDR ' + formatNumber(monthlyPayment);
            document.getElementById('totalInterest').textContent = 'IDR ' + formatNumber(totalInterest);
            document.getElementById('calcResult').style.display = 'block';
        }
        
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        
        document.getElementById('calcDown').addEventListener('input', function() {
            document.getElementById('downPercent').textContent = this.value + '%';
        });
        </script>
        <?php
        
        return ob_get_clean();
    }

    /**
     * Contact form shortcode
     */
    public function contact_form_shortcode($atts) {
        $atts = shortcode_atts(array(
            'property_id' => '',
        ), $atts, 'cps_contact_form');

        ob_start();
        ?>
        <form class="cps-contact-form" id="contactForm">
            <input type="hidden" name="property_id" value="<?php echo esc_attr($atts['property_id']); ?>">
            <?php wp_nonce_field('cps_contact', 'cps_contact_nonce'); ?>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="cfName"><?php esc_html_e('Name *', 'cari-prop-shop'); ?></label>
                    <input type="text" id="cfName" name="name" required>
                </div>
                <div class="form-group">
                    <label for="cfEmail"><?php esc_html_e('Email *', 'cari-prop-shop'); ?></label>
                    <input type="email" id="cfEmail" name="email" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="cfPhone"><?php esc_html_e('Phone *', 'cari-prop-shop'); ?></label>
                    <input type="tel" id="cfPhone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="cfType"><?php esc_html_e('Inquiry Type', 'cari-prop-shop'); ?></label>
                    <select id="cfType" name="inquiry_type">
                        <option value="purchase">Purchase</option>
                        <option value="rent">Rent</option>
                        <option value="sell">Sell</option>
                        <option value="valuation">Property Valuation</option>
                        <option value="mortgage">Mortgage</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group full">
                <label for="cfMessage"><?php esc_html_e('Message', 'cari-prop-shop'); ?></label>
                <textarea id="cfMessage" name="message" rows="5"></textarea>
            </div>
            
            <button type="submit" class="cps-btn-submit">
                <?php esc_html_e('Submit', 'cari-prop-shop'); ?>
            </button>
            
            <div class="form-message" id="formMessage"></div>
        </form>
        <?php
        
        return ob_get_clean();
    }
}

// Initialize shortcodes
new CPS_Shortcodes();
