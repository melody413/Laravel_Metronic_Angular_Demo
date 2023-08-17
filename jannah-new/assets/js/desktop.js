/* modernizr 3.5.0 (Custom Build) | MIT user for: Flex Menu on DESKTOP only * https://modernizr.com/download/?-prefixes-setclasses-teststyles */
!function(e,n,t){function s(e,n){return typeof e===n}function o(){var e,n,t,o,a,i,r;for(var l in d)if(d.hasOwnProperty(l)){if(e=[],n=d[l],n.name&&(e.push(n.name.toLowerCase()),n.options&&n.options.aliases&&n.options.aliases.length))for(t=0;t<n.options.aliases.length;t++)e.push(n.options.aliases[t].toLowerCase());for(o=s(n.fn,"function")?n.fn():n.fn,a=0;a<e.length;a++)i=e[a],r=i.split("."),1===r.length?Modernizr[r[0]]=o:(!Modernizr[r[0]]||Modernizr[r[0]]instanceof Boolean||(Modernizr[r[0]]=new Boolean(Modernizr[r[0]])),Modernizr[r[0]][r[1]]=o),f.push((o?"":"no-")+r.join("-"))}}function a(e){var n=u.className,t=Modernizr._config.classPrefix||"";if(h&&(n=n.baseVal),Modernizr._config.enableJSClass){var s=new RegExp("(^|\s)"+t+"no-js(\s|$)");n=n.replace(s,"$1"+t+"js$2")}Modernizr._config.enableClasses&&(n+=" "+t+e.join(" "+t),h?u.className.baseVal=n:u.className=n)}function i(){return"function"!=typeof n.createElement?n.createElement(arguments[0]):h?n.createElementNS.call(n,"http://www.w3.org/2000/svg",arguments[0]):n.createElement.apply(n,arguments)}function r(){var e=n.body;return e||(e=i(h?"svg":"body"),e.fake=!0),e}function l(e,t,s,o){var a,l,f,d,c="modernizr",p=i("div"),h=r();if(parseInt(s,10))for(;s--;)f=i("div"),f.id=o?o[s]:c+(s+1),p.appendChild(f);return a=i("style"),a.type="text/css",a.id="s"+c,(h.fake?h:p).appendChild(a),h.appendChild(p),a.styleSheet?a.styleSheet.cssText=e:a.appendChild(n.createTextNode(e)),p.id=c,h.fake&&(h.style.background="",h.style.overflow="hidden",d=u.style.overflow,u.style.overflow="hidden",u.appendChild(h)),l=t(p,e),h.fake?(h.parentNode.removeChild(h),u.style.overflow=d,u.offsetHeight):p.parentNode.removeChild(p),!!l}var f=[],d=[],c={_version:"3.5.0",_config:{classPrefix:"",enableClasses:!0,enableJSClass:!0,usePrefixes:!0},_q:[],on:function(e,n){var t=this;setTimeout(function(){n(t[e])},0)},addTest:function(e,n,t){d.push({name:e,fn:n,options:t})},addAsyncTest:function(e){d.push({name:null,fn:e})}},Modernizr=function(){};Modernizr.prototype=c,Modernizr=new Modernizr;var p=c._config.usePrefixes?" -webkit- -moz- -o- -ms- ".split(" "):["",""];c._prefixes=p;var u=n.documentElement,h="svg"===u.nodeName.toLowerCase();c.testStyles=l;o(),a(f),delete c.addTest,delete c.addAsyncTest;for(var m=0;m<Modernizr._q.length;m++)Modernizr._qm;e.Modernizr=Modernizr}(window,document);

