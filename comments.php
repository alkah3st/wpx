<?php
/**
 * The template file for displaying the comments and comment form for the
 * Twenty Twenty theme.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
*/
if ( post_password_required() ) { return; }

?>

<div class="post-comments" id="comments">

	<div class="wrap">

		<?php 
			if ( comments_open() || pings_open() ) {
				comment_form(
					array(
						'class_form'         => '',
						'cancel_reply_link'=>'<i class="icon-cancel"></i>',
						'title_reply_before' => '<p id="reply-title" class="comment-form-title">',
						'title_reply_after'  => '</p>',
						'cancel_reply_before'=>' ',
						'cancel_reply_after'=>' ',
						'title_reply'=>'Leave Comment',
						'title_reply_to'=>'Leave a Comment <span>%s</span>',
						'comment_notes_before'=>'<p class="comment-count">Your Two Cents</p>',
						'comment_notes_after'=>'',
						'fields'=>array(
							'author' => '<input placeholder="Name *" id="author" name="author" type="text" value="'.esc_attr( $commenter['comment_author'] ).'" size="30" required="required" maxlength="245" />',
							'email' => '<input placeholder="Email Address*" id="email" type="text" name="email" required="required" value="'.esc_attr( $commenter['comment_author_email'] ).'" size="30" maxlength="100" aria-describedby="email-notes" />',
							'url' => '<input id="url" name="url" placeholder="Website" type="text" value="'.esc_attr( $commenter['comment_author_url'] ).'" size="30" maxlength="200" />',
						),
						'comment_field'=>'<textarea placeholder="Comment*" id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea>'
					)
				);
			}
		?>

		<?php if ( $comments ) { ?>

			<section class="comment-thread">

				<h1 class="screenreader">Comments on <?php the_title(); ?></h1>

				<?php
				wp_list_comments(
					array(
						'walker'      => new WPX\Comments\WPX_Comment_Walker(),
						'avatar_size' => 120,
						'style'       => 'div',
					)
				);

				$comment_pagination = paginate_comments_links(
					array(
						'echo'      => false,
						'end_size'  => 0,
						'mid_size'  => 0,
						'next_text' => __( 'Newer Comments', 'twentytwenty' ) . ' <span aria-hidden="true">&rarr;</span>',
						'prev_text' => '<span aria-hidden="true">&larr;</span> ' . __( 'Older Comments', 'twentytwenty' ),
					)
				);

				if ( $comment_pagination ) {
					$pagination_classes = '';

					// If we're only showing the "Next" link, add a class indicating so.
					if ( false === strpos( $comment_pagination, 'prev page-numbers' ) ) {
						$pagination_classes = ' only-next';
					}
					?>

					<nav class="comments-pagination pagination<?php echo $pagination_classes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?>" aria-label="<?php esc_attr_e( 'Comments', 'twentytwenty' ); ?>">
						<?php echo wp_kses_post( $comment_pagination ); ?>
					</nav>

					<?php
				}
				?>

			</section>

		<?php } ?>

	</div>

</div>