
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


    </div>
@endforeach

<h2><b>Other Data : </b></h2>
<div class="col-sm-12">
    <br>

    <div class="input-group input-group-lg">
        <span class="input-group-addon">
            {{ Form::label('Country Code ') }} :
        </span>
        <div class="form-line">
            {!! Form::text('code', isset($item)?$item->code:'' , ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'code'])
    </div>
    <div class="input-group input-group-lg">
        <span class="input-group-addon">
            {{ Form::label('Currency code ') }} :
        </span>
        <div class="form-line">
            {!! Form::text('currency_code', isset($item)?$item->currency_code:'' , ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'currency_code'])
    </div>
    @include('admin.partial._form_image', ['input' => 'image', 'label' => 'Logo', 'path' => 'labs'])

    <div class="form-group">
        @include('admin.partial._form_switch', ['input' => 'is_active', 'label' => 'is active'])
    </div>
    @include('admin.partial._form_submit')
</div>
