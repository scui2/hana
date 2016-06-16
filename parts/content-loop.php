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
	if ( hana_is_featured() && has_post_thumbnail() ) { ?>
		<div class="featured-media-container">
			<?php hana_featured_image( 'full' ); ?>
		</div>
<?php
	} ?>

<?php
	if ( hana_is_featured() ) { ?>
		<header class="entry-header">
<?php		hana_post_title();
			hana_comment_link();
			hana_meta_middle(); ?>
		</header>
		<div class="entry-content clearfix">
			<?php the_content( hana_readmore_text() ); ?>
		</div>
<?php		
	} else {
		if ( hana_has_featured_media() )
			hana_featured_media(); ?>
		<header class="entry-header">
<?php		hana_post_title();
			hana_comment_link();
			hana_meta_middle(); ?>
		</header>
		<div class="entry-summary clearfix">
			<?php the_excerpt(); ?>
		</div>
<?php	
	}
	hana_single_post_link();
	hana_post_edit();
?>
	<footer class="entry-footer show-for-medium clearfix">
<?php	
		hana_meta_bottom(); ?>
	</footer>
</article>
