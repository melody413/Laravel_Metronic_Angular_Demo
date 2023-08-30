<?php
/**
 * BuddyPress Class
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly



if( ! class_exists( 'TIELABS_BUDDYPRESS' ) ) {

	class TIELABS_BUDDYPRESS{

		/**
		 * __construct
		 *
		 * Class constructor where we will call our filter and action hooks.
		 */
		function __construct(){

			// Disable if the BuddyPress plugin is not active
			if( ! TIELABS_BUDDYPRESS_IS_ACTIVE ){
				return;
			}

			// Wrapper Start
			add_action( 'bp_before_group_body',                    array( $this, 'before_content' ) );
			add_action( 'bp_before_member_body',                   array( $this, 'before_content' ) );
			add_action( 'bp_before_register_page',                 array( $this, 'before_content' ) );
			add_action( 'bp_before_activation_page',               array( $this, 'before_content' ) );
			add_action( 'bp_before_directory_blogs',               array( $this, 'before_content' ) );
			add_action( 'bp_before_directory_groups',              array( $this, 'before_content' ) );
			add_action( 'bp_before_directory_members',             array( $this, 'before_content' ) );
			add_action( 'bp_before_directory_activity_content',    array( $this, 'before_content' ) );
			add_action( 'bp_before_create_group_content_template', array( $this, 'before_content' ) );

			// Wrapper End
			add_action( 'bp_after_group_body',                     array( $this, 'after_content' ) );
			add_action( 'bp_after_member_body',                    array( $this, 'after_content' ) );
			add_action( 'bp_after_register_page',                  array( $this, 'after_content' ) );
			add_action( 'bp_after_activation_page',                array( $this, 'after_content' ) );
			add_action( 'bp_after_directory_blogs',                array( $this, 'after_content' ) );
			add_action( 'bp_after_directory_groups',               array( $this, 'after_content' ) );
			add_action( 'bp_after_directory_members',              array( $this, 'after_content' ) );
			add_action( 'bp_after_directory_activity_content',     array( $this, 'after_content' ) );
			add_action( 'bp_after_create_group_content_template',  array( $this, 'after_content' ) );

			// Enqueue and Dequeue CSS files
			add_action( 'wp_enqueue_scripts', array( $this, 'dequeue_styles' ), 10 );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_resources' ), 5 );

			//
			add_action( 'bp_nouveau_enqueue_styles', array( $this, 'remove_default_buddypress_dependency' ), 20 );

			// Covers args
			add_filter( 'bp_before_members_cover_image_settings_parse_args', array( $this, 'cover_image_css' ), 1 );
			add_filter( 'bp_before_groups_cover_image_settings_parse_args',  array( $this, 'cover_image_css' ), 1 );

			// Notifications Menu Content
			add_filter( 'TieLabs/BuddyPress/notifications', array( $this, 'get_notifications' ) );

			// Js Vars
			add_filter( 'TieLabs/js_main_vars', array( $this, 'js_var' ) );

			// BuddyPress pages logo
			add_filter( 'TieLabs/Logo/args', array( $this, 'logo_args' ), 10, 2 );

			// BuddyPress Nouveau Templates
			add_theme_support('buddypress-use-nouveau');
		}


		/**
		 * BuddyPress Pages HTML markup | before content
		 */
		function before_content(){

			tie_html_before_main_content();

			echo '<div ' .tie_content_column_attr( false ). '>';
			echo '<div class="container-wrapper">';
		}


		/**
		 * BuddyPress Pages HTML markup | after content
		 */
		function after_content(){

			echo '<div class="clearfix"></div>';
			echo '</div><!-- .container-wrapper /-->';
			echo '</div><!-- .main-content  /-->';

			get_sidebar();
			tie_html_after_main_content();
		}


		/**
		 * Dequeue buddyPress Default Css files
		 */
		function dequeue_styles(){

			wp_dequeue_style( 'bp-nouveau' );
		}


		/**
		 * remove_default_buddypress_dependency
		 */
		function remove_default_buddypress_dependency( $styles ){

			foreach ( $styles as $file => $attr ) {

				$key = array_search( 'bp-nouveau', $attr['dependencies'], false );

				if( isset( $key ) ){
					$styles[$file]['dependencies'][$key] = 'tie-css-buddypress';
				}
			}

			return $styles;
		}


		/**
		 * Enqueue JS and CSS files
		 */
		function enqueue_resources(){

			// Enqueue buddyPress Custom Css file
			wp_enqueue_style( 'tie-css-buddypress', TIELABS_TEMPLATE_URL.'/assets/css/plugins/buddypress'. TIELABS_STYLES::is_minified() .'.css', array('dashicons'), TIELABS_DB_VERSION, 'all' );

			// For Grid Archives
			if( ! is_buddypress() ){
				return;
			}

			wp_enqueue_script( 'jquery-masonry' );

			$masonry_js = "
				jQuery(document).ready(function(){

					console.log( 'document ready' );

					jQuery( '#buddypress' ).on( 'bp_ajax_request', '.dir-list', function(){

						console.log( 'ajax-request' );

						if( jQuery.fn.masonry ){

							console.log( 'masonry Loaded' );

							var grid = jQuery('.bp-list.grid');

							if( grid.length ){

								grid.masonry({
									percentPosition : true,
									isInitLayout    : false, // v3
									initLayout      : false, // v4
									originLeft      : ! is_RTL,
									isOriginLeft    : ! is_RTL
								});

								setTimeout(function(){
									grid.masonry('layout');
								}, 1);

								if( jQuery.fn.imagesLoaded ){
									grid.imagesLoaded().progress( function(){
										grid.masonry('layout');
									});
								}
							}
						}
					});
				});
			";

			TIELABS_HELPER::inline_script( 'jquery-masonry', $masonry_js );
		}


		/**
		 * Notifications Menu Content
		 */
		function get_notifications(){

			$notifications = bp_notifications_get_notifications_for_user( bp_loggedin_user_id(), 'object' );
			$count         = ! empty( $notifications ) ? count( $notifications ) : 0;
			$menu_link     = trailingslashit( bp_loggedin_user_domain() . bp_get_notifications_slug() );
			$count         = (int) $count > 0 ? number_format_i18n( $count ) : '';

			$out_data = '<ul class="bp-notifications">';

			if ( ! empty( $notifications ) ){
				foreach ( (array) $notifications as $notification ){
					$out_data .= '<li id="'. $notification->id .'" class="notifications-item"><a href="'. $notification->href .'"><span class="tie-icon-bell"></span> '. $notification->content .'</a></li>';
				}
			}
			else {
				$out_data .= '<li id="no-notifications" class="notifications-item"><a href="'. $menu_link .'"><span class="tie-icon-bell"></span>  '. esc_html__( 'No new notifications', TIELABS_TEXTDOMAIN ) .'</a></li>';
			}

			$out_data .= '</ul>';

			return array(
				'data'  => $out_data,
				'count' => $count,
				'link'  => $menu_link,
			);
		}


		/**
		 * BuddyPress Cover Image
		 */
		function cover_image_css( $settings = array() ){

			$settings['callback']      = array( $this, 'cover_image_callback' );
			$settings['theme_handle']  = 'tie-css-buddypress';
			$settings['width']         = 1400;
			$settings['height']        = 440;
			$settings['default_cover'] = TIELABS_TEMPLATE_URL. '/assets/images/default-cover-image.jpg';

			return $settings;
		}


		/**
		 * BuddyPress Logo
		 */
		function logo_args( $logo_args, $logo_suffix ){

			if( ! is_buddypress() || ( is_buddypress() && ! self::get_page_data( 'custom_logo'.$logo_suffix ) ) ){
				return $logo_args;
			}

			$logo_args['logo_type']            = self::get_page_data( 'logo_setting'.$logo_suffix );
			$logo_args['logo_img']             = self::get_page_data( 'logo'.$logo_suffix );
			$logo_args['logo_retina']          = self::get_page_data( 'logo_retina'.$logo_suffix );
			$logo_args['logo_inverted']        = self::get_page_data( 'logo_inverted'.$logo_suffix );
			$logo_args['logo_inverted_retina'] = self::get_page_data( 'logo_inverted_retina'.$logo_suffix );
			$logo_args['logo_width']           = self::get_page_data( 'logo_retina_width'.$logo_suffix );
			$logo_args['logo_height']          = self::get_page_data( 'logo_retina_height'.$logo_suffix );
			$logo_args['logo_margin_top']      = self::get_page_data( 'logo_margin'.$logo_suffix );
			$logo_args['logo_margin_bottom']   = self::get_page_data( 'logo_margin_bottom'.$logo_suffix );
			$logo_args['logo_title']           = self::get_page_data( 'logo_text', get_bloginfo() );
			$logo_args['logo_url']             = self::get_page_data( 'logo_url'.$logo_suffix );

			return $logo_args;
		}


		/**
		 * Cover Image CSS
		 */
		function cover_image_callback( $params = array() ){

			if ( empty( $params ) ){
				return;
			}

			$background_attr = '';

			if( $params['cover_image'] == TIELABS_TEMPLATE_URL. '/assets/images/default-cover-image.jpg' ){
				$background_attr = '
		    	background-repeat: repeat !important;
		    	background-size: 400px !important;
		    ';
			}

			return '
				#buddypress #header-cover-image {
					background-image: url(' . $params['cover_image'] . ');
					'. $background_attr .'
				}
			';
		}


		/**
		 * BuddyPress Current Page ID
		 */
		public static function current_page_id(){

			global $bp;

			if( bp_is_user() || bp_is_current_component( 'members' ) ){
				return ! empty( $bp->pages->members->id ) ? $bp->pages->members->id : false;
			}

			if( bp_is_current_component( 'groups' ) ){
				return ! empty( $bp->pages->groups->id ) ? $bp->pages->groups->id : false;
			}

			if( bp_is_current_component( 'activity' ) ){
				return ! empty( $bp->pages->activity->id ) ? $bp->pages->activity->id : false;
			}

			if( bp_is_current_component( 'register' ) ){
				return ! empty( $bp->pages->register->id ) ? $bp->pages->register->id : false;
			}

			return false;
		}


		/**
		 * Get BuddyPress Custom Option
		 */
		public static function get_page_data( $key, $default = false ){

			if( self::current_page_id() ){

				if( $value = get_post_meta( self::current_page_id(), $key, $single = true ) ) {
					return $value;
				}
			}

			if( $default ){
				return $default;
			}

			return false;
		}


		/**
		 * Add is_buddypress to main tie js var
		 */
		public static function js_var( $array ){

			$array['is_buddypress_active'] = true;

			return $array;
		}

	}

	// Instantiate the class
	new TIELABS_BUDDYPRESS();
}
