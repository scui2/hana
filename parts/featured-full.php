<?php
/**
 * The template to fullwidth featured contents
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
	global $hana_featured_posts, $post;
?>
	<ul class="hanaSlider">
<?php
	foreach ( $hana_featured_posts as $order => $post ) {
		setup_postdata( $post );
?>
		<li class="hana-slide hana-slide-<?php echo $post->ID; ?>">
<?php
			if ( hana_get_video() ) {
				echo hana_get_video();
			}
			elseif ( has_post_thumbnail() )
				the_post_thumbnail( 'full', array( 'class'	=> 'fullwidth-image', 'title' => get_the_title() ) ); ?>
			<div class="featured-caption clearfix">

<?php			if ('post' == get_post_type() )  { ?>
					<h3 class="featured-title">
						<a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
					</h3>
<?php				if ( has_excerpt()) { ?>
						<div class="featured-excerpt">
							<?php the_excerpt( '' ); ?>
						</div>
<?php				} ?>
					<a class="button btn-featured" href="<?php echo get_permalink(); ?>"><?php echo esc_attr( hana_readmore_text() ); ?></a>
<?php			} else { ?>
					<h3 class="featured-title">
						<?php the_title(); ?>
					</h3>
					<div class="featured-page">
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
		'mode' => hana_option( 'slider_mode' ),
		'speed' => hana_option( 'slider_speed' ),	
	);
	wp_localize_script( 'hana', 'hanaSlider', $sliderOption );
	wp_reset_postdata();
?>