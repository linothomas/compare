<?php
function compare_alert_func( $atts, $content ){
	extract( shortcode_atts( array(
		'text' => '',
		'border_color' => '',
		'bg_color' => '',
		'font_color' => '',
		'icon' => '',
		'closeable' => 'no',
		'close_icon_color' => '',
		'close_icon_color_hvr' => '',
	), $atts ) );

	$rnd = compare_random_string();

	$style_css = '
		<style>
			.'.$rnd.'.alert .close{
				color: '.$close_icon_color.';
			}
			.'.$rnd.'.alert .close:hover{
				color: '.$close_icon_color_hvr.';
			}
		</style>
	';

	return compare_shortcode_style( $style_css ).'
	<div class="alert '.$rnd.' alert-default '.( $closeable == 'yes' ? 'alert-dismissible' : '' ).'" role="alert" style=" color: '.$font_color.'; border-color: '.$border_color.'; background-color: '.$bg_color.';">
		'.( !empty( $icon ) && $icon !== 'No Icon' ? '<i class="fa fa-'.$icon.'"></i>' : '' ).'
		'.$text.'
		'.( $closeable == 'yes' ? '<button type="button" class="close" data-dismiss="alert"> <span aria-hidden="true">×</span> <span class="sr-only">'.__( 'Close', 'compare' ).'</span> </button>' : '' ).'
	</div>';
}

add_shortcode( 'alert', 'compare_alert_func' );

function compare_alert_params(){
	return array(
		array(
			"type" => "textarea",
			"holder" => "div",
			"class" => "",
			"heading" => __("Text","compare"),
			"param_name" => "text",
			"value" => '',
			"description" => __("Input alert text.","compare")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Border Color","compare"),
			"param_name" => "border_color",
			"value" => '',
			"description" => __("Select border color for the alert box.","compare")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Background Color Color","compare"),
			"param_name" => "bg_color",
			"value" => '',
			"description" => __("Select background color of the alert box.","compare")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Text Color","compare"),
			"param_name" => "font_color",
			"value" => '',
			"description" => __("Select font color for the alert box text.","compare")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => __("Icon","compare"),
			"param_name" => "icon",
			"value" => compare_awesome_icons_list(),
			"description" => __("Select icon.","compare")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => __("Closeable","compare"),
			"param_name" => "closeable",
			"value" => array(
				__( 'No', 'compare' ) => 'no',
				__( 'Yes', 'compare' ) => 'yes'
			),
			"description" => __("Enable or disable alert closing.","compare")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Close Icon Color","compare"),
			"param_name" => "close_icon_color",
			"value" => '',
			"description" => __("Select color for the close icon.","compare")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Close Icon Color On Hover","compare"),
			"param_name" => "close_icon_color_hvr",
			"value" => '',
			"description" => __("Select color for the close icon on hover.","compare")
		),
	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => __("Alert", 'compare'),
	   "base" => "alert",
	   "category" => __('Content', 'compare'),
	   "params" => compare_alert_params()
	) );
}
?>