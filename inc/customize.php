<?php
/**
 * Hana Customize Functions
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
if ( ! defined('ABSPATH') ) exit;

function hana_customize_register( $wp_customize ){			
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	$featured_section = $wp_customize->get_section( 'featured_content' );
	if ( !empty($featured_section) )
		$featured_section->priority = 22;
	$featured_section = $wp_customize->get_section( 'static_front_page' )->priority = 20;
	// Remove the core Display Header Text option.
	$wp_customize->remove_control( 'display_header_text' );	
    /*****************
	* Layout Section 
    *****************/
    $wp_customize->add_section(
        'hana_layout',
        array(
            'title'         => __('Layout', 'hana'),
		    'description'  => __( 'The theme uses 12-column grid system. Grid width is defined in pixels. Content and sidebar width are defined in columns. Make sure the sume of content and sidebar columns equals to 12.', 'hana' ),            
            'priority'      => 20,
        )
    );

	$wp_customize->add_setting( 'fluid_grid', array(
		'default'           => 0,
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'fluid_grid', array(
		'label'    => __( 'Fluid Grid (Full Width)', 'hana' ),
		'section'  => 'hana_layout',
		'type'     => 'checkbox',
		'priority' => 10,
	) ); 
    		
	// Grid Width
	$wp_customize->add_setting( 'grid_width', array(
		'default'           => 1200,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'grid_width', array(
		'label'    => __( 'Grid Width (Pixel)', 'hana' ),
		'section'  => 'hana_layout',
		'type'     => 'number',
		'priority' => 10,
        'input_attrs' => array(
            'min'   => 960,
            'max'   => 4000,
            'step'  => 10,
        ),
	) );
	// Content Width
	$wp_customize->add_setting( 'content_column', array(
		'default'           => 8,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'content_column', array(
		'label'    => __( 'Content (Column)', 'hana' ),
		'section'  => 'hana_layout',
		'type'     => 'number',
		'priority' => 11,
        'input_attrs' => array(
        	'min'   => 1,
            'max'   => 12,
            'step'  => 1,
        ),
	) );
	$wp_customize->add_setting( 'sidebar1_column', array(
		'default'           => 2,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'sidebar1_column', array(
		'label'    => __( 'Sidebar 1 (Column)', 'hana' ),
		'section'  => 'hana_layout',
		'type'     => 'number',
		'priority' => 12,
        'input_attrs' => array(
        	'min'   => 0,
            'max'   => 6,
            'step'  => 1,
        ),
	) );

	$wp_customize->add_setting( 'sidebar2_column', array(
		'default'           => 2,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'sidebar2_column', array(
		'label'    => __( 'Sidebar 2 (Column)', 'hana' ),
		'section'  => 'hana_layout',
		'type'     => 'number',
		'priority' => 13,
        'input_attrs' => array(
        	'min'   => 0,
            'max'   => 6,
            'step'  => 1,
        ),
	) );
	
	$wp_customize->add_setting( 'sidebar_bbp', array(
		'default'           => 3,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'sidebar_bbp', array(
		'label'    => __( 'bbPress Sidebar (Column)', 'hana' ),
		'section'  => 'hana_layout',
		'type'     => 'number',
		'priority' => 13,
      	'input_attrs' => array(
    	   	'min'   => 0,
            'max'   => 6,
            'step'  => 1,
        	),
	) );
		
	// Sidebar Position.
	$wp_customize->add_setting( 'sidebar_pos', array(
		'default'           => 'right',
		'sanitize_callback' => 'hana_sanitize_sidebar',
	) );
	$wp_customize->add_control( 'sidebar_pos', array(
		'label'    => __( 'Sidebar Position', 'hana' ),
		'description'    => __( 'Blog Widget Area (Full) will not be displayed for Left & Right Sidebar', 'hana' ),
		'section'  => 'hana_layout',
		'type'     => 'radio',
		'choices'  => hana_sidebar_postion_choices(),
		'priority' => 40,
	) );	
	
	$wp_customize->add_setting( 'sticky_sidebar', array(
		'default'           => 0,
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'sticky_sidebar', array(
		'label'    => __( 'Sticky Sidebar (Only one sidebar at each side will be sticky)', 'hana' ),
		'section'  => 'hana_layout',
		'type'     => 'checkbox',
		'priority' => 50,
	) );

    /*****************
	* Typography 
    *****************/
    $wp_customize->add_section(
        'hana_typo',
        array(
            'title'         => __('Typography', 'hana'),
		    'description'  => __( 'You can choose the font for many theme elements such as Body and Headings. Other fonts can be used to load additional web fonts', 'hana' ),            
            'priority'      => 20,
        )
    );
	$font_elements = hana_font_elements();
	foreach ( $font_elements as $key => $element ) {
		$wp_customize->add_setting( $key, array(
				'default'           => 'default',
			'sanitize_callback' => 'hana_sanitize_fonts',
		) );
		$wp_customize->add_control( $key, array(
			'label'    => $element['label'],
			'section'  => 'hana_typo',
			'type'     => 'select',
			'priority' => 10,
			'choices'  => hana_font_choices(),
		) );	
	}
	
    /*****************
	* Header 
    *****************/
    $wp_customize->add_section(
        'hana_header',
        array(
            'title'         => __('Header', 'hana'),
		    'description'  => '',            
            'priority'      => 21,
        )
    );
	$wp_customize->add_setting( 'fluid_header', array(
		'default'           => 0,
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'fluid_header', array(
		'label'    => __( 'Fluid Width Header and Footer', 'hana' ),
		'section'  => 'hana_header',
		'type'     => 'checkbox',
		'priority' => 10,
	) );
	
	$wp_customize->add_setting( 'sticky_header', array(
		'default'           => 0,
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'sticky_header', array(
		'label'    => __( 'Sticky Header', 'hana' ),
		'section'  => 'hana_header',
		'type'     => 'checkbox',
		'priority' => 20,
	) );

	$wp_customize->add_setting( 'shrink_topbar', array(
		'default'           => 0,
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'shrink_topbar', array(
		'label'    => __( 'Shrink Top Bar when scroll down', 'hana' ),
		'section'  => 'hana_header',
		'type'     => 'checkbox',
		'priority' => 30,
	) );
   
    /*****************
	* Featured Content 
    *****************/
	if ( !empty( $featured_section ) ) { //If Jetpack is active
	
		$wp_customize->add_setting( 'max_featured', array(
			'default'           => 10,
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'max_featured', array(
			'label'    => __( 'Maximum Featured Posts', 'hana' ),
			'section'  => 'featured_content',
			'type'     => 'number',
			'priority' => 40,
	        'input_attrs' => array(
	        	'min'   => 1,
	            'max'   => 99,
	            'step'  => 1,
	        ),
		) ); 
		
		$wp_customize->add_setting( 'slider_type', array(
			'default'           => 'full',
			'sanitize_callback' => 'hana_sanitize_slider_type',
		) );
		$wp_customize->add_control( 'slider_type', array(
			'label'    => __( 'Slider Type', 'hana' ),
			'section'  => 'featured_content',
			'type'     => 'radio',
			'choices'  => hana_slider_type_choices(),
			'priority' => 50,
		) );	

		$wp_customize->add_setting( 'slider_mode', array(
			'default'           => 'horizontal',
			'sanitize_callback' => 'hana_sanitize_slider_mode',
		) );
		$wp_customize->add_control( 'slider_mode', array(
			'label'    => __( 'Slider Mode', 'hana' ),
			'section'  => 'featured_content',
			'type'     => 'radio',
			'choices'  => hana_slider_mode_choices(),
			'priority' => 50,
		) );	

		$wp_customize->add_setting( 'slider_top', array(
			'default'           => 0,
			'sanitize_callback' => 'hana_sanitize_checkbox',
		) );
		$wp_customize->add_control( 'slider_top', array(
			'label'    => __( 'Align Fullwidth Slider to Top', 'hana' ),
			'section'  => 'featured_content',
			'type'     => 'checkbox',
			'priority' => 50,
		) );
		
		$wp_customize->add_setting( 'slider_speed', array(
			'default'           => 10, // second
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'slider_speed', array(
			'label'    => __( 'Speed (second)', 'hana' ),
			'section'  => 'featured_content',
			'type'     => 'number',
			'priority' => 50,
	        'input_attrs' => array(
	        	'min'   => 1,
	            'max'   => 500,
	            'step'  => 1,
	        ),
		) );   

		$wp_customize->add_setting( 'slider_height', array(
			'default'           => 0, //px
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'slider_height', array(
			'label'    => __( 'Slide Height (0 = Auto Height)', 'hana' ),
			'section'  => 'featured_content',
			'type'     => 'number',
			'priority' => 50,
	        'input_attrs' => array(
	        	'min'   => 0,
	            'max'   => 1080,
	            'step'  => 1,
	        ),
		) );   
		
		$wp_customize->add_setting( 'ticker_min', array(
			'default'           => 2, //Slide
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'ticker_min', array(
			'label'    => __( 'Minimum slides (Ticker mode)', 'hana' ),
			'section'  => 'featured_content',
			'type'     => 'number',
			'priority' => 50,
	        'input_attrs' => array(
	        	'min'   => 1,
	            'max'   => 10,
	            'step'  => 1,
	        ),
		) );   
		$wp_customize->add_setting( 'ticker_max', array(
			'default'           => 5, //slides
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'ticker_max', array(
			'label'    => __( 'Maximum slides (Ticker mode)', 'hana' ),
			'section'  => 'featured_content',
			'type'     => 'number',
			'priority' => 50,
	        'input_attrs' => array(
	        	'min'   => 1,
	            'max'   => 10,
	            'step'  => 1,
	        ),
		) );  		 			

	} // end of featured_content	
	
    /*****************
	* Colors 
    *****************/
	$wp_customize->add_setting( 'color_scheme', array(
			'default'           => 'default',
			'sanitize_callback' => 'hana_sanitize_schemes',
	) );
	$wp_customize->add_control( 'color_scheme', array(
			'label'    => __('Scheme', 'hana'),
			'section'  => 'colors',
			'type'     => 'select',
			'priority' => 10,
			'choices'  => hana_scheme_choices(),
	) );
    /*****************
	* Posts 
    *****************/
    $wp_customize->add_section(
        'hana_posts',
        array(
            'title'         => __('Posts', 'hana'),
		    'description'  => '',            
            'priority'      => 25,
        )
    );
		
	$wp_customize->add_setting( 'hide_author', array(
		'default'           => 0,
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'hide_author', array(
		'label'    => __( 'Hide Author', 'hana' ),
		'section'  => 'hana_posts',
		'type'     => 'checkbox',
		'priority' => 10,
	) );
   
	$wp_customize->add_setting( 'hide_date', array(
		'default'           => 0,
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'show_date', array(
		'label'    => __( 'Hide Date', 'hana' ),
		'section'  => 'hana_posts',
		'type'     => 'checkbox',
		'priority' => 10,
	) );
	
	$wp_customize->add_setting( 'hide_featured', array(
		'default'           => 0,
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'hide_featured', array(
		'label'    => __( 'Hide Featured Imagae in Single Post View', 'hana' ),
		'section'  => 'hana_posts',
		'type'     => 'checkbox',
		'priority' => 10,
	) );
	
    /*****************
	* Footer 
    *****************/
    $wp_customize->add_section(
        'hana_footer',
        array(
            'title'         => __('Footer', 'hana'),
		    'description'  => '',            
            'priority'      => 40,
        )
    );
    
	$wp_customize->add_setting( 'footer1', array(
		'default'           => 3,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'footer1', array(
		'label'    => __( 'Footer Widget 1 (Column)', 'hana' ),
		'section'  => 'hana_footer',
		'type'     => 'number',
		'priority' => 10,
        'input_attrs' => array(
        	'min'   => 0,
            'max'   => 12,
            'step'  => 1,
        ),
	) );

	$wp_customize->add_setting( 'footer2', array(
		'default'           => 3,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'footer2', array(
		'label'    => __( 'Footer Widget 2 (Column)', 'hana' ),
		'section'  => 'hana_footer',
		'type'     => 'number',
		'priority' => 10,
        'input_attrs' => array(
        	'min'   => 0,
            'max'   => 12,
            'step'  => 1,
        ),
	) );

	$wp_customize->add_setting( 'footer3', array(
		'default'           => 3,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'footer3', array(
		'label'    => __( 'Footer Widget 3 (Column)', 'hana' ),
		'section'  => 'hana_footer',
		'type'     => 'number',
		'priority' => 10,
        'input_attrs' => array(
        	'min'   => 0,
            'max'   => 12,
            'step'  => 1,
        ),
	) );
	
	$wp_customize->add_setting( 'footer4', array(
		'default'           => 3,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'footer4', array(
		'label'    => __( 'Footer Widget 4 (Column)', 'hana' ),
		'section'  => 'hana_footer',
		'type'     => 'number',
		'priority' => 10,
        'input_attrs' => array(
        	'min'   => 0,
            'max'   => 12,
            'step'  => 1,
        ),
	) );

	$wp_customize->add_setting( 'copyright_text', array(
		'default'           => '',
		'sanitize_callback' => 'hana_sanitize_text',
	) );
	$wp_customize->add_control( 'copyright_text', array(
		'label'    => __( 'Copyright Text', 'hana' ),
		'section'  => 'hana_footer',
		'type'     => 'text',
		'priority' => 45,
	) );
		
	$wp_customize->add_setting( 'hide_credit', array(
		'default'           => 0,
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'hide_credit', array(
		'label'    => __( 'Hide Design Credit', 'hana' ),
		'section'  => 'hana_footer',
		'type'     => 'checkbox',
		'priority' => 50,
	) );
    /*****************
	* Social 
    *****************/  
    $wp_customize->add_section(
        'hana_social',
        array(
            'title'         => __('Social', 'hana'),
		    'description'  => __( 'Choose the location where Jetpack sharing buttons are displayed.', 'hana'),           
            'priority'      => 50,
        )
    );
	$wp_customize->add_setting( 'share_top', array(
		'default'           => 0,
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'share_top', array(
		'label'    => __( 'Display Jetpack Sharing on Top', 'hana' ),
		'section'  => 'hana_social',
		'type'     => 'checkbox',
		'priority' => 10,
	) );
	
	$wp_customize->add_setting( 'share_bottom', array(
		'default'           => 0,
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'share_bottom', array(
		'label'    => __( 'Display Jetpack Sharing at Bottom', 'hana' ),
		'section'  => 'hana_social',
		'type'     => 'checkbox',
		'priority' => 10,
	) );

	$wp_customize->add_setting( 'social_top', array(
		'default'           => 0,
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'social_top', array(
		'label'    => __( 'Display Social Menu with Top Menu', 'hana' ),
		'description'  => __( 'Create a custom Social Menu and choose the location to display. Supported social services will be displayed as an icon. See theme documentation for setup instruction.', 'hana'),           
		'section'  => 'hana_social',
		'type'     => 'checkbox',
		'priority' => 20,
	) );	

	$wp_customize->add_setting( 'social_section', array(
		'default'           => 0,
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'social_section', array(
		'label'    => __( 'Display Social Menu with Section Menu', 'hana' ),
		'section'  => 'hana_social',
		'type'     => 'checkbox',
		'priority' => 20,
	) );

	$wp_customize->add_setting( 'social_footer', array(
		'default'           => 0,
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'social_footer', array(
		'label'    => __( 'Display Social Link in Footer', 'hana' ),
		'section'  => 'hana_social',
		'type'     => 'checkbox',
		'priority' => 20,
	) );
    /*****************
	* Home Page 
    *****************/
	$wp_customize->add_section(
        'hana_homepage',
        array(
            'title'         => __( 'Home Page', 'hana'),
		    'description'  => __(  'Widgets in Home Widget Areas can be displayed horizontally. Simple specify the width and the layout for each widget area.','hana'),            
            'priority'      => 50,
        )
    );
    
    $num = absint( apply_filters('hana_homewidget_number', 4) );
	for ( $i = 1; $i <= $num; $i++ ) {
		// Title		
		$wp_customize->add_setting( 'home_title_' . $i, array(
			'default'           => '',
			'sanitize_callback' => 'hana_sanitize_text',
		) );
		$wp_customize->add_control( 'home_title_' . $i, array(
			'label'    => sprintf( __('Home Widget Area %1$s Title', 'hana'), $i),
			'section'  => 'hana_homepage',
			'type'     => 'text',
			'priority' => 10 * $i,
		) );
		// Subtitle Title		
		$wp_customize->add_setting( 'home_subtitle_' . $i, array(
			'default'           => '',
			'sanitize_callback' => 'hana_sanitize_text',
		) );
		$wp_customize->add_control( 'home_subtitle_' . $i, array(
			'label'    => __('Sub-Title', 'hana'),
			'section'  => 'hana_homepage',
			'type'     => 'text',
			'priority' => 10 * $i,
		) );
		// Width
		$wp_customize->add_setting( 'home_width_' . $i, array(
			'default'           => 12,
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'home_width_' . $i, array(
			'label'    => __( 'Width (Column)', 'hana' ),
			'section'  => 'hana_homepage',
			'type'     => 'number',
			'priority' => 10 * $i,
 	   		'input_attrs' => array(
  		    	'min'   => 0,
           	 	'max'   => 12,
           		 'step'  => 1 ),
		) );

		$wp_customize->add_setting( 'home_column_' . $i, array(
			'default'           => '3',
			'sanitize_callback' => 'hana_sanitize_columns',
		) );
		$wp_customize->add_control( 'home_column_' . $i, array(
			'label'    => __( 'Layout', 'hana'),
			'section'  => 'hana_homepage',
			'type'     => 'select',
			'priority' => 10 * $i,
			'choices'  => hana_columns_choices(),
		) );	
	} //end for
    
}
add_action('customize_register', 'hana_customize_register');


function hana_customize_preview_js() {
	wp_enqueue_script( 'hana-customize', HANA_THEME_URI . 'js/customize.js', array( 'customize-preview' ), '20160606', true );
}
add_action( 'customize_preview_init', 'hana_customize_preview_js' );

function hana_customize_section_js() {
	wp_enqueue_script( 'hana-customize-section', HANA_THEME_URI . 'js/customize-section.js', array( 'customize-controls' ), '20160606', true );
}
add_action( 'customize_controls_enqueue_scripts', 'hana_customize_section_js' );

function hana_custom_css( ) {	
	$css = '';
	$width = get_theme_mod( 'grid_width' );
	if ( 1200 != $width ) {
		$css .= '.row {max-width: ' . $width . 'px; }' . "\n";
	}
	// Site Title text color
	if ( get_theme_mod('header_textcolor') )
		$css .= '.site-title a {color: #' . get_theme_mod('header_textcolor') . '; }' . "\n";
	// Header image as background	
	$header_image = get_header_image();
	if ( ! empty ($header_image) ) {
		$css .= '.top-bar {background-image:url(' . esc_url( $header_image ) . '); }' . "\n";		
	}
	if ( get_theme_mod( 'slider_height' ) &&  'full' == get_theme_mod ('slider_type', 'full' ) ) {
		$css .= '.hana-slide {max-height: ' . get_theme_mod( 'slider_height' ) . 'px;}' . "\n";
	}
	//Font
	$hana_fonts = hana_font_list();	
	$font_elements = hana_font_elements();
	foreach ( $font_elements as $key => $element ) {
		$option = get_theme_mod( $key );
		if ( $option &&  'default' != $option && !empty( $element['selector'] ) )
			$css .= $element['selector'] . ' {font-family:' . $hana_fonts[ $option ]['name'] . ',' . $hana_fonts[ $option ]['type'] . ';}' . "\n";		
	}
	return apply_filters( 'hana_custom_css', $css);
}

/***********************
* Sanitize Functions 
***********************/
function hana_sanitize_sidebar( $input ) {
    $valid = hana_sidebar_postion_choices();
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

function hana_sanitize_slider_type( $input ) {
    $valid = hana_slider_type_choices();
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

function hana_sanitize_slider_mode( $input ) {
    $valid = hana_slider_mode_choices();
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

function hana_sanitize_schemes( $input ) {
    $valid = hana_scheme_choices();
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
/***********************
* Choices Functions 
***********************/
function hana_sidebar_postion_choices() {
    $choices = array(
        'right'    => __('Right Sidebar', 'hana'),
        'left'     => __('Left Sidebar', 'hana'),
        'both'     => __('Left & Right Sidebar', 'hana'),
        'none'   => __('No Sidebar', 'hana')
    );    
 	return apply_filters( 'hana_sidebar_postion_choices', $choices );
}

function hana_slider_type_choices() {
    $choices = array(
        'full'    => __('Full Width Slider', 'hana'),
        'grid'    => __('Grid Width Slider', 'hana'),
        'ticker'     => __('Ticker', 'hana'),
    );    
 	return apply_filters( 'hana_slider_type_choices', $choices );
}

function hana_slider_mode_choices() {
    $choices = array(
        'horizontal'    => __('Horizontal', 'hana'),
        'vertical'     => __('Vertical', 'hana'),
        'fade'     => __('Fade', 'hana'),
    );    
 	return apply_filters( 'hana_slider_type_choices', $choices );
}

function hana_scheme_choices() {
	$schemes = hana_scheme_options();
	$choices = array();
	foreach ( $schemes as $key => $scheme ) {
		$choices[$key] = $scheme['label'];
	}
	return $choices;
}
/***************************************
* Custome Header and Background Support
***************************************/
if ( ! function_exists( 'hana_custom_header_background' ) ):
function hana_custom_header_background() {
	add_theme_support( 'custom-background', array(
		'default-color' => '', //Default background color
	) );
	$arg = array(
		'default-text-color'     => 'FBB700',
		'width'                  => 1980,
		'height'                 => 300,
		'flex-height'            => true,
	);
	add_theme_support( 'custom-header', $arg );	
}
endif;
add_action( 'after_setup_theme', 'hana_custom_header_background' );

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