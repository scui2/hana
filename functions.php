<?php
/**
 * Hana Theme Functions
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
// Load HANACore Functions
require_once( trailingslashit( get_template_directory() ) . 'core/hana-core.php' );
new HANA_Core();

add_action( 'after_setup_theme', 'hana_theme_setup', 10 );
if ( ! function_exists( 'hana_theme_setup' ) ):
function hana_theme_setup() {
	// Load Text Domain.
	load_theme_textdomain( 'hana' , HANA_THEME_DIR . 'languages' );
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
	// Jetpack Featured Conent
	add_theme_support( 'featured-content', array(
		'filter' => 'hana_get_featured_posts',
		'max_posts' => esc_attr( get_theme_mod( 'max_featured', 10 ) ),
	 	'post_types' => array( 'post', 'page' ),
	 ));
	// Editor Style
	add_editor_style( 'css/editor.css' );
	// Image Sizes
	if ( 'ticker' == get_theme_mod('slider_type') )
		add_image_size( 'hana-ticker', 255, 155, true);
	add_image_size( 'hana-thumb', 480, 320, true);
	// Menus
	register_nav_menus( array(
		'top-bar' => esc_html__( 'Top Menu' , 'hana' ),
		'section' => esc_html__( 'Section Menu' , 'hana' ),
		'footer'  => esc_html__( 'Footer Menu', 'hana' ),
		'social'  => esc_html__( 'Social Menu', 'hana' ),
	));
	// Hana Plugin Support
	add_theme_support( 'hana-widgets' );
	add_theme_support( 'hana-block' );
}
endif;

// Global variable for content width
add_action( 'after_setup_theme', 'hana_content_width', 0 );
function hana_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'hana_content_width', 840 );
}

add_action( 'wp_enqueue_scripts', 'hana_theme_scripts' );
if ( ! function_exists( 'hana_theme_scripts' ) ):
function hana_theme_scripts() {
	// Load Google Font
	$font_url = hana_font()->url();
	if (! empty( $font_url ) )
		wp_enqueue_style( 'hana-fonts', $font_url );
	// Load Font Awesome
	wp_enqueue_style( 'font-awesome' );
	// Load Theme Style and Script
	$deps = array( 'hana-foundation' );
	if ( $has_featured = hana_has_featured_posts() ) {
		$deps[] = 'jquery-bxslider';	
	}
	wp_enqueue_style( 'hana-style', HANA_THEME_URI . 'css/hana.css', $deps, HANA_THEME_VERSION );
	wp_enqueue_script( 'hana-script' , HANA_THEME_URI . 'js/hana.js', $deps, HANA_THEME_VERSION, true );
	$inline_handle = 'hana-style';
	// Load Scheme's style
	$scheme = get_theme_mod( 'color_scheme', 'default' );
    if ( 'default' != $scheme  ) {
		$schemes = hana_scheme_options();		
		wp_enqueue_style( 'hana-scheme', $schemes[ $scheme ]['css'], $deps, HANA_THEME_VERSION );
 		$deps[] = 'hana-scheme';
		$inline_handle = 'hana-scheme';
	} 
	//Load child theme's style.css
    if ( HANA_THEME_URI != HANA_CHILD_URI ) {
		wp_enqueue_style( 'hana-child', get_stylesheet_uri(), $deps, HANA_THEME_VERSION );		
		$inline_handle = 'hana-child';
	}

	// Add inline style based on customizer settings
    $custom_css = hana_custom_css();
	if ( ! empty( $custom_css ) )
	    wp_add_inline_style( $inline_handle, htmlspecialchars_decode( $custom_css ) );
}
endif;

add_action( 'widgets_init', 'hana_widgets_init' );
function hana_widgets_init() {
	$sidebars = array (
		'sidebar-full' => array(
			'name' => esc_html__( 'Blog Widget Area (Full)', 'hana' ),
			'description' => esc_html__( 'Blog Widget Area (Full) will not be displayed for Left & Right Sidebar', 'hana' ),
		),
		'sidebar-1' => array(
			'name' => esc_html__( 'Blog Widget Area 1', 'hana' ),
			'description' => esc_html__( 'Blog Widget Area 1', 'hana' ),
		),
		'sidebar-2' => array(
			'name' => esc_html__( 'Blog Widget Area 2', 'hana' ),
			'description' => esc_html__( 'Blog Widget Area 2', 'hana' ),
		),
		'footer-1' => array(
			'name' => esc_html__( 'Footer Widget Area 1', 'hana' ),
			'description' => esc_html__( 'Footer Widget Area 1', 'hana' ),
		),
		'footer-2' => array(
			'name' => esc_html__( 'Footer Widget Area 2', 'hana' ),
			'description' => esc_html__( 'Footer Widget Area 2', 'hana' ),
		),
		'footer-3' => array(
			'name' => esc_html__( 'Footer Widget Area 3', 'hana' ),
			'description' => esc_html__( 'Footer Widget Area 3', 'hana' ),
		),
		'footer-4' => array(
			'name' => esc_html__( 'Footer Widget Area 4', 'hana' ),
			'description' => esc_html__( 'Footer Widget Area 4', 'hana' ),
		),
	);
	if ( class_exists( 'bbPress' ) ) {
		$sidebars['sidebar-bbp'] = array(
			'name' => esc_html__( 'bbPress Widget Area', 'hana' ),
			'description' => esc_html__( 'bbPress Widget Area', 'hana' ),
		);
	}
	
	foreach ( $sidebars as $id => $sidebar ) {
		register_sidebar( array(
			'id'   			=> $id,
			'name' 			=> $sidebar['name'],
			'description'   => $sidebar['description'],
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section><hr class="widget-divider">',
			'before_title'  => '<div class="widget-title-container"><h4 class="widget-title">',
			'after_title'   => '</h4></div>',
		) );
	}	
	// Home Widget
	$num = absint( apply_filters('hana_homewidget_number', 4) );
	for ( $i = 1; $i <= $num; $i++ ) {
		$column = absint( get_theme_mod( 'home_column_' . $i, 3 ) );
		if ( $column > 1 ) {
			$desc = sprintf( esc_html__('The widgets will be displayed horizontally in %1$s-column layout.', 'hana'), $column);	
			$col = absint( 12 / $column );
			$class = 'large-' . $col . ' columns ';	
		} else {
			$desc = '';	
			$class = '';	
		}
		// Same height for all widgets
		$width = absint( get_theme_mod( 'home_width_' . $i, 12 ) );
		if ( 12 == $width && $column > 1) {
			$watch = 'data-equalizer-watch';
		} else {
			$watch = '';
		}
		register_sidebar( array(
			'id'   			=> 'home-' . $i,
			'name' 			=> sprintf( esc_html__('Home Widget Area %1$s', 'hana'), $i),
			'description'   => $desc,
			'before_widget' => '<div id="%1$s" class="' . $class . 'widget %2$s" ' . $watch .  '>',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}
}

function hana_scheme_options() {
	$schemes = array(
		'default' 	=> array(
			'label' => esc_html__('Default','hana'),
			'css'   => '',
		),
		'rewind' 	=> array(
			'label' => esc_html__('Rewind Creation','hana'),
			'css'   => HANA_THEME_URI . 'css/rewind.css',
		),
		'dark' 	=> array(
			'label' => esc_html__('Dark','hana'),
			'css'   => HANA_THEME_URI . 'css/dark.css',
		),
    );
	return apply_filters( 'hana_scheme_options', $schemes );
}

add_filter( 'body_class', 'hana_body_classes' );
if ( ! function_exists( 'hana_body_classes' ) ):
function hana_body_classes( $classes ) {		
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}
	if ( 'full' == get_theme_mod('slider_type', 'full' ) &&  get_theme_mod( 'sticky_header' ) &&  get_theme_mod( 'slider_top' ) && hana_has_featured_posts() )
		$classes[] = 'fullwidth-slider';
	if ( ! is_page_template( array('pages/fullwidth.php', 'pages/nosidebar.php') ) && ! is_attachment() )
		$classes[] = 'sidebar-' . esc_attr( get_theme_mod( 'sidebar_pos', 'right' ) );

	return $classes;
}
endif;

if ( ! function_exists( 'hana_the_attached_image' ) ) :	
function hana_the_attached_image() {
//Adopted from Twenty Fourteen
	$post = get_post();

	$attachment_size     = apply_filters( 'hana_attachment_size', array( 1024, 1024 ) );
	$next_attachment_url = wp_get_attachment_url();

	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID',
	) );

	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		if ( $next_id ) {
			$next_attachment_url = get_attachment_link( $next_id );
		} else {
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}
	}

	printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

if ( ! function_exists( 'hana_branding' ) ):
function hana_branding() {
	if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) { //To remove function_exists from 4.7
		the_custom_logo();
	}
	else { // Display Site Title and Tagline ?>
		<div class="site-title-container">
		  <h3 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h3>
		  <h4 class="site-description show-for-medium "><?php bloginfo( 'description' ); ?></h4>
		</div>
<?php	
	}
}
endif;

require_once( trailingslashit( get_template_directory() ) . 'inc/lib-featured.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/lib-template.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/customize.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/extras.php' );
