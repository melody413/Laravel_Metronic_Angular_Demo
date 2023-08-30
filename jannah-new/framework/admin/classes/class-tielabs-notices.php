<?php
/**
 * Dashboard Notices
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


if( ! class_exists( 'TIELABS_NOTICES' ) ){

	class TIELABS_NOTICES {

		public static $is_hooked = false;
		public static $is_hooked_popup = false;


		/**
		 * Runs on class initialization. Adds filters and actions.
		 */
		function __construct() {

			//Debug
			//delete_user_meta( get_current_user_id(), 'dismissed_wp_pointers' );
			//delete_transient( 'tie_milestone_check' );

			add_action( 'admin_enqueue_scripts', array( $this, 'load_notices' ) );
		}


		/**
		 * Enqueue the pointers styles and scripts
		 */
		function load_notices(){

			// Current Screen
			$current_page = ! empty( get_current_screen()->base ) ? get_current_screen()->base : '';

			// Check if current page is the theme options page
			$theme_pages = ! empty( get_current_screen()->tiebase ) ? get_current_screen()->tiebase : '';

			// Display the live message on the homepage and theme option pages only
			if ( $theme_pages == 'toplevel_page_tie-theme-options' || $current_page == 'dashboard' ){
				add_action( 'admin_notices', array( $this, 'live_message' ), 105 );
			}

			// --
			if ( $theme_pages == 'toplevel_page_tie-theme-options' ){

				// Need Help pointer
				if( ! self::is_dismissed( 'tie_need_help_'. TIELABS_THEME_SLUG ) ){

					add_action( 'admin_print_footer_scripts', array( $this, 'need_help_script' ) );
					wp_enqueue_style ( 'wp-pointer' );
					wp_enqueue_script( 'wp-pointer' );
				}

				add_action( 'admin_notices', array( $this, 'happy_new_year' ),       105 );
				add_action( 'admin_notices', array( $this, 'new_update' ),           105 );
				add_action( 'admin_notices', array( $this, 'rate_theme' ),           105 );
				add_action( 'admin_notices', array( $this, 'new_milestone' ),        105 );
				add_action( 'admin_notices', array( $this, 'happy_anniversary' ),    105 );
				add_action( 'admin_notices', array( $this, 'rate_theme_version_5' ), 115 );

				add_action( 'TieLabs/Dashboard_tab/before_news', array( $this, 'theme_translation' ), 105 );
			}

			do_action( 'tie_admin_notices' );
		}


		/**
		 * Check Dismissed Notices
		 */
		public static function is_dismissed( $name ){

			$dismissed_notices = explode( ',', get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );

			if( in_array( sanitize_key( $name ), $dismissed_notices ) ){
				return true;
			}

			return false;
		}


		/**
		 * Check if already there is a notice message
		 */
		public static function is_hooked(){

			if( self::$is_hooked ){
				return true;
			}

			self::$is_hooked = true;

			return false;
		}


		/**
		 * Check if already there is a pop notice message
		 */
		public static function is_hooked_popup(){

			if( self::$is_hooked_popup ){
				return true;
			}

			self::$is_hooked_popup = true;

			return false;
		}


		/**
		 * Need Help Script
		 */
		function need_help_script(){
			$pointer_content  = '<h3>'. esc_html__( 'Need Help?', TIELABS_TEXTDOMAIN ) .'</h3>';
			$pointer_content .= '<p>'. sprintf( esc_html__( 'Click on the help icon %s if you need help.', TIELABS_TEXTDOMAIN ), '<span class="dashicons dashicons-editor-help"></span>' ) .'</p>'; ?>

			<script>
				//<![CDATA[
				jQuery(document).ready( function($){
					$('#help-icon-general-settings-tab').pointer({
						content: '<?php echo wp_kses_post( $pointer_content ); ?>',
						pointerWidth:	350,
						position: {
							edge : 'top',
							align: 'middle',
						},
						close: function(){
							$.post( ajaxurl, {
								pointer: 'tie_need_help_<?php echo esc_js( TIELABS_THEME_SLUG ) ?>',
								action : 'dismiss-wp-pointer',
							});
						}
					}).pointer('open');
				});
				//]]>
			</script>
			<?php
		}


		/**
		 * Happy New Year :)
		 */
		function happy_new_year(){

			$new_year_dates = array(
				'today_date'         => time(),
				'first_congrats_day' => mktime( 0, 0, 0, 12, 25 ),
				'last_congrats_day'  => mktime( 0, 0, 0, 1, 5 ),
				'first_dat_new_year' => mktime( 0, 0, 0, 1, 1 ),
				'the_new_year'       => date( 'Y' )+1,
			);

			if( $new_year_dates['today_date'] >= $new_year_dates['first_dat_new_year'] && $new_year_dates['today_date'] < $new_year_dates['last_congrats_day'] ){
				$new_year_dates['the_new_year'] = date( 'Y' );
			}

			$notice_id = 'tie_happy_new_year_'.$new_year_dates['the_new_year'];

			if ( ! self::is_dismissed( $notice_id ) && ( $new_year_dates['today_date'] >= $new_year_dates['first_congrats_day'] || $new_year_dates['today_date'] < $new_year_dates['last_congrats_day'] ) ){

				if( self::is_hooked() ){
					return false;
				}

				$notice_content  = '<h4>'. esc_html__( 'Happy New Year!', TIELABS_TEXTDOMAIN ) .'</h4>';
				$notice_content .= '<p>'. esc_html__( 'To our client who have made our progress possible, All of us at TieLabs join in wishing you a Happy New Year with the best of everything in your life for you and your family and we look forward to serving you in the new year :)', TIELABS_TEXTDOMAIN ) .'</p>';
				$notice_content .= '<p>'. sprintf(
					esc_html__( 'Follow us on %1$sTwitter%3$s or %2$sFacebook%3$s.', TIELABS_TEXTDOMAIN ),
					'<a href="http://twitter.com/tielabs" target="_blank">',
					'<a href="https://www.facebook.com/tielabs" target="_blank">',
					'</a>'
				) .'</p>';

				echo '<div id="tie-page-overlay" class="is-notice-dismissible" data-id="'. $notice_id .'" style="bottom: 0; opacity: 0.8;"></div>';

				self::message( array(
					'notice_id' => $notice_id,
					'title'     => '&#x1f38a;',
					'message'   => $notice_content,
					'class'     => 'sucess tie-popup-block tie-popup-window tie-notice-popup tie-yay',
				));
			}
		}


		/**
		 * Rate V5
		 */
		function rate_theme_version_5(){

			/*$install_date = get_option( 'tie_install_date_'. TIELABS_THEME_ID );

			if( empty( $install_date ) || $install_date > 1597328527 ){ // If the install date is after 13 Aug
				return false;
			}
			*/

			$notice_id = 'tie_bigupdate_date_'. TIELABS_THEME_ID;

			if ( self::is_dismissed( $notice_id ) || self::is_hooked_popup() ){
				return false;
			}

			$the_rate = tie_get_latest_theme_data( 'rating' );

			if( empty( $the_rate ) || $the_rate > 3 ){ // Check the user rate first
				return false;
			}

			if( ! get_option( $notice_id ) ){
				update_option( $notice_id, time(), false );
			}
			else{

				if( ( time() - get_option( $notice_id ) ) < ( 2 * DAY_IN_SECONDS ) ){
					return false;
				}

				$notice_content  = '<h4 style="color: #9200c6; font-size: 26px;">'. esc_html__( 'Biggest Update Ever', TIELABS_TEXTDOMAIN ) .'</h4>';
				$notice_content .= '<p style="font-size: 16px; margin-bottom: 10px;">'. esc_html__( 'We want to provide you with a great experience which is why we want to hear from you. Your feedback helps us bring you more of the features you love and the improvements you expect.', TIELABS_TEXTDOMAIN ) .'</p>';
				$notice_content .= '<p style="font-size: 16px; margin-bottom: 25px;">'. esc_html__( 'Thank you in advance for your collaboration. We really appreciate your time!', TIELABS_TEXTDOMAIN ) .'</p>';
				$notice_content .= '<a href="'. tie_get_purchase_link( array( 'utm_medium' => 'rate-v5' ) ) .'" target="_blank" style="background-color: #9200c6; border:none; font-size: 20px; margin: 0 10%; width: 80%; text-align:center;" class="button button-primary button-hero">'. esc_html__( 'Leave a Review on ThemeForest', TIELABS_TEXTDOMAIN ) .'</a>';

				echo '<div id="tie-page-overlay" class="is-notice-dismissible" data-id="'. $notice_id .'" style="bottom: 0; opacity: 0.8;"></div>';

				self::message( array(
					'notice_id' => $notice_id,
					'title'     => '<img style="max-width: 300px;" src="'. TIELABS_TEMPLATE_URL .'/framework/admin/assets/images/jannah-5.png" />',
					'message'   => $notice_content,
					'class'     => 'sucess tie-popup-block tie-popup-window tie-notice-popup tie-yay',
				));
			}
		}


		/**
		 * Rate the Theme
		 */
		function rate_theme(){

			$install_date = get_option( 'tie_install_date_'. TIELABS_THEME_ID );

			if( empty( $install_date ) || $install_date > 1598832000 ){ // If the install date is after 31 Aug

				$notice_id = 'tie_install_date_'. TIELABS_THEME_ID;

				if ( self::is_dismissed( $notice_id ) || tie_is_theme_rated() || self::is_hooked_popup() ){
					return false;
				}

				if( ! get_option( $notice_id ) ){
					update_option( $notice_id, time(), false );
				}
				else{

					if( ( time() - get_option( $notice_id ) ) < ( 10 * DAY_IN_SECONDS ) ){
						return false;
					}

					$notice_content  = '<h4>'. sprintf( esc_html__( 'Like %s?', TIELABS_TEXTDOMAIN ), apply_filters( 'TieLabs/theme_name', 'TieLabs' ) ) .'</h4>';
					$notice_content .= sprintf(
						esc_html__( 'We\'ve noticed you\'ve been using %1$s for some time now; we hope you love it! We\'d be thrilled if you could %2$sgive us a 5* rating on themeforest.net!%4$s If you are experiencing issues, please %3$sopen a support ticket%4$s and we\'ll do our best to help you out.', TIELABS_TEXTDOMAIN ),
						apply_filters( 'TieLabs/theme_name', 'TieLabs' ),
						'<a href="'. tie_get_purchase_link( array( 'utm_medium' => 'rate-popup' ) ) .'" target="_blank">',
						'<a href="'. apply_filters( 'TieLabs/External/open_ticket', '' ) .'" target="_blank">',
						'</a>'
					);

					echo '<div id="tie-page-overlay" class="is-notice-dismissible" data-id="'. $notice_id .'" style="bottom: 0; opacity: 0.8;"></div>';

					self::message( array(
						'notice_id' => $notice_id,
						'title'     => '&#x2b50;',
						'message'   => $notice_content,
						'class'     => 'sucess tie-popup-block tie-popup-window tie-notice-popup tie-yay',
					));
				}

			}

			// An Update
			else{

				$install_date = 'tie_install_date_'. TIELABS_THEME_ID;
				$notice_id    = $install_date . '-1';

				if ( self::is_dismissed( $notice_id ) || tie_is_theme_rated() || self::is_hooked_popup() ){
					return false;
				}

				if( ! get_option( $install_date ) ){
					update_option( $install_date, time(), false );
				}
				else{

					if( ( time() - get_option( $install_date ) ) < ( 5 * DAY_IN_SECONDS ) ){
						return false;
					}

					$notice_content  = '<h4 style="color: #9200c6; font-size: 26px;">'. esc_html__( 'Biggest Update Ever', TIELABS_TEXTDOMAIN ) .'</h4>';
					$notice_content .= '<p style="font-size: 16px; margin-bottom: 10px;">'. esc_html__( 'Jannah 5 contains more than 130 new features and improvements, We hope you love it, We\'d be thrilled if you could rate Jannah 5 stars &#x2b50;&#x2b50;&#x2b50;&#x2b50;&#x2b50; on ThemeForest.', TIELABS_TEXTDOMAIN ) .'</p>';
					$notice_content .= '<p style="font-size: 16px; margin-bottom: 25px;">'. esc_html__( 'Thank you in advance, We really appreciate your time!', TIELABS_TEXTDOMAIN ) .' &#x1F60A;</p>';
					$notice_content .= '<a href="'. tie_get_purchase_link( array( 'utm_medium' => 'rate-v5-new' ) ) .'" target="_blank" style="background-color: #9200c6; border:none; font-size: 20px; margin: 0 10%; width: 80%; text-align:center;" class="button button-primary button-hero">'. esc_html__( 'Leave a Review on ThemeForest', TIELABS_TEXTDOMAIN ) .'</a>';

					echo '<div id="tie-page-overlay" class="is-notice-dismissible" data-id="'. $notice_id .'" style="bottom: 0; opacity: 0.8;"></div>';

					self::message( array(
						'notice_id' => $notice_id,
						'title'     => '<img style="max-width: 300px;" src="'. TIELABS_TEMPLATE_URL .'/framework/admin/assets/images/jannah-5.png" />',
						'message'   => $notice_content,
						'class'     => 'sucess tie-popup-block tie-popup-window tie-notice-popup tie-yay',
					));
				}
			}

		}


		/**
		 * Share the Theme Translations
		 */
		function theme_translation(){

			$locale = get_locale();
			$notice_id = 'tie_translate_theme_'.$locale.'_'.TIELABS_THEME_ID;

			// Don't show the message if the site's language is English
			if( strpos( $locale, 'en_' ) !== false ){
				return false;
			}

			// Show the Message after 5 days of installing the theme
			if( get_option( 'tie_install_date_'. TIELABS_THEME_ID ) && ( time() - get_option( 'tie_install_date_'. TIELABS_THEME_ID) ) < ( 5 * DAY_IN_SECONDS ) ){
				return false;
			}

			$remote_languages  = tie_get_latest_theme_data( 'translations' );
			$translation_meter = ! empty( $remote_languages[ $locale ] ) ? str_replace( '%', '', $remote_languages[ $locale ] ) : 0;

			if( empty( $remote_languages ) || $translation_meter > 90 || self::is_dismissed( $notice_id ) ){
				return false;
			}

			// Prepare the Meter
			if( ! function_exists( 'wp_get_available_translations' ) ){
				require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );
			}

			$translations = wp_get_available_translations();
			$native_name  = ! empty( $translations[ $locale ]['native_name'] ) ? $translations[ $locale ]['native_name'] : $translations[ $locale ]['english_name'];

			// The Message
			$notice_content = '<p>'.
			sprintf(
				esc_html__( '%1s comes localization-ready out of the box. All that’s needed is a translation file for your language, Contribute in our translation portal to complete the %2s translation, In exchange, we offer %3sExtra 6 Months FREE TieLabs Support*%4s to the most 3 contributors for each completed translation. Thank you very much for your contribution.', TIELABS_TEXTDOMAIN ),
				apply_filters( 'TieLabs/theme_name', 'TieLabs' ),
				$native_name,
				'<strong>',
				'</strong>'
			) .'</p>';


			$notice_content .= '
				<div class="translations-meter-outer">
					<span style="width:'. $translation_meter .'%"></span>'.
					sprintf( esc_html__( '%1s Translation Status: %2s Done', TIELABS_TEXTDOMAIN ), $native_name, '<strong>'. $translation_meter .'%</strong>') .'
				</div>
			';

			$notice_content .= '<em><small>'. esc_html__( '* The extra support will appear in your profile on our website, support center and in the theme dashboared only. it will not appear on ThemeForest.', TIELABS_TEXTDOMAIN ) .'</small></em><div class="clearfix"></div>';

			self::message( array(
				'notice_id'   => $notice_id,
				'title'       => esc_html__( 'Get Extra FREE 6 Months Support period', TIELABS_TEXTDOMAIN ),
				'message'     => $notice_content,
				'color'       => '#A770EF',
				'button_text' => esc_html__( 'Go to the Translation Portal', TIELABS_TEXTDOMAIN ),
				'button_url'  => apply_filters( 'TieLabs/translations_panel_url', '' ),
			));
		}


		/**
		 * New Theme Update
		 */
		function new_update(){

			$notice_id = 'tie_new_updates_'. TIELABS_THEME_ID;

			if ( ! self::is_dismissed( $notice_id ) && $changelog = get_option( 'tie_chnagelog_'. TIELABS_THEME_ID ) ){

				// There is any popup ? if no set it to TRUE
				if( self::is_hooked_popup() ){
					return false;
				}

				$changelog       = array_filter( explode( PHP_EOL, $changelog ),  'strlen' );
				$notice_content  = '<h4>'. esc_html__( 'YAY, New Features', TIELABS_TEXTDOMAIN ) .'</h4>';
				$notice_content .= '<ul><li><span class="dashicons dashicons-yes"></span> '. implode( '</li><li> <span class="dashicons dashicons-yes"></span> ', $changelog ) . '</li></ul>';
				$notice_content .= '
					<div class="tie-message-hint">
						<strong>'. esc_html__( 'IMPORTANT', TIELABS_TEXTDOMAIN ) .'</strong><br />'.
						esc_html__( "After updating, Clear the site's cache, CDN cache and your browser's cache.", TIELABS_TEXTDOMAIN ) .'
						<a href="https://tielabs.com/go/jannah-clear-cache" target="_blank">'. esc_html__( 'How to Clear Cache', TIELABS_TEXTDOMAIN ) .'</a>
					</div>
				';

				// If the Customer already rated the theme and the rate is > 3 hide the rate button
				if( ! tie_is_theme_rated() ){

					$notice_content .= '<span class="awesome">'. esc_html__( 'Awesome, isn\'t it? Give us some love :)', TIELABS_TEXTDOMAIN ) .'</span>';
					$button_text     = sprintf( esc_html__( 'Rate %s', TIELABS_TEXTDOMAIN ), apply_filters( 'TieLabs/theme_name', 'TieLabs' ) );
				}

				echo '<div id="tie-page-overlay" class="is-notice-dismissible" data-id="'. $notice_id .'" style="bottom: 0; opacity: 0.8;"></div>';

				self::message( array(
					'notice_id'   => $notice_id,
					'title'       => '&#x1F389;',
					'message'     => $notice_content,
					'class'       => 'sucess tie-popup-block tie-popup-window tie-notice-popup tie-yay',
					'button_text' => ! empty( $button_text ) ? $button_text : false,
					'button_url'  => tie_get_purchase_link( array( 'utm_source' => 'theme-update', 'utm_medium' => 'button' ) ),
					'button_class'=> 'green',
				));
			}
		}


		/**
		 * New Theme Update
		 */
		function new_milestone(){

			// Let's make this check every 2 weeks
			if( ( false !== get_transient( 'tie_milestone_check' ) ) || self::is_hooked_popup() ){
				return false;
			}

			$miles_range = array( 10000000, 5000000, 2000000, 1000000, 500000, 100000, 25000, 10000 );
			$notice_base = 'tie_milestones';
			$milestone   = false;

			# Check the number of follwers
			if( class_exists( 'ARQAM_LITE_COUNTERS' ) || function_exists( 'arq_counters_data' ) ){

				$milestone_type = 'followers';
				$notice_title   = '&#x1F3C6;';
				$notice_desc    = esc_html__( 'Followers', TIELABS_TEXTDOMAIN );

				# Get the followers data
				$arq_counters = get_option( 'arq_options' );

				if( ! empty( $arq_counters['data'] ) && is_array( $arq_counters['data'] ) ){

					$number = array_sum( $arq_counters['data'] );

					# Do we get a number? Let's check if it is a milestone
					if( ! empty( $number ) && ! is_wp_error( $number ) ){
						foreach ( $miles_range as $value ) {
							if( $number >= $value ){

								$milestone = ( $value >= 1000000 ) ? ( $value/1000000 ).'M' : ( $value/1000 ).'K';
								break;
							}
						}
					}

					# Let's check if we showed this before
					if( ! empty( $milestone ) ){

						$the_number = sprintf( esc_html__( '%s Followers', TIELABS_TEXTDOMAIN ), $milestone );

						$notice_id = strtolower( $notice_base .'_'. $milestone_type .'_'. $milestone );

						if( self::is_dismissed( $notice_id ) ){
							$milestone = false;
						}
					}
				}
			}

			// Check if the Post Views is active
			if( tie_get_option( 'tie_post_views' ) == 'theme' && ! $milestone ){

				$milestone_type = 'views';
				$notice_title   = '&#128079;';
				$notice_desc    = esc_html__( 'Total Articles\' Views!', TIELABS_TEXTDOMAIN );

				// Let's Sum all post views for all posts
				global $wpdb;
				$number = $wpdb->get_var( $wpdb->prepare( " SELECT sum(meta_value) FROM $wpdb->postmeta WHERE meta_key = %s", apply_filters( 'TieLabs/views_meta_field', 'tie_views' ) ) );

				// Do we get a number? Let's check if it is a milestone
				if( ! empty( $number ) && ! is_wp_error( $number ) ){
					foreach ( $miles_range as $value ) {
						if( $number >= $value ){
							$milestone = ( $value > 1000000 ) ? ( $value/1000000 ).'M' : ( $value/1000 ).'K';
							break;
						}
					}
				}

				// Let's check if we showed this before
				if( ! empty( $milestone ) ){

					$the_number = sprintf( esc_html__( '%s articles views', TIELABS_TEXTDOMAIN ), $milestone );

					$notice_id = strtolower( $notice_base .'_'. $milestone_type .'_'. $milestone );

					if( self::is_dismissed( $notice_id ) ){
						$milestone = false;
					}
				}
			}

			// Let's make this check every 2 weeks
			set_transient( 'tie_milestone_check', 'true', 2 * WEEK_IN_SECONDS );

			// No Milestones yet :(
			if( ! $milestone ){
				return;
			}

			// The Notice message
			$the_message     = sprintf( esc_html__( 'We just reached the %s milestone! We are taking this moment to give YOU a big THANK YOU for all the support and confidence you gave us.', TIELABS_TEXTDOMAIN ), $the_number ) .' #milestone';
			$notice_content  = '<h4>'. esc_html__( 'New Milestone', TIELABS_TEXTDOMAIN ) .'</h4>';
			$notice_content .= '<div class="milestone-number">'. $milestone .'</div>';
			$notice_content .= '<div class="milestone-desc">'. $notice_desc .'</div>';
			$notice_content .= '<a class="tie-primary-button button button-primary tweet-milestone button-hero" target="_blank" href="https://twitter.com/intent/tweet?text='. urlencode( $the_message ).'&amp;url='. esc_url(home_url( '/' )) .'"><span class="dashicons dashicons-twitter"></span> '. esc_html__( 'Spread The Word', TIELABS_TEXTDOMAIN ) .'</a>';

			// If the Customer already rated the theme and the rate is > 3 hide the rate button
			if( ! tie_is_theme_rated() ){
				$notice_content .= '<span class="awesome">'. esc_html__( 'Awesome, isn\'t it? Give us some love :)', TIELABS_TEXTDOMAIN ) .'</span>';
				$button_text     = sprintf( esc_html__( 'Rate %s', TIELABS_TEXTDOMAIN ), apply_filters( 'TieLabs/theme_name', 'TieLabs' ) );
			}

			echo '
				<div id="tie-page-overlay" class="is-notice-dismissible" data-id="'. $notice_id .'" style="bottom: 0; opacity: 0.8;">
					<div class="snowflakes" aria-hidden="true">
						<div class="snowflake"></div><div class="snowflake"></div><div class="snowflake"></div><div class="snowflake"></div><div class="snowflake"></div>
						<div class="snowflake"></div><div class="snowflake"></div><div class="snowflake"></div><div class="snowflake"></div><div class="snowflake"></div>
					</div>
				</div>
			';

			self::message( array(
				'notice_id'   => $notice_id,
				'title'       => $notice_title,
				'message'     => $notice_content,
				'class'       => 'sucess tie-popup-block tie-popup-window tie-notice-popup tie-yay',
				'button_text' => ! empty( $button_text ) ? $button_text : false,
				'button_url'  => tie_get_purchase_link( array( 'utm_source' => 'theme-milestone', 'utm_medium' => 'button' ) ),
				'button_class'=> 'green',
			));
		}


		/**
		 * Happy Customer
		 */
		function happy_anniversary(){

			$current_year = date( 'y' );
			$notice_id    = 'tie_happy_anniversary_'.$current_year;

			if ( self::is_dismissed( $notice_id ) ){
				return false;
			}

			$customer_since = tie_get_latest_theme_data( 'customer_since' );

			if( ! empty( $customer_since ) ) {
				$customer_month = date( 'n', strtotime( $customer_since ) );
				$customer_year  = date( 'y', strtotime( $customer_since ) );
				$current_month  = date( 'n' );

				if( $current_month == $customer_month && $customer_year < $current_year ){

					if( self::is_hooked_popup() !== false ){
						return false;
					}

					$number_of_years = $current_year - $customer_year;
					$years_text = sprintf( _n( '%d year', '%d years', $number_of_years, TIELABS_TEXTDOMAIN ), $number_of_years );

					$notice_content  = '<h4>'. esc_html__( 'Happy Anniversary with TieLabs!', TIELABS_TEXTDOMAIN ) .'</h4>';
					$notice_content .= '<p>'. sprintf( esc_html__( 'Woohoo! We are so happy You have been with us for %s We are looking forward to providing an awesome WordPress theme and plugins for you for many more. Thanks for being an awesome customer!', TIELABS_TEXTDOMAIN ), $years_text ) .'</p>';
					$notice_content .= '<p>'. esc_html__( 'Your friends at TieLabs', TIELABS_TEXTDOMAIN ) .'</p>';

					echo '<div id="tie-page-overlay" class="is-notice-dismissible" data-id="'. $notice_id .'" style="bottom: 0; opacity: 0.8;"></div>';

					self::message( array(
						'notice_id' => $notice_id,
						'title'     => '<img src="'.TIELABS_TEMPLATE_URL. '/framework/admin/assets/images/badges/'. $number_of_years .'.png" alt="" />',
						'class'     => 'sucess tie-popup-block tie-popup-window tie-notice-popup tie-yay',
						'message'   => $notice_content,
					));
				}
			}
		}


		/**
		 * Live Message
		 */
		function live_message(){

			if( ! current_user_can( 'manage_options' ) || ! apply_filters( 'TieLabs/Notices/Live', true ) ){
				return false;
			}

			$data  = tie_get_latest_theme_data( 'message' );
			$today = strtotime( date('Y-m-d') );

			if( ! empty( $data ) && is_array( $data ) && ! empty( $data['notice_id'] ) && ! self::is_dismissed( $data['notice_id'] ) ){

				if( self::is_hooked() ){
					return false;
				}

				// Function Exists
				if( ! empty( $data['function'] ) && function_exists( $data['function'] ) ){
					return false;
				}

				// Show the message if current Version is lower than
				if( ! empty( $data['version_max'] ) && version_compare( TIELABS_DB_VERSION, $data['version_max'], '>' ) ){
					return false;
				}

				// Show the message if current Version is greater than
				if( ! empty( $data['version_min'] ) && version_compare( TIELABS_DB_VERSION, $data['version_min'], '<' ) ){
					return false;
				}

				// Start date
				if( ! empty( $data['start_date'] ) ) {
					$start_date = strtotime( $data['start_date'] );

					if( $start_date > $today ){
						return false;
					}
				}

				// Expire date
				if( ! empty( $data['expire_date'] ) ) {
					$expire_date = strtotime( $data['expire_date'] );

					if( $expire_date <= $today ){
						return false;
					}
				}

				self::message( $data );
			}
		}


		/**
		 * Show the Notice
		 */
		public static function message( $args = array() ){

			$defaults = array(
				'notice_id'      => '',
				'title'          => esc_html__( 'Howdy', TIELABS_TEXTDOMAIN ),
				'img'            => false,
				'message'        => '',
				'dismissible'    => true,
				'color'          => '',
				'class'          => '',
				'standard'       => true,
				'button_text'    => '',
				'button_class'   => '',
				'button_url'     => '',
				'button_2_text'  => '',
				'button_2_class' => '',
				'button_2_url'   => '',
			);

			$args = wp_parse_args( $args, $defaults );


			if( ! empty( $args['color'] ) ){
				$args['color'] = 'border-color:'. $args['color'];
			}

			if( $args['class'] ){
				$args['class'] = 'tie-'. $args['class'];
			}

			if( $args['standard'] ){
				$args['class'] .= ' notice';
			}

			if( $args['dismissible'] ){
				$args['class'] .= ' is-dismissible';
			}

			if( ! empty( $args['button_class'] ) ){
				$args['button_class'] = 'tie-button-'. $args['button_class'];
			}

			if( ! empty( $args['button_2_class'] ) ){
				$args['button_2_class'] = 'tie-button-'. $args['button_2_class'];
			}

			?>

			<div id="<?php echo esc_attr( sanitize_key( $args['notice_id'] ) ) ?>" class="tie-notice <?php echo esc_attr( $args['class'] ); ?>" style="<?php echo esc_attr( $args['color'] ); ?>">
				<h3><?php echo wp_kses_post( $args['title'] ) ?></h3>

				<div class="tie-notice-content">

					<?php
					if( ! empty( $args['img'] ) ){ ?>
						<img src="<?php echo esc_attr( $args['img'] ); ?>" class="tie-notice-img" alt="">
						<?php
					}
					?>

					<?php

						if( strpos( $args['message'], '<p>' ) === false ){
							$args['message'] = '<p>'. $args['message'] .'</p>';
						}

						echo wp_kses_post( $args['message'] );

					?>

					<?php
					if( ! empty( $args['button_text'] ) ){ ?>
						<a class="tie-primary-button button button-primary button-hero <?php echo esc_attr( $args['button_class'] ) ?>" href="<?php echo esc_url( $args['button_url'] ) ?>"><?php echo esc_html( $args['button_text'] ) ?></a>
						<?php
					}
					?>

					<?php
					if( ! empty( $args['button_2_text'] ) ){ ?>
						<a class="tie-primary-button button button-primary button-hero <?php echo esc_attr( $args['button_2_class'] ) ?>" href="<?php echo esc_url( $args['button_2_url'] ) ?>"><?php echo esc_html( $args['button_2_text'] ) ?></a>
						<?php
					}
					?>

				</div>
			</div>

			<?php
		}

	}

	// Single instance.
	$TIELABS_NOTICES = new TIELABS_NOTICES();
}
