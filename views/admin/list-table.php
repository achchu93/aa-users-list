<?php
/**
 * Admin view for users list table
 *
 * @package AhamedArshad\UsersList
 * @since 1.0.0
 */

?>
<div class="wrap">
	<h2><?php echo esc_html( $table->get_table_title() ); ?></h2>
	<div id="nds-wp-list-table-demo">
		<div id="nds-post-body">
			<form id="nds-user-list-form" method="get">
				<?php $table->display(); ?>
			</form>
		</div>
	</div>
</div>
