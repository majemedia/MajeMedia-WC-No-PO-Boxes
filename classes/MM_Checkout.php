<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/*
 * Some of this came from here: https://docs.woothemes.com/document/dont-allow-po-box-shipping/
 */

class MajeMedia_WC_No_Po_Checkout {

	public function __construct() {

	}

	/**
	 * Main checkout function called after clicking the "Place Order" button
	 *
	 * Gathers the correct fields that are going to be used for sending any shipment
	 *
	 * @since 1.0
	 */
	public static function get_checkout_post() {

		$restriction_enabled = get_option( MajeMedia_WC_No_PO_Boxes::OPTIONS_ENABLE );

		if ( WC()->cart->needs_shipping() && $restriction_enabled === 'on' ) {

			if ( isset( $_POST[ 'ship_to_different_address' ] ) && $_POST[ 'ship_to_different_address' ] ) {

				$address_fields[ 1 ] = array( 'type' => 'shipping', 'value' => $_POST[ 'shipping_address_1' ] );
				$address_fields[ 2 ] = array( 'type' => 'shipping', 'value' => $_POST[ 'shipping_address_2' ] );

			}
			else {

				$address_fields[ 1 ] = array( 'type' => 'billing', 'value' => $_POST[ 'billing_address_1' ] );
				$address_fields[ 2 ] = array( 'type' => 'billing', 'value' => $_POST[ 'billing_address_2' ] );

			}

			$has_po_box = self::check_for_po_box( $address_fields );

			if ( $has_po_box[ 'po_found' ] ) {

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
				 * - $has_po_box['string']: the string that triggered the error
				 * - $has_po_box['field']: the field that triggered the error
				 *
				 * Description: Allows for the programmatic updating of the list of restricted words
				 *
				 */
				$restricted_shipping_message = apply_filters( 'mmwc_restricted_message', esc_attr( get_option( MajeMedia_WC_No_PO_Boxes::OPTIONS_ERROR_MESSAGE ) ), $has_po_box[ 'string' ], $has_po_box[ 'field' ] );

				wc_add_notice( esc_html__( $restricted_shipping_message, 'mm-wc-no-po-boxes' ), 'error' );

			}

		}

	}

	/**
	 * This function contains the array that is used to determine restricted strings.
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public static function restricted_strings() {

		$possible_pobox_combinations = array(
			'po box'
			, 'p.o. box'
			, 'p.o box'
			, 'po.box'
			, 'po. box'
			, 'p.o'
			, 'p.o.'
			, 'pobox'
			, 'p.o.box'
			, 'post office box'
			, 'p.o.'
			, 'pmb' // private mail box (UPS Stores)
			, 'private mail box'
		);

		/*
		 * Filter: mmwc_restricted_words
		 *
		 * @since 1.1.0
		 *
		 * Expected return: array of words
		 *
		 * example: array('new word','another new word');
		 *
		 * Online Example: https://majemedia.com/plugins/no-po-boxes/#mmwc_restricted_words
		 *
		 * Allows for the programmatic updating of the list of restricted words
		 *
		 * Note: This filter will not change the message displayed to the customer.
		 */
		$filtered_restrictions = apply_filters( 'mmwc_restricted_words', $possible_pobox_combinations );

		return $filtered_restrictions;

	}

	/**
	 *
	 * check_for_po_box() takes an array of address fields to be used in evaluating their
	 * content for restricted strings. It returns an array in both true and false cases.
	 *
	 * @since 1.0
	 *
	 * @param $address_fields
	 *
	 * @return array
	 */
	public static function check_for_po_box( $address_fields ) {

		$possible_pobox_strings = self::restricted_strings();

		foreach ( $address_fields as $key => $address ) {

			foreach ( $possible_pobox_strings as $po_box_string ) {

				$po_box_position = strpos( strtolower( $address[ 'value' ] ), strtolower( $po_box_string ) );

				if ( $po_box_position !== FALSE ) {

					$field = $address[ 'type' ] . '_address_' . $key;

					return array( 'po_found' => TRUE, 'field' => $field, 'string' => $po_box_string );

				}

			}

		}

		return array( 'po_found' => FALSE );

	}

}
