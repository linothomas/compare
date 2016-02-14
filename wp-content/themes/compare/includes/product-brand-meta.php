<?php

/* Custom Meta For Taxonomies */


/* Adding New */
/* icon meta */
function compare_brand_icon_add() {
	echo '
	<div class="form-field">
		<label for="term_meta[brand_image]">'.__( 'Image:', 'compare' ).'</label>
		<input type="hidden" name="term_meta[brand_image]" value="">
		<div class="image-holder">
		</div>
		<a href="javascript:;" class="add_cat_image button">'.__( 'Select Image', 'compare' ).'</a>
		<p class="description">'.__( 'Select image for the brand','compare' ).'</p>
	</div>';
}
add_action( 'product-brand_add_form_fields', 'compare_brand_icon_add', 10, 2 );

/* Editing */
function compare_brand_icon_edit( $term ) {
	$t_id = $term->term_id;
	$term_meta = get_option( "taxonomy_$t_id" );
	
	$brand_image = !empty( $term_meta['brand_image'] ) ? $term_meta['brand_image'] : '';
	?>
	<table class="form-table">
		<tbody>
			<tr class="form-field form-required">
				<th scope="row"><label for="term_meta[brand_image]"><?php _e( 'Image', 'compare' ); ?></label></th>
				<td>
					<input type="hidden" name="term_meta[brand_image]" value="<?php esc_attr( $brand_image ) ?>">
					<div class="image-holder">
						<?php
						if( !empty( $brand_image ) ){
							echo wp_get_attachment_image( $brand_image, 'thumbnail' );
						}
						?>
						<a href="javascript:;" class="remove_cat_image">X</a>
					</div>
					<a href="javascript:;" class="add_cat_image button"><?php _e( 'Select Image', 'compare' ); ?></a>
				<p class="description"><?php _e( 'Select image for the brand', 'compare' ); ?></p></td>
			</tr>			
		</tbody>
	</table>
	<?php
}
add_action( 'product-brand_edit_form_fields', 'compare_brand_icon_edit', 10, 2 );

/* Save It */
function compare_brand_icon_save( $term_id ) {
	if ( isset( $_POST['term_meta'] ) ) {
		$t_id = $term_id;
		$term_meta = get_option( "taxonomy_$t_id" );
		$cat_keys = array_keys( $_POST['term_meta'] );
		foreach ( $cat_keys as $key ) {
			if ( isset ( $_POST['term_meta'][$key] ) ) {
				$term_meta[$key] = $_POST['term_meta'][$key];
			}
		}
		// Save the option array.
		update_option( "taxonomy_$t_id", $term_meta );
	}
}  
add_action( 'edited_product-brand', 'compare_brand_icon_save', 10, 2 );  
add_action( 'create_product-brand', 'compare_brand_icon_save', 10, 2 );

/* Delete meta */
function compare_brand_icon_delete( $term_id ) {
	delete_option( "taxonomy_$term_id" );
}  
add_action( 'delete_product-brand', 'compare_brand_icon_delete', 10, 2 );

/* Add icon column */
function compare_brand_column( $columns ) {
    $new_columns = array(
        'cb' => '<input type="checkbox" />',
        'name' => __('Name', 'compare'),
		'description' => __('Description', 'compare'),
        'slug' => __( 'Slug', 'compare' ),
        'posts' => __( 'Products', 'compare' ),
		'image' => __( 'Image', 'compare' )
        );
    return $new_columns;
}
add_filter("manage_edit-product-brand_columns", 'compare_brand_column'); 

function compare_populate_brand_column( $out, $column_name, $label_id ){
    switch ( $column_name ) {
 		case 'image':
			$term_meta = get_option( "taxonomy_$label_id" );
			$brand_image = !empty( $term_meta['brand_image'] ) ? $term_meta['brand_image'] : '';

            $out .= '<div style="width: 50px; height: 50px;">'.wp_get_attachment_image( $brand_image, 'thumbnail' ).'</div>';
            break;
        default:
            break;
    }
    return $out; 
}

add_filter("manage_product-brand_custom_column", 'compare_populate_brand_column', 10, 3);
?>