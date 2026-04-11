<?php
/**
 * Template Name: Services
 */

get_header();
?>

<div class="services-page">
    <div class="services-hero">
        <div class="container">
            <h1>Our Services</h1>
            <p>Professional real estate services to help you buy, sell, and manage properties in Indonesia</p>
        </div>
    </div>

    <section class="services-section">
        <div class="container">
            <div class="services-grid">
                
                <!-- Notary Services -->
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <h2>Notary Services</h2>
                    <p>Professional notary services for all your property documentation needs in Indonesia.</p>
                    
                    <div class="service-features">
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <div>
                                <h4>Property Deed Processing</h4>
                                <p>Complete assistance with AJB (Akta Jual Beli) and SHM (Sertifikat Hak Milik) documentation</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <div>
                                <h4>Ownership Transfer (Shifting)</h4>
                                <p>Expert handling of property ownership transfer procedures</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <div>
                                <h4>Contract Authentication</h4>
                                <p>Notarization and authentication of all property-related contracts</p>
                            </div>
                        </div>
                    </div>
                    
                    <a href="#contact" class="btn-service">Get Started</a>
                </div>

                <!-- Interior Design -->
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-couch"></i>
                    </div>
                    <h2>Interior Design</h2>
                    <p>Transform your space with our professional interior design services tailored to Indonesian homes.</p>
                    
                    <div class="service-features">
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <div>
                                <h4>Space Planning</h4>
                                <p>Optimize your living spaces with expert layout planning and furniture placement</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <div>
                                <h4>Material Selection</h4>
                                <p>Guidance on selecting the best local and imported materials</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <div>
                                <h4>Custom Furniture</h4>
                                <p>Bespoke furniture design and procurement services</p>
                            </div>
                        </div>
                    </div>
                    
                    <a href="#contact" class="btn-service">Get Started</a>
                </div>

                <!-- Construction -->
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-hard-hat"></i>
                    </div>
                    <h2>Construction</h2>
                    <p>Build your dream property with our trusted construction partners across Indonesia.</p>
                    
                    <div class="service-features">
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <div>
                                <h4>New Building Construction</h4>
                                <p>Complete residential and commercial building construction services</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <div>
                                <h4>Renovation & Extension</h4>
                                <p>Transform existing properties with professional renovation</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <div>
                                <h4>Project Management</h4>
                                <p>End-to-end project oversight from planning to completion</p>
                            </div>
                        </div>
                    </div>
                    
                    <a href="#contact" class="btn-service">Get Started</a>
                </div>

                <!-- Legal Consultancy -->
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-gavel"></i>
                    </div>
                    <h2>Legal Consultancy</h2>
                    <p>Expert legal guidance for all your real estate transactions and property matters.</p>
                    
                    <div class="service-features">
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <div>
                                <h4>Due Diligence</h4>
                                <p>Comprehensive legal review of property documents and titles</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <div>
                                <h4>Contract Review</h4>
                                <p>Thorough examination of purchase agreements and contracts</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <div>
                                <h4>Regulatory Compliance</h4>
                                <p>Ensure compliance with Indonesian property regulations</p>
                            </div>
                        </div>
                    </div>
                    
                    <a href="#contact" class="btn-service">Get Started</a>
                </div>

            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="why-choose-us">
        <div class="container">
            <h2>Why Choose CariPropShop Services?</h2>
            <div class="benefits-grid">
                <div class="benefit-item">
                    <i class="fas fa-shield-alt"></i>
                    <h3>Trusted & Verified</h3>
                    <p>All our partners are vetted and verified for quality and reliability</p>
                </div>
                <div class="benefit-item">
                    <i class="fas fa-clock"></i>
                    <h3>Fast Processing</h3>
                    <p>Quick turnaround times for all documentation and services</p>
                </div>
                <div class="benefit-item">
                    <i class="fas fa-hand-holding-usd"></i>
                    <h3>Competitive Rates</h3>
                    <p>Transparent pricing with no hidden costs</p>
                </div>
                <div class="benefit-item">
                    <i class="fas fa-headset"></i>
                    <h3>Dedicated Support</h3>
                    <p>Personal assistance throughout the entire process</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact CTA -->
    <section class="contact-cta" id="contact">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to Get Started?</h2>
                <p>Contact us today to discuss your property needs. Our team is ready to help you with any of our services.</p>
                <div class="cta-buttons">
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-primary">Contact Us</a>
                    <a href="tel:+6281234567890" class="btn-secondary"><i class="fas fa-phone"></i> Call Now</a>
                </div>
            </div>
        </div>
    </section>

