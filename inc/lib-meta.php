<?php
/**
 * Content functions
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCteation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */

// Post Meta After Title
if ( ! function_exists( 'hana_meta_top' ) ) :
function hana_meta_top() {
	if ( 'post' == get_post_type() ) {
		$html = '<ul class="entry-meta entry-meta-top">';		
		if ( hana_is_featured() ) {
			$html .= sprintf( '<li class="entry-featured">%1$s  &bull;</li>', __( 'Featured', 'hana') );
		}
		$html .= hana_meta_category();	
		$html .= '</ul>';
		echo apply_filters( 'hana_meta_top', $html );
	}
}
endif;

// Post Meta Below Title
if ( ! function_exists( 'hana_meta_middle' ) ) :
function hana_meta_middle() {
	if ( 'post' == get_post_type() ) {
		$html = '<ul class="entry-meta entry-meta-middle">';
		if ( ! is_single() )
			$html .= hana_meta_category();	
		if (  ! get_theme_mod('hide_date') )
			$html .= hana_meta_date();
		if ( ! get_theme_mod('hide_author') )
			$html .= hana_meta_author();	
		$html .= '</ul>';	
		echo apply_filters( 'hana_meta_middle', $html );	
	}
}
endif;

// Post Meta Above Title
if ( ! function_exists( 'hana_meta_bottom' ) ) :
function hana_meta_bottom() {
	if ( 'post' == get_post_type() ) {
		$html = '<ul class="entry-meta entry-meta-bottom clearfix">';		
		$html .= hana_meta_tag();
		$html .= '</ul>';
		echo apply_filters( 'hana_meta_bottom', $html );
	}
}
endif;

if ( ! function_exists( 'hana_comment_link' ) ) :
function hana_comment_link() {
	if ( 'post' == get_post_type() )
		echo hana_meta_comment( false );
}
endif;
// Post Meta for Recent Post Widget
if ( ! function_exists( 'hana_meta_widget' ) ) :
function hana_meta_widget() {
	if ( 'post' == get_post_type() && ( hana_option('show_date')  || hana_option('show_author') ) ) {
		$html = '<ul class="entry-meta entry-meta-bottom">';
		$html .= hana_meta_category();
		if (  hana_option('show_date') )
			$html .= hana_meta_date();
		if (  hana_option('show_author') )
			$html .= hana_meta_author();	
		$html .= '</ul>';	
		echo apply_filters( 'hana_meta_widget', $html );
	}	
}
endif;
// Post Meta for Portfolio
if ( ! function_exists( 'hana_meta_portfolio' ) ) :
function hana_meta_portfolio() {
	if ( 'post' == get_post_type() && ( hana_option('show_date')  || hana_option('show_author') ) ) {
		$sep = ' &bull; ';
		$html = '<ul class="entry-meta entry-meta-middle">';
		$html .= hana_meta_tag();
		$html .= '</ul>';	
		echo apply_filters( 'hana_meta_portfolio', $html );
	}	
}
endif;
// Prints Post Categories
function hana_meta_category( $list = true ) {
	$html = '';

	$categories = wp_get_post_categories( get_the_ID() , array('fields' => 'ids'));
	if( $categories ) {
 		$sep = ' &bull; ';
 		$cat_ids = implode( ',' , $categories );
 		$cats = wp_list_categories( 'title_li=&style=none&echo=0&include='.$cat_ids);
 		$cats = rtrim( trim( str_replace( '<br />',  $sep, $cats) ), $sep);
 		
 		if ( $list )
			$html .= '<li class="entry-category">';
		else
			$html .= '<span class="entry-category">';

 		$html .=  $cats;
 	 	if ( $list )
			$html .= '</li>';
		else
			$html .= '</span>';

	}
	return apply_filters( 'hana_meta_category', $html );
}

