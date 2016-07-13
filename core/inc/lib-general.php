<?php
/**
 * Utility Functions
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */

//Sorting array by key
function hana_sort_array( &$array, $key ) {
    $sorter = array();
    $ret = array();
    reset( $array );
    foreach ( $array as $ii => $va ) {
        $sorter[ $ii ] = $va[ $key ];
    }
    asort( $sorter );
    foreach ( $sorter as $ii => $va ) {
        $ret[ $ii ] = $array[ $ii ];
    }
    $array = $ret;
}
// Return Post Type array
function hana_post_types() { 
	$types = array_merge(
		get_post_types( array( 'public'  => true, '_builtin' => true ) ),
		get_post_types( array( 'public'  => true, '_builtin' => false ) )
  	);
	return apply_filters( 'hana_post_types', $types );
}

// Return Thumbnail
if ( ! function_exists( 'hana_thumbnail_size' ) ) : 
function hana_thumbnail_size( $size, $x = 96, $y = 96 ) {

	if ( empty( $size ) )
		return 'thumbnail';
	elseif ( 'custom' == $size ) {
		if ( ($x > 0) && ($y > 0) )
			return array( $x, $y);
		else
			return 'thumbnail';	
	}
	else 
		return $size;
}
endif;

//Thumbal Array
function hana_thumbnail_array() {
	$sizes = array (
		''			=> __( 'Thumbnail', 'hana' ),
		'medium'	=> __( 'Medium', 'hana' ),
		'large'		=> __( 'Large', 'hana' ),
		'full'		=> __( 'Full', 'hana' ),	
		'none'		=> __( 'None', 'hana' ),	
	);

	global $_wp_additional_image_sizes;
	if ( isset( $_wp_additional_image_sizes ) )
		foreach( $_wp_additional_image_sizes as $key => $item) 
			$sizes[ $key ] = $key;
	return apply_filters( 'hana_thumbnail_array', $sizes );
}

/* Category Array */
function hana_categories() {
	$categories = get_categories();
	return apply_filters( 'hana_categories', $categories );
}
// Return Top Categories
function hana_top_categories( $count = 0 ) {
	$args = array(
		'orderby' => 'count',
		'order' => 'DESC',
		'parent' => 0 );
	$categories = get_categories( $args );
	$top_cats = array();
	foreach ( $categories as $category )
		if ( $category->count >= $count )
			$top_cats[] = $category;
	return apply_filters( 'hana_top_categories', $top_cats );
}

// Returns permalink except link post in which 1st link will be returned
function hana_get_post_link() {
	$link_url = get_the_permalink();
	if ( has_post_format( 'link' ) ) {
		$link = array();
		if ( preg_match('/<a (.+?)>/', get_the_content(), $match) ) {
    		foreach ( wp_kses_hair($match[1], array('http')) as $attr) {
        		$link[$attr['name']] = $attr['value'];
    		}
		}			
    	if ( isset( $link['href'] ) )
    		$link_url = $link['href'];
	}
	return $link_url;
}

