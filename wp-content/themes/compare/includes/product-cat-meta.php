<?php

/* Custom Meta For Taxonomies */


/* Adding New */
/* icon meta */
function compare_category_icon_add() {
	echo '
	<div class="form-field">
		<label for="term_meta[category_icon]">'.__( 'Icon:', 'compare' ).'</label>
		<select name="term_meta[category_icon]" id="term_meta[category_icon]"> 
			'.compare_icons_list( '' ).'
		</select>
		<p class="description">'.__( 'Select icon for the category','compare' ).'</p>
	</div>
	<div class="form-field">
		<label for="term_meta[category_image]">'.__( 'Image:', 'compare' ).'</label>
		<input type="hidden" name="term_meta[category_image]" value="">
		<div class="image-holder">
		</div>
		<a href="javascript:;" class="add_cat_image button">'.__( 'Select Image', 'compare' ).'</a>
		<p class="description">'.__( 'Select image for the category','compare' ).'</p>
	</div>';
}
add_action( 'product-cat_add_form_fields', 'compare_category_icon_add', 10, 2 );

/* Editing */
function compare_category_icon_edit( $term ) {
	$t_id = $term->term_id;
	$term_meta = get_option( "taxonomy_$t_id" );
	
	$category_icon = !empty( $term_meta['category_icon'] ) ? $term_meta['category_icon'] : '';
	$category_image = !empty( $term_meta['category_image'] ) ? $term_meta['category_image'] : '';
	?>
	<table class="form-table">
		<tbody>
			<tr class="form-field form-required">
				<th scope="row"><label for="term_meta[category_icon]"><?php _e( 'Icon', 'compare' ); ?></label></th>
				<td>
					<select name="term_meta[category_icon]" id="term_meta[category_icon]"> 
						<?php echo compare_icons_list( $category_icon ); ?>
					</select>
				<p class="description"><?php _e( 'Select icon for the code category', 'compare' ); ?></p></td>
			</tr>
			<tr class="form-field form-required">
				<th scope="row"><label for="term_meta[category_image]"><?php _e( 'Image', 'compare' ); ?></label></th>
				<td>
					<input type="hidden" name="term_meta[category_image]" value="<?php esc_attr( $category_image ) ?>">
					<div class="image-holder">
						<?php
						if( !empty( $category_image ) ){
							echo wp_get_attachment_image( $category_image, 'thumbnail' );
						}
						?>
						<a href="javascript:;" class="remove_cat_image">X</a>
					</div>
					<a href="javascript:;" class="add_cat_image button"><?php _e( 'Select Image', 'compare' ); ?></a>
				<p class="description"><?php _e( 'Select image for the category', 'compare' ); ?></p></td>
			</tr>			
		</tbody>
	</table>
	<?php
}
add_action( 'product-cat_edit_form_fields', 'compare_category_icon_edit', 10, 2 );

/* Save It */
function compare_category_icon_save( $term_id ) {
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
add_action( 'edited_product-cat', 'compare_category_icon_save', 10, 2 );  
add_action( 'create_product-cat', 'compare_category_icon_save', 10, 2 );

/* Delete meta */
function compare_category_icon_delete( $term_id ) {
	delete_option( "taxonomy_$term_id" );
}  
add_action( 'delete_product-cat', 'compare_category_icon_delete', 10, 2 );

/* Add icon column */
function compare_category_column( $columns ) {
    $new_columns = array(
        'cb' => '<input type="checkbox" />',
        'name' => __('Name', 'compare'),
		'description' => __('Description', 'compare'),
        'slug' => __( 'Slug', 'compare' ),
        'posts' => __( 'Products', 'compare' ),
		'icon' => __( 'Icon', 'compare' ),
		'image' => __( 'Image', 'compare' )
        );
    return $new_columns;
}
add_filter("manage_edit-product-cat_columns", 'compare_category_column'); 

function compare_populate_category_column( $out, $column_name, $label_id ){
    switch ( $column_name ) {
        case 'icon': 
			$term_meta = get_option( "taxonomy_$label_id" );
			$category_icon = !empty( $term_meta['category_icon'] ) ? $term_meta['category_icon'] : '';

            $out .= '<div style="width: 20px; height: 20px;"><span class="fa fa-'.$category_icon.'"></span></div>';
            break;
 		case 'image':
			$term_meta = get_option( "taxonomy_$label_id" );
			$category_image = !empty( $term_meta['category_image'] ) ? $term_meta['category_image'] : '';

            $out .= '<div style="width: 50px; height: 50px;">'.wp_get_attachment_image( $category_image, 'thumbnail' ).'</div>';
            break;
        default:
            break;
    }
    return $out; 
}

add_filter("manage_product-cat_custom_column", 'compare_populate_category_column', 10, 3);
?>