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
	hana_display_portfolio( $args, $thumbnail, $column, $entry_meta );
	$data = ob_get_clean();
	wp_send_json_success( $data );
	wp_die();
}
add_action( 'wp_ajax_hana_portfolio_load_more', 'hana_portfolio_load_more' );
add_action( 'wp_ajax_nopriv_hana_portfolio_load_more', 'hana_portfolio_load_more' );

if ( ! function_exists( 'hana_display_portfolio' ) ):
function hana_display_portfolio( $args, $thumbnail = 'hana-thumb', $column = 1, $entry_meta = 0 ) {	
	global $hana_entry_meta, $hana_thumbnail;
			
	$hana_entry_meta = $entry_meta;
	$hana_thumbnail = $thumbnail;
	
	$blog = new WP_Query( $args );	
	if ( $blog->have_posts() ) :
		$col = 0;
		if ( $column > 1 )
			$div_class = 'columns medium-' . intval(12/$column);
		else
			$div_class = '';		
		while ( $blog->have_posts() ) {
			$blog->the_post();
			
			if ( $column  > 1 && 0 == $col )
				echo '<div class="row pfitem" data-equalizer data-equalize-on="medium">';
			if  ($column > 1) {
				echo '<div class="' . $div_class .'">';				
				$col = $col + 1;
				if ($col == $column )
					$col = 0;	
				get_template_part( 'parts/content', 'portfolio' );				
				echo '</div>';
				if ($col == 0)
					echo '</div>';
			}
			else {
				get_template_part( 'parts/content', 'loop' );				
			}
				
		}				
		if ( $col > 0 )
			echo '</div>';
		if 	($args['paged'] < $blog->max_num_pages) {
			echo apply_filters( 'hana_portfolio_load_more', '<a class="expanded secondary button load-more">' . __('SEE MORE','hana') . '</a>' );
		}
	endif;	
	wp_reset_postdata();
}
endif;