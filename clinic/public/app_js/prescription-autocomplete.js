/**
 * Created by rifat on 10/14/17.
 */
$(document).ready(function () {

    var availableStrength = [];
    var availableType = [];
    var availableDose = [];
    var availableDurations = [];
    var availableDrugAdvices = [];
    var availableAdvices = [];



    $("#strength").on('focus',function () {
        if(availableStrength.length == 0){
            $(this).getDrugStrength();
            $("#strength").autocomplete({source:availableStrength});
            $("#updateDrugStrength").autocomplete({source:availableStrength});
            console.log(availableStrength);
        }
    });

    $("#drug_type").on('focus',function () {
        if(availableType.length == 0){
            $(this).getDrugTypes();
            $("#drug_type").autocomplete({source:availableType});
            $("#updateDrugType").autocomplete({source:availableType});
            console.log(availableType);
        }
    });

    $("#dose").on('focus',function () {
        if(availableDose.length == 0){
            $(this).getDrugDoses();
            $("#dose").autocomplete({source:availableDose});
            $("#updateDrugDose").autocomplete({source:availableDose});
            console.log(availableDose);
        }
    });

    $("#duration").on('focus',function () {
        if(availableDurations.length == 0){
            $(this).getDrugDurations();
            $("#duration").autocomplete({source:availableDurations});
            $("#updateDrugDuration").autocomplete({source:availableDurations});
            console.log(availableDurations);
        }
    });

    $("#drug_advice").on('focus',function () {
        if(availableDrugAdvices.length == 0){
            $(this).getDrugAdvice();
            $("#drug_advice").autocomplete({source:availableDrugAdvices});
            $("#updateDrugAdvice").autocomplete({source:availableDrugAdvices});
            console.log(availableDrugAdvices);
        }
    });

    $("#advice").on('focus',function () {
       if(availableAdvices.length == 0){
           $(this).getAdvices();
           $( "#advice" )
           // don't navigate away from the field on tab when selecting an item
               .on( "keydown", function( event ) {
                   if ( event.keyCode === $.ui.keyCode.TAB &&
                       $( this ).autocomplete( "instance" ).menu.active ) {
                       event.preventDefault();
                   }
               })
               .autocomplete({
                   minLength: 0,
                   source: function( request, response ) {
                       // delegate back to autocomplete, but extract the last term
                       response( $.ui.autocomplete.filter(
                           availableAdvices, extractLast( request.term ) ) );
                   },
                   focus: function() {
                       // prevent value inserted on focus
                       return false;
                   },
                   select: function( event, ui ) {
                       var terms = split( this.value );
                       // remove the current input
                       terms.pop();
                       // add the selected item
                       terms.push( ui.item.value );
                       // add placeholder to get the comma-and-space at the end
                       terms.push( "" );
                       this.value = terms.join( ", " );
                       return false;
                   }
               });

       }
    });




    $.fn.getDrugStrength = function () {
      $.get('/api/get-drug-strengths',function (data) {
          $.each(data,function (key,data) {
             availableStrength.push(data.strength)
          });
      })
    };

    $.fn.getDrugTypes = function () {
        $.get('/api/get-drug-types',function (data) {
            $.each(data,function (key,data) {
                availableType.push(data.type);
            })
        })
    };

    $.fn.getDrugDoses = function () {
        $.get('/api/get-drug-doses',function (data) {
            $.each(data,function (key,data) {
                availableDose.push(data.dose);
            })
        })
    };

    $.fn.getDrugDurations = function () {
        $.get('/api/get-drug-durations',function (data) {
            $.each(data,function (key,data) {
                availableDurations.push(data.duration);
            })
        })
    };

    $.fn.getDrugAdvice = function () {
        $.get('/api/get-drug-advices',function (data) {
            $.each(data,function (key,data) {
                availableDrugAdvices.push(data.drug_advice);
            })
        })
    };

    $.fn.getAdvices = function () {
        $.get('/api/get-advices',function (data) {
            $.each(data,function (key,data) {
                availableAdvices.push(data.advice);
            })
        })
    };

});

function split( val ) {
    return val.split( /,\s*/ );
}
function extractLast( term ) {
    return split( term ).pop();
}