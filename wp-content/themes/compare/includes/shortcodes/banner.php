<?php
function compare_banner_func( $atts, $content ){
	extract( shortcode_atts( array(
		'link' => '',
		'bg_image' => '',
	), $atts ) );	
	return '<a href="'.esc_url( $link ).'" class="banner-link shortcode shortcode-banner">'.wp_get_attachment_image( $bg_image, 'full' ).'</a>';
}

add_shortcode( 'banner', 'compare_banner_func' );

function compare_banner_params(){
	return array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Banner Link","compare"),
			"param_name" => "link",
			"value" => '',
			"description" => __("Input banner link","compare")
		),
		array(
			"type" => "attach_image",
			"holder" => "div",
			"class" => "",
			"heading" => __("Image","compare"),
			"param_name" => "bg_image",
			"value" => '',
			"description" => __("Select image","compare")
		),		
	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => __("Banner", 'compare'),
	   "base" => "banner",
	   "category" => __('Content', 'compare'),
	   "params" => compare_banner_params()
	) );
}
?>