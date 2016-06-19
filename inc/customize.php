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

function hana_default_options() {
	$defaults = array(
		// Header
		'sticky_header' => 1,
		'fullwidth_header' => 0,
		'shrink_topbar' => 0,
		//Layout
		'fluid_width' => 0,
		'grid_width' => 1200,
		'content_column' => 8,
		'sidebar1_column' => 2,
		'sidebar2_column' => 2,
		'sidebar_bbp' => 3,
		'sidebar_pos' => 'right',
		'sticky_sidebar' => 0,
		//Feature
		'max_featured' => 10,
		'slider_type' => 'full',
		'slider_mode' => 'horizontal',
		'slider_speed' => 10,
		'slider_height' => 720,
		'slider_top' => 0,
		'ticker_min' => 2,
		'ticker_max' => 5,		
		//Posts
		'show_author' => 1,
		'show_date' => 1,
		'show_featured' => 1,
		//Social
		'share_top' => 0,
		'share_bottom' => 1,
		'social_top' => 1,
		'social_section' => 0,
		'social_footer' => 0,
		// Footer
		'design_credit' => 1,
		'footer1' => 3,	
		'footer2' => 3,	
		'footer3' => 3,	
		'footer4' => 3,	
		//Fonts
		'bodyfont' => 'default',
		'headingfont' => 'default',
		'posttitlefont' => 'default',
		'sitetitlefont' => 'default',
		'otherfont1' => 'default',
		'otherfont2' => 'default',
		'otherfont3' => 'default',
		//Others
		'color_scheme' => 'default',
	);
	return apply_filters( 'hana_default_options', $defaults);
}

function hana_option( $option ) {
	global $hana_defaults;
	
	return get_theme_mod( $option, $hana_defaults[$option] );
}

