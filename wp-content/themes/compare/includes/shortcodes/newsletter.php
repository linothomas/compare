<?php
function compare_newsletter_func( $atts, $content ){
	extract( shortcode_atts( array(
		'title' => '',
		'subtitle' => '',
		'placeholder' => '',
		'button_text' => '',
		'bg_image' => '',
	), $atts ) );	
	$style = '';
	if( !empty( $bg_image ) ){
		$image_data = wp_get_attachment_image_src( $bg_image, 'full' );
		$style = 'background-image: url('.$image_data[0].')';
	}
	return '<div class="shortcode white-block newsletter" style="'.esc_attr( $style ).'">
		'.( !empty( $title ) ? '<h2>'.$title.'</h2>' : '' ).'
		'.( !empty( $subtitle ) ? '<p>'.$subtitle.'</p>' : '' ).'
		<div class="newsletter-form">
			<input type="text" class="form-control" placeholder="'.esc_attr( $placeholder ).'">
			<a href="javascript:;" class="btn subscribe"><i class="fa fa-envelope-o"></i> '.$button_text.'</a> 
		</div>
		<div class="subscribe-result"></div>
	</div>';
}

add_shortcode( 'newsletter', 'compare_newsletter_func' );

function compare_newsletter_params(){
	return array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Title","compare"),
			"param_name" => "title",
			"value" => '',
			"description" => __("Input title text","compare")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Subtitle","compare"),
			"param_name" => "subtitle",
			"value" => '',
			"description" => __("Input subtitle text","compare")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Placeholder","compare"),
			"param_name" => "placeholder",
			"value" => '',
			"description" => __("Input placeholder text","compare")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Button Text","compare"),
			"param_name" => "button_text",
			"value" => '',
			"description" => __("Input button text","compare")
		),
		array(
			"type" => "attach_image",
			"holder" => "div",
			"class" => "",
			"heading" => __("Background Image","compare"),
			"param_name" => "bg_image",
			"value" => '',
			"description" => __("Select background image","compare")
		),		
	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => __("Newsletter", 'compare'),
	   "base" => "newsletter",
	   "category" => __('Content', 'compare'),
	   "params" => compare_newsletter_params()
	) );
}
?>