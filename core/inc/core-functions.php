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

// Allow a br and em and strong tag only.
function hana_wp_kses_text( $text ) {
	return wp_kses( $text , array(	'a'  => array( 'href' => array(), 'title' => array() ),
    								'br' => array(),
    								'em' => array(),
									'strong' => array() ) );
}

// Change post class sticky to wp-sticky to avoid conflict with Foundation
add_filter('post_class','hana_change_sticky_class');
function hana_change_sticky_class( $classes ) {	
	$classes = array_diff( $classes, array( 'sticky' ) );
	$classes[] = 'wp-sticky';
	return $classes;
}
/** 
* Add span to category/archive count
*/
add_filter( 'wp_list_categories', 'hana_archive_count_span' );
add_filter( 'get_archives_link', 'hana_archive_count_span' );
function hana_archive_count_span( $links ) {
	$links = str_replace( array('</a> (',  '</a>&nbsp;(') , '</a><span>', $links );
	$links = str_replace( ')', '</span>', $links );
	return $links;
}

/**
 * Replace rel="category tag" with rel="tag"
 * For W3C validation purposes only.
 */
add_filter('wp_list_categories', 'hana_replace_rel_category');
add_filter('the_category', 'hana_replace_rel_category');
function hana_replace_rel_category ($output) {
    $output = str_replace(' rel="category tag"', ' rel="tag"', $output);
    return $output;
}

// Display Post Title
if ( ! function_exists( 'hana_post_title' ) ) :
function hana_post_title( $link = false ) {
	if ( ! is_single() || $link ) {
		the_title( sprintf( '<h2 class="entry-title"><a href="%1$s" rel="bookmark">', esc_url( hana_get_post_link() ) ), '</a></h2>' );
	}
	else {
		the_title( '<h1 class="entry-title">', '</h1>');
	}
}
endif;

if ( ! function_exists( 'hana_archive_title' ) ) :	
function hana_archive_title() {	
	if ( ! have_posts() )
		return;
	
	$class = 'large-12 columns ';
	if ( is_search() ) {
		$title = sprintf( '%1$s<span class="search-term">%2$s</span>', 
					__( 'Search Results for: ', 'hana'),
					esc_html( get_search_query() ) );
		$class .= 'ph-search'; ?>
		<div class="page-header <?php echo esc_attr( $class ); ?>">
			<h1 class="page-title"><?php echo $title; ?></h1>
		</div>	
<?php	return;
	} 
	elseif ( is_category() ) { //
		$category_name = single_cat_title( '', false );
		$category_id = get_cat_ID( $category_name );
		// Category Title Class
		$class .= 'pt-category pt-category-' .  esc_attr( $category_id );
		$parent = get_term( $category_id, 'category' );
		while ( $parent->parent ) {
			$class .= ' pt-category-' . esc_attr( $parent->parent );
			$parent = get_term( $parent->parent , 'category' );				
		}
	}
	elseif ( is_tag() ) {
		$class .= 'pt-tag';
	}
	elseif ( is_day() || is_month() || is_year() ) {
		$class .= 'pt-date';
	}
	else {
		return;
	}
?>
	<div class="page-header <?php echo esc_attr( $class ); ?>">
<?php	the_archive_title( '<h1 class="page-title">', '</h1>' );
		the_archive_description( '<div class="page-description">', '</div>' ); ?>
	</div>
<?php		
}
endif;

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
		$title = "$title $sep " . sprintf( __( 'Page %s', 'hana' ), max( $paged, $page ) );

	return $title;
}

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
		$output .= ' <a class="more-link" href="'. esc_url( get_permalink() ) . '">' . hana_readmore_text() . '</a>';
	}
	return $output;
}

function hana_readmore_text() {
	global $post;
	
	$readmore = get_post_meta( $post->ID, '_hana_readmore', true );
	if ( empty( $readmore ) )
		$readmore = apply_filters( 'hana_readmore', __( 'Read More', 'hana' ) );
	return esc_html( $readmore );
}
