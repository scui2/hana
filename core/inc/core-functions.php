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

add_action( 'wp_enqueue_scripts', 'hanacore_register_scripts', 0 );
function hanacore_register_scripts() {
	// Font Awesome and bxSlider handdle should not be prefixed
	wp_register_style( 'fontawesome', HANA_CORE_URI . 'css/font-awesome.min.css', null, '4.6.3');
	wp_register_style( 'bxslider', HANA_CORE_URI . 'css/jquery.bxslider.min.css', null, '4.2.5');	
	// We are using custom version of Foundation 6
	wp_register_style( 'hana-foundation', HANA_CORE_URI . 'css/foundation6.min.css', null, '6.2.3');
	wp_register_script( 'hana-foundation' , HANA_CORE_URI . 'js/foundation.min.js', array( 'jquery'), '6.2.3', true );
	// bxSlider handdle should not be prefixed
	wp_register_script( 'bxslider' , HANA_CORE_URI . 'js/jquery.bxslider.min.js', array( 'jquery'), '4.2.5', true );	
}

add_action( 'wp_enqueue_scripts', 'hanacore_enqueue_scripts', 11 );
function hanacore_enqueue_scripts() {
	// WordPress uses comment-reply script to handle thread comments
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
