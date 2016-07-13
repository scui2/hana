<?php
/**
 * The template for displaying comment form.
 *
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
// No comments and comment is not open
	if ( ! have_comments() && ! comments_open() )
		return;
?>
<button class="hollow secondary button expanded hana-toggle comment-toggle" data-toggle="comments">
	<span class="show-comment"><?php comments_number( __( 'Leave a Reply', 'hana' ), __( 'Show 1 Comment.', 'hana' ), __( 'Show % Comments', 'hana' ) ); ?></span>
	<span class="hide-comment"><?php _e( 'Hide Commeont', 'hana'); ?></span>
</button>
<div id="comments" class="comments-area" data-toggler data-animate="fade-in fade-out">
<?php
	if ( post_password_required() ) { ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'hana' ); ?></p></div>
<?php	return;
	}
	if ( have_comments() ) {
		the_comments_navigation(); ?>
		<ul class="commentlist">
			<?php wp_list_comments( array(
					'short_ping'  => true,
					'avatar_size' => 40 ) ); ?>
		</ul>
<?php	the_comments_navigation();
	} 
	comment_form(); ?>
</div><!-- comments -->
