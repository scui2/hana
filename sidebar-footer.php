<?php
/**
 * Footer Widget Areas
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
	if ( ( is_active_sidebar( 'first-footer-widget-area' ) && hana_option( 'footer1' ) > 0 )
		|| ( is_active_sidebar( 'second-footer-widget-area' ) && hana_option( 'footer2' ) > 0 )
		|| ( is_active_sidebar( 'third-footer-widget-area' ) && hana_option( 'footer3' ) > 0 )		
		|| ( is_active_sidebar( 'fourth-footer-widget-area' ) && hana_option( 'footer4' ) > 0 ) ) {
?>
<div id="footer-widget-area" role="complementary">
	<div class="row">
<?php
	if ( is_active_sidebar( 'first-footer-widget-area' ) && hana_option( 'footer1' ) > 0 ) { ?>
		<div id="first" class="<?php echo hana_grid_columns( hana_option( 'footer1' ) ); ?> widget footer-widget">
			<ul class="xoxo">
				<?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
			</ul>
		</div>
<?php
	}
	if ( is_active_sidebar( 'second-footer-widget-area' ) && hana_option( 'footer2' ) > 0) { ?>
		<div id="second" class="<?php echo hana_grid_columns( hana_option( 'footer2' ) ); ?> widget footer-widget">	
			<ul class="xoxo">
				<?php dynamic_sidebar( 'second-footer-widget-area' ); ?>
			</ul>
		</div>
<?php
	}
	if ( is_active_sidebar( 'third-footer-widget-area' ) && hana_option( 'footer3' ) > 0 ) { ?>
		<div id="third" class="<?php echo hana_grid_columns( hana_option( 'footer3' ) ); ?> widget footer-widget">
			<ul class="xoxo">
				<?php dynamic_sidebar( 'third-footer-widget-area' ); ?>
			</ul>
		</div>
<?php
	}
	if ( is_active_sidebar( 'fourth-footer-widget-area' ) && hana_option( 'footer4' ) > 0 ) { ?>
		<div id="fourth" class="<?php echo hana_grid_columns( hana_option( 'footer4' ) ); ?> widget footer-widget">
			<ul class="xoxo">
				<?php dynamic_sidebar( 'fourth-footer-widget-area' ); ?>
			</ul>
		</div>
<?php
	} ?>
	</div>
</div>
<?php
	}