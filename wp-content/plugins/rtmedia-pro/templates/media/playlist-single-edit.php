<div class="rtmedia-container rtmedia-single-container row rtmedia-media-edit">


    <?php if (have_rtmedia()) : rtmedia(); ?>

	<?php

            if(rtmedia_edit_allowed ()) {
                global $rtmedia_media;
                ?>
            <div class="rtmedia-single-edit-title-container">
                <h2 class="rtmedia-title"><?php echo __ ( 'Edit Playlist : ' , 'rtmedia' ) . $rtmedia_media->media_title ; ?></h2>
            </div>



            <form method="post" action="" name="rtmedia_media_single_edit" id="rtmedia_media_single_edit">
                <div class="rtmedia-editor-main columns large-12 small">
                        <dl class="tabs" data-tab>
                            <dd class="active"><a href="#details-tab"><i class='rtmicon-edit'></i><?php _e('Details', 'rtmedia') ;?></a></dd>
                            <dd class=""><a href="#media-list-tab"><i class='rtmicon-list'></i><?php _e('Media List', 'rtmedia') ;?></a></dd>
                            <!-- use this hook to add title of a new tab-->
                            <?php do_action('rtmedia_add_edit_tab_title', rtmedia_type());?>
                        </dl>
                         <div class="tabs-content">
                             <div class="content active" id="details-tab">
                                 <div class="rtmedia-edit-title">
                                    <label><?php _e('Title : ', 'rtmedia'); ?></label>
                                    <?php rtmedia_title_input(); ?>
                                  </div>
                                  <?php echo rtmedia_edit_media_privacy_ui(); ?>

                                  <div class="rtmedia-editor-description">
                                        <label><?php _e('Description: ', 'rtmedia') ?></label>
                                        <?php

                                                echo rtmedia_description_input( $editor = false);
                                                        RTMediaMedia::media_nonce_generator(rtmedia_id());
                                        ?>
                                    </div>
                                    <?php do_action('rtmedia_add_edit_fields', rtmedia_type()); ?>
                             </div>
                             
                             <div class="content" id="media-list-tab">
                                 <?php get_playlist_media_list_table(); ?>
                             </div>
                             <?php do_action('rtmedia_add_edit_tab_content', rtmedia_type());?>
                         </div>
                        

                </div>

                <div class="rtmedia-editor-buttons columns large-12 small">

                        <input type="submit" value="<?php _e('Save', 'rtmedia')?>">
                        <a href="<?php rtmedia_permalink(); ?>"><input type="button" value="<?php _e('Back','rtmedia') ?>"></a>

                </div>
				<div class="clear"></div>
           </form>
           <?php // if( rtmedia_delete_allowed() ) { rtmedia_delete_form(); } // delete button removed ?>


            <?php } else {

                ?>

            <p><?php echo __("Oops !! You do not have rights to edit this media","rtmedia"); ?></p>

            <?php } ?>

    <?php else: ?>
        <p><?php echo __("Oops !! There's no media found for the request !!","rtmedia"); ?></p>
    <?php endif; ?>
</div>
