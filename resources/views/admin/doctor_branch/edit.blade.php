@extends('admin.layout')

@section('content')
    {!! Form::model($item, array('route' => array('admin.doctor_branch.store'), 'enctype' => "multipart/form-data" ) ) !!}
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
                        @include('admin.doctor_branch._form')
                        {!! Form::hidden('item_id', $item->id) !!}
                    </div>
                </div>
            @endslot
            @endadmin_block
        </div>
    {!! Form::close() !!}
@stop
