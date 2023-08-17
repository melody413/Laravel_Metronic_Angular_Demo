
<div class="input-group input-group-lg">
    <span class="input-group-addon">
        {{ Form::label('Pharmacy company ') }} :
    </span>
    <div class="form-line">
        {{ Form::select('parent_id', dataForm()->getPharmacyCompanies()->prepend('Select pharmacy company', 0) ,null , ['class' => 'form-control parentGetAjaxData' , 'data-from' => env('ADMIN_PREFIX') . '/data/labInfo/']) }}
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
    <div class="input-group input-group-lg">
        <span class="input-group-addon">
            {{ Form::label('facebook') }} :
        </span>
        <div class="form-line">
            {!! Form::text('facebook', null , ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'facebook'])
    </div>
</div>

<div class="col-sm-12">
    <div class="input-group input-group-lg">
        <span class="input-group-addon">
            {{ Form::label('twitter') }} :
        </span>
        <div class="form-line">
            {!! Form::text('twitter', null , ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'twitter'])
    </div>
</div>

<div class="col-sm-12">
    <div class="input-group input-group-lg">
        <span class="input-group-addon">
            {{ Form::label('instagram') }} :
        </span>
        <div class="form-line">
            {!! Form::text('instagram', null , ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'instagram'])
    </div>
</div>

<div class="col-sm-12">
    <div class="input-group input-group-lg">
        <span class="input-group-addon">
            {{ Form::label('youtube') }} :
        </span>
        <div class="form-line">
            {!! Form::text('youtube', null , ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'youtube'])
    </div>
</div>

<div class="form-group hidden">
    @include('admin.partial._form_tags_input', [
        'name'=>'user_id',
        'id'=>'tagsInput',
        'label' => 'user E-mail',
        'data' => [
            'data-url' => '/data/getUser',
            'data-input-hidden' => 'user_id',
            'data-display-key' => 'email',
            'data-max-tags' => 1
        ],
        'available' => isset($item->user->email)?[$item->user->id => $item->user->email]:null
    ])
</div>

<div class="col-sm-12">
    <div class="input-group input-group-lg">
        <span class="input-group-addon">
            {{ Form::label('website') }} :
        </span>
        <div class="form-line">
            {!! Form::text('website', null , ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'website'])
    </div>
</div>

<div class="col-sm-12">
    <br>
    @include('admin.partial._form_image', ['input' => 'image', 'label' => 'Logo', 'path' => 'pharmacies'])

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
            {{ Form::label('Open hours ') }} :
        </span>
        <div class="form-line">
            {!! Form::text('open_hours', null, ['class' => 'form-control']) !!}
        </div>
        <small>per Hours ex: 24 </small>
        @include('admin.partial._row_error', ['input' => 'open_hours'])
    </div>

    <div class="col-sm-12">
        @include('admin.partial._form_tags_input', ['name'=>'insurance_company','id'=>'tagsinputInsuranceCompany' , 'available' => isset($insuranceCompanies)?$insuranceCompanies:null])
    </div>

    @include('admin.partial._locationInpts', [])

    <div class="form-group">
        @include('admin.partial._form_switch', ['input' => 'is_active', 'label' => 'is active'])
    </div>
    @include('admin.partial._form_submit')
</div>
