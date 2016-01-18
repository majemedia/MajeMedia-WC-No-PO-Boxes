=== Maje WooCommerce No PO Boxes ===
Contributors: majemedia
Tags: woocommerce,checkout,po boxes
Requires at least: 4.3.2
Tested up to: 4.4.1
Stable tag: 1.1.1
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds messaging to the WooCommerce checkout form

== Description ==
Restricts the WooCommerce checkout form for allowing PO Boxes for shipping addresses.

- If same billing/shipping address the customer cannot complete checkout with a PO Box as a billing/shipping address.
- If the customer is shipping to a different physical address they cannot use a PO Box as a shipping address, but can use it as a billing address.
- Does not restrict the use of PO Boxes on Digital/Virtual only carts.
- Disabled by default.

Usage and extending examples can be found here: https://majemedia.com/plugins/no-po-boxes

Github project: https://github.com/majemedia/MajeMedia-WC-No-PO-Boxes

== Installation ==
1. Have WooCommerce installed and activated
2. Add this plugin or upload the .zip file (downloaded from here)
3. Activate plugin
4. Go to the settings screen (can be found under the WooCommerce menu as "No PO Boxes")
5. Insert your custom messages
6. Click "Save Changes"

== Screenshots ==
1. When shipping to a different address only the shipping side is reviewed
2. When shipping to the same billing address the billing address fields are reviewed
3. Settings page with configurable messaging (no html markup allowed)

== Changelog ==
= 1.1.1 =
* Changed to using plain text text domain instead of class constant

= 1.1.0: =
* Added filter `mmwc_restricted_message`
* Added filter `mmwc_restricted_words`

= 1.0.2: =
* Added the ability to turn on and off the restriction (off by default)
* Added Settings link to the Plugin listing page

= 1.0.1: =
* Updated documentation

= 1.0.0: =
* Created plugin
