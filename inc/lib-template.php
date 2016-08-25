<?php
/**
 * Functions for page templates
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCteation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */

function hana_portfolio_load_more() {
	check_ajax_referer( 'hana-load-more-nonce', 'nonce' );
    
	$args = isset( $_POST['query'] ) ? array_map( 'esc_attr', $_POST['query'] ) : array();
	$args['post_type'] = isset( $args['post_type'] ) ? esc_attr( $args['post_type'] ) : 'post';
	$args['paged'] = esc_attr( $_POST['page'] );
	$args['post_status'] = 'publish';

	$column = isset( $_POST['column'] ) ? intval( $_POST['column'] ) : 1;
	$entry_meta = isset( $_POST['entry_meta'] ) ? intval( $_POST['entry_meta'] ) : 0;
	$thumbnail = isset( $_POST['thumbnail'] ) ? esc_attr( $_POST['thumbnail'] ) : 'hana-thumb';
	
	ob_start();
	hana_display_portfolio( $args, $thumbnail, $column, $entry_meta, false );
	$data = ob_get_clean();
	wp_send_json_success( $data );
	wp_die();
}
add_action( 'wp_ajax_hana_portfolio_load_more', 'hana_portfolio_load_more' );
add_action( 'wp_ajax_nopriv_hana_portfolio_load_more', 'hana_portfolio_load_more' );

if ( ! function_exists( 'hana_display_portfolio' ) ):
function hana_display_portfolio( $args, $thumbnail = 'hana-thumb', $column = 1, $entry_meta = 0, $wrapper = true ) {	
	global $hana_entry_meta, $hana_thumbnail;
			
	$hana_entry_meta = $entry_meta;
	$hana_thumbnail = $thumbnail;	
	$blog = new WP_Query( $args );
    if ( $blog->have_posts() ) {
        if  ( $column > 1) {
            if ( $wrapper )
                echo '<div class="row portfolio-items">';
            hana_layout()->display( 'portfolio-' . $column, $blog->posts, 'parts/content-portfolio'  );
            if 	($args['paged'] < $blog->max_num_pages) {
                echo apply_filters( 'hana_portfolio_load_more', '<div class="loadmore-container small-12 columns"><a class="expanded secondary button load-more">' . esc_html__('SEE MORE','hana') . '</a></div>' );
            }
            if ( $wrapper )
                echo '</div>';
        } else {
            while ( $blog->have_posts() ) {
                $blog->the_post();
                get_template_part( 'parts/content', 'loop' );				
            }
            if 	($args['paged'] < $blog->max_num_pages) {
                echo apply_filters( 'hana_portfolio_load_more', '<div class="loadmore-container small-12 columns"><a class="expanded secondary button load-more">' . esc_html__('SEE MORE','hana') . '</a></div>' );
            }
        }
    }
	wp_reset_postdata();
}
endif;

add_action( 'admin_enqueue_scripts', 'hana_load_template_scripts' );
function hana_load_template_scripts( $hooks ) {
	global $post_type;

	if ( 'page' == $post_type ) {
		wp_enqueue_script( 'hana-template', HANA_THEME_URI . 'js/template.js', array( 'jquery') );	
	}
}
