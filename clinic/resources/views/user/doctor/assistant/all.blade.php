@extends('layouts.app')

@section('title')
    All Assistant
@endsection

@section('extra-css')
    <link rel="stylesheet" href="{{url('/dashboard/plugins/datatables/datatable.min.css')}}">
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header card-header-icon">
                <i class="fa fa-user-circle-o fa-2x"></i>
            </div>
            <div class="card-content">
                <h4 class="card-title">All Assistant</h4>
            </div>
            <table class="table table-striped" id="datatable">
                <thead>
                <tr>
                    <th width="5px">#</th>
                    <th width="120px">Photo</th>
                    <th>Name & Email</th>
                    <th>info</th>
                    <th>Status</th>
                    <th width="100px">Action</th>
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
                "ajax": "{{ route('assistant.datatable') }}",
                "columns": [
                    { "data" : "#"},
                    { "data": "image" },
                    { "data": "name" },
                    { "data": "address" },
                    { "data": "status" },
                    { "data": "action" }
                ],
                oLanguage: {
                    oPaginate: {
                        sNext: '<span class="pagination-default"></span><span class="pagination-fa"><i class="fa fa-chevron-right" ></i></span>',
                        sPrevious: '<span class="pagination-default"></span><span class="pagination-fa"><i class="fa fa-chevron-left" ></i></span>'
                    },
                    sProcessing : '<div class="loading-bro"><h1>Loading</h1><svg id="load" x="0px" y="0px" viewBox="0 0 150 150"><circle id="loading-inner" cx="75" cy="75" r="60"/></svg></div>'
                }
            });
            @if(session('delete_assistant'))
                    $.Notification.notify('success','top right','Assistant Deleted','Assistant has been deleted');
            @endif
            @if(session('delete_fail'))
                    $.Notification.notify('error','top right','Assistant cannot Deleted','This assistant makes appointment.' +
                    ' you cannot delete this assistant but you can disable this account');
            @endif
        });
    </script>
@endsection