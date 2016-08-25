<?php
/**
 * Common Display Functions
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */

/**************************************************
* Display Post Title
**************************************************/
if ( ! function_exists( 'hana_post_title' ) ) :
function hana_post_title() {
    global $post;
    if ( ! is_single( $post ) )
		the_title( sprintf( '<h2 class="entry-title"><a href="%1$s" rel="bookmark">', esc_url( hana_get_post_link() ) ), '</a></h2>' );
	else
		the_title( '<h1 class="entry-title">', '</h1>');
}
endif;

/**************************************************
* Returns permalink except link post
* For link post, first link will be returned
**************************************************/
if ( ! function_exists( 'hana_get_post_link' ) ) :
function hana_get_post_link() {
	$link_url = get_the_permalink();
	if ( has_post_format( 'link' ) ) {
		$link = array();
		if ( preg_match('/<a (.+?)>/', get_the_content(), $match) ) {
    		foreach ( wp_kses_hair($match[1], array('http')) as $attr) {
        		$link[$attr['name']] = $attr['value'];
    		}
		}			
    	if ( isset( $link['href'] ) )
    		$link_url = $link['href'];
	}
	return $link_url;
}
endif;
/**************************************************
* Manual read more for get_the_excerpt filter 
* or after the excerpt
**************************************************/
if ( ! function_exists( 'hana_read_more' ) ) :
function hana_read_more( $output ) {
	if ( ! is_attachment() ) {
		$output .= ' <a class="more-link" href="'. esc_url( get_permalink() ) . '">' . apply_filters( 'hana_readmore_label', esc_html__( 'Read More', 'hana' ) ) . '</a>';
	}
    return $output;
}
endif;
/**************************************************
* Display Page Header for Archive pages
**************************************************/
if ( ! function_exists( 'hana_archive_title' ) ) :	
function hana_archive_title( $single_title = false ) {	
	if ( ! have_posts() )
		return;
	$class = '';
	if ( is_search() ) {
		$title = sprintf( '%1$s<span class="search-term">%2$s</span>', 
					esc_html__( 'Search Results for: ', 'hana'),
					get_search_query() ); //already escaped
		$class .= 'ph-search'; ?>
        <div class="page-header <?php echo esc_attr( $class ); ?>">
            <div class="row column">
                <h1 class="page-title"><?php echo $title; ?></h1>
            </div>
		</div>	
<?php	return;
	} elseif ( is_category() ) { 
		$category_name = single_cat_title( '', false );
		$category_id = get_cat_ID( $category_name );
		// Category Title Class
		$class .= 'pt-category pt-category-' .  esc_attr( $category_id );
		$parent = get_term( $category_id, 'category' );
		while ( $parent->parent ) {
			$class .= ' pt-category-' . esc_attr( $parent->parent );
			$parent = get_term( $parent->parent , 'category' );				
		}
	} elseif ( is_tag() ) {
		$class .= 'pt-tag';
	} elseif ( is_day() || is_month() || is_year() ) {
		$class .= 'pt-date';
	} else {
		return;
	}
?>
	<div class="page-header <?php echo esc_attr( $class ); ?>">
        <div class="row column">
<?php   ob_start();
		the_archive_description( '<div class="page-description">', '</div>' ); 
        $html = ob_get_clean();
        if ( empty( $html ) ) //Only display page tile if no description
            the_archive_title( '<h1 class="page-title">', '</h1>' );
        else
            echo $html;
?>
        </div>
	</div>
<?php
}
endif;

/******************************
* Site Branding
******************************/
if ( ! function_exists( 'hana_branding' ) ):
function hana_branding( $tagline = TRUE ) { ?>
    <div class="branding">
<?php
    if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) { //To remove function_exists from 4.7
		the_custom_logo();
	} else { // Display Site Title and Tagline ?>
        <h3 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_html( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h3>
<?php   if ( $tagline ) { ?>
            <h4 class="site-description show-for-medium "><?php bloginfo( 'description' ); ?></h4>
<?php   }
	} ?>
</div>
<?php
}
endif;

/******************************
* Pagination for main loop
******************************/
function  hana_content_nav( $nav_id ) {
	global $wp_query;
	hana_content_nav_link( $wp_query->max_num_pages, $nav_id );
}

/******************************
* Pagination
******************************/
function hana_content_nav_link( $num_of_pages, $nav_id ) {
	$html = '';
	if ( $num_of_pages > 1 ) {
		$html .=  '<ul id="' .$nav_id. '" class="pagination text-center" role="navigation" aria-label="Pagination">';

		$big = 999999999;
    	if ( get_query_var( 'paged' ) )
	    	$current_page = get_query_var( 'paged' );
		elseif ( get_query_var( 'page' ) ) 
	   	 	$current_page = get_query_var( 'page' );
		else 
			$current_page = 1;
		$links =  paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, $current_page ),
			'total' => $num_of_pages,
			'mid_size' => 3,
			'prev_text'    => '<i class="fa fa-chevron-left"></i>' ,
			'next_text'    => '<i class="fa fa-chevron-right"></i>' ,
			'type' => 'array' ) );
			
		foreach ( $links as $link )
			$html .= '<li>' . $link . '</li>';			
		$html .='</ul>';
	}
	echo apply_filters( 'hana_pagination', $html );
}

/******************************
* Display Attached Image
* with the link to next image
******************************/
if ( ! function_exists( 'hana_the_attached_image' ) ) :	
function hana_the_attached_image() {
	$post = get_post();

	$attachment_size     = apply_filters( 'hana_attachment_size', array( 1024, 1024 ) );
	$next_attachment_url = wp_get_attachment_url();

	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID',
	) );

	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		if ( $next_id ) {
			$next_attachment_url = get_attachment_link( $next_id );
		} else {
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}
	}

	printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;