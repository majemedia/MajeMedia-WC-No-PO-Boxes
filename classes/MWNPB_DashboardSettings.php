<?php

if( ! defined( 'ABSPATH' ) ) {
	die();
}

class MWNPB_DashboardSettings {

	public function __construct() {

	}

	/**
	 * register_settings registers settings to be used by this plugin
	 *
	 * @since 1.0
	 */
	public static function RegisterSettings() {

		$MWNPB = MWNPB::GetInstance();

		register_setting( $MWNPB->optionsGroup, $MWNPB->optionsErrorMessage );
		register_setting( $MWNPB->optionsGroup, $MWNPB->optionsEnable );

	}

	/**
	 * setup_options_page() sets up the submenu page under the woocommerce main menu
	 *
	 *
	 *
	 * @since 1.0
	 */
	public static function SetupOptionsPage() {

		$parent_slug = 'woocommerce';
		$page_title  = esc_html__( "Don't Allow PO Boxes", 'mm-wc-no-po-boxes' );
		$menu_title  = esc_html__( 'No PO Boxes', 'mm-wc-no-po-boxes' );
		$capability  = 'manage_woocommerce';
		$menu_slug   = 'mm_wc_no_po_boxes';
		$callback    = array( 'MWNPB_DashboardSettings', 'OptionsPage', );

		add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $callback );

	}

	public static function OptionsPage() {

		$MWNPB = MWNPB::GetInstance();

		include( $MWNPB->pluginPath . '/templates/settings_page.php' );

	}

	public static function PluginSettingsLink( $links ) {

		$MWNPB = MWNPB::GetInstance();

		$settings_link = array( '<a href="' . admin_url( 'admin.php?page=mm_wc_no_po_boxes' ) . '" title="Customize Messaging and Enable PO Box Restriction">Settings</a>' );

		return array_merge( $settings_link, $links );

	}

}