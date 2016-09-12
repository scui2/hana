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
    if ( hana_media()->has_media() ) {
        hana_media()->the_media( 'hana-thumb' ); ?>
        <a href="<?php the_permalink(); ?>"><div class="block-caption">
            <?php the_title('<h3 class="block-title">', '</h3>'); ?>
<?php       if ( has_excerpt() ) { ?>
                <div class="block-excerpt">            
                    <?php the_excerpt(); ?>
                </div>
<?php       } ?>
        </div></a>
<?php  
    } else { ?>
        <div class="block-content">
            <h3 class="block-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <div class="block-excerpt">            
                <?php the_excerpt(); ?>
            </div>
        </div>
        <div class="block-fade"></div>
<?php
    }
