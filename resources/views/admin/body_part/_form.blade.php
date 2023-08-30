
<div class="input-group input-group-lg hidden">
    <span class="input-group-addon">
        {{ Form::label('Module') }} :
    </span>
    <div class="form-line">
            <select name="module_name" id="module_name">
                <option value="">Select Module</option>
                <option value="doctor">Doctor</option>
                <option value="hospital">Hospital</option>
                <option value="center">Center</option>
            </select>

              </div>
    @include('admin.partial._row_error', ['input' => 'module_name'])
</div>
<script>
    (function() {
        @if(isset($item))
        document.getElementById('module_name').value="{{$item->module_name}}";
        @endif
    })();
</script>


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
                {{ Form::label('description' . $key) }} :
                {{ Form::textarea($key.'[description]', (isset($item) && isset($item->translate($key)->description))?$item->translate($key)->description:'', array_merge(['class' => 'form-control tinymce', 'placeholder' => 'Description' ])) }}
            </div>
            @include('admin.partial._row_error', ['input' => $key.'.content'])
        </div>
    </div>
@endforeach

<h2><b>Other Data : </b></h2>
<div class="col-sm-12">
    <br>
    <div class="form-group" hidden>
        <span class="col-sm-1">{{ Form::label('Country ') }} :</span>
        <div class="col-sm-11">
            {!! Form::select('country_id', dataForm()->getCountries() ,null , ['class' => 'form-control show-tick bsGetAjaxData','id'=> 'bsCountryId']) !!}
            @include('admin.partial._row_error', ['input' => 'country_id'])
        </div>
    </div>

</div>

<div class="col-sm-12">
    <h2><b>Parent Body Part : </b></h2>
    <br>
    @if(isset($bps_parent))

    @endif

    <div class="subs-checkbox">
        @foreach (\App\Models\BodyPart::all() as $bp)
            {{-- @if(isset($specialityIds) && $specialityIds)
                @foreach ($subc->specialties()->whereIn('specialtyid', $specialityIds)->distinct()->get() as $tg) --}}
                    {!! Form::radio('parent[]', $bp->id, isset($body_parts_parent) && in_array($bp->id, $body_parts_parent), array('id'=> 'subcp_'.$bp->id,'class' => 'filled-in chk-col-brown subcp', 'onchange' => 'return OptionsSelectedSubs(this)' )) !!}
                    <label for="subcp_{{ $bp->id }}">{{\App\Models\BodyPart::find($bp->id)->name}}</label>
                {{-- @endforeach
            @endif --}}
        @endforeach
    </div>
    {{-- <div hidden class="form-group" style="border: 1px solid; box-shadow: 1px 3px;">
        <select multiple="multiple" data-placeholder="{{ trans('general.specialities_multiple') }}" class="form-control" name="parent[]" id="">
            <option></option>
            @foreach($bps as $row)
                <option {{isset($bps_parent) && in_array($row->id, $bps_parent) ? 'selected' : ''}} value="{{$row->id}}" class="">{{ $row->name }}</option>
            @endforeach
        </select>
    </div> --}}
<br>
    @include('admin.partial._form_image', ['input' => 'image', 'label' => 'Logo', 'path' => 'body_parts'])

    <div class="form-group">
        @include('admin.partial._form_switch', ['input' => 'is_active', 'label' => 'is active'])
    </div>
    @include('admin.partial._form_submit')
</div>

