@extends('admin.layout')

@section('content')
    {!! Form::open(['route' => 'admin.doctor_branch.store', 'method' => 'post'], ['enctype' => "multipart/form-data"]) !!}
    <div class="col-sm-12">
        @admin_block
        @slot('desc')

        @endslot
        @slot('content')
            <div class="col-sm-12">
                <div class="form-group">

                    @include('admin.doctor_branch._form')
                    {!! Form::hidden('doctor_id', $doctor->id) !!}
                </div>
            </div>
        @endslot
        @endadmin_block
    </div>
    {!! Form::close() !!}
@stop
