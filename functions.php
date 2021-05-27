<?php

function crunchify_init() {
    add_filter('comment_form_defaults','crunchify_comments_form_defaults');
}

add_action('after_setup_theme','crunchify_init');

function crunchify_comments_form_defaults($default) {
    unset($default['comment_notes_after']);
    return $default;
}


function custom_comment( $comment, $args, $depth ){
    
    global $current_user;

    ?><li <?php comment_class() ?> id="comment-<?php comment_ID() ?>">
    
    <div class="comments_wrap">
        <div class="comment_area">

            <?php
                $commentAuthorID = $GLOBALS['comment']->user_id;
                $profile_img	= @json_decode(get_user_meta($commentAuthorID, 'profile_image', true));
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

            <div class="comment__text">

                <div class="top">
                    <span class="name"><?php echo $commentname = $GLOBALS['comment']->comment_author; ?></span>
                    <span class="time"><?php echo human_time_diff( strtotime( $comment->comment_date ), current_time( 'timestamp', 1 ) ); ?></span>
                </div>
                
                <p class="comment_info"><?php comment_text() ?></p>
                
                <div class="leave_reply">
                    <?php
                        comment_reply_link(
                            array_merge(
                                $args,
                                array(
                                    'depth'     => $depth,
                                    'max_depth' => $args['max_depth']
                                )
                            )
                        );
                    ?>
                    
                </div>
            </div>

        </div>
    </div>
    <?php
}

function custom_end_comment( $comment, $args, $depth ){
    echo '</li>';
}

add_filter( 'comment_form_defaults', 'wpse33039_form_defaults' );

function wpse33039_form_defaults( $defaults ){
    $defaults['title_reply'] = '';
    return $defaults;
}

add_filter( 'comment_form_defaults', 'my_comment_form_defaults' );

/**
 * Customize the text prior to the comment form fields.
 * @param  array $defaults
 * @return $defaults
 */
function my_comment_form_defaults( $defaults ) {

    $defaults['comment_notes_before'] = null;
    return $defaults;

}

function comment_reply_link_filter($content){
    return '<div class="reply_link-wrapper">' . $content . '</div>';
}

add_filter('comment_reply_link', 'comment_reply_link_filter', 99);
add_filter( 'comment_form_defaults', 'afn_custom_comment_form' );

function afn_custom_comment_form($no_fields) {
    $no_fields['comment_notes_before'] = ''; // Removes comment before notes
    $no_fields['comment_notes_after'] = ''; // Removes comment after notes
    $no_fields['title_reply'] =''; // Remove Title Reply
    return $no_fields;
}

add_filter('the_content', 'add_paragraph_class');

function add_paragraph_class($content){
    $content = str_replace('<p>', '<p class="info_about">', $content);
    return $content;
}