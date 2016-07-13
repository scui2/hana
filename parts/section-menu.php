<?php
/**
 * The template part to display section menu
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
if (  has_nav_menu( 'section' ) || ( get_theme_mod( 'social_section' ) && has_nav_menu( 'social' ) ) ) { ?>
	<div class="sectionmenu show-for-large">
		<div class="<?php hana_grid()->header_row_class(); ?>">
<?php		if ( has_nav_menu( 'section' ) ) { ?>
				<nav class="section-menu">
<?php				wp_nav_menu( array(
						'theme_location'  => 'section',
						'menu_class' => '',	
						'container'  => false,
					)); ?>
				</nav>
<?php		}
			if ( get_theme_mod( 'social_section') && has_nav_menu( 'social' ) ) {
				hana_social_menu( 'social social-section float-right' );
			} ?>
		</div>
	</div>
<?php
}