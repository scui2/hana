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
if ( ( is_active_sidebar( 'footer-1' ) && get_theme_mod( 'footer1' ) )
		|| ( is_active_sidebar( 'footer-2' ) && get_theme_mod( 'footer2' ) > 0 )
		|| ( is_active_sidebar( 'footer-3' ) && get_theme_mod( 'footer3' ) > 0 )		
		|| ( is_active_sidebar( 'footer-4' ) && get_theme_mod( 'footer4' ) > 0 ) ) {
?>
<div id="footer-widgets" role="complementary">
	<div class="row">
<?php
	if ( is_active_sidebar( 'footer-1' ) && get_theme_mod( 'footer1' )) { ?>
		<div id="footer-1" class="<?php hana_grid()->column_class( absint(get_theme_mod( 'footer1' ) ) ); ?> footer-widget">
			<?php dynamic_sidebar( 'footer-1' ); ?>
		</div>
<?php
	}
	if ( is_active_sidebar( 'footer-2' ) && get_theme_mod( 'footer2' ) > 0 ) { ?>
		<div id="footer-2" class="<?php hana_grid()->column_class( absint(get_theme_mod( 'footer2' ) ) ); ?> footer-widget">
			<?php dynamic_sidebar( 'footer-2' ); ?>
		</div>
<?php
	}
	if ( is_active_sidebar( 'footer-3' ) && get_theme_mod( 'footer3' ) > 0 ) { ?>
		<div id="footer-3" class="<?php hana_grid()->column_class( absint(hana_option( 'footer3' ) ) ); ?> footer-widget">
			<?php dynamic_sidebar( 'footer-3' ); ?>
		</div>
<?php
	}
	if ( is_active_sidebar( 'footer-4' ) && get_theme_mod( 'footer4' ) > 0 ) { ?>
		<div id="footer-4" class="<?php hana_grid()->column_class( absint(get_theme_mod( 'footer4' ) ) ); ?> footer-widget">
			<?php dynamic_sidebar( 'footer-4' ); ?>
		</div>
<?php
	} ?>
	</div>
</div>
<?php
}
