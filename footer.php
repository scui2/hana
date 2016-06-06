<?php
/**
 * Hana Footer
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
 ?>
 	</div><!-- main -->
<?php
	get_sidebar( 'footer' );
?>
  <div id="footer" class="site-footer">
	<div class="row">
<?php
	if ( hana_option( 'social_footer') )
		hana_social_display( 'sociallink sociallink-footer' );
	if ( has_nav_menu( 'footer' ) ) {
		wp_nav_menu( array( 'container_class' => 'footer-menu float-right',
							'menu_class' => '',
							'theme_location' => 'footer' ) );
    }
?>
		<div id="site-info" class="float-left">
		<?php esc_attr_e('&copy;', 'hana'); ?> <?php printf( date('Y') ); ?><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
		</div>
	</div>
<?php if ( hana_option( 'design_credit' ) ) {?>
		<div class="design-credit row text-center">
			<a href="<?php echo esc_url( __( 'http://www.rewindcreation.com/', 'hana' ) ); ?>"><?php _e('Hana Theme by RewindCreation', 'hana') ?></a>
		</div>
<?php } ?>
	<div class="back-to-top"><a href="#"><span class="fa fa-chevron-up"></span></a></div>
  </div><!-- #footer -->
</div><!-- wrapper -->
</div>
</div><!-- Offcanvas -->
<?php wp_footer(); ?>
</body>
</html>
