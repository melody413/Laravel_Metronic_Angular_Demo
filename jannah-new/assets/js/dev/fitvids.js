/*!
* tieFitVids
*
* Copyright 2013, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
* Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
* Released under the WTFPL license - http://sam.zoy.org/wtfpl/
*
*/

/*
	- Changed the default clss name to tie-fluid-width-video-wrapper to avoid conflicts with other plugins
	- Performance improvements

	- removed getElementById( 'tie-container' ) to avoid issues with the pages that doesn't load header.php
	- Last Visit: 21 Oct 2019
*/

;(function( $ ){

	'use strict';

	$.fn.tieFitVids = function( options ) {

		var settings = {
			customSelector: null,
			ignore: null
		};

		if ( options ) {
			$.extend( settings, options );
		}

		var selectors = [
			'iframe[src*="player.vimeo.com"]',
			'iframe[src*="player.twitch.tv"]',
			'iframe[src*="youtube.com"]',
			'iframe[src*="youtube-nocookie.com"]',
			//'iframe[src*="kickstarter.com"][src*="video.html"]',
			'iframe[src*="maps.google.com"]',
			'iframe[src*="google.com/maps"]',
			'iframe[src*="dailymotion.com"]',
			'iframe[src*="twitter.com/i/videos"]',
			'object',
			'embed'
		];

		selectors = selectors.join(',');

		if (settings.customSelector) {
			selectors.push(settings.customSelector);
		}

		// querySelectorAll is much faster than .find we do this dirty check to return early
		var earlyCheckVideos = document.querySelectorAll( selectors );

		if( earlyCheckVideos.length ){

			// Prepare the ignore list
			var ignoreList = '.tie-ignore-fitvid, #buddypress';
			if( settings.ignore ) {
				ignoreList = ignoreList + ', ' + settings.ignore;
			}

			return this.each(function(){

				var $allVideos = $(this).find( selectors );
				//$allVideos = $allVideos.not('object object'); // SwfObj conflict patch
				//$allVideos = $allVideos.not(ignoreList); // Disable tieFitVids on this video. No need for this the ignore classes for parents only

				$allVideos.each(function(){

					var $this = $(this);

					// Check the parents
					if( $this.parents(ignoreList).length > 0 ) {
						return; // Disable tieFitVids on this video.
					}

					if ( ( ( this.tagName.toLowerCase() === 'embed' || this.tagName.toLowerCase() === 'object' ) && $this.parent('object').length ) || $this.parent('.tie-fluid-width-video-wrapper').length) { return; }

					if ((!$this.css('height') && !$this.css('width')) && (isNaN($this.attr('height')) || isNaN($this.attr('width')))){
						$this.attr('height', 9);
						$this.attr('width', 16);
					}

					var height = ( this.tagName.toLowerCase() === 'object' || ($this.attr('height') && !isNaN(parseInt($this.attr('height'), 10))) ) ? parseInt($this.attr('height'), 10) : $this.height(),
							width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
							aspectRatio = height / width;

					$this.removeAttr('height').removeAttr('width');

					$this.wrap('<div class="tie-fluid-width-video-wrapper"></div>').parent('.tie-fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100)+'%');
				});
			});
		}
	};
})( window.jQuery );
