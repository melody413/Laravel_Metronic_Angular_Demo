<?php
/**
 * The template for displaying comments
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ){
	return;
}

if ( have_comments() || comments_open() ) : ?>
	<div id="comments" class="comments-area">

		<?php if ( have_comments() ) : ?>
			<div id="comments-box" class="container-wrapper">

				<div class="block-head">
					<h3 id="comments-title" <?php tie_box_class() ?>>
						<?php

							$comments_number = get_comments_number();

							if ( $comments_number > 1 ){
								printf( esc_html__( '%s Comments',  TIELABS_TEXTDOMAIN ), get_comments_number_text( '0', '1', '%' ) );
							}
							else {
								esc_html_e( 'One Comment', TIELABS_TEXTDOMAIN );
							}

						?>
					</h3>
				</div><!-- .block-head /-->

				<?php the_comments_navigation(); ?>

				<ol class="comment-list">
					<?php
						wp_list_comments( array(
							'style'       => 'ol',
							'short_ping'  => true,
							'avatar_size' => 70,
						) );
					?>
				</ol><!-- .comment-list -->

				<?php the_comments_navigation(); ?>

			</div><!-- #comments-box -->
		<?php endif; // Check for have_comments(). ?>


		<?php comment_form( array( 'title_reply_before' => '<h3 id="reply-title" '. tie_box_class( 'comment-reply-title', false ) .'>' ) ); ?>

	</div><!-- .comments-area -->

<?php endif; // Check for have_comments() || comments_open() ?>
