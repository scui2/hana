<?php
/**
 * Google Fonts
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
		
function hana_font_list() {
	$fonts = array(
//Sans	
	'default' => array( 
			'label' => 'Default',
			'family' => "'Helvetica Neue', Helvetica, Arial, sans-serif" ),
	'1' => array( 
			'label' => '-- Sans --' ),
	'Arial' => array(
			'label' => 'Arial',
			'family' => "Arial, Helvetica, sans-serif" ),
	'Arial Black' => array(
			'label' => 'Arial Black',
			'family' => "Arial Black, Gadget, sans-serif" ),
	'Cabin' => array(
			'label' => 'Cabin',
			'url'  => '//fonts.googleapis.com/css?family=Cabin:400,700,400italic,700italic',
			'family' => "'Cabin', sans-serif" ),
	'Impact' => array(
			'label' => 'Impact',
			'family' => "Impact, Charcoal, sans-serif" ),		
	'Lato' => array(
			'label' => 'Lato',
			'url'  => '//fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic',
			'family' => "Lato, sans-serif" ),		
	'Lucida Sans' => array(
			'label' => 'Lucida Sans',
			'family' => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif" ),		
	'MS Sans Serif' => array(
			'label' => 'MS Sans Serif',
			'family' => "'MS Sans Serif', Geneva, sans-serif" ),
	'Tahoma' => array(
			'label' => 'Tahoma',
			'family' => "Tahoma, Geneva, sans-serif" ),
	'Trebuchet MS' => array(
			'label' => 'Trebuchet MS',
			'family' => "'Trebuchet MS', sans-serif" ),			
	'Open Sans' => array(
			'label' => 'Open Sans',
			'url'  => '//fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,700italic',
			'family' => "'Open Sans', sans-serif" ),
	'Oswald' => array(
			'label' => 'Oswald',
			'url'  => '//fonts.googleapis.com/css?family=Oswald:400,700',			
			'family' => "'Oswald', sans-serif" ),
	'Roboto' => array(
			'label' => 'Roboto',
			'url'  => '//fonts.googleapis.com/css?family==Roboto:400,700,400italic,700italic',	
			'family' => "'Roboto', sans-serif" ),
	'Ubuntu' => array(
			'label' => 'Ubuntu',
			'url'  => '//fonts.googleapis.com/css?family=Ubuntu:400,400italic,700italic,700',
			'family' => "'Ubuntu', sans-serif;" ),	
	'Verdana' => array(
			'label' => 'Verdana',
			'family' => "Verdana, Geneva, sans-serif" ),
			
//Serif
	'2' => array( 
			'label' => '-- Serif --' ),
	'Georgia' => array(
			'label' => 'Georgia',
			'family' => "Georgia, serif" ),
	'MS Serif' => array(
			'label' => 'MS Serif',
			'family' => "'MS Serif', 'New York', serif" ),	
	'Palatino' => array(
			'label' => 'Palatino',
			'family' => "'Palatino Linotype', 'Book Antiqua', Palatino, serif" ),
	'Times New Roman' => array(
			'label' => 'Times New Roman',
			'family' => "'Times New Roman', Times, serif" ),	
	'Old Standard TT' => array(
			'label' => 'Old Standard TT',
			'url'  => '//fonts.googleapis.com/css?family=Old+Standard+TT:400,700,400italic',
			'family' => "'Old Standard TT', serif" ),
//Monospae
	'3' => array( 
			'label' => '-- Monospace --' ),
	'Courier New' => array(
			'label' => 'Courier New',
			'family' => "'Courier New', monospace" ),
	'Lucida Console' => array(
			'label' => 'Lucida Console',
			'family' => "'Lucida Console', Monaco, monospace" ),
//Cursive
	'4' => array( 
			'label' => '-- Cursive --' ),
	'Berkshire Swash' => array(
			'label' => 'Berkshire Swash',
			'url' => '//fonts.googleapis.com/css?family=Berkshire+Swash',
			'family' => "'Berkshire Swash', cursive" ),
	'Comic Sans MS' => array(
			'label' => 'Comic Sans MS',
			'family' => "'Comic Sans MS', cursive" ),
	'Lobster' => array(
			'label' => 'Lobster',
			'url' => '//fonts.googleapis.com/css?family=Lobster',
			'family' => "'Lobster', cursive" ),
	);
	return apply_filters( 'hana_font_list', $fonts );	
}

function hana_font_choices() {
	$fonts = hana_font_list();
	$choices = array();
	foreach ( $fonts as $key => $font ) {
		if ( ! empty( $font['url'] ) )
			$choices[$key] = '* ' . $font['label'];
		else
			$choices[$key] = $font['label'];
	}
	return $choices;
}

function hana_font_elements() {
	$elements = array(
		'bodyfont'      => array( 'label' => __( 'Body Font', 'hana'),
							 	'selector' => 'body'  ),
		'headingfont'   => array( 'label' => __( 'Heading Font', 'hana'),
								'selector' => 'h1, h2, h3, h4, h5, h6'  ),
		'posttitlefont' => array( 'label' => __( 'Post Title Font', 'hana'),
								'selector' => '.entry-title'  ),
		'sitetitlefont' => array( 'label' => __( 'Site Title Font', 'hana'),
								'selector' => '.site-title a'  ),
		'otherfont1' => array( 'label' => __( 'Other Font 1', 'hana'),
								'selector' => ''  ),
		'otherfont2' => array( 'label' => __( 'Other Font 2', 'hana'),
								'selector' => ''  ),
		'otherfont3' => array( 'label' => __( 'Other Font 3', 'hana'),
								'selector' => ''  ),
	);
	return apply_filters( 'hana_font_elements', $elements );
}
