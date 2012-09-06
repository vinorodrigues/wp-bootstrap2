<?php
/**
 * Implements a custom comment form with HTML5 tags
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
 */ 

/**
 * Outputs a complete commenting form for use within a template.
 *
 * @see comment_form
 * @param array $args Options for strings, fields etc in the form
 * @param mixed $post_id Post ID to generate the form for, uses the current post if null
 * @return void
 */
function bootstrap2_comment_form( $args = array(), $post_id = null ) {
	global $id;

	if ( null === $post_id )
		$post_id = $id;
	else
		$id = $post_id;

	$commenter = wp_get_current_commenter();
	$user = wp_get_current_user();
	$user_identity = $user->exists() ? $user->display_name : '';

	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? ' aria-required="true" required="required"' : '' );
	$fields =  array(
		'author' => '<label class="control-label" for="author">' . __( 'Name', 'bootstrap2' ) . ( $req ? ' <span class="required">*</span>' : ' ' ) . '</label>' .
			'<div class="comment-form-author controls">' .
			'<input class="input-xlarge" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '"' . $aria_req . ' />' .
			'</p>',
		'email' => '<label class="control-label" for="email">' . __( 'Email', 'bootstrap2' ) . ( $req ? ' <span class="required">*</span>' : ' ' ) . '</label>' .
			'<div class="comment-form-email controls">' .
			'<input class="input-xlarge" id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '"' . $aria_req . ' />' .
			'</div>',
		'url' => '<label class="control-label" for="url">' . __( 'Website', 'bootstrap2' ) . ' </label>' .
			'<div class="comment-form-url controls">' .
			'<input class="input-xlarge" id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" />' .
			'</div>',
	);

	$required_text = sprintf( ' ' . __('Required fields are marked %s', 'bootstrap2'), '<span class="required">*</span>' );
	$defaults = array(
		'fields' => apply_filters( 'comment_form_default_fields', $fields ),
		'comment_field' => '<label class="control-label" for="comment">' . _x( 'Comment', 'noun', 'bootstrap2' ) . '</label>' .
			'<div class="comment-form-comment controls">' .
			'<textarea class="input-xlarge" id="comment" name="comment" aria-required="true" required="required" rows="5"></textarea>' .
			'</div>',
		'must_log_in' => '<span class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</span>',
		'logged_in_as' => '<div class="controls"><p class="logged-in-as help-block">' . sprintf( __( 'Logged in as <i class="icon-user"></i> <a href="%1$s">%2$s</a>. <a class="btn btn-danger btn-mini" href="%3$s" title="Log out of this account">Log out</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p></div>',
		'comment_notes_before' => '<div class="controls"><p class="comment-notes help-block">' . __( 'Your email address will not be published.', 'bootstrap2' ) . ( $req ? $required_text : '' ) . '</p></div>',
		'comment_notes_after' => '<div class="controls"><p class="form-allowed-tags help-block"">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'bootstrap2' ), ' <code>' . allowed_tags() . '</code>' ) . '</p></div>',
		'id_form' => 'commentform',
		'id_submit' => 'submit',
		'title_reply' => __( 'Leave a Reply', 'bootstrap2' ),
		'title_reply_to' => __( 'Leave a Reply to %s', 'bootstrap2' ),
		'cancel_reply_link' => __( 'Cancel reply', 'bootstrap2' ),
		'label_submit' => __( 'Post Comment', 'bootstrap2' ),
	);

	$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

	?>
		<?php if ( comments_open( $post_id ) ) : ?>
			<?php do_action( 'comment_form_before' ); ?>
			<div id="respond">
				<?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
					<?php echo $args['must_log_in']; ?>
					<?php do_action( 'comment_form_must_log_in_after' ); ?>
				<?php else : ?>
					<form class="form-horizontal" action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>">
						<fieldset>
						<legend id="reply-title"><?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?> <?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></legend>
						<?php do_action( 'comment_form_top' ); ?>
						<?php if ( is_user_logged_in() ) : ?>
							<div class="control-group"><?php echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity ); ?>
							<?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity ); ?></div>
						<?php else : ?>
							<div class="control-group"><?php echo $args['comment_notes_before']; ?></div>
							<?php
							do_action( 'comment_form_before_fields' );
							foreach ( (array) $args['fields'] as $name => $field ) {
								echo '<div class="control-group">';
								echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
								echo '</div>';
							}
							do_action( 'comment_form_after_fields' );
							?>
						<?php endif; ?>
						<?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
						<div class="control-group"><?php echo $args['comment_notes_after']; ?></div>
						<div class="form-submit form-actions">
							<input class="btn btn-primary" name="submit" type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>" />
							<?php comment_id_fields( $post_id ); ?>
						</div>
						<?php do_action( 'comment_form', $post_id ); ?>
						</fieldset>
					</form>
				<?php endif; ?>
			</div>
			<?php do_action( 'comment_form_after' ); ?>
		<?php else : ?>
			<?php do_action( 'comment_form_comments_closed' ); ?>
		<?php endif; ?>
	<?php
}


function bootstrap2_cancel_comment_reply_link($output) {
	return str_replace('<a ', '<a class="btn btn-danger btn-mini"', $output);
}
add_filter( 'cancel_comment_reply_link', 'bootstrap2_cancel_comment_reply_link' );


/* eof */
