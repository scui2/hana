<?php
/**
 * The template to display featured contents as ticker
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
?>
	<ul class="hanaTicker">
<?php
	global $hana_featured_posts, $post;
	
	$width = 0; 
	foreach ( $hana_featured_posts as $order => $post ) {
		setup_postdata( $post ); ?>
			
		<li><a href="<?php echo esc_url( get_permalink() ); ?>">
<?php	if ( has_post_thumbnail() ) { //  Featured Images
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'hana-ticker' );
			if ( $image[1] > $width )
				$width =  $image[1];
					
			the_post_thumbnail( 'hana-ticker', array(  'class' => 'ticker-img', 'title' => get_the_title() ) ); ?>
			<div class="ticker-caption"><?php the_title() ?></div>
<?php	} else { // No Featured Images  ?>
			<h3 class="entry-title">
				<?php the_title(); ?>
			</h3>
<?php	} ?>
		</a></li>
<?php
	} ?>
	</ul>
<?php
	if ( 0 == $width )
		$width = 255;
	$tickerOption = array (
			'minSlides' => hana_option( 'ticker_min' ),
			'maxSlides' => hana_option( 'ticker_max' ),
			'slideWidth' =>  $width,
			'speed' =>  hana_option( 'slider_speed' ),
	);
	wp_localize_script( 'hana', 'hanaTicker', $tickerOption ); 
	wp_reset_postdata();
?>
