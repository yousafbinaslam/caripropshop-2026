<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$default_role   = get_option( 'cps_default_user_role', 'cps_buyer' );
$show_title     = isset( $atts['show_title'] ) && 'false' === $atts['show_title'] ? false : true;
$show_social    = isset( $atts['show_social'] ) && 'false' === $atts['show_social'] ? false : true;
$role           = isset( $atts['role'] ) ? sanitize_text_field( $atts['role'] ) : $default_role;

$register_message = get_transient( 'cps_message_register' );
if ( $register_message ) {
	delete_transient( 'cps_message_register' );
}

$login_url       = get_option( 'cps_login_page', wp_login_url() );
$facebook_enabled = get_option( 'cps_enable_facebook_login', 0 );
$google_enabled   = get_option( 'cps_enable_google_login', 0 );
$apple_enabled    = get_option( 'cps_enable_apple_login', 0 );

$show_company = in_array( $role, array( CPS_ROLE_AGENT, CPS_ROLE_AGENCY ), true );
$show_license = in_array( $role, array( CPS_ROLE_AGENT, CPS_ROLE_AGENCY ), true );
$show_agency  = ( CPS_ROLE_AGENT === $role );

wp_enqueue_style( 'cps-login-public' );
?>

<div class="cps-register-form-wrapper">
	<?php if ( $show_title ) : ?>
		<h2 class="cps-form-title"><?php esc_html_e( 'Create Your Account', 'cari-prop-shop-login' ); ?></h2>
	<?php endif; ?>

	<?php if ( $register_message ) : ?>
		<div class="cps-message cps-message-<?php echo esc_attr( $register_message['type'] ); ?>">
			<?php echo esc_html( $register_message['message'] ); ?>
		</div>
	<?php endif; ?>

	<?php if ( $show_social && ( $facebook_enabled || $google_enabled || $apple_enabled ) ) : ?>
		<div class="cps-social-login">
			<?php if ( $facebook_enabled ) : ?>
				<button type="button" class="cps-social-btn cps-facebook-btn" id="cps-facebook-register">
					<span class="cps-social-icon">
						<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
							<path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
						</svg>
					</span>
					<span><?php esc_html_e( 'Sign up with Facebook', 'cari-prop-shop-login' ); ?></span>
				</button>
			<?php endif; ?>

			<?php if ( $google_enabled ) : ?>
				<button type="button" class="cps-social-btn cps-google-btn" id="cps-google-register">
					<span class="cps-social-icon">
						<svg viewBox="0 0 24 24" width="20" height="20">
							<path fill="#4285F4" d="M23.745 12.27c0-.79-.07-1.54-.19-2.27h-11.3v4.51h6.47c-.29 1.48-1.14 2.73-2.4 3.6v3h3.9c2.28-2.1 3.6-5.2 3.6-8.84z"/>
							<path fill="#34A853" d="M12.255 24c3.24 0 5.95-1.08 7.96-2.91l-3.91-3c-1.08.72-2.45 1.16-4.05 1.16-3.13 0-5.78-2.11-6.73-4.96h-4.19v3.21c1.98 3.89 6.06 6.5 10.92 6.5z"/>
							<path fill="#FBBC05" d="M5.525 14.29c-.25-.72-.38-1.49-.38-2.29s.14-1.57.38-2.29V6.5h-4.19c-.82 1.64-1.29 3.5-1.29 5.5s.47 3.86 1.29 5.5l4.19-3.21z"/>
							<path fill="#EA4335" d="M12.255 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C18.205 1.19 15.495 0 12.255 0c-4.86 0-8.94 2.61-10.92 6.5l4.19 3.21c.95-2.85 3.6-4.96 6.73-4.96z"/>
						</svg>
					</span>
					<span><?php esc_html_e( 'Sign up with Google', 'cari-prop-shop-login' ); ?></span>
				</button>
			<?php endif; ?>

			<?php if ( $apple_enabled ) : ?>
				<button type="button" class="cps-social-btn cps-apple-btn" id="cps-apple-register">
					<span class="cps-social-icon">
						<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
							<path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.53 4.08zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z"/>
						</svg>
					</span>
					<span><?php esc_html_e( 'Sign up with Apple', 'cari-prop-shop-login' ); ?></span>
				</button>
			<?php endif; ?>
		</div>

		<div class="cps-divider">
			<span><?php esc_html_e( 'or', 'cari-prop-shop-login' ); ?></span>
		</div>
	<?php endif; ?>

	<form method="post" class="cps-register-form" id="cps-register-form">
		<?php wp_nonce_field( 'cps_register_action', 'cps_register_nonce' ); ?>
		<input type="hidden" name="cps_action" value="register" />
		<input type="hidden" name="cps_user_role" value="<?php echo esc_attr( $role ); ?>" />

		<div class="cps-form-group cps-form-row-2">
			<div class="cps-form-field">
				<label for="cps-first-name"><?php esc_html_e( 'First Name', 'cari-prop-shop-login' ); ?></label>
				<input type="text" name="cps_first_name" id="cps-first-name" class="cps-input" required />
			</div>
			<div class="cps-form-field">
				<label for="cps-last-name"><?php esc_html_e( 'Last Name', 'cari-prop-shop-login' ); ?></label>
				<input type="text" name="cps_last_name" id="cps-last-name" class="cps-input" required />
			</div>
		</div>

		<div class="cps-form-group">
			<label for="cps-username"><?php esc_html_e( 'Username', 'cari-prop-shop-login' ); ?></label>
			<input type="text" name="cps_username" id="cps-username" class="cps-input" required minlength="4" />
			<span class="cps-username-message"></span>
		</div>

		<div class="cps-form-group">
			<label for="cps-email"><?php esc_html_e( 'Email Address', 'cari-prop-shop-login' ); ?></label>
			<input type="email" name="cps_email" id="cps-email" class="cps-input" required />
			<span class="cps-email-message"></span>
		</div>

		<div class="cps-form-group">
			<label for="cps-phone"><?php esc_html_e( 'Phone Number', 'cari-prop-shop-login' ); ?></label>
			<input type="tel" name="cps_phone" id="cps-phone" class="cps-input" />
		</div>

		<?php if ( $show_company ) : ?>
			<div class="cps-form-group">
				<label for="cps-company-name"><?php esc_html_e( 'Company Name', 'cari-prop-shop-login' ); ?></label>
				<input type="text" name="cps_company_name" id="cps-company-name" class="cps-input" />
			</div>
		<?php endif; ?>

		<?php if ( $show_agency ) : ?>
			<div class="cps-form-group">
				<label for="cps-agency-name"><?php esc_html_e( 'Agency Name', 'cari-prop-shop-login' ); ?></label>
				<input type="text" name="cps_agency_name" id="cps-agency-name" class="cps-input" />
			</div>
		<?php endif; ?>

		<?php if ( $show_license ) : ?>
			<div class="cps-form-group">
				<label for="cps-license-number"><?php esc_html_e( 'License Number', 'cari-prop-shop-login' ); ?>
					<?php if ( get_option( 'cps_require_license_number', 1 ) ) : ?>
						<span class="required">*</span>
					<?php endif; ?>
				</label>
				<input type="text" name="cps_license_number" id="cps-license-number" class="cps-input" />
			</div>
		<?php endif; ?>

		<div class="cps-form-group">
			<label for="cps-address"><?php esc_html_e( 'Address', 'cari-prop-shop-login' ); ?></label>
			<input type="text" name="cps_address" id="cps-address" class="cps-input" />
		</div>

		<div class="cps-form-group cps-form-row-2">
			<div class="cps-form-field">
				<label for="cps-city"><?php esc_html_e( 'City', 'cari-prop-shop-login' ); ?></label>
				<input type="text" name="cps_city" id="cps-city" class="cps-input" />
			</div>
			<div class="cps-form-field">
				<label for="cps-state"><?php esc_html_e( 'State/Province', 'cari-prop-shop-login' ); ?></label>
				<input type="text" name="cps_state" id="cps-state" class="cps-input" />
			</div>
		</div>

		<div class="cps-form-group cps-form-row-2">
			<div class="cps-form-field">
				<label for="cps-zip-code"><?php esc_html_e( 'ZIP/Postal Code', 'cari-prop-shop-login' ); ?></label>
				<input type="text" name="cps_zip_code" id="cps-zip-code" class="cps-input" />
			</div>
			<div class="cps-form-field">
				<label for="cps-country"><?php esc_html_e( 'Country', 'cari-prop-shop-login' ); ?></label>
				<select name="cps_country" id="cps-country" class="cps-select">
					<option value=""><?php esc_html_e( 'Select Country', 'cari-prop-shop-login' ); ?></option>
					<option value="US"><?php esc_html_e( 'United States', 'cari-prop-shop-login' ); ?></option>
					<option value="CA"><?php esc_html_e( 'Canada', 'cari-prop-shop-login' ); ?></option>
					<option value="UK"><?php esc_html_e( 'United Kingdom', 'cari-prop-shop-login' ); ?></option>
					<option value="AU"><?php esc_html_e( 'Australia', 'cari-prop-shop-login' ); ?></option>
					<option value="DE"><?php esc_html_e( 'Germany', 'cari-prop-shop-login' ); ?></option>
					<option value="FR"><?php esc_html_e( 'France', 'cari-prop-shop-login' ); ?></option>
					<option value="OTHER"><?php esc_html_e( 'Other', 'cari-prop-shop-login' ); ?></option>
				</select>
			</div>
		</div>

		<div class="cps-form-group">
			<label for="cps-password"><?php esc_html_e( 'Password', 'cari-prop-shop-login' ); ?></label>
			<div class="cps-password-wrapper">
				<input type="password" name="cps_password" id="cps-password" class="cps-input" required minlength="8" />
				<button type="button" class="cps-toggle-password" aria-label="<?php esc_attr_e( 'Toggle password visibility', 'cari-prop-shop-login' ); ?>">
					<span class="cps-eye-icon">
						<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
							<path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
						</svg>
					</span>
				</button>
			</div>
			<div class="cps-password-strength">
				<div class="cps-strength-bar">
					<div class="cps-strength-fill"></div>
				</div>
				<span class="cps-strength-text"></span>
			</div>
		</div>

		<div class="cps-form-group">
			<label for="cps-confirm-password"><?php esc_html_e( 'Confirm Password', 'cari-prop-shop-login' ); ?></label>
			<div class="cps-password-wrapper">
				<input type="password" name="cps_confirm_password" id="cps-confirm-password" class="cps-input" required />
				<button type="button" class="cps-toggle-password" aria-label="<?php esc_attr_e( 'Toggle password visibility', 'cari-prop-shop-login' ); ?>">
					<span class="cps-eye-icon">
						<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
							<path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
						</svg>
					</span>
				</button>
			</div>
		</div>

		<div class="cps-form-group">
			<label class="cps-checkbox-wrapper">
				<input type="checkbox" name="cps_terms_agreement" value="1" required />
				<span class="cps-checkbox-label">
					<?php 
					$terms_url = get_option( 'cps_terms_page', '' );
					if ( $terms_url ) {
						echo sprintf( 
							__( 'I agree to the <a href="%s" target="_blank">Terms and Conditions</a>', 'cari-prop-shop-login' ),
							esc_url( $terms_url )
						);
					} else {
						esc_html_e( 'I agree to the Terms and Conditions', 'cari-prop-shop-login' );
					}
					?>
				</span>
			</label>
		</div>

		<button type="submit" class="cps-submit-btn"><?php esc_html_e( 'Create Account', 'cari-prop-shop-login' ); ?></button>

		<p class="cps-login-link">
			<?php esc_html_e( 'Already have an account?', 'cari-prop-shop-login' ); ?>
			<a href="<?php echo esc_url( $login_url ); ?>"><?php esc_html_e( 'Login here', 'cari-prop-shop-login' ); ?></a>
		</p>
	</form>
</div>