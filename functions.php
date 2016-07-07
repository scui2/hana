<?php
/**
 * New Voyage Functions
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
		'max_posts' => get_theme_mod( 'max_featured', 10 ),
	 	'post_types' => array( 'post', 'page' ),
	 ));
	// Woo Commerce support
	add_theme_support( 'woocommerce' );
	// Editor Style
	add_editor_style( 'css/editor.css' );
	// Image Sizes
	if ( 'ticker' == get_theme_mod('slider_type') )
		add_image_size( 'hana-ticker', 255, 155, true);
	add_image_size( 'hana-thumb', 480, 320, true);
	// Menus
	register_nav_menus( array(
		'top-bar' => __( 'Top Menu' , 'hana' ),
		'section' => __( 'Section Menu' , 'hana' ),
		'footer'  => __( 'Footer Menu', 'hana' ),
		'social'  => __( 'Social Menu', 'hana' ),
	));
	// Widgets
	add_theme_support( 'hana-recentpost' );
	add_theme_support( 'hana-navigation' );
	add_theme_support( 'hana-marketing' );	
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
	$font_url = hana_google_font_url();
	if (! empty( $font_url ) )
		wp_enqueue_style( 'hana-fonts', $font_url );
	// Load Font Awesome
	wp_enqueue_style( 'fontawesome' );
	// Load Theme Style and Script
	$deps = array( 'hana-foundation' );
	if ( $has_featured = hana_has_featured_posts() ) {
		$deps[] = 'bxslider';	
	}
	wp_enqueue_style( 'hana-style', HANA_THEME_URI . 'css/hana.css', $deps, HANA_THEME_VERSION );
	wp_enqueue_script( 'hana-script' , HANA_THEME_URI . 'js/hana.js', $deps, HANA_THEME_VERSION, true );	
	// Load Scheme's style
	$scheme = get_theme_mod( 'color_scheme', 'default' );
    if ( 'default' != $scheme  ) {
		$schemes = hana_scheme_options();		
		wp_enqueue_style( 'hana-scheme', $schemes[ $scheme ]['css'], $deps, HANA_THEME_VERSION );
 		$deps[] = 'hana-scheme';
	} 
	//Load child theme's style.css
    if ( HANA_THEME_URI != HANA_CHILD_URI )
		wp_enqueue_style( 'hana-child', get_stylesheet_uri(), $deps, HANA_THEME_VERSION );
	// Add inline style based on customizer settings
    $custom_css = hana_custom_css();
	if ( ! empty( $custom_css ) )
	    wp_add_inline_style( 'hana-style', htmlspecialchars_decode( $custom_css ) );
}
endif;

add_action( 'widgets_init', 'hana_widgets_init' );
function hana_widgets_init() {	
	$sidebars = array (
		'sidebar-full' => array(
			'name' => __( 'Blog Widget Area (Full)', 'hana' ),
			'description' => __( 'Blog Widget Area (Full) will not be displayed for Left & Right Sidebar', 'hana' ),
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
	
	foreach ( $sidebars as $id => $sidebar ) {
		register_sidebar( array(
			'id'   			=> $id,
			'name' 			=> $sidebar['name'],
			'description'   => $sidebar['description'],
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section><hr class="widget-divider">',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );		
	}	
	// Home Widget
	$num = absint( apply_filters('hana_homewidget_number', 4) );
	for ( $i = 1; $i <= $num; $i++ ) {
		$column = absint( get_theme_mod( 'home_column_' . $i, 3 ) );
		if ( $column > 1 ) {
			$desc = sprintf( __('The widgets will be displayed horizontally in %1$s-column layout.', 'hana'), $column);	
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
			'name' 			=> sprintf( __('Home Widget Area %1$s', 'hana'), $i),
			'description'   => $desc,
			'before_widget' => '<section id="%1$s" class="' . $class . 'widget %2$s" ' . $watch .  '>',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}
}

function hana_scheme_options() {
	$schemes = array(
		'default' 	=> array(
			'label' => __('Default','hana'),
			'css'   => '',
		),
		'rewind' 	=> array(
			'label' => __('Rewind Creation','hana'),
			'css'   => HANA_THEME_URI . 'css/rewind.css',
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
	if ( ! is_page_template( 'pages/fullwidth.php') && ! is_page_template( 'pages/nosidebar.php') )
		$classes[] = 'sidebar-' . get_theme_mod( 'sidebar_pos', 'right' );

	return $classes;
}
endif;


if ( ! function_exists( 'hana_comment' ) ) :
function hana_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) {
		case 'pingback' :
		case 'trackback' : ?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'hana' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( '<i class="fa fa-pencil"></i>'); ?></p>
	</li>
	<?php
			break;
		default : ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="clearfix">
				<div class="comment-meta">
<?php 				echo get_avatar( $comment, 40 );
					printf( '<cite class="fn">%1$s</cite>', get_comment_author_link() );  ?>
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>"><?php echo human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp') ) . __( ' ago', 'hana' ); ?>
						</time></a>
<?php				if ( $comment->comment_approved == '0' ) { ?>
						<em><?php _e( 'Your comment is awaiting moderation.', 'hana' ); ?></em>
<?php 				}; ?>
				</div>
			</footer>
			<div class="comment-content">
				<?php comment_text(); ?>
				<div class="comment-reply">
<?php 				comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => __('Reply', 'hana') ) ) );
					edit_comment_link( '<i class="fa fa-pencil"></i> ' ); ?>
				</div>
			</div>
		</article>
	<?php
			break;
	}
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
	if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) { //To remove function_exists at 4.7
		the_custom_logo();
	}
	else { // Display Site Title and Tagline
?>
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
require_once( trailingslashit( get_template_directory() ) . 'inc/lib-meta.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/customize.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/extras.php' );
