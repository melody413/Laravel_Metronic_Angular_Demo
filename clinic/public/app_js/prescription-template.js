/**
 * Created by rifat on 10/7/17.
 */

$(document).bind('keydown', 'ctrl+d', function (e) {
    e.preventDefault();
    $("#btnNewDrug").click();
});

$(document).ready(function () {
    var updateTemplateId = null;
    var patientId = null;
    var drugList = [];
    var drugUpdateKey = null;
    var selectedTemplate = null;

    var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nove", "Dec"
    ];

    // Select 2 initialize
    $(".select2").select2({
        placeholder: "Please select a drug",
        width: '100%'
    });

    // Add new drug
    $("#saveDrug").on('click', function () {
        $("#newDrug").submit();
    });

    // Open new drug modal
    $("#newDrug").on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url:'/save-new-drug',
            type:'POST',
            data:formData,
            contentType: false,
            cache: false,
            processData:false,
            success:function (data) {
                $.Notification.notify('success','top right',"Drug added successfully","drug has been added successfully");
                $("#drug").append('<option value='+data.id+'>'+data.name+'</option>');
                $("#drugUpdateSelect").append('<option value='+data.id+'>'+data.name+'</option>');
                $("#drug").val(data.id).trigger('change');
                $("#con-close-modal").modal('hide');
                $("#newDrug").get(0).reset();
            },error:function (data){
                $(this).showAjaxError(data);
            }

        });
    });

    // Add drug to the list
    $("#addDrugToListForm").on('submit',function (e) {
        e.preventDefault();
        if($(this).checkValidation()){
            drug = {
                drug_id : $("#drug").val(),
                drug_name : $("#drug").select2('data')[0].text,
                drug_type : $("#drug_type").val(),
                strength : $("#strength").val(),
                dose : $("#dose").val(),
                duration : $("#duration").val(),
                drug_advice : $("#drug_advice").val()
            };
            drugList.push(drug);
            $(this).refreshDrugForm();
            $(this).renderDrug(drugList);
            console.log(drugList);
        }
    });

    // Open drug update (form the drug list) modal
    $("#updateDrugList").on('click',function () {
       $("#drugUpdateForm").submit();
    });

    // Update drug form the list
    $("#drugUpdateForm").on('submit',function (e) {
        e.preventDefault();
        if(drugUpdateKey != null){
            drug = {
                drug_id : $("#drugUpdateSelect").val(),
                drug_name : $("#drugUpdateSelect").select2('data')[0].text,
                strength : $("#updateDrugStrength").val(),
                dose : $("#updateDrugDose").val(),
                duration : $("#updateDrugDuration").val(),
                drug_advice : $("#updateDrugAdvice").val(),
                drug_type : $("#updateDrugType").val()
            };
            drugList[drugUpdateKey] = drug;
            $(this).refreshDrugForm();
            $(this).renderDrug();
            $("#edit-drug-modal").modal('hide');
            drugUpdateKey = null;
        }
    });

    // Save Template
    $("#saveTemplate").on('click',function (e) {
        $(this).saveTemplate('/save-template',true);
    });

    // Update template
    $("#updateTemplate").on('click',function (e) {
        var url = '/update-template/'+updateTemplateId;
        $(this).saveTemplate(url,false);
    });

    // Generate prescription form prescription
    $.fn.getPrescriptionDetails = function(prescriptionId){
      console.log(prescriptionId);
      $.get('/api/prescription-details/'+prescriptionId,function (data) {
          console.log(data);
          var _drugs = [];
          $.each(data.drugs, function (key, data) {
              var _drug = {
                  drug_id: data.drug.id,
                  drug_name: data.drug.name,
                  drug_type: data.type,
                  strength: data.strength,
                  dose: data.dose,
                  duration: data.duration,
                  drug_advice: data.advice
              }
              _drugs.push(_drug);
          });
          $(this).setDrugList(_drugs);
          $(this).renderDrug();
          $(this).renderPrescriptionLeftForPrescription(data);

      })
    };

    $.fn.getPatientDetails = function (patientId) {
        $(this).setPatientId(patientId);
        if (patientId != '') {
            $.get('/api/patient-details/' + patientId, function (data) {
                $("#_patientName").text(data.patient.name);
                $("#_patientAge").text(data.age);
                $("#_patientGender").text(data.patient.gender === 1 ? 'Male' : data.patient.gender === 2 ? 'Fe-male' : 'Other');
                $("#_patientImage").attr('src', data.patient.image != null ? data.patient.image : '/dashboard/images/image_placeholder.jpg')
                if (data.patient.prescriptions.length != 0) {

                    $("#_patientPrescriptions").children().remove();
                    $(".patientPres").show();
                    $("#_patientPrescriptions").append(
                        $("<option>", {value: null, text: 'Select one'})
                    );
                    $.each(data.patient.prescriptions, function (key, data) {
                        var d = new Date(data.created_at);
                        $("#_patientPrescriptions").append(
                            $("<option>", {value: data.id,
                                text: d.getDate()+"-"+monthNames[d.getMonth()]+"-"+d.getFullYear()
                            })
                        )
                    });

                } else {
                    $("#_patientPrescriptions").children().remove();
                    $(".patientPres").hide();
                }
                console.log(data.patient);
            })
        }
    };

    // Save Prescription function
    $.fn.savePrescription = function () {
        console.log('Save prescription');
        if (drugList.length != 0) {
            if(patientId != null){
                prescriptionData = {
                    _token : $('input[name=_token]').val(),
                    drugs : drugList,
                    template_id : selectedTemplate,
                    patient_id : patientId,
                    drug_type : $("#drug_type").val(),
                    cc : $("#cc").val(),
                    oe : $("#oe").val(),
                    pd : $("#pd").val(),
                    dd : $("#dd").val(),
                    lab_workup : $("#lab_worekup").val(),
                    advice : $("#advice").val(),
                    note : $("#note").val(),
                    next_visit : $("#next_visit").val()
                };
                $("#loadingSavePrescription").show();
                $.ajax({
                    url:'/save-prescription',
                    type:'post',
                    data : JSON.stringify(prescriptionData),
                    contentType: 'application/json; charset=utf-8',
                    cache: false,
                    processData:false,
                    success:function (data) {
                        window.location.replace('/print-prescription/'+data.id);
                        $("#loadingSavePrescription").hide();
                    },error:function (data) {
                        console.log(data);
                        $("#loadingSavePrescription").hide();
                    }
                })
            }else{
                $.Notification.notify('error', 'top right', "No Patient selected yet",
                    "You cannot create an prescription without any patient." +
                    "Please select patient first.");
            }
        } else {
            $.Notification.notify('error', 'top right', "No drug added",
                "You cannot create an prescription without any drug." +
                "Please add minimum one drug to save template.");
        }
    };

    // Save template function
    $.fn.saveTemplate = function (url,isFormReset) {
        if(drugList.length != 0){
            templateData = {
                _token : $('input[name=_token]').val(),
                drugs : drugList,
                name : $("#templateName").val(),
                drug_type : $("#drug_type").val(),
                cc : $("#cc").val(),
                oe : $("#oe").val(),
                pd : $("#pd").val(),
                dd : $("#dd").val(),
                lab_workup : $("#lab_worekup").val(),
                advice : $("#advice").val(),
                note : $("#note").val(),
            };
            // ajax request
            $("#loadingSaveTemplate").show();
            $.ajax({
                url:url,
                type:'POST',
                data : JSON.stringify(templateData),
                contentType: 'application/json; charset=utf-8',
                cache: false,
                processData:false,
                success:function (data) {
                    $.Notification.notify('success','top right', "Prescription template save successfully")
                    if(isFormReset === true){
                        $(this).resetTemplate();
                    }
                    $("#loadingSaveTemplate").hide();
                },
                error:function (data) {
                    $.Notification.notify('error','top right','Whops! Something went worng');
                    $("#loadingSaveTemplate").hide();
                }
            })
        }else{
            $.Notification.notify('error','top right',"No drug added",
                "You cannot create an prescription template without any drug." +
                "Please add minimum one drug to save template.");
        }
    };

    // Render drug
    $.fn.renderDrug = function () {
        $("#drugListView").empty();
        $.each(drugList,function (key,data) {
            console.log(data);
            $("#drugListView").append(
                $('<li>').append(
                    $("<i>",{text:data.drug_type}).append("&nbsp;&nbsp;"),
                    $("<b>",{text:data.drug_name}).append("&emsp;"),
                    $("<i>",{text:data.strength}).append("&emsp;"),
                    $("<button>",{class:"btn btn-sm btn-link btn-primary",
                        onClick:"$(this).editDrug("+key+")"}).append(
                        $("<i>",{class:'fa fa-pencil'})
                    ),
                    $("<button>",{class:"btn btn-sm btn-link btn-danger",
                        onClick:"$(this).deleteDrug("+key+")"}).append(
                        $("<i>",{class:'fa fa-trash-o'})
                    ),
                    $('<ul>').append(
                        $('<li>').append(
                            $('<span>',{text:data.dose}).append("&emsp;"),
                            $("<span>",{text:data.duration})
                        ),
                        $('<li>',{text:data.drug_advice})
                    )
                )
            )
        })
    };

    // Render prescription elements left
    $.fn.renderPrescriptionLeft = function (data) {
        $("#cc").val(data.prescription_template_left.cc);
        $("#oe").val(data.prescription_template_left.oe);
        $("#pd").val(data.prescription_template_left.pd);
        $("#dd").val(data.prescription_template_left.dd);
        $("#lab_worekup").val(data.prescription_template_left.lab_workup);
        $("#templateName").val(data.name);
        $("#note").val(data.note);
        $("#advice").val(data.prescription_template_left.advice);
    };

    $.fn.renderPrescriptionLeftForPrescription = function (data) {
        $("#cc").val(data.prescription_left.cc);
        $("#oe").val(data.prescription_left.oe);
        $("#pd").val(data.prescription_left.pd);
        $("#dd").val(data.prescription_left.dd);
        $("#lab_worekup").val(data.prescription_left.lab_workup);
        $("#advice").val(data.prescription_left.advice);
    };

    // Set the selected drug value on the drug update modal
    $.fn.editDrug = function (key) {
        var drug = drugList[key];
        drugUpdateKey = key;
        $("#edit-drug-modal").modal('show');
        $("#drugUpdateSelect").val(drug.drug_id).trigger('change');
        $("#updateDrugStrength").val(drug.strength);
        $("#updateDrugDose").val(drug.dose);
        $("#updateDrugDuration").val(drug.duration);
        $("#updateDrugAdvice").val(drug.drug_advice);
        $("#updateDrugType").val(drug.drug_type);

    };

    // Delete drug form the list
    $.fn.deleteDrug = function (key) {
        var check = confirm('Are you sure you want to delete this drug form the list ?');
        if(check){
            drugList.splice(key,1);
            console.log(drugList);
            $(this).renderDrug(drugList);
        }
    };

    // check validation
    $.fn.checkValidation = function () {
      if($("#drug").val() == ''){
          alert('You have to select a drug first');
          return false;
      }else{
          return true;
      }
    };

    // Refresh drug form
    $.fn.refreshDrugForm = function () {
        $("#drug").val('').trigger('change');
        $("#strength").val('');
        $("#dose").val('');
        $("#duration").val('');
        $("#drug_advice").val('');
        $("#drug_type").val('')
    };

    $.fn.showAjaxError = function(data){
        if(data.status == 422 ){
            $.each(data.responseJSON,function (key,data) {
                for(var key in data) {
                    if(key.length > 2){
                        $.each(data[key],function (index,data) {
                            $.Notification.notify('error','top right',data)
                        })
                    }
                }
            });
        }else{
            $.Notification.notify('warning','top right',"Internal server error",
                "Internal server error" +
                "Refresh this page and try again" +
                "Or, contact to your system admin")
        }
    };

    // Reset prescription template
    $.fn.resetTemplate = function () {
        $(this).refreshDrugForm();
        drugList = [];
        $(this).renderDrug();
        $("#cc").val('');
        $("#oe").val('');
        $("#pd").val('');
        $("#dd").val('');
        $("#lab_worekup").val('');
        $("#templateName").val('');
        $("#note").val('');
        $("#advice").val('');
    };

    $.fn.setDrugList = function (drugs) {
        drugList = drugs;
    };

    $.fn.setTemplateId = function (id) {
        updateTemplateId = id;
    };

    $.fn.setPatientId = function (id) {
        patientId = id;
    };

    $.fn.setSelectedTemplate = function (id) {
        selectedTemplate = id;
    }
});