<?php
/**
 * Featured Content
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCteation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
function hana_is_featured() {
	global $post; // WP global variable
	
	if ( is_sticky() && ! is_paged() )
		return true;
	else
		return false;
}

/******************************
* Display Featured Media
******************************/
if ( ! function_exists( 'hana_featured_image' ) ) :
function hana_featured_image( $size = 'full', $class = null, $link = false ) {
	global $post;

	if ( 'none' != $size && has_post_thumbnail() ) {
		if ( ! $class )
			$class = 'featured-image-' . $size;
		if ( ! is_single( $post ) || $link ) {
			printf ('<div class="scale-item"><a href="%1$s" title="%2$s">', 
				esc_url( get_permalink() ),
				esc_attr( get_the_title() ) );	
			the_post_thumbnail( $size, array( 'class'	=> $class, 'title' => get_the_title() ) );
			echo '</a></div>';
		}
		else {
			the_post_thumbnail( $size, array( 'class' => $class, 'title' => get_the_title() ) );
		}
	}
}
endif;

/******************************
* Featured Posts
******************************/
if ( ! function_exists( 'hana_featured_top' ) ):
function hana_featured_top( ) {
	if ( hana_has_featured_posts() ) {
		$slider_type = esc_attr( get_theme_mod('slider_type', 'full') ); ?>
		<div class="featured-content featured-content-<?php echo $slider_type; ?> clearfix">
			<?php get_template_part( 'parts/featured', $slider_type ); ?>
		</div>
<?php
	}
}
endif;

function hana_has_featured_posts( $minimum = 1 ) { 
	global $hana_featured_posts;
	if ( is_paged() || is_search() || is_archive() || is_single()  )
       return false;
       
	if ( class_exists( 'bbPress' ) && is_bbpress() )
       return false;	       
       
    if ( is_page() &&  !is_front_page() )
       return false;
       	
    $minimum = absint( $minimum );
    
    if ( ! is_array( $hana_featured_posts ) )
	    $hana_featured_posts = apply_filters( 'hana_get_featured_posts', array() );
 
    if ( ! is_array( $hana_featured_posts ) )
        return false;
 
    if ( $minimum > count( $hana_featured_posts ) )
        return false;
 
    return true;
}
