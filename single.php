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

get_header();
?>
	<div id="content" class="site-content <?php hana_content_class(); ?>" role="main">
<?php	while ( have_posts() ) {
			the_post();
			get_template_part( 'parts/content', get_post_format() ); ?>

			<nav id="nav-single" class="clearfix">
				<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '<i class="fa fa-chevron-left"></i>', 'Previous post link', 'hana' ) . '</span> %title' ); ?></span>
				<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '<i class="fa fa-chevron-right"></i>', 'Next post link', 'hana' ) . '</span>' ); ?></span>
			</nav>
<?php		comments_template( '', true );
		} ?>
	</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
