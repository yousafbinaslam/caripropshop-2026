/**
 * CariPropShop Main JavaScript
 * Interactive functionality for the theme
 */

(function($) {
    'use strict';

    const CPS = {
        init: function() {
            this.cacheDom();
            this.bindEvents();
            this.initModules();
        },

        cacheDom: function() {
            this.$body = $('body');
            this.$window = $(window);
            this.$header = $('.site-header');
            this.$mobileMenuBtn = $('.mobile-menu-toggle');
            this.$searchBtn = $('.search-toggle');
            this.$favBtns = $('.favorite-btn');
            this.$compareBtns = $('.compare-btn');
            this.$toastContainer = null;
        },

        bindEvents: function() {
            // Mobile menu
            this.$body.on('click', '.mobile-menu-toggle', this.toggleMobileMenu.bind(this));
            this.$body.on('click', '.close-mobile-menu', this.closeMobileMenu.bind(this));
            
            // Search
            this.$body.on('click', '.search-toggle', this.toggleSearch.bind(this));
            this.$body.on('submit', '.header-search-form', this.handleSearch.bind(this));
            
            // Favorites
            this.$body.on('click', '.favorite-btn', this.toggleFavorite.bind(this));
            
            // Compare
            this.$body.on('click', '.compare-btn', this.toggleCompare.bind(this));
            this.$body.on('click', '.remove-compare', this.removeFromCompare.bind(this));
            
            // Property filters
            this.$body.on('change', '.property-filter', this.handleFilterChange.bind(this));
            this.$body.on('click', '.filter-toggle', this.toggleFilters.bind(this));
            
            // Forms
            this.$body.on('submit', '.ajax-form', this.handleAjaxForm.bind(this));
            this.$body.on('click', '.submit-contact-form', this.submitContactForm.bind(this));
            
            // Tabs
            this.$body.on('click', '.cps-tabs a', this.handleTabClick.bind(this));
            
            // Modal
            this.$body.on('click', '.modal-trigger', this.openModal.bind(this));
            this.$body.on('click', '.modal-close, .modal-overlay', this.closeModal.bind(this));
            
            // Lazy loading images
            this.$window.on('scroll', this.lazyLoadImages.bind(this));
            
            // Scroll effects
            this.$window.on('scroll', this.handleScroll.bind(this));
            
            // Price slider
            this.$body.on('input', '.price-slider', this.updatePriceDisplay.bind(this));
            
            // Mortgage calculator
            this.$body.on('input', '.mortgage-input', this.calculateMortgage.bind(this));
            
            // Gallery lightbox
            this.$body.on('click', '.gallery-item', this.openGallery.bind(this));
            this.$body.on('click', '.lightbox-close', this.closeGallery.bind(this));
            this.$body.on('click', '.lightbox-nav', this.galleryNav.bind(this));
            
            // Share buttons
            this.$body.on('click', '.share-btn', this.handleShare.bind(this));
            
            // Map interactions
            this.$body.on('click', '.map-refresh', this.refreshMap.bind(this));
            this.$body.on('change', '.map-style-select', this.changeMapStyle.bind(this));
            
            // Infinite scroll
            this.$window.on('scroll', this.checkInfiniteScroll.bind(this));
        },

        initModules: function() {
            this.createToastContainer();
            this.initTooltips();
            this.initDropdowns();
            this.initPriceSliders();
            this.initMap();
            this.initCompareBar();
        },

        // Mobile Menu
        toggleMobileMenu: function(e) {
            e.preventDefault();
            const $menu = $('.mobile-navigation');
            const $btn = $(e.currentTarget);
            
            $btn.toggleClass('active');
            $menu.toggleClass('active');
            this.$body.toggleClass('mobile-menu-open');
            
            if ($menu.hasClass('active')) {
                $menu.slideDown(300);
            } else {
                $menu.slideUp(300);
            }
        },

        closeMobileMenu: function() {
            $('.mobile-navigation').removeClass('active').slideUp(300);
            this.$body.removeClass('mobile-menu-open');
            $('.mobile-menu-toggle').removeClass('active');
        },

        // Search
        toggleSearch: function(e) {
            e.preventDefault();
            const $search = $('.header-search');
            $search.toggleClass('active');
            $search.find('input').focus();
        },

        handleSearch: function(e) {
            e.preventDefault();
            const $form = $(e.currentTarget);
            const query = $form.find('input').val();
            const searchType = $form.find('select[name="post_type"]').val() || 'property';
            
            if (query.length < 2) {
                this.showToast('Please enter at least 2 characters', 'error');
                return;
            }
            
            window.location.href = cpsData.homeUrl + '?s=' + encodeURIComponent(query) + '&post_type=' + searchType;
        },

        // Favorites
        toggleFavorite: function(e) {
            e.preventDefault();
            const $btn = $(e.currentTarget);
            const propertyId = $btn.data('property-id');
            const $icon = $btn.find('i');
            const isFavorited = $btn.hasClass('favorited');
            const action = isFavorited ? 'cps_remove_favorite' : 'cps_add_favorite';
            
            $.ajax({
                url: cpsData.ajaxUrl,
                type: 'POST',
                data: {
                    action: action,
                    property_id: propertyId,
                    nonce: cpsData.nonce
                },
                beforeSend: () => {
                    $btn.addClass('loading');
                },
                success: (response) => {
                    if (response.success) {
                        $btn.toggleClass('favorited');
                        if ($icon.hasClass('far')) {
                            $icon.removeClass('far').addClass('fas');
                        } else {
                            $icon.removeClass('fas').addClass('far');
                        }
                        this.showToast(response.data.message, 'success');
                        this.updateFavoritesCount();
                    } else {
                        if (response.data.require_login) {
                            window.location.href = cpsData.homeUrl + 'login/?redirect=' + encodeURIComponent(window.location.href);
                        } else {
                            this.showToast(response.data.message, 'error');
                        }
                    }
                },
                error: () => {
                    this.showToast('An error occurred', 'error');
                },
                complete: () => {
                    $btn.removeClass('loading');
                }
            });
        },

        updateFavoritesCount: function() {
            const $count = $('.favorites-count');
            if ($count.length) {
                const current = parseInt($count.text()) || 0;
                if ($('.favorite-btn.favorited').length > $('.favorite-btn:not(.favorited)').length) {
                    $count.text(current + 1);
                } else {
                    $count.text(Math.max(0, current - 1));
                }
            }
        },

        // Compare
        toggleCompare: function(e) {
            e.preventDefault();
            const $btn = $(e.currentTarget);
            const propertyId = $btn.data('property-id');
            const isAdded = $btn.hasClass('added');
            const action = isAdded ? 'cps_compare_remove' : 'cps_compare_add';
            
            $.ajax({
                url: cpsData.ajaxUrl,
                type: 'POST',
                data: {
                    action: action,
                    property_id: propertyId,
                    nonce: cpsData.nonce
                },
                success: (response) => {
                    if (response.success) {
                        $btn.toggleClass('added');
                        this.updateCompareBar();
                        this.showToast(response.data.message, 'success');
                    } else {
                        this.showToast(response.data.message, 'error');
                    }
                }
            });
        },

        removeFromCompare: function(e) {
            e.preventDefault();
            const $item = $(e.currentTarget).closest('.compare-item');
            const propertyId = $item.data('property-id');
            
            $.ajax({
                url: cpsData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'cps_remove_compare',
                    property_id: propertyId,
                    nonce: cpsData.nonce
                },
                success: (response) => {
                    if (response.success) {
                        $item.remove();
                        this.updateCompareBar();
                        $('.compare-btn[data-property-id="' + propertyId + '"]').removeClass('added');
                    }
                }
            });
        },

        updateCompareBar: function() {
            const compareList = JSON.parse(sessionStorage.getItem('cps_compare') || '[]');
            const $bar = $('.compare-bar');
            const $list = $bar.find('.compare-items');
            
            if (compareList.length > 0) {
                $bar.addClass('active');
                $list.empty();
                compareList.forEach(item => {
                    $list.append('<div class="compare-item" data-property-id="' + item.id + '">' +
                        '<img src="' + item.thumb + '" alt="">' +
                        '<button class="remove-compare">&times;</button></div>');
                });
            } else {
                $bar.removeClass('active');
            }
        },

        initCompareBar: function() {
            this.updateCompareBar();
        },

        // Filters
        handleFilterChange: function(e) {
            const $filter = $(e.currentTarget);
            const value = $filter.val();
            const filterName = $filter.attr('name');
            
            this.applyFilters();
        },

        toggleFilters: function(e) {
            e.preventDefault();
            const $filters = $('.property-filters');
            const $btn = $(e.currentTarget);
            
            $btn.toggleClass('active');
            $filters.slideToggle(300);
        },

        applyFilters: function() {
            const filters = {};
            $('.property-filter').each(function() {
                const $this = $(this);
                const name = $this.attr('name');
                let value = $this.val();
                
                if ($this.attr('type') === 'checkbox') {
                    value = $this.is(':checked') ? 1 : '';
                }
                
                if (value) {
                    filters[name] = value;
                }
            });
            
            filters.action = 'cps_filter_properties';
            filters.nonce = cpsData.nonce;
            
            this.filterProperties(filters);
        },

        filterProperties: function(filters) {
            const $grid = $('.property-grid');
            const $loader = $('.property-loader');
            
            $.ajax({
                url: cpsData.ajaxUrl,
                type: 'POST',
                data: filters,
                beforeSend: () => {
                    $grid.addClass('loading');
                    $loader.show();
                },
                success: (response) => {
                    if (response.success) {
                        $grid.html(response.data.html);
                        this.updateResultsCount(response.data.count);
                    }
                },
                error: () => {
                    this.showToast('Error loading properties', 'error');
                },
                complete: () => {
                    $grid.removeClass('loading');
                    $loader.hide();
                }
            });
        },

        updateResultsCount: function(count) {
            const $count = $('.results-count');
            if ($count.length) {
                $count.text(count + ' properties found');
            }
        },

        // Forms
        handleAjaxForm: function(e) {
            e.preventDefault();
            const $form = $(e.currentTarget);
            
            $.ajax({
                url: cpsData.ajaxUrl,
                type: 'POST',
                data: $form.serialize(),
                beforeSend: () => {
                    $form.find('button[type="submit"]').addClass('loading').prop('disabled', true);
                },
                success: (response) => {
                    if (response.success) {
                        this.showToast(response.data.message, 'success');
                        $form[0].reset();
                        if (response.data.redirect) {
                            window.location.href = response.data.redirect;
                        }
                    } else {
                        this.showToast(response.data.message, 'error');
                    }
                },
                error: () => {
                    this.showToast('An error occurred', 'error');
                },
                complete: () => {
                    $form.find('button[type="submit"]').removeClass('loading').prop('disabled', false);
                }
            });
        },

        submitContactForm: function(e) {
            e.preventDefault();
            const $form = $(e.currentTarget).closest('form');
            
            const formData = {
                action: 'cps_submit_contact',
                nonce: cpsData.nonce,
                name: $form.find('[name="name"]').val(),
                email: $form.find('[name="email"]').val(),
                phone: $form.find('[name="phone"]').val(),
                subject: $form.find('[name="subject"]').val(),
                message: $form.find('[name="message"]').val(),
                property_id: $form.find('[name="property_id"]').val() || ''
            };
            
            if (!formData.name || !formData.email || !formData.message) {
                this.showToast('Please fill in all required fields', 'error');
                return;
            }
            
            $.ajax({
                url: cpsData.ajaxUrl,
                type: 'POST',
                data: formData,
                beforeSend: () => {
                    $(e.currentTarget).addClass('loading').prop('disabled', true);
                },
                success: (response) => {
                    if (response.success) {
                        this.showToast(response.data.message, 'success');
                        $form[0].reset();
                    } else {
                        this.showToast(response.data.message, 'error');
                    }
                },
                error: () => {
                    this.showToast('An error occurred', 'error');
                },
                complete: () => {
                    $(e.currentTarget).removeClass('loading').prop('disabled', false);
                }
            });
        },

        // Tabs
        handleTabClick: function(e) {
            e.preventDefault();
            const $tab = $(e.currentTarget);
            const $tabs = $tab.closest('.cps-tabs');
            const target = $tab.attr('href');
            
            $tabs.find('a').removeClass('active');
            $tab.addClass('active');
            
            $tabs.next('.cps-tabs-content').find('.tab-pane').removeClass('active');
            $(target).addClass('active');
        },

        // Modal
        openModal: function(e) {
            e.preventDefault();
            const target = $(e.currentTarget).data('modal');
            const $modal = $('#' + target);
            
            if ($modal.length) {
                $modal.addClass('active');
                this.$body.addClass('modal-open');
            }
        },

        closeModal: function(e) {
            const $modal = $(e.currentTarget).closest('.modal');
            $modal.removeClass('active');
            this.$body.removeClass('modal-open');
        },

        // Scroll effects
        handleScroll: function() {
            const scrollTop = this.$window.scrollTop();
            
            // Header scroll effect
            if (scrollTop > 100) {
                this.$header.addClass('scrolled');
            } else {
                this.$header.removeClass('scrolled');
            }
            
            // Back to top button
            const $backToTop = $('.back-to-top');
            if (scrollTop > 500) {
                $backToTop.addClass('visible');
            } else {
                $backToTop.removeClass('visible');
            }
        },

        // Price Slider
        updatePriceDisplay: function(e) {
            const value = $(e.currentTarget).val();
            const $display = $(e.currentTarget).siblings('.price-value');
            if ($display.length) {
                $display.text(this.formatPrice(value));
            }
        },

        initPriceSliders: function() {
            $('.price-range-slider').each(function() {
                const $slider = $(this);
                const $min = $slider.find('.min-price');
                const $max = $slider.find('.max-price');
                const $minVal = $slider.find('input[name="min_price"]');
                const $maxVal = $slider.find('input[name="max_price"]');
                
                noUiSlider.create(this, {
                    start: [parseInt($minVal.val()) || 0, parseInt($maxVal.val()) || 10000000000],
                    connect: true,
                    range: {
                        'min': 0,
                        'max': 10000000000
                    },
                    format: {
                        to: value => Math.round(value),
                        from: value => Math.round(value)
                    }
                });
                
                this.noUiSlider.on('update', (values) => {
                    $min.text(CPS.formatPrice(values[0]));
                    $max.text(CPS.formatPrice(values[1]));
                    $minVal.val(values[0]);
                    $maxVal.val(values[1]);
                });
            });
        },

        // Mortgage Calculator
        calculateMortgage: function() {
            const principal = parseFloat($('[name="loan_amount"]').val()) || 0;
            const rate = parseFloat($('[name="interest_rate"]').val()) || 0;
            const years = parseFloat($('[name="loan_term"]').val()) || 0;
            
            if (principal && rate && years) {
                const monthlyRate = rate / 100 / 12;
                const numPayments = years * 12;
                const monthlyPayment = principal * (monthlyRate * Math.pow(1 + monthlyRate, numPayments)) / 
                                       (Math.pow(1 + monthlyRate, numPayments) - 1);
                
                const totalPayment = monthlyPayment * numPayments;
                const totalInterest = totalPayment - principal;
                
                $('.monthly-payment').text(this.formatPrice(Math.round(monthlyPayment)));
                $('.total-payment').text(this.formatPrice(Math.round(totalPayment)));
                $('.total-interest').text(this.formatPrice(Math.round(totalInterest)));
            }
        },

        // Gallery Lightbox
        openGallery: function(e) {
            const $item = $(e.currentTarget);
            const $gallery = $item.closest('.property-gallery');
            const images = [];
            
            $gallery.find('.gallery-item').each(function() {
                images.push({
                    src: $(this).data('full') || $(this).attr('href'),
                    thumb: $(this).find('img').attr('src')
                });
            });
            
            const currentIndex = $gallery.find('.gallery-item').index($item);
            
            this.galleryImages = images;
            this.currentGalleryIndex = currentIndex;
            
            this.showGalleryImage(currentIndex);
            this.$body.addClass('lightbox-open');
            $('#gallery-lightbox').addClass('active');
        },

        showGalleryImage: function(index) {
            const $lightbox = $('#gallery-lightbox');
            const image = this.galleryImages[index];
            
            $lightbox.find('.lightbox-image').attr('src', image.src);
            $lightbox.find('.lightbox-counter').text((index + 1) + ' / ' + this.galleryImages.length);
            
            this.currentGalleryIndex = index;
        },

        galleryNav: function(e) {
            const direction = $(e.currentTarget).data('direction');
            let newIndex = this.currentGalleryIndex;
            
            if (direction === 'prev') {
                newIndex = (newIndex - 1 + this.galleryImages.length) % this.galleryImages.length;
            } else {
                newIndex = (newIndex + 1) % this.galleryImages.length;
            }
            
            this.showGalleryImage(newIndex);
        },

        closeGallery: function() {
            this.$body.removeClass('lightbox-open');
            $('#gallery-lightbox').removeClass('active');
        },

        // Share
        handleShare: function(e) {
            e.preventDefault();
            const $btn = $(e.currentTarget);
            const platform = $btn.data('platform');
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent(document.title);
            let shareUrl = '';
            
            switch (platform) {
                case 'facebook':
                    shareUrl = 'https://www.facebook.com/sharer/sharer.php?u=' + url;
                    break;
                case 'twitter':
                    shareUrl = 'https://twitter.com/intent/tweet?url=' + url + '&text=' + title;
                    break;
                case 'whatsapp':
                    shareUrl = 'https://wa.me/?text=' + title + '%20' + url;
                    break;
                case 'telegram':
                    shareUrl = 'https://t.me/share/url?url=' + url + '&text=' + title;
                    break;
                case 'linkedin':
                    shareUrl = 'https://www.linkedin.com/shareArticle?mini=true&url=' + url + '&title=' + title;
                    break;
                case 'email':
                    shareUrl = 'mailto:?subject=' + title + '&body=' + url;
                    break;
                case 'copy':
                    this.copyToClipboard(window.location.href);
                    return;
            }
            
            if (shareUrl) {
                window.open(shareUrl, '_blank', 'width=600,height=400');
            }
        },

        copyToClipboard: function(text) {
            navigator.clipboard.writeText(text).then(() => {
                this.showToast('Link copied to clipboard', 'success');
            }).catch(() => {
                this.showToast('Failed to copy link', 'error');
            });
        },

        // Map
        initMap: function() {
            if (typeof google === 'undefined' && !$('.property-map').data('map-ready')) {
                return;
            }
            $('.property-map').data('map-ready', true);
        },

        refreshMap: function() {
            this.$body.trigger('cps_map_refresh');
        },

        changeMapStyle: function(e) {
            const style = $(e.currentTarget).val();
            this.$body.trigger('cps_map_style_change', [style]);
        },

        // Infinite Scroll
        checkInfiniteScroll: function() {
            if ($('.infinite-scroll').length) {
                const $trigger = $('.infinite-scroll-trigger');
                if ($trigger.length && $trigger.is(':in-viewport')) {
                    this.loadMoreProperties();
                }
            }
        },

        loadMoreProperties: function() {
            const $trigger = $('.infinite-scroll-trigger');
            if ($trigger.hasClass('loading')) return;
            
            const nextPage = parseInt($trigger.data('page')) + 1;
            const maxPages = parseInt($trigger.data('max'));
            
            if (nextPage > maxPages) return;
            
            $trigger.addClass('loading');
            
            $.ajax({
                url: cpsData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'cps_load_more_properties',
                    page: nextPage,
                    nonce: cpsData.nonce
                },
                success: (response) => {
                    if (response.success) {
                        $('.property-grid').append(response.data.html);
                        $trigger.data('page', nextPage);
                        if (nextPage >= maxPages) {
                            $trigger.hide();
                        }
                    }
                },
                complete: () => {
                    $trigger.removeClass('loading');
                }
            });
        },

        // Lazy Loading
        lazyLoadImages: function() {
            $('.lazy-load').each(function() {
                const $img = $(this);
                if ($img.is(':in-viewport') && !$img.hasClass('loaded')) {
                    $img.attr('src', $img.data('src')).addClass('loaded');
                }
            });
        },

        // Tooltips
        initTooltips: function() {
            $('[data-tooltip]').hover(function(e) {
                const text = $(this).data('tooltip');
                if (!$('#tooltip-box').length) {
                    $('body').append('<div id="tooltip-box"></div>');
                }
                $('#tooltip-box').text(text).addClass('visible');
            }, function() {
                $('#tooltip-box').removeClass('visible');
            });
        },

        // Dropdowns
        initDropdowns: function() {
            this.$body.on('click', '.dropdown-toggle', function(e) {
                e.preventDefault();
                $(this).siblings('.dropdown-menu').toggleClass('show');
            });
            
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.dropdown').length) {
                    $('.dropdown-menu').removeClass('show');
                }
            });
        },

        // Toast Notifications
        createToastContainer: function() {
            if (!this.$toastContainer) {
                this.$toastContainer = $('<div class="cps-toast-container"></div>');
                this.$body.append(this.$toastContainer);
            }
        },

        showToast: function(message, type = 'info') {
            const $toast = $('<div class="cps-toast toast-' + type + '">' + message + '</div>');
            this.$toastContainer.append($toast);
            
            setTimeout(() => $toast.addClass('show'), 10);
            
            setTimeout(() => {
                $toast.removeClass('show');
                setTimeout(() => $toast.remove(), 300);
            }, 4000);
        },

        // Utilities
        formatPrice: function(price) {
            return 'Rp ' + parseInt(price).toLocaleString('id-ID');
        },

        debounce: function(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }
    };

    $(document).ready(function() {
        CPS.init();
    });

    window.CPS = CPS;

})(jQuery);
