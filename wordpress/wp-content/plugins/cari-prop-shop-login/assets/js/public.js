(function($) {
	'use strict';

	var CPSLogin = {
		init: function() {
			this.bindEvents();
			this.initPasswordStrength();
			this.initPasswordToggle();
			this.initAjaxValidation();
		},

		bindEvents: function() {
			$('#cps-login-form').on('submit', this.handleLoginSubmit);
			$('#cps-register-form').on('submit', this.handleRegisterSubmit);
			$('#cps-password-reset-form').on('submit', this.handlePasswordResetSubmit);
			$('#cps-set-new-password-form').on('submit', this.handleSetNewPasswordSubmit);

			$('#cps-password').on('input', this.updatePasswordStrength);
			$('#cps-new-password').on('input', this.updatePasswordStrength);

			$('#cps-username').on('blur', this.checkUsernameAvailability);
			$('#cps-email').on('blur', this.checkEmailAvailability);

			$('.cps-toggle-password').on('click', this.togglePasswordVisibility);
		},

		handleLoginSubmit: function(e) {
			var $form = $(this);
			var $submitBtn = $form.find('.cps-submit-btn');
			var username = $form.find('#cps-username').val();
			var password = $form.find('#cps-password').val();

			if (!username || !password) {
				e.preventDefault();
				CPSLogin.showMessage('login', cpsLogin.i18n.fieldRequired, 'error');
				return;
			}

			$submitBtn.prop('disabled', true).text(cpsLogin.i18n.loading);
		},

		handleRegisterSubmit: function(e) {
			var $form = $(this);
			var $submitBtn = $form.find('.cps-submit-btn');
			var password = $form.find('#cps-password').val();
			var confirmPassword = $form.find('#cps-confirm-password').val();

			if (password !== confirmPassword) {
				e.preventDefault();
				CPSLogin.showMessage('register', cpsLogin.i18n.passMismatch, 'error');
				return;
			}

			if (password.length < 8) {
				e.preventDefault();
				CPSLogin.showMessage('register', 'Password must be at least 8 characters', 'error');
				return;
			}

			$submitBtn.prop('disabled', true).text(cpsLogin.i18n.loading);
		},

		handlePasswordResetSubmit: function(e) {
			var $form = $(this);
			var $submitBtn = $form.find('.cps-submit-btn');
			var userLogin = $form.find('#cps-user-login').val();

			if (!userLogin) {
				e.preventDefault();
				CPSLogin.showMessage('password_reset', cpsLogin.i18n.fieldRequired, 'error');
				return;
			}

			$submitBtn.prop('disabled', true).text(cpsLogin.i18n.loading);
		},

		handleSetNewPasswordSubmit: function(e) {
			var $form = $(this);
			var $submitBtn = $form.find('.cps-submit-btn');
			var password = $form.find('#cps-new-password').val();
			var confirmPassword = $form.find('#cps-confirm-new-password').val();

			if (password !== confirmPassword) {
				e.preventDefault();
				CPSLogin.showMessage('password_reset', cpsLogin.i18n.passMismatch, 'error');
				return;
			}

			if (password.length < 8) {
				e.preventDefault();
				CPSLogin.showMessage('password_reset', 'Password must be at least 8 characters', 'error');
				return;
			}

			$submitBtn.prop('disabled', true).text(cpsLogin.i18n.loading);
		},

		initPasswordStrength: function() {
			$('#cps-password, #cps-new-password').each(function() {
				var $input = $(this);
				var $wrapper = $input.closest('.cps-form-group');
				var $strengthBar = $wrapper.find('.cps-strength-fill');
				var $strengthText = $wrapper.find('.cps-strength-text');

				if ($strengthBar.length === 0) {
					$wrapper.append(
						'<div class="cps-password-strength">' +
						'<div class="cps-strength-bar"><div class="cps-strength-fill"></div></div>' +
						'<span class="cps-strength-text"></span>' +
						'</div>'
					);
				}
			});
		},

		updatePasswordStrength: function() {
			var password = $(this).val();
			var $wrapper = $(this).closest('.cps-form-group');
			var $fill = $wrapper.find('.cps-strength-fill');
			var $text = $wrapper.find('.cps-strength-text');

			var strength = CPSLogin.calculatePasswordStrength(password);

			$fill.removeClass('weak fair good strong');

			if (password.length === 0) {
				$text.text('');
				return;
			}

			$fill.addClass(strength.class);
			$text.text(strength.text);
		},

		calculatePasswordStrength: function(password) {
			var score = 0;

			if (password.length >= 8) score += 1;
			if (password.length >= 12) score += 1;
			if (/[A-Z]/.test(password)) score += 1;
			if (/[a-z]/.test(password)) score += 1;
			if (/[0-9]/.test(password)) score += 1;
			if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) score += 1;

			if (score <= 2) {
				return { class: 'weak', text: 'Weak password' };
			} else if (score <= 4) {
				return { class: 'fair', text: 'Fair password' };
			} else if (score <= 5) {
				return { class: 'good', text: 'Good password' };
			} else {
				return { class: 'strong', text: 'Strong password' };
			}
		},

		initPasswordToggle: function() {
			$('.cps-toggle-password').on('click', function() {
				var $btn = $(this);
				var $input = $btn.closest('.cps-password-wrapper').find('input');
				var type = $input.attr('type');

				if (type === 'password') {
					$input.attr('type', 'text');
					$btn.addClass('active');
				} else {
					$input.attr('type', 'password');
					$btn.removeClass('active');
				}
			});
		},

		initAjaxValidation: function() {
			var usernameTimeout;
			$('#cps-username').on('input', function() {
				var $input = $(this);
				var $message = $input.closest('.cps-form-group').find('.cps-username-message');

				clearTimeout(usernameTimeout);
				$message.text(cpsLogin.i18n.loading).removeClass('available taken').addClass('validating');

				usernameTimeout = setTimeout(function() {
					var username = $input.val();
					if (username.length < 4) {
						$message.text('Username must be at least 4 characters').removeClass('available').addClass('taken');
						return;
					}

					$.ajax({
						url: cpsLogin.ajaxUrl,
						type: 'POST',
						data: {
							action: 'cps_check_username',
							nonce: cpsLogin.nonce,
							username: username
						},
						success: function(response) {
							if (response.success) {
								$message.text(response.data.message).removeClass('taken').addClass('available');
								$input.addClass('success').removeClass('error');
							} else {
								$message.text(response.data.message).removeClass('available').addClass('taken');
								$input.addClass('error').removeClass('success');
							}
						}
					});
				}, 500);
			});

			var emailTimeout;
			$('#cps-email').on('input', function() {
				var $input = $(this);
				var $message = $input.closest('.cps-form-group').find('.cps-email-message');

				clearTimeout(emailTimeout);
				$message.text(cpsLogin.i18n.loading).removeClass('available taken').addClass('validating');

				emailTimeout = setTimeout(function() {
					var email = $input.val();

					if (!CPSLogin.isValidEmail(email)) {
						$message.text(cpsLogin.i18n.validEmail).removeClass('available').addClass('taken');
						return;
					}

					$.ajax({
						url: cpsLogin.ajaxUrl,
						type: 'POST',
						data: {
							action: 'cps_check_email',
							nonce: cpsLogin.nonce,
							email: email
						},
						success: function(response) {
							if (response.success) {
								$message.text(response.data.message).removeClass('taken').addClass('available');
								$input.addClass('success').removeClass('error');
							} else {
								$message.text(response.data.message).removeClass('available').addClass('taken');
								$input.addClass('error').removeClass('success');
							}
						}
					});
				}, 500);
			});
		},

		isValidEmail: function(email) {
			var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			return re.test(email);
		},

		checkUsernameAvailability: function() {
			var $input = $(this);
			var username = $input.val();

			if (username.length < 4) return;

			$.ajax({
				url: cpsLogin.ajaxUrl,
				type: 'POST',
				data: {
					action: 'cps_check_username',
					nonce: cpsLogin.nonce,
					username: username
				},
				success: function(response) {
					var $message = $input.closest('.cps-form-group').find('.cps-username-message');
					if (response.success) {
						$message.text(response.data.message).removeClass('taken').addClass('available');
					} else {
						$message.text(response.data.message).removeClass('available').addClass('taken');
					}
				}
			});
		},

		checkEmailAvailability: function() {
			var $input = $(this);
			var email = $input.val();

			if (!CPSLogin.isValidEmail(email)) return;

			$.ajax({
				url: cpsLogin.ajaxUrl,
				type: 'POST',
				data: {
					action: 'cps_check_email',
					nonce: cpsLogin.nonce,
					email: email
				},
				success: function(response) {
					var $message = $input.closest('.cps-form-group').find('.cps-email-message');
					if (response.success) {
						$message.text(response.data.message).removeClass('taken').addClass('available');
					} else {
						$message.text(response.data.message).removeClass('available').addClass('taken');
					}
				}
			});
		},

		showMessage: function(form, message, type) {
			var $wrapper;
			if (form === 'login') {
				$wrapper = $('.cps-login-form-wrapper');
			} else if (form === 'register') {
				$wrapper = $('.cps-register-form-wrapper');
			} else if (form === 'password_reset') {
				$wrapper = $('.cps-password-reset-wrapper');
			}

			if ($wrapper) {
				var $existingMessage = $wrapper.find('.cps-message');
				$existingMessage.remove();

				var $message = $('<div class="cps-message cps-message-' + type + '">' + message + '</div>');
				$wrapper.prepend($message);

				setTimeout(function() {
					$message.fadeOut(function() {
						$(this).remove();
					});
				}, 5000);
			}
		},

		togglePasswordVisibility: function() {
			var $btn = $(this);
			var $input = $btn.closest('.cps-password-wrapper').find('input');
			var type = $input.attr('type');

			if (type === 'password') {
				$input.attr('type', 'text');
				$btn.addClass('active');
			} else {
				$input.attr('type', 'password');
				$btn.removeClass('active');
			}
		}
	};

	$(document).ready(function() {
		CPSLogin.init();
	});

})(jQuery);