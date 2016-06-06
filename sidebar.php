<?php
/**
 * Display Sidebars
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
	$sidebar_pos = hana_option( 'sidebar_pos' );
	$sidebar1 = hana_option( 'sidebar1_column' );
	$sidebar2 = hana_option( 'sidebar2_column' );
	
	// Full Sidebar	
	$width = $sidebar1 + $sidebar2;
	$sticky = '';
	if ( hana_option( 'sticky_sidebar' ) )
		$sticky = 'class="sticky" data-sticky data-anchor="content" data-margin-top="4"';
	if ( 'both' != $sidebar_pos && 'none' != $sidebar_pos && $width > 0 && is_active_sidebar( 'full-widget-area' ) ) { ?>
		<aside id="sidebar_full" class="<?php hana_sidebar_class( 'full' ); ?> widget blog-widget" role="complementary" data-sticky-container>
			<ul <?php echo $sticky; $sticky = ''; ?>>
<?php			dynamic_sidebar( 'full-widget-area' );	?>
			</ul>
		</aside>
<?php
	}
	// First Sidebar	
	if ( is_active_sidebar( 'first-widget-area' ) && 'none' != $sidebar_pos && ( $sidebar1 > 0) ) {	?>	
		<aside id="sidebar_one" class="<?php hana_sidebar_class( 'one' ); ?> widget blog-widget" role="complementary" data-sticky-container>
			<ul <?php if (!empty($sticky)) echo $sticky; ?>>
				<?php dynamic_sidebar( 'first-widget-area' ); ?>
			</ul>
		</aside>
<?php
	}
	// Second Sidebar
	if ( is_active_sidebar( 'second-widget-area' ) && 'none' != $sidebar_pos && ( $sidebar2 > 0) ) {
?>
		<aside id="sidebar_two" class="<?php hana_sidebar_class( 'two' ); ?> widget blog-widget" role="complementary" data-sticky-container>
			<ul <?php if (!empty($sticky)) echo $sticky; ?>>
				<?php dynamic_sidebar( 'second-widget-area' ); ?>
			</ul>
		</aside>
<?php
	}
?>	
