<?php
/**
 * Template Name: Property Comparison
 */

get_header();

$compare_ids = isset($_COOKIE['cps_compare']) ? json_decode(stripslashes($_COOKIE['cps_compare']), true) : array();
$compare_ids = array_slice($compare_ids, 0, 4);
?>

<div class="compare-page">
    <div class="compare-header">
        <div class="container">
            <h1><i class="fas fa-balance-scale"></i> Compare Properties</h1>
            <p>Compare up to 4 properties side by side</p>
            <a href="<?php echo esc_url(home_url('/properties')); ?>" class="btn-back">Back to Listings</a>
        </div>
    </div>

    <div class="container">
        <?php if (empty($compare_ids)) : ?>
            <div class="empty-compare">
                <i class="fas fa-search"></i>
                <h2>No Properties to Compare</h2>
                <p>Start browsing and add properties to your comparison list.</p>
                <a href="<?php echo esc_url(home_url('/properties')); ?>" class="btn-primary">Browse Properties</a>
            </div>
        <?php else : ?>
            <div class="compare-table-wrapper">
                <table class="compare-table">
                    <thead>
                        <tr>
                            <th class="label-col"></th>
                            <?php foreach ($compare_ids as $id) : 
                                $property = get_post($id);
                                if (!$property) continue;
                                $image = get_the_post_thumbnail_url($id, 'medium');
                            ?>
                                <th class="property-col">
                                    <a href="<?php echo esc_url(get_permalink($id)); ?>" class="property-link">
                                        <?php if ($image) : ?>
                                            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($property->post_title); ?>">
                                        <?php else : ?>
                                            <div class="no-image"><i class="fas fa-home"></i></div>
                                        <?php endif; ?>
                                        <h3><?php echo esc_html($property->post_title); ?></h3>
                                    </a>
                                    <button class="btn-remove" onclick="removeFromCompare(<?php echo $id; ?>)">
                                        <i class="fas fa-times"></i> Remove
                                    </button>
                                </th>
                            <?php endforeach; ?>
                            <?php for ($i = count($compare_ids); $i < 4; $i++) : ?>
                                <th class="property-col empty-col">
                                    <div class="add-more">
                                        <i class="fas fa-plus"></i>
                                        <span>Add Property</span>
                                    </div>
                                </th>
                            <?php endfor; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Price -->
                        <tr class="highlight-row">
                            <td class="label-col">Price</td>
                            <?php foreach ($compare_ids as $id) : 
                                $price = get_post_meta($id, 'property_price', true);
                            ?>
                                <td><span class="price"><?php echo esc_html($price ?: '-'); ?></span></td>
                            <?php endforeach; ?>
                            <?php for ($i = count($compare_ids); $i < 4; $i++) : ?>
                                <td class="empty-col">-</td>
                            <?php endfor; ?>
                        </tr>
                        
                        <!-- Status -->
                        <tr>
                            <td class="label-col">Status</td>
                            <?php foreach ($compare_ids as $id) : 
                                $status = get_the_terms($id, 'property_status');
                                $status_name = $status && !is_wp_error($status) ? $status[0]->name : '-';
                            ?>
                                <td><span class="status-badge"><?php echo esc_html($status_name); ?></span></td>
                            <?php endforeach; ?>
                            <?php for ($i = count($compare_ids); $i < 4; $i++) : ?>
                                <td class="empty-col">-</td>
                            <?php endfor; ?>
                        </tr>
                        
                        <!-- Type -->
                        <tr>
                            <td class="label-col">Property Type</td>
                            <?php foreach ($compare_ids as $id) : 
                                $types = get_the_terms($id, 'property_type');
                                $type_name = $types && !is_wp_error($types) ? $types[0]->name : '-';
                            ?>
                                <td><?php echo esc_html($type_name); ?></td>
                            <?php endforeach; ?>
                            <?php for ($i = count($compare_ids); $i < 4; $i++) : ?>
                                <td class="empty-col">-</td>
                            <?php endfor; ?>
                        </tr>
                        
                        <!-- Location -->
                        <tr>
                            <td class="label-col">Location</td>
                            <?php foreach ($compare_ids as $id) : 
                                $address = get_post_meta($id, 'property_address', true);
                                $city = get_post_meta($id, 'property_city', true);
                            ?>
                                <td>
                                    <i class="fas fa-map-marker-alt"></i>
                                    <?php echo esc_html($address ?: '-'); ?>
                                    <?php if ($city) echo ', ' . esc_html($city); ?>
                                </td>
                            <?php endforeach; ?>
                            <?php for ($i = count($compare_ids); $i < 4; $i++) : ?>
                                <td class="empty-col">-</td>
                            <?php endfor; ?>
                        </tr>
                        
                        <!-- Bedrooms -->
                        <tr>
                            <td class="label-col">Bedrooms</td>
                            <?php foreach ($compare_ids as $id) : 
                                $bedrooms = get_post_meta($id, 'property_bedrooms', true);
                            ?>
                                <td><?php echo esc_html($bedrooms ?: '-'); ?></td>
                            <?php endforeach; ?>
                            <?php for ($i = count($compare_ids); $i < 4; $i++) : ?>
                                <td class="empty-col">-</td>
                            <?php endfor; ?>
                        </tr>
                        
                        <!-- Bathrooms -->
                        <tr>
                            <td class="label-col">Bathrooms</td>
                            <?php foreach ($compare_ids as $id) : 
                                $bathrooms = get_post_meta($id, 'property_bathrooms', true);
                            ?>
                                <td><?php echo esc_html($bathrooms ?: '-'); ?></td>
                            <?php endforeach; ?>
                            <?php for ($i = count($compare_ids); $i < 4; $i++) : ?>
                                <td class="empty-col">-</td>
                            <?php endfor; ?>
                        </tr>
                        
                        <!-- Area -->
                        <tr>
                            <td class="label-col">Area (sq ft)</td>
                            <?php foreach ($compare_ids as $id) : 
                                $sqft = get_post_meta($id, 'property_sqft', true);
                            ?>
                                <td><?php echo esc_html($sqft ?: '-'); ?></td>
                            <?php endforeach; ?>
                            <?php for ($i = count($compare_ids); $i < 4; $i++) : ?>
                                <td class="empty-col">-</td>
                            <?php endfor; ?>
                        </tr>
                        
                        <!-- Land Area -->
                        <tr>
                            <td class="label-col">Land Area (sq ft)</td>
                            <?php foreach ($compare_ids as $id) : 
                                $land = get_post_meta($id, 'property_land_area', true);
                            ?>
                                <td><?php echo esc_html($land ?: '-'); ?></td>
                            <?php endforeach; ?>
                            <?php for ($i = count($compare_ids); $i < 4; $i++) : ?>
                                <td class="empty-col">-</td>
                            <?php endfor; ?>
                        </tr>
                        
                        <!-- Garage -->
                        <tr>
                            <td class="label-col">Garages</td>
                            <?php foreach ($compare_ids as $id) : 
                                $garage = get_post_meta($id, 'property_garage', true);
                            ?>
                                <td><?php echo esc_html($garage ?: '-'); ?></td>
                            <?php endforeach; ?>
                            <?php for ($i = count($compare_ids); $i < 4; $i++) : ?>
                                <td class="empty-col">-</td>
                            <?php endfor; ?>
                        </tr>
                        
                        <!-- Year Built -->
                        <tr>
                            <td class="label-col">Year Built</td>
                            <?php foreach ($compare_ids as $id) : 
                                $year = get_post_meta($id, 'property_year', true);
                            ?>
                                <td><?php echo esc_html($year ?: '-'); ?></td>
                            <?php endforeach; ?>
                            <?php for ($i = count($compare_ids); $i < 4; $i++) : ?>
                                <td class="empty-col">-</td>
                            <?php endfor; ?>
                        </tr>
                        
                        <!-- Features -->
                        <tr class="features-row">
                            <td class="label-col">Features</td>
                            <?php foreach ($compare_ids as $id) : 
                                $features = get_the_terms($id, 'property_feature');
                            ?>
                                <td>
                                    <?php if ($features && !is_wp_error($features)) : ?>
                                        <ul class="features-list">
                                            <?php foreach (array_slice($features, 0, 8) as $feature) : ?>
                                                <li><i class="fas fa-check"></i> <?php echo esc_html($feature->name); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else : ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                            <?php for ($i = count($compare_ids); $i < 4; $i++) : ?>
                                <td class="empty-col">-</td>
                            <?php endfor; ?>
                        </tr>
                        
                        <!-- Actions -->
                        <tr class="action-row">
                            <td class="label-col"></td>
                            <?php foreach ($compare_ids as $id) : ?>
                                <td>
                                    <a href="<?php echo esc_url(get_permalink($id)); ?>" class="btn-view">View Details</a>
                                    <a href="<?php echo esc_url(get_permalink($id)); ?>?schedule=1" class="btn-schedule">Schedule Tour</a>
                                </td>
                            <?php endforeach; ?>
                            <?php for ($i = count($compare_ids); $i < 4; $i++) : ?>
                                <td class="empty-col">-</td>
                            <?php endfor; ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.compare-page {
    background: #f5f7fa;
    min-height: 100vh;
}

