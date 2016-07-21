<?php
/**
 * The template part to display top menu
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
	if ( get_theme_mod( 'sticky_header' ) ) { ?>
		<div data-sticky-container class="sticky-container">
  	 		<div class="small-12 sticky sticky-header is-anchored" data-sticky data-sticky-on="small" data-margin-top="0" data-top-anchor="1" data-bottom-anchor="content:bottom" <?php if ( get_theme_mod( 'shrink_topbar') ) echo 'data-shrink'; ?>>
<?php
	}
	// Title for small screen ?>
    <div class="title-bar show-for-small-only" data-responsive-toggle="top-menu" data-hide-for="medium">
<?php	if ( has_nav_menu( 'section' ) ) { ?>
			<button class="float-left title-bar-icon leftmenu-toggle" data-open="offCanvasLeft"><i class="fa fa-bars"></i></button>
<?php	} ?>
 		<div class="top-bar-title"><?php hana_branding(); ?></div>
    	<button class="float-right title-bar-icon hana-toggle topmenu-toggle" data-toggle="top-menu"></button>
    </div>
	<div id="top-menu" class="top-bar" data-toggler>
		<div class="<?php hana_grid()->header_row_class(); ?>">
<?php		if ( has_nav_menu( 'section' ) ) { ?>
		  		<div class="top-bar-left">
					<button class="title-bar-icon leftmenu-toggle hide hide-for-small-only" data-toggle="offCanvasLeft"><i class="fa fa-bars"></i></button>    
	 	  		</div>
<?php		} ?>
			<div class="top-bar-left show-for-small-only small-search-form"> 
				<?php get_search_form(); ?>
			</div>
 			<div class="top-bar-title show-for-medium"><?php hana_branding(); ?></div>
  			<div class="top-bar-right show-for-medium">
  				<ul class="menu menu-search"><li><a data-open="modelSearch"><span class="fa fa-search"></span></a></li></ul>		
 			</div> 
<?php		if ( get_theme_mod( 'social_top') && has_nav_menu( 'social') ) { ?>
 				<div class="top-bar-right">
					<?php hana_social_menu( apply_filters( 'hana_topbar_social', 'social social-topbar menu' ) ); ?>
 				</div>
<?php		} ?>
  			<div class="top-bar-right">
<?php  			wp_nav_menu( array(
					'theme_location' => 'top-bar',
					'container' => false,
					'menu_class' => 'menu horizontal dropdown',
					'fallback_cb' => 'hana_nav_fb', // fallback function 
					'items_wrap' => '<ul id="%1$s" class="%2$s" data-responsive-menu="drilldown medium-dropdown">%3$s</ul>',
					'walker' => new hana_topbar_walker()
				)); ?>
			</div>
			<?php do_action('hana_topbar_close'); //Action Hook ?>
		</div>	
	</div><!-- top-bar -->
<?php
	if ( get_theme_mod( 'sticky_header' ) ) { ?>
  	  		</div>
		</div><!-- sticky container -->
<?php
	} ?>
	<div id="modelSearch" class="reveal" data-reveal>
		<?php get_search_form(); ?>
	</div>
