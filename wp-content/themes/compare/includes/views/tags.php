<?php if( $products_single !== 'style1' ): ?>
<div class="white-block">
	<div class="white-title clearfix">
		<div class="white-block-border clearfix">
			<div class="pull-left">
				<?php echo compare_get_white_title_icon(); ?>
				<h3><?php _e( 'Tags', 'compare' ) ?></h3>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<div class="white-block-content">
		<?php
		global $COMPARE_SEARCH_URL;
		global $compare_slugs;
		$tags = get_the_terms( get_the_ID(), 'product-tag' );
		$tags_list = array();
		if( !empty( $tags ) ){
			foreach( $tags as $tag ){
				$tags_list[] = '<a href="'.esc_attr( add_query_arg( array( $compare_slugs['product-tag'] => $tag->slug ), $COMPARE_SEARCH_URL ) ).'">'.$tag->name.'</a>';
			}
		}

		echo join( ', ', $tags_list );
		?>
	</div>

	<?php if( $products_single !== 'style1' ): ?>
	</div>
<?php endif; ?>