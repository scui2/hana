<?php
/**
 * The template for displaying image attachments.
 *
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 * 
 */
	get_header();
?>
<div id="content" class="site-content <?php echo hana_grid_full(); ?>" role="main">
<?php
	while ( have_posts() ) {
		the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
<?php 		hana_post_title(); 
			hana_meta_attachment(); ?>
		</header>
		<div class="entry-attachment clearfix">
<?php		hana_the_attached_image();
			if ( has_excerpt() ) { ?>
				<div class="entry-caption">
					<?php the_excerpt(); ?>
				</div>
<?php		}
			 the_content();
			 wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'hana' ) . '</span>', 'after' => '</div>' ) ); 
 ?>
		</div>
		<?php hana_post_edit(); ?>
		<nav id="nav-single" class="clearfix">
				<span class="nav-previous"><?php previous_image_link( false, __( '<i class="fa fa-chevron-left"></i> Previous', 'hana') ); ?></span>
				<span class="nav-next"><?php next_image_link( false, __( 'Next <i class="fa fa-chevron-right"></i>', 'hana') ); ?></span>
		</nav>
	</article>
<?php
	} ?>
</div>
<?php
	get_footer();


