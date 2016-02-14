<?php $post_format = get_post_format(); ?>
<?php if( $post_format == 'quote' && compare_has_media() ): ?>
	<div <?php post_class( 'white-block clearfix' ) ?>>
		<?php
		if( has_post_thumbnail() ){
			the_post_thumbnail( 'compare-quote-box' );
		}
		else{
			echo '<img src="'.esc_url( get_template_directory_uri().'/images/product-placeholder.jpg' ).'">';
		}
		include( get_template_directory() . '/media/media'.( !empty( $post_format ) ? '-'.$post_format : '' ).'.php' );
		?>	
	</div>
<?php else: ?>
	<div <?php post_class( 'white-block clearfix' ) ?>>
		<?php if( $has_media ): ?>
			<div class="white-block-media">
			<?php
			$image_size = 'compare-blog-box';
			include( get_template_directory() . '/media/media'.( !empty( $post_format ) ? '-'.$post_format : '' ).'.php' );
			?>
			</div>
		<?php endif; ?>
		<?php if( is_sticky() ): ?>
			<div class="sticky">
				<i class="fa fa-paperclip"></i>
			</div>
		<?php endif; ?>
		<div class="white-block-content">
			<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
			<?php
			$excerpt = get_the_excerpt();
			if( strlen( $excerpt ) > 145 ){
				$excerpt = substr( $excerpt, 0, 145 ).'...';
			}
			echo '<p>'.$excerpt.'</p>';
			?>
			<p class="blog-meta">
				<a href="<?php the_permalink() ?>">
					<?php the_time( 'm/d/Y' ); ?>
				</a>
				<?php _e( ' by ', 'compare' ); the_author(); _e( ' with ', 'compare' ); comments_number( __( '0 comments', 'compare' ), __( '1 comment', 'compare' ), __( '% comments', 'compare' ) )  ?>
			</p>
		</div>	
	</div>
<?php endif; ?>