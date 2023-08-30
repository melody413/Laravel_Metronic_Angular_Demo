<script>
    $(document).ready(function () {

        var updateDrugAdvice = null;

        $("#drugAdviceTable").dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ url('/api/data-table/all-drug-advice') }}",
            "columns": [
                { "data" : "#"},
                { "data": "drug_advice" },
                { "data": "status" },
                { "data": "created_at" },
                { "data": "actions" }
            ]
        });

        $("#addDrugAdviceForm").on('submit',function (e) {
            e.preventDefault();
            var data = new FormData(this);
            $.ajax({
                url: '{{url('/save-drug-advice')}}',
                type: 'POST',
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $.Notification.notify('success', 'top right', data[0], data[1]);
                    $(this).formReset($("#addDrugAdviceForm"));
                    $("#add-drug-advice").modal('toggle');
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

        $.fn.getDrugAdviceDetails = function (id) {
            $.get('/api/get-drug-advice-details/'+id,function (data) {
                $("#input_update_drug_advice").val(data.drug_advice);
                $("#checkbox_drug_advice_status").prop('checked',data.status == 1 ? true : false);
                $(this).setDrugAdviceId(data.id);
            })
        };

        $.fn.setDrugAdviceId = function (id) {
            updateDrugAdvice = id;
        }

        $("#updateDrugAdviceForm").on('submit',function (e) {
            e.preventDefault();
            var data = new FormData(this);
            $.ajax({
                url: '{{url('/update-drug-advice')}}'+'/'+updateDrugAdvice,
                type: 'POST',
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $.Notification.notify('success', 'top right', data[0], data[1]);
                    $(this).formReset($("#updateDrugAdviceForm"));
                    $("#edit-drug-advice").modal('toggle');
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

        @if(session('delete_drug_advice'))
            $.Notification.notify('success','top right','Drug advice Deleted','Drug advice has been deleted successfully');
        @endif
    })
</script>