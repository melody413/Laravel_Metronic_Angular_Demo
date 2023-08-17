<?php
/**
 * Instagram Above Footer
 *
 * This template can be overridden by copying it to your-child-theme/templates/footers/footer-tiktok.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author 		TieLabs
 * @version   5.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


if( tie_get_option( 'footer_tiktok' ) && tie_get_option( 'footer_tiktok_source' ) && ! TIELABS_HELPER::is_mobile_and_hidden( 'footer_tiktok' ) ) {

	if( ! TIELABS_TIKTOK_IS_ACTIVE ){
		TIELABS_HELPER::notice_message( esc_html__( 'This section requries the TikTok Plugin, You can install it from the Theme settings menu > Install Plugins.', TIELABS_TEXTDOMAIN ) );
	}
	else{

		$feeds = get_option( 'tiktok_feed_feeds' );
		if( empty( $feeds ) || ! is_array( $feeds ) ) {
			TIELABS_HELPER::notice_message( esc_html__( 'No accounts found, Go to TikTok Feed > Feeds to setup your account.', TIELABS_TEXTDOMAIN ) );
		}
		else{

			$id = tie_get_option( 'footer_tiktok_source' );
			$id = str_replace( 'tiktok-', '', $id );

			echo '<div id="footer-tiktok">';
			$tiktok = do_shortcode( '[tiktok-feed id="'. $id .'"]' );
			$tiktok = preg_replace( "/(&quot;limit&quot;:&quot;)(.*?)(&quot;)/",   '&quot;limit&quot;:&quot;6&quot;',   $tiktok );
			$tiktok = preg_replace( "/(&quot;columns&quot;:&quot;)(.*?)(&quot;)/", '&quot;columns&quot;:&quot;6&quot;', $tiktok );
			echo $tiktok;
			echo '</div>';
		}
	}
}
