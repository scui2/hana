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
		setup_postdata( $post );
?>
		<li><a href="<?php the_permalink() ?>">
<?php	if ( has_post_thumbnail() ) { //  Featured Images
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'hana-ticker' );
			if ( $image[1] > $width )
				$width =  $image[1];
			the_post_thumbnail( 'hana-ticker', array(  'class' => 'ticker-img', 'title' =>  esc_attr( the_title_attribute( 'echo=0' ) ) ) );
            the_title( '<div class="ticker-caption">', '</div>' );
        } else { // No Featured Images
			the_title('<h3 class="entry-title">', '</h3>' );			
        } ?>
		</a></li>
<?php
	} ?>
	</ul>
<?php
	if ( 0 == $width )
		$width = 255; //default width if no featured image
	$tickerOption = array (
			'minSlides' => esc_attr( get_theme_mod( 'ticker_min', 2 ) ),
			'maxSlides' => esc_attr( get_theme_mod( 'ticker_max', 5 ) ),
			'slideWidth' =>  esc_attr( $width ),
			'speed' =>  esc_attr( get_theme_mod( 'slider_speed', 10 ) ),
	);
	wp_localize_script( 'hana-script', 'hanaTicker', $tickerOption ); 
	wp_reset_postdata();
?>
