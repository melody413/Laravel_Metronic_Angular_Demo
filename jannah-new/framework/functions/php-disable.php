<?php
/**
 * Prevents The theme from running on PHP Versions prior to 5.3.
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly



/**
 * Prevent switching on old versions of WordPress.
 */
add_action( 'after_switch_theme', 'tie_php_disable_switch_theme' );
function tie_php_disable_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );

	unset( $_GET['activated'] );

	add_action( 'admin_notices', 'tie_php_disable_upgrade_notice' );
}


/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch the theme
 */
function tie_php_disable_upgrade_notice() {
	$message = sprintf( esc_html__( 'This theme requires at least PHP version 5.3. You are running version %s. Please upgrade and try again.', TIELABS_TEXTDOMAIN ), phpversion() );
	printf( '<div class="error"><p>%s</p></div>', $message );
}


/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.4.
 */
add_action( 'load-customize.php', 'tie_php_disable_customize' );
function tie_php_disable_customize() {
	wp_die( sprintf( esc_html__( 'This theme requires at least PHP version 5.3. You are running version %s. Please upgrade and try again.', TIELABS_TEXTDOMAIN ), phpversion() ), '', array(
		'back_link' => true,
	) );
}


/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.4.
 */
add_action( 'template_redirect', 'tie_php_disable_preview' );
function tie_php_disable_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( esc_html__( 'This theme requires at least PHP version 5.3. You are running version %s. Please upgrade and try again.', TIELABS_TEXTDOMAIN ), phpversion() ));
	}
}
