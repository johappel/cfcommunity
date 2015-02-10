<?php

function setup_cover_profile_nav(){
    global $bp;
    $profile_link = bp_loggedin_user_domain() . $bp->profile->slug . '/';
    $args = array(
                'name' => __('Profile Cover Photo','cfctranslation'),
                'slug' => 'change-cover',
                'parent_url' => $profile_link,
                'parent_slug' => $bp->profile->slug,
                'screen_function' => 'screen_change_cover',
                'user_has_access'   => ( bp_is_my_profile() || is_super_admin() ),
                'position' => 40
            );
    bp_core_new_subnav_item($args);
}
add_action( 'bp_setup_nav', 'setup_cover_profile_nav' );

function screen_change_cover(){
    global $bp;
    add_action( 'bp_template_title', 'page_title');
    add_action( 'bp_template_content', 'page_content');
    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}

function page_title(){
        echo __('Change your Profile Cover Photo','cfctranslation');
}

function page_content(){?>

        <div id="profile-cover-uploader">
        <?php
        rtmedia_uploader();
        ?>
        </div>
        <span class="small-text"><?php _e('Upload an image you would like to use as your Cover Photo! As soon as you have uploaded your photo you can leave this page!', 'cfctranslation'); ?>  </span>

        <?php
}

function set_featured_after_upload ( $media_id, $file_object, $uploaded ) {
    global $bp;
    if ( $bp->current_action == 'change-cover' ) {
        update_user_meta ( bp_loggedin_user_id(), 'rtmedia_featured_media', $media_id[0] );
    }
}

function setup_coverphoto () {
    if ( !is_admin() ) {
         add_action( 'bp_xprofile_setup_nav', 'setup_cover_profile_nav' );
         add_action( 'rtmedia_after_add_media', 'set_featured_after_upload' );
    }
}
add_action('wp', 'setup_coverphoto');
?>