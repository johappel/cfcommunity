<?php
// Exit if accessed directly
if ( ! defined( 'WPINC' ) ) exit;

/**
 * Get the rss feed data and display it
 */
class BPRF_Feed {

    public $source;
    public $source_id;

    // Some RSS data
    public $rss;
    public $items = array();
    public $maxitems = 0;

    public $title;
    public $link;

    // RSS images upload dir
    public $upload_dir;

    function __construct($url, $source){
        $bp = buddypress();

        switch($source){
            case $bp->groups->id:
                $this->source = $bp->groups->id;
                $this->source_id = bp_get_current_group_id();
                break;

            case $bp->members->id:
                $this->source = $bp->members->id;
                $this->source_id = bp_displayed_user_id();
                break;
        }

        $this->upload_dir = BPRF_UPLOAD_DIR.'/'.$this->source.'/'.$this->source_id;

        include_once( ABSPATH . WPINC . '/feed.php' );

        add_filter( 'wp_feed_cache_transient_lifetime', 'bprf_feed_cache_lifetime', 10, 2 );

            $this->rss = fetch_feed( $url );

        remove_filter( 'wp_feed_cache_transient_lifetime', 'bprf_feed_cache_lifetime', 10, 2 );

        $this->save();

        // Checks that the object is created correctly
        if ( ! is_wp_error( $this->rss ) ) {

            // Figure out how many total items are there, but pass no limit
            $this->maxitems = $this->rss->get_item_quantity( 0 );

            // Build an array of all the items, starting with element 0 (first element).
            $this->items = $this->rss->get_items( 0, $this->maxitems );

            /**
             * Will be saved on per activity item basis
             */
            // name of a site
            $this->title = $this->rss->get_title();
            // ..and its link
            $this->link  = $this->rss->get_link();

            return $this->rss;
        } else {
            return $this->get_feed_meta();
        }
    }

    /**
     * In case we are our of source - display local feed
     * @return object
     */
    function get_feed_meta(){
        $meta = groups_get_groupmeta(bp_get_current_group_id(), 'bprf_feed_meta');

        if(!isset($meta['title'])){
            $meta['title'] = '';
        }
        if(!isset($meta['link'])){
            $meta['link'] = '';
        }

        $meta['local'] = true;

        return (object) $meta;
    }

