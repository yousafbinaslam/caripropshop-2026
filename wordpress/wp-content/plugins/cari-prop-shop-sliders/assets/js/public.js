/**
 * CariPropShop Sliders - Public JavaScript
 */

(function($) {
    'use strict';

    var CPS_Public = {
        initialized: false,

        init: function() {
            if (this.initialized) {
                return;
            }
            this.initialized = true;
            this.initSliders();
        },

        initSliders: function() {
            var self = this;

            $('.cps-slick-slider').each(function() {
                var $slider = $(this);
                var slickData = $slider.data('slick');

                if (slickData) {
                    $slider.slick(slickData);
                }
            });

            $(document).on('click', '.cps-hero-cta', function(e) {
                var $cta = $(this);
                if ($cta.attr('href') === '#' || !$cta.attr('href')) {
                    e.preventDefault();
                }
            });
        }
    };

    $(document).ready(function() {
        CPS_Public.init();
    });

})(jQuery);