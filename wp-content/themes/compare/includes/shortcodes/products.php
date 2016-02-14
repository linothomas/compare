<?php
function compare_products_func( $atts, $content ){
	extract( shortcode_atts( array(
		'tabs' => '',
		'products' => '10',
		'rows' => '2',
		'visible_items' => '4'
	), $atts ) );

	$tabs = explode( ',', $tabs );

	$navigation = '<ul class="nav nav-tabs" role="tablist">';
	$panels = '<div class="tab-content">';

	$active_first = false;

	if( !empty( $tabs ) ){

		foreach( $tabs as $tab ){
			switch( $tab ){
				case 'popular' : 
					$navigation .= '<li role="presentation" class="'.( !$active_first ? 'active' : '' ).'"><a href="#popular" aria-controls="popular" role="tab" data-toggle="tab">'.__( 'The Most Popular', 'compare' ).'</a></li>';
					$panels .= '<div role="tabpanel" class="tab-pane '.( !$active_first ? 'active' : '' ).'" id="popular"><div class="products-slider" data-visible_items="'.esc_attr( $visible_items ).'">';
					$panels .= compare_generate_products_panel( 'popular', $rows, $products );
					$panels .='</div></div>';
					$active_first = true;
					break;
				case 'seller' : 
					$navigation .= '<li role="presentation" class="'.( !$active_first ? 'active' : '' ).'"><a href="#seller" aria-controls="seller" role="tab" data-toggle="tab">'.__( 'Best Sellers', 'compare' ).'</a></li>';
					$panels .= '<div role="tabpanel" class="tab-pane '.( !$active_first ? 'active' : '' ).'" id="seller"><div class="products-slider" data-visible_items="'.esc_attr( $visible_items ).'">';
					$panels .= compare_generate_products_panel( 'seller', $rows, $products );
					$panels .='</div></div>';
					$active_first = true;
					break;
				case 'latest' : 
					$navigation .= '<li role="presentation" class="'.( !$active_first ? 'active' : '' ).'"><a href="#latest" aria-controls="latest" role="tab" data-toggle="tab">'.__( 'Latest Added', 'compare' ).'</a></li>';
					$panels .= '<div role="tabpanel" class="tab-pane '.( !$active_first ? 'active' : '' ).'" id="latest"><div class="products-slider" data-visible_items="'.esc_attr( $visible_items ).'">';
					$panels .= compare_generate_products_panel( 'latest', $rows, $products );
					$panels .='</div></div>';
					$active_first = true;
					break;
				case 'ratings' : 
					$navigation .= '<li role="presentation" class="'.( !$active_first ? 'active' : '' ).'"><a href="#ratings" aria-controls="ratings" role="tab" data-toggle="tab">'.__( 'Top Rated', 'compare' ).'</a></li>';
					$panels .= '<div role="tabpanel" class="tab-pane '.( !$active_first ? 'active' : '' ).'" id="ratings"><div class="products-slider" data-visible_items="'.esc_attr( $visible_items ).'">';
					$panels .= compare_generate_products_panel( 'ratings', $rows, $products );
					$panels .='</div></div>';
					$active_first = true;
					break;
			}
		}
	}
	$panels .= '</div>';
	$navigation .= '</ul>';
	$html = '<div class="white-title clearfix">
				<div class="white-block-border clearfix">
					<div class="pull-left">
						'.compare_get_white_title_icon().'
						'.$navigation.'
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
			</div>'.$panels;

	return '<div class="owl-parent shortcode shortcode-products">'.$html.'</div>';
}

add_shortcode( 'products', 'compare_products_func' );

function compare_generate_products_panel( $source, $rows, $products ){
	$list = '';
	$args = array(
		'post_type' => 'product',
		'posts_per_page' => $products,
		'post_status' => 'publish'
	);
	switch( $source ){
		case 'popular':
			$args['orderby'] = 'meta_value_num';
			$args['meta_key'] = 'product_clicks';
			$args['order'] = 'DESC';		
			break;
		case 'seller':
			$args['orderby'] = 'meta_value_num';
			$args['meta_key'] = 'product_store_clicks';
			$args['order'] = 'DESC';
			break;
		case 'ratings':
			$args['orderby'] = 'meta_value_num';
			$args['meta_key'] = 'average_review';
			$args['order'] = 'DESC';
			break;
	}
	$products = new WP_Query($args);
	$product_ids = wp_list_pluck( $products->posts, 'ID' );
	$product_metas = compare_product_item_meta( $product_ids );	

	$html_container = array();
	if( $products->have_posts() ){
		$columns = ceil( $products->post_count / $rows );
		$counter = 0;

		while( $products->have_posts() ){
			$products->the_post();
			if( $counter == $columns ){
				$counter = 0;
			}			
			$counter++;
			if( empty( $html_container['column'.$counter] ) ){
				$html_container['column'.$counter] = '';
			}
			ob_start();
			include( get_template_directory() . '/includes/product-box.php' );
			$html_container['column'.$counter] .= ob_get_contents();
			ob_end_clean();
		}
		$list .= '</div>';
	}	
	wp_reset_postdata();
	for( $i=1; $i<=$columns; $i++ ){
		$html_container['column'.$i] = '<div>'.$html_container['column'.$i].'</div>';
	}

	return join( '', $html_container );
}

function compare_products_params(){
	return array(
		array(
			"type" => "multidropdown",
			"holder" => "div",
			"class" => "",
			"heading" => __("Tabs","compare"),
			"param_name" => "tabs",
			"value" => array(
				__( 'The Most Popular', 'compare' ) => 'popular',
				__( 'Best Sellers', 'compare' ) => 'seller',
				__( 'Latest Added', 'compare' ) => 'latest',
				__( 'Top Rated', 'compare' ) => 'ratings',
			),
			"description" => __("Select which tabs you wish to display","compare")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Number Of Products","compare"),
			"param_name" => "products",
			"value" => '10',
			"description" => __("Input number of products you wish to shiow in each panel","compare")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Rows Of Products","compare"),
			"param_name" => "rows",
			"value" => '2',
			"description" => __("Input number of rows in which you widh to present your products","compare")
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