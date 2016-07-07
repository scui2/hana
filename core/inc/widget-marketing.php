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

add_action( 'widgets_init', 'hana_widget_marketing_init' );
function hana_widget_marketing_init() {
	register_widget( 'Hana_Marketing' );
}

class Hana_Marketing extends WP_Widget {
	function __construct() {
		WP_Widget::__construct(
			'widget_hana_marketing',
			__( '(Hana) Marketing', 'hana' ),
			array(
				'classname'   => 'marketing',
				'description' => __( 'Display image/icon, headline and action button', 'hana' ),
			)
		);
	}
	// Widget outputs
	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		$instance = wp_parse_args($instance, $this->widget_defaults());
		extract( $instance, EXTR_SKIP );
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base);

		echo $before_widget; ?>
		<div class="marketing-<?php echo esc_attr($layout); ?>">		
<?php
		  if ( ! empty( $title ) ) {
			echo  $before_title;
			echo esc_html( $title );
			echo $after_title;
		  }
		
		  if ( 'vertical' == $layout) {
			$class1 = $class2 = hana_grid()->column_class( 12, 12, false );
		  } else {
			$class1 = hana_grid()->column_class( 4, 4, false );			
			$class2 = hana_grid()->column_class( 8, 8, false );	
		  } ?>
		  <div class="row">		
			<div class="marketing-logo <?php echo $class1; ?>">
<?php			if ( ! empty( $image ) || ! empty( $icon ) ) {
					if ( ! empty( $action_url ) )
						echo '<a href="' . esc_url( $action_url ) . '">';
					if ( ! empty( $icon ) )
						echo '<i class="marketing-icon fa fa-' . esc_attr( $icon ) . '"></i>';
					else
						echo wp_get_attachment_image( $image, hana_thumbnail_size( $thumbnail ) );
					if ( ! empty( $action_url ) )
						echo '</a>';			
				} ?>
			</div>
			<div class="marketing-text <?php echo $class2; ?>">		
<?php			if ( ! empty( $headline ) )
					echo '<h2>' . esc_attr( $headline ) . '</h2>';
				if ( ! empty( $tagline ) )
					echo do_shortcode( $tagline );
				if ( ! empty( $action_url ) && ! empty( $action_label ) ) {
					echo '<a href="' . esc_url( $action_url );
					$color = $action_color;
					if ( $hollow )
					 $color .= ' hollow';
					echo '" class="marketing-coa button ' . esc_attr( $color ) . '">';
					echo esc_attr( $action_label ) . '</a>';
				} ?>
			</div>
		  </div>
		</div>
<?php
		echo $after_widget;
	}

	// Update options
	function update( $new, $old ) {
		$instance = $old;
		$instance['title'] = strip_tags( $new['title'] );
		$instance['headline'] = wp_kses_stripslashes($new['headline']);
		$instance['tagline'] = wp_kses_stripslashes($new['tagline']);
		$instance['image'] =  $new['image'];
		$instance['icon'] = wp_kses_stripslashes($new['icon']);
		$instance['thumbnail'] = $new['thumbnail'];
		$instance['action_url'] = esc_url_raw($new['action_url']);
		$instance['action_label'] = wp_kses_stripslashes($new['action_label']);
		$instance['action_color'] = wp_kses_stripslashes( $new['action_color'] );
		$instance['hollow'] = absint( $new['hollow'] );		
		$instance['layout'] = $new['layout'];
		
		return $instance;
	}

	function widget_defaults() {
		return array(
			'title' => '',
			'headline' => '',
			'tagline' => '',
			'image' => '',
			'icon' => '',
			'action_url' => '',
			'action_label' => 'Learn More',
			'action_color' => 'primary',
			'hollow' => '',
			'thumbnail' => 'hana-thumb',
			'layout' => 'vertical',
		);
	}

	// Display options
	function form( $instance ) {
		$instance = wp_parse_args( $instance, $this->widget_defaults() );
		echo '<p>' . __( 'Enter FontAwesom icon name or choose an image. Only one of them will be displayed', 'hana') . '</p>';
		hana_widget_field( $this, array ( 'field' => 'title', 'label' => __( 'Title:', 'hana' ) ), $instance['title'] );
		hana_widget_field( $this, array ( 'field' => 'icon', 'label' => __( 'Icon:', 'hana' ) ), $instance['icon'] );
		if ( $instance['image'] )
			echo wp_get_attachment_image( $instance['image'], hana_thumbnail_size( $instance['thumbnail'] ), false, array( 'class' => 'widget-image' ) );
		hana_widget_field( $this, array ( 'field' => 'image', 'label' => '', 'type' => 'media' ), $instance['image'] );
		hana_widget_field( $this, array ( 'field' => 'thumbnail', 'type' => 'select', 'label' => __( 'Image Size:', 'hana' ), 'options' => hana_thumbnail_array(), 'class' => '' ), $instance['thumbnail'] );
		hana_widget_field( $this, array ( 'field' => 'headline', 'label' => __( 'Headline:', 'hana' ) ), $instance['headline'] );
		hana_widget_field( $this, array ( 'field' => 'tagline', 'label' => __( 'Tagline:', 'hana' ), 'type' => 'textarea' ), $instance['tagline'] );
		hana_widget_field( $this, array ( 'field' => 'action_url', 'label' => __( 'Action URL:', 'hana' ), 'type' => 'url' ), $instance['action_url'] );
		hana_widget_field( $this, array ( 'field' => 'action_label', 'label' => __( 'Action Label:', 'hana' ) ), $instance['action_label'] );
		hana_widget_field( $this, array ( 'field' => 'action_color', 'type' => 'select', 'label' => __( 'Action Button Color: ', 'hana' ),
			'options' => array (
				'primary' => __( 'Primary', 'hana' ),
				'secondary' => __( 'Secondary', 'hana' ),
				'alert' => __( 'Alert', 'hana' ),
				'warning' => __( 'Warning', 'hana' ),
				'success' => __( 'Success', 'hana' ) ),
			'class' => '' ), $instance['action_color'] );
		hana_widget_field( $this, array ( 'field' => 'hollow', 'type' => 'checkbox', 'desc' => __( 'Hollow Button', 'hana' ), 'class' => '' ), $instance['hollow'] );
		hana_widget_field( $this, array ( 'field' => 'layout', 'type' => 'select', 'label' => __( 'Layout: ', 'hana' ),
			'options' => array (
				'vertical' => __( 'Vertical', 'hana' ),
				'horizontal' => __( 'Horizontal', 'hana' ) ),
			'class' => '' ), $instance['layout'] );
	}
}
