<?php
/**
 * Header
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) { ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php } ?>
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
	get_template_part( 'parts/section', 'menu' );
	if ( 'full' != hana_option( 'slider_type' ) )
		hana_featured_top();
	do_action('hana_header_before_main'); //Action Hook
?>
<div id="main" class="<?php echo hana_main_class();?>">
