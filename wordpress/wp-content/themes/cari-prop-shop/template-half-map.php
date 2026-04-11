<?php
/**
 * Template Name: Half Map Search
 */

get_header();

$google_maps_api_key = get_option('cps_google_maps_api_key', '');
?>

<div class="half-map-page">
    <div class="half-map-container">
        <!-- Search Panel -->
        <div class="search-panel">
            <div class="search-panel-header">
                <h3>Find Your Property</h3>
                <button class="btn-toggle-search" id="toggleSearch">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            
            <form id="propertySearchForm" class="property-search-form">
                <!-- Status Tabs -->
                <div class="search-status-tabs">
                    <button type="button" class="status-tab active" data-status="">All</button>
                    <button type="button" class="status-tab" data-status="for-sale">For Sale</button>
                    <button type="button" class="status-tab" data-status="for-rent">For Rent</button>
                </div>
                
                <!-- Keyword Search -->
                <div class="search-field">
                    <input type="text" id="keyword" placeholder="Enter keyword..." class="search-input">
                </div>
                
                <!-- Property Type -->
                <div class="search-field">
                    <select id="propertyType" class="search-select">
                        <option value="">All Types</option>
                        <?php
                        $types = get_terms(array('taxonomy' => 'property_type', 'hide_empty' => false));
                        foreach ($types as $type) {
                            echo '<option value="' . esc_attr($type->slug) . '">' . esc_html($type->name) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                
                <!-- Location -->
                <div class="search-field">
                    <select id="propertyLocation" class="search-select">
                        <option value="">All Locations</option>
                        <?php
                        $locations = get_terms(array('taxonomy' => 'property_location', 'hide_empty' => false));
                        foreach ($locations as $location) {
                            echo '<option value="' . esc_attr($location->slug) . '">' . esc_html($location->name) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                
                <!-- Bedrooms & Bathrooms -->
                <div class="search-row">
                    <div class="search-field half">
                        <select id="bedrooms" class="search-select">
                            <option value="">Beds</option>
                            <?php for ($i = 1; $i <= 10; $i++) { ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?>+</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="search-field half">
                        <select id="bathrooms" class="search-select">
                            <option value="">Baths</option>
                            <?php for ($i = 1; $i <= 10; $i++) { ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?>+</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                
                <!-- Price Range -->
                <div class="search-field">
                    <select id="minPrice" class="search-select">
                        <option value="">Min Price</option>
                        <option value="50000000">IDR 50M</option>
                        <option value="100000000">IDR 100M</option>
                        <option value="250000000">IDR 250M</option>
                        <option value="500000000">IDR 500M</option>
                        <option value="1000000000">IDR 1B</option>
                        <option value="2000000000">IDR 2B</option>
                        <option value="5000000000">IDR 5B</option>
                        <option value="10000000000">IDR 10B</option>
                    </select>
                </div>
                <div class="search-field">
                    <select id="maxPrice" class="search-select">
                        <option value="">Max Price</option>
                        <option value="100000000">IDR 100M</option>
                        <option value="250000000">IDR 250M</option>
                        <option value="500000000">IDR 500M</option>
                        <option value="1000000000">IDR 1B</option>
                        <option value="2000000000">IDR 2B</option>
                        <option value="5000000000">IDR 5B</option>
                        <option value="10000000000">IDR 10B</option>
                        <option value="50000000000">IDR 50B</option>
                    </select>
                </div>
                
                <!-- Currency -->
                <div class="search-field">
                    <select id="currency" class="search-select">
                        <option value="">Currency</option>
                        <option value="idr">IDR</option>
                        <option value="usd">USD</option>
                    </select>
                </div>
                
                <!-- Features Toggle -->
                <button type="button" class="btn-features" id="toggleFeatures">
                    <i class="fas fa-sliders-h"></i> Other Features
                </button>
                
                <!-- Features Checklist -->
                <div class="features-checklist" id="featuresChecklist" style="display: none;">
                    <div class="features-grid">
                        <?php
                        $features = get_terms(array('taxonomy' => 'property_feature', 'hide_empty' => false));
                        foreach ($features as $feature) {
                            echo '<label class="feature-checkbox">';
                            echo '<input type="checkbox" name="features[]" value="' . esc_attr($feature->slug) . '">';
                            echo '<span>' . esc_html($feature->name) . '</span>';
                            echo '</label>';
                        }
                        ?>
                    </div>
                </div>
                
                <!-- Search Button -->
                <button type="submit" class="btn-search">
                    <i class="fas fa-search"></i> Search
                </button>
                
                <!-- Clear Button -->
                <button type="button" class="btn-clear" id="clearSearch">
                    Clear All
                </button>
            </form>
        </div>
        
        <!-- Map Container -->
        <div class="map-container">
            <div id="propertyMap" class="property-map"></div>
            
            <!-- Map Controls -->
            <div class="map-controls">
                <button class="map-control-btn" id="mapStyleToggle" title="Change Map Style">
                    <i class="fas fa-layer-group"></i>
                </button>
                <button class="map-control-btn" id="fullscreenToggle" title="Fullscreen">
                    <i class="fas fa-expand"></i>
                </button>
                <button class="map-control-btn" id="recenterMap" title="Recenter">
                    <i class="fas fa-crosshairs"></i>
                </button>
            </div>
            
            <!-- Map Style Selector -->
            <div class="map-style-selector" id="mapStyleSelector" style="display: none;">
                <button class="style-btn active" data-style="roadmap">Roadmap</button>
                <button class="style-btn" data-style="satellite">Satellite</button>
                <button class="style-btn" data-style="hybrid">Hybrid</button>
                <button class="style-btn" data-style="terrain">Terrain</button>
            </div>
            
            <!-- Radius Search -->
            <div class="radius-search">
                <label>Radius:</label>
                <select id="searchRadius">
                    <option value="1">1 km</option>
                    <option value="5" selected>5 km</option>
                    <option value="10">10 km</option>
                    <option value="25">25 km</option>
                    <option value="50">50 km</option>
                </select>
            </div>
        </div>
        
        <!-- Results Panel -->
        <div class="results-panel">
            <div class="results-header">
                <div class="results-count">
                    <span id="resultsCount">0</span> Properties Found
                </div>
                <div class="results-sort">
                    <select id="sortBy" class="sort-select">
                        <option value="date-desc">Newest First</option>
                        <option value="date-asc">Oldest First</option>
                        <option value="price-asc">Price: Low to High</option>
                        <option value="price-desc">Price: High to Low</option>
                        <option value="title-asc">Title: A-Z</option>
                        <option value="title-desc">Title: Z-A</option>
                    </select>
                </div>
                <div class="results-view-toggle">
                    <button class="view-btn active" data-view="grid"><i class="fas fa-th"></i></button>
                    <button class="view-btn" data-view="list"><i class="fas fa-list"></i></button>
                    <button class="view-btn" data-view="map"><i class="fas fa-map-marked-alt"></i></button>
                </div>
            </div>
            
            <div id="propertyResults" class="property-results">
                <!-- Results will be loaded via AJAX -->
                <div class="loading-spinner">
                    <i class="fas fa-spinner fa-spin"></i> Loading properties...
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Property Detail Modal -->
<div id="propertyModal" class="property-modal">
    <div class="modal-content">
        <span class="modal-close">&times;</span>
        <div id="modalContent"></div>
    </div>
</div>

<script>
// Property Data for Map - will be loaded via AJAX
var googleMapsApiKey = '<?php echo esc_js($google_maps_api_key); ?>';
</script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/half-map.js"></script>

<?php get_footer(); ?>
