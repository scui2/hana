<?php
/**
 * The template to display content in Portfolio Page
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
	global $hana_thumbnail, $hana_entry_meta;

    hana_media()->the_media( $hana_thumbnail ); ?>
    <div class="block-content">
        <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <div class="block-excerpt">            
            <?php the_excerpt(); ?>
        </div>
    </div>
    <div class="portfolio-footer">
        <div class="portfolio-fade"></div> 
<?php   if ( $hana_entry_meta ) { ?>
            <div class="portfolio-meta hide-for-small-only">
                <?php hana_postmeta()->display( array( 'tag' ) ); ?>
            </div>     
<?php   } ?>
    </div> 
