<?php
/**
 * This file contains a bunch of helper functions that handle add caching to core WordPress functions.
 *
 */


defined( 'ABSPATH' ) || exit; // Exit if accessed directly


if( ! class_exists( 'TIELABS_WP_HELPER' ) ) {

	class TIELABS_WP_HELPER {

		/**
		 * Runs on class initialization. Adds filters and actions.
		 */
		function __construct() {

			// Properly clear get_term_by() cache when a term is updated
			add_action( 'edit_terms', array( $this, 'wp_flush_get_term_by_cache' ), 10, 2 );

			// Properly clear get_term_by() cache when a term is updated
			add_action( 'edit_terms', array( $this, 'wp_flush_get_term_by_cache' ), 10, 2 );

			// Properly clear term_exists() cache when a term is updated
			add_action( 'delete_term', array( $this, 'wp_flush_term_exists' ), 10, 4 );

			// Flush the cache for published pages so we don't end up with stale data
			add_action( 'transition_post_status', array( $this, 'flush_get_page_by_path_cache'  ), 10, 3 );
			add_action( 'transition_post_status', array( $this, 'flush_get_page_by_title_cache' ), 10, 3 );
		}


		/**
		 * Cached version of get_term_by.
		 *
		 * Many calls to get_term_by (with name or slug lookup) across on a single pageload can easily add up the query count.
		 * This function helps prevent that by adding a layer of caching.
		 *
		 * @param string $field Either 'slug', 'name', or 'id'
		 * @param string|int $value Search for this term value
		 * @param string $taxonomy Taxonomy Name
		 * @param string $output Optional. Constant OBJECT, ARRAY_A, or ARRAY_N
		 * @param string $filter Optional. Default is 'raw' or no WordPress defined filter will applied.
		 * @return mixed|null|bool Term Row from database in the type specified by $filter. Will return false if $taxonomy does not exist or $term was not found.
		 * @link http://vip.wordpress.com/documentation/uncached-functions/ Uncached Functions
		 */
		public static function get_term_by( $field, $value, $taxonomy, $output = OBJECT, $filter = 'raw' ){

			// ID lookups are cached
			if ( 'id' == $field )
				return get_term_by( $field, $value, $taxonomy, $output, $filter );

			$cache_key = $field . '|' . $taxonomy . '|' . md5( $value );
			$term_id = wp_cache_get( $cache_key, 'get_term_by' );

			if ( false === $term_id ){
				$term = get_term_by( $field, $value, $taxonomy );
				if ( $term && ! is_wp_error( $term ) )
					wp_cache_set( $cache_key, $term->term_id, 'get_term_by' );
				else
					wp_cache_set( $cache_key, 0, 'get_term_by' ); // if we get an invalid value, let's cache it anyway
			} else {
				$term = get_term( $term_id, $taxonomy, $output, $filter );
			}

			if ( is_wp_error( $term ) )
				$term = false;

			return $term;
		}


		/**
		 * Cached version of term_exists()
		 *
		 * Term exists calls can pile up on a single pageload.
		 * This function adds a layer of caching to prevent lots of queries.
		 *
		 * @param int|string $term The term to check can be id, slug or name.
		 * @param string $taxonomy The taxonomy name to use
		 * @param int $parent Optional. ID of parent term under which to confine the exists search.
		 * @return mixed Returns null if the term does not exist. Returns the term ID
		 *               if no taxonomy is specified and the term ID exists. Returns
		 *               an array of the term ID and the term taxonomy ID the taxonomy
		 *               is specified and the pairing exists.
		 */

		public static function term_exists( $term, $taxonomy = '', $parent = null ){
			//If $parent is not null, let's skip the cache.
			if ( null !== $parent ){
				return term_exists( $term, $taxonomy, $parent );
			}

			if ( ! empty( $taxonomy ) ){
				$cache_key = $term . '|' . $taxonomy;
			}else{
				$cache_key = $term;
			}

			$cache_value = wp_cache_get( $cache_key, 'term_exists' );

			//term_exists frequently returns null, but (happily) never false
			if ( false  === $cache_value ){
				$term_exists = term_exists( $term, $taxonomy );
				wp_cache_set( $cache_key, $term_exists, 'term_exists' );
			}else{
				$term_exists = $cache_value;
			}

			if ( is_wp_error( $term_exists ) )
				$term_exists = null;

			return $term_exists;
		}


		/**
		 * Optimized version of get_term_link that adds caching for slug-based lookups.
		 *
		 * Returns permalink for a taxonomy term archive, or a WP_Error object if the term does not exist.
		 *
		 * @param int|string|object $term The term object / term ID / term slug whose link will be retrieved.
		 * @param string $taxonomy The taxonomy slug. NOT required if you pass the term object in the first parameter
		 *
		 * @return string|WP_Error HTML link to taxonomy term archive on success, WP_Error if term does not exist.
		 */
		public static function get_term_link( $term, $taxonomy = null ){
			// ID- or object-based lookups already result in cached lookups, so we can ignore those.
			if ( is_numeric( $term ) || is_object( $term ) ){
				return get_term_link( $term, $taxonomy );
			}

			$term_object = self::get_term_by( 'slug', $term, $taxonomy );
			return get_term_link( $term_object );
		}


		/**
		 * Cached version of count_user_posts, which is uncached but doesn't always need to hit the db
		 *
		 * count_user_posts is generally fast, but it can be easy to end up with many redundant queries
		 * if it's called several times per request. This allows bypassing the db queries in favor of
		 * the cache
		 */
		public static function count_user_posts( $user_id ){

			if ( ! is_numeric( $user_id ) ){
				return 0;
			}

			$cache_key = 'vip_' . (int) $user_id;
			$cache_group = 'user_posts_count';

			if ( false === ( $count = wp_cache_get( $cache_key, $cache_group ) ) ){

				$count = count_user_posts( $user_id );
				wp_cache_set( $cache_key, $count, $cache_group, 5 * MINUTE_IN_SECONDS );
			}

			return $count;
		}


		/**
		 * Properly clear get_term_by() cache when a term is updated
		 */
		function wp_flush_get_term_by_cache( $term_id, $taxonomy ){
			$term = get_term_by( 'id', $term_id, $taxonomy );
			if ( ! $term ){
				return;
			}
			foreach( array( 'name', 'slug' ) as $field ){
				$cache_key = $field . '|' . $taxonomy . '|' . md5( $term->$field );
				$cache_group = 'get_term_by';
				wp_cache_delete( $cache_key, $cache_group );
			}
		}


		/**
		 * Flush the cache for published pages so we don't end up with stale data
		 *
		 * @param string $new_status The post's new status
		 * @param string $old_status The post's previous status
		 * @param WP_Post $post The post
		 * @link http://vip.wordpress.com/documentation/uncached-functions/ Uncached Functions
		 */
		function flush_get_page_by_title_cache( $new_status, $old_status, $post ){
			if ( 'publish' == $new_status || 'publish' == $old_status )
				wp_cache_delete( $post->post_type . '_' . sanitize_key( $post->post_title ), 'get_page_by_title' );
		}


		/**
		 * Flush the cache for published pages so we don't end up with stale data
		 *
		 * @param string  $new_status The post's new status
		 * @param string  $old_status The post's previous status
		 * @param WP_Post $post       The post
		 *
		 * @link http://vip.wordpress.com/documentation/uncached-functions/ Uncached Functions
		 */
		function flush_get_page_by_path_cache( $new_status, $old_status, $post ){
			if ( 'publish' === $new_status || 'publish' === $old_status ){
				$page_path = get_page_uri( $post->ID );
				wp_cache_delete( $post->post_type . '_' . sanitize_key( $page_path ), 'get_page_by_path' );
			}
		}


		/**
		 * Properly clear term_exists() cache when a term is updated
		 */
		function wp_flush_term_exists( $term, $tt_id, $taxonomy, $deleted_term ){
			foreach( array( 'term_id', 'name', 'slug' ) as $field ){
				$cache_key = $deleted_term->$field . '|' . $taxonomy ;
				$cache_group = 'term_exists';
				wp_cache_delete( $cache_key, $cache_group );
			}
		}

	}

	// Single instance.
	$TIELABS_WP_HELPER = new TIELABS_WP_HELPER();
}
