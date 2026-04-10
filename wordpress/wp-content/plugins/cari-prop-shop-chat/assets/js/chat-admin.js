/**
 * CariPropShop Chat - Admin JavaScript
 */

(function($) {
	'use strict';

	var currentConversationId = null;

	$(document).ready(function() {
		initConversationModal();
		initReplyForm();
		initViewButtons();
	});

	function initConversationModal() {
		var modal = $('#cps-conversation-modal');
		var closeBtn = $('.cps-modal-close');

		closeBtn.on('click', function() {
			modal.hide();
			currentConversationId = null;
		});

		$(document).on('click', function(e) {
			if (e.target === modal[0]) {
				modal.hide();
				currentConversationId = null;
			}
		});
	}

	function initViewButtons() {
		$('.cps-view-conversation').on('click', function() {
			var conversationId = $(this).data('id');
			viewConversation(conversationId);
		});
	}

	function viewConversation(conversationId) {
		currentConversationId = conversationId;

		$.ajax({
			url: cpsChatAdminData.ajaxUrl,
			type: 'POST',
			data: {
				action: 'cps_chat_get_conversation',
				nonce: cpsChatAdminData.nonce,
				conversation_id: conversationId
			},
			beforeSend: function() {
				$('#cps-messages-container').html('<div class="cps-loading"></div>');
				$('#cps-conversation-modal').show();
			},
			success: function(response) {
				if (response.success) {
					var conversation = response.data.conversation;
					var messages = response.data.messages;

					$('#cps-conv-visitor').text(conversation.visitor_name);
					$('#cps-conv-email').text(conversation.visitor_email);
					$('#cps-conv-session').text(conversation.session_id);

					renderMessages(messages);

					markAsRead(conversationId);
				} else {
					$('#cps-messages-container').html('<p>Error loading conversation</p>');
				}
			},
			error: function() {
				$('#cps-messages-container').html('<p>Error loading conversation</p>');
			}
		});
	}

	function renderMessages(messages) {
		var container = $('#cps-messages-container');
		container.empty();

		if (!messages || messages.length === 0) {
			container.html('<p>No messages in this conversation.</p>');
			return;
		}

		messages.forEach(function(message) {
			var messageClass = message.sender_type === 'admin' ? 'cps-admin-message' : 'cps-visitor-message';
			var time = formatDateTime(message.created_at);

			var html = '<div class="' + messageClass + '">';
			html += '<div>' + escapeHtml(message.message) + '</div>';
			html += '<div class="cps-message-time">' + time + '</div>';
			html += '</div>';

			container.append(html);
		});

		container.scrollTop(container[0].scrollHeight);
	}

	function formatDateTime(dateString) {
		var date = new Date(dateString);
		var options = {
			month: 'short',
			day: 'numeric',
			hour: 'numeric',
			minute: '2-digit'
		};
		return date.toLocaleDateString('en-US', options);
	}

	function escapeHtml(text) {
		var div = document.createElement('div');
		div.textContent = text;
		return div.innerHTML;
	}

	function markAsRead(conversationId) {
		$.ajax({
			url: cpsChatAdminData.ajaxUrl,
			type: 'POST',
			data: {
				action: 'cps_chat_mark_read',
				nonce: cpsChatAdminData.nonce,
				conversation_id: conversationId
			}
		});
	}

	function initReplyForm() {
		$('#cps-send-reply').on('click', function() {
			var message = $('#cps-reply-message').val().trim();
			var conversationId = currentConversationId;

			if (!message || !conversationId) {
				return;
			}

			$.ajax({
				url: cpsChatAdminData.ajaxUrl,
				type: 'POST',
				data: {
					action: 'cps_chat_send_admin_reply',
					nonce: cpsChatAdminData.nonce,
					conversation_id: conversationId,
					message: message
				},
				beforeSend: function() {
					$('#cps-send-reply').prop('disabled', true).text('Sending...');
				},
				success: function(response) {
					if (response.success) {
						$('#cps-reply-message').val('');
						viewConversation(conversationId);
					} else {
						alert('Failed to send reply. Please try again.');
					}
				},
				complete: function() {
					$('#cps-send-reply').prop('disabled', false).text('Send Reply');
				}
			});
		});
	}

})(jQuery);