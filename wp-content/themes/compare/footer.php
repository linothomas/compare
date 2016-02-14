<?php get_sidebar('footer'); ?>

<?php
$footer_copyrights = compare_get_option( 'footer_copyrights' );
$footer_copyrights_image = compare_get_option( 'footer_copyrights_image' );

if( !empty( $footer_copyrights ) || !empty( $footer_copyrights_image['url'] ) ):
?>
	<footer class="footer">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php
					$show_to_top = compare_get_option( 'show_to_top' );
					if( $show_to_top == 'yes' ):
					?>
						<div class="to-top">
							<a href="javascript:;">
								<i class="fa fa-angle-double-up"></i>
							</a>
						</div>
					<?php endif; ?>

					<div class="pull-left">
						<?php echo wp_kses_post( $footer_copyrights ); ?>
					</div>

					<div class="pull-right">
						<?php
							if( !empty( $footer_copyrights_image['url'] ) ){
								?>
								<img src="<?php echo esc_url( $footer_copyrights_image['url'] ) ?>" alt="copyrights_image" width="<?php echo esc_attr( $footer_copyrights_image['width'] ) ?>" height="<?php echo esc_attr( $footer_copyrights_image['height'] ) ?>">
								<?php
							}						
						?>
					</div>

				</div>
			</div>
		</div>
	</footer>
<?php
endif;
?>

<!-- Modal -->
<div class="modal fade" id="feed_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><?php _e( 'XML / CSV Feed Structure', 'compare' ) ?></h4>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table data-toggle="table" data-search="false" data-classes="table table-striped">
						<thead>
						    <tr>
						        <th data-field="element">
						        	<?php _e( 'ELEMENT', 'compare' ) ?>
						        </th>
						        <th data-field="exaplanation">
						        	<?php _e( 'EXPLANATION', 'compare' ) ?>
						        </th>
						        <th data-field="example">
						        	<?php _e( 'EXAMPLE', 'compare' ) ?>
						        </th>
						        <th data-field="required">
						        	<?php _e( 'REQUIRED', 'compare' ) ?>
						        </th>
						    </tr>
						</thead>
						<tbody>
							<tr>
								<td>
									pid
								</td>
								<td>
									<?php _e( 'Unique identification of the product. This is being used to check if product already exists', 'compare' ) ?>
								</td>
								<td>
									123456
								</td>
								<td>
									<?php _e( 'Yes', 'compare' ) ?>
								</td>
							</tr>
							<tr>
								<td>
									name
								</td>
								<td>
									<?php _e( 'Name of the product. It will be used if the product is not already imported.', 'compare' ) ?>
								</td>
								<td>
									<?php _e( 'ASUS Notebook', 'compare' ) ?>
								</td>
								<td>
									<?php _e( 'Yes', 'compare' ) ?>
								</td>
							</tr>
							<tr>
								<td>
									description
								</td>
								<td>
									<?php _e( 'Description of the product. It will be used if the product is not already imported.', 'compare' ) ?>
								</td>
								<td>
									<?php _e( 'Best computer out there, with plenty of features,...', 'compare' ) ?>
								</td>
								<td>
									<?php _e( 'No', 'compare' ) ?>
								</td>
							</tr>
							<tr>
								<td>
									short_desc
								</td>
								<td>
									<?php _e( 'Short description of the product. It will be used if the product is not already imported.', 'compare' ) ?>
								</td>
								<td>
									<?php _e( 'Best computer out there, with plenty of features.', 'compare' ) ?>
								</td>
								<td>
									<?php _e( 'No', 'compare' ) ?>
								</td>
							</tr>
							<tr>
								<td>
									url
								</td>
								<td>
									<?php _e( 'URL to the product on your store. If this is empty link to your store will be used instead.', 'compare' ) ?>
								</td>
								<td>
									<?php _e( 'http://www.google.com', 'compare' ) ?>
								</td>
								<td>
									<?php _e( 'No', 'compare' ) ?>
								</td>
							</tr>
							<tr>
								<td>
									categories
								</td>
								<td>
									<?php _e( 'Comma separated list of the categories. Comma separation is for the nesting of the categories.', 'compare' ) ?>
								</td>
								<td>
									<?php _e( 'Cloth, Man, Shoes', 'compare' ) ?>
								</td>
								<td>
									<?php _e( 'Yes', 'compare' ) ?>
								</td>
							</tr>
							<tr>
								<td>
									tags
								</td>
								<td>
									<?php _e( 'Comma separated list of the tags.', 'compare' ) ?>
								</td>
								<td>
									<?php _e( 'black,new,brand', 'compare' ) ?>
								</td>
								<td>
									<?php _e( 'No', 'compare' ) ?>
								</td>
							</tr>
							<tr>
								<td>
									brand
								</td>
								<td>
									<?php _e( 'Manufacturer name of the product.', 'compare' ) ?>
								</td>
								<td>
									<?php _e( 'apple', 'compare' ) ?>
								</td>
								<td>
									<?php _e( 'Yes', 'compare' ) ?>
								</td>
							</tr>
							<tr>
								<td>
									price
								</td>
								<td>
									<?php _e( 'Price of the product. Field requires number only with decimals separated with dot (.) if the price has any.', 'compare' ) ?>
								</td>
								<td>
									<?php _e( '10.99', 'compare' ) ?>
								</td>
								<td>
									<?php _e( 'Yes', 'compare' ) ?>
								</td>
							</tr>
							<tr>
								<td>
									shipping
								</td>
								<td>
									<?php _e( 'Shipping of the product. Field requires number only with decimals separated with dot (.) if the price has any.', 'compare' ) ?>
								</td>
								<td>
									<?php _e( '10.99', 'compare' ) ?>
								</td>
								<td>
									<?php _e( 'No', 'compare' ) ?>
								</td>
							</tr>
							<tr>
								<td>
									shipping_comment
								</td>
								<td>
									<?php _e( 'Small desciption for the shipping comment.', 'compare' ) ?>
								</td>
								<td>
									<?php _e( 'We do not deliver on Saturday.', 'compare' ) ?>
								</td>
								<td>
									<?php _e( 'No', 'compare' ) ?>
								</td>
							</tr>
							<tr>
								<td>
									image
								</td>
								<td>
									<?php _e( 'Input URL to the featured image of the product.', 'compare' ) ?>
								</td>
								<td>
									<?php _e( 'https://image_link.png', 'compare' ) ?>
								</td>
								<td>
									<?php _e( 'No', 'compare' ) ?>
								</td>
							</tr>						
						</tbody>
					</table>
				</div>
				<a href="<?php echo esc_url( get_template_directory_uri().'/includes/feed-example.xml' ) ?>" target="_blank"><?php _e( 'See working XML example', 'compare' ) ?></a>
				<a href="<?php echo esc_url( get_template_directory_uri().'/includes/feed-example.csv' ) ?>" target="_blank"><?php _e( 'See working CSV example', 'compare' ) ?></a>
			</div>
		</div>
	</div>
</div>
<?php
wp_footer();
?>
</body>
</html>