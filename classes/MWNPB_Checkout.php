<?php

if( ! defined( 'ABSPATH' ) ) {
	die();
}

/*
 * Some of this came from here: https://docs.woothemes.com/document/dont-allow-po-box-shipping/
 */

class MWNPB_Checkout extends MWNPB_Base {

	public function __construct() {

		parent::__construct();

	}

	/**
	 * Main checkout function called after clicking the "Place Order" button
	 *
	 * Gathers the correct fields that are going to be used for sending any shipment
	 *
	 * @since 1.0
	 */
	public function GetCheckoutPost() {

		if( ! WC()->cart->needs_shipping() ) {
			return FALSE;
		}

		$enabled = get_option( $this->optionsEnable );

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

		$hasPoBox = $this->PoBoxExists( $address_fields );

		if( $hasPoBox[ 'po_found' ] ) {

			if( get_option( $this->optionsShippingRestrictions, $this->optionsShippingRestrictionsDefault ) === 'on' ) {

				$shipping_zones = get_option( $this->optionsShippingZones, "all" );

				if( ! empty( $_POST[ 'shipping_method' ] ) && $shipping_zones !== "all" ) {

					foreach( $_POST[ 'shipping_method' ] as $method ) {

						$method_array = explode( ':', $method );
						$method_value = $method_array[ 1 ];
						$methodId     = ( is_numeric( $method_value ) )
							? $method_array[ 1 ]
							: $method_array[ 0 ];

						if( array_key_exists( $methodId, $shipping_zones ) ) {

							if( $shipping_zones[ $methodId ] === 'yes' ) {

								/*
								 * Filter: mwnpb_restrict_shipping_method
								 *
								 * @since 2.0.0
								 *
								 * Expected return: Boolean
								 *
								 * This filter will, when returned TRUE, will allow for the shipping method to not allow P.O. Boxes for a shipping method that has been saved as "Allowed".
								 * This is good for specific situations where you want the shipping method restricted but most of the time the method should be allowed to ship to P.O. Boxes.
								 *
								 * Usage examples and discussion: https://www.majemedia.com/plugins/no-po-boxes/#mwnpb_restrict_shipping_method
								 *
								 */
								$restrictShipMethod = (bool) apply_filters( 'mwnpb_restrict_shipping_method', FALSE );

								if( ! $restrictShipMethod ) {
									return FALSE;
								}

							}

						}

					}

				}

			}

			/*
			 * Filter: mwnpb_allow_pobox
			 *
			 * @since 2.0.0
			 *
			 * Expected return: Boolean
			 *
			 * This filter, when returned as TRUE will allow for a PO Box to be in the shipping address.
			 *
			 * Online Example: https://www.majemedia.com/plugins/no-po-boxes/#mwnpb_allow_pobox
			 *
			 * Additional Arguments available:
			 * - $hasPoBox['string']: the string that triggered the error
			 * - $hasPoBox['field']: the field that triggered the error
			 *
			 * Default is FALSE
			 */

			$allowPoBox = apply_filters( 'mwnpb_allow_pobox', FALSE, $hasPoBox[ 'string' ], $hasPoBox[ 'field' ] );
			if( $allowPoBox ) {
				return FALSE;
			}

			/*
			 * Filter: mmwc_restricted_message
			 *
			 * @since 1.1.0
			 *
			 * Expected return: String
			 *
			 * example return: "This is the message that's displayed when checkout fails";
			 *
			 * Online Example: https://www.majemedia.com/plugins/no-po-boxes/#mmwc_restricted_message
			 *
			 * Additional Arguments available:
			 * - $hasPoBox[ 'string' ]: the string that triggered the error
			 * - $hasPoBox[ 'field' ]: the field that triggered the error
			 *
			 * Description: Allows for the programmatic updating of the list of restricted words
			 *
			 */
			$restrictedShippingMessage  = apply_filters( 'mmwc_restricted_message', esc_attr( get_option( $this->optionsErrorMessage ) ), $hasPoBox[ 'string' ], $hasPoBox[ 'field' ] );
			$_restrictedShippingMessage = esc_html( $restrictedShippingMessage );

			throw new Exception( $_restrictedShippingMessage );

		}

	}

	/**
	 * This function contains the array that is used to determine restricted strings.
	 *
	 * @return array
	 * @since 1.0
	 *
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
	 * @param $address_fields
	 *
	 * @return array
	 * @since 1.0
	 *
	 */
	public function PoBoxExists( $address_fields ) {

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
