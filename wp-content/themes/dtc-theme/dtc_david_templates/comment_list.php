<?php
	/**
	 * Created by PhpStorm.
	 * User: me664
	 * Date: 1/17/15
	 * Time: 12:26 PM
	 */
	$GLOBALS['comment'] = $comment;
	/* override default avatar size */
	$args['avatar_size'] = 74;
	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>
		<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', HATT_TEXTDOMAIN ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'unitedthemes' ), '<span class="edit-link"><i class="fa fa-pencil-square-o"></i>', '</span>' ); ?>
		</div>
	<?php else : ?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<div class="comment-avatar">
			<?php if ( 0 != $args['avatar_size'] ) {
				echo get_avatar( $comment, $args['avatar_size'] );
			} ?>
		</div>
		<span class="comment-arrow"></span>

		<div class="comment-body">
			<div class="comment-header">
				<div class="comment-author vcard">
					<?php printf( __( '%s', HATT_TEXTDOMAIN ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) );

					?>
					<?php if ( isset( $comment->user_id ) and $comment->user_id == get_the_author_meta( 'ID' ) ): ?>
						<span class="label label-default"><?php _e( 'Author', HATT_TEXTDOMAIN ) ?></span>
					<?php endif; ?>

				</div>
				<div class="comment-metadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php printf( _x( '%1$s', '1: date', HATT_TEXTDOMAIN ), get_comment_date() ); ?>
						</time>
					</a>
				</div>
			</div>
			<div class="comment-content clearfix">
				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', HATT_TEXTDOMAIN ); ?></p>
				<?php endif; ?>
				<?php comment_text(); ?>
			</div>
			<div class="comment-footer clearfix">
                <span class="reply-link"><i class="fa fa-reply"></i>
	                <?php comment_reply_link( array_merge( $args, array(
		                'add_below' => 'div-comment',
		                'depth'     => $depth,
		                'max_depth' => $args['max_depth']
	                ) ) ); ?>
                </span>
				<?php edit_comment_link( __( 'Edit', HATT_TEXTDOMAIN ), '<span class="edit-link"><i class="fa fa-pencil-square-o"></i>', '</span>' ); ?>
			</div>
			<!-- .reply -->

		</div>

	<?php
	endif;