<?php
/**
 * Taqyeem Class
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly



if( ! class_exists( 'TIELABS_TAQYEEM' ) ) {

	class TIELABS_TAQYEEM{

		/**
		 * __construct
		 *
		 * Class constructor where we will call our filter and action hooks.
		 */
		function __construct(){

			// Disable if the Taqyeem plugin is not active
			if( ! TIELABS_TAQYEEM_IS_ACTIVE ){
				return;
			}

			// Disable the Custom Styles and Typofraphy options
			add_filter( 'taqyeem_custom_styles', '__return_false' );

			// Disable Updater and Verification
			add_filter( 'Taqyeem/Updater/disable',      '__return_true' );
			add_filter( 'Taqyeem/Verification/disable', '__return_true' );

			// Disable the plugin Rich Snippets
			add_filter( 'tie_taqyeem_rich_snippets', '__return_false' );

			// Remove Shortcodes code and Keep the content
			add_filter( 'taqyeem_exclude_content', 'TIELABS_HELPER::strip_shortcodes' );

			// Dequeue Scripts and Styles
			add_filter( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 50 );

			// Dequeue Scripts and Styles
			add_filter( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 50 );

			// Change the reviews head box class
			add_filter( 'taqyeem_reviews_head_classes', array( $this, 'review_head_class' ) );

			// Alter the Queries
			add_filter( 'TieLabs/Query/args', array( $this, 'best_reviews_query' ), 10, 2 );

			// Alter the Related Posts Query
			add_filter( 'TieLabs/related_posts_query', array( $this, 'related_posts_query' ) );

			// Alter the Check Also box Query
			add_filter( 'TieLabs/checkalso_query', array( $this, 'checkalso_query' ) );

			// Default Widgets Posts Thumb Size
			add_filter( 'tie_taqyeem_widget_thumb_size', array( $this, 'reviews_thumb_size' ) );

			// Allow the Rview Rich Snippet on Pages
			add_filter( 'TieLabs/is_page_rich_snippet', array( $this, 'rich_snippet_for_page' ) );

			// Change the Review Rich Snippet
			add_filter( 'TieLabs/rich_snippet_schema', array( $this, 'review_rich_snippet' ) );

			// Add Best Reviews to the post order option menu.
			add_filter( 'TieLabs/Options/Related/post_order_args',   array( $this, 'posts_order_args' ) );
			add_filter( 'TieLabs/Options/Checkalso/post_order_args', array( $this, 'posts_order_args' ) );
			add_filter( 'TieLabs/Builder/Block/post_order_args',     array( $this, 'posts_order_args' ) );
			add_filter( 'TieLabs/Settings/Category/posts_order',     array( $this, 'posts_order_args' ) );
			add_filter( 'TieLabs/Widget/Slider/post_order_args',     array( $this, 'posts_order_args' ) );
			add_filter( 'TieLabs/Widget/Posts/post_order_args',      array( $this, 'posts_order_args_2' ) );

			// Prevent Taqyeem from displaying the review box in the content block in the builder
			add_action( 'TieLabs/Builder/before', array( $this, 'remove_review_block' ) );

			// Replace the old icon classes with the new classes of Font Awesome 5.0
			add_filter( 'taqyeem_buttons_icon',  array( $this, 'replace_icon_fa5' ) );
		}


		/**
		 * Allow the Rview Rich Snippet on Pages
		 */
		function rich_snippet_for_page(){

			if( tie_get_postdata( 'taq_review_position' ) ){
				return true;
			}
		}


		/**
		 * Change the Review Rich Snippet
		 */
		function review_rich_snippet( $schema ){

			// Check if the Taqyeem Structured Data is active, current post has review and the Taqyeem version is >= 2.3.0
			if( ! taqyeem_get_option( 'structured_data' ) || ! tie_get_postdata( 'taq_review_position' ) || ! function_exists( 'taqyeem_review_get_rich_snippet' ) ){
				return $schema;
			}

			// Unset some data
			unset( $schema['articleBody'] );
			unset( $schema['articleSection'] );

			// Get the Review structure data
			$review_rich_snippet = taqyeem_review_get_rich_snippet();

			if( $review_rich_snippet['@type'] == 'product' ){
				$schema = $review_rich_snippet;
			}
			else{
				// Add the data to the post structure data
				$schema['@type']        = 'review';
				$schema['itemReviewed'] = $review_rich_snippet['itemReviewed'];
				$schema['reviewBody']   = $review_rich_snippet['reviewBody'];
				$schema['reviewRating'] = $review_rich_snippet['reviewRating'];
			}

			// return the modefied data
			return $schema;
		}


		/**
		 * Change the reviews head box class
		 */
		function review_head_class( $class ){
			return tie_get_box_class( $class );
		}


		/**
		 * Alter the query for the best reviews
		 */
		function best_reviews_query( $args, $block ){

			if( ! empty( $block['order'] ) && $block['order'] == 'best' ){
				$args['orderby']  = 'meta_value_num';
				$args['meta_key'] = 'taq_review_score';
			}

			return $args;
		}


		/**
		 * Alter the Related Posts Query
		 */
		function related_posts_query( $args ){

			if( tie_get_option( 'related_order' ) == 'best' ){
				$args['orderby']  = 'meta_value_num';
				$args['meta_key'] = 'taq_review_score';
			}

			return $args;
		}


		/**
		 * Alter the Check Also Query
		 */
		function checkalso_query( $args ){

			if( tie_get_option( 'check_also_order' ) == 'best' ){
				$args['orderby']  = 'meta_value_num';
				$args['meta_key'] = 'taq_review_score';
			}

			return $args;
		}


		/**
		 * Add Best Reviews to the post order option menu.
		 */
		function posts_order_args( $args ){

			$args['best'] = esc_html__( 'Best Reviews', TIELABS_TEXTDOMAIN );

			return $args;
		}


		/**
		 * Add Best Reviews to the post order option menu.
		 */
		function posts_order_args_2( $args ){

			$args['standard']['best'] = esc_html__( 'Best Reviews', TIELABS_TEXTDOMAIN );

			return $args;
		}


		/**
		 * Default Widgets Posts Thumb Size
		 */
		function reviews_thumb_size(){
			return TIELABS_THEME_SLUG.'-image-small';
		}


		/**
		 * Prevent Taqyeem from displaying the review box in the content block in the builder
		 */
		function remove_review_block(){
			remove_filter( 'the_content', 'taqyeem_insert_review' );
		}


		/**
		 * Dequeue Scripts and Styles
		 */
		function enqueue_scripts(){

			wp_dequeue_script( 'taqyeem-main' );
			wp_dequeue_style( 'taqyeem-style' );

			wp_enqueue_style( 'taqyeem-styles', TIELABS_TEMPLATE_URL.'/assets/css/plugins/taqyeem'. TIELABS_STYLES::is_minified() .'.css', array(), TIELABS_DB_VERSION, 'all' );

			if( ! is_admin() ){
				wp_dequeue_style( 'taqyeem-fontawesome' );
			}
		}


		/**
		 * Dequeue Scripts and Styles from admin
		 */
		function admin_enqueue_scripts(){

			// Don't Load the main Font Awesome file of the theme in the add/edit posts screens, avoid issue with Taqyeem Button which uses v4.0
			if( function_exists( 'tie_taqyeem_button_output' ) && get_post_type() ){

				wp_dequeue_style( 'tie-fontawesome' );
			}
		}


		/**
		 * Replace the old icon classes with the new classes of Font Awesome 5.0
		 */
		function replace_icon_fa5( $icon ){
			return tie_fa4_to_fa5_value_migration( $icon );
		}


	}


	// Instantiate the class
	new TIELABS_TAQYEEM();
}
