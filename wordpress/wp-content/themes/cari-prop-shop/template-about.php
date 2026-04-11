<?php
/**
 * Template Name: About Us - CariPropShop
 */

get_header();

$stats = array(
    array('value' => '10+', 'label' => 'Years Experience'),
    array('value' => '500+', 'label' => 'Properties Sold'),
    array('value' => '1000+', 'label' => 'Happy Clients'),
    array('value' => '50+', 'label' => 'Expert Agents'),
);

$team_members = array(
    array(
        'name' => 'Ahmad Wijaya',
        'role' => 'Chief Executive Officer',
        'image' => 'https://randomuser.me/api/portraits/men/32.jpg',
        'bio' => 'Over 15 years of experience in Indonesian real estate market'
    ),
    array(
        'name' => 'Sarah Indonesia',
        'role' => 'Head of Operations',
        'image' => 'https://randomuser.me/api/portraits/women/44.jpg',
        'bio' => 'Expert in property management and client relations'
    ),
    array(
        'name' => 'Budi Santoso',
        'role' => 'Senior Property Consultant',
        'image' => 'https://randomuser.me/api/portraits/men/75.jpg',
        'bio' => 'Specialized in luxury properties and investments'
    ),
    array(
        'name' => 'Dewi Lestari',
        'role' => 'Marketing Director',
        'image' => 'https://randomuser.me/api/portraits/women/65.jpg',
        'bio' => 'Digital marketing expert with real estate focus'
    ),
);

$values = array(
    array(
        'icon' => 'fas fa-handshake',
        'title' => 'Integrity',
        'description' => 'We believe in transparent dealings and honest communication with all our clients.'
    ),
    array(
        'icon' => 'fas fa-star',
        'title' => 'Excellence',
        'description' => 'We strive for excellence in every transaction and service we provide.'
    ),
    array(
        'icon' => 'fas fa-users',
        'title' => 'Client Focus',
        'description' => 'Your satisfaction is our priority. We tailor our services to meet your needs.'
    ),
    array(
        'icon' => 'fas fa-chart-line',
        'title' => 'Innovation',
        'description' => 'We continuously improve our services using the latest technology and trends.'
    ),
);
?>

