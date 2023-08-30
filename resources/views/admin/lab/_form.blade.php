
<div class="input-group input-group-lg">
    <span class="input-group-addon">
        {{ Form::label('Lab company ') }} :
    </span>
    <div class="form-line">
        {!! Form::select('parent_id', dataForm()->getLabCompanies()->prepend('Select lab company', 0) ,null , ['class' => 'form-control parentGetAjaxData' , 'data-from' => env('ADMIN_PREFIX') . '/data/labInfo/']) !!}
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
<div class="col-md-12">
    <br>
    @include('admin.partial._form_image', ['input' => 'image', 'label' => 'Logo', 'path' => 'labs'])

    <div class="col-sm-12">
        @include('admin.partial._form_tags_input', ['name'=>'insurance_company','id'=>'tagsinputInsuranceCompany' , 'available' => isset($insuranceCompanies)?$insuranceCompanies:null])
    </div>

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

 <h2><b>Lab Services : </b></h2>
<br>
    <div class="col-sm-10 center center-align">
        <div class="demo-checkbox">
            <div class="row">
            @foreach(dataForm()->getLabServices() as $row)
                {!! Form::checkbox('lab_services[]', $row->id, isset($labServicesId) && in_array($row->id, $labServicesId), array('id'=> 'lab_service_'.$row->id,'class' => 'filled-in chk-col-brown')) !!}
                <label for="lab_service_{{ $row->id }}">{{ $row->name }}</label>
            @endforeach
            </div>
        </div>
    </div>



    <div class="form-group">
        <div class="input-group input-group-lg">
            <span class="input-group-addon">
                {{ Form::label('map_link') }} :
            </span>
            <div class="form-line">
                {!! Form::text('map_link', null , ['class' => 'form-control']) !!}
            </div>
            @include('admin.partial._row_error', ['input' => 'map_link'])
        </div>
        @include('admin.partial._form_switch', ['input' => 'is_active', 'label' => 'is active'])
    </div>
    @include('admin.partial._form_submit')
</div>
