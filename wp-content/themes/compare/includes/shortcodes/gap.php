<?php
function compare_gap_func( $atts, $content ){
	extract( shortcode_atts( array(
		'height' => '',
	), $atts ) );

	return '<span style="height: '.esc_attr( $height ).'; display: block;"></span>';
}

add_shortcode( 'gap', 'compare_gap_func' );

function compare_gap_params(){
	return array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Gap Height","compare"),
			"param_name" => "height",
			"value" => '',
			"description" => __("Input gap height.","compare")
		),
	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => __("Gap", 'compare'),
	   "base" => "gap",
	   "category" => __('Content', 'compare'),
	   "params" => compare_gap_params()
	) );
}
?>