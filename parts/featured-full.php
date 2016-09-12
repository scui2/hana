<?php
/**
 * The template to fullwidth featured contents
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
	global $hana_featured_posts, $post;
?>
	<ul class="hanaSlider">
<?php
	foreach ( $hana_featured_posts as $order => $post ) {
		setup_postdata( $post ); ?>
		<li class="hana-slide hana-slide-<?php the_ID(); ?>">
            <?php hana_media()->the_media( 'full' ); ?>
			<div class="featured-caption clearfix">
<?php			if ( 'post' == get_post_type() ) { ?>
                    <h2 class="featured-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<?php			    if ( has_excerpt() ) { ?>
						<div class="featured-excerpt">
							<?php the_excerpt(); ?>
						</div>
<?php				} ?>
					<a class="button btn-featured" href="<?php the_permalink(); ?>"><?php echo esc_html( apply_filters('hana_learnmore_label', __('Learn More', 'hana') ) ); ?></a>
<?php			} else { ?>
					<div class="featured-excerpt">
						<?php the_content(); ?>
					</div>
<?php			} ?>
			</div>
		</li>
<?php
	} ?>
	</ul>
<?php
	$sliderOption = array (
		'mode' => esc_attr( get_theme_mod( 'slider_mode', 'horizontal' ) ),
		'speed' => esc_attr( get_theme_mod( 'slider_speed', 10 ) ),	
	);
	wp_localize_script( 'hana-script', 'hanaSlider', $sliderOption );
	wp_reset_postdata();
?>
