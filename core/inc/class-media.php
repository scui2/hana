<?php
/**
 * Media Class
 * 
 * @package	  hanacore
 * @since     1.0
 * @author	  Stephen Cui
 * @copyright Copyright 2016, Stephen Cui
 * @license   GPL v3 or later
 * @link      http://rewindcreation.com/
 */
if ( ! class_exists( 'HANA_Media' ) ) {
	class HANA_Media {

        public $media = array();
        
		private function __construct() {
		}

        public function image() {
            global $more;
            $post_id = get_the_ID();
            if( isset( $this->media[ $post_id ] ) )
                return $this->media[ $post_id ];
            
            $format = get_post_format( $post_id );
            if ( 'image' != $format && 'gallery' != $format )
                return false;

            $more = 1;
            $content = get_the_content();
            $content = apply_filters( 'the_content', $content );
            $content = str_replace( ']]>', ']]&gt;', $content );
            $content = trim($content);

            if ( preg_match('/<img[^>]+./' , $content, $match) )
                $this->media[ $post_id ] = $match[0];
            else
                $this->media[ $post_id ] = false;
            return $this->media[ $post_id ];            
		}

        public function video() {
            global $more;
            $post_id = get_the_ID();
            if( isset( $this->media[ $post_id ] ) )
                return $this->media[ $post_id ];	

            $format = get_post_format( $post_id );
            if ( 'video' != $format )
                return false;

            $more = 1;            
            $content = get_the_content();
            $content = apply_filters( 'the_content', $content );
            $embeds = get_media_embedded_in_content( $content );
            if( is_array( $embeds ) )
                $this->media[ $post_id ] = $embeds[0];
            else
                $this->media[ $post_id ] = false;

            return $this->media[ $post_id ];
        }

        public function audio() {
            global $more;
            
            $post_id = get_the_ID();
            if( isset( $this->media[ $post_id ] ) )
                return $this->media[ $post_id ];
            
            $format = get_post_format( $post_id );
            if ( 'audio' != $format )
                return false;

            $more = 1;
            $content = get_the_content();
            $content = apply_filters( 'the_content', $content );
            $embeds = get_media_embedded_in_content( $content );
            if( is_array( $embeds ) )
                $this->media[ $post_id ] = $embeds[0];
            else
                $this->media[ $post_id ] = false;

            return $this->media[ $post_id ];
        }

        public function has_media() {
            if ( has_post_thumbnail() )
                return true;
            elseif ( $this->image() )
                return true;
            elseif ( $this->video() )
                return true;
            elseif ( $this->audio() )
                return true;

            return false;
        }

        public function the_media( $size = 'hana-thumb', $class = 'featured-image' ) {
            if ( has_post_thumbnail() ) {
                $this->featured_image( $size, $class );                
            } elseif ( $this->image() ) {
                if ( empty( $class  ) )
                    echo hana_kses()->image( $this->image() );
                else
                    echo '<div class="' . hana_kses()->sanitize_html_classes( $class ) . '">' . hana_kses()->image( $this->image() ) . '</div>';              
            } elseif ( $this->video() ) {
                if ( $class )
                    $class .= ' ' . $class.'-video'; 
                echo '<div class="' . hana_kses()->sanitize_html_classes( $class ) . '"><div class="flex-video">' . hana_kses()->embed( $this->video() ) . '</div></div>';     
            } elseif ( $this->audio() ) {
                if ( $class )
                    $class .= ' ' . $class.'-audio';        
                echo '<div class="' . hana_kses()->sanitize_html_classes( $class ) . '">'  . hana_kses()->embed( $this->audio() ). '</div>';
            }
        }
        
        public function featured_image( $size = 'full', $class = 'featured-image'  ) {
            global $post;
            if ( 'none' != $size && has_post_thumbnail() ) {
                if ( ! is_single( $post ) ) { ?>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <figure class="<?php echo sanitize_html_class( $class ); ?>">
                            <?php the_post_thumbnail( $size ); ?>
                        </figure>
                    </a>
<?php           } else { ?>
                    <figure class="<?php echo sanitize_html_class( $class ); ?>">
<?php                   the_post_thumbnail( $size );
                        $caption =  get_post( get_post_thumbnail_id() )->post_excerpt;
                        if ( !empty($caption) ) { ?>
                            <figcaption><?php echo hana_kses()->text( $caption ); ?></figcaption>                            
<?php                   } ?>
                    </figure>
<?php          }
            }
        }
		/**
		 * Create the object when called for the 1st time
		 */
		public static function get_instance() {
			static $instance = null;

			if ( is_null( $instance ) )
				$instance = new HANA_Media;

			return $instance;
		}

	}

	function hana_media() {
		return HANA_Media::get_instance();
	}

}