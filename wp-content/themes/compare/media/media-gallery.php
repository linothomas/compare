<?php
	$post_meta = get_post_custom();
	$gallery_images = compare_smeta_images( 'gallery_images', get_the_ID(), array() );
	if( !empty( $gallery_images ) ){
		?>
		<ul class="list-unstyled post-slider embed-responsive-item">
			<?php
			foreach( $gallery_images as $image_id ){
				echo '<li>'.wp_get_attachment_image( $image_id, $image_size ).'</li>';
			}
			?>
		</ul>
		<?php
	}
	else{
		the_post_thumbnail( $image_size );
	}
?>