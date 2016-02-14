<?php
/*
Plugin Name: Compare Custom Post Types
Plugin URI: http://demo.powerthemes.club/themes/compare-cpt/
Description: Compare custom post types and taxonomies
Version: 1.0
Author: pebas
Author URI: http://themeforest.net/user/pebas/
License: GNU General Public License version 3.0
*/

if( !function_exists( 'compare_cpt_post_types_and_taxonomies' ) ){
	function compare_cpt_post_types_and_taxonomies(){
		$product_args = array(
			'labels' => array(
				'name' => __( 'Products', 'compare-cpt' ),
				'singular_name' => __( 'Product', 'compare-cpt' )
			),
			'public' => true,
			'menu_icon' => 'dashicons-cart',
			'has_archive' => false,
			'supports' => array(
				'title',
				'editor',
				'thumbnail',
				'author',
				'excerpt',
				'comments'
			)
		);

		register_post_type( 'slider', array(
			'labels' => array(
				'name' => __( 'Sliders', 'compare-cpt' ),
				'singular_name' => __( 'Slider', 'compare-cpt' )
			),
			'public' => true,
			'menu_icon' => 'dashicons-images-alt',
			'has_archive' => false,
			'supports' => array(
				'title',
			)
		));

		register_post_type( 'parser', array(
			'labels' => array(
				'name' => __( 'Parsers', 'compare-cpt' ),
				'singular_name' => __( 'Parser', 'compare-cpt' )
			),
			'public' => true,
			'menu_icon' => 'dashicons-search',
			'has_archive' => false,
			'supports' => array(
				'title',
			)
		));			
		
		$product_cat_args = array(
			'label' => __( 'Category', 'compare-cpt' ),
			'hierarchical' => true,
			'labels' => array(
				'name' 							=> __( 'Category', 'compare-cpt' ),
				'singular_name' 				=> __( 'Category', 'compare-cpt' ),
				'menu_name' 					=> __( 'Category', 'compare-cpt' ),
				'all_items'						=> __( 'All Categories', 'compare-cpt' ),
				'edit_item'						=> __( 'Edit Category', 'compare-cpt' ),
				'view_item'						=> __( 'View Category', 'compare-cpt' ),
				'update_item'					=> __( 'Update Category', 'compare-cpt' ),
				'add_new_item'					=> __( 'Add New Category', 'compare-cpt' ),
				'new_item_name'					=> __( 'New Category Name', 'compare-cpt' ),
				'parent_item'					=> __( 'Parent Category', 'compare-cpt' ),
				'parent_item_colon'				=> __( 'Parent Category:', 'compare-cpt' ),
				'search_items'					=> __( 'Search Categories', 'compare-cpt' ),
				'popular_items'					=> __( 'Popular Categories', 'compare-cpt' ),
				'separate_items_with_commas'	=> __( 'Separate categories with commas', 'compare-cpt' ),
				'add_or_remove_items'			=> __( 'Add or remove categories', 'compare-cpt' ),
				'choose_from_most_used'			=> __( 'Choose from the most used categories', 'compare-cpt' ),
				'not_found'						=> __( 'No categories found', 'compare-cpt' ),
			)
		);
		
		$product_tag_args = array(
			'label' => __( 'Tag', 'compare-cpt' ),
			'labels' => array(
				'name' 							=> __( 'Tag', 'compare-cpt' ),
				'singular_name' 				=> __( 'Tag', 'compare-cpt' ),
				'menu_name' 					=> __( 'Tag', 'compare-cpt' ),
				'all_items'						=> __( 'All Tags', 'compare-cpt' ),
				'edit_item'						=> __( 'Edit Tag', 'compare-cpt' ),
				'view_item'						=> __( 'View Tag', 'compare-cpt' ),
				'update_item'					=> __( 'Update Tag', 'compare-cpt' ),
				'add_new_item'					=> __( 'Add New Tag', 'compare-cpt' ),
				'new_item_name'					=> __( 'New Tag Name', 'compare-cpt' ),
				'parent_item'					=> __( 'Parent Tag', 'compare-cpt' ),
				'parent_item_colon'				=> __( 'Parent Tag:', 'compare-cpt' ),
				'search_items'					=> __( 'Search Tags', 'compare-cpt' ),
				'popular_items'					=> __( 'Popular Tags', 'compare-cpt' ),
				'separate_items_with_commas'	=> __( 'Separate tags with commas', 'compare-cpt' ),
				'add_or_remove_items'			=> __( 'Add or remove tags', 'compare-cpt' ),
				'choose_from_most_used'			=> __( 'Choose from the most used tags', 'compare-cpt' ),
				'not_found'						=> __( 'No tags found', 'compare-cpt' ),
			)
		);

		$product_brand_args = array(
			'label' => __( 'Brand', 'compare-cpt' ),
			'hierarchical' => true,
			'labels' => array(
				'name' 							=> __( 'Brand', 'compare-cpt' ),
				'singular_name' 				=> __( 'Brand', 'compare-cpt' ),
				'menu_name' 					=> __( 'Brand', 'compare-cpt' ),
				'all_items'						=> __( 'All Brands', 'compare-cpt' ),
				'edit_item'						=> __( 'Edit Brand', 'compare-cpt' ),
				'view_item'						=> __( 'View Brand', 'compare-cpt' ),
				'update_item'					=> __( 'Update Brand', 'compare-cpt' ),
				'add_new_item'					=> __( 'Add New Brand', 'compare-cpt' ),
				'new_item_name'					=> __( 'New Brand Name', 'compare-cpt' ),
				'parent_item'					=> __( 'Parent Brand', 'compare-cpt' ),
				'parent_item_colon'				=> __( 'Parent Brand:', 'compare-cpt' ),
				'search_items'					=> __( 'Search Brand', 'compare-cpt' ),
				'popular_items'					=> __( 'Popular Brands', 'compare-cpt' ),
				'separate_items_with_commas'	=> __( 'Separate offer brands with commas', 'compare-cpt' ),
				'add_or_remove_items'			=> __( 'Add or remove offer brands', 'compare-cpt' ),
				'choose_from_most_used'			=> __( 'Choose from the most used offer brands', 'compare-cpt' ),
				'not_found'						=> __( 'No offer brands found', 'compare-cpt' ),
			)
		);

		if( class_exists('ReduxFramework') && function_exists('compare-cpt_get_option') ){
			$trans_product = compare_get_option( 'trans_product' );
			if( !empty( $trans_product ) ){
				$product_args['rewrite'] = array( 'slug' => $trans_product );
			}

			$trans_product_cat = compare_get_option( 'trans_product_cat' );
			if( !empty( $product_cat_args ) ){
				$product_cat_args['rewrite'] = array( 'slug' => $trans_product_cat );
			}

			$trans_product_brand = compare_get_option( 'trans_product_brand' );
			if( !empty( $trans_product_brand ) ){
				$product_brand_args['rewrite'] = array( 'slug' => $trans_product_brand );
			}

			$trans_product_tag = compare_get_option( 'trans_product_tag' );
			if( !empty( $trans_product_tag ) ){
				$product_tag_args['rewrite'] = array( 'slug' => $trans_product_tag );
			}			
		}

		register_post_type( 'product', $product_args );	
		register_taxonomy( 'product-brand', array( 'product' ), $product_brand_args );
		register_taxonomy( 'product-cat', array( 'product' ), $product_cat_args );
		register_taxonomy( 'product-tag', array( 'product' ), $product_tag_args );


	}
	add_action('init', 'compare_cpt_post_types_and_taxonomies' );
}

add_action( 'plugins_loaded', 'compare_cpt_textdomain' );
function compare_cpt_textdomain() {
  load_plugin_textdomain( 'compare-cpt', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}

?>