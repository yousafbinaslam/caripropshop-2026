<?php
/**
 * CariPropShop Demo Content Generator
 * Run this file once to create sample data for the theme
 */

if (!defined('ABSPATH')) {
    exit;
}

class CPS_Demo_Content {
    
    public function __construct() {
        $this->demo_agent_id = null;
        $this->demo_agent2_id = null;
        $this->demo_agent3_id = null;
    }
    
    public function generate_all() {
        $this->create_agents();
        $this->create_agencies();
        $this->create_properties();
        $this->create_neighborhoods();
        $this->create_developers();
        $this->create_testimonials();
        $this->create_blog_posts();
        $this->setup_taxonomies();
        
        flush_rewrite_rules();
        
        return array(
            'success' => true,
            'message' => 'Demo content created successfully!'
        );
    }
    
    private function create_agents() {
        $agents = array(
            array(
                'name' => 'Ahmad Wijaya',
                'position' => 'Senior Property Consultant',
                'phone' => '+62 812 3456 7890',
                'email' => 'ahmad.wijaya@caripropshop.com',
                'bio' => 'With over 10 years of experience in the Jakarta real estate market, Ahmad specializes in luxury residential properties and commercial spaces.',
                'facebook' => 'https://facebook.com/ahmadwijaya',
                'instagram' => 'https://instagram.com/ahmadwijaya_realtor',
                'linkedin' => 'https://linkedin.com/in/ahmadwijaya'
            ),
            array(
                'name' => 'Siti Nurhaliza',
                'position' => 'Property Specialist',
                'phone' => '+62 813 9876 5432',
                'email' => 'siti.nurhaliza@caripropshop.com',
                'bio' => 'Siti is known for her expertise in the South Jakarta area and has helped hundreds of families find their dream homes.',
                'facebook' => 'https://facebook.com/sitinurhaliza',
                'instagram' => 'https://instagram.com/siti_property',
                'whatsapp' => '+6281398765432'
            ),
            array(
                'name' => 'Budi Santoso',
                'position' => 'Investment Advisor',
                'phone' => '+62 814 5678 9012',
                'email' => 'budi.santoso@caripropshop.com',
                'bio' => 'Budi specializes in investment properties and commercial real estate, helping clients build wealth through strategic property investments.',
                'linkedin' => 'https://linkedin.com/in/budisantoso',
                'twitter' => 'https://twitter.com/budi_realtor'
            )
        );
        
        foreach ($agents as $agent_data) {
            $agent_id = $this->create_agent($agent_data);
            if ($this->demo_agent_id === null) {
                $this->demo_agent_id = $agent_id;
            }
        }
    }
    
    private function create_agent($data) {
        $agent = array(
            'post_type' => 'agent',
            'post_title' => $data['name'],
            'post_content' => $data['bio'],
            'post_status' => 'publish',
            'post_author' => 1
        );
        
        $agent_id = wp_insert_post($agent);
        
        update_post_meta($agent_id, 'cps_agent_position', $data['position']);
        update_post_meta($agent_id, 'cps_agent_phone', $data['phone']);
        update_post_meta($agent_id, 'cps_agent_email', $data['email']);
        
        if (isset($data['facebook'])) {
            update_post_meta($agent_id, 'cps_agent_facebook', $data['facebook']);
        }
        if (isset($data['instagram'])) {
            update_post_meta($agent_id, 'cps_agent_instagram', $data['instagram']);
        }
        if (isset($data['linkedin'])) {
            update_post_meta($agent_id, 'cps_agent_linkedin', $data['linkedin']);
        }
        if (isset($data['twitter'])) {
            update_post_meta($agent_id, 'cps_agent_twitter', $data['twitter']);
        }
        if (isset($data['whatsapp'])) {
            update_post_meta($agent_id, 'cps_agent_whatsapp', $data['whatsapp']);
        }
        
        return $agent_id;
    }
    
