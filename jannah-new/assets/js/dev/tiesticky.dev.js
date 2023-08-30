/*!
 * tiesticky.js v1.2.1 Sticky Navigation Menu with default stikcy and when scrolling upwards behaviors.
 * Copyright (c) 2017 TieLabs
 * License: MIT
 * Based on: headroom.js v0.9.3 | URL: http://wicky.nillia.ms/headroom.js
 * 5 Dec 17
 */
(function($) {

  if(!$) {
    return;
  }

  ////////////
  // Plugin //
  ////////////

  $.fn.tiesticky = function(option) {
    return this.each(function() {
      var $this   = $(this),
        data      = $this.data('tiesticky'),
        options   = typeof option === 'object' && option;

      options = $.extend(true, {}, TieSticky.options, options);

      if (!data) {
        data = new TieSticky(this, options);
        data.init();
        $this.data('tiesticky', data);
      }
      if (typeof option === 'string') {
        data[option]();

        if(option === 'destroy'){
          $this.removeData('tiesticky');
        }
      }
    });
  };

  //////////////
  // Data API //
  //////////////
  /*
  $('[data-tiesticky]').each(function() {
    var $this = $(this);
    $this.tiesticky($this.data());
  });
  */
}(window.jQuery));


(function(root, factory) {
  'use strict';

  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module.
    define([], factory);
  }
  else if (typeof exports === 'object') {
    // COMMONJS
    module.exports = factory();
  }
  else {
    // BROWSER
    root.TieSticky = factory();
  }
}(this, function() {
  'use strict';

  /* exported features */

  var features = {
    bind : !!(function(){}.bind),
    classList : 'classList' in document.documentElement,
    rAF : !!(window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame)
  };
  window.requestAnimationFrame = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame;

  /**
   * Handles debouncing of events via requestAnimationFrame
   * @see http://www.html5rocks.com/en/tutorials/speed/animations/
   * @param {Function} callback The callback to handle whichever event
   */
  function Debouncer (callback) {
    this.callback = callback;
    this.ticking = false;
  }
  Debouncer.prototype = {
    constructor : Debouncer,

    /**
     * dispatches the event to the supplied callback
     * @private
     */
    update : function() {
      this.callback && this.callback();
      this.ticking = false;
    },

    /**
     * ensures events don't get stacked
     * @private
     */
    requestTick : function() {
      if(!this.ticking) {
        requestAnimationFrame(this.rafCallback || (this.rafCallback = this.update.bind(this)));
        this.ticking = true;
      }
    },

    /**
     * Attach this as the event listeners
     */
    handleEvent : function() {
      this.requestTick();
    }
  };
  /**
   * Check if object is part of the DOM
   * @constructor
   * @param {Object} obj element to check
   */
  function isDOMElement(obj) {
    return obj && typeof window !== 'undefined' && (obj === window || obj.nodeType);
  }

  /**
   * Helper function for extending objects
   */
  function extend (object /*, objectN ... */) {
    if(arguments.length <= 0) {
      throw new Error('Missing arguments in extend function');
    }

    var result = object || {},
        key,
        i;

    for (i = 1; i < arguments.length; i++) {
      var replacement = arguments[i] || {};

      for (key in replacement) {
        // Recurse into object except if the object is a DOM element
        if(typeof result[key] === 'object' && ! isDOMElement(result[key])) {
          result[key] = extend(result[key], replacement[key]);
        }
        else {
          result[key] = result[key] || replacement[key];
        }
      }
    }

    return result;
  }

  /**
   * Helper function for normalizing tolerance option to object format
   */
  function normalizeTolerance (t) {
    return t === Object(t) ? t : { down : t, up : t };
  }

  /**
   * UI enhancement for fixed headers.
   * Hides header when scrolling down
   * Shows header when scrolling up
   * @constructor
   * @param {DOMElement} elem the header element
   * @param {Object} options options for the widget
   */
  function TieSticky (elem, options) {
    options = extend(options, TieSticky.options);

    this.lastKnownScrollY     = 0;
    this.elem                 = elem;
    this.tolerance            = normalizeTolerance(options.tolerance);
    this.classes              = options.classes;
    this.behaviorMode         = options.behaviorMode;
    this.scroller             = options.scroller;
    this.initialised          = false;
    this.onPin                = options.onPin;
    this.onUnpin              = options.onUnpin;
    this.onTop                = options.onTop;
    this.onNotTop             = options.onNotTop;
    this.onBottom             = options.onBottom;
    this.onNotBottom          = options.onNotBottom;
    this.offset               = options.offset;
    this.windwidth            = options.windwidth;
    this.offset               = (this.behaviorMode !='default')? this.offset + this.elem.offsetHeight : this.offset;
    this.offset               = ($body.hasClass('admin-bar'))? this.offset - options.adminBarH : this.offset;
    this.offset               = ($body.hasClass('border-layout'))? this.offset - 25 : this.offset;
    this.offset               = ($body.hasClass('border-layout') && this.windwidth < 992)? this.offset + 25 : this.offset;
    this.menuHeight           = options.menuHeight;
    this.isHightestThanSticky = options.isHightestThanSticky;
    this.heightDiff           = options.heightDiff;
  }

  TieSticky.prototype = {
    constructor : TieSticky,

    /**
     * Initialises the widget
     */
    init : function() {
      if(!TieSticky.cutsTheMustard) {
        return;
      }

      if(this.behaviorMode == 'default'){
        this.elem.classList.add('default-behavior-mode');
      }

      this.debouncer = new Debouncer(this.update.bind(this));
      this.elem.classList.add(this.classes.initial);

      // defer event registration to handle browser
      // potentially restoring previous scroll position
      setTimeout(this.attachEvent.bind(this), 100);

      return this;
    },

    /**
     * Unattaches events and removes any classes that were added
     */
    destroy : function() {
      var classes = this.classes;

      this.initialised = true;
      this.elem.classList.remove(classes.unpinned, classes.pinned, classes.top, classes.notTop, classes.initial, 'fixed-nav');
      this.scroller.removeEventListener('scroll', this.debouncer, false);
    },

    /**
     * Attaches the scroll event
     * @private
     */
    attachEvent : function() {
      if(!this.initialised){
        this.lastKnownScrollY = this.getScrollY();
        this.initialised = true;
        this.scroller.addEventListener('scroll', this.debouncer, false);

        this.debouncer.handleEvent();
      }
    },

    /**
     * Unpins the header if it's currently pinned
     */
    unpin : function() {
      var classList = this.elem.classList,
        classes = this.classes;

      if(classList.contains(classes.pinned) || !classList.contains(classes.unpinned)) {
        classList.add(classes.unpinned);
        classList.remove(classes.pinned);
        this.onUnpin && this.onUnpin.call(this);
      }
    },

    /**
     * Pins the header if it's currently unpinned
     */
    pin : function() {
      var classList = this.elem.classList,
        classes = this.classes;

      if(classList.contains(classes.unpinned)) {
        classList.remove(classes.unpinned);
        classList.add(classes.pinned);
        this.onPin && this.onPin.call(this);
      }
    },

    /**
     * Handles the top states
     */
    top : function() {
      var classList = this.elem.classList,
        classes = this.classes;

      if(!classList.contains(classes.top)) {
        classList.add(classes.top);
        classList.remove(classes.notTop);
        this.onTop && this.onTop.call(this);
      }
    },

    /**
     * Handles the not top state
     */
    notTop : function() {
      var classList = this.elem.classList,
        classes = this.classes;

      if(!classList.contains(classes.notTop)) {
        classList.add(classes.notTop);
        classList.remove(classes.top);
        this.onNotTop && this.onNotTop.call(this);
      }
    },

    bottom : function() {
      var classList = this.elem.classList,
        classes = this.classes;

      if(!classList.contains(classes.bottom)) {
        classList.add(classes.bottom);
        classList.remove(classes.notBottom);
        this.onBottom && this.onBottom.call(this);
      }
    },

    /**
     * Handles the not top state
     */
    notBottom : function() {
      var classList = this.elem.classList,
        classes = this.classes;

      if(!classList.contains(classes.notBottom)) {
        classList.add(classes.notBottom);
        classList.remove(classes.bottom);
        this.onNotBottom && this.onNotBottom.call(this);
      }
    },

    /**
     * Gets the Y scroll position
     * @see https://developer.mozilla.org/en-US/docs/Web/API/Window.scrollY
     * @return {Number} pixels the page has scrolled along the Y-axis
     */
    getScrollY : function() {
      return (this.scroller.pageYOffset !== undefined)
        ? this.scroller.pageYOffset
        : (this.scroller.scrollTop !== undefined)
          ? this.scroller.scrollTop
          : (document.documentElement || document.body.parentNode || document.body).scrollTop;
    },

    /**
     * Gets the height of the viewport
     * @see http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript
     * @return {int} the height of the viewport in pixels
     */
    getViewportHeight : function () {
      return window.innerHeight
        || document.documentElement.clientHeight
        || document.body.clientHeight;
    },

    /**
     * Gets the physical height of the DOM element
     * @param  {Object}  elm the element to calculate the physical height of which
     * @return {int}     the physical height of the element in pixels
     */
    getElementPhysicalHeight : function (elm) {
      return Math.max(
        elm.offsetHeight,
        elm.clientHeight
      );
    },

    /**
     * Gets the physical height of the scroller element
     * @return {int} the physical height of the scroller element in pixels
     */
    getScrollerPhysicalHeight : function () {
      return (this.scroller === window || this.scroller === document.body)
        ? this.getViewportHeight()
        : this.getElementPhysicalHeight(this.scroller);
    },

    /**
     * Gets the height of the document
     * @see http://james.padolsey.com/javascript/get-document-height-cross-browser/
     * @return {int} the height of the document in pixels
     */
    getDocumentHeight : function () {
      var body = document.body,
        documentElement = document.documentElement;

      return Math.max(
        body.scrollHeight, documentElement.scrollHeight,
        body.offsetHeight, documentElement.offsetHeight,
        body.clientHeight, documentElement.clientHeight
      );
    },

    /**
     * Gets the height of the DOM element
     * @param  {Object}  elm the element to calculate the height of which
     * @return {int}     the height of the element in pixels
     */
    getElementHeight : function (elm) {
      return Math.max(
        elm.scrollHeight,
        elm.offsetHeight,
        elm.clientHeight
      );
    },

    /**
     * Gets the height of the scroller element
     * @return {int} the height of the scroller element in pixels
     */
    getScrollerHeight : function () {
      return (this.scroller === window || this.scroller === document.body)
        ? this.getDocumentHeight()
        : this.getElementHeight(this.scroller);
    },

    /**
     * determines if the scroll position is outside of document boundaries
     * @param  {int}  currentScrollY the current y scroll position
     * @return {bool} true if out of bounds, false otherwise
     */
    isOutOfBounds : function (currentScrollY) {
      var pastTop  = currentScrollY < 0,
        pastBottom = currentScrollY + this.getScrollerPhysicalHeight() > this.getScrollerHeight();

      return pastTop || pastBottom;
    },

    /**
     * determines if the tolerance has been exceeded
     * @param  {int} currentScrollY the current scroll y position
     * @return {bool} true if tolerance exceeded, false otherwise
     */
    toleranceExceeded : function (currentScrollY, direction) {
      return Math.abs(currentScrollY-this.lastKnownScrollY) >= this.tolerance[direction];
    },

    /**
     * determine if it is appropriate to unpin
     * @param  {int} currentScrollY the current y scroll position
     * @param  {bool} toleranceExceeded has the tolerance been exceeded?
     * @return {bool} true if should unpin, false otherwise
     */
    shouldUnpin : function (currentScrollY, toleranceExceeded) {
      var scrollingDown = currentScrollY > this.lastKnownScrollY,
        pastOffset = currentScrollY >= this.offset;

      return scrollingDown && pastOffset && toleranceExceeded;
    },

    /**
     * determine if it is appropriate to pin
     * @param  {int} currentScrollY the current y scroll position
     * @param  {bool} toleranceExceeded has the tolerance been exceeded?
     * @return {bool} true if should pin, false otherwise
     */
    shouldPin : function (currentScrollY, toleranceExceeded) {
      var scrollingUp  = currentScrollY < this.lastKnownScrollY,
        pastOffset = currentScrollY <= this.offset;

      return (scrollingUp && toleranceExceeded) || pastOffset;
    },

    /**
     * Handles updating the state of the widget
     */

    update : function() {
      var currentScrollY  = this.getScrollY(),
        scrollDirection = currentScrollY > this.lastKnownScrollY ? 'down' : 'up',
        toleranceExceeded = this.toleranceExceeded(currentScrollY, scrollDirection)
      if(this.isOutOfBounds(currentScrollY)) { // Ignore bouncy scrolling in OSX
        return;
      }


      // this.isHightestThanSticky : if the menu height in normal mode is highest than of sticky nav height (60);
      // this.heightDiff: the value of (menuHeight - 60)

      if(this.behaviorMode =='default' && this.isHightestThanSticky &&
         this.offset < currentScrollY  && currentScrollY < (this.offset + this.heightDiff)){
        this.elem.classList.add('just-before-sticky');
      }else{
        this.elem.classList.remove('just-before-sticky');
      }






      if ((currentScrollY <= this.offset - this.elem.offsetHeight) && this.behaviorMode !='default') {
        this.top();
        this.elem.classList.add('unpinned-no-transition');
      }
      else if ((currentScrollY <= this.offset) && this.behaviorMode =='default') {
        this.top();
      }
      else if(currentScrollY > this.offset ) {
        this.notTop(); // fixed nav

        if (this.behaviorMode =='default' && currentScrollY < (this.offset + 100) ){
          jQuery('#autocomplete-suggestions').hide();
        }
      }

      if(currentScrollY + this.getViewportHeight() >= this.getScrollerHeight()) {
        this.bottom();
      }
      else {
        this.notBottom();
      }

      if(this.shouldUnpin(currentScrollY, toleranceExceeded)) {
        this.unpin();
      }
      else if(this.shouldPin(currentScrollY, toleranceExceeded)) {
        this.pin();

        // check if notTop(if below sticky) if we want to change menu to pinned
        if((currentScrollY > this.offset) && this.behaviorMode !='default'){
          this.elem.classList.remove('unpinned-no-transition');

          jQuery('#autocomplete-suggestions').hide();
        }
      }

      this.lastKnownScrollY = currentScrollY;
    }
  };
  /**
   * Default options
   * @type {Object}
   */
  TieSticky.options = {
    tolerance : {
      up : 0,
      down : 0
    },
    offset : 0,
    behaviorMode: 'upwards',
    scroller: window,
    classes : {
      initial  : 'fixed',
      pinned   : 'fixed-pinned',
      unpinned : 'fixed-unpinned',
      top      : 'fixed-top',
      notTop   : 'fixed-nav',
      bottom   : 'fixed-bottom',
      notBottom: 'fixed-not-bottom'
    }
  };
  TieSticky.cutsTheMustard = typeof features !== 'undefined' && features.rAF && features.bind && features.classList;

  return TieSticky;
}));
