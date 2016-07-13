<?php
/**
 * Widgets
 * 
 * @package	hanacore
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
if ( ! defined('ABSPATH') ) exit;

add_action( 'widgets_init', 'hana_widget_navigation_init' );
function hana_widget_navigation_init() {
	register_widget( 'Hana_Navigation' );
}

class Hana_Navigation extends WP_Widget {
	function __construct() {
		WP_Widget::__construct(
			'hana_navigation',
			__( '(Hana) Navigation', 'hana' ),
			array(
				'classname'   => 'navigation',
				'description' => __( 'Tabbed navigation.', 'hana' ),
			)
		);
	}
	// Widget outputs
	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		$instance = wp_parse_args($instance, $this->widget_defaults());
		extract( $instance, EXTR_SKIP );
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base);		
		$id = esc_attr( substr( $widget_id, strlen( $this->id_base ) + 1 ) );

		$tabs = array();
		if ( $category )
			$tabs[] = array( 'order' => esc_attr( $category ),
							 'type'	 => 'category',
							 'name' =>  esc_attr( $category_label ) );
		if ( $archive )
			$tabs[] = array( 'order' => esc_attr( $archive ),
							 'type'	 => 'archive',
							 'name' =>  esc_attr( $archive_label ) );
		if ( $recent )
			$tabs[] = array( 'order' => esc_attr( $recent ),
							 'type'	 => 'recent',
							 'name' =>  esc_attr( $recent_label ) );
		if ( $tag )
			$tabs[] = array( 'order' => esc_attr( $tag ),
							 'type'	 => 'tag',
							 'name' =>  esc_attr( $tag_label ) );
		if ($menu && $menu_id )
			$tabs[] = array( 'order' => esc_attr( $menu ),
							 'type'	 => 'menu',
							 'name' =>  esc_attr( $menu_label ) );
		if ( $text && ! empty( $textcontent ) )
			$tabs[] = array( 'order' => esc_attr( $text ),
							 'type'	 => 'text',
							 'name' =>  esc_attr( $text_label ) );

		hana_sort_array( $tabs, "order" );

		echo $before_widget; 
		if ( ! empty( $title ) ) {
			echo $before_title;
			echo esc_html( $title );
			echo $after_title;
		}

		$first = true; ?>
		<ul class="tabs" data-tabs id="hana-tab-<?php echo $id ;?>">
<?php
		foreach ( $tabs as $tab) {
			if ( $tab['order'] > 0) {
		  		if ( $first ) {
					echo '<li class="tabs-title is-active"><a href="#tab' . $id . '-' . $tab['order'] .  '" aria-selected="true">' . $tab['name'] . '</a></li>';
					$first = false;
				}
				else
					echo '<li class="tabs-title" ><a href="#tab' . $id . '-' . $tab['order'] .  '">' . $tab['name'] . '</a></li>';				
			}
		} ?>
		</ul>
		<div class="tabs-content" data-tabs-content="hana-tab-<?php echo $id;?>">
<?php
		$first = true;
		foreach ( $tabs as $tab) {
		  if ( $tab['order'] > 0) {
		  	if ( $first ) {
				echo '<div class="tabs-panel is-active" id="tab' .  $id . '-' . $tab['order'] . '">';
				$first = false;
			}
		  	else
				echo '<div class="tabs-panel" id="tab' . $id .  '-' . $tab['order'] . '">';
    
			switch ($tab['type']) {
			  case 'category':
				echo '<div class="widget_categories"><ul>';				
				$cat_args = array();
				$cat_args['show_count'] = esc_attr( $showcount );
				$cat_args['title_li'] = '';
				$cat_args['exclude'] = 1;
				wp_list_categories( $cat_args );		
				echo '</ul></div>';		
				break;
			  case 'archive':
				echo '<div class="widget_archive"><ul>';
				$arc_args = array();
				$arc_args['type'] = 'monthly';
				$arc_args['show_post_count'] = esc_attr( $showcount );	
				$arc_args['limit'] = esc_attr( $limits );
				wp_get_archives( $arc_args ); 			
				echo '</ul></div>';
				break;
			  case 'recent':
				echo '<div class="widget_recent_entries"><ul>';
				
				$rec_args = array();
				$rec_args['numberposts'] = esc_attr( $limits );
				$rec_args['post_status'] = 'publish';
				$recent_posts = wp_get_recent_posts( $rec_args ); 
				foreach( $recent_posts as $recent_post ){
					echo '<li><a href="' . esc_url( get_permalink($recent_post["ID"]) ) . '" title="Look '. esc_attr($recent_post["post_title"]).'" >' . esc_attr( $recent_post["post_title"] ) .'</a> </li> ';
				}			
				echo '</ul></div>';
				break;
			  case 'tag':
				echo '<div class="widget_tag_cloud"><ul>';
				
				$tag_args = array();
				wp_tag_cloud( $tag_args ); 			
				echo '</ul></div>';
				break;
			  case 'menu':
				echo '<div class="widget_nav_menu">';				
				$menu_args = array();
				$menu_args['menu'] = esc_attr( $menu_id );
				wp_nav_menu( $menu_args);		
				echo '</div>';	
				break;
			  case 'text':
				echo '<div class="widget_text">';
				echo do_shortcode( $textcontent );	
				echo '</div>';		
				break;
			}
		  	echo '</div>';
		  }
		} ?>		
        </div>
<?php
		echo $after_widget;
		wp_reset_postdata();
	}

	// Update options
	function update( $new, $old ) {
		$instance = $old;
		$instance['title'] = strip_tags( $new['title'] );
		$instance['category'] =  (int) $new['category'];
		$instance['archive'] =  (int) $new['archive'];
		$instance['recent'] =  (int) $new['recent'];
		$instance['tag'] =  (int) $new['tag'];
		$instance['menu'] =  (int) $new['menu'];		
		$instance['text'] =  (int) $new['text'];		
		$instance['showcount'] =  (int) $new['showcount'];
		$instance['limits'] =  (int) $new['limits'];		

		$instance['category_label'] =  wp_kses_stripslashes($new['category_label']);
		$instance['archive_label'] =  wp_kses_stripslashes($new['archive_label']);
		$instance['recent_label'] =  wp_kses_stripslashes($new['recent_label']);
		$instance['tag_label'] =  wp_kses_stripslashes($new['tag_label']);
		$instance['menu_label'] =  wp_kses_stripslashes($new['menu_label']);
		$instance['menu_id'] =  esc_attr( $new['menu_id'] );
		$instance['text_label'] =  wp_kses_stripslashes($new['text_label']);
		$instance['textcontent'] =  wp_kses_stripslashes($new['textcontent']);
		$instance['data'] = wp_kses_stripslashes( $new['data'] );
		$items = array();
		parse_str($instance['data'], $items);

		if ( ! empty( $items['tab'] ) ) {
			$ii = 1;
			foreach( $items['tab'] as $item ) {
				if ( $instance[ $item ] ) {
					$instance[ $item ] = $ii;
					$ii = $ii + 1;
				}
			}
		}			
		return $instance;
	}

	function widget_defaults() {
		return array(
			'title' => '',
			'category' => '2',
			'category_label' => __('Categories','hana'),
			'archive' => '3',
			'archive_label' => __('Archives','hana'),
			'recent' => '1',
			'recent_label' => __('Latest','hana'),
			'tag' => '4',
			'tag_label' => __('Tags','hana'),
			'menu' => '0',
			'menu_label' => __('Menu','hana'),
			'menu_id' => '0',
			'text' => '0',
			'text_label' => __('Text','hana'),
			'showcount' => '1',
			'limits' => '10',
			'textcontent' => '',
			'data' => '',
		);
	}

	// Display options
	function form( $instance ) {
		$instance = wp_parse_args( $instance, $this->widget_defaults() );
		
		$tabs = array(
			array( 'order' => $instance['category'],
						 'type'	 => 'category' ),
			array( 'order' => $instance['archive'],
						 'type'	 => 'archive' ),
			array( 'order' => $instance['recent'],
						 'type'	 => 'recent' ),
			array( 'order' => $instance['tag'],
						 'type'	 => 'tag' ),
			array( 'order' => $instance['menu'],
						 'type'	 => 'menu' ),
			array( 'order' => $instance['text'],
						 'type'	 => 'text' ),
				);
		hana_sort_array($tabs, "order");
		
		hana_widget_field( $this, array ( 'field' => 'title', 'label' => __( 'Title:', 'hana' ) ), $instance['title'] );
		?>
		<ul id="widget-nav-tabs" class="hana-sortable">
<?php
		$data = "";
		foreach( $tabs as $tab ) {
			$data .= 'tab[]=' . $tab['type'] . '&';
			switch ( $tab['type'] ) {
				case 'category':
					if ( $instance['category'] > 0 )
						$flag = 1;
					else
						$flag = 0;						
					echo '<li id="tab_category" ';
					if ( $flag )
						echo 'class="tab-selected"';
					echo '>';	
					hana_widget_field( $this, array ( 'field' => 'category', 'type' => 'checkbox', 'desc' => __( 'Category', 'hana' ), 'ptag' => false, 'class' => 'widget-checkbox' ), $flag );
					hana_widget_field( $this, array ( 'field' => 'category_label', 'type' => 'text', 'ptag' => false, 'class' => '' ), $instance['category_label'] );
					echo '</li>';
					break;
				case 'archive':
					if ( $instance['archive'] > 0 )
						$flag = 1;
					else
						$flag = 0;						
					echo '<li id="tab_archive" ';
					if ( $flag )
						echo 'class="tab-selected"';
					echo '>';
					hana_widget_field( $this, array ( 'field' => 'archive', 'type' => 'checkbox', 'desc' => __( 'Archive', 'hana' ), 'ptag' => false, 'class' => 'widget-checkbox' ), $flag );
					hana_widget_field( $this, array ( 'field' => 'archive_label', 'type' => 'text', 'ptag' => false, 'class' => '' ), $instance['archive_label'] );
					echo '</li>';
					break;
				case 'recent':
					if ( $instance['recent'] > 0 )
						$flag = 1;
					else
						$flag = 0;						
					echo '<li id="tab_recent" ';
					if ( $flag )
						echo 'class="tab-selected"';
					echo '>';
					hana_widget_field( $this, array ( 'field' => 'recent', 'type' => 'checkbox', 'desc' => __( 'Recent', 'hana' ), 'ptag' => false, 'class' => 'widget-checkbox' ), $flag );
					hana_widget_field( $this, array ( 'field' => 'recent_label', 'type' => 'text', 'ptag' => false, 'class' => '' ), $instance['recent_label'] );
					echo '</li>';
					break;
				case 'tag':
					if ( $instance['tag'] > 0 )
						$flag = 1;
					else
						$flag = 0;						
					echo '<li id="tab_tag" ';
					if ( $flag )
						echo 'class="tab-selected"';
					echo '>';
					hana_widget_field( $this, array ( 'field' => 'tag', 'type' => 'checkbox', 'desc' => __( 'Tag', 'hana' ), 'ptag' => false, 'class' => 'widget-checkbox' ), $flag );
					hana_widget_field( $this, array ( 'field' => 'tag_label', 'type' => 'text', 'ptag' => false, 'class' => '' ), $instance['tag_label'] );
					echo '</li>';
					break;
				case 'menu':
					if ( $instance['menu'] > 0 )
						$flag = 1;
					else
						$flag = 0;						
					echo '<li id="tab_menu" ';
					if ( $flag )
						echo 'class="tab-selected"';
					echo '>';
					hana_widget_field( $this, array ( 'field' => 'menu', 'type' => 'checkbox', 'desc' => __( 'Menu', 'hana' ), 'ptag' => false, 'class' => 'widget-checkbox' ), $flag );
					hana_widget_field( $this, array ( 'field' => 'menu_label', 'type' => 'text', 'ptag' => false, 'class' => '' ), $instance['menu_label'] );
					hana_widget_field( $this, array ( 'field' => 'menu_id', 'type' => 'category', 'label' => __( 'Menu:', 'hana' ), 'label_all' => __( 'Select Menu', 'hana' ), 'options' => get_terms('nav_menu'), 'ptag' => true ), $instance['menu_id'] );
					echo '</li>';
					break;
				case 'text':
					if ( $instance['text'] > 0 )
						$flag = 1;
					else
						$flag = 0;						
					echo '<li id="tab_text" ';
					if ( $flag )
						echo 'class="tab-selected"';
					echo '>';
					hana_widget_field( $this, array ( 'field' => 'text', 'type' => 'checkbox', 'desc' => __( 'Text', 'hana' ), 'ptag' => false, 'class' => 'widget-checkbox' ), $flag );
					hana_widget_field( $this, array ( 'field' => 'text_label', 'type' => 'text', 'ptag' => false, 'class' => '' ), $instance['text_label'] );
					echo '</li>';
					break;
			}
		}
		$instance['data'] = $data;
?>		
		</ul>
<?php	hana_widget_field( $this, array ( 'field' => 'limits', 'type' => 'number', 'label' => __( 'Post/Line Limits', 'hana' ),  'class' => '' ), $instance['limits'] );
		hana_widget_field( $this, array ( 'field' => 'showcount', 'type' => 'checkbox', 'desc' => __( 'Show Post Counts', 'hana' ), 'class' => '' ), $instance['showcount'] );
		hana_widget_field( $this, array ( 'field' => 'textcontent', 'type' => 'textarea', 'label' => __( 'Text:', 'hana' ) ), $instance['textcontent'] );
		hana_widget_field( $this, array ( 'field' => 'data', 'type' => 'hidden', 'class' => 'widefat hanadata', 'ptag' => false ), $instance['data'] );		
	}
}
