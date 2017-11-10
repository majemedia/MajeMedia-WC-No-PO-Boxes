<?php

if( ! defined( 'ABSPATH' ) ) {
	die();
}

/*
 * Some of this came from here: https://docs.woothemes.com/document/dont-allow-po-box-shipping/
 */

class MWNPB_Checkout {

	public function __construct() {

	}

	/**
	 * Main checkout function called after clicking the "Place Order" button
	 *
	 * Gathers the correct fields that are going to be used for sending any shipment
	 *
	 * @since 1.0
	 */
	public static function GetCheckoutPost() {

		if( ! WC()->cart->needs_shipping() ) {
			return FALSE;
		}

		$MWNPB   = MWNPB::GetInstance();
		$enabled = get_option( $MWNPB->optionsEnable );

		if( $enabled !== 'on' ) {
			return FALSE;
		}

		if( isset( $_POST[ 'ship_to_different_address' ] ) && $_POST[ 'ship_to_different_address' ] ) {

			$address_fields[ 1 ] = array( 'type' => 'shipping', 'value' => $_POST[ 'shipping_address_1' ] );
			$address_fields[ 2 ] = array( 'type' => 'shipping', 'value' => $_POST[ 'shipping_address_2' ] );

		}
		else {

			$address_fields[ 1 ] = array( 'type' => 'billing', 'value' => $_POST[ 'billing_address_1' ] );
			$address_fields[ 2 ] = array( 'type' => 'billing', 'value' => $_POST[ 'billing_address_2' ] );

		}

		$hasPoBox = self::PoBoxExists( $address_fields );

		if( $hasPoBox[ 'po_found' ] ) {

			/*
			 * Filter: mmwc_restricted_message
			 *
			 * @since 1.1.0
			 *
			 * Expected return: String
			 *
			 * example return: "This is the message that's displayed when checkout fails";
			 *
			 * Online Example: https://majemedia.com/plugins/no-po-boxes/#mmwc_restricted_message
			 *
			 * Additional Arguments available:
			 * - $hasPoBox[ 'string' ]: the string that triggered the error
			 * - $hasPoBox[ 'field' ]: the field that triggered the error
			 *
			 * Description: Allows for the programmatic updating of the list of restricted words
			 *
			 */
			$restrictedShippingMessage = apply_filters( 'mmwc_restricted_message', esc_attr( get_option( $MWNPB->optionsErrorMessage ) ), $hasPoBox[ 'string' ], $hasPoBox[ 'field' ] );

			wc_add_notice( esc_html__( $restrictedShippingMessage, 'mm-wc-no-po-boxes' ), 'error' );

		}

	}

	/**
	 * This function contains the array that is used to determine restricted strings.
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public static function RestrictedStrings() {

		$restricted_strings = array(
			'po box',
			'p.o. box',
			'p.o box',
			'po.box',
			'po. box',
			'p.o',
			'p.o.',
			'pobox',
			'p.o.box',
			'post office box',
			'p.o.',
			'pmb', // private mail box (UPS Stores)
			'private mail box',
		);

		/*
		 * Filter: mmwc_restricted_words
		 *
		 * @since 1.1.0
		 *
		 * Expected return: array of words
		 *
		 * Online Example: https://majemedia.com/plugins/no-po-boxes/#mmwc_restricted_words
		 *
		 * Allows for the programmatic updating of the list of restricted words
		 *
		 * Note: This filter will not change the message displayed to the customer.
		 */
		$filtered_restrictions = apply_filters( 'mmwc_restricted_words', $restricted_strings );

		if( gettype( $filtered_restrictions ) !== "array" ) {
			error_log( "The WooCommerce: No PO Boxes plugin is not being filtered correctly and a non-array has been returned to the filter 'mmwc_rescripted_words'. Setting to default to avoid errors on site" );
			$filtered_restrictions = $restricted_strings;
		}

		return $filtered_restrictions;

	}

	/**
	 *
	 * PoBoxExists() takes an array of address fields to be used in evaluating their
	 * content for restricted strings. It returns an array in both true and false cases.
	 *
	 * @since 1.0
	 *
	 * @param $address_fields
	 *
	 * @return array
	 */
	public static function PoBoxExists( $address_fields ) {

		foreach( $address_fields as $key => $address ) {

			foreach( self::RestrictedStrings() as $poBoxString ) {

				$poBoxPosition = strpos( strtolower( $address[ 'value' ] ), strtolower( $poBoxString ) );

				if( $poBoxPosition !== FALSE ) {

					$field = $address[ 'type' ] . '_address_' . $key;

					return array( 'po_found' => TRUE, 'field' => $field, 'string' => $poBoxString );

				}

			}

		}

		return array( 'po_found' => FALSE );

	}

}
