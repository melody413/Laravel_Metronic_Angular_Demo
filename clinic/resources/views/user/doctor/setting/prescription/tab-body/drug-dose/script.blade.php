<script>
    $(document).ready(function () {

        var updateDrugDose = null;

        $("#doseTable").dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ url('/api/data-table/all-drug-dose') }}",
            "columns": [
                { "data" : "#"},
                { "data": "dose" },
                { "data": "status" },
                { "data": "created_at" },
                { "data": "actions" }
            ]
        });

        $("#addDrugDoseForm").on('submit',function (e) {
            e.preventDefault();
            var data = new FormData(this);
            $.ajax({
                url: '{{url('/save-drug-dose')}}',
                type: 'POST',
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $.Notification.notify('success', 'top right', data[0], data[1]);
                    $(this).formReset($("#addDrugDoseForm"));
                    $("#add-drug-dose").modal('toggle');
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
        
        $.fn.getDrugDoseDetails = function (id) {
            $.get('/api/get-drug-dose-details/'+id,function (data) {
//                console.log(data);
                $("#input_update_dose").val(data.dose);
                $("#checkbox_dose_status").prop('checked',data.status == 1 ? true : false);
                $(this).setDoseId(data.id);
            })
        };

        $.fn.setDoseId = function (id) {
            updateDrugDose = id;
        }

        $("#updateDrugDoseForm").on('submit',function (e) {
            e.preventDefault();
            var data = new FormData(this);
            $.ajax({
                url: '{{url('/update-drug-dose')}}'+'/'+updateDrugDose,
                type: 'POST',
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $.Notification.notify('success', 'top right', data[0], data[1]);
                    $(this).formReset($("#updateDrugDoseForm"));
                    $("#edit-drug-dose").modal('toggle');
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

        @if(session('drug_dose_delete'))
            $.Notification.notify('success','top right','Drug dose Deleted','Drug dose has been deleted successfully');
        @endif
    })
</script>