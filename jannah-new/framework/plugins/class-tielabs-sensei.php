<?php
/**
 * Sensei Plugin
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly



if( ! class_exists( 'TIELABS_SENSEI' ) ) {

	class TIELABS_SENSEI{

		/**
		 * __construct
		 *
		 * Class constructor where we will call our filter and action hooks.
		 */
		function __construct(){

			// Disable if the Sensei plugin is not active
			if( ! TIELABS_SENSEI_IS_ACTIVE ) return;

			// Unhook the default Sensei wrappers
			global $woothemes_sensei;
			remove_action( 'sensei_before_main_content', array( $woothemes_sensei->frontend, 'sensei_output_content_wrapper' ),     10 );
			remove_action( 'sensei_after_main_content',  array( $woothemes_sensei->frontend, 'sensei_output_content_wrapper_end' ), 10 );

			// Before main content warapper
			add_action( 'sensei_before_main_content', array( $this, 'before_main_content' ), 10);

			// After main content warapper
			add_action( 'sensei_after_main_content', array( $this, 'after_main_content' ), 10);
		}


		/*
		 * Before main content warapper
		 */
		function before_main_content() {
			echo '<div '. tie_content_column_attr( false ) .'>';
			echo '<div class="container-wrapper">';
		}


		/*
		 * After main content warapper
		 */
		function after_main_content() {
			echo '</div>';
			echo '</div>';
			get_sidebar();
		}
	}


	// Instantiate the class
	new TIELABS_SENSEI();
}
