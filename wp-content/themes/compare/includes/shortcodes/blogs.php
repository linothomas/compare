<?php
function compare_blogs_func( $atts, $content ){
	extract( shortcode_atts( array(
		'title' => '',
		'items' => '10',
		'visible_items' => '2',
		'blogs_orderby' => 'date',
		'blogs_order' => 'DESC'
	), $atts ) );

	$html = '<div class="white-title clearfix">
				<div class="white-block-border clearfix">
					 <div class="pull-left">
						'.compare_get_white_title_icon().'
						'.( !empty( $title ) ? '<h3>'.$title.'</h3>' : '' ).'
					</div>
					<div class="pull-right">
						<a href="javascript:;" class="list-left">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="javascript:;" class="list-right">
							<i class="fa fa-angle-right"></i>
						</a>				
					</div>
				</div>
			</div>';

	
	$blogs = new WP_Query(array(
		'post_type' => 'post',
		'ignore_sticky_posts' => true,
		'posts_per_page' => $items,
		'post_status' => 'publish',
		'orderby' => $blogs_orderby,
		'order' => $blogs_order,
	));
	if( $blogs->have_posts() ){
		$html .= '<div class="blogs-slider" data-visible_items="'.esc_attr( $visible_items ).'">';
		while( $blogs->have_posts() ){
			$blogs->the_post();
			$has_media = compare_has_media();
			ob_start();
			include( get_template_directory() . '/includes/blog-box.php' );
			$html .= ob_get_contents();
			ob_end_clean();
		}
		$html .= '</div>';
	}

	wp_reset_postdata();

	return '<div class="owl-parent shortcode shortcode-blogs">'.$html.'</div>';
	
}

add_shortcode( 'blogs', 'compare_blogs_func' );

function compare_blogs_params(){
	return array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Title","compare"),
			"param_name" => "title",
			"value" => "",
			"description" => __("Input title.","compare")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Blogs","compare"),
			"param_name" => "items",
			"value" => '10',
			"description" => __("Input how many blog posts to display.","compare")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Visible Items","compare"),
			"param_name" => "visible_items",
			"value" => '2',
			"description" => __("Input how many blog posts to be visible.","compare")
		),		
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => __("Order By","compare"),
			"param_name" => "blogs_orderby",
			"value" => array(
				__( 'Date Added', 'compare' ) => 'date',
				__( 'Title', 'compare' ) => 'title',
			),
			"description" => __("Select by which field to order blogs.","compare")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => __("Order","compare"),
			"param_name" => "blogs_order",
			"value" => array(
				__( 'Ascending', 'compare' ) => 'ASC',
				__( 'Descending', 'compare' ) => 'DESC',
			),
			"description" => __("Select how to order blogs.","compare")
		),		
	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => __("Blogs", 'compare'),
	   "base" => "blogs",
	   "category" => __('Content', 'compare'),
	   "params" => compare_blogs_params()
	) );
}

?>