<?php
/**
 * The template to display content in Portfolio Page
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> data-equalizer-watch>
<?php
	global $hana_thumbnail;
	
	if ( $has_media = hana_has_featured_media() )
		hana_featured_media( $hana_thumbnail ); ?>
	<header class="entry-header">
		<?php hana_post_title(); ?>
	</header>
<?php
	if ( ! $has_media ) { ?>
		<div class="entry-summary clearfix">
			<?php the_excerpt(); ?>
		</div>
<?php
	}
	hana_post_edit();
	global $hana_entry_meta;
	if ( $hana_entry_meta ) { ?>
		<footer class="entry-footer clearfix">
			<?php hana_meta_portfolio(); ?>
		</footer>
<?php
	} ?>
</article>