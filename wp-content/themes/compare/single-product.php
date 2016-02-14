<?php
get_header();
the_post();
$products_single = compare_get_option( 'products_single' );
if( isset( $_GET['variation'] ) ){
	$products_single = 'style'.$_GET['variation'];
}
?>
<input type="hidden" class="post-id" value="<?php the_ID(); ?>">
<section>
	<div class="container">
		<div class="row">
			<div class="col-md-<?php echo $products_single == 'style1' || $products_single == 'style2' ? esc_attr( '9' ) : esc_attr( '12' ); ?>">
				<div class="<?php echo esc_attr( $products_single ) ?>">
					<div class="white-block">
						<div class="white-block-media">
							<?php			
							if( has_post_thumbnail() ){
								if( $products_single !== 'style3' ){
									the_post_thumbnail( 'post-thumbnail' );
								}
								else{
									the_post_thumbnail( 'compare-single-product-2' );
								}
							}
							?>
						</div>
						<div class="white-block-content">
							<h1><?php the_title(); ?></h1>
							<?php compare_get_ratings() ?>
							<hr />
							<?php echo apply_filters( 'the_content', get_post_meta( get_the_ID(), 'product_short', true ) ) ?>
						</div>
					</div>

					<?php if( empty( $products_single ) || $products_single == 'style1' ): ?>
						<div class="white-block">
							<div class="white-title clearfix">
								<div class="white-block-border clearfix">
									<div class="pull-left">
										<?php echo compare_get_white_title_icon(); ?>
										<ul class="nav nav-tabs" role="tablist">
											<li role="presentation" class="active"><a href="#prices" aria-controls="prices" role="tab" data-toggle="tab"><?php _e( 'Compare Prices', 'compare' ); ?></a></li>
											<li role="presentation"><a href="#description" aria-controls="description" role="tab" data-toggle="tab"><?php _e( 'Full Description', 'compare' ); ?></a></li>
											<li role="presentation"><a href="#reviews" aria-controls="reviews" role="tab" data-toggle="tab"><?php _e( 'Reviews', 'compare' ); ?></a></li>
											<li role="presentation"><a href="#tags" aria-controls="tags" role="tab" data-toggle="tab"><?php _e( 'Tags', 'compare' ); ?></a></li>
											<li role="presentation"><a href="#categories" aria-controls="categories" role="tab" data-toggle="tab"><?php _e( 'Categories', 'compare' ); ?></a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="prices">
									<?php include( get_template_directory() . '/includes/views/price-list.php' ) ?>
								</div>
								<div role="tabpanel" class="tab-pane" id="description">
									<?php include( get_template_directory() . '/includes/views/description.php' ) ?>
								</div>
								<div role="tabpanel" class="tab-pane" id="reviews">
									<?php include( get_template_directory() . '/includes/views/reviews.php' ) ?>
								</div>
								<div role="tabpanel" class="tab-pane" id="tags">
									<?php include( get_template_directory() . '/includes/views/tags.php' ) ?>
								</div>
								<div role="tabpanel" class="tab-pane" id="categories">
									<?php include( get_template_directory() . '/includes/views/categories.php' ) ?>
								</div>
							</div>							
						</div>

					<?php elseif( $products_single == 'style2' ): ?>
						<?php include( get_template_directory() . '/includes/views/price-list.php' ) ?>
						<?php include( get_template_directory() . '/includes/views/description.php' ) ?>
						<?php include( get_template_directory() . '/includes/views/reviews.php' ) ?>
						<?php include( get_template_directory() . '/includes/views/tags.php' ) ?>
						<?php include( get_template_directory() . '/includes/views/categories.php' ) ?>
					<?php elseif( $products_single == 'style3' ): ?>
						<?php include( get_template_directory() . '/includes/views/price-list.php' ) ?>
						<?php include( get_template_directory() . '/includes/views/description.php' ) ?>
						<?php include( get_template_directory() . '/includes/views/reviews.php' ) ?>
						<?php include( get_template_directory() . '/includes/views/tags.php' ) ?>
						<?php include( get_template_directory() . '/includes/views/categories.php' ) ?>
					<?php endif; ?>
				</div>

				<?php
				$similar_num = compare_get_option( 'similar_num' );
				if( !empty( $similar_num ) ):
					$product_cats = get_the_terms( get_the_ID(), 'product-cat' );
					$product_cats_list = array();
					if( !empty( $product_cats ) ){
						foreach( $product_cats as $product_cat ){
							$product_cats_list[] = $product_cat->slug;
						}
					}
					$args = array(
						'post_type' => 'product',
						'posts_per_page' => $similar_num,
						'post__not_in' => array( get_the_ID() ),
						'post_status' => 'publish',
						'tax_query' => array(
							'taxonomy' => 'product-cat',
							'field' => 'slug',
							'terms' => $product_cats_list
						)
					);
					
					$similar = new WP_Query( $args );
					$product_ids = wp_list_pluck( $similar->posts, 'ID' );
					$product_metas = compare_product_item_meta( $product_ids );

					if( $similar->have_posts() ):
					?>
					<div class="owl-parent">
						<div class="white-title clearfix">
							<div class="white-block-border clearfix">
								<div class="pull-left">
									<?php echo compare_get_white_title_icon(); ?>
									<h3><?php _e( 'Similar Products', 'compare' ) ?></h3>
								</div>
								<div class="pull-right">
									<a href="javascript:;" class="list-left">
										<i class="fa fa-angle-left"></i>
									</a>
									<a href="javascript:;" class="list-right">
										<i class="fa fa-angle-right"></i>
									</a>
								</div> 
							</div>
						</div>
						<div class="similar-slider" data-visible-items="<?php echo $products_single == 'style3' ? esc_attr('4') : esc_attr('3') ?>">
							<?php
							while( $similar->have_posts() ){
								$similar->the_post();
								include( get_template_directory() . '/includes/product-box.php' );
							}
							?>
						</div>
					</div>
					<?php endif; 
				endif;
				?>				

			</div>
			<?php if( $products_single == 'style1' || $products_single == 'style3' ): ?>
				<div class="col-md-3">
					<?php get_sidebar( 'product' ) ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>