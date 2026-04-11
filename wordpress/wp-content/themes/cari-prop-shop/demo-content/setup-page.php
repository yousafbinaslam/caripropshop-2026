<?php
/**
 * CariPropShop Demo Content Setup Page
 * Admin page to generate demo content
 */

if (!defined('ABSPATH')) {
    exit;
}

class CPS_Demo_Content_Page {
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_post_cps_generate_demo_content', array($this, 'handle_generate_content'));
    }
    
    public function add_admin_menu() {
        add_theme_page(
            __('Demo Content', 'cari-prop-shop'),
            __('Demo Content', 'cari-prop-shop'),
            'manage_options',
            'cps-demo-content',
            array($this, 'render_page')
        );
    }
    
    public function render_page() {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        ?>
        <div class="wrap cps-admin-header">
            <h1><?php _e('CariPropShop Demo Content', 'cari-prop-shop'); ?></h1>
            <p><?php _e('Generate sample data to test your real estate website.', 'cari-prop-shop'); ?></p>
        </div>
        
        <div class="wrap cps-demo-content-page">
            <div class="cps-demo-info">
                <h2><?php _e('What will be created:', 'cari-prop-shop'); ?></h2>
                <ul>
                    <li><strong>3 Agents</strong> - Sample agent profiles with contact info</li>
                    <li><strong>2 Agencies</strong> - Sample agency listings</li>
                    <li><strong>10 Properties</strong> - Various property types (houses, apartments, villas, land, commercial)</li>
                    <li><strong>5 Neighborhoods</strong> - Popular areas in Jakarta and Bali</li>
                    <li><strong>3 Developers</strong> - Real estate developers</li>
                    <li><strong>4 Testimonials</strong> - Customer reviews</li>
                    <li><strong>5 Blog Posts</strong> - Sample articles</li>
                    <li><strong>Taxonomies</strong> - Property types, statuses, and cities</li>
                </ul>
                
                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <?php wp_nonce_field('cps_generate_demo_content', 'cps_demo_nonce'); ?>
                    <input type="hidden" name="action" value="cps_generate_demo_content">
                    
                    <p class="submit">
                        <input type="submit" class="button button-primary button-large" value="<?php esc_attr_e('Generate Demo Content', 'cari-prop-shop'); ?>">
                    </p>
                </form>
            </div>
            
            <div class="cps-demo-actions">
                <h2><?php _e('After Generation:', 'cari-prop-shop'); ?></h2>
                <ol>
                    <li>Go to <a href="<?php echo esc_url(admin_url('edit.php?post_type=property')); ?>">Properties</a> to see sample listings</li>
                    <li>Go to <a href="<?php echo esc_url(admin_url('edit.php?post_type=agent')); ?>">Agents</a> to see agent profiles</li>
                    <li>Go to <a href="<?php echo esc_url(admin_url('edit.php?post_type=testimonial')); ?>">Testimonials</a> to see reviews</li>
                    <li>Check <a href="<?php echo esc_url(home_url('/')); ?>">your homepage</a> to see the layout</li>
                </ol>
            </div>
        </div>
        
        <style>
            .cps-demo-content-page {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
                margin-top: 20px;
            }
            .cps-demo-info, .cps-demo-actions {
                background: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            }
            .cps-demo-info h2, .cps-demo-actions h2 {
                margin-top: 0;
            }
            .cps-demo-info ul {
                list-style: disc;
                padding-left: 20px;
            }
            .cps-demo-info li {
                margin-bottom: 8px;
            }
            .cps-demo-actions ol {
                padding-left: 20px;
            }
            .cps-demo-actions li {
                margin-bottom: 8px;
            }
        </style>
        <?php
    }
    
    public function handle_generate_content() {
        if (!current_user_can('manage_options')) {
            wp_die(__('Unauthorized', 'cari-prop-shop'));
        }
        
        check_admin_referer('cps_generate_demo_content', 'cps_demo_nonce');
        
        require_once get_template_directory() . '/demo-content/demo-content.php';
        $result = cps_run_demo_content_generator();
        
        if ($result['success']) {
            wp_redirect(admin_url('admin.php?page=cps-demo-content&message=success'));
        } else {
            wp_redirect(admin_url('admin.php?page=cps-demo-content&message=error'));
        }
        exit;
    }
}

new CPS_Demo_Content_Page();
