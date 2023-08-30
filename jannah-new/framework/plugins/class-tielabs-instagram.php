<?php
/**
 * Instagram Class
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly



if( ! class_exists( 'TIELABS_INSTAGRAM_COMPATIBILITY' ) ) {

	class TIELABS_INSTAGRAM_COMPATIBILITY{

		/**
		 * __construct
		 *
		 * Class constructor where we will call our filter and action hooks.
		 */
		function __construct(){

			// Disable if the plugin is not active
			if( ! TIELABS_INSTAGRAM_FEED_IS_ACTIVE ){
				return;
			}

			// Add support for the plugin
			add_action( 'after_setup_theme',  array( $this, 'add_theme_support' ) );

			add_filter( 'TieLabs/Instagram_Feed/connect_redirect',  array( $this, 'connect_redirect' ) );

			// Style the front-end errors messages
			add_filter( 'TieLabs/Instagram_Feed/error', array( $this, 'style_errors' ) );

			// Enqueue the LightBox Js file
			add_action( 'TieLabs/Instagram_Feed/after_media_section', array( $this, 'load_lightbox' ) );
		}


		/**
		 *  Add support for the plugin
		 */
		function add_theme_support( $url ){
			add_theme_support( 'TieLabs_Instagram_Feed' );
		}

		/**
		 * Redirect back to the integration tab after authorization
		 */
		function connect_redirect( $url ){
			return $url . '#tie-options-tab-integrations-target';
		}

		/**
		 * Style the front-end errors messages
		 */
		function style_errors( $message ){
			return TIELABS_HELPER::notice_message( $message, false );
		}


		/**
		 * Enqueue the LightBox Js file
		 */
		function load_lightbox( $args ){

			if( ! empty( $args['link'] ) && $args['link'] == 'file' ){
				wp_enqueue_script( 'tie-js-ilightbox' );
			}
		}

	}


	// Instantiate the class
	new TIELABS_INSTAGRAM_COMPATIBILITY();
}
