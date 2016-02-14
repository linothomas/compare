/**
 * ColorPickers
 */

SM.addCallbackForInit( function() {

	// Colorpicker
	jQuery('input:text.sm_colorpicker').wpColorPicker();

} );

SM.addCallbackForClonedField( 'SM_Color_Picker', function( newT ) {

	// Reinitialize colorpickers
    newT.find('.wp-color-result').remove();
	newT.find('input:text.sm_colorpicker').wpColorPicker();

} );
