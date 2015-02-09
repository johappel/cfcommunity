<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Register all handlers
 */
function bpgt_admin_page_types(){
    if ( isset($_GET['mode']) ) {
        if ( $_GET['mode'] == 'add_type') {
            bpgt_admin_types_manage('add');
        } elseif( $_GET['mode'] == 'edit_type') {
            $type_id = (isset($_GET['type_id']) && !empty($_GET['type_id'])) ? $_GET['type_id'] : false;
            bpgt_admin_types_manage('edit', $type_id);
        }
    } else {
        bpgt_admin_types_list();
    }
}

/**
 * List all types page
 */
function bpgt_admin_types_list() { ?>
    <style>body {overflow: scroll}</style>

    <div class="wrap">
        <h2>
            <?php _e( 'Group Types', 'bpgt' ); ?>
            <a id="add_group_type" class="add-new-h2" href="?page=bp-groups-types&amp;mode=add_type">
                <?php _e('Add New', 'bpgt'); ?>
            </a>
        </h2>

        <form action="" method="post">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <?php
            $types = new BPGT_Types();
            $types->prepare_items();
            $types->display();
            ?>
        </form>
    </div>
<?php
}

/**
 * Add / Edit pages
 *
 * @param      $type
 * @param bool $type_id
 */
function bpgt_admin_types_manage($type, $type_id = false){
    $cancel = '?page='.BPGT_ADMIN_SLUG;

    if ( $type == 'edit' && is_numeric($type_id) ) {
        $title	= __( 'Edit Group Type', 'bpgt' );
        $action = '?page='.BPGT_ADMIN_SLUG.'&amp;mode=add_type';
        $button	= __( 'Save Changes', 'buddypress' );
        $data   = new BPGT_Type($type_id);
    } else {
        $type   = 'add';
        $title  = __( 'Add New Group Type', 'bpgt' );
        $action	= '';
        $button	= __( 'Create Group Type', 'bpgt' );
        $data   = new BPGT_Type();
    }
    ?>

	<div class="wrap bpgt_admin_page" id="edit_type">
        <h2>
            <?php echo $title; ?>
            <?php if ( !empty($action) ) : ?>
                <a id="add_group_type" class="add-new-h2" href="<?php echo $action; ?>">
                    <?php _e('Add New', 'bpgt'); ?>
                </a>
            <?php endif; ?>
        </h2>

        <?php
        if ( isset($_GET['message']) && !empty($_GET['message']) ) {
            $message_data = bpgt_admin_get_messages_data($_GET['message']);
            echo '<div id="message" class="'. $message_data['class'] .'">'.
                    '<p>'. $message_data['message'] .'</p>'.
                 '</div>';
        }
        ?>

        <p class="description"><?php _e('Fill in the form below with the details about your Group Type in your community. Each group type can have its own name/slug, directory, default avatar and custom group fields.', 'bpgt'); ?></p>
        <p class="description"><?php _e('In addition you can also choose which Group Extensions (for example, bbPress forums) should be available for this group type.'); ?></p>

		<div class="bpgt_debug hidden">
		    <pre>
			    <?php print_r( $data ); ?>
		    </pre>
		</div>

		<form action="" method="post">
            <input type="hidden" value="<?php echo $data->ID; ?>" id="type_id">
            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2">
                    <div id="post-body-content">

                        <!-- Title -->
                        <div id="titlediv">
                            <label class="screen-reader-text" id="title-prompt-text" for=​"title">​<?php _e( 'Name', 'bpgt') ?></label>
                            <input type="text" name="type_title" id="title" value="<?php echo esc_attr( $data->title ); ?>" placeholder="<?php esc_attr_e( 'Name', 'bpgt' ); ?>" />
                        </div>

                        <!-- Associated WordPress page -->
                        <div id="wppagediv">
                            <p>
                                <strong><?php _e('Directory:', 'bpgt'); ?></strong>&nbsp;
                                <?php
                                $pages = get_pages();
                                if ( !empty($pages) ) {
                                    echo '<select name="type_page">';
                                        foreach ($pages as $page) {
                                            echo '<option '.selected($page->ID, $data->page, false).' value="'.$page->ID.'">'.stripslashes($page->post_title).'</option>';
                                        }
                                    echo '</select>';
                                } ?>
                                <span class="description" style="margin-left:10px"><?php _e('Associated WordPress Page with this group type directory.', 'bpgt'); ?></span>
                            </p>
                        </div>

                        <!-- Description -->
                        <div id="postdiv">
                            <div class="postbox">
                                <h3 class="hndle"><?php _e( 'Group Creation Instructions', 'bpgt' ); ?></h3>
                                <div class="inside">
                                    <textarea name="type_description" id="type_description" rows="8" cols="60" placeholder="<?php _e('A short description that tells your users something about this group type', 'bpgt'); ?>"><?php echo esc_textarea( $data->content ); ?></textarea>
                                </div>
                            </div>
                        </div>

	                    <!-- Active Group Plugins -->
	                    <div id="postdiv">
		                    <div class="postbox">
			                    <h3 class="hndle"><?php _e( 'Active Group Plugins for this Group Type', 'bpgt' ); ?></h3>

			                    <div class="inside">
				                    <ul class="bpgt_plugins">
					                    <?php
					                    $type_disabled_plugins = '';
					                    foreach ( bpgt_get_plugins() as $plugin => $plugin_data ) { ?>
						                    <?php
						                    $checked  = '';
						                    $disabled = '';

						                    if ( $plugin == BPGT_PLUGIN_SLUG ) {
							                    $disabled = 'disabled="disabled"';
						                    }
						                    if ( ! in_array( $plugin_data['class'], $data->disabled_plugins ) ) {
							                    $checked = 'checked="checked"';
						                    } else {
							                    $type_disabled_plugins .= $plugin_data['class'] . ',';
						                    }
						                    ?>
						                    <li>
							                    <input type="checkbox" value="<?php echo $plugin_data['class']; ?>" id="<?php echo $plugin_data['class']; ?>" <?php echo $checked; ?> <?php echo $disabled; ?> />
							                    <label for="<?php echo $plugin_data['class']; ?>"><?php echo $plugin_data['name']; ?></label>
						                    </li>
					                    <?php } ?>

					                    <?php do_action( 'bpgt_admin_get_plugins', $data ); ?>
				                    </ul>

				                    <p class="bpgt_debug hidden"><code><?php echo $type_disabled_plugins; ?></code></p>

				                    <input type="hidden" id="type_disabled_plugins" name="type_disabled_plugins" value="<?php echo $type_disabled_plugins; ?>"/>
				                    <script>
					                    jQuery('.bpgt_plugins input').click(function () {
						                    var input = jQuery('#type_disabled_plugins');
						                    if (!jQuery(this).is(':checked')) {
							                    input.val(input.val() + jQuery(this).val() + ',');
						                    } else {
							                    input.val(
								                    input.val().replace(
									                    jQuery(this).val() + ',',
									                    ''
								                    )
							                    );
						                    }
					                    });
				                    </script>
				                    <p class="description"><?php _e( 'Uncheck plugins that you do not want to be active in groups of this type.', 'bpgt' ); ?></p>
			                    </div>
		                    </div>
	                    </div>

                    </div>

                    <div id="postbox-container-1" class="postbox-container">

	                    <!-- Save/Cancel -->
                        <div id="submitdiv" class="postbox">
                            <h3 class="hndle"><?php _e( 'Save', 'bpgt' ); ?></h3>
                            <div class="inside">
                                <div id="submitcomment" class="submitbox">
                                    <div id="major-publishing-actions">
                                        <div id="delete-action">
                                            <a href="<?php echo $cancel; ?>" class="submitdelete deletion"><?php _e( 'Cancel', 'bpgt' ); ?></a>
                                        </div>
                                        <div id="publishing-action">
	                                        <a class="button bpgt_debug_toggle"
	                                           href="#"><?php _e( 'Debug', 'bpgt' ); ?></a>
                                            <input type="submit" name="save_type" value="<?php echo esc_attr( $button ); ?>" class="button-primary"/>
                                        </div>
                                        <input type="hidden" name="type_id" id="type_order" value="<?php echo esc_attr( $data->ID ); ?>" />
                                        <input type="hidden" name="type_order" id="type_order" value="<?php echo esc_attr( $data->order ); ?>" />
                                        <input type="hidden" name="mode" id="mode" value="<?php echo $type; ?>" />
                                        <div class="clear"></div>
	                                    <script>
		                                    jQuery('.bpgt_debug_toggle').click(function (e) {
			                                    e.preventDefault();
			                                    jQuery('.bpgt_debug').toggleClass('hidden');
		                                    });
	                                    </script>
                                    </div>
                                </div>
                            </div>
                        </div>

	                    <!-- Avatar Upload -->
                        <div id="avatardiv" class="postbox">
                            <h3 class="hndle"><?php _e( 'Default Avatar', 'bpgt' ); ?></h3>
                            <div class="inside">
                                <p class="description"><?php _e('It will be used instead of the default BuddyPress image for all new groups of this type.', 'bpgt'); ?></p>
                                <p>
                                    <a href="#" class="button bpgt_type_upload_avatar" data-uploader_title="<?php _e('Group Type Default Avatar', 'bpgt'); ?>">
                                        <?php _e('Select / Upload', 'bpgt'); ?>
                                    </a>&nbsp;
	                                <a href="#"
	                                   class="bpgt_type_upload_avatar_cancel"><?php _e( 'Delete', 'bpgt' ); ?></a>
                                </p>

                                <p class="bpgt_type_avatar_preview <?php echo empty($data->avatar_id)?'hide':'' ?>">
                                    <input type="hidden" name="type_avatar" value="<?php echo esc_attr( $data->avatar_id ); ?>" />
                                    <img src="<?php echo $data->get_avatar_img_src(); ?>" style="width: 100%" alt="" />
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>

    </div>

    <?php
}