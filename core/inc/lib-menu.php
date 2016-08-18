<?php
/**
 * Menu Wakler and Fallback function
 * 
 * @package	hanacore
 * @since   1.0
 * @author  RewindCteation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
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
// Add active class for current selected menu item
add_filter('nav_menu_css_class' , 'hana_active_menu_class');
function hana_active_menu_class( $classes ) {
    if ( in_array('current-menu-item', $classes) ){
        $classes[] = 'active';
    }
    return $classes;
}
/******************************
* Social Menu
******************************/
if ( ! function_exists( 'hana_social_menu' ) ) :
function hana_social_menu( $class = 'sociallink' ) {
	if ( has_nav_menu( 'social' ) ) {
		wp_nav_menu(
			array(
				'theme_location'  => 'social',
				'container'       => false,
				'menu_class'      => $class,
				'depth'           => 1,
				'link_before'     => '<span class="screen-reader-text">',
				'link_after'      => '</span>',
				'fallback_cb'     => '',
			)
		);
	}
}
endif;