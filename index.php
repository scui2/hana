<?php
/**
 * Main Template
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
	get_header(); ?>
<div id="content" class="site-content <?php hana_grid()->content_class(); ?>" role="main">
<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			if ( is_search() )
				get_template_part( 'parts/content', 'summary' );
			else
				get_template_part( 'parts/content', 'loop' );
		}
		hana_content_nav( 'nav-below' );
	} elseif ( current_user_can( 'edit_posts' ) ) {
		get_template_part( 'parts/content', 'none' );
	} ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
