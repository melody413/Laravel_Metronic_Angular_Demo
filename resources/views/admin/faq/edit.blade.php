@extends('admin.layout')

@section('content')
    {!! Form::model($item, array('route' => array('admin.faq.store'), 'enctype' => "multipart/form-data" ) ) !!}
    <div class="col-sm-9">
        @admin_block
        @slot('desc')
            Create Dynamic Pages Like (About Us)
        @endslot
        @slot('content')
            <div class="col-sm-12">
                <div class="form-group">

                        @include('admin.faq._form')
                    {!! Form::hidden('item_id', $item->id) !!}

                </div>
            </div>
        @endslot
        @endadmin_block
    </div>

    <div class="col-sm-12">
        @admin_block
            @slot('title')
                Options
            @endslot

            @slot('content')
                <div class="col-sm-12">
                    <div class="form-group">
                        <!-- @include('admin.partial._form_image', ['input' => 'image', 'label' => 'image', 'path' => 'faqs']) -->

                        @include('admin.partial._form_switch', ['input' => 'is_active', 'label' => 'is active'])

                        @include('admin.partial._form_submit')
                    </div>
                </div>
            @endslot
        @endadmin_block
    </div>

    {!! Form::close() !!}
@stop