    private function create_agencies() {
        $agencies = array(
            array(
                'name' => 'CariPropShop Premium',
                'tagline' => 'Your Trusted Real Estate Partner',
                'phone' => '+62 21 1234 5678',
                'email' => 'info@caripropshop.com',
                'address' => 'Jl. Sudirman No. 123, Jakarta Selatan',
                'description' => 'CariPropShop Premium offers a wide range of premium properties across Indonesia, from luxury apartments in Jakarta to beachfront villas in Bali.'
            ),
            array(
                'name' => 'CariPropShop Commercial',
                'tagline' => 'Excellence in Commercial Real Estate',
                'phone' => '+62 21 8765 4321',
                'email' => 'commercial@caripropshop.com',
                'address' => 'Jl. Thamrin No. 456, Jakarta Pusat',
                'description' => 'Specializing in commercial properties including office spaces, retail locations, and industrial warehouses.'
            )
        );
        
        foreach ($agencies as $agency_data) {
            $agency = array(
                'post_type' => 'agency',
                'post_title' => $agency_data['name'],
                'post_content' => $agency_data['description'],
                'post_status' => 'publish',
                'post_author' => 1
            );
            
            $agency_id = wp_insert_post($agency);
            
            update_post_meta($agency_id, 'cps_agency_tagline', $agency_data['tagline']);
            update_post_meta($agency_id, 'cps_agency_phone', $agency_data['phone']);
            update_post_meta($agency_id, 'cps_agency_email', $agency_data['email']);
            update_post_meta($agency_id, 'cps_agency_address', $agency_data['address']);
            update_post_meta($agency_id, 'cps_agency_agents', array($this->demo_agent_id));
        }
    }
    
