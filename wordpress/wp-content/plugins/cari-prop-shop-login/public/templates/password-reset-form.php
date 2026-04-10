<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$action = isset( $_GET['action'] ) ? sanitize_text_field( wp_unslash( $_GET['action'] ) ) : 'request';

$password_reset_message = get_transient( 'cps_message_password_reset' );
if ( $password_reset_message ) {
	delete_transient( 'cps_message_password_reset' );
}

$login_url = get_option( 'cps_login_page', wp_login_url() );

wp_enqueue_style( 'cps-login-public' );
?>

<div class="cps-password-reset-wrapper">
	<?php if ( 'request' === $action ) : ?>
		<h2 class="cps-form-title"><?php esc_html_e( 'Reset Your Password', 'cari-prop-shop-login' ); ?></h2>
		<p class="cps-form-description"><?php esc_html_e( 'Enter your username or email address and we will send you a link to reset your password.', 'cari-prop-shop-login' ); ?></p>

		<?php if ( $password_reset_message ) : ?>
			<div class="cps-message cps-message-<?php echo esc_attr( $password_reset_message['type'] ); ?>">
				<?php echo esc_html( $password_reset_message['message'] ); ?>
			</div>
		<?php endif; ?>

		<form method="post" class="cps-password-reset-form" id="cps-password-reset-form">
			<?php wp_nonce_field( 'cps_password_reset_action', 'cps_password_reset_nonce' ); ?>
			<input type="hidden" name="cps_action" value="password_reset" />

			<div class="cps-form-group">
				<label for="cps-user-login"><?php esc_html_e( 'Username or Email', 'cari-prop-shop-login' ); ?></label>
				<input type="text" name="cps_user_login" id="cps-user-login" class="cps-input" required />
			</div>

			<button type="submit" class="cps-submit-btn"><?php esc_html_e( 'Send Reset Link', 'cari-prop-shop-login' ); ?></button>

			<p class="cps-back-link">
				<a href="<?php echo esc_url( $login_url ); ?>"><?php esc_html_e( 'Back to Login', 'cari-prop-shop-login' ); ?></a>
			</p>
		</form>

	<?php elseif ( 'rp' === $action ) : ?>
		<?php
		$key   = isset( $_GET['key'] ) ? sanitize_text_field( wp_unslash( $_GET['key'] ) ) : '';
		$login = isset( $_GET['login'] ) ? sanitize_text_field( wp_unslash( $_GET['login'] ) ) : '';
		?>

		<h2 class="cps-form-title"><?php esc_html_e( 'Create New Password', 'cari-prop-shop-login' ); ?></h2>
		<p class="cps-form-description"><?php esc_html_e( 'Please enter your new password below.', 'cari-prop-shop-login' ); ?></p>

		<?php if ( $password_reset_message ) : ?>
			<div class="cps-message cps-message-<?php echo esc_attr( $password_reset_message['type'] ); ?>">
				<?php echo esc_html( $password_reset_message['message'] ); ?>
			</div>
		<?php endif; ?>

		<form method="post" class="cps-password-reset-form" id="cps-set-new-password-form">
			<?php wp_nonce_field( 'cps_set_password_action', 'cps_set_password_nonce' ); ?>
			<input type="hidden" name="cps_action" value="set_new_password" />
			<input type="hidden" name="key" value="<?php echo esc_attr( $key ); ?>" />
			<input type="hidden" name="login" value="<?php echo esc_attr( $login ); ?>" />

			<div class="cps-form-group">
				<label for="cps-new-password"><?php esc_html_e( 'New Password', 'cari-prop-shop-login' ); ?></label>
				<div class="cps-password-wrapper">
					<input type="password" name="cps_new_password" id="cps-new-password" class="cps-input" required minlength="8" />
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
				<label for="cps-confirm-new-password"><?php esc_html_e( 'Confirm New Password', 'cari-prop-shop-login' ); ?></label>
				<div class="cps-password-wrapper">
					<input type="password" name="cps_confirm_new_password" id="cps-confirm-new-password" class="cps-input" required />
					<button type="button" class="cps-toggle-password" aria-label="<?php esc_attr_e( 'Toggle password visibility', 'cari-prop-shop-login' ); ?>">
						<span class="cps-eye-icon">
							<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
								<path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
							</svg>
						</span>
					</button>
				</div>
			</div>

			<button type="submit" class="cps-submit-btn"><?php esc_html_e( 'Reset Password', 'cari-prop-shop-login' ); ?></button>

			<p class="cps-back-link">
				<a href="<?php echo esc_url( $login_url ); ?>"><?php esc_html_e( 'Back to Login', 'cari-prop-shop-login' ); ?></a>
			</p>
		</form>
	<?php endif; ?>
</div>