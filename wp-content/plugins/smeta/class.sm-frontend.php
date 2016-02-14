<?php

class SM_Frontend{

	function __construct(){}
	
	//get post meta by id
	public function sm_get_meta( $meta_key, $post_id = ''){
		if( empty( $post_id ) ){
			$post_id = get_the_ID();
		}
		$meta_values = get_post_meta( $post_id, $meta_key );
		if( !empty( $meta_values ) ){
			if( !is_array( $meta_values[0] ) ){
				$meta_values_try = unserialize( $meta_values[0] );
			}
			if( !$meta_values_try ){
				return $meta_values;
			}
			else{
				return array_values( $meta_values_try );
			}
		}
		else{
			return array();
		}
	}

}

?>