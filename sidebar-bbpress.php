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
	if ( $sidebar > 0 && is_active_sidebar( 'bbp-widget-area' ) ) {
				
		$sidebar_class = 'large-' . $sidebar . ' medium-' . $sidebar . ' columns';
?>	
		<div id="bbp-sidebar" class="<?php echo $sidebar_class; ?> widget blog-widget" role="complementary">		
			<ul class="xoxo">		
<?php			dynamic_sidebar( 'bbp-widget-area' );	?>
			</ul>
		</div>
<?php
	}
?>
