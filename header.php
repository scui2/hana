<?php
/**
 * Header
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="off-canvas-wrapper" class="off-canvas-wrapper">
<div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
	<?php get_template_part( 'parts/left', 'menu' ); ?>
<div id="wrapper" class="site off-canvas-content" data-off-canvas-content>
			<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'hana' ); ?></a>
	<?php do_action('hana_header_top'); //Action Hook ?>
 	<header id="masthead" class="site-header clearfix" role="banner">
		<?php get_template_part( 'parts/top', 'menu' ); ?>
	</header>
 <?php
	if ( 'full' == hana_option( 'slider_type' ) )
		hana_featured_top();
	if (  has_nav_menu( 'section' ) ||  hana_option( 'social_section' ) ) {
?>
		<div class="sectionmenu show-for-large">
			<div class="column row <?php if ( hana_option( 'fullwidth_header' ) ) echo 'expanded'; ?>">
<?php
			if (  has_nav_menu( 'section' ) ) { ?>
				<nav class="section-menu">
<?php				wp_nav_menu( array(
						'theme_location'  => 'section',
						'menu_class' => '',	
						'container'  => false,
					)); ?>
				</nav>
<?php		}
		if ( hana_option( 'social_section') )
			hana_social_display( 'sociallink sociallink-section float-right' ); ?>
			</div>
		</div>
<?php
	}
	if ( 'full' != hana_option( 'slider_type' ) )
		hana_featured_top();
	hana_page_title();
	do_action('hana_header_before_main'); //Action Hook
?>
	
  <div id="main" class="row<?php hana_full_width_class() ?>">
