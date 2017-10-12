=== Maje WooCommerce No PO Boxes ===
Contributors: majemedia
Tags: woocommerce,checkout,po boxes,don't ship to po boxes,disallow po box shipping,prevent po boxes,post office box
Requires at least: 4.3.2
Tested up to: 4.8.2
Stable tag: 1.1.10
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Stop Shipping to PO Boxes

== Description ==
Restricts the WooCommerce checkout form for allowing PO Boxes for shipping addresses.

- If same billing/shipping address the customer cannot complete checkout with a PO Box as a billing/shipping address.
- If the customer is shipping to a different physical address they cannot use a PO Box as a shipping address, but can use it as a billing address.
- Does not restrict the use of PO Boxes on Digital/Virtual only carts.
- Requires that WooCommerce shipping is enabled.
- Requires that WooCommerce has a shipping method setup (can be free shipping only)

Usage and extending examples can be found here: https://majemedia.com/plugins/no-po-boxes

Github project: https://github.com/majemedia/MajeMedia-WC-No-PO-Boxes

== Installation ==
1. Have WooCommerce installed and activated
2. Enable shipping
3. Add this plugin or upload the .zip file (downloaded from here)
4. Activate plugin

== Screenshots ==
1. When shipping to a different address only the shipping side is reviewed
2. When shipping to the same billing address the billing address fields are reviewed
3. Settings page with configurable messaging (no html markup allowed)

== Changelog ==
= 1.1.10 =
* Fix: Plugin now puts all restricted strings to lowercase instead of assuming they are
* Tested to WordPress version 4.8.2
* Added WooCommerce version check strings to main php file

= 1.1.9 =
* Fix: Plugin options getting deleted upon plugin deactivation
* Updated: Plugin options are deleted upon uninstall
* Updated: Added link to documentation on settings page
* Updated: Default functionality status: On (previously disabled upon installation)
* Tested to Wordpress version 4.8.1

= 1.1.8: =
* Tested to WordPress version 4.8

= 1.1.7: =
* Tested to WordPress version 4.7.1

= 1.1.6: =
* Tested to WordPress version 4.7

= 1.1.5: =
* Tested to WordPress version 4.6.1

= 1.1.4: =
* Updated tested to WordPress version.

= 1.1.3: =
* Updated for WordPress 4.5 Compatibility

= 1.1.2: =
* Added instruction text for cases where WooCommerce shipping is not enabled

= 1.1.1: =
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
