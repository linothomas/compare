<?php 
	get_header(); 
?>
<section>
	<div class="container">
		<div class="white-block">
            <div class="white-title clearfix">
				<div class="white-block-border clearfix">
					 <div class="pull-left">
						<?php echo compare_get_white_title_icon(); ?>
						<h3><?php _e( '404 Error Page', 'compare' ); ?></h3>
					</div>
				</div>
            </div>  		
			<div class="error-image">
				<?php
				$error_img = compare_get_option( 'error_img' );
				if( !empty( $error_img['url'] ) ){
					echo '<img src="'.esc_url( $error_img['url'] ).'" width="'.esc_attr( $error_img['width'] ).'" height="'.esc_attr( $error_img['height'] ).'" alt="404">';
				}
				?>
			</div>
			<p><?php _e( 'Sorry but this post or page does not exists!', 'compare' ) ?></p>				
		</div>
		<?php echo do_shortcode( '[products tabs="latest" products="10" rows="1"][/products]' ); ?>
	</div>
</section>
<?php get_footer(); ?>