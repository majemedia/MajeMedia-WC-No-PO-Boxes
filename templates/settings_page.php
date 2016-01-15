<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

?>

<div class="wrap">
	<h1><?php esc_html_e( "Don't Allow PO Boxes", MajeMedia_WC_No_PO_Boxes::TEXT_DOMAIN ); ?></h1>

	<h2><?php esc_html_e( 'How it works', MajeMedia_WC_No_PO_Boxes::TEXT_DOMAIN ); ?></h2>
	<p><span><?php esc_html_e( 'When a checkout is attempted with a billing address only then the check is done on both billing address fields.', MajeMedia_WC_No_PO_Boxes::TEXT_DOMAIN); ?></span><br /><span><?php esc_html_e( 'If a checkout is attempted with a separate shipping address is enabled then the check is only done on the shipping addresses.', MajeMedia_WC_No_PO_Boxes::TEXT_DOMAIN ); ?></span></p>

	<h2><?php esc_html_e( 'Options', MajeMedia_WC_No_PO_Boxes::TEXT_DOMAIN ); ?></h2>
	<form method="post" action="options.php">
		<?php settings_fields( MajeMedia_WC_No_PO_Boxes::OPTIONS_GROUP ); ?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php esc_html_e( 'Error Message', MajeMedia_WC_No_PO_Boxes::TEXT_DOMAIN ); ?>:</th>
				<td><input type="text" name="<?php echo MajeMedia_WC_No_PO_Boxes::OPTIONS_ERROR_MESSAGE; ?>"
				           value="<?php echo esc_attr( get_option( MajeMedia_WC_No_PO_Boxes::OPTIONS_ERROR_MESSAGE ) ); ?>"
				</td>
			</tr>
		</table>
		<?php do_settings_sections( MajeMedia_WC_No_PO_Boxes::OPTIONS_GROUP ); ?>
		<?php submit_button(); ?>
	</form>

	<h2><?php esc_html_e( 'Currently Restricted Text', MajeMedia_WC_No_PO_Boxes::TEXT_DOMAIN ); ?></h2>
	<p><?php esc_html_e( 'This plugin looks at the entered text in the address fields in lower case and then checks against the following', MajeMedia_WC_No_PO_Boxes::TEXT_DOMAIN ); ?>:</p>
	<ul>
		<?php

		$strings = MajeMedia_WC_No_Po_Checkout::restricted_strings();

		foreach ( $strings as $string ) {

			echo '<li><code>' . $string . '</code></li>';

		}

		?>
	</ul>

</div>