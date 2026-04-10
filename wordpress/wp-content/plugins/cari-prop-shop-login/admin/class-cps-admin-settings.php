<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CPS_Admin_Settings {

	private $settings_group = 'cps_login_settings';
	private $settings_tabs = array();

	public function __construct() {
		$this->init_hooks();
		$this->init_settings_tabs();
	}

	private function init_hooks() {
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		add_filter( 'plugin_action_links_' . CPS_LOGIN_PLUGIN_BASENAME, array( $this, 'plugin_action_links' ) );
	}

	private function init_settings_tabs() {
		$this->settings_tabs = array(
			'general'    => __( 'General', 'cari-prop-shop-login' ),
			'login'      => __( 'Login Settings', 'cari-prop-shop-login' ),
			'registration' => __( 'Registration', 'cari-prop-shop-login' ),
			'social'     => __( 'Social Login', 'cari-prop-shop-login' ),
			'emails'     => __( 'Email Templates', 'cari-prop-shop-login' ),
		);
	}

	public function add_admin_menu() {
		add_submenu_page(
			'options-general.php',
			__( 'CariPropShop Login', 'cari-prop-shop-login' ),
			__( 'CariPropShop Login', 'cari-prop-shop-login' ),
			'manage_options',
			'cps-login-settings',
			array( $this, 'render_settings_page' )
		);
	}

	public function register_settings() {
		register_setting( $this->settings_group, 'cps_login_page', 'esc_url' );
		register_setting( $this->settings_group, 'cps_registration_page', 'esc_url' );
		register_setting( $this->settings_group, 'cps_redirect_after_login', 'esc_url' );
		register_setting( $this->settings_group, 'cps_redirect_after_logout', 'esc_url' );
		register_setting( $this->settings_group, 'cps_auto_login_after_registration', 'intval' );
		register_setting( $this->settings_group, 'cps_require_email_verification', 'intval' );
		register_setting( $this->settings_group, 'cps_require_admin_approval', 'intval' );
		register_setting( $this->settings_group, 'cps_default_user_role', 'sanitize_text_field' );
		register_setting( $this->settings_group, 'cps_password_min_length', 'intval' );
		register_setting( $this->settings_group, 'cps_password_require_uppercase', 'intval' );
		register_setting( $this->settings_group, 'cps_password_require_lowercase', 'intval' );
		register_setting( $this->settings_group, 'cps_password_require_number', 'intval' );
		register_setting( $this->settings_group, 'cps_password_require_special', 'intval' );
		register_setting( $this->settings_group, 'cps_require_license_number', 'intval' );
		register_setting( $this->settings_group, 'cps_facebook_app_id', 'sanitize_text_field' );
		register_setting( $this->settings_group, 'cps_facebook_app_secret', 'sanitize_text_field' );
		register_setting( $this->settings_group, 'cps_google_client_id', 'sanitize_text_field' );
		register_setting( $this->settings_group, 'cps_google_client_secret', 'sanitize_text_field' );
		register_setting( $this->settings_group, 'cps_apple_client_id', 'sanitize_text_field' );
		register_setting( $this->settings_group, 'cps_apple_team_id', 'sanitize_text_field' );
		register_setting( $this->settings_group, 'cps_apple_key_id', 'sanitize_text_field' );
		register_setting( $this->settings_group, 'cps_apple_private_key', 'sanitize_textarea_field' );
		register_setting( $this->settings_group, 'cps_enable_facebook_login', 'intval' );
		register_setting( $this->settings_group, 'cps_enable_google_login', 'intval' );
		register_setting( $this->settings_group, 'cps_enable_apple_login', 'intval' );
		register_setting( $this->settings_group, 'cps_registration_email_subject', 'sanitize_text_field' );
		register_setting( $this->settings_group, 'cps_registration_email_template', 'wp_kses_post' );
		register_setting( $this->settings_group, 'cps_verification_email_subject', 'sanitize_text_field' );
		register_setting( $this->settings_group, 'cps_verification_email_template', 'wp_kses_post' );
		register_setting( $this->settings_group, 'cps_password_reset_email_subject', 'sanitize_text_field' );
		register_setting( $this->settings_group, 'cps_password_reset_email_template', 'wp_kses_post' );
	}

	public function enqueue_admin_scripts( $hook ) {
		if ( 'settings_page_cps-login-settings' !== $hook ) {
			return;
		}
		wp_enqueue_style( 'wp-components' );
	}

	public function plugin_action_links( $links ) {
		$settings_link = '<a href="' . admin_url( 'options-general.php?page=cps-login-settings' ) . '">' . __( 'Settings', 'cari-prop-shop-login' ) . '</a>';
		array_unshift( $links, $settings_link );
		return $links;
	}

	public function render_settings_page() {
		$active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'general';
		?>
		<div class="wrap cps-admin-settings">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			
			<h2 class="nav-tab-wrapper">
				<?php foreach ( $this->settings_tabs as $tab_key => $tab_label ) : ?>
					<a href="?page=cps-login-settings&tab=<?php echo esc_attr( $tab_key ); ?>" class="nav-tab <?php echo $active_tab === $tab_key ? 'nav-tab-active' : ''; ?>">
						<?php echo esc_html( $tab_label ); ?>
					</a>
				<?php endforeach; ?>
			</h2>

			<form method="post" action="options.php">
				<?php
				settings_fields( $this->settings_group );
				
				switch ( $active_tab ) {
					case 'login':
						$this->render_login_settings();
						break;
					case 'registration':
						$this->render_registration_settings();
						break;
					case 'social':
						$this->render_social_settings();
						break;
					case 'emails':
						$this->render_email_settings();
						break;
					default:
						$this->render_general_settings();
						break;
				}
				
				submit_button( __( 'Save Settings', 'cari-prop-shop-login' ) );
				?>
			</form>
		</div>
		<?php
	}

	private function render_general_settings() {
		?>
		<table class="form-table">
			<tr>
				<th scope="row"><?php _e( 'Login Page', 'cari-prop-shop-login' ); ?></th>
				<td>
					<input type="url" name="cps_login_page" value="<?php echo esc_attr( get_option( 'cps_login_page', wp_login_url() ) ); ?>" class="regular-text" />
					<p class="description"><?php _e( 'URL of the login page containing [cps_login_form] shortcode.', 'cari-prop-shop-login' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Registration Page', 'cari-prop-shop-login' ); ?></th>
				<td>
					<input type="url" name="cps_registration_page" value="<?php echo esc_attr( get_option( 'cps_registration_page', '' ) ); ?>" class="regular-text" />
					<p class="description"><?php _e( 'URL of the registration page containing [cps_register_form] shortcode.', 'cari-prop-shop-login' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Redirect After Login', 'cari-prop-shop-login' ); ?></th>
				<td>
					<input type="url" name="cps_redirect_after_login" value="<?php echo esc_attr( get_option( 'cps_redirect_after_login', '' ) ); ?>" class="regular-text" />
					<p class="description"><?php _e( 'Default redirect URL after successful login. Leave empty to redirect to previous page.', 'cari-prop-shop-login' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Redirect After Logout', 'cari-prop-shop-login' ); ?></th>
				<td>
					<input type="url" name="cps_redirect_after_logout" value="<?php echo esc_attr( get_option( 'cps_redirect_after_logout', '' ) ); ?>" class="regular-text" />
					<p class="description"><?php _e( 'Redirect URL after logout. Leave empty to stay on current page.', 'cari-prop-shop-login' ); ?></p>
				</td>
			</tr>
		</table>
		<?php
	}

	private function render_login_settings() {
		?>
		<table class="form-table">
			<tr>
				<th scope="row"><?php _e( 'Enable Remember Me', 'cari-prop-shop-login' ); ?></th>
				<td>
					<input type="checkbox" name="cps_enable_remember_me" value="1" <?php checked( get_option( 'cps_enable_remember_me', 1 ), 1 ); ?> id="cps_enable_remember_me" />
					<label for="cps_enable_remember_me"><?php _e( 'Show "Remember Me" checkbox on login form', 'cari-prop-shop-login' ); ?></label>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Password Visibility Toggle', 'cari-prop-shop-login' ); ?></th>
				<td>
					<input type="checkbox" name="cps_password_visibility_toggle" value="1" <?php checked( get_option( 'cps_password_visibility_toggle', 1 ), 1 ); ?> id="cps_password_visibility_toggle" />
					<label for="cps_password_visibility_toggle"><?php _e( 'Allow users to toggle password visibility', 'cari-prop-shop-login' ); ?></label>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Max Login Attempts', 'cari-prop-shop-login' ); ?></th>
				<td>
					<input type="number" name="cps_max_login_attempts" value="<?php echo esc_attr( get_option( 'cps_max_login_attempts', 5 ) ); ?>" min="1" max="20" />
					<p class="description"><?php _e( 'Maximum failed login attempts before account lockout (0 to disable).', 'cari-prop-shop-login' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Lockout Duration (minutes)', 'cari-prop-shop-login' ); ?></th>
				<td>
					<input type="number" name="cps_lockout_duration" value="<?php echo esc_attr( get_option( 'cps_lockout_duration', 15 ) ); ?>" min="1" max="1440" />
					<p class="description"><?php _e( 'How long to lock out the account after max failed attempts.', 'cari-prop-shop-login' ); ?></p>
				</td>
			</tr>
		</table>
		<?php
	}

	private function render_registration_settings() {
		?>
		<table class="form-table">
			<tr>
				<th scope="row"><?php _e( 'Auto Login After Registration', 'cari-prop-shop-login' ); ?></th>
				<td>
					<input type="checkbox" name="cps_auto_login_after_registration" value="1" <?php checked( get_option( 'cps_auto_login_after_registration', 0 ), 1 ); ?> id="cps_auto_login_after_registration" />
					<label for="cps_auto_login_after_registration"><?php _e( 'Automatically log in users after successful registration', 'cari-prop-shop-login' ); ?></label>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Require Email Verification', 'cari-prop-shop-login' ); ?></th>
				<td>
					<input type="checkbox" name="cps_require_email_verification" value="1" <?php checked( get_option( 'cps_require_email_verification', 1 ), 1 ); ?> id="cps_require_email_verification" />
					<label for="cps_require_email_verification"><?php _e( 'Require users to verify their email address before logging in', 'cari-prop-shop-login' ); ?></label>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Require Admin Approval', 'cari-prop-shop-login' ); ?></th>
				<td>
					<input type="checkbox" name="cps_require_admin_approval" value="1" <?php checked( get_option( 'cps_require_admin_approval', 0 ), 1 ); ?> id="cps_require_admin_approval" />
					<label for="cps_require_admin_approval"><?php _e( 'Require admin approval for agents and agencies', 'cari-prop-shop-login' ); ?></label>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Default User Role', 'cari-prop-shop-login' ); ?></th>
				<td>
					<select name="cps_default_user_role" id="cps_default_user_role">
						<option value="cps_buyer" <?php selected( get_option( 'cps_default_user_role', 'cps_buyer' ), 'cps_buyer' ); ?>><?php _e( 'Buyer', 'cari-prop-shop-login' ); ?></option>
						<option value="cps_agent" <?php selected( get_option( 'cps_default_user_role', 'cps_buyer' ), 'cps_agent' ); ?>><?php _e( 'Agent', 'cari-prop-shop-login' ); ?></option>
						<option value="cps_agency" <?php selected( get_option( 'cps_default_user_role', 'cps_buyer' ), 'cps_agency' ); ?>><?php _e( 'Agency', 'cari-prop-shop-login' ); ?></option>
					</select>
					<p class="description"><?php _e( 'Default role assigned to new users during registration.', 'cari-prop-shop-login' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Password Settings', 'cari-prop-shop-login' ); ?></th>
				<td>
					<fieldset>
						<label>
							<input type="number" name="cps_password_min_length" value="<?php echo esc_attr( get_option( 'cps_password_min_length', 8 ) ); ?>" min="6" max="32" style="width: 60px;" />
							<?php _e( 'Minimum password length', 'cari-prop-shop-login' ); ?>
						</label><br />
						<label>
							<input type="checkbox" name="cps_password_require_uppercase" value="1" <?php checked( get_option( 'cps_password_require_uppercase', 0 ), 1 ); ?> />
							<?php _e( 'Require uppercase letter', 'cari-prop-shop-login' ); ?>
						</label><br />
						<label>
							<input type="checkbox" name="cps_password_require_lowercase" value="1" <?php checked( get_option( 'cps_password_require_lowercase', 0 ), 1 ); ?> />
							<?php _e( 'Require lowercase letter', 'cari-prop-shop-login' ); ?>
						</label><br />
						<label>
							<input type="checkbox" name="cps_password_require_number" value="1" <?php checked( get_option( 'cps_password_require_number', 0 ), 1 ); ?> />
							<?php _e( 'Require number', 'cari-prop-shop-login' ); ?>
						</label><br />
						<label>
							<input type="checkbox" name="cps_password_require_special" value="1" <?php checked( get_option( 'cps_password_require_special', 0 ), 1 ); ?> />
							<?php _e( 'Require special character', 'cari-prop-shop-login' ); ?>
						</label>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Require License Number', 'cari-prop-shop-login' ); ?></th>
				<td>
					<input type="checkbox" name="cps_require_license_number" value="1" <?php checked( get_option( 'cps_require_license_number', 1 ), 1 ); ?> id="cps_require_license_number" />
					<label for="cps_require_license_number"><?php _e( 'Require license number for agents and agencies', 'cari-prop-shop-login' ); ?></label>
				</td>
			</tr>
		</table>
		<?php
	}

	private function render_social_settings() {
		?>
		<table class="form-table">
			<tr>
				<th colspan="2"><h3><?php _e( 'Facebook Login', 'cari-prop-shop-login' ); ?></h3></th>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Enable Facebook Login', 'cari-prop-shop-login' ); ?></th>
				<td>
					<input type="checkbox" name="cps_enable_facebook_login" value="1" <?php checked( get_option( 'cps_enable_facebook_login', 0 ), 1 ); ?> id="cps_enable_facebook_login" />
					<label for="cps_enable_facebook_login"><?php _e( 'Enable Facebook social login', 'cari-prop-shop-login' ); ?></label>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'App ID', 'cari-prop-shop-login' ); ?></th>
				<td>
					<input type="text" name="cps_facebook_app_id" value="<?php echo esc_attr( get_option( 'cps_facebook_app_id', '' ) ); ?>" class="regular-text" />
					<p class="description"><?php _e( 'Facebook App ID from Facebook Developer Console.', 'cari-prop-shop-login' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'App Secret', 'cari-prop-shop-login' ); ?></th>
				<td>
					<input type="password" name="cps_facebook_app_secret" value="<?php echo esc_attr( get_option( 'cps_facebook_app_secret', '' ) ); ?>" class="regular-text" />
					<p class="description"><?php _e( 'Facebook App Secret from Facebook Developer Console.', 'cari-prop-shop-login' ); ?></p>
				</td>
			</tr>
			<tr>
				<th colspan="2"><h3><?php _e( 'Google Login', 'cari-prop-shop-login' ); ?></h3></th>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Enable Google Login', 'cari-prop-shop-login' ); ?></th>
				<td>
					<input type="checkbox" name="cps_enable_google_login" value="1" <?php checked( get_option( 'cps_enable_google_login', 0 ), 1 ); ?> id="cps_enable_google_login" />
					<label for="cps_enable_google_login"><?php _e( 'Enable Google social login', 'cari-prop-shop-login' ); ?></label>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Client ID', 'cari-prop-shop-login' ); ?></th>
				<td>
					<input type="text" name="cps_google_client_id" value="<?php echo esc_attr( get_option( 'cps_google_client_id', '' ) ); ?>" class="regular-text" />
					<p class="description"><?php _e( 'Google OAuth Client ID from Google Cloud Console.', 'cari-prop-shop-login' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Client Secret', 'cari-prop-shop-login' ); ?></th>
				<td>
					<input type="password" name="cps_google_client_secret" value="<?php echo esc_attr( get_option( 'cps_google_client_secret', '' ) ); ?>" class="regular-text" />
					<p class="description"><?php _e( 'Google OAuth Client Secret from Google Cloud Console.', 'cari-prop-shop-login' ); ?></p>
				</td>
			</tr>
			<tr>
				<th colspan="2"><h3><?php _e( 'Apple Login', 'cari-prop-shop-login' ); ?></h3></th>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Enable Apple Login', 'cari-prop-shop-login' ); ?></th>
				<td>
					<input type="checkbox" name="cps_enable_apple_login" value="1" <?php checked( get_option( 'cps_enable_apple_login', 0 ), 1 ); ?> id="cps_enable_apple_login" />
					<label for="cps_enable_apple_login"><?php _e( 'Enable Apple social login', 'cari-prop-shop-login' ); ?></label>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Client ID (Service ID)', 'cari-prop-shop-login' ); ?></th>
				<td>
					<input type="text" name="cps_apple_client_id" value="<?php echo esc_attr( get_option( 'cps_apple_client_id', '' ) ); ?>" class="regular-text" />
					<p class="description"><?php _e( 'Apple Service ID from Apple Developer Console.', 'cari-prop-shop-login' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Team ID', 'cari-prop-shop-login' ); ?></th>
				<td>
					<input type="text" name="cps_apple_team_id" value="<?php echo esc_attr( get_option( 'cps_apple_team_id', '' ) ); ?>" class="regular-text" />
					<p class="description"><?php _e( 'Apple Team ID from Apple Developer Console.', 'cari-prop-shop-login' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Key ID', 'cari-prop-shop-login' ); ?></th>
				<td>
					<input type="text" name="cps_apple_key_id" value="<?php echo esc_attr( get_option( 'cps_apple_key_id', '' ) ); ?>" class="regular-text" />
					<p class="description"><?php _e( 'Apple Key ID from Apple Developer Console.', 'cari-prop-shop-login' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Private Key', 'cari-prop-shop-login' ); ?></th>
				<td>
					<textarea name="cps_apple_private_key" rows="5" class="large-text code"><?php echo esc_textarea( get_option( 'cps_apple_private_key', '' ) ); ?></textarea>
					<p class="description"><?php _e( 'Apple Private Key (P8 file content).', 'cari-prop-shop-login' ); ?></p>
				</td>
			</tr>
		</table>
		<?php
	}

	private function render_email_settings() {
		?>
		<table class="form-table">
			<tr>
				<th colspan="2"><h3><?php _e( 'Registration Email', 'cari-prop-shop-login' ); ?></h3></th>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Subject', 'cari-prop-shop-login' ); ?></th>
				<td>
					<input type="text" name="cps_registration_email_subject" value="<?php echo esc_attr( get_option( 'cps_registration_email_subject', __( 'Welcome to CariPropShop!', 'cari-prop-shop-login' ) ) ); ?>" class="regular-text" />
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Template', 'cari-prop-shop-login' ); ?></th>
				<td>
					<textarea name="cps_registration_email_template" rows="10" class="large-text"><?php echo esc_textarea( get_option( 'cps_registration_email_template', "Hi {first_name},\n\nWelcome to CariPropShop! Your account has been created successfully.\n\nUsername: {username}\nEmail: {email}\n\nThank you for joining us!" ) ); ?></textarea>
					<p class="description"><?php _e( 'Available placeholders: {first_name}, {last_name}, {username}, {email}, {site_name}, {site_url}', 'cari-prop-shop-login' ); ?></p>
				</td>
			</tr>
			<tr>
				<th colspan="2"><h3><?php _e( 'Email Verification', 'cari-prop-shop-login' ); ?></h3></th>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Subject', 'cari-prop-shop-login' ); ?></th>
				<td>
					<input type="text" name="cps_verification_email_subject" value="<?php echo esc_attr( get_option( 'cps_verification_email_subject', __( 'Verify your email address', 'cari-prop-shop-login' ) ) ); ?>" class="regular-text" />
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Template', 'cari-prop-shop-login' ); ?></th>
				<td>
					<textarea name="cps_verification_email_template" rows="10" class="large-text"><?php echo esc_textarea( get_option( 'cps_verification_email_template', "Hi {first_name},\n\nPlease verify your email address by clicking the link below:\n\n{verification_url}\n\nIf you did not create this account, please ignore this email." ) ); ?></textarea>
					<p class="description"><?php _e( 'Available placeholders: {first_name}, {verification_url}, {site_name}', 'cari-prop-shop-login' ); ?></p>
				</td>
			</tr>
			<tr>
				<th colspan="2"><h3><?php _e( 'Password Reset', 'cari-prop-shop-login' ); ?></h3></th>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Subject', 'cari-prop-shop-login' ); ?></th>
				<td>
					<input type="text" name="cps_password_reset_email_subject" value="<?php echo esc_attr( get_option( 'cps_password_reset_email_subject', __( 'Password Reset Request', 'cari-prop-shop-login' ) ) ); ?>" class="regular-text" />
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Template', 'cari-prop-shop-login' ); ?></th>
				<td>
					<textarea name="cps_password_reset_email_template" rows="10" class="large-text"><?php echo esc_textarea( get_option( 'cps_password_reset_email_template', "Hi {first_name},\n\nYou requested a password reset. Click the link below to reset your password:\n\n{reset_url}\n\nIf you did not request this, please ignore this email." ) ); ?></textarea>
					<p class="description"><?php _e( 'Available placeholders: {first_name}, {reset_url}, {site_name}', 'cari-prop-shop-login' ); ?></p>
				</td>
			</tr>
		</table>
		<?php
	}

	public function get_settings() {
		return array(
			'login_page' => get_option( 'cps_login_page', wp_login_url() ),
			'registration_page' => get_option( 'cps_registration_page', '' ),
			'redirect_after_login' => get_option( 'cps_redirect_after_login', '' ),
			'redirect_after_logout' => get_option( 'cps_redirect_after_logout', '' ),
			'auto_login_after_registration' => get_option( 'cps_auto_login_after_registration', 0 ),
			'require_email_verification' => get_option( 'cps_require_email_verification', 1 ),
			'require_admin_approval' => get_option( 'cps_require_admin_approval', 0 ),
			'default_user_role' => get_option( 'cps_default_user_role', 'cps_buyer' ),
			'password_min_length' => get_option( 'cps_password_min_length', 8 ),
			'facebook_enabled' => get_option( 'cps_enable_facebook_login', 0 ),
			'google_enabled' => get_option( 'cps_enable_google_login', 0 ),
			'apple_enabled' => get_option( 'cps_enable_apple_login', 0 ),
		);
	}
}