/*! Theia Sticky Sidebar v1.7.0. (c) 2013-2016 WeCodePixels and other contributors. MIT @license: en.wikipedia.org/wiki/MIT_License */
!function(i){i.fn.theiaStickySidebar=function(t){function o(t,o){return!0===t.initialized||!(i("body").width()<t.minWidth)&&(function(t,o){t.initialized=!0,o.each(function(){var o={};o.sidebar=i(this),o.options=t||{},o.container=i(o.options.containerSelector),0==o.container.length&&(o.container=o.sidebar.parent()),o.sidebar.css({position:o.options.defaultPosition,overflow:"visible","-webkit-box-sizing":"border-box","-moz-box-sizing":"border-box","box-sizing":"border-box"}),o.stickySidebar=o.sidebar.find(".theiaStickySidebar"),o.marginBottom=parseInt(o.sidebar.css("margin-bottom")),o.paddingTop=parseInt(o.sidebar.css("padding-top")),o.paddingBottom=parseInt(o.sidebar.css("padding-bottom"));var a=o.stickySidebar.offset().top,n=o.stickySidebar.outerHeight();function s(){o.fixedScrollTop=0,o.sidebar.removeClass("is-fixed").css({"min-height":"1px"}),o.stickySidebar.css({position:"static",width:"",transform:"none"})}o.stickySidebar.css("padding-top",1),o.stickySidebar.css("padding-bottom",1),a-=o.stickySidebar.offset().top,n=o.stickySidebar.outerHeight()-n-a,0==a?(o.stickySidebar.css("padding-top",0),o.stickySidebarPaddingTop=0):o.stickySidebarPaddingTop=1,0==n?(o.stickySidebar.css("padding-bottom",0),o.stickySidebarPaddingBottom=0):o.stickySidebarPaddingBottom=1,o.previousScrollTop=null,o.fixedScrollTop=0,s(),o.onScroll=function(o){if(o.stickySidebar.is(":visible"))if(i("body").width()<o.options.minWidth)s();else{if(o.options.disableOnResponsiveLayouts){var a=o.sidebar.outerWidth("none"==o.sidebar.css("float"));if(a+50>o.container.width())return void s()}var n,d,r=i(document).scrollTop(),c="static";if(r>=o.sidebar.offset().top+(o.paddingTop-o.options.additionalMarginTop)){var p,b=o.paddingTop+t.additionalMarginTop,l=o.paddingBottom+o.marginBottom+t.additionalMarginBottom,f=o.sidebar.offset().top,g=o.sidebar.offset().top+(n=o.container,d=n.height(),n.children().each(function(){d=Math.max(d,i(this).height())}),d),h=0+t.additionalMarginTop,u=o.stickySidebar.outerHeight()+b+l<i(window).height();p=u?h+o.stickySidebar.outerHeight():i(window).height()-o.marginBottom-o.paddingBottom-t.additionalMarginBottom;var S=f-r+o.paddingTop,m=g-r-o.paddingBottom-o.marginBottom,y=o.stickySidebar.offset().top-r,k=o.previousScrollTop-r;"fixed"==o.stickySidebar.css("position")&&"modern"==o.options.sidebarBehavior&&(y+=k),"stick-to-top"==o.options.sidebarBehavior&&(y=t.additionalMarginTop),"stick-to-bottom"==o.options.sidebarBehavior&&(y=p-o.stickySidebar.outerHeight()),y=k>0?Math.min(y,h):Math.max(y,p-o.stickySidebar.outerHeight()),y=Math.max(y,S),y=Math.min(y,m-o.stickySidebar.outerHeight());var v=o.container.height()==o.stickySidebar.outerHeight();c=(v||y!=h)&&(v||y!=p-o.stickySidebar.outerHeight())?r+y-o.sidebar.offset().top-o.paddingTop<=t.additionalMarginTop?"static":"absolute":"fixed"}if("fixed"==c){var x=i(document).scrollLeft();o.stickySidebar.css({position:"fixed",width:e(o.stickySidebar)+"px",transform:"translateY("+y+"px)",left:o.sidebar.offset().left+parseInt(o.sidebar.css("padding-left"))-x+"px",top:"0px"})}else if("absolute"==c){var T={};"absolute"!=o.stickySidebar.css("position")&&(T.position="absolute",T.transform="translateY("+(r+y-o.sidebar.offset().top-o.stickySidebarPaddingTop-o.stickySidebarPaddingBottom)+"px)",T.top="0px"),T.width=e(o.stickySidebar)+"px",T.left="",o.stickySidebar.css(T)}else"static"==c&&s();"static"!=c&&(1==o.options.updateSidebarHeight&&o.sidebar.addClass("is-fixed").css({"min-height":o.stickySidebar.outerHeight()+o.stickySidebar.offset().top-o.sidebar.offset().top+o.paddingBottom}),o.sidebar.hasClass("is-alreay-loaded")||(tie_animate_element(o.sidebar),o.sidebar.addClass("is-alreay-loaded"))),o.previousScrollTop=r}},o.onScroll(o),i(document).on("scroll."+o.options.namespace,function(i){return function(){i.onScroll(i)}}(o)),i(window).on("resize."+o.options.namespace,function(i){return function(){i.stickySidebar.css({position:"static"}),i.onScroll(i)}}(o)),"undefined"!=typeof ResizeSensor&&new ResizeSensor(o.stickySidebar[0],function(i){return function(){i.onScroll(i)}}(o))})}(t,o),!0)}function e(i){var t;try{t=i[0].getBoundingClientRect().width}catch(i){}return void 0===t&&(t=i.width()),t}return(t=i.extend({containerSelector:"",additionalMarginTop:0,additionalMarginBottom:0,updateSidebarHeight:!0,minWidth:0,disableOnResponsiveLayouts:!0,sidebarBehavior:"modern",defaultPosition:"relative",namespace:"TSS"},t)).additionalMarginTop=parseInt(t.additionalMarginTop)||0,t.additionalMarginBottom=parseInt(t.additionalMarginBottom)||0,function(t,e){o(t,e)||(console.log("TSS: Body width smaller than options.minWidth. Init is delayed."),i(document).on("scroll."+t.namespace,function(t,e){return function(a){var n=o(t,e);n&&i(this).unbind(a)}}(t,e)),i(window).on("resize."+t.namespace,function(t,e){return function(a){var n=o(t,e);n&&i(this).unbind(a)}}(t,e)))}(t,this),this}}(jQuery);