function hana_customize_register( $wp_customize ){
	global $hana_defaults;
			
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
		    'description'  => __( 'The theme uses 12 columns grid system. Grid width is defined in pixels. Content and sidebar width are defined in columns. Make sure the sume of content and sidebar columns equals to 12.', 'hana' ),            
            'priority'      => 20,
        )
    );

	$wp_customize->add_setting( 'fluid_width', array(
		'default'           => $hana_defaults['fluid_width'],
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'fluid_width', array(
		'label'    => __( 'Fluid Width (Full Width)', 'hana' ),
		'section'  => 'hana_layout',
		'type'     => 'checkbox',
		'priority' => 10,
	) ); 
    		
	// Grid Width
	$wp_customize->add_setting( 'grid_width', array(
		'default'           => $hana_defaults['grid_width'],
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
		'default'           => $hana_defaults['content_column'],
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
		'default'           => $hana_defaults['sidebar1_column'],
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
		'default'           => $hana_defaults['sidebar2_column'],
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
			'default'           => $hana_defaults['sidebar_bbp'],
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
		'default'           => $hana_defaults['sidebar_pos'],
		'sanitize_callback' => 'hana_sanitize_sidebar',
	) );
	$wp_customize->add_control( 'sidebar_pos', array(
		'label'    => __( 'Sidebar Position', 'hana' ),
		'section'  => 'hana_layout',
		'type'     => 'radio',
		'choices'  => hana_sidebar_postion_choices(),
		'priority' => 40,
	) );	
	
	$wp_customize->add_setting( 'sticky_sidebar', array(
		'default'           => $hana_defaults['sticky_sidebar'],
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'sticky_sidebar', array(
		'label'    => __( 'Sticky Sidebar (Only one sidebar at each side will be sticky)', 'hana' ),
		'section'  => 'hana_layout',
		'type'     => 'checkbox',
		'priority' => 50,
	) );

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
    
	$wp_customize->add_setting( 'sticky_header', array(
		'default'           => $hana_defaults['sticky_header'],
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'sticky_header', array(
		'label'    => __( 'Sticky Header', 'hana' ),
		'section'  => 'hana_header',
		'type'     => 'checkbox',
		'priority' => 10,
	) );

	$wp_customize->add_setting( 'shrink_topbar', array(
		'default'           => $hana_defaults['shrink_topbar'],
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'shrink_topbar', array(
		'label'    => __( 'Shrink Top Bar when scroll down', 'hana' ),
		'section'  => 'hana_header',
		'type'     => 'checkbox',
		'priority' => 10,
	) );
	
	$wp_customize->add_setting( 'fullwidth_header', array(
		'default'           => $hana_defaults['fullwidth_header'],
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'fullwidth_header', array(
		'label'    => __( 'Fluid Width Header', 'hana' ),
		'section'  => 'hana_header',
		'type'     => 'checkbox',
		'priority' => 11,
	) );
   
    /*****************
	* Featured Content 
    *****************/
	if ( !empty( $featured_section ) ) {
	
		$wp_customize->add_setting( 'max_featured', array(
			'default'           => $hana_defaults['max_featured'],
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
			'default'           => $hana_defaults['slider_type'],
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
			'default'           => $hana_defaults['slider_mode'],
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
			'default'           => $hana_defaults['slider_top'],
			'sanitize_callback' => 'hana_sanitize_checkbox',
		) );
		$wp_customize->add_control( 'slider_top', array(
			'label'    => __( 'Align slider to top', 'hana' ),
			'section'  => 'featured_content',
			'type'     => 'checkbox',
			'priority' => 50,
		) );
		
		$wp_customize->add_setting( 'slider_speed', array(
			'default'           => $hana_defaults['slider_speed'],
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
			'default'           => $hana_defaults['slider_height'],
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
			'default'           => $hana_defaults['ticker_min'],
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
			'default'           => $hana_defaults['ticker_max'],
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
		'default'           => $hana_defaults['share_top'],
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'share_top', array(
		'label'    => __( 'Display Jetpack Sharing on Top', 'hana' ),
		'section'  => 'hana_social',
		'type'     => 'checkbox',
		'priority' => 10,
	) );
	
	$wp_customize->add_setting( 'share_bottom', array(
		'default'           => $hana_defaults['share_bottom'],
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'share_bottom', array(
		'label'    => __( 'Display Jetpack Sharing at Bottom', 'hana' ),
		'section'  => 'hana_social',
		'type'     => 'checkbox',
		'priority' => 10,
	) );

	$wp_customize->add_setting( 'social_top', array(
		'default'           => $hana_defaults['social_top'],
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
		'default'           => $hana_defaults['social_section'],
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'social_section', array(
		'label'    => __( 'Display Social Menu with Section Menu', 'hana' ),
		'section'  => 'hana_social',
		'type'     => 'checkbox',
		'priority' => 20,
	) );

	$wp_customize->add_setting( 'social_footer', array(
		'default'           => $hana_defaults['social_footer'],
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'social_footer', array(
		'label'    => __( 'Display Social Link in Footer', 'hana' ),
		'section'  => 'hana_social',
		'type'     => 'checkbox',
		'priority' => 20,
	) );
    /*****************
	* Colors 
    *****************/
	
	$wp_customize->add_setting( 'color_scheme', array(
			'default'           => $hana_defaults['color_scheme'],
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
		
	$wp_customize->add_setting( 'show_author', array(
		'default'           => $hana_defaults['show_author'],
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'show_author', array(
		'label'    => __( 'Display Author', 'hana' ),
		'section'  => 'hana_posts',
		'type'     => 'checkbox',
		'priority' => 10,
	) );
   
	$wp_customize->add_setting( 'show_date', array(
		'default'           => $hana_defaults['show_date'],
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'show_date', array(
		'label'    => __( 'Display Date', 'hana' ),
		'section'  => 'hana_posts',
		'type'     => 'checkbox',
		'priority' => 10,
	) );
	
	$wp_customize->add_setting( 'show_featured', array(
		'default'           => $hana_defaults['show_featured'],
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'show_featured', array(
		'label'    => __( 'Display Featured Imagae for single post', 'hana' ),
		'section'  => 'hana_posts',
		'type'     => 'checkbox',
		'priority' => 10,
	) );

    /*****************
	* Fonts 
    *****************/
    $wp_customize->add_section(
        'hana_fonts',
        array(
            'title'         => __('Web Fonts', 'hana'),
		    'description'  => __( 'You can choose the font for many theme elements such as Body and Headings. Other fonts can be used to load additional web fonts', 'hana' ),            
            'priority'      => 26,
        )
    );
	$font_elements = hana_font_elements();
	foreach ( $font_elements as $key => $element ) {
		$wp_customize->add_setting( $key, array(
				'default'           => $hana_defaults[$key],
			'sanitize_callback' => 'hana_sanitize_fonts',
		) );
		$wp_customize->add_control( $key, array(
			'label'    => $element['label'],
			'section'  => 'hana_fonts',
			'type'     => 'select',
			'priority' => 10,
			'choices'  => hana_font_choices(),
		) );	
	}
	
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
		'default'           => $hana_defaults['footer1'],
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
		'default'           => $hana_defaults['footer2'],
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
		'default'           => $hana_defaults['footer3'],
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
		'default'           => $hana_defaults['footer4'],
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
	
	$wp_customize->add_setting( 'design_credit', array(
		'default'           => $hana_defaults['design_credit'],
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'design_credit', array(
		'label'    => __( 'Show Design Credit', 'hana' ),
		'section'  => 'hana_footer',
		'type'     => 'checkbox',
		'priority' => 50,
	) );	
}
add_action('customize_register', 'hana_customize_register');


function hana_customize_preview_js() {
	wp_enqueue_script( 'hana-customize', get_template_directory_uri() . '/js/customize.js', array( 'customize-preview' ), '20160606', true );
}
add_action( 'customize_preview_init', 'hana_customize_preview_js' );

function hana_customize_section_js() {
	wp_enqueue_script( 'hana-customize-section', get_template_directory_uri() . '/js/customize-section.js', array( 'customize-controls' ), '20160606', true );
}
add_action( 'customize_controls_enqueue_scripts', 'hana_customize_section_js' );

function hana_custom_css( ) {
	global $hana_defaults;
	
	$css = '';
	$width = hana_option( 'grid_width' );
	if ( $hana_defaults[ 'grid_width' ] != $width ) {
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
	if ( 0 != hana_option( 'slider_height' ) &&  'full' == hana_option ('slider_type' ) ) {
		$css .= '.hana-slide {max-height: ' . hana_option( 'slider_height' ) . 'px;}' . "\n";
	}
	//Font
	$hana_fonts = hana_font_list();	
	$font_elements = hana_font_elements();
	foreach ( $font_elements as $key => $element ) {
		$option = hana_option( $key );
		if ( ! empty( $option ) &&  'default' != $option && !empty( $element['selector'] ) )
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

function hana_sanitize_social_icon( $input ) {
    $valid = hana_social_icon_choices();
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

function hana_sanitize_fonts( $input ) {
    $valid = hana_font_choices();
 
    if ( array_key_exists( $input, $valid ) ) {
    	if ( is_numeric($input ) )
    		return 'default';
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
// Checkbox
function hana_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}
// Text
function hana_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
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
    );    
 	return apply_filters( 'hana_slider_type_choices', $choices );
}

function hana_social_icon_choices() {
    $choices = array(
        '1'    => __('Normal', 'hana'),
        '2'     => __('Square', 'hana'),
    );    
 	return apply_filters( 'hana_social_icon_choices', $choices );
}

function hana_scheme_choices() {
	$schemes = apply_filters( 'hana_scheme_options', NULL );
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