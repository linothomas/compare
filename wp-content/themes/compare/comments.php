<?php
	/**********************************************************************
	***********************************************************************
	PROPERSHOP COMMENTS
	**********************************************************************/
	
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ( 'Please do not load this page directly. Thanks!' );
	if ( post_password_required() ) {
		return;
	}
	$products_single = compare_get_option( 'products_single' );
	if( isset( $_GET['variation'] ) ){
		$products_single = 'style'.$_GET['variation'];
	}	
	global $compare_can_review;
	$compare_can_review = 'can_review';
?>
<?php if ( comments_open() ) :?>


    <!-- row -->
    <div class="comments">
    	<?php if( have_comments() ): ?>
    		<?php if( ( $products_single !== 'style1' && is_singular( 'product' ) ) || !is_singular( 'product' ) ): ?>
	    	<div class="white-block">
				<div class="white-title clearfix">
					<div class="white-block-border clearfix">
						 <div class="pull-left">
							<?php echo compare_get_white_title_icon(); ?>
							<h3><?php echo is_singular( 'product' ) ? __( 'Reviews', 'compare' ) : __( 'Comments', 'compare' ); ?></h3>
						</div>
					</div>
				</div>
				<?php endif; ?>

		        <div class="white-block-content">
					
						
						<?php 
						wp_list_comments( array(
							'type' => 'comment',
							'callback' => 'compare_comments',
							'end-callback' => 'compare_end_comments',
							'style' => 'div'
						)); 
						?>

		                <!-- pagination -->
						<?php
							$comment_links = paginate_comments_links( 
								array(
									'echo' => false,
									'type' => 'array',
									'prev_text' => __( 'Prev', 'compare' ),
									'next_text' => __( 'Next', 'compare' )
								) 
							);
							if( !empty( $comment_links ) ):
						?>					
			                <div class="custom-pagination">
			                    <ul class="pagination">
									<?php echo  compare_format_pagination( $comment_links ); ?>
								</ul>
							</div>
						<?php endif; ?>
		                <!-- .pagination -->

		        </div>   
		     <?php if( ( $products_single !== 'style1' && is_singular( 'product' ) ) || !is_singular( 'product' ) ): ?>
	    	</div>
	    	<?php endif; ?>
    	<?php endif; ?>
    	
    	<?php if( $compare_can_review == 'can_review' || !is_singular( 'product' ) ): ?>
	    	<?php if( ( $products_single !== 'style1' && is_singular( 'product' ) ) || !is_singular( 'product' ) ): ?>
	    	<div class="white-block">
	    	<?php endif; ?>
				<div class="white-title clearfix">
					<div class="white-block-border clearfix">
						 <div class="pull-left">
							<?php echo compare_get_white_title_icon(); ?>
							<h3><?php echo is_singular( 'product' ) ? __( 'Leave Review', 'compare' ) : __( 'Leave Comment', 'compare' ); ?></h3>
						</div>
					</div>
				</div>

	    		<div class="white-block-content">
						<?php
						$ratings = '';
						if( is_singular( 'product' )  ){
							$col = 5;
							$ratings = ( is_user_logged_in() ? '' : '<div class="col-md-2">' ).'<div class="input-group"><p class="comment-review">
					    		<label>'.__( 'Rating', 'compare' ).' <span class="required">*</span></label>
					    		<input type="hidden" id="review" name="review" value=""/>
					    		<span class="bottom-ratings">
					    			<i class="fa fa-star-o"></i>
					    			<i class="fa fa-star-o"></i>
					    			<i class="fa fa-star-o"></i>
					    			<i class="fa fa-star-o"></i>
					    			<i class="fa fa-star-o"></i>
					    		</span>
					    	</p></div>'.( is_user_logged_in() ? '' : '</div>' );
						}
						else{
							$col = 6;
							$ratings = '<input type="hidden" id="review" name="review" value="-1"/>';
						}
						?> 
						<?php
							$comments_args = array(
								'label_submit'	=>	is_singular( 'product' ) ? __( 'SUBMIT REVIEW', 'compare' ) : __( 'SUBMIT COMMENT', 'compare' ),
								'title_reply'	=>	'',
								'fields'		=>	apply_filters( 'comment_form_default_fields', array(
														'author' => '<div class="row"><div class="col-md-'.esc_attr( $col ).'">
																		<div class="input-group">
																			<label for="author">'.__( 'Name', 'compare' ).' <span class="required">*</span></label>
			                          										<input type="text" class="form-control" id="author" name="author">
		                        										</div>
		                        									</div>',
														'email'	 => '<div class="col-md-'.esc_attr( $col ).'">
																		<div class="input-group">
																			<label for="email">'.__( 'Email', 'compare' ).' <span class="required">*</span></label>
			                          										<input type="text" class="form-control" id="email" name="email">
		                        										</div>
		                        									</div>'.( !is_user_logged_in() ? $ratings : '' ).'</div>'
													)),
								'comment_field'	=>	( is_user_logged_in() ? $ratings : '' ).'
														<div class="input-group">
															<label for="comment">'.__( 'Comment', 'compare' ).' <span class="required">*</span></label>
															<textarea class="form-control" id="comment" name="comment"></textarea>
		        										</div>
		        									',
								'cancel_reply_link' => __( 'or cancel reply', 'compare' ),
								'comment_notes_after' => '',
								'comment_notes_before' => ''
							);
							comment_form( $comments_args );	
						?>
	    		</div>
	    	<?php if( ( $products_single !== 'style1' && is_singular( 'product' ) ) || !is_singular( 'product' ) ): ?>
	    	</div>
	    	<?php endif; ?>
	    <?php elseif( $compare_can_review == 'already_reviewed' ): ?>
			<div class="white-title clearfix">
				<div class="white-block-border clearfix">
					 <div class="pull-left">
						<?php echo compare_get_white_title_icon(); ?>
						<h3><?php echo is_singular( 'product' ) ? __( 'Leave Review', 'compare' ) : __( 'Leave Comment', 'compare' ); ?></h3>
					</div>
				</div>
			</div>	    	
	    	<p class="already_reviewed"><?php _e( 'You have already reviewed this product', 'compare' ) ?></p>
    	<?php endif; ?>

    </div>
    <!-- .row -->

<?php endif; ?>