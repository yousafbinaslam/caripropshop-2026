<?php
/**
 * Template part for displaying agent cards
 */

$agent_id = $agent->ID ?? get_the_ID();
$name = get_the_title($agent_id);
$thumb_url = get_the_post_thumbnail_url($agent_id, 'agent-avatar');
$position = get_post_meta($agent_id, 'cps_agent_position', true);
$phone = get_post_meta($agent_id, 'cps_agent_phone', true);
$email = get_post_meta($agent_id, 'cps_agent_email', true);
$facebook = get_post_meta($agent_id, 'cps_agent_facebook', true);
$twitter = get_post_meta($agent_id, 'cps_agent_twitter', true);
$instagram = get_post_meta($agent_id, 'cps_agent_instagram', true);
$linkedin = get_post_meta($agent_id, 'cps_agent_linkedin', true);
$whatsapp = get_post_meta($agent_id, 'cps_agent_whatsapp', true);
$properties_count = count_user_posts($agent_id, 'property');
$permalink = get_permalink($agent_id);
?>

<div class="agent-card">
    <div class="agent-card-image">
        <?php if ($thumb_url) : ?>
            <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($name); ?>">
        <?php else : ?>
            <div class="agent-placeholder">
                <i class="fas fa-user"></i>
            </div>
        <?php endif; ?>
        
        <div class="agent-card-social">
            <?php if ($facebook) : ?>
                <a href="<?php echo esc_url($facebook); ?>" target="_blank" title="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
            <?php endif; ?>
            
            <?php if ($twitter) : ?>
                <a href="<?php echo esc_url($twitter); ?>" target="_blank" title="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
            <?php endif; ?>
            
            <?php if ($instagram) : ?>
                <a href="<?php echo esc_url($instagram); ?>" target="_blank" title="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
            <?php endif; ?>
            
            <?php if ($linkedin) : ?>
                <a href="<?php echo esc_url($linkedin); ?>" target="_blank" title="LinkedIn">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="agent-card-content">
        <h3 class="agent-card-name">
            <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($name); ?></a>
        </h3>
        
        <?php if ($position) : ?>
            <p class="agent-card-position"><?php echo esc_html($position); ?></p>
        <?php endif; ?>
        
        <div class="agent-card-stats">
            <span class="stat">
                <i class="fas fa-home"></i>
                <?php echo esc_html($properties_count); ?> <?php _e('Properties', 'cari-prop-shop'); ?>
            </span>
        </div>
        
        <div class="agent-card-contact">
            <?php if ($phone) : ?>
                <a href="tel:<?php echo esc_attr($phone); ?>" class="contact-item">
                    <i class="fas fa-phone"></i>
                    <?php echo esc_html($phone); ?>
                </a>
            <?php endif; ?>
            
            <?php if ($email) : ?>
                <a href="mailto:<?php echo esc_attr($email); ?>" class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <?php echo esc_html($email); ?>
                </a>
            <?php endif; ?>
            
            <?php if ($whatsapp) : ?>
                <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $whatsapp)); ?>" 
                   target="_blank" class="contact-item whatsapp">
                    <i class="fab fa-whatsapp"></i>
                    WhatsApp
                </a>
            <?php endif; ?>
        </div>
        
        <div class="agent-card-actions">
            <a href="<?php echo esc_url($permalink); ?>" class="btn btn-primary">
                <?php _e('View Profile', 'cari-prop-shop'); ?>
            </a>
            <a href="<?php echo esc_url($permalink); ?>?action=contact" class="btn btn-outline">
                <?php _e('Contact', 'cari-prop-shop'); ?>
            </a>
        </div>
    </div>
</div>
