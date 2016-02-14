<div class="wrap">
	<h2><?php _e( 'Stores', 'compare' ) ?> 
		<a href="<?php echo esc_url( add_query_arg( array( 'action' => 'new' ), $permalink ) ) ?>" class="add-new-h2"><?php _e( 'Add New', 'compare' ) ?></a>
	</h2>

	<?php echo !empty( $message ) ? $message : ''; ?>
	
	<ul class="subsubsub">
		<li class="all"><a href="edit.php?post_type=product" class="current"><?php _e( 'All', 'compare' ) ?> <span class="count">(0)</span></a></li>
	</ul>
	<form id="posts-filter" method="post" action="<?php echo esc_url( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ); ?>">

		<div class="tablenav top">
			<div class="alignleft actions bulkactions">
				<label for="bulk-action-selector-top" class="screen-reader-text"><?php _e( 'Select bulk action', 'compare' ) ?></label>
				<select name="action" id="bulk-action-selector-top">
					<option value="" selected="selected"><?php _e( 'Bulk Actions', 'compare' ) ?></option>
					<option value="delete"><?php _e( 'Delete', 'compare' ) ?></option>
				</select>
				<input type="submit" id="doaction" class="button action" value="Apply">
			</div>
			<br class="clear">
		</div>
		<table class="wp-list-table widefat fixed striped posts">
			<thead>
				<tr>
					<th scope="col" id="cb" class="manage-column column-cb check-column" style="">
						<label class="screen-reader-text" for="cb-select-all-1"><?php _e( 'Select All', 'compare' ) ?></label>
						<input id="cb-select-all-1" type="checkbox">
					</th>
					<th scope="col" id="title" class="manage-column column-author" style="">
						<?php _e( 'Store Logo', 'compare' ) ?>
					</th>
					<th scope="col" id="author" class="manage-column column-author" style="">
						<?php _e( 'Store Name', 'compare' ) ?>
					</th>
					<th scope="col" id="comments" class="manage-column column-author" style="">
						<?php _e( 'Store Slug', 'compare' ) ?>
					</th>
					<th scope="col" id="date" class="manage-column column-title" style="">
						<?php _e( 'Store URL', 'compare' ) ?>
					</th>
					<th scope="col" id="date" class="manage-column column-author" style="">
						<?php _e( 'Click Through', 'compare' ) ?>
					</th>
					<th scope="col" id="date" class="manage-column column-author" style="">
						<?php _e( 'Status', 'compare' ) ?>
					</th>					
					<th scope="col" id="action" class="manage-column column-author" style="">
						<?php _e( 'Action', 'compare' ) ?>
					</th>					
				</tr>
			</thead>

			<tbody id="the-list">
				<?php
				if( !empty( $stores ) ){
					foreach( $stores as $store ){
						?>
						<tr class="hentry alternate">
							<th scope="row" class="check-column">
								<label class="screen-reader-text" for="cb-select-<?php echo esc_attr( $store->store_id ) ?>"><?php echo esc_attr( $store->store_name ) ?></label>
								<input id="cb-select-<?php echo esc_attr( $store->store_id ) ?>" type="checkbox" name="stores[]" value="<?php echo esc_attr( $store->store_id ) ?>">
								<div class="locked-indicator"></div>
							</th>
							<td class="post-title page-title column-author">
								<?php echo wp_get_attachment_image( $store->store_logo, 'thumbnail' ); ?>
							</td>
							<td class="author column-title">
								<?php echo esc_html( $store->store_name ); ?>
							</td>
							<td class="tags column-author">
								<?php echo esc_html( $store->store_slug ) ?>
							</td>
							<td class="comments column-author">
								<a href="<?php echo esc_url( $store->store_url ) ?>" target="_blank">
									<?php _e( 'Visit Website', 'compare' ) ?>
								</a>
							</td>
							<td class="comments column-author">
								<?php echo esc_html( $store->store_clicks ) ?>
							</td>
							<td class="comments column-author">
								<?php
								if( $store->store_status == '0' ){
									_e( 'Not Paid', 'compare' );
								}
								else{
									_e( 'Paid', 'compare' );
								}
								?>
							</td>							
							<td class="comments column-author">
								<a href="<?php echo esc_url( add_query_arg( array( 'store_id' => $store->store_id, 'action' => 'edit' ), $permalink ) ) ?>">
									<?php _e( 'Edit', 'compare' ) ?>
								</a>
								|
								<a href="<?php echo esc_url( add_query_arg( array( 'store_id' => $store->store_id, 'action' => 'import' ), $permalink ) ) ?>">
									<?php _e( 'Import', 'compare' ) ?>
								</a>
								|
								<a href="<?php echo esc_url( add_query_arg( array( 'store_id' => $store->store_id, 'action' => 'delete' ), $permalink ) ) ?>">
									<?php _e( 'Delete', 'compare' ) ?>
								</a>
							</td>							
						</tr>						
						<?php
					}
				}
				else{ ?>
					<tr class="no-items">
						<td class="colspanchange" colspan="6">
							<?php _e( 'No posts found.', 'compare' ) ?>
						</td>
					</tr>				
				<?php 
				}
				?>
			</tbody>

		</table>
	</form>
	<br class="clear">
</div>