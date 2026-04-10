<?php
$options = get_option( 'cps_chat_options', array() );

$position = isset( $options['position'] ) ? $options['position'] : 'right';
$button_color = isset( $options['button_color'] ) ? $options['button_color'] : '#4a90d9';
$header_color = isset( $options['header_color'] ) ? $options['header_color'] : '#4a90d9';
$chat_bg_color = isset( $options['chat_bg_color'] ) ? $options['chat_bg_color'] : '#ffffff';
$user_message_color = isset( $options['user_message_color'] ) ? $options['user_message_color'] : '#4a90d9';
$bot_message_color = isset( $options['bot_message_color'] ) ? $options['bot_message_color'] : '#f0f0f0';
$welcome_message = isset( $options['welcome_message'] ) ? $options['welcome_message'] : __( 'Hello! How can we help you today?', 'cari-prop-shop-chat' );
$company_name = isset( $options['company_name'] ) ? $options['company_name'] : get_bloginfo( 'name' );
$auto_open = isset( $options['auto_open'] ) ? $options['auto_open'] : 0;
$auto_open_delay = isset( $options['auto_open_delay'] ) ? $options['auto_open_delay'] : 5000;
$typing_indicator = isset( $options['typing_indicator'] ) ? $options['typing_indicator'] : 1;

$session_id = isset( $_COOKIE['cps_chat_session'] ) ? sanitize_text_field( $_COOKIE['cps_chat_session'] ) : '';
if ( empty( $session_id ) ) {
	$session_id = 'cps_' . wp_generate_uuid4();
	setcookie( 'cps_chat_session', $session_id, time() + ( 86400 * 30 ), '/' );
}
?>

