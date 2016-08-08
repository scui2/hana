<?php
/**
 * Post Meta Class
 * 
 * @package	  hanacore
 * @since     1.0
 * @author	  Stephen Cui
 * @copyright Copyright 2016, Stephen Cui
 * @license   GPL v3 or later
 * @link      http://rewindcreation.com/
 */
if ( ! class_exists( 'HANA_Post_Meta' ) ) {

	class HANA_Post_Meta {

		private function __construct() {
		}
		
		// meta array, class, icon,
		public function display( $metas = NULL, $class = NULL, $icon = true ) {
			if ( 'page' == get_post_type() )
				return;
			if ( ! is_array( $metas ) ) // No Meta defined
				return;
			
			if ( empty( $class ) )
				$class = 'entry-meta';
			else
				$class .= ' entry-meta';
			$html = '';
			foreach ( $metas as $meta ) {
				switch ( $meta ) {
				    case 'comment':
						$html .= $this->meta_comment( $icon );
				        break;
				    case 'category':
						$html .= $this->meta_category( $icon );
				        break;
				    case 'date':
						if (  ! get_theme_mod('hide_date') )
							$html .= $this->meta_date( $icon );
				        break;
				    case 'author':
						if (  ! get_theme_mod('hide_author') )
							$html .= $this->meta_author( $icon );
				        break;
				    case 'tag':
						$html .= $this->meta_tag( $icon );
				        break;			
				    case 'attachment':
						$html .= $this->meta_attachment( $icon );
				        break;	
				}
			}
			if ( !empty( $html ) ) { ?>
				<ul class="<?php echo esc_attr($class); ?>">
					<?php echo $html; ?>
				</ul>
	<?php	}
		}
		
		public function edit_link() {
			ob_start();
			edit_post_link( '<i class="fa fa-pencil"></i>', '<span class="post-edit-link">', '</span>' );
			$html = ob_get_clean();
			echo apply_filters( 'hana_meta_editlink', $html );
		}

		/* This function echo the link to single post view for the following:
		- Aside Post
		- Quote Post
		- Post without title
		------------------------------------------------------------------------- */
		public function single_post_link() {
			if ( ! is_single() ) {
				if ( has_post_format( 'aside' ) || has_post_format( 'quote' ) || '' == the_title_attribute( 'echo=0' ) ) { 
					printf ('<a class="single-post-link meta-icon" href="%1$s" title="%2$s"><span class="screen-reader-text">%3$s</span></a>',
						esc_url( get_permalink() ),
						esc_attr( get_the_title() ),
						esc_html__( 'Permalink', 'hana') );
				} 
			}
		}
        
		public function meta_category( $icon = true ) {
			$html = '';
	 		$sep = ' &bull; ';
			$categories = wp_get_post_categories( get_the_ID() , array('fields' => 'ids'));
			$cats = '';
			if( $categories ) {
	 			$cat_ids = implode( ',' , $categories );
	 			$cats = wp_list_categories( 'title_li=&style=none&echo=0&include='.$cat_ids);
	 			$cats = rtrim( trim( str_replace( '<br />',  $sep, $cats) ), $sep);
			}
			if ( is_sticky() && ! is_paged() ) {
				$cats = sprintf( '<span class="entry-featured">%1$s</span>%2$s', esc_html__( 'Featured', 'hana'), $sep ) . $cats;		
			}
			if ( $icon )
				$html .= '<li class="entry-category meta-icon">';
			else
				$html .= '<li class="entry-category">';
	 		$html .= $cats;
			$html .= '</li>';
				
			return apply_filters( 'hana_meta_category', $html );	
		}

		public function meta_tag( $icon = true ) {
			$html = '';
			$tags_list = get_the_tag_list( '', ' &bull; ' );
			if ( $tags_list ) {
				if ( $icon )
					$html .= '<li class="entry-tag meta-icon">';
				else
					$html .= '<li class="entry-tag">';
				$html .= sprintf( '%1$s', $tags_list );
				$html .= '</li>';
				$html .= '</span>';		
			}
			return apply_filters( 'hana_meta_tag', $html );
		}

		public function meta_comment( $icon = true ) {
			$html = '';	
			if ( comments_open() && ! post_password_required() ) {
				ob_start();
				if ( $icon )
					$class = 'comment-link meta-icon';
				else
					$class = 'comment-link';
				echo '<li>';
				comments_popup_link( esc_html__( '0', 'hana' ), esc_html__( '1', 'hana' ) , esc_html__( '%', 'hana' ), $class );			
				echo '</li>';
				$html = ob_get_clean();
			}
			return apply_filters( 'hana_meta_comment', $html );
		}

		public function meta_date( $icon = true ) {
			$html = '';
			if ( $icon )
				$html .= '<li class="entry-date meta-icon">';
			else
				$html .= '<li class="entry-date">';
			$html .= sprintf( '<time datetime="%1$s">%2$s</time>' ,
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() ) );
			$html .= '</li>';
			return apply_filters( 'hana_meta_post_date', $html );
		}	

		public function meta_author( $icon = true ) {
			$html = '';
			if ( $icon )
				$html .= '<li class="by-author meta-icon">';
			else
				$html .= '<li class="by-author">';
			$html .= sprintf( '<a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s %4$s</a>',
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					esc_attr( sprintf( esc_html__( 'View all posts by %s', 'hana' ), get_the_author() ) ),
					'<span class="by-author-label">' . esc_html__('By', 'hana') . '</span>',
					esc_attr( get_the_author() ) );
			$html .= '</li>';
			return apply_filters( 'hana_meta_author', $html );
		}

		function meta_attachment( $icon = true ) {
			global $post;
		
			$html = '';	
			$metadata = wp_get_attachment_metadata();	
			// Image Size
			$html .= '<li class="meta-size meta-icon"><a href="' . esc_url( wp_get_attachment_url() );
			$html .= '">' . esc_attr( $metadata['width'] ) . '&times;' . esc_attr( $metadata['height'] ) . '</a></li>';
			// Parent-Post		
			$html .= '<li class="meta-parent meta-icon"><a href="' . esc_url( get_permalink( $post->post_parent ) );		
			$html .= '"  rel="gallery">' . esc_html( get_the_title( $post->post_parent ) ) . '</a></li>';
			return apply_filters( 'hana_meta_attachment', $html );
		}
		/**
		 * Create the object when called for the 1st time
		 */
		public static function get_instance() {
			static $instance = null;

			if ( is_null( $instance ) )
				$instance = new HANA_Post_Meta;

			return $instance;
		}

	}

	function hana_postmeta() {
		return HANA_Post_Meta::get_instance();
	}

}