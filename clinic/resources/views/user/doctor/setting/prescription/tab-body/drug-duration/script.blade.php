<script>
    $(document).ready(function () {

        $("#durationTable").dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ url('/api/data-table/all-drug-duration') }}",
            "columns": [
                { "data" : "#"},
                { "data": "duration" },
                { "data": "status" },
                { "data": "created_at" },
                { "data": "actions" }
            ]
        });

        var updateDrugDurationId = null;
        $('#newDrugDurationForm').on('submit',function (e) {
            e.preventDefault();
            var data = new FormData(this);
            $.ajax({
                url: '{{url('/save-drug-duration')}}',
                type: 'POST',
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $.Notification.notify('success', 'top right', data[0], data[1]);
                    $(this).formReset($("#newDrugDurationForm"));
                    $("#add-drug-duration").modal('toggle');
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

        $("#updateDrugDurationForm").on('submit',function (e) {
            e.preventDefault();
            var data = new FormData(this);
            $.ajax({
                url: '{{url('/update-drug-duration')}}'+'/'+updateDrugDurationId,
                type: 'POST',
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $.Notification.notify('success', 'top right', data[0], data[1]);
                    $("#edit-drug-duration").modal('toggle');
                    $(this).formReset($("#updateDrugDurationForm"));
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

        $.fn.getDrugDurationDetails = function (id) {
            $.get('/api/get-drug-duration-details/'+id,function (data) {
               $(this).setDrugDurationId(data.id);
               $("#input_drug_duration").val(data.duration);
               $("#drug_duration_status").prop('checked',data.status ==1 ? true : false);
            });
        };

        $.fn.setDrugDurationId = function (id) {
            updateDrugDurationId = id;
        }

        @if(session('delete_drug_duration'))
                $.Notification.notify('success','top right','Drug duration Deleted','Drug duration has been deleted successfully');
        @endif
    })
</script>