
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

    <div class="form-group">
        <span class="col-sm-1">
            {{ Form::label('Country ') }} :
        </span>
        <div class="col-sm-11">
            {!! Form::select('country_id', $countries ,null , ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'country_id'])
    </div>


    <div class="form-group">
        @include('admin.partial._form_switch', ['input' => 'is_active', 'label' => 'is active'])
    </div>
    @include('admin.partial._form_submit')
</div>
