<?php
/**
 * Plugin Name: Smeta
 * Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
 * Description: Create custom metaboxes for all post types
 * Version: 1.0
 * Author: S Web Design Studio
 * Author URI: http://URI_Of_The_Plugin_Author
 * License: GPL2
 */

if ( ! defined( 'SM_PATH') )
define( 'SM_PATH', str_replace( '\\', '/', dirname( __FILE__ ) ) );
if ( ! defined( 'SM_URL' ) )
define( 'SM_URL', str_replace( str_replace( '\\', '/', WP_CONTENT_DIR ), str_replace( '\\', '/', WP_CONTENT_URL ), SM_PATH ) );
include_once( SM_PATH . '/classes.fields.php' );
include_once( SM_PATH . '/class.sm-meta-box.php' );
// Make it possible to add fields in locations other than post edit screen.
include_once( SM_PATH . '/fields-anywhere.php' );
include_once( SM_PATH . '/class.sm-frontend.php' );
$sm = new SM_Frontend();
/**
 * Get all the meta boxes on init
 * 
 * @return null
 */
function sm_init() {
	if ( ! is_admin() )
		return;
	// Load translations
	$textdomain = 'sm';
	$locale = apply_filters( 'plugin_locale', get_locale(), $textdomain );
	// By default, try to load language files from /wp-content/languages/custom-meta-boxes/
	load_textdomain( $textdomain, WP_LANG_DIR . '/custom-meta-boxes/' . $textdomain . '-' . $locale . '.mo' );
	load_textdomain( $textdomain, SM_PATH . '/languages/' . $textdomain . '-' . $locale . '.mo' );
	$meta_boxes = apply_filters( 'sm_meta_boxes', array() );
	if ( ! empty( $meta_boxes ) )
		foreach ( $meta_boxes as $meta_box )
			new SM_Meta_Box( $meta_box );
}
add_action( 'init', 'sm_init' );
/**
 * Return an array of built in available fields
 *
 * Key is field name, Value is class used by field.
 * Available fields can be modified using the 'sm_field_types' filter.
 * 
 * @return array
 */
function _sm_available_fields() {
	return apply_filters( 'sm_field_types', array(
		'text'				=> 'SM_Text_Field',
		'url'				=> 'SM_URL_Field',
		'radio'				=> 'SM_Radio_Field',
		'checkbox'			=> 'SM_Checkbox',
		'file'				=> 'SM_File_Field',
		'image' 			=> 'SM_Image_Field',
		'wysiwyg'			=> 'SM_wysiwyg',
		'textarea'			=> 'SM_Textarea_Field',
		'multiple'			=> 'SM_Multiple_Select',
		'select'			=> 'SM_Select',
		'taxonomy_select'	=> 'SM_Taxonomy',
		'post_select'		=> 'SM_Post_Select',
		'date'				=> 'SM_Date_Field',
		'date_unix'			=> 'SM_Date_Timestamp_Field',
		'datetime_unix'		=> 'SM_Datetime_Timestamp_Field',
		'time'				=> 'SM_Time_Field',
		'colorpicker'		=> 'SM_Color_Picker',
		'group'				=> 'SM_Group_Field',
	) );
}
/**
 * Get a field class by type
 * 
 * @param  string $type 
 * @return string $class, or false if not found.
 */
function _sm_field_class_for_type( $type ) {
	$map = _sm_available_fields();
	if ( isset( $map[$type] ) )
		return $map[$type];
	return false;
}