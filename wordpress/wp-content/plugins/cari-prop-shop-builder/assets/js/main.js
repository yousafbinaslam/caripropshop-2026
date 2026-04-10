/**
 * CariPropShop Builder - Main JavaScript
 */

(function($) {
    'use strict';

    var CPSBuilder = window.CPSBuilder || {};

    CPSBuilder.init = function() {
        this.initPropertySlider();
        this.initStatsCounter();
        this.initContactForm();
        this.initMap();
        this.initTestimonialSlider();
        this.initSearchForm();
    };

    CPSBuilder.initPropertySlider = function() {
        $('.cps-property-slider').each(function() {
            var $slider = $(this);
            var config = JSON.parse($slider.data('slider-config') || '{}');

            if ($slider.hasClass('slick-initialized')) {
                return;
            }

            $slider.slick({
                slidesToShow: config.slidesToShow || 3,
                slidesToScroll: config.slidesToScroll || 1,
                autoplay: config.autoplay || true,
                autoplaySpeed: config.autoplaySpeed || 3000,
                pauseOnHover: config.pauseOnHover !== false,
                infinite: config.infinite !== false,
                arrows: config.arrows !== false,
                dots: config.dots !== false,
                centerMode: config.centerMode || false,
                responsive: config.responsive || [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

            $slider.addClass('slick-initialized');
        });
    };

    CPSBuilder.initTestimonialSlider = function() {
        $('.cps-testimonial-slider').each(function() {
            var $slider = $(this);
            var slides = parseInt($slider.data('slides')) || 2;
            var autoplay = $slider.data('autoplay') !== 'no';
            var speed = parseInt($slider.data('speed')) || 5000;

            if ($slider.hasClass('slick-initialized')) {
                return;
            }

            $slider.slick({
                slidesToShow: slides,
                slidesToScroll: 1,
                autoplay: autoplay,
                autoplaySpeed: speed,
                pauseOnHover: true,
                infinite: true,
                arrows: true,
                dots: true,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

            $slider.addClass('slick-initialized');
        });
    };

    CPSBuilder.initStatsCounter = function() {
        $('.cps-stat-item').each(function() {
            var $item = $(this);
            var $number = $item.find('.cps-stat-number');
            var targetNumber = $number.data('number');
            var duration = parseInt($number.data('duration')) || 2000;

            if (!targetNumber && targetNumber !== 0) {
                return;
            }

            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var start = 0;
                        var end = parseInt(targetNumber);
                        var stepTime = Math.abs(duration / end);
                        var timer = setInterval(function() {
                            start += 1;
                            $number.text(start);
                            if (start >= end) {
                                clearInterval(timer);
                            }
                        }, stepTime);

                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });

            observer.observe($item[0]);
        });
    };

    CPSBuilder.initContactForm = function() {
        $('.cps-contact-form').on('submit', function(e) {
            e.preventDefault();

            var $form = $(this);
            var $response = $form.find('.cps-form-response');
            var formData = $form.serialize();

            $response.removeClass('success error').hide();

            $.ajax({
                url: cpsBuilderAjax.ajaxUrl,
                type: 'POST',
                data: formData + '&action=cps_property_inquiry&nonce=' + cpsBuilderAjax.nonce,
                beforeSend: function() {
                    $form.find('.cps-submit-btn').prop('disabled', true).text('Sending...');
                },
                success: function(response) {
                    if (response.success) {
                        $response.addClass('success').html(response.data.message).show();
                        $form[0].reset();
                    } else {
                        $response.addClass('error').html(response.data.message || 'An error occurred. Please try again.').show();
                    }
                },
                error: function() {
                    $response.addClass('error').html('An error occurred. Please try again.').show();
                },
                complete: function() {
                    $form.find('.cps-submit-btn').prop('disabled', false).text('Send Message');
                }
            });
        });
    };

    CPSBuilder.initMap = function() {
        $('.cps-map-container').each(function() {
            var $map = $(this);
            var provider = $map.data('provider');
            var markers = $map.find('.cps-map-markers');
            var showTooltip = $map.data('show-tooltip') !== 'no';
            var zoom = parseInt($map.data('zoom')) || 12;
            var style = $map.data('map-style') || 'default';

            if (provider === 'google') {
                initGoogleMap($map, markers, showTooltip, zoom, style);
            } else if (provider === 'mapbox') {
                initMapboxMap($map, markers, showTooltip, zoom, style);
            }
        });

        function initGoogleMap($container, $markers, showTooltip, zoom, style) {
            var googleApiKey = cpsBuilderAjax.googleMapsApiKey || '';
            if (!googleApiKey) {
                $container.find('.cps-map-placeholder').show();
                return;
            }

            var mapStyle = getGoogleMapStyle(style);
            var markerData = [];

            $markers.find('.cps-map-marker').each(function() {
                markerData.push({
                    lat: $(this).data('lat'),
                    lng: $(this).data('lng'),
                    title: $(this).data('title'),
                    price: $(this).data('price'),
                    address: $(this).data('address'),
                    image: $(this).data('image'),
                    url: $(this).data('url')
                });
            });

            if (markerData.length === 0) {
                return;
            }

            var center = { lat: parseFloat(markerData[0].lat), lng: parseFloat(markerData[0].lng) };

            $.ajax({
                url: 'https://maps.googleapis.com/maps/api/js?key=' + googleApiKey + '&callback=initMap',
                dataType: 'script',
                cache: true,
                success: function() {
                    var map = new google.maps.Map($container[0], {
                        center: center,
                        zoom: zoom,
                        styles: mapStyle,
                        disableDefaultUI: true
                    });

                    markerData.forEach(function(data) {
                        var marker = new google.maps.Marker({
                            position: { lat: parseFloat(data.lat), lng: parseFloat(data.lng) },
                            map: map,
                            title: data.title
                        });

                        if (showTooltip) {
                            var infoWindow = new google.maps.InfoWindow({
                                content: '<div class="cps-map-info">' +
                                    (data.image ? '<img src="' + data.image + '" alt="' + data.title + '">' : '') +
                                    '<h4>' + data.title + '</h4>' +
                                    (data.address ? '<p>' + data.address + '</p>' : '') +
                                    (data.price ? '<span>' + data.price + '</span>' : '') +
                                    (data.url ? '<a href="' + data.url + '">View Details</a>' : '') +
                                    '</div>'
                            });

                            marker.addListener('click', function() {
                                infoWindow.open(map, marker);
                            });
                        }
                    });
                }
            });
        }

        function initMapboxMap($container, $markers, showTooltip, zoom, style) {
            var mapboxToken = cpsBuilderAjax.mapboxToken || '';
            if (!mapboxToken) {
                $container.find('.cps-map-placeholder').show();
                return;
            }

            var markerData = [];

            $markers.find('.cps-map-marker').each(function() {
                markerData.push({
                    lat: $(this).data('lat'),
                    lng: $(this).data('lng'),
                    title: $(this).data('title'),
                    price: $(this).data('price'),
                    address: $(this).data('address'),
                    url: $(this).data('url')
                });
            });

            if (markerData.length === 0) {
                return;
            }

            mapboxgl.accessToken = mapboxToken;

            var map = new mapboxgl.Map({
                container: $container[0],
                style: 'mapbox://styles/mapbox/' + style + '-v10',
                center: [parseFloat(markerData[0].lng), parseFloat(markerData[0].lat)],
                zoom: zoom
            });

            map.on('load', function() {
                markerData.forEach(function(data) {
                    var el = document.createElement('div');
                    el.className = 'cps-map-marker-custom';
                    el.innerHTML = data.price ? '<span>' + data.price + '</span>' : '<i class="eicon-map-marker"></i>';

                    new mapboxgl.Marker(el)
                        .setLngLat([parseFloat(data.lng), parseFloat(data.lat)])
                        .addTo(map);
                });
            });
        }

        function getGoogleMapStyle(style) {
            var styles = {
                default: [],
                silver: [{"elementType":"geometry","stylers":[{"color":"#f5f5f5"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#f5f5f5"}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#c9c9c9"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#bdbdbd"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c8e6c9"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#388e3c"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#ffffff"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#dadada"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#c9c9c9"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]}],
                retro: [{"elementType":"geometry","stylers":[{"color":"#ebe3cd"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#523735"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#f5f1e6"}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#c3b78a"}]},{"featureType":"landscape.nature","elementType":"geometry","stylers":[{"color":"#c8e6c9"}]},{"featureType":"landscape.nature","elementType":"labels.text.fill","stylers":[{"color":"#448d4e"}]},{"featureType":"landscape.nature.landcover","elementType":"geometry","stylers":[{"color":"#c8e6c9"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#c8e6c9"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#448d4e"}]},{"featureType":"poi.medical","elementType":"geometry","stylers":[{"color":"#e0e0e0"}]},{"featureType":"poi.medical","elementType":"labels.text.fill","stylers":[{"color":"#b0a5a5"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#a5d6a7"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#1b5e20"}]},{"featureType":"poi.school","elementType":"geometry","stylers":[{"color":"#c8e6c9"}]},{"featureType":"poi.school","elementType":"labels.text.fill","stylers":[{"color":"#1b5e20"}]},{"featureType":"poi.sports_complex","elementType":"geometry","stylers":[{"color":"#c8e6c9"}]},{"featureType":"poi.sports_complex","elementType":"labels.text.fill","stylers":[{"color":"#1b5e20"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#f5f1e6"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#c9b89a"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#c8e6c9"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c8e6c9"}]},{"featureType":"road.highway.controlled_access","elementType":"geometry","stylers":[{"color":"#93c5d9"}]},{"featureType":"road.highway.controlled_access","elementType":"labels.text.fill","stylers":[{"color":"#1b5e20"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#645b52"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#c8e6c9"}]},{"featureType":"transit.line","elementType":"labels.text.fill","stylers":[{"color":"#8e9d82"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#b8d0d4"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#4f6877"}]}],
                dark: [{"elementType":"geometry","stylers":[{"color":"#212121"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#212121"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"color":"#757575"}]},{"featureType":"administrative.country","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.fill","stylers":[{"color":"#bdbdbd"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#303030"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#181818"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"featureType":"poi.park","elementType":"labels.text.stroke","stylers":[{"color":"#1b1b1b"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"color":"#2f2f2f"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#8a8a8a"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#373737"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#3c3c3c"}]},{"featureType":"road.highway.controlled_access","elementType":"geometry","stylers":[{"color":"#4e4e4e"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"featureType":"transit","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#3d3d3d"}]}],
                night: [{"elementType":"geometry","stylers":[{"color":"#242f3e"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#746855"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#242f3e"}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#192a27"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.fill","stylers":[{"color":"#43515e3"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#283d6a"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#6f9ba5"}]},{"featureType":"poi","elementType":"labels.text.stroke","stylers":[{"color":"#1d2c4d"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#263d3f"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#6b9aa0"}]},{"featureType":"poi.park","elementType":"labels.text.stroke","stylers":[{"color":"#192d30"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#2f2f2f"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#9caed3"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#242f3e"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#3a3a3a"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#f3d19c"}]},{"featureType":"road.highway.controlled_access","elementType":"geometry","stylers":[{"color":"#7e7e7e"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#283d6a"}]},{"featureType":"transit","elementType":"labels.text.fill","stylers":[{"color":"#8caed3"}]},{"featureType":"transit","elementType":"labels.text.stroke","stylers":[{"color":"#1d2c4d"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#17263c"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#515c6d"}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"color":"#17263c"}]}]
            };

            return styles[style] || styles.default;
        }
    };

    CPSBuilder.initSearchForm = function() {
        $('.cps-search-form').each(function() {
            var $form = $(this);

            $form.find('.cps-search-select').on('change', function() {
                var $field = $(this).closest('.cps-search-field');
                if ($(this).val()) {
                    $field.addClass('active');
                } else {
                    $field.removeClass('active');
                }
            });
        });
    };

    $(document).ready(function() {
        CPSBuilder.init();
    });

})(jQuery);