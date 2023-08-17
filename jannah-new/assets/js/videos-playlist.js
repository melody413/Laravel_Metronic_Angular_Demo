/*! FAKTOR VIER Video Controller v0.1.3 | (c) 2015 FAKTOR VIER GmbH | http://faktorvier.ch */
function tieIsJson(a){a="string"!=typeof a?JSON.stringify(a):a;try{a=JSON.parse(a)}catch(a){return!1}return"object"==typeof a&&null!==a}function onYouTubeIframeAPIReady(){if(void 0!==jQuery.video)for(callback_index in jQuery.video.global.youtube_api_ready_callbacks)jQuery.video.global.youtube_api_ready_callbacks[callback_index]()}var video_postmessage_event_func="attachEvent",video_postmessage_event="onmessage";window.addEventListener&&(video_postmessage_event_func="addEventListener",video_postmessage_event="message"),window[video_postmessage_event_func](video_postmessage_event,function(a){if(tieIsJson(a.data)&&/^https?:\/\/player.vimeo.com/.test(a.origin)&&"object"!=typeof a.data){var b=JSON.parse(a.data);if(void 0!==b.player_id&&-1===b.player_id.indexOf("VideoWorker")){var c=void 0===b.event?null:b.event,e=(void 0===b.method||b.method,jQuery("#"+b.player_id)),f=e.getVideoConfig();switch(null==f&&(e.initVideo(),f=e.getVideoConfig()),c){case"ready":jQuery.video.vimeo_postmessage(e,"addEventListener","play"),jQuery.video.vimeo_postmessage(e,"addEventListener","pause"),jQuery.video.vimeo_postmessage(e,"addEventListener","finish"),e.data("video-player",e),e.attr(f.attr_ready,""),e.trigger("ready"+jQuery.video.global.event_suffix);break;case"play":e.removeAttr(f.attr_paused),e.attr(f.attr_playing,""),e.trigger("play"+jQuery.video.global.event_suffix);break;case"pause":e.removeAttr(f.attr_playing),e.attr(f.attr_paused,""),e.trigger("pause"+jQuery.video.global.event_suffix);break;case"finish":e.removeAttr(f.attr_playing),e.removeAttr(f.attr_paused),e.trigger("finish"+$.video.global.event_suffix)}}}},!1),function(a){a.video={global:{event_suffix:"_video",youtube_api_ready_callbacks:[],youtube_iframe_api:"https://www.youtube.com/iframe_api"},config:{attr_ready:"data-video-ready",attr_playing:"data-video-playing",attr_paused:"data-video-paused"}};var b=function(b,c){var d=b.data("video").config;if(void 0===b.data("video-player")){var e=function(){var e=new YT.Player(b[0],{events:{onReady:function(a){b.attr(d.attr_ready,""),c(a.target)},onStateChange:function(c){switch(c.data){case 0:b.removeAttr(d.attr_paused),b.removeAttr(d.attr_playing),b.trigger("finish"+a.video.global.event_suffix);break;case 1:b.removeAttr(d.attr_paused),b.attr(d.attr_playing,""),b.trigger("play"+a.video.global.event_suffix);break;case 2:b.removeAttr(d.attr_playing),b.attr(d.attr_paused,""),b.trigger("pause"+a.video.global.event_suffix)}}}});b.data("video-player",e)};"undefined"==typeof YT||void 0===YT.Player?(a.video.global.youtube_api_ready_callbacks.push(function(){e()}),0==a('script[src="https://www.youtube.com/iframe_api"]').length&&0==a('script[src="http://www.youtube.com/iframe_api"]').length&&a("<script></script>").attr("src",a.video.global.youtube_iframe_api).insertBefore(a("script").first())):e()}else c(b.data("video-player"))},c=function(a,b){void 0!==a.data("video-player")&&b(a.data("video-player"))};a.video.vimeo_postmessage=function(a,b,c){var d={method:b};c&&(d.value=c),void 0!==a[0]&&a[0].contentWindow.postMessage(JSON.stringify(d),"*")},a.fn.getVideoConfig=function(){var b=a(this).first();return void 0!==b.data("video")?b.data("video").config:null},a.fn.getVideoPlayer=function(){var b=a(this).first();return void 0!==b.data("video-player")?b.data("video-player"):null},a.fn.getVideoType=function(){var b=a(this).first();return"video"==b.prop("tagName").toLowerCase()?video_type="video":-1!==b.attr("src").indexOf("youtube.com/embed")?video_type="youtube":-1!==b.attr("src").indexOf("player.vimeo.com/video")?video_type="vimeo":video_type="undefined",video_type},a.fn.initVideo=function(d){return this.each(function(){var e=a(this),f=e.getVideoType(),g=e.getVideoConfig();if(null!=g)return console.warn("Player already initialized!"),!1;if(g=a.extend(a.extend({},a.video.config),d),e.data("video",{config:g}),"youtube"==f)-1==e.attr("src").indexOf("enablejsapi=true")&&-1==e.attr("src").indexOf("enablejsapi=1")&&(-1==e.attr("src").indexOf("?")?e.attr("src",e.attr("src")+"?enablejsapi=1"):e.attr("src",e.attr("src")+"&enablejsapi=1"));else if("vimeo"==f&&(-1==e.attr("src").indexOf("api=true")&&-1==e.attr("src").indexOf("api=1")&&(-1==e.attr("src").indexOf("?")?e.attr("src",e.attr("src")+"?api=1"):e.attr("src",e.attr("src")+"&api=1")),-1==e.attr("src").indexOf("player_id="))){var h=e.attr("id");void 0===h&&(h="video-"+Math.round((new Date).getTime()+100*Math.random()),e.attr("id",h)),-1==e.attr("src").indexOf("?")?e.attr("src",e.attr("src")+"?player_id="+h):e.attr("src",e.attr("src")+"&player_id="+h)}"video"==f?(4==e.get(0).readyState?(e.attr(g.attr_ready,""),e.trigger("ready"+a.video.global.event_suffix)):e.get(0).addEventListener("canplaythrough",function(){e.attr(g.attr_ready,""),e.trigger("ready"+a.video.global.event_suffix),e.get(0).removeEventListener("canplaythrough",this)},!1),e.bind("play",function(){e.removeAttr(g.attr_paused),e.attr(g.attr_playing,""),e.trigger("play"+a.video.global.event_suffix)}),e.bind("pause",function(){e.removeAttr(g.attr_playing),e.attr(g.attr_paused,""),e.trigger("pause"+a.video.global.event_suffix)}),e.bind("ended",function(){e.removeAttr(g.attr_playing),e.removeAttr(g.attr_paused),e.trigger("finish"+a.video.global.event_suffix)}),e.data("video-player",e[0])):"youtube"==f?b(e,function(b){e.trigger("ready"+a.video.global.event_suffix)}):"vimeo"==f&&c(e,function(b){e.trigger("ready"+a.video.global.event_suffix)})})},a.fn.playVideo=function(){return this.each(function(){var d=a(this),e=d.getVideoType(),f=d.getVideoPlayer();if(null==f)return console.warn("Player not initialized!"),!1;"video"==e?f.play():"youtube"==e?b(d,function(a){a.playVideo()}):"vimeo"==e&&c(d,function(b){a.video.vimeo_postmessage(b,"play")})})},a.fn.pauseVideo=function(){return this.each(function(){var d=a(this),e=d.getVideoType(),f=d.getVideoPlayer();if(null==f)return console.warn("Player not initialized!"),!1;"video"==e?f.pause():"youtube"==e?b(d,function(a){a.pauseVideo()}):"vimeo"==e&&c(d,function(b){a.video.vimeo_postmessage(b,"pause")})})},a.fn.stopVideo=function(){return this.each(function(){var d=a(this),e=d.getVideoType(),f=d.getVideoPlayer();if(null==f)return console.warn("Player not initialized!"),!1;"video"==e?(f.pause(),f.currentTime=0):"youtube"==e?b(d,function(a){a.seekTo(a.getDuration())}):"vimeo"==e&&c(d,function(b){a.video.vimeo_postmessage(b,"unload")})})},a.fn.restartVideo=function(){return this.each(function(){var d=a(this),e=d.getVideoType(),f=d.getVideoPlayer();d.getVideoConfig();if(null==f)return console.warn("Player not initialized!"),!1;"video"==e?(f.currentTime=0,f.play()):"youtube"==e?b(d,function(b){b.seekTo(0),b.playVideo(),d.trigger("restart"+a.video.global.event_suffix)}):"vimeo"==e&&c(d,function(b){a.video.vimeo_postmessage(b,"seekTo","0"),a.video.vimeo_postmessage(b,"play"),d.trigger("restart"+a.video.global.event_suffix)})})},a.fn.muteVideo=function(){return this.each(function(){var d=a(this),e=d.getVideoType(),f=d.getVideoPlayer();if(null==f)return console.warn("Player not initialized!"),!1;"video"==e?f.muted=!0:"youtube"==e?b(d,function(a){a.mute()}):"vimeo"==e&&c(d,function(b){a.video.vimeo_postmessage(b,"setVolume","0")})})},a.fn.unmuteVideo=function(){return this.each(function(){var d=a(this),e=d.getVideoType(),f=d.getVideoPlayer();if(null==f)return console.warn("Player not initialized!"),!1;"video"==e?f.muted=!1:"youtube"==e?b(d,function(a){a.unMute()}):"vimeo"==e&&c(d,function(b){a.video.vimeo_postmessage(b,"setVolume",1)})})},a.fn.seekToVideo=function(d){return this.each(function(){var e=a(this),f=e.getVideoType(),g=e.getVideoPlayer();if(null==g)return console.warn("Player not initialized!"),!1;"video"==f?g.currentTime=d:"youtube"==f?b(e,function(a){a.seekTo(d)}):"vimeo"==f&&c(e,function(b){a.video.vimeo_postmessage(b,"seekTo",d)})})},a.fn.destroyVideo=function(){return this.each(function(){var b=a(this),e=(b.getVideoType(),b.getVideoPlayer(),b.getVideoConfig());null!=e&&(b.removeData("video"),b.removeData("video-player"),b.removeAttr(e.attr_ready),b.removeAttr(e.attr_playing),b.removeAttr(e.attr_paused),b.trigger("destroy"+a.video.global.event_suffix))})},a.fn.addVideoEvent=function(b,c){return this.each(function(){var d=a(this),e=d.getVideoType(),f=d.getVideoPlayer();"play"!=b||"video"!=e||void 0===d.get(0).paused||d.get(0).paused||c(null,d,e,f),d.bind(b+a.video.global.event_suffix,function(a){c(a,d,e,f)})})},a.fn.removeVideoEvent=function(b){return this.each(function(){a(this).unbind(b+a.video.global.event_suffix)})},a.fn.video=function(){var b="init",c={};return"string"==typeof arguments[0]?(b=arguments[0],c=arguments[1]):c=arguments[0],this.each(function(){var d=a(this);switch(b){case"init":d.initVideo(c);break;case"play":d.playVideo();break;case"pause":d.pauseVideo();break;case"stop":d.stopVideo();break;case"restart":d.restartVideo();break;case"mute":d.muteVideo();break;case"unmute":d.unmuteVideo();break;case"seekTo":d.seekToVideo(c);break;case"destroy":d.destroyVideo();break;case"addEvent":d.addVideoEvent(c[0],c[1]);break;case"removeEvent":d.removeVideoEvent(c[0]);break;default:console.warn('Video action "'+b+'" not found')}})}}(jQuery);

