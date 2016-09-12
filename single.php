<?php
/**
 * The Template for displaying all single posts.
 *
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */

get_header(); ?>
<div id="content" class="site-content <?php hana_grid()->content_class(); ?>" role="main">
<?php   while ( have_posts() ) {
			the_post();
			get_template_part( 'parts/content', get_post_format() );
			the_post_navigation();
			comments_template( '', true );
		} ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
