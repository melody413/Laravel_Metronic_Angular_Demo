



require('./Init');
Events = require('./events');

/*

window.Vue = require('vue');

/!**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 *!/

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app'
});
*/

openReserveModel = function($branch, $dateTime, $doctor){
  $('#doctorReserveBranchId').val($branch);
  $('#doctorReserveDateId').val($dateTime);
  $('#reserve_modal').modal('show')
};

$(function() {
    $(document).on("changed.bs.select","select.bsCityies" ,function(e){ Events.handleHeaderSearchCityChang(e) });
    $(document).on("click",".rating-star" ,function(e){ Events.handleRating(this) });
});



