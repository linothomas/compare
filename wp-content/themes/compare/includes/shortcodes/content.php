<?php
function compare_content_func( $atts, $content ){
	return '<div class="white-block"><div class="white-block-content">'.apply_filters( 'the_content', $content ).'</div></div>';
}
add_shortcode( 'content', 'compare_content_func' );
function compare_content_params(){
	return array();
}
?>