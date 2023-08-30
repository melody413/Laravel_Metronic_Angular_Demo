<?php
/**
 * Theme Validation
 *
 */


defined( 'ABSPATH' ) || exit; // Exit if accessed directly


if( ! class_exists( 'TIELABS_VERIFICATION' ) ){

	class TIELABS_VERIFICATION {


		/**
		 * Runs on class initialization. Adds filters and actions.
		 */
		function __construct() {

			add_action( 'admin_enqueue_scripts',          array( $this, 'load_notices' ) );
			add_filter( 'TieLabs/welcome_splash_content', array( $this, 'theme_registerantion_section' ), 9 );
		}


		/**
		 * Get the authorize url
		 */
		public static function api_url(){

			return add_query_arg(
				array(
					'envato_verify_purchase' => '',
					'redirect_url' => esc_url( add_query_arg( array( 'page' => 'tie-theme-options' ), admin_url( 'admin.php' ) )),
					'item' => TIELABS_THEME_ID,
					'blog' => esc_url( home_url( '/' ) ),
				),
				'https://tielabs.com'
			);
		}


		/**
		 * Theme validation notices
		 */
		function load_notices(){

			$current_page = ! empty( get_current_screen()->tiebase ) ? get_current_screen()->tiebase : '';

			// Theme page validation notices
			if ( $current_page != 'toplevel_page_tie-theme-options' ){
				return;
			}

			if( isset( $_GET['tie-envato-authorize'] ) && isset( $_GET['item'] ) && $_GET['item'] == TIELABS_THEME_ID ){

				if( isset( $_GET['sucess'] ) && ! empty( $_GET['token'] ) ){

					$theme_data = tie_get_latest_theme_data( '', $_GET['token'] );

					if( ! empty( $theme_data['status'] ) && $theme_data['status'] == 1 ){
						add_action( 'admin_notices', array( $this, 'success' ), 101 );
					}
					else{
						add_action( 'admin_notices', array( $this, 'error' ), 103 );
					}
				}
				elseif( isset($_GET['fail']) ){
					add_action( 'admin_notices', array( $this, 'error' ), 103 );
				}
			}

			elseif( get_option( 'tie_token_error_'.TIELABS_THEME_ID ) ){
				add_action( 'admin_notices', array( $this, 'error' ), 103 );
			}

			elseif( ! get_option( 'tie_token_'.TIELABS_THEME_ID ) ){
				add_action( 'admin_notices', array( $this, 'authorize_notice' ), 102 );
			}
		}


		/**
		 * Authorized Successfully
		 */
		function success(){

			TIELABS_NOTICES::message( array(
				'notice_id'   => 'theme_authorized',
				'title'       => esc_html__( 'Congratulations', TIELABS_TEXTDOMAIN ),
				'message'     => esc_html__( 'Your site is now validated!, Demo import and bundeled plugins are now unlocked.', TIELABS_TEXTDOMAIN ),
				'dismissible' => false,
				'class'       => 'success',
			));
		}


		/**
		 * Theme Not Authorized Yet
		 */
		public static function authorize_notice( $standard = true ){

			$notice_content  = esc_html__( 'Your license is not validated. Click on the link below to unlock demo import, bundeled plugins and access to premium support.', TIELABS_TEXTDOMAIN );
			$notice_content .= '<p><em>'. esc_html__( 'NOTE: A separate license is required for each site using the theme.', TIELABS_TEXTDOMAIN ) .'</em></p>';
			$notice_content .= '<p><span class="dashicons dashicons-editor-help"></span> <strong><a href="'. apply_filters( 'TieLabs/External/licenses_article', '' ) .'" target="_blank">'. esc_html__( 'Have a question about the license? Check this article.', TIELABS_TEXTDOMAIN ) .'</a></strong></p>';

			TIELABS_NOTICES::message( array(
				'notice_id'   => 'theme_not_authorized',
				'title'       => esc_html__( 'You\'re almost finished!', TIELABS_TEXTDOMAIN ),
				'message'     => $notice_content,
				'dismissible' => false,
				'class'       => 'warning',
				'standard'    => $standard,
				'button_text' => esc_html__( 'Verify Now!', TIELABS_TEXTDOMAIN ),
				'button_url'  => self::api_url(),
				'button_class'=> 'green',
				'button_2_text'  => esc_html__( 'Buy a License', TIELABS_TEXTDOMAIN ),
				'button_2_url'   => tie_get_purchase_link(),
			));
		}


		/**
		 * Authorize Error
		 */
		function error(){

			$notice_content = '<p>'. esc_html__( 'Authorization Failed', TIELABS_TEXTDOMAIN ) .'</p>';

			if( isset($_GET['error-description']) ){
				$notice_content .= '<p>'. $_GET['error-description'] .'</p>';
			}

			$error_description = tie_get_latest_theme_data( 'error' );

			if( ! empty( $error_description ) ){
				$notice_content .= '<p>'. $error_description .'</p>';
			}

			if( $error = get_option( 'tie_token_error_'.TIELABS_THEME_ID ) ){
				$notice_content .= '<p>'. $error .'</p>';
			}

			TIELABS_NOTICES::message( array(
				'notice_id'     => 'theme_authorized_error',
				'title'         => esc_html__( 'ERROR', TIELABS_TEXTDOMAIN ),
				'message'       => $notice_content,
				'dismissible'   => false,
				'class'         => 'error',
				'button_text'   => esc_html__( 'Try again', TIELABS_TEXTDOMAIN ),
				'button_url'    => self::api_url(),
				'button_class'  => 'green',
				'button_2_text' => esc_html__( 'Buy a License', TIELABS_TEXTDOMAIN ),
				'button_2_url'  => tie_get_purchase_link(),
			));
		}


		/**
		 * Theme Registeration Section in the Welcome Page
		 */
		function theme_registerantion_section(){

			echo '<div id="theme-validation-info">';
			echo '<h2>'. esc_html__( 'Theme Registration', TIELABS_TEXTDOMAIN ) .'</h2>';

			// Make connection to revoke the theme
			if( isset( $_REQUEST['revoke-theme'] ) && check_admin_referer( 'revoke-theme', 'revoke_theme_nonce' ) ){
				tie_get_latest_theme_data( '', false, false, false, true );
			}

			// Make connection to refresh support
			elseif( isset( $_REQUEST['refresh-support'] ) && check_admin_referer( 'refresh-support', 'refresh_support_nonce' ) ){
				tie_get_latest_theme_data( '', false, true );
			}

			// Site is not validated
			if( ! get_option( 'tie_token_'.TIELABS_THEME_ID ) ){
				self::authorize_notice( false );
			}

			// Site is validated
			else{ ?>

				<div class="tie-notice tie-success">
					<h3>
						<span class="dashicons dashicons-unlock"></span>
						<?php esc_html_e( 'Your Site is Validated', TIELABS_TEXTDOMAIN ); ?>
						<a id="revoke-tie-token" data-message="<?php esc_html_e( 'Are you sure?', TIELABS_TEXTDOMAIN ) ?>" class="tie-primary-button button button-primary button-large tie-button-red" href="<?php print wp_nonce_url( admin_url( 'admin.php?page=tie-theme-welcome&revoke-theme' ), 'revoke-theme', 'revoke_theme_nonce' ) ?>"><?php esc_html_e( 'Revoke', TIELABS_TEXTDOMAIN ) ?></a>
					</h3>
				</div>

				<?php

				self::rating_notice();
				self::support_notice();
			}

			echo '</div>';
			echo '<br /><br /><hr />';
		}


		/**
		 * Show the support messages
		 */
		public static function support_notice(){

			if( ! get_option( 'tie_token_'.TIELABS_THEME_ID ) ){
				return;
			}

			$support_info = tie_get_support_period_info();

			// Support is active
			if( ! empty( $support_info['status'] ) && $support_info['status'] == 'active' ){

				# Expiring Soon in just two months
				if( ! empty( $support_info['expiring'] ) ){

					$notice_class   = 'warning';
					$notice_title   = '<span class="dashicons dashicons-warning"></span> ' . esc_html__( 'Your Support Period Expiring Soon', TIELABS_TEXTDOMAIN );
					$notice_content = sprintf(
						esc_html__( 'Your Support Period expires on %1$s, active Support Period is requried for %2$sAutomatic Theme Updates%3$s and %2$sSupport System Access%3$s. %4$sGet an extra 6 months of support now%5$s. Once the support is renewed please click on the button bellow.', TIELABS_TEXTDOMAIN ),
						'<strong style="color: orange;">'. $support_info['human_date'] .'</strong>',
						'<strong>',
						'</strong>',
						'<a target="_blank" href="'. tie_get_purchase_link( array( 'utm_medium' => 'extend-support' ) ) .'">',
						'</a>'
					);
				}

				// No, Still have at least 2 months
				else{

					$notice_class   = 'success';
					$notice_title   = '<span class="dashicons dashicons-yes"></span> ' . esc_html__( 'Your Support Period is Active', TIELABS_TEXTDOMAIN );
					$notice_content = sprintf(
						esc_html__( 'Your Support Period expires on %1$s, active Support Period is requried for %2$sAutomatic Theme Updates%3$s and %2$sSupport System Access%3$s. %4$sGet an extra 6 months of support now%5$s. Once the support is renewed please click on the button bellow.', TIELABS_TEXTDOMAIN ),
						'<strong style="color: green;">'. $support_info['human_date'] .'</strong>',
						'<strong>',
						'</strong>',
						'<a target="_blank" href="'. tie_get_purchase_link( array( 'utm_medium' => 'extend-expiring-support' ) ) .'">',
						'</a>'
					);
				}

			}

			// Boom, Expired :(
			else{
				$notice_class   = 'error';
				$notice_title   = '<span class="dashicons dashicons-no"></span> ' . esc_html__( 'Your Support Period Has Expired', TIELABS_TEXTDOMAIN );
				$notice_content = sprintf(
					esc_html__( 'Your Support Period has expired, %1$sAutomatic Theme Updates%2$s and %1$sSupport System Access%2$s have been disabled. %3$sRenew your Support Period%4$s. Once the support is renewed please click on the button bellow.', TIELABS_TEXTDOMAIN ),
					'<strong>',
					'</strong>',
					'<a target="_blank" href="'. tie_get_purchase_link( array( 'utm_medium' => 'renew-support' ) ) .'">',
					'</a>'
				);
			}

			// Show the Message
			TIELABS_NOTICES::message( array(
				'notice_id'     => 'support_status',
				'title'         => $notice_title,
				'message'       => $notice_content,
				'dismissible'   => false,
				'standard'      => false,
				'class'         => $notice_class,
				'button_text'   => esc_html__( 'Refresh Expiration Date', TIELABS_TEXTDOMAIN ),
				'button_url'    => wp_nonce_url( admin_url( 'admin.php?page=tie-theme-welcome&refresh-support' ), 'refresh-support', 'refresh_support_nonce' ),
				'button_class'  => 'green',
				'button_2_text' => esc_html__( 'More info', TIELABS_TEXTDOMAIN ),
				'button_2_url'  => apply_filters( 'TieLabs/External/renew_support_article', '' ),
			));
		}


		/*
		 * Show the Rating Message
		 */
		public static function rating_notice(){

			if( ! get_option( 'tie_token_'.TIELABS_THEME_ID ) ){
				return;
			}

			$the_rate = tie_get_latest_theme_data( 'rating' );


			// The customer has rated the theme
			if( ! empty( $the_rate ) ){

				// He rated the theme 3 or below :(
				if( $the_rate < 4 ){

					$notice_title   = esc_html__( 'Have you changed your mind? :)', TIELABS_TEXTDOMAIN );
					$notice_content = sprintf(
						esc_html__( 'We noticed that you rated the theme %1$s stars. We are looking to improve our theme so if you need help, please %2$ssubmit a ticket through our support system%5$s or %3$ssubmit your feature requests%5$s, otherwise we highly appreciate your valuable five stars. %4$sClick here to change your rating%5$s.', TIELABS_TEXTDOMAIN ),
						'<strong>'. $the_rate .'</strong>',
						'<a target="_blank" href="'. apply_filters( 'TieLabs/External/open_ticket', '' ) .'">',
						'<a target="_blank" href="'. apply_filters( 'TieLabs/External/share_idea', '' ) .'">',
						'<a target="_blank" href="'. tie_get_purchase_link( array( 'utm_medium' => 'change-rating' ) ) .'">',
						'</a>'
					);
				}
			}

			// Didn't rate the theme yet
			else{

				$notice_title   = sprintf( esc_html__( 'Like %s?', TIELABS_TEXTDOMAIN ), apply_filters( 'TieLabs/theme_name', 'TieLabs' ) );
				$notice_content = sprintf(
					esc_html__( 'We\'ve noticed you\'ve been using %1$s for some time now; we hope you love it! We\'d be thrilled if you could %2$sgive us a 5* rating on themeforest.net!%4$s If you are experiencing issues, please %3$sopen a support ticket%4$s and we\'ll do our best to help you out.', TIELABS_TEXTDOMAIN ),
					apply_filters( 'TieLabs/theme_name', 'TieLabs' ),
					'<a href="'. tie_get_purchase_link( array( 'utm_medium' => 'rate-welcome' ) ) .'" target="_blank">',
					'<a href="'. apply_filters( 'TieLabs/External/open_ticket', '' ) .'" target="_blank">',
					'</a>'
				);
			}

			// Show the Message
			if( ! empty( $notice_title ) ){

				TIELABS_NOTICES::message( array(
					'notice_id'   => 'rate_the_theme',
					'title'       => $notice_title,
					'message'     => $notice_content,
					'dismissible' => false,
					'standard'    => false,
					'class'       => 'warning',
				));
			}
		}


		/**
		 * Show the support messages | compact
		 */
		public static function support_compact_notice(){

			if( ! get_option( 'tie_token_'.TIELABS_THEME_ID ) ){
				return;
			}

			$is_expired   = false;
			$support_info = tie_get_support_period_info();

			// Support is active
			if( ! empty( $support_info['status'] ) && $support_info['status'] == 'active' ){

				// Expiring Soon in just two months
				if( ! empty( $support_info['expiring'] ) ){

					$is_expired = true;

					$message = array(
						'color' => 'orange',
						'text'  => esc_html__( 'Your Support Period Expiring Soon', TIELABS_TEXTDOMAIN ),
						'icon'  => 'warning'
					);
				}

				// No, Still has at least 2 months
				else{

					$message = array(
						'color' => '#65b70e',
						'text'  => esc_html__( 'Your Support Period is Active', TIELABS_TEXTDOMAIN ),
						'icon'  => 'yes'
					);
				}
			}

			// Boom, Expired :(
			else{
				$is_expired = true;

				$message = array(
					'color' => 'red',
					'text'  => esc_html__( 'Your Support Period Has Expired', TIELABS_TEXTDOMAIN ),
					'icon'  => 'no'
				);
			}

			if( ! empty( $message ) ){
				echo '<a class="footer-support-status" style="color: '. $message['color'] .'" target="_blank" href="'. menu_page_url( 'tie-theme-welcome', false ) .'"><strong><span class="dashicons dashicons-'. $message['icon'] .'"></span> '. $message['text'] .'</strong></a>';
				if( $is_expired ){
					echo '<a class="button button-primary" style="line-height: 24px; min-height: 24px; margin: 0 5px;" target="_blank" href="'. tie_get_purchase_link( array( 'utm_medium' => 'renew-support' ) ) .'">'. esc_html__( 'Renew', TIELABS_TEXTDOMAIN ) .'</a>';
				}
			}
		}
	}

	// Single instance.
	$TIELABS_VERIFICATION = new TIELABS_VERIFICATION();
}
