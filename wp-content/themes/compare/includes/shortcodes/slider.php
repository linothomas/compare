<?php
function compare_slider_func( $atts, $content ){
	extract( shortcode_atts( array(
		'slider_id' => '',
	), $atts ) );	
	ob_start();
	include( get_template_directory() . '/includes/featured-slider.php' );
	$content = ob_get_contents();
	ob_end_clean();

	return '<div class="shortcode shortcode-slider">'.$content.'</div>';
}

add_shortcode( 'slider', 'compare_slider_func' );

function compare_slider_params(){
	return array(
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => __("Slider","compare"),
			"param_name" => "slider_id",
			"value" => compare_get_post_list( 'slider', 'left' ),
			"description" => __("Select slider to show","compare")
		),
	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => __("Slider", 'compare'),
	   "base" => "slider",
	   "category" => __('Content', 'compare'),
	   "params" => compare_slider_params()
	) );
}
?>