<style>
	#cps-chat-widget {
		--cps-button-color: <?php echo esc_html( $button_color ); ?>;
		--cps-header-color: <?php echo esc_html( $header_color ); ?>;
		--cps-chat-bg: <?php echo esc_html( $chat_bg_color ); ?>;
		--cps-user-msg-color: <?php echo esc_html( $user_message_color ); ?>;
		--cps-bot-msg-color: <?php echo esc_html( $bot_message_color ); ?>;
	}

	#cps-chat-toggle {
		position: fixed;
		bottom: 20px;
		<?php echo 'left' === $position ? 'left: 20px;' : 'right: 20px;'; ?>
		width: 60px;
		height: 60px;
		border-radius: 50%;
		background: var(--cps-button-color);
		border: none;
		cursor: pointer;
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
		z-index: 9999;
		display: flex;
		align-items: center;
		justify-content: center;
		transition: transform 0.3s ease, opacity 0.3s ease;
	}

	#cps-chat-toggle:hover {
		transform: scale(1.05);
	}

	#cps-chat-toggle svg {
		width: 28px;
		height: 28px;
		fill: #fff;
		transition: transform 0.3s ease;
	}

	#cps-chat-toggle.cps-open svg.chat-icon {
		display: none;
	}

	#cps-chat-toggle:not(.cps-open) svg.close-icon {
		display: none;
	}

	#cps-chat-container {
		position: fixed;
		bottom: 90px;
		<?php echo 'left' === $position ? 'left: 20px;' : 'right: 20px;'; ?>
		width: 380px;
		max-width: calc(100vw - 40px);
		max-height: calc(100vh - 120px);
		background: var(--cps-chat-bg);
		border-radius: 12px;
		box-shadow: 0 5px 40px rgba(0, 0, 0, 0.16);
		z-index: 9999;
		display: none;
		flex-direction: column;
		overflow: hidden;
		font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
	}

	#cps-chat-container.cps-open {
		display: flex;
		animation: cpsSlideUp 0.3s ease;
	}

	@keyframes cpsSlideUp {
		from {
			opacity: 0;
			transform: translateY(20px);
		}
		to {
			opacity: 1;
			transform: translateY(0);
		}
	}

	.cps-chat-header {
		background: var(--cps-header-color);
		color: #fff;
		padding: 16px 20px;
		display: flex;
		align-items: center;
		justify-content: space-between;
	}

	.cps-chat-header-info {
		display: flex;
		align-items: center;
		gap: 12px;
	}

	.cps-chat-avatar {
		width: 40px;
		height: 40px;
		border-radius: 50%;
		background: rgba(255, 255, 255, 0.2);
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.cps-chat-avatar svg {
		width: 24px;
		height: 24px;
		fill: #fff;
	}

	.cps-chat-title {
		font-size: 16px;
		font-weight: 600;
		margin: 0;
	}

	.cps-chat-status {
		font-size: 12px;
		opacity: 0.8;
	}

	.cps-chat-close {
		background: none;
		border: none;
		cursor: pointer;
		padding: 4px;
		opacity: 0.8;
		transition: opacity 0.2s;
	}

	.cps-chat-close:hover {
		opacity: 1;
	}

	.cps-chat-close svg {
		width: 20px;
		height: 20px;
		fill: #fff;
	}

	.cps-chat-messages {
		flex: 1;
		overflow-y: auto;
		padding: 20px;
		display: flex;
		flex-direction: column;
		gap: 16px;
	}

	.cps-message {
		max-width: 80%;
		padding: 12px 16px;
		border-radius: 18px;
		font-size: 14px;
		line-height: 1.5;
		word-wrap: break-word;
	}

	.cps-message.cps-user {
		background: var(--cps-user-msg-color);
		color: #fff;
		align-self: flex-end;
		border-bottom-right-radius: 4px;
	}

	.cps-message.cps-bot,
	.cps-message.cps-admin {
		background: var(--cps-bot-msg-color);
		color: #333;
		align-self: flex-start;
		border-bottom-left-radius: 4px;
	}

	.cps-message-time {
		font-size: 10px;
		opacity: 0.6;
		margin-top: 4px;
	}

	.cps-typing-indicator {
		display: none;
		align-self: flex-start;
		background: var(--cps-bot-msg-color);
		padding: 12px 16px;
		border-radius: 18px;
		border-bottom-left-radius: 4px;
	}

	.cps-typing-indicator.cps-visible {
		display: flex;
		gap: 4px;
		align-items: center;
	}

	.cps-typing-dot {
		width: 8px;
		height: 8px;
		background: #999;
		border-radius: 50%;
		animation: cpsTyping 1.4s infinite;
	}

	.cps-typing-dot:nth-child(2) {
		animation-delay: 0.2s;
	}

	.cps-typing-dot:nth-child(3) {
		animation-delay: 0.4s;
	}

	@keyframes cpsTyping {
		0%, 60%, 100% {
			transform: translateY(0);
		}
		30% {
			transform: translateY(-4px);
		}
	}

	.cps-chat-input-area {
		padding: 16px;
		border-top: 1px solid rgba(0, 0, 0, 0.1);
		display: flex;
		flex-direction: column;
		gap: 12px;
	}

	.cps-chat-user-info {
		display: flex;
		gap: 8px;
	}

	.cps-chat-user-info input {
		flex: 1;
		padding: 8px 12px;
		border: 1px solid #ddd;
		border-radius: 8px;
		font-size: 13px;
	}

	.cps-chat-user-info input:focus {
		outline: none;
		border-color: var(--cps-button-color);
	}

	.cps-chat-input-row {
		display: flex;
		gap: 8px;
	}

	.cps-chat-input {
		flex: 1;
		padding: 12px 16px;
		border: 1px solid #ddd;
		border-radius: 24px;
		font-size: 14px;
		resize: none;
		max-height: 100px;
		font-family: inherit;
	}

	.cps-chat-input:focus {
		outline: none;
		border-color: var(--cps-button-color);
	}

	.cps-chat-send {
		width: 44px;
		height: 44px;
		border-radius: 50%;
		background: var(--cps-button-color);
		border: none;
		cursor: pointer;
		display: flex;
		align-items: center;
		justify-content: center;
		transition: transform 0.2s ease;
		flex-shrink: 0;
	}

	.cps-chat-send:hover {
		transform: scale(1.05);
	}

	.cps-chat-send:disabled {
		opacity: 0.5;
		cursor: not-allowed;
	}

	.cps-chat-send svg {
		width: 20px;
		height: 20px;
		fill: #fff;
	}

	@media (max-width: 480px) {
		#cps-chat-container {
			width: 100%;
			height: 100%;
			max-width: 100%;
			max-height: 100%;
			bottom: 0;
			right: 0;
			border-radius: 0;
		}

		#cps-chat-toggle {
			bottom: 10px;
			right: 10px;
			width: 56px;
			height: 56px;
		}
	}
