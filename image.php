<?php
/**
 * The template for displaying image attachments.
 *
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 * 
 */
	get_header();
?>
<div id="content" class="site-content <?php hana_grid()->fullgrid_class(); ?>" role="main">
<?php
	while ( have_posts() ) {
		the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
<?php 		hana_post_title(); 
			hana_postmeta()->display( array( 'date', 'attachment' ) ); ?>
		</header>
		<div class="entry-attachment clearfix">
<?php		hana_the_attached_image();
			if ( has_excerpt() ) { ?>
				<div class="entry-caption">
					<?php the_excerpt(); ?>
				</div>
<?php		}
			the_content(); ?>
		</div>
		<?php hana_postmeta()->edit_link(); ?>
	</article>
	<div class="navigation image-navigation">
		<div class="nav-previous "><?php previous_image_link( false, esc_html__( 'Previous', 'hana') ); ?></div>
		<div class="nav-next "><?php next_image_link( false, esc_html__( 'Next', 'hana') ); ?></div>
	</div>
<?php
	} ?>
</div>
<?php
	get_footer();


