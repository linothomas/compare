<?php if( $products_single !== 'style1' ): ?>
<div class="white-block">
	<div class="white-title clearfix">
		<div class="white-block-border clearfix">
			<div class="pull-left">
				<?php echo compare_get_white_title_icon(); ?>
				<h3><?php _e( 'Description', 'compare' ) ?></h3>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<div class="white-block-content">
		<?php the_content() ?>
	</div>

	<?php if( $products_single !== 'style1' ): ?>
	</div>
<?php endif; ?>