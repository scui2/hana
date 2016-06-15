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
			'name' => 'Default' ),
	'1'		=> array( 
			'name' => '-- Sans --' ),
	'Arimo' => array(
			'name' => 'Arimo',
			'type' => 'sans-serif',
			'weight'  => ':400,700,400italic,700italic' ),
	'Cabin' => array(
			'name' => 'Cabin',
			'type' => 'sans-serif',
			'weight'  => ':400,700,400italic,700italic' ),
	'Lato'	 => array(
			'name' => 'Lato',
			'type' => 'sans-serif',
			'weight'  => ':400,700,400italic,700italic' ),					
	'Open Sans' => array(
			'name' => 'Open Sans',
			'type' => 'sans-serif',
			'weight'  => ':400,400italic,700,700italic' ),
	'Oswald' => array(
			'name' => 'Oswald',
			'type' => 'sans-serif',
			'weight'  => ':400,700' ),
	'Roboto' => array(
			'name' => 'Roboto',
			'type' => 'sans-serif',
			'weight'  => ':400,700,400italic,700italic' ),
	'Ubuntu' => array(
			'name' => 'Ubuntu',
			'type' => 'sans-serif',
			'weight'  => ':400,700,400italic,700italic' ),
//Serif
	'2' => array( 
			'name' => '-- Serif --' ),	
	'Old Standard TT' => array(
			'name' => 'Old Standard TT',
			'type' => 'serif',
			'weight'  => ':400,700,400italic' ),
//Cursive
	'3' => array( 
			'name' => '-- Cursive --' ),
	'Berkshire Swash' => array(
			'name' => 'Berkshire Swash',
			'type' => 'cursive',
			'weight' => '' ),
	'Lobster' => array(
			'name' => 'Lobster',
			'type' => 'cursive',
			'weight' => '' ),
// End of font array			
	);
	return apply_filters( 'hana_font_list', $fonts );	
}

function hana_font_choices() {
	$fonts = hana_font_list();
	$choices = array();
	foreach ( $fonts as $key => $font ) {
		$choices[$key] = $font['name'];
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

if ( ! function_exists( 'hana_google_font_url' ) ):
function hana_google_font_url() {
	$url = '';
	$hana_fonts = hana_font_list();	
	$font_elements = hana_font_elements();
	$fonts = array();
	foreach ( $font_elements as $key => $element ) {
		$value = hana_option( $key );
		if ( ! empty( $value ) && 'default' != $value && ! in_array( $value, $fonts) ) {
			$fonts[] = $value ;					
		}
	}
	if ( !empty( $fonts ) ) {
		$font_families = array();
		foreach ( $fonts as $font ) {
			$font_families[] = $hana_fonts[ $font ]['name'] . $hana_fonts[ $font ]['weight'];
		}
		$args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( apply_filters( 'hana_webfont_subset', 'latin,latin-ext' ) ),
		);
		$url = add_query_arg( $args, apply_filters( 'hana_webfont_url', '//fonts.googleapis.com/css' ) );
	}
	return $url;
}
endif;
