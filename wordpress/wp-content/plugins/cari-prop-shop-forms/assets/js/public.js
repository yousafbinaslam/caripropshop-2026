(function($) {
    'use strict';

    var CPSForms = {
        init: function() {
            this.bindEvents();
            this.initMortgageCalculator();
            this.initRecaptcha();
        },

        bindEvents: function() {
            $(document).on('submit', '.cps-form', this.handleFormSubmit);
            $(document).on('input', '.cps-input, .cps-textarea', this.clearErrors);
            $(document).on('change', '.cps-select', this.clearErrors);
        },

        initMortgageCalculator: function() {
            var self = this;

            $('#cps_calculate_btn').on('click', function(e) {
                e.preventDefault();
                self.calculateMortgage($(this).closest('form'));
            });

            $('#cps_down_payment_percent').on('input', function() {
                var form = $(this).closest('form');
                var propertyPrice = parseFloat(form.find('#cps_property_price').val()) || 0;
                var percent = parseFloat($(this).val()) || 0;
                var downPayment = (propertyPrice * percent / 100).toFixed(0);
                form.find('#cps_down_payment').val(downPayment);
            });
        },

        calculateMortgage: function(form) {
            var propertyPrice = parseFloat(form.find('#cps_property_price').val()) || 0;
            var downPayment = parseFloat(form.find('#cps_down_payment').val()) || 0;
            var loanTerm = parseInt(form.find('#cps_loan_term').val()) || 30;
            var interestRate = parseFloat(form.find('#cps_interest_rate').val()) || 0;

            if (propertyPrice <= 0 || downPayment <= 0) {
                alert('Please enter valid property price and down payment values.');
                return;
            }

            var loanAmount = propertyPrice - downPayment;
            var monthlyRate = interestRate / 100 / 12;
            var numberOfPayments = loanTerm * 12;

            var monthlyPayment;
            if (monthlyRate === 0) {
                monthlyPayment = loanAmount / numberOfPayments;
            } else {
                monthlyPayment = loanAmount * (monthlyRate * Math.pow(1 + monthlyRate, numberOfPayments)) / (Math.pow(1 + monthlyRate, numberOfPayments) - 1);
            }

            var propertyTax = (propertyPrice * 0.0125) / 12;
            var insurance = (propertyPrice * 0.0035) / 12;
            var totalMonthly = monthlyPayment + propertyTax + insurance;

            form.find('.cps-mortgage-results').show();
            form.find('.cps-monthly-payment .cps-amount').text(this.formatNumber(monthlyPayment));
            form.find('.cps-breakdown-row .cps-pi').text('$' + this.formatNumber(monthlyPayment));
            form.find('.cps-breakdown-row .cps-tax').text('$' + this.formatNumber(propertyTax));
            form.find('.cps-breakdown-row .cps-insurance').text('$' + this.formatNumber(insurance));
            form.find('.cps-breakdown-row .cps-total-amount').text('$' + this.formatNumber(totalMonthly));

            form.find('input[name="property_price"]').val(propertyPrice);
            form.find('input[name="down_payment"]').val(downPayment);
            form.find('input[name="loan_term"]').val(loanTerm);
            form.find('input[name="interest_rate"]').val(interestRate);
        },

        formatNumber: function(num) {
            return num.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        },

        initRecaptcha: function() {
            var settings = cpsForms.settings || {};
            if (settings.recaptcha && settings.recaptcha.enable && typeof grecaptcha !== 'undefined') {
                $('.cps-form').each(function() {
                    var form = $(this);
                    if (form.data('recaptcha-rendered')) {
                        return;
                    }
                    var recaptchaContainer = document.createElement('div');
                    recaptchaContainer.className = 'cps-recaptcha';
                    form.append(recaptchaContainer);
                    var widgetId = grecaptcha.render(recaptchaContainer, {
                        sitekey: settings.recaptcha.site_key,
                        callback: function(token) {
                            form.find('input[name="recaptcha_token"]').val(token);
                        }
                    });
                    form.data('recaptcha-widget-id', widgetId);
                    form.data('recaptcha-rendered', true);
                });
            }
        },

        handleFormSubmit: function(e) {
            e.preventDefault();

            var form = $(this);
            var formType = form.data('form-type');
            var submitBtn = form.find('.cps-submit-btn');
            var messageContainer = form.find('.cps-form-message');

            if (!CPSForms.validateForm(form)) {
                return;
            }

            submitBtn.prop('disabled', true).text(cpsForms.strings.submitting);

            var formData = {};
            form.find('input, textarea, select').each(function() {
                var input = $(this);
                var name = input.attr('name');
                if (name) {
                    if (input.is(':checkbox')) {
                        formData[name] = input.is(':checked');
                    } else {
                        formData[name] = input.val();
                    }
                }
            });

            $.ajax({
                url: cpsForms.ajax_url,
                type: 'POST',
                data: {
                    action: 'cps_form_submission',
                    nonce: cpsForms.nonce,
                    form_type: formType,
                    form_data: formData
                },
                success: function(response) {
                    if (response.success) {
                        messageContainer.removeClass('error').addClass('success').text(response.data.message).show();
                        form[0].reset();
                        form.find('.cps-mortgage-results').hide();
                        
                        if (typeof grecaptcha !== 'undefined' && form.data('recaptcha-widget-id')) {
                            grecaptcha.reset(form.data('recaptcha-widget-id'));
                        }
                    } else {
                        messageContainer.removeClass('success').addClass('error');
                        if (response.data && response.data.message) {
                            messageContainer.text(response.data.message);
                        } else {
                            messageContainer.text(cpsForms.strings.error);
                        }
                        messageContainer.show();
                        
                        if (response.data && response.data.errors) {
                            CPSForms.showFieldErrors(form, response.data.errors);
                        }
                    }
                },
                error: function() {
                    messageContainer.removeClass('success').addClass('error').text(cpsForms.strings.error).show();
                },
                complete: function() {
                    submitBtn.prop('disabled', false).text(submitBtn.data('original-text') || 'Submit');
                }
            });
        },

        validateForm: function(form) {
            var isValid = true;
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            var phoneRegex = /^[\d\s\-\+\(\)]{10,}$/;

            form.find('[required]').each(function() {
                var input = $(this);
                var value = input.val();
                var type = input.attr('type');

                input.removeClass('error');

                if (!value || (type === 'checkbox' && !input.is(':checked'))) {
                    input.addClass('error');
                    isValid = false;
                }

                if (type === 'email' && value && !emailRegex.test(value)) {
                    input.addClass('error');
                    isValid = false;
                }

                if (type === 'tel' && value && !phoneRegex.test(value)) {
                    input.addClass('error');
                    isValid = false;
                }
            });

            return isValid;
        },

        showFieldErrors: function(form, errors) {
            if (typeof errors === 'object') {
                $.each(errors, function(field, message) {
                    var input = form.find('[name="' + field + '"]');
                    if (input.length) {
                        input.addClass('error');
                    }
                });
            }
        },

        clearErrors: function() {
            var input = $(this);
            input.removeClass('error');
        }
    };

    $(document).ready(function() {
        CPSForms.init();
    });

})(jQuery);