/* tiesticky.js 1.2.1 - headroom.js | URL: http://wicky.nillia.ms/headroom.js */
!function(t){t&&(t.fn.tiesticky=function(i){return this.each(function(){var e=t(this),o=e.data("tiesticky"),s="object"==typeof i&&i;s=t.extend(!0,{},TieSticky.options,s),o||((o=new TieSticky(this,s)).init(),e.data("tiesticky",o)),"string"==typeof i&&(o[i](),"destroy"===i&&e.removeData("tiesticky"))})})}(window.jQuery),function(t,i){"use strict";"function"==typeof define&&define.amd?define([],i):"object"==typeof exports?module.exports=i():t.TieSticky=i()}(this,function(){"use strict";var t={bind:!!function(){}.bind,classList:"classList"in document.documentElement,rAF:!!(window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame)};function i(t){this.callback=t,this.ticking=!1}function e(t,i){var o;i=function t(i){if(arguments.length<=0)throw new Error("Missing arguments in extend function");var e,o,s,n=i||{};for(o=1;o<arguments.length;o++){var h=arguments[o]||{};for(e in h)"object"!=typeof n[e]||(s=n[e])&&"undefined"!=typeof window&&(s===window||s.nodeType)?n[e]=n[e]||h[e]:n[e]=t(n[e],h[e])}return n}(i,e.options),this.lastKnownScrollY=0,this.elem=t,this.tolerance=(o=i.tolerance)===Object(o)?o:{down:o,up:o},this.classes=i.classes,this.behaviorMode=i.behaviorMode,this.scroller=i.scroller,this.initialised=!1,this.onPin=i.onPin,this.onUnpin=i.onUnpin,this.onTop=i.onTop,this.onNotTop=i.onNotTop,this.onBottom=i.onBottom,this.onNotBottom=i.onNotBottom,this.offset=i.offset,this.windwidth=i.windwidth,this.offset="default"!=this.behaviorMode?this.offset+this.elem.offsetHeight:this.offset,this.offset=$body.hasClass("admin-bar")?this.offset-i.adminBarH:this.offset,this.offset=$body.hasClass("border-layout")?this.offset-25:this.offset,this.offset=$body.hasClass("border-layout")&&this.windwidth<992?this.offset+25:this.offset,this.menuHeight=i.menuHeight,this.isHightestThanSticky=i.isHightestThanSticky,this.heightDiff=i.heightDiff}return window.requestAnimationFrame=window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame,i.prototype={constructor:i,update:function(){this.callback&&this.callback(),this.ticking=!1},requestTick:function(){this.ticking||(requestAnimationFrame(this.rafCallback||(this.rafCallback=this.update.bind(this))),this.ticking=!0)},handleEvent:function(){this.requestTick()}},e.prototype={constructor:e,init:function(){if(e.cutsTheMustard)return"default"==this.behaviorMode&&this.elem.classList.add("default-behavior-mode"),this.debouncer=new i(this.update.bind(this)),this.elem.classList.add(this.classes.initial),setTimeout(this.attachEvent.bind(this),100),this},destroy:function(){var t=this.classes;this.initialised=!0,this.elem.classList.remove(t.unpinned,t.pinned,t.top,t.notTop,t.initial,"fixed-nav"),this.scroller.removeEventListener("scroll",this.debouncer,!1)},attachEvent:function(){this.initialised||(this.lastKnownScrollY=this.getScrollY(),this.initialised=!0,this.scroller.addEventListener("scroll",this.debouncer,!1),this.debouncer.handleEvent())},unpin:function(){var t=this.elem.classList,i=this.classes;!t.contains(i.pinned)&&t.contains(i.unpinned)||(t.add(i.unpinned),t.remove(i.pinned),this.onUnpin&&this.onUnpin.call(this))},pin:function(){var t=this.elem.classList,i=this.classes;t.contains(i.unpinned)&&(t.remove(i.unpinned),t.add(i.pinned),this.onPin&&this.onPin.call(this))},top:function(){var t=this.elem.classList,i=this.classes;t.contains(i.top)||(t.add(i.top),t.remove(i.notTop),this.onTop&&this.onTop.call(this))},notTop:function(){var t=this.elem.classList,i=this.classes;t.contains(i.notTop)||(t.add(i.notTop),t.remove(i.top),this.onNotTop&&this.onNotTop.call(this))},bottom:function(){var t=this.elem.classList,i=this.classes;t.contains(i.bottom)||(t.add(i.bottom),t.remove(i.notBottom),this.onBottom&&this.onBottom.call(this))},notBottom:function(){var t=this.elem.classList,i=this.classes;t.contains(i.notBottom)||(t.add(i.notBottom),t.remove(i.bottom),this.onNotBottom&&this.onNotBottom.call(this))},getScrollY:function(){return void 0!==this.scroller.pageYOffset?this.scroller.pageYOffset:void 0!==this.scroller.scrollTop?this.scroller.scrollTop:(document.documentElement||document.body.parentNode||document.body).scrollTop},getViewportHeight:function(){return window.innerHeight||document.documentElement.clientHeight||document.body.clientHeight},getElementPhysicalHeight:function(t){return Math.max(t.offsetHeight,t.clientHeight)},getScrollerPhysicalHeight:function(){return this.scroller===window||this.scroller===document.body?this.getViewportHeight():this.getElementPhysicalHeight(this.scroller)},getDocumentHeight:function(){var t=document.body,i=document.documentElement;return Math.max(t.scrollHeight,i.scrollHeight,t.offsetHeight,i.offsetHeight,t.clientHeight,i.clientHeight)},getElementHeight:function(t){return Math.max(t.scrollHeight,t.offsetHeight,t.clientHeight)},getScrollerHeight:function(){return this.scroller===window||this.scroller===document.body?this.getDocumentHeight():this.getElementHeight(this.scroller)},isOutOfBounds:function(t){var i=t<0,e=t+this.getScrollerPhysicalHeight()>this.getScrollerHeight();return i||e},toleranceExceeded:function(t,i){return Math.abs(t-this.lastKnownScrollY)>=this.tolerance[i]},shouldUnpin:function(t,i){var e=t>this.lastKnownScrollY,o=t>=this.offset;return e&&o&&i},shouldPin:function(t,i){var e=t<this.lastKnownScrollY,o=t<=this.offset;return e&&i||o},update:function(){var t=this.getScrollY(),i=t>this.lastKnownScrollY?"down":"up",e=this.toleranceExceeded(t,i);this.isOutOfBounds(t)||("default"==this.behaviorMode&&this.isHightestThanSticky&&this.offset<t&&t<this.offset+this.heightDiff?this.elem.classList.add("just-before-sticky"):this.elem.classList.remove("just-before-sticky"),t<=this.offset-this.elem.offsetHeight&&"default"!=this.behaviorMode?(this.top(),this.elem.classList.add("unpinned-no-transition")):t<=this.offset&&"default"==this.behaviorMode?this.top():t>this.offset&&(this.notTop(),"default"==this.behaviorMode&&t<this.offset+100&&jQuery("#autocomplete-suggestions").hide()),t+this.getViewportHeight()>=this.getScrollerHeight()?this.bottom():this.notBottom(),this.shouldUnpin(t,e)?this.unpin():this.shouldPin(t,e)&&(this.pin(),t>this.offset&&"default"!=this.behaviorMode&&(this.elem.classList.remove("unpinned-no-transition"),jQuery("#autocomplete-suggestions").hide())),this.lastKnownScrollY=t)}},e.options={tolerance:{up:0,down:0},offset:0,behaviorMode:"upwards",scroller:window,classes:{initial:"fixed",pinned:"fixed-pinned",unpinned:"fixed-unpinned",top:"fixed-top",notTop:"fixed-nav",bottom:"fixed-bottom",notBottom:"fixed-not-bottom"}},e.cutsTheMustard=void 0!==t&&t.rAF&&t.bind&&t.classList,e});

