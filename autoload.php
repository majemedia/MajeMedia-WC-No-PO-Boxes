<?php

if( ! defined( 'ABSPATH' ) ) {
	die();
}

// Slash in front
$files_to_load = array(
	'/classes/MWNPB_Base.php',
	'/classes/MWNPB_DashboardSettings.php',
	'/classes/MWNPB_Checkout.php',
);

foreach( $files_to_load as $file ) {
	require_once realpath( dirname( __FILE__ ) ) . $file;
}

if( ! function_exists( '_log' ) ) {

	/**
	 * @description Takes any message and sends it to the error_log. Due to how php's serialize works (will add binary characters) and that error_log will truncate when it hits a binary character a str_replace is used.
	 *
	 * @param $message mixed anything you want to print out
	 */
	function _log( $message = '', BOOL $backtrace = FALSE ) {

		if( $backtrace || func_num_args() === 0 ) {

			$backtrace = debug_backtrace();
			error_log( print_r( [ 'file' => $backtrace[ 0 ][ 'file' ], 'line' => $backtrace[ 0 ][ 'line' ] ], TRUE ) );

		}

		if( func_num_args() !== 0 ) {
			error_log( str_replace( "\0", "(NULL)", print_r( $message, TRUE ) ) );
		}

	}

}