@extends('admin.layout')

@section('content')

    @admin_block
    @slot('desc')
    @endslot
    @slot('menu')
        @include('admin.partial._create_new_button', ['routeParams' => ['id' => $id]])
    @endslot
    @slot('content')
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover dataTable dataTableAjax" searching="true"
                       data-url="{{ route('admin.doctor_branch.index', ['id' => $id]) }}">
                    <thead>
                    <tr>
                        <th name="id" orderable="1">ID#</th>
                        <th name="user_name" >Address Ar</th>
                        <th name="user_name" >Phones</th>
                        <th name="user_name" >Business day</th>
                        <th name="user_name" >Time Start</th>
                        <th name="user_name" >Time End</th>
                        <th name="title" >Price</th>
                        <th name="title" >Date</th>

                        @if(isset($hasListAction))
                            <th name="Actions" width="20%">Actions</th>
                        @endif

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
