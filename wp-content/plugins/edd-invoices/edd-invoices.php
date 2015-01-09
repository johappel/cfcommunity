<?php
/**
* Plugin Name: Easy Digital Downloads - Invoices
* Plugin URI: http://www.wpbeginner.com
* Version: 1.0.1
* Author: WPBeginner
* Author URI: http://www.wpbeginner.com
* Description: Display HTML Invoices for EDD
* License: GPL2
*/

/*  Copyright 2014 WPBeginner (email : support@wpbeginner.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
* EDD Invoices Class
* 
* @package EDD
* @subpackage EDD Invoices
* @author Tim Carr, Chris Christoff, Syed Balki, Thomas Griffin
* @version 1.0.1
* @copyright WPBeginner
*/
class EDDInvoices {
    /**
    * Constructor.
    */
    function __construct() {
        // Plugin Details
        $this->plugin = new stdClass;
        $this->plugin->name = 'edd-invoices'; // Plugin Folder
        $this->plugin->displayName = 'Invoices'; // Plugin Name
        $this->plugin->version = '1.0.1';
        $this->plugin->folder = WP_PLUGIN_DIR.'/'.'edd-invoices'; // Full Path to Plugin Folder
        $this->plugin->dirname = plugin_dir_path( __FILE__ );
        $this->plugin->url = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
        $this->settings = get_option('edd_settings');
        
        // Updater
        if( class_exists( 'EDD_License' ) ) {
            $license = new EDD_License( __FILE__, $this->plugin->displayName, $this->plugin->version, 'WPBeginner' );
        }
        
        // Admin Hooks
		add_filter('edd_settings_extensions', array($this, 'adminSettings'), 1, 1);
		
		add_action('plugins_loaded', array( $this, 'loadLanguageFiles' ) );
		add_action('admin_init', array( $this, 'add_page' ) );
	        
        // Add hooks & filters if settings defined
        if ( ! empty( $this->settings['edd-invoices-page'] ) ) {        
	        // Shortcode
	        add_shortcode('edd_invoices', array($this, 'generateInvoice'));
	        
			// Frontend Hooks
			add_action('edd_purchase_history_header_after', array($this, 'purchaseHistoryHeader'));
			add_action('edd_purchase_history_row_end', array($this, 'purchaseHistoryLink'), 1, 2);
			add_action('init', array($this, 'generateInvoiceHTML'));
		}

    }
    
