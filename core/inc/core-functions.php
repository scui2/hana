<?php
/**
 * Core Functions
 * @package	  hanacore
 * @since     1.0
 * @author	  Stephen Cui
 * @copyright Copyright 2016, Stephen Cui
 * @license   GPL v3 or later
 * @link      http://rewindcreation.com/
 */

/**************************************************
* Register 3rd party styles and script
**************************************************/
add_action( 'wp_enqueue_scripts', 'hanacore_register_scripts', 0 );
function hanacore_register_scripts() {
	// Font Awesome and bxSlider handdle should not be prefixed
	wp_register_style( 'font-awesome', HANA_CORE_URI . 'css/font-awesome.min.css', null, '4.6.3');
	wp_register_style( 'jquery-bxslider', HANA_CORE_URI . 'css/jquery.bxslider.min.css', null, '4.2.5');	
	// We are using custom version of Foundation 6
	wp_register_style( 'hana-foundation', HANA_CORE_URI . 'css/foundation6.min.css', null, '6.2.3');
	wp_register_script( 'hana-foundation' , HANA_CORE_URI . 'js/foundation.min.js', array( 'jquery'), '6.2.3', true );
	// bxSlider handdle should not be prefixed
	wp_register_script( 'jquery-bxslider' , HANA_CORE_URI . 'js/jquery.bxslider.min.js', array( 'jquery'), '4.2.5', true );	
}

add_action( 'wp_enqueue_scripts', 'hanacore_enqueue_scripts', 11 );
function hanacore_enqueue_scripts() {
	// WordPress uses comment-reply script to handle thread comments
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
/**************************************************
* Change post class sticky to wp-sticky
* to avoid conflict with Foundation 6
**************************************************/
add_filter('post_class','hana_change_sticky_class');
function hana_change_sticky_class( $classes ) {	
	if ( is_sticky() ) {
		$classes = array_diff( $classes, array( 'sticky' ) );		
		$classes[] = 'wp-sticky';
	}
	return $classes;
}
/**************************************************
* Add span to category/archive count
**************************************************/
add_filter( 'wp_list_categories', 'hana_archive_count_span' );
add_filter( 'get_archives_link', 'hana_archive_count_span' );
function hana_archive_count_span( $links ) {
	$links = str_replace( array('</a> (',  '</a>&nbsp;(') , '</a><span>', $links );
	$links = str_replace( ')', '</span>', $links );
	return $links;
}
/**************************************************
* Replace rel="category tag" with rel="tag"
* For W3C validation purposes only.
**************************************************/
add_filter('wp_list_categories', 'hana_replace_rel_category');
add_filter('the_category', 'hana_replace_rel_category');
function hana_replace_rel_category ($output) {
    $output = str_replace(' rel="category tag"', ' rel="tag"', $output);
    return $output;
}

/**************************************************
* wp_title filter for better SEO
**************************************************/
add_filter( 'wp_title', 'hana_wp_title', 10, 2 );
function hana_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	$title .= get_bloginfo( 'name' );
	
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( esc_html__( 'Page %s', 'hana' ), max( $paged, $page ) );

	return $title;
}

/**************************************************
* Filters for auto excerpt
**************************************************/
add_filter( 'excerpt_length', 'hana_excerpt_length' );
function hana_excerpt_length( $length ) {
	return apply_filters('hana_excerpt_length', 40);
}

add_filter( 'excerpt_more', 'hana_auto_excerpt_more' );
function hana_auto_excerpt_more( $more ) {
	return ' &hellip;';
}

add_filter( 'get_the_excerpt', 'hana_custom_excerpt_more' );
function hana_custom_excerpt_more( $output ) {
	if ( ! is_attachment() ) {
		$output .= ' <a class="more-link" href="'. esc_url( get_permalink() ) . '">' . esc_html( hana_readmore_text() ) . '</a>';
	}
	return $output;
}

function hana_readmore_text() {
	return apply_filters( 'hana_readmore_label', esc_html__( 'Read More', 'hana' ) );
}

/**************************************************
* Featured Posts
**************************************************/
function hana_is_featured() {
	if ( is_sticky() && ! is_paged() )
		return true;
	else
		return false;
}

function hana_has_featured_posts( $minimum = 1 ) { 
	global $hana_featured_posts;
	if ( is_paged() || is_search() || is_archive() || is_single() || is_404() )
       return false;
       
	if ( class_exists( 'bbPress' ) && is_bbpress() )
       return false;	       
       
    if ( is_page() &&  ! is_front_page() )
       return false;
       	
    $minimum = absint( $minimum );
    
    if ( ! is_array( $hana_featured_posts ) )
	    $hana_featured_posts = apply_filters( 'hana_get_featured_posts', array() );
 
    if ( ! is_array( $hana_featured_posts ) )
        return false;
 
    if ( $minimum > count( $hana_featured_posts ) )
        return false;
 
    return true;
}

