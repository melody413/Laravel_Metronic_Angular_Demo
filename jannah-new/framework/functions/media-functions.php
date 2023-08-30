<?php
/**
 * Media
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


/**
 * php 5.4 doesn't support adding const.string in the args so we define this as a const
 * to use it in the functions below
 */
define( 'TIELABS_SMALL_IMAGE',  TIELABS_THEME_SLUG.'-image-small' );

/**
 * Custom post thumbnail
 */
if( ! function_exists( 'tie_post_thumbnail' ) ) {

	function tie_post_thumbnail( $thumb = TIELABS_SMALL_IMAGE, $review = 'small', $cat = false, $trending = true, $media_icon = false ){

		echo '
			<a aria-label="'. the_title_attribute( 'echo=0' ) .'" href="'. get_permalink() .'" class="post-thumb">';

			// Get The Rating Score
			if( ! empty( $review ) ) {
				tie_the_score( $review );
			}

			// Large Thumb only
			if( $review == 'large' ){

				// Get the Trending icon
				if( $trending == true ){
					tie_the_trending_icon( 'trending-lg' );
				}

				// Show the Category icon
				$hide_category_meta = is_category() ? false : true;
				$hide_category_meta = apply_filters( 'TieLabs/Archive_Thumbnail/category_meta', $hide_category_meta );

				if( ! empty( $cat ) && $hide_category_meta ){
					tie_the_category( '<span class="post-cat-wrap">', '</span>', true, true );
				}
			}

			// Get the post format icon code
			tie_post_format_icon( $media_icon );

			//array( 'alt' => sprintf( esc_html__( 'Photo of %s', TIELABS_TEXTDOMAIN ), the_title_attribute( 'echo=0' ) ) )

			// Get The Post Thumbnail
			if( ! empty( $thumb ) ){
				the_post_thumbnail( $thumb );
			}

		echo '</a>';
	}
}


/**
 * Get the path of the LazyLoad Placeholder image
 */
if( ! function_exists( 'tie_lazyload_placeholder' ) ) {

	function tie_lazyload_placeholder( $size = '' ){

		// Image Data
		if( apply_filters( 'TieLabs/images/use_data', true ) ){

			switch ( $size ) {

				case 'small':
					return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAG4AAABLAQMAAACr9CA9AAAAA1BMVEX///+nxBvIAAAAAXRSTlMAQObYZgAAABZJREFUOI1jYMADmEe5o9xR7iiXQi4A4BsA388WUyMAAAAASUVORK5CYII=';
					break;

				case 'wide':
					return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAKCAYAAADVTVykAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAB9JREFUeNpi/P//P8NAAiaGAQajDhh1wKgDRh0AEGAAQTcDEcKDrpMAAAAASUVORK5CYII=';
					break;

				case 'square':
					return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEX///+nxBvIAAAAAXRSTlMAQObYZgAAAApJREFUCJljYAAAAAIAAfRxZKYAAAAASUVORK5CYII=';
					break;

				case 'slider':
					return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKYAAABkCAMAAAA7drv6AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAAZQTFRF////AAAAVcLTfgAAAAF0Uk5TAEDm2GYAAAAqSURBVHja7MEBDQAAAMKg909tDjegAAAAAAAAAAAAAAAAAAAAAH5NgAEAQTwAAWZtItYAAAAASUVORK5CYII=';
					break;

				default:
					return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAYYAAADcAQMAAABOLJSDAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAACJJREFUaIHtwTEBAAAAwqD1T20ND6AAAAAAAAAAAAAA4N8AKvgAAUFIrrEAAAAASUVORK5CYII=';
					break;
			}
		}

		// Normal Images
		else{
			$size = ! empty( $size ) ? '-'.$size : '';
			return TIELABS_TEMPLATE_URL.'/assets/images/tie-empty'.$size.'.png';
		}

	}
}


/**
 * Get thumbnail image id
 */
if( ! function_exists( 'tie_thumb_src' ) ) {

	function tie_get_post_thumbnail_id( $id = null ){

		$image_id = get_post_thumbnail_id( $id );

		if( empty( $image_id ) ){
			if( tie_get_option( 'default_featured_image' ) && tie_get_option( 'default_featured_image_id' ) ){
				$image_id = tie_get_option( 'default_featured_image_id' );
			}
		}

		return $image_id;
	}
}


/**
 * Get thumbnail image src
 */
