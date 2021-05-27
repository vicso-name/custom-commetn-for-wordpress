<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package vicso
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
    <div class="comment__form-wrapper">
        <?php
            $user_id      = get_current_user_id();
            $profile_img	= @json_decode(get_user_meta($user_id, 'profile_image', true));
            $profile_img  = !$profile_img ? '' : $profile_img;

            if ( is_user_logged_in() ) {
                $user_avatar = $profile_img->thumb;
            }else {
                $user_avatar = 'http://localhost:3000/vicso/wp-content/uploads/2021/05/user.png';
            }
            if($user_avatar == ""){
                $user_avatar = 'http://localhost:3000/vicso/wp-content/uploads/2021/05/user.png';
            }
        ?>
        <img src="<?php echo  $user_avatar; ?>" alt="user_avatar">
        <?php
        $comment_send = 'Send';
        $comments_args = array(
            'label_submit' => __( $comment_send ),
            'class_form' => 'review_form',
            'fields' => null,
            'comment_field' => '<p class="comment-form-comment"> <textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="Your Comment"></textarea></p>',
            'submit_field' => '%1$s %2$s'
        );

        comment_form($comments_args);

    echo '</div>';

    if ( have_comments() ) : 
		?>

			<ol class="comment-list">
				<?php
					wp_list_comments(
						array(
							'style'      => 'ol',
							'short_ping' => true,
							'callback' => 'custom_comment',
							'end-callback' => 'custom_end_comment'
						)
					);
				?>
			</ol>

		<?php
    endif;

    ?>
</div>
