<?php
/**
 * Core Admin Functions
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
if ( ! defined('ABSPATH') ) exit;

function hana_meta_boxes() {
	$prefix = apply_filters( 'hana_meta_box_prefix', '_hana');	
	$meta_boxes = array(
	
	'page' => array( 
		'id' => 'hana-page-meta',
		'title' => __('Template Options', 'hana'), 
		'type' => 'page',
		'context' => 'side',  //normal, advaned, side  
		'priority' => 'default', //high, core, default, low
		'fields' => array(
        	array(
            	'name' => __( 'Post Category :' ,'hana'),
            	'desc' => '',
            	'id' => $prefix . '_category',
            	'type' => 'select',
				'options' => hana_category_choices( 'metaall' ),
        	),
        	array(
            	'name' => __( 'Posts per page/load :', 'hana' ),
            	'desc' => '',
            	'id' => $prefix . '_postperpage',
            	'type' => 'number',
        	),
			array(
            	'name' => __('Sidebar :', 'hana'),
            	'desc' => __('check to display sidebar','hana'),
            	'id' => $prefix . '_sidebar',
            	'type' => 'checkbox',
        	),
        	array(
            	'name' => __('Layout :', 'hana'),
            	'desc' => __('Columns','hana'),
            	'id' => $prefix . '_column',
            	'type' => 'select',
				'options' => array( 
					'1' => '1',
					'2' => '2',
					'' 	=> '3',	// Default
					'4'	=> '4' ),
        	),
        	array(
            	'name' => __('Image Size : ', 'hana'),
            	'desc' => '',
            	'id' => $prefix . '_thumbnail',
            	'type' => 'select',
				'options' => hana_thumbnail_array(),
        	),
        	array(
            	'name' => __('Intro Text', 'hana'),
            	'desc' => __('check to display page content', 'hana'),
            	'id' => $prefix . '_intro',
            	'type' => 'checkbox',
        	),
        	array(
            	'name' => __('Post Meta :', 'hana'),
            	'desc' => __('check to display post meta','hana'),
            	'id' => $prefix . '_disp_meta',
            	'type' => 'checkbox',
        	),
    	),
	),
	'post' => array( 
		'id' => 'hana-post-meta',
		'title' => __('Post Options', 'hana'), 
		'type' => 'post',
		'context' => 'side',  //normal, advaned, side  
		'priority' => 'high', //high, core, default, low
		'fields' => array(
        	array(
            	'name' => __('Read More Label :', 'hana'),
            	'desc' => '',
            	'id' => $prefix . '_readmore',
            	'type' => 'text',
            	'default' => '',
        	),
    	)
	) );
	return apply_filters( 'hana_meta_boxes', $meta_boxes );
}

function hana_add_meta_boxes() {
	$meta_boxes = hana_meta_boxes();
	
	foreach ( $meta_boxes as $meta_box )
		$box = new Hana_Meta_Box( $meta_box );
}
add_action( 'admin_menu', 'hana_add_meta_boxes' );


function hana_load_template_scripts( $hooks ) {
	global $post_type;

	$tmp_path = get_template_directory_uri();	
	if ( 'page' == $post_type ) {
		wp_enqueue_script( 'hana-template', $tmp_path . '/js/template.js', array( 'jquery') );	
	}
	if ( 'widgets.php' == $hooks ) {
		wp_enqueue_style( 'hana-widgets', $tmp_path . '/css/widgets.css', null, '1.0' );	
		wp_enqueue_script( 'hana-widgets', $tmp_path . '/js/widgets.js', array( 'jquery-ui-sortable' ) );			
	}
}
add_action( 'admin_enqueue_scripts', 'hana_load_template_scripts' );

class Hana_Meta_Box {
	protected $_meta_box;

	function __construct( $meta_box ) {
		if ( !is_admin())
			return;

		$this->_meta_box = $meta_box;
		
		add_action( 'add_meta_boxes', array( $this, 'add' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}
	
	function add( $post_type ) {
		$this->_meta_box['context'] = empty($this->_meta_box['context']) ? 'side' : $this->_meta_box['context'];
		$this->_meta_box['priority'] = empty($this->_meta_box['priority']) ? 'default' : $this->_meta_box['priority'];
		$this->_meta_box['type'] = empty($this->_meta_box['type']) ? 'page' : $this->_meta_box['type'];
		if ( $post_type == $this->_meta_box['type'] )
			add_meta_box( $this->_meta_box['id'], $this->_meta_box['title'], array(&$this, 'display'), $this->_meta_box['type'], $this->_meta_box['context'], $this->_meta_box['priority'] );	
	}
	
	function display( $post ) {
		// Use nonce for verification
		echo '<input type="hidden" name="hana_meta_box_nonce" value="', wp_create_nonce( basename( __FILE__ ) ), '" />';
	
		foreach ( $this->_meta_box['fields'] as $field ) {
			$meta = get_post_meta( $post->ID, $field['id'], true);

			if ( 'hidden' != $field['type'] ) {
				$fldid = $field['id'];
				echo '<p id="p' . $fldid . '"><strong>' . $field['name'] . ' </strong>';
			}
			$default = ( isset( $field['default'] ) ? $field['default'] : '' );
			switch ( $field['type'] ) {
				case 'text':
					echo '<input type="text" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . ( $meta ? $meta : $default ) . '" size="20" />';
					break;
				case 'hidden':
					echo '<input type="hidden" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . ( $meta ? $meta : $default ) . '" />';
					break;
				case 'textarea':
					echo '<textarea name="' . $field['id'] . '" id="'. $field['id'] . '" cols="60" rows="4" >' . ( $meta ? $meta : $default ) . '</textarea>' . '<br />' . $field['desc'];
					break;
				case 'number':
					echo '<input type="text" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . ( $meta ? $meta : $default ) . '" size="4" />';
					break;
				case 'select':
					echo '<select name="'. $field['id'] . '" id="'. $field['id'] . '">';
					foreach ( $field['options'] as $key => $label ) {
						echo '<option value="' . $key . '" ' . selected( $key, $meta,  false ) . '>' . $label . '</option>';
					}
					echo '</select> ' . $field['desc'];
					break;
				case 'radio':
					foreach ( $field['options'] as $key => $label ) {
						echo '<label class="description"><input type="radio" name="' . $field['id'] . '" value="' . $key . '"' . checked( $key,  $meta, false ) . ' /> ' . $label . ' </label>';
					}
					break;
				case 'checkbox':
					echo '<label class="description"><input type="checkbox" name="' . $field['id'] . '" id="' . $field['id'] . '" value="1"' . checked( '1', $meta, false ) . ' /> ' . $field['desc'] . '</label>';
					break;
			}
			echo '</p>';
		} //foreach
	}
	
	function save( $post_id ) {
    	//Verify nonce
		if ( ! isset( $_POST['hana_meta_box_nonce'] ) )
			return $post_id;
		if ( ! wp_verify_nonce( $_POST['hana_meta_box_nonce'], basename( __FILE__ ) ) )
       	 return $post_id; 
    	//Check autosave
    	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        	return $post_id;
        	
    	//Check permissions
    	if ( 'page' == $_POST['post_type'] ) {
        	if ( ! current_user_can( 'edit_page', $post_id ) )
            	return $post_id;
    	} elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
       		 return $post_id;
    	}

    	foreach ( $this->_meta_box['fields'] as $field ) {
        	$old = get_post_meta( $post_id, $field['id'], true );
			if ( isset( $_POST[ $field['id'] ] ) ) {
				$new = $_POST[ $field['id'] ];
				switch ( $field['type'] ) {
					case 'number':
						$new = intval( $new );
						break;
					case 'text':
					case 'textarea':
						$new = wp_kses_stripslashes( $new );
						break;
				} 
			}
			else
        		$new = '';			

        	if ( $new && $new != $old )
            	update_post_meta( $post_id, $field['id'], $new );
       		elseif ( '' == $new && $old )
            	delete_post_meta( $post_id, $field['id'], $old );
    	}  
	}
}
