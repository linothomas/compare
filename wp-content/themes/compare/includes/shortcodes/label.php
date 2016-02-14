<?php
function compare_label_func( $atts, $content ){
	extract( shortcode_atts( array(
		'text' => '',
		'bg_color' => '',
		'font_color' => '',
	), $atts ) );

	return '<span class="label label-default" style="color: '.$font_color.'; background-color: '.$bg_color.'">'.$text.'</span>';
}

add_shortcode( 'label', 'compare_label_func' );

function compare_label_params(){
	return array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Text","compare"),
			"param_name" => "text",
			"value" => '',
			"description" => __("Input label text.","compare")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Background Color Color","compare"),
			"param_name" => "bg_color",
			"value" => '',
			"description" => __("Select background color of the label.","compare")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Text Color","compare"),
			"param_name" => "font_color",
			"value" => '',
			"description" => __("Select font color for the label text.","compare")
		),

	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => __("Label", 'compare'),
	   "base" => "label",
	   "category" => __('Content', 'compare'),
	   "params" => compare_label_params()
	) );
}

?>