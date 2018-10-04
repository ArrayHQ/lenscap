<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package Lenscap
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
?>

<?php
	if ( comments_open() || '0' != get_comments_number() ) {

	if ( post_password_required() ) {
		return;
	}
?>

<div id="comments" class="comments-area">
	<div class="comments-wrap">
		<button class="comments-toggle">
			<?php if ( have_comments() ) { ?>
			<?php
				printf(
					esc_html( _nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments title', 'lenscap' ) ),
					number_format_i18n( get_comments_number() ),
					'<span>' . get_the_title() . '</span>'
				);
			?>
			<?php } else {
				esc_html_e( 'Leave a comment', 'lenscap' );
			} ?>
		</button>

		<?php if ( have_comments() ) : ?>
			<ol class="comment-list">
				<?php
					wp_list_comments( array(
						'style'       => 'ol',
						'short_ping'  => true,
						'avatar_size' => 50,
						'callback'    => 'lenscap_comment'
					) );
				?>
			</ol><!-- .comment-list -->

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
			<nav id="comment-nav-above" class="comment-navigation">
				<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'lenscap' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'lenscap' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'lenscap' ) ); ?></div>
			</nav><!-- #comment-nav-above -->
			<?php endif; // check for comment navigation ?>

		<?php endif; // have_comments() ?>

		<?php
			// If comments are closed and there are comments, let's leave a little note, shall we?
			if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'lenscap' ); ?></p>
		<?php endif; ?>

		<?php comment_form(); ?>
	</div><!-- .comments-wrap -->
</div><!-- #comments -->

<?php } // If comments are open and we have comments ?>
