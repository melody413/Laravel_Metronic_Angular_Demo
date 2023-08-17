@extends('layouts.app')

@section('title')
    Schedule
@endsection

@section('extra-css')
    <link rel="stylesheet" href="{{url('/dashboard/plugins/datatables/datatable.min.css')}}">
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header card-header-icon">
                <i class="fa fa-calendar fa-2x"></i>
            </div>
            <div class="card-content">
                <a href="{{url('/new-schedule')}}" class="btn btn-success pull-right">New Schedule</a>
                <h4 class="card-title">My Schedule</h4>
            </div>
            <table class="table table-striped" id="datatable">
                <thead>
                <tr>
                    <th width="5px">#</th>
                    <th>Title</th>
                    <th>Address</th>
                    <th>Contact person</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Days / Time</th>
                    <th width="25px">Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('extra-js')

    <script src="{{url('/dashboard/plugins/datatables/datatable.min.js')}}"></script>
    <script>
        $(document).ready( function () {
            $('#datatable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ url('/api/data-table/my-schedule') }}",
                "columns": [
                    { "data": "#"},
                    { "data": "name" },
                    { "data": "address" },
                    { "data": "contact_person_name" },
                    { "data": "phone" },
                    { "data": "email" },
                    { "data": "model" },
                    { "data": "action" }
                ],

            });

            $.fn.getScheduleDetails = function (id) {
//                console.log("data" +id);
                $.get('/api/get-schedule-details/'+id,function (data) {
                    $("#scheduleHead").text(data.name);
                    $("#renderHear").empty();
                    $.each(data.date_time,function (key,data) {
                        $("#renderHear").append(
                            $("<tr>").append(
                                $("<td>",{text:data.days}),
                                $("<td>",{text:data.start_time}),
                                $("<td>",{text:data.end_time})
                            )
                        )
                    });

                })
            }

            @if(session('schedule_delete'))
                $.Notification.notify('success','top right','Schedule Place deleted','Schedule place deleted successfully');
            @endif

            @if(session('schedule_delete_fail'))
            $.Notification.notify('error','top right','Schedule Place cannot deleted','This schedule place is uses by many appointment.');
            @endif

        });
    </script>
@endsection