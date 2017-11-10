<?php

/*
Plugin Name: WooCommerce: No PO Boxes
Plugin URI:  https://majemedia.com/plugins/no-po-boxes
Description: Restricts the use of PO Boxes during WooCommerce checkout. It contains a configurable message to display when a PO Box is attempted to be used. Will not limit the use of PO Boxes for carts that only contain digital products.
Version:     1.2.0
Author:      Maje Media LLC
Author URI:  https://majemedia.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: mm-wc-no-po-boxes
WC requires at least: 3.0.0
WC tested up to: 3.2.3
*/

if( ! defined( 'ABSPATH' ) ) {
	die();
}

class MWNPB {

	private static $instance;
	public         $pluginPath;
	public         $pluginUrl;
	public         $optionsGroup        = "mm_wc_no_po_boxes_options";
	public         $optionsErrorMessage = "mm_wc_no_po_boxes_error_message";
	public         $optionsEnable       = "mm_wc_no_po_boxes_enable";

	/*
	 * @since v1.0
	 */
	public static function GetInstance() {

		if( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/*
	 * @since v1.0
	 */
	public function __construct() {

		$this->SetClassVars();

		require 'autoload.php';

		$this->Actions();
		$this->Filters();

	}

	public function SetClassVars() {

		$this->pluginPath = realpath( dirname( __FILE__ ) );
		$this->pluginUrl  = plugins_url( '', __FILE__ );

	}

	/**
	 * Actions to perform during the activation of this plugin
	 *
	 * @since v1.0
	 * @return void
	 *
	 */
	public static function Activate() {

		$MWNPB = MWNPB::GetInstance();

		update_option( $MWNPB->optionsErrorMessage, esc_html__( 'Sorry, we cannot ship to P.O. Boxes', 'mm-wc-no-po-boxes' ) );
		update_option( $MWNPB->optionsEnable, 'on' );

	}

	/**
	 * Actions to perform during the deactivation of this plugin
	 *
	 * @since v1.0
	 * @description Actions to run upon deactivation of this plugin.
	 */
	public static function Deactivate() {

	}

	public static function Uninstall() {

		$MWNPB = MWNPB::GetInstance();

		delete_option( $MWNPB->optionsErrorMessage );
		delete_option( $MWNPB->optionsEnable );

	}

	/**
	 * Actions and filters called for use in the admin area
	 *
	 * @since v1.0
	 */
	public function Actions() {

		add_action( 'activate_plugin', array( 'MWNPB', 'Activate' ) );

		add_action( 'deactivate_plugin', array( 'MWNPB', 'Deactivate' ) );

		add_action( 'admin_init', array( 'MWNPB_DashboardSettings', 'RegisterSettings' ) );

		add_action( 'admin_menu', array( 'MWNPB_DashboardSettings', 'SetupOptionsPage' ) );

		add_action( 'woocommerce_before_checkout_process', array(
			'MWNPB_Checkout',
			'GetCheckoutPost',
		) );

	}

	/**
	 * Actions and filters called for use on the live side of the install
	 *
	 * @since v1.0
	 */
	public function Filters() {

		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array(
			'MWNPB_DashboardSettings',
			'PluginSettingsLink',
		) );

	}

}

$MWNPB = MWNPB::GetInstance();

register_uninstall_hook( __FILE__, [ 'MWNPB', 'Uninstall' ] );
