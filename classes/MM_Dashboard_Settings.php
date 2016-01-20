<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/*
 * 
 */

class MajeMedia_WC_No_PO_Dashboard_Settings {

	public function __construct() {

	}

	/**
	 * register_settings registers settings to be used by this plugin
	 *
	 * @since 1.0
	 */
	public static function register_settings() {

		if ( is_admin() ) {

			register_setting( MajeMedia_WC_No_PO_Boxes::OPTIONS_GROUP, MajeMedia_WC_No_PO_Boxes::OPTIONS_ERROR_MESSAGE );
			register_setting( MajeMedia_WC_No_PO_Boxes::OPTIONS_GROUP, MajeMedia_WC_No_PO_Boxes::OPTIONS_ENABLE );

		}

	}

	/**
	 * setup_options_page() sets up the submenu page under the woocommerce main menu
	 *
	 *
	 *
	 * @since 1.0
	 */
	public static function setup_options_page() {

		$parent_slug = 'woocommerce';
		$page_title  = esc_html__( "Don't Allow PO Boxes", 'mm-wc-no-po-boxes' );
		$menu_title  = esc_html__( 'No PO Boxes', 'mm-wc-no-po-boxes' );
		$capability  = 'manage_woocommerce';
		$menu_slug   = 'mm_wc_no_po_boxes';
		$callback    = array( 'MajeMedia_WC_No_PO_Dashboard_Settings', 'options_page', );

		add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $callback );

	}

	public static function options_page() {

		if ( is_admin() ) {

			include( MajeMedia_WC_No_PO_Boxes::$plugin_path . '/templates/settings_page.php' );

		}

	}

	public static function plugin_settings_link( $links ) {

		$settings_link = array( '<a href="' . admin_url( 'admin.php?page=mm_wc_no_po_boxes' ) . '" title="Customize Messaging and Enable PO Box Restriction">Settings</a>' );

		return array_merge( $settings_link, $links );

	}

}