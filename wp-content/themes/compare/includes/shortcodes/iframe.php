<?php
function compare_iframe_func( $atts, $content ){
	extract( shortcode_atts( array(
		'link' => '',
		'proportion' => '',
	), $atts ) );

	$random = compare_random_string();

	return '
		<div class="embed-responsive embed-responsive-'.$proportion.'">
		  <iframe class="embed-responsive-item" src="'.esc_url( $link ).'"></iframe>
		</div>';
}

add_shortcode( 'iframe', 'compare_iframe_func' );

function compare_iframe_params(){
	return array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Iframe link","compare"),
			"param_name" => "link",
			"value" => '',
			"description" => __("Input link you want to embed.","compare")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => __("Iframe Proportion","compare"),
			"param_name" => "proportion",
			"value" => array(
				__( '4 by 3', 'compare' ) => '4by3',
				__( '16 by 9', 'compare' ) => '16by9',
			),
			"description" => __("Select iframe proportion.","compare")
		),

	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => __("Iframe", 'compare'),
	   "base" => "iframe",
	   "category" => __('Content', 'compare'),
	   "params" => compare_iframe_params()
	) );
}

?>