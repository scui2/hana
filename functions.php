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
define( 'HANA_VERSION', '1.0.4' );

if ( ! function_exists( 'hana_setup' ) ):
function hana_setup() {
	global $hana_defaults;
	$hana_defaults = hana_default_options();
	
	load_theme_textdomain( 'hana', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
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
	// Woo Commerce support
	add_theme_support( 'woocommerce' );
	
	remove_filter( 'term_description', 'wpautop' );
	// Editor Style
	add_editor_style();
	// Image Sizes
	if ( 'ticker' == hana_option('slider_type') )
		add_image_size( 'hana-ticker', 255, 155, true);
	add_image_size( 'hana-thumb', 480, 320, true);
	
	register_nav_menus( array(
		'top-bar' => __( 'Top Menu' , 'hana' ),
		'section' => __( 'Section Menu' , 'hana' ),
		'footer'  => __( 'Footer Menu', 'hana' ),
		'social'  => __( 'Social Menu', 'hana' ),
	));
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
	$font_url = hana_google_font_url();
	if (! empty( $font_url ) )
		wp_enqueue_style( 'hana-fonts', $font_url );
	
	wp_enqueue_style('hana-fontawesome', $template_uri . '/css/font-awesome.min.css', null, '4.6.3');
	wp_enqueue_style('hana-foundation', $template_uri . '/css/foundation6.min.css', null, '6.2.3');
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
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );		
	}	
}
add_action( 'widgets_init', 'hana_widgets_init' );

function hana_sidebars() {
	$sidebars = array (
		'sidebar-full' => array(
			'name' => __( 'Blog Widget Area (Full)', 'hana' ),
			'description' => __( 'Available for Left or Right sidebar layout.', 'hana' ),
		),
		'sidebar-1' => array(
			'name' => __( 'Blog Widget Area 1', 'hana' ),
			'description' => __( 'Blog Widget Area 1', 'hana' ),
		),
		'sidebar-2' => array(
			'name' => __( 'Blog Widget Area 2', 'hana' ),
			'description' => __( 'Blog Widget Area 2', 'hana' ),
		),
		'footer-1' => array(
			'name' => __( 'Footer Widget Area 1', 'hana' ),
			'description' => __( 'Footer Widget Area 1', 'hana' ),
		),
		'footer-2' => array(
			'name' => __( 'Footer Widget Area 2', 'hana' ),
			'description' => __( 'Footer Widget Area 2', 'hana' ),
		),
		'footer-3' => array(
			'name' => __( 'Footer Widget Area 3', 'hana' ),
			'description' => __( 'Footer Widget Area 3', 'hana' ),
		),
		'footer-4' => array(
			'name' => __( 'Footer Widget Area 4', 'hana' ),
			'description' => __( 'Footer Widget Area 4', 'hana' ),
		),
	);
	if ( class_exists( 'bbPress' ) ) {
		$sidebars['sidebar-bbp'] = array(
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
		'rewind' 	=> array(
			'label' => __('Rewind Creation','hana'),
			'css'   => $theme_uri . '/schemes/rewind.css',
		),
	);
	return $schemes;
}
add_filter( 'hana_scheme_options', 'hana_scheme_options');

require_once( get_template_directory() . '/inc/general.php' );
require_once( get_template_directory() . '/inc/fonts.php' );
require_once( get_template_directory() . '/inc/core-functions.php' );
require_once( get_template_directory() . '/inc/lib-foundation.php' );
require_once( get_template_directory() . '/inc/lib-formats.php' );
require_once( get_template_directory() . '/inc/lib-template.php' );
require_once( get_template_directory() . '/inc/lib-meta.php' );
require_once( get_template_directory() . '/inc/customize.php' );
require_once( get_template_directory() . '/inc/widgets.php' );
require_once( get_template_directory() . '/inc/extras.php' );
if ( is_admin() ) {
	require_once( get_template_directory() . '/inc/core-admin.php' );
}


