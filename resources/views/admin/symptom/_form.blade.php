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

    </div>
@endforeach

<div class="col-sm-12">

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
    @include('admin.partial._form_image', ['input' => 'image', 'label' => 'Logo', 'path' => 'pharmacies'])
    <div class="form-group">
        @include('admin.partial._form_switch', ['input' => 'is_active', 'label' => 'is active'])
    </div>
    @include('admin.partial._form_submit')
</div>
