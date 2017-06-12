# Maje Media WooCommerce No PO Boxes
Disallows the use of PO Boxes for shipping when using WooCommerce

## Description
Restricts the WooCommerce checkout form for allowing PO Boxes for shipping addresses.

- If same billing/shipping address the customer cannot complete checkout with a PO Box as a billing/shipping address.
- If the customer is shipping to a different physical address they cannot use a PO Box as a shipping address, but can use it as a billing address.
- Does not restrict the use of PO Boxes on Digital/Virtual only carts.
- Disabled by default.
- Requires that WooCommerce shipping is enabled.

## Installation
1. Have WooCommerce installed and activated
1. Enable shipping
1. Add this plugin or upload the .zip file (downloaded from here)
1. Activate plugin
1. Go to the settings screen (can be found under the WooCommerce menu as "No PO Boxes")
1. Insert your custom messages
1. Click "Save Changes"

## Extending

### Filter: `mmwc_restricted_message`
[example](https://majemedia.com/plugins/no-po-boxes/#mmwc_restricted_message)

    add_filter( 'mmwc_restricted_message', 'mmwc_restricted_message_example', 10, 3 );
    function mmwc_restricted_message_example( $message, $restricted_string, $field_with_restricted_string ) {
    
        // use $restricted_string to customize $message based on different conditions. 
        // use $field_with_restricted_string to customize the message based on what field the restriction occurred in
    
        $message = 'This is the message I want to display now instead of the saved one from the dashboard';
    
        return $message;
    
    }

### Filter: `mmwc_restricted_words`
[example](https://majemedia.com/plugins/no-po-boxes/#mmwc_restricted_words)

    add_filter( 'mmwc_restricted_words', 'mmwc_restricted_words_example' );
    function mmwc_restricted_words_example( $words ) {
    
        /*
         * You'll need to modify this example function since a number of different filtering options are being used.
         */
    
        // Remove options by word (has to be exact to what is in `MajeMedia_WC_No_Po_Checkout::restricted_strings()` );
        if ( ( $key = array_search( 'word I do not want to filter', $words ) ) !== FALSE ) {
            unset( $words[ $key ] );
        }
    
        // Remove strings by array_key from `MajeMedia_WC_No_Po_Checkout::restricted_strings()`
        unset( $words[ 0 ] ); // unsets "po box"
    
        // Add an additional string
        $words[] = 'my new restricted string';
    
        // delete all restricted strings from default plugin and define your own
        $words = array( 'my restriction 1', 'my restriction 2' );
    
        return $words;
    
    }

## Changelog
### 1.1.8:
* Tested to WordPress version 4.8

### 1.1.7:
* Tested to WordPress version 4.7.1

### 1.1.6:
* Tested to WordPress version 4.7

### 1.1.5:
* Tested to WordPress version 4.6.1

### 1.1.4:
* Updated tested to WordPress version.

### 1.1.3:
* Updated compatibility to WordPress 4.5
* Tested against WooCommerce 2.5.x

### 1.1.2:
* Added instruction text for cases where WooCommerce shipping is not enabled

### 1.1.1:
* Changed to using plain text text domain instead of class constant

### 1.1.0:
* Added filter `mmwc_restricted_message`
* Added filter `mmwc_restricted_words`

### 1.0.2:
* Added the ability to turn on and off the restriction (off by default)
* Added Settings link to the Plugin listing page

### 1.0.1:
* Updated documentation

### 1.0.0:
* Created plugin
