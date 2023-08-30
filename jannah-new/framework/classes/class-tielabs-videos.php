<?php
/**
 * Video Playlist Class
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly



if( ! class_exists( 'TIELABS_VIDEOS' ) ) {

	class TIELABS_VIDEOS {


		/**
		 * Runs on class initialization. Adds filters and actions.
		 */
		function __construct() {

			// Save Videos list block
			add_filter( 'TieLabs/save_block', array( $this, 'save_block' ) );

			// Save Videos list category
			add_filter( 'TieLabs/save_category', array( $this, 'save_category' ) );

			// Download and set the featured image
			add_filter( 'save_post', array( $this, 'save_post' ), 10, 2 );

		}


		/**
		 * Download and assign the featured image while Saving the Post
		 */
		function save_post( $post_id, $post ){

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			// We need to prevent trying to assign when trashing or untrashing posts in the list screen.
			// get_current_screen() was not providing a unique enough value to use here.
			if ( isset( $_REQUEST['action'] ) && in_array( $_REQUEST['action'], array( 'trash', 'untrash' ) )  ) {
				return;
			}

			// Check if the post has a featured image
			if ( empty( $post_id ) || has_post_thumbnail( $post_id ) || wp_is_post_revision( $post_id ) ){
				return;
			}

			// Check if the post is a Video and has tie_video_url
			if( ! empty( $_POST[ 'tie_post_head' ] ) && $_POST[ 'tie_post_head' ] == 'video' && ! empty( $_POST[ 'tie_video_url' ] ) ){

				$video = $_POST[ 'tie_video_url' ];

				// YouTube
				if( $video_id = self::is_youtube( $video ) ){

					$video_data = self::get_youtube_info( $video_id );

					$sizes_array = array( 'maxres', 'standard', 'high', 'medium' );

					foreach ( $sizes_array as $size ) {

						if( ! empty( $video_data['snippet']['thumbnails'][ $size ] ) ){
							$video_thumbnail_url = $video_data['snippet']['thumbnails'][ $size ]['url'];
							break;
						}
					}
				}
				// Vimeo
				elseif( $video_id = self::is_vimeo( $video ) ) {

					$video_data = self::get_vimeo_info( $video_id );

					if( ! empty( $video_data['thumbnail_large'] ) ){
						$video_thumbnail_url = $video_data['thumbnail_large'];
					}
					elseif( ! empty( $video_data['thumbnail_medium'] ) ){
						$video_thumbnail_url = $video_data['thumbnail_medium'];
					}
				}

				// Set Thumbnail
				if( ! empty( $video_thumbnail_url ) ) {

					$attachment_id = self::download_thumbnail( $video_thumbnail_url, $post_id, $video_id );

					if ( is_wp_error( $attachment_id ) ) {
						return;
					}

					// Woot! We got an image, so set it as the post thumbnail.
					set_post_thumbnail( $post_id, $attachment_id );
				}
			}
		}


		/**
		 * Set the post thumbnail
		 */
		public static function download_thumbnail( $url, $post_id, $video_id ) {

			$filename = sanitize_title( preg_replace( '/[^a-zA-Z0-9\s]/', '-', get_the_title() ) ) . '-' . $video_id;

			require_once( ABSPATH . 'wp-admin/includes/file.php' );

			// Download file to temp location, returns full server path to temp file, ex; /home/user/public_html/mysite/wp-content/26192277_640.tmp.
			$tmp = download_url( $url );

			// If error storing temporarily, unlink.
			if ( is_wp_error( $tmp ) ) {
				// And output wp_error.
				return $tmp;
			}

			// Fix file filename for query strings.
			preg_match( '/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $url, $matches );

			// Extract filename from url for title.
			$url_filename = basename( $matches[0] );

			// Determine file type (ext and mime/type).
			$url_type = wp_check_filetype( $url_filename );

			// Override filename if given, reconstruct server path.
			if ( ! empty( $filename ) ) {
				$filename = sanitize_file_name( $filename );

				// Extract path parts.
				$tmppath = pathinfo( $tmp );

				// Build new path.
				$new = $tmppath['dirname'] . '/' . $filename . '.' . $tmppath['extension'];

				// Renames temp file on server.
				rename( $tmp, $new );

				// Push new filename (in path) to be used in file array later.
				$tmp = $new;
			}

			// Full server path to temp file.
			$file_array['tmp_name'] = $tmp;

			if ( ! empty( $filename ) ) {
				// User given filename for title, add original URL extension.
				$file_array['name'] = $filename . '.' . $url_type['ext'];
			}
			else {
				// Just use original URL filename.
				$file_array['name'] = $url_filename;
			}

			$post_data = array(
				// Just use the original filename (no extension).
				'post_title'  => get_the_title( $post_id ),
				// Make sure gets tied to parent.
				'post_parent' => $post_id,
			);

			// Required libraries for media_handle_sideload.
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/media.php' );
			require_once( ABSPATH . 'wp-admin/includes/image.php' );

			// Do the validation and storage stuff.
			// $post_data can override the items saved to wp_posts table, like post_mime_type, guid, post_parent, post_title, post_content, post_status.
			$att_id = media_handle_sideload( $file_array, $post_id, null, $post_data );

			// If error storing permanently, unlink.
			if ( is_wp_error( $att_id ) ) {
				// Clean up.
				@unlink( $file_array['tmp_name'] );

				// And output wp_error.
				return $att_id;
			}

			return $att_id;
		}


		/**
		 * Save Videos list block
		 */
		function save_block( $sections ){

			if( !empty( $sections ) && is_array( $sections ) ){
				foreach ( $sections as $s_id => $section ){
					if( ! empty( $section['blocks'] ) && is_array( $section['blocks'] ) ) {
						foreach( $section['blocks'] as $b_id => $block ){

							if( ! empty( $block['style'] ) && $block['style'] == 'videos_list' && ! empty( $block['videos'] ) ){
								$videos_list = explode( PHP_EOL, $block['videos'] );
								$videos_data = self::get_video_info( $videos_list );

								$sections[ $s_id ]['blocks'][ $b_id ]['videos_list_data'] = $videos_data;
							}

						}
					}
				}
			}

			return $sections;
		}


		/**
		 * Save Videos list category
		 */
		function save_category( $category_data ){

			if( ! empty( $category_data['featured_posts'] ) && ! empty( $category_data['featured_posts_style'] ) && $category_data['featured_posts_style'] == 'videos_list' && ! empty( $category_data['featured_videos_list'] ) ) {

				$videos_list = explode( PHP_EOL, $category_data['featured_videos_list'] );
				$videos_data = self::get_video_info( $videos_list );

				# Return the videos data
				$category_data['featured_videos_list_data'] = $videos_data;
			}

			return $category_data;
		}


		/*
		 * Get Videos List data
		 */
		public static function get_video_info( $videos_list ){

			$videos_ids	     = array();
			$vimeo_ids	     = array();
			$videos_list     = array_filter( $videos_list );
			$youtube_videos  = get_option( 'tie_youtube_videos', array() );
			$vimeo_videos    = get_option( 'tie_vimeo_videos', array() );
			$youtube_updated = false;
			$vimeo_updated   = false;

			if( ! empty( $youtube_videos ) && ! is_array( $youtube_videos ) ){
				delete_option( 'tie_youtube_videos' );
				$youtube_videos = array();
			}

			if( ! empty( $vimeo_videos ) && ! is_array( $vimeo_videos ) ){
				delete_option( 'tie_vimeo_videos' );
				$vimeo_videos = array();
			}

			// Reset the api error
			delete_option( 'tie_youtube_api_error' );

			//
			foreach ( $videos_list as $video ){

				// YouTube
				if( $video_id = self::is_youtube( $video ) ) {

					$videos_ids[] = array(
						'id'   => $video_id,
						'type' => 'y',
					);

					if( ! isset( $youtube_videos[ $video_id ] ) ){

						$video_info = self::get_youtube_info( $video_id );

						if( $video_info ){

							$the_video = array();

							// Prepare the Video duration
							if( ! empty( $video_info['contentDetails']['duration'] ) ) {
								$interval     = new DateInterval( $video_info['contentDetails']['duration'] );
								$duration_sec = $interval->h * 3600 + $interval->i * 60 + $interval->s;
								$time_format  = ( $duration_sec >= 3600 ) ? 'H:i:s' : 'i:s';

								$the_video['duration'] = gmdate( $time_format, $duration_sec );
							}

							// Video data
							$the_video['title'] = self::remove_emoji( $video_info['snippet']['title'] );
							$the_video['id']    = $video_id;

							$youtube_videos[ $video_id ] = $the_video;
							$youtube_updated = true;
						}
					}
				}

				// Vimeo
				elseif( $video_id = self::is_vimeo( $video ) ) {

					$videos_ids[] = array(
						'id'   => $video_id,
						'type' => 'v',
					);

					if( ! isset( $vimeo_videos[ $video_id ] ) ){

						$video_info = self::get_vimeo_info( $video_id );

						if( $video_info ){

							$the_video = array();

							// Prepare the Video duration
							if( ! empty( $video_info['duration'] ) ){

								$duration_sec = $video_info['duration'];
								$time_format  = ( $duration_sec >= 3600 ) ? 'H:i:s' : 'i:s';

								$the_video['duration'] = gmdate( $time_format, $duration_sec );
							}

							// Prepare the Video thumbnail
							if( ! empty( $video_info['thumbnail_small'] ) ){
								$video_thumb    = @parse_url( $video_info['thumbnail_small'] );
								$video_thumb    = str_replace( '/video/', '', $video_thumb['path'] );
								$the_video['thumb'] = $video_thumb;
							}

							// Video data
							$the_video['title'] = self::remove_emoji( $video_info['title'] );
							$the_video['id']    = $video_id;

							$vimeo_videos[ $video_id ] = $the_video;
							$vimeo_updated = true;
						}
					}
				}

			}

			if( $youtube_updated ){
				update_option( 'tie_youtube_videos', $youtube_videos, false );
			}

			if( $vimeo_updated ){
				update_option( 'tie_vimeo_videos', $vimeo_videos, false );
			}

			return $videos_ids;
		}


		/**
		 * Check if the Video is YouTube
		 */
		private static function is_youtube( $video ) {
			preg_match( "#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $video, $matches );

			if( ! empty( $matches[0] ) ){
				return TIELABS_HELPER::remove_spaces( $matches[0] );
			}

			return false;
		}


		/**
		 * Get YouTube Video data
		 */
		private static function get_youtube_info( $vid ){

			if( ! tie_get_option( 'api_youtube' ) ){
				return false;
			}

			// Build the Api request
			$params = array(
				'part' => 'snippet,contentDetails',
				'id'   => $vid,
				'key'  => TIELABS_HELPER::remove_spaces( tie_get_option( 'api_youtube' ) ),
			);

			$api_url = 'https://www.googleapis.com/youtube/v3/videos?' . http_build_query( $params );
			$request = wp_remote_get( $api_url );

			// Check if there are errors
			if( is_wp_error( $request ) ){
				tie_debug_log( $request->get_error_message(), true );
				return null;
			}

			// Prepare the data
			$result = json_decode( wp_remote_retrieve_body( $request ), true );

			// Check Youtube API Errors
			if( ! empty( $result['error']['errors'][0]['message'] ) ){
				update_option( 'tie_youtube_api_error', $result['error']['errors'][0]['message'], 'no' );
				tie_debug_log( $result['error']['errors'][0]['message'], true );
				return null;
			}

			// Check if the video title is exists
			if( empty( $result['items'][0]['snippet']['title'] ) ) {
				return null;
			}

			return $result['items'][0];
		}


		/**
		 * Check if the Video is Vimeo
		 */
		private static function is_vimeo( $video ) {
			preg_match( "/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $video, $matches );

			if( ! empty( $matches[5] ) ){
				return TIELABS_HELPER::remove_spaces( $matches[5] );
			}

			return false;
		}


		/**
		 * Get Vimeo Video data
		 */
		private static function get_vimeo_info( $vid ){

			// Build the Api request
			$api_url = "https://vimeo.com/api/v2/video/$vid.json";
			$request = wp_remote_get( $api_url );

			// Check if there is no any errors
			if( is_wp_error( $request ) ){

				tie_debug_log( $request->get_error_message(), true );

				return null;
			}

			// Prepare the data
			$result = json_decode( wp_remote_retrieve_body( $request ), true );

			// Check if the video title exists
			if( empty( $result[0]['title'] ) ){
				return null;
			}

			return $result[0];
		}


		/**
		 * Remove emojis
		 *
		 * Causes issues https://core.trac.wordpress.org/ticket/21212
		 */
		private static function remove_emoji( $string ) {

			// Match Emoticons
			$regex_emoticons = '/[\x{1F600}-\x{1F64F}]/u';
			$clear_string = preg_replace($regex_emoticons, '', $string);

			// Match Miscellaneous Symbols and Pictographs
			$regex_symbols = '/[\x{1F300}-\x{1F5FF}]/u';
			$clear_string = preg_replace($regex_symbols, '', $clear_string);

			// Match Transport And Map Symbols
			$regex_transport = '/[\x{1F680}-\x{1F6FF}]/u';
			$clear_string = preg_replace($regex_transport, '', $clear_string);

			// Match Miscellaneous Symbols
			$regex_misc = '/[\x{2600}-\x{26FF}]/u';
			$clear_string = preg_replace($regex_misc, '', $clear_string);

			// Match Dingbats
			$regex_dingbats = '/[\x{2700}-\x{27BF}]/u';
			$clear_string = preg_replace($regex_dingbats, '', $clear_string);

			return $clear_string;
		}

	}

	// Instantiate the class
	new TIELABS_VIDEOS();

}
