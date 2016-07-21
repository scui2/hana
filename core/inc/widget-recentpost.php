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
if ( ! class_exists( 'Hana_Recent_Post' ) ) {

	class Hana_Recent_Post extends WP_Widget {
		function __construct() {
			WP_Widget::__construct(
				'hana_recent_post',
				esc_html__( '(Hana) Advanced Recent Posts', 'hana' ),
				array(
					'classname' => 'recent-post',
					'description' => esc_html__( 'Use this widget to display posts/pages...', 'hana' ),
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
				'posts_per_page' => absint( $number ),
				'post_status' => 'publish',
				'post_type' => esc_attr( $posttype ),
				'ignore_sticky_posts' => 1,
				'no_found_rows' => 1,
			);
			if ( 'post' == $posttype ) {
				$query_str['category__in'] = esc_attr( $category );
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
                    if ( $category ) { // Single Category
						printf( '<a href="%1$s" title="%2$s">%3$s</a>',
							esc_url( get_category_link( $category ) ) ,
							esc_attr( get_the_category_by_ID( $category ) ),
							esc_html( $title ) );	                        
                    } else {
  		                echo esc_html( $title );                    
                    }
					echo $after_title;
				}

				global $hana_thumbnail, $hana_entry_meta;
				$hana_entry_meta = $entry_meta;			
				$hana_thumbnail = hana_thumbnail_size( $thumbnail );
				$col = 0;
				if ( $column > 1 ) {
					$width = absint( 12 / $column );
					$div_class = hana_grid()->column_class($width, NULL, NULL, false);
				}
				while ( $recent_posts->have_posts() ) : 
					$recent_posts->the_post();
					if ( $column > 1 && $col == 0 )
						echo '<div class="row">';
					
					$col = $col + 1;
					if ( $col == $column )
						$col = 0;
					if  ($column > 1)
						echo '<div class="' . esc_attr( $div_class )  .'">';
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
			$instance['column'] = (int) $new['column'];;
			$instance['posttype'] = esc_attr( $new['posttype'] );	
			$instance['customquery'] = wp_kses_stripslashes( $new['customquery'] );
			$instance['category'] =  (int) $new['category'];
			$instance['sticky_post'] =  (int) $new['sticky_post'];
			$instance['random_post'] =  (int) $new['random_post'];
			$instance['entry_meta'] =  (int) $new['entry_meta'];
			$instance['category_link'] =  strip_tags($new['category_link']);
			$instance['thumbnail'] = esc_attr( $new['thumbnail'] );

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
				'thumbnail' => '',
				'entry_meta' => '0',
				'customquery' => '',
			);
		}
		// Display options
		function form( $instance ) {
			$instance = wp_parse_args($instance, $this->widget_defaults());

			hana_widget_field( $this, array ( 'field' => 'title', 'label' => esc_html__( 'Title:', 'hana' ) ), $instance['title'] );
			hana_widget_field( $this, array ( 'field' => 'posttype', 'type' => 'select', 'label' => esc_html__( 'Post Type:', 'hana' ), 'options' => hana_post_types(), 'class' => '' ), $instance['posttype'] );
			hana_widget_field( $this, array ( 'field' => 'number', 'type' => 'number', 'label' => esc_html__( 'Number of posts to show:', 'hana' ),  'class' => '' ), $instance['number'] );
			hana_widget_field( $this, array ( 'field' => 'random_post', 'type' => 'checkbox', 'desc' => esc_html__( 'Random Posts', 'hana' ), 'class' => '' ), $instance['random_post'] );
			hana_widget_field( $this, array ( 'field' => 'column', 'type' => 'select', 'label' => esc_html__( 'Layout:', 'hana' ),  'options' => hana_columns_choices( false ), 'class' => '' ), $instance['column'] );
			hana_widget_field( $this, array ( 'field' => 'category', 'type' => 'select', 'label' => esc_html__( 'Category:', 'hana' ), 'label_all' => esc_html__( 'All Categories', 'hana' ), 'options' => hana_category_choices() ), $instance['category'] );
			hana_widget_field( $this, array ( 'field' => 'sticky_post', 'type' => 'checkbox', 'desc' => esc_html__( 'Include sticky posts in the category', 'hana' ), 'class' => '' ), $instance['sticky_post'] );	
			hana_widget_field( $this, array ( 'field' => 'thumbnail', 'type' => 'select', 'label' => esc_html__( 'Thumbnail:', 'hana' ), 'options' => hana_thumbnail_array(), 'class' => '' ), $instance['thumbnail'] );
			hana_widget_field( $this, array ( 'field' => 'entry_meta', 'type' => 'checkbox', 'desc' => esc_html__( 'Display post meta', 'hana' ), 'class' => '' ), $instance['entry_meta'] );
			hana_widget_field( $this, array ( 'field' => 'customquery', 'label' => esc_html__( 'Custom Query:', 'hana' ) ), $instance['customquery'] );	
		}
	}

	add_action( 'widgets_init', 'hana_widget_recentpost_init' );
	function hana_widget_recentpost_init() {
		register_widget( 'Hana_Recent_Post' );
	}

}
