<?php
/**
 * Sidebar for bbPress/BuddyPress.
 *
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */ 
	$sidebar = intval( hana_option( 'sidebar_bbp' ) );
	if ( $sidebar > 0 && is_active_sidebar( 'sidebar-bbp' ) ) {
		$sidebar_class = 'large-' . $sidebar . ' medium-' . $sidebar . ' columns';
?>	
		<div id="sidebar-bbp" class="<?php echo $sidebar_class; ?> sidebar" role="complementary">			
			<?php dynamic_sidebar( 'sidebar-bbp' );	?>
		</div>
<?php
	}
