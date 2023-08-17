<?php
/**
 * General Functions
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly



/**
 * Get the components of theme mobile header
 */
if( ! function_exists( 'tie_mobile_header_components' ) ) {

	function tie_mobile_header_components( $area ){

		$mobile_header_components = array(

			'menu' => tie_mobile_menu_icon(),

			'search' => '
				<a href="#" class="tie-search-trigger-mobile">
					<span class="tie-icon-search tie-search-icon" aria-hidden="true"></span>
					<span class="screen-reader-text">'. esc_html__( 'Search for', TIELABS_TEXTDOMAIN ) .'</span>
				</a>
			',

			'skin' => '
				<a href="#" class="change-skin" title="'. esc_html__( 'Switch skin', TIELABS_TEXTDOMAIN ) .'">
					<span class="tie-icon-moon change-skin-icon" aria-hidden="true"></span>
					<span class="screen-reader-text">'. esc_html__( 'Switch skin', TIELABS_TEXTDOMAIN ) .'</span>
				</a>
			',
		);

		// Login and user account
		if( is_user_logged_in() ){

			ob_start();
			tie_login_form();
			$login_form = ob_get_clean();

			$current_user = wp_get_current_user();
			$mobile_header_components['login'] = '
				<a href="#" class="profile-btn">'.
					get_avatar( $current_user->ID, apply_filters( 'TieLabs/Login/avatar_size', 30 ) ) .'
					<span class="screen-reader-text">'. esc_html__( 'Your Profile', TIELABS_TEXTDOMAIN ) .'</span>
				</a>

				<div class="components-sub-menu comp-sub-menu components-user-profile">'. $login_form .'</div>
			';
		}
		else {
			$mobile_header_components['login'] = '
				<a href="#" class="lgoin-btn tie-popup-trigger">
					<span class="tie-icon-author" aria-hidden="true"></span>
					<span class="screen-reader-text">'. esc_html__( 'Log In', TIELABS_TEXTDOMAIN ) .'</span>
				</a>
			';
		}

		// WooCommerce Cart
		if ( TIELABS_WOOCOMMERCE_IS_ACTIVE ){
			$mobile_header_components['cart'] = tie_component_button_cart();
		}

		// BuddyPress
		if ( TIELABS_BUDDYPRESS_IS_ACTIVE ){
			$mobile_header_components['bp_notifications'] = tie_component_button_bp_notifications();
		}

		// Check the active components
		$components = array();
		foreach ( $mobile_header_components as $key => $html ) {
			if( tie_get_option( 'mobile_header_components_'.$key ) == $area ){
				$components[ $key ] = '<li class="mobile-component_'.$key .' custom-menu-link">'. $html .'</li>';
			}
		}

		//
		$components = apply_filters( 'TieLabs/Mobile/Header/Components', $components, $area );


		if( ! empty( $components ) ){
			echo '<div id="mobile-header-components-'. $area .'" class="mobile-header-components">';
				echo '<ul class="components">'. join( ' ', $components ) .'</ul>';
			echo '</div>';
		}

		// If Header layout is centered we need to place the div even if it is empty || FLEX
		elseif ( tie_get_option( 'mobile_header' ) == 'centered' ) {
			echo '<div id="mobile-header-components-'. $area .'" class="mobile-header-components"></div>';
		}

		return false;
	}
}


/**
 * Mobile Menu icon
 */
if( ! function_exists( 'tie_mobile_menu_icon' ) ) {

	function tie_mobile_menu_icon(){

		if( ! tie_get_option( 'mobile_header_components_menu' ) ){
			return false;
		}

		$menu_icon = tie_get_option( 'mobile_menu_icon', 1 );

		$class = 'tie-mobile-menu-icon ';

		if( is_numeric( $menu_icon ) ){
			$class .= "nav-icon is-layout-$menu_icon";
		}
		else{
			$class .= "tie-icon-$menu_icon";
		}

		$class_wrapper = tie_get_option( 'mobile_menu_text' ) ? 'menu-text-wrapper' : '';

		$mobile_icon  = '<a href="#" id="mobile-menu-icon" class="'. $class_wrapper .'">';
		$mobile_icon .= '<span class="'. $class .'"></span>';

		if( tie_get_option( 'mobile_menu_text' ) ){
			$mobile_icon .= '<span class="menu-text">'. esc_html__( 'Menu', TIELABS_TEXTDOMAIN ) .'</span>';
		}
		else{
			$mobile_icon .= '<span class="screen-reader-text">'. esc_html__( 'Menu', TIELABS_TEXTDOMAIN ) .'</span>';
		}

		$mobile_icon .= '</a>';

		return $mobile_icon;
	}
}


/**
 * Mobile Header Components Main area
 */
if( ! function_exists( 'tie_mobile_header_components_area_1' ) ) {

	add_action( 'TieLabs/Logo/before', 'tie_mobile_header_components_area_1' );
	function tie_mobile_header_components_area_1(){
		tie_mobile_header_components( 'area_1' );
	}
}



/**
 * Mobile Header Components
 */
if( ! function_exists( 'tie_mobile_header_components_area_2' ) ) {

	add_action( 'TieLabs/Logo/after', 'tie_mobile_header_components_area_2' );
	function tie_mobile_header_components_area_2(){
		tie_mobile_header_components( 'area_2' );
	}
}