<div class="about-page">
    <section class="about-hero">
        <div class="container">
            <div class="hero-content">
                <h1><?php esc_html_e('About CariPropShop', 'cari-prop-shop'); ?></h1>
                <p><?php esc_html_e('Your trusted partner in finding the perfect property in Indonesia', 'cari-prop-shop'); ?></p>
            </div>
        </div>
    </section>

    <section class="about-intro">
        <div class="container">
            <div class="intro-layout">
                <div class="intro-content">
                    <span class="section-label"><?php esc_html_e('Who We Are', 'cari-prop-shop'); ?></span>
                    <h2><?php esc_html_e('Indonesia\'s Premier Real Estate Platform', 'cari-prop-shop'); ?></h2>
                    <p><?php esc_html_e('CariPropShop is a leading real estate company dedicated to helping individuals and businesses find their perfect property in Indonesia. Founded in 2014, we have grown to become one of the most trusted names in the Indonesian property market.', 'cari-prop-shop'); ?></p>
                    <p><?php esc_html_e('Our platform combines extensive local market knowledge with cutting-edge technology to provide a seamless property search experience. Whether you\'re looking to buy, sell, rent, or invest in property, our team of experienced professionals is here to guide you every step of the way.', 'cari-prop-shop'); ?></p>
                    <div class="intro-features">
                        <div class="intro-feature">
                            <i class="fas fa-check-circle"></i>
                            <span><?php esc_html_e('Licensed & Verified Agents', 'cari-prop-shop'); ?></span>
                        </div>
                        <div class="intro-feature">
                            <i class="fas fa-check-circle"></i>
                            <span><?php esc_html_e('Transparent Pricing', 'cari-prop-shop'); ?></span>
                        </div>
                        <div class="intro-feature">
                            <i class="fas fa-check-circle"></i>
                            <span><?php esc_html_e('Full-Service Support', 'cari-prop-shop'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="intro-image">
                    <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=600&h=400&fit=crop" alt="<?php esc_attr_e('Modern Office', 'cari-prop-shop'); ?>">
                </div>
            </div>
        </div>
    </section>

    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <?php foreach ($stats as $stat) : ?>
                    <div class="stat-item">
                        <div class="stat-value"><?php echo esc_html($stat['value']); ?></div>
                        <div class="stat-label"><?php echo esc_html($stat['label']); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="mission-section">
        <div class="container">
            <div class="mission-layout">
                <div class="mission-content">
                    <h2><?php esc_html_e('Our Mission', 'cari-prop-shop'); ?></h2>
                    <p><?php esc_html_e('To simplify the property search and transaction process in Indonesia by providing a comprehensive, user-friendly platform that connects buyers, sellers, and renters with verified properties and trusted professionals.', 'cari-prop-shop'); ?></p>
                    <div class="mission-points">
                        <div class="mission-point">
                            <i class="fas fa-building"></i>
                            <div>
                                <h4><?php esc_html_e('Diverse Property Portfolio', 'cari-prop-shop'); ?></h4>
                                <p><?php esc_html_e('From affordable apartments to luxury villas, we have properties for every budget and lifestyle.', 'cari-prop-shop'); ?></p>
                            </div>
                        </div>
                        <div class="mission-point">
                            <i class="fas fa-handshake-angle"></i>
                            <div>
                                <h4><?php esc_html_e('End-to-End Service', 'cari-prop-shop'); ?></h4>
                                <p><?php esc_html_e('We support you from property search to notary services, making your journey seamless.', 'cari-prop-shop'); ?></p>
                            </div>
                        </div>
                        <div class="mission-point">
                            <i class="fas fa-globe-asia"></i>
                            <div>
                                <h4><?php esc_html_e('Local Expertise', 'cari-prop-shop'); ?></h4>
                                <p><?php esc_html_e('Our deep understanding of Indonesian real estate ensures you make informed decisions.', 'cari-prop-shop'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mission-image">
                    <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=600&h=500&fit=crop" alt="<?php esc_attr_e('Jakarta Skyline', 'cari-prop-shop'); ?>">
                </div>
            </div>
        </div>
    </section>

    <section class="values-section">
        <div class="container">
            <div class="section-header">
                <span class="section-label"><?php esc_html_e('Our Values', 'cari-prop-shop'); ?></span>
                <h2><?php esc_html_e('What Drives Us', 'cari-prop-shop'); ?></h2>
            </div>
            <div class="values-grid">
                <?php foreach ($values as $value) : ?>
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="<?php echo esc_attr($value['icon']); ?>"></i>
                        </div>
                        <h3><?php echo esc_html($value['title']); ?></h3>
                        <p><?php echo esc_html($value['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="team-section">
        <div class="container">
            <div class="section-header">
                <span class="section-label"><?php esc_html_e('Our Team', 'cari-prop-shop'); ?></span>
                <h2><?php esc_html_e('Meet the Experts', 'cari-prop-shop'); ?></h2>
                <p><?php esc_html_e('Our dedicated team of real estate professionals is committed to helping you find your dream property.', 'cari-prop-shop'); ?></p>
            </div>
            <div class="team-grid">
                <?php foreach ($team_members as $member) : ?>
                    <div class="team-card">
                        <div class="team-image">
                            <img src="<?php echo esc_url($member['image']); ?>" alt="<?php echo esc_attr($member['name']); ?>">
                            <div class="team-social">
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                        <div class="team-info">
                            <h3><?php echo esc_html($member['name']); ?></h3>
                            <span class="team-role"><?php echo esc_html($member['role']); ?></span>
                            <p><?php echo esc_html($member['bio']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="timeline-section">
        <div class="container">
            <div class="section-header">
                <span class="section-label"><?php esc_html_e('Our Journey', 'cari-prop-shop'); ?></span>
                <h2><?php esc_html_e('Company Timeline', 'cari-prop-shop'); ?></h2>
            </div>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-year">2014</div>
                    <div class="timeline-content">
                        <h3><?php esc_html_e('Company Founded', 'cari-prop-shop'); ?></h3>
                        <p><?php esc_html_e('CariPropShop established in Jakarta with a vision to modernize property transactions in Indonesia.', 'cari-prop-shop'); ?></p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-year">2016</div>
                    <div class="timeline-content">
                        <h3><?php esc_html_e('First 100 Properties', 'cari-prop-shop'); ?></h3>
                        <p><?php esc_html_e('Reached milestone of 100 successful property transactions and expanded our agent network.', 'cari-prop-shop'); ?></p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-year">2018</div>
                    <div class="timeline-content">
                        <h3><?php esc_html_e('Digital Transformation', 'cari-prop-shop'); ?></h3>
                        <p><?php esc_html_e('Launched our online platform with virtual tours and advanced property search features.', 'cari-prop-shop'); ?></p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-year">2020</div>
                    <div class="timeline-content">
                        <h3><?php esc_html_e('Expansion to Bali', 'cari-prop-shop'); ?></h3>
                        <p><?php esc_html_e('Opened our second office in Bali to serve the growing tourism property market.', 'cari-prop-shop'); ?></p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-year">2024</div>
                    <div class="timeline-content">
                        <h3><?php esc_html_e('500+ Properties Sold', 'cari-prop-shop'); ?></h3>
                        <p><?php esc_html_e('Celebrated milestone of 500+ successful transactions across Indonesia.', 'cari-prop-shop'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="partners-section">
        <div class="container">
            <div class="section-header">
                <h2><?php esc_html_e('Our Partners', 'cari-prop-shop'); ?></h2>
                <p><?php esc_html_e('We work with trusted financial and service institutions to provide you with comprehensive property solutions.', 'cari-prop-shop'); ?></p>
            </div>
            <div class="partners-grid">
                <div class="partner-logo"><i class="fas fa-university"></i><span>Bank BCA</span></div>
                <div class="partner-logo"><i class="fas fa-university"></i><span>Bank Mandiri</span></div>
                <div class="partner-logo"><i class="fas fa-university"></i><span>Bank BNI</span></div>
                <div class="partner-logo"><i class="fas fa-university"></i><span>BTN</span></div>
                <div class="partner-logo"><i class="fas fa-building"></i><span>Notaris协会</span></div>
                <div class="partner-logo"><i class="fas fa-shield-alt"></i><span>Allianz</span></div>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2><?php esc_html_e('Ready to Find Your Dream Property?', 'cari-prop-shop'); ?></h2>
                <p><?php esc_html_e('Join thousands of satisfied clients who found their perfect property with CariPropShop.', 'cari-prop-shop'); ?></p>
                <div class="cta-buttons">
                    <a href="<?php echo esc_url(get_post_type_archive_link('property')); ?>" class="cta-btn primary">
                        <i class="fas fa-search"></i>
                        <?php esc_html_e('Browse Properties', 'cari-prop-shop'); ?>
                    </a>
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="cta-btn secondary">
                        <i class="fas fa-phone"></i>
                        <?php esc_html_e('Contact Us', 'cari-prop-shop'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<?php get_footer(); ?>
