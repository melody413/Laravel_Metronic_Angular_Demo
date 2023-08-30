/*
 * JQUERY NEWS TICKER 1.4
 * https://www.jquerynewsticker.com/
 *
 * Customized By TieLabs
 * updated: 25/03/2019
 */

(function($){
	$.fn.ticker = function(options) {

		// Extend our default options with those provided.
		// Note that the first arg to extend is an empty object -
		// this is to keep from overriding our "defaults" object.
		var opts = $.extend({}, $.fn.ticker.defaults, options);

		// check that the passed element is actually in the DOM
		if ($(this).length == 0) {
			if (window.console && window.console.log) {
				window.console.log('Element does not exist in DOM!');
			}
			else {
				alert('Element does not exist in DOM!');
			}
			return false;
		}

		/* Get the id of the UL to get our news content from */
		var newsID = '#' + $(this).attr('id');

		/* Get the tag type - we will check this later to makde sure it is a UL tag */
		var tagType = $(this).get(0).tagName;

		return this.each(function() {
			// get a unique id for this ticker
			var uniqID = getUniqID();

			/* Internal vars */
			var settings = {
				position: 0,
				time: 0,
				distance: 0,
				newsArr: {},
				play: true,
				paused: false,
				contentLoaded: false,
				dom: {
					contentID : '#ticker-content-' + uniqID,
					tickerID  : '#ticker-' + uniqID,
					wrapperID : '#ticker-wrapper-' + uniqID,
					revealID  : '#ticker-swipe-' + uniqID,
					revealElem: '#ticker-swipe-' + uniqID + ' SPAN',
					controlsID: '#ticker-controls-' + uniqID,
					prevID    : '#prev-' + uniqID,
					nextID    : '#next-' + uniqID,
				}
			};

			// if we are not using a UL, display an error message and stop any further execution
			if (tagType != 'UL' && tagType != 'OL') {
				debugError('Cannot use <' + tagType.toLowerCase() + '> type of element for this plugin - must of type <ul> or <ol>');
				return false;
			}

			// set the ticker direction
			opts.direction == 'rtl' ? opts.direction = 'ticker-dir-right' : opts.direction = 'ticker-dir-left';

			// if transition is empty - set the default transition type
			if(opts.displayType == null || opts.displayType == undefined || opts.displayType == '')
				opts.displayType = 'flipY';

			// lets go...
			initialisePage();

			/* Function to get the size of an Object*/
			function countSize(obj) {
				var size = 0, key;
				for (key in obj) {
					if (obj.hasOwnProperty(key)) size++;
				}
				return size;
			};

			function getUniqID() {
				var newDate = new Date;
				return newDate.getTime();
			}

			/* Function for handling debug and error messages */
			function debugError(obj) {
				if (opts.debugMode) {
					if (window.console && window.console.log) {
						window.console.log(obj);
					}
					else {
						alert(obj);
					}
				}
			}

			/* Function to setup the page */
			function initialisePage() {

				// process the content for this ticker
				processContent();

				// add our HTML structure for the ticker to the DOM
				$(newsID).wrap('<div id="' + settings.dom.wrapperID.replace('#', '') + '"></div>');

				// remove any current content inside this ticker
				$(settings.dom.wrapperID).children().remove();

				$(settings.dom.wrapperID).append('<div id="' + settings.dom.tickerID.replace('#', '') + '" class="ticker"><p id="' + settings.dom.contentID.replace('#', '') + '" class="ticker-content"></p><div id="' + settings.dom.revealID.replace('#', '') + '" class="ticker-swipe"><span><!-- --></span></div></div>');
				$(settings.dom.wrapperID).removeClass('no-js').addClass('ticker-wrapper has-js ' + opts.direction);
				// hide the ticker
				$(settings.dom.tickerElem + ',' + settings.dom.contentID).hide();
				// add the controls to the DOM if required
				if (opts.controls) {
					// add related events - set functions to run on given event
					$(document).on('click', $(settings.dom.controlsID) , function (e) {
						var button = e.target.id;
						switch (button) {
							case settings.dom.prevID.replace('#', ''):
								manualChangeContent('prev');
								break;
							case settings.dom.nextID.replace('#', ''):
								manualChangeContent('next');
								break;
						}
					});
					/* add controls HTML to DOM
					* we don't need pause button so we remove it, but we take a backup from the previous snippet that contains a puase button.
					*/
					$(settings.dom.wrapperID).append('<ul id="' + settings.dom.controlsID.replace('#', '') + '" class="breaking-news-nav slider-arrow-nav "><li id="' + settings.dom.prevID.replace('#', '') + '" class="jnt-prev controls"></li><li id="' + settings.dom.nextID.replace('#', '') + '" class="jnt-next controls"></li></ul>');
				}

				/* Pause On Hover -------*/
				if(opts.displayType == 'reveal'){
					$(settings.dom.contentID).mouseenter(function () {
						pauseTicker();
					}).mouseleave(function () {
						restartTicker();
					});
				}

				setupContentAndTriggerDisplay();
			}

			/* Start to process the content for this ticker */
			function processContent() {
				// check to see if we need to load content
				if (settings.contentLoaded == false) {
					if($(newsID + ' LI').length > 0) {
						$(newsID + ' LI').each(function (i) {
							// maybe this could be one whole object and not an array of objects?
							settings.newsArr['item-' + i] = {content: $(this).html()};
						});
					}
					else {
						debugError('Couldn\'t find HTML any content for the ticker to use!');
						return false;
					}
				}
			}

			function setupContentAndTriggerDisplay() {

				settings.contentLoaded = true;

				// update the ticker content with the correct item
				// insert news content into DOM
				$(settings.dom.contentID).html(settings.newsArr['item-' + settings.position].content);

				// set the next content item to be used - loop round if we are at the end of the content
				if (settings.position == (countSize(settings.newsArr) -1)) {
					settings.position = 0;
				}
				else {
					settings.position++;
				}

				// get the values of content and set the time of the reveal (so all reveals have the same speed regardless of content size)
				distance = $(settings.dom.contentID).width();
				time = distance / opts.speed;

				// start the ticker animation
				revealContent();
			}

			// slide back cover or fade in content
			function revealContent() {
				$(settings.dom.contentID).css('opacity', '1');
				if(settings.play) {
					if (opts.displayType == 'reveal') {
						// show the reveal element and start the animation
						$(settings.dom.revealElem).show(0, function () {
							$(settings.dom.contentID).show();
							// set our animation direction
							animationAction = opts.direction == 'ticker-dir-right' ? { marginRight: distance + 'px'} : { marginLeft: distance + 'px' };
							$(settings.dom.revealID).css('margin-' + opts.direction, '0px').delay(20).animate(animationAction, time, 'linear', postReveal);
						});
					}
					else{

						$(settings.dom.revealID).hide();

						// Fade
						if( opts.displayType == 'flipY' ){
							$(settings.dom.contentID).fadeIn(opts.fadeInSpeed, function () {
								setTimeout(function(){
									postReveal();
								}, 10);
							});
						}

						// Sliding
						else{
							$(settings.dom.contentID).velocity('stop').velocity( 'transition.' + opts.displayType + 'In' ,{ duration: opts.fadeInSpeed, complete: function () {
								setTimeout(function(){
									postReveal();
								}, 10);
							}});
						}

					}
				}
				else {
					return false;
				}
			};

			// here we hide the current content and reset the ticker elements to a default state ready for the next ticker item
			function postReveal() {
				if(settings.play) {
					if (opts.displayType == 'reveal') {

						// we have to separately fade the content out here to get around an IE bug - needs further investigation
						$(settings.dom.contentID).delay(opts.pauseOnItems).fadeOut(opts.fadeOutSpeed);

						$(settings.dom.revealID).hide(0, function () {
							$(settings.dom.contentID).fadeOut(opts.fadeOutSpeed, function () {
								$(settings.dom.wrapperID)
									.find(settings.dom.revealElem + ',' + settings.dom.contentID).hide().end()
									.find(settings.dom.tickerID   + ',' + settings.dom.revealID ).show().removeAttr('style');
								setupContentAndTriggerDisplay();
							});
						});
					}

					// Rest Animations
					else {

						// Fade
						if( opts.displayType == 'flipY' ){
							$(settings.dom.contentID).delay(opts.pauseOnItems).fadeOut(opts.fadeOutSpeed, function () {
								setupContentAndTriggerDisplay();
							});
						}

						// Sliding
						else{
							$(settings.dom.contentID).velocity('stop').velocity('transition.' + opts.displayType + 'Out' , {delay: opts.pauseOnItems , duration: opts.fadeOutSpeed, complete: setupContentAndTriggerDisplay });
						}

					}
				}
				else {
					$(settings.dom.revealElem).hide();
				}
			}

			// pause ticker
			function pauseTicker() {
				settings.play = false;
				settings.pause = true;
				if(opts.displayType != 'reveal'){
					$content = $(settings.dom.wrapperID).find(settings.dom.contentID);
					$content.removeAttr('style').show();
					$.Velocity.hook($content, "translateY", "0");
					$.Velocity.hook($content, "translateX", "0");
					$.Velocity.hook($content, "perspective", "0");
					$.Velocity.hook($content, "rotateY", "0");
					$.Velocity.hook($content, "rotateX", "0");
				}else{
					// stop animation and show content - must pass "true, true" to the stop function, or we can get some funky behaviour
					$(settings.dom.tickerID + ',' + settings.dom.revealID + ',' + settings.dom.revealElem + ',' + settings.dom.contentID).stop(true,true);
					$(settings.dom.revealID + ',' + settings.dom.revealElem).hide();
					$(settings.dom.wrapperID).find(settings.dom.contentID).show();
				}
			}

			// play ticker
			function restartTicker() {
				settings.play = true;
				settings.paused = false;
				// start the ticker again
				postReveal();
			}

			// change the content on user input
			function manualChangeContent(direction) {

				pauseTicker();

				switch (direction) {
					case 'prev':
						if (settings.position == 0) {
							settings.position = countSize(settings.newsArr) -2;
						}
						else if (settings.position == 1) {
							settings.position = countSize(settings.newsArr) -1;
						}
						else {
							settings.position = settings.position - 2;
						}
						$(settings.dom.contentID).html(settings.newsArr['item-' + settings.position].content);
						break;
					case 'next':
						$(settings.dom.contentID).html(settings.newsArr['item-' + settings.position].content);
						break;
				}

				// set the next content item to be used - loop round if we are at the end of the content
				if (settings.position == (countSize(settings.newsArr) -1)) {
					settings.position = 0;
				}
				else {
					settings.position++;
				}

				restartTicker();
			}
		});
	};

	// plugin defaults - added as a property on our plugin function
	$.fn.ticker.defaults = {
		speed        : 0.2,
		debugMode    : false,
		controls     : false,
		direction    : 'ltr',
		pauseOnItems : 2000,
		fadeInSpeed  : 600,
		fadeOutSpeed : 300,
		displayType  : 'reveal',

		/** Predefiend displayType:
			reveal          = typing
			flipY           = fade - default display type
			flipX
			slideLeft
			slideRight
			slideUp
			slideDown

			perspectiveUp
			perspectiveDown
		*/
	};
})(jQuery);