    /**
    * Adds settings to EDD > Settings > Extensions tab
    */
    function adminSettings($settingsArr) {
    	// Settings
		$settingsArr['edd-invoices'.'-settings'] = array(
			'id' 		=> 'edd-invoices'.'-settings',
			'name' 		=> __('Invoices', 'edd-invoices'),
			'desc' 		=> '',
			'type' 		=> 'header',
		); 		
		$settingsArr['edd-invoices'.'-page'] = array(
			'id' 		=> 'edd-invoices'.'-page',
			'name' 		=> __('Invoice Page', 'edd-invoices'),
			'desc' 		=> __('Which Page contains the [edd_invoices] shortcode?', 'edd-invoices'),
			'type' 		=> 'select',
			'options' 	=> edd_get_pages(),
		); 
		$settingsArr['edd-invoices'.'-logo'] = array(
			'id' 		=> 'edd-invoices'.'-logo',
			'name' 		=> __('Logo URL', 'edd-invoices'),
			'type' 		=> 'upload',
			'size' 		=> 'regular',
		); 
		$settingsArr['edd-invoices'.'-company-name'] = array(
			'id' 		=> 'edd-invoices'.'-company-name',
			'name' 		=> __('Company Name', 'edd-invoices'),
			'desc' 		=> __('Company Name shown on Invoices', 'edd-invoices'),
			'type' 		=> 'text',
			'size' 		=> 'regular',
		);
		$settingsArr['edd-invoices'.'-address'] = array(
			'id' 		=> 'edd-invoices'.'-address',
			'name' 		=> __('Address Line 1', 'edd-invoices'),
			'desc' 		=> __('Company Address, Line 1', 'edd-invoices'),
			'type' 		=> 'text',
			'size' 		=> 'regular',
		);
		$settingsArr['edd-invoices'.'-address2'] = array(
			'id' 		=> 'edd-invoices'.'-address2',
			'name' 		=> __('Address Line 2', 'edd-invoices'),
			'desc' 		=> __('Company Address, Line 2', 'edd-invoices'),
			'type' 		=> 'text',
			'size' 		=> 'regular',
		); 
		$settingsArr['edd-invoices'.'-city'] = array(
			'id' 		=> 'edd-invoices'.'-city',
			'name' 		=> __('City', 'edd-invoices'),
			'desc' 		=> __('Company City', 'edd-invoices'),
			'type' 		=> 'text',
			'size' 		=> 'regular',
		);
		$settingsArr['edd-invoices'.'-zipcode'] = array(
			'id' 		=> 'edd-invoices'.'-zipcode',
			'name' 		=> __('ZIP / Postal Code', 'edd-invoices'),
			'desc' 		=> __('Company ZIP/Postal Code', 'edd-invoices'),
			'type' 		=> 'text',
			'size' 		=> 'regular',
		);
		$settingsArr['edd-invoices'.'-country'] = array(
			'id' 		=> 'edd-invoices'.'-country',
			'name' 		=> __('Country', 'edd-invoices'),
			'desc' 		=> __('Company Country', 'edd-invoices'),
			'type' 		=> 'select',
			'options' 	=> edd_get_country_list(),
		);
		$settingsArr['edd-invoices'.'-number'] = array(
			'id' 		=> 'edd-invoices'.'-number',
			'name' 		=> __('Registration Number', 'edd-invoices'),
			'desc' 		=> __('Company Registration Number', 'edd-invoices'),
			'type' 		=> 'text',
			'size' 		=> 'regular',
		);
		$settingsArr['edd-invoices'.'-vat'] = array(
			'id' 		=> 'edd-invoices'.'-tax',
			'name' 		=> __('Tax/VAT Number', 'edd-invoices'),
			'desc' 		=> __('Company Tax/VAT Number', 'edd-invoices'),
			'type' 		=> 'text',
			'size' 		=> 'regular',
		); 
		 
		return $settingsArr;
    }
    
    /**
	* Appends a header column called 'Invoice'
	*/
	function purchaseHistoryHeader() {
		echo '<th class="edd_invoice">'.__( 'Invoice', 'edd-invoices').'</th>';
	}
	
	/**
	* Appends a header column called 'Invoice'
	*
	* @param int $receiptID Receipt ID
	* @param array $purchaseData Purchase Data
	*/
	function purchaseHistoryLink($paymentID, $purchaseData) {
		$url = add_query_arg(array(
			'payment_key' => edd_get_payment_key($paymentID),
		), get_permalink($this->settings['edd-invoices'.'-page']));
	
		echo '<td class="edd_invoice"><a href="'.$url.'">'.__('Generate Invoice', 'edd-invoices').'</a></td>';
	}
	
	/**
	* Used by generateInvoice() and generateInvoiceHTML(), checks that the requested
	* payment can be viewed by the user
	*/
	function checkReceipt() {
		// Check payment key exists
		$session = edd_get_purchase_session();
		if (isset($_GET['payment_key'])) {
			$payment_key = urldecode($_GET['payment_key']);
		}
		if (!isset($payment_key)) {
			return __('Invalid payment key specified.', 'edd-invoices');
		}
		
		// Get payment ID and customer ID
		$paymentID = edd_get_purchase_id_by_key($payment_key);
		if ($paymentID == 0) {
			return __('Invalid payment key specified.', 'edd-invoices');
		}
		
		// Check user has permission to view invoice
		$customerID = edd_get_payment_user_id($paymentID);
		$user_can_view = ( is_user_logged_in() && $customerID == get_current_user_id() ) || ( ( $customerID == 0 || $customerID == '-1' ) && ! is_user_logged_in() && edd_get_purchase_session() ) || current_user_can( 'view_shop_sensitive_data' );
		if (!$user_can_view) {
			return __('Invalid payment key specified.', 'edd-invoices');
		}
		
		return $paymentID;
	}
	
