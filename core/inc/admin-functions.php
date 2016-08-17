<?php
/**
 * Admin Functions
 * @package	  hanacore
 * @since     1.0
 * @author	  Stephen Cui
 * @copyright Copyright 2016, Stephen Cui
 * @license   GPL v3 or later
 * @link      http://rewindcreation.com/
 */
if ( ! defined('ABSPATH') ) exit;

add_action( 'admin_menu', 'hana_add_meta_boxes' );
function hana_add_meta_boxes() {
	$prefix = apply_filters( 'hana_meta_box_prefix', '_hana');	
	$meta_boxes = array(
	
	'page' => array( 
		'id' => 'hana-page-meta',
		'title' => esc_html__('Template Options', 'hana'), 
		'type' => 'page',
		'context' => 'side',  //normal, advaned, side  
		'priority' => 'default', //high, core, default, low
		'fields' => array(
        	array(
            	'name' => esc_html__( 'Post Category :' ,'hana'),
            	'desc' => '',
            	'id' => $prefix . '_category',
            	'type' => 'select',
				'options' => hana_category_choices( 'metaall' ),
        	),
        	array(
            	'name' => esc_html__( 'Posts per page/load :', 'hana' ),
            	'desc' => '',
            	'id' => $prefix . '_postperpage',
            	'type' => 'number',
        	),
			array(
            	'name' => esc_html__('Sidebar :', 'hana'),
            	'desc' => esc_html__('check to display sidebar','hana'),
            	'id' => $prefix . '_sidebar',
            	'type' => 'checkbox',
        	),
        	array(
            	'name' => esc_html__('Layout :', 'hana'),
            	'desc' => '',
            	'id' => $prefix . '_column',
            	'type' => 'select',
				'options' => hana_column_choices( true ),
        	),
        	array(
            	'name' => esc_html__('Image Size : ', 'hana'),
            	'desc' => '',
            	'id' => $prefix . '_thumbnail',
            	'type' => 'select',
				'options' => hana_thumbnail_array(),
        	),
        	array(
            	'name' => esc_html__('Intro Text', 'hana'),
            	'desc' => esc_html__('check to display page content', 'hana'),
            	'id' => $prefix . '_intro',
            	'type' => 'checkbox',
        	),
        	array(
            	'name' => esc_html__('Post Meta :', 'hana'),
            	'desc' => esc_html__('check to display post meta','hana'),
            	'id' => $prefix . '_disp_meta',
            	'type' => 'checkbox',
        	),
    	),
	) );
	$meta_boxes = apply_filters( 'hana_meta_boxes', $meta_boxes );
	
	foreach ( $meta_boxes as $meta_box )
		$box = new Hana_Meta_Box( $meta_box );
}


