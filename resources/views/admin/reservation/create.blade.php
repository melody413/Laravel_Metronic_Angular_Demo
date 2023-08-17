@extends('admin.layout')

@section('content')

    {!! Form::open(['route' => 'admin.reservation.store', 'method' => 'post' , 'files' => true]) !!}
    <div class="col-sm-12">
        @admin_block
        @slot('desc')

        @endslot
        @slot('content')
            <div class="col-sm-12">
                <div class="form-group">

                    @include('admin.reservation._form')

                </div>
            </div>
        @endslot
        @endadmin_block
    </div>



    {!! Form::close() !!}
@stop
