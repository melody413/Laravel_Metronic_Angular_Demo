<script>
    $(document).ready(function () {

        var updateStrengthId = null;
        $("#strengthTable").dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ url('/api/data-table/all-drug-strength') }}",
            "columns": [
                { "data" : "#"},
                { "data": "strength" },
                { "data": "status" },
                { "data": "created_at" },
                { "data": "actions" }
            ]
        });



        $('#saveDrugStrength').on('submit',function (e) {
            e.preventDefault();
            var data = new FormData(this);
            $.ajax({
                url: '{{url('/save-drug-strength')}}',
                type: 'POST',
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $.Notification.notify('success', 'top right', data[0], data[1]);
                    $(this).formReset($("#drugTypeForm"));
                    $("#add-drug-strength").modal('toggle');
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

        $.fn.getDrugStrengthDetails = function (id) {
            console.log(id);
            $.get('/api/get-drug-strength-details/'+id,function (data) {
                $("#input_drug_strength").val(data.strength);
                $("#checkbox_strength_status").prop('checked',data.status ==1 ? true : false);
                $(this).setStrengthId(data.id)
            });
        };

        $.fn.setStrengthId = function (id) {
            updateStrengthId = id;
        }

        $("#updateDrugStrength").on('submit',function (e) {
            e.preventDefault();
            var data = new FormData(this);
            $.ajax({
                url: '{{url('/update-drug-strength')}}/'+updateStrengthId,
                type: 'POST',
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $.Notification.notify('success', 'top right', data[0], data[1]);
                    $(this).formReset($("#drugTypeForm"));
                    $("#edit-drug-strength").modal('toggle');
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

        @if(session('delete_strength'))
            $.Notification.notify('success','top right','Drug Strength Deleted','Drug strength has been deleted successfully');
        @endif

    });
</script>