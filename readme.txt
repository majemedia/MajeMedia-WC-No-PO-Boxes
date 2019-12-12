=== WooCommerce: No PO Boxes ===
Contributors: majemedia
Tags: woocommerce,checkout,po boxes,don't ship to po boxes,disallow po box shipping,prevent po boxes,post office box
Requires at least: 4.3.2
Tested up to: 5.3
Requires PHP: 5.6
Stable tag: 2.1.0
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Stop Shipping to PO Boxes

== Description ==
Please contact us at support@majemedia.com or go to [https://www.majemedia.com](https://majemedia.com/plugins/no-po-boxes) for plugin support.

Restricts the WooCommerce checkout form for allowing PO Boxes for shipping addresses.

- If same billing/shipping address the customer cannot complete checkout with a PO Box as a billing/shipping address.
- If the customer is shipping to a different physical address they cannot use a PO Box as a shipping address, but can use it as a billing address.
- Does not restrict the use of PO Boxes on Digital/Virtual only carts.
- Requires that WooCommerce shipping is enabled.
- Requires that WooCommerce has a shipping method setup (can be free shipping only).

[Usage and extending examples](https://majemedia.com/plugins/no-po-boxes)

[Github project](https://github.com/MajeMediaLLC/MajeMedia-WC-No-PO-Boxes)

== Installation ==
1. Have WooCommerce installed and activated
2. Enable shipping
3. Add this plugin or upload the .zip file (downloaded from here)
4. Activate plugin

== Screenshots ==
1. When shipping to the same billing address the billing address fields are reviewed
2. When shipping to a different address only the shipping side is reviewed
3. Settings page with configurable messaging (no html markup allowed)

== Changelog ==
= 2.1.0 =
* Github #17: Plugin is now semi-comptible with WooCommerce's official USPS shipping plugin. Please see github issue referenced for limits of the compatibility.

= 2.0.9 =
* Github #16: Updated the settings screen display of shipping methods to display the title of the shipping method instead of the shipping method type title.

= 2.0.8 =
* Tested to WordPress 5.3
* Tested to WooCommerce 3.8.1
* Fixed issue causing checkouts to go through with PO Boxes in limited cases

= 2.0.7 =
* Renamed plugin to drop "Maje"

= 2.0.6 =
* Really removed mailto link from readme

= 2.0.5 =
* Removed mailto link from description because it doesn't work

= 2.0.4 =
* Updated screenshots
* Updated readme changelog
* Updated github repo link
* Updated Description with links

= 2.0.3 =
* Bumped tested to versions of WordPress & WooCommerce

= 2.0.2 =
* Fix: Used the wrong function for translation

= 2.0.1 =
* Fix: Accidentally used a PHP7.0 only argument. Fixed to allow for php 5.3+
* Fix: Settings page was throwing notices when new, unsaved shipping methods were displayed

= 2.0.0 =
* New: Restrict by Shipping Method per Shipping Zone
* New: Filter: [mwnpb_restrict_shipping_method](https://www.majemedia.com/plugins/no-po-boxes/#mwnpb_restrict_shipping_method)
* New: Filter: [mwnpb_allow_pobox](https://www.majemedia.com/plugins/no-po-boxes/#mwnpb_allow_pobox)
* Bug Fix: Verifying that the returned variable type in the 'mmwc_restricted_words' filter is an array otherwise resetting to default set of words
* Update: Plugin Name to "WooCommerce: No PO Boxes" from "Maje WooCommerce No PO Boxes" for WC extension conformity.
* Update: Actually setting tested against WordPress 4.9
* Maintenance: Complete codebase refactor to make future updates less time intensive
* Meta: Added Requires PHP 5.6 header to plugin main file and readme
* Meta: Readme information to claim 5.6 required. Not yet required. Just setting the stage

= 1.1.12 = 
* Tested against WordPress 4.9
* tested against WooCommerce 3.2.3
* Added the following words to the deny list: PO. Box, PO.Box, P.O Box, P.O

= 1.1.11 =
* Forgot to update version in main php file... fixing to allow for updates in sites using

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