</style>

<div id="cps-chat-widget">
	<button id="cps-chat-toggle" aria-label="<?php esc_attr_e( 'Toggle chat', 'cari-prop-shop-chat' ); ?>">
		<svg class="chat-icon" viewBox="0 0 24 24">
			<path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/>
		</svg>
		<svg class="close-icon" viewBox="0 0 24 24">
			<path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
		</svg>
	</button>

	<div id="cps-chat-container" role="dialog" aria-label="<?php esc_attr_e( 'Chat window', 'cari-prop-shop-chat' ); ?>">
		<div class="cps-chat-header">
			<div class="cps-chat-header-info">
				<div class="cps-chat-avatar">
					<svg viewBox="0 0 24 24">
						<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
					</svg>
				</div>
				<div>
					<h3 class="cps-chat-title"><?php echo esc_html( $company_name ); ?></h3>
					<span class="cps-chat-status"><?php _e( 'We\'re online', 'cari-prop-shop-chat' ); ?></span>
				</div>
			</div>
			<button class="cps-chat-close" aria-label="<?php esc_attr_e( 'Close chat', 'cari-prop-shop-chat' ); ?>">
				<svg viewBox="0 0 24 24">
					<path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
				</svg>
			</button>
		</div>

		<div class="cps-chat-messages" id="cps-messages">
			<div class="cps-message cps-bot">
				<?php echo esc_html( $welcome_message ); ?>
			</div>
		</div>

		<div class="cps-typing-indicator" id="cps-typing">
			<span class="cps-typing-dot"></span>
			<span class="cps-typing-dot"></span>
			<span class="cps-typing-dot"></span>
		</div>

		<div class="cps-chat-input-area">
			<div class="cps-chat-user-info">
				<input type="text" id="cps-visitor-name" placeholder="<?php esc_attr_e( 'Your name', 'cari-prop-shop-chat' ); ?>" />
				<input type="email" id="cps-visitor-email" placeholder="<?php esc_attr_e( 'Email (optional)', 'cari-prop-shop-chat' ); ?>" />
			</div>
			<div class="cps-chat-input-row">
				<textarea id="cps-message-input" class="cps-chat-input" placeholder="<?php esc_attr_e( 'Type a message...', 'cari-prop-shop-chat' ); ?>" rows="1"></textarea>
				<button id="cps-send-btn" class="cps-chat-send" aria-label="<?php esc_attr_e( 'Send message', 'cari-prop-shop-chat' ); ?>">
					<svg viewBox="0 0 24 24">
						<path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
					</svg>
				</button>
			</div>
		</div>
	</div>
</div>

