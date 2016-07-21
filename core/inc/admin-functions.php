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
					echo '<input type="text" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . ( $meta ? esc_textarea( $meta ) : $default ) . '" size="20" />';
					break;
				case 'hidden':
					echo '<input type="hidden" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . ( $meta ? esc_textarea( $meta ) : $default ) . '" />';
					break;
				case 'textarea':
					echo '<textarea name="' . $field['id'] . '" id="'. $field['id'] . '" cols="60" rows="4" >' . ( $meta ? esc_textarea( $meta ) : $default ) . '</textarea>' . '<br />' . $field['desc'];
					break;
				case 'number':
					echo '<input type="text" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . ( $meta ? intval( $meta ) : $default ) . '" size="4" />';
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

function hana_meta_boxes() {
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
				'options' => hana_columns_choices( true ),
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
	return apply_filters( 'hana_meta_boxes', $meta_boxes );
}

add_action( 'admin_menu', 'hana_add_meta_boxes' );
function hana_add_meta_boxes() {
	$meta_boxes = hana_meta_boxes();
	
	foreach ( $meta_boxes as $meta_box )
		$box = new Hana_Meta_Box( $meta_box );
}

function hana_widget_field( $widget, $args = array(), $value ) {
	$args = wp_parse_args($args, array ( 
		'field' => 'title',
		'type' => 'text',
		'label' => '',
		'desc' => '',
		'class' => 'widefat',
		'options' => array(),
		'label_all' => '',
		'ptag' => true,
		) );
	extract( $args, EXTR_SKIP );

	$field_id =  esc_attr( $widget->get_field_id( $field ) );
	$field_name = esc_attr( $widget->get_field_name( $field ) );
	
	if ( $ptag )
		echo '<p>';
	if ( ! empty( $label ) ) {
		echo '<label for="' . $field_id . '">';
		echo $label . '</label> ';
	}
	switch ( $type ) {
		case 'text':
		case 'hidden':
			echo '<input class="' . $class . '" id="' . $field_id;
			echo '" name="' . $field_name . '" type="' . $type .'" value="';
			echo esc_attr( $value ) . '" />';
			break;
		case 'textarea':
			echo '<textarea class="' . $class . '" id="' . $field_id;
			echo '" name="' . $field_name . '" type="' . $type .'" row="10" col="20">';
			echo esc_textarea( $value ) . '</textarea>';
			break;
		case 'url':
			echo '<input class="' . $class . '" id="' . $field_id;
			echo '" name="' . $field_name . '" type="' . $type .'" value="';
			echo esc_url( $value ) . '" />';
			break;
		case 'number':
			echo '<input class="' . $class . '" id="' . $field_id;
			echo '" name="' . $field_name . '" type="text" size="3" value="';
			echo esc_attr( $value ) . '" />';
			break;
		case 'checkbox':
			echo '<input class="' . $class . '" id="' . $field_id;
			echo '" name="' . $field_name . '" type="' . $type .'" value="1" ';
			echo checked( '1', $value, false ) . ' /> ';
			echo '<label for="' . $field_id . '"> ' . $desc . '</label>';
			break;
		case 'select':
			echo '<select id="' . $field_id . '" name="' . $field_name . '">';
			foreach ( $options as $key => $label ) {
				echo '<option value="' . $key . '" ' . selected( $key, $value, false );
				echo '>' . $label . '</option>';
			}
			echo '</select>';
			break;
		case 'media':
			echo '<input class="media-upload-id" id="' . $field_id;
			echo '" name="' . $field_name . '" type="hidden" value="';
			echo esc_attr( $value ) . '" />';
			echo '<input class="media-upload-btn" id="' . $field_id;
			echo '_btn" name="' . $field_name . '_btn" type="button" value="'. esc_html__( 'Choose Image', 'hana' ) . '">';
			echo '<input class="media-upload-del" id="' . $field_id;
			echo '_del" name="' . $field_name . '_del" type="button" value="'. esc_html__( 'Remove', 'hana' ) . '">';
			break;
	}
	if ( $ptag )
		echo '</p>';
}

add_action( 'admin_enqueue_scripts', 'hana_load_widget_scripts' );
function hana_load_widget_scripts( $hooks ) {
	global $post_type;

	if ( 'widgets.php' == $hooks ) {
		wp_enqueue_media();
		wp_enqueue_style( 'hana-widgets', HANA_CORE_URI . 'css/widgets.css', null, '1.0' );	
		wp_enqueue_script( 'hana-widgets', HANA_CORE_URI . 'js/widgets.js', array( 'jquery-ui-sortable' ) );			
	}
}
