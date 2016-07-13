<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header clearfix">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>	
	</header>
	<div class="entry-content clearfix">
<?php	the_content();
		wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'hana' ) . '</span>', 'after' => '</div>' ) ); ?>
	</div>
	<?php hana_postmeta()->edit_link(); ?>				
</article>
