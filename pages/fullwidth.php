<?php
/**
 * Template Name: Full Width
 *
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
get_header(); ?>
<div id="content" class="site-content fullwidth <?php hana_grid()->fullgrid_class(); ?>" role="main">
<?php
	while ( have_posts() ) {
		the_post();
		get_template_part( 'parts/content', 'page' );
		comments_template( '', true );
	}
?>
</div>
<?php get_footer(); ?>