    /**
     * We need to save all the RSS items into the activity feed
     */
    function save(){
        global $bp;

        if ( ! is_wp_error( $this->rss ) ) {

            // save feed title and link
            if ( bp_is_group() ) {
                groups_update_groupmeta(
                    $bp->groups->current_group->id,
                    'bprf_feed_meta',
                    array(
                        'title' => $this->rss->get_title(),
                        'link'  => $this->rss->get_link()
                    )
                );
            }else if( bp_is_user() ) {
                bp_update_user_meta(
                    bp_displayed_user_id(),
                    'bprf_feed_meta',
                    array(
                        'title' => $this->rss->get_title(),
                        'link'  => $this->rss->get_link()
                    )
                );
            }

            $bprf = bp_get_option('bprf');

            // retrieve only defined amount of RSS items
            $this->maxitems = $this->rss->get_item_quantity( $bprf['rss']['posts'] );

            // Build an array of all the items, starting with element 0 (first element).
            $this->items = $this->rss->get_items( 0, $this->maxitems );

            foreach($this->items as $item){
                /** @var $item SimplePie_Item */
                $item_time = strtotime($item->get_date());

                // ignore already saved items based on time published
                // dunno better solution
                if ( bp_activity_get_activity_id( array( 'secondary_item_id' => $item_time ) ) ) {
                    continue;
                }

                // prepare content to be stored in activity feed

                $image_src = '';

                $content = wp_trim_words($item->get_content(), $bprf['rss']['excerpt']);

                if ($bprf['rss']['image'] == 'display_remote' || $bprf['rss']['image'] == 'display_local') {
                    switch($bprf['rss']['image']){
                        case 'display_local':
                            $image_src = $this->get_save_item_image( $item );
                            break;
                        case 'display_remote':
                            $image_src = $this->get_item_image( $item->get_content() );
                            break;
                    }
                    if ( !empty($image_src) ) {
                        $content = '<a href="'. esc_url( $item->get_permalink() ) .'" class="bprf_feed_item_image">' .
                            '<img src="'. $image_src .'" alt="'. esc_html( $item->get_title() ) .'" />' .
                            '</a>' . $content;
                    }
                }

                $item_link = '<a href="'. esc_url( $item->get_permalink() ) .'" '. ($bprf['rss']['nofollow'] == 'yes' ? 'rel="nofollow"' : '') .' class="bprf_feed_item_title">'. $item->get_title() . '</a>';
                $user_id = false;
                $action  = $bp_link = $component = '';
                if ( bp_is_group() ) {
                    $component = buddypress()->groups->id;
                    $bp_link = '<a href="' . bp_get_group_permalink( $bp->groups->current_group ) . '" class="bprf_feed_group_title">' . esc_attr( $bp->groups->current_group->name ) . '</a>';
                    $action  = sprintf(__( 'New RSS post %1$s was shared in %1$s', 'bprf' ), $item_link, $bp_link);
                } else if ( bp_is_user() ) {
                    $component = 'activity';
                    $user_id   = bp_displayed_user_id();
                    $bp_link   = bp_core_get_userlink( bp_displayed_user_id() );
                    $action    = sprintf(__( '%1$s shared a new RSS post %2$s', 'bprf' ), $bp_link, $item_link);
                }

                // TODO: clear cache for counter
                // save all the results with resulting activity ID
                $activity_id = bprf_record_profile_new_feed_item_activity( array(
                    'user_id'           => $user_id,
                    'action'            => $action, // for backward compatibility
                    'content'           => $content,
                    'component'         => $component,
                    'type'              => $component . '_rss_item',
                    'primary_link'      => $item->get_permalink(),
                    'item_id'           => $this->source_id,
                    'secondary_item_id' => $item_time,
                    'recorded_time'     => date('Y-m-d h:i:s', $item_time),
                    'hide_sitewide'     => false
                ) );

                // need to save links to the feed item in a non-natural way
                bp_activity_update_meta( $activity_id, 'bprf_title_links', array(
                    'item'   => $item_link,
                    'source' => $bp_link
                ));
            }
        }
    }

    /**
     * Parse the text and find the first image which is basically a featured image in most cases
     */
    function returnImage ($text) {
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        $pattern = '/<img[^>]+\>/i';
        preg_match($pattern, $text, $matches);
        if(!empty($matches) && is_array($matches)){
            $text = $matches[0];
        }
        return $text;
    }
    function get_item_image($text) {
        $text = $this->returnImage($text);

        $pattern = '/src=[\'"]?([^\'" >]+)[\'" >]/';
        preg_match($pattern, $text, $link);
        if(!empty($link) && is_array($link)) {
            $link = $link[1];
            $link = urldecode( $link );
            return $link;
        }
        return false;
    }

    /**
     * We need to parse the text, find the image and save it locally, so no hotlinking will be used
     * If we have error on saving - revert back to the original image, silently
     *
     * @param  object $item
     * @return string URL of an image
     */
    function get_save_item_image($item){
        $remote_img_url = $this->get_item_image($item->get_content());
        if(empty($remote_img_url)){
            return false;
        }

        $ext            = bprf_get_file_extension_by_type(exif_imagetype($remote_img_url));
        $file_name      = strtotime($item->get_date());
        $upload_dir     = wp_upload_dir();

        $uploaded_dir     = $upload_dir['basedir'] . '/' . $this->upload_dir;
        // create folders if we don't have them
        if ( ! wp_mkdir_p($uploaded_dir) ) {
            // failed creating a dir - permissions?
            return $remote_img_url;
        }

        $uploaded_file    = '/' . $file_name . '.' . $ext;
        $upload_file_path = $uploaded_dir . $uploaded_file;

        $image = file_get_contents($remote_img_url);
        if ( ! file_put_contents($upload_file_path, $image) ) {
            // we have an error, role back to the hotlinking
            return $remote_img_url;
        }

        return $upload_dir['baseurl'] .  '/' . $this->upload_dir . '/' . $uploaded_file;
    }

    function get_item_date_format($delimiter = ' @ '){
        $item_date = get_option('date_format');
        $item_time = get_option('time_format');

        return $item_date . $delimiter . $item_time;
    }

}