<?php
/**
 * Sidebar for bbPress/BuddyPress.
 *
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */ 
	if ( absint( get_theme_mod( 'sidebar_bbp', 3 ) ) > 0 && is_active_sidebar( 'sidebar-bbp' ) ) {
?>		<div id="sidebar-bbp" class="sidebar <?php hana_grid()->bbp_sidebar_class(); ?>" role="complementary">			
			<?php dynamic_sidebar( 'sidebar-bbp' );	?>
		</div>
<?php
	}
