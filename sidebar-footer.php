<?php
/**
 * Footer Widget Areas
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
$width1 = absint( get_theme_mod( 'footer1', 3 ) );
$width2 = absint( get_theme_mod( 'footer2', 3 ) );
$width3 = absint( get_theme_mod( 'footer3', 3 ) );
$width4 = absint( get_theme_mod( 'footer4', 3 ) );

if ( ( is_active_sidebar( 'footer-1' ) &&  $width1 > 0 )
		|| ( is_active_sidebar( 'footer-2' ) && $width2 > 0 )
		|| ( is_active_sidebar( 'footer-3' ) && $width3 > 0 )		
		|| ( is_active_sidebar( 'footer-4' ) && $width4 > 0 ) ) {
?>
<div id="footer-widgets" role="complementary">
	<div class="<?php hana_grid()->row_class('row'); ?>">
<?php
	if ( is_active_sidebar( 'footer-1' ) && $width1 ) { ?>
		<div id="footer-1" class="<?php hana_grid()->column_class( $width1 ); ?> footer-widget">
			<?php dynamic_sidebar( 'footer-1' ); ?>
		</div>
<?php
	}
	if ( is_active_sidebar( 'footer-2' ) && $width2 > 0 ) { ?>
		<div id="footer-2" class="<?php hana_grid()->column_class( $width2 ); ?> footer-widget">
			<?php dynamic_sidebar( 'footer-2' ); ?>
		</div>
<?php
	}
	if ( is_active_sidebar( 'footer-3' ) && $width3 > 0 ) { ?>
		<div id="footer-3" class="<?php hana_grid()->column_class( $width3 ); ?> footer-widget">
			<?php dynamic_sidebar( 'footer-3' ); ?>
		</div>
<?php
	}
	if ( is_active_sidebar( 'footer-4' ) && $width4 > 0 ) { ?>
		<div id="footer-4" class="<?php hana_grid()->column_class( $width4 ); ?> footer-widget">
			<?php dynamic_sidebar( 'footer-4' ); ?>
		</div>
<?php
	} ?>
	</div>
</div>
<?php
}
