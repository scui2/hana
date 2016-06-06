<?php
/**
 * Core functions
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
if ( ! defined('ABSPATH') ) exit;

function hana_change_sticky_class( $classes ) {
	$classes = array_diff( $classes, array( 'sticky' ) );
	$classes[] = 'wp-sticky';
	return $classes;
}
add_filter('post_class','hana_change_sticky_class');

if ( ! function_exists( 'hana_body_classes' ) ):
function hana_body_classes( $classes ) {		
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}
	if ( 'full' == hana_option('slider_type') &&  hana_option( 'sticky_header' ) && hana_has_featured_posts() )
		$classes[] = 'fullwidth-slider';	

	if ( ! is_page_template( 'pages/fullwidth.php') && ! is_page_template( 'pages/nosidebar.php') )
		$classes[] = 'sidebar-' . hana_option( 'sidebar_pos' );

	return $classes;
}
endif;
add_filter( 'body_class', 'hana_body_classes' );

function hana_active_menu_class($classes) {
    if (in_array('current-menu-item', $classes) ){
        $classes[] = 'active ';
    }
    return $classes;
}
add_filter('nav_menu_css_class' , 'hana_active_menu_class');

function hana_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	$title .= get_bloginfo( 'name' );
	
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'hana' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'hana_wp_title', 10, 2 );

// Add <p> tag to WordPress the_excerpt()
function hana_excerpt_filter( $content ) {
	return '<p>' . $content . '</p>';
}
//remove_filter('the_excerpt', 'wpautop');
//add_filter( 'the_excerpt', 'hana_excerpt_filter' );

/** 
* Add span to category/archive count
*/
function hana_category_count_span($links) {
  $links = str_replace( '</a> (', '</a> <span>(', $links );
  $links = str_replace( ')', ')</span>', $links );
  return $links;
}
add_filter( 'wp_list_categories', 'hana_category_count_span' );

function hana_archive_count_span($links) {
  $links = str_replace( '</a>&nbsp;(', '</a> <span>(', $links );
  $links = str_replace( ')', ')</span>', $links );
  return $links;
}
add_filter( 'get_archives_link', 'hana_archive_count_span' );

if ( ! function_exists( 'hana_comment' ) ) :
function hana_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) {
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'hana' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( '<i class="fa fa-pencil"></i>'); ?></p>
	</li>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="clearfix">
				<div class="comment-meta">
<?php 				echo get_avatar( $comment, 40 );
					printf( '<cite class="fn">%1$s</cite>', get_comment_author_link() );  ?>
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time datetime="<?php comment_time( 'c' ); ?>">
					<?php
					 	echo human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp') ) . __( ' ago', 'hana' );
						//printf( __( '%1$s at %2$s', 'hana' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<div class="comment-reply">
<?php 					comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => __('Reply', 'hana') ) ) );
						edit_comment_link( '<i class="fa fa-pencil"></i> ' ); ?>
					</div>
<?php					if ( $comment->comment_approved == '0' ) { ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'hana' ); ?></em>
<?php 				}; ?>
				</div>
			</footer>
			<div class="comment-content"><?php comment_text(); ?></div>

		</article>
	<?php
			break;
	}
}
endif;

function hana_excerpt_length( $length ) {
	return apply_filters('hana_excerpt_length', 40);
}
add_filter( 'excerpt_length', 'hana_excerpt_length' );

function hana_auto_excerpt_more( $more ) {
	return ' &hellip;';
}
add_filter( 'excerpt_more', 'hana_auto_excerpt_more' );

