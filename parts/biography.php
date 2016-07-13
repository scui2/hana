<?php
/**
 * The template parts for displaying author biography
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
	if ( ! get_the_author_meta( 'description' )  )
		return; ?>
	<hr class="post-divider">
	<div id="author-info" class="row">
		<div id="author-avatar" class="small-3 columns">		
			<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php printf( __( 'All posts by %s', 'hana' ), esc_attr( get_the_author() ) ); ?>" rel="author">
				<div class="img-circle">
					<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'hana_author_avatar_size', 64 ) ); ?>
				</div>
			</a>
		</div><!-- #author-avatar -->
		<div id="author-description" class=""small-9 columns">
			<h2><?php printf( __( 'About %s', 'hana' ), esc_html( get_the_author() ) ); ?></h2>
			<p><?php the_author_meta( 'description' ); ?></p>
		</div>
	</div>
