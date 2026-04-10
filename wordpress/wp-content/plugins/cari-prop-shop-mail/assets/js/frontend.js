(function($) {
    'use strict';

    function initNewsletterForms() {
        $('.cps-newsletter-form').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            var button = form.find('.cps-submit-button');
            var message = form.find('.cps-message');
            var emailInput = form.find('input[name="email"]');
            var nameInput = form.find('input[name="name"]');

            var email = emailInput.val().trim();

            if (!email || !isValidEmail(email)) {
                showMessage(message, cpsMailData.strings.invalid_email, 'error');
                return;
            }

            button.prop('disabled', true).text(cpsMailData.strings.subscribing);

            $.ajax({
                url: cpsMailData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'cps_subscribe',
                    nonce: cpsMailData.nonce,
                    email: email,
                    name: nameInput.length ? nameInput.val() : ''
                },
                success: function(response) {
                    if (response.success) {
                        showMessage(message, response.data.message, 'success');
                        form[0].reset();
                    } else {
                        showMessage(message, response.data.message, 'error');
                    }
                },
                error: function() {
                    showMessage(message, cpsMailData.strings.error, 'error');
                },
                complete: function() {
                    button.prop('disabled', false).text(cpsMailData.strings.subscribe);
                }
            });
        });
    }

    function isValidEmail(email) {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function showMessage(container, text, type) {
        container.removeClass('success error').addClass(type).text(text).fadeIn();
        
        if (type === 'success') {
            setTimeout(function() {
                container.fadeOut();
            }, 5000);
        }
    }

    $(document).ready(function() {
        initNewsletterForms();
    });

})(jQuery);