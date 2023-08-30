<?php
/**
 * Jetpack
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly



if( ! class_exists( 'TIELABS_JETPACK' ) ) {

	class TIELABS_JETPACK{

		public $count_key;


		/**
		 * __construct
		 *
		 * Class constructor where we will call our filter and action hooks.
		 */
		function __construct(){

			// Disable if the Jetpack plugin is not active
			if ( ! TIELABS_JETPACK_IS_ACTIVE ){
				return;
			}

			// Disable Jetpack upsell ads
			add_filter( 'jetpack_just_in_time_msgs', '__return_false' );

			// Check OpenGraph
			add_filter( 'TieLabs/is_opengraph_active', array( $this, 'is_opengraph_active' ) );

			// Mobile Theme
			/**
			if( Jetpack::is_module_active( 'minileven' ) && ! tie_get_option( 'disable_responsive' ) ){
				add_filter( 'jetpack_active_modules', array( $this, 'gg' ) );
			}
			*/

			// Get Most Viewd Post for x days
			add_filter( 'TieLabs/posts_widget_query', array( $this, 'widget_query' ), 10, 1 );

			// Jetpack Views option is enabled
			if( Jetpack::is_module_active( 'stats' ) ){

				// Theme Meta Jetpack post views
				if( tie_get_option( 'tie_post_views' ) == 'jetpack' ){

					// Add Stats to REST API Post response
					if ( function_exists( 'register_rest_field' ) ) {
						add_action( 'rest_api_init',  array( $this, 'rest_register_post_views' ) );
					}

					$this->count_key = apply_filters( 'TieLabs/views_meta_field', 'tie_views' );
				}
			}
		}


		/**
		 * is_opengraph_active
		 *
		 * Check if the Open Graph Added by the Jetpack
		 */
		public function is_opengraph_active( $active ){

			if( Jetpack::is_module_active( 'publicize' ) || Jetpack::is_module_active( 'sharedaddy' ) ){
				return true;
			}

			return $active;
		}


		/**
		 * widget_query
		 *
		 * Set the args
		 */
		public function widget_query( $query_args ){

			if( ! empty( $query_args['order'] ) && strpos( $query_args['order'], 'jetpack' ) !== false && function_exists( 'stats_get_csv' ) ) {

				// Number of Days
				$days  = str_replace( 'jetpack-', '', $query_args['order'] );

				// Get the Posts via the API
				$post_views = stats_get_csv( 'postviews', array('days' => absint( $days ), 'limit' => 100 ));

				// If the Jetpack posts list has posts
				if( ! empty( $post_views ) && is_array( $post_views ) ){

					$post_ids = array_filter( wp_list_pluck( $post_views, 'post_id' ) );

					if( ! empty( $query_args['exclude_posts'] ) ){
						$post_id_key = array_search( $query_args['exclude_posts'], $post_ids );

						if( ! empty( $post_id_key ) ){
							unset( $post_ids[ $post_id_key ] );
						}
					}

					$query_args['posts'] = implode( ',', $post_ids );

					unset( $query_args['order'] );
				}

				// Jetpack request is empty > get most commented posts
				else{
					$query_args['order'] = 'popular';
				}
			}

			return $query_args;
		}


		/**
		 * rest_register_post_views
		 */
		public function rest_register_post_views() {

			register_rest_field( 'post',
				'views',
				array(
					'get_callback'    => array( $this, 'rest_get_views' ),
					'update_callback' => array( $this, 'rest_update_views' ),
					'schema'          => null,
				)
			);
		}


		/**
		 * Get the Post views for the API.
		 *
		 * @param array           $object     Details of current post.
		 * @param string          $field_name Name of field.
		 * @param WP_REST_Request $request    Current request.
		 *
		 * @return array $views Array of views stored for that Post ID.
		 */
		public function rest_get_views( $object, $field_name, $request ) {

			return get_post_meta( $object['id'], $this->count_key, true );
		}


		/**
		 * Update post views from the API.
		 *
		 * Only accepts a string.
		 *
		 * @param string $view       New post view value.
		 * @param object $object     The object from the response.
		 * @param string $field_name Name of field.
		 *
		 * @return bool|int
		 */
		public function rest_update_views( $view, $object, $field_name ) {

			if ( empty( $view ) ){
				return false;
			}

			return update_post_meta( $object->ID, $this->count_key, $view );
		}


		/**
		 * Retrieve Post Views for a post, using the WordPress.com Stats API.
		 */
		public static function post_views( $post_id ){

			$views = 0;

			/**
			 * Default method
			 */

			// Return early if we use a too old version of Jetpack.
			if ( ! function_exists( 'stats_get_csv' ) ) {
				return $views;
			}

			$args = array( 'days' => -1, 'limit' => -1, 'post_id'=> $post_id );
			$result = stats_get_csv( 'postviews', $args );

			if( ! empty( $result[0]['views'] ) ){
				$views = $result[0]['views'];
			}


			/**
			 * Alternative method
			 */
			else{

				// Return early if we use a too old version of Jetpack.
				if ( ! function_exists( 'stats_get_from_restapi' ) ) {
					return $views;
				}

				// Build our sub-endpoint to get stats for a specific post.
				$endpoint = sprintf( 'post/%d', $post_id );

				// Get the data
				$stats = stats_get_from_restapi( array( 'fields' => 'views' ), $endpoint );

				// Process that data
				if ( ! empty( $stats ) && isset( $stats->views ) ) {
					$views = $stats->views;
				}
			}

			// Update the meta field
			if( ! empty( $views ) ){
				$count_key = apply_filters( 'TieLabs/views_meta_field', 'tie_views' );
				update_post_meta( $post_id, $count_key, $views );
			}

			return $views;
		}

	}


	// Instantiate the class
	new TIELABS_JETPACK();
}
