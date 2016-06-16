<?php
/**
 * Foundation Framework functions
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCteation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
class hana_topbar_walker extends Walker_Nav_Menu {
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\" menu\" data-submenu>\n";
	}
}

function hana_nav_fb() {
	echo '<ul class="menu" data-responsive-menu="drilldown medium-dropdown">';
	wp_list_pages(array(
			'echo' => 1,
			'title_li'     => '',
			'sort_column' => 'menu_order, post_title',
			'post_type' => 'page',
			'walker' => new hana_page_walker(),
			'post_status' => 'publish'
	));
	echo '</ul>';
}

class hana_page_walker extends Walker_Page {
	
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"vertical menu\" data-submenu>\n";
	}

}

if ( ! function_exists( 'hana_content_class' ) ) :
function hana_content_class() {
	$content = hana_option( 'content_column' );
	$sidebar_pos = hana_option( 'sidebar_pos' );
	$sidebar1 = hana_option( 'sidebar1_column' );
	$sidebar2 = hana_option( 'sidebar2_column' );
		
	$class = 'large-' . $content . ' medium-' . $content;
	if ( 'left' == $sidebar_pos && ( $sidebar1 > 0 || $sidebar2 > 0 ) ) {
		if ( ( $content + $sidebar1 + $sidebar2 ) > 12 ) {
			if ( $sidebar1 > $sidebar2 )
				$push_col = $sidebar1; 
			else
				$push_col = $sidebar2;
		}
		else {
			$push_col = $sidebar1 + $sidebar2; 			
		}
		$class .=  ' large-push-' . $push_col . ' medium-push-' . $push_col;
	}
	elseif ( 'both' == $sidebar_pos && $sidebar1 > 0 ) {
		$class .= ' large-push-' . $sidebar1 . ' medium-push-' . $sidebar1;	;		
	}
	elseif ( 'none' == $sidebar_pos  ) {
		$class .= ' large-centered';		
	}
	$class .= ' columns';
	return $class;
}
endif;

if ( ! function_exists( 'hana_sidebar_class' ) ) :
function hana_sidebar_class( $location ) {
	$content = hana_option( 'content_column' );
	$sidebar_pos = hana_option( 'sidebar_pos' );
	$sidebar1 = hana_option( 'sidebar1_column' );
	$sidebar2 = hana_option( 'sidebar2_column' );

	$width = $sidebar1 + $sidebar2;		
	if ( ( $width + $content ) > 12 ) 
		$width = 12 - $content;
	$class = '';
	if ( 'full' == $location ) {
		$class = 'large-' . $width . ' medium-' . $width;
		if ( 'left' == $sidebar_pos )
			$class .= ' large-pull-' . $content . ' medium-pull-' . $content;
		$class .= ' columns';
	}
	elseif ( 'one' == $location ) {
		if ( 'both' == $sidebar_pos )
			$width = $sidebar1;
		$class = 'large-' . $sidebar1  . ' medium-' . $width;
		if ( 'right' != $sidebar_pos )
			$class .= ' large-pull-' . $content . ' medium-pull-' . $content;
		$class .= ' columns';		
	}
	elseif ( 'two' == $location ) {
		if ( 'both' == $sidebar_pos )
			$width = $sidebar2;
		$class = 'large-' . $sidebar2  . ' medium-' . $width;
		if ( 'left' == $sidebar_pos )
			$class .= ' large-pull-' . $content . ' medium-pull-' . $content;
		$class .= ' columns';	
	}		
			    
	return $class;
}
endif;

if ( ! function_exists( 'hana_grid_columns' ) ) :
function hana_grid_columns( $large_col, $medium_col = NULL ) {
	if ( !isset( $medium_col ) )
		$medium_col = $large_col;
	return 'large-' . $large_col . ' medium-' . $medium_col . ' columns';
}
endif; 

if ( ! function_exists( 'hana_grid_full' ) ) :
function hana_grid_full() {
	return "large-12 columns";
}
endif;

if ( ! function_exists( 'hana_bbp_class' ) ) :
function hana_bbp_class() {
	$sidebar = intval( hana_option( 'sidebar_bbp' ) );

	$width = 12 - $sidebar;		
	$class = 'large-' . $width  . ' medium-' . $width;
	$class .= ' columns';	
			    
	return $class;
}
endif;

if ( ! function_exists( 'hana_full_width_class' ) ) :
function hana_full_width_class() {
	if ( hana_option('fluid_width') || is_page_template( 'pages/fullwidth.php') )
		echo ' expanded';
}
endif;
