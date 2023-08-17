<?php


/**
	Check if the current device is mobile ( Not tablet )
*/
function tie_is_mobile(){

	// Will recognize tablets as mobile, we use it as early check
	if ( ! wp_is_mobile() ) {
		return false;
	}

	/**
	 * We are using a Custom name for the Mobile_Detect Class name because some plugins -
	 * such as Envira Gallery uses an modefied/old version of the library
	 */
	if ( ! class_exists( 'TIE_Mobile_Detect' ) ){
		require_once ( TIELABS_TEMPLATE_PATH . '/framework/vendor/Mobile_Detect/Mobile_Detect.php');
	}

	// Cache the tie_is_mobile
	if( isset( $GLOBALS['tie_is_mobile'] ) ){
		$is_mobile = $GLOBALS['tie_is_mobile'];
	}
	else{

		$mobble_detect = new TIE_Mobile_Detect();

		if ( $mobble_detect->isTablet() ){
			$is_mobile = false;
		}
		else{
			$is_mobile = $mobble_detect->isMobile();
		}

		$GLOBALS['tie_is_mobile'] = $is_mobile;
	}

	return $is_mobile;
}
