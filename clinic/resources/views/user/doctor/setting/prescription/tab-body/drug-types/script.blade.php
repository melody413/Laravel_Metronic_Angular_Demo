<script>
    $(document).ready(function () {
        var updateId = null;

        $("#typeTable").dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ url('/api/data-table/all-drug-types') }}",
            "columns": [
                { "data" : "#"},
                { "data": "type" },
                { "data": "status" },
                { "data": "created_at" },
                { "data" : "actions"}
            ]
        });

        $("#saveDrugType").on('click', function () {
            $("#drugTypeForm").submit();
        });


        $("#drugTypeForm").on('submit', function (e) {
            e.preventDefault();
            console.log('Submit');
            var data = new FormData(this);
            $.ajax({
                url: '{{url('/save-drug-type')}}',
                type: 'POST',
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $.Notification.notify('success', 'top right', data[0], data[1]);
                    $(this).formReset($("#drugTypeForm"));
                    $("#add-drug-type").modal('toggle');
                }, error: function (data) {
                    if (data.status == 422) {
                        $(this).showValidationError(data);
                    }
                    else {
                        $(this).showServerError();
                    }
                }
            });
            $("#loading").hide();
        });

        $.fn.getDrugTypeDetails = function (id) {
          $.get('/api/get-drug-type-details/'+id,function (data) {
              $("#input_drug_type").val(data.type);
              $("#drug_type_status").prop('checked',data.status ==1 ? true : false);
              $(this).setUpdateId(data.id);
          })
        };

        $("#updateDrugType").on('click', function () {
            $("#updateTypeForm").submit();
        });

        $("#updateTypeForm").on('submit',function (e) {
            e.preventDefault();
            var data = new FormData(this);
            $.ajax({
                url: '/update-drug-type/'+updateId,
                type: 'POST',
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $.Notification.notify('success', 'top right', data[0], data[1]);
                    $(this).formReset($("#drugTypeForm"));
                    $("#edit-drug-type").modal('toggle');
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


        $.fn.setUpdateId = function (id) {
            updateId = id;
        }

        @if(session('delete_drug_type'))
            $.Notification.notify('success','top right','Drug Type Deleted','Drug type has been deleted successfully');
        @endif
        @if(session('delete_fail'))
            $.Notification.notify('error','top right','Drug Type cannot delete','Something went wrong');
        @endif

    })
</script>