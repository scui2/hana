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
	global $hana_thumbnail, $hana_entry_meta;

    hana_media()->the_media( $hana_thumbnail ); ?>
    <div class="block-content">
        <?php the_title( sprintf( '<h3 class="entry-title"><a href="%1$s">', esc_url( hana_get_post_link() ) ), '</a></h3>' ); ?>
        <div class="block-excerpt">            
            <?php the_excerpt(); ?>
        </div>
   
    </div>
    <div class="portfolio-footer">
        <div class="portfolio-fade"></div> 
<?php   if ( $hana_entry_meta )
            hana_postmeta()->display( array( 'tag' ) ); ?>
    </div> 
