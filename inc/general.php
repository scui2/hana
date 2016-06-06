<?php
/**
 * Content Functions
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
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
	$types = array( 
		'post' => __( 'Post', 'hana' ),
		'page' => __( 'Page', 'hana' ),
	);

	$args = array(
  		'public'   => true,
  		'_builtin' => false ); 
	$post_types = get_post_types( $args ); 
	foreach ( $post_types as $post_type ) {
		$types[ $post_type ] = $post_type;
	}
	return apply_filters( 'hana_post_types', $types );
}

// Return Thumbnail
if ( ! function_exists( 'hana_thumbnail_size' ) ) : 
function hana_thumbnail_size( $option, $x = 96, $y = 96 ) {

	if ( empty( $option ) )
		return 'thumbnail';
	elseif ( 'custom' == $option ) {
		if ( ($x > 0) && ($y > 0) )
			return array( $x, $y);
		else
			return 'thumbnail';	
	}
	else 
		return $option;
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

function hana_category_choices( $inc = 'all' ) {
	$categories = hana_categories();
	
	$choices = array();
	if ( 'all' == $inc )
		$choices[0] = __( 'All Categories', 'hana' );
	elseif ( 'metaall' == $inc )
		$choices[''] = __( 'All Categories', 'hana' );
	
	foreach ( $categories as $categorie )
		$choices[ $categorie->term_id ] = $categorie->name;
	return apply_filters( 'hana_category_choices', $choices );
}

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

function hana_adjust_brightness( $hex, $steps ) {
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));

    // Format the hex color string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
    }

    // Get decimal values
    $r = hexdec(substr($hex,0,2));
    $g = hexdec(substr($hex,2,2));
    $b = hexdec(substr($hex,4,2));

    // Adjust number of steps and keep it inside 0 to 255
    $r = max(0,min(255,$r + $steps));
    $g = max(0,min(255,$g + $steps));  
    $b = max(0,min(255,$b + $steps));

    $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
    $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
    $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

    return '#'.$r_hex.$g_hex.$b_hex;
}

function hana_get_related_posts( $numb_of_posts = 4 ) {
	$post = get_post();
		
	$args = array(
		'posts_per_page' => $numb_of_posts,
		'ignore_sticky_posts' => 1,
		'post__not_in' => array( $post->ID ),
		'orderby' => 'rand',
	);

	if ( function_exists( 'yarpp_get_related' ) ) { // Support Yet Another Related Posts
		$related = yarpp_get_related( array( 'limit' => $numb_of_posts ), $post->ID );
		$args['post__in'] = wp_list_pluck( $related, 'ID' );
	} else {
		$categories = get_the_category();
		if ( ! empty( $categories ) ) {
			$category = array_shift( $categories );
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field' => 'id',
					'terms' => $category->term_id,
				),
			);
		}		
	}

	return new WP_Query( $args );
}

if ( ! function_exists( 'hana_single_post_link' ) ) :
/* This function echo the link to single post view for the following:
- Aside Post
- Post without title
------------------------------------------------------------------------- */
function hana_single_post_link() {
	if ( ! is_single() ) {
		if ( has_post_format( 'aside' ) || has_post_format( 'quote' ) || '' == the_title_attribute( 'echo=0' ) ) { 
			printf ('<a class="single-post-link" href="%1$s" title="%1$s"><i class="fa fa-chevron-right"></i></a>',
				get_permalink(),
				get_the_title()	);
		} 
	}
}
endif;