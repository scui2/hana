<?php
/**
 * Translatable texts used in Hana Core. Replace 'hana' with the theme-slug
 * In this way, theme will work well with WordPress translation pack
 * 
 * @package	  hanacore
 * @since     1.0
 * @author	  Stephen Cui
 * @copyright Copyright 2016, Stephen Cui
 * @license   GPL v3 or later
 * @link      http://rewindcreation.com/
 */
function hana_text() {
	return HANA_Core_Text::get_instance();
}

class HANA_Core_Text {

	public $texts = array();

	private function __construct() {
		$this->texts = array(
			'widget_nav' => __( '(Hana) Navigation' , 'hana' ),
		);
	}

	public function text_exists( $id ) {
		return isset( $this->texts[ $id ] );
	}

	public function get_text( $id ) {
		return $this->text_exists( $id ) ? $this->texts[ $id ] : false;
	}

	/**
	 * Create the object when called for the 1st time
	 */
	public static function get_instance() {
		static $instance = null;

		if ( is_null( $instance ) )
			$instance = new HANA_Core_Text;

		return $instance;
	}

}