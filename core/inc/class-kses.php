<?php
/**
 * Class for KSES Strips Evil Scripts
 * 
 * @package	  hanacore
 * @since     1.0
 * @author	  Stephen Cui
 * @copyright Copyright 2016, Stephen Cui
 * @license   GPL v3 or later
 * @link      http://rewindcreation.com/
 */
if ( ! class_exists( 'HANA_KSES' ) ) {
	
	class HANA_KSES {

		public $allowed_text_tags = array(
			'a' 	=> array(
				'href' => array (),
				'title' => array ()),
   			'br' => array(),
   			'em' => array(),
   			'strong' => array(),
		);
		
		public $allowed_image_tags = array(
			'a' 	=> array(
				'href' => array (),
				'title' => array () ),
   			'em' => array(),
   			'strong' => array(),
			'img'  => array( 
				'class' => array(),
				'src' => array(),
				'alt' => array(),
				'width' => array(),
				'srcset' => array(),
				'sizes' => array() ),
		);
		
		public $allowed_embed_tags = array(
			'a' 	=> array(
				'class' => array (),
				'href' => array (),
				'title' => array ()),
   			'em' => array(),
   			'strong' => array(),
			 'iframe'  => array( 
				'width' => array(),
				'height' => array(),
				'src' => array(),
				'frameborder' => array(),
				'allowfullscreen' => array() ),
			'video'  => array( 
				'width' => array(),
				'height' => array(),
				'id' => array(),
				'class' => array(),
				'style' => array(),
				'controls' => array(),
				'preload' => array() ),
			'audio'  => array( 
				'width' => array(),
				'height' => array(),
				'id' => array(),
				'class' => array(),
				'style' => array(),
				'controls' => array(),
				'preload' => array() ),
			'source'  => array( 
				'type' => array(),
				'src' => array() ),
		);

		private function __construct() {
		}

		public function text( $content ) {
			return wp_kses( $content , $this->allowed_text_tags );
		}
		
		public function image( $content ) {
			return wp_kses( $content , $this->allowed_image_tags );
		}
		
		public function embed( $content ) {
			return wp_kses( $content , $this->allowed_embed_tags );
		}
		/**
		 * Create the object when called for the 1st time
		 */
		public static function get_instance() {
			static $instance = null;

			if ( is_null( $instance ) )
				$instance = new HANA_KSES;

			return $instance;
		}

	}

	function hana_kses() {
		return HANA_KSES::get_instance();
	}

}