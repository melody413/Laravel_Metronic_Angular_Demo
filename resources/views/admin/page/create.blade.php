@extends('admin.layout')

@section('content')

    {!! Form::open(['route' => 'admin.page.store', 'method' => 'post'], ['enctype' => "multipart/form-data"]) !!}
    <div class="col-sm-9">
        @admin_block
        @slot('desc')
            Create Dynamic Pages Like (About Us)
        @endslot
        @slot('content')
            <div class="col-sm-12">
                <div class="form-group">

                    @include('admin.page._form')

                </div>
            </div>
        @endslot
        @endadmin_block
    </div>

    <div class="col-sm-3">
        @admin_block
        @slot('title')
            Options
        @endslot

        @slot('content')
            <div class="col-sm-12">
                <div class="form-group">
                    @include('admin.partial._form_image', ['input' => 'image', 'label' => 'image', 'path' => 'pages'])

                    @include('admin.partial._form_switch', ['input' => 'is_active', 'label' => 'is active'])

                    @include('admin.partial._form_submit')
                </div>
            </div>
        @endslot
        @endadmin_block
    </div>

    {!! Form::close() !!}
@stop