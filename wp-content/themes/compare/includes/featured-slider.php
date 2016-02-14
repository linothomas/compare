<?php

global $compare_slugs;
if( is_tax($compare_slugs['product-cat'] ) ){
	$slug = get_query_var( $compare_slugs['product-cat'] );
	$sliders = get_posts( array(
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'post_type' => 'slider',
		'post_meta' => array(
			array(
				'key' => 'slider_cat',
				'value' => $slug,
				'compare' => ''
			)
		)
	) );

	if( !empty( $sliders ) ){
		$slider_id = $sliders[0]->ID;
	}
}
if( !empty( $slider_id ) ){
	?>
	<div class="featured-slider-wrap">
		
		<div class="featured-slider-loader embed-responsive embed-responsive-16by9">
			<div class="featured-slider-loader-holder embed-responsive-item">
				<i class="fa fa-spin fa-spinner"></i>
			</div>
		</div>
		
		<ul class="list-unstyled featured-slider">
			<?php
			$slides = get_post_meta( $slider_id, 'slides' );
			if( !empty( $slides ) ){
				foreach( $slides as $slide ){
					echo '<li><a href="'.esc_url( $slide['slider_link'] ).'">'.wp_get_attachment_image( $slide['slider_image'], 'compare-slider-image' ).'</a></li>';
				}
			}
			?>
		</ul>
	</div>	
	<?php
}

?>