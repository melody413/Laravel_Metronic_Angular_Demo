@extends('admin.layout')

@section('content')
    {!! Form::model($item, ['route' => 'admin.reservation.store', 'method' => 'post' , 'files' => true]) !!}
        <div class="col-sm-12">
            @admin_block
            @slot('desc')

            @endslot
            @slot('menu')
                @isset($item)
                    <div class="row clearfix">
                        <div class="col-md-12">

                        </div>
                    </div>
                @endisset
            @endslot
            @slot('content')
                <div class="col-sm-12">
                    <div class="form-group">
                        @include('admin.reservation._form')
                        {!! Form::hidden('item_id', $item->id) !!}
                    </div>
                </div>
            @endslot
            @endadmin_block

        </div>
    {!! Form::close() !!}
@stop
