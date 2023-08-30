
<h2><b>info Data</b></h2>
<br>
<div class="col-sm-12">
    <div class="input-group input-group-lg">
        <span class="input-group-addon">
            {{ Form::label('lab_category') }} :
        </span>
        <div class="form-line">
            <select name="lab_category[]" multiple id="parent_sel" style="width: 100%">
                <option value="">Select parent</option>
                @foreach (\App\Models\LabCategory::where('is_active' , 1)->get() as $alphabet => $collection)
                    <option value="{!! $collection->id !!}" @if(isset($categories_parent) && in_array($collection->id, $categories_parent) ) selected @endif>{!! $collection->name !!}</option>
                @endforeach
            </select>
            <script>
                var x = document.getElementById("category").value;
                document.getElementById("category_sel").value = x;
            </script>
        </div>
        @include('admin.partial._row_error', ['input' => 'lab_category'])
    </div>
</div>
@foreach( config('laravellocalization.supportedLocales') as $key=>$row )
    <div class="col-sm-6">
            <br>
            <div class="input-group input-group-lg">
                    <span class="input-group-addon">
                        {{ Form::label('name ' . $key) }}
                    </span>
                <div class="form-line">
                    {!! Form::text($key.'[name]', isset($item)?$item->translate($key)->name:'' , ['class' => 'form-control']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => $key.'.name'])
            </div>
    </div>
@endforeach

@foreach( config('laravellocalization.supportedLocales') as $key=>$row )
    <div class="col-sm-3">
        <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('sample ' . $key) }}
                </span>
            <div class="form-line">
                {!! Form::text($key.'[sample]', isset($item)?$item->translate($key)->sample:'' , ['class' => 'form-control']) !!}
            </div>
            @include('admin.partial._row_error', ['input' => $key.'.sample'])
        </div>
    </div>
    <div class="col-sm-3">
        <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('normal_range_male ' . $key) }}
                </span>
            <div class="form-line">
                {!! Form::text($key.'[measruing_unit]', isset($item)?$item->translate($key)->measruing_unit:'' , ['class' => 'form-control']) !!}
            </div>
            @include('admin.partial._row_error', ['input' => $key.'.measruing_unit'])
        </div>
    </div>
    <div class="col-sm-3">
        <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('normal_range_female ' . $key) }}
                </span>
            <div class="form-line">
                {!! Form::text($key.'[measruing_unit_female]', isset($item)?$item->translate($key)->measruing_unit_female:'' , ['class' => 'form-control']) !!}
            </div>
            @include('admin.partial._row_error', ['input' => $key.'.measruing_unit_female'])
        </div>
    </div>
    <div class="col-sm-3">
        <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('measruing_unit ' . $key) }}
                </span>
            <div class="form-line">
                {!! Form::text($key.'[normal_range]', isset($item)?$item->translate($key)->normal_range:'' , ['class' => 'form-control']) !!}
            </div>
            @include('admin.partial._row_error', ['input' => $key.'.normal_range'])
        </div>
    </div>

@endforeach
@foreach( config('laravellocalization.supportedLocales') as $key=>$row )
    <div class="col-sm-6">
            <br>
            <div class="input-group input-group-lg">
                    <span class="input-group-addon">
                        {{ Form::label('about_test ' . $key) }}
                    </span>
                <div class="form-line">
                    {!! Form::textarea($key.'[about_test]', isset($item)?$item->translate($key)->about_test:'' , ['class' => 'form-control tinymce']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => $key.'.about_test'])
            </div>
    </div>
@endforeach
@foreach( config('laravellocalization.supportedLocales') as $key=>$row )
    <div class="col-sm-6">
            <br>
            <div class="input-group input-group-lg">
                    <span class="input-group-addon">
                        {{ Form::label('used_to ' . $key) }}
                    </span>
                <div class="form-line">
                    {!! Form::textarea($key.'[used_to]', isset($item)?$item->translate($key)->used_to:'' , ['class' => 'form-control tinymce']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => $key.'.used_to'])
            </div>
    </div>
