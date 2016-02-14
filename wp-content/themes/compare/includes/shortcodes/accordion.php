<?php
function compare_accordion_func( $atts, $content ){
	extract( shortcode_atts( array(
		'titles' => '',
		'contents' => ''
	), $atts ) );

	$titles = explode( "/n/", $titles );
	$contents = explode( "/n/", $contents );

	$titles_html = '';
	$contents_html = '';

	$rnd = compare_random_string();

	$html = '';

	if( !empty( $titles ) ){
		for( $i=0; $i<sizeof( $titles ); $i++ ){
			if( !empty( $titles[$i] ) ){
				$html .= '
				  <div class="panel panel-default">
				    <div class="panel-heading" role="tab" id="heading_'.$i.'">
				      <div class="panel-title">
				        <a class="'.( $i !== 0 ? 'collapsed' : '' ).'" data-toggle="collapse" data-parent="#accordion_'.$rnd.'" href="#coll_'.$i.'_'.$rnd.'" aria-expanded="true" aria-controls="coll_'.$i.'_'.$rnd.'">
				        	'.$titles[$i].'
				        	<i class="fa fa-chevron-circle-down animation"></i>
				        </a>
				      </div>
				    </div>
				    <div id="coll_'.$i.'_'.$rnd.'" class="panel-collapse collapse '.( $i == 0 ? 'in' : '' ).'" role="tabpanel" aria-labelledby="heading_'.$i.'">
				      <div class="panel-body">
				        '.( !empty( $contents[$i] ) ? apply_filters( 'the_content', $contents[$i] ) : '' ).'
				      </div>
				    </div>
				  </div>
				';
			}
		}
	}

	return '
		<div class="panel-group shortcode" id="accordion_'.$rnd.'" role="tablist" aria-multiselectable="true">
		'.$html.'
		</div>';
}

add_shortcode( 'accordion', 'compare_accordion_func' );

function compare_accordion_params(){
	return array(
		array(
			"type" => "textarea",
			"holder" => "div",
			"class" => "",
			"heading" => __("Titles","compare"),
			"param_name" => "titles",
			"value" => '',
			"description" => __("Input accordion titles separated by /n/.","compare")
		),
		array(
			"type" => "textarea_raw_html",
			"holder" => "div",
			"class" => "",
			"heading" => __("Contents","compare"),
			"param_name" => "contents",
			"value" => '',
			"description" => __("Input accordion contents separated by /n/.","compare")
		),

	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => __("Accordion", 'compare'),
	   "base" => "accordion",
	   "category" => __('Content', 'compare'),
	   "params" => compare_accordion_params()
	) );
}
?>