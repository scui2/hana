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
            if ( ! has_post_format( array( 'image','gallery' ) ) )
                return false;

            $post_id = get_the_ID();
            if( isset( $this->media[ $post_id ] ) )
                return $this->media[ $post_id ];	

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
            if ( ! has_post_format( 'video') )
                return false;
            $post_id = get_the_ID();
            if( isset( $this->media[ $post_id ] ) )
                return $this->media[ $post_id ];	

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
            if ( ! has_post_format( 'audio') )
                return false;
            $post_id = get_the_ID();
            if( isset( $this->media[ $post_id ] ) )
                return $this->media[ $post_id ];	

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

        public function the_media( $size = 'hana-thumb', $class = NULL ) {
            if ( has_post_thumbnail() ) {
                $this->featured_image( $size, $class );                
            } elseif ( $this->image() ) {
                if ( empty( $class  ) )
                    echo hana_kses()->image( $this->image() );
                else
                    echo '<div class="' . esc_attr( $class ) . '">' . hana_kses()->image( $this->image() ) . '</div>';              
            } elseif ( $this->video() ) {
                if ( $class )
                    $class .= ' ' . $class.'-video'; 
                echo '<div class="' . esc_attr( $class ) . '"><div class="flex-video">' . hana_kses()->embed( $this->video() ) . '</div></div>';     
            } elseif ( $this->audio() ) {
                if ( $class )
                    $class .= ' ' . $class.'-audio';        
                echo '<div class="' . esc_attr( $class ) . '">'  . hana_kses()->embed( $this->audio() ). '</div>';
            }
        }
        
        public function featured_image( $size = 'full', $class = null  ) {
            global $post;
            if ( 'none' != $size && has_post_thumbnail() ) {
                if ( ! is_single( $post ) ) {
                    printf ('<a href="%1$s" title="%2$s"><figure class="%3$s">', 
                        esc_url( hana_get_post_link() ),
                        esc_attr( the_title_attribute( 'echo=0' ) ),
                        esc_attr( $class ) );	
                    the_post_thumbnail( $size );
                    echo '</figure></a>';
                }
                else {
                    echo '<figure>';
                    the_post_thumbnail( $size, array( 'class' => $class, 'title' => esc_attr( get_the_title() ) ) );
                    $caption =  get_post( get_post_thumbnail_id() )->post_excerpt;
                    if ( !empty($caption) )
                        echo '<figcaption>' . hana_kses()->text( $caption ) . '</figcaption>';
                    echo '</figure>';
                }
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