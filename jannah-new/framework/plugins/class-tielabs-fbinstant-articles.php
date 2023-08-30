<?php
/**
 * Instant Articles for WP
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly



if( ! class_exists( 'TIELABS_FBINSTANT_ARTICLES' ) ) {

	class TIELABS_FBINSTANT_ARTICLES{


		/**
		 * __construct
		 *
		 * Class constructor where we will call our filter and action hooks.
		 */
		function __construct(){

			// Disable if the Instant Articles for WP plugin is not active
			if( ! TIELABS_FB_INSTANT_IS_ACTIVE ){

				return false;
			}

			// Filters
			add_filter( 'instant_articles_transformer_custom_rules_loaded', array( $this, '_transformer_custom_rules' ));
			add_filter( 'instant_articles_subtitle',                        array( $this, '_articles_subtitle' ), 10, 2);
		}


		/**
		 * _transformer_custom_rules
		 */
		function _transformer_custom_rules( $transformer ){

			$rules = array(

				'rules' => array(

					array(
						'class' => 'TextNodeRule'
					),

					array(
						'class' => 'PassThroughRule',
						'selector' => "div[class^='tie-padding']",
					),

					array(
						'class' => 'PassThroughRule',
						'selector' => "div[class^='checklist']",
					),

					array(
						'class' => 'PassThroughRule',
						'selector' => "div[class^='tie-full-width-img']",
					),

					array(
						'class' => 'PassThroughRule',
						'selector' => "div[class^='wp-block-image']",
					),

					array(
						'class' => 'PassThroughRule',
						'selector' => "figure",
					),

					array(
						'class' => 'IgnoreRule',
						'selector' => 'div.review_wrap',
					),

					array(
						'class' => 'IgnoreRule',
						'selector' => 'div.index-title',
					),

					array(
						'class' => 'IgnoreRule',
						'selector' => "div[class^='stream-item-in-post']",
					),
				)
			);

			$transformer->loadRules( json_encode( $rules ) );

			return $transformer;
		}


		/**
		 * _articles_subtitle
		 *
		 */
		function _articles_subtitle( $sub_title = '', $the_post = false ){

			if( empty( $the_post ) ){
				return $sub_title;
			}

			return tie_get_postdata( 'tie_post_sub_title', $sub_title, $the_post->get_the_id() );
		}
	}


	// Instantiate the class
	new TIELABS_FBINSTANT_ARTICLES();

}
