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
	if ( hana_is_featured() && has_post_thumbnail() ) { ?>
		<div class="featured-media-container clearfix">
			<?php hana_media()->featured_image( 'full', 'scale-item' ); ?>
		</div>
<?php
	}
	if ( hana_is_featured() ) { ?>
		<header class="entry-header">
<?php		hana_post_title();
			hana_postmeta()->display( array( 'comment' ), 'meta-comment' );
			hana_postmeta()->display( array( 'category', 'date', 'author' ), 'entry-meta-middle', false  ); ?>
		</header>
		<div class="entry-content clearfix">
			<?php the_content( '' ); ?>
		</div>
<?php		
	} else {
        hana_media()->the_media( 'hana-thumb', 'scale-item' );
        if ( ! has_post_format( array( 'quote', 'aside') ) ) { ?>
            <header class="entry-header">
    <?php		hana_post_title();
                hana_postmeta()->display( array( 'comment' ), 'meta-comment' );
                hana_postmeta()->display( array( 'category', 'date', 'author' ), 'entry-meta-middle', false  ); ?>
            </header>
<?php   } ?>
		<div class="entry-summary clearfix">
<?php		if ( has_post_format( array('quote','aside' ) ) )
				the_content( '' );
			else
				the_excerpt(); ?>
		</div>
<?php	
	}
	hana_postmeta()->single_post_link();
	hana_postmeta()->edit_link();
    if ( ! has_post_format( array( 'quote', 'aside') ) ) { ?>
        <footer class="entry-footer clearfix">
            <?php hana_postmeta()->display( array( 'tag' ) ); ?>
        </footer>
<?php
    } ?>
</article>
<hr class="post-divider">
