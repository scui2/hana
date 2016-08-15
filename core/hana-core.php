<?php
/**
 * Hana Core supports the development of Hana Themes based on Foundaiton 6 Framework.
 * The idea is that core handles common functions such as Grid, Meta, Widgets, etc.
 * Themes will focus on style, markup and other content presentation functions.
 * 
 * Credit: The idea and template loading sequencing of Hana Core class  
 * are coming from Justin Tadlock's Hybrid Core Framework licensed under GPL. 
 * Otherwise, all other functions are developed independently.
 * 
 * @package	  hanacore
 * @since     1.0
 * @author	  Stephen Cui
 * @copyright Copyright 2016, Stephen Cui
 * @license   GPL v3 or later
 * @link      http://rewindcreation.com/
 */
if ( ! class_exists( 'HANA_Core' ) ) {
	
	class HANA_Core {
		/**
		* Define constants, Control load orders of libraries 
		* and setup common theme supports
		*/
		public function __construct() {
			add_action( 'after_setup_theme', array( $this, 'constants' ), -99 ); //Before Theme
			add_action( 'after_setup_theme', array( $this, 'includes' ), -98 );
			add_action( 'after_setup_theme', array( $this, 'core_setup' ), 12 ); // After Theme
			add_action( 'after_setup_theme', array( $this, 'admin' ),  99 ); // Admin Functions
		}
		/**
		* Define constants to be used in Core and Themes
		*/
		public function constants() {
			// Core Version
			define( 'HANA_CORE_VERSION', '1.0.0' );

			// Theme directory.
			define( 'HANA_THEME_DIR', trailingslashit( get_template_directory() ) );
			define( 'HANA_CHILD_DIR',  trailingslashit( get_stylesheet_directory() ) );
			// Theme directory URIs.
			define( 'HANA_THEME_URI', trailingslashit( get_template_directory_uri() ) );
			define( 'HANA_CHILD_URI',  trailingslashit( get_stylesheet_directory_uri() ) );
			// Core directory and URI.
			if ( ! defined( 'HANA_CORE_DIR' ) )
				define( 'HANA_CORE_DIR', trailingslashit( HANA_THEME_DIR . basename( dirname( __FILE__ ) ) ) );
			if ( ! defined( 'HANA_CORE_URI' ) )
				define( 'HANA_CORE_URI', trailingslashit( HANA_THEME_URI . basename( dirname( __FILE__ ) ) ) );
			// Parent theme version
			$theme  = wp_get_theme( get_template() );
			define( 'HANA_THEME_VERSION', esc_attr( $theme->get( 'Version' ) ) );
		}
		
		/**
		* Load core functions
		*/		
		public function includes() {
			require_once( HANA_CORE_DIR . 'inc/class-grid.php' );
			require_once( HANA_CORE_DIR . 'inc/class-kses.php' );
			require_once( HANA_CORE_DIR . 'inc/class-post-meta.php' );
			require_once( HANA_CORE_DIR . 'inc/class-media.php' );
            require_once( HANA_CORE_DIR . 'inc/class-font.php' );
            require_once( HANA_CORE_DIR . 'inc/core-functions.php' );
            require_once( HANA_CORE_DIR . 'inc/lib-choices.php' );
            require_once( HANA_CORE_DIR . 'inc/lib-menu.php' );
			require_once( HANA_CORE_DIR . 'inc/lib-customizer.php' );
		}		
		/**
		* Define constants to be used in Core and Themes
		*/		
		public function core_setup() {
			// Add fead links to the head
			add_theme_support( 'automatic-feed-links' );
			// Add <title> to the head
			add_theme_support( 'title-tag' );
			//HTML5 support
			add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
		}
        
		public function admin() {
			if ( is_admin() ) {
				require_once( HANA_CORE_DIR . 'inc/class-meta-box.php' );				
                require_once( HANA_CORE_DIR . 'inc/admin-functions.php' );				
			}
		}	
	} // Class HanaCore

}
