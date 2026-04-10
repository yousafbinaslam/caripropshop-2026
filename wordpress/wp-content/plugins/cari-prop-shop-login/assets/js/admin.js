(function($) {
	'use strict';

	var CPSAdmin = {
		init: function() {
			this.bindEvents();
			this.initTabs();
		},

		bindEvents: function() {
			$('.cps-tab').on('click', this.switchTab);
			$('.cps-toggle').each(function() {
				var $toggle = $(this);
				var $checkbox = $toggle.find('input[type="checkbox"]');
				var $slider = $toggle.find('.cps-toggle-slider');

				$slider.on('click', function() {
					$checkbox.trigger('click');
				});
			});
		},

		initTabs: function() {
			$('.cps-tab').on('click', function() {
				var tabId = $(this).data('tab');

				$('.cps-tab').removeClass('active');
				$(this).addClass('active');

				$('.cps-tab-content').removeClass('active');
				$('#' + tabId).addClass('active');
			});

			var activeTab = $('.cps-tab.active').first();
			if (activeTab.length === 0) {
				$('.cps-tab').first().addClass('active');
				$('.cps-tab-content').first().addClass('active');
			}
		},

		switchTab: function() {
			var $this = $(this);
			var target = $this.data('target');

			$('.cps-tab').removeClass('active');
			$this.addClass('active');

			$('.cps-tab-content').removeClass('active');
			$(target).addClass('active');
		}
	};

	$(document).ready(function() {
		CPSAdmin.init();
	});

})(jQuery);