.compare-header {
    background: linear-gradient(135deg, #1a365d 0%, #2c5282 100%);
    color: white;
    padding: 60px 0;
    text-align: center;
}

.compare-header h1 {
    margin: 0 0 10px;
}

.compare-header p {
    opacity: 0.9;
    margin: 0 0 20px;
}

.btn-back {
    display: inline-block;
    padding: 12px 30px;
    background: rgba(255,255,255,0.2);
    color: white;
    border-radius: 6px;
    text-decoration: none;
}

.empty-compare {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 12px;
    margin: 40px 0;
}

.empty-compare i {
    font-size: 64px;
    color: #cbd5e0;
    margin-bottom: 20px;
}

.btn-primary {
    display: inline-block;
    padding: 15px 40px;
    background: #3182ce;
    color: white;
    border-radius: 6px;
    text-decoration: none;
    margin-top: 20px;
}

.compare-table-wrapper {
    overflow-x: auto;
    margin: 40px 0;
}

.compare-table {
    width: 100%;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.compare-table th,
.compare-table td {
    padding: 20px;
    text-align: center;
    border-bottom: 1px solid #edf2f7;
    vertical-align: top;
}

.compare-table th.label-col {
    text-align: left;
    font-weight: 600;
    color: #4a5568;
    width: 150px;
    background: #f8fafc;
}

.compare-table th.property-col {
    width: 25%;
    background: white;
}

.property-col img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 15px;
}

.property-link h3 {
    margin: 0 0 10px;
    color: #1a365d;
}

.btn-remove {
    background: #fed7d7;
    color: #c53030;
    border: none;
    padding: 8px 15px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 13px;
}

.empty-col {
    background: #f8fafc;
}

.add-more {
    padding: 80px 20px;
    border: 2px dashed #e2e8f0;
    border-radius: 8px;
    color: #a0aec0;
}

.highlight-row td {
    background: #ebf8ff;
}

.highlight-row .price {
    font-size: 24px;
    font-weight: 700;
    color: #3182ce;
}

.status-badge {
    background: #c6f6d5;
    color: #276749;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 13px;
}

.features-list {
    list-style: none;
    padding: 0;
    margin: 0;
    text-align: left;
}

.features-list li {
    padding: 5px 0;
    font-size: 13px;
}

.features-list li i {
    color: #48bb78;
    margin-right: 8px;
}

.action-row td {
    background: #f8fafc;
}

.btn-view {
    display: inline-block;
    padding: 10px 20px;
    background: #3182ce;
    color: white;
    border-radius: 6px;
    text-decoration: none;
    margin-right: 10px;
}

.btn-schedule {
    display: inline-block;
    padding: 10px 20px;
    background: #48bb78;
    color: white;
    border-radius: 6px;
    text-decoration: none;
}

@media (max-width: 768px) {
    .compare-table th,
    .compare-table td {
        padding: 10px;
        font-size: 14px;
    }
    
    .property-col img {
        height: 150px;
    }
}
</style>

<script>
function removeFromCompare(id) {
    var compareList = JSON.parse(localStorage.getItem('cps_compare') || '[]');
    compareList = compareList.filter(function(item) { return item !== id; });
    localStorage.setItem('cps_compare', JSON.stringify(compareList));
    location.reload();
}
</script>

<?php get_footer(); ?>
