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
	$sidebar_pos = get_theme_mod( 'sidebar_pos', 'right' );
	if ( 'none' != $sidebar_pos  ) {
		$sidebar1 = absint( get_theme_mod( 'sidebar1_column', 2 ) );
		$sidebar2 = absint( get_theme_mod( 'sidebar2_column', 2 ) );
		$width = $sidebar1 + $sidebar2;
		//Sticky Sidebar
		$sticky = '';
		if ( get_theme_mod( 'sticky_sidebar' ) )
			$sticky = '<div class="sticky sticky-sidebar" data-sticky data-anchor="content" data-margin-top="4">';
		// Full Sidebar	
		if ( 'both' != $sidebar_pos && $width > 0 && is_active_sidebar( 'sidebar-full' ) ) { ?>
			<aside id="sidebar-full" class="<?php hana_grid()->sidebar_class( 'full' ); ?> sidebar" role="complementary" data-sticky-container>
<?php			if ( !empty($sticky) )
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
		if ( is_active_sidebar( 'sidebar-1' ) && ( $sidebar1 > 0) ) {	?>	
			<aside id="sidebar-1" class="<?php hana_grid()->sidebar_class( 'one' ); ?> sidebar" role="complementary" data-sticky-container>
<?php			if ( !empty($sticky) )
					echo $sticky;
				dynamic_sidebar( 'sidebar-1' );
				if ( !empty($sticky) ) {
					echo '</div>';
				} ?>
			</aside>
<?php
		}
		// Second Sidebar
		if ( is_active_sidebar( 'sidebar-2' ) && ( $sidebar2 > 0) ) { ?>
			<aside id="sidebar-2" class="<?php hana_grid()->sidebar_class( 'two' ); ?> sidebar" role="complementary" data-sticky-container>
<?php			if ( !empty($sticky) )
				echo $sticky;
				dynamic_sidebar( 'sidebar-2' );
				if ( !empty($sticky) ) {
					echo '</div>';
				} ?>
			</aside>
<?php
		}
	}

