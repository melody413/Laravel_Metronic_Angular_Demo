$(function() {
    "use strict";

    // Toggle responsive navigation
    $( "#responsive_nav_toggler" ).on( "click", function() {
        $("#responsive_nav_block").toggleClass('opened');
        $("#overlay").toggleClass('opened');
        $("body").toggleClass('responsive_nav_opened');
    });
    $("#responsive_nav_block_close").on( "click", function () {
        $("#responsive_nav_block").removeClass('opened');
        $("#overlay").removeClass('opened');
        $("body").removeClass('responsive_nav_opened');
    } );
    $("#overlay").on( "click", function () {
        $("#responsive_nav_block").removeClass('opened');
        $("#overlay").removeClass('opened');
        $("body").removeClass('responsive_nav_opened');
    } );

    // Clone Search From Into Search Modal
    var Cloner = $( "#the_search_form" ).clone();

    $( "#responsive_nav_search_block_inner" ).html(Cloner);

   $('[name="speciality"]').selectpicker('refresh');
   $('[name="city"]').selectpicker('refresh');
   $('[name="area"]').selectpicker('refresh');
   $('[name="insurance_company"]').selectpicker('refresh');
});
