/*! jQuery-viewport-checker v1.8.8 (c) 2015 Dirk Groenen https://github.com/dirkgroenen/jQuery-viewport-checker MIT @license: en.wikipedia.org/wiki/MIT_License */
!function(o){o.fn.viewportChecker=function(t){var e={classToAdd:"visible",classToRemove:"invisible",classToAddForFullView:"full-visible",removeClassAfterAnimation:!1,offset:100,repeat:!1,invertBottomOffset:!0,callbackFunction:function(o,t){},scrollHorizontal:!1,scrollBox:window};o.extend(e,t);var a=this,s={height:o(e.scrollBox).height(),width:o(e.scrollBox).width()};return this.checkElements=function(){var t,l;e.scrollHorizontal?(t=Math.max(o("html").scrollLeft(),o("body").scrollLeft(),o(window).scrollLeft()),l=t+s.width):(t=Math.max(o("html").scrollTop(),o("body").scrollTop(),o(window).scrollTop()),l=t+s.height),a.each(function(){var a=o(this),i={},n={};if(a.data("vp-add-class")&&(n.classToAdd=a.data("vp-add-class")),a.data("vp-remove-class")&&(n.classToRemove=a.data("vp-remove-class")),a.data("vp-add-class-full-view")&&(n.classToAddForFullView=a.data("vp-add-class-full-view")),a.data("vp-keep-add-class")&&(n.removeClassAfterAnimation=a.data("vp-remove-after-animation")),a.data("vp-offset")&&(n.offset=a.data("vp-offset")),a.data("vp-repeat")&&(n.repeat=a.data("vp-repeat")),a.data("vp-scrollHorizontal")&&(n.scrollHorizontal=a.data("vp-scrollHorizontal")),a.data("vp-invertBottomOffset")&&(n.scrollHorizontal=a.data("vp-invertBottomOffset")),o.extend(i,e),o.extend(i,n),!a.data("vp-animated")||i.repeat){String(i.offset).indexOf("%")>0&&(i.offset=parseInt(i.offset)/100*s.height);var d=i.scrollHorizontal?a.offset().left:a.offset().top,r=i.scrollHorizontal?d+a.width():d+a.height(),c=Math.round(d)+i.offset,f=i.scrollHorizontal?c+a.width():c+a.height();if(i.invertBottomOffset&&(f-=2*i.offset),c<l&&f>t){if(e.isInTop&&d-t>300)return;a.removeClass(i.classToRemove),a.addClass(i.classToAdd),i.callbackFunction(a,"add"),r<=l&&d>=t?a.addClass(i.classToAddForFullView):a.removeClass(i.classToAddForFullView),a.data("vp-animated",!0),i.removeClassAfterAnimation&&a.one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend",function(){a.removeClass(i.classToAdd)})}else a.hasClass(i.classToAdd)&&i.repeat&&(a.removeClass(i.classToAdd+" "+i.classToAddForFullView),i.callbackFunction(a,"remove"),a.data("vp-animated",!1))}})},("ontouchstart"in window||"onmsgesturechange"in window)&&o(document).bind("touchmove MSPointerMove pointermove",this.checkElements),o(e.scrollBox).bind("load scroll",this.checkElements),o(window).resize(function(t){s={height:o(e.scrollBox).height(),width:o(e.scrollBox).width()},a.checkElements()}),this.checkElements(),this}}(jQuery);


$doc.ready(function(){

	'use strict';

	/**
	 * Load More Button for archives
	 **/
	$doc.on( 'click', '#load-more-archives', function(){
		if( isDuringAjax === false ){
			isDuringAjax = true;
			tie_ajax_archives();
		}
	});


	/**
	 * Infinite Scroll for archives
	 **/
	var $infiniteScrollArchives = jQuery('.infinite-scroll-archives');
	if( $infiniteScrollArchives.length ){
		$infiniteScrollArchives.viewportChecker({
			repeat: true,
			offset: 60,
			callbackFunction: function(){
				if( isDuringAjax === false ){
					isDuringAjax = true;
					tie_ajax_archives();
				}
			}
		});
	}


	/**
	 * Story Index
	 */
	var $StoryIndex = jQuery('#story-index');
	if( $StoryIndex.length && window.innerWidth ){

		var $content = jQuery('#content');

		jQuery('.index-title').viewportChecker({
			repeat: true,
			offset: 15,
			isInTop: true, // By TieLabs - Used to heighlight the element when it reach the top of the page
			callbackFunction: function( elem, action ){
				var ID = elem.attr('id');
				$StoryIndex.find('a').removeClass('is-current');
				jQuery('#trigger-' + ID).addClass('is-current');
			}
		});

		if( jQuery.fn.theiaStickySidebar ){
			$StoryIndex.theiaStickySidebar({
				'containerSelector'   : '#the-post .entry-content',
				'additionalMarginTop' : 150
			});
		}

		jQuery( '#story-index-icon, #story-index a' ).on('click', function(){
			$StoryIndex.find( '.story-index-content' ).toggle();
		});

		storyIndexStatus();

		jQuery(window).resize(function() {
			storyIndexStatus();
		});
	}

	function storyIndexStatus(){

		if( jQuery(window).width() < $content.outerWidth() + 370 ){
			$StoryIndex.addClass( 'is-compact' );
			$StoryIndex.find( '.theiaStickySidebar' ).removeAttr('style');
		}else{
			$StoryIndex.removeClass( 'is-compact' );
			$StoryIndex.find( '.theiaStickySidebar' ).removeAttr('style');
		}
	}

	// End Of Text :)
});


/**
 * Archives Ajax Pagination
 */
function tie_ajax_archives(){

	var pagiButton = jQuery('#load-more-archives');

	if( ! pagiButton.length ){
		return false;
	}

	var theQuery    = pagiButton.attr('data-query'),
			theURL      = pagiButton.attr('data-url'),
			maxPages    = pagiButton.attr('data-max'),
			buttonText  = pagiButton.attr('data-text'),
			latest_post = pagiButton.attr('data-latest'),
			currentPage = parseInt( pagiButton.attr('data-page') ) +1,
			is_masonry  = false;

	// Check if the Button Disabled
	if( pagiButton.hasClass( 'pagination-disabled' ) || currentPage > maxPages ){
		return false;
	}

	// Page Layout
	if( jQuery('#masonry-grid').length ){
		var theBlock = jQuery('#masonry-grid');
		is_masonry = true;
	}
	else{
		var theBlock = jQuery('#posts-container');
	}

	var theLayout   = theBlock.attr('data-layout'),
			theSettings = theBlock.attr('data-settings');

	// Ajax Call
	jQuery.ajax({
		url : tie.ajaxurl,
		type: 'post',
		data: {
			action      : 'tie_archives_load_more',
			query       : theQuery,
			max         : maxPages,
			page        : currentPage,
			latest_post : latest_post,
			layout      : theLayout,
			settings    : theSettings
		},
		beforeSend: function(){
			pagiButton.html( tie.ajax_loader );
		},
		success: function( data ){

			data = jQuery.parseJSON(data);

			// Change the latest post number
			pagiButton.attr( 'data-latest', data['latest_post'] );

			// Hide next posts button
			if( data['hide_next'] ){
				pagiButton.addClass( 'pagination-disabled' );
				pagiButton.html( data['button'] );
			}
			else{
				pagiButton.html( buttonText );
			}

			data = data['code'];
			data = data.replace( /<li class="/g, '<li class="posts-items-'+ currentPage +' ' );

			var content = jQuery( data );

			if( is_masonry ){
				theBlock.append( content ).masonry( 'appended', content );
				var theBlockList_li = theBlock.find('.post-element');
				tie_animate_element( theBlockList_li );
				isDuringAjax = false;

				// Load images and re fire masonry
				theBlock.imagesLoaded().progress( function(){
					theBlock.masonry('layout');
				});

			}
			else{

				theBlock.append( content );
				var theBlockList_li = theBlock.find( '.posts-items-'+currentPage ).hide();

				// Animate the loaded items
				//theBlockList_li.addClass( 'tie-animate-slideInUp tie-animate-delay' ).show();

				var $i = 0;
				theBlockList_li.each(function(){
					$i++;
					jQuery(this).addClass( 'tie-animate-slideInUp' ).attr('style', 'animation-delay: 0.'+ $i +'s' ).show();
				});

				tie_animate_element( theBlockList_li );
				isDuringAjax = false;
			}

		}
	});

	// Change the next page number
	pagiButton.attr( 'data-page', currentPage );

	return false;
}