<script>
(function() {
	var sessionId = '<?php echo esc_js( $session_id ); ?>';
	var autoOpen = <?php echo $auto_open ? 'true' : 'false'; ?>;
	var autoOpenDelay = <?php echo intval( $auto_open_delay ); ?>;
	var showTypingIndicator = <?php echo $typing_indicator ? 'true' : 'false'; ?>;
	var lastMessageId = 0;
	var pollingInterval = null;

	var chatToggle = document.getElementById('cps-chat-toggle');
	var chatContainer = document.getElementById('cps-chat-container');
	var chatClose = document.querySelector('.cps-chat-close');
	var messagesContainer = document.getElementById('cps-messages');
	var messageInput = document.getElementById('cps-message-input');
	var sendBtn = document.getElementById('cps-send-btn');
	var typingIndicator = document.getElementById('cps-typing');

	function openChat() {
		chatToggle.classList.add('cps-open');
		chatContainer.classList.add('cps-open');
		messageInput.focus();
		loadMessages();
		startPolling();
	}

	function closeChat() {
		chatToggle.classList.remove('cps-open');
		chatContainer.classList.remove('cps-open');
		stopPolling();
	}

	function toggleChat() {
		if (chatContainer.classList.contains('cps-open')) {
			closeChat();
		} else {
			openChat();
		}
	}

	chatToggle.addEventListener('click', toggleChat);
	chatClose.addEventListener('click', closeChat);

	function formatTime(dateString) {
		var date = new Date(dateString);
		var hours = date.getHours();
		var minutes = date.getMinutes();
		var ampm = hours >= 12 ? 'pm' : 'am';
		hours = hours % 12;
		hours = hours ? hours : 12;
		minutes = minutes < 10 ? '0' + minutes : minutes;
		return hours + ':' + minutes + ' ' + ampm;
	}

	function createMessageElement(message) {
		var div = document.createElement('div');
		div.className = 'cps-message cps-' + message.sender_type;
		div.dataset.id = message.id;

		var textDiv = document.createElement('div');
		textDiv.textContent = message.message;

		var timeDiv = document.createElement('div');
		timeDiv.className = 'cps-message-time';
		timeDiv.textContent = formatTime(message.created_at);

		div.appendChild(textDiv);
		div.appendChild(timeDiv);

		return div;
	}

	function appendMessage(message) {
		var messageDiv = createMessageElement(message);
		messagesContainer.appendChild(messageDiv);
		messagesContainer.scrollTop = messagesContainer.scrollHeight;
		lastMessageId = Math.max(lastMessageId, parseInt(message.id));
	}

	function loadMessages() {
		jQuery.ajax({
			url: cpsChatData.ajaxUrl,
			type: 'POST',
			data: {
				action: 'cps_chat_get_messages',
				nonce: cpsChatData.nonce,
				session_id: sessionId,
				last_id: lastMessageId
			},
			success: function(response) {
				if (response.success && response.data.messages) {
					response.data.messages.forEach(function(message) {
						var existing = messagesContainer.querySelector('[data-id="' + message.id + '"]');
						if (!existing) {
							appendMessage(message);
						}
					});
				}
			}
		});
	}

	function sendMessage() {
		var message = messageInput.value.trim();
		var visitorName = document.getElementById('cps-visitor-name').value.trim() || 'Visitor';
		var visitorEmail = document.getElementById('cps-visitor-email').value.trim();

		if (!message) return;

		sendBtn.disabled = true;

		jQuery.ajax({
			url: cpsChatData.ajaxUrl,
			type: 'POST',
			data: {
				action: 'cps_chat_send_message',
				nonce: cpsChatData.nonce,
				session_id: sessionId,
				message: message,
				sender_type: 'visitor',
				visitor_name: visitorName,
				visitor_email: visitorEmail
			},
			success: function(response) {
				messageInput.value = '';
				messageInput.style.height = 'auto';
				loadMessages();

				if (cpsChatData.options.enable_notifications && showTypingIndicator) {
					showTyping();
					setTimeout(function() {
						hideTyping();
						loadMessages();
					}, 1500);
				}
			},
			complete: function() {
				sendBtn.disabled = false;
				messageInput.focus();
			}
		});
	}

	function showTyping() {
		typingIndicator.classList.add('cps-visible');
		messagesContainer.appendChild(typingIndicator);
		messagesContainer.scrollTop = messagesContainer.scrollHeight;
	}

	function hideTyping() {
		typingIndicator.classList.remove('cps-visible');
	}

	function startPolling() {
		if (pollingInterval) return;
		pollingInterval = setInterval(loadMessages, 5000);
	}

	function stopPolling() {
		if (pollingInterval) {
			clearInterval(pollingInterval);
			pollingInterval = null;
		}
	}

	sendBtn.addEventListener('click', sendMessage);

	messageInput.addEventListener('keypress', function(e) {
		if (e.key === 'Enter' && !e.shiftKey) {
			e.preventDefault();
			sendMessage();
		}
	});

	messageInput.addEventListener('input', function() {
		this.style.height = 'auto';
		this.style.height = Math.min(this.scrollHeight, 100) + 'px';
	});

	if (autoOpen) {
		setTimeout(openChat, autoOpenDelay);
	}
})();
</script>