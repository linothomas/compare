<?php
function compare_row_func( $atts, $content ){

	return '<div class="row">'.do_shortcode( $content ).'</div>';
}

add_shortcode( 'row', 'compare_row_func' );

function compare_row_params(){
	return array();
}
?>