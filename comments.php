<?php
/**
 * The template for displaying comment form.
 *
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
// No comments and comment is not open
	if ( ! have_comments() && ! comments_open() )
		return;
?>
<button class="hollow secondary button expanded comment-toggle" data-toggle="comments"><?php comments_number( __( 'Leave a Reply', 'hana' ), __( 'Show 1 Comment.', 'hana' ), __( 'Show % Comments', 'hana' ) ); ?></button>
<div id="comments" class="comments-area" data-toggler data-animate="hinge-in-from-top slide-out-right">

<?php
	if ( post_password_required() ) { ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'hana' ); ?></p></div>
<?php	return;
	}
	if ( have_comments() ) {
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) {
  	 	// Comments navigate ?>
			<nav id="comment-nav-above" class="site-navigation comment-navigation">
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'hana' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'hana' ) ); ?></div>
			</nav>
<?php 	} ?>
		<ol class="commentlist">
<?php		wp_list_comments( array( 'callback' => 'hana_comment' ) ); ?>
		</ol>

<?php 	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { 		// Comments Navigation  ?>
			<nav id="comment-nav-below" class="site-navigation comment-navigation">
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'hana' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'hana' ) ); ?></div>
			</nav>
<?php 	}
	} 
	comment_form(); ?>
</div>