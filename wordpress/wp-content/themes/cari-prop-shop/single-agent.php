<?php
get_header();

$email = get_post_meta(get_the_ID(), 'cps_agent_email', true);
$phone = get_post_meta(get_the_ID(), 'cps_agent_phone', true);
$mobile = get_post_meta(get_the_ID(), 'cps_agent_mobile', true);
$whatsapp = get_post_meta(get_the_ID(), 'cps_agent_whatsapp', true);
$position = get_post_meta(get_the_ID(), 'cps_agent_position', true);
$license = get_post_meta(get_the_ID(), 'cps_agent_license', true);
$experience = get_post_meta(get_the_ID(), 'cps_agent_experience', true);
$specialties = get_post_meta(get_the_ID(), 'cps_agent_specialties', true);

$facebook = get_post_meta(get_the_ID(), 'cps_agent_facebook', true);
$twitter = get_post_meta(get_the_ID(), 'cps_agent_twitter', true);
$linkedin = get_post_meta(get_the_ID(), 'cps_agent_linkedin', true);
$instagram = get_post_meta(get_the_ID(), 'cps_agent_instagram', true);
$youtube = get_post_meta(get_the_ID(), 'cps_agent_youtube', true);
$tiktok = get_post_meta(get_the_ID(), 'cps_agent_tiktok', true);
?>

<div class="agent-page">
    <div class="agent-hero">
        <div class="container">
            <div class="agent-profile">
                <div class="agent-photo">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('medium_large'); ?>
                    <?php else : ?>
                        <div class="agent-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="agent-info">
                    <h1><?php the_title(); ?></h1>
                    <?php if ($position) : ?>
                        <p class="agent-position"><?php echo esc_html($position); ?></p>
                    <?php endif; ?>
                    
                    <div class="agent-contact">
                        <?php if ($email) : ?>
                            <a href="mailto:<?php echo esc_attr($email); ?>" class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <span><?php echo esc_html($email); ?></span>
                            </a>
                        <?php endif; ?>
                        <?php if ($phone) : ?>
                            <a href="tel:<?php echo esc_attr($phone); ?>" class="contact-item">
                                <i class="fas fa-phone"></i>
                                <span><?php echo esc_html($phone); ?></span>
                            </a>
                        <?php endif; ?>
                        <?php if ($whatsapp) : ?>
                            <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $whatsapp)); ?>" class="contact-item whatsapp" target="_blank">
                                <i class="fab fa-whatsapp"></i>
                                <span><?php echo esc_html($whatsapp); ?></span>
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="agent-social">
                        <?php if ($facebook) : ?>
                            <a href="<?php echo esc_url($facebook); ?>" target="_blank" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <?php endif; ?>
                        <?php if ($twitter) : ?>
                            <a href="<?php echo esc_url($twitter); ?>" target="_blank" class="social-link"><i class="fab fa-twitter"></i></a>
                        <?php endif; ?>
                        <?php if ($linkedin) : ?>
                            <a href="<?php echo esc_url($linkedin); ?>" target="_blank" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                        <?php endif; ?>
                        <?php if ($instagram) : ?>
                            <a href="<?php echo esc_url($instagram); ?>" target="_blank" class="social-link"><i class="fab fa-instagram"></i></a>
                        <?php endif; ?>
                        <?php if ($youtube) : ?>
                            <a href="<?php echo esc_url($youtube); ?>" target="_blank" class="social-link"><i class="fab fa-youtube"></i></a>
                        <?php endif; ?>
                        <?php if ($tiktok) : ?>
                            <a href="<?php echo esc_url($tiktok); ?>" target="_blank" class="social-link"><i class="fab fa-tiktok"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="agent-content">
        <div class="container">
            <div class="agent-grid">
                <div class="agent-main">
                    <div class="agent-section">
                        <h2>About Me</h2>
                        <div class="agent-bio">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <div class="agent-section">
                        <h2>My Listings</h2>
                        <?php echo do_shortcode('[cps_properties agent_id="' . get_the_ID() . '" count="6"]'); ?>
                    </div>
                </div>

                <div class="agent-sidebar">
                    <div class="agent-stats-card">
                        <h3>Agent Stats</h3>
                        <?php if ($license) : ?>
                            <div class="stat-item">
                                <span class="stat-label">License</span>
                                <span class="stat-value"><?php echo esc_html($license); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ($experience) : ?>
                            <div class="stat-item">
                                <span class="stat-label">Experience</span>
                                <span class="stat-value"><?php echo esc_html($experience); ?> Years</span>
                            </div>
                        <?php endif; ?>
                        <?php if ($specialties) : ?>
                            <div class="stat-item">
                                <span class="stat-label">Specialties</span>
                                <span class="stat-value"><?php echo esc_html($specialties); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="agent-contact-card">
                        <h3>Contact Me</h3>
                        <form class="agent-contact-form" id="agentContactForm">
                            <input type="hidden" name="agent_id" value="<?php the_ID(); ?>">
                            <?php wp_nonce_field('cps_agent_contact', 'cps_agent_nonce'); ?>
                            
                            <div class="form-group">
                                <input type="text" name="name" placeholder="Your Name *" required>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" placeholder="Your Email *" required>
                            </div>
                            <div class="form-group">
                                <input type="tel" name="phone" placeholder="Your Phone *" required>
                            </div>
                            <div class="form-group">
                                <textarea name="message" rows="4" placeholder="Your Message *" required></textarea>
                            </div>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-paper-plane"></i> Send Message
                            </button>
                            <div class="form-message" id="formMessage"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.agent-page {
    background: #f8f9fa;
}

