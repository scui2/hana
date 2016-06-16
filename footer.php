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
<?php get_sidebar( 'footer' ); ?>
<div id="footer" class="site-footer">
	<div class="row">
		<div id="site-info" class="medium-4 columns">
			<i class="fa fa-copyright"></i> <?php printf( date('Y') ); ?><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
		</div>
<?php	$menu_class ='medium-8';
		if ( hana_option( 'social_footer') ) { 
			$menu_class ='medium-4'; ?>
			<div class="medium-4 columns">
				<?php hana_social_display( 'sociallink sociallink-footer' ); ?>
			</div>
<?php	} ?>
		<div class="<?php echo $menu_class;?> columns footer-menu">
<?php		if ( has_nav_menu('footer') )
				wp_nav_menu( array( 'container' => false,
									'menu_class' => '',
									'theme_location' => 'footer' ) ); ?>
		</div>
	</div>
<?php
	if ( hana_option( 'design_credit' ) ) { ?>
		<div class="design-credit row text-center">
			<a href="<?php echo esc_url( __( 'http://www.rewindcreation.com/', 'hana' ) ); ?>"><?php _e('Hana Theme by RewindCreation', 'hana') ?></a>
		</div>
<?php
	} ?>
	<div class="back-to-top"><a href="#"><span class="fa fa-chevron-up"></span></a></div>
</div><!-- #footer -->
</div><!-- wrapper -->
</div></div><!-- Offcanvas -->
<?php wp_footer(); ?>
</body>
</html>
