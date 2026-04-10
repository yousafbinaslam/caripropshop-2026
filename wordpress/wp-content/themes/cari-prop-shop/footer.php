<?php
/**
 * The template for displaying the footer
 */
?>

        </div><!-- .container -->
    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-about">
                    <h3>CariPropShop</h3>
                    <p>Your trusted partner in finding the perfect property. We specialize in residential and commercial real estate, providing exceptional service to buyers, sellers, and investors across the region.</p>
                </div>
                
                <div class="footer-links">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                        <li><a href="<?php echo esc_url(home_url('/properties')); ?>">Properties</a></li>
                        <li><a href="<?php echo esc_url(home_url('/about')); ?>">About Us</a></li>
                        <li><a href="<?php echo esc_url(home_url('/contact')); ?>">Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-links">
                    <h4>Property Types</h4>
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/properties')); ?>">For Sale</a></li>
                        <li><a href="<?php echo esc_url(home_url('/properties')); ?>">For Rent</a></li>
                        <li><a href="<?php echo esc_url(home_url('/properties')); ?>">New Listings</a></li>
                        <li><a href="<?php echo esc_url(home_url('/properties')); ?>">Featured</a></li>
                    </ul>
                </div>
                
                <div class="footer-contact">
                    <h4>Contact Us</h4>
                    <p><i class="fas fa-map-marker-alt"></i> 123 Real Estate Ave</p>
                    <p><i class="fas fa-phone"></i> (555) 123-4567</p>
                    <p><i class="fas fa-envelope"></i> info@caripropshop.com</p>
                    <p><i class="fas fa-clock"></i> Mon-Fri: 9AM-6PM</p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved. | Powered by WordPress</p>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
