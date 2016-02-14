<div class="white-block product-box">
	<div class="white-block-border">
		<div class="white-block-media">
			<div class="embed-responsive embed-responsive-4by3">
				<?php			
				if( has_post_thumbnail() ){
					the_post_thumbnail( 'compare-offer-box', array( 'class' => 'embed-responsive-item' ) );
				}
				else{
					echo '<img src="'.esc_url( get_template_directory_uri().'/images/product-placeholder.jpg' ).'">';
				}
				?>
			</div>
			<a class="overlay" href="<?php the_permalink() ?>">
				<i class="fa fa-compress"></i>
				<h3><?php _e( 'COMPARE', 'compare' ) ?></h3>
			</a>		
		</div>
		<div class="white-block-content">
			<p class="product-ratings">
				<?php compare_get_ratings() ?>
			</p>

			<h4>
				<a href="<?php the_permalink() ?>">
					<?php
					$title = get_the_title();
					if( strlen( $title ) > 40 ){
						$title = substr( $title, 0, 42 ).'...';
					}
					echo esc_html( $title );
					?>
				</a>
			</h4>

			<p class="product-meta">
				<?php
				$stores = !empty( $product_metas[get_the_ID()] ) ? $product_metas[get_the_ID()]['stores'] : 0;
				$min_price = !empty( $product_metas[get_the_ID()] ) ? $product_metas[get_the_ID()]['minPrice'] : 0;
				echo __( 'From ', 'compare' ).'<span>'.compare_format_currency_number( $min_price ).'</span>'.__( ' in ', 'compare' ).'<span>'.$stores.'</span>'.( $stores == 1 ? __( ' store', 'compare' ) : __( ' stores', 'compare' ) );
				?>
			</p>
		</div>
	</div>
</div>