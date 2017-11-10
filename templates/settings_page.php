<?php

if( ! defined( 'ABSPATH' ) ) {
	exit();
}

$WCShipping              = new WC_Shipping();
$shippingEnabled         = (bool) $WCShipping->enabled;
$restrictPoSetting       = ( esc_attr( get_option( $MWNPB->optionsEnable ) ) === 'on' )
	? TRUE
	: FALSE;
$woocommerceShippingPage = 'admin.php?page=wc-settings&tab=shipping';

?>

<div class="wrap">
    <h1><?php esc_html_e( "Don't Allow PO Boxes", 'mm-wc-no-po-boxes' ); ?></h1>

    <h2><?php esc_html_e( 'How it works', 'mm-wc-no-po-boxes' ); ?></h2>
    <p>
        <span><?php esc_html_e( 'When a checkout is attempted with a billing address only then the check is done on both billing address fields.', 'mm-wc-no-po-boxes' ); ?></span><br/><span><?php esc_html_e( 'If a checkout is attempted with a separate shipping address is enabled then the check is only done on the shipping addresses.', 'mm-wc-no-po-boxes' ); ?></span>
    </p>

    <h2><?php esc_html_e( 'Options', 'mm-wc-no-po-boxes' ); ?></h2>
	<?php if( ! $shippingEnabled ) {

		?>

        <div class="error notice">
            <p><?php _e( 'WooCommerce shipping is currently disabled. Restriction will only work when shipping is enabled.', 'mm-wc-no-po-boxes' ); ?>
                <br/><a
                        href="<?= $woocommerceShippingPage; ?>"><?php _e( 'View WooCommerce shipping options', 'mm-wc-no-po-boxes' ); ?></a>
            </p>
        </div>

		<?php

	}

	?>
    <form method="post" action="options.php">
		<?php settings_fields( $MWNPB->optionsGroup ); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    <label for="<?= $MWNPB->optionsEnable; ?>"><?php esc_html_e( 'Enable PO Box Restriction', 'mm-wc-no-po-boxes' ); ?>
                        :</label></th>
                <td>
                    <input id="<?= $MWNPB->optionsEnable; ?>" type="checkbox" name="<?= $MWNPB->optionsEnable; ?>" <?php checked( $restrictPoSetting, TRUE ); ?>>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="<?= $MWNPB->optionsErrorMessage; ?>"><?php esc_html_e( 'Error Message', 'mm-wc-no-po-boxes' ); ?>
                        :</label></th>
                <td>
                    <input id="<?= $MWNPB->optionsErrorMessage; ?>" type="text" name="<?= $MWNPB->optionsErrorMessage; ?>" value="<?= esc_attr( get_option( $MWNPB->optionsErrorMessage ) ); ?>">
                </td>
            </tr>
        </table>
		<?php do_settings_sections( $MWNPB->optionsGroup ); ?>
		<?php submit_button(); ?>
    </form>

    <h2><?php esc_html_e( 'Currently Restricted Text', 'mm-wc-no-po-boxes' ); ?></h2>
    <p><?php esc_html_e( 'This plugin looks at the entered text in the address fields in lower case and then checks against the following (not case sensitive)', 'mm-wc-no-po-boxes' ); ?>
        :<br/>Add or Remove items from this list by using filters.
        <a href="https://www.majemedia.com/plugins/no-po-boxes/" target="_blank">Guide here</a></p>
    <ul>
		<?php

		foreach( MWNPB_Checkout::RestrictedStrings() as $string ) {

			echo '<li><code>' . $string . '</code></li>';

		}

		?>
    </ul>

</div>