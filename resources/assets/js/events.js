
class Events {

    init() {
        console.log ('-->kamal' );
    }

    handleHeaderSearchCityChang(e){
        var eleParent = $(e.currentTarget);
        var ele = $('.bsCityies');
        var url = appVars.site_url + '_' + appVars.lang + '/data/areas/' + eleParent.val();
        var pushTo = $('select.bsAreas');

        $.get(url, function(data){
            var bsOptions = '<option value="0">أختر المنطقه</option>';
            if(appVars.lang == 'en')
               bsOptions = '<option value="0">Select area</option>';

            for (const [key, value] of Object.entries(data)) {
                selected = '';
                bsOptions += '<option value="'+ key +'" '+ selected +' >'+ value +'</option>';
            }
            $(pushTo).each( function(){
              $(this).html('');
              $(this).html(bsOptions).selectpicker('refresh');
            });

        });
    }

    handleRating(event){
        rateValue =  $(event).prev("input").val();
        $('#review-star-value').val(rateValue);
    }
};

module.exports = new Events();
