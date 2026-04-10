(function($) {
    'use strict';

    var CPSCookieBanner = {
        init: function() {
            this.cacheDOM();
            this.bindEvents();
            this.applyCustomStyles();
        },

        cacheDOM: function() {
            this.$banner = $('#cps-cookie-banner');
            this.$modal = $('#cps-cookie-modal');
            this.$settingsLink = $('#cps-cookie-settings-link');
            this.$acceptBtn = $('#cps-accept-all');
            this.$rejectBtn = $('#cps-reject-all');
            this.$settingsBtn = $('#cps-show-settings');
            this.$closeSettingsBtn = $('#cps-close-settings');
            this.$savePreferencesBtn = $('#cps-save-preferences');
            this.$categoryToggles = $('.cps-category-toggle input[data-category]');
            this.$modalToggles = {
                analytics: $('#cps-analytics-toggle'),
                marketing: $('#cps-marketing-toggle'),
                functional: $('#cps-functional-toggle')
            };
        },

        bindEvents: function() {
            this.$acceptBtn.on('click', $.proxy(this.acceptAll, this));
            this.$rejectBtn.on('click', $.proxy(this.rejectAll, this));
            this.$settingsBtn.on('click', $.proxy(this.showSettings, this));
            this.$closeSettingsBtn.on('click', $.proxy(this.hideSettings, this));
            this.$savePreferencesBtn.on('click', $.proxy(this.savePreferences, this));

            $(document).on('click', '.cps-settings-link', function(e) {
                e.preventDefault();
                CPSCookieBanner.showSettings();
            });

            this.$categoryToggles.on('change', $.proxy(this.onCategoryToggle, this));

            this.$modal.on('click', function(e) {
                if ($(e.target).is(CPSCookieBanner.$modal)) {
                    CPSCookieBanner.hideSettings();
                }
            });

            $(document).keyup(function(e) {
                if (e.keyCode === 27) {
                    CPSCookieBanner.hideSettings();
                }
            });
        },

        applyCustomStyles: function() {
            if (cpsCookieData && cpsCookieData.settings) {
                var settings = cpsCookieData.settings;
                var $style = $('#cps-cookie-custom-styles');

                if (!$style.length) {
                    $style = $('<style id="cps-cookie-custom-styles">');
                    $('head').append($style);
                }

                var css = '';
                var position = settings.position || 'bottom';

                if (settings.theme === 'dark') {
                    css += '#cps-cookie-banner { background: #1f2937; } ';
                    css += '#cps-cookie-banner .cps-cookie-content h2 { color: #ffffff; } ';
                    css += '#cps-cookie-banner .cps-cookie-content p { color: #d1d5db; } ';
                    css += '#cps-cookie-banner .cps-cookie-content p a { color: #60a5fa; } ';
                    css += '#cps-cookie-banner .cps-cookie-categories { background: #374151; } ';
                    css += '#cps-cookie-banner .cps-category { border-color: #4b5563; } ';
                    css += '#cps-cookie-banner .cps-category-name { color: #ffffff; } ';
                    css += '#cps-cookie-banner .cps-category-desc { color: #9ca3af; } ';
                } else if (settings.theme === 'custom') {
                    if (settings.backgroundColor) {
                        css += '#cps-cookie-banner { background: ' + settings.backgroundColor + '; } ';
                    }
                    if (settings.textColor) {
                        css += '#cps-cookie-banner .cps-cookie-content h2, ';
                        css += '#cps-cookie-banner .cps-cookie-content p, ';
                        css += '#cps-cookie-banner .cps-category-name, ';
                        css += '#cps-cookie-banner .cps-category-desc { color: ' + settings.textColor + '; } ';
                    }
                }

                if (settings.primaryColor) {
                    css += '#cps-cookie-banner .cps-btn-accept, ';
                    css += '#cps-cookie-banner .cps-btn-primary { background: ' + settings.primaryColor + '; } ';
                    css += '#cps-cookie-banner .cps-category-toggle input:checked + .cps-toggle-slider, ';
                    css += '#cps-cookie-banner .cps-switch input:checked + .cps-switch-slider { background: ' + settings.primaryColor + '; } ';
                }

                if (settings.borderRadius) {
                    css += '#cps-cookie-banner { border-radius: ' + settings.borderRadius + 'px; } ';
                }

                $style.text(css);
            }
        },

        acceptAll: function() {
            this.sendConsent('accept_all', {}, function() {
                CPSCookieBanner.hideBanner();
            });
        },

        rejectAll: function() {
            this.sendConsent('reject_all', {}, function() {
                CPSCookieBanner.hideBanner();
            });
        },

        showSettings: function() {
            this.$modal.addClass('cps-modal-visible');
            this.syncTogglesFromConsent();
        },

        hideSettings: function() {
            this.$modal.removeClass('cps-modal-visible');
        },

        onCategoryToggle: function(e) {
            var $banner = this.$banner;
            var hasAnyEnabled = false;

            this.$categoryToggles.each(function() {
                if ($(this).is(':checked')) {
                    hasAnyEnabled = true;
                    return false;
                }
            });

            if (hasAnyEnabled) {
                $banner.addClass('cps-categories-visible');
            } else {
                $banner.removeClass('cps-categories-visible');
            }
        },

        syncTogglesFromConsent: function() {
            var consent = cpsCookieData.consent;

            if (consent && consent.categories) {
                if (consent.categories.analytics) {
                    this.$modalToggles.analytics.prop('checked', true);
                }
                if (consent.categories.marketing) {
                    this.$modalToggles.marketing.prop('checked', true);
                }
                if (consent.categories.functional) {
                    this.$modalToggles.functional.prop('checked', true);
                }
            } else {
                this.$modalToggles.analytics.prop('checked', false);
                this.$modalToggles.marketing.prop('checked', false);
                this.$modalToggles.functional.prop('checked', false);
            }
        },

        savePreferences: function() {
            var categories = {
                analytics: this.$modalToggles.analytics.is(':checked'),
                marketing: this.$modalToggles.marketing.is(':checked'),
                functional: this.$modalToggles.functional.is(':checked')
            };

            this.sendConsent('save_preferences', { categories: categories }, function() {
                CPSCookieBanner.hideBanner();
                CPSCookieBanner.hideSettings();
            });
        },

        sendConsent: function(action, data, callback) {
            $.ajax({
                url: cpsCookieData.ajaxUrl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'cps_cookie_consent',
                    action_type: action,
                    categories: JSON.stringify(data.categories || {}),
                    nonce: cpsCookieData.nonce
                },
                success: function(response) {
                    if (response.success) {
                        if (callback && typeof callback === 'function') {
                            callback(response.data);
                        }
                        CPSCookieBanner.triggerConsentEvents(action, data);
                    }
                },
                error: function() {
                    console.error('CPS Cookie: Failed to save consent');
                }
            });
        },

        triggerConsentEvents: function(action, data) {
            if (action === 'accept_all') {
                $(document).trigger('cpsCookieAcceptAll');
            } else if (action === 'reject_all') {
                $(document).trigger('cpsCookieRejectAll');
            } else if (action === 'save_preferences') {
                $(document).trigger('cpsCookiePreferencesSaved', [data]);
            }

            $(document).trigger('cpsCookieConsentUpdated');
        },

        hideBanner: function() {
            var position = cpsCookieData.settings.position || 'bottom';
            var $banner = this.$banner;

            if (position === 'top') {
                $banner.css('transform', 'translateY(-100%)');
            } else {
                $banner.css('transform', 'translateY(100%)');
            }

            setTimeout(function() {
                $banner.addClass('cps-banner-hidden');
            }, 300);

            this.$settingsLink.show();
        }
    };

    $(document).ready(function() {
        if ($('#cps-cookie-banner').length) {
            CPSCookieBanner.init();
        }
    });

})(jQuery);