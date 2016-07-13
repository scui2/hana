<?php
/**
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
get_header(); ?>
<div id="content" role="main" class="site-content <?php hana_grid()->bbp_content_class(); ?>">
<?php
	while ( have_posts() ) {
		the_post();
		get_template_part( 'parts/content', 'page' );
	}
?>
</div>
<?php get_sidebar('bbpress'); ?>	
<?php get_footer(); ?>
