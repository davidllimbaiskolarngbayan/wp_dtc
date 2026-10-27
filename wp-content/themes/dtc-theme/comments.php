<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 1/17/15
 * Time: 12:17 PM
 */

if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area box-shadow box-comment wow fadeInUp animated">

    <?php // You can start editing here -- including this comment! ?>

    <?php if ( have_comments() ) : ?>
        <h2 class="comments-title">
            <?php
            printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', HATT_TEXTDOMAIN ),
                number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
            ?>
        </h2>

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
            <nav id="comment-nav-above" class="comment-navigation" role="navigation">
                <h1 class="screen-reader-text"><?php _e( 'Comment navigation', HATT_TEXTDOMAIN ); ?></h1>
                <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', HATT_TEXTDOMAIN ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', HATT_TEXTDOMAIN ) ); ?></div>
            </nav><!-- #comment-nav-above -->
        <?php endif; // check for comment navigation ?>

        <ol class="comment-list">
            <?php
            wp_list_comments( array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 74,
                'callback'=>'hatt_comments'
            ) );
            ?>
        </ol><!-- .comment-list -->

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
            <nav id="comment-nav-below" class="comment-navigation" role="navigation">
                <h1 class="screen-reader-text"><?php _e( 'Comment navigation', HATT_TEXTDOMAIN ); ?></h1>
                <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', HATT_TEXTDOMAIN ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', HATT_TEXTDOMAIN ) ); ?></div>
            </nav><!-- #comment-nav-below -->
        <?php endif; // check for comment navigation ?>
        <hr>

    <?php endif; // have_comments() ?>



    <?php
    // If comments are closed and there are comments, let's leave a little note, shall we?
    if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
        ?>
        <p class="no-comments"><?php _e( 'Comments are closed.', HATT_TEXTDOMAIN ); ?></p><hr>
    <?php endif; ?>



<?php
$commenter = wp_get_current_commenter();
$comment_form = array(
    'title_reply'          => have_comments() ? __( 'Add a comment', HATT_TEXTDOMAIN ) : __( 'Be the first to comment', HATT_TEXTDOMAIN ) . ' &ldquo;' . get_the_title() . '&rdquo;',
    'title_reply_to'       => __( 'Leave a Reply to %s', HATT_TEXTDOMAIN ),
    'comment_notes_before' => '',
    'fields'               => array(
        'author' => '<div class="row">
							                <div class="form-group">
							                    <div class="col-md-6">' .
            '<input id="author"  name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true"  class="form-control" placeholder="'.__('Name*',HATT_TEXTDOMAIN).'" />
							                     </div>   ',
        'email'  => '<div class="col-md-6">' .
            '<input  placeholder="'.__('Your email address *',HATT_TEXTDOMAIN).'"  class="form-control" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></div>
							                </div>
							                </div><!--End row-->',
    ),
    'label_submit'  => __( 'Post Comment', HATT_TEXTDOMAIN ),
    'logged_in_as'  => '',
    'comment_field' => '<div class="row">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <textarea id="comment" name="comment" cols="40" rows="5" class="form-control" placeholder="'.__('Message',HATT_TEXTDOMAIN).'"></textarea>
                                            </div>
                                        </div>
                                    </div>',
    'comment_notes_after'=>''
);
comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
?>

</div><!-- #comments -->
