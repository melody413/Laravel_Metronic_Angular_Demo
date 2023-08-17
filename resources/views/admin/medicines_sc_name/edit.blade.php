@extends('admin.layout')

@section('content')
    {!! Form::model($item, array('route' => array('admin.medicines_sc_name.store'), 'enctype' => "multipart/form-data" ) ) !!}
        <div class="col-sm-12">
            @admin_block
            @slot('desc')

            @endslot
            @slot('menu')
                @isset($item)
                    <div class="row clearfix">
                        <div class="col-md-12">
                            @include('admin.partial._delete_button')
                            {{--<a href="{{ route('admin.medicines_sc_name.copy', ['id' => $item->id]) }}" class="btn bg-orange waves-effect">
                                <i class="material-icons">content_copy</i>
                                Copy
                            </a>--}}
                        </div>
                    </div>
                @endisset
            @endslot
            @slot('content')
                <div class="col-sm-12">
                    <div class="form-group">
                        @include('admin.medicines_sc_name._form')
                        {!! Form::hidden('item_id', $item->id) !!}
                    </div>
                </div>
            @endslot
            @endadmin_block
        </div>
    {!! Form::close() !!}
@stop