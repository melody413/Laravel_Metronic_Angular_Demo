<?php
/**
 * Tielabs Extensions Class
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly



if( ! class_exists( 'TIELABS_EXTENSIONS' ) ) {

	class TIELABS_EXTENSIONS{

		/**
		 * __construct
		 *
		 * Class constructor where we will call our filter and action hooks.
		 */
		function __construct(){

			add_filter( 'TieLabs/shortcodes_check', array( $this, 'shortcodes_check' ), 10, 2 );

			// Disable if the plugin is not active
			if( ! TIELABS_EXTENSIONS_IS_ACTIVE ){
				return;
			}

			// Add the Post Index Module
			add_action( 'TieLabs/before_single_post_title', array( $this, 'post_index' ) );

			// Replace the old icon classes with the new classes of Font Awesome 5.0
			add_action( 'tie/extensions/shortcodes/button/icon', array( $this, 'replace_icon_fa5' ) );
		}


		/**
		 * Post Index Module
		 */
		function post_index(){

			if( tie_get_option( 'autoload_posts' ) && is_singular( 'post' ) ){
				return;
			}

			$post = get_post();

			$pattern = '\[(\[?)(tie_index)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)';

			if( preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches )
			    && array_key_exists( 2, $matches )
			    && in_array( 'tie_index', $matches[2] ) ){

				echo '
					<div id="story-index">
						<div class="theiaStickySidebar">
						<span id="story-index-icon" class="tie-icon-list" aria-hidden="true"></span>
							<div class="story-index-content">
								<ul>';

									foreach ( $matches[5] as $title ){

										$index_id = sanitize_title( $title );
										$index_id = preg_replace( '/[^A-Za-z0-9\-]/', '', $index_id ); // Remove all special characters to fix an issue with non-latin languages

										echo '<li><a id="trigger-'. $index_id .'" href="#go-to-'. $index_id .'">'. $title .'</a></li>';
									}

									echo '
								</ul>
							</div>
						</div>
					</div>
				';

				// Load the file contains the requrired js codes
				wp_enqueue_script( 'tie-js-viewport' );

			}
		}


		/**
		 * Add message if the post contanins shortcodes and the plugin is not active
		 */
		function shortcodes_check( $message, $content ){

			if( TIELABS_EXTENSIONS_IS_ACTIVE ){
				return $message;
			}

			$shortcodes_list = array(
				'[divider',
				'[tie_list',
				'[dropcap',
				'[tie_full_img',
				'[padding',
				'[button',
				'[tie_tooltip',
				'[highlight',
				'[tie_index',
				'[tie_slideshow',
			);

			foreach( $shortcodes_list as $shortcode ){
				if( strpos( $content, $shortcode ) !== false ){
					$message .= TIELABS_HELPER::notice_message( sprintf(
						esc_html__( 'This section contains some shortcodes that requries the %s Plugin. Install it from the Theme Menu &gt; Install Plugins.', TIELABS_TEXTDOMAIN ),
						'<strong>Jannah Extinsions</strong>'
					), false );

					break;
				}
			}

			return $message;
		}


		/**
		 * Replace the old icon classes with the new classes of Font Awesome 5.0
		 */
		function replace_icon_fa5( $icon ){
			return tie_fa4_to_fa5_value_migration( $icon );
		}
	}


	// Instantiate the class
	new TIELABS_EXTENSIONS();
}