/**
 * Videos Playlist
 */
jQuery(document).ready(function(){

	'use strict';

	jQuery('.videos-block').each(function (idx, item){

		var videoBoxID    = 'videos-block-id-' + idx,
				$thisVideoBox = jQuery(this),
				$videFrames   = $thisVideoBox.find('.video-frame');

		// Set an ID to the block
		$thisVideoBox.attr( 'id', videoBoxID );

		// Replace for mCustomScrollbar
		tie_animate_element( $thisVideoBox );

		// Init
		$videFrames.video();

		// Update Video status
		update_video_status( $thisVideoBox );

		// Show First video and remove the loader icon
		$videFrames.addVideoEvent('ready', function(e, $video, video_type){
			$videFrames.css('visibility', 'visible').fadeIn();
			$thisVideoBox.find('.loader-overlay').remove();
		});

		// Play videos
		$thisVideoBox.on( 'click', '.video-playlist-item:not(".is-playing")', function(){
			var $thisVideo = jQuery(this),
					frameID    = $thisVideo.data('name'),
					$thisFrame = jQuery( '#' + frameID ),
					videoSrc   = $thisVideo.data('video-src'),
					videoNum   = $thisVideo.find('.video-number').text();

			// Update the number of the playing video in the title section
			$thisVideoBox.find('.video-playing-number').text(videoNum);

			// Pause all Videos
			$thisVideoBox.find('.video-frame').each(function(){
				jQuery(this).pauseVideo().hide();
			})

			// If the iframe not loaded before, add it
			if( ! $thisFrame.length ){

				// Add the loader icon
				$thisVideoBox.find('.video-playlist-wrapper').prepend( tie.ajax_loader );

				$thisVideoBox.find('.video-player-wrapper').append('<iframe class="video-frame" id="' + frameID + '" src="'+ videoSrc +'" frameborder="0" width="771"" height="434" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');
				$thisFrame = jQuery( '#' + frameID );

				$thisFrame.video(); // reinit

				$thisFrame.addVideoEvent('ready', function(e, $thisFrame, video_type){
					$thisFrame.playVideo();
					$thisVideoBox.find('.loader-overlay').remove();
				});
			}

			// Or play the video
			else{
				$thisFrame.playVideo();
			}

			$thisFrame.css('visibility', 'visible').fadeIn();

			// Update Video status
			update_video_status( $thisVideoBox );

		});
	});

	// Update Video status
	function update_video_status( $theVideoBox ){
		$theVideoBox.find('.video-frame').each(function(){

			var $videoFrame = jQuery(this),
					$videoItem  = jQuery("[data-name='" + $videoFrame.attr('id') + "']");

			$videoFrame.addVideoEvent('play', function(e, $video, video_type){
				$videoItem.removeClass('is-paused').addClass('is-playing');
			});

			$videoFrame.addVideoEvent('pause', function(e, $video, video_type){
				$videoItem.removeClass('is-playing').addClass('is-paused');
			});

			$videoFrame.addVideoEvent('finish', function(e, $video, video_type){
				$videoItem.removeClass('is-paused is-playing');
			});
		});
	}

	/**
	 * Videos PlayList hot fix
	 */
	jQuery('.video-playlist-wrapper .video-frame').css('visibility', 'visible');

});
