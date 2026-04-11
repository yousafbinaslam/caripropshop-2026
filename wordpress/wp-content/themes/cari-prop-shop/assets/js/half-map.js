/**
 * CariPropShop Advanced Property Search
 * Features: Radius search, draw search, geo-location, voice search, save searches, clustering, street view
 */

(function($) {
    'use strict';

    let map = null;
    let markers = [];
    let markerCluster = null;
    let properties = [];
    let infoWindows = [];
    let drawingManager = null;
    let drawnShape = null;
    let searchCircle = null;
    let userLocation = null;
    let recognition = null;
    let isListening = false;
    let savedSearches = JSON.parse(localStorage.getItem('cps_saved_searches') || '[]');
    let recentSearches = JSON.parse(localStorage.getItem('cps_recent_searches') || '[]');
    let streetViewPanorama = null;
    let schoolsLayer = null;
    let placesService = null;

    const DEFAULT_CENTER = { lat: -6.2088, lng: 106.8456 };
    const CLUSTER_STYLES = [
        { textColor: '#ffffff', height: 40, width: 40, url: 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgdmlld0JveD0iMCAwIDQwIDQwIj48Y2lyY2xlIGN4PSIyMCIgY3k9IjIwIiByPSIxOCIgc3R5bGU9ImZpbGw6ICMyNTNEMzQ7Ii8+PC9zdmc+' },
        { textColor: '#ffffff', height: 50, width: 50, url: 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCIgdmlld0JveD0iMCAwIDUwIDUwIj48Y2lyY2xlIGN4PSIyNSIgY3k9IjI1IiByPSIyMiIgc3R5bGU9ImZpbGw6ICMyNTNEMzQ7Ii8+PC9zdmc+' },
        { textColor: '#ffffff', height: 60, width: 60, url: 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgdmlld0JveD0iMCAwIDYwIDYwIj48Y2lyY2xlIGN4PSIzMCIgY3k9IjMwIiByPSIyNiIgc3R5bGU9ImZpbGw6ICMyNTNEMzQ7Ii8+PC9zdmc+' }
    ];

    const MAP_STYLES = {
        default: [],
        silver: [{"featureType":"all","elementType":"geometry.fill","stylers":[{"weight":"2.00"}]},{"featureType":"all","elementType":"geometry.stroke","stylers":[{"color":"#9c9c9c"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#94c1d7"}]}],
        dark: [{"featureType":"all","elementType":"geometry","stylers":[{"color":"#242f3e"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#38414e"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#8b979d"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#17263c"}]}],
        night: [{"elementType":"geometry","stylers":[{"color":"#1d2c4d"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#8ec3b9"}]},{"elementType":"water","elementType":"geometry","stylers":[{"color":"#0e1626"}]}],
        retro: [{"elementType":"geometry","stylers":[{"color":"#ebe3cd"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#f5f1e6"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#b9d3c2"}]}]
    };

    function initMap() {
        if (typeof google === 'undefined') {
            console.warn('Google Maps API not loaded');
            return;
        }

        map = new google.maps.Map(document.getElementById('propertyMap'), {
            center: DEFAULT_CENTER,
            zoom: 11,
            mapTypeId: 'roadmap',
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: false,
            gestureHandling: 'greedy',
            zoomControl: true,
            zoomControlOptions: {
                position: google.maps.ControlPosition.RIGHT_CENTER
            }
        });

        initMarkerClustering();
        initDrawingManager();
        initOverlays();
        initStreetView();
        initPlacesService();
        loadProperties();
        renderSavedSearches();
        renderRecentSearches();
        initVoiceSearch();
    }

    function initMarkerClustering() {
        if (typeof MarkerClusterer !== 'undefined') {
            markerCluster = new MarkerClusterer(map, [], {
                imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m',
                styles: CLUSTER_STYLES,
                maxZoom: 15,
                gridSize: 60,
                minimumClusterSize: 2
            });
        }
    }

    function initStreetView() {
        if (typeof google !== 'undefined' && google.maps.StreetViewPanorama) {
            const mapContainer = document.getElementById('propertyMap');
            if (mapContainer) {
                const streetViewContainer = document.createElement('div');
                streetViewContainer.id = 'streetViewContainer';
                streetViewContainer.style.display = 'none';
                streetViewContainer.style.position = 'absolute';
                streetViewContainer.style.top = '0';
                streetViewContainer.style.left = '0';
                streetViewContainer.style.width = '100%';
                streetViewContainer.style.height = '100%';
                streetViewContainer.style.zIndex = '1000';
                mapContainer.style.position = 'relative';
                mapContainer.parentNode.insertBefore(streetViewContainer, mapContainer.nextSibling);

                streetViewPanorama = new google.maps.StreetViewPanorama(streetViewContainer, {
                    position: DEFAULT_CENTER,
                    pov: { heading: 0, pitch: 0 },
                    zoom: 1
                });

                map.addListener('click', function() {
                    if (streetViewPanorama && streetViewPanorama.getVisible()) {
                        closeStreetView();
                    }
                });
            }
        }
    }

    function initPlacesService() {
        if (typeof google !== 'undefined' && google.maps.places) {
            placesService = new google.maps.places.PlacesService(map);
        }
    }

    function toggleStreetView() {
        if (streetViewPanorama) {
            if (streetViewPanorama.getVisible()) {
                closeStreetView();
            } else {
                openStreetView();
            }
        }
    }

    function openStreetView(lat, lng) {
        if (streetViewPanorama) {
            document.getElementById('streetViewContainer').style.display = 'block';
            document.getElementById('propertyMap').style.opacity = '0.3';

            if (lat && lng) {
                streetViewPanorama.setPosition({ lat: lat, lng: lng });
            } else if (map.getCenter()) {
                streetViewPanorama.setPosition(map.getCenter());
            }

            streetViewPanorama.setVisible(true);
            $('#streetViewToggle').addClass('active');
        }
    }

    function closeStreetView() {
        if (streetViewPanorama) {
            document.getElementById('streetViewContainer').style.display = 'none';
            document.getElementById('propertyMap').style.opacity = '1';
            streetViewPanorama.setVisible(false);
            $('#streetViewToggle').removeClass('active');
        }
    }

    function getStreetViewData(lat, lng, callback) {
        const sv = new google.maps.StreetViewService();
        sv.getPanorama({ location: { lat: lat, lng: lng }, radius: 50 }, function(data, status) {
            callback(status === google.maps.StreetViewStatus.OK, data);
        });
    }

    function searchNearby(type, callback) {
        if (!placesService || !map.getCenter()) return;

        const request = {
            location: map.getCenter(),
            radius: '5000',
            type: type
        };

        placesService.nearbySearch(request, function(results, status) {
            if (status === google.maps.places.PlacesServiceStatus.OK) {
                callback(results);
            }
        });
    }

    function toggleSchoolsLayer() {
        if (schoolsLayer) {
            schoolsLayer.setMap(null);
            schoolsLayer = null;
            $('#schoolsToggle').removeClass('active');
        } else {
            if (typeof kmllayer === 'undefined') {
                searchNearby('school', function(schools) {
                    displayNearbyPlaces(schools, 'school');
                });
            }
            $('#schoolsToggle').addClass('active');
        }
    }

    function displayNearbyPlaces(places, type) {
        places.forEach(function(place) {
            const marker = new google.maps.Marker({
                position: place.geometry.location,
                map: map,
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    scale: 8,
                    fillColor: type === 'school' ? '#9b59b6' : '#e74c3c',
                    fillOpacity: 1,
                    strokeColor: '#fff',
                    strokeWeight: 2
                },
                title: place.name
            });
        });
    }

    function initDrawingManager() {
        if (typeof google.maps.drawing === 'undefined') return;

        drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: null,
            drawingControl: false,
            polygonOptions: {
                fillColor: '#3498db',
                fillOpacity: 0.3,
                strokeColor: '#3498db',
                strokeWeight: 2,
                editable: true
            },
            rectangleOptions: {
                fillColor: '#3498db',
                fillOpacity: 0.3,
                strokeColor: '#3498db',
                strokeWeight: 2,
                editable: true
            },
            circleOptions: {
                fillColor: '#3498db',
                fillOpacity: 0.3,
                strokeColor: '#3498db',
                strokeWeight: 2,
                editable: true
            }
        });

        drawingManager.setMap(map);

        google.maps.event.addListener(drawingManager, 'drawingmode_changed', function() {
            if (drawnShape) {
                drawnShape.setMap(null);
                drawnShape = null;
            }
        });

        google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event) {
            if (drawnShape) drawnShape.setMap(null);
            drawnShape = event.overlay;
            drawnShape.type = event.type;

            if (event.type === 'circle') {
                drawnShape.addListener('radius_changed', updatePropertiesInShape);
                drawnShape.addListener('center_changed', updatePropertiesInShape);
            } else {
                google.maps.event.addListener(drawnShape, 'bounds_changed', updatePropertiesInShape);
                google.maps.event.addListener(drawnShape.getPath(), 'set_at', updatePropertiesInShape);
                google.maps.event.addListener(drawnShape.getPath(), 'insert_at', updatePropertiesInShape);
            }
            updatePropertiesInShape();
        });
    }

    function initOverlays() {
        window.cpsTransitLayer = new google.maps.TransitLayer();
        window.cpsBicyclingLayer = new google.maps.BicyclingLayer();
    }

    function updatePropertiesInShape() {
        if (!drawnShape || properties.length === 0) return;

        const filtered = properties.filter(function(property) {
            if (!property.lat || !property.lng) return false;
            const point = new google.maps.LatLng(parseFloat(property.lat), parseFloat(property.lng));

            if (drawnShape.type === 'circle') {
                return google.maps.geometry.spherical.computeDistanceBetween(point, drawnShape.getCenter()) <= drawnShape.getRadius();
            } else if (drawnShape.type === 'polygon') {
                return google.maps.geometry.poly.isLocationOnEdge(point, drawnShape, 1e-5);
            } else if (drawnShape.type === 'rectangle') {
                return drawnShape.getBounds().contains(point);
            }
            return true;
        });

        displayFilteredProperties(filtered);
    }

    function searchByRadius(lat, lng, radiusKm) {
        if (searchCircle) searchCircle.setMap(null);
        userLocation = new google.maps.LatLng(lat, lng);

        searchCircle = new google.maps.Circle({
            map: map,
            center: userLocation,
            radius: radiusKm * 1000,
            fillColor: '#3498db',
            fillOpacity: 0.2,
            strokeColor: '#3498db',
            strokeWeight: 2,
            editable: true
        });

        searchCircle.addListener('radius_changed', updatePropertiesInRadius);
        searchCircle.addListener('center_changed', updatePropertiesInRadius);
        map.fitBounds(searchCircle.getBounds());
        updatePropertiesInRadius();
    }

    function updatePropertiesInRadius() {
        if (!searchCircle || properties.length === 0) return;

        const filtered = properties.filter(function(property) {
            if (!property.lat || !property.lng) return false;
            const point = new google.maps.LatLng(parseFloat(property.lat), parseFloat(property.lng));
            return google.maps.geometry.spherical.computeDistanceBetween(point, searchCircle.getCenter()) <= searchCircle.getRadius();
        });

        displayFilteredProperties(filtered);
    }

    function clearRadiusSearch() {
        if (searchCircle) {
            searchCircle.setMap(null);
            searchCircle = null;
        }
        updateMarkers();
        updateResults();
    }

    function clearDrawShape() {
        if (drawnShape) {
            drawnShape.setMap(null);
            drawnShape = null;
        }
        if (drawingManager) drawingManager.setDrawingMode(null);
        updateMarkers();
        updateResults();
    }

    function detectUserLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const pos = { lat: position.coords.latitude, lng: position.coords.longitude };
                    userLocation = new google.maps.LatLng(pos.lat, pos.lng);

                    new google.maps.Marker({
                        position: pos,
                        map: map,
                        icon: {
                            path: google.maps.SymbolPath.CIRCLE,
                            scale: 12,
                            fillColor: '#3498db',
                            fillOpacity: 1,
                            strokeColor: '#fff',
                            strokeWeight: 3
                        },
                        title: 'Your Location'
                    });

                    map.setCenter(pos);
                    map.setZoom(14);
                    $('#radiusSearch').prop('disabled', false);
                    $('#useMyLocation').addClass('located').text('Update Location');

                    const radius = parseFloat($('#searchRadius').val()) || 5;
                    searchByRadius(pos.lat, pos.lng, radius);
                },
                function() {
                    showNotification('Unable to get your location.', 'error');
                    $('#useMyLocation').removeClass('located');
                }
            );
        } else {
            showNotification('Geolocation not supported', 'error');
        }
    }

    function initVoiceSearch() {
        if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            recognition = new SpeechRecognition();
            recognition.continuous = false;
            recognition.interimResults = true;
            recognition.lang = 'en-US';

            recognition.onresult = function(event) {
                let transcript = '';
                for (let i = event.resultIndex; i < event.results.length; i++) {
                    transcript += event.results[i][0].transcript;
                }
                $('#keyword').val(transcript);
                if (event.results[0].isFinal) filterProperties();
            };

            recognition.onerror = function(event) {
                stopVoiceSearch();
                if (event.error !== 'no-speech') {
                    showNotification('Voice search error: ' + event.error, 'error');
                }
            };

            recognition.onend = stopVoiceSearch;
        } else {
            $('#voiceSearch').hide();
        }
    }

    function toggleVoiceSearch() {
        if (!recognition) return;
        if (isListening) {
            isListening = false;
            $('#voiceSearch').removeClass('listening').find('i').removeClass('fa-stop').addClass('fa-microphone');
            recognition.stop();
        } else {
            isListening = true;
            $('#voiceSearch').addClass('listening').find('i').removeClass('fa-microphone').addClass('fa-stop');
            recognition.start();
        }
    }

    function saveCurrentSearch() {
        const filters = getCurrentFilters();
        const searchName = prompt('Enter a name for this search:', 'My Search ' + (savedSearches.length + 1));

        if (searchName) {
            savedSearches.push({
                id: Date.now(),
                name: searchName,
                filters: filters,
                created: new Date().toISOString(),
                alertEnabled: false
            });
            localStorage.setItem('cps_saved_searches', JSON.stringify(savedSearches));
            renderSavedSearches();
            showNotification('Search saved!', 'success');
        }
    }

    function loadSavedSearch(searchId) {
        const search = savedSearches.find(function(s) { return s.id === searchId; });
        if (search) {
            applyFilters(search.filters);
            filterProperties();
            showNotification('Search loaded', 'success');
        }
    }

    function deleteSavedSearch(searchId) {
        savedSearches = savedSearches.filter(function(s) { return s.id !== searchId; });
        localStorage.setItem('cps_saved_searches', JSON.stringify(savedSearches));
        renderSavedSearches();
    }

    function toggleSearchAlert(searchId) {
        const search = savedSearches.find(function(s) { return s.id === searchId; });
        if (search) {
            search.alertEnabled = !search.alertEnabled;
            localStorage.setItem('cps_saved_searches', JSON.stringify(savedSearches));

            if (search.alertEnabled) {
                $.ajax({
                    url: cpsData.ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'cps_subscribe_search_alert',
                        nonce: cpsData.nonce,
                        search_name: search.name,
                        search_filters: JSON.stringify(search.filters)
                    }
                });
                showNotification('Alert enabled!', 'success');
            }
            renderSavedSearches();
        }
    }

    function renderSavedSearches() {
        const $container = $('#savedSearchesList');
        if (savedSearches.length === 0) {
            $container.html('<p class="no-saved-searches">No saved searches yet</p>');
            return;
        }

        let html = '';
        savedSearches.forEach(function(search) {
            html += `
                <div class="saved-search-item" data-id="${search.id}">
                    <div class="search-info">
                        <h4>${search.name}</h4>
                        <p>${getFilterSummary(search.filters)}</p>
                    </div>
                    <div class="search-actions">
                        <button class="btn-load-search" title="Load"><i class="fas fa-search"></i></button>
                        <button class="btn-alert-search ${search.alertEnabled ? 'active' : ''}" title="${search.alertEnabled ? 'Disable' : 'Enable'} Alert"><i class="fas fa-bell"></i></button>
                        <button class="btn-delete-search" title="Delete"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `;
        });
        $container.html(html);
    }

    function renderRecentSearches() {
        const $container = $('#recentSearchesList');
        if (recentSearches.length === 0) {
            $container.html('<p class="no-recent-searches">No recent searches</p>');
            return;
        }

        let html = '';
        recentSearches.slice(0, 5).forEach(function(search, index) {
            html += `
                <li class="recent-search-item" data-index="${index}">
                    <i class="fas fa-history"></i> ${search.keyword || getFilterSummary(search)}
                    <button class="btn-remove-recent"><i class="fas fa-times"></i></button>
                </li>
            `;
        });
        $container.html(html);
    }

    function addToRecentSearches(filters) {
        const existing = recentSearches.findIndex(function(s) {
            return JSON.stringify(s) === JSON.stringify(filters);
        });
        if (existing !== -1) recentSearches.splice(existing, 1);
        recentSearches.unshift(filters);
        recentSearches = recentSearches.slice(0, 10);
        localStorage.setItem('cps_recent_searches', JSON.stringify(recentSearches));
        renderRecentSearches();
    }

    function getCurrentFilters() {
        return {
            keyword: $('#keyword').val(),
            type: $('#propertyType').val(),
            location: $('#propertyLocation').val(),
            min_price: $('#minPrice').val(),
            max_price: $('#maxPrice').val(),
            bedrooms: $('#bedrooms').val(),
            bathrooms: $('#bathrooms').val(),
            min_area: $('#minArea').val(),
            max_area: $('#maxArea').val(),
            status: $('.status-tab.active').data('status') || '',
            radius: $('#searchRadius').val(),
            radius_enabled: searchCircle !== null,
            features: getSelectedFeatures()
        };
    }

    function getSelectedFeatures() {
        const features = [];
        $('#featuresChecklist input:checked').each(function() {
            features.push($(this).val());
        });
        return features;
    }

    function applyFilters(filters) {
        $('#keyword').val(filters.keyword || '');
        $('#propertyType').val(filters.type || '');
        $('#propertyLocation').val(filters.location || '');
        $('#minPrice').val(filters.min_price || '');
        $('#maxPrice').val(filters.max_price || '');
        $('#bedrooms').val(filters.bedrooms || '');
        $('#bathrooms').val(filters.bathrooms || '');
        $('#minArea').val(filters.min_area || '');
        $('#maxArea').val(filters.max_area || '');
        $('#searchRadius').val(filters.radius || '5');

        if (filters.features && filters.features.length) {
            $('#featuresChecklist input').prop('checked', false);
            filters.features.forEach(function(feature) {
                $('#featuresChecklist input[value="' + feature + '"]').prop('checked', true);
            });
        }
    }

    function getFilterSummary(filters) {
        const parts = [];
        if (filters.keyword) parts.push('"' + filters.keyword + '"');
        if (filters.type) parts.push(filters.type);
        if (filters.location) parts.push(filters.location);
        if (filters.bedrooms) parts.push(filters.bedrooms + ' bed');
        if (filters.bathrooms) parts.push(filters.bathrooms + ' bath');
        if (filters.radius && filters.radius_enabled) parts.push(filters.radius + 'km');
        return parts.length > 0 ? parts.join(', ') : 'All';
    }

    function displayFilteredProperties(filtered) {
        const $container = $('#propertyResults');
        $('#resultsCount').text(filtered.length);

        if (filtered.length === 0) {
            $container.html('<div class="no-results"><p>No properties found in selected area</p></div>');
            return;
        }

        let html = '<div class="results-grid">';
        filtered.forEach(function(property) {
            const image = property.image || 'https://via.placeholder.com/400x300?text=No+Image';
            html += `
                <article class="result-card" data-id="${property.id}">
                    <a href="${property.permalink}">
                        <div class="card-image">
                            <img src="${image}" alt="${property.title}">
                            ${property.status_label ? '<span class="status-badge">' + property.status_label + '</span>' : ''}
                        </div>
                        <div class="card-content">
                            <h3>${property.title}</h3>
                            ${property.price ? '<p class="price">' + property.price + '</p>' : ''}
                            ${property.address ? '<p class="address"><i class="fas fa-map-marker-alt"></i> ' + property.address + '</p>' : ''}
                            <div class="card-specs">
                                ${property.bedrooms ? '<span><i class="fas fa-bed"></i> ' + property.bedrooms + '</span>' : ''}
                                ${property.bathrooms ? '<span><i class="fas fa-bath"></i> ' + property.bathrooms + '</span>' : ''}
                                ${property.sqft ? '<span><i class="fas fa-ruler-combined"></i> ' + property.sqft + '</span>' : ''}
                            </div>
                        </div>
                    </a>
                </article>
            `;
        });
        html += '</div>';
        $container.html(html);
        updateMarkersForFiltered(filtered);
    }

    function updateMarkersForFiltered(filtered) {
        clearMarkers();
        filtered.forEach(function(property) {
            if (!property.lat || !property.lng) return;
            const marker = new google.maps.Marker({
                position: { lat: parseFloat(property.lat), lng: parseFloat(property.lng) },
                map: map,
                title: property.title,
                icon: getMarkerIcon(property.status)
            });
            const infoWindow = new google.maps.InfoWindow({
                content: createInfoWindowContent(property)
            });
            marker.addListener('click', function() {
                closeAllInfoWindows();
                infoWindow.open(map, marker);
            });
            markers.push(marker);
            infoWindows.push(infoWindow);
        });
        if (markers.length > 0) {
            const bounds = new google.maps.LatLngBounds();
            markers.forEach(function(marker) { bounds.extend(marker.getPosition()); });
            map.fitBounds(bounds);
        }
    }

    function loadProperties(filters = {}) {
        const params = new URLSearchParams();
        if (filters.keyword) params.append('search', filters.keyword);
        if (filters.type) params.append('type', filters.type);
        if (filters.location) params.append('location', filters.location);
        if (filters.min_price) params.append('min_price', filters.min_price);
        if (filters.max_price) params.append('max_price', filters.max_price);
        if (filters.bedrooms) params.append('bedrooms', filters.bedrooms);
        if (filters.bathrooms) params.append('bathrooms', filters.bathrooms);
        if (filters.status) params.append('status', filters.status);

        const apiUrl = cpsData.ajaxUrl + '?action=cps_get_properties&' + params.toString();

        $.getJSON(apiUrl, function(data) {
            properties = data;
            updateMarkers();
            updateResults();
        }).fail(function() {
            $.getJSON('/wp-json/cps/v1/properties', function(data) {
                properties = data;
                updateMarkers();
                updateResults();
            });
        });
    }

    function updateMarkers() {
        clearMarkers();
        const newMarkers = [];

        properties.forEach(function(property) {
            if (!property.lat || !property.lng) return;
            const marker = new google.maps.Marker({
                position: { lat: parseFloat(property.lat), lng: parseFloat(property.lng) },
                map: map,
                title: property.title,
                icon: getMarkerIcon(property.status)
            });
            const infoWindow = new google.maps.InfoWindow({
                content: createInfoWindowContent(property)
            });
            marker.addListener('click', function() {
                closeAllInfoWindows();
                infoWindow.open(map, marker);
            });
            newMarkers.push(marker);
            infoWindows.push(infoWindow);
        });

        markers = newMarkers;

        if (markerCluster) {
            markerCluster.clearMarkers();
            markerCluster.addMarkers(markers);
        }

        if (markers.length > 0) {
            const bounds = new google.maps.LatLngBounds();
            markers.forEach(function(marker) { bounds.extend(marker.getPosition()); });
            map.fitBounds(bounds);
        }
    }

    function clearMarkers() {
        if (markerCluster) {
            markerCluster.clearMarkers();
        }
        markers.forEach(function(marker) { marker.setMap(null); });
        markers = [];
        infoWindows = [];
    }

    function closeAllInfoWindows() {
        infoWindows.forEach(function(iw) { iw.close(); });
    }

    function getMarkerIcon(status) {
        let color = '#2ecc71';
        if (status === 'for-rent') color = '#3498db';
        if (status === 'sold') color = '#e74c3c';
        if (status === 'pending') color = '#f39c12';
        return {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 10,
            fillColor: color,
            fillOpacity: 1,
            strokeColor: '#fff',
            strokeWeight: 2
        };
    }

    function createInfoWindowContent(property) {
        const image = property.image || 'https://via.placeholder.com/300x200?text=No+Image';
        return '<div class="map-info-window"><a href="' + property.permalink + '"><img src="' + image + '" alt="' + property.title + '"></a><div class="info-content"><h4><a href="' + property.permalink + '">' + property.title + '</a></h4>' + (property.price ? '<p class="price">' + property.price + '</p>' : '') + (property.address ? '<p class="address"><i class="fas fa-map-marker-alt"></i> ' + property.address + '</p>' : '') + '</div></div>';
    }

    function updateResults() {
        const $container = $('#propertyResults');
        if (properties.length === 0) {
            $container.html('<div class="no-results"><p>No properties found</p></div>');
            $('#resultsCount').text('0');
            return;
        }

        $('#resultsCount').text(properties.length);
        let html = '<div class="results-grid">';

        properties.forEach(function(property) {
            const image = property.image || 'https://via.placeholder.com/400x300?text=No+Image';
            html += '<article class="result-card" data-id="' + property.id + '"><a href="' + property.permalink + '"><div class="card-image"><img src="' + image + '" alt="' + property.title + '">' + (property.status_label ? '<span class="status-badge">' + property.status_label + '</span>' : '') + '</div><div class="card-content"><h3>' + property.title + '</h3>' + (property.price ? '<p class="price">' + property.price + '</p>' : '') + (property.address ? '<p class="address"><i class="fas fa-map-marker-alt"></i> ' + property.address + '</p>' : '') + '<div class="card-specs">' + (property.bedrooms ? '<span><i class="fas fa-bed"></i> ' + property.bedrooms + '</span>' : '') + (property.bathrooms ? '<span><i class="fas fa-bath"></i> ' + property.bathrooms + '</span>' : '') + (property.sqft ? '<span><i class="fas fa-ruler-combined"></i> ' + property.sqft + '</span>' : '') + '</div></div></a></article>';
        });

        html += '</div>';
        $container.html(html);

        $('.result-card').on('click', function() {
            const id = $(this).data('id');
            const property = properties.find(function(p) { return p.id === id; });
            if (property && property.lat && property.lng) {
                map.setCenter({ lat: parseFloat(property.lat), lng: parseFloat(property.lng) });
                map.setZoom(15);
                markers.forEach(function(marker, index) {
                    if (properties[index].id === id) {
                        google.maps.event.trigger(marker, 'click');
                    }
                });
            }
        });
    }

    function filterProperties() {
        const filters = getCurrentFilters();
        addToRecentSearches(filters);
        loadProperties(filters);
    }

    function clearFilters() {
        $('#propertySearchForm')[0].reset();
        $('.status-tab').removeClass('active').first().addClass('active');
        clearRadiusSearch();
        clearDrawShape();
        loadProperties();
    }

    function sortResults(sortBy) {
        const parts = sortBy.split('-');
        const field = parts[0];
        const order = parts[1];

        properties.sort(function(a, b) {
            let valA, valB;
            if (field === 'date') {
                valA = new Date(a.date).getTime();
                valB = new Date(b.date).getTime();
            } else if (field === 'price') {
                valA = parseFloat(a.price) || 0;
                valB = parseFloat(b.price) || 0;
            } else {
                valA = a.title || '';
                valB = b.title || '';
            }
            if (order === 'asc') return valA > valB ? 1 : -1;
            return valA < valB ? 1 : -1;
        });
        updateResults();
    }

    function toggleView(view) {
        $('.view-btn').removeClass('active');
        $('.view-btn[data-view="' + view + '"]').addClass('active');
        const $results = $('#propertyResults');
        $results.removeClass('grid-view list-view map-view');
        $results.addClass(view + '-view');
    }

    function showNotification(message, type) {
        const $notification = $('<div class="cps-notification ' + type + '">' + message + '</div>');
        $('body').append($notification);
        setTimeout(function() { $notification.fadeOut(function() { $(this).remove(); }); }, 3000);
    }

    $(document).ready(function() {
        if ($('#propertyMap').length) {
            if (typeof google !== 'undefined') {
                initMap();
            } else {
                const script = document.createElement('script');
                script.src = 'https://maps.googleapis.com/maps/api/js?key=' + (typeof googleMapsApiKey !== 'undefined' ? googleMapsApiKey : '') + '&libraries=drawing,geometry&callback=initMap';
                script.async = true;
                script.defer = true;
                document.head.appendChild(script);
                window.initMap = initMap;
            }
        }

        $('#propertySearchForm').on('submit', function(e) {
            e.preventDefault();
            filterProperties();
        });

        $('#clearSearch').on('click', clearFilters);

        $('.status-tab').on('click', function() {
            $('.status-tab').removeClass('active');
            $(this).addClass('active');
            filterProperties();
        });

        $('#toggleFeatures').on('click', function() {
            $('#featuresChecklist').slideToggle();
        });

        $('#sortBy').on('change', function() {
            sortResults($(this).val());
        });

        $('.view-btn').on('click', function() {
            toggleView($(this).data('view'));
        });

        $('#mapStyleToggle').on('click', function() {
            $('#mapStyleSelector').toggle();
        });

        $('.style-btn').on('click', function() {
            const style = $(this).data('style');
            map.setOptions({ styles: MAP_STYLES[style] || [] });
            $('.style-btn').removeClass('active');
            $(this).addClass('active');
            $('#mapStyleSelector').hide();
        });

        $('#fullscreenToggle').on('click', function() {
            const mapContainer = document.getElementById('propertyMap');
            if (!document.fullscreenElement) {
                mapContainer.requestFullscreen();
            } else {
                document.exitFullscreen();
            }
        });

        $('#recenterMap').on('click', function() {
            if (markers.length > 0) {
                const bounds = new google.maps.LatLngBounds();
                markers.forEach(function(marker) { bounds.extend(marker.getPosition()); });
                map.fitBounds(bounds);
            } else {
                map.setCenter(DEFAULT_CENTER);
                map.setZoom(11);
            }
        });

        $('#toggleSearch').on('click', function() {
            $('.search-panel').toggleClass('collapsed');
        });

        $('#useMyLocation').on('click', detectUserLocation);

        $('#radiusSearch').on('click', function() {
            if (userLocation) {
                const radius = parseFloat($('#searchRadius').val()) || 5;
                searchByRadius(userLocation.lat(), userLocation.lng(), radius);
            } else {
                detectUserLocation();
            }
        });

        $('#clearRadius').on('click', clearRadiusSearch);

        $('#drawPolygon').on('click', function() {
            if (drawingManager) drawingManager.setDrawingMode(google.maps.drawing.OverlayType.POLYGON);
        });

        $('#drawRectangle').on('click', function() {
            if (drawingManager) drawingManager.setDrawingMode(google.maps.drawing.OverlayType.RECTANGLE);
        });

        $('#clearDraw').on('click', clearDrawShape);

        $('#voiceSearch').on('click', toggleVoiceSearch);

        $('#saveSearchBtn').on('click', saveCurrentSearch);

        $(document).on('click', '.btn-load-search', function() {
            loadSavedSearch($(this).closest('.saved-search-item').data('id'));
        });

        $(document).on('click', '.btn-delete-search', function() {
            deleteSavedSearch($(this).closest('.saved-search-item').data('id'));
        });

        $(document).on('click', '.btn-alert-search', function() {
            toggleSearchAlert($(this).closest('.saved-search-item').data('id'));
        });

        $(document).on('click', '.recent-search-item', function() {
            const index = $(this).data('index');
            if (recentSearches[index]) {
                applyFilters(recentSearches[index]);
                filterProperties();
            }
        });

        $(document).on('click', '.btn-remove-recent', function(e) {
            e.stopPropagation();
            const index = $(this).closest('.recent-search-item').data('index');
            recentSearches.splice(index, 1);
            localStorage.setItem('cps_recent_searches', JSON.stringify(recentSearches));
            renderRecentSearches();
        });

        $('#clearRecent').on('click', function() {
            recentSearches = [];
            localStorage.setItem('cps_recent_searches', JSON.stringify(recentSearches));
            renderRecentSearches();
        });

        $('#toggleTransit').on('click', function() {
            if (window.cpsTransitLayer.getMap()) {
                window.cpsTransitLayer.setMap(null);
                $(this).removeClass('active');
            } else {
                window.cpsTransitLayer.setMap(map);
                $(this).addClass('active');
            }
        });

        $('#toggleBiking').on('click', function() {
            if (window.cpsBicyclingLayer.getMap()) {
                window.cpsBicyclingLayer.setMap(null);
                $(this).removeClass('active');
            } else {
                window.cpsBicyclingLayer.setMap(map);
                $(this).addClass('active');
            }
        });

        $('#streetViewToggle').on('click', function() {
            toggleStreetView();
        });

        $('#closeStreetView').on('click', function() {
            closeStreetView();
        });

        $('#schoolsToggle').on('click', function() {
            toggleSchoolsLayer();
        });

        $('#clusterToggle').on('click', function() {
            if (markerCluster) {
                if (markerCluster.getMarkers().length > 0) {
                    markerCluster.clearMarkers();
                    markers.forEach(function(marker) { marker.setMap(map); });
                    $(this).removeClass('active');
                } else {
                    markerCluster.addMarkers(markers);
                    markers.forEach(function(marker) { marker.setMap(null); });
                    $(this).addClass('active');
                }
            }
        });

        $('#findSchools').on('click', function() {
            const center = map.getCenter();
            if (center) {
                searchNearby('school', function(schools) {
                    displayNearbyPlaces(schools, 'school');
                    showNotification(schools.length + ' schools found nearby', 'success');
                });
            }
        });

        $('#findHospitals').on('click', function() {
            const center = map.getCenter();
            if (center) {
                searchNearby('hospital', function(hospitals) {
                    displayNearbyPlaces(hospitals, 'hospital');
                    showNotification(hospitals.length + ' hospitals found nearby', 'success');
                });
            }
        });

        $('#findTransit').on('click', function() {
            const center = map.getCenter();
            if (center) {
                searchNearby('transit_station', function(stations) {
                    displayNearbyPlaces(stations, 'transit');
                    showNotification(stations.length + ' transit stations found nearby', 'success');
                });
            }
        });

        $('#mapBoundsSearch').on('click', function() {
            const bounds = map.getBounds();
            if (bounds) {
                const filtered = properties.filter(function(property) {
                    if (!property.lat || !property.lng) return false;
                    return bounds.contains({ lat: parseFloat(property.lat), lng: parseFloat(property.lng) });
                });
                displayFilteredProperties(filtered);
                showNotification(filtered.length + ' properties in current map area', 'success');
            }
        });
    });

})(jQuery);