// Display Meta Date
function hana_meta_date( $list = true, $style = 2 ) {
	$html = '';
	if ( 1 == $style ) {
		$html .= '<p class="post-date-2">';
		$html .=  '<span class="month">' . get_the_date('M') . '</span>';
		$html .=  '<span class="day">' . get_the_date('j') . '</span>';
		$html .=  '<span class="year">' . get_the_date('Y') . '</span></p>';
	} elseif ( 2 == $style ) {
 		if ( $list )
			$html .= '<li class="entry-date">';
		else
			$html .= '<span class="entry-date">';

		$html .= sprintf( __( '<time datetime="%1$s">%2$s</time>', 'hana' ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ) );	
 		if ( $list )
			$html .= '</li>';
		else
			$html .= '</span>';			
	}
	return apply_filters( 'hana_meta_post_date', $html );
}

function hana_meta_author( $list = true ) {
	$html = '';	
 	if ( $list )
		$html .= '<li class="by-author">';
	else
		$html .= '<span class="by-author">';		
	$html .= sprintf( '%1$s<a class="url fn n" href="%2$s" title="%3$s" rel="author">%4$s</a>',
				__('<span class="by-author-label">By </span>', 'hana'),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'View all posts by %s', 'hana' ), get_the_author() ) ),
				get_the_author() );
 	if ( $list )
		$html .= '</li>';
	else
		$html .= '</span>';		
	return apply_filters( 'hana_meta_author', $html );
}

// Prints Comments Link
function hana_meta_comment( $list ) {
	$html = '';	
	if ( comments_open() && ! post_password_required() ) {
		ob_start();
 		if ( $list )
			echo '<li class="meta-comment">';
		else
			echo '<span class="entry-meta meta-comment">';
		comments_popup_link( __( '0', 'hana' ), __( '1', 'hana' ) , __( '%', 'hana' ) );			
 		if ( $list )
			echo '</li>';
		else
			echo '</span>';
		$html = ob_get_clean();
	}
	return apply_filters( 'hana_meta_comment', $html );
}

// Prints Post Tags
function hana_meta_tag( $list = true ) {
	$html = '';
	$tags_list = get_the_tag_list( '', __( ' &bull; ', 'hana' ) );
	if ( $tags_list ) {
		if ( $list )
			$html .= '<li class="entry-tag">';
		else
			$html .= '<span class="entry-tag">';		
		$html .= sprintf( '%1$s', $tags_list );
 		if ( $list )
			$html .= '</li>';
		else
			$html .= '</span>';		
	}
	return apply_filters( 'hana_meta_tag', $html );
}

if ( ! function_exists( 'hana_post_edit' ) ) :
function hana_post_edit() {
	edit_post_link( '<i class="fa fa-pencil"></i>', '<span class="edit-link">', '</span>' );	
}
endif;

if ( ! function_exists( 'hana_author_info' ) ) :
/************************************************
Display Author Info on single post view 
 and author has filled out their description
 and showauthor option checked 
************************************************/ 
function hana_author_info() {
	if ( is_single() && get_the_author_meta( 'description' )  ) { ?>
	<div id="author-info">
		<div id="author-avatar">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'hana_author_bio_avatar_size', 64 ) ); ?>
		</div><!-- #author-avatar -->
		<div id="author-description">
			<h2><?php printf( __( 'About %s', 'hana' ), get_the_author() ); ?></h2>
			<p><?php the_author_meta( 'description' ); ?></p>
			<div id="author-link">
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php printf( __( 'View all posts by %s <span class="meta-nav"></span>', 'hana' ), get_the_author() ); ?></a>
			</div>
		</div>
	</div>
<?php 
	}
}
endif;

// Post Meta for attachment
if ( ! function_exists( 'hana_meta_attachment' ) ) :
function hana_meta_attachment() {
	global $post;
	
	$html = '<ul class="entry-meta entry-meta-attachment clearfix">';		
	$html .= hana_meta_date();	
	
	$metadata = wp_get_attachment_metadata();	
	// Image Size
	$html .= '<li class="meta-img-size"><a href="' . wp_get_attachment_url();
	$html .= '">' . $metadata['width'] . '&times;' . $metadata['height'] . '</a></li>';
	// Parent-Post		
	$html .= '<li class="meta-parent"><a href="' . get_permalink( $post->post_parent );		
	$html .= '"  rel="gallery">' . get_the_title( $post->post_parent ) . '</a></li>';
											
	$html .= '</ul>';
	echo apply_filters( 'hana_meta_attachment', $html );
}
endif;