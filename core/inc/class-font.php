<?php
/**
 * Google Web Fonts
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
if ( ! class_exists( 'Hana_Font' ) ) {
    class Hana_Font {
        public $fonts = array();
        public $choices = NULL;
        public $host_url = '//fonts.googleapis.com/css'; //Child can overide the $host_url
        
		private function __construct() {
            // Use type for backup font family
            $this->fonts = array(
            //Sans
                'default' => array( 
                        'name' => 'Default' ),
                '1'		=> array( 
                        'name' => '-- Sans --' ),
                'arimo' => array(
                        'name' => 'Arimo',
                        'type' => 'sans-serif',
                        'weight'  => '400,700,400italic,700italic' ),
                'cabin' => array(
                        'name' => 'Cabin',
                        'type' => 'sans-serif',
                        'weight'  => '400,700,400italic,700italic' ),
                'lato'	 => array(
                        'name' => 'Lato',
                        'type' => 'sans-serif',
                        'weight'  => '400,700,400italic,700italic' ),					
                'open-sans' => array(
                        'name' => 'Open Sans',
                        'type' => 'sans-serif',
                        'weight'  => '400,400italic,700,700italic' ),
                'oswald' => array(
                        'name' => 'Oswald',
                        'type' => 'sans-serif',
                        'weight'  => '400,700' ),
                'pt-sans' => array(
                        'name' => 'PT Sans',
                        'type' => 'sans-serif',
                        'weight'  => '400,400italic,700,700italic' ),
                'roboto' => array(
                        'name' => 'Roboto',
                        'type' => 'sans-serif',
                        'weight'  => ':400,700,400italic,700italic' ),
                'ubuntu' => array(
                        'name' => 'Ubuntu',
                        'type' => 'sans-serif',
                        'weight'  => '400,700,400italic,700italic' ),
            //Serif
                '2' => array( 
                        'name' => '-- Serif --' ),	
                'old-standard-tt' => array(
                        'name' => 'Old Standard TT',
                        'type' => 'serif',
                        'weight'  => '400,700,400italic' ),
                'playfair-display' => array(
                        'name' => 'Playfair Display',
                        'type' => 'serif',
                        'weight'  => '400,700,400italic,700italic' ),

                //Cursive
                '3' => array( 
                        'name' => '-- Cursive --' ),
                'berkshire-swash' => array(
                        'name' => 'Berkshire Swash',
                        'type' => 'cursive',
                         ),
                'lobster' => array(
                        'name' => 'Lobster',
                        'type' => 'cursive',
                        ),
            // End of font array			
                );
        }
        
		public function choices() {
            if ( is_array( $this->choices ) )
                return $this->choices;
            $this->choices = array();
            foreach ( $this->fonts as $key => $font )
                $this->choices[$key] = $font['name'];
            return $this->choices;
        }
 
		public function url() {
            $url = '';
            $fonts = apply_filters( 'hana_default_fonts', array() ); // Theme's default fonts      
            $elements = apply_filters( 'hana_font_elements', NULL ); // Theme's CSS elements
            
            if ( is_array( $elements ) ) {
                foreach ( $elements as $key => $element ) {
                    $option = get_theme_mod( $key );
                    if ( $option && 'default' != $option && ! in_array( $option, $fonts) ) {
                        $fonts[] = sanitize_key( $option );
                    }
                }                
            }

            if ( ! empty( $fonts ) ) {
                $families = array();
                foreach ( $fonts as $key ) {
                    $font = $this->fonts[ $key ]['name'];
                    if ( isset( $this->fonts[ $key ]['weight'] ) )
                        $font .=  ':' . $this->fonts[ $key ]['weight'];
                    $families[] = $font;
                }
                $args = array(
                    'family' => urlencode( implode( '|', $families ) ),
                    'subset' => urlencode( _x( 'latin,latin-ext', 'translate to the available subset for your language', 'hana' ) ),
                );
                $url = add_query_arg( $args, $this->host_url );
            }
            return $url;
        }
        
		public static function get_instance() {
			static $instance = null;

			if ( is_null( $instance ) )
				$instance = new Hana_Font;

			return $instance;
		}
    }

    function hana_font() {
		return Hana_Font::get_instance();
	}
}
