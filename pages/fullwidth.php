<?php
/**
 * Template Name: Full Width
 *
 * @package	passion
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
get_header(); ?>
<div id="content" class="site-content <?php hana_grid()->fullgrid_class(); ?>" role="main">
<?php
	while ( have_posts() ) {
		the_post();
		get_template_part( 'parts/content', 'page' );
		comments_template( '', true );
	}
?>
</div>
<?php get_footer(); ?>
