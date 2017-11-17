<?php

if( ! defined( 'ABSPATH' ) ) {
	die();
}

class MWNPB_DashboardSettings extends MWNPB_Base {

	public function __construct() {

		parent::__construct();

	}

	/**
	 * register_settings registers settings to be used by this plugin
	 *
	 * @since 1.0
	 */
	public function RegisterSettings() {

		register_setting( $this->optionsGroup, $this->optionsErrorMessage );
		register_setting( $this->optionsGroup, $this->optionsEnable );

		/*
		 * Support Section
		 */
		add_settings_section( $this->settingsSectionSupport, $this->settingsSectionSupportName, array(
			$this,
			'SettingsSectionSupport',
		), $this->menuSlug );

		/*
		 * Options Section
		 */
		add_settings_section( $this->settingsSectionOptions, $this->settingsSectionOptionsName, array(
			$this,
			'SettingsSectionOptions',
		), $this->menuSlug );

		add_settings_field( $this->optionsEnable, $this->optionsEnableName, array(
			$this,
			"OptionsEnable",
		), $this->menuSlug, $this->settingsSectionOptions );

		add_settings_field( $this->optionsErrorMessage, $this->optionsErrorMessageName, array(
			$this,
			"OptionsErrorMessage",
		), $this->menuSlug, $this->settingsSectionOptions );

		/*_log( WC_Shipping_Zones::get_zones() );
		_log( $WCShipping->get_shipping_methods() );*/

	}

	/**
	 * setup_options_page() sets up the submenu page under the woocommerce main menu
	 *
	 *
	 *
	 * @since 1.0
	 */
	public function SetupOptionsPage() {

		$parent_slug = 'woocommerce';
		$page_title  = esc_html__( "Don't Allow PO Boxes", 'mm-wc-no-po-boxes' );
		$menu_title  = esc_html__( 'No PO Boxes', 'mm-wc-no-po-boxes' );
		$capability  = 'manage_woocommerce';
		$callback    = array( $this, 'OptionsPage', );

		add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $this->menuSlug, $callback );

	}

	public function OptionsPage() {

		include( $this->pluginPath . '/templates/AdminSettings.php' );

	}

	public function OptionsErrorMessage() {

		$description = __( "This message will be displayed as an error on the checkout page when a P.O. Box is detected",'mm-wc-no-po-boxes');

		echo $this->RenderSingleLineText( $this->optionsErrorMessage, $description, $this->optionsErrorMessageDefault );

	}

	public function OptionsEnable() {

		$description = __( "Turns on or off the restrictions globally", "mm-wc-no-po-boxes" );

		echo $this->RenderCheckbox( $this->optionsEnable, $description, $this->optionsEnableDefault );

	}

	public function PluginSettingsLink( $links ) {

		$adminUrl          = admin_url( "admin.php?page={$this->menuSlug}" );
		$settingsLinkTitle = _( "Customize Messaging and Enable PO Box Restriction", "mm-wc-no-po-boxes" );
		$settingsLink      = array( "<a href='{$adminUrl}' title='{$settingsLinkTitle}'>Settings</a>" );

		return array_merge( $settingsLink, $links );

	}

	public function SettingsSectionOptions() {

	}

	public function SettingsSectionSupport() {

		echo <<<EOT
<p>
We're considering adding an opt-in only live support chat that would appear on this page only. This option would collect data about you (login email) and your site (web address and site name).<br />
In order to avoid adding features that our user base might not appreciate or want we've setup a survey to gather feedback (yes/no/more info). <a href="https://www.surveymonkey.com/r/RWPJ8M5" target="_blank">Take the survey here. Link opens in new tab/window.</a>
</p>
EOT;

	}

	private function RenderSingleLineText( $optionName, $fieldDescription, $default ) {

		$optionValue = esc_attr( get_option( $optionName, $default ) );
		$output = <<<EOT
<p>
<input type="text" name="{$optionName}" id="{$optionName}" value="{$optionValue}" class="regular-text">
</p>
<p>
{$fieldDescription}
</p>
EOT;

		return $output;


	}

	private function RenderParagraphText( $optionName ) {

	}

	private function RenderCheckbox( $optionName, $fieldDescription, $default ) {

		$optionValue = ( get_option( $optionName, $default ) === "on" );
		$default     = ( $default === 'on' );
		$checked     = checked( $optionValue, $default, FALSE );
		$output      = <<<EOT
<p>
<input type="checkbox" name="{$optionName}" id="{$optionName}" {$checked}>
</p>
<p>{$fieldDescription}</p>
EOT;

		return $output;

	}

}