<?php
/**
 * The template for displaying comments and comment form.
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
	<span class="show-comment"><?php comments_number( esc_html__( 'Leave a Reply', 'hana' ), esc_html__( 'Show 1 Comment.', 'hana' ), esc_html__( 'Show % Comments', 'hana' ) ); ?></span>
	<span class="hide-comment"><?php esc_html_e( 'Hide Comment', 'hana'); ?></span>
</button>
<div id="comments" class="comments-area" data-toggler data-animate="fade-in fade-out">
<?php
	if ( post_password_required() ) { ?>
		<p class="nopassword"><?php esc_html_e( 'This post is password protected. Enter the password to view the comments.', 'hana' ); ?></p></div>
<?php	return;
	}
	if ( have_comments() ) {
		the_comments_navigation(); ?>
		<ul class="commentlist">
			<?php wp_list_comments( array(
					'short_ping'  => true,
					'avatar_size' => apply_filters( 'hana_comment_avatar_size', 40 ) ) ); ?>
		</ul>
<?php	the_comments_navigation();
	} 
	comment_form(); ?>
</div><!-- comments -->