    private function create_properties() {
        $properties = array(
            array(
                'title' => 'Modern Apartment with City View',
                'price' => 2500000000,
                'type' => 'apartment',
                'status' => 'sale',
                'city' => 'jakarta-selatan',
                'bedrooms' => 3,
                'bathrooms' => 2,
                'area' => 120,
                'address' => 'Jl. Kemang Raya No. 45, Kemang, Jakarta Selatan',
                'description' => 'Beautiful modern apartment located in the heart of Kemang. Features floor-to-ceiling windows with stunning city views, fully equipped kitchen, and access to world-class amenities including swimming pool, gym, and 24-hour security.'
            ),
            array(
                'title' => 'Luxury Villa with Private Pool',
                'price' => 8500000000,
                'type' => 'villa',
                'status' => 'sale',
                'city' => 'bali',
                'bedrooms' => 5,
                'bathrooms' => 4,
                'area' => 450,
                'address' => 'Jl. Raya Seminyak, Bali',
                'description' => 'Stunning luxury villa in the heart of Seminyak. This 5-bedroom villa features a private infinity pool, tropical garden, fully furnished interiors, and is just minutes away from the beach and best restaurants in Bali.'
            ),
            array(
                'title' => 'Cozy Studio Apartment',
                'price' => 850000000,
                'type' => 'apartment',
                'status' => 'sale',
                'city' => 'jakarta-barat',
                'bedrooms' => 1,
                'bathrooms' => 1,
                'area' => 35,
                'address' => 'Jl. Puri Indah Raya, Jakarta Barat',
                'description' => 'Perfect starter home or investment property. This well-designed studio apartment offers efficient living space with modern amenities and is located in a vibrant neighborhood with easy access to shopping and dining.'
            ),
            array(
                'title' => 'Spacious Family House',
                'price' => 4500000000,
                'type' => 'house',
                'status' => 'sale',
                'city' => 'tangerang',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'area' => 200,
                'address' => 'Kelapa Gading, Tangerang',
                'description' => 'Ideal for growing families, this spacious house features a large living room, separate dining area, private garden, and garage for 2 cars. Located in a quiet, secure residential area with excellent schools nearby.'
            ),
            array(
                'title' => 'Downtown Office Space',
                'price' => 350000000,
                'type' => 'commercial',
                'status' => 'rent',
                'city' => 'jakarta-pusat',
                'bedrooms' => 0,
                'bathrooms' => 2,
                'area' => 150,
                'address' => 'Jl. Sudirman, Jakarta Pusat',
                'description' => 'Prime office space in the central business district. Features open floor plan, central air conditioning, fiber optic internet, and building amenities including meeting rooms and parking facilities.'
            ),
            array(
                'title' => 'Beachfront Land for Development',
                'price' => 12000000000,
                'type' => 'land',
                'status' => 'sale',
                'city' => 'bali',
                'bedrooms' => 0,
                'bathrooms' => 0,
                'area' => 2500,
                'address' => 'Sanur Beach, Bali',
                'description' => 'Rare opportunity to own beachfront land in Sanur. This 2,500 sqm plot is perfect for resort development or luxury villa construction. Clear beachfrontage with stunning ocean views.'
            ),
            array(
                'title' => 'Modern Townhouse',
                'price' => 1800000000,
                'type' => 'house',
                'status' => 'sale',
                'city' => 'jakarta-barat',
                'bedrooms' => 3,
                'bathrooms' => 2,
                'area' => 120,
                'address' => 'Puri Indah, Jakarta Barat',
                'description' => 'Contemporary townhouse in a premium cluster housing complex. Features 3 floors of living space, rooftop terrace, smart home features, and access to community facilities.'
            ),
            array(
                'title' => 'Penthouse Suite',
                'price' => 15000000000,
                'type' => 'apartment',
                'status' => 'sale',
                'city' => 'jakarta-selatan',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'area' => 350,
                'address' => 'Mega Kuningan, Jakarta Selatan',
                'description' => 'Exclusive penthouse in one of Jakarta most prestigious towers. Enjoy panoramic views, private elevator access, designer interiors, and five-star building services.'
            ),
            array(
                'title' => 'Warehouse for Lease',
                'price' => 150000000,
                'type' => 'commercial',
                'status' => 'rent',
                'city' => 'tangerang',
                'bedrooms' => 0,
                'bathrooms' => 1,
                'area' => 1000,
                'address' => 'Cikupa, Tangerang',
                'description' => 'Industrial warehouse space ideal for logistics or manufacturing. Features high ceilings, loading docks, adequate power supply, and easy access to toll roads connecting to Jakarta and beyond.'
            ),
            array(
                'title' => 'Hillside Villa with Valley View',
                'price' => 6800000000,
                'type' => 'villa',
                'status' => 'sale',
                'city' => 'bandung',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'area' => 380,
                'address' => 'Lembang, Bandung',
                'description' => 'Escape to this stunning hillside villa with breathtaking views of the surrounding valleys. Perfect for those seeking tranquility while being just an hour from Jakarta. Features hot spring access and organic garden.'
            )
        );
        
        foreach ($properties as $property_data) {
            $this->create_property($property_data);
        }
    }
    
    private function create_property($data) {
        $property = array(
            'post_type' => 'property',
            'post_title' => $data['title'],
            'post_content' => $data['description'],
            'post_status' => 'publish',
            'post_author' => 1
        );
        
        $property_id = wp_insert_post($property);
        
        update_post_meta($property_id, 'cps_price', $data['price']);
        update_post_meta($property_id, 'cps_price_label', '');
        update_post_meta($property_id, 'cps_price_suffix', $data['status'] === 'rent' ? 'month' : '');
        update_post_meta($property_id, 'cps_bedrooms', $data['bedrooms']);
        update_post_meta($property_id, 'cps_bathrooms', $data['bathrooms']);
        update_post_meta($property_id, 'cps_area', $data['area']);
        update_post_meta($property_id, 'cps_address', $data['address']);
        update_post_meta($property_id, 'cps_agent', $this->demo_agent_id);
        update_post_meta($property_id, 'cps_features', array('parking', 'swimming-pool', 'gym', 'security', 'air-conditioning'));
        
        wp_set_object_terms($property_id, $data['type'], 'property_type');
        wp_set_object_terms($property_id, $data['status'], 'property_status');
        wp_set_object_terms($property_id, $data['city'], 'property_city');
        
        return $property_id;
    }
    
