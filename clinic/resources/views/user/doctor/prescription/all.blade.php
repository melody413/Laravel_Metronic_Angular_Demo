@extends('layouts.app')

@section('title')
    All Prescription
@endsection

@section('extra-css')
    <link rel="stylesheet" href="{{url('/dashboard/plugins/datatables/datatable.min.css')}}">
@endsection

@section('content')
    <div class="card">
        <div class="card-header card-header-icon">
            <i class="ti-write" style="font-size: 30px;"></i>
        </div>
        <div class="card-content">
            <h4 class="card-title">All Prescription</h4>
        </div>
        <table class="table table-striped" id="datatable">
            <thead>
            <tr>
                <th width="5px">#</th>
                <th>Date</th>
                <th>Patient</th>
                <th width="25px">Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection

@section('extra-js')
    <script src="{{url('/dashboard/plugins/datatables/datatable.min.js')}}"></script>
    <script>
        $(document).ready( function () {
            $('#datatable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ url('/api/data-table/all-prescription/'.auth()->user()->id ) }}",
                "columns": [
                    { "data" : "#"},
                    { "data": "created_at" },
                    { "data": "patient_id" },
                    { "data" : "action"}
                ]
            });
        });
    </script>
@endsection