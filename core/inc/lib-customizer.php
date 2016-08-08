<?php
/**
 * Customizer Functions
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
/***************************
* Common Sanitize Functions 
***************************/
//Fonts
function hana_sanitize_fonts( $input ) {
    $valid = hana_font_choices();
 
    if ( array_key_exists( $input, $valid ) ) {
    	if ( is_numeric($input ) )
    		return 'default';
        return $input;
    } else {
        return '';
    }
}
// Layout Columns
function hana_sanitize_columns( $input ) {
    $valid = hana_column_choices();
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
// Checkbox
function hana_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}
// Text
function hana_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

