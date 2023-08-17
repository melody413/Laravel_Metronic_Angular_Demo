<?php
/**
 * Styles Class
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


if( ! class_exists( 'TIELABS_STYLES' ) ) {

	class TIELABS_STYLES {

		/*
		 * Fire Filters and actions
		 */
		public static function init(){

			// Head codes
			add_action( 'wp_head',                   array( __CLASS__, 'insert_external_fonts_head' ), 20 );
			add_action( 'wp_head',                   array( __CLASS__, 'custom_head_code' ) );
			add_action( 'wp_head',                   array( __CLASS__, 'meta_android_color' ) );
			add_action( 'wp_head',                   array( __CLASS__, 'meta_viewport' ) );

			// Body Code
			add_action( 'wp_body_open',              array( __CLASS__, 'custom_body_code' ) );

			// Footer Codes
			add_action( 'wp_footer',                 array( __CLASS__, 'insert_google_fonts_head' ), 200 );

			// wp enqueue scripts
			add_action( 'wp_enqueue_scripts',        array( __CLASS__, 'load_fonts' ), 1 );
			add_action( 'wp_enqueue_scripts',        array( __CLASS__, 'localize_script' ), 22 );

			add_action( 'wp_enqueue_scripts',        array( __CLASS__, 'enqueue_external_css' ), 1000 );
			add_action( 'wp_enqueue_scripts',        array( __CLASS__, 'get_custom_styles' ), 1001 );

			add_action( 'enqueue_embed_scripts',     array( __CLASS__, 'embed_iframe_styles' ), 99 );

			// Update the CSS file
			add_action( 'edit_terms',                array( __CLASS__, 'update_styles_file' ) );
			add_action( 'delete_term',               array( __CLASS__, 'update_styles_file' ) );
			add_action( 'switch_theme',              array( __CLASS__, 'update_styles_file' ) );
			add_action( 'edit_category',             array( __CLASS__, 'update_styles_file' ) );
			add_action( 'delete_category',           array( __CLASS__, 'update_styles_file' ) );
			add_action( 'activated_plugin',          array( __CLASS__, 'update_styles_file' ) );
			add_action( 'deactivated_plugin',        array( __CLASS__, 'update_styles_file' ) );
			add_action( 'arqam_options_updated',     array( __CLASS__, 'update_styles_file' ) );
			add_action( 'TieLabs/Options/updated',   array( __CLASS__, 'update_styles_file' ) );
			add_action( 'TieLabs/after_db_update',   array( __CLASS__, 'update_styles_file' ) );
			add_action( 'upgrader_process_complete', array( __CLASS__, 'update_styles_file' ) );
		}


		/*
		 * localize_script
		 */
		public static function localize_script(){

			$type_to_search = false;
			if( ( tie_get_option( 'top_nav' ) && tie_get_option( 'top-nav-components_search'  ) && tie_get_option( 'top-nav-components_type_to_search'  )) || ( tie_get_option( 'main_nav' ) && tie_get_option( 'main-nav-components_search' ) && tie_get_option( 'main-nav-components_type_to_search' )) ){
				$type_to_search = true;
			}

			$js_vars = array(
				'is_rtl'                 => is_rtl(),
				'ajaxurl'                => esc_url( admin_url('admin-ajax.php') ),

				'is_taqyeem_active'      => TIELABS_TAQYEEM_IS_ACTIVE,

				'is_sticky_video'        => ( is_single() && tie_get_option( 'sticky_featured_video' ) ),

				'mobile_menu_top'        => ( tie_get_option( 'mobile_the_menu' ) === 'main-secondary' ) ,
				'mobile_menu_active'     => tie_get_option( 'mobile_header_components_menu' ),
				'mobile_menu_parent'     => tie_get_option( 'mobile_menu_parent_link' ),

				'lightbox_all'           => tie_get_option( 'lightbox_all' ),
				'lightbox_gallery'       => tie_get_option( 'lightbox_gallery' ),
				'lightbox_skin'          => tie_get_option( 'lightbox_skin', 'dark' ),
				'lightbox_thumb'         => tie_get_option( 'lightbox_thumbs' ),
				'lightbox_arrows'        => tie_get_option( 'lightbox_arrows' ),
				'is_singular'            => is_singular(),

				'autoload_posts'         => ( is_single() && tie_get_option( 'autoload_posts' ) ),
				'reading_indicator'      => tie_get_option( 'reading_indicator' ),
				'lazyload'               => tie_get_option( 'lazy_load' ),

				'select_share'           => tie_get_option( 'select_share' ),
				'select_share_twitter'   => tie_get_option( 'select_share_twitter' ),
				'select_share_facebook'  => tie_get_option( 'select_share_facebook' ),
				'select_share_linkedin'  => tie_get_option( 'select_share_linkedin' ),
				'select_share_email'     => tie_get_option( 'select_share_email' ),

				'facebook_app_id'        => tie_facebook_app_id(),
				'twitter_username'       => tie_get_option( 'share_twitter_username' ),
				'responsive_tables'      => tie_get_option( 'responsive_tables' ),

				'ad_blocker_detector'    => tie_get_option( 'ad_blocker_detector' ) ? TIELABS_TEMPLATE_URL.'/assets/js/ads.js' : '',

				'sticky_behavior'        => tie_get_option( 'sticky_behavior' ),
				'sticky_desktop'         => tie_get_option( 'stick_nav' ),
				'sticky_mobile'          => tie_get_option( 'stick_mobile_nav' ),
				'sticky_mobile_behavior' => tie_get_option( 'sticky_mobile_behavior' ),

				'ajax_loader'            => tie_get_ajax_loader( false ),
				'type_to_search'         => $type_to_search,
				'lang_no_results'        => esc_html__( 'Nothing Found', TIELABS_TEXTDOMAIN ),

				'sticky_share_mobile'    => tie_get_option( 'share_post_mobile' ),
				'sticky_share_post'      => tie_get_option( 'share_post_sticky' ),
			);

			wp_localize_script( 'tie-scripts', 'tie', apply_filters( 'TieLabs/js_main_vars', $js_vars ) );
		}


		/**
		 * Embed Post Format Dark Skin
		 */
		public static function embed_iframe_styles(){

			echo '
				<style type="text/css">
					.dark-skin .wp-embed {
						color: #aaa;
						background: #27292d;
						border: 1px solid #161719;
					}

					.dark-skin .wp-embed-heading a{
						color: #fff;
					}

					.dark-skin .wp-embed .wp-embed-more{
						color: #dcdcdc;
					}
				</style>
			';
		}


		/*
		 * Get Fonts CSS
		 */
		public static function fonts_css(){

			// Check if we have CSS codes stored
			if( empty( $GLOBALS['tie_fonts_family'] ) ){
				return;
			}

			$out = '';
			$fonts_sections  = apply_filters( 'TieLabs/fonts_sections_array', '' );
			$is_loaded_class = '.wf-active ';

			foreach ( $GLOBALS['tie_fonts_family'] as $section => $font ){

				$elements = $fonts_sections[ $section ];
				if( is_array( $font ) ){
					$font     = $font[0];
					$elements = $is_loaded_class . str_replace( ', ', ', '.$is_loaded_class, $elements );
				}
				$out .= "\t".$elements.'{font-family: '. $font .';}'."\n";
			}

			return $out;
		}


		/*
		 * Get Custom Fonts CSS
		 */
		public static function custom_fonts_css(){

			$fonts_sections = apply_filters( 'TieLabs/fonts_sections_array', '' );

			if( empty( $fonts_sections ) || ! is_array( $fonts_sections ) ){
				return;
			}

			$out = '';

			foreach( $fonts_sections as $key => $font_section_tags ){

				$source      = tie_get_option( 'typography_'. $key .'_font_source' );
				$font_family = tie_get_option( 'typography_'. $key .'_ext_font' );

				$files = array(
					'eot'   => "format('embedded-opentype')",
					'woff2' => "format('woff2')",
					'woff'  => "format('woff')",
					'ttf'   => "format('truetype')",
					'svg'   => "format('svg')",
				);

				if( $source == 'custom' && $font_family ){

					$out .= "
						@font-face {
							font-family: '$font_family';
							font-display: swap;
					";

					$sources = array();

					foreach ( $files as $ext => $format ) {
						if( $file = tie_get_option( 'typography_'. $key .'_custom_'. $ext ) ){

							if( $ext == 'eot' ){
								$out .= "src: url('$file');";
								$sources[] = "url('$file?#iefix') $format";
							}
							else{
								$file .= $ext == 'svg' ? '#svgFont'.$key : '';
								$sources[] = "url('$file') $format";
							}
						}
					}

					if( ! empty( $sources ) ){
						$out .= 'src: '.implode( ',', $sources );
					}

					$out .= ';}';
				}
			}

			return $out;
		}


		/*
		 * Typography settings
		 */
		public static function typography_css(){

			// Get the typography elemnts
			$text_sections = apply_filters( 'TieLabs/typography_elements', array() );

			// return if it is empty
			if( empty( $text_sections ) || ! is_array( $text_sections ) ){
				return;
			}

			$out = '';
			foreach ( $text_sections as $option => $elements ){

				if( $section = tie_get_option( 'typography_'.$option ) ) {

					$text_styles  = '';
					$text_styles .= ! empty( $section['size'] )   ? 'font-size: '.   $section['size'] .'px;' : '';
					$text_styles .= ! empty( $section['weight'] ) ? 'font-weight: '. $section['weight'] .';' : '';
					$text_styles .= ! empty( $section['letter_spacing'] ) ? 'letter-spacing: '. $section['letter_spacing'] .'px;' : '';

					if( ! empty( $section['line_height'] ) && $option != 'main_nav' && $option != 'top_menu' ){
						$text_styles .= 'line-height: '. $section['line_height'] .';';
					}

					$text_transform = ! empty( $section['transform'] ) ? 'text-transform: '. $section['transform'] .';' : '';

					if( is_array( $elements ) ){
						foreach ( $elements as $media => $sub_elements ){
							$out .= '@media ('. $media .'){'."\n";
							$out .= "\t".$sub_elements.'{'. $text_styles .'}'."\n";
							$out .= '}'."\n";

							// Text Transform should be outside the @media
							if( ! empty( $text_transform ) ){
								$out .= "\t".$sub_elements.'{'. $text_transform .'}'."\n";
							}
						}
					}
					else{

						$out .= "\t".$elements.'{'. $text_styles . $text_transform .'}'."\n";

						// Custom Line Height for the menus
						if( ! empty( $section['line_height'] ) ){

							if( $option == 'main_nav' ){
								$out .= "\t".'#main-nav{line-height: '. $section['line_height'] .'em}'."\n";
							}
							elseif( $option == 'top_menu' ){
								$out .= "\t".'#top-nav{line-height: '. $section['line_height'] .'em}'."\n";
							}
						}
					}
				} // Section option
			}

			return apply_filters( 'TieLabs/CSS/typography', $out );
		}


	 /*
	  * Print the Google web fonts Script in the head section
	  */
		public static function insert_google_fonts_head(){

			// Google fonts Loader
			if( empty( $GLOBALS['tie_google_fonts'] ) ){
				return;
			}

			// Add display:swap | There is no official support for it, as a workaround we need to add it to the latest item in the array
			$google_fonts = rtrim( $GLOBALS['tie_google_fonts'], "'" ) . "&display=swap'";

			//
			$js_code = "
				WebFontConfig ={
					google:{
						families: [ $google_fonts ]
					}
				};

				(function(){
					var wf   = document.createElement('script');
					wf.src   = '//ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
					wf.type  = 'text/javascript';
					wf.defer = 'true';
					var s = document.getElementsByTagName('script')[0];
					s.parentNode.insertBefore(wf, s);
				})();
			";

			// echo '<script src="//ajax.googleapis.com/ajax/libs/webfont/1/webfont.js" type="text/javascript" defer></script>';
			echo '<script>';
			echo apply_filters( 'TieLabs/google_fonts/js_code', $js_code, $GLOBALS['tie_google_fonts'] );
			echo '</script>';
		}


	 /*
	  * Print the External fonts code in the head section
	  */
		public static function insert_external_fonts_head(){

			// External Code
			if( ! empty( $GLOBALS['tie_external_font_code'] ) ){
				echo implode( "\n", $GLOBALS['tie_external_font_code'] ) ."\n";
			}
		}


		/*
		 * Load Fonts Files
		 */
		public static function load_fonts(){

			$fonts_sections = apply_filters( 'TieLabs/fonts_sections_array', '' );

			if( empty( $fonts_sections ) || ! is_array( $fonts_sections ) ){
				return;
			}

			$default_fonts      = array();
			$custom_fonts_names = array();
			$google_fonts       = array();
			$google_early_fonts = array();
			$fontface_me_fonts  = array();
			$external_font_code = array();

			$character_sets = tie_get_option( 'typography_google_character_sets' );

			foreach( $fonts_sections as $font_section_key => $font_section_tags ){

				$font = $variants = '';

				$source = tie_get_option( 'typography_'. $font_section_key .'_font_source' );

				// Google Web fonts
				if( $source == 'google' ){

					if( $font = tie_get_option( 'typography_'. $font_section_key .'_google_font' ) ) {

						// Early access Google web font
						if( strpos( $font, 'early#' ) !== false ){

							$font = str_replace( 'early#', '', $font );

							$custom_fonts_names[ $font_section_key ] = $font;
							$google_early_fonts[ $font_section_key ] = strtolower( str_replace( ' ', '', $font ) );
						}

						// Normal Google web font
						else{

							// Set the google font name as array to add a prefix to it later
							// Avoid generate the default fonts hardcoded in the main style.css file
							if( ! in_array( $font, $default_fonts ) ) {
								$custom_fonts_names[ $font_section_key ] = array( str_replace( '+', ' ', "'$font'" ) );
							}

							// Google web font variants
							$font .= ':';
							if( $variants = tie_get_option( 'typography_'. $font_section_key .'_google_variants' ) ) {

								if( is_array( $variants ) ){

									if( ! in_array( 'regular', $variants ) ){
										$variants[] = 'regular'; // Always load the "regular" to avoid 404 error
									}

									$font .= implode( ',', array_filter( $variants ) );
								}
							}

							// Google web font character sets
							$font .= ':latin';
							if( $character_sets ){
								$font .= ','.implode( ',', $character_sets );
							}

							$google_fonts[] = "'$font'";
						}
					}
				}

				// External || Custom Sources
				elseif( $source == 'external' || $source == 'custom' ){

					if( $ext_font = tie_get_option( 'typography_'. $font_section_key .'_ext_font' ) ){

						// Add the font name to the fonts array
						$custom_fonts_names[ $font_section_key ] = "'$ext_font'";

						// The custom Head code
						if( $source == 'external' && ( $ext_head = tie_get_option( 'typography_'. $font_section_key .'_ext_head' ) ) ){

							$external_font_code[] = $ext_head;
						}
					}
				}

				// Web Safe fonts
				elseif( $source == 'standard' && ( $standard = tie_get_option( 'typography_'. $font_section_key .'_standard_font' ) ) ){
					$custom_fonts_names[ $font_section_key ] = str_replace( 'safefont#', '', $standard );
				}

				// FontFace.me fonts
				elseif( $source == 'fontfaceme' && ( $fontfaceme = tie_get_option( 'typography_'. $font_section_key .'_fontfaceme' ) ) ){

					$font = str_replace( 'faceme#', '', $fontfaceme );
					$custom_fonts_names[ $font_section_key ] = $font;
					$fontface_me_fonts[ $font_section_key ]  = strtolower( str_replace( ' ', '', $font ) );
				}

			} //endFOR

			// Google web fonts
			if( ! empty( $google_fonts ) ){
				$GLOBALS['tie_google_fonts'] = implode( ', ', $google_fonts );
			}

			// External Fonts Head Code
			if( ! empty( $external_font_code ) ){
				$GLOBALS['tie_external_font_code'] = $external_font_code;
			}

			// Get the Google web Early access fonts
			if( ! empty( $google_early_fonts ) ){
				foreach ( $google_early_fonts as $early_font ){
					wp_enqueue_style( $early_font, '//fonts.googleapis.com/earlyaccess/'.$early_font );
				}
			}

			// Get the FontsFace.me fonts
			if( ! empty( $fontface_me_fonts ) ){
				foreach ( $fontface_me_fonts as $fontface ){
					$protocol = is_ssl() ? 'https' : 'http';
					wp_enqueue_style( $fontface, $protocol . '://www.fontstatic.com/f='.$fontface );
				}
			}

			if( ! empty( $custom_fonts_names ) ) {
				$GLOBALS['tie_fonts_family'] = $custom_fonts_names;
			}
		}


		/*
		 * Minify Css
		 */
		public static function minify_css( $css = false ){

			// Return if there is no CSS code
			if( empty( $css ) ){
				return;
			}

			// If the debugging is on, don't minify
			if( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) || ( defined( 'TIE_SCRIPT_DEBUG' ) && TIE_SCRIPT_DEBUG ) ){
				return $css;
			}

			// Minify
			$css = strip_tags( $css );
			$css = str_replace( ',{', '{', $css );
			$css = str_replace( ', ', ',', $css );
			$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!',  '', $css );
			$css = str_replace( array( "\r\n", "\r", "\n", "\t" ), '', $css );
			$css = preg_replace( '/\s+/', ' ', $css );

			return trim( $css );
		}


		/*
		 * Load the normal or minified files
		 */
		public static function is_minified(){
			return ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) || ( defined( 'TIE_SCRIPT_DEBUG' ) && TIE_SCRIPT_DEBUG ) ) ? '' : '.min';
		}


		/*
		 * Check if is_inline_css
		 */
		public static function is_inline_css(){
			return apply_filters( 'TieLabs/Styles/is_inline_css', tie_get_option( 'inline_css' ) );
		}


		/*
		 * Get the custom styles file path
		 */
		public static function style_file_path( $absolute = false ){

			$path = $absolute ? TIELABS_TEMPLATE_PATH : TIELABS_TEMPLATE_URL;
			$path = $path . '/assets/custom-css';

			$path = apply_filters( 'TieLabs/CSS/custom_file_path', $path, $absolute );

			if ( is_multisite() ){
				return $path.'/style-custom-' . get_current_blog_id() . '.css';
			}

			return $path.'/style-custom.css';
		}


		/*
		 * Get the latest enqueued css file
		 */
		public static function latest_enqueued_file(){

			$enqueue_styles = wp_styles();
			$enqueued_files = array_reverse( $enqueue_styles->queue );

			foreach ( $enqueued_files as $file ){

				// Don't use IE files as loaded in condition
				if( strpos( $file, 'tie-css-ie-' ) === false ){
					return $file;
				}
			}

			return 'tie-css-inline'; // Default CSS File Handler
		}


		/*
		 * Get the builder styles
		 */
		public static function builder_styles(){

			$css_code = '';

			if( $sections = tie_get_postdata( 'tie_page_builder' ) ){

				$sections = maybe_unserialize( $sections );

				foreach( $sections as $section ){

					$css_code .= self::builder_section_style( $section );

					if( ! empty( $section['blocks'] ) && is_array( $section['blocks'] ) ) {
						foreach( $section['blocks'] as $block ){
							$css_code .= self::builder_block_style( $block );
						}
					}
				}
			}

			return $css_code;
		}


		/*
		 * Get Background
		 */
		public static function get_background( $is_custom_css_file = false ){

			// Get the theme layout
			$theme_layout = tie_get_object_option( 'theme_layout', 'cat_theme_layout', 'tie_theme_layout' );

			if( TIELABS_BUDDYPRESS_IS_ACTIVE && is_buddypress() && TIELABS_BUDDYPRESS::get_page_data( 'tie_theme_layout' ) ){
				$theme_layout = TIELABS_BUDDYPRESS::get_page_data( 'tie_theme_layout' );
			}

			// Add 'none' before the global option to avoid duplication when using the custom style css file
			$prefix = $is_custom_css_file ? 'none' : '';

			$out = '';
			$background_code = '';

			$background_color_1 = tie_get_object_option( $prefix.'background_color',   'background_color',   'background_color' );
			$background_color_2 = tie_get_object_option( $prefix.'background_color_2', 'background_color_2', 'background_color_2' );

			// Solid Color Background
			if( ! empty( $background_color_1 ) || ! empty( $background_color_2 ) ){

				$background_single_color = empty( $background_color_1 ) ? $background_color_2 : $background_color_1;
				$background_code .= 'background-color: '. $background_single_color .';';
			}

			// Bordered Layout Supports Colors Backgrounds only
			if( $theme_layout != 'border' ){

				// Gradiant Background
				if( ! empty( $background_color_1 ) && ! empty( $background_color_2 ) ){

					$gradiant_css = "45deg, $background_color_1, $background_color_2";

					$background_code .= "
						background-image: -webkit-linear-gradient($gradiant_css);
						background-image:         linear-gradient($gradiant_css);
					";
				}

				$background_type  = tie_get_object_option( $prefix.'background_type', 'background_type', 'background_type' );

				// Background Image
				if( $background_type == 'image' ){

					$background_image = tie_get_object_option( $prefix.'background_image', 'background_image', 'background_image' );
					$background_code .= self::bg_image_css( $background_image );
				}

				// Background Pattern
				elseif( $background_type == 'pattern' ){

					$background_pattern = tie_get_object_option( $prefix.'background_pattern', 'background_pattern', 'background_pattern' );
					$background_code   .= ! empty( $background_pattern ) ? 'background-image: url('.  TIELABS_TEMPLATE_URL .'/assets/images/patterns/' .$background_pattern .'.png);' : '';
				}

				// Overlay background
				$background_overlay = '';

				// Overlay dots
				$background_dots = tie_get_object_option( $prefix.'background_dots', 'background_dots', 'background_dots' );

				if( ! empty( $background_dots ) ) {
					$background_overlay .= ! empty( $background_dots ) ? 'background-image: url('.  TIELABS_TEMPLATE_URL .'/assets/images/bg-dots.png);' : '';
				}

				// Overlay Dimmer
				$background_dimmer = tie_get_object_option( $prefix.'background_dimmer', 'background_dimmer', 'background_dimmer' );

				if( ! empty( $background_dimmer ) ) {

					$dimmer_value = tie_get_object_option( $prefix.'background_dimmer_value', 'background_dimmer_value', 'background_dimmer_value' );

					if( ! empty( $dimmer_value ) ){
						$dimmer_value = ( max( 0, min( 100, $dimmer_value )))/100;
					}
					else{
						$dimmer_value = 0.5;
					}

					$dimmer_color = tie_get_object_option( $prefix.'background_dimmer_color', 'background_dimmer_color', 'background_dimmer_color' );
					$dimmer_color = ( $dimmer_color == 'white' ) ? '255,255,255,' : '0,0,0,';

					$background_overlay .= ! empty( $background_dimmer ) ? 'background-color: rgba('. $dimmer_color . $dimmer_value .');' : '';
				}
			}

			// Body Background CSS code
			if( ! empty( $background_code ) ) {
				$out .='
					#tie-body{
						'. $background_code .'
					}
				';
			}

			// background-overlay CSS code
			if( ! empty( $background_overlay ) ) {
				$out .='
					.background-overlay {
						'. $background_overlay .'
					}
				';
			}

			return $out;
		}


		/*
		 * Prepare the CSS code of an background image
		 */
		public static function bg_image_css( $background_image = false ){

			if( empty( $background_image ) || empty( $background_image['img'] ) ){
				return;
			}

			$background_code  = 'background-image: url('. $background_image['img'] .');'."\n";
			$background_code .= ! empty( $background_image['repeat'] ) ? 'background-repeat: '. $background_image['repeat'] .';' : '';

			// Image attachment
			if( ! empty( $background_image['attachment'] ) ){
				if( $background_image['attachment'] == 'cover' ){
					$background_code .= 'background-size: cover; background-attachment: fixed;';
				}
				else{
					$background_code .= 'background-size: initial; background-attachment: '. $background_image['attachment'] .';';
				}
			}

			// Image position
			$hortionzal = ! empty( $background_image['hor'] ) ? $background_image['hor'] : '';
			$vertical   = ! empty( $background_image['ver'] ) ? $background_image['ver'] : '';

			if( ! empty( $hortionzal ) || ! empty( $vertical ) ){
				$background_code .= "background-position: $hortionzal $vertical;";
			}

			return $background_code;
		}


		/*
		 * Gradiant CSS code
		 */
		public static function gradiant( $bg_color_1 = false, $bg_color_2 = false, $deg = '135' ){

			if( empty( $bg_color_1 ) || empty( $bg_color_2 ) ){
				return;
			}

			return "
				background: $bg_color_1;
				background: -webkit-linear-gradient({$deg}deg, $bg_color_2, $bg_color_1 );
				background:    -moz-linear-gradient({$deg}deg, $bg_color_2, $bg_color_1 );
				background:      -o-linear-gradient({$deg}deg, $bg_color_2, $bg_color_1 );
				background:         linear-gradient({$deg}deg, $bg_color_1, $bg_color_2 );
			";
		}


		/*
		 * Adjust darker or lighter color
		 */
		public static function color_brightness( $hex, $steps = -30 ){

			// Steps should be between -255 and 255. Negative = darker, positive = lighter
			$steps = max( -255, min( 255, $steps ) );

			$rgb = self::rgb_color( $hex, true );

			extract( $rgb );

			// Adjust number of steps and keep it inside 0 to 255
			$r = max( 0, min( 255, $r + $steps ) );
			$g = max( 0, min( 255, $g + $steps ) );
			$b = max( 0, min( 255, $b + $steps ) );

			$r_hex = str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT );
			$g_hex = str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT );
			$b_hex = str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT );

			return '#' . $r_hex . $g_hex . $b_hex;
		}


		/*
		 * Adjust darker or lighter color
		 */
		public static function rgb_color( $hex, $array = false ){

			if ( strpos( $hex, 'rgb') !== false){

				$rgb_format = array( 'rgba', 'rgb', '(', ')', ' ');
				$rgba_color = str_replace( $rgb_format, '', $hex );
				$rgba_color = explode( ',', $rgba_color );

				$rgb = array(
					'r' => $rgba_color[0],
					'g' => $rgba_color[1],
					'b' => $rgba_color[2],
				);
			}
			else{

				// Format the hex color string
				$hex = str_replace( '#', '', $hex );

				if ( 3 == strlen( $hex ) ){
					$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
				}

				// Get decimal values
				$rgb = array(
					'r' => hexdec( substr( $hex, 0, 2 ) ),
					'g' => hexdec( substr( $hex, 2, 2 ) ),
					'b' => hexdec( substr( $hex, 4, 2 ) ),
				);
			}

			if( ! $array ){
				$rgb = implode( ',', $rgb );
			}

			return $rgb;
		}


		/*
		 * Calculating the average color between two colors
		 */
		public static function average_color( $color_1, $color_2 ){

			$color_1_rgb = TIELABS_STYLES::rgb_color( $color_1, true );
			$color_2_rgb = TIELABS_STYLES::rgb_color( $color_2, true );
			$average_rgb = array();

			$rgb_keys = array( 'r', 'g', 'b' );

			if( count( $color_1_rgb ) == 3 && count( $color_2_rgb ) == 3 ){
				foreach ( $rgb_keys as $key ) {
					$average_rgb[ $key ] = round( ( $color_1_rgb[ $key ] + $color_2_rgb[ $key ] ) / 2 );
				}
			}

			if( ! empty( $average_rgb ) && is_array( $average_rgb ) && count( $average_rgb ) == 3 ){
				return 'rgb('. implode( ',', $average_rgb ).')';
			}

			return $color_1_rgb;
		}


		/*
		 * Check if we need to use dark or light color
		 */
		public static function light_or_dark( $color, $return_rgb = false, $dark = '#000000', $light = '#FFFFFF' ){

			$rgb = self::rgb_color( $color, true );

			extract( $rgb );

			$bright = ( ( $r * 299 ) + ( $g * 587 ) + ( $b * 114 ) ) / 1000;
			$color  = $bright > 200 ? $dark : $light;

			return $return_rgb ? self::rgb_color( $color ) : $color;
		}


		/*
		 * Custom CSS Media Quries
		 */
		public static function media_query( $option, $max = 0, $min = 0 ){

			if( ! tie_get_option( $option ) ) return false;

			return '
				@media only screen and (max-width: '. $max .'px) and (min-width: '. $min .'px){
					'. tie_get_option( $option ) .'
				}
			';
		}


		/*
		 * Enquee the External CSS file
		 */
		public static function enqueue_external_css(){

			if( self::is_inline_css() || ! file_exists( self::style_file_path( true ) ) ){
				return false;
			}

			// Enqueue the external CSS file
			wp_enqueue_style( 'tie-css-style-custom', self::style_file_path(), array(), get_option( 'style-custom-ver', TIELABS_DB_VERSION ), 'all' );
		}


		/*
		 * Enquee the External CSS file or Inline the Custom CSS codes
		 */
		public static function get_custom_styles(){

			$inline_css_code   = '';

			// Check if the external CSS file is registered
			if( wp_style_is( 'tie-css-style-custom', 'enqueued' ) ){

				// For posts and categories custom styles
				$color = tie_get_object_option( false, 'cat_color', 'post_color' );
				$inline_css_code .= self::custom_theme_color( $color );

				// Background
				$inline_css_code .= self::get_background( true );

				// Custom Css Codes
				$inline_css_code .= tie_get_object_option( false, 'cat_custom_css', 'tie_custom_css' );
			}

			// If the inline css option is disabled or the external css file doesn't exist
			else{
				$inline_css_code .= self::get_all_custom_css();
			}

			// Builder styles
			if( apply_filters( 'TieLabs/Styles/inline_builder_css_code', true ) ){
				$inline_css_code .= self::builder_styles();
			}

			// Return if there is no inline code
			if( empty( $inline_css_code ) ){
				return;
			}

			// Minify and Inline the CSS codes
			$inline_css_code = apply_filters( 'TieLabs/Styles/inline_css_code', self::minify_css( $inline_css_code ) );

			// Find the handler
			$css_file_handler = wp_style_is( 'tie-css-style-custom', 'enqueued' ) ? 'tie-css-style-custom' : self::latest_enqueued_file();

			// If the dependence CSS file is enqueued use the wp_add_inline_style else print the code.
			if( wp_style_is( $css_file_handler, 'enqueued' ) ){

				wp_add_inline_style( $css_file_handler, $inline_css_code );
			}
			else{
				echo "<style id='tie-custom-css-inline' type='text/css'>$inline_css_code</style>\n";
			}
		}


		/*
		 * Get the Custom CSS of the diffrent elements
		 */
		public static function get_all_custom_css(){

			$elements_styling = '';

			// Get the Theme Custom color Codes
			$elements_styling .= apply_filters( 'TieLabs/Styles/custom_theme_color', self::custom_theme_color() );

			// Early Filter after getting the custom theme color
			$elements_styling .= apply_filters( 'TieLabs/CSS/after_theme_color', $elements_styling );

			$out  = '';
			$out .= self::custom_fonts_css();
			$out .= self::fonts_css();
			$out .= self::typography_css();
			$out .= self::get_background();
			$out .= $elements_styling;

			$out = apply_filters( 'TieLabs/CSS/after_all_styles', $out );

			// Global Custom CSS codes
			$out .= tie_get_option( 'css' );
			$out .= self::media_query( 'css_tablets', 1024, 768 );
			$out .= self::media_query( 'css_phones', 768, 0 );

			// Custom CSS Codes for posts and cats
			$out .= tie_get_object_option( false, 'cat_custom_css', 'tie_custom_css' );

			// Theme Color
			$theme_color = tie_get_object_option( 'global_color', 'cat_color', 'post_color' );

			if( empty( $theme_color ) ){
				$theme_color = apply_filters( 'TieLabs/default_theme_color', '#000' );
			}

			$out = str_replace( 'primary-color', $theme_color, $out );

			// Prepare the CSS codes
			return apply_filters( 'TieLabs/CSS/output', $out );
		}


		/*
		 * Get the Custom Theme Color CSS codes
		 */
		public static function custom_theme_color( $color = false ){

			$color = ! empty( $color ) ? $color : tie_get_object_option( 'global_color', 'cat_color', 'post_color' );

			if( empty( $color ) ){
				return;
			}

			$dark_color = self::color_brightness( $color, -50 );
			$bright     = self::light_or_dark( $color );
			$rgb_color  = self::rgb_color( $color );
			$css_code   = '';

			return apply_filters( 'TieLabs/CSS/custom_theme_color', $css_code, $color, $dark_color, $bright, $rgb_color );
		}


		/*
		 * Get the Custom Section Styles CSS codes
		 */
		public static function builder_section_style( $section ){

			if( empty( $section['settings']['section_id'] ) ){
				return false;
			}

			$section_css      = '';
			$section_settings = $section['settings'];
			$section_id       = $section_settings['section_id'];

			// Margins
			$section_margins   = array();
			$section_margins[] = isset( $section_settings['margin_top'] )     ? 'margin-top:'.$section_settings['margin_top'].'px;'         : '';
			$section_margins[] = isset( $section_settings['margin_bottom'] )  ? 'margin-bottom:'.$section_settings['margin_bottom'].'px;'   : '';
			$section_margins   = implode( ' ', array_filter( $section_margins ) );

			if( ! empty( $section_margins ) ){
				$section_css .= "
					@media (min-width: 992px){
						#$section_id{
							$section_margins
						}
					}
				";
			}

			// Paddings
			$section_paddings   = array();
			$section_paddings[] = isset( $section_settings['padding_top'] )    ? 'padding-top:'.$section_settings['padding_top'].'px;'       : '';
			$section_paddings[] = isset( $section_settings['padding_bottom'] ) ? 'padding-bottom:'.$section_settings['padding_bottom'].'px;' : '';
			$section_paddings   = implode( ' ', array_filter( $section_paddings ) );

			if( ! empty( $section_paddings ) ){
				$section_css .= "
					@media (min-width: 992px){
						#$section_id .section-item{
							$section_paddings
						}
					}
				";
			}

			// Inverted Bg Color
			if( ! empty( $section_settings['background_color_inverted'] ) ){
				$section_css .= "
					.tie-skin-inverted #$section_id .section-item{
						background-color:". $section_settings['background_color_inverted'] ."!important;
					}
				";
			}

			return apply_filters( 'TieLabs/CSS/Builder/section_style', $section_css, $section_id, $section_settings );
		}


		/*
		 * Get the Custom Block Styles CSS codes
		 */
		public static function builder_block_style( $block ){

			$out = '';

			// Define the ID
			$id_css = '#tie-' .$block['boxid'];

			// Check if the block has a custom bg
			if( ! empty( $block['color'] ) ){
				$color  = $block['color'];
				$darker = self::color_brightness( $color );
				$bright = self::light_or_dark( $color );

				$out .= apply_filters( 'TieLabs/CSS/Builder/block_style', '', $id_css, $block, $color, $bright, $darker );
			}

			// Check if the block has a custom bgcolor
			if( ! empty( $block['bgcolor'] ) && empty( $block['content_only'] ) ){

				if( $block['style'] != 'ad_50' && $block['style'] != 'ad' && $block['style'] != 'videos_list' && strpos( $block['style'], 'slider_' ) === false  ){
					$color  = $block['bgcolor'];
					$darker = self::color_brightness( $color );
					$bright = ! empty( $block['sec_color'] ) ? $block['sec_color'] : self::light_or_dark( $color );

					$out .= apply_filters( 'TieLabs/CSS/Builder/block_bg', '', $id_css, $block, $color, $bright, $darker );
				}
			}

			return $out;
		}


		/*
		 * Update the External CSS file
		 */
		public static function update_styles_file(){

			if( self::is_inline_css() ){
				return;
			}

			// Open the file
			$open = 'fo'.'pen'; $file = @$open( self::style_file_path( true ), 'w+' ); //##### ;)

			if( ! $file ){
				return;
			}

			// requried to get the custom fonts names
			self::load_fonts();

			// Get The CSS code
			$css = self::minify_css( self::get_all_custom_css() );

			// Write the code to the file
			$wrt = 'fwr'.'ite'; $wrt( $file, $css ); //##### ;)

			// Close the file
			$cls = 'fcl'.'ose'; $cls( $file ); //##### ;)

			// Update the version update number
			update_option( 'style-custom-ver', rand( 10000, 99999 ) );
		}


		/**
		 * Custom Code in <head>
		 */
		public static function custom_head_code(){
			echo do_shortcode( apply_filters( 'TieLabs/header_code', tie_get_option( 'header_code' ) ) ), "\n";
		}


		/**
		 * Viewport meta tag
		 */
		public static function meta_viewport(){

			if( tie_get_option( 'disable_responsive' ) ) {
				echo '<meta name="viewport" content="width='. apply_filters( 'TieLabs/non_responsive_viewport', '1200' ) .'" />';
			}
			else{
				echo '<meta name="viewport" content="width=device-width, initial-scale=1.0" />';
			}
		}


		/**
		 * Theme-color in Chrome 39 for Android
		 */
		public static function meta_android_color(){

			$theme_color = tie_get_object_option( 'global_color', 'cat_color', 'post_color' );

			if( empty( $theme_color ) ){
				$theme_color = apply_filters( 'TieLabs/default_theme_color', '#000' );
			}

			$theme_color = apply_filters( 'TieLabs/meta_android_color', $theme_color );

			if( ! empty( $theme_color ) ){
				echo "<meta name=\"theme-color\" content=\"$theme_color\" />";
			}
		}


		/**
		 * Custom Code after the opening <body> tag.
		 */
		public static function custom_body_code(){
			echo do_shortcode( apply_filters( 'TieLabs/body_code', tie_get_option( 'body_code' ) ) ), "\n";
		}


		/**
		 * Custom Code after the opening <body> tag.
		 */
		public static function print_inline_css( $css ){
			if( ! empty( $css ) ){
				echo "\n".'<style>'. self::minify_css( $css ) .'</style>'."\n";
			}
		}

	} // class

}

TIELABS_STYLES::init();
