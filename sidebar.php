<?php
/**
 * Display Sidebars
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
	$sidebar_pos = hana_option( 'sidebar_pos' );
	$sidebar1 = intval( hana_option( 'sidebar1_column' ) );
	$sidebar2 = intval( hana_option( 'sidebar2_column' ) );
	$width = $sidebar1 + $sidebar2;
	//Sticky Sidebar
	$sticky = '';
	if ( hana_option( 'sticky_sidebar' ) )
		$sticky = '<div class="sticky" data-sticky data-anchor="content" data-margin-top="4" style="width:100%">';
	// Full Sidebar	
	if ( 'both' != $sidebar_pos && 'none' != $sidebar_pos && $width > 0 && is_active_sidebar( 'sidebar-full' ) ) { ?>
		<aside id="sidebar-full" class="<?php echo hana_sidebar_class( 'full' ); ?> sidebar" role="complementary" data-sticky-container>
<?php		if ( !empty($sticky) )
				echo $sticky;
			dynamic_sidebar( 'sidebar-full' );
			if ( !empty($sticky) ) {
				echo '</div>';
				$sticky = '';
			} ?>
		</aside>
<?php
	}
	
	// First Sidebar	
	if ( is_active_sidebar( 'sidebar-1' ) && 'none' != $sidebar_pos && ( $sidebar1 > 0) ) {	?>	
		<aside id="sidebar-1" class="<?php echo hana_sidebar_class( 'one' ); ?> sidebar" role="complementary" data-sticky-container>
<?php		if ( !empty($sticky) )
				echo $sticky;
			dynamic_sidebar( 'sidebar-1' );
			if ( !empty($sticky) ) {
				echo '</div>';
			} ?>
		</aside>
<?php
	}
	// Second Sidebar
	if ( is_active_sidebar( 'sidebar-2' ) && 'none' != $sidebar_pos && ( $sidebar2 > 0) ) { ?>
		<aside id="sidebar-2" class="<?php echo hana_sidebar_class( 'two' ); ?> sidebar" role="complementary" data-sticky-container>
<?php		if ( !empty($sticky) )
				echo $sticky;
			dynamic_sidebar( 'sidebar-2' );
			if ( !empty($sticky) ) {
				echo '</div>';
			} ?>
		</aside>
<?php
	}

