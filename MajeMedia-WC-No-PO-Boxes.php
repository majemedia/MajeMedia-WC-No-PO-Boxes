<?php

/*
Plugin Name: WooCommerce: No PO Boxes
Plugin URI:  https://majemedia.com/plugins/no-po-boxes
Description: Restricts the use of PO Boxes during WooCommerce checkout. It contains a configurable message to display when a PO Box is attempted to be used. Will not limit the use of PO Boxes for carts that only contain digital products.
Version:     2.0.8
Author:      Maje Media LLC
Author URI:  https://majemedia.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: mm-wc-no-po-boxes
WC requires at least: 3.0.0
WC tested up to: 3.8.1
*/

if( ! defined( 'ABSPATH' ) ) {
	die();
}

require_once 'autoload.php';

class MWNPB extends MWNPB_Base {

	private static $instance;

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

		parent::__construct();

		$this->Actions();
		$this->Filters();

	}

	/**
	 * Actions to perform during the activation of this plugin
	 *
	 * @since v1.0
	 * @return void
	 *
	 */
	public function Activate() {

		update_option( $this->optionsErrorMessage, $this->optionsErrorMessageDefault );
		update_option( $this->optionsEnable, $this->optionsEnableDefault );

	}

	public static function Uninstall() {

		global $MWNPB;

		delete_option( $MWNPB->optionsErrorMessage );
		delete_option( $MWNPB->optionsEnable );

	}

	/**
	 * Actions and filters called for use in the admin area
	 *
	 * @since v1.0
	 */
	public function Actions() {

		$Dashboard = new MWNPB_DashboardSettings();
		$Checkout  = new MWNPB_Checkout();

		add_action( 'activate_plugin', array( $this, 'Activate' ) );
		add_action( 'admin_init', array( $Dashboard, 'RegisterSettings' ) );
		add_action( 'admin_menu', array( $Dashboard, 'SetupOptionsPage' ) );
		add_action( 'woocommerce_before_checkout_process', array(
			$Checkout,
			'GetCheckoutPost',
		) );

	}

	/**
	 * Actions and filters called for use on the live side of the install
	 *
	 * @since v1.0
	 */
	public function Filters() {

		$Dashboard = new MWNPB_DashboardSettings();

		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array(
			$Dashboard,
			'PluginSettingsLink',
		) );

	}

}

$MWNPB = MWNPB::GetInstance();

register_uninstall_hook( __FILE__, array( 'MWNPB', 'Uninstall' ) );