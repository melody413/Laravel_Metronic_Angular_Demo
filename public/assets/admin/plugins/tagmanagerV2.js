(function ($) {

    "use strict";

    var defaults = {

    },

    publicMethods = {
        pushTag: function (tag){

        }
    };

    $.fn.tagsManagerV2 = function (method) {
        var $self = $(this);

        if (!(0 in this)) { return this; }

        if (publicMethods[method]) {
            return publicMethods[method].apply($self, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return privateMethods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist.');
            return false;
        }
    };

}(jQuery));