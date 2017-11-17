<?php

if( ! defined( 'ABSPATH' ) ) {
	die();
}

/*
 *
 */

abstract class MWNPB_Base {

	public $pluginPath;
	public $pluginUrl;
	public $optionsGroup           = "mm_wc_no_po_boxes_options";
	public $optionsErrorMessage    = "mm_wc_no_po_boxes_error_message";
	public $optionsEnable          = "mm_wc_no_po_boxes_enable";
	public $settingsSectionOptions = "settingsSectionsOptions";
	public $settingsSectionSupport = "settingsSectionsSupport";
	public $settingsSectionInfo    = "settingsSectionInfo";
	public $pluginDirName          = "maje-wc-no-po-boxes";
	public $menuSlug               = "mm_wc_no_po_boxes";
	public $optionsEnableName;
	public $optionsEnableDefault   = "on";
	public $optionsErrorMessageName;
	public $optionsErrorMessageDefault;
	public $settingsSectionOptionsName;
	public $settingsSectionSupportName;
	public $settingsSectionInfoName;

	public function __construct() {

		$this->pluginPath                 = realpath( dirname( __FILE__, 2 ) );
		$this->pluginUrl                  = plugins_url( $this->pluginDirName );
		$this->optionsEnableName          = __( "Enable PO Box Restriction", "mm-wc-no-po-boxes" );
		$this->optionsErrorMessageName    = __( "Error Message", "mm-wc-no-po-boxes" );
		$this->optionsErrorMessageDefault = __( "Sorry, we cannot ship to P.O. Boxes", 'mm-wc-no-po-boxes' );
		$this->settingsSectionInfoName    = __( "Information", "mm-wc-no-po-boxes" );
		$this->settingsSectionSupportName = __( "Support", "mm-wc-no-po-boxes" );
		$this->settingsSectionOptionsName = __( "Options", "mm-wc-no-po-boxes" );

	}

}