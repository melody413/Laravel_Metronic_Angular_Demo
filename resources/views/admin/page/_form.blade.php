
<h2><b>Language Data</b></h2>
@foreach( config('laravellocalization.supportedLocales') as $key=>$row )
    <div class="col-sm-6">
            <br>
            <div class="input-group input-group-lg">
                    <span class="input-group-addon">
                        {{ Form::label('title ' . $key) }} :
                    </span>
                <div class="form-line">
                    {!! Form::text($key.'[title]', isset($item)?$item->translate($key)->title:'' , ['class' => 'form-control']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => $key.'.title'])
            </div>
            <div class="form-group">
                <div class="form-line">
                    {{ Form::label('Content ' . $key) }} :
                    {{ Form::textarea($key.'[content]', isset($item)?$item->translate($key)->content:'', array_merge(['class' => 'form-control tinymce', 'placeholder' => 'Content' ])) }}
                </div>
                @include('admin.partial._row_error', ['input' => $key.'.content'])
            </div>
            <div class="form-group">
                <div class="form-line">
                    {{ Form::label('Meta title ' . $key) }} :
                    {{ Form::textarea($key.'[meta_title]', isset($item)?$item->translate($key)->meta_title:'', array_merge(['class' => 'form-control', 'rows'=>2])) }}
                </div>
                @include('admin.partial._row_error', ['input' => $key.'.meta_title'])
            </div>
            <div class="form-group">
                <div class="form-line">
                    {{ Form::label('Meta description ' . $key) }} :
                    {{ Form::textarea($key.'[meta_description]', isset($item)?$item->translate($key)->meta_description:null, array_merge(['class' => 'form-control', 'rows'=>2])) }}
                </div>
                @include('admin.partial._row_error', ['input' => $key.'.meta_description'])
            </div>
            <div class="form-group">
                <div class="form-line">
                    {{ Form::label('Meta keywords ' . $key) }} :
                    {{ Form::textarea($key.'[meta_keywords]', isset($item)?$item->translate($key)->meta_keywords:'', array_merge(['class' => 'form-control', 'rows'=>2])) }}
                </div>
                @include('admin.partial._row_error', ['input' => $key.'.meta_keywords'])
            </div>

    </div>
@endforeach

<h2><b>Other Data : </b></h2>
<div class="col-sm-12">
    <br>
    <div class="input-group input-group-lg error">
            <span class="input-group-addon">
                {{ Form::label('slug') }} :
            </span>
        <div class="form-line">
            {!! Form::text('slug', null, ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'slug'])
    </div>
    <div class="form-group">
        @include('admin.partial._form_image', ['input' => 'image', 'label' => 'image', 'path' => 'pages'])

        @include('admin.partial._form_switch', ['input' => 'is_active', 'label' => 'is active'])

    </div>
    @include('admin.partial._form_submit')

</div>
