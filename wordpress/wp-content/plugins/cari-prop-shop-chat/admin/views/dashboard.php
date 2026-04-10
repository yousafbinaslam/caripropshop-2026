<div class="wrap cps-chat-admin">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<div class="cps-chat-stats">
		<div class="cps-stat-box">
			<span class="cps-stat-number"><?php echo esc_html( $stats['total_conversations'] ); ?></span>
			<span class="cps-stat-label"><?php _e( 'Total Conversations', 'cari-prop-shop-chat' ); ?></span>
		</div>
		<div class="cps-stat-box">
			<span class="cps-stat-number"><?php echo esc_html( $stats['active_conversations'] ); ?></span>
			<span class="cps-stat-label"><?php _e( 'Active', 'cari-prop-shop-chat' ); ?></span>
		</div>
		<div class="cps-stat-box">
			<span class="cps-stat-number"><?php echo esc_html( $stats['unread_messages'] ); ?></span>
			<span class="cps-stat-label"><?php _e( 'Unread Messages', 'cari-prop-shop-chat' ); ?></span>
		</div>
		<div class="cps-stat-box">
			<span class="cps-stat-number"><?php echo esc_html( $stats['today_conversations'] ); ?></span>
			<span class="cps-stat-label"><?php _e( 'Today', 'cari-prop-shop-chat' ); ?></span>
		</div>
	</div>

	<div class="cps-chat-quick-actions">
		<a href="<?php echo admin_url( 'admin.php?page=cps-chat-conversations' ); ?>" class="button button-primary">
			<?php _e( 'View All Conversations', 'cari-prop-shop-chat' ); ?>
		</a>
		<a href="<?php echo admin_url( 'admin.php?page=cps-chat-settings' ); ?>" class="button">
			<?php _e( 'Settings', 'cari-prop-shop-chat' ); ?>
		</a>
	</div>

	<div class="cps-chat-recent-activity">
		<h2><?php _e( 'Recent Activity', 'cari-prop-shop-chat' ); ?></h2>
		<?php
		$recent_conversations = CPS_Chat_Storage::get_all_conversations( 1, 5 );
		if ( ! empty( $recent_conversations ) ) :
		?>
			<table class="widefat striped">
				<thead>
					<tr>
						<th><?php _e( 'Visitor', 'cari-prop-shop-chat' ); ?></th>
						<th><?php _e( 'Email', 'cari-prop-shop-chat' ); ?></th>
						<th><?php _e( 'Status', 'cari-prop-shop-chat' ); ?></th>
						<th><?php _e( 'Last Activity', 'cari-prop-shop-chat' ); ?></th>
						<th><?php _e( 'Unread', 'cari-prop-shop-chat' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $recent_conversations as $conv ) : ?>
						<tr>
							<td>
								<a href="<?php echo admin_url( 'admin.php?page=cps-chat-conversations&conversation_id=' . $conv['id'] ); ?>">
									<?php echo esc_html( $conv['visitor_name'] ); ?>
								</a>
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
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php else : ?>
			<p><?php _e( 'No conversations yet.', 'cari-prop-shop-chat' ); ?></p>
		<?php endif; ?>
	</div>
</div>