var megaMenuAjax = false;

/**
 * Custom Scrollbar
 */
jQuery(document).ready(function(){

	'use strict';

	/**
	 * Mega Menus
	 */
	//Featured post and check also
	$mainNav.on('mouseenter', '.mega-recent-featured, .mega-cat', function(){
		var menuItem    = jQuery(this),
				thePostsDiv = menuItem.find( '.mega-ajax-content' ),
				isMegaCat   = false,
				number      = 0;

		if( menuItem.hasClass('mega-cat') ){
			isMegaCat = true;
			number    = 5;

			if( menuItem.has( '.cats-vertical' ).length ){
				number  = 4;
			}
		}

		tie_mega_menu_category( menuItem, thePostsDiv, isMegaCat, number );
	});


	// Mega menu For menu with sub cats layout
	$mainNav.on('mouseenter', '.mega-sub-cat', function(){

		var menuItem = jQuery(this),
				theCatID = menuItem.attr('data-id');

		if( menuItem.hasClass('is-active') ){
			return;
		}

		var theMenuParent = menuItem.closest( '.mega-menu' ),
				thePostsDiv   = theMenuParent.find( '.mega-ajax-content' ),
				number        = 5;

		if( theMenuParent.has( '.cats-vertical' ).length ){
			number  = 4;
		}

		theMenuParent.find( '.mega-sub-cat' ).removeClass( 'is-active' );
		menuItem.addClass( 'is-active' );

		if( thePostsDiv.find( '#loaded-' + theCatID ).length ){
			thePostsDiv.find( 'ul' ).hide();

			var currentUL = thePostsDiv.find( '#loaded-' + theCatID + ', .mega-check-also ul' ).show();

			// Animate the loaded items
			//currentUL.find( 'li' ).addClass('tie-animate-slideInUp tie-animate-delay');

			/*var $i = 0;
			currentUL.find('li').each(function(){
				$i++;
				jQuery(this).show();
			});
			*/

			return false;
		}
		else{
			menuItem.removeClass( 'is-loaded' );
		}

		tie_mega_menu_category( menuItem, thePostsDiv, true, number );
		return false;
	});


	/**
	 * MEGA MENUS GET AJAX POSTS
	 */
	function tie_mega_menu_category( menuItem, thePostsDiv, isMegaCat, number ){
		var theCatID     = menuItem.attr('data-id'),
		    postIcon     = menuItem.attr('data-icon'),
				postsNumber  = 7,
				featuredPost = true;

		if( theCatID && ! menuItem.hasClass( 'is-loaded' )){

			menuItem.addClass('is-loaded');

			if( isMegaCat ){
				postsNumber = number;
				featuredPost = false;
			}
			else if( menuItem.hasClass( 'menu-item-has-children' ) ){
				postsNumber = 4;
			}

			// Cancel the current Ajax request if the user made a new one
			if( megaMenuAjax && megaMenuAjax.readystate != 4 ){
				megaMenuAjax.abort();
			}

			// Ajax Call
			megaMenuAjax = jQuery.ajax({
				url : tie.ajaxurl,
				type: 'post',
				data: {
					action    : 'tie_mega_menu_load_ajax',
					id        : theCatID,
					featured  : featuredPost,
					number    : postsNumber,
					post_icon : postIcon
				},
				beforeSend: function(){
					// Add the loader
					if( ! thePostsDiv.find('.loader-overlay').length ){
						thePostsDiv.addClass('is-loading').append( tie.ajax_loader );
					}
				},
				success: function( data ){

					if( !featuredPost ){
						var content = '<ul id="loaded-'+ theCatID +'">'+ data +'</ul>';
					}
					else{
						var content = jQuery( data );
					}

					thePostsDiv.append( content );

					thePostsDiv.find( 'ul' ).hide();

					var currentUL  = thePostsDiv.find( '#loaded-' + theCatID + ', .mega-check-also ul' ).show().find('li'),
							recentPost = thePostsDiv.find('.mega-recent-post');

					// Animate the loaded items
					//recentPost.add(currentUL).addClass('tie-animate-slideInUp');

					var $i = 0;
					recentPost.add(currentUL).each(function(){
						$i++;
						jQuery(this).addClass( 'tie-animate-slideInUp' ).attr('style', 'animation-delay: 0.'+ $i +'s' );
					});

					// Apply the lazyload
					tie_animate_element( thePostsDiv );
				},
				error: function(){
					menuItem.removeClass('is-loaded');
				},
				complete: function(){
					thePostsDiv.removeClass('is-loading').find('.loader-overlay').remove();
				}
			});
		}
	}


	/**
	 * Desktop Sticky Nav
	 */
	function tieFixedNav(){

		if( $mainNav.length ){

			var windwidth = window.innerWidth,
			adminBarHeight;

			// Desktop : Get the Sticky Element
			if( windwidth > 992 ){

				// The Admin bar is active
				if( $body.hasClass('admin-bar') ){
					adminBarHeight = windwidth < 783 ? 46 : 32;
					adminBarHeight = windwidth < 601 ? 0  : adminBarHeight;
				}

				// The Element height
				var menuHeight = $mainNav.outerHeight();

				// Set the height to the parent element
				$mainNav.parent().css({height: menuHeight});

				// destory the plugin to call it againe with new values in resize
				$mainNav.tiesticky('destroy');

				// intialize it againe
				$mainNav.tiesticky({
					offset       : $mainNav.offset().top,
					behaviorMode : tie.sticky_behavior,
					tolerance    : {
							up: 0,
							down: 0
					},
					windwidth    : windwidth,
					menuHeight   : menuHeight,
					heightDiff   : menuHeight - 60,
					adminBarH    : adminBarHeight,
					isHightestThanSticky:  menuHeight > 60 ? true : false
				});
			}
		}
	}

	if( tie.sticky_desktop ){
		tieFixedNav();
		$window.resize(tieFixedNav);
	}


	/**
	 * Sticky Sidebars
	 */
	function tieStickySidebars(){

		if( jQuery.fn.theiaStickySidebar ){
			var $stickySidebar = jQuery( '.is-sticky', '.main-content-row' );
			if( $stickySidebar.length ){

				var stickySidebarBottom = 35,
				stickySidebarTop = tie.sticky_desktop ? 68 : 0;
				stickySidebarTop = ( tie.sticky_behavior != 'default' ) ? 8 : stickySidebarTop;
				stickySidebarTop = ( $body.hasClass('admin-bar') )      ? stickySidebarTop + 32 : stickySidebarTop;
				stickySidebarTop = ( $body.hasClass('border-layout') )  ? stickySidebarTop + 30 : stickySidebarTop;

				$stickySidebar.theiaStickySidebar({
					'additionalMarginTop'    : stickySidebarTop, //20,
					'additionalMarginBottom' : stickySidebarBottom, //30,
					'minWidth'               : 990
				});
			}


			/*jQuery( '#post-extra-info', '#the-post' ).theiaStickySidebar({
				'additionalMarginTop'    : 120,
				'additionalMarginBottom' : 0,
				'minWidth'               : 990
			});
			*/

		}

	}
	tieStickySidebars();


	/**
	 * Menus
	 */
	// Properly update the ARIA states on focus (keyboard) and mouse over events
	jQuery( 'nav > ul', '#theme-header' ).on( 'focus.wparia  mouseenter.wparia', '[aria-haspopup="true"]', function ( ev ){
		jQuery( ev.currentTarget ).attr( 'aria-expanded', true );
	});

	// Properly update the ARIA states on blur (keyboard) and mouse out events
	jQuery( 'nav > ul', '#theme-header' ).on( 'blur.wparia  mouseleave.wparia', '[aria-haspopup="true"]', function ( ev ){
		jQuery( ev.currentTarget ).attr( 'aria-expanded', false );
	});

	// iPad menu hover bug with Safari
	var userAgent = navigator.userAgent;
	if( userAgent.match(/iPad/i) ){
		if( userAgent.search('Safari') >= 0 && userAgent.search('Chrome') < 0 ){
			jQuery('#main-nav li.menu-item-has-children a, #main-nav li.mega-menu a, .top-bar li.menu-item-has-children a').attr('onclick','return true');
		}
	}

});
