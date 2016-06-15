<?php
/**
 * The default template for displaying content
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
<?php
		hana_comment_link();
		hana_meta_top();
		hana_post_title();
		if ( is_single() && has_excerpt() ) { ?>
			<div class="entry-excerpt clearfix">
				<?php the_excerpt(); ?>
			</div>
<?php	}
		hana_jetpack_sharing( 'top' );
		hana_meta_middle();
?>
	</header>
<?php

	if ( hana_option( 'show_featured' ) && has_post_thumbnail() ) { ?>
		<div class="featured-media-container">
			<?php hana_featured_image(); ?>
		</div>
<?php
	} ?>
	<div class="entry-content clearfix">
<?php
		the_content( '' );
		wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'hana' ) . '</span>', 'after' => '</div>' ) ); 
?>
	</div>
	<footer class="entry-footer clearfix">
<?php	hana_meta_bottom();
		hana_jetpack_sharing( 'bottom' );
		hana_post_edit();
		hana_author_info();
?>
	</footer>
</article>
