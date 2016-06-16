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
if ( ( is_active_sidebar( 'footer-1' ) && hana_option( 'footer1' ) > 0 )
		|| ( is_active_sidebar( 'footer-2' ) && hana_option( 'footer2' ) > 0 )
		|| ( is_active_sidebar( 'footer-3' ) && hana_option( 'footer3' ) > 0 )		
		|| ( is_active_sidebar( 'footer-4' ) && hana_option( 'footer4' ) > 0 ) ) {
?>
<div id="footer-widget-area" role="complementary">
	<div class="row">
<?php
	if ( is_active_sidebar( 'footer-1' ) && hana_option( 'footer1' ) > 0 ) { ?>
		<div id="footer-1" class="<?php echo hana_grid_columns( intval(hana_option( 'footer1' ) ) ); ?> footer-widget">
			<?php dynamic_sidebar( 'footer-1' ); ?>
		</div>
<?php
	}
	if ( is_active_sidebar( 'footer-2' ) && hana_option( 'footer2' ) > 0 ) { ?>
		<div id="footer-2" class="<?php echo hana_grid_columns( intval(hana_option( 'footer2' ) ) ); ?> footer-widget">
			<?php dynamic_sidebar( 'footer-2' ); ?>
		</div>
<?php
	}
	if ( is_active_sidebar( 'footer-3' ) && hana_option( 'footer3' ) > 0 ) { ?>
		<div id="footer-3" class="<?php echo hana_grid_columns( intval(hana_option( 'footer3' ) ) ); ?> footer-widget">
			<?php dynamic_sidebar( 'footer-3' ); ?>
		</div>
<?php
	}
	if ( is_active_sidebar( 'footer-4' ) && hana_option( 'footer4' ) > 0 ) { ?>
		<div id="footer-4" class="<?php echo hana_grid_columns( intval(hana_option( 'footer4' ) ) ); ?> footer-widget">
			<?php dynamic_sidebar( 'footer-4' ); ?>
		</div>
<?php
	} ?>
	</div>
</div>
<?php
}
