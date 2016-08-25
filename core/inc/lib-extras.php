<?php
/**
 * Functions for Plug-In supports
 * 
 * @package	hanacore
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
/**
 * WooCommerce Support
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_before_main_content', 'hana_woocommerce_content_wrapper', 10);
add_action( 'woocommerce_after_main_content', 'hana_woocommerce_content_wrapper_end', 10);

function hana_woocommerce_content_wrapper() {
  echo '<div id="content" class="' . esc_attr( hana_grid()-> content_class(false) ) . '">';
}
 
function hana_woocommerce_content_wrapper_end() {
  echo '</div><!-- end of #content -->';
}

/**
 * Jigoshop Support
 */
remove_action( 'jigoshop_before_main_content', 'jigoshop_output_content_wrapper', 10 );
remove_action( 'jigoshop_after_main_content', 'jigoshop_output_content_wrapper_end', 10 );

add_action( 'jigoshop_before_main_content', 'hana_jigoshop_content_wrapper', 10 );
add_action( 'jigoshop_after_main_content', 'hana_jigoshop_content_wrapper_end', 10 );

function hana_jigoshop_content_wrapper() {
  echo '<div id="content" class="' . esc_attr( hana_grid()->cotent_class(false) ) . '">';
}
 
function hana_jigoshop_content_wrapper_end() {
  echo '</div><!-- end of #content -->';
}

/******************************
* Jetpack Sharing Integration
******************************/
if ( ! function_exists( 'hana_remove_sharing_filters' ) ) :
function hana_remove_sharing_filters() {
	if (  function_exists( 'sharing_display' ) ) {
		remove_filter( 'the_excerpt', 'sharing_display', 19 );
		remove_filter( 'the_content', 'sharing_display', 19 );
	}
}
add_action('hana_header_top','hana_remove_sharing_filters');
endif;

if ( ! function_exists( 'hana_jetpack_sharing' ) ) :
function hana_jetpack_sharing( $pos = 'bottom' ) {
	if ( function_exists( 'sharing_display' ) ) {
		if ( 'top' == $pos && get_theme_mod( 'share_top' ) )
			echo '<span class="hana-share-top">' . sharing_display() . '</span>';
		elseif ( 'bottom' == $pos && get_theme_mod( 'share_bottom' ) )
			echo '<span class="hana-share-bottom clearfix">' . sharing_display() . '</span>';
	}
}
endif;