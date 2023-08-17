@extends('layouts.app')

@section('title')
    All Patient
@endsection

@section('extra-css')
    <style>
        .pagination {

        }

        .pagination li {

        }

        .pagination li.disabled {
            color: #868e96;
            pointer-events: none;
            background-color: #fff;
            border-color: #ddd;
            margin-left: 0;

        }

        .pagination li.active > span {
            background-color: orangered;
            border: 1px solid orangered;
            color: #ffffff;
            font-size: 1rem;
            border-radius: 50%;
            padding: 5px 10px;
            margin: 0px 5px;
        }

        .pagination li.active > span:hover {
            background-color: orangered;
            border-color: orangered;
        }

        .pagination li a {
            font-size: 1rem;
            padding: 5px 10px;
            border: 1px solid orangered;
            margin: 0px 5px;
            border-radius: 50%;
            color: orangered;

        }

        .pagination li:last-child a {

        }

        .pagination li:first-child a {

        }
    </style>

@endsection

@section('content')
    <div class="card">
        <div class="card-header card-header-icon">
            <i class="fa fa-users fa-2x"></i>
        </div>
        <div class="card-content">
            <h4 class="card-title">All Patient</h4>
        </div>
        <form class="row" action="{{ url('all-patient') }}" method="get">
            <div class="col-md-2">
                <div class="form-group-custom">
                    <select name="paginate">
                        <option {{ request()->query('paginate') == 10 ? 'selected' : '' }} value="10">10</option>
                        <option {{ request()->query('paginate') == 20 ? 'selected' : '' }} value="20">20</option>
                        <option {{ request()->query('paginate') == 50 ? 'selected' : '' }} value="50">50</option>
                        <option {{ request()->query('paginate') == 100 ? 'selected' : '' }} value="100">100</option>
                    </select>
                    <label class="control-label">Show</label><i class="bar"></i>
                </div>
            </div>

            <div class="col-md-5">

            </div>

            <div class="col-md-3">
                <div class="form-group-custom">
                    <input placeholder="Search" type="text" name="search_string"
                           value="{{ request()->query('search_string') }}"/>
                    <label class="control-label">Search String</label><i class="bar"></i>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group-custom">
                    <select name="order">
                        <option {{ request()->query('order') == 'DESC' ? 'selected' : '' }} value="DESC">Z - A</option>
                        <option {{ request()->query('order') == 'ASC' ? 'selected' : '' }} value="ASC">A - Z</option>
                    </select>
                    <label class="control-label">Order</label><i class="bar"></i>
                </div>
            </div>

            <div class="col-md-1">
                <button type="submit" class="btn btn-default">Search</button>
            </div>

        </form>
        <table class="table table-striped" id="datatable">
            <thead>
            <tr>
                <th width="5px">#</th>
                <th>Patient Pic</th>
                <th>Patient Info</th>
                <th>Contact Info</th>
                <th>Medical Info</th>
                {{--<th>Status</th>--}}
                <th width="25px">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($patients as $key=>$patient)
                <tr>
                    <td>{{ $key + $patients->firstItem() }}</td>
                    <td>@include('user.doctor.patient.datatable.image',['image' => $patient->image])</td>
                    <td>@include('user.doctor.patient.datatable.patient-info')</td>
                    <td>@include('user.doctor.patient.datatable.contact-info')</td>
                    <td>@include('user.doctor.patient.datatable.medical-info')</td>
                    <td>@include('user.doctor.patient.datatable.actions', ['id' => $patient->id])</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="col-md-4">
                <h4>Showing {{ $patients->firstItem() }} to {{ $patients->lastItem() }} out
                    of {{ $patients->total() }}</h4>
            </div>
            <div class="col-md-8">
                <div class="pull-right">
                    {{ $patients->appends(request()->query())->links() }}
                </div>

            </div>
        </div>

    </div>
@endsection

@section('extra-js')
    {{--    <script src="{{url('/dashboard/plugins/datatables/datatable.min.js')}}"></script>--}}
    {{--    <script>--}}
    {{--        $(document).ready( function () {--}}
    {{--            $('#datatable').DataTable({--}}
    {{--                "processing": true,--}}
    {{--                "serverSide": true,--}}
    {{--                "ajax": "{{ url('/api/data-table/all-patient') }}",--}}
    {{--                "columns": [--}}
    {{--                    { "data" : "#"},--}}
    {{--                    { "data": "image" },--}}
    {{--                    { "data": "patient_info" },--}}
    {{--                    { "data": "contact_info" },--}}
    {{--                    { "data": "medical_info" },--}}
    {{--                    { "data" : "actions"}--}}
    {{--                ],--}}
    {{--                oLanguage: {--}}
    {{--                    oPaginate: {--}}
    {{--                        sNext: '<span class="pagination-default"></span><span class="pagination-fa"><i class="fa fa-chevron-right" ></i></span>',--}}
    {{--                        sPrevious: '<span class="pagination-default"></span><span class="pagination-fa"><i class="fa fa-chevron-left" ></i></span>'--}}
    {{--                    },--}}
    {{--                    sProcessing : '<div class="loading-bro"><h1>Loading</h1><svg id="load" x="0px" y="0px" viewBox="0 0 150 150"><circle id="loading-inner" cx="75" cy="75" r="60"/></svg></div>'--}}
    {{--                }--}}

    {{--            });--}}

    {{--            @if(session('delete_patient'))--}}
    {{--                $.Notification.notify('success','top right',"Patient deleted",'Patient has been deleted successfully');--}}
    {{--            @endif--}}
    {{--        });--}}
    {{--    </script>--}}
@endsection