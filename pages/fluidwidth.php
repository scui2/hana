<?php
/**
 * Template Name: Fluid Width
 *
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
get_header(); ?>
<div id="content" class="site-content fluidwidth" role="main">
<?php
	while ( have_posts() ) {
		the_post();
        the_content();	
	}
?>
</div>
<?php get_footer(); ?>
