<?php
/**
 * Template Name: Contact Us - CariPropShop
 */

get_header();

$contact_info = array(
    'address' => get_option('cps_contact_address', 'Jl. Sudirman No. 123, Jakarta Selatan'),
    'phone' => get_option('cps_contact_phone', '+62 21 1234 5678'),
    'email' => get_option('cps_contact_email', 'info@caripropshop.com'),
    'whatsapp' => get_option('cps_contact_whatsapp', '+62 812 3456 7890'),
    'hours' => get_option('cps_contact_hours', 'Mon - Fri: 9:00 AM - 6:00 PM'),
);

$offices = array(
    array(
        'name' => 'Jakarta Headquarters',
        'address' => 'Jl. Sudirman No. 123, Jakarta Selatan 12190',
        'phone' => '+62 21 1234 5678',
        'email' => 'jakarta@caripropshop.com',
        'map' => '-6.2088,106.8456'
    ),
    array(
        'name' => 'Bali Office',
        'address' => 'Jl. Raya Seminyak No. 45, Bali 80361',
        'phone' => '+62 361 987 654',
        'email' => 'bali@caripropshop.com',
        'map' => '-8.4095,115.1889'
    ),
);
?>

<div class="contact-page">
    <section class="contact-hero">
        <div class="container">
            <div class="hero-content">
                <h1><?php esc_html_e('Get in Touch', 'cari-prop-shop'); ?></h1>
                <p><?php esc_html_e('Have questions about properties? We\'re here to help!', 'cari-prop-shop'); ?></p>
            </div>
        </div>
    </section>

    <section class="contact-info-section">
        <div class="container">
            <div class="contact-info-grid">
                <div class="contact-info-card">
                    <div class="info-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="info-content">
                        <h3><?php esc_html_e('Visit Us', 'cari-prop-shop'); ?></h3>
                        <p><?php echo esc_html($contact_info['address']); ?></p>
                    </div>
                </div>
                
                <div class="contact-info-card">
                    <div class="info-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="info-content">
                        <h3><?php esc_html_e('Call Us', 'cari-prop-shop'); ?></h3>
                        <p><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $contact_info['phone'])); ?>"><?php echo esc_html($contact_info['phone']); ?></a></p>
                        <p class="secondary"><?php echo esc_html($contact_info['hours']); ?></p>
                    </div>
                </div>
                
                <div class="contact-info-card">
                    <div class="info-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="info-content">
                        <h3><?php esc_html_e('Email Us', 'cari-prop-shop'); ?></h3>
                        <p><a href="mailto:<?php echo esc_attr($contact_info['email']); ?>"><?php echo esc_html($contact_info['email']); ?></a></p>
                    </div>
                </div>
                
                <div class="contact-info-card">
                    <div class="info-icon">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <div class="info-content">
                        <h3><?php esc_html_e('WhatsApp', 'cari-prop-shop'); ?></h3>
                        <p><a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $contact_info['whatsapp'])); ?>" target="_blank"><?php echo esc_html($contact_info['whatsapp']); ?></a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-form-section">
        <div class="container">
            <div class="contact-layout">
                <div class="contact-form-wrapper">
                    <div class="form-header">
                        <h2><?php esc_html_e('Send Us a Message', 'cari-prop-shop'); ?></h2>
                        <p><?php esc_html_e('Fill out the form below and we\'ll get back to you shortly.', 'cari-prop-shop'); ?></p>
                    </div>
                    
                    <form id="contact-form" class="contact-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first-name"><?php esc_html_e('First Name', 'cari-prop-shop'); ?> *</label>
                                <input type="text" id="first-name" name="first_name" required>
                            </div>
                            <div class="form-group">
                                <label for="last-name"><?php esc_html_e('Last Name', 'cari-prop-shop'); ?> *</label>
                                <input type="text" id="last-name" name="last_name" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email"><?php esc_html_e('Email Address', 'cari-prop-shop'); ?> *</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="phone"><?php esc_html_e('Phone Number', 'cari-prop-shop'); ?></label>
                                <input type="tel" id="phone" name="phone">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="subject"><?php esc_html_e('Subject', 'cari-prop-shop'); ?> *</label>
                            <select id="subject" name="subject" required>
                                <option value=""><?php esc_html_e('Select a topic', 'cari-prop-shop'); ?></option>
                                <option value="general"><?php esc_html_e('General Inquiry', 'cari-prop-shop'); ?></option>
                                <option value="buying"><?php esc_html_e('Buying a Property', 'cari-prop-shop'); ?></option>
                                <option value="selling"><?php esc_html_e('Selling a Property', 'cari-prop-shop'); ?></option>
                                <option value="renting"><?php esc_html_e('Renting a Property', 'cari-prop-shop'); ?></option>
                                <option value="investing"><?php esc_html_e('Investment Opportunities', 'cari-prop-shop'); ?></option>
                                <option value="services"><?php esc_html_e('Our Services', 'cari-prop-shop'); ?></option>
                                <option value="support"><?php esc_html_e('Technical Support', 'cari-prop-shop'); ?></option>
                                <option value="partnership"><?php esc_html_e('Partnership Inquiry', 'cari-prop-shop'); ?></option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="message"><?php esc_html_e('Message', 'cari-prop-shop'); ?> *</label>
                            <textarea id="message" name="message" rows="6" required placeholder="<?php esc_attr_e('How can we help you?', 'cari-prop-shop'); ?>"></textarea>
                        </div>
                        
                        <div class="form-group checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="newsletter">
                                <span class="checkmark"></span>
                                <?php esc_html_e('Subscribe to our newsletter for property updates', 'cari-prop-shop'); ?>
                            </label>
                        </div>
                        
                        <div class="form-group checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="privacy_policy" required>
                                <span class="checkmark"></span>
                                <?php printf(esc_html__('I agree to the %sPrivacy Policy%s', 'cari-prop-shop'), '<a href="' . esc_url(home_url('/privacy-policy')) . '" target="_blank">', '</a>'); ?>
                            </label>
                        </div>
                        
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-paper-plane"></i>
                            <?php esc_html_e('Send Message', 'cari-prop-shop'); ?>
                        </button>
                        
                        <div class="form-message" id="form-message"></div>
                    </form>
                </div>
                
                <aside class="contact-sidebar">
                    <div class="sidebar-card">
                        <h3><?php esc_html_e('Quick Contact', 'cari-prop-shop'); ?></h3>
                        <p><?php esc_html_e('Prefer to talk? Contact us directly:', 'cari-prop-shop'); ?></p>
                        
                        <div class="quick-contact-items">
                            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $contact_info['phone'])); ?>" class="quick-contact-item">
                                <i class="fas fa-phone"></i>
                                <span><?php echo esc_html($contact_info['phone']); ?></span>
                            </a>
                            <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $contact_info['whatsapp'])); ?>" target="_blank" class="quick-contact-item whatsapp">
                                <i class="fab fa-whatsapp"></i>
                                <span><?php echo esc_html($contact_info['whatsapp']); ?></span>
                            </a>
                            <a href="mailto:<?php echo esc_attr($contact_info['email']); ?>" class="quick-contact-item">
                                <i class="fas fa-envelope"></i>
                                <span><?php echo esc_html($contact_info['email']); ?></span>
                            </a>
                        </div>
                    </div>
                    
                    <div class="sidebar-card">
                        <h3><?php esc_html_e('Working Hours', 'cari-prop-shop'); ?></h3>
                        <ul class="hours-list">
                            <li>
                                <span><?php esc_html_e('Monday - Friday', 'cari-prop-shop'); ?></span>
                                <span>9:00 AM - 6:00 PM</span>
                            </li>
                            <li>
                                <span><?php esc_html_e('Saturday', 'cari-prop-shop'); ?></span>
                                <span>10:00 AM - 4:00 PM</span>
                            </li>
                            <li>
                                <span><?php esc_html_e('Sunday', 'cari-prop-shop'); ?></span>
                                <span><?php esc_html_e('Closed', 'cari-prop-shop'); ?></span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="sidebar-card social-card">
                        <h3><?php esc_html_e('Follow Us', 'cari-prop-shop'); ?></h3>
                        <div class="social-links">
                            <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <section class="offices-section">
        <div class="container">
            <div class="section-header">
                <h2><?php esc_html_e('Our Offices', 'cari-prop-shop'); ?></h2>
                <p><?php esc_html_e('Visit us at any of our locations', 'cari-prop-shop'); ?></p>
            </div>
            
            <div class="offices-grid">
                <?php foreach ($offices as $office) : ?>
                    <div class="office-card">
                        <div class="office-map">
                            <div class="map-placeholder" data-lat="<?php echo esc_attr($office['map']); ?>">
                                <i class="fas fa-map-marked-alt"></i>
                                <span><?php esc_html_e('Map Location', 'cari-prop-shop'); ?></span>
                            </div>
                        </div>
                        <div class="office-info">
                            <h3><?php echo esc_html($office['name']); ?></h3>
                            <p class="office-address">
                                <i class="fas fa-map-marker-alt"></i>
                                <?php echo esc_html($office['address']); ?>
                            </p>
                            <p class="office-contact">
                                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $office['phone'])); ?>">
                                    <i class="fas fa-phone"></i>
                                    <?php echo esc_html($office['phone']); ?>
                                </a>
                            </p>
                            <p class="office-contact">
                                <a href="mailto:<?php echo esc_attr($office['email']); ?>">
                                    <i class="fas fa-envelope"></i>
                                    <?php echo esc_html($office['email']); ?>
                                </a>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="faq-section">
        <div class="container">
            <div class="section-header">
                <h2><?php esc_html_e('Frequently Asked Questions', 'cari-prop-shop'); ?></h2>
                <p><?php esc_html_e('Quick answers to common questions', 'cari-prop-shop'); ?></p>
            </div>
            
            <div class="faq-list">
                <div class="faq-item">
                    <button class="faq-question">
                        <span><?php esc_html_e('How do I schedule a property viewing?', 'cari-prop-shop'); ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p><?php esc_html_e('You can schedule a viewing by contacting us via phone, WhatsApp, or by filling out the inquiry form on the property page. Our agents will arrange a convenient time for you to visit.', 'cari-prop-shop'); ?></p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question">
                        <span><?php esc_html_e('What documents do I need to buy a property?', 'cari-prop-shop'); ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p><?php esc_html_e('Required documents typically include: valid ID (KTP), NPWP, family card (KK), marriage certificate (if applicable), and proof of income. Our team will guide you through the entire process.', 'cari-prop-shop'); ?></p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question">
                        <span><?php esc_html_e('Do you offer property management services?', 'cari-prop-shop'); ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p><?php esc_html_e('Yes, we provide comprehensive property management services including tenant screening, rent collection, maintenance coordination, and regular property inspections.', 'cari-prop-shop'); ?></p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question">
                        <span><?php esc_html_e('What areas do you serve?', 'cari-prop-shop'); ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p><?php esc_html_e('We operate throughout Indonesia with primary focus on Jakarta, Bali, Surabaya, and other major cities. Contact us to discuss your specific location requirements.', 'cari-prop-shop'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contact-form');
    const formMessage = document.getElementById('form-message');
    
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(contactForm);
        formData.append('action', 'cps_submit_contact');
        formData.append('nonce', cpsData.nonce);
        
        const submitBtn = contactForm.querySelector('.btn-submit');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
        
        fetch(cpsData.ajaxUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                formMessage.className = 'form-message success';
                formMessage.textContent = data.data.message;
                contactForm.reset();
            } else {
                formMessage.className = 'form-message error';
                formMessage.textContent = data.data.message || 'Error sending message';
            }
        })
        .catch(error => {
            formMessage.className = 'form-message error';
            formMessage.textContent = 'Network error. Please try again.';
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Send Message';
        });
    });
    
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        question.addEventListener('click', () => {
            const isActive = item.classList.contains('active');
            faqItems.forEach(i => i.classList.remove('active'));
            if (!isActive) {
                item.classList.add('active');
            }
        });
    });
});
</script>

<?php get_footer(); ?>
