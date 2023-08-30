window.$ = require('jquery')
require('bootstrap');
require('bootstrap-select');
require('lightgallery.js');
require('bootstrap-datepicker');



$('#homeFilter a').on('click', function (e) {
    e.preventDefault();
    $(this).tab('show')
});
$('#topping_tabs_ul a').on('click', function (e) {
    e.preventDefault();
    $(this).tab('show')
});

$('.the_search select').selectpicker({
    liveSearch: true
});

//$('.the_search_holder')


$(window).scroll(function(e) {
    e.preventDefault();
    var scroll = $(window).scrollTop();

    if (scroll >= 100) {
        $(".the_search_holder").addClass("stick_it");
        $(".inner_container").addClass("sticked");
    } else {
        $(".the_search_holder").removeClass("stick_it");
        $(".inner_container").removeClass("sticked");
    }
});

//$('.collapse').collapse();


// Gallery handler
lightGallery(document.getElementById('lightgallery'), {
    mode: 'lg-fade',
    cssEasing : 'cubic-bezier(0.25, 0, 0.25, 1)'
});

$('.datepicker').datepicker({format: 'yyyy-mm-dd'});

// Full nav toggle
$('.full_nav_toggler').on('click', function () {
   $('.full_nav').addClass('open');
   $('body').css('overflow-y', 'hidden');
});
$('.full_nav .close').on('click', function () {
    $('.full_nav').removeClass('open');
    $('body').css('overflow-y', 'scroll');
});
