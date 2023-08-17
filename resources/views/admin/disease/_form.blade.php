
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
                {{ Form::label('description ' . $key) }} :
                {{ Form::textarea($key.'[description]', isset($item)?$item->translate($key)->description:'', array_merge(['class' => 'form-control tinymce', 'placeholder' => 'Description' ])) }}
            </div>
            @include('admin.partial._row_error', ['input' => $key.'.content'])
        </div>
        <div class="form-group">
            <div class="form-line">
                {{ Form::label('symptoms ' . $key) }} :
                {{ Form::textarea($key.'[symptoms]', isset($item)?$item->translate($key)->symptoms:'', array_merge(['class' => 'form-control tinymce', 'placeholder' => 'symptoms' ])) }}
            </div>
            @include('admin.partial._row_error', ['input' => $key.'.content'])
        </div>
        <div class="form-group">
            <div class="form-line">
                {{ Form::label('causes ' . $key) }} :
                {{ Form::textarea($key.'[causes]', isset($item)?$item->translate($key)->causes:'', array_merge(['class' => 'form-control tinymce', 'placeholder' => 'causes' ])) }}
            </div>
            @include('admin.partial._row_error', ['input' => $key.'.content'])
        </div>
        <div class="form-group">
            <div class="form-line">
                {{ Form::label('complications ' . $key) }} :
                {{ Form::textarea($key.'[complications]', isset($item)?$item->translate($key)->complications:'', array_merge(['class' => 'form-control tinymce', 'placeholder' => 'complications' ])) }}
            </div>
            @include('admin.partial._row_error', ['input' => $key.'.content'])
        </div>
        <div class="form-group">
            <div class="form-line">
                {{ Form::label('diagnosis ' . $key) }} :
                {{ Form::textarea($key.'[diagnosis]', isset($item)?$item->translate($key)->diagnosis:'', array_merge(['class' => 'form-control tinymce', 'placeholder' => 'diagnosis' ])) }}
            </div>
            @include('admin.partial._row_error', ['input' => $key.'.content'])
        </div>
        <div class="form-group">
            <div class="form-line">
                {{ Form::label('treatment ' . $key) }} :
                {{ Form::textarea($key.'[treatment]', isset($item)?$item->translate($key)->treatment:'', array_merge(['class' => 'form-control tinymce', 'placeholder' => 'treatment' ])) }}
            </div>
            @include('admin.partial._row_error', ['input' => $key.'.content'])
        </div>
        <div class="form-group">
            <div class="form-line">
                {{ Form::label('protection ' . $key) }} :
                {{ Form::textarea($key.'[protection]', isset($item)?$item->translate($key)->protection:'', array_merge(['class' => 'form-control tinymce', 'placeholder' => 'protection' ])) }}
            </div>
            @include('admin.partial._row_error', ['input' => $key.'.content'])
        </div>
        <div class="form-group">
            <div class="form-line">
                {{ Form::label('alternative_therapies ' . $key) }} :
                {{ Form::textarea($key.'[alternative_therapies]', isset($item)?$item->translate($key)->alternative_therapies:'', array_merge(['class' => 'form-control tinymce', 'placeholder' => 'alternative_therapies' ])) }}
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
            {!! Form::select('countryid', dataForm()->getCountries() ,null , ['class' => 'form-control show-tick bsGetAjaxData','id'=> 'bsCountryId']) !!}
            @include('admin.partial._row_error', ['input' => 'countryid'])
        </div>
    </div>

</div>

<div class="col-sm-12">

    <h2><b>Parent Disease : </b></h2>
    <br>
    @if(isset($diseases_parent))

    @endif

    <div class="subs-checkbox">
        @foreach (\App\Models\Disease::all() as $bp)
            {{-- @if(isset($specialityIds) && $specialityIds)
                @foreach ($subc->specialties()->whereIn('specialtyid', $specialityIds)->distinct()->get() as $tg) --}}
                    {!! Form::checkbox('parent_ids[]', $bp->id, isset($diseases_parent) && in_array($bp->id, $diseases_parent), array('id'=> 'pid_'.$bp->id,'class' => 'filled-in chk-col-brown subcp', 'onchange' => 'return OptionsSelectedSubs(this)' )) !!}
                    <label for="pid_{{ $bp->id }}">{{\App\Models\Disease::find($bp->id)->name}}</label>
                {{-- @endforeach
            @endif --}}
        @endforeach
    </div>
    <br>

    <h2><b>Body Parts : </b></h2>
    <br>
    @if(isset($bps_parent))

    @endif

    <div class="subs-checkbox">
        @foreach (\App\Models\BodyPart::all() as $bp)
            {{-- @if(isset($specialityIds) && $specialityIds)
                @foreach ($subc->specialties()->whereIn('specialtyid', $specialityIds)->distinct()->get() as $tg) --}}
                    {!! Form::checkbox('body_part_ids[]', $bp->id, isset($bps_parent) && in_array($bp->id, $bps_parent), array('id'=> 'bpid_'.$bp->id,'class' => 'filled-in chk-col-brown subcp', 'onchange' => 'return OptionsSelectedSubs(this)' )) !!}
                    <label for="bpid_{{ $bp->id }}">{{\App\Models\BodyPart::find($bp->id)->name}}</label>
                {{-- @endforeach
            @endif --}}
        @endforeach
    </div>

    <br>
    <h2><b>Symptoms : </b></h2>
    <br>
    <div class="subs-checkbox">
        @foreach (\App\Models\Symptom::all() as $symp)
            {{-- @if(isset($specialityIds) && $specialityIds)
                @foreach ($subc->specialties()->whereIn('specialtyid', $specialityIds)->distinct()->get() as $tg) --}}
                    {!! Form::checkbox('symptom_ids[]', $symp->id, isset($symps_parent) && in_array($symp->id, $symps_parent), array('id'=> 'sympid_'.$symp->id,'class' => 'filled-in chk-col-brown subcp', 'onchange' => 'return OptionsSelectedSubs(this)' )) !!}
                    <label for="sympid_{{ $symp->id }}">{{\App\Models\Symptom::find($symp->id)->name}}</label>
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

    <div class="form-group">
        @include('admin.partial._form_switch', ['input' => 'is_active', 'label' => 'is active'])
    </div>
    @include('admin.partial._form_submit')
</div>