</div>

<style>
.services-page {
    background: #f8f9fa;
}

.services-hero {
    background: linear-gradient(135deg, #1a365d 0%, #2c5282 100%);
    color: white;
    padding: 80px 0;
    text-align: center;
}

.services-hero h1 {
    font-size: 48px;
    margin-bottom: 20px;
}

.services-hero p {
    font-size: 20px;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
}

.services-section {
    padding: 80px 0;
}

.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
}

.service-card {
    background: white;
    border-radius: 12px;
    padding: 40px;
    box-shadow: 0 5px 30px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.service-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.service-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #3182ce 0%, #2c5282 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 25px;
}

.service-icon i {
    font-size: 32px;
    color: white;
}

.service-card h2 {
    font-size: 24px;
    color: #1a365d;
    margin-bottom: 15px;
}

.service-card > p {
    color: #666;
    margin-bottom: 25px;
    line-height: 1.6;
}

.service-features {
    margin-bottom: 30px;
}

.feature-item {
    display: flex;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid #eee;
}

.feature-item:last-child {
    border-bottom: none;
}

.feature-item i {
    color: #48bb78;
    font-size: 20px;
    margin-top: 3px;
}

.feature-item h4 {
    font-size: 16px;
    color: #1a365d;
    margin-bottom: 5px;
}

.feature-item p {
    font-size: 14px;
    color: #666;
    margin: 0;
}

.btn-service {
    display: inline-block;
    padding: 12px 30px;
    background: #3182ce;
    color: white;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    transition: background 0.3s ease;
}

.btn-service:hover {
    background: #2c5282;
    color: white;
}

.why-choose-us {
    background: white;
    padding: 80px 0;
    text-align: center;
}

.why-choose-us h2 {
    font-size: 36px;
    color: #1a365d;
    margin-bottom: 50px;
}

.benefits-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 40px;
}

.benefit-item {
    padding: 30px;
}

.benefit-item i {
    font-size: 48px;
    color: #3182ce;
    margin-bottom: 20px;
}

.benefit-item h3 {
    font-size: 20px;
    color: #1a365d;
    margin-bottom: 10px;
}

.benefit-item p {
    color: #666;
    margin: 0;
}

.contact-cta {
    background: linear-gradient(135deg, #1a365d 0%, #2c5282 100%);
    padding: 80px 0;
    text-align: center;
    color: white;
}

.cta-content h2 {
    font-size: 36px;
    margin-bottom: 20px;
}

.cta-content p {
    font-size: 18px;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto 30px;
}

.cta-buttons {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-primary {
    display: inline-block;
    padding: 15px 40px;
    background: white;
    color: #1a365d;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    transition: transform 0.3s ease;
}

.btn-primary:hover {
    transform: scale(1.05);
    color: #1a365d;
}

.btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 40px;
    background: transparent;
    border: 2px solid white;
    color: white;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: white;
    color: #1a365d;
}

@media (max-width: 768px) {
    .services-hero h1 {
        font-size: 32px;
    }
    
    .services-hero p {
        font-size: 16px;
    }
    
    .service-card {
        padding: 30px;
    }
    
    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }
}
</style>

<?php get_footer(); ?>