if( ! function_exists( 'tie_thumb_src' ) ) {

	function tie_thumb_src( $size = TIELABS_SMALL_IMAGE ){

		$image_id = tie_get_post_thumbnail_id( get_the_ID() );
		$image    = wp_get_attachment_image_src( $image_id, $size );

		return ! empty( $image[0] ) ? $image[0] : '';
	}
}


/**
 * Get thumbnail image src as background
 */
if( ! function_exists( 'tie_thumb_src_bg' ) ) {

	function tie_thumb_src_bg( $size = TIELABS_SMALL_IMAGE ){

		$image      = tie_thumb_src( $size );
		$background = ! empty( $image ) ? 'url('. $image .')' : 'none';

		return esc_attr( 'background-image: '.$background );
	}
}


/**
 * Get slider image URL by ID
 */
if( ! function_exists( 'tie_slider_img_src' ) ) {

	function tie_slider_img_src( $image_id, $size ){
		$image = wp_get_attachment_image_src( $image_id, $size );
		return ! empty( $image[0] ) ? $image[0] : '';
	}
}


/**
 * Get slider image URL by ID as background
 */
if( ! function_exists( 'tie_slider_img_src_bg' ) ) {

	function tie_slider_img_src_bg( $image_id, $size ){

		$image      = tie_slider_img_src( $image_id, $size );
		$background = 'none';

		if( ! empty( $image ) ) {
			$background = 'url('. $image .')';
		}

		return esc_attr( 'background-image: '.$background );
	}
}


/**
 * Get Post Audio
 */
if( ! function_exists( 'tie_audio' ) ) {

	function tie_audio( $poster_size = false ){

		// SoundCloud
		if( $soundcloud = tie_get_postdata( 'tie_audio_soundcloud' ) ) {
			echo tie_soundcloud( $soundcloud, 'false', 'true' );
		}

		// Self Hosted audio
		elseif( tie_get_postdata( 'tie_audio_mp3' ) || tie_get_postdata( 'tie_audio_m4a' ) || tie_get_postdata( 'tie_audio_oga' ) ){

			$mp3 = tie_get_postdata( 'tie_audio_mp3' );
		  $m4a = tie_get_postdata( 'tie_audio_m4a' );
		  $oga = tie_get_postdata( 'tie_audio_oga' );

			the_post_thumbnail( $poster_size );

			echo do_shortcode('[audio mp3="'.$mp3.'" ogg="'.$oga.'" m4a="'.$m4a.'"]');
		}

		// Embed Audio Code
		elseif( $embed_code = tie_get_postdata( 'tie_audio_embed' ) ){
			echo do_shortcode( $embed_code );
		}
	}
}


/**
 * Get Post Video
 */
if( ! function_exists( 'tie_video' ) ) {

	function tie_video(){

		// YouTube, Vimeo, etc direct link
		if( $video_url = tie_get_postdata( 'tie_video_url' ) ){

			// facebook
			if( strpos( $video_url, 'facebook.com' ) !== false ){
				$video_output = tie_facebook_video( $video_url );
			}

			// Twitter
			elseif( strpos( $video_url, 'twitter.com' ) !== false ){
				echo tie_twitter_video( $video_url );
				return;
			}

			// OEmbed external url
			else{
				$wp_embed = new WP_Embed();
				$video_output = $wp_embed->autoembed( $video_url );

				// Backup plan, in some cases the oEmbed returns especially with Youtube false due to API or Cache issues
				if( ! $video_output || ( $video_output == $video_url ) ){
					$video_output = '<iframe loading="lazy" width="1280" height="720" src="'. tie_get_video_embed( $video_url ) .'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
				}
			}
		}

		// Self hosted video
		elseif( $video_self = tie_get_postdata( 'tie_video_self' ) ) {
			$video_output = do_shortcode( '[video width="1280" height="720" mp4="'. $video_self .'"][/video]' );
		}

		// Video embed code
		elseif( $embed_code = tie_get_postdata( 'tie_embed_code' ) ) {
			$video_output = do_shortcode( $embed_code );
		}

		// Display the video
		if( ! empty( $video_output ) ) {
			echo '<div class="tie-fluid-width-video-wrapper tie-ignore-fitvid">'. $video_output .'</div>';
		}
	}
}


/**
 * Video embed URL
 */
if( ! function_exists( 'tie_video_embed' ) ) {

	function tie_video_embed(){

		if( $video_url = tie_get_postdata( 'tie_video_url' ) ) {
			$video_output = tie_get_video_embed( $video_url );
		}

		return ! empty( $video_output ) ? $video_output : esc_url(home_url( '/' ));
	}

}


