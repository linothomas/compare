<?php
function compare_button_func( $atts, $content ){
	extract( shortcode_atts( array(
		'text' => '',
		'link' => '',
		'target' => '',
		'bg_color' => '',
		'bg_color_hvr' => '',
		'border_radius' => '',
		'icon' => '',
		'font_color' => '',
		'font_color_hvr' => '',
		'size' => 'normal',
		'align' => '',
		'btn_width' => 'normal',
		'inline' => 'no',
		'margin' => ''
	), $atts ) );

	$rnd = compare_random_string();

	$style_css = '
	<style>
		a.'.$rnd.', a.'.$rnd.':active, a.'.$rnd.':visited, a.'.$rnd.':focus{
			display: '.( $btn_width == 'normal' ? 'inline-block' : 'block' ).';
			'.( !empty( $bg_color ) ? 'background-color: '.$bg_color.';' : '' ).'
			'.( !empty( $font_color ) ? 'color: '.$font_color.';' : '' ).'
			'.( !empty( $border_radius ) ? 'border-radius: '.$border_radius : '' ).'
		}
		a.'.$rnd.':hover{
			display: '.( $btn_width == 'normal' ? 'inline-block' : 'block' ).';
			'.( !empty( $bg_color_hvr ) ? 'background-color: '.$bg_color_hvr.';' : '' ).'
			'.( !empty( $font_color_hvr ) ? 'color: '.$font_color_hvr.';' : '' ).'
		}		
	</style>
	';

	return compare_shortcode_style( $style_css ).'
	<div class="btn-wrap" style="margin: '.esc_attr( $margin ).'; text-align: '.$align.'; '.( $inline == 'yes' ? 'display: inline-block;' : '' ).' '.( $inline == 'yes' && $align == 'right' ? 'float: right;' : '' ).'">
		<a href="'.esc_url( $link ).'" class="btn btn-default '.$size.' '.$rnd.' '.( $link != '#' && $link[0] == '#' ? 'slideTo' : '' ).'" target="'.esc_attr( $target ).'">
			'.( $icon != 'No Icon' && $icon != '' ? '<i class="fa fa-'.$icon.' '.( empty( $text ) ? 'no-margin' : '' ).'"></i>' : '' ).'
			'.$text.'
		</a>
	</div>';
}

add_shortcode( 'button', 'compare_button_func' );

function compare_button_params(){
	return array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Button Text","compare"),
			"param_name" => "text",
			"value" => '',
			"description" => __("Input button text.","compare")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Button Link","compare"),
			"param_name" => "link",
			"value" => '',
			"description" => __("Input button link.","compare")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => __("Select Window","compare"),
			"param_name" => "target",
			"value" => array(
				__( 'Same Window', 'compare' ) => '_self',
				__( 'New Window', 'compare' ) => '_blank',
			),
			"description" => __("Select window where to open the link.","compare")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Background Color","compare"),
			"param_name" => "bg_color",
			"value" => '',
			"description" => __("Select button background color.","compare")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Background Color On Hover","compare"),
			"param_name" => "bg_color_hvr",
			"value" => '',
			"description" => __("Select button background color on hover.","compare")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Button Border Radius","compare"),
			"param_name" => "border_radius",
			"value" => '',
			"description" => __("Input button border radius. For example 5px or 5ox 9px 0px 0px or 50% or 50% 50% 20% 10%.","compare")
		),
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
			"heading" => __("Font Color","compare"),
			"param_name" => "font_color",
			"value" => '',
			"description" => __("Select button font color.","compare")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Font Color On Hover","compare"),
			"param_name" => "font_color_hvr",
			"value" => '',
			"description" => __("Select button font color on hover.","compare")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => __("Button Size","compare"),
			"param_name" => "size",
			"value" => array(
				__( 'Normal', 'compare' ) => '',
				__( 'Medium', 'compare' ) => 'medium',
				__( 'Large', 'compare' ) => 'large',
			),
			"description" => __("Select button size.","compare")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => __("Button Align","compare"),
			"param_name" => "align",
			"value" => array(
				__( 'Left', 'compare' ) => 'left',
				__( 'Center', 'compare' ) => 'center',
				__( 'Right', 'compare' ) => 'right',
			),
			"description" => __("Select button align.","compare")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => __("Select Button Width","compare"),
			"param_name" => "btn_width",
			"value" => array(
				__( 'Normal', 'compare' ) => 'normal',
				__( 'Full Width', 'compare' ) => 'full',
			),
			"description" => __("Select button alwidthign.","compare")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => __("Display Inline","compare"),
			"param_name" => "inline",
			"value" => array(
				__( 'No', 'compare' ) => 'no',
				__( 'Yes', 'compare' ) => 'yes',
			),
			"description" => __("Display button inline.","compare")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Button Margins","compare"),
			"param_name" => "margin",
			"value" => '',
			"description" => __("Add button margins.","compare")
		),
	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => __("Button", 'compare'),
	   "base" => "button",
	   "category" => __('Content', 'compare'),
	   "params" => compare_button_params()
	) );
}

?>