.agent-hero {
    background: linear-gradient(135deg, #1a365d 0%, #2c5282 100%);
    padding: 60px 0;
    color: white;
}

.agent-profile {
    display: flex;
    gap: 40px;
    align-items: center;
}

.agent-photo {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    overflow: hidden;
    border: 5px solid rgba(255,255,255,0.3);
    background: rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
}

.agent-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.agent-placeholder i {
    font-size: 80px;
    opacity: 0.5;
}

.agent-info h1 {
    margin: 0 0 10px;
    font-size: 36px;
}

.agent-position {
    font-size: 18px;
    opacity: 0.9;
    margin: 0 0 20px;
}

.agent-contact {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 20px;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 12px;
    color: white;
    text-decoration: none;
    font-size: 15px;
}

.contact-item:hover {
    color: #63b3ed;
}

.contact-item.whatsapp:hover {
    color: #25d366;
}

.contact-item i {
    width: 20px;
}

.agent-social {
    display: flex;
    gap: 15px;
}

.social-link {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-link:hover {
    background: white;
    color: #1a365d;
}

.agent-content {
    padding: 60px 0;
}

.agent-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 40px;
}

.agent-section {
    background: white;
    border-radius: 12px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.agent-section h2 {
    margin: 0 0 20px;
    font-size: 24px;
    color: #1a365d;
}

.agent-bio {
    color: #4a5568;
    line-height: 1.8;
}

.agent-stats-card,
.agent-contact-card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-bottom: 20px;
}

.agent-stats-card h3,
.agent-contact-card h3 {
    margin: 0 0 20px;
    font-size: 18px;
    color: #1a365d;
}

.stat-item {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #edf2f7;
}

.stat-item:last-child {
    border-bottom: none;
}

.stat-label {
    color: #718096;
}

.stat-value {
    font-weight: 600;
    color: #1a365d;
}

.agent-contact-form .form-group {
    margin-bottom: 15px;
}

.agent-contact-form input,
.agent-contact-form textarea {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 14px;
}

.agent-contact-form input:focus,
.agent-contact-form textarea:focus {
    outline: none;
    border-color: #3182ce;
}

.btn-submit {
    width: 100%;
    padding: 14px;
    background: #3182ce;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s ease;
}

.btn-submit:hover {
    background: #2c5282;
}

.form-message {
    margin-top: 15px;
    padding: 10px;
    border-radius: 6px;
    display: none;
}

.form-message.success {
    background: #c6f6d5;
    color: #276749;
    display: block;
}

.form-message.error {
    background: #fed7d7;
    color: #c53030;
    display: block;
}

@media (max-width: 768px) {
    .agent-profile {
        flex-direction: column;
        text-align: center;
    }
    
    .agent-contact {
        align-items: center;
    }
    
    .agent-social {
        justify-content: center;
    }
    
    .agent-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    $('#agentContactForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: formData + '&action=cps_save_lead',
            beforeSend: function() {
                $('.btn-submit').text('Sending...').prop('disabled', true);
            },
            success: function(response) {
                if (response.success) {
                    $('#formMessage').removeClass('error').addClass('success').text('Message sent successfully!');
                    $('#agentContactForm')[0].reset();
                } else {
                    $('#formMessage').removeClass('success').addClass('error').text('Failed to send message. Please try again.');
                }
            },
            error: function() {
                $('#formMessage').removeClass('success').addClass('error').text('An error occurred. Please try again.');
            },
            complete: function() {
                $('.btn-submit').text('Send Message').prop('disabled', false);
            }
        });
    });
});
</script>

<?php get_footer(); ?>
