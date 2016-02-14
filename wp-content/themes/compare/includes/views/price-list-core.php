			<?php
			if( empty( $post_id ) ){
				if( isset( $_GET['post_id'] ) ){
					$post_id = $_GET['post_id'];
				}
				else{
					$post_id = get_the_ID();
				}
			}
			global $wpdb;
			$results = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM {$wpdb->prefix}feed_list AS feed LEFT JOIN {$wpdb->prefix}stores AS stores ON feed.store_id = stores.store_id WHERE post_id = %d ORDER BY feed.price DESC",
					$post_id
				)
			);


			?>
			<div class="bt-table table-responsive">
				<table data-toggle="table" data-search="false" data-classes="table table-striped" data-sort-name="price" data-sort-order="asc">
					<thead>
					    <tr>
					        <th data-field="logo" data-sortable="false">
					        	<i class="fa fa-shopping-cart"></i>
					        	<?php _e( 'STORE LOGO', 'compare' ) ?>
					        </th>
					        <th data-field="date" data-sortable="true">
					        	<i class="fa fa-clock-o"></i>
					        	<?php _e( 'DATE', 'compare' ) ?>
					        </th>
					        <th data-field="price" data-sortable="true">
					        	<i class="fa fa-dollar"></i>
					        	<?php _e( 'PRICE', 'compare' ) ?>
					        </th>
					        <th data-field="shipping" data-sortable="false">
					        	<i class="fa fa-truck"></i>
					        	<?php _e( 'SHIPPING', 'compare' ) ?>
					        </th>
					        <th data-field="link">
					        	<i class="fa fa-external-link-square"></i>
					        	<?php _e( 'LINK', 'compare' ) ?>
					        </th>
					        <?php if( is_admin() ): ?>
						        <th data-field="action" data-sortable="false">
						        	<i class="fa fa-sliders"></i>
						        	<?php _e( 'ACTION', 'compare' ) ?>
						        </th>					        	
					        <?php endif; ?>
					    </tr>
					</thead>
					<?php
					if( !empty( $results ) ){
						?>
						<tbody>
						<?php
						foreach( $results as $result ){
							?>
							<tr data-id="<?php echo esc_attr( $result->feed_id ) ?>">
								<td>
									<?php echo wp_get_attachment_image( $result->store_logo, 'full' ) ?>
								</td>
								<td>
									<?php $unix = strtotime( $result->time ); echo date_i18n( 'd.m.Y', $unix ); ?>
								</td>
								<td class="price">
									<?php echo compare_format_currency_number( $result->price ) ?>
								</td>
								<td class="shipping">
									<?php
									if( !empty( $result->shipping ) ){
										echo compare_format_currency_number( $result->shipping );
									}
									else {
										_e( 'Free', 'compare' );
									}

									if( !empty( $result->shipping_comment ) ){
										echo '<a href="javascript:;" data-toggle="tooltip" data-placement="top" title="'.esc_attr( $result->shipping_comment ).'"><i class="fa fa-info-circle"></i></a>';
									}
									?>
								</td>
								<td>
									<?php if( !is_admin() ): ?>
										<a href="<?php echo esc_url( add_query_arg( array( 'post_id' => get_the_ID(), 'store_id' => $result->store_id ) ) ) ?>" target="_blank"><?php echo  $products_single == 'style2' ? _e( 'Website', 'compare' ) : _e( 'Visit Store Website', 'compare' ); ?></a>
									<?php else: ?>
										<a href="<?php echo esc_url( $result->product_link ) ?>" target="_blank"><?php _e( 'Visit Store Website', 'compare' ); ?></a>										
									<?php endif; ?>
								</td>
						        <?php if( is_admin() ): ?>
									<td>
										<a href="javascript:;" class="button edit-feed" data-feed_id="<?php echo esc_attr( $result->feed_id ) ?>">
											<?php _e('Edit', 'compare') ?>
										</a>
										<a href="javascript:;" class="button delete-feed" data-feed_id="<?php echo esc_attr( $result->feed_id ) ?>">
											<?php _e('Delete', 'compare') ?>
										</a>
									</td>
						        <?php endif; ?>								
							</tr>
							<?php
						}
						?>
						</tbody>
						<?php		
					}
					?>
				</table>
			</div>
			<?php if( is_admin() ): ?>
				<a href="javascript:;" class="button button-primary add-feed">
					<?php _e( 'Add', 'compare' ) ?>
				</a>
			<?php endif; ?>