    private function create_neighborhoods() {
        $neighborhoods = array(
            array(
                'name' => 'Kemang',
                'city' => 'jakarta-selatan',
                'description' => 'Kemang is known for its vibrant nightlife, trendy cafes, and expatriate community. The area offers a mix of apartments, houses, and international restaurants.'
            ),
            array(
                'name' => 'SCBD',
                'city' => 'jakarta-selatan',
                'description' => 'The Sudirman Central Business District is Jakarta premier business enclave, featuring premium office towers, luxury apartments, and high-end retail.'
            ),
            array(
                'name' => 'Senayan',
                'city' => 'jakarta-pusat',
                'description' => 'A prestigious residential and commercial area home to embassies, golf courses, and the Jakarta Convention Center.'
            ),
            array(
                'name' => 'Bintaro',
                'city' => 'tangerang',
                'description' => 'A popular expat-friendly residential area with international schools, shopping malls, and excellent infrastructure.'
            ),
            array(
                'name' => 'Seminyak',
                'city' => 'bali',
                'description' => 'Bali most fashionable beach destination, known for its beaches, restaurants, boutiques, and vibrant nightlife scene.'
            )
        );
        
        foreach ($neighborhoods as $neighborhood_data) {
            $neighborhood = array(
                'post_type' => 'neighborhood',
                'post_title' => $neighborhood_data['name'],
                'post_content' => $neighborhood_data['description'],
                'post_status' => 'publish',
                'post_author' => 1
            );
            
            $neighborhood_id = wp_insert_post($neighborhood);
            wp_set_object_terms($neighborhood_id, $neighborhood_data['city'], 'property_city');
        }
    }
    
    private function create_developers() {
        $developers = array(
            array(
                'name' => 'PT. Jaya Real Estate',
                'tagline' => 'Building Tomorrow Today',
                'description' => 'Leading Indonesian real estate developer with over 30 years of experience in residential and commercial projects across Indonesia.'
            ),
            array(
                'name' => 'Agung Podomoro Group',
                'tagline' => 'Excellence in Urban Development',
                'description' => 'Premier property developer specializing in integrated townships, apartments, and commercial spaces in major Indonesian cities.'
            ),
            array(
                'name' => 'Sinar Mas Land',
                'tagline' => 'Creating Sustainable Communities',
                'description' => 'One of Indonesia largest property developers, known for innovative township developments and green building practices.'
            )
        );
        
        foreach ($developers as $developer_data) {
            $developer = array(
                'post_type' => 'developer',
                'post_title' => $developer_data['name'],
                'post_content' => $developer_data['description'],
                'post_status' => 'publish',
                'post_author' => 1
            );
            
            $developer_id = wp_insert_post($developer);
            update_post_meta($developer_id, 'cps_developer_tagline', $developer_data['tagline']);
        }
    }
    
    private function create_testimonials() {
        $testimonials = array(
            array(
                'name' => 'Dr. Robert Chen',
                'company' => 'CEO, TechAsia Indonesia',
                'content' => 'CariPropShop helped us find the perfect office space for our growing tech company. Their professionalism and market knowledge saved us both time and money.',
                'rating' => 5
            ),
            array(
                'name' => 'Sarah Johnson',
                'company' => 'Expat Family',
                'content' => 'As newcomers to Jakarta, we were overwhelmed by the housing options. CariPropShop made the entire process smooth and found us a home we truly love.',
                'rating' => 5
            ),
            array(
                'name' => 'Hendra Wijaya',
                'company' => 'Investor',
                'content' => 'I have worked with CariPropShop on multiple investment properties. Their market insights and investment advice have consistently delivered excellent returns.',
                'rating' => 4
            ),
            array(
                'name' => 'Maria Santos',
                'company' => 'Restaurant Owner',
                'content' => 'Found the perfect commercial space for my restaurant through CariPropShop. The team understood my requirements perfectly and negotiated a great deal.',
                'rating' => 5
            )
        );
        
        foreach ($testimonials as $testimonial_data) {
            $testimonial = array(
                'post_type' => 'testimonial',
                'post_title' => $testimonial_data['name'],
                'post_content' => $testimonial_data['content'],
                'post_status' => 'publish',
                'post_author' => 1
            );
            
            $testimonial_id = wp_insert_post($testimonial);
            update_post_meta($testimonial_id, 'cps_company', $testimonial_data['company']);
            update_post_meta($testimonial_id, 'cps_rating', $testimonial_data['rating']);
        }
    }
    
