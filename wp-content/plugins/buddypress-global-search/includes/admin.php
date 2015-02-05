<?php
/**
 * @package WordPress
 * @subpackage BuddyPress Global Search
 */
// Exit if accessed directly
if (!defined('ABSPATH'))
	exit;

if (!class_exists('BuddyBoss_Global_Search_Admin')):

	/**
	 *
	 * BuddyPress Global Search Admin
	 * ********************
	 *
	 *
	 */
	class BuddyBoss_Global_Search_Admin {
		/* Options/Load
		 * ===================================================================
		 */

		/**
		 * Plugin options
		 *
		 * @var array
		 */
		public $options = array();

		/**
		 * Empty constructor function to ensure a single instance
		 */
		public function __construct() {
			// ... leave empty, see Singleton below
		}

		/* Singleton
		 * ===================================================================
		 */

		/**
		 * Admin singleton
		 *
		 * @since 1.0.0
		 *
		 * @param  array  $options [description]
		 *
		 * @uses BuddyBoss_Global_Search_Admin::setup() Init admin class
		 *
		 * @return object BuddyBoss_Global_Search_Admin
		 */
		public static function instance() {
			static $instance = null;

			if (null === $instance) {
				$instance = new BuddyBoss_Global_Search_Admin();
				$instance->setup();
			}

			return $instance;
		}

		/* Utility functions
		 * ===================================================================
		 */

		/**
		 * Get option
		 *
		 * @since BuddyPress Global Search (1.0.0)
		 *
		 * @param  string $key Option key
		 *
		 * @uses BuddyBoss_Global_Search_Plugin::option() Get option
		 *
		 * @return mixed      Option value
		 */
		public function option($key) {
			$value = buddyboss_global_search()->option($key);
			return $value;
		}

		/* Actions/Init
		 * ===================================================================
		 */

		/**
		 * Setup admin class
		 *
		 * @since BuddyPress Global Search (1.0.0)
		 *
		 * @uses buddyboss_global_search() Get options from main BuddyBoss_Global_Search_Plugin class
		 * @uses is_admin() Ensures we're in the admin area
		 * @uses curent_user_can() Checks for permissions
		 * @uses add_action() Add hooks
		 */
		public function setup() {
			if ((!is_admin() && !is_network_admin() ) || !current_user_can('manage_options')) {
				return;
			}

			$actions = array(
				'admin_init',
				'admin_menu',
				'network_admin_menu'
			);

			foreach ($actions as $action) {
				add_action($action, array($this, $action));
			}
		}

		/**
		 * Register admin settings
		 *
		 * @since 1.0.0
		 *
		 * @uses register_setting() Register plugin options
		 * @uses add_settings_section() Add settings page option sections
		 * @uses add_settings_field() Add settings page option
		 */
		public function admin_init() {
			register_setting( 'buddyboss_global_search_plugin_options', 'buddyboss_global_search_plugin_options', array($this, 'plugin_options_validate'));
			add_settings_section( 'general_section', __( 'General Settings', 'buddypress-global-search' ), array($this, 'section_general'), __FILE__);
			//add_settings_section( 'style_section', 'Style Settings', array( $this, 'section_style' ), __FILE__ );
			//general options
			add_settings_field('items-to-search', __( 'Items To Search', 'buddypress-global-search' ), array($this, 'setting_items_to_search'), __FILE__, 'general_section');
			add_settings_field('enable-ajax-search', __( 'AutoSuggest', 'buddypress-global-search' ), array($this, 'setting_enable_ajax_search'), __FILE__, 'general_section');
		}

		/**
		 * Add plugin settings page
		 *
		 * @since BuddyPress Global Search (1.0.0)
		 *
		 * @uses add_options_page() Add plugin settings page
		 */
		public function admin_menu() {
			add_options_page('BP Global Search', 'BP Global Search', 'manage_options', __FILE__, array($this, 'options_page'));
		}

		/**
		 * Add plugin settings page
		 *
		 * @since BuddyPress Global Search (1.0.0)
		 *
		 * @uses BuddyBoss_Global_Search_Admin::admin_menu() Add settings page option sections
		 */
		public function network_admin_menu() {
			return $this->admin_menu();
		}

		/* Settings Page + Sections
		 * ===================================================================
		 */

		/**
		 * Render settings page
		 *
		 * @since 1.0.0
		 *
		 * @uses do_settings_sections() Render settings sections
		 * @uses settings_fields() Render settings fields
		 * @uses esc_attr_e() Escape and localize text
		 */
		public function options_page() {
			?>
			<div class="wrap">
				<h2><?php _e( 'BuddyPress Global Search', 'buddypress-global-search' ); ?></h2>
				<div class="updated fade">
					<p><?php _e( 'Need BuddyPress customizations?', 'buddypress-global-search' ); ?>  &nbsp;<a href="http://buddyboss.com/buddypress-developers/" target="_blank"><?php _e( 'Say hello.', 'buddypress-global-search' ); ?></a></p>
				</div>
				<div class="content-wrapper clearfix">
					<div class="settings">
						<div class="padder">
							<form action="options.php" method="post">
								<?php settings_fields('buddyboss_global_search_plugin_options'); ?>
								<?php do_settings_sections(__FILE__); ?>

								<p class="submit">
									<input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
								</p>
							</form>
						</div>
					</div>
					<div style="clear: both"></div>
				</div>
			</div>
			<?php
		}

		/**
		 * General settings section
		 *
		 * @since BuddyPress Global Search (1.0.0)
		 */
		public function section_general() {
			
		}

		/**
		 * Style settings section
		 *
		 * @since BuddyPress Global Search (1.0.0)
		 */
		public function section_style() {
			
		}

		/**
		 * Validate plugin option
		 *
		 * @since 1.0.0
		 */
		public function plugin_options_validate($input) {
			if( !isset( $input['enable-ajax-search'] ) || !$input['enable-ajax-search'] )
				$input['enable-ajax-search'] = 'no';

			return $input; // return validated input
		}

		/* Settings Page Options
		 * ===================================================================
		 */
		
		/**
		 * Setting > Whether to have autosuggest search dropdown
		 *
		 * @since 1.0.3
		 *
		 * @uses BuddyBoss_Global_Search_Admin::option() Get plugin option
		 */
		public function setting_enable_ajax_search(){
			$enabled = $this->option('enable-ajax-search');
			$checked = $enabled=='yes' ? ' checked' : '';
			echo '<label><input type="checkbox" name="buddyboss_global_search_plugin_options[enable-ajax-search]" value="yes" '. $checked . '>' . __( 'Enable AutoSuggest dropdown in search inputs.', 'buddypress-global-search' ) . '</label>';
		}
		
		/**
		 * Setting > what to search?
		 *
		 * @since 1.0.0
		 *
		 * @uses BuddyBoss_Global_Search_Admin::option() Get plugin option
		 */
		public function setting_items_to_search() {
			$items_to_search = $this->option('items-to-search');

			echo '<p class="description">' . __('Search the following components:', 'buddypress-global-search') . '</p><br />';
			
			$items = array(
				'posts'		=> __( 'Blog Posts', 'buddypress-global-search' ),
				'members'	=> __( 'Members', 'buddypress-global-search' ),
			);
			
			//forums?
			if ( is_plugin_active( 'bbpress/bbpress.php' ) ) {
				$items['forums'] = __( 'Forums', 'buddypress-global-search' );
			}
			
			//other buddypress components
			$bp_components = array(
				'groups'		=> __( 'Groups', 'buddypress-global-search' ),
				'activity'		=> __( 'Activity', 'buddypress-global-search' ),
				'messages'		=> __( 'Messages', 'buddypress-global-search' ),
				/* should we search notifications as well?
				'notifications'	=> __( 'Notifications', 'buddypress-global-search' ), */
			);
			//only the active ones please!
			foreach( $bp_components as $component=>$label ){
				if( bp_is_active( $component ) ){
					$items[$component] = $label;
				}
			}
			
			//now print those items
			foreach( $items as $item=>$label ){
				$checked = !empty( $items_to_search ) && in_array( $item, $items_to_search ) ? ' checked' : '';
				echo "<label><input type='checkbox' value='{$item}' name='buddyboss_global_search_plugin_options[items-to-search][]' {$checked}>{$label}</label><br>";
			}
			
			/**
			 * Use the action below to add more things in the list of searchable items.
			 * This will just print those new items in admin section. You'll have hook into other actions/filters to actually perform the search.
			 */
			do_action( 'bboss_global_search_settings_items_to_search', $items_to_search );
		}
	}

// End class BuddyBoss_Global_Search_Admin

endif;
?>