function hana_custom_excerpt_more( $output ) {
	if ( ! is_attachment() ) {
		$output .= ' <a class="more-link" href="'. get_permalink() . '">' . esc_attr( hana_readmore_text() ) . '</a>';
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'hana_custom_excerpt_more' );

function hana_readmore_text() {
	global $post;
	
	$readmore = get_post_meta( $post->ID, '_hana_readmore', true );
	if ( empty( $readmore ) )
		$readmore = apply_filters( 'hana_readmore', __( 'Read More', 'hana' ) );
	return $readmore;
}
/**
 * Replace rel="category tag" with rel="tag"
 * For W3C validation purposes only.
 */
function hana_replace_rel_category ($output) {
    $output = str_replace(' rel="category tag"', ' rel="tag"', $output);
    return $output;
}
add_filter('wp_list_categories', 'hana_replace_rel_category');
add_filter('the_category', 'hana_replace_rel_category');

/******************************
* Pagination for main loop
******************************/
function  hana_content_nav( $nav_id ) {
	global $wp_query;
	hana_content_nav_link( $wp_query->max_num_pages, $nav_id );
}

/******************************
* Pagination
******************************/
function hana_content_nav_link( $num_of_pages, $nav_id ) {
	$html = '';
	if ( $num_of_pages > 1 ) {
		$html .=  '<ul id="' .$nav_id. '" class="pagination text-center" role="navigation" aria-label="Pagination">';

		$big = 999999999;
    	if ( get_query_var( 'paged' ) )
	    	$current_page = get_query_var( 'paged' );
		elseif ( get_query_var( 'page' ) ) 
	   	 	$current_page = get_query_var( 'page' );
		else 
			$current_page = 1;
		$links =  paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, $current_page ),
			'total' => $num_of_pages,
			'mid_size' => 3,
			'prev_text'    => '<i class="fa fa-chevron-left"></i>' ,
			'next_text'    => '<i class="fa fa-chevron-right"></i>' ,
			'type' => 'array' ) );
			
		foreach ( $links as $link )
			$html .= '<li>' . $link . '</li>';			
		$html .='</ul>';
	}
	echo apply_filters( 'hana_pagination', $html );
}

if ( ! function_exists( 'hana_branding' ) ):
function hana_branding() {
	if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
		the_custom_logo();
	}
	else { // Display Site Title and Tagline
?>
		<div class="site-title-container">
		  <h3 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h3>
		  <h4 class="site-description show-for-medium"><?php bloginfo( 'description' ); ?></h4>
		</div>
<?php	
	}
}
endif;

if ( ! function_exists( 'hana_post_title' ) ) :
// Display Post Title
function hana_post_title( $link = false ) {
	if ( ! is_single() || $link ) {
		printf('<h2 class="entry-title"><a href="%1$s" title="%2$s" rel="bookmark">%3$s</a></h2>',
			get_permalink(),
			sprintf( esc_attr__( 'Permalink to %s', 'hana' ), the_title_attribute( 'echo=0' ) ),
			get_the_title()	);
	}
	else {
		printf('<h1 class="entry-title">%1$s</h1>',
			get_the_title()	);		
	}
}
endif;



if ( ! function_exists( 'hana_page_title' ) ) :	
function hana_page_title() {	
	if ( ! have_posts() ) return;
	
	$title = '';
	$class = '';
	if ( is_search() ) { 
		$title = sprintf( __( 'Search Results for: %s', 'hana' ), '<span>' . get_search_query() . '</span>' );
	} elseif ( is_author() ) {
			the_post();
			$title = sprintf( __( 'Author: %s', 'hana' ), '<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a>' );
			rewind_posts();		
	}
	elseif ( is_category() ) {
		$category_description = get_the_archive_description();
		$category_name = single_cat_title( '', false );
		if ( empty( $category_description ) )			
			$title = sprintf( __( 'Category: %s', 'hana' ), '<span>' . $category_name . '</span>' );
		else
			$title = $category_description;		
		$category_id = get_cat_ID( $category_name );
		// Category Title Class
		$class = 'cat-title cat-title-' .  $category_id;
		$parent = get_term( $category_id, 'category' );
		while ( $parent->parent ) {
			$class = $class . ' cat-title-' . $parent->parent;
			$parent = get_term( $parent->parent , 'category' );				
		}
	}
	elseif ( is_tag() ) {
		$tag_description = tag_description();
		if ( empty( $tag_description ) )				
			$title = sprintf( __( 'Tag: %s', 'hana' ), '<span>' . single_tag_title( '', false ) . '</span>' );
		else
			$title = $tag_description;
	}
	elseif ( is_archive() ) {
		if ( is_day() ) 
			$title = sprintf( __( 'Daily Archives: %s', 'hana' ), '<span>' . get_the_date() . '</span>' );
		elseif ( is_month() )
			$title = sprintf( __( 'Monthly Archives: %s', 'hana' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'hana' ) ) . '</span>' );
		elseif ( is_year() )
			$title = sprintf( __( 'Yearly Archives: %s', 'hana' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'hana' ) ) . '</span>' );
		else
			$title = get_the_title();
	}
	if ( !empty( $title ) ) {
?>
		<div class="page-title <?php echo $class; ?>">
			<div class="row"><div class="large-12 columns">
				<h3><?php echo $title; ?></h3>
			</div></div>
		</div>
<?php		
	}
}
endif;

if ( ! function_exists( 'hana_the_attached_image' ) ) :	
function hana_the_attached_image() {
//Adopted from WP2014
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
