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
    $valid = hana_columns_choices();
 
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
/***************************
* Common Choice Functions 
***************************/
function hana_category_choices( $inc = 'all' ) {
	$categories = hana_categories();
	
	$choices = array();
	if ( 'all' == $inc )
		$choices[0] =  __( 'All Categories', 'hana' );
	elseif ( 'metaall' == $inc )
		$choices[''] =   __( 'All Categories', 'hana' );
	elseif ( 'blank' == $inc )
		$choices[''] = '';
		
	foreach ( $categories as $category )
		$choices[ $category->term_id ] = $category->name;
	return apply_filters( 'hana_category_choices', $choices );
}

function hana_columns_choices( $meta = false ) {
	if ( $meta ) {
		$choices =  array( 
					'1' => __( 'Full', 'hana'),
					'2' => __( 'Half', 'hana'),
					'' 	=> __( 'One Third', 'hana'),	// Default
					'4'	=> __( 'One Fourth', 'hana'));		
	} else {
		$choices =  array( 
					'1' => __( 'Full', 'hana'),
					'2' => __( 'Half', 'hana'),
					'3' => __( 'One Third', 'hana'),	// Default
					'4'	=> __( 'One Fourth', 'hana'));		
	}
	return apply_filters( 'hana_columns_choices', $choices );
}

