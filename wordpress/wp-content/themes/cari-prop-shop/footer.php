<?php
/**
 * The template for displaying the footer - CariPropShop
 */
?>

    </main><!-- #main -->
</div><!-- .site-content-wrap -->

<footer id="footer" class="site-footer">
    <div class="footer-wrap">
        <div class="container">
            <div class="footer-top">
                <div class="footer-grid">
                    <div class="footer-col footer-about">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo">
                            <img src="<?php echo get_template_directory_uri(); ?>/logo.png" alt="<?php bloginfo('name'); ?>">
                        </a>
                        <p><?php esc_html_e('Your trusted partner in finding the perfect property in Indonesia. We specialize in residential and commercial real estate with a commitment to excellence.', 'cari-prop-shop'); ?></p>
                        <div class="footer-social">
                            <a href="#" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="#" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" target="_blank" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                    
                    <div class="footer-col">
                        <h4><?php esc_html_e('Quick Links', 'cari-prop-shop'); ?></h4>
                        <ul class="footer-menu">
                            <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'cari-prop-shop'); ?></a></li>
                            <li><a href="<?php echo esc_url(get_post_type_archive_link('property')); ?>"><?php esc_html_e('Properties', 'cari-prop-shop'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/services/')); ?>"><?php esc_html_e('Services', 'cari-prop-shop'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/about/')); ?>"><?php esc_html_e('About Us', 'cari-prop-shop'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Contact', 'cari-prop-shop'); ?></a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-col">
                        <h4><?php esc_html_e('Property Types', 'cari-prop-shop'); ?></h4>
                        <ul class="footer-menu">
                            <li><a href="<?php echo esc_url(add_query_arg(array('type' => 'apartment'), get_post_type_archive_link('property'))); ?>"><?php esc_html_e('Apartments', 'cari-prop-shop'); ?></a></li>
                            <li><a href="<?php echo esc_url(add_query_arg(array('type' => 'house'), get_post_type_archive_link('property'))); ?>"><?php esc_html_e('Houses', 'cari-prop-shop'); ?></a></li>
                            <li><a href="<?php echo esc_url(add_query_arg(array('type' => 'villa'), get_post_type_archive_link('property'))); ?>"><?php esc_html_e('Villas', 'cari-prop-shop'); ?></a></li>
                            <li><a href="<?php echo esc_url(add_query_arg(array('type' => 'land'), get_post_type_archive_link('property'))); ?>"><?php esc_html_e('Land', 'cari-prop-shop'); ?></a></li>
                            <li><a href="<?php echo esc_url(add_query_arg(array('type' => 'commercial'), get_post_type_archive_link('property'))); ?>"><?php esc_html_e('Commercial', 'cari-prop-shop'); ?></a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-col">
                        <h4><?php esc_html_e('Request Callback', 'cari-prop-shop'); ?></h4>
                        <p class="callback-intro"><?php esc_html_e('Leave your number and we\'ll call you back!', 'cari-prop-shop'); ?></p>
                        <form class="callback-form" id="callback-form">
                            <input type="text" name="name" placeholder="<?php esc_attr_e('Your Name', 'cari-prop-shop'); ?>" required>
                            <input type="tel" name="phone" placeholder="<?php esc_attr_e('Phone Number', 'cari-prop-shop'); ?>" required>
                            <select name="topic" required>
                                <option value=""><?php esc_html_e('Select Topic', 'cari-prop-shop'); ?></option>
                                <option value="buying"><?php esc_html_e('Buying a Property', 'cari-prop-shop'); ?></option>
                                <option value="selling"><?php esc_html_e('Selling a Property', 'cari-prop-shop'); ?></option>
                                <option value="renting"><?php esc_html_e('Renting', 'cari-prop-shop'); ?></option>
                                <option value="other"><?php esc_html_e('Other', 'cari-prop-shop'); ?></option>
                            </select>
                            <button type="submit" class="btn-callback">
                                <i class="fas fa-phone-alt"></i>
                                <?php esc_html_e('Request Callback', 'cari-prop-shop'); ?>
                            </button>
                        </form>
                        <div class="callback-message" id="callback-message"></div>
                    </div>
                </div>
            </div>
            
            <div class="footer-middle">
                <div class="footer-contact-info">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><?php esc_html_e('Jl. Sudirman No. 123, Jakarta Selatan 12190', 'cari-prop-shop'); ?></span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <a href="tel:+622112345678">+62 21 1234 5678</a>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:info@caripropshop.com">info@caripropshop.com</a>
                    </div>
                    <div class="contact-item">
                        <i class="fab fa-whatsapp"></i>
                        <a href="https://wa.me/628123456789" target="_blank">+62 812 3456 7890</a>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="footer-bottom-content">
                    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('All rights reserved.', 'cari-prop-shop'); ?></p>
                    <div class="footer-bottom-links">
                        <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>"><?php esc_html_e('Privacy Policy', 'cari-prop-shop'); ?></a>
                        <a href="<?php echo esc_url(home_url('/terms/')); ?>"><?php esc_html_e('Terms of Service', 'cari-prop-shop'); ?></a>
                        <a href="<?php echo esc_url(home_url('/sitemap/')); ?>"><?php esc_html_e('Sitemap', 'cari-prop-shop'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<button class="back-to-top" id="back-to-top" aria-label="Back to top">
    <i class="fas fa-chevron-up"></i>
</button>

<div class="compare-bar" id="compare-bar">
    <div class="compare-bar-inner">
        <div class="compare-label">
            <i class="fas fa-balance-scale"></i>
            <span><?php esc_html_e('Compare', 'cari-prop-shop'); ?>: <span class="compare-count">0</span></span>
        </div>
        <div class="compare-items"></div>
        <div class="compare-actions">
            <button class="btn-clear-compare"><?php esc_html_e('Clear', 'cari-prop-shop'); ?></button>
            <a href="<?php echo esc_url(home_url('/compare/')); ?>" class="btn-compare"><?php esc_html_e('Compare', 'cari-prop-shop'); ?></a>
        </div>
    </div>
</div>

</div><!-- #page -->

<?php wp_footer(); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.querySelector('.mobile-menu-toggle');
    const mobileNav = document.querySelector('.mobile-navigation');
    
    if (mobileToggle && mobileNav) {
        mobileToggle.addEventListener('click', function() {
            mobileNav.classList.toggle('active');
            this.classList.toggle('active');
        });
    }
    
    const backToTop = document.getElementById('back-to-top');
    if (backToTop) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });
        
        backToTop.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
    
    const callbackForm = document.getElementById('callback-form');
    const callbackMessage = document.getElementById('callback-message');
    
    if (callbackForm) {
        callbackForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(callbackForm);
            formData.append('action', 'cps_request_callback');
            formData.append('nonce', cpsData.nonce);
            
            const submitBtn = callbackForm.querySelector('.btn-callback');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            
            fetch(cpsData.ajaxUrl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    callbackMessage.className = 'callback-message success';
                    callbackMessage.textContent = data.data.message;
                    callbackForm.reset();
                } else {
                    callbackMessage.className = 'callback-message error';
                    callbackMessage.textContent = data.data || 'Error';
                }
            })
            .catch(error => {
                callbackMessage.className = 'callback-message error';
                callbackMessage.textContent = 'Network error. Please try again.';
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-phone-alt"></i> Request Callback';
            });
        });
    }
    
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('<?php echo get_template_directory_uri(); ?>/sw.js')
                .then(function(registration) {
                    console.log('ServiceWorker registered');
                })
                .catch(function(error) {
                    console.log('ServiceWorker registration failed:', error);
                });
        });
    }
});
</script>

</body>
</html>
