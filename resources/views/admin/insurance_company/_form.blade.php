
<div class="input-group input-group-lg">
    <span class="input-group-addon">
        {{ Form::label('Parent Branch ') }} :
    </span>
    <div class="form-line">
        {!! Form::select('parent_id', dataForm()->getParentLab()->prepend('Select parent branch', 0) ,null , ['class' => 'form-control parentGetAjaxData' , 'data-from' => env('ADMIN_PREFIX') . '/data/labInfo/']) !!}
    </div>
    @include('admin.partial._row_error', ['input' => 'phone'])
</div>


<h2><b>Language Data</b></h2>
@foreach( config('laravellocalization.supportedLocales') as $key=>$row )
    <div class="col-sm-6">
        <br>
        <div class="input-group input-group-lg">
            <span class="input-group-addon">
                {{ Form::label('name ' . $key) }} :
            </span>
            <div class="form-line">
                {!! Form::text($key.'[name]', isset($item)?$item->translate($key)->name:'' , ['class' => 'form-control']) !!}
            </div>
            @include('admin.partial._row_error', ['input' => $key.'.name'])
        </div>
        <div class="form-group">
            <div class="form-line">
                {{ Form::label('excerpt ' . $key) }} :
                {{ Form::textarea($key.'[excerpt]', isset($item)?$item->translate($key)->excerpt:'', array_merge(['class' => 'form-control', 'placeholder' => 'excerpt', 'rows'=>2 ])) }}
            </div>
            <small>display in list not show in unit</small>
            @include('admin.partial._row_error', ['input' => $key.'.content'])
        </div>
        <div class="form-group">
            <div class="form-line">
                {{ Form::label('description ' . $key) }} :
                {{ Form::textarea($key.'[description]', isset($item)?$item->translate($key)->description:'', array_merge(['class' => 'form-control tinymce', 'placeholder' => 'Description' ])) }}
            </div>
            @include('admin.partial._row_error', ['input' => $key.'.content'])
        </div>

        <div class="input-group input-group-lg">
            <div class="input-group-addon">
                {{ Form::label('address ' . $key ) }} :

            </div>
            <div class="form-line">
                {{ Form::textarea($key. '[address]', isset($item)?$item->translate($key)->address:'', array_merge(['class' => 'form-control', 'placeholder' => 'address', 'rows'=>2 ])) }}
            </div>
            <small>display in list not show in unit</small>
            @include('admin.partial._row_error', ['input' => $key.'.address'])
        </div>

    </div>
@endforeach

<h2><b>Other Data : </b></h2>
<div class="col-sm-12">
    <br>
    @include('admin.partial._form_image', ['input' => 'image', 'label' => 'Logo', 'path' => 'insurance_companies'])

    <div class="input-group input-group-lg">
        <span class="input-group-addon">
            {{ Form::label('Phones ') }} :
        </span>
        <div class="form-line">
            {!! Form::text('phone', null, ['class' => 'form-control']) !!}

        </div>
        <small>separate between numbers using "/" </small>
        @include('admin.partial._row_error', ['input' => 'phone'])
    </div>

    @include('admin.partial._locationInpts', [])



    <div class="form-group">
        @include('admin.partial._form_switch', ['input' => 'is_active', 'label' => 'is active'])
    </div>
    @include('admin.partial._form_submit')
</div>