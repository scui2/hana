<?php
/**
 * The template to display content in the loop
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php
	hana_media()->the_media( 'hana-thumb', 'scale-item' ) ?>
	<header class="entry-header">
<?php	hana_post_title();
		hana_postmeta()->display( array( 'comment' ), 'meta-comment' );
		hana_postmeta()->display( array( 'category', 'date', 'author' ) ); ?>
	</header>
	<div class="entry-summary clearfix">
		<?php the_excerpt(); ?>
	</div>
<?php
	hana_postmeta()->edit_link(); ?>
	<footer class="entry-footer clearfix">
<?php	hana_postmeta()->display( array( 'tag' ) ); ?>
	</footer>
</article>
<hr class="post-divider">
