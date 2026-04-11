<?php
if (!defined('ABSPATH')) {
    exit;
}

class CPS_SEO {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('wp_head', array($this, 'output_open_graph'), 1);
        add_action('wp_head', array($this, 'output_schema_markup'), 1);
        add_action('wp_head', array($this, 'output_twitter_cards'), 1);
        add_filter('language_attributes', array($this, 'add_open_graph_namespace'));
        add_action('wp_head', array($this, 'output_critical_css'), 1);
        add_filter('the_content', array($this, 'lazy_load_images'), 20);
        add_filter('post_thumbnail_html', array($this, 'add_lazy_loading'), 10, 5);
        add_filter('wp_get_attachment_image_attributes', array($this, 'defer_offscreen_images'), 20, 3);
    }

    public function add_open_graph_namespace($output) {
        $output .= ' xmlns:og="http://ogp.me/ns#"';
        $output .= ' xmlns:fb="http://ogp.me/ns/fb#"';
        return $output;
    }

    public function output_open_graph() {
        global $post;

        $og_type = 'website';
        $og_title = get_bloginfo('name');
        $og_description = get_bloginfo('description');
        $og_url = home_url();
        $og_image = '';

        if (is_singular('property')) {
            $og_type = 'article';
            $og_title = get_the_title() . ' | ' . get_bloginfo('name');
            $og_description = wp_trim_words(get_the_excerpt(), 30);
            $og_url = get_permalink();
            $og_image = get_the_post_thumbnail_url(get_the_ID(), 'large');

            $price = get_post_meta(get_the_ID(), 'property_price', true);
            $property_status = get_the_terms(get_the_ID(), 'property_status');
            $status_name = $property_status && !is_wp_error($property_status) ? $property_status[0]->name : '';

            if ($price) {
                $og_description .= ' - Price: ' . $price;
            }
            if ($status_name) {
                $og_description .= ' - ' . $status_name;
            }
        } elseif (is_singular('agent')) {
            $og_type = 'profile';
            $og_title = get_the_title() . ' | ' . get_bloginfo('name');
            $og_url = get_permalink();
            $og_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
        } elseif (is_singular()) {
            $og_type = 'article';
            $og_title = get_the_title() . ' | ' . get_bloginfo('name');
            $og_description = wp_trim_words(get_the_excerpt(), 30);
            $og_url = get_permalink();
            $og_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
        } elseif (is_home() || is_front_page()) {
            $og_title = get_bloginfo('name');
            $og_description = get_bloginfo('description');
        }

        if (!$og_image) {
            $og_image = get_theme_mod('cps_default_og_image', '');
        }
        if (!$og_image) {
            $og_image = get_template_directory_uri() . '/assets/images/default-og.jpg';
        }

        $og_image_meta = wp_get_attachment_image_src($this->get_image_attachment_id($og_image), 'large');
        if ($og_image_meta) {
            $og_image = $og_image_meta[0];
        }

        $site_name = get_bloginfo('name');
        $locale = get_locale();
        $fb_app_id = get_option('cps_fb_app_id', '');

        $article_published_time = '';
        $article_modified_time = '';
        $article_author = '';
        $article_section = '';

        if (is_singular()) {
            $article_published_time = get_the_date('c');
            $article_modified_time = get_the_modified_date('c');
            $article_author = get_the_author_meta('display_name');
            $categories = get_the_category();
            if ($categories) {
                $article_section = $categories[0]->name;
            }
        }
        ?>
        <meta property="og:type" content="<?php echo esc_attr($og_type); ?>">
        <meta property="og:site_name" content="<?php echo esc_attr($site_name); ?>">
        <meta property="og:title" content="<?php echo esc_attr($og_title); ?>">
        <meta property="og:description" content="<?php echo esc_attr($og_description); ?>">
        <meta property="og:url" content="<?php echo esc_url($og_url); ?>">
        <meta property="og:image" content="<?php echo esc_url($og_image); ?>">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:locale" content="<?php echo esc_attr($locale); ?>">

        <?php if ($fb_app_id) : ?>
        <meta property="fb:app_id" content="<?php echo esc_attr($fb_app_id); ?>">
        <?php endif; ?>

        <?php if ($og_type === 'article' && $article_published_time) : ?>
        <meta property="article:published_time" content="<?php echo esc_attr($article_published_time); ?>">
        <meta property="article:modified_time" content="<?php echo esc_attr($article_modified_time); ?>">
        <?php if ($article_author) : ?>
        <meta property="article:author" content="<?php echo esc_attr($article_author); ?>">
        <?php endif; ?>
        <?php if ($article_section) : ?>
        <meta property="article:section" content="<?php echo esc_attr($article_section); ?>">
        <?php endif; ?>
        <?php endif; ?>

        <?php if ($og_type === 'profile') : ?>
        <meta property="profile:first_name" content="<?php echo esc_attr(get_the_title()); ?>">
        <?php endif; ?>
        <?php
    }

    public function output_twitter_cards() {
        global $post;

        $card_type = 'summary_large_image';
        $tc_title = get_bloginfo('name');
        $tc_description = get_bloginfo('description');
        $tc_image = '';
        $tc_site = '@caripropshop';
        $tc_creator = '';

        if (is_singular('property')) {
            $tc_title = get_the_title();
            $tc_description = wp_trim_words(get_the_excerpt(), 30);
            $tc_image = get_the_post_thumbnail_url(get_the_ID(), 'large');

            $agent_id = get_post_meta(get_the_ID(), 'cps_property_agent', true);
            if ($agent_id) {
                $agent = get_post($agent_id);
                if ($agent) {
                    $tc_creator = get_post_meta($agent_id, 'cps_agent_twitter', true);
                }
            }
        } elseif (is_singular()) {
            $tc_title = get_the_title();
            $tc_description = wp_trim_words(get_the_excerpt(), 30);
            $tc_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
        }

        if (!$tc_image) {
            $tc_image = get_template_directory_uri() . '/assets/images/default-og.jpg';
        }
        ?>
        <meta name="twitter:card" content="<?php echo esc_attr($card_type); ?>">
        <meta name="twitter:site" content="<?php echo esc_attr($tc_site); ?>">
        <meta name="twitter:title" content="<?php echo esc_attr($tc_title); ?>">
        <meta name="twitter:description" content="<?php echo esc_attr($tc_description); ?>">
        <meta name="twitter:image" content="<?php echo esc_url($tc_image); ?>">
        <?php if ($tc_creator) : ?>
        <meta name="twitter:creator" content="<?php echo esc_attr($tc_creator); ?>">
        <?php endif; ?>
        <?php
    }

    public function output_schema_markup() {
        if (!is_singular('property')) {
            $this->output_organization_schema();
            return;
        }

        global $post;
        $property_id = get_the_ID();

        $price = get_post_meta($property_id, 'property_price', true);
        $price_label = get_post_meta($property_id, 'property_price_label', true);
        $address = get_post_meta($property_id, 'property_address', true);
        $city = get_post_meta($property_id, 'property_city', true);
        $state = get_post_meta($property_id, 'property_state', true);
        $zip = get_post_meta($property_id, 'property_zip', true);
        $country = get_post_meta($property_id, 'property_country', true) ?: 'Indonesia';
        $latitude = get_post_meta($property_id, 'property_latitude', true);
        $longitude = get_post_meta($property_id, 'property_longitude', true);
        $bedrooms = get_post_meta($property_id, 'property_bedrooms', true);
        $bathrooms = get_post_meta($property_id, 'property_bathrooms', true);
        $sqft = get_post_meta($property_id, 'property_sqft', true);
        $year = get_post_meta($property_id, 'property_year', true);
        $property_type_terms = get_the_terms($property_id, 'property_type');
        $property_type = $property_type_terms && !is_wp_error($property_type_terms) ? $property_type_terms[0]->name : '';
        $property_status_terms = get_the_terms($property_id, 'property_status');
        $property_status = $property_status_terms && !is_wp_error($property_status_terms) ? $property_status_terms[0]->name : '';

        $property_schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'RealEstateListing',
            'name' => get_the_title(),
            'description' => wp_strip_all_tags(get_the_excerpt()),
            'url' => get_permalink(),
            'image' => get_the_post_thumbnail_url($property_id, 'large'),
            'datePosted' => get_the_date('c'),
            'lastReviewed' => get_the_modified_date('c'),
        );

        if ($price) {
            $property_schema['offers'] = array(
                '@type' => 'Offer',
                'price' => preg_replace('/[^0-9.]/', '', $price),
                'priceCurrency' => 'IDR',
                'availability' => $property_status === 'Sold' ? 'https://schema.org/SoldOut' : 'https://schema.org/InStock',
            );
            if ($price_label) {
                $property_schema['offers']['description'] = $price_label;
            }
        }

        if ($address || $city) {
            $property_schema['address'] = array(
                '@type' => 'PostalAddress',
            );
            if ($address) $property_schema['address']['streetAddress'] = $address;
            if ($city) $property_schema['address']['addressLocality'] = $city;
            if ($state) $property_schema['address']['addressRegion'] = $state;
            if ($zip) $property_schema['address']['postalCode'] = $zip;
            $property_schema['address']['addressCountry'] = $country;
        }

        if ($latitude && $longitude) {
            $property_schema['geo'] = array(
                '@type' => 'GeoCoordinates',
                'latitude' => floatval($latitude),
                'longitude' => floatval($longitude),
            );
        }

        $property_schema['numberOfRooms'] = array(
            '@type' => 'PropertyValue',
            'value' => $bedrooms ?: 0,
        );

        if ($sqft) {
            $property_schema['floorSize'] = array(
                '@type' => 'QuantitativeValue',
                'value' => intval($sqft),
                'unitCode' => 'MTK',
            );
        }

        if ($property_type) {
            $property_schema['additionalProperty'] = array(
                '@type' => 'PropertyValue',
                'name' => 'Property Type',
                'value' => $property_type,
            );
        }

        $agent_id = get_post_meta($property_id, 'cps_property_agent', true);
        if ($agent_id) {
            $agent_name = get_the_title($agent_id);
            $agent_phone = get_post_meta($agent_id, 'cps_agent_phone', true);
            $agent_email = get_post_meta($agent_id, 'cps_agent_email', true);

            $property_schema['seller'] = array(
                '@type' => 'RealEstateAgent',
                'name' => $agent_name,
                'url' => get_permalink($agent_id),
            );

            if ($agent_phone) {
                $property_schema['seller']['telephone'] = $agent_phone;
            }
            if ($agent_email) {
                $property_schema['seller']['email'] = $agent_email;
            }
        }

        $image_urls = array();
        if (has_post_thumbnail()) {
            $image_urls[] = get_the_post_thumbnail_url($property_id, 'large');
        }

        $gallery_images = get_post_meta($property_id, 'cps_property_images', true);
        if ($gallery_images && is_array($gallery_images)) {
            foreach ($gallery_images as $img_id) {
                $img_url = wp_get_attachment_image_url($img_id, 'large');
                if ($img_url) {
                    $image_urls[] = $img_url;
                }
            }
        }

        if (!empty($image_urls)) {
            $property_schema['photo'] = array_map(function($url) {
                return array('@type' => 'ImageObject', 'url' => $url);
            }, $image_urls);
        }

        echo '<script type="application/ld+json">' . wp_json_encode($property_schema) . '</script>' . "\n";

        $this->output_breadcrumb_schema();
    }

    private function output_breadcrumb_schema() {
        $breadcrumbs = array();
        $position = 1;

        $breadcrumbs[] = array(
            '@type' => 'ListItem',
            'position' => $position,
            'name' => 'Home',
            'item' => home_url('/'),
        );
        $position++;

        if (is_singular('property')) {
            $breadcrumbs[] = array(
                '@type' => 'ListItem',
                'position' => $position,
                'name' => 'Properties',
                'item' => home_url('/properties/'),
            );
            $position++;
            $breadcrumbs[] = array(
                '@type' => 'ListItem',
                'position' => $position,
                'name' => get_the_title(),
                'item' => get_permalink(),
            );
        } elseif (is_singular('post')) {
            $categories = get_the_category();
            if ($categories) {
                $breadcrumbs[] = array(
                    '@type' => 'ListItem',
                    'position' => $position,
                    'name' => $categories[0]->name,
                    'item' => get_category_link($categories[0]->term_id),
                );
                $position++;
            }
            $breadcrumbs[] = array(
                '@type' => 'ListItem',
                'position' => $position,
                'name' => get_the_title(),
                'item' => get_permalink(),
            );
        } elseif (is_post_type_archive('property')) {
            $breadcrumbs[] = array(
                '@type' => 'ListItem',
                'position' => $position,
                'name' => 'Properties',
                'item' => get_post_type_archive_link('property'),
            );
        } elseif (is_archive()) {
            $breadcrumbs[] = array(
                '@type' => 'ListItem',
                'position' => $position,
                'name' => get_the_archive_title(),
                'item' => get_permalink(),
            );
        }

        if (count($breadcrumbs) > 1) {
            $schema = array(
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => $breadcrumbs,
            );
            echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>' . "\n";
        }
    }

    private function output_organization_schema() {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'RealEstateAgent',
            'name' => get_bloginfo('name'),
            'description' => get_bloginfo('description'),
            'url' => home_url('/'),
            'logo' => get_template_directory_uri() . '/assets/images/logo.png',
            'telephone' => get_option('cps_contact_phone', '+62-21-1234-5678'),
            'email' => get_option('admin_email'),
            'address' => array(
                '@type' => 'PostalAddress',
                'streetAddress' => get_option('cps_contact_address', ''),
                'addressLocality' => 'Jakarta',
                'addressCountry' => 'ID',
            ),
            'sameAs' => array(
                'https://facebook.com/caripropshop',
                'https://instagram.com/caripropshop',
                'https://linkedin.com/company/caripropshop',
            ),
        );

        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>' . "\n";
    }

    public function output_critical_css() {
        if (is_singular('property')) {
            $critical_css = '
                body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif;line-height:1.6;color:#333}
                .property-header{background:#f8f9fa;padding:40px 0}
                .property-title{font-size:2.5rem;font-weight:700;margin-bottom:10px}
                .property-price{font-size:1.75rem;color:#007bff;font-weight:600;margin-bottom:20px}
                .property-specs{display:flex;gap:30px;margin-bottom:20px}
                .property-specs span{display:flex;align-items:center;gap:8px}
                .property-gallery{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:15px}
                .property-map{height:400px;background:#e9ecef}
                .property-description{font-size:1.1rem;line-height:1.8}
                .property-features{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:10px}
                .property-features li{display:flex;align-items:center;gap:8px}
            ';
            echo '<style id="critical-css">' . $critical_css . '</style>' . "\n";
        }
    }

    public function lazy_load_images($content) {
        if (is_admin() || is_feed() || is_preview()) {
            return $content;
        }

        $content = preg_replace('/<img(?![^>]*data-src=)([^>]*)>/i', '<img data-src="$1" class="lazy-load"$2>', $content);

        return $content;
    }

    public function add_lazy_loading($html, $post_id, $size) {
        if (is_admin() || is_feed() || is_preview()) {
            return $html;
        }

        if (strpos($html, 'loading=') === false) {
            $html = str_replace('<img', '<img loading="lazy"', $html);
        }

        if (strpos($html, 'data-src=') === false && strpos($html, 'src=') !== false) {
            $html = preg_replace('/src=([\'"])(.*?)\1/', 'data-src="$2" class="lazy-load"', $html);
        }

        return $html;
    }

    public function defer_offscreen_images($attr, $attachment, $size) {
        if (is_admin() || is_feed() || is_preview()) {
            return $attr;
        }

        $attr['loading'] = 'lazy';

        return $attr;
    }

    private function get_image_attachment_id($url) {
        $attachment_id = 0;

        if (is_numeric($url)) {
            return intval($url);
        }

        global $wpdb;
        $attachment_id = attachment_url_to_postid($url);

        if (!$attachment_id) {
            $upload_dir = wp_upload_dir();
            $path = str_replace($upload_dir['baseurl'], '', $url);

            $attachment_id = $wpdb->get_var($wpdb->prepare(
                "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_value LIKE %s LIMIT 1",
                '%' . $wpdb->esc_like($path) . '%'
            ));
        }

        return $attachment_id;
    }

    public function get_canonical_url() {
        global $post;
        $canonical = '';

        if (is_singular()) {
            $canonical = get_permalink();
        } elseif (is_home() || is_front_page()) {
            $canonical = home_url('/');
        } elseif (is_archive()) {
            $canonical = get_post_type_archive_link(get_post_type());
        } elseif (is_search()) {
            $canonical = get_search_link();
        }

        if ($canonical) {
            echo '<link rel="canonical" href="' . esc_url($canonical) . '">' . "\n";
        }
    }
}

CPS_SEO::get_instance();
