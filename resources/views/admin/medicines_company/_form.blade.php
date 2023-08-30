<h2><b>Name</b></h2>
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
        <div class="form-group hidden">
            <div class="form-line">
                {{ Form::label('excerpt ' . $key) }} :
                {{ Form::textarea($key.'[excerpt]', isset($item)?$item->translate($key)->excerpt:'', array_merge(['class' => 'form-control', 'placeholder' => 'excerpt', 'rows'=>2 ])) }}
            </div>
            <small>display in list not show in unit</small>
            @include('admin.partial._row_error', ['input' => $key.'.content'])
        </div>
        <div class="form-group hidden">
            <div class="form-line">
                {{ Form::label('description ' . $key) }} :
                {{ Form::textarea($key.'[description]', isset($item)?$item->translate($key)->description:'', array_merge(['class' => 'form-control tinymce', 'placeholder' => 'Description' ])) }}
            </div>
            @include('admin.partial._row_error', ['input' => $key.'.content'])
        </div>

    </div>
@endforeach

<div class="col-sm-12">

    <div class="input-group input-group-lg">
        <span class="input-group-addon">
            {{ Form::label('phone') }} :
        </span>
        <div class="form-line">
            {!! Form::text('phone', null, ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'phone'])
    </div>
    <div class="input-group input-group-lg">
        <span class="input-group-addon">
            {{ Form::label('facebook') }} :
        </span>
        <div class="form-line">
            {!! Form::text('facebook', null, ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'facebook'])
    </div>
    <div class="input-group input-group-lg">
        <span class="input-group-addon">
            {{ Form::label('twitter') }} :
        </span>
        <div class="form-line">
            {!! Form::text('twitter', null, ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'twitter'])
    </div>
    <div class="input-group input-group-lg">
        <span class="input-group-addon">
            {{ Form::label('instagram') }} :
        </span>
        <div class="form-line">
            {!! Form::text('instagram', null, ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'instagram'])
    </div>
    <div class="input-group input-group-lg">
        <span class="input-group-addon">
            {{ Form::label('youtube') }} :
        </span>
        <div class="form-line">
            {!! Form::text('youtube', null, ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'youtube'])
    </div>
    <div class="input-group input-group-lg">
        <span class="input-group-addon">
            {{ Form::label('website') }} :
        </span>
        <div class="form-line">
            {!! Form::text('website', null, ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'website'])
    </div>
    <div class="form-group">
        <span class="col-sm-1">{{ Form::label('Country ') }} :</span>
        <div class="col-sm-11">
            {!! Form::select('country_id', dataForm()->getCountries() ,null , ['class' => 'form-control show-tick bsGetAjaxData','id'=> 'bsCountryId']) !!}
            @include('admin.partial._row_error', ['input' => 'country_id'])
        </div>
    </div>

    <div class="input-group input-group-lg">
        <span class="input-group-addon">
            {{ Form::label('City ') }} :
        </span>
        <div class="form-line">
            {!! Form::select('city_id', [] ,null , ['class' => 'form-control bsGetAjaxData', 'id' => 'bsCityies', 'data-val' => isset($item->city_id)?$item->city_id:'']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'city_id'])
    </div>

    <div class="input-group input-group-lg">
        <span class="input-group-addon">
            {{ Form::label('Area ') }} :
        </span>
        <div class="form-line">
            {!! Form::select('area_id', [] ,null , ['class' => 'form-control bsGetAjaxData', 'id' => 'bsAreas', 'data-val' => isset($item->area_id)?$item->area_id:'']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'area_id'])
    </div>
    @include('admin.partial._form_image', ['input' => 'image', 'label' => 'image', 'path' => 'medicines_company'])

    <div class="form-group">
        @include('admin.partial._form_switch', ['input' => 'is_active', 'label' => 'is active'])
    </div>
    @include('admin.partial._form_submit')
</div>
