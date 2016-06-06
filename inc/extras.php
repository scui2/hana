<?php
/**
 * Functions for Plug-In supports
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
if ( ! defined( 'ABSPATH' )) exit;

/**
 * WooCommerce Support
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_before_main_content', 'hana_woocommerce_content_wrapper', 10);
add_action( 'woocommerce_after_main_content', 'hana_woocommerce_content_wrapper_end', 10);

function hana_woocommerce_content_wrapper() {
  echo '<div id="content" class="' . hana_content_class() . '">';
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
  echo '<div id="content" class="' . hana_cotent_class() . '">';
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
		if ( 'top' == $pos && hana_option( 'share_top' ) )
			echo '<span class="hana-share-top">' . sharing_display() . '</span>';
		elseif ( 'bottom' == $pos && hana_option( 'share_bottom' ) )
			echo '<span class="hana-share-bottom clearfix">' . sharing_display() . '</span>';
	}
}
endif;
/******************************
* Social Links
******************************/
function hana_social_services() {
	$socials = array(
		'facebook' => array(
			'label' => __( 'Facebook', 'hana' ),
			'variants' => array(
				'1' => '<i class="fa fa-facebook"></i>',
			),
		),
		'twitter' => array(
			'label' => __( 'Twitter', 'hana' ),
			'variants' => array(
				'1' => '<i class="fa fa-twitter"></i>',
			),
		),
		'linkedin' => array(
			'label' => __( 'Linkedin', 'hana' ),
			'variants' => array(
				'1' => '<i class="fa fa-linkedin"></i>',
			),
		),
		'googleplus' => array(
			'label' => __( 'Google+', 'hana' ),
			'variants' => array(
				'1' => '<i class="fa fa-google-plus-official"></i>',
			),
		),
		'youtube' => array(
			'label' => __( 'YouTube', 'hana' ),
			'variants' => array(
				'1' => '<i class="fa fa-youtube-play"></i>',
			),
		),
		'pinterest' => array(
			'label' => __( 'Pinterest', 'hana' ),
			'variants' => array(
				'1' => '<i class="fa fa-pinterest"></i>',
			),
		),
		'rss' => array(
			'label' => __( 'RSS', 'hana' ),
			'variants' => array(
				'1' => '<i class="fa fa-rss"></i>',
			),
		),
	);
	return apply_filters('hana_social_services', $socials );
}

function hana_social_display( $class = 'sociallink' ) {
	$services = hana_social_services();	
	$list = '';
	foreach ($services as $key => $service ) {
		if ( get_theme_mod( 'social_' . $key ) ) {
			$list .= '<li><a class="sl-' . esc_attr( $key  ) . '" href="';
			$list .= esc_url( get_theme_mod( 'social_' . $key ) ) . '" title="';
			$list .= __('Follow us on ', 'hana') .$service['label'] . '">' . $service['variants'][1];
			$list .= '</a></li>';
		}
	}
	if ( !empty( $list ) ) {
		$list = '<ul class="' . $class . '">' . $list . '</ul>';
	}
	echo apply_filters( 'hana_social_display', $list );
}