@endforeach
@foreach( config('laravellocalization.supportedLocales') as $key=>$row )
    <div class="col-sm-6">
            <br>
            <div class="input-group input-group-lg">
                    <span class="input-group-addon">
                        {{ Form::label('reasons_for ' . $key) }}
                    </span>
                <div class="form-line">
                    {!! Form::textarea($key.'[reasons_for]', isset($item)?$item->translate($key)->reasons_for:'' , ['class' => 'form-control tinymce']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => $key.'.reasons_for'])
            </div>
    </div>
@endforeach
@foreach( config('laravellocalization.supportedLocales') as $key=>$row )
    <div class="col-sm-6">
            <br>
            <div class="input-group input-group-lg">
                    <span class="input-group-addon">
                        {{ Form::label('how_is ' . $key) }}
                    </span>
                <div class="form-line">
                    {!! Form::textarea($key.'[how_is]', isset($item)?$item->translate($key)->how_is:'' , ['class' => 'form-control tinymce']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => $key.'.how_is'])
            </div>
    </div>
@endforeach
@foreach( config('laravellocalization.supportedLocales') as $key=>$row )
    <div class="col-sm-6">
            <br>
            <div class="input-group input-group-lg">
                    <span class="input-group-addon">
                        {{ Form::label('how_prepare ' . $key) }}
                    </span>
                <div class="form-line">
                    {!! Form::textarea($key.'[how_prepare]', isset($item)?$item->translate($key)->how_prepare:'' , ['class' => 'form-control tinymce']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => $key.'.how_prepare'])
            </div>
    </div>
@endforeach
@foreach( config('laravellocalization.supportedLocales') as $key=>$row )
    <div class="col-sm-6">
            <br>
            <div class="input-group input-group-lg">
                    <span class="input-group-addon">
                        {{ Form::label('risks ' . $key) }}
                    </span>
                <div class="form-line">
                    {!! Form::textarea($key.'[risks]', isset($item)?$item->translate($key)->risks:'' , ['class' => 'form-control tinymce']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => $key.'.risks'])
            </div>
    </div>
@endforeach
@foreach( config('laravellocalization.supportedLocales') as $key=>$row )
    <div class="col-sm-6">
            <br>
            <div class="input-group input-group-lg">
                    <span class="input-group-addon">
                        {{ Form::label('interpretation_result ' . $key) }}
                    </span>
                <div class="form-line">
                    {!! Form::textarea($key.'[interpretation_result]', isset($item)?$item->translate($key)->interpretation_result:'' , ['class' => 'form-control tinymce']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => $key.'.interpretation_result'])
            </div>
    </div>
@endforeach
@foreach( config('laravellocalization.supportedLocales') as $key=>$row )
    <div class="col-sm-6">
            <br>
            <div class="input-group input-group-lg">
                    <span class="input-group-addon">
                        {{ Form::label('reasons_high_reading ' . $key) }}
                    </span>
                <div class="form-line">
                    {!! Form::textarea($key.'[reasons_high_reading]', isset($item)?$item->translate($key)->reasons_high_reading:'' , ['class' => 'form-control tinymce']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => $key.'.reasons_high_reading'])
            </div>
    </div>
@endforeach
@foreach( config('laravellocalization.supportedLocales') as $key=>$row )
    <div class="col-sm-6">
            <br>
            <div class="input-group input-group-lg">
                    <span class="input-group-addon">
                        {{ Form::label('references ' . $key) }}
                    </span>
                <div class="form-line">
                    {!! Form::textarea($key.'[references]', isset($item)?$item->translate($key)->references:'' , ['class' => 'form-control tinymce']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => $key.'.references'])
            </div>
    </div>
@endforeach
<style>
    span.input-group-addon{
        display: block;
    }
</style>
<div class="col-sm-12">
    @include('admin.partial._form_image', ['input' => 'image', 'label' => 'image', 'path' => 'pharmacies'])

    @include('admin.partial._form_submit')
</div>