	/**
	* Shows the form to allow the user to complete billing + VAT fields, before seeing an on-screen HTML invoice
	*/
	function generateInvoice() {
		global $post;
		
		// Check access
		$paymentID = $this->checkReceipt();
		if (!is_numeric($paymentID)) {
			// Error
			return $paymentID;
		}
		
		// Generate Form
		$payment   = get_post($paymentID);
		$user      = edd_get_payment_meta_user_info( $payment->ID );
		
		// Generate form URL
		$url = add_query_arg(array(
			'payment_key' 	=> edd_get_payment_key($paymentID),
		), get_permalink($this->settings['edd-invoices'.'-page']));
		
		// Output form
		ob_start();
		include_once('views/form.php');
		$display = ob_get_clean();
		return $display;		
	}
	
	/**
	* Generates Invoice HTML Template
	*/
	function generateInvoiceHTML() {
		// Check invoice generation was requested
		if (!isset($_REQUEST['edd-invoices'.'-nonce'])) {
			return;
		}
		if (!wp_verify_nonce($_REQUEST['edd-invoices'.'-nonce'], 'edd-invoices'.'-generate-invoice')) {
			return;
		}
		
		// Check access
		$paymentID = $this->checkReceipt();
		if (!is_numeric($paymentID)) {
			return;
		}
		
		// Save user details from POST
		// Set new meta values
		$meta = edd_get_payment_meta($paymentID);
		$user_info = edd_get_payment_meta_user_info($paymentID);
		$user_info['first_name'] = $_POST['edd-payment-user-name'];
		$user_info['last_name'] = '';
		$user_info['address'] = array_map('trim', $_POST['edd-payment-address'][0]);
		$meta['user_info'] = $user_info;
		update_post_meta($paymentID, '_edd_payment_meta', $meta);
		
		// Get payment
		$payment   = get_post($paymentID);
		$meta      = edd_get_payment_meta( $payment->ID );
		$cart      = edd_get_payment_meta_cart_details( $payment->ID, true );
		$user      = edd_get_payment_meta_user_info( $payment->ID );
		$email     = edd_get_payment_user_email( $payment->ID );
		$status    = edd_get_payment_status( $payment, true );
		
		// Generate HTML
		ob_start();
		include_once('views/invoice.php');
		$display = ob_get_clean();
		echo $display;
		die();
	}
    
    /**
	* Loads plugin textdomain
	*/
	function loadLanguageFiles() {
	    // Set filter for language directory
        $lang_dir = $this->plugin->dirname . '/languages/';
        $lang_dir = apply_filters( 'edd-invoices' . '_languages_directory', $lang_dir );

        // Traditional WordPress plugin locale filter
        $locale = apply_filters( 'plugin_locale', get_locale(), 'edd-invoices' );
        $mofile = sprintf( '%1$s-%2$s.mo', 'edd-invoices', $locale );

        // Setup paths to current locale file
        $mofile_local   = $lang_dir . $mofile;
        $mofile_global  = WP_LANG_DIR . '/'. 'edd-invoices' .'/' . $mofile;

        if( file_exists( $mofile_global ) ) {
            // Look in global /wp-content/languages/edd-plugin-name/ folder
            load_textdomain( 'edd-invoices', $mofile_global );
        } elseif( file_exists( $mofile_local ) ) {
            // Look in local /wp-content/plugins/edd-plugin-name/languages/ folder
            load_textdomain( 'edd-invoices', $mofile_local );
        } else {
            // Load the default language files
            load_plugin_textdomain( 'edd-invoices', false, $lang_dir );
        }
	}

	function add_page(){
		// if settings exist
		if ( !empty( $this->settings ) ) {

			// if our page isnt set
			if ( ! edd_get_option( 'edd-invoices-page', false ) ) {
				// make page
				$page = wp_insert_post(
					array(
							'post_title'     => __( 'Invoice', 'edd-invoices' ),
							'post_content'   => '[edd_invoices]',
							'post_status'    => 'publish',
							'post_author'    => get_current_user_id(),
							'post_type'      => 'page',
							'post_parent'    => edd_get_option( 'purchase_history_page', false ),
							'comment_status' => 'closed'
						)
					);
				global $edd_options;
				$options[ 'edd-invoices-page' ] = $page;
				update_option( 'edd_settings', array_merge( $edd_options, $options ) );
			}
		}
	}
}

if ( class_exists( 'Easy_Digital_Downloads' ) ) {
	new EDDInvoices();
}
