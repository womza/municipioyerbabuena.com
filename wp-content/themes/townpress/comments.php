<?php $comment_count = get_comment_count( $post->ID ); ?>

<?php if ( $comment_count['approved'] > 0 ) : ?>

    <h3><?php echo sprintf( __( 'Comments (%d)', 'lsvrtheme' ), $comment_count['approved'] ); ?></h3>

    <!-- COMMENT LIST : begin -->
    <ul class="comment-list">

        <?php

        $args = array(
            'walker' => new lsvr_walker_comment,
            'reply_text' => __( 'Reply', 'lsvrtheme' ),
            'avatar_size' => 60,
            'format' => 'html5'
        );
        wp_list_comments( $args );

        $args = array(
            'echo' => false,
            'prev_next' => false,
            'type' => 'list'
        );
        $pagination = paginate_comments_links( $args );
        if ( ! is_null( $pagination ) ) {
            echo '<div class="c-pagination">' . $pagination . '</div>';
        }

        ?>

    </ul>
    <!-- COMMENT LIST : end -->

<?php else: ?>

	<p class="c-alert-message m-info"><i class="ico fa fa-info-circle"></i>
	<?php _e( 'There are no comments yet.', 'lsvrtheme' ); ?>
	</p>

<?php endif; ?>

<!-- COMMENT FORM : begin -->
<div class="respond-form<?php if ( is_user_logged_in() ) { echo ' user-logged-in'; } ?>">

    <?php

    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );

    if ( is_user_logged_in() ) {

        $args = array(
            'id_submit' => 'submit',
            'title_reply' => __( 'Leave a Comment', 'lsvrtheme' ),
            'title_reply_to' => __( 'Leave a reply to %s', 'lsvrtheme' ),
            'cancel_reply_link' => __( 'Cancel', 'lsvrtheme' ),
            'must_log_in' => '<p class="c-alert-message m-info"><i class="ico fa fa-info-circle"></i>' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'lsvrtheme' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
            'logged_in_as' => '<p class="c-alert-message m-info"><i class="ico fa fa-info-circle"></i>' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'lsvrtheme' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>' . '<p style="display: none;" class="c-alert-message m-warning m-validation-error"><i class="ico fa fa-exclamation-circle"></i>' . __( 'Fields with (*) are required!', 'lsvrtheme' ) . '</p>',
            'comment_notes_after' => '<p class="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'lsvrtheme' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>',
            'comment_field' => '<p class="form-row comment-row"><label for="comment">' . __( 'Comment', 'lsvrtheme' ) . ' <span class="required">*</span></label><textarea id="comment" class="required" name="comment" cols="45" rows="8"></textarea></p>',
            'label_submit' => __( 'Post Comment', 'lsvrtheme' )
        );

    }
    else {

        $args = array(

            'id_submit' => 'submit',
            'title_reply' => __( 'Leave a Comment', 'lsvrtheme' ),
            'title_reply_to' => __( 'Leave a reply to %s', 'lsvrtheme' ),
            'cancel_reply_link' => __( 'Cancel', 'lsvrtheme' ),
            'must_log_in' => '<p class="c-alert-message m-info"><i class="ico fa fa-info-circle"></i>' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'lsvrtheme' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
            'logged_in_as' => '<p class="c-alert-message m-info"><i class="ico fa fa-info-circle"></i>' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'lsvrtheme' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
            'comment_notes_before' => '<p class="comment-notes c-alert-message m-info"><i class="ico fa fa-info-circle"></i>' . __( 'Your email address will not be published. Required fields are marked (*).', 'lsvrtheme' ) . '</p>' . '<p style="display: none;" class="c-alert-message m-warning m-validation-error"><i class="ico fa fa-exclamation-circle"></i>' . __( 'Fields with (*) are required!', 'lsvrtheme' ) . '</p>',
            'comment_notes_after' => '<p class="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'lsvrtheme' ), ' <code>' . allowed_tags() . '</code>' ) . '</p></div>',
            'fields' => apply_filters( 'comment_form_default_fields', array(
                'author' => '<div class="form-fields"><p><label for="author">' . __( 'Name', 'lsvrtheme' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label><input id="author"' . ( $req ? ' class="required"' : '' ) . ' name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . '></p>',
                'email' => '<p><label for="email">' . __( 'Email', 'lsvrtheme' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label><input id="email"' . ( $req ? ' class="required email"' : '' ) . ' name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . '></p>',
                'url' => '<p><label for="url">' . __( 'Website', 'lsvrtheme' ) . '</label><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30"></p>' ) ),
            'comment_field' => '<p class="form-row comment-row"><label for="comment">' . __( 'Comment', 'lsvrtheme' ) . ' <span class="required">*</span></label><textarea id="comment" class="required" name="comment" cols="45" rows="8"></textarea></p>',
            'label_submit' => __( 'Post Comment', 'lsvrtheme' )

        );

    }

    // remove legend from comment form
    if (isset($args['comment_notes_after']))
        $args['comment_notes_after'] = '</div>';

    // remove website field
    if (isset($args['fields']['url']))
        unset($args['fields']['url']);

    comment_form( $args );

    ?>
</div>
<!-- COMMENT FORM : end -->