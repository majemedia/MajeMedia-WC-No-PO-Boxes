<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

// Slash in front
$files_to_load = array(
	'/classes/MWNPB_DashboardSettings.php',
	'/classes/MWNPB_Checkout.php',
);

foreach ( $files_to_load as $file ) {
	require realpath( dirname( __FILE__ ) ) . $file;
}