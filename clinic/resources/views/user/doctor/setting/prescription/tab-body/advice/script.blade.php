<script>
    $(document).ready(function () {

        var updateAdvice = null;

        $("#adviceTable").dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ url('/api/data-table/all-advice') }}",
            "columns": [
                { "data" : "#"},
                { "data": "advice" },
                { "data": "status" },
                { "data": "created_at" },
                { "data": "actions" }
            ]
        });

        $("#newAdviceForm").on('submit',function (e) {
            e.preventDefault();
            var data = new FormData(this);
            $.ajax({
                url: '{{url('/save-advice')}}',
                type: 'POST',
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $.Notification.notify('success', 'top right', data[0], data[1]);
                    $(this).formReset($("#newAdviceForm"));
                    $("#add-advice").modal('toggle');
                }, error: function (data) {
                    if (data.status == 422) {
                        $(this).showValidationError(data);
                    }
                    else {
                        $(this).showServerError();
                    }
                }
            });

        });

        $.fn.getAdviceDetails = function (id) {
            $.get('/api/get-advice-details/'+id,function (data) {
                $("#input_update_advice").val(data.advice);
                $("#checkbox_advice_status").prop('checked',data.status == 1 ? true : false);
                $(this).setDrugAdviceId(data.id);
            })
        };

        $.fn.setDrugAdviceId = function (id) {
            updateAdvice = id;
        };

        $("#updateAdviceForm").on('submit',function (e) {
            e.preventDefault();
            var data = new FormData(this);
            $.ajax({
                url: '{{url('/update-advice')}}'+'/'+updateAdvice,
                type: 'POST',
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $.Notification.notify('success', 'top right', data[0], data[1]);
                    $(this).formReset($("#updateAdviceForm"));
                    $("#edit-advice").modal('toggle');
                }, error: function (data) {
                    if (data.status == 422) {
                        $(this).showValidationError(data);
                    }
                    else {
                        $(this).showServerError();
                    }
                }
            });
        });

        @if(session('advice_delete'))
$.Notification.notify('success','top right','Prescription Advice Deleted','Prescription advice has been deleted successfully');
        @endif
    })
</script>