/**
 * Declaring and initializing global variables
 */
var $the_post    = jQuery('#the-post'),
		$postContent = $the_post.find('.entry');


$doc.ready(function(){

	'use strict';

	/**
	 * Compact Comments
	 */
	jQuery('#show-comments-section').on('click', function(){
		var $comments = jQuery('#comments');
		tie_animate_element( $comments );
		$comments.show();
		jQuery(this).hide();
		return false;
	});

	/**
	 * Share Buttons : Print
	 */
	$doc.on('click', '.print-share-btn', function(){
		window.print();
		return false;
	});


	/**
	 * Responsive Tables
	 */
	if( tie.responsive_tables ){
		$the_post.find('table').wrap( '<div class="table-is-responsive"></div>' );
	}


	/**
	 * Open Share buttons in a popup
	 */
	/*
	$doc.on('click', '.share-links a:not(.email-share-btn)', function(){
		var link = jQuery(this).attr('href');
		if( link != '#' ){
			window.open( link, 'TIEshare', 'height=450,width=760,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0' );
			return false;
		}
	});
	*/


	// --
	if( ! tie.autoload_posts ){

		/**
		 * Sticky video
		 */
		var $featuredMedia = jQuery( '#the-sticky-video' );
		if( tie.is_sticky_video && $featuredMedia.length ){

			var top = $featuredMedia.offset().top,
					beforeOffset = tie.sticky_desktop ? 60 : 0,
					beforeOffset = $body.hasClass('admin-bar') ? beforeOffset + 32 : beforeOffset,
					offset = Math.floor( top + $featuredMedia.outerHeight() - beforeOffset),
					widowWidth = $window.width();

			jQuery('.video-close-btn').click(function() {
				$featuredMedia.removeClass('video-is-sticky').addClass('stop-sticky');
			});

			/*
			*  Twitter video dosen't load untile the page is loaded,
			* so we recalcualte the offset after the twitter video loaded.
			*/
			$window.on( 'resize load', function() {

				top = $featuredMedia.offset().top;
				offset = Math.floor( top + $featuredMedia.outerHeight() - beforeOffset);
				widowWidth = $window.width();

				/*
				* if the page has a sidebar, sticky the video at the top of it with the same width.
				*/
				var $sidebar = jQuery('.sidebar');
				if( $body.hasClass('has-sidebar') && $sidebar.length ){
					var sidebarWidth       = $sidebar.width(),
							sidebarPadding     = ($body.hasClass('magazine2') && $body.hasClass('sidebar-right')) ? 40 : 15,
							sidebarRightOffset = $window.width() - ($sidebar.offset().left + sidebarWidth);

					if( sidebarWidth ){
						$featuredMedia.find('.featured-area-inner').css({
							width: sidebarWidth,
							right: sidebarRightOffset - sidebarPadding,
							left: "auto",
							bottom: "auto",
							top: beforeOffset + 20
						});
					}
				}

			}).on( 'scroll', function() {
				if( ! $featuredMedia.hasClass('stop-sticky') ){
					$featuredMedia.toggleClass('video-is-sticky', $window.scrollTop() > offset && widowWidth > 992 ).show();
				}
			});
		}


		/**
		 * Reading Position Indicator
		 */
		if( tie.reading_indicator && $postContent.length ){

			var content_height  = $postContent.height(),
					window_height   = $window.height();

			$window.scroll(function(){
				var percent        = 0,
						content_offset = $postContent.offset().top,
						window_offest  = $window.scrollTop();

				if (window_offest > content_offset){
					percent = 100 * (window_offest - content_offset) / (content_height - window_height);
				}

				jQuery('#reading-position-indicator').css('width', percent + '%');
			});

		}

	} //! tie.autoload_posts

	/**
	 * Check Also Box
	 */
	var $check_also_box = jQuery('#check-also-box');
	if( $check_also_box.length ){

		// LazyLoad
		tie_animate_element( $check_also_box );

		var articleHeight   = $the_post.outerHeight(),
				checkAlsoClosed = false;

		$window.scroll(function(){
			if( ! checkAlsoClosed ){
				var articleScroll = $window.scrollTop();
				if ( articleScroll > articleHeight ){
					$check_also_box.addClass('show-check-also');
				}
				else {
					$check_also_box.removeClass('show-check-also');
				}
			}
		});
	}

	jQuery('#check-also-close').on( 'click', function(){
		$check_also_box.removeClass('show-check-also');
		checkAlsoClosed = true ;
		return false;
	});


	/**
	 * Select and Share
	 */
	if( tie.select_share ){

		$postContent.mousedown(function (event){

			$body.attr('mouse-top',event.clientY+window.pageYOffset);
			$body.attr('mouse-left',event.clientX);
			if(!getRightClick(event) && getSelectionText().length){
				jQuery('.fly-text-share').remove();
				document.getSelection().removeAllRanges();
			}
		});

		$postContent.mouseup(function (event){

			var t  = jQuery(event.target),
					st = getSelectionText(),
					ds = st;

			if(st.length > 3 && !getRightClick(event)){
				var mts = $body.attr('mouse-top'),
						mte = event.clientY+window.pageYOffset;

				if( parseInt(mts) < parseInt(mte) ) mte = mts;

				var mlp = $body.attr('mouse-left'),
						mrp = event.clientX,
						ml  = parseInt(mlp)+(parseInt(mrp)-parseInt(mlp))/2,
						sl  = window.location.href.split('?')[0],
						maxl = 114;

				st   = st.substring(0,maxl);

				if( tie.twitter_username ){
					maxl = maxl - ( tie.twitter_username.length+2 );
					st   = st.substring(0,maxl);
					st   = st+' @'+tie.twitter_username;
				}

				var share_content = '';

				if( tie.select_share_twitter ){
					share_content += "<a href=\"https://twitter.com/share?url="+encodeURIComponent(sl)+"&text="+encodeURIComponent(st)+"\" class='tie-icon-twitter' onclick=\"window.open(this.href, \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600\');return false;\"></a>";
				}

				if( tie.select_share_facebook && tie.facebook_app_id ){
					share_content += "<a href=\"https://www.facebook.com/dialog/feed?app_id="+tie.facebook_app_id+"&amp;link="+encodeURIComponent(sl)+"&amp;quote="+encodeURIComponent(ds)+"\" class='tie-icon-facebook' onclick=\"window.open(this.href, \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600\');return false;\"></a>";
				}

				if( tie.select_share_linkedin ){
					share_content += "<a href=\"https://www.linkedin.com/shareArticle?mini=true&url="+encodeURIComponent(sl)+"&summary="+encodeURIComponent(ds)+"\" class='tie-icon-linkedin' onclick=\"window.open(this.href, \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600\');return false;\"></a>";
				}

				if( tie.select_share_email ){
					share_content += "<a href=\"mailto:?body="+encodeURIComponent(ds)+" "+encodeURIComponent(sl)+"\" class='tie-icon-envelope' onclick=\"window.open(this.href, \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;\"></a>";
				}

				if( share_content != '' ){
					$body.append( "<div class=\"fly-text-share\">"+ share_content +"</div>" );
				}

				jQuery('.fly-text-share').css({
					position: 'absolute',
					top     : parseInt(mte)-60,
					left    : parseInt(ml)
				}).show();
			}
		});
	}

	function getRightClick(e){
		var rightclick;
		if (!e) var e = window.event;
		if (e.which) rightclick = (e.which == 3);
		else if (e.button) rightclick = (e.button == 2);
		return rightclick;
	}

	function getSelectionText(){
		var text = '';
		if (window.getSelection){
			text = window.getSelection().toString();
		}
		else if (document.selection && document.selection.type != "Control"){
			text = document.selection.createRange().text;
		}
		return text;
	}


	/**
	 * Taqyeem scripts
	 */
	// MOUSEMOVE HANDLER
	$doc.on( 'mousemove', '.taq-user-rate-active', function(e){
		var $rated = jQuery(this);

		if( $rated.hasClass('rated-done') ){
			return false;
		}

		if( !e.offsetX ){
			e.offsetX = e.clientX - jQuery(e.target).offset().left;
		}

		// Custom Code for the theme
		var offset = e.offsetX,
				width = $rated.width(),
		score = Math.round((offset/width)*100);

		$rated.find('.user-rate-image span').attr( 'data-user-rate', score ).css('width', score + '%');
	});

	// CLICK HANDLER
	$doc.on( 'click', '.taq-user-rate-active', function(){

		var $rated = jQuery(this),
				$ratedParent = $rated.parent(),
				$ratedCount  = $ratedParent.find('.taq-count'),
				post_id      = $rated.attr( 'data-id' ),
				numVotes     = $ratedCount.text();

		if( $rated.hasClass('rated-done') || $rated.hasClass('rated-in-progress') ){
			return false;
		}

		$rated.addClass('rated-in-progress');

		// Custom Code for the theme
		var userRatedValue = $rated.find('.user-rate-image span').data('user-rate');
		$rated.find( '.user-rate-image' ).hide();
		$rated.append('<span class="taq-load">'+ tie.ajax_loader  +'</span>');
		// --------

		if (userRatedValue >= 95) {
			userRatedValue = 100;
		}

		var userRatedValueCalc = (userRatedValue*5)/100;

		// Ajax Call
		jQuery.post(
			taqyeem.ajaxurl,
			{
				action: 'taqyeem_rate_post',
				post  : post_id,
				value : userRatedValueCalc
			},
			function( data ) {
				$rated.addClass('rated-done').attr('data-rate',userRatedValue);
				$rated.find('.user-rate-image span').width(userRatedValue+'%');

				jQuery('.taq-load').fadeOut(function () {
					$ratedParent.find('.taq-score').html( userRatedValueCalc );

					if( $ratedCount.length ){
						numVotes =  parseInt(numVotes)+1;
						$ratedCount.html(numVotes);
					}
					else{
						$ratedParent.find('small').hide();
					}

					$ratedParent.find('strong').html(taqyeem.your_rating);
					$rated.find('.user-rate-image').fadeIn();
			});
		}, 'html');

		return false;
	});

	// MOUSELEAVE HANDLER
	$doc.on( 'mouseleave', '.taq-user-rate-active', function(){
		var $rated = jQuery(this);
		if( $rated.hasClass('rated-done') ){
			return false;
		}
		var post_rate = $rated.attr('data-rate');
		$rated.find('.user-rate-image span').css('width', post_rate + '%');
	});

});
