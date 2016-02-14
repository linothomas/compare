<?php
function compare_sidebar_func( $atts, $content ){
	extract( shortcode_atts( array(
		'home_sidebar' => '',
	), $atts ) );

	ob_start();
	if( is_active_sidebar( $home_sidebar ) ){
		dynamic_sidebar( $home_sidebar );
	}
	$content = ob_get_contents();
	ob_end_clean();

	return '<div class="shortcode shortcode-sidebar">'.$content.'</div>';
}

add_shortcode( 'sidebar', 'compare_sidebar_func' );

function compare_sidebar_params(){
	$home_sidebars = compare_get_option( 'home_sidebars' );
	if( empty( $home_sidebars ) ){
		$home_sidebars = 2;
	}

	$sidebars = array();

	for( $i=1; $i<=$home_sidebars; $i++ ){
		$sidebars[__( 'Home Sidebar ', 'compare' ).$i] = 'home-sidebar-'.$i;
	}
	return array(
		array(
			"type" => "dropdown",
			"value" => $sidebars,
			"holder" => "div",
			"class" => "",
			"heading" => __("Home Sidebar","compare"),
			"param_name" => "home_sidebar",
			"description" => __("Select Sidebar To Show","compare")
		),
	);
}
?>