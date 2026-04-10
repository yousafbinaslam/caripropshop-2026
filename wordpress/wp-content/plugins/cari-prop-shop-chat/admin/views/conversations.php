<div class="wrap cps-chat-admin">
	<h1><?php _e( 'Chat Conversations', 'cari-prop-shop-chat' ); ?></h1>

	<div class="cps-chat-conversations-list">
		<table class="widefat striped">
			<thead>
				<tr>
					<th><?php _e( 'ID', 'cari-prop-shop-chat' ); ?></th>
					<th><?php _e( 'Visitor', 'cari-prop-shop-chat' ); ?></th>
					<th><?php _e( 'Email', 'cari-prop-shop-chat' ); ?></th>
					<th><?php _e( 'Status', 'cari-prop-shop-chat' ); ?></th>
					<th><?php _e( 'Last Activity', 'cari-prop-shop-chat' ); ?></th>
					<th><?php _e( 'Unread', 'cari-prop-shop-chat' ); ?></th>
					<th><?php _e( 'Actions', 'cari-prop-shop-chat' ); ?></th>
				</tr>
			</thead>
			<tbody id="cps-conversations-list">
				<?php
				if ( ! empty( $conversations ) ) :
					foreach ( $conversations as $conv ) :
				?>
						<tr data-conversation-id="<?php echo esc_attr( $conv['id'] ); ?>">
							<td><?php echo esc_html( $conv['id'] ); ?></td>
							<td>
								<strong><?php echo esc_html( $conv['visitor_name'] ); ?></strong>
							</td>
							<td><?php echo esc_html( $conv['visitor_email'] ); ?></td>
							<td>
								<span class="cps-status cps-status-<?php echo esc_attr( $conv['status'] ); ?>">
									<?php echo esc_html( ucfirst( $conv['status'] ) ); ?>
								</span>
							</td>
							<td><?php echo esc_html( date( 'M j, g:i a', strtotime( $conv['last_activity'] ) ) ); ?></td>
							<td>
								<?php if ( $conv['unread_count'] > 0 ) : ?>
									<span class="cps-badge"><?php echo esc_html( $conv['unread_count'] ); ?></span>
								<?php else : ?>
									<span class="cps-badge cps-badge-zero">0</span>
								<?php endif; ?>
							</td>
							<td>
								<button class="button cps-view-conversation" data-id="<?php echo esc_attr( $conv['id'] ); ?>">
									<?php _e( 'View', 'cari-prop-shop-chat' ); ?>
								</button>
							</td>
						</tr>
					<?php
					endforeach;
				else :
					?>
						<tr>
							<td colspan="7"><?php _e( 'No conversations yet.', 'cari-prop-shop-chat' ); ?></td>
						</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

	<div id="cps-conversation-modal" class="cps-modal" style="display: none;">
		<div class="cps-modal-content">
			<div class="cps-modal-header">
				<h2><?php _e( 'Conversation Details', 'cari-prop-shop-chat' ); ?></h2>
				<span class="cps-modal-close">&times;</span>
			</div>
			<div class="cps-modal-body">
				<div class="cps-conversation-info">
					<p><strong><?php _e( 'Visitor:', 'cari-prop-shop-chat' ); ?></strong> <span id="cps-conv-visitor"></span></p>
					<p><strong><?php _e( 'Email:', 'cari-prop-shop-chat' ); ?></strong> <span id="cps-conv-email"></span></p>
					<p><strong><?php _e( 'Session:', 'cari-prop-shop-chat' ); ?></strong> <span id="cps-conv-session"></span></p>
				</div>
				<div class="cps-messages-container" id="cps-messages-container">
				</div>
				<div class="cps-reply-form">
					<textarea id="cps-reply-message" placeholder="<?php esc_attr_e( 'Type your reply...', 'cari-prop-shop-chat' ); ?>"></textarea>
					<button class="button button-primary" id="cps-send-reply"><?php _e( 'Send Reply', 'cari-prop-shop-chat' ); ?></button>
				</div>
			</div>
		</div>
	</div>
</div>