<?php
/**
 * The default template for displaying content
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
<?php
		hana_postmeta()->display( array( 'comment' ), 'meta-comment' );
		hana_postmeta()->display( array( 'category' ), 'entry-meta-top', false );
		hana_post_title();
		if ( is_single() && has_excerpt() ) { ?>
			<div class="entry-excerpt clearfix">
				<?php the_excerpt(); ?>
			</div>
<?php	}
		hana_jetpack_sharing( 'top' );
		hana_postmeta()->display( array( 'date', 'author' ), 'entry-meta-middle', false  ); ?>
	</header>
<?php

	if ( ! get_theme_mod( 'hide_featured' ) && has_post_thumbnail() ) { ?>
		<div class="featured-media-container clearfix">
			<?php hana_featured_image(); ?>
		</div>
<?php
	} ?>
	<div class="entry-content clearfix">
<?php
		the_content();
		wp_link_pages( array( 'before' => '<div class="page-link"><span class="page-link-title">' . __( 'Pages:', 'hana' ) . '</span>',
						 	'after' => '</div>' ,
						 	'link_before' => '<span class="page-link-number">',
						 	'link_after' => '</span>' ) ); 
?>
	</div>
	<?php hana_postmeta()->edit_link(); ?>
	<footer class="entry-footer clearfix">
<?php	hana_postmeta()->display( array( 'tag' ) );
		hana_jetpack_sharing( 'bottom' );		
		get_template_part( 'parts/biography' ); ?>
	</footer>
</article>
