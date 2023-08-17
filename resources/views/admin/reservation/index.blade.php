@extends('admin.layout')

@section('content')
    @admin_block
    @slot('desc')
        List Reservation
    @endslot
    @slot('menu')
        {{--@include('admin.partial._create_new_button')--}}
    @endslot
    @slot('content')
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover dataTable dataTableAjax" searching="true" data-url="{{ route('admin.reservation.index') }}">
                    <thead>
                    <tr>
                        <th name="id" orderable="1">ID#</th>
                        <th name="id" orderable="1" data-type="html">Doctor</th>
                        <th name="id" orderable="1">Patient info</th>
                        <th name="id" orderable="1">Reservation Date && Time</th>
                        <th name="id" orderable="1">Address</th>
                        <th name="title" >Reserve at</th>
                        <th name="Actions" width="20%">Actions</th>
                    </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>
        </div>
    @endslot
    @endadmin_block

@stop

@include('admin.partial._dataTableJs')
