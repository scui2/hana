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
 	global $hana_thumbnail, $hana_entry_meta;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php hana_featured_image( $hana_thumbnail ); ?>
	<header class="entry-header">
<?php	hana_post_title();
		if ( $hana_entry_meta )
			hana_meta_widget(); ?>
	</header>
	<div class="entry-summary clearfix">
		<?php the_excerpt(); ?>
	</div>
</article>
