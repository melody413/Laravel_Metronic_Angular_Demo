<?php
/**
 * Open Graph
 *
 */


defined( 'ABSPATH' ) || exit; // Exit if accessed directly


if( ! class_exists( 'TIELABS_OPENGRAPH' ) ) {

	class TIELABS_OPENGRAPH {

		/**
		 * Runs on class initialization. Adds filters and actions.
		 */
		function __construct() {

			add_action( 'wp_head', array( $this, 'insert_opengraph' ), 5 );
			add_filter( 'language_attributes', array( $this, 'opengraph_namespace' ) );
		}


		/**
		 * Open Graph Meta for posts
		 */
		function insert_opengraph(){

			// Check if single and og is active and there is no OG plugin is active
			if( self::is_active() || ! is_singular() || ! tie_get_option( 'post_og_cards' ) ){
				return;
			}

			$post           = get_post();
			$og_title       = the_title_attribute( 'echo=0' ) . ' - ' . get_bloginfo('name');
			$og_description = apply_filters( 'TieLabs/exclude_content', $post->post_content );
			$og_description = strip_tags( strip_shortcodes( $og_description ) );
			$og_type        = 'article';

			if( is_home() || is_front_page() ){
				$og_title       = get_bloginfo( 'name' );
				$og_description = get_bloginfo( 'description' );
				$og_type        = 'website';
			}

			echo '
<meta property="og:title" content="'. $og_title .'" />
<meta property="og:type" content="'. $og_type .'" />
<meta property="og:description" content="'. esc_attr( wp_html_excerpt( $og_description, 100 ) ) .'" />
<meta property="og:url" content="'. get_permalink() .'" />
<meta property="og:site_name" content="'. get_bloginfo( 'name' ) .'" />
';

			if ( has_post_thumbnail() || tie_get_option( 'post_og_cards_image' ) ){

				$image = has_post_thumbnail() ? tie_thumb_src( TIELABS_THEME_SLUG.'-image-post' ) : tie_get_option( 'post_og_cards_image' );
echo '<meta property="og:image" content="'. esc_url( $image ) .'" />'."\n";
			}
		}


		/**
		 * Add the opengraph namespace to the <html> tag
		 */
		function opengraph_namespace( $input ){

			// Check if single and og is active and there is no OG plugin is active
			if( is_admin() || self::is_active() || ! is_singular() || ! tie_get_option( 'post_og_cards' ) ) {
				return $input;
			}

			return $input.' prefix="og: http://ogp.me/ns#"';
		}


		/**
		 * Check if an open graph plugin active
		 */
		public static function is_active(){

			$is_active = false;

			// Yoast SEO
			if( class_exists( 'WPSEO_Frontend' ) ){
				$yoast = get_option( 'wpseo_social' );
				if( ! empty( $yoast['opengraph'] ) ) {
					$is_active = true;
				}
			}

			// Open Graph and Twitter Card Tags
			elseif( class_exists( 'Webdados_FB' ) ){
				$is_active = true;
			}

			return apply_filters( 'TieLabs/is_opengraph_active', $is_active );
		}

	}

	// Single instance
	$TIELABS_OPENGRAPH = new TIELABS_OPENGRAPH();
}