/**
 * Get Video embed URL
 */
if( ! function_exists( 'tie_get_video_embed' ) ) {

	function tie_get_video_embed( $video_url ){

		if( empty( $video_url ) ){
			return;
		}

		$video_link = parse_url( $video_url );

		// youtube.com video
		if ( $video_link['host'] == 'www.youtube.com' || $video_link['host']  == 'youtube.com' ){
			parse_str( parse_url( $video_url, PHP_URL_QUERY ), $video_array_of_vars );
			$video_id     =  $video_array_of_vars['v'] ;
			$video_output = 'https://www.youtube.com/embed/'.$video_id.'?rel=0&wmode=opaque&autohide=1&border=0&egm=0&showinfo=0';
		}

		// youtu.be video
		elseif( $video_link['host'] == 'www.youtu.be' || $video_link['host']  == 'youtu.be' ){
			$video_id     = substr( parse_url( $video_url, PHP_URL_PATH ), 1 );
			$video_output = 'https://www.youtube.com/embed/'.$video_id.'?rel=0&wmode=opaque&autohide=1&border=0&egm=0&showinfo=0';
		}

		// vimeo.com video
		elseif( $video_link['host'] == 'www.vimeo.com' || $video_link['host']  == 'vimeo.com' ){
			$video_id     = (int) substr( parse_url( $video_url, PHP_URL_PATH ), 1 );
			$video_output = 'https://player.vimeo.com/video/'.$video_id.'?wmode=opaque';
		}

		else{
			$video_output = $video_url;
		}

		if( ! empty( $video_output ) ){
			return $video_output;
		}
	}
}


/**
 * Google Map
 */
if( ! function_exists( 'tie_google_maps' ) ) {

	function tie_google_maps( $url ){

		if( empty( $url ) ){
			return;
		}

		if( strpos( $url, 'embed' ) !== false ){
			$url .= '&amp;output=embed';
		}
		elseif( tie_get_option( 'api_google_maps' ) ){

			$api_key  = TIELABS_HELPER::remove_spaces( tie_get_option( 'api_google_maps' ) );
			$url_attr = parse_url( $url );
			$url_attr = str_replace( '/maps/place/', '', $url_attr );

			if( ! empty( $url_attr['path'] ) ) {
				$url_attr = explode( '/', $url_attr['path'] );
				$location = $url_attr[0];

				$url = "https://www.google.com/maps/embed/v1/place?key=$api_key&q=$location";
			}
		}
		else{

			 TIELABS_HELPER::notice_message( esc_html__( 'You need to set the Google Map API Key in the theme options page > Integrations.', TIELABS_TEXTDOMAIN ) );
		}

		return '
			<div class="google-map">
				<iframe loading="lazy" width="1280" height="720" frameborder="0" title="Map" src="'.$url.'" async></iframe>
			</div>
		';
	}
}


/**
 * Soundcloud
 */
if( ! function_exists( 'tie_soundcloud' ) ) {

	function tie_soundcloud( $url, $autoplay = 'false', $visual = 'true' ){
		if( empty( $url )) return;

		return '<iframe loading="lazy" width="100%" height="350" scrolling="no" frameborder="no" src="//w.soundcloud.com/player/?url='.$url.'&amp;auto_play='.$autoplay.'&amp;show_artwork=true&amp;visual='.$visual.'" async></iframe>';
	}
}


/**
 * Facebook Video
 */
if( ! function_exists( 'tie_facebook_video' ) ) {

	function tie_facebook_video( $url ){

		if( empty( $url ) ){
			return;
		}

		return '<iframe loading="lazy" src="//www.facebook.com/plugins/video.php?href='. urlencode( $url ) .'&show_text=0&width=780" width="780" height="439" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe>';
	}
}


/**
 * Twitter Video
 */
if( ! function_exists( 'tie_twitter_video' ) ) {

	function tie_twitter_video( $url ){

		if( empty( $url ) ){
			return;
		}

		$video_id = explode( 'status/', $url );

		if( ! empty( $video_id ) && is_array( $video_id ) && ! empty( $video_id[1] ) ){

			return '
				<div class="twitter-video-wrap">
					<iframe loading="lazy" src="https://twitter.com/i/videos/tweet/'. $video_id[1] .'" allowfullscreen="" width="780" height="439" allow="autoplay; fullscreen" id="player_tweet_'. $video_id[1] .'" width=></iframe>
				</div>
			';
		}

		return $url;
	}
}
