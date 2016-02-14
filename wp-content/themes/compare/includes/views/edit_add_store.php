<div class="wrap">
	<h2><?php empty( $store ) ? _e( 'Add New Store', 'compare' ) : _e( 'Edit Store', 'compare' ) ?> </h2>
	<?php echo !empty( $message ) ? $message : ''; ?>
	<form id="posts-filter" method="post" action="<?php echo esc_url( add_query_arg( array( 'action' => 'save' ), $permalink ) ) ?>">
		<input type="hidden" name="store_id" value="<?php echo !empty( $store ) ? $store->store_id : '' ?>">
		<input type="hidden" name="old_slug" value="<?php echo !empty( $store ) ? $store->store_slug : '' ?>">
		<table class="form-table">
			<tbody>
				<tr class="form-field form-required">
					<th scope="row"><label for="store_name"><?php _e( 'Store Name', 'compare' ) ?> <span class="description"><?php _e( '(required)', 'compare' ) ?></span></label></th>
					<td><input name="store_name" type="text" id="store_name" value="<?php echo !empty( $store_name ) ? $store_name : '' ?>" aria-required="true"></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="store_slug"><?php _e( 'Store Slug', 'compare' ) ?> <span class="description"><?php _e( '(required)', 'compare' ) ?></span></label></th>
					<td><input name="store_slug" type="text" id="store_slug" value="<?php echo !empty( $store_slug ) ? $store_slug : '' ?>" aria-required="true"><br><span class="description"><?php _e( 'If this field is empty it will be generated from title', 'compare' )?></span></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="store_url"><?php _e( 'Store URL', 'compare' ) ?> <span class="description"><?php _e( '(required)', 'compare' ) ?></span></label></th>
					<td><input name="store_url" type="text" id="store_url" value="<?php echo !empty( $store_url ) ? $store_url : '' ?>" aria-required="true"></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="store_url"><?php _e( 'Store Logo', 'compare' ) ?> <span class="description"><?php _e( '(required)', 'compare' ) ?></span></label></th>
					<td>
						<div class="store_current_image">
						<?php
						if( !empty( $store_logo ) ){
							echo wp_get_attachment_image( $store_logo, 'thumbnail' );
							echo '<a href="javascript:;" class="remove_store_logo">X</a>';
						}
						?>
						</div>
						<a href="javascript:;" class="add_store_logo button"><?php _e( 'Select Image', 'compare' ) ?></a>
						<input name="store_logo" type="hidden" id="store_logo" value="<?php echo !empty( $store_logo ) ? $store_logo : '' ?>" aria-required="true">
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="store_clicks"><?php _e( 'Clicks Through', 'compare' ) ?></label></th>
					<td><input name="store_clicks" type="text" id="store_clicks" value="<?php echo !empty( $store_clicks ) ? $store_clicks : 0 ?>" aria-required="true"></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="store_contact_name"><?php _e( 'Store Contact Name', 'compare' ) ?> </label></th>
					<td><input name="store_contact_name" type="text" id="store_contact_name" value="<?php echo !empty( $store_contact_name ) ? $store_contact_name : '' ?>"></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="store_contact_email"><?php _e( 'Store Contact Email', 'compare' ) ?> </label></th>
					<td><input name="store_contact_email" type="text" id="store_contact_email" value="<?php echo !empty( $store_contact_email ) ? $store_contact_email : '' ?>"></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="store_contact_phone"><?php _e( 'Store Contact Phone', 'compare' ) ?> </label></th>
					<td><input name="store_contact_phone" type="text" id="store_contact_phone" value="<?php echo !empty( $store_contact_phone ) ? $store_contact_phone : '' ?>"></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="store_package"><?php _e( 'Store Package', 'compare' ) ?> </label></th>
					<td>
						<select name="store_package" id="store_package">
							<option value=""><?php _e( 'Select Package', 'compare' ); ?></option>
							<?php echo compare_list_packages( $store_package ); ?>
						</select>
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="store_expire_time"><?php _e( 'Store Expire Date', 'compare' ) ?> </label></th>
					<td>
						<input name="store_expire_time" type="text" id="store_expire_time" value="<?php echo !empty( $store_expire_time ) ? date( 'm/d/Y', $store_expire_time ) : '' ?>">
						<br><span class="description"><?php _e( 'Time must be inputed in format m/d/Y', 'compare' )?></span>
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="store_xml_feed"><?php _e( 'Store Feed Link', 'compare' ) ?> </label></th>
					<td><input name="store_xml_feed" type="text" id="store_xml_feed" value="<?php echo !empty( $store_xml_feed ) ? $store_xml_feed : '' ?>"></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="store_status"><?php _e( 'Store Status', 'compare' ) ?> </label></th>
					<td>
						<select name="store_status" id="store_status">
							<option value="1" <?php echo !empty( $store_status ) && $store_status == '1' ? 'selected="selected"' : '' ?>><?php _e( 'Paid', 'compare' ); ?></option>
							<option value="0" <?php echo empty( $store_status ) || $store_status == '0' ? 'selected="selected"' : '' ?>><?php _e( 'Not Paid', 'compare' ); ?></option>
						</select>
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="store_parser"><?php _e( 'Store Parser', 'compare' ) ?> </label></th>
					<td>
						<select name="store_parser" id="store_parser">
							<option value=""><?php _e( 'Default', 'compare' ) ?></option>
							<?php
							$parsers = compare_get_post_list( 'parser' );
							if( !empty( $parsers ) ){
								foreach( $parsers as $parser_id => $parser_name ){
									?>
									<option value="<?php echo esc_attr( $parser_id ) ?>" <?php echo !empty( $store_parser ) && $parser_id == $store_parser ? esc_attr( 'selected="selected' ) : '' ?>><?php echo esc_html( $parser_name ) ?></option>
									<?php
								}
							}
							?>
						</select>
					</td>
				</tr>			
				<tr class="form-field form-required">
					<th scope="row"></th>
					<td><input type="submit" class="button" value="<?php empty( $store ) ? esc_attr_e( 'Add Store', 'compare' ) : esc_attr_e( 'Edit Store', 'compare' ) ?>"></td>
				</tr>
			</tbody>
		</table>
	</form>
	<br class="clear">
</div>