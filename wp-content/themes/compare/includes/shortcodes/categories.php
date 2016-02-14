<?php
function compare_categories_func( $atts, $content ){
	extract( shortcode_atts( array(
		'title' => '',
		'visible_items' => '',
		'children' => '5',
		'categories' => '',
	), $atts ) );	
	$categories = explode( ',', $categories );

	$html = '';
	global $COMPARE_SEARCH_URL;
	global $compare_slugs;
	if( !empty( $categories ) ){
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
				</div>
				<div class="white-block categories"><div class="categories-slider" data-visible_items="'.esc_attr( $visible_items ).'">';
		foreach( $categories as $category ){
			$term = get_term_by( 'slug', $category, 'product-cat' );
			if( !is_wp_error( $term ) ){
				$term_meta = get_option( 'taxonomy_'.$term->term_id );
				$style = '';
				if( !empty( $term_meta['category_image'] ) ){
					$image_data = wp_get_attachment_image_src( $term_meta['category_image'], 'full' );
					if( !empty( $image_data[0] ) ){
						$style = 'background-image: url('.$image_data[0].')';
					}
				}
				$children_terms = get_terms( 'product-cat', array(
					'parent' => $term->term_id,
					'hide_empty' => false,
					'number' => $children
				));
				$children_list = array();
				if( !is_wp_error( $children_terms ) ){
					foreach( $children_terms as $child ){
						$children_list[]= '<a href="'.esc_url( add_query_arg( array( $compare_slugs['product-cat'] => $child->slug ), $COMPARE_SEARCH_URL ) ).'">'.$child->name.'</a>';
					}
				}
				$html .= '<div style="'.esc_attr( $style ).'" class="category-item"><h5><a href="'.esc_url( add_query_arg( array( $compare_slugs['product-cat'] => $term->slug ), $COMPARE_SEARCH_URL ) ).'">'.$term->name.'</a></h5><p>'.join( ', ', $children_list ).'</p></div>';
			}
		}

		$html.='</div></div>';
	}

	return '<div class="owl-parent shortcode shortcode-categories">'.$html.'</div>';

}

add_shortcode( 'categories', 'compare_categories_func' );

function compare_categories_params(){
	return array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Categories Title","compare"),
			"param_name" => "title",
			"value" => '',
			"description" => __("Input tite for the categories box","compare")
		),		
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Visible Items","compare"),
			"param_name" => "visible_items",
			"value" => '',
			"description" => __("Input number how many items to be visible","compare")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Number Of Children","compare"),
			"param_name" => "children",
			"value" => '',
			"description" => __("Input number how many children categories to display","compare")
		),		
		array(
			"type" => "multidropdown",
			"holder" => "div",
			"class" => "",
			"heading" => __("Categories","compare"),
			"param_name" => "categories",
			"value" => compare_get_taxonomy_list( 'product-cat', 'left' ),
			"description" => __("Select categories to display","compare")
		),	
	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => __("Categories", 'compare'),
	   "base" => "categories",
	   "category" => __('Content', 'compare'),
	   "params" => compare_categories_params()
	) );
}
?>