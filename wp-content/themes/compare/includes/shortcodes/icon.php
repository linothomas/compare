<?php
function compare_icon_func( $atts, $content ){
	extract( shortcode_atts( array(
		'icon' => '',
		'color' => '',
		'size' => '',
	), $atts ) );

	return '<span class="fa fa-'.$icon.'" style="color: '.$color.'; font-size: '.$size.'; margin: 0px 2px;"></span>';
}

add_shortcode( 'icon', 'compare_icon_func' );

function compare_icon_params(){
	return array(
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => __("Select Icon","compare"),
			"param_name" => "icon",
			"value" => compare_awesome_icons_list(),
			"description" => __("Select an icon you want to display.","compare")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Icon Color","compare"),
			"param_name" => "color",
			"value" => '',
			"description" => __("Select color of the icon.","compare")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Icon Size","compare"),
			"param_name" => "size",
			"value" => '',
			"description" => __("Input size of the icon.","compare")
		),

	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => __("Icon", 'compare'),
	   "base" => "icon",
	   "category" => __('Content', 'compare'),
	   "params" => compare_icon_params()
	) );
}

?>