    private function create_blog_posts() {
        $posts = array(
            array(
                'title' => 'Top 10 Neighborhoods to Live in Jakarta in 2026',
                'content' => 'Jakarta continues to evolve as a world-class city, offering diverse neighborhoods for every lifestyle. From the bustling streets of Kemang to the serene suburbs of BSD, discover the best areas to call home in Indonesia capital.',
                'category' => 'Guides'
            ),
            array(
                'title' => 'Investment Outlook: Indonesian Real Estate Market 2026',
                'content' => 'The Indonesian property market shows strong fundamentals with growing demand in both residential and commercial sectors. Learn about the key trends and opportunities for property investors.',
                'category' => 'Market Trends'
            ),
            array(
                'title' => 'First-Time Home Buyer Guide: Everything You Need to Know',
                'content' => 'Buying your first home is a significant milestone. This comprehensive guide covers everything from mortgage options to legal requirements, helping you navigate the process with confidence.',
                'category' => 'Guides'
            ),
            array(
                'title' => 'Bali Property: Why Now is the Time to Invest',
                'content' => 'Bali real estate market is experiencing unprecedented growth. Discover why investors are flocking to the Island of the Gods and what opportunities exist for both local and international buyers.',
                'category' => 'Investment'
            ),
            array(
                'title' => 'Commercial vs Residential: Which Property Investment is Right for You?',
                'content' => 'We break down the pros and cons of commercial and residential property investments, helping you make an informed decision based on your financial goals and risk tolerance.',
                'category' => 'Investment'
            )
        );
        
        foreach ($posts as $post_data) {
            $post = array(
                'post_type' => 'post',
                'post_title' => $post_data['title'],
                'post_content' => $post_data['content'],
                'post_status' => 'publish',
                'post_author' => 1
            );
            
            $post_id = wp_insert_post($post);
            wp_set_object_terms($post_id, $post_data['category'], 'category');
        }
    }
    
    private function setup_taxonomies() {
        $property_types = array(
            'house' => 'House',
            'apartment' => 'Apartment',
            'villa' => 'Villa',
            'land' => 'Land',
            'commercial' => 'Commercial'
        );
        
        foreach ($property_types as $slug => $name) {
            if (!term_exists($name, 'property_type')) {
                wp_insert_term($name, 'property_type', array('slug' => $slug));
            }
        }
        
        $property_status = array(
            'sale' => 'For Sale',
            'rent' => 'For Rent',
            'sold' => 'Sold',
            'pending' => 'Pending'
        );
        
        foreach ($property_status as $slug => $name) {
            if (!term_exists($name, 'property_status')) {
                wp_insert_term($name, 'property_status', array('slug' => $slug));
            }
        }
        
        $cities = array(
            'jakarta-selatan' => 'Jakarta Selatan',
            'jakarta-pusat' => 'Jakarta Pusat',
            'jakarta-barat' => 'Jakarta Barat',
            'jakarta-timur' => 'Jakarta Timur',
            'jakarta-utara' => 'Jakarta Utara',
            'tangerang' => 'Tangerang',
            'bogor' => 'Bogor',
            'depok' => 'Depok',
            'bandung' => 'Bandung',
            'bali' => 'Bali',
            'surabaya' => 'Surabaya'
        );
        
        foreach ($cities as $slug => $name) {
            if (!term_exists($name, 'property_city')) {
                wp_insert_term($name, 'property_city', array('slug' => $slug));
            }
        }
    }
}

function cps_run_demo_content_generator() {
    $generator = new CPS_Demo_Content();
    return $generator->generate_all();
}
