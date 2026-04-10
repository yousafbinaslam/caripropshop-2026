<div class="wrap cps-chat-admin">
	<h1><?php _e( 'Chat Settings', 'cari-prop-shop-chat' ); ?></h1>

	<form method="post" action="options.php" id="cps-settings-form">
		<?php settings_fields( 'cps_chat_settings' ); ?>

		<div class="cps-settings-section">
			<h2><?php _e( 'General Settings', 'cari-prop-shop-chat' ); ?></h2>
			<table class="form-table">
				<tr>
					<th scope="row">
						<label for="cps_enabled"><?php _e( 'Enable Chat', 'cari-prop-shop-chat' ); ?></label>
					</th>
					<td>
						<input type="checkbox" id="cps_enabled" name="cps_chat_options[enabled]" value="1" <?php checked( isset( $options['enabled'] ) && $options['enabled'], 1 ); ?>>
						<p class="description"><?php _e( 'Enable or disable the chat widget on your site.', 'cari-prop-shop-chat' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="cps_show_on_mobile"><?php _e( 'Show on Mobile', 'cari-prop-shop-chat' ); ?></label>
					</th>
					<td>
						<input type="checkbox" id="cps_show_on_mobile" name="cps_chat_options[show_on_mobile]" value="1" <?php checked( isset( $options['show_on_mobile'] ) && $options['show_on_mobile'], 1 ); ?>>
						<p class="description"><?php _e( 'Display chat widget on mobile devices.', 'cari-prop-shop-chat' ); ?></p>
					</td>
				</tr>
			</table>
		</div>

		<div class="cps-settings-section">
			<h2><?php _e( 'Widget Position', 'cari-prop-shop-chat' ); ?></h2>
			<table class="form-table">
				<tr>
					<th scope="row">
						<label for="cps_position"><?php _e( 'Position', 'cari-prop-shop-chat' ); ?></label>
					</th>
					<td>
						<select id="cps_position" name="cps_chat_options[position]">
							<option value="right" <?php selected( isset( $options['position'] ) ? $options['position'] : 'right', 'right' ); ?>><?php _e( 'Bottom Right', 'cari-prop-shop-chat' ); ?></option>
							<option value="left" <?php selected( isset( $options['position'] ) ? $options['position'] : 'right', 'left' ); ?>><?php _e( 'Bottom Left', 'cari-prop-shop-chat' ); ?></option>
						</select>
					</td>
				</tr>
			</table>
		</div>

		<div class="cps-settings-section">
			<h2><?php _e( 'Colors & Styling', 'cari-prop-shop-chat' ); ?></h2>
			<table class="form-table">
				<tr>
					<th scope="row">
						<label for="cps_button_color"><?php _e( 'Button Color', 'cari-prop-shop-chat' ); ?></label>
					</th>
					<td>
						<input type="color" id="cps_button_color" name="cps_chat_options[button_color]" value="<?php echo esc_attr( isset( $options['button_color'] ) ? $options['button_color'] : '#4a90d9' ); ?>">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="cps_header_color"><?php _e( 'Header Color', 'cari-prop-shop-chat' ); ?></label>
					</th>
					<td>
						<input type="color" id="cps_header_color" name="cps_chat_options[header_color]" value="<?php echo esc_attr( isset( $options['header_color'] ) ? $options['header_color'] : '#4a90d9' ); ?>">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="cps_chat_bg_color"><?php _e( 'Chat Background', 'cari-prop-shop-chat' ); ?></label>
					</th>
					<td>
						<input type="color" id="cps_chat_bg_color" name="cps_chat_options[chat_bg_color]" value="<?php echo esc_attr( isset( $options['chat_bg_color'] ) ? $options['chat_bg_color'] : '#ffffff' ); ?>">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="cps_user_message_color"><?php _e( 'User Message Color', 'cari-prop-shop-chat' ); ?></label>
					</th>
					<td>
						<input type="color" id="cps_user_message_color" name="cps_chat_options[user_message_color]" value="<?php echo esc_attr( isset( $options['user_message_color'] ) ? $options['user_message_color'] : '#4a90d9' ); ?>">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="cps_bot_message_color"><?php _e( 'Bot/Admin Message Color', 'cari-prop-shop-chat' ); ?></label>
					</th>
					<td>
						<input type="color" id="cps_bot_message_color" name="cps_chat_options[bot_message_color]" value="<?php echo esc_attr( isset( $options['bot_message_color'] ) ? $options['bot_message_color'] : '#f0f0f0' ); ?>">
					</td>
				</tr>
			</table>
		</div>

		<div class="cps-settings-section">
			<h2><?php _e( 'Auto-Open Settings', 'cari-prop-shop-chat' ); ?></h2>
			<table class="form-table">
				<tr>
					<th scope="row">
						<label for="cps_auto_open"><?php _e( 'Auto-Open Chat', 'cari-prop-shop-chat' ); ?></label>
					</th>
					<td>
						<input type="checkbox" id="cps_auto_open" name="cps_chat_options[auto_open]" value="1" <?php checked( isset( $options['auto_open'] ) && $options['auto_open'], 1 ); ?>>
						<p class="description"><?php _e( 'Automatically open the chat window when page loads.', 'cari-prop-shop-chat' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="cps_auto_open_delay"><?php _e( 'Auto-Open Delay (ms)', 'cari-prop-shop-chat' ); ?></label>
					</th>
					<td>
						<input type="number" id="cps_auto_open_delay" name="cps_chat_options[auto_open_delay]" value="<?php echo esc_attr( isset( $options['auto_open_delay'] ) ? $options['auto_open_delay'] : 5000 ); ?>" min="0" step="100">
						<p class="description"><?php _e( 'Delay in milliseconds before auto-opening the chat.', 'cari-prop-shop-chat' ); ?></p>
					</td>
				</tr>
			</table>
		</div>

		<div class="cps-settings-section">
			<h2><?php _e( 'Notifications', 'cari-prop-shop-chat' ); ?></h2>
			<table class="form-table">
				<tr>
					<th scope="row">
						<label for="cps_enable_notifications"><?php _e( 'Email Notifications', 'cari-prop-shop-chat' ); ?></label>
					</th>
					<td>
						<input type="checkbox" id="cps_enable_notifications" name="cps_chat_options[enable_notifications]" value="1" <?php checked( isset( $options['enable_notifications'] ) && $options['enable_notifications'], 1 ); ?>>
						<p class="description"><?php _e( 'Receive email when new messages are sent.', 'cari-prop-shop-chat' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="cps_notification_email"><?php _e( 'Notification Email', 'cari-prop-shop-chat' ); ?></label>
					</th>
					<td>
						<input type="email" id="cps_notification_email" name="cps_chat_options[notification_email]" value="<?php echo esc_attr( isset( $options['notification_email'] ) ? $options['notification_email'] : get_option( 'admin_email' ) ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="cps_enable_sound"><?php _e( 'Sound Notification', 'cari-prop-shop-chat' ); ?></label>
					</th>
					<td>
						<input type="checkbox" id="cps_enable_sound" name="cps_chat_options[enable_sound]" value="1" <?php checked( isset( $options['enable_sound'] ) && $options['enable_sound'], 1 ); ?>>
						<p class="description"><?php _e( 'Play sound when new messages arrive.', 'cari-prop-shop-chat' ); ?></p>
					</td>
				</tr>
			</table>
		</div>

		<div class="cps-settings-section">
			<h2><?php _e( 'Chat Content', 'cari-prop-shop-chat' ); ?></h2>
			<table class="form-table">
				<tr>
					<th scope="row">
						<label for="cps_company_name"><?php _e( 'Company Name', 'cari-prop-shop-chat' ); ?></label>
					</th>
					<td>
						<input type="text" id="cps_company_name" name="cps_chat_options[company_name]" value="<?php echo esc_attr( isset( $options['company_name'] ) ? $options['company_name'] : get_bloginfo( 'name' ) ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="cps_welcome_message"><?php _e( 'Welcome Message', 'cari-prop-shop-chat' ); ?></label>
					</th>
					<td>
						<textarea id="cps_welcome_message" name="cps_chat_options[welcome_message]" rows="3" class="large-text"><?php echo esc_textarea( isset( $options['welcome_message'] ) ? $options['welcome_message'] : __( 'Hello! How can we help you today?', 'cari-prop-shop-chat' ) ); ?></textarea>
					</td>
				</tr>
			</table>
		</div>

		<div class="cps-settings-section">
			<h2><?php _e( 'Bot Responses', 'cari-prop-shop-chat' ); ?></h2>
			<table class="form-table">
				<tr>
					<th scope="row">
						<label for="cps_bot_responses"><?php _e( 'Auto-Responses', 'cari-prop-shop-chat' ); ?></label>
					</th>
					<td>
						<textarea id="cps_bot_responses" name="cps_chat_options[bot_responses]" rows="10" class="large-text code"><?php echo esc_textarea( isset( $options['bot_responses'] ) ? $options['bot_responses'] : '' ); ?></textarea>
						<p class="description"><?php _e( 'JSON format: [{"keywords": "hello,hi", "response": "Hello!"}, {"keywords": "default", "response": "Default response"}]', 'cari-prop-shop-chat' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="cps_initial_delay"><?php _e( 'Bot Response Delay (ms)', 'cari-prop-shop-chat' ); ?></label>
					</th>
					<td>
						<input type="number" id="cps_initial_delay" name="cps_chat_options[initial_delay]" value="<?php echo esc_attr( isset( $options['initial_delay'] ) ? $options['initial_delay'] : 1000 ); ?>" min="0" step="100">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="cps_typing_indicator"><?php _e( 'Show Typing Indicator', 'cari-prop-shop-chat' ); ?></label>
					</th>
					<td>
						<input type="checkbox" id="cps_typing_indicator" name="cps_chat_options[typing_indicator]" value="1" <?php checked( isset( $options['typing_indicator'] ) && $options['typing_indicator'], 1 ); ?>>
						<p class="description"><?php _e( 'Show typing indicator while bot is responding.', 'cari-prop-shop-chat' ); ?></p>
					</td>
				</tr>
			</table>
		</div>

		<?php submit_button( __( 'Save Settings', 'cari-prop-shop-chat' ) ); ?>
	</form>
</div>