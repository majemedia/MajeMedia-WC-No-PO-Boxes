<?php

if( ! defined( 'ABSPATH' ) ) {
	exit();
}

global $woocommerce;

$Settings                = new MWNPB_DashboardSettings();
$WCShipping              = new WC_Shipping();
$WCShippingZones         = new WC_Shipping_Zones();
$shippingEnabled         = (bool) $WCShipping->enabled;
$woocommerceShippingPage = 'admin.php?page=wc-settings&tab=shipping';

?>

<div class="wrap">
    <h1><?= __( "No PO Boxes", 'mm-wc-no-po-boxes' ); ?></h1>
    <h2><?= __( "How it works", 'mm-wc-no-po-boxes' ); ?></h2>

	<?php if( ! $shippingEnabled ) {

		?>

        <div class="error notice">
            <p>
				<?= __( 'WooCommerce shipping is currently disabled. Restriction will only work when shipping is enabled.', 'mm-wc-no-po-boxes' ); ?>
                <a href="<?= $woocommerceShippingPage; ?>"><?= __( 'View WooCommerce shipping options', 'mm-wc-no-po-boxes' ); ?></a>
            </p>
        </div>

		<?php

	}

	?>
    <p>
        <span>
            <?= __( "When a checkout is attempted with a billing address only then the check is done on both billing address fields.", 'mm-wc-no-po-boxes' ); ?>
        </span>
    </p>

    <form method="post" action="options.php">
		<?php
		settings_fields( $Settings->optionsGroup );
		do_settings_sections( $Settings->menuSlug );
		submit_button( "Save" );
		?>
    </form>

    <h2><?= __( 'Currently Restricted Text (includes any customization in place)', 'mm-wc-no-po-boxes' ); ?></h2>
    <p>
		<?= __( "This plugin looks at the entered text in the address fields in lower case and then checks against the following (not case sensitive)", 'mm-wc-no-po-boxes' ); ?>
    </p>
    <p>
		<?= __( "Add or Remove items from this list by using filters.", 'mm-wc-no-po-boxes' ); ?><br/>
        <a href="https://www.majemedia.com/plugins/no-po-boxes/" target="_blank">
			<?= __( "Guide here", 'mm-wc-no-po-boxes' ); ?>
        </a>
    </p>
    <ul>
		<?php
		foreach( MWNPB_Checkout::RestrictedStrings() as $string ) {
			echo "<li><code>{$string}</code></li>";
		}
		?>
    </ul>
</div>
