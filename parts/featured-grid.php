<?php
/**
 * The template to grid width featured contents
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
	global $hana_featured_posts, $post;
?>
	<div class="row"><ul class="hanaSlider">
<?php
	foreach ( $hana_featured_posts as $order => $post ) {
		setup_postdata( $post );
?>
		<li class="hana-slide hana-slide-<?php echo $post->ID; ?>">
<?php
			if ( has_post_thumbnail() )
				the_post_thumbnail( 'full', array( 'class'	=> 'fullwidth-image', 'title' => get_the_title() ) ); ?>
			<div class="featured-caption clearfix">
				<h3 class="featured-title">
					<a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
				</h3>
<?php			if ( has_excerpt()) { ?>
					<div class="featured-excerpt">
						<?php the_excerpt( '' ); ?>
					</div>
<?php			} ?>
				<a class="button btn-featured float-right" href="<?php echo get_permalink(); ?>"><?php echo esc_attr( hana_readmore_text() ); ?></a>
			</div>
		</li>
<?php
	} ?>
	</ul></div>
<?php
	$sliderOption = array (
		'mode' => get_theme_mod( 'slider_mode', 'horizontal' ),
		'speed' => get_theme_mod( 'slider_speed', 10 ),
	);
	wp_localize_script( 'hana-script', 'hanaSlider', $sliderOption );
	wp_reset_postdata();
?>