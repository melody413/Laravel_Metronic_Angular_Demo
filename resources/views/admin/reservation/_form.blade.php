

<h2><b>Language Data</b></h2>
@foreach( config('laravellocalization.supportedLocales') as $key=>$row )
    <div class="col-sm-6">
        <br>
        <div class="input-group input-group-lg">
            <span class="input-group-addon">
                {{ Form::label('reservation name ' . $key) }} :
            </span>
            <div class="form-line">
                {!! Form::text($key.'[name]', isset($item)?$item->translate($key)->name:'' , ['class' => 'form-control']) !!}
            </div>
            @include('admin.partial._row_error', ['input' => $key.'.name'])
        </div>
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
                {{ Form::label('excerpt ' . $key) }} :
                {{ Form::textarea($key.'[excerpt]', isset($item)?$item->translate($key)->excerpt:'', array_merge(['class' => 'form-control', 'placeholder' => 'excerpt', 'rows'=>2 ])) }}
            </div>
            <small>display in list not show in unit</small>
            @include('admin.partial._row_error', ['input' => $key.'.excerpt'])
        </div>
        <div class="form-group">
            <div class="form-line">
                {{ Form::label('description ' . $key) }} :
                {{ Form::textarea($key.'[description]', isset($item)?$item->translate($key)->description:'', array_merge(['class' => 'form-control tinymce', 'placeholder' => 'Description' ])) }}
            </div>
            @include('admin.partial._row_error', ['input' => $key.'.content'])
        </div>
    </div>
@endforeach

<h2><b>Other Data : </b></h2>
<div class="col-sm-12">
    <br>
    @include('admin.partial._form_image', ['input' => 'image', 'label' => 'image', 'path' => 'reservations'])

    @include('admin.partial._image_gallery_field', ['input' => 'image_gallery', 'label' => 'Gallery', 'path' => 'hospitals'])

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

    <div class="input-group input-group-lg">
        <span class="input-group-addon">
            {{ Form::label('gender ') }} :
        </span>
        <div class="form-line">
            {!! Form::select('gender', dataForm()->getGender() , null , ['class' => 'form-control ']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'gender'])
    </div>

    <div class="input-group input-group-lg error">
            <span class="input-group-addon">
                {{ Form::label('wait time') }} :
            </span>
        <div class="form-line">
            {!! Form::text('wait_time', null, ['class' => 'form-control']) !!}
        </div>
        <small>Time per Minuets ex: 45 </small>
        @include('admin.partial._row_error', ['input' => 'wait_time'])
    </div>

    <div class="input-group input-group-lg error">
            <span class="input-group-addon">
                {{ Form::label('price') }} :
            </span>
        <div class="form-line">
            {!! Form::text('price', null, ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'price'])
    </div>

    <div class="input-group input-group-lg">
        <span class="input-group-addon">
            {{ Form::label('Country ') }} :
        </span>
        <div class="form-line">
            {!! Form::select('country_id', dataForm()->getCountries() ,null , ['class' => 'form-control bsGetAjaxData','id'=> 'bsCountryId']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'country_id'])
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

    <h2><b>Speciality : </b></h2>
    <br>
    <div class="col-sm-10 center center-align">
        <div class="demo-checkbox">
            <div class="row">
            @foreach(dataForm()->getSpeciality() as $row)
                {!! Form::checkbox('specialties[]', $row->id, isset($specialityIds) && in_array($row->id, $specialityIds), array('id'=> 'specialties_'.$row->id,'class' => 'filled-in chk-col-brown')) !!}
                <label for="specialties_{{ $row->id }}">{{ $row->name }}</label>
            @endforeach
            </div>
        </div>
    </div>

    <div class="form-group">
        @include('admin.partial._form_switch', ['input' => 'is_active', 'label' => 'is active'])
    </div>

</div>
<h2><b>Additional Data : </b></h2>
<div class="col-sm-12">
    @include('admin.partial._form_tags_input', ['label'=>'hospitals', 'id'=>'tagsinputHospital' , 'available' => isset($hospitals)?$hospitals:null])
</div>

<div class="col-sm-12">
    @include('admin.partial._form_tags_input', ['name'=>'insurance_company','id'=>'tagsinputInsuranceCompany' , 'available' => isset($insuranceCompanies)?$insuranceCompanies:null])
</div>

@include('admin.partial._form_submit')


@section('js')
    {!! Mapper::renderJavascript() !!}
@stop
