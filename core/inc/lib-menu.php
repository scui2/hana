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
