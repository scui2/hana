<?php
/**
 * Functions related to Post Formats
 * 
 * @package	hanacore
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
// Get image from Image Post
function hana_get_image() {
	global $hana_objects;
	
	if ( ! has_post_format( array( 'image','gallery' ) ) )
		return false;
	$post_id = get_the_ID();
	if( empty( $hana_objects ) )
		$hana_objects = array();
	if( isset( $hana_objects[ $post_id ] ) )
		return $hana_objects[ $post_id ];	
		
	$content = get_the_content();
	$content = apply_filters( 'the_content', $content );
	$content = str_replace( ']]>', ']]&gt;', $content );
	$content = trim($content);
	
	if ( preg_match('/<img[^>]+./' , $content, $match) )
		$hana_objects[ $post_id ] = hana_kses()->image( $match[0] ); //escape image
	else
		$hana_objects[ $post_id ] = false;
	return $hana_objects[ $post_id ];
}
// Get video from Video Post
function hana_get_video() {
	global $hana_objects;
	
	if ( ! has_post_format('video') )
		return false;
	$post_id = get_the_ID();
	if( empty( $hana_objects ) )
		$hana_objects = array();
	if( isset( $hana_objects[ $post_id ] ) )
		return $hana_objects[ $post_id ];	
		
	$content = get_the_content();
	$content = apply_filters( 'the_content', $content );
	$embeds = get_media_embedded_in_content( $content );
	if( ! empty( $embeds ) )
		$hana_objects[ $post_id ] = '<div class="' . apply_filters( 'hana_flexvideo_class', 'flex-video' ) . '">' . hana_kses()->embed( $embeds[0] ) . '</div>'; //escape embed
	else
		$hana_objects[ $post_id ] = false;

	return $hana_objects[ $post_id ];
}

// Get audio from Audio Post
function hana_get_audio() {
	global $hana_objects;
	
	if ( ! has_post_format('audio') )
		return false;
	$post_id = get_the_ID();
	if( empty( $hana_objects ) )
		$hana_objects = array();
	if( isset( $hana_objects[ $post_id ] ) )
		return $hana_objects[ $post_id ];	
		
	$content = get_the_content();
	$content = apply_filters( 'the_content', $content );
	$embeds = get_media_embedded_in_content( $content );
	if( ! empty( $embeds ) )
		$hana_objects[ $post_id ] = hana_kses()->embed( $embeds[0] ); //escape embed
	else
		$hana_objects[ $post_id ] = false;

	return $hana_objects[ $post_id ];
}

function hana_has_featured_media() {

	if ( has_post_thumbnail() )
		return true;
	elseif ( hana_get_image() )
		return true;
	elseif ( hana_get_video() )
		return true;
	elseif ( hana_get_audio() )
		return true;

	return false;
}

function hana_featured_media( $size = 'hana-thumb' ) {
	if ( has_post_thumbnail() )
		hana_featured_image( $size );
	elseif ( hana_get_image() )
		echo '<div class="scale-item">' . hana_get_image() . '</div>';
	elseif ( hana_get_video() )
		echo '<div class="scale-item scale-item-video">' . hana_get_video() . '</div>';
	elseif ( hana_get_audio() )
		echo '<div class="scale-item scale-item-audio">' . hana_get_audio() . '</div>';
}

function hana_featured_image( $size = 'full', $class = null, $link = false ) {
	global $post;

	if ( 'none' != $size && has_post_thumbnail() ) {
		if ( ! $class )
			$class = 'featured-image-' . esc_attr( $size );
		if ( ! is_single( $post ) || $link ) {
			printf ('<div class="scale-item"><a href="%1$s" title="%2$s">', 
				esc_url( get_permalink() ),
				esc_attr( get_the_title() ) );	
			the_post_thumbnail( $size, array( 'class' => $class, 'title' => esc_attr( get_the_title() ) ) );
			echo '</a></div>';
		}
		else {
			the_post_thumbnail( $size, array( 'class' => $class, 'title' => esc_attr( get_the_title() ) ) );
		}
	}
}
