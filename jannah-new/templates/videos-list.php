<?php
/**
 * Videos List
 *
 * This template can be overridden by copying it to your-child-theme/templates/videos-list.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  5.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


if( empty( $videos_data ) ){
	return;
}

// Enqueue the Videos Playlist Js file
wp_enqueue_script( 'tie-js-videoslist' );

// Variables
$youtube_thumbnail_base = 'https://i.ytimg.com/vi/';
$youtube_player_base    = 'https://www.youtube.com/embed/';
$vimeo_thumbnail_base   = 'https://i.vimeocdn.com/video/';
$vimeo_player_base      = 'https://player.vimeo.com/video/';
$playlist_has_title     = ! empty( $title ) ? ' playlist-has-title' : '';
$videos_count           = count( $videos_data );
$videos_list            = array();
$youtube_videos         = get_option( 'tie_youtube_videos' );
$vimeo_videos           = get_option( 'tie_vimeo_videos' );

$custom_color = ! empty( $color ) ? $color : tie_get_object_option( 'global_color', 'cat_color', 'post_color' );
$custom_color = str_replace( '#', '', $custom_color );

// Get Videos
foreach ( $videos_data as $video ){

	// YouTube
	if( $video['type'] == 'y' ){

		$video_id = $video['id'];

		if( ! empty( $youtube_videos[ $video_id ] ) ) {
			$video_data          = $youtube_videos[ $video_id ];
			$video_data['thumb'] = $youtube_thumbnail_base. $video_id .'/default.jpg';
			$video_data['id']    = $youtube_player_base. $video_id .'?enablejsapi=1&amp;rel=0&amp;showinfo=0';
		}
	}

	// Vimeo
	elseif( $video['type'] == 'v' ){

		$video_id = $video['id'];

		if( ! empty( $vimeo_videos[ $video_id ] ) ) {
			$video_data          = $vimeo_videos[ $video_id ];
			$video_data['thumb'] = $vimeo_thumbnail_base. $video_data['thumb'];
			$video_data['id']    = $vimeo_player_base. $video_id .'?api=1&amp;title=0&amp;byline=0&amp;color='. $custom_color;
		}
	}

	if( ! empty( $video_data ) ){
		$videos_list[] = $video_data;
	}
}


if( ! tie_get_option( 'api_youtube' ) ){
	TIELABS_HELPER::notice_message( esc_html__( 'You need to set the YouTube API Key in the theme options page > Integrations.', TIELABS_TEXTDOMAIN ) );
}
elseif( get_option( 'tie_youtube_api_error' ) ){
	TIELABS_HELPER::notice_message( esc_html__( 'YouTube API ERROR, Go to the Youtube API Console on Google Cloud and remove any restrictions on the API key, Then edit the current page and click on the Update/Save button to re-connect to the YouTube servers to load the videos.', TIELABS_TEXTDOMAIN ) .'<br /><br /><em>'. get_option( 'tie_youtube_api_error' ) .'</em>' );
}
?>

<div class="videos-block">
	<div class="video-playlist-wrapper">

		<?php tie_get_ajax_loader(); ?>

		<div class="video-player-wrapper tie-ignore-fitvid">
			<?php foreach( $videos_list as $video ): ?>
				<iframe class="video-frame" id="video-<?php echo esc_attr( $id ) ?>-1" src="<?php echo esc_attr( $video['id'] ) ?>" title="Videos List" width="771" height="434" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen async></iframe>
			<?php break; endforeach; ?>
		</div><!-- .video-player-wrapper -->

	</div><!-- .video-playlist-wrapper /-->

	<div class="video-playlist-nav-wrapper">

		<?php if( ! empty( $title ) ): ?>
			<div class="playlist-title">
				<div class="playlist-title-icon"><span class="tie-icon-play" aria-hidden="true"></span></div>
				<h2><?php echo esc_html( $title ) ?></h2>
				<span class="videos-number">
					<span class="video-playing-number">1</span> / <span class="video-totlal-number"><?php echo ( $videos_count ) ?></span> <?php esc_html_e( 'Videos', TIELABS_TEXTDOMAIN ); ?>
				</span>
			</div> <!-- .playlist-title /-->
		<?php endif; ?>

		<div data-height="window" class="video-playlist-nav has-custom-scroll<?php echo esc_attr( $playlist_has_title ) ?>">

		<?php

			$video_number = 0;
			foreach( $videos_list as $video ):
				$video_number++;
				?>
				<div data-name="video-<?php echo esc_attr( $id. '-' .$video_number ) ?>" data-video-src="<?php echo esc_attr( $video['id'] ) ?>" class="video-playlist-item">
					<div class="video-number"><?php echo esc_attr( $video_number ) ?></div>
					<div class="video-play-icon"><span class="tie-icon-play" aria-hidden="true"></span></div>
					<div class="video-paused-icon"><span class="tie-icon-pause" aria-hidden="true"></span></div>

					<?php
						if( tie_get_option( 'lazy_load' ) ) { ?>
							<div data-lazy-bg="<?php echo esc_attr( $video['thumb'] ); ?>" class="video-thumbnail post-thumb"></div>
							<?php
						}
						else{ ?>
							<div style="background-image: url(<?php echo esc_attr( $video['thumb'] ); ?>)" class="video-thumbnail post-thumb"></div>
							<?php
						}
					?>

					<div class="video-info">
						<h2><?php echo esc_attr( $video['title'] ) ?></h2>
						<span class="video-duration"><?php echo esc_attr( $video['duration'] ) ?></span>
					</div><!-- .video-info -->
				</div><!-- video-playlist-item -->
				<?php
			endforeach;

		?>

		</div><!-- .video-playlist-nav /-->
	</div><!-- .video-playlist-nav-wrapper /-->
</div><!-- .videos-block /-->
