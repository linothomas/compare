<?php if( $products_single !== 'style1' ): ?>
<div class="white-block">
	<div class="white-title clearfix">
		<div class="white-block-border clearfix">
			<div class="pull-left">
				<?php echo compare_get_white_title_icon(); ?>
				<h3><?php _e( 'Categories', 'compare' ) ?></h3>
			</div>
		</div>
	</div>
	<?php endif; ?>
	
	<div class="white-block-content">
		<?php
		global $COMPARE_SEARCH_URL;
		$cats = get_the_terms( get_the_ID(), 'product-cat' );
		$cats_list = array();
		if( !empty( $cats ) ){
			foreach( $cats as $cat ){
				$cats_list[] = '<a href="'.esc_attr( add_query_arg( array( $compare_slugs['product-cat'] => $cat->slug ), $COMPARE_SEARCH_URL ) ).'">'.$cat->name.'</a>';
			}
		}

		echo join( ', ', $cats_list );
		?>
	</div>

	<?php if( $products_single !== 'style1' ): ?>
	</div>
<?php endif; ?>