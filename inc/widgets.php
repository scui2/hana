<?php
/**
 * Widgets
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
if ( ! defined('ABSPATH') ) exit;

class Hana_Recent_Post extends WP_Widget {
	function __construct() {
		WP_Widget::__construct(
			'hana_recent_post',
			__( '(Hana) Recent Posts', 'hana' ),
			array(
				'classname' => 'hana_recent_post',
				'description' => __( 'Use this widget to list your recent post summary.', 'hana' ),
			)
		);
	}
	// Widget outputs
	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		$instance = wp_parse_args($instance, $this->widget_defaults());
		extract( $instance, EXTR_SKIP );
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base);
					
 		if ( $random_post )
			$sortby = 'rand';
		else
			$sortby = '';
		if ( $sticky_post )
			$sticky = array();
		else
			$sticky = get_option( 'sticky_posts' );
						
		$query_str = array(
			'order' => 'DESC',
			'orderby' => $sortby,
			'posts_per_page' => $number,
			'post_status' => 'publish',
			'post_type' => $posttype,
			'ignore_sticky_posts' => 1,
			'no_found_rows' => 1,
		);
		if ( 'post' == $posttype ) {
			$query_str['category__in'] = $category;
			$query_str['post__not_in'] = $sticky;			
		}
		if ( ! empty( $customquery ) ) {
			$custom_query = wp_parse_args( $customquery, NULL );
			foreach ( $custom_query as $key => $query ) {
				if ( strpos( $key, '__' ) && strpos( $query, ',' ) )
					$query_str[$key] = explode( ',', $query );	
				else
					$query_str[$key] = $query;
			}
		}

		$recent_posts = new WP_Query( $query_str );
		if ( $recent_posts->have_posts() ) :
			echo $before_widget; 

			if ( ! empty( $title ) ) {
				echo $before_title;
				echo esc_attr( $title ); // Can set this with a widget option, or omit altogether
				echo $after_title;			
				if ( ! empty( $category_link ) && $category ) {
					printf( '<a href="%1$s" title="%2$s" class="hana_recent_post_link">%3$s <i class="fa fa-angle-right"></i></a>',
						esc_url( get_category_link( $category ) ) ,
						esc_attr( get_the_category_by_ID( $category ) ),
						esc_attr( $category_link ) );					
				}	
			}

			global $hana_thumbnail, $hana_entry_meta;
			$hana_entry_meta = $entry_meta;			
			$hana_thumbnail = hana_thumbnail_size( $thumbnail );
			$col = 0;
			while ( $recent_posts->have_posts() ) : 
				$recent_posts->the_post();
				$div_class = '';
				if ( $column > 1 && $col == 0 )
					echo '<div class="row">';
				if ($column == 2) {
					$div_class = "large-6 medium-6 columns";
					$col = $col + 1;
					if ($col == 2)
						$col = 0;
				}
				elseif ($column == 3) {
					$div_class = "large-4 medium-4 columns";
					$col = $col + 1;
					if ($col == 3)
						$col = 0;
				}
				elseif ($column == 4) {
					$div_class = "large-3 medium-3 columns";
					$col = $col + 1;
					if ($col == 4)
						$col = 0;
				}

				if  ($column > 1)
					echo '<div class="' . $div_class .'">';
				get_template_part( 'parts/content', 'widget' );
				
				if  ($column > 1) {
					echo '</div>';				
					if ($col == 0)
						echo '</div>';
				}
			endwhile;
			
			if ( $col > 0 )
				echo '</div>';
			echo $after_widget;
			// Reset the post globals as this query will have stomped on it
			wp_reset_postdata();
		endif;
	}

	// Update options
	function update( $new, $old ) {
		$instance = $old;
		$instance['title'] = strip_tags( $new['title'] );
		$instance['number'] = (int) $new['number'];
		$col = (int) $new['column'];
		if ($col > 4)
			$col = 4;
		if ($col <1 )
			$col = 1;
		$instance['column'] = $col;
		$instance['posttype'] = $new['posttype'];	
		$instance['customquery'] = wp_kses_stripslashes( $new['customquery'] );
		$instance['category'] =  (int) $new['category'];
		$instance['sticky_post'] =  (int) $new['sticky_post'];
		$instance['random_post'] =  (int) $new['random_post'];
		$instance['entry_meta'] =  (int) $new['entry_meta'];
		$instance['category_link'] =  strip_tags($new['category_link']);
		$instance['thumbnail'] = $new['thumbnail'];

		return $instance;
	}
	
	function widget_defaults() {
		return array(
			'title' => '',
			'posttype' => 'post',
			'number' => '10',
			'category' => '0',
			'sticky_post' => '0',
			'random_post' => '0',
			'column' => '1',
			'thumbnail' => '1',
			'entry_meta' => '0',
			'category_link' => '',
			'customquery' => '',
		);
	}
	// Display options
	function form( $instance ) {
		$instance = wp_parse_args($instance, $this->widget_defaults());

		hana_widget_field( $this, array ( 'field' => 'title', 'label' => __( 'Title:', 'hana' ) ), $instance['title'] );
		hana_widget_field( $this, array ( 'field' => 'posttype', 'type' => 'select', 'label' => __( 'Post Type:', 'hana' ), 'options' => hana_post_types(), 'class' => '' ), $instance['posttype'] );
		hana_widget_field( $this, array ( 'field' => 'number', 'type' => 'number', 'label' => __( 'Number of posts to show:', 'hana' ),  'class' => '' ), $instance['number'] );
		hana_widget_field( $this, array ( 'field' => 'random_post', 'type' => 'checkbox', 'desc' => __( 'Random Posts', 'hana' ), 'class' => '' ), $instance['random_post'] );
		hana_widget_field( $this, array ( 'field' => 'column', 'type' => 'number', 'label' => __( 'No of Columns (1-4):', 'hana' ),  'class' => '' ), $instance['column'] );
		hana_widget_field( $this, array ( 'field' => 'category', 'type' => 'select', 'label' => __( 'Category:', 'hana' ), 'label_all' => __( 'All Categories', 'hana' ), 'options' => hana_category_choices() ), $instance['category'] );
		hana_widget_field( $this, array ( 'field' => 'sticky_post', 'type' => 'checkbox', 'desc' => __( 'Include sticky posts in the category', 'hana' ), 'class' => '' ), $instance['sticky_post'] );	
		hana_widget_field( $this, array ( 'field' => 'thumbnail', 'type' => 'select', 'label' => __( 'Thumbnail:', 'hana' ), 'options' => hana_thumbnail_array(), 'class' => '' ), $instance['thumbnail'] );
		hana_widget_field( $this, array ( 'field' => 'entry_meta', 'type' => 'checkbox', 'desc' => __( 'Display post meta', 'hana' ), 'class' => '' ), $instance['entry_meta'] );
		hana_widget_field( $this, array ( 'field' => 'category_link', 'label' => __( 'Single category link : ', 'hana' ), 'class' => '' ), $instance['category_link'] );
		hana_widget_field( $this, array ( 'field' => 'customquery', 'label' => __( 'Custom Query:', 'hana' ) ), $instance['customquery'] );	
	}
}

class Hana_Navigation extends WP_Widget {
	function __construct() {
		WP_Widget::__construct(
			'hana_navigation',
			__( '(Hana) Navigation', 'hana' ),
			array(
				'classname'   => 'hana_navigation',
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
		$id = substr( $widget_id, strlen( $this->id_base ) + 1 );

		$tabs = array();
		if ( $category )
			$tabs[] = array( 'order' => $category,
							 'type'	 => 'category',
							 'name' =>  $category_label );
		if ( $archive )
			$tabs[] = array( 'order' => $archive,
							 'type'	 => 'archive',
							 'name' =>  $archive_label );
		if ( $recent )
			$tabs[] = array( 'order' => $recent,
							 'type'	 => 'recent',
							 'name' =>  $recent_label );
		if ( $tag )
			$tabs[] = array( 'order' => $tag,
							 'type'	 => 'tag',
							 'name' =>  $tag_label );
		if ($menu && $menu_id )
			$tabs[] = array( 'order' => $menu,
							 'type'	 => 'menu',
							 'name' =>  $menu_label );
		if ( $text && ! empty( $textcontent ) )
			$tabs[] = array( 'order' => $text,
							 'type'	 => 'text',
							 'name' =>  $text_label );

		hana_sort_array( $tabs, "order" );

		echo $before_widget; 
		if ( ! empty( $title ) ) {
			echo $before_title;
			echo esc_attr( $title );
			echo $after_title;
		}

		$first = true; ?>
		<ul class="tabs" data-tabs id="hana-tab-<?php echo $id;?>">
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
				$cat_args['show_count'] = $showcount;
				$cat_args['title_li'] = '';
				$cat_args['exclude'] = 1;
				wp_list_categories( $cat_args );		
				echo '</ul></div>';		
				break;
			  case 'archive':
				echo '<div class="widget_archive"><ul>';
				$arc_args = array();
				$arc_args['type'] = 'monthly';
				$arc_args['show_post_count'] = $showcount;	
				$arc_args['limit'] = $limits;
				wp_get_archives( $arc_args ); 	
							
				echo '</ul></div>';
				break;
			  case 'recent':
				echo '<div class="widget_recent_entries"><ul>';
				
				$rec_args = array();
				$rec_args['numberposts'] = $limits;
				$rec_args['post_status'] = 'publish';
				$recent_posts = wp_get_recent_posts( $rec_args ); 
				foreach( $recent_posts as $recent_post ){
					echo '<li><a href="' . esc_url( get_permalink($recent_post["ID"]) ) . '" title="Look '.esc_attr($recent_post["post_title"]).'" >' . esc_attr( $recent_post["post_title"] ) .'</a> </li> ';
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
				$menu_args['menu'] = $menu_id;
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
		$instance['menu_id'] =  $new['menu_id'];
		$instance['text_label'] =  wp_kses_stripslashes($new['text_label']);
		$instance['textcontent'] =  wp_kses_stripslashes($new['textcontent']);
		$instance['data'] = $new['data'];
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
	}
	if ( $ptag )
		echo '</p>';
}
