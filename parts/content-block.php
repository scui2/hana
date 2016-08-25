<?php
/**
 * The template to display featured post in block
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
?>
<?php
    if ( hana_media()->has_media() ) {
        hana_media()->the_media( 'hana-thumb' ); ?>
        <div class="block-caption">
            <?php the_title( sprintf( '<h3 class="block-title"><a href="%1$s">', esc_url( hana_get_post_link() ) ), '</a></h3>' );
            if ( has_excerpt() ) { ?>
                <div class="block-excerpt">            
                    <?php the_excerpt(); ?>
                </div>
<?php       } ?>
        </div>
<?php  
    } else { ?>
        <div class="block-content">
<?php       the_title( sprintf( '<h3 class="block-title"><a href="%1$s">', esc_url( hana_get_post_link() ) ), '</a></h3>' ); ?>
            <div class="block-excerpt">            
                <?php the_excerpt(); ?>
            </div>
        </div>
        <div class="block-fade"></div>
<?php
    }
