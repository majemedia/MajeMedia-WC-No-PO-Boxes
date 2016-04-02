<?php

/*
Plugin Name: Maje WC No PO Boxes
Plugin URI:  https://majemedia.com/plugins/no-po-boxes
Description: Restricts the use of PO Boxes during WooCommerce checkout. It contains a configurable message to display when a PO Box is attempted to be used. Will not limit the use of PO Boxes for carts that only contain digital products.
Version:     1.1.3
Author:      Maje Media LLC
Author URI:  https://majemedia.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: mm-wc-no-po-boxes
*/

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class MajeMedia_WC_No_PO_Boxes {

	private static $instance;
	public static  $plugin_path;

	const OPTIONS_GROUP         = 'mm_wc_no_po_boxes_options';
	const OPTIONS_ERROR_MESSAGE = 'mm_wc_no_po_boxes_error_message';
	const OPTIONS_ENABLE        = 'mm_wc_no_po_boxes_enable';
	const TEXT_DOMAIN           = 'mm-wc-no-po-boxes';

	/*
	 * @since v1.0
	 */
	public static function get_instance() {

		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/*
	 * @since v1.0
	 */
	public function __construct() {

		self::$plugin_path = realpath( dirname( __FILE__ ) );

		require 'autoload.php';

		$this->admin_actions();
		$this->nopriv_actions();

	}

	/**
	 * Actions to perform during the activation of this plugin
	 *
	 * @since v1.0
	 * @return void
	 *
	 */
	public static function activate() {

		update_option( self::OPTIONS_ERROR_MESSAGE, esc_html__( 'Sorry, we cannot ship to P.O. Boxes', 'mm-wc-no-po-boxes' ) );
		update_option( self::OPTIONS_ENABLE, '' );

	}

	/**
	 * Actions to perform during the deactivation of this plugin
	 *
	 * @since v1.0
	 * @description Actions to run upon deactivation of this plugin.
	 */
	public static function deactivate() {

		delete_option( self::OPTIONS_ERROR_MESSAGE );
		delete_option( self::OPTIONS_ENABLE );

	}

	/**
	 * Actions and filters called for use in the admin area
	 *
	 * @since v1.0
	 */
	public function admin_actions() {

		// Plugin activatation related
		add_action( 'activate_plugin', array( 'MajeMedia_WC_No_PO_Boxes', 'activate' ) );
		add_action( 'deactivate_plugin', array( 'MajeMedia_WC_No_PO_Boxes', 'deactivate' ) );

		// Plugin functions
		add_action( 'admin_init', array( 'MajeMedia_WC_No_PO_Dashboard_Settings', 'register_settings' ) );
		add_action( 'admin_menu', array( 'MajeMedia_WC_No_PO_Dashboard_Settings', 'setup_options_page' ) );
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array(
			'MajeMedia_WC_No_PO_Dashboard_Settings',
			'plugin_settings_link',
		) );

	}

	/**
	 * Actions and filters called for use on the live side of the install
	 *
	 * @since v1.0
	 */
	public function nopriv_actions() {

		add_action( 'woocommerce_before_checkout_process', array(
			'MajeMedia_WC_No_Po_Checkout',
			'get_checkout_post',
		) );

	}

}

$MajeMedia_WC_No_PO_Boxes = MajeMedia_WC_No_PO_Boxes::get_instance();