<?php
/**
 * Popup
 *
 * This template can be overridden by copying it to your-child-theme/templates/popup.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author 		TieLabs
 * @version   5.0.8
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

function tie_popup_search_html( $id, $class = false, $placeholder = false ){

	if( empty( $placeholder ) ){
		$placeholder = esc_html__( 'Search for', TIELABS_TEXTDOMAIN );
	}
	?>
	<div id="<?php echo $id ?>" class="tie-popup tie-popup-search-wrap" style="display: none;">
		<a href="#" class="tie-btn-close remove big-btn light-btn">
			<span class="screen-reader-text"><?php esc_html_e( 'Close', TIELABS_TEXTDOMAIN ); ?></span>
		</a>
		<div class="popup-search-wrap-inner">
			<div class="live-search-parent pop-up-live-search" data-skin="live-search-popup" aria-label="<?php esc_html_e( 'Search', TIELABS_TEXTDOMAIN ); ?>">
				<form method="get" class="tie-popup-search-form" action="<?php echo esc_url(home_url( '/' )); ?>">
					<input class="tie-popup-search-input <?php echo ( $class ); ?>" inputmode="search" type="text" name="s" title="<?php esc_html_e( 'Search for', TIELABS_TEXTDOMAIN ) ?>" autocomplete="off" placeholder="<?php echo $placeholder ?>" />
					<button class="tie-popup-search-submit" type="submit">
						<span class="tie-icon-search tie-search-icon" aria-hidden="true"></span>
						<span class="screen-reader-text"><?php esc_html_e( 'Search for', TIELABS_TEXTDOMAIN ) ?></span>
					</button>
				</form>
			</div><!-- .pop-up-live-search /-->
		</div><!-- .popup-search-wrap-inner /-->
	</div><!-- .tie-popup-search-wrap /-->
	<?php
}

// Desktop Search PopUp Module
if( tie_menu_has_search( 'top_nav', false, true ) || tie_menu_has_search( 'main_nav', false, true ) ){

	$live_search_class = '';

	if( tie_menu_has_search( 'top_nav', true ) || tie_menu_has_search( 'main_nav', true ) ){
		$live_search_class = 'is-ajax-search';
	}

	tie_popup_search_html( 'tie-popup-search-desktop', $live_search_class, esc_html__( 'Type and hit Enter', TIELABS_TEXTDOMAIN ) );
}

// Mobile Search PopUp Module
if( tie_get_option( 'mobile_header_components_search') ){

	$live_search_class = '';
	if( tie_get_option( 'mobile_header_live_search') ){
		$live_search_class = 'is-ajax-search';
	}

	tie_popup_search_html( 'tie-popup-search-mobile', $live_search_class );
}

// Login popup module
if( ! is_user_logged_in() && (
			( tie_get_option( 'top_nav' )  && tie_get_option( 'top-nav-components_login'  ) && ( tie_get_option( 'top-nav-area-1' ) == 'components' || tie_get_option( 'top-nav-area-2' ) == 'components' ) ) ||
			( tie_get_option( 'main_nav' ) && tie_get_option( 'main-nav-components_login' ) ) ||
			( tie_get_option( 'mobile_header_components_login' ) )
		)
	){
	?>
	<div id="tie-popup-login" class="tie-popup" style="display: none;">
		<a href="#" class="tie-btn-close remove big-btn light-btn">
			<span class="screen-reader-text"><?php esc_html_e( 'Close', TIELABS_TEXTDOMAIN ); ?></span>
		</a>
		<div class="tie-popup-container">
			<div class="container-wrapper">
				<div class="widget login-widget">

					<div <?php tie_box_class( 'widget-title' ) ?>>
						<div class="the-subtitle"><?php echo esc_html__( 'Log In', TIELABS_TEXTDOMAIN ) ?> <span class="widget-title-icon tie-icon"></span></div>
					</div>

					<div class="widget-container">
						<?php tie_login_form(); ?>
					</div><!-- .widget-container  /-->
				</div><!-- .login-widget  /-->
			</div><!-- .container-wrapper  /-->
		</div><!-- .tie-popup-container /-->
	</div><!-- .tie-popup /-->
	<?php
}
