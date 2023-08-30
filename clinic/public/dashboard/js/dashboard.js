/**
 * Created by rifat on 10/5/17.
 */

$(document).ready(function () {

    $('form').parsley();

    $.uploadPreview({
        input_field: "#image-upload",   // Default: .image-upload
        preview_box: "#image-preview",  // Default: .image-preview
        label_field: "#image-label",    // Default: .image-label
        label_default: "Choose File",   // Default: Choose File
        label_selected: "Change File",  // Default: Change File
        no_label: false                 // Default: false
    });

    $.fn.confirmDelete = function (url) {
        var conf = confirm('Are You sure to delete ?');
        if(conf){
            window.location.replace(url);
        }
    };

    $.fn.speedPost = function (url,formData,formId) {
        $("#loading").show();
        $.ajax({
            url:url,
            type:'POST',
            data:formData,
            contentType: false,
            cache: false,
            processData:false,
            success:function (data) {
                $.Notification.notify('success','top right',data[0],data[1]);
                if(formId){
                    $(this).formReset(formId);
                };
            },error:function (data) {
                if(data.status === 422 ){
                    $(this).showValidationError(data);
                }
                else{
                    $(this).showServerError();
                }
            }
        });
        $("#loading").hide();
    };

    var imageBackground = "../images/image_placeholder.jpg";

    $.fn.formReset = function (formId) {
        formId.get(0).reset();
        $("#image-preview").css('background-image','url('+imageBackground+')');
        $('.select2').val('').change();
        $('.select3').val('').change();
    }

    $.fn.showValidationError = function (data) {
        $.each(data.responseJSON,function (key,data) {
            for(var key in data) {
                if(key.length > 2){
                    $.each(data[key],function (index,data) {
                        console.log(data);
                        $.Notification.notify('error','top right',data)
                    })
                }
            }
        });
    };

    $.fn.showServerError = function () {
        $.Notification.notify('warning','top right',"Internal server error",
            "Internal server error" +
            "Refresh this page and try again" +
            "Or, contact to your system admin")
    }



});