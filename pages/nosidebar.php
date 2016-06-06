<?php
/**
 * Template Name: No Sidebar
 *
 * @package	passion
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
get_header(); ?>
<div id="content" class="site-content <?php echo hana_grid_full(); ?>" role="main">
<?php
	while ( have_posts() ) {
		the_post();
		get_template_part( 'parts/content', 'page' );
		comments_template( '', true );
	}
?>
</div>
<?php get_footer(); ?>
