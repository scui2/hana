<?php
/**
 * New Voyage Functions
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
define( 'HANA_VERSION', '1.0.3' );

if ( ! function_exists( 'hana_setup' ) ):
function hana_setup() {
	global $hana_defaults;
	$hana_defaults = hana_default_options();
	
	load_theme_textdomain( 'hana', get_template_directory() . '/languages' );
	
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
		
	register_nav_menus( array(
		'top-bar' => __( 'Top Menu' , 'hana' ),
		'section' => __( 'Section Menu' , 'hana' ),
		'footer'  => __( 'Footer Menu', 'hana' ),
	));
	
	// Custom Logo 
	add_theme_support( 'custom-logo', array(
		'height'      => 160,
		'width'       => 240,
		'flex-height' => true,
	) );
	// Featured Image
	add_theme_support( 'post-thumbnails' );
	// Post Formats	
	add_theme_support( 'post-formats', array( 'aside', 'link', 'quote', 'gallery', 'status', 'quote', 'image', 'video', 'audio', 'chat' ) );
	//HTML5 support
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
	// Jetpack Featured Conent
	add_theme_support( 'featured-content', array(
		'filter' => 'hana_get_featured_posts',
		'max_posts' => hana_option( 'max_featured' ),
	 	'post_types' => array( 'post', 'page' ),
	));
	remove_filter( 'term_description', 'wpautop' );
	// Editor Style
	add_editor_style();
	// Image Sizes
	add_image_size( 'hana-ticker', 255, 155, true);
	add_image_size( 'hana-thumb', 300, 200, true);
}
endif;
add_action( 'after_setup_theme', 'hana_setup' );

// Global variable for content width
function hana_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'hana_content_width', 840 );
}
add_action( 'after_setup_theme', 'hana_content_width', 0 );

function hana_theme_scripts() {
	$template_uri = get_template_directory_uri();		
	// Load Google Font
	$hana_fonts = hana_font_list();
	$fonts = array();
	$font_elements = hana_font_elements();
	foreach ( $font_elements as $key => $element ) {
		$value = hana_option( $key );
		if ( ! empty( $value ) && 'default' != $value && ! in_array( $value, $fonts) )
			$fonts[] = $value;		
	}
	foreach ( $fonts as $font ) {
		if ( ! empty( $hana_fonts[ $font ]['url'] ) )
			wp_enqueue_style( str_replace(' ', '-', $hana_fonts[ $font ]['label']), $hana_fonts[ $font ]['url'], false, '20160525' );
	}
	
	wp_enqueue_style('hana-fontawesome', $template_uri . '/css/font-awesome.min.css', null, '4.6.3');
	wp_enqueue_style('hana-foundation', $template_uri . '/css/foundation6.css', null, '6.2.3');
	$deps = array( 'hana-foundation' );
	if ( $has_featured = hana_has_featured_posts() ) {
		wp_enqueue_style('hana-bxslider', $template_uri . '/css/jquery.bxslider.min.css', null, '4.2.5');		
		$deps = 'hana-bxslider';	
	}
	wp_enqueue_style( 'hana-style', $template_uri . '/css/hana.css', $deps , HANA_VERSION );
    if ( 'default' != hana_option( 'color_scheme' ) ) {
		$schemes = apply_filters( 'hana_scheme_options', NULL );		
		wp_enqueue_style( 'hana-scheme', $schemes[ hana_option( 'color_scheme' ) ]['css'], $deps, HANA_VERSION );
 		$deps = array( 'hana-scheme' );
	} 
	//Load child theme's style.css
    if ( $template_uri != get_stylesheet_directory_uri() )
		wp_enqueue_style('hana-child', get_stylesheet_uri(), $deps, HANA_VERSION );
			
    $custom_css = hana_custom_css();
	if ( ! empty( $custom_css ) )
	    wp_add_inline_style( 'hana-style', htmlspecialchars_decode( $custom_css ) );

	// Load Javascript
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	wp_enqueue_script( 'hana-foundation' , $template_uri . '/js/foundation.min.js', array( 'jquery'), '6.2.3', true );
	$deps = array( 'hana-foundation' );
	if ( $has_featured ) {
		wp_enqueue_script( 'hana-bxslider' , $template_uri . '/js/jquery.bxslider.min.js', array( 'jquery'), '4.2.5', true );
		$deps = 'hana-bxslider';	
	}
	wp_enqueue_script( 'hana' , $template_uri . '/js/hana.js', $deps, HANA_VERSION, true );
}
if ( ! is_admin() )
	add_action( 'wp_enqueue_scripts', 'hana_theme_scripts' );
	
function hana_widgets_init() {
	register_widget( 'Hana_Recent_Post' );
	register_widget( 'Hana_Navigation' );

	$sidebars = hana_sidebars();
	foreach ( $sidebars as $id => $sidebar ) {
		register_sidebar( array(
			'id'   			=> $id,
			'name' 			=> $sidebar['name'],
			'description'   => $sidebar['description'],
			'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
			'after_widget'  => '</li>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );		
	}	
}
add_action( 'widgets_init', 'hana_widgets_init' ); 

function hana_sidebars() {
	$sidebars = array (
		'full-widget-area' => array(
			'name' => __( 'Blog Widget Area (Full)', 'hana' ),
			'description' => __( 'Available for Left or Right sidebar layout.', 'hana' ),
		),
		'first-widget-area' => array(
			'name' => __( 'Blog Widget Area 1', 'hana' ),
			'description' => __( 'Blog Widget Area 1', 'hana' ),
		),
		'second-widget-area' => array(
			'name' => __( 'Blog Widget Area 2', 'hana' ),
			'description' => __( 'Blog Widget Area 2', 'hana' ),
		),
		'first-footer-widget-area' => array(
			'name' => __( 'Footer Widget Area 1', 'hana' ),
			'description' => __( 'Footer Widget Area 1', 'hana' ),
		),
		'second-footer-widget-area' => array(
			'name' => __( 'Footer Widget Area 2', 'hana' ),
			'description' => __( 'Footer Widget Area 2', 'hana' ),
		),
		'third-footer-widget-area' => array(
			'name' => __( 'Footer Widget Area 3', 'hana' ),
			'description' => __( 'Footer Widget Area 3', 'hana' ),
		),
		'fourth-footer-widget-area' => array(
			'name' => __( 'Footer Widget Area 4', 'hana' ),
			'description' => __( 'Footer Widget Area 4', 'hana' ),
		),
	);
	if ( class_exists( 'bbPress' ) ) {
		$sidebars['bbp-widget-area'] = array(
			'name' => __( 'bbPress Widget Area', 'hana' ),
			'description' => __( 'bbPress Widget Area', 'hana' ),
		);
	}
	return apply_filters( 'hana_sidebars', $sidebars );
}

function hana_scheme_options( $scheme  ) {
	$theme_uri = get_template_directory_uri();
	$schemes = array(
		'default' 	=> array(
			'label' => __('Default','hana'),
			'css'   => '',
		),
		'orange' 	=> array(
			'label' => __('Orange','hana'),
			'css'   => $theme_uri . '/schemes/orange.css',
		),
	);
	return $schemes;
}
add_filter( 'hana_scheme_options', 'hana_scheme_options');

require( get_template_directory() . '/inc/general.php' );
require( get_template_directory() . '/inc/fonts.php' );
require( get_template_directory() . '/inc/core-functions.php' );
require( get_template_directory() . '/inc/lib-foundation.php' );
require( get_template_directory() . '/inc/lib-formats.php' );
require( get_template_directory() . '/inc/lib-template.php' );
require( get_template_directory() . '/inc/lib-meta.php' );
require( get_template_directory() . '/inc/customize.php' );
require( get_template_directory() . '/inc/widgets.php' );
require( get_template_directory() . '/inc/extras.php' );
if ( is_admin() ) {
	require( get_template_directory() . '/inc/core-admin.php' );
}

