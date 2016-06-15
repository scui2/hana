<?php
/**
 * The template to display content in the loop
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php
	if ( hana_has_featured_media() )
		hana_featured_media(); ?>
	<header class="entry-header">
<?php	hana_post_title();
		hana_comment_link();
		hana_meta_middle(); ?>
	</header>
	<div class="entry-summary clearfix">
		<?php the_excerpt(); ?>
	</div>
<?php
	hana_post_edit();
?>
	<footer class="entry-footer show-for-medium clearfix">
<?php
		//wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'hana' ) . '</span>', 'after' => '</div>' ) );
		hana_meta_bottom();	
?>
	</footer>
</article>
