@extends('layouts.app')

@section('title')
    Prescription templated
@endsection

@section('extra-css')
    <link rel="stylesheet" href="{{url('/dashboard/plugins/datatables/datatable.min.css')}}">
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header card-header-icon">
                <i class="fa fa-file-o fa-2x"></i>
            </div>
            <div class="card-content">
                <h4 class="card-title">All Template</h4>
            </div>
            <table class="table table-striped" id="datatable">
                <thead>
                <tr>
                    <th width="5px">#</th>
                    <th>Name</th>
                    <th>Note</th>
                    <th>Drugs</th>
                    <th>Total Use</th>
                    <th>Date</th>
                    <th>Status</th>
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
                "ajax": "{{ route('template.datatable', auth()->user()->id) }}",
                "columns": [
                    { "data" : "#"},
                    { "data": "name" },
                    { "data": "note" },
                    { "data": "total_drug" },
                    { "data": "total_use" },
                    { "data": "created_at" },
                    { "data": "status" },
                    { "data": "action" }
                ]
            });
            @if(session('delete_template'))
                $.Notification.notify('success','top right','Template deleted','Template has been deleted');
            @elseif(session('delete_fail'))
                $.Notification.notify('error','top right','Delete Failed','We cannot delete this template due to use in prescription');
            @endif
        });
    </script>
@endsection