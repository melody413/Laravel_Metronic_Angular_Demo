<?php
/**
 * Cryptocurrency All-in-One
 * WP Ultimate Crypto
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly



/**
 * Wrap the Shortcode of the Cryptocurrency All-in-One and remove the H2 title tag
 */
if ( TIELABS_CRYPTOALL_IS_ACTIVE ){

	add_filter( 'do_shortcode_tag','tie_crypto_allinone_shortcode', 10, 3 );
	function tie_crypto_allinone_shortcode($output, $tag, $attr){

		if( $tag != 'currencyprice' ){
			return $output;
		}

		$output = preg_replace( '/<h2\b[^>]*>(.*?)<\/h2>/i', '', $output );
		$output = str_replace( '="', 'xyz', $output );
		$output = str_replace( '= jQuery', 'xx jQuery', $output );
		$output = str_replace( '=', '</span><span class="bct-equal-sign">=</span>', $output );
		$output = str_replace( 'xyz', '="', $output );
		$output = str_replace( 'xx jQuery', '= jQuery', $output );
		$output = str_replace( '<input type="text" class="currency1value" value="1" />', '<input type="text" class="currency1value" value="1" /><span class="bct-currency-1">', $output );

		return '<div class="btc-calculator">'. $output .'</div>';
	}
}


/**
 * Crypto css file
 */
if ( TIELABS_CRYPTOALL_IS_ACTIVE || TIELABS_WPUC_IS_ACTIVE ){

	add_action( 'wp_enqueue_scripts', 'tie_crypto_enqueue_styles' );
	function tie_crypto_enqueue_styles(){
		wp_enqueue_style( 'tie-css-crypto', TIELABS_TEMPLATE_URL.'/assets/css/plugins/crypto'. TIELABS_STYLES::is_minified() .'.css', array(), TIELABS_DB_VERSION );
	}
}


/**
 * Add message if the post contanins shortcodes and the plugin is not active
 */
add_filter( 'TieLabs/shortcodes_check', 'tie_crypto_shortcodes_check', 10, 2 );
function tie_crypto_shortcodes_check( $message, $content ){

	// Cryptocurrency All-in-One Plugin
	if( ! TIELABS_CRYPTOALL_IS_ACTIVE ){

		$shortcodes_list = array(
			'[currencygraph',
			'[allcurrencies',
			'[cryptopayment',
			'[cryptodonation',
			'[cryptoethereum',
			'[currencyprice',
		);

		foreach( $shortcodes_list as $shortcode ){
			if( strpos( $content, $shortcode ) !== false ){
				$message .= TIELABS_HELPER::notice_message( sprintf(
					esc_html__( 'This section contains some shortcodes that requries the %2$s%1$s%3$s Plugin.', TIELABS_TEXTDOMAIN ),
					'<strong>Cryptocurrency All-in-One</strong>',
					'<a href="https://wordpress.org/plugins/cryptocurrency-prices/" target="_blank" rel="nofollow noopener">',
					'</a>'
				), false );

				break;
			}
		}
	}

	// WP Ultimate Crypto
	if( ! TIELABS_WPUC_IS_ACTIVE ){

		if( strpos( $content, '[wpcrypto_grid' ) !== false ){
			$message .= TIELABS_HELPER::notice_message( sprintf(
				esc_html__( 'This section contains some shortcodes that requries the %2$s%1$s%3$s Plugin.', TIELABS_TEXTDOMAIN ),
				'<strong>Ultimate Crypto</strong>',
				'<a href="https://wordpress.org/plugins/wp-ultimate-crypto/" target="_blank" rel="nofollow noopener">',
				'</a>'
			), false );
		}
	}

	return $message;
}
