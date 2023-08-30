@extends('layouts.app')

@section('title')
    All Drug
@endsection

@section('extra-css')
    <link rel="stylesheet" href="{{url('/dashboard/plugins/datatables/datatable.min.css')}}">

@endsection

@section('breadcrumb')
    <li class="float-left">
        <a href="{{url('/')}}" class="">Home</a>&nbsp;/&nbsp;
    </li>
    <li class="float-left">
        Drug / &nbsp;
    </li>
    <li class="float-left">
        <a href="{{url('/all-drug')}}" class="">All Drug</a>
    </li>
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header card-header-icon">
                <i class="icon icon-pill"></i>
            </div>
            <div class="card-content">
                <h4 class="card-title">All Drug</h4>
            </div>

            <table class="table table-striped table-bordered" id="datatable">
                <thead>
                <tr>
                    <th width="5px">#</th>
                    <th>Name</th>
                    <th>Form</th>
                    <th>Made in</th>
                    <th>concentration</th>
                    {{-- <th width="25px">Action</th> --}}
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
                // "ajax": "{{ route('drug.datatable') }}",
                "ajax": "https://doctorak.com/eg/medicinesForClinic",
                "crossDomain": true,
                "columns": [
                    { "data" : "id" },
                    { "data": "name" },
                    { "data": "form" },
                    { "data" : "made_in"},
                    { "data": "concentration" }
                    // { "data" : "action"}
                ]
            });

            @if(session('delete_drug'))
                $.Notification.notify('success','top right','Drug deleted','Drug has been deleted successfully');
            @endif
            @if(session('delete_fail'))
                $.Notification.notify('error','top right','Delete Failed','We cannot delete the durg, coz it is used in temllate or prescription');
            @endif
        